<?php

/**
 * 微信会员卡系统
 *
 * @author 枫叶
 */
class MemberCardAction extends CommonAction {

    public function index() {
        //设置并获取用户微信唯一识别令牌
        $weixin_id = $this->weixin_id(U("/member_card"), intval($_GET['id']));

        $card_info = $this->get_user_card($weixin_id);
        if (empty($card_info)) {
            $card_info = $this->draw_member_card($weixin_id);
            $this->card_info = $card_info;
        } else {
            $this->card_info = $card_info;
        }
        $sales_info = $this->get_sales(0);
        $base_info = $this->get_sales(1);
        $count = count($sales_info);
//        dump($count);
//        exit();
        $this->assign('sales_info', $sales_info);
        $this->assign('base_info', $base_info);
        $this->assign('count', $count);
        $this->display();
    }

    /**
     * 
     * @param String $id 优惠信息ID
     * @return String
     */
    public function view() {
        $id = $_REQUEST['id'];
        $model = M('MemberSales');
        $info = $model->where("id={$id} AND status=1")->find();
        if(empty($info)){
            $info['title'] = "错误!";
            $info['content'] = "获取优惠活动信息失败！";
        }
        $this->assign('info',$info);
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
        $data = array(
            'weixin_id' => $weixin_id,
            'create_time' => time(),
            'create_date' => get_date()
        );
        $MemberCard = M('MemberCard');
        $card_id = $MemberCard->add($data);
        $card_no = $this->make_car_no($card_id);
        $MemberCard->where("id={$card_id}")->setField('card_no', $card_no);
        $card_info = $MemberCard->where("id={$card_id}")->find();
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

    /**
     * 获取优惠信息
     * @param integer $type 获取信息类型
     * @return array 获取的信息
     */
    private function get_sales($type) {
        $M = M('MemberSales');
        $info = $M->where("type={$type} AND status=1")->order('sort ASC,id DESC')->select();
        unset($M);
        return $info;
    }

}
