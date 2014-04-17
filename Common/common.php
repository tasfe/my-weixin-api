<?php

/**
 * 由数据库取出系统的配置
 *
 * @access  public
 * @param   mix     $name
 *
 * @return  mix
 */
function MC($name) {
    $name = strtolower($name);
    if (S('cache_config')) {
        $sys_conf = S('cache_config');
    } else {
        $sys_conf = M("Config")->where("status=1")->getField("name,val");
        S("cache_config", $sys_conf, 3600);
    }
    return $sys_conf[$name];
}


function time_format($time=0){
    $return_str='';
    if($time<60){
        return $time.'秒';
    }
    if(floor($time/86400)>0){
        $return_str=floor($time/86400).'天';
        $time-=floor($time/86400)*86400;
    }
    if(floor($time/3600)>0){
        $return_str.=floor($time/3600).'小时';
        $time-=floor($time/3600)*3600;
    }
    if(floor($time/60)>0){
        $return_str.=floor($time/60).'分';
        $time-=floor($time/60)*60;
    }
    if($time<=60){
        $return_str.=$time.'秒';
    }
    return $return_str;
}

/**
 * 获取秒杀商品剩余数量
 * @param integer $id 秒杀活动ID
 * 
 * @return integer 秒杀商品剩余数量
 */
function get_seckill_surplus($id) {
    if (S('seckill_surplus_' . $id)) {
        $surplus_num=S('seckill_surplus_' . $id);
    } else {
        $SeckillGoods = M('SeckillGoods');
        $SeckillRecord = M('SeckillRecord');
        $sum_count = $SeckillGoods->where("id={$id}")->getField('goods_num');
        $sell_num = $SeckillRecord->where("seckill_id={$id}")->count("id");
        $surplus_num = $sum_count - $sell_num;
        S('seckill_surplus_' . $id,$surplus_num,0);
    }
    return $surplus_num;

    
}

function get_choujiang_type_name($str) {
    switch ($str) {
        case 'guaguaka':
            return '刮刮卡';
            break;
        case 'zajindan':
            return '砸金蛋';
            break;
        case 'dazhuanpan':
            return '大转盘';
            break;
        default:
            return '无';
            break;
    }
}

/**
 * 根据奖项ID获取奖项名称
 */
function get_award_name($award_id = 0) {
    if (empty($award_id)) {
        return '无兑奖码';
    }

    $award_id = intval($award_id);
    $award_name = M('ChoujiangAward')->where("id={$award_id}")->find();
    if (empty($award_name)) {
        return '奖项信息不存在';
    }

    return $award_name['name'];
}

/**
 * 获取兑换截止日期
 */
function get_award_stop_time($choujiang_id=0){
    $award_stop_time = M('Choujiang')->where("id={$choujiang_id}")->getField('award_stop_time');
    if($award_stop_time==0){
        return '无限期';
    }else{
        return get_date_full($award_stop_time);
    }
}

/**
 * 获取配置信息缓存版本
 * @param String $cache_name 缓存版本名称
 * @return string 缓存版本字符串
 */
function get_cache_version($cache_name = 'cache_config_version') {
    $cache_name = strtolower($cache_name);
    if (S($cache_name)) {
        return S($cache_name);
    } else {
        $version = M('CacheVersion')->where("name='{$cache_name}'")->getField('version');
        $version = empty($version) ? '1' : $version;
        S($cache_name, $version, 0);
    }
}

/**
 * 传递秒数 获取Y-m-d H:i:s格式的时间
 * @author zibin.dou <zibin_5257@163.com>
 * @var Int $time 距离1970的秒数
 */
function get_date_full($time) {
    $time = empty($time) ? time() : $time;
    return date('Y-m-d H:i:s', $time);
}

/**
 * 传递秒数 获取Y-m-d格式的时间
 * @author zibin.dou <zibin_5257@163.com>
 * @var Int $time 距离1970的秒数
 */
function get_date($time) {
    $time = empty($time) ? time() : $time;
    return date('Y-m-d', $time);
}

/**
 * 传递秒数 获取Y-m格式的月份
 * @author zibin.dou <zibin_5257@163.com>
 * @var Int $time 距离1970的秒数
 */
function get_year_month($time) {
    $time = empty($time) ? time() : $time;
    return date('Y-m', $time);
}

// 循环创建目录
function mk_dir($dir, $mode = 0777) {
    if (is_dir($dir) || @mkdir($dir, $mode))
        return true;
    if (!mk_dir(dirname($dir), $mode))
        return false;
    return @mkdir($dir, $mode);
}

?>
