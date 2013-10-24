<?php

/**
 * 抽奖活动
 * @Created on : 2013-7-22, 10:17:45
 * @author <zibin_5257@163.com>lanfengye
 */
class ChoujiangAction extends CommonAction {

    public function aa() {
        import('ORG.Util.Image');
        Image::buildString("一等奖\n请到[查看中奖记录]中查看", '', '', 'png', 0);
    }

    public function index() {
        $id = intval($_GET['id']);

        //设置并获取用户微信唯一识别令牌
        $weixin_id = $this->weixin_id(U("/choujiang-" . $id));

        $info = M(MODULE_NAME)->where("id={$id}")->find();

        //判断是否开启关注状态验证
        if ($info['is_subscribe']) {
            //判断是否已经关注该微信平台，未关注则跳转到指定链接
            if (!$this->insert_subscribe_user($weixin_id, 0)) {
                redirect(MC("no_subscribe_url"));
                exit;
            }
        }

        $this->assign($info);
        if (empty($info)) {
            header("Content-Type: text/html; charset=UTF-8");
            echo '该抽奖活动不存在，请返回！';
        } else {
            //写入访客信息
            $this->insert_access($id);

            //判断活动模板
            switch ($info['type']) {
                case 'guaguaka': //刮刮卡
                    $templet = 'guaguaka';
                    break;
                case 'zajindan':  //砸金蛋
                    $templet = 'zajindan';
                    break;
                case 'dazhuanpan':  //大转盘
                    $templet = 'dazhuanpan';
                    break;
            }
            //检测活动是否开始
            if ($info['begin_time'] > time() && $info['begin_time'] != 0) {
                header("Content-Type: text/html; charset=UTF-8");
                $this->msg = '该活动尚未开始，请在活动开始后在参加！';
                $this->display($templet);
                exit;
            }

            //检测活动是否结束
            if ($info['stop_time'] < time() && $info['stop_time'] != 0) {
                header("Content-Type: text/html; charset=UTF-8");
                $this->msg = '该活动已经结束！';
                $this->display($templet);
                exit;
            }

            //判断活动模板
            switch ($info['type']) {
                case 'guaguaka': //刮刮卡
                    $return_data = $this->make($id, 1);
                    $this->msg = $return_data['msg'];
                    break;
                case 'zajindan':  //砸金蛋
                    $return_data = $this->make($id, 1);
                    $this->msg = $return_data['msg'];
                    break;
                case 'dazhuanpan':  //大转盘
                    $return_data = $this->make($id, 1);
                    $this->msg = $return_data['msg'];
                    break;
            }

            $this->display($templet);
        }
    }

    /**
     * 流水号输入页面 
     * 实现自动跳转到相关的抽奖活动页面
     */
    public function liushuihao() {
        $id = intval($_GET['id']);

        //设置并获取用户微信唯一识别令牌
        $weixin_id = $this->weixin_id(U("/liushuihao-" . $id));

        $info = M(MODULE_NAME)->where("id={$id}")->find();
        $this->assign($info);
        if (empty($info)) {
            header("Content-Type: text/html; charset=UTF-8");
            echo '该抽奖活动不存在，请返回！';
        } else {
            $this->display();
        }
    }

    /**
     * 保存用户流水号
     */
    public function insert_liushuihao() {
        if ($this->isAjax()) {
            $weixin_id = $this->weixin_id();
            $liushuihao = MAGIC_QUOTES_GPC ? $_POST['liushuihao'] : addslashes($_POST['liushuihao']);
            $count = M("ChoujiangLiushuihao")->where("liushuihao='{$liushuihao}'")->count("id");
            if ($count > 0) {  //流水号已经被使用
                $this->ajaxReturn(array("data" => 0));
                exit;
            }

            $data = array(
                "weixin_id" => $weixin_id,
                "liushuihao" => $_POST['liushuihao'],
                "choujiang_id" => intval($_POST['id']),
                "create_time" => time(),
                "create_date" => get_date()
            );
            M("ChoujiangLiushuihao")->add($data);
            $this->ajaxReturn(array("data" => 1));
        }
    }

