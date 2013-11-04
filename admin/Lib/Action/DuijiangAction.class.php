<?php

/**
 * 兑奖
 * @Created on : 2013-7-24, 16:28:24
 * @author <zibin_5257@163.com>lanfengye
 */
class DuijiangAction extends CommonAction {

    public function index() {
        $this->check_auth('Activities/Choujiang/award/duihuan');
        parent::index();
    }

    /**
     * 获取兑奖码信息
     */
    public function get_code() {
        $this->check_auth('Activities/Choujiang/award/duihuan');
        $code = trim($_POST['code']);
        if (empty($code)) {
            $this->assign($info);
            $this->display();
            exit;
        }
        $M = M("ChoujiangRecord");
        $info = $M->where("award_code='{$code}' and status=0")->find();
        if (!empty($info)) {
            $choujiang = M("Choujiang")->where("id={$info['choujiang_id']}")->find();
            $info['choujiang_name'] = $choujiang['name'];
            $info['choujiang_type'] = get_choujiang_type_name($choujiang['type']);
            $award = M("ChoujiangAward")->where("id={$info['award_id']}")->find();
            $info['award_name'] = $award['name'];
            $info['award_explain'] = $award['explain'];
        }
        $this->assign($info);
        $this->display();
    }

    /**
     * 进行兑奖码兑换操作
     */
    public function duihuan_action() {
        $this->check_auth('Activities/Choujiang/award/duihuan');
        $id = intval($_POST['id']);
        M("ChoujiangRecord")->where("id={$id}")->setField("status", 1);
        $info = M("ChoujiangRecord")->where("id={$id}")->find();

        $data = array(
            'weixin_id' => $info['weixin_id'],
            'record_id' => $id,
            'create_time' => time(),
            'create_date' => get_date()
        );
        M("ChoujiangDuijiang")->add($data);


        $this->display();
    }

}

?>
