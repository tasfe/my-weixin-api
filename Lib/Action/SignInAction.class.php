<?php

/**
 * 每日签到功能
 * @Created on : 2013-9-4, 10:08:14
 * @author <zibin_5257@163.com>lanfengye
 */
class SignInAction extends CommonAction {

    private $integral = 2;  //每日签到获取的积分

    public function index() {
        $weixin_id = $this->weixin_id(U('/sign_in'));

        $M = M('SignInRecord');
        $date = get_date();
        $is_sign = $M->where("weixin_id='{$weixin_id}' and create_date='{$date}'")->count();
        $this->is_sign = $is_sign > 0 ? true : false;
        $this->sign_count = $M->where("weixin_id='{$weixin_id}'")->count();
        $this->sign_integral = $M->where("weixin_id='{$weixin_id}'")->sum('integral');
        $this->sign_near_list=$M->where("weixin_id='{$weixin_id}'")->order("create_time desc")->limit(4)->select();
        unset($M);

        $SignIn = M('SignIn');
        $this->assign($SignIn->find());
        unset($SignIn);

        //获取每日定义宣传语
        $SignInDescription = M('SignInDescription');
        $now_date = get_date();
        $description = $SignInDescription->where("use_date='{$now_date}'")->getField('business_description');
        if (!is_null($description))
            $this->business_description = $description;
        
        $this->display();
    }

    public function insert_sign_in() {
        if ($this->isAjax()) {
            $weixin_id = $this->weixin_id();
            $M = M('SignInRecord');
            $date = get_date();
            if ($M->where("create_date='{$date}' and weixin_id='{$weixin_id}'")->count() > 0) {
                $this->ajaxReturn(array('data' => 0));
                exit;
            }

            $data = array(
                'weixin_id' => $weixin_id,
                'create_time' => time(),
                'create_date' => get_date(),
                'integral' => $this->integral,
                'client_ip' => get_client_ip()
            );
            $id = M('SignInRecord')->add($data);
            if ($id !== false) {
                $this->ajaxReturn(array('data' => 1));
            } else {
                $this->ajaxReturn(array('data' => 2));
            }
        } else {
            exit('请求错误！');
        }
    }

}

?>
