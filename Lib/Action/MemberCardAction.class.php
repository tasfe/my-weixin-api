<?php

/**
 * 微信会员卡系统
 *
 * @author 枫叶
 */
class MemberCardAction extends CommonAction {

    public function index() {
        //设置并获取用户微信唯一识别令牌
        $weixin_id = $this->weixin_id(U("/member_card"),intval($_GET['id']));

        $card_info = $this->get_user_card($weixin_id);
        if (empty($card_info)) {
            $card_info = $this->draw_member_card($weixin_id);
            $this->card_info=$card_info;
        } else {
            $this->card_info = $card_info;
        }

        $this->display();
    }

    /**
     * 
     * @param String $weixin_id 微信会员ID
     * @return type
     */
    private function get_user_card($weixin_id) {
        $M = M('MemberCard');
        $info = $M->where("weixin_id='{$weixin_id}'")->find();
        unset($M);
        return $info;
    }

    /**
     * 新生成微信会员卡
     * @param String $weixin_id 微信ID
     * @return Array 微信会员卡数据
     */
    private function draw_member_card($weixin_id) {
        $data=array(
            'weixin_id'=>$weixin_id,
            'create_time'=>time(),
            'create_date'=>  get_date()
        );
        $MemberCard=M('MemberCard');
        $card_id=$MemberCard->add($data);
        $card_no=  $this->make_car_no($card_id);
        $MemberCard->where("id={$card_id}")->setField('card_no', $card_no);
        $card_info=$MemberCard->where("id={$card_id}")->find();
        unset($MemberCard);
        return $card_info;
    }

    /**
     * 生成会员卡号
     * @param integer $car_id 数据库唯一自增字段
     * 
     * @return string 指定长度的会员卡号
     */
    private function make_car_no($car_id) {
        define('car_num', 10);  //定义会员卡号长度
        define('car_prefix', '');  //定义会员卡前缀
        $car_id = intval($car_id);
        $car_no = ($car_id < pow(10, car_num - 1)) ? ($car_id + pow(10, car_num - 1)) : $car_id;
        $car_no = car_prefix . $car_no;
        return $car_no;
    }

}
