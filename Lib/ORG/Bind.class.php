<?php

/**
 * 手机微信控制绑定扩展类
 * @Created on:2013-11-18 16:16:43
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class Bind{

    private $weixin_id, $content; //微信ID,微信回复内容
    private $shuoming = ''; //指令说明

    function __construct($weixin_id, $content) {
        $this->weixin_id = $weixin_id;
        $this->content = $content;
        $this->shuoming = $this->make_control_shuoming();
    }

    /**
     * 生成指令说明
     */
    private function make_control_shuoming() {
        $str = "您可以用以下指令进行管理:\n"
                . "测试指令:" . MC('bind_test_dictate') . "\n"
                . "优惠券兑换:" . MC('coupon_convert_dictate') . " 兑换码\n"
                . "抽奖奖品兑换:" . MC('choujiang_convert_dictate') . " 兑换码";
        return $str;
    }

    /**
     * 处理绑定事件 该方法中断后续执行
     */
    public function bind_control() {
        $mobile_bind_dictate = MC('mobile_bind_dictate');  //绑定指令
        $mobile_bind_secret = MC('mobile_bind_secret'); //绑定密钥

        $matchs = array();
        preg_match("#^{$mobile_bind_dictate}\s(\w*)\s(.*)$#", $this->content, $matchs);
        if ($matchs[1] == $mobile_bind_secret) {
            $this->bind_list_control();
        } else {
            file_put_contents('error.txt', '密码错误');
            $Index=A('Index');
            $Index->return_text('请核对您的微信管理绑定密码并重新绑定!');
        }
        exit;
    }

    private function bind_list_control() {
        $Index=A('Index');
        $M = M('MobileBindList');
        if ($M->where("weixin_id='{$this->weixin_id}'")->count('id') > 0) {
            $Index->return_text("您已经绑定过,{$this->shuoming}");
        } else {
            $data = array('weixin_id' => $this->weixin_id, 'create_time' => time(), 'name' => $matchs[2]);
            $return_id = $M->add($data);
            unset($M);
            if ($return_id !== FALSE) {
                $Index->return_text("手机微信管理绑定成功,{$this->shuoming}");
            } else {
                $Index->return_text('绑定失败,请尝试重新绑定!');
            }
        }
    }

}
