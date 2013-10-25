<?php

/**
 * 微信优惠券
 *
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class CouponAction extends CommonAction {
    public function index(){
        $id=  intval($_GET['id']);
        //设置并获取用户微信唯一识别令牌
        $weixin_id = $this->weixin_id(U("/coupon-" . $id));
        
        $Coupon=M('Coupon');
        $info=$Coupon->where("id={$id} and status=1")->find();
        //判断活动是否存在
        if(empty($info)){
            $this->pop='优惠券不存在或者已经结束!';
            $this->display();
            exit;
        }
        $this->info=$info;
        
        $CouponRecord=M('CouponRecord');
        $code_info=$CouponRecord->where("weixin_id='{$weixin_id}' and coupon_id={$id}")->find();
        //判断是否已经领取了优惠券
        if(empty($code_info)){
            //自动进行领取优惠券
            $code_info=$this->draw_code($id, $weixin_id, $info);
            $this->code_info=$code_info;
        }else{
            $this->code_info=$code_info;
            $this->display();
            exit;
        }
        
        if($info['begin_time']>time() && $info['begin_time']!=0){
            $this->assign('pop','本次优惠券领取活动暂未开始!');
        }elseif($info['stop_time']<time() && $info['stop_time']!=0){
            $this->assign('pop','本次优惠券领取活动已经结束!');
        }elseif($CouponRecord->where("id={$id}")->count('id')>=$info['limited'] && $info['limited']!=0){
            $this->assign('pop','本次优惠券已经被抢光了!');
        }
        
        $this->display();
    }
    
    /**
     * 领取优惠券
     * @param type $id 优惠券活动ID
     * @param type $weixin_id 用户微信ID
     * @param type $info 本次优惠券活动信息数组
     * @return array 优惠券信息
     */
    private function draw_code($id,$weixin_id,$info){
        $code=  $this->generate_promotion_code(1, $info['code_length']);
        $data=array(
            'weixin_id'=>$weixin_id,
            'create_time'=>time(),
            'create_date'=>  get_date(),
            'coupon_id'=>$id,
            'code'=>$code,
            'client_ip'=>  get_client_ip()
        );
        M('CouponRecord')->add($data);
        return $data;
    }


    /**
     * 
     * @param type $no_of_codes 定义一个int类型的参数 用来确定生成多少个优惠码
     * @param type $code_length 定义一个code_length的参数来确定优惠码的长度
     * @return array 返回的唯一兑奖码
     */
    private function generate_promotion_code($no_of_codes, $code_length = 4) {
        $characters = "23456789ABCDEFGHJKLMNPQRSTUVWXY";
        $promotion_codes = array(); //这个数组用来接收生成的优惠码 
        for ($j = 0; $j < $no_of_codes; $j++) {
            $code = "";
            for ($i = 0; $i < $code_length; $i++) {
                $code .= $characters[mt_rand(0, strlen($characters) - 1)];
            }
            if (!in_array($code, $promotion_codes)) {
                $count = M('CouponRecord')->where("code='{$code}'")->count();
                if ($count > 0) {
                    $j--;
                } else {
                    $promotion_codes[$j] = $code; //将优惠码赋值给数组 
                }
            } else {
                $j--;
            }
        }
        if ($no_of_codes == 1) {
            return $promotion_codes[0];
        } else {
            return $promotion_codes;
        }
    }
    
}
