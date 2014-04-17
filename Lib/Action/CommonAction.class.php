<?php

class CommonAction extends Action {

    //控制器初始化
    function _initialize() {
//        if (strpos($_SERVER["HTTP_USER_AGENT"], "MicroMessenger") === false && strpos($_SERVER["HTTP_USER_AGENT"], "IEMobile") === false) {
//            header("Content-Type: text/html; charset=UTF-8");
//            exit('请使用微信打开该页面');
//        }
    }

    function subscribe_count() {
        
    }

    /**
     * 信息展示
     */
    public function view() {
        $id = intval($_GET['id']);
        $M = M(MODULE_NAME);
        $info = $M->where(array("id" => $id, "status" => 1))->find();
        if (empty($info)) {
            unset($M);
            header("Content-Type: text/html; charset=UTF-8");
            exit('您要访问的信息不存在！请点击左上角[返回]按钮');
        } else {
            $M->where("id={$id}")->setInc('num');
            unset($M);
            $this->info = $info;
            $this->display();
        }
    }

    /**
     * 判断微信号是否关注并插入关注记录
     * @param String $weixin_name
     * @param int $type 类型，1-插入关注记录 0-只返回结果
     */
    public function insert_subscribe_user($weixin_name, $type = 1) {
        $M = M('WeixinUser');
        $weixin_name = MAGIC_QUOTES_GPC ? $weixin_name : addslashes($weixin_name);
        if ($M->where("weixin_name='$weixin_name'")->count("id") == 0) {
            if ($type) {
                $data = array(
                    'weixin_name' => $weixin_name,
                    'create_time' => time(),
                    'create_date' => get_date(),
                    'last_time'=>time()
                );
                $M->add($data);
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * 设置并获取微信用户的ID
     */
    public function weixin_id($url = '') {
        $weixin_id = MAGIC_QUOTES_GPC ? $_GET['from_weixin_user'] : addslashes($_GET['from_weixin_user']);
        if ($weixin_id=='') {
            $weixin_id = cookie('weixin_id');
            if ($weixin_id=='') {
                $weixin_id = md5($_SERVER['REMOTE_ADDR'] . time());
            }
            cookie('weixin_id', $weixin_id, 31536000);
            return $weixin_id;
        } else {
            cookie('weixin_id', $weixin_id, 31536000);
            redirect($url);
            exit;
        }
    }

}

?>
