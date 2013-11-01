<?php

/**
 * 会员管理
 * @author Damon_loo
 */
class MemberCardAction extends CommonAction {
    
    /**
     * 会员验证方法
     */
    public function identity() {
        $this->display();
    }
    
    /**
     * 会员验证方法
     */
    public function detail() {
        $code = $_POST['code'];
        if(empty($code)){
            $flasemsg = "您输入的会员卡号无效！"; 
            $this->assign('flasemsg',$flasemsg);
            $this->display();
            exit;
        }
        $M=M("member_card");
        $info=$M->where("card_no='{$code}'")->find();
        if(empty($info)){
            $flasemsg = "您输入的会员卡号无效！"; 
            $this->assign('flasemsg',$flasemsg);
        }
        $this->assign('info',$info);
        $this->display();
    }

    /**
     * 编辑页面显示方法
     */
    public function edit() {
        $id = intval($_GET['id']);
        $M = M(MODULE_NAME);
        $info = $M->where("id=%d", $id)->find();
        
        $info['begin_time']=  empty($info['begin_time'])?$info['begin_time']:get_date_full($info['begin_time']);
        $info['stop_time']=  empty($info['stop_time'])?$info['stop_time']:get_date_full($info['stop_time']);
        $info['award_stop_time']=  empty($info['award_stop_time'])?$info['award_stop_time']:get_date_full($info['award_stop_time']);
        
        $info['explain']=  br2nl($info['explain']);
        $info['prize']=  br2nl($info['prize']);
        
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

        $M->explain = nl2br($M->explain);
        $M->prize = nl2br($M->prize);

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

