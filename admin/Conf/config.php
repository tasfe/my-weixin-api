<?php
$base_config=  require("../Conf/config.php");
$config=array(
    'admin_secret_key'=>'lWsoP7hNlPApcqXGItvHax0OiOC6IqIW',  //后台管理员cookies加密密钥,建议16位以上
    'AUTH_CONFIG'=>array(  //后台权限系统配置
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'lfy_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'lfy_auth_group_access', //用户组明细表
        'AUTH_RULE' => 'lfy_auth_rule', //权限规则表
        'AUTH_USER' => 'lfy_admin',//用户信息表,
        'SuperAdmin'=>'admin'  //超级管理员
    ),
     'URL_ROUTER_ON' => false
);
return array_merge($base_config,$config);
?>