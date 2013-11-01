<?php

/**
 * 新订阅管理
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class SubscribeAction extends CommonAction {
    public function add(){
        $this->get_main_list();
        parent::add();
    }
    
    
    public function edit() {
        $this->get_main_list();
        parent::edit();
    }
    
    

}

?>
