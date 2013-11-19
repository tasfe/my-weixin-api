<?php

/**
 * 腾讯微信公众平台自定义回复接口
 * @version v1.0 2013-01-31
 * @author lanfengye <zibin_5257@163.com>
 */
class IndexAction extends CommonAction {

    var $token = '';  //与微信交互密钥
    //var $key_count=1;  //提取大于等于该数值的词
    var $msg_info;  //微信传递过来的消息信息 全局对象
    private $return_count = 10;  //图文列表返回的数量

    /**
     * 初始化方法
     */

    public function _initialize() {
        parent::_initialize();
        //初始化配置信息
        $this->return_count = MC('list_return_count');
        $this->token = MC('weixin_token');
    }

    public function index() {
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature()) {
            //获取传递过来的XML数据文件
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
            //判断是否传递XML文件
            if (!empty($postStr)) {
                //对XML进行解析
                $this->msg_info = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $this->insert_subscribe_user((string) $this->msg_info->FromUserName);
                $this->msg_type_action();
            } else {
                echo $echoStr;
                exit;
            }
        } else {
            header("Content-Type: text/html; charset=UTF-8");
            echo '微信公众平台API访问成功!';
        }
    }

    /**
     * 根据消息类型选择执行不同方法
     */
    private function msg_type_action() {
        //选择消息类型
        switch ($this->msg_info->MsgType) {
            case 'event': //事件消息
                switch ($this->msg_info->Event) {
                    case 'subscribe':  //订阅事件
                        $this->subscribe_msg();
                        break;
                    case 'unsubscribe':  //取消订阅事件
                        //写入取消订阅记录
                        $this->unsubscribe((string) $this->msg_info->FromUserName);
                        break;
                    case 'CLICK':  //自定义菜单点击事件(预留)
                        //调用菜单单击消息处理
                        $this->menu_click_msg();
                        break;
                    default:  //默认事件为订阅事件
                        $this->subscribe_msg();
                        break;
                }
                break;
            case 'text':  //文本消息
                $this->text_msg();
                break;
            case 'image':  //图片消息
                break;
            case 'location': //地理位置消息
                break;
            default:
                $this->subscribe_msg();
                break;
        }
    }

    /**
     * 微信自定义菜单点击消息事件处理 
     */
    protected function menu_click_msg() {
        //获取菜单消息
        $content = trim($this->msg_info->EventKey);
        $Zhiling = M('Zhiling');
        $data = $Zhiling->where(array("menu_key" => $content, "status" => 1, "main" => 0))->find();
        if (!empty($data)) {
            //判断回复的消息类型
            $this->text_msg_return($data);
        } else {
            $this->return_text('该菜单点击功能未定义，请到后台定义菜单响应功能！');
        }
    }

    /**
     * 退订触发事件
     * @param type $weixin_name
     */
    protected function unsubscribe($weixin_name) {
        $weixin_name = MAGIC_QUOTES_GPC ? $weixin_name : addslashes($weixin_name);
        M('WeixinUser')->where("weixin_name='{$weixin_name}'")->delete();
        $data = array(
            'weixin_name' => $weixin_name,
            'create_time' => time(),
            'create_date' => get_date()
        );
        M('Unsubscrib')->add($data);
        return true;
    }

    /**
     * 订阅事件消息
     */
    private function subscribe_msg() {
        $Subscribe = M('Subscribe');

        $data = $Subscribe->where("status=1 and main=0")->order("sort,id")->find();

        if (empty($data)) {
            $this->return_text('欢迎您关注微信！');
        } else {
            //判断回复的消息类型
            switch ($data['msg_type']) {
                case 1:  //文本
                    $content = empty($data['contents']) ? '欢迎您关注微信！' : $data['contents'];
                    $this->return_text($content);
                    break;
                case 2:  //单条图文
//                    $url = empty($data['click_url']) ? 'http://' . $_SERVER['SERVER_NAME'] . U('subscribe/view?id=' . $data['id']) : $data['click_url'];
                    if (empty($data['click_url'])) {
                        $url = 'http://' . $_SERVER['SERVER_NAME'] . U('subscribe/view?id=' . $data['id']);
                    } else {
                        if (strpos($data['click_url'], '?') !== false) {
                            $url = $data['click_url'] . '&from_weixin_user=' . $this->msg_info->FromUserName;
                        } else {
                            $url = $data['click_url'] . '?from_weixin_user=' . $this->msg_info->FromUserName;
                        }
                    }
                    $pic_url = empty($data['pic_url_big']) ? MC('pic_url') : $data['pic_url_big'];
                    $pic_url = 'http://' . $_SERVER['SERVER_NAME'] . $pic_url;
                    $info = array(
                        'title' => $data['title'],
                        'discription' => $data['description'], //描述
                        'url' => $url, //点击url
                        'pic_url' => $pic_url  //封面图片url
                    );
                    $this->return_image_text($info);
                    break;
                case 3: //多条图文
                    $data_array[] = $data;
                    $temp_array = $Subscribe->where("main={$data['id']} and status=1")->order("sort,id")->select();

                    //合并两个结果数组
                    $return_array = array_merge($data_array, $temp_array);

                    //返回图文列表
                    $this->return_images_texts($return_array, 'subscribe');
                    break;
                default:
                    $content = empty($data['contents']) ? '欢迎您关注微信！' : $data['contents'];
                    $this->return_text($content);
                    break;
            }
        }
    }

    /**
     * 处理系统级指令
     * @param type $content
     */
    private function system_callback($content) {
        switch ($content) {
            case 'wxid':
                $this->return_text('您的微信ID：' . $this->msg_info->FromUserName);
                exit;
                break;
            default:
                break;
        }
    }

    /**
     * 处理手机微信管理指令系统
     * @param String $content 用户回复的文本信息
     */
    private function dictate_control($content) {
        if (MC('mobile_bind_status')) { //判断是否开启绑定
            $mobile_bind_dictate = MC('mobile_bind_dictate');
            if (stripos($content, $mobile_bind_dictate) === 0) { //判断开头为"绑定指令"
                import("@.ORG.Bind");
                $Bind = new Bind($this->msg_info);
                $Bind->bind_control();
            }
        }
    }

    /**
     * 文本消息处理
     */
    private function text_msg() {
        //获取文本消息内容
        $content = trim($this->msg_info->Content);
        $this->system_callback($content);   //系统级指令
        $this->dictate_control($content);  //指令系统
        $Zhiling = M('Zhiling');
        $data = $Zhiling->where(array("code" => $content, "status" => 1))->find();
        //判断是否定义指令
        if (!empty($data)) {
            //判断回复的消息类型
            $this->text_msg_return($data);
        } else {
            //判断是否为5位数字流水号
            preg_match("#^(\d){5}$#", $this->msg_info->Content, $str);
            if (!empty($str)) {
                $data = $Zhiling->where(array("code" => '刮刮卡', "status" => 1))->find();
                $this->text_msg_return($data);
                exit;
            }

            //导入智能回复扩展类
            import("@.ORG.IntelligentMsg");
            $IntelligentMsg = new IntelligentMsg($this->msg_info);
            $return_array = $IntelligentMsg->get_intelligent_msg();

            if (empty($return_array)) {
                //默认没有找到回复
//                $this->return_text($this->no_keys_return);
            } elseif ($return_array[0]['msg_type'] == 1) {
                $this->return_text($return_array[0]['contents']);
            } elseif ($return_array[0]['msg_type'] == 2) {
                $url = empty($return_array[0]['click_url']) ? 'http://' . $_SERVER['SERVER_NAME'] . U('reply_database/view?id=' . $return_array[0]['id']) : $return_array[0]['click_url'];
                $pic_url_big = empty($return_array[0]['pic_url_big']) ? MC('pic_url_big') : $return_array[0]['pic_url_big'];
                $pic_url = 'http://' . $_SERVER['SERVER_NAME'] . $pic_url_big;
                $info = array(
                    'title' => $return_array[0]['title'],
                    'discription' => $return_array[0]['description'], //描述
                    'url' => $url, //点击url
                    'pic_url' => $pic_url  //封面图片url
                );

                $this->return_image_text($info);
            } else {
                $this->return_images_texts($return_array, 'reply_database');
            }
        }
    }

    private function text_msg_return($data, $type = 'Zhiling') {
        switch ($data['msg_type']) {
            case 1:  //文本
                $content = empty($data['contents']) ? '欢迎您关注微信！' : $data['contents'];
                $this->return_text($content);
                break;
            case 2:  //单条图文
                if (empty($data['click_url'])) {
                    $url = 'http://' . $_SERVER['SERVER_NAME'] . U('zhiling/view?id=' . $data['id']);
                } else {
                    if (strpos($data['click_url'], '?') !== false) {
                        $url = $data['click_url'] . '&from_weixin_user=' . $this->msg_info->FromUserName;
                    } else {
                        $url = $data['click_url'] . '?from_weixin_user=' . $this->msg_info->FromUserName;
                    }
                }

                $pic_url_small = empty($data['pic_url_small']) ? MC('pic_url_small') : $data['pic_url_small'];
                $pic_url_big = empty($data['pic_url_big']) ? MC('pic_url_big') : $data['pic_url_big'];
                $info = array(
                    'title' => $data['title'],
                    'discription' => $data['description'], //描述
                    'url' => $url, //点击url
                    'pic_url' => 'http://' . $_SERVER['SERVER_NAME'] . $pic_url_big  //封面图片url  大图
                );
                $this->return_image_text($info);
                break;
            case 3: //多条图文
                $data_array[] = $data;
                $Zhiling = M($type);
                $temp_array = $Zhiling->where("main={$data['id']} and status=1")->order("sort,id")->select();
                //合并两个结果数组
                $return_array = array_merge($data_array, $temp_array);
                //返回图文列表
                $this->return_images_texts($return_array);
                break;
            default:
                $content = empty($data['contents']) ? '欢迎您关注微信！' : $data['contents'];
                $this->return_text($content);
                break;
        }
    }

    /**
     * 返回多条图文列表
     */
    private function return_images_texts($list, $action_name = 'zhiling') {
        $time = time();
        $textTpl = "<xml>
                 <ToUserName><![CDATA[{$this->msg_info->FromUserName}]]></ToUserName>
                 <FromUserName><![CDATA[{$this->msg_info->ToUserName}]]></FromUserName>
                 <CreateTime>{$time}</CreateTime>
                 <MsgType><![CDATA[news]]></MsgType>
                 <Content><![CDATA[]]></Content>";
        foreach ($list as $key => $value) {
            if ($key + 1 > $this->return_count) {
                break;
            }

            //判断点击链接是否为空
            if (empty($value['click_url'])) {
                $url = 'http://' . $_SERVER['SERVER_NAME'] . U($action_name . '/view?id=' . $value['id']);
            } else {
                if (strpos($value['click_url'], '?') !== false) {
                    $url = $value['click_url'] . '&from_weixin_user=' . $this->msg_info->FromUserName;
                } else {
                    $url = $value['click_url'] . '?from_weixin_user=' . $this->msg_info->FromUserName;
                }
            }

            $pic_url_small = empty($value['pic_url_small']) ? MC('pic_url') : $value['pic_url_small'];  //小封皮
            $pic_url_big = empty($value['pic_url_big']) ? MC('pic_url') : $value['pic_url_big'];  //大封皮
            $pic_url = ($key <= 0) ? 'http://' . $_SERVER['SERVER_NAME'] . $pic_url_big : 'http://' . $_SERVER['SERVER_NAME'] . $pic_url_small;
            $list_str[] = "<item>
                 <Title><![CDATA[{$value['title']}]]></Title>
                 <Description><![CDATA[{$value['discription']}]]></Description>
                 <PicUrl><![CDATA[{$pic_url}]]></PicUrl>
                 <Url><![CDATA[{$url}]]></Url>
                 </item>";
        }

        $count = count($list_str);
        $list_strstr = implode($list_str);


        $tempStr = "<ArticleCount>{$count}</ArticleCount>
                 <Articles>
                 {$list_strstr}
                 </Articles>
                 <FuncFlag>1</FuncFlag>
                 </xml>";
        $textTpl.=$tempStr;
        echo $textTpl;
    }

    /**
     * 
     * @param array $info 单条图文信息数组
     * $info=array(
     * title:标题
     * discription:描述信息
     * url:点击链接
     * pic_url:图片链接
     * );
     */
    private function return_image_text($info) {
        $textTpl = "<xml>
 <ToUserName><![CDATA[%s]]></ToUserName>
 <FromUserName><![CDATA[%s]]></FromUserName>
 <CreateTime>%s</CreateTime>
 <MsgType><![CDATA[news]]></MsgType>
 <Content><![CDATA[]]></Content>
 <ArticleCount>1</ArticleCount>
 <Articles>
 <item>
 <Title><![CDATA[%s]]></Title>
 <Description><![CDATA[%s]]></Description>
 <PicUrl><![CDATA[%s]]></PicUrl>
 <Url><![CDATA[%s]]></Url>
 </item>
 </Articles>
 <FuncFlag>1</FuncFlag>
 </xml>";
        if (!empty($info)) {
            $resultStr = sprintf($textTpl, $this->msg_info->FromUserName, $this->msg_info->ToUserName, time(), $info['title'], $info['discription'], $info['pic_url'], $info['url']);
            echo $resultStr;
        } else {
            echo "您什么都没有输入...";
        }
    }

    /**
     * 给微信接口返回单条文本信息
     * @param String $str 要回复的文本
     */
    public function return_text($str) {
        import("@.ORG.TextMsg");
        $TextMsg = new TextMsg($this->msg_info);
        $TextMsg->return_text($str);
        unset($TextMsg);
    }

    /**
     * 对签名进行验证
     * @return boolean
     */
    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $tmpArr = array("{$this->token}", $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

}
