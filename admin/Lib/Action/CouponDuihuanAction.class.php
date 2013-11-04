<?php

/**
 * 优惠券管理
 * @author Damon_loo
 */
class CouponDuihuanAction extends CommonAction {
    
    public function index() {
        $this->check_auth('Coupon/CouponDuihuan');
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
        $list = $M->field("c.name,b.create_time,b.code,a.create_time create_time_duihuan,a.user_name,a.user_telephone,a.weixin_id")
                ->table("{$prefix}coupon_duihuan a")
                ->join(" {$prefix}coupon_record b on b.id=a.record_id")
                ->join(" {$prefix}coupon c on b.coupon_id=c.id")
                ->where("1 and 1 {$where} and b.status = 1")
                ->order('a.id desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        $this->page = $show;

        unset($Page);
        unset($M);



        $this->list = $list;
        $this->display();
    }

    /**
     * 兑换方法
     */
    public function duihuan() {
        $this->check_auth('Coupon/CouponDuihuan/duihuan');
        $this->display();
    }

    /**
     * 优惠券兑换方法
     */
    public function detail() {
        $this->check_auth('Coupon/CouponDuihuan/duihuan');
        $code = $_POST['code'];
        $M = M();
        $where = " AND a.code like '%" . $code . "%'";
        $info = $M->field("a.*,b.name,b.direction,b.activity,b.begin_time,b.stop_time,b.award_stop_time,b.remark")
                ->table(C('DB_PREFIX')."coupon_record a")
                ->where("1 and 1 {$where}")
                ->join(" ".C('DB_PREFIX')."coupon b on a.coupon_id=b.id")
                ->find();
        $this->assign('info', $info);
        $this->display();
    }
    
    /**
     * 兑换成功方法
     */
    public function duihuan_action() {
        $this->check_auth('Coupon/CouponDuihuan/duihuan');
        $id = intval($_POST['id']);
        M('coupon_record')->where("id={$id}")->setField("status", 1);
        $info = M("coupon_record")->where("id={$id}")->find();

        $data = array(
            'weixin_id' => $info['weixin_id'],
            'record_id' => $info['id'],
            'create_time' => time(),
            'create_date' => get_date(),
            'user_name'=>$_POST['user_name'],
            'user_telephone'=>$_POST['user_telephone']
        );
        M("coupon_duihuan")->add($data);
        $this->display();
    }

}
?>


