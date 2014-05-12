<?php

/**
 * 用户消息管理
 *
 * @author 蓝枫叶<zibin_5257@163.com>
 * @CreateTime 2014-5-9 9:23:38
 */
class UserMessageAction extends CommonAction {

    function index() {
        $order = "create_time desc";
        $M = M(MODULE_NAME);

        import("ORG.Util.Page");
        $list_temp = $M->field("id")->group("wx_name")->select();
        $count=count($list_temp);
        $Page = new Page($count, 15);
        $show = $Page->show();

        $list = $M->group("wx_name")->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->page = $show;

        unset($Page);
        unset($M);
        $this->list = $list;
        $this->display();
    }
    
    /**
     * 查看用户会话消息
     */
    public function view(){
        $this->check_auth("Message/index/view");
        $id=intval($_GET['id']);
        $UserMessage=M("UserMessage");
        $weixin_name=$UserMessage->where("id={$id}")->getField("wx_name");
        $list=$UserMessage->where("wx_name='{$weixin_name}'")->order("id desc")->select();
        $this->list=$list;
        $this->display();
    }
    
    /**
     * 回复消息给用户
     * 注意 必须产生交互48小时内
     */
    public function reply_action(){
        $wx_name=$_POST['wx_name'];
        $content=$_POST['content'];
        $data=array(
            "touser"=>$wx_name,
            "msgtype"=>"text",
            "text"=>array(
                "content"=>"content"
            )
        );
        $weixin_access_token = get_weixin_access_token();
        $json_data=urldecode(json_encode($data));
        $return_code=https_post_data($this->api_url . 'message/custom/send?access_token=' . $weixin_access_token, $json_data);
        $json_decode_data = json_decode($return_code[1], true);
        $this->ajaxReturn($json_decode_data);
    }

}
