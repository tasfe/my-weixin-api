<?php

/**
 * 普通用户功能
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class UserAction extends CommonAction {

    public function change_password() {
        $this->check_auth('User/change_password');
        $this->display();
    }

    /**
     * 更新密码
     */
    public function update_password() {
        $this->check_auth('User/change_password');
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

        $M = D('User');

        $info = $M->where("id=%d and status=1", $user_id)->find();

        if (empty($info)) {
            $this->ajaxReturn(3);  //用户不存在
        } else {
            $user_pwd = md5(base64_encode($_POST['user_pwd']));
            $new_pwd = md5(base64_encode($_POST['new_user_pwd']));
            if ($user_pwd != $info['user_pwd']) {
                $this->ajaxReturn(4);  //当前密码不正确
            } else {
                if ($M->where("id=%d", $user_id)->setField('user_pwd', $new_pwd)) {
                    $this->ajaxReturn(5);  //修改成功
                } else {
                    $this->ajaxReturn(6);  //修改失败
                }
            }
        }

        $this->ajaxReturn(4);
    }
    
    /**
     *用户列表 
     */
    public function index(){
        $this->check_auth('User/Index');
        parent::index();
    }
    
    public function add(){
        $this->check_auth('User/Index/add');
        parent::add();
    }


    /**
     * 插入新增的用户
     */
    public function insert() {
        $this->check_auth('User/Index/add');
        $M = D(MODULE_NAME);
        $data = $M->create();
        if ($data === false) {
            $this->ajaxReturn(array('data' => 0));  //失败
            exit;
        }
        
        if(trim($_POST['user_pwd'])!=trim($_POST['user_pwd_confirm'])){
            $this->ajaxReturn(array('data'=>2));  //两次密码不一致
            exit;
        }
        
        $M->create_time = time();
        $M->user_pwd=md5(base64_encode(trim($_POST['user_pwd'])));

        $id = $M->add();
        if ($id !== false) {
            $this->ajaxReturn(array('data' => 1));  //成功
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }
    
    public function edit() {
        $this->check_auth('User/Index/edit');
        parent::edit();
    }

    /**
     * 用户资料修改
     */
    public function update() {
        $this->check_auth('User/Index/edit');
        $id = intval($_POST['id']);
        $M = M(MODULE_NAME);
        $data=array(
            'user_name'=>$_POST['user_name'],
            'title'=>$_POST['title'],
            'remark'=>$_POST['remark'],
            'status'=>$_POST['status']
        );
        if(trim($_POST['user_pwd'])!=''){
            $data['user_pwd']=md5(base64_encode(trim($_POST['user_pwd'])));
        }
        

        if ($M->where("id=%d", $id)->save($data)) {
            $this->ajaxReturn(array('data' => 1));  //失败
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }
    
    /**
     * 编辑用户所属权限组
     */
    public function edit_user_group() {
        $this->check_auth('User/Index/edit_user_group');
        $user_id = intval($_GET['id']);
        $this->user_id=$user_id;
        $info = M('User')->field('id,user_name')->where("id={$user_id}")->find();
        $user_group = get_user_group($user_id);
        $all_group = M('AuthGroup')->order("id")->select();
        if (!empty($user_group)) {
            foreach ($all_group as $key => $value) {
                foreach ($user_group as $u_key => $u_value) {
                    if ($value['id'] == $u_value['group_id'])
                        $all_group[$key]['is_checked'] = 1;
                }
            }
        }
        $this->group_list=$all_group;
        $this->assign($info);
        $this->display();
    }
    
    /**
     * 更新用户权限组信息
     */
    public function update_edit_user_group(){
        $this->check_auth('User/Index/edit_user_group');
        $user_id=intval($_POST['user_id']);
        $M=M('AuthGroupAccess');
        $M->where("uid=%d",$user_id)->delete();
        foreach($_POST['groups'] as $key=>$value){
            $M->add(array('uid'=>$user_id,"group_id"=>$value));
        }
        $this->ajaxReturn(array("data"=>1));
    }
    
    /**
     * 用户删除功能
     */
    public function delete() {
        $this->check_auth('User/Index/delete');
        $M = D(MODULE_NAME);
        $id = intval($_POST['id']);
        $user_name=M("User")->where("id={$id}")->getField("user_name");
        
        $super_admin=C("AUTH_CONFIG.SuperAdmin");
        //判断是否为超级用户
        if($super_admin==$user_name){
            $this->ajaxReturn(array('data'=>2));
            exit;
        }
        
        M('AuthGroupAccess')->where("uid={$id}")->delete();
        
        if ($M->where("id=%d", $id)->delete() !== false) {
            $this->ajaxReturn(array('data' => 1));
        } else {
            $this->ajaxReturn(array('data' => 0));
        }
    }

}

?>
