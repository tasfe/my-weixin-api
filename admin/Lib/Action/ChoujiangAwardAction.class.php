<?php

/**
 * 抽奖活动礼品管理
 * 
 * @Created on : 2013-7-24, 17:21:05
 * @author <zibin_5257@163.com>lanfengye
 */
class ChoujiangAwardAction extends CommonAction {

    public function index() {
        $id = intval($_GET['id']);
        
        $this->assign('choujiang_id', $id);

        $this->choujiang_name=M("Choujiang")->where("id={$id}")->getField('name');
        
        $M = M(MODULE_NAME);


        import("ORG.Util.Page");
        $count = $M->where("choujiang_id={$id}")->count();
        $Page = new Page($count, 15);
//        $Page->parameter = $parameter;
        $show = $Page->show();

        $list = $M->where("choujiang_id={$id}")->order('sort,id')->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->page = $show;

        unset($Page);
        unset($M);
        $this->list = $list;
        $this->display();
    }
    
    
    /**
     * 添加页面显示方法
     */
    public function add() {
        $this->choujiang_id=$_GET['choujiang_id'];
        $this->display();
    }

}

?>
