<?php

/**
 * 手机微信控制配置
 * @Created on:2013-11-18 10:15:34
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class MobileConfigAction extends CommonAction {

    function _initialize() {
        parent::_initialize();
        $this->check_auth('Mobile/mobile_con');
    }

    public function index() {
        $M = M('Config');
        $conf_list = $M->where("status=1 and group_id=2")->order("sort,name")->select();
        $this->conf_list = $conf_list;
        $this->display();
    }

    public function update() {
        $M = M('Config');
        $data = $_POST;
        foreach ($data as $key => $value) {
            $M->save(array('name' => $key, 'val' => $value));
        }
        unset($M);
        S('cache_config', NULL);

        $this->ajaxReturn(array('data' => 1));  //成功
    }

}
