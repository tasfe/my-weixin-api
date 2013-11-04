<?php

/**
 * 微信秒杀商品管理
 * @Created on : 2013-9-27, 10:02:39
 * @author <zibin_5257@163.com>lanfengye
 */
class SeckillGoodsAction extends CommonAction {

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
            $M->pic_url = $pic_url;
        }

        $M->begin_time = empty($M->begin_time) ? 0 : strtotime($M->begin_time);
        $M->stop_time = empty($M->stop_time) ? 0 : strtotime($M->stop_time);
        $M->exchange_stop_time = empty($M->exchange_stop_time) ? 0 : strtotime($M->exchange_stop_time);

        $M->remark = nl2br($M->remark);
        $M->exchange_explain = nl2br($M->exchange_explain);

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
        $M = M(MODULE_NAME);
        $info = $M->where("id=%d", $id)->find();

        $info['begin_time'] = empty($info['begin_time']) ? $info['begin_time'] : get_date_full($info['begin_time']);
        $info['stop_time'] = empty($info['stop_time']) ? $info['stop_time'] : get_date_full($info['stop_time']);
        $info['exchange_stop_time'] = empty($info['exchange_stop_time']) ? $info['exchange_stop_time'] : get_date_full($info['exchange_stop_time']);

        $info['remark'] = br2nl($info['remark']);
        $info['exchange_explain'] = br2nl($info['exchange_explain']);

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
            $M->pic_url = $pic_url_big;
        }

        if ($data === FALSE) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }

        $M->begin_time = empty($M->begin_time) ? 0 : strtotime($M->begin_time);
        $M->stop_time = empty($M->stop_time) ? 0 : strtotime($M->stop_time);
        $M->exchange_stop_time = empty($M->exchange_stop_time) ? 0 : strtotime($M->exchange_stop_time);

        $M->remark = nl2br($M->remark);
        $M->exchange_explain = nl2br($M->exchange_explain);

        if ($M->where("id=%d", $id)->save()) {
            $this->ajaxReturn(array('data' => 1));  //失败
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }

}

?>
