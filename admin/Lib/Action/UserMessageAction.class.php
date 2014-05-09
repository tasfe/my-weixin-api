<?php

/**
 * 用户消息管理
 *
 * @author 蓝枫叶<zibin_5257@163.com>
 * @CreateTime 2014-5-9 9:23:38
 */
class UserMessageAction extends CommonAction {

    function index() {
        $order = "create_time desc";
        $M = M(MODULE_NAME);

        import("ORG.Util.Page");
        $list_temp = $M->field("id")->group("wx_name")->select();
        $count=count($list_temp);
        $Page = new Page($count, 15);
        $show = $Page->show();

        $list = $M->group("wx_name")->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->page = $show;

        unset($Page);
        unset($M);
        $this->list = $list;
        $this->display();
    }

}
