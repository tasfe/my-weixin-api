<?php

/**
 * 优惠券管理
 * @author Damon_loo
 */
class CouponDuihuanAction extends CommonAction {
    
    public function index() {
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
        $list = $M->field("c.name,b.create_time,b.code,a.create_date,a.user_name,a.user_telephone,a.weixin_id")
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
        $this->display();
    }

    /**
     * 优惠券兑换方法
     */
    public function detail() {
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

    
    /**
     * 插入方法
     */
    public function insert() {
        $M = D(MODULE_NAME);
        $data = $M->create();
        if ($data === false) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
        $M->create_time = time();
        if (!empty($_POST['filename_imgupload'])) {
            $pic_url_big = $_POST['big_imgupload'] . $_POST['filename_imgupload'];
            $M->pic_url = $pic_url;
        }

        $M->begin_time = empty($M->begin_time) ? 0 : strtotime($M->begin_time);
        $M->stop_time = empty($M->stop_time) ? 0 : strtotime($M->stop_time);
        $M->exchange_stop_time = empty($M->exchange_stop_time) ? 0 : strtotime($M->exchange_stop_time);

        $M->remark = nl2br($M->remark);
        $M->exchange_explain = nl2br($M->exchange_explain);

        $id = $M->add();
        if ($id !== false) {
            $this->ajaxReturn(array('data' => 1));  //成功
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }

    /**
     * 编辑页面显示方法
     */
    public function edit() {
        $id = intval($_GET['id']);
        $M = M(MODULE_NAME);
        $info = $M->where("id=%d", $id)->find();

        $info['begin_time'] = empty($info['begin_time']) ? $info['begin_time'] : get_date_full($info['begin_time']);
        $info['stop_time'] = empty($info['stop_time']) ? $info['stop_time'] : get_date_full($info['stop_time']);
        $info['award_stop_time'] = empty($info['award_stop_time']) ? $info['award_stop_time'] : get_date_full($info['award_stop_time']);

        $info['explain'] = br2nl($info['explain']);
        $info['prize'] = br2nl($info['prize']);

        unset($M);
        if (empty($info)) {
            $this->pop = '编辑的信息不存在！';
        } else {
            $this->info = $info;
        }
        $this->display();
    }

    /**
     * 更新方法
     */
    public function update() {
        $id = intval($_POST['id']);
        $M = D(MODULE_NAME);
        $data = $M->create();

        $M->begin_time = empty($M->begin_time) ? 0 : strtotime($M->begin_time);
        $M->stop_time = empty($M->stop_time) ? 0 : strtotime($M->stop_time);
        $M->award_stop_time = empty($M->award_stop_time) ? 0 : strtotime($M->award_stop_time);

        $M->direction = nl2br($M->direction);
        $M->activity = nl2br($M->activity);
        $M->remark = nl2br($M->remark);

        if ($data === FALSE) {
            $this->ajaxReturn(array('data' => 0));  //失败
        }

        if ($M->where("id=%d", $id)->save()) {
            $this->ajaxReturn(array('data' => 1));  //失败
        } else {
            $this->ajaxReturn(array('data' => 0));  //失败
        }
    }

}
?>


