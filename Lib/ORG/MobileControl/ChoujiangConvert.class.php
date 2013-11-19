<?php

/**
 * 抽奖活动奖品兑换扩展类
 * @Created on:2013-11-19 16:29:25
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class ChoujiangConvert {

    private $msg_info; //微信信息
    private $choujiang_convert_dictate; //抽奖奖品兑换指令

    function __construct($msg_info) {
        $this->msg_info = $msg_info;
        $this->choujiang_convert_dictate = MC('choujiang_convert_dictate');
    }

    /**
     * 兑换执行方法
     */
    public function convert() {
        
    }

}
