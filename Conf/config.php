<?php

return array(
    'URL_MODEL' => 1, //url访问模式
    //'URL_HTML_SUFFIX' => '.html', // URL伪静态后缀设置
    'URL_PATHINFO_DEPR' => '/', // PATHINFO模式下，各参数之间的分割符号
    'URL_CASE_INSENSITIVE' => true, // URL地址是否不区分大小写
    
    /* 数据库设置 */
    'DB_TYPE' => 'mysql', // 数据库类型
    //'DB_HOST' => '10.70.99.34', // 服务器地址
    'DB_HOST' => '192.168.0.88', // 服务器地址
    'DB_NAME' => 'weixin_api',
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'lanfengye',
    'DB_PORT' => 3308, // 端口
    'DB_PREFIX' => 'lfy_', // 数据库表前缀
    'DB_SUFFIX' => '', // 数据库表后缀
    
    'root_path'=>'/weixin',  //所在目录，如果为根目录则填写''
    
    /* URL路由规则 */
    'URL_ROUTER_ON' => true,
    'URL_ROUTE_RULES' => array(
        //抽奖活动访问规则
        '/^choujiang-(\d+)$/' => 'Choujiang/index?id=:1',
        //输入流水号访问规则 需要和活动ID配合使用
        '/^liushuihao-(\d+)$/' => 'Choujiang/liushuihao?id=:1',
        //中奖记录访问规则
        '/^my_prize$/' => 'Choujiang/my_prize',
        //指令内容展示页面
        '/^zhiling-(\d+)$/'=>'Zhiling/view?id=:1',
        //秒杀活动详细页面
        '/^seckill-(\d+)$/'=>'Seckill/view?id=:1',
        //优惠券访问规则
        '/^coupon-(\d+)$/'=>'Coupon/index?id=:1',
        //会员卡填写资料领取规则
        '/^member_card-add_user$/'=>'MemberCard/add_user'
    ),
);
?>