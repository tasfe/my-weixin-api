<?php

/**
 * 系统配置
 * @Created on : 2013-7-19, 10:12:54
 * @author <zibin_5257@163.com>lanfengye
 */
class ConfigAction extends CommonAction {

    function _initialize() {
        parent::_initialize();
        $this->check_auth('Config/sys_con');
    }

    public function index() {
        $M = M('Config');
        $conf_list = $M->where("status=1 and group_id=1")->order("sort,name")->select();
        $this->conf_list = $conf_list;
//        dump($conf_list);
        $this->display();
    }

    public function update() {
        $M = D(MODULE_NAME);
        $data = $_POST;
        foreach ($data as $key => $value) {
            $M->save(array('name'=>$key,'val'=>$value));
        }
        unset($M);
        S('cache_config',NULL);

        $this->ajaxReturn(array('data' => 1));  //成功
    }

}

?>
