<?php

/**
 * 微信文本消息返回扩展类
 * @Created on:2013-11-19 10:24:59
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class TextMsg {

    private $msg_info = array(); //微信消息信息

//    FromUserName 消息发送方weixin_id
//    ToUserName 消息接收方weixin_id

    function __construct($msg_info) {
        $this->msg_info = $msg_info;
    }

    /**
     * 给微信接口返回单条文本信息
     * @param String $str 要回复的文本
     */
    public function return_text($str) {
        $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>"
                . "<FromUserName><![CDATA[%s]]></FromUserName>"
                . "<CreateTime>%s</CreateTime>"
                . "<MsgType><![CDATA[text]]></MsgType>"
                . "<Content><![CDATA[%s]]></Content>"
                . "<FuncFlag>0</FuncFlag></xml>";
        $str = $str == '' ? '没有返回信息' : $str;
        $resultStr = sprintf($textTpl, $this->msg_info->FromUserName, $this->msg_info->ToUserName, time(), $str);
        echo $resultStr;
        exit;
    }

}
