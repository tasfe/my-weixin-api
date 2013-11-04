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
}

?>
