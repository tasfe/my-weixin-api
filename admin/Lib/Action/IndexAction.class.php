<?php

class IndexAction extends Action {

    public function index() {
        if (check_login()) {
            redirect(U('/main'));
        } else {
            $this->display();
        }
    }
    
    
     /**

     * 验证码生成方法

     */
    public function verify() {
        import('ORG.Util.Image');
        $type = isset($_GET['type']) ? $_GET['type'] : 'png';
        $type = 'png';
        Image::buildImageVerify(6, 1, $type, 60, 42, "verify");
    }

    /**
     * 验证登录
     */
    public function login() {
        if ($this->isAjax()) {
            $user_name = MAGIC_QUOTES_GPC ? $_POST['user_name'] : addslashes($_POST['user_name']);
            $user_pwd = md5(base64_encode(trim($_POST['user_pwd'])));
            $remember = intval($_POST['remember']);
            $Admin = M('User');
            $info = $Admin->where("user_name='%s'", $user_name)->find();
            
            if (md5($_POST['verify']) != session('verify')) {
                $this->ajaxReturn(array('data' => 3));
            }
            if (empty($info)) {
                $this->ajaxReturn(array('data' => 0));
            }
            if ($info['user_pwd'] == $user_pwd) {
                $expire = $remember ? 2592000 : 3600;  //cookie保存时间
                $data = array('admin' => $info['admin'], 'user_id' => $info['id']);
                $encode_json = aes_encode(json_encode($data), md5(C('admin_secret_key').$_SERVER['HTTP_USER_AGENT']));
                cookie('weixin_admin', $encode_json, $expire);
                $Admin->where("id={$info['id']}")->save(array('lastlogin_ip'=>  get_client_ip(),'lastlogin_time'=>time()));
                $this->ajaxReturn(array('data' => 1));
            } else {
                $this->ajaxReturn(array('data' => 2));
            }
        } else {
            header("Content-Type: text/html; charset=UTF-8");
            echo '请通过正确的页面进行登录！';
        }
    }

    /**
     * 退出方法
     */
    public function out() {
        session('[destroy]');
        cookie('weixin_admin',null);
        redirect(U('/'));
    }

}
