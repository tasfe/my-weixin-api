<?php

/**
 * 微信秒杀商城
 * @Created on : 2013-9-10, 14:19:06
 * @author <zibin_5257@163.com>lanfengye
 */
class SeckillAction extends CommonAction {

    public function index() {
        $weixin_id = $this->weixin_id(U('/seckill'));
        $this->insert_access();

        $SeckillAccess = M('SeckillGoods');
        $now_time = time();
        $this->start_array = $SeckillAccess->where("begin_time<={$now_time} and status=1 and stop_time>{$now_time}")->order('sort,begin_time')->select();

        $this->future_array = $SeckillAccess->where("begin_time>{$now_time} and status=1")->order('sort,begin_time')->select();

        $this->display();
    }

    public function record() {
        $weixin_id = $this->weixin_id();
        $type = is_null($_GET['type']) ? 1 : intval($_GET['type']);
        $this->type=$type;
        $where = '';
        if ($type == 1) {
            $where = ' and t.status=0';
        }
        $SeckillRecord = M();
        $pre = C('DB_PREFIX');  //数据库前缀
        $list = $SeckillRecord
                ->field('t.seckill_id,t1.goods_title,t1.goods_name,'
                        . 't1.goods_cost_price,t1.goods_price,t1.exchange_stop_time,'
                        . 't.create_time record_create_time,t.code,t.status record_status')
                ->Table("{$pre}seckill_record t")
                ->join("{$pre}seckill_goods t1 ON t.seckill_id=t1.id")
                ->where("t.weixin_id='{$weixin_id}'{$where}")
                ->order('t.create_time desc')
                ->select();
        
        $this->list = $list;
        $this->display();
    }

    public function view() {
        $id = intval($_GET['id']);
        $weixin_id = $this->weixin_id();
        $this->insert_access($id);

        //获取活动信息
        $SeckillGoods = M('SeckillGoods');
        $this->goods_info = $SeckillGoods->where("id={$id} and status=1")->find();
        if (empty($this->goods_info)) {
            exit('该微信秒杀活动不存在，请返回！');
        }

        //计算用户参与次数
        $SeckillRecord = M('SeckillRecord');
        $partake_num = $SeckillRecord->where("weixin_id='{$weixin_id}' and seckill_id={$id}")->count();
        unset($SeckillRecord);
        $this->partake_num = $partake_num;

        $this->display();
    }

    /**
     * 写入访问记录
     * @return boolean 
     */
    private function insert_access($seckill_id = 0) {
        $weixin_id = $this->weixin_id();
        $data = array(
            'weixin_id' => $weixin_id,
            'create_time' => time(),
            'create_date' => get_date(),
            'seckill_id' => $seckill_id
        );
        $id = M('SeckillAccess')->add($data);
        if ($id !== false)
            return true;
        else
            return false;
    }

    /**
     * 进行秒杀具体操作
     */
    public function insert_record_action() {
        if ($this->isAjax()) {
            $goods_id = intval($_POST['id']);
            $weixin_id = $this->weixin_id();
            $SeckillGoods = M('SeckillGoods');
            $SeckillRecord = M('SeckillRecord');
            $goods_info = $SeckillGoods->where("id={$goods_id}")->find();
            //秒杀信息不存在
            if (empty($goods_info)) {
                $this->ajaxReturn(array('data' => 4));
                exit();
            }
            //活动未开始
            if ($goods_info['begin_time'] > time()) {
                $this->ajaxReturn(array("data" => 0));
                exit();
            }
            //活动已经结束
            if ($goods_info['stop_time'] < time()) {
                $this->ajaxReturn(array("data" => 1));
                exit();
            }
            //商品剩余为0
            if (get_seckill_surplus($goods_id) <= 0) {
                $this->ajaxReturn(array("data" => 2));
                exit();
            }
            //当前秒杀活动次数用完
            if ($SeckillRecord->where("weixin_id='{$weixin_id}' and seckill_id={$goods_id}")->count() >= $goods_info['wx_user_num'] and $goods_info['wx_user_num'] != 0) {
                $this->ajaxReturn(array("data" => 3));
                exit();
            }

            //秒杀成功
            $return_status = $this->insert_record($goods_id, $weixin_id, $goods_info['code_num']);
            if ($return_status) {
                $this->ajaxReturn(array('data' => 88));
            } else {
                $this->ajaxReturn(array('data' => 99));
            }
        } else {
            exit('请求错误！');
        }
    }

    /**
     * 写入成功秒杀记录
     */
    private function insert_record($id, $weixin_id, $code_num = 10) {
        $code = $this->generate_promotion_code(1, $code_num);
        $data = array(
            'weixin_id' => $weixin_id,
            'create_time' => time(),
            'create_date' => get_date(),
            'seckill_id' => $id,
            'code' => $code
        );
        $SeckillRecord = M('SeckillRecord');
        $return_id = $SeckillRecord->add($data);
        S('seckill_surplus_' . $id, NULL);  //清除商品剩余缓存
        if ($return_id !== false) {
            return true;
        } else {
            return false;
        }
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
                $count = M('SeckillRecord')->where("code='{$code}'")->count();
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

?>
