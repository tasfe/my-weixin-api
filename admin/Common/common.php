<?php

require '../Common/common.php';

/**
 * 根据用户UID获取用户所在权限组
 * @param type $uid
 * @return type
 */
function get_user_group($uid) {
    import('ORG.Util.Auth'); //加载类库
    $auth = new Auth();
    $group_name=$auth->getGroups($uid);
    unset($auth);
    return $group_name;
}

/**
 * 根据weixin_id或者用户ID获取来源和用户名
 * @param string $str weixin_id字符串或后台用户ID
 * @return string "渠道&用户名/用户姓名"
 */
function get_channel_user($str){
    if(is_numeric($str)){
        $user_name=M('User')->where("id={$str}")->getField('title');
        $user_name=  empty($user_name)?未知:$user_name;
        $return_str.='PC&'.$user_name;
    }  else {
        $user_name=M('MobileBindList')->where("weixin_id='{$str}'")->getField('name');
        $user_name=  empty($user_name)?未知:$user_name;
        $return_str.='微信&'.$user_name;
    }
    return $return_str;
}

/**
 * 权限检查
 * @param String $auth_name 规则名称
 * @param Integer $uid 用户ID
 */
function check_auth($auth_name, $uid = '') {
    $uid=  empty($uid)?session('user_id'):$uid;
    import('ORG.Util.Auth'); //加载类库
    $auth = new Auth();
    return $auth->check($auth_name, $uid);
}

/**
 * 判断是否正确登录了系统
 * @return boolean
 */
function check_login() {
    $decode_str = aes_decode(cookie('weixin_admin'), md5(C('admin_secret_key').$_SERVER['HTTP_USER_AGENT']));
    if (!empty($decode_str)) {
        $user_data = json_decode($decode_str, true);
        if (!empty($user_data['admin']) && !empty($user_data['user_id'])) {
            session('admin', $user_data['admin']);
            session('user_id', $user_data['user_id']);
            return true;
        }
    } else {
        return false;
    }
}

function aes_encode($data,$key) {
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $encrypted = mcrypt_generic($td, $data);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $return=base64_encode($iv.$encrypted);
    return $return;
}

function aes_decode($data,$key) {
    $data=  base64_decode($data);
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
    $iv = mb_substr($data, 0, 32, 'latin1');
    mcrypt_generic_init($td, $key, $iv);
    $data = mb_substr($data, 32, mb_strlen($data, 'latin1'), 'latin1');
    $data = mdecrypt_generic($td, $data);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return trim($data);
}

/**
 * 获取抽奖活动打开人数 参与人数
 * @param integer $choujiang_id 抽奖活动ID
 */
function get_choujiang_user_num($choujiang_id = 0) {
    if (empty($choujiang_id))
        return 0;
    $num = M("ChoujiangAccess")->field("distinct weixin_id")->where("choujiang_id={$choujiang_id}")->select();
    return count($num);
}

/**
 * 获取秒杀活动已秒杀数量
 * @param integer $seckill_id 秒杀活动ID
 * @return integer 已秒杀数量
 */
function get_seckill_num($seckill_id) {
    return M('SeckillRecord')->where("seckill_id={$seckill_id}")->count();
}

/**
 * 获取秒杀活动页面浏览次数
 */
function get_seckill_pv($seckill_id) {
    return M('SeckillAccess')->where("seckill_id={$seckill_id}")->count();
}

/**
 * 获取秒杀活动状态
 * @param type $seckill_id 秒杀活动ID
 * @return string 状态文字
 */
function get_seckill_status($seckill_id) {
    $M = M('SeckillGoods');
    $info = $M->where("id={$seckill_id}")->find();
    if ($info['stop_time'] < time()) {
        return '已结束';
    }
    if ($info['begin_time'] > time()) {
        return '未开始';
    }
    if ($info['begin_time'] <= time() && $info['stop_time'] > time()) {
        return '<font color="red">进行中</font>';
    }
}

/**
 * 统计特定日期关注和卸载用户数量
 * @param String $date 统计的日期
 * @param String $type 'subscribe'=新关注 默认，'unsubscribe'=取消关注
 * @return integer 数量
 */
function subscribe_count($date = '', $type = 'subscribe') {
    $date = empty($date) ? get_date() : $date;
    if ($type == 'subscribe') {
        if (S('subscribe_count_' . $date)) {
            $count = S('subscribe_count_' . $date);
        } else {
            $count = M('Weixin_user')->where("create_date='{$date}'")->count('id');
            S('subscribe_count_' . $date, $count, 300);
        }
    } else {
        if (S('unsubscribe_count_' . $date)) {
            $count = S('unsubscribe_count_' . $date);
        } else {
            $count = M('Unsubscrib')->where("create_date='{$date}'")->count('id');
            S('unsubscribe_count_' . $date, $count, 300);
        }
    }
    return $count;
}