    /**
     * 中奖记录
     */
    public function my_prize() {
        $weixin_id = $this->weixin_id();
        $ChoujiangRecord = M('ChoujiangRecord');
        $prize_list = $ChoujiangRecord->where("weixin_id='{$weixin_id}' and award_id>0 and status=0 and award_code<>''")->order('create_time desc')->select();

        $this->prize_list = $prize_list;

        $this->display();
    }

    /**
     * 自动生成刮刮卡图片
     */
    public function guaguaka_make() {
        $id = intval($_GET['id']);
        $return_data = $this->make($id);
//        dump($return_data);

        import('ORG.Util.Image');
        if ($return_data['code']) {
            $award_name = get_award_name($return_data['award_id']);
            Image::buildString($award_name . "\n请到[中奖记录]中查看", '', '', 'png', 0);
        } else {
            Image::buildString($return_data['msg'] . "\n请到[中奖记录]中查看", '', '', 'png', 0);
        }
    }

    /**
     * 生成砸金蛋json
     */
    public function zajindan_make() {
        $id = intval($_GET['id']);
        $return_data = $this->make($id);

//        dump($return_data);
//        exit;

        if ($return_data['code']) {
            $award_name = get_award_name($return_data['award_id']);
            if (!empty($return_data['award_code'])) {
                $prize = "恭喜您获得：{$award_name}，请到[查看中奖记录]中查看";
            } else {
                $prize = "金蛋里面是空的呀！感谢参与！";
            }
        } else {
            $prize = $return_data['msg'];
        }


        $data = array(
            'msg' => 1,
            'prize' => $prize
        );
        $this->ajaxReturn($data);
    }

    /**
     * 生成砸金蛋json
     */
    public function dazhuanpan_make() {
        $id = intval($_GET['id']);
        $return_data = $this->make($id);

        $angle = 24; //返回弧度
        $prize = 100;  //中奖奖项 100为谢谢惠顾

        if ($return_data['code']) {
            switch ($return_data['sort']) {
                case 1: //判断奖项
                    $data = array(1, 2);
                    $rand_keys = array_rand($data, 1);
                    $prize = 11;
                    if ($data[$rand_keys] == 1) { //判断正弧度
                        $angle = mt_rand(0, 20);
                    } else {
                        $angle = mt_rand(342, 360);
                    }
                    break;
                case 2:
                    $prize = 12;
                    $angle = mt_rand(70, 110);
                    break;
                case 3:
                    $prize = 13;
                    $angle = mt_rand(160, 200);
                    break;
                case 4:
                    $prize = 14;
                    $angle = mt_rand(250, 290);
                    break;
                case 5:
                    $rand_num = mt_rand(1, 4);
                    $prize = 100;
                    switch ($rand_num) {
                        case 1:
                            $angle = mt_rand(25, 65);
                            break;
                        case 2:
                            $angle = mt_rand(115, 155);
                            break;
                        case 3:
                            $angle = mt_rand(205, 245);
                            break;
                        case 4:
                            $angle = mt_rand(300, 335);
                            break;
                    }
                    break;
            }
        }


        $this->ajaxReturn(array('data' => $angle, 'prize' => $prize));
    }

