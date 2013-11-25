<?php

/**
 * 优惠券管理
 * @author Damon_loo
 */
class CouponAction extends CommonAction {
    
    public function index(){
        $this->check_auth('Coupon/Index');
        parent::index();
    }
    
    public function add() {
        $this->check_auth('Coupon/Index/add');
        parent::add();
    }
    
    public function delete() {
        $this->check_auth('Coupon/Index/delete');
        parent::delete();
    }

    /**
     * 插入方法
     */
    public function insert() {
        $this->check_auth('Coupon/Index/add');
        $M = D(MODULE_NAME);
        $data = $M->create();
        if ($data === false) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
        $M->create_time = time();
        if (!empty($_POST['filename_imgupload'])) {
            $pic_url_big = $_POST['big_imgupload'] . $_POST['filename_imgupload'];
            $M->pic_url = $pic_url;
        }

        $M->begin_time = empty($M->begin_time) ? 0 : strtotime($M->begin_time);
        $M->stop_time = empty($M->stop_time) ? 0 : strtotime($M->stop_time);
        $M->award_stop_time = empty($M->award_stop_time) ? 0 : strtotime($M->award_stop_time);

        $M->remark = nl2br($M->remark);
        $M->direction = nl2br($M->direction);
        $M->activity = nl2br($M->activity);

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
        $this->check_auth('Coupon/Index/edit');
        $id = intval($_GET['id']);
        $M = M(MODULE_NAME);
        $info = $M->where("id=%d", $id)->find();

        $info['begin_time'] = empty($info['begin_time']) ? $info['begin_time'] : get_date_full($info['begin_time']);
        $info['stop_time'] = empty($info['stop_time']) ? $info['stop_time'] : get_date_full($info['stop_time']);
        $info['award_stop_time'] = empty($info['award_stop_time']) ? $info['award_stop_time'] : get_date_full($info['award_stop_time']);
        
        $info['remark'] = br2nl($info['remark']);
        $info['direction'] = br2nl($info['direction']);
        $info['activity'] = br2nl($info['activity']);

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
        $this->check_auth('Coupon/Index/edit');
        $id = intval($_POST['id']);
        $M = D(MODULE_NAME);
        $data = $M->create();

        $M->begin_time = empty($M->begin_time) ? 0 : strtotime($M->begin_time);
        $M->stop_time = empty($M->stop_time) ? 0 : strtotime($M->stop_time);
        $M->award_stop_time = empty($M->award_stop_time) ? 0 : strtotime($M->award_stop_time);

        $M->direction = nl2br($M->direction);
        $M->activity = nl2br($M->activity);
        $M->remark = nl2br($M->remark);

        if ($data === FALSE) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }

        if ($M->where("id=%d", $id)->save()) {
            $this->ajaxReturn(array('data' => 1));  //失败
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }

}
?>