/**
 * 获取微信服务器授权密钥
 * @return string 微信access_token字符串
 */
function get_weixin_access_token() {
    if (S('weixin_access_token')) {
        $access_token = S('weixin_access_token');
    } else {
        $return = https_request('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . MC('weixin_appid') . '&secret=' . MC('weixin_appsecret'));
        $data = json_decode($return, true);
        if (!is_null($data['errcode'])) {
//            return '授权密钥获取错误：' . $data['errcode'] . ',' . $data['errmsg'];
            return '123456';
        } else {
            S('weixin_access_token', $data['access_token'], $data['expires_in'] - 1000);
            $access_token = $data['access_token'];
        }
    }
    return $access_token;
}

/**
 * HTTPS GET请求
 * @param string $url 请求链接
 * @param type $timeout 请求超时时间，单位秒
 * @return json json字符串
 */
function https_request($url = '', $timeout = 10) {
    if (!function_exists('curl_init')) {
        exit('check server not curl');
    }
//    $url = $this->api_url . $url . '?access_token=' . MC('weixin_access_token');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    if ($data == false) {
        curl_close($ch);
        return json_encode(array('errcode' => 99, 'errmsg' => '远程接口请求错误'));
    }
    @curl_close($ch);
    return $data;
}

/**
 * 获取子菜单数量
 * @param type $menu_id 菜单ID
 */
function get_submenu_count($menu_id) {
    return M('WeixinMenu')->where("main=$menu_id")->count("id");
}

/**
 * 获取自定义菜单名称
 * @param type $menu_id 菜单ID
 */
function get_menu_name($menu_id) {
    return M('WeixinMenu')->where("id={$menu_id}")->getField('name');
}

function br2nl($string, $line_break = PHP_EOL) {
    $patterns = array(
        "/(<br>|<br \/>|<br\/>)\s*/i",
        "/(\r\n|\r|\n)/"
    );
    $replacements = array(
        PHP_EOL,
        $line_break
    );
    $string = preg_replace($patterns, $replacements, $string);
    return $string;
}

/**
 * 获取奖品剩余数量
 * @param integer $award_id 奖品ID
 */
function get_award_shengyu($award_id = 0) {
    if (empty($award_id))
        return 0;
//    $award_num=M("ChoujiangAward")->where("id={$award_id}")->getField('num');
    $ready_num = M("ChoujiangRecord")->where("award_id={$award_id}")->count("id");
    return $ready_num;
}

/**
 * 获取奖品剩余数量
 * @param integer $award_id 奖品ID
 */
function get_award_duihuan($award_id = 0) {
    if (empty($award_id))
        return 0;
//    $award_num=M("ChoujiangAward")->where("id={$award_id}")->getField('num');
    $ready_num = M("ChoujiangRecord")->where("award_id={$award_id} and status=1")->count("id");
    return $ready_num;
}

/**
 * 获得状态图片
 * @param integer $data 状态值
 */
function get_status_img($data) {
    if ($data == 1) {
        return '<img src="__PUBLIC__/images/status-1.gif" border="0">';
    } else {
        return '<img src="__PUBLIC__/images/status-0.gif" border="0">';
    }
}

/**
 * 获得消息回复类型的显示文字
 * @param integer $type 类型值
 */
function get_reply_text($type) {
    switch ($type) {
        case 1:
            return '单条文本';
            break;
        case 2:
            return '单条图文';
            break;
        case 3:
            return '图文列表';
            break;
        default:
            return '单条文本';
            break;
    }
}

/**
 * 获得上级节点
 */
function get_main_str($data,$type="Zhiling") {
    if ($data == 0) {
        return '父级';
    } else {
        $M=M($type);
        $name=$M->where("id={$data}")->getField('title');
        return $name;
    }
}


/**
 * 
 * @param String $url 链接地址
 * @param String $data_string 需要提交到远程的JSON字符串
 *         注意：提交到腾讯的数据需要
 * $weixin_access_token = get_weixin_access_token();
 * $json_data=urldecode(json_encode(array("button" => $menu_data)));
 * https_post_data($this->api_url . 'create?access_token=' . $weixin_access_token, $json_data);
 * $json_decode_data = json_decode($return_code[1], true);
  //成功返回{"errcode":0,"errmsg":"ok"}
  //失败返回{"errcode":40018,"errmsg":"invalid button name size"}
  //具体错误码详见腾讯微信公众平台官方文档http://mp.weixin.qq.com/wiki/index.php?title=%E8%87%AA%E5%AE%9A%E4%B9%89%E8%8F%9C%E5%8D%95%E6%8E%A5%E5%8F%A3
 * @return array list($return_code, $return_content) 返回码，返回内容
 */
function https_post_data($url, $data_string = '', $timeout = 10) {
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

?>
