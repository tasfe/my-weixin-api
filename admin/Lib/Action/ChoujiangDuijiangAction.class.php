<?php

/**
 * 抽奖兑奖记录
 * @Created on : 2013-7-24, 17:18:29
 * @author <zibin_5257@163.com>lanfengye
 */
class ChoujiangDuijiangAction extends CommonAction {

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
        $list = $M->field("t.id id,t.create_time duijiang_time,t1.award_code,t2.name award_name,t2.explain award_explain,t.weixin_id")
                ->table("{$prefix}choujiang_duijiang t")
                ->where("1 and 1 {$where}")
                ->order('t.id desc')
                ->join(" {$prefix}choujiang_record t1 on t.record_id=t1.id")
                ->join(" {$prefix}choujiang_award t2 on t2.id=t1.award_id")
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();

//        dump($list);

        $this->page = $show;

        unset($Page);
        unset($M);



        $this->list = $list;
        $this->display();
    }

}

?>