    /**
     * 写入访客信息
     */
    private function insert_access($choujiang_id = 0) {
        $data = array(
            'weixin_id' => $this->weixin_id(),
            'create_time' => time(),
            'create_date' => get_date(),
            'choujiang_id' => $choujiang_id
        );
        M('ChoujiangAccess')->add($data);
        return true;
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
                $count = M('ChoujiangRecord')->where("award_code='{$code}'")->count();
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

    /**
     * 进行抽奖操作
     * 
     * 前端直接调用
     */
    private function make($id = 0, $type = 0) {
        $weixin_id = $this->weixin_id();
        //获取唯一兑奖码
//        $duijiang = $this->generate_promotion_code(1, 10);
//        dump($duijiang);
        //获取抽奖活动信息
        $choujiang_info = M('Choujiang')->where("id={$id}")->find();
        $code = 1;

        //判断该用户单日抽奖次数
        if ($choujiang_info['user_num'] != 0) {
            $date = get_date();
            if ($choujiang_info['user_num'] <= M('ChoujiangRecord')->where("choujiang_id={$id} and weixin_id='{$weixin_id}' and create_date='{$date}'")->count()) {
                $code = 0;
                $msg = '今日抽奖次数已经用完！请明日再来！查看中奖记录请点击右侧[查看中奖记录]';
            }
        }
        //判断该用户总抽奖次数
        if ($choujiang_info['user_sum_num'] != 0) {
            if ($choujiang_info['user_sum_num'] <= M('ChoujiangRecord')->where("choujiang_id={$id} and weixin_id='{$weixin_id}'")->count()) {
                $code = 0;
                $msg = '您已参加过本次活动，无法再次参加！查看中奖记录请点击右侧[查看中奖记录]';
            }
        }
        /**
         * 判断是否是用户抽奖次数检查
         */
        if ($type) {
            $return_data = array(
                'code' => $code,
                'msg' => $msg
            );
            return $return_data;
        }

        if (empty($msg)) {
            //中奖信息
            $zhongjiang_info = $this->lottery_draw($id);
            $promotion_code = ''; //唯一兑奖码
            //判断奖品数量是否已经超出
            $award_count = M("ChoujiangRecord")->where("award_id={$zhongjiang_info['id']}")->count();
            if ($award_count >= $zhongjiang_info['num'] && $zhongjiang_info['num'] != 0) {
                $msg = '谢谢惠顾！';
                $code = 0;
                $zhongjiang_info['id'] = 0;
            } else {
                if ($zhongjiang_info['make_key']) {
                    //生成兑奖码
                    $promotion_code = $this->generate_promotion_code(1, $choujiang_info['award_code_length']);
                }
            }
            //正确抽奖返回
            if ($code) {
                //构建抽奖记录数组
                $record_data = array(
                    'weixin_id' => $weixin_id,
                    'create_time' => time(),
                    'create_date' => get_date(),
                    'choujiang_id' => $zhongjiang_info['choujiang_id'],
                    'award_code' => $promotion_code,
                    'sort' => $zhongjiang_info['sort'],
                    'award_id' => $zhongjiang_info['id'],
                    'code' => $code,
                    'msg' => $msg
                );
                M('ChoujiangRecord')->add($record_data);
            } else {
                $record_data = array(
                    'code' => $code,
                    'msg' => $msg
                );
            }
        } else {
            $record_data = array(
                'code' => $code,
                'msg' => $msg
            );
        }
        return $record_data;
    }

    /**
     * 进行抽奖
     * @param integer $id 抽奖活动ID
     * 
     * @return array 中奖信息
     */
    private function lottery_draw($id) {
        $award_list = M('ChoujiangAward')->where("choujiang_id={$id}")->order('sort,id')->select();
        if (empty($award_list)) {
            return false;
        }
        //构建奖项信息数组
        foreach ($award_list as $key => $value) {
            $temp_array[$key] = $value['chance'];
        }
        //获取随机中奖号码
        $zhongjiang_no = $this->get_rand($temp_array);
        //获取中奖信息
        return $award_list[$zhongjiang_no];
    }

    /**
     * 根据概率获取中奖号码
     * @param array $proArr 奖项ID和概率数组
     *              $proArr=array(
     *                  0=>1(中奖率)
     *                  1=>10(中奖率)
     *              );
     * @return integer 中奖ID
     */
    private function get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度 
        $proSum = array_sum($proArr);
        //概率数组循环 
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset($proArr);
        return $result;
    }

}

?>
