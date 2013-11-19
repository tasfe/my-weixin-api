<?php

/**
 * 手机微信管理指令功能扩展类
 * @uses MobileControl/TextMsgClass 微信文本回复扩展类
 * @uses MobileControl/BindClass 微信手机控制绑定扩展类
 * @uses class MobileControl/ChoujiangConvert 抽奖活动奖品兑换扩展类
 * @Created on:2013-11-19 15:15:36
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class MobileDictate {

    private $msg_info; //微信信息
    private $bind_test_dictate; //测试指令
    private $coupon_convert_dictate; //优惠券兑换指令
    private $choujiang_convert_dictate; //抽奖奖品兑换指令  

    function __construct($msg_info) {
        $this->msg_info = $msg_info;
        $this->bind_test_dictate = MC('bind_test_dictate');
        $this->coupon_convert_dictate = MC('coupon_convert_dictate');
        $this->choujiang_convert_dictate = MC('choujiang_convert_dictate');
        $this->control_test();
    }

    /**
     * 判断执行哪个指令
     */
    private function control_test() {
        //测试功能指令
        if ($this->msg_info->Content == $this->bind_test_dictate) {
            $this->bind_test_dictate();
        } elseif (stripos($this->msg_info->Content, $this->coupon_convert_dictate) === 0) { //优惠券兑换指令
            $this->coupon_convert_control();
        } elseif (stripos($this->msg_info->Content, $this->choujiang_convert_dictate) === 0) { //抽奖奖品兑换指令
            $this->choujiang_convert_control();
        }
    }

    /**
     * 测试功能指令
     * @uses class MobileControl/Bind::make_control_shuoming() 手机微信控制绑定::生成指令说明
     */
    private function bind_test_dictate() {
        import("@.ORG.MobileControl.Bind");
        $Bind = new Bind();
        $shuoming = $Bind->make_control_shuoming();
        import("@.ORG.TextMsg");
        $TextMsg = new TextMsg($this->msg_info);
        $TextMsg->return_text($shuoming);
    }

    /**
     * 优惠券兑换指令控制方法
     * @uses class MobileControl/CouponConvert 优惠券兑换扩展类
     */
    private function coupon_convert_control() {
        import("@.ORG.MobileControl.CouponConvert");
        $CouponConvert = new CouponConvert($this->msg_info);
        $CouponConvert->convert();
    }

    /**
     * 活动奖品兑换指令控制方法
     * @uses class MobileControl/ChoujiangConvert 抽奖活动奖品兑换扩展类
     */
    private function choujiang_convert_control() {
        import("@.ORG.MobileControl.ChoujiangConvert");
        $ChoujiangConvert = new ChoujiangConvert($this->msg_info);
        $ChoujiangConvert->convert();
    }

}
