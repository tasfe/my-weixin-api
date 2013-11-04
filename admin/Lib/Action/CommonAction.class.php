<?php

/**
 * 全局基类
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class CommonAction extends Action {

    //控制器初始化
    function _initialize() {
        //判断是否已经正确登录
//        if (!session('?admin')) {
//            redirect(U('/index'));
//            exit;
//        }
        if(!check_login()){
            redirect(U('/index'));
            exit;
        }
        

        $this->module_name = parse_name(MODULE_NAME);
        $this->action_name = parse_name(ACTION_NAME);

        //上一页url链接
        $this->pre_url = session('preUrl');
        $preaction = array('index','index_submenu','add_submenu','config');  //允许记录的上一页
        if (in_array($this->action_name, $preaction))
            session('preUrl', __SELF__);
    }
    
    public function check_auth($auth_name){
        if(!check_auth($auth_name)){
            $this->error('您没有权限,请您联系系统管理员!');
            exit;
        }
    }

    public function index($where_and = '', $order = 'id desc', $page_num = 15) {
        $order = empty($order) ? 'id desc' : $order;
        $M = M(MODULE_NAME);

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

    /**
     * 编辑页面显示方法
     */
    public function edit() {
        $id = intval($_GET['id']);
        $M = M(MODULE_NAME);
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
        $M = D(MODULE_NAME);
        $data = $M->create();

        if (!empty($_POST['filename_imgupload'])) {
            $pic_url_big = $_POST['big_imgupload'] . $_POST['filename_imgupload'];
            $pic_url_small = $_POST['small_imgupload'] . $_POST['filename_imgupload'];
            $M->pic_url_big = $pic_url_big;
            $M->pic_url_small = $pic_url_small;
        }

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
     * 添加页面显示方法
     */
    public function add() {
        $this->display();
    }

    /**
     * 插入方法
     */
    public function insert() {
        $M = D(MODULE_NAME);
        $data = $M->create();
        if ($data === false) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
        $M->create_time = time();
        if (!empty($_POST['filename_imgupload'])) {
            $pic_url_big = $_POST['big_imgupload'] . $_POST['filename_imgupload'];
            $pic_url_small = $_POST['small_imgupload'] . $_POST['filename_imgupload'];
            $M->pic_url_big = $pic_url_big;
            $M->pic_url_small = $pic_url_small;
        }

        $id = $M->add();
        if ($id !== false) {
            $this->ajaxReturn(array('data' => 1));  //成功
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }

    public function delete() {
        $M = D(MODULE_NAME);
        $id = intval($_POST['id']);
        if ($M->where("id=%d", $id)->delete() !== false) {
            $this->ajaxReturn(array('data' => 1));
        } else {
            $this->ajaxReturn(array('data' => 0));
        }
    }

    /**
     * 获取多图文主题封面列表
     */
    public function get_main_list() {
        $M = M(MODULE_NAME);
        $main_list = $M->where("status=1 and main=0 and msg_type=3")->order("id desc")->select();
        unset($M);
        $this->main_list = $main_list;
    }

}

?>
