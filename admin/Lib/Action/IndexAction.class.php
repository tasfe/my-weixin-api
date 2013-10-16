<?php

class IndexAction extends Action {

    public function index() {
        if(session('?admin')){
            redirect(U('/main'));
        }else{
            $this->display();
        }
    }
    
    /**
     * 验证登录
     */
    public function login() {
        if ($this->isAjax()) {
            $user_name = MAGIC_QUOTES_GPC?$_POST['user_name']:  addslashes($_POST['user_name']);
            $user_pwd = md5(base64_encode(trim($_POST['user_pwd'])));
            $Admin=M('Admin');
            $info=$Admin->where("user_name='%s'",$user_name)->find();
            unset($Admin);
            if(empty($info)){
                $this->ajaxReturn(array('data'=>0));
            }
            if($info['user_pwd']==$user_pwd){ 
//                $admin= $info['admin']==1?'y':'n';
                $admin= $info['admin'];
                //登录成功
                session('admin', $admin);
                session('user_id',$info['id']);
                $this->ajaxReturn(array('data'=>1));
            }else{
                $this->ajaxReturn(array('data'=>2));
            }
        }else{
            header("Content-Type: text/html; charset=UTF-8");
            echo '请通过正确的页面进行登录！';
        }
    }
    
    /**
     * 退出方法
     */
    public function out(){
        session('[destroy]');
        redirect(U('/'));
    }

}