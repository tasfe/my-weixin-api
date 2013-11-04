<?php

/**
 * 微信秒杀兑换管理
 * @Created on : 2013-9-27, 10:04:26
 * @author <zibin_5257@163.com>lanfengye
 */
class SeckillDuihuanAction extends CommonAction {

    public function index() {
        $this->check_auth('Seckill/duihuan');
        $M = M(MODULE_NAME);

        //处理搜索条件
        $db_fields = $M->getDbFields();
        $search_data = $_GET;

        foreach ($search_data as $key => $value) {
            if (in_array($key, $db_fields)) {
                $parameter .= "{$key}=" . urlencode($value) . '&';
                $this->assign($key, $value);
                $where.="and {$key} like '%{$value}%' ";
            }
        }


        import("ORG.Util.Page");
        $count = $M->where("1 and 1 {$where}")->count();
        $Page = new Page($count, 15);
        $Page->parameter = $parameter;
        $show = $Page->show();
        $prefix = C('DB_PREFIX');
        $list = $M->field("t.id id,t.weixin_id weixin_id,t.create_time duihuan_time,t1.create_time record_time,t2.goods_name,t1.code,t2.goods_price,t.user_name,t.user_telephone")
                ->table("{$prefix}seckill_duihuan t")
                ->where("1 and 1 {$where}")
                ->order('t.id desc')
                ->join(" {$prefix}seckill_record t1 on t.seckill_record_id=t1.id")
                ->join(" {$prefix}seckill_goods t2 on t2.id=t1.seckill_id")
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();

//        dump($list);

        $this->page = $show;

        unset($Page);
        unset($M);



        $this->list = $list;
        $this->display();
    }
    
    public function duihuan(){
        $this->check_auth('Seckill/SeckillDuihuan');
        $this->display();
    }

    /**
     * 获取兑换码信息
     */
    public function get_code() {
        $this->check_auth('Seckill/SeckillDuihuan');
        $code = trim($_POST['code']);
        if (empty($code)) {
            $this->assign($info);
            $this->display();
            exit;
        }
        $M = M("SeckillRecord");
        $info = $M->where("code='{$code}' and status=0")->find();
        if (!empty($info)) {
            $goods_info = M("SeckillGoods")->where("id={$info['seckill_id']}")->find();
            $this->goods_info = $goods_info;
        }
        $this->assign($info);
        $this->display();
    }

    /**
     * 进行兑奖码兑换操作
     */
    public function duihuan_action() {
        $this->check_auth('Seckill/SeckillDuihuan');
        $id = intval($_POST['id']);
        M("SeckillRecord")->where("id={$id}")->setField("status", 1);
        $info = M("SeckillRecord")->where("id={$id}")->find();

        $data = array(
            'weixin_id' => $info['weixin_id'],
            'seckill_record_id' => $info['id'],
            'create_time' => time(),
            'create_date' => get_date(),
            'user_name'=>$_POST['user_name'],
            'user_telephone'=>$_POST['user_telephone']
        );
        M("SeckillDuihuan")->add($data);


        $this->display();
    }

}

?>
