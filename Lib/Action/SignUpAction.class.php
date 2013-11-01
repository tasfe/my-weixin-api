<?php

/**
 * 
 * @Created on : 2013-9-17, 9:15:28
 * @author <zibin_5257@163.com>lanfengye
 */
class SignUpAction extends CommonAction {
    public function index(){
        //设置并获取用户微信唯一识别令牌
        $weixin_id = $this->weixin_id(U("/sign_up" . $id));
        $this->display();
    }
    
    
    
    public function insert() {
        if ($this->isAjax()) {
            import("ORG.Util.Input");
            $name = Input::forShow($_POST['name']);
            $telephone = Input::forShow($_POST['telephone']);
            $kind = Input::forShow($_POST['kind']);
            $data = array(
                'name' => $name,
                'telephone' => $telephone,
                'kind' => $kind,
                'create_time' => time(),
                'create_ip' => get_client_ip(),
                'weixin_id'=>  $this->weixin_id()
            );
            $id = M("SignUp")->add($data);
            if ($id !== false) {
                $this->ajaxReturn(1);
            } else {
                $this->ajaxReturn(0);
            }
        } else {
            exit('请求方式错误！');
        }
    }
}

?>
