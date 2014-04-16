<?php

/**
 * 基础配置-微信用户管理
 *
 * @author 蓝枫叶<zibin_5257@163.com>
 * @CreateTime 2014-4-16 13:23:35
 */
class WeixinUserAction extends CommonAction{
    public function index(){
        switch ($_GET['sort']) {
            case 'active':
                parent::index('',"last_time desc");
                break;
            case 'create7days':
                parent::index('and DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=FROM_UNIXTIME(create_time,"%Y-%m-%d")',"last_time desc");
                break;
            case 'active7days':
                parent::index('and DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=FROM_UNIXTIME(last_time,"%Y-%m-%d")',"last_time desc");
                break;
            case 'create_time':
                parent::index('',"create_time desc");
                break;
            default:
                parent::index('',"create_time desc");
                break;
        }
    }
}
