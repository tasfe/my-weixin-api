<?php

/**
 * 会员优惠管理
 * @author Zibin.Dou{zibin_5257@163.com}
 */
class MemberSalesAction extends CommonAction {  
    public function index(){
        parent::index("and type=0");
    }
    
    public function config(){
        parent::index("and type=1");
    }
}

?>


