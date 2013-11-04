<?php

/**
 * 会员优惠管理
 * @author Zibin.Dou{zibin_5257@163.com}
 */
class MemberSalesAction extends CommonAction {

    public function index() {
        $this->check_auth('Member/MemberSales');
        parent::index("and type=0");
    }

    public function add() {
        $this->check_auth('Member/MemberSales/add');
        parent::add();
    }
    
    public function insert() {
        $this->check_auth('Member/MemberSales/add');
        parent::insert();
    }
    
    public function delete() {
        $this->check_auth('Member/MemberSales/delete');
        parent::delete();
    }

    public function config() {
        $this->check_auth('Member/config');
        parent::index("and type=1");
    }

}
?>


