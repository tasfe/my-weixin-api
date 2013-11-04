<?php

/**
 * 文本指令管理
 *
 * @author <zibin_5257@163.com>lanfengye
 */
class ZhilingAction extends CommonAction {
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
