<?php

/**
 * 新订阅管理
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class SubscribeAction extends CommonAction {
    function _initialize() {
        parent::_initialize();
         $this->check_auth('Config/Subscribe');
    }
    
    
    public function add(){
        $this->check_auth('Config/Subscribe/add');
        $this->get_main_list();
        parent::add();
    }
    
    public function insert(){
        $this->check_auth('Config/Subscribe/add');
        parent::insert();
    }

    public function edit() {
        $this->check_auth('Config/Subscribe/edit');
        $this->get_main_list();
        parent::edit();
    }
    
    public function update() {
        $this->check_auth('Config/Subscribe/edit');
        parent::update();
    }
    
    public function delete() {
        $this->check_auth('Config/Subscribe/delete');
        parent::delete();
    }
}

?>
