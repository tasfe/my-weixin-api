<?php

/**
 * 智能回复数据库管理
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class ReplyDatabaseAction extends CommonAction {
    public function index() {
        $this->check_auth('Reply/ReplyDatabase');
        parent::index();
    }
    
    public function add() {
        $this->check_auth('Reply/ReplyDatabase/add');
        parent::add();
    }
    
    public function edit() {
        $this->check_auth('Reply/ReplyDatabase/edit');
        parent::edit();
    }
    
    public function insert() {
        $this->check_auth('Reply/ReplyDatabase/add');
        parent::insert();
    }
    
    public function update() {
        $this->check_auth('Reply/ReplyDatabase/edit');
        parent::update();
    }
    
    public function delete() {
        $this->check_auth('Reply/ReplyDatabase/delete');
        parent::delete();
    }
}

?>
