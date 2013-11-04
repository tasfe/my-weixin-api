<?php

/**
 * 文本指令管理
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class ZhilingAction extends CommonAction {
    public function index(){
        $this->check_auth('Reply/Zhiling');
        parent::index();
    }

    public function add(){
        $this->check_auth('Reply/Zhiling/add');
        $this->get_main_list();
        parent::add();
    }
    
    public function insert() {
        $this->check_auth('Reply/Zhiling/add');
        parent::insert();
    }

    public function edit() {
        $this->check_auth('Reply/Zhiling/edit');
        $this->get_main_list();
        parent::edit();
    }
    
    public function update() {
        $this->check_auth('Reply/Zhiling/edit');
        parent::update();
    }
    
    public function delete() {
        $this->check_auth('Reply/Zhiling/delete');
        parent::delete();
    }
    
    

}

?>
