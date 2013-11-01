<?php

/**
 * 微信自定义菜单管理
 * @Created on : 2013-8-9, 15:20:17
 * @author <zibin_5257@163.com>lanfengye
 */
class WeixinMenuAction extends CommonAction {

    private $api_url = 'https://api.weixin.qq.com/cgi-bin/menu/'; //微信服务器接口基础地址
    
    function _initialize() {
        parent::_initialize();
        $this->check_auth('Config/WeixinMenu');
    }

    /**
     * 顶级菜单列表首页
     */

    public function index() {
        $this->check_auth('Config/WeixinMenu');
        parent::index(" and main=0", 'sort,id');
    }

    /**
     * 子菜单列表
     */
    public function index_submenu() {
        $main_id = intval($_GET['menu_id']);
        $this->main_id = $main_id;
        parent::index(" and main={$main_id}", 'sort,id');
    }

    /**
     * 添加子菜单
     */
    public function add_submenu() {
        $this->menu_id = intval($_GET['id']);
        parent::add();
    }

    /**
     * 删除微信服务器上的微信菜单
     */
    public function delete_weixin_menu() {
        if ($this->isAjax()) {
            //获取微信服务器访问授权密钥
            $weixin_access_token = get_weixin_access_token();
            $return = https_request($this->api_url . 'delete' . '?access_token=' . $weixin_access_token);
            $this->ajaxReturn(json_decode($return, true));
        } else {
            header("Content-Type: text/html; charset=UTF-8");
            exit('请使用正确的方式进行访问！');
        }
    }

    /**
     * 获取微信服务器当前菜单
     */
    public function get_weixin_server_menu() {
        //获取微信服务器访问授权密钥
        $weixin_access_token = get_weixin_access_token();
        $return = https_request($this->api_url . 'get' . '?access_token=' . $weixin_access_token);

        $return_array = json_decode($return, true);

//        $return='{"menu":{"button":[{"type":"click","name":"今日歌曲","key":"V1001_TODAY_MUSIC","sub_button":[]},{"type":"click","name":"歌手简介","key":"V1001_TODAY_SINGER","sub_button":[]},{"name":"菜单","sub_button":[{"type":"click","name":"hello word","key":"V1001_HELLO_WORLD","sub_button":[]},{"type":"click","name":"赞一下我们","key":"V1001_GOOD","sub_button":[]}]}]}}';
        $this->data = $return_array;

        $this->display();
    }

    /**
     * 将自定义菜单上传到微信服务器
     */
    public function put_weixin_menu() {
        $M = M("WeixinMenu");
        $menu_data = array();
        $main_menu = $M->where("main=0 and status=1")->order('sort,id')->select();
        foreach ($main_menu as $key => $value) {
            $menu_data[$key] = $this->create_menu_field($value);
            //判断是否为直接展示链接
            if (!empty($value['url'])) {
                unset($menu_data[$key]['key']);
                unset($menu_data[$key]['type']);
                $menu_data[$key]['type'] = 'view';
                $menu_data[$key]['url'] = $value['url'];
            } else {
                $submenu = $M->where("main={$value['id']} and status=1")->order('sort,id')->select();
                if (count($submenu) > 0) {
                    unset($menu_data[$key]['key']);
                    unset($menu_data[$key]['type']);
                    foreach ($submenu as $key_sub => $value_sub) {
                        $menu_data[$key]['sub_button'][$key_sub] = $this->create_menu_field($value_sub);
                    }
                }
            }
        }
        //将json_data POST上传到微信服务器接口地址即可
        $json_data = urldecode(json_encode(array("button" => $menu_data)));

        //获取微信服务器访问授权密钥
        $weixin_access_token = get_weixin_access_token();
        $return_code = $this->https_post_data($this->api_url . 'create?access_token=' . $weixin_access_token, $json_data);
        $json_decode_data = json_decode($return_code[1], true);
//        dump($json_decode_data);
        //成功返回{"errcode":0,"errmsg":"ok"}
        //失败返回{"errcode":40018,"errmsg":"invalid button name size"}
        //具体错误码详见腾讯微信公众平台官方文档http://mp.weixin.qq.com/wiki/index.php?title=%E8%87%AA%E5%AE%9A%E4%B9%89%E8%8F%9C%E5%8D%95%E6%8E%A5%E5%8F%A3
        $this->ajaxReturn($json_decode_data);
    }

    /**
     * 构建微信菜单数组
     */
    private function create_menu_field($info) {
        if (!empty($info['url'])) {
            $data = array(
                'type' => "view",
                'name' => urlencode($info['name']),
                'url' => $info['url']
            );
        } else {
            $data = array(
                'type' => "click",
                'name' => urlencode($info['name']),
                'key' => $info['menu_key']
            );
        }
        return $data;
    }

    /**
     * 
     * @param String $url 链接地址
     * @param String $data_string 需要提交到远程的JSON字符串
     * @return array list($return_code, $return_content) 返回码，返回内容
     */
    private function https_post_data($url, $data_string = '', $timeout = 10) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }

}

?>
