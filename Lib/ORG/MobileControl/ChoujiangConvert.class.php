<?php

/**
 * 抽奖活动奖品兑换扩展类
 * @Created on:2013-11-19 16:29:25
 * @author 蓝枫叶{zibin_5257@163.com}
 */
class ChoujiangConvert {

    private $msg_info; //微信信息
    private $choujiang_convert_dictate; //抽奖奖品兑换指令

    function __construct($msg_info) {
        $this->msg_info = $msg_info;
        $this->choujiang_convert_dictate = MC('choujiang_convert_dictate');
    }

    /**
     * 兑换执行方法
     */
    public function convert() {
        $matchs = array();
        import("@.ORG.TextMsg");
        $TextMsg = new TextMsg($this->msg_info);
        preg_match("#^{$this->choujiang_convert_dictate}\s(\w*)$#", $this->msg_info->Content, $matchs);
        $award_info = $this->get_award_info($matchs[1]);
        if (empty($award_info)) {
            $TextMsg->return_text("兑换码为:{$matchs[1]}的奖品信息不存在或者已经兑换!");
        } elseif ($award_info['award_stop_time'] < time() && $award_info['award_stop_time'] != 0) {
            $TextMsg->return_text("兑换码为:{$matchs[1]}的活动奖品兑换已截止,无法进行兑换!");
        } else {
            $this->write_convert_log($award_info['id']);
            $return_shuoming = $this->make_shuoming($award_info);
            $TextMsg->return_text($return_shuoming);
        }
    }

    /**
     * 生成兑换信息
     * @param array $award_info 奖品信息数组
     */
    private function make_shuoming($award_info) {
        $str = "兑奖码{$award_info['award_code']}兑换成功,以下为奖品信息:\n\n"
                . "活动名称:{$award_info['choujiang_name']}\n\n"
                . "抽奖类型:{$award_info['choujiang_type']}\n\n"
                . "奖品名称:{$award_info['award_name']}\n\n"
                . "奖品说明:{$award_info['award_explain']}";
        return $str;
    }

    /**
     * 根据兑换码获取活动和奖品信息
     */
    private function get_award_info($code) {
        $M = M("ChoujiangRecord");
        $info = $M->where("award_code='{$code}' and status=0")->find();
        if (!empty($info)) {
            $choujiang = M("Choujiang")->where("id={$info['choujiang_id']}")->find();
            $info['choujiang_name'] = $choujiang['name'];
            $info['choujiang_type'] = get_choujiang_type_name($choujiang['type']);
            $info['award_stop_time'] = $choujiang['award_stop_time'];
            $award = M("ChoujiangAward")->where("id={$info['award_id']}")->find();
            $info['award_name'] = $award['name'];
            $info['award_explain'] = $award['explain'];
        }
        return $info;
    }

    /**
     * 写入兑换记录
     */
    private function write_convert_log($id) {
        M("ChoujiangRecord")->where("id={$id}")->setField("status", 1);
        $info = M("ChoujiangRecord")->where("id={$id}")->find();

        $data = array(
            'weixin_id' => $info['weixin_id'],
            'record_id' => $id,
            'create_time' => time(),
            'create_date' => get_date(),
            'convert_from' => (string) $this->msg_info->FromUserName
        );
        M("ChoujiangDuijiang")->add($data);
    }

}
