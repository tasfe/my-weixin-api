<?php

/**
 * 普通用户功能
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class UserAction extends CommonAction {

    public function change_password() {
        $this->display();
    }

    /**
     * 更新密码
     */
    public function update_password() {
        $user_id = intval(session('user_id'));
        if ($_POST['user_pwd'] == '') {
            $this->ajaxReturn(0);  //当前密码为空
            exit;
        }

        if ($_POST['new_user_pwd'] == '') {
            $this->ajaxReturn(1);  //新密码为空
            exit;
        }

        if ($_POST['new_user_pwd1'] != $_POST['new_user_pwd']) {
            $this->ajaxReturn(2);  //新密码两次不正确
            exit;
        }

        $M = D('Admin');

        $info = $M->where("id=%d and status=1", $user_id)->find();

        if (empty($info)) {
            $this->ajaxReturn(3);  //用户不存在
        }else{
            $user_pwd=  md5(base64_encode($_POST['user_pwd']));
            $new_pwd=  md5(base64_encode($_POST['new_user_pwd']));
            if($user_pwd!=$info['user_pwd']){
                $this->ajaxReturn(4);  //当前密码不正确
            }else{
                if($M->where("id=%d",$user_id)->setField('user_pwd', $new_pwd)){
                    $this->ajaxReturn(5);  //修改成功
                }else{
                    $this->ajaxReturn(6);  //修改失败
                }
            }
        }








        $this->ajaxReturn(4);
    }

}

?>
