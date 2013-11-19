<?php

/**
 * 优惠券手机兑换扩展类
 * @Created on:2013-11-19 16:03:16
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class CouponConvert {

    private $msg_info; //微信信息
    private $coupon_convert_dictate; //优惠券兑换指令

    function __construct($msg_info) {
        $this->msg_info = $msg_info;
        $this->coupon_convert_dictate = MC('coupon_convert_dictate');
    }

    /**
     * 兑换执行方法
     */
    public function convert() {
        $matchs = array();
        import("@.ORG.TextMsg");
        $TextMsg = new TextMsg($this->msg_info);
        preg_match("#^{$this->coupon_convert_dictate}\s(\w*)$#", $this->msg_info->Content, $matchs);
        $coupon_info = $this->get_coupon_info($matchs[1]);
        if (empty($coupon_info)) {
            $TextMsg->return_text("兑换码为:{$matchs[1]}的优惠券信息不存在或者已经兑换!");
        } elseif ($coupon_info['award_stop_time'] < time() && $coupon_info['award_stop_time']!=0) {
            $TextMsg->return_text("兑换码为:{$matchs[1]}的优惠券已经过期,无法进行兑换!");
        } else {
            $this->write_convert_log($coupon_info['id']);
            $return_shuoming = $this->make_shuoming($coupon_info);
            $TextMsg->return_text($return_shuoming);
        }
    }

    /**
     * 生成兑换信息
     * @param array $coupon_info 兑换券信息数组
     */
    private function make_shuoming($coupon_info) {
        $str = "优惠券{$coupon_info['code']}兑换成功,以下为优惠券信息:\n\n"
                . "优惠券名称:{$coupon_info['name']}\n\n"
                . "使用说明:{$coupon_info['direction']}";
        return $str;
    }

    /**
     * 根据兑换码获取优惠券信息
     */
    private function get_coupon_info($code) {
        $M = M();
        $info = $M->field("a.*,b.name,b.direction,b.activity,b.award_stop_time")
                ->table(C('DB_PREFIX') . "coupon_record a")
                ->where("a.code='{$code}' and a.status=0")
                ->join(C('DB_PREFIX') . "coupon b on a.coupon_id=b.id")
                ->find();
        return $info;
    }

    /**
     * 写入兑换记录
     */
    private function write_convert_log($id) {
        M('CouponRecord')->where("id={$id}")->setField("status", 1);
        $info = M("CouponRecord")->where("id={$id}")->find();

        $data = array(
            'weixin_id' => $info['weixin_id'],
            'record_id' => $info['id'],
            'create_time' => time(),
            'create_date' => get_date(),
            'user_name' => $_POST['user_name'],
            'user_telephone' => $_POST['user_telephone'],
            'convert_from' => (string) $this->msg_info->FromUserName
        );
        M("CouponDuihuan")->add($data);
    }

}
