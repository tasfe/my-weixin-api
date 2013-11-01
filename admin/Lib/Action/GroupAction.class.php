<?php

/**
 * 权限组管理
 *
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class GroupAction extends CommonAction {

    public function index() {
        $order = empty($order) ? 'id desc' : $order;
        $M = M("AuthGroup");
        //处理搜索条件
        $db_fields = $M->getDbFields();
        $search_data = $_GET;

        foreach ($search_data as $key => $value) {
            if (in_array($key, $db_fields)) {
                $parameter .= "{$key}=" . urlencode($value) . '&';
                $this->assign($key, $value);
                $where.="and {$key} like '%{$value}%' ";
            }
        }

        $where.=$where_and;
        import("ORG.Util.Page");
        $count = $M->where("1 and 1 {$where}")->count();
        $Page = new Page($count, $page_num);
        $Page->parameter = $parameter;
        $show = $Page->show();

        $list = $M->where("1 and 1 {$where}")->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->page = $show;

        unset($Page);
        unset($M);
        $this->list = $list;
        $this->display();
    }

    public function insert() {
        $M = D('AuthGroup');
        $data = $M->create();
        if ($data === false) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }

        $id = $M->add();
        if ($id !== false) {
            $this->ajaxReturn(array('data' => 1));  //成功
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }

    /**
     * 编辑页面显示方法
     */
    public function edit() {
        $id = intval($_GET['id']);
        $M = M('AuthGroup');
        $info = $M->where("id=%d", $id)->find();
        unset($M);
        if (empty($info)) {
            $this->pop = '编辑的信息不存在！';
        } else {
            $this->info = $info;
        }
        $this->display();
    }
    
    /**
     * 更新方法
     */
    public function update() {
        $id = intval($_POST['id']);
        $M = D('AuthGroup');
        $data = $M->create();

        if ($data === FALSE) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }

        if ($M->where("id=%d", $id)->save()) {
            $this->ajaxReturn(array('data' => 1));  //失败
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }
    
    /**
     * 删除权限组
     */
    public function delete() {
        $M = D('AuthGroup');
        $id = intval($_POST['id']);
        $AuthGroupAccess=M('AuthGroupAccess');
        $AuthGroupAccess->where("group_id={$id}")->delete();
        if ($M->where("id=%d", $id)->delete() !== false) {
            $this->ajaxReturn(array('data' => 1));
        } else {
            $this->ajaxReturn(array('data' => 0));
        }
    }
    
    /**
     * 权限组成员管理
     */
    public function user_manage(){
        $g_id=  intval($_GET['id']);
        $AuthGroup=M('AuthGroup');
        $this->group_name=$AuthGroup->where("id={$g_id}")->getField('title');
        
        $this->display();
    }
    
    /**
     * 权限组授权管理
     */
    public function authorize_manage(){
        $group_id=  intval($_GET['id']);
        $this->id=$group_id;
        $AuthGroup=M('AuthGroup');
        $group_info=$AuthGroup->where("id={$group_id}")->find();
        $group_auth= explode(',',$group_info['rules']);
        $this->group_auth=$group_auth;
        $this->group_name=$group_info['title'];
        
        $AuthRule=M('AuthRule');
        $auth_rule_array=$AuthRule->where("status=1")->select();
        load("extend");
        $tree=list_to_tree($auth_rule_array, 'id', 'main');
        $this->tree_list=$tree;
        $this->display();
    }
    
    /**
     * 更新权限组授权信息
     */
    public function update_authorize_manage(){
        $group_id=  intval($_POST['id']);
        $rules=$_POST['rules'];
        $AuthGroup=M('AuthGroup');
        $id=$AuthGroup->where("id={$group_id}")->setField('rules', implode(',', $rules));
        if($id!==FALSE){
            $this->ajaxReturn(array('data'=>1));
        }else{
            $this->ajaxReturn(array('data'=>0));
        }
    }
}
