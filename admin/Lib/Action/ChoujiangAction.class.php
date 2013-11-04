<?php

/**
 * 抽奖活动管理
 * @Created on : 2013-7-24, 16:10:09
 * @author <zibin_5257@163.com>lanfengye
 */
class ChoujiangAction extends CommonAction {

    public function index() {
        $this->check_auth('Activities/Choujiang');
        parent::index();
    }

    public function add() {
        $this->check_auth('Activities/Choujiang/add');
        parent::add();
    }

    public function delete() {
        $this->check_auth('Activities/Choujiang/delete');
        parent::delete();
    }

    /**
     * 插入方法
     */
    public function insert() {
        $this->check_auth('Activities/Choujiang/add');
        $M = D(MODULE_NAME);
        $data = $M->create();
        if ($data === false) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
        $M->create_time = time();

        $M->begin_time = empty($M->begin_time) ? 0 : strtotime($M->begin_time);
        $M->stop_time = empty($M->stop_time) ? 0 : strtotime($M->stop_time);
        $M->award_stop_time = empty($M->award_stop_time) ? 0 : strtotime($M->award_stop_time);

        $M->explain = nl2br($M->explain);
        $M->prize = nl2br($M->prize);


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
        $this->check_auth('Activities/Choujiang/edit');
        $id = intval($_GET['id']);
        $M = M(MODULE_NAME);
        $info = $M->where("id=%d", $id)->find();

        $info['begin_time'] = empty($info['begin_time']) ? $info['begin_time'] : get_date_full($info['begin_time']);
        $info['stop_time'] = empty($info['stop_time']) ? $info['stop_time'] : get_date_full($info['stop_time']);
        $info['award_stop_time'] = empty($info['award_stop_time']) ? $info['award_stop_time'] : get_date_full($info['award_stop_time']);

        $info['explain'] = br2nl($info['explain']);
        $info['prize'] = br2nl($info['prize']);

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
        $this->check_auth('Activities/Choujiang/edit');
        $id = intval($_POST['id']);
        $M = D(MODULE_NAME);
        $data = $M->create();

        $M->begin_time = empty($M->begin_time) ? 0 : strtotime($M->begin_time);
        $M->stop_time = empty($M->stop_time) ? 0 : strtotime($M->stop_time);
        $M->award_stop_time = empty($M->award_stop_time) ? 0 : strtotime($M->award_stop_time);

        $M->explain = nl2br($M->explain);
        $M->prize = nl2br($M->prize);

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
