/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : weixin_api

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2014-05-09 15:59:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lfy_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `lfy_auth_group`;
CREATE TABLE `lfy_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` varchar(5000) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='权限用户组表';

-- ----------------------------
-- Records of lfy_auth_group
-- ----------------------------
INSERT INTO `lfy_auth_group` VALUES ('1', '默认用户组', '1', '11,12,13,14,15,16,17,21,22,23,20,19,18,87,88,89,90,91,92,24,25,26,27,28,29,30,31,32,82,84,86,85,83,67,68,69,70,71,72,81,73,78,76,75,74,77,60,65,66,61,64,63,62,2,1,49,52,53,54,55,56,58,59,57,50,51,42,43,44,45,46,47,48,33,79,80,34,35,36,37,38,41,40,39', '默认全部权限');
INSERT INTO `lfy_auth_group` VALUES ('2', '兑奖管理', '1', '2,1,3', '');

-- ----------------------------
-- Table structure for lfy_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `lfy_auth_group_access`;
CREATE TABLE `lfy_auth_group_access` (
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限用户组-用户明细表';

-- ----------------------------
-- Records of lfy_auth_group_access
-- ----------------------------
INSERT INTO `lfy_auth_group_access` VALUES ('1', '1');
INSERT INTO `lfy_auth_group_access` VALUES ('10', '2');

-- ----------------------------
-- Table structure for lfy_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `lfy_auth_rule`;
CREATE TABLE `lfy_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT ' 状态 0-禁用 1-正常',
  `condition` varchar(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `main` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单 0-为一级主菜单',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '菜单排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`main`,`sort`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COMMENT='权限规则表';

-- ----------------------------
-- Records of lfy_auth_rule
-- ----------------------------
INSERT INTO `lfy_auth_rule` VALUES ('1', 'Main/index_census', '首页统计', '1', '', '2', '100');
INSERT INTO `lfy_auth_rule` VALUES ('2', 'Main', '首页', '1', '', '0', '100');
INSERT INTO `lfy_auth_rule` VALUES ('11', 'Config', '基础配置', '1', '', '0', '1');
INSERT INTO `lfy_auth_rule` VALUES ('12', 'Config/sys_con', '系统配置', '1', '', '11', '100');
INSERT INTO `lfy_auth_rule` VALUES ('13', 'Config/Subscribe', '新订阅管理', '1', '', '11', '100');
INSERT INTO `lfy_auth_rule` VALUES ('14', 'Config/Subscribe/add', '新增', '1', '', '13', '100');
INSERT INTO `lfy_auth_rule` VALUES ('15', 'Config/Subscribe/edit', '编辑', '1', '', '13', '100');
INSERT INTO `lfy_auth_rule` VALUES ('16', 'Config/Subscribe/delete', '删除', '1', '', '13', '100');
INSERT INTO `lfy_auth_rule` VALUES ('17', 'Config/WeixinMenu', '微信菜单管理', '1', '', '11', '100');
INSERT INTO `lfy_auth_rule` VALUES ('18', 'Config/WeixinMenu/add', '新增菜单', '1', '', '17', '100');
INSERT INTO `lfy_auth_rule` VALUES ('19', 'Config/WeixinMenu/edit', '编辑菜单', '1', '', '17', '100');
INSERT INTO `lfy_auth_rule` VALUES ('20', 'Config/WeixinMenu/delete', '删除菜单', '1', '', '17', '100');
INSERT INTO `lfy_auth_rule` VALUES ('21', 'Config/WeixinMenu/upload_server', '上传到服务器', '1', '', '17', '100');
INSERT INTO `lfy_auth_rule` VALUES ('22', 'Config/WeixinMenu/delete_server', '删除服务器菜单', '1', '', '17', '100');
INSERT INTO `lfy_auth_rule` VALUES ('23', 'Config/WeixinMenu/submenu', '子菜单管理', '1', '', '17', '100');
INSERT INTO `lfy_auth_rule` VALUES ('24', 'Reply', '回复管理', '1', '', '0', '3');
INSERT INTO `lfy_auth_rule` VALUES ('25', 'Reply/Zhiling', '文本指令管理', '1', '', '24', '100');
INSERT INTO `lfy_auth_rule` VALUES ('26', 'Reply/Zhiling/add', '新增', '1', '', '25', '100');
INSERT INTO `lfy_auth_rule` VALUES ('27', 'Reply/Zhiling/edit', '编辑', '1', '', '25', '100');
INSERT INTO `lfy_auth_rule` VALUES ('28', 'Reply/Zhiling/delete', '删除', '1', '', '25', '100');
INSERT INTO `lfy_auth_rule` VALUES ('29', 'Reply/ReplyDatabase', '智能回复管理', '1', '', '24', '100');
INSERT INTO `lfy_auth_rule` VALUES ('30', 'Reply/ReplyDatabase/add', '新增', '1', '', '29', '100');
INSERT INTO `lfy_auth_rule` VALUES ('31', 'Reply/ReplyDatabase/edit', '编辑', '1', '', '29', '100');
INSERT INTO `lfy_auth_rule` VALUES ('32', 'Reply/ReplyDatabase/delete', '删除', '1', '', '29', '100');
INSERT INTO `lfy_auth_rule` VALUES ('33', 'Activities', '活动管理', '1', '', '0', '100');
INSERT INTO `lfy_auth_rule` VALUES ('34', 'Activities/Choujiang', '活动管理', '1', '', '33', '100');
INSERT INTO `lfy_auth_rule` VALUES ('35', 'Activities/Choujiang/add', '新增', '1', '', '34', '100');
INSERT INTO `lfy_auth_rule` VALUES ('36', 'Activities/Choujiang/edit', '编辑', '1', '', '34', '100');
INSERT INTO `lfy_auth_rule` VALUES ('37', 'Activities/Choujiang/delete', '删除', '1', '', '34', '100');
INSERT INTO `lfy_auth_rule` VALUES ('38', 'Activities/Choujiang/award', '奖品管理', '1', '', '33', '100');
INSERT INTO `lfy_auth_rule` VALUES ('39', 'Activities/Choujiang/award/add', '新增', '1', '', '38', '100');
INSERT INTO `lfy_auth_rule` VALUES ('40', 'Activities/Choujiang/award/edit', '编辑', '1', '', '38', '100');
INSERT INTO `lfy_auth_rule` VALUES ('41', 'Activities/Choujiang/award/delete', '删除', '1', '', '38', '100');
INSERT INTO `lfy_auth_rule` VALUES ('42', 'Seckill', '微信秒杀管理', '1', '', '0', '100');
INSERT INTO `lfy_auth_rule` VALUES ('43', 'Seckill/SeckillGoods', '秒杀商品管理', '1', '', '42', '100');
INSERT INTO `lfy_auth_rule` VALUES ('44', 'Seckill/SeckillGoods/add', '新增', '1', '', '43', '100');
INSERT INTO `lfy_auth_rule` VALUES ('45', 'Seckill/SeckillGoods/edit', '编辑', '1', '', '43', '100');
INSERT INTO `lfy_auth_rule` VALUES ('46', 'Seckill/SeckillGoods/delete', '删除', '1', '', '43', '100');
INSERT INTO `lfy_auth_rule` VALUES ('47', 'Seckill/duihuan', '兑换记录', '1', '', '42', '100');
INSERT INTO `lfy_auth_rule` VALUES ('48', 'Seckill/SeckillDuihuan', '秒杀兑换', '1', '', '42', '100');
INSERT INTO `lfy_auth_rule` VALUES ('49', 'Member', '会员管理', '1', '', '0', '100');
INSERT INTO `lfy_auth_rule` VALUES ('50', 'Member/config', '基础配置', '1', '', '49', '100');
INSERT INTO `lfy_auth_rule` VALUES ('51', 'Member/config/edit', '编辑', '1', '', '50', '100');
INSERT INTO `lfy_auth_rule` VALUES ('52', 'Member/MemberSales', '会员优惠', '1', '', '49', '100');
INSERT INTO `lfy_auth_rule` VALUES ('53', 'Member/MemberSales/add', '新增', '1', '', '52', '100');
INSERT INTO `lfy_auth_rule` VALUES ('54', 'Member/MemberSales/edit', '编辑', '1', '', '52', '100');
INSERT INTO `lfy_auth_rule` VALUES ('55', 'Member/MemberSales/delete', ' 删除', '1', '', '52', '100');
INSERT INTO `lfy_auth_rule` VALUES ('56', 'Member/MemberCard', '会员名单', '1', '', '49', '100');
INSERT INTO `lfy_auth_rule` VALUES ('57', 'Member/identity', '会员验证', '1', '', '49', '100');
INSERT INTO `lfy_auth_rule` VALUES ('58', 'Member/MemberCard/edit', '编辑', '1', '', '56', '100');
INSERT INTO `lfy_auth_rule` VALUES ('59', 'Member/MemberCard/delete', '删除', '1', '', '56', '100');
INSERT INTO `lfy_auth_rule` VALUES ('60', 'Coupon', '优惠券管理', '1', '', '0', '100');
INSERT INTO `lfy_auth_rule` VALUES ('61', 'Coupon/Index', '优惠券活动', '1', '', '60', '100');
INSERT INTO `lfy_auth_rule` VALUES ('62', 'Coupon/Index/add', '新增', '1', '', '61', '100');
INSERT INTO `lfy_auth_rule` VALUES ('63', 'Coupon/Index/edit', '编辑', '1', '', '61', '100');
INSERT INTO `lfy_auth_rule` VALUES ('64', 'Coupon/Index/delete', '删除', '1', '', '61', '100');
INSERT INTO `lfy_auth_rule` VALUES ('65', 'Coupon/CouponDuihuan', '兑换记录', '1', '', '60', '100');
INSERT INTO `lfy_auth_rule` VALUES ('66', 'Coupon/CouponDuihuan/duihuan', '优惠券兑换', '1', '', '60', '100');
INSERT INTO `lfy_auth_rule` VALUES ('67', 'User', '用户管理', '1', '', '0', '100');
INSERT INTO `lfy_auth_rule` VALUES ('68', 'User/Index', '用户管理', '1', '', '67', '100');
INSERT INTO `lfy_auth_rule` VALUES ('69', 'User/Index/add', '新增', '1', '', '68', '100');
INSERT INTO `lfy_auth_rule` VALUES ('70', 'User/Index/edit', '编辑', '1', '', '68', '100');
INSERT INTO `lfy_auth_rule` VALUES ('71', 'User/Index/delete', '删除', '1', '', '68', '100');
INSERT INTO `lfy_auth_rule` VALUES ('72', 'User/Index/edit_user_group', '授权', '1', '', '68', '100');
INSERT INTO `lfy_auth_rule` VALUES ('73', 'User/Group', '权限组管理', '1', '', '67', '100');
INSERT INTO `lfy_auth_rule` VALUES ('74', 'User/Group/add', '新增', '1', '', '73', '100');
INSERT INTO `lfy_auth_rule` VALUES ('75', 'User/Group/edit', '编辑', '1', '', '73', '100');
INSERT INTO `lfy_auth_rule` VALUES ('76', 'User/Group/delete', '删除', '1', '', '73', '100');
INSERT INTO `lfy_auth_rule` VALUES ('77', 'User/Group/authorize_manage', '授权管理', '1', '', '73', '100');
INSERT INTO `lfy_auth_rule` VALUES ('78', 'User/Group/user_manage', '成员管理', '1', '', '73', '100');
INSERT INTO `lfy_auth_rule` VALUES ('79', 'Activities/Choujiang/award/duihuan', '奖品兑换', '1', '', '33', '100');
INSERT INTO `lfy_auth_rule` VALUES ('80', 'Activities/Choujiang/award/duihuanjilu', '奖品兑换记录', '1', '', '79', '100');
INSERT INTO `lfy_auth_rule` VALUES ('81', 'User/change_password', '修改密码', '1', '', '67', '100');
INSERT INTO `lfy_auth_rule` VALUES ('82', 'Mobile', '手机微信控制', '1', '', '0', '3');
INSERT INTO `lfy_auth_rule` VALUES ('83', 'Mobile/mobile_con', '基础配置', '1', '', '82', '100');
INSERT INTO `lfy_auth_rule` VALUES ('84', 'Mobile/mobile_bind', '绑定管理', '1', '', '82', '100');
INSERT INTO `lfy_auth_rule` VALUES ('85', 'Mobile/mobile_bind/delete', '删除', '1', '', '84', '100');
INSERT INTO `lfy_auth_rule` VALUES ('86', 'Mobile/mobile_bind/edit', '编辑', '1', '', '84', '100');
INSERT INTO `lfy_auth_rule` VALUES ('87', 'Config/WeixinUser', '微信用户管理', '1', '', '11', '101');
INSERT INTO `lfy_auth_rule` VALUES ('88', 'Config/WeixinUser/edit', '编辑', '1', '', '87', '100');
INSERT INTO `lfy_auth_rule` VALUES ('89', 'Message', '消息管理', '1', '', '0', '2');
INSERT INTO `lfy_auth_rule` VALUES ('90', 'Message/index', '用户消息管理', '1', '', '89', '100');
INSERT INTO `lfy_auth_rule` VALUES ('91', 'Message/index/view', '用户消息查看', '1', '', '90', '100');
INSERT INTO `lfy_auth_rule` VALUES ('92', 'Message/index/delete_all', '用户消息全部删除', '1', '', '90', '100');

-- ----------------------------
-- Table structure for lfy_cache_version
-- ----------------------------
DROP TABLE IF EXISTS `lfy_cache_version`;
CREATE TABLE `lfy_cache_version` (
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '控制缓存更新名称',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '随机版本字符串',
  PRIMARY KEY (`name`),
  KEY `main` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lfy_cache_version
-- ----------------------------
INSERT INTO `lfy_cache_version` VALUES ('cache_config_version', 'Fgdf');

-- ----------------------------
-- Table structure for lfy_choujiang
-- ----------------------------
DROP TABLE IF EXISTS `lfy_choujiang`;
CREATE TABLE `lfy_choujiang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '抽奖活动ID',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '抽奖活动名称',
  `explain` text COMMENT '活动说明',
  `prize` text COMMENT '抽奖奖项及中奖率说明',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `stop_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `type` varchar(20) NOT NULL DEFAULT '0' COMMENT '抽奖活动类型，guaguaka 刮刮卡/zajindan 砸金蛋',
  `user_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '每天每微信号参加次数限制，0 不限制',
  `user_sum_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户最多参加次数，0 不限制，其他数值为用户总计参加次数',
  `is_subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否判断已经关注，0-不判断 1-判断',
  `award_stop_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '奖品兑换截止时间 0-不限制',
  `award_code_length` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '兑奖码位数',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`begin_time`,`stop_time`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='抽奖活动设置表';

-- ----------------------------
-- Records of lfy_choujiang
-- ----------------------------
INSERT INTO `lfy_choujiang` VALUES ('2', '购物微信刮刮卡 刮送IPHONE 5及现金券', '<b>兑奖说明：</b><br />\r\n1.中奖微友需凭16位代码中奖信息及发送流水号码的购物小票领取礼品，每个代码限兑换一次奖品。<br />\r\n2.16位代码已删除、购物小票丢失或与发放信息中流水号码不一致均不予兑奖。<br />\r\n3.<font color=\"red\">兑奖日期：7月26日——8月4日，过期不予兑奖。</font><br />\r\n<br />\r\n<b>兑奖地点：0101流行馆中街店6楼会员中心</b><br />\r\n<br />\r\n本次活动最终解释权归本公司所有', '特等奖 IPHONE 5手机<br />\r\n一等奖 3000元现金券<br />\r\n二等奖 1000元现金券<br />\r\n三等奖 200元现金券<br />\r\n四等奖 100元现金券<br />\r\n五等奖 50元现金券', '0', '0', 'guaguaka', '0', '0', '0', '0', '10');
INSERT INTO `lfy_choujiang` VALUES ('3', '大转盘活动', '<b>兑奖地点：0101流行馆中街店6楼会员中心</b><br />\r\n本次活动最终解释权归本公司所有', '特等奖 三星S4手机<br />\r\n一等奖 数码相机<br />\r\n二等奖 小音箱<br />\r\n三等奖 音乐枕<br />\r\n四等奖 电影票<br />\r\n五等奖 笑脸餐具', '0', '0', 'guaguaka', '0', '0', '0', '1375351200', '16');

-- ----------------------------
-- Table structure for lfy_choujiang_access
-- ----------------------------
DROP TABLE IF EXISTS `lfy_choujiang_access`;
CREATE TABLE `lfy_choujiang_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '访问id',
  `weixin_id` varchar(50) NOT NULL DEFAULT '' COMMENT '微信用户唯一识别码',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问时间',
  `create_date` date NOT NULL COMMENT '访问日期',
  `choujiang_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抽奖活动ID',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`create_time`,`choujiang_id`,`create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=3301 DEFAULT CHARSET=utf8 COMMENT='抽奖活动用户访问记录';

-- ----------------------------
-- Records of lfy_choujiang_access
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_choujiang_award
-- ----------------------------
DROP TABLE IF EXISTS `lfy_choujiang_award`;
CREATE TABLE `lfy_choujiang_award` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `choujiang_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抽奖活动ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '奖项名称',
  `explain` varchar(200) NOT NULL DEFAULT '' COMMENT '奖项说明',
  `sort` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '奖品排序',
  `num` int(10) NOT NULL DEFAULT '0' COMMENT '奖品数量',
  `chance` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '中奖概率系数',
  `make_key` tinyint(1) unsigned zerofill NOT NULL DEFAULT '1' COMMENT '是否生成兑奖号码，0 不生成，1 生成',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`choujiang_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='抽奖活动奖品及中奖概率';

-- ----------------------------
-- Records of lfy_choujiang_award
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_choujiang_duijiang
-- ----------------------------
DROP TABLE IF EXISTS `lfy_choujiang_duijiang`;
CREATE TABLE `lfy_choujiang_duijiang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weixin_id` varchar(50) NOT NULL DEFAULT '',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `create_date` date NOT NULL,
  `convert_from` varchar(100) NOT NULL DEFAULT '' COMMENT '兑奖方式，字符串为微信远程兑换，数值为后台兑换的用户ID',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='兑奖记录';

-- ----------------------------
-- Records of lfy_choujiang_duijiang
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_choujiang_liushuihao
-- ----------------------------
DROP TABLE IF EXISTS `lfy_choujiang_liushuihao`;
CREATE TABLE `lfy_choujiang_liushuihao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '流水号ID',
  `weixin_id` varchar(50) NOT NULL DEFAULT '',
  `liushuihao` varchar(100) NOT NULL DEFAULT '',
  `choujiang_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抽奖活动ID',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `create_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`choujiang_id`,`create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='抽奖流水号记录';

-- ----------------------------
-- Records of lfy_choujiang_liushuihao
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_choujiang_record
-- ----------------------------
DROP TABLE IF EXISTS `lfy_choujiang_record`;
CREATE TABLE `lfy_choujiang_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '抽奖参与ID',
  `weixin_id` varchar(50) NOT NULL DEFAULT '' COMMENT '微信用户唯一识别码',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抽奖时间',
  `create_date` date NOT NULL COMMENT '抽奖日期',
  `choujiang_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '抽奖活动ID',
  `award_code` varchar(50) NOT NULL DEFAULT '' COMMENT '中奖兑奖码',
  `award_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '中奖信息ID，用于读取具体奖项',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '兑换状态，是否已经兑换。0 未兑换，1 已经兑换',
  PRIMARY KEY (`id`),
  KEY `main` (`weixin_id`,`choujiang_id`,`award_code`,`award_id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2985 DEFAULT CHARSET=utf8 COMMENT='抽奖参与记录表';

-- ----------------------------
-- Records of lfy_choujiang_record
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_config
-- ----------------------------
DROP TABLE IF EXISTS `lfy_config`;
CREATE TABLE `lfy_config` (
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `c_name` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '中文名称',
  `remark` varchar(300) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '备注说明',
  `val` varchar(2000) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '10',
  `list_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:手动输入长框 1:单选 2:下拉 3:文本域 4:图像 5:手动输入  短框',
  `val_arr` varchar(200) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT ' 可选的值的集合，序列化存放 规则为value1:title1,value2:title2或者value1,value2',
  `group_id` tinyint(2) NOT NULL DEFAULT '1' COMMENT '组ID',
  PRIMARY KEY (`name`),
  KEY `main` (`name`,`status`,`sort`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of lfy_config
-- ----------------------------
INSERT INTO `lfy_config` VALUES ('weixin_token', '微信通信密钥', '与微信公众平台通信token密钥一致', '123456', '1', '1', '0', '', '1');
INSERT INTO `lfy_config` VALUES ('list_return_count', '图文列表返回数量', '图文列表最大返回数量，最大设置10', '10', '1', '5', '0', '', '1');
INSERT INTO `lfy_config` VALUES ('no_keys_return', '默认回复文本', '没有找到任何信息时的默认回复', '该话题没有找到，咱们换个话题吧！kkk', '1', '6', '3', '', '1');
INSERT INTO `lfy_config` VALUES ('no_subscribe_url', '未关注跳转链接', '未关注跳转链接', 'http://api.qqdaliao.com/0101/zhiling/view/id/5', '1', '4', '0', '', '1');
INSERT INTO `lfy_config` VALUES ('weixin_appid', '微信开发者appid', '订阅号无需填写', '1234561', '1', '2', '0', '', '1');
INSERT INTO `lfy_config` VALUES ('weixin_appsecret', '微信开发者appsecret', '订阅号无需填写', '89545112661', '1', '3', '0', '', '1');
INSERT INTO `lfy_config` VALUES ('mobile_bind_status', '手机微信绑定状态', '是否开启手机微信管理绑定', '1', '1', '1', '1', '1:开启,0:关闭', '2');
INSERT INTO `lfy_config` VALUES ('mobile_bind_secret', '手机微信绑定密钥', '手机微信管理绑定的安全密钥，只能为字母和数字', '1234', '1', '2', '0', '', '2');
INSERT INTO `lfy_config` VALUES ('mobile_bind_dictate', '手机绑定指令', '手机微信管理绑定指令，绑定格式为\"绑定指令 绑定密钥 姓名\"', '绑定管理', '1', '3', '0', '', '2');
INSERT INTO `lfy_config` VALUES ('bind_test_dictate', '手机管理测试指令', '手机微信管理测试指令', '测试兑换', '1', '4', '0', '', '2');
INSERT INTO `lfy_config` VALUES ('coupon_convert_dictate', '优惠券兑换指令', '手机微信管理优惠券兑换指令', '优惠券兑换', '1', '5', '0', '', '2');
INSERT INTO `lfy_config` VALUES ('choujiang_convert_dictate', '抽奖奖品兑换指令', '手机微信管理抽奖奖品兑换指令', '抽奖兑换', '1', '6', '0', '', '2');
INSERT INTO `lfy_config` VALUES ('member_verify_dictate', '会员卡验证指令', '手机微信管理会员卡信息获取指令', '会员卡', '1', '7', '0', '', '2');

-- ----------------------------
-- Table structure for lfy_coupon
-- ----------------------------
DROP TABLE IF EXISTS `lfy_coupon`;
CREATE TABLE `lfy_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '优惠券名称',
  `code_length` int(10) unsigned NOT NULL DEFAULT '6' COMMENT '优惠券兑换码长度',
  `direction` text COMMENT '使用说明',
  `activity` text COMMENT '活动说明',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动开始时间 0-不限制',
  `stop_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动结束时间 0-不限制',
  `limited` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '限制发放的数量 0-不限制',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '开始状态 0-停止 1-开始',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `award_stop_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '兑换截止日期 0-永久',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`begin_time`,`stop_time`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='优惠券基础信息表';

-- ----------------------------
-- Records of lfy_coupon
-- ----------------------------
INSERT INTO `lfy_coupon` VALUES ('1', '微信会员专享打折卡', '6', '1.使用本优惠券享受全场商品8折优惠，仅使用一次。<br /><br />\r\n2.使用本优惠券享受全场商品8折优惠，仅使用一次。', '1.使用本优惠券享受全场商品8折优惠，仅使用一次。<br /><br />\r\n2.使用本优惠券享受全场商品8折优惠，仅使用一次。', '1382407810', '1382407810', '10000', '1', '0', '1382407810', '1.使用本优惠券享受全场商品8折优惠，仅使用一次。<br /><br />\r\n2.使用本优惠券享受全场商品8折优惠，仅使用一次。');
INSERT INTO `lfy_coupon` VALUES ('2', '大乐透', '6', '大乐透大乐透大乐透大乐透<br />\r\ndsdsd<br />\r\nsdsd<br />\r\nsdsdsd', '大乐透大乐透大乐透<br />\r\nddd<br />\r\naaaaa', '1382407810', '1382407810', '0', '1', '1382690662', '1382407810', '最新活动');

-- ----------------------------
-- Table structure for lfy_coupon_duihuan
-- ----------------------------
DROP TABLE IF EXISTS `lfy_coupon_duihuan`;
CREATE TABLE `lfy_coupon_duihuan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '兑换记录ID',
  `weixin_id` varchar(100) NOT NULL DEFAULT '' COMMENT '微信用户ID',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券领取记录ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '兑换时间',
  `create_date` date DEFAULT NULL COMMENT '兑换日期',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `user_telephone` varchar(50) NOT NULL DEFAULT '' COMMENT '用户联系电话',
  `convert_from` varchar(100) NOT NULL DEFAULT '' COMMENT '兑奖方式，字符串为微信远程兑换，数值为后台兑换的用户ID',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`record_id`,`create_time`,`create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='微信优惠券兑换记录';

-- ----------------------------
-- Records of lfy_coupon_duihuan
-- ----------------------------
INSERT INTO `lfy_coupon_duihuan` VALUES ('5', '123456', '9', '1380509564', '2013-09-30', '', '', '');
INSERT INTO `lfy_coupon_duihuan` VALUES ('6', '1acf3b3c931e50ea84153f5374c868d4', '15', '1380509587', '2013-09-30', '', '', '');
INSERT INTO `lfy_coupon_duihuan` VALUES ('7', '123456', '12', '1380510859', '2013-09-30', '', '', '');
INSERT INTO `lfy_coupon_duihuan` VALUES ('8', '123456', '11', '1380510941', '2013-09-30', '窦子滨', '15940442002', '');
INSERT INTO `lfy_coupon_duihuan` VALUES ('9', '9bf27ad185dd05f8d6930f9395adc0c3', '3', '1382688940', '2013-10-25', 'damon', '13142431441', '');
INSERT INTO `lfy_coupon_duihuan` VALUES ('10', '1234567', '1', '1382690844', '2013-10-25', '帅姐', '12345678900', '');
INSERT INTO `lfy_coupon_duihuan` VALUES ('11', '123456', '4', '1382692253', '2013-10-25', '', '', '');

-- ----------------------------
-- Table structure for lfy_coupon_record
-- ----------------------------
DROP TABLE IF EXISTS `lfy_coupon_record`;
CREATE TABLE `lfy_coupon_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weixin_id` varchar(255) NOT NULL DEFAULT '' COMMENT '微信ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '领取时间',
  `create_date` date NOT NULL,
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券ID',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '优惠券兑换码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '兑换状态 0-未兑换 1-已经兑换',
  `client_ip` varchar(50) NOT NULL DEFAULT '' COMMENT '领取的ip',
  PRIMARY KEY (`id`),
  KEY `main` (`weixin_id`,`create_time`,`create_date`,`coupon_id`,`code`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='优惠券领取记录表';

-- ----------------------------
-- Records of lfy_coupon_record
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_member_card
-- ----------------------------
DROP TABLE IF EXISTS `lfy_member_card`;
CREATE TABLE `lfy_member_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weixin_id` varchar(50) NOT NULL DEFAULT '' COMMENT '微信ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_date` date NOT NULL,
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `user_telephone` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `user_sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别 0-男 1-女',
  `user_birthday` varchar(20) NOT NULL DEFAULT '' COMMENT '出生日期',
  `card_no` varchar(20) NOT NULL DEFAULT '' COMMENT '微信会员卡号',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`create_date`,`user_name`,`user_telephone`,`user_birthday`,`card_no`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='微信会员卡用户信息表';

-- ----------------------------
-- Records of lfy_member_card
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_member_sales
-- ----------------------------
DROP TABLE IF EXISTS `lfy_member_sales`;
CREATE TABLE `lfy_member_sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间戳',
  `contents` text COMMENT '文章内容',
  `sort` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示状态 0-隐藏 1-显示',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-默认促销信息 1-下部固定信息 促销信息管理不含type=1管理',
  `num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`create_time`,`sort`,`status`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员卡文章信息';

-- ----------------------------
-- Records of lfy_member_sales
-- ----------------------------
INSERT INTO `lfy_member_sales` VALUES ('1', '会员优先预约', '0', '<p style=\"text-indent:2em;\">会员卡到店消费独享9折优惠会员卡泛指普通身份识别卡，包括商场、宾馆、健身中心、酒家等消费场所的会员认证。它们的用途非常广泛，凡涉及到需要识别身份的地方，都可应用到身份识别卡，如学校、俱乐部、公司、机关、团体等。</p><p style=\"text-indent:2em;\">会员制服务也是现在流行的一种服务管理模式，它可以提高顾客的回头率，提高顾客对企业忠诚度。很多的服务行业都采取这样的服务模式，会员制的形式多数都表现为会员卡。一个公司发行的会员卡相当于公司的名片，在会员卡上可以印刷公司的标志或者图案，为公司形象作宣传，是公司进行广告宣传的理想载体。同时发行会员卡还能起到吸引新顾客，留住老顾客，增强顾客忠诚度的作用，还能实现打折、积分、客户管理等功能，是一种确实可行的增加效益的途径。</p>', '1', '1', '0', '14');
INSERT INTO `lfy_member_sales` VALUES ('2', '会员卡说明', '0', '<p>会员卡泛指普通身份识别卡，包括商场、宾馆、健身中心、酒家等消费场所的会员认证，它们的用途非常广泛，凡涉及到需要识别身份的地方，都可应用到身份识别卡。</p>', '1', '1', '1', '10');
INSERT INTO `lfy_member_sales` VALUES ('3', ' 联系方式及地址', '0', '<p>【地址】:沈阳市和平区青年大街322号昌鑫大厦F座1801</p><p>【邮编】:110000</p><p>【电话】:024-31897563</p><p>【传真】:024-31897564<br /></p>', '2', '1', '1', '8');
INSERT INTO `lfy_member_sales` VALUES ('4', '微信会员卡独享9折优惠', '1382594184', '<p style=\"text-indent:2em;\">会员卡到店消费独享9折优惠会员卡泛指普通身份识别卡，包括商场、宾馆、健身中心、酒家等消费场所的会员认证。它们的用途非常广泛，凡涉及到需要识别身份的地方，都可应用到身份识别卡，如学校、俱乐部、公司、机关、团体等。</p><p style=\"text-indent:2em;\"><img src=\"/web-api/uploadfiles/20131024/61841382603793.jpg\" style=\"float:left;\" title=\"sports.jpg\" border=\"0\" hspace=\"0\" vspace=\"0\" /><br /></p><p style=\"text-indent:2em;\">会员制服务也是现在流行的一种服务管理模式，它可以提高顾客的回头率，提高顾客对企业忠诚度。很多的服务行业都采取这样的服务模式，会员制的形式多数都表现为会员卡。一个公司发行的会员卡相当于公司的名片，在会员卡上可以印刷公司的标志或者图案，为公司形象作宣传，是公司进行广告宣传的理想载体。同时发行会员卡还能起到吸引新顾客，留住老顾客，增强顾客忠诚度的作用，还能实现打折、积分、客户管理等功能，是一种确实可行的增加效益的途径。</p>', '1', '1', '0', '30');

-- ----------------------------
-- Table structure for lfy_mobile_bind_list
-- ----------------------------
DROP TABLE IF EXISTS `lfy_mobile_bind_list`;
CREATE TABLE `lfy_mobile_bind_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动编号',
  `weixin_id` varchar(100) NOT NULL DEFAULT '' COMMENT '微信ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绑定时间',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '绑定的用户姓名',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0-禁用 1-启用',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `main` (`weixin_id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='手机微信管理绑定名单';

-- ----------------------------
-- Records of lfy_mobile_bind_list
-- ----------------------------
INSERT INTO `lfy_mobile_bind_list` VALUES ('5', 'fdfgdgdfg5435', '0', 'fff', '1', 'fff');
INSERT INTO `lfy_mobile_bind_list` VALUES ('3', '111111', '0', '', '1', '');

-- ----------------------------
-- Table structure for lfy_reply_database
-- ----------------------------
DROP TABLE IF EXISTS `lfy_reply_database`;
CREATE TABLE `lfy_reply_database` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '消息标题',
  `keywords` varchar(150) NOT NULL DEFAULT '',
  `contents` text COMMENT '内容',
  `description` varchar(250) NOT NULL DEFAULT '' COMMENT '描述信息，最长120个汉字',
  `click_url` varchar(250) NOT NULL DEFAULT '' COMMENT '手机访问的链接',
  `pic_url_big` varchar(250) NOT NULL DEFAULT '' COMMENT '封面图片链接',
  `pic_url_small` varchar(200) NOT NULL DEFAULT '' COMMENT '小封面图片url',
  `msg_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '回复类型，1-单条文本回复,2-单条图文回复,3-图文列表回复',
  `sort` int(11) NOT NULL DEFAULT '9999999' COMMENT '排序等级',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问数量',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0-禁用 1-启用',
  PRIMARY KEY (`id`),
  KEY `key` (`id`,`title`,`keywords`,`sort`,`msg_type`,`status`,`create_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=717 DEFAULT CHARSET=utf8 COMMENT='智能回复数据表';

-- ----------------------------
-- Records of lfy_reply_database
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_seckill_access
-- ----------------------------
DROP TABLE IF EXISTS `lfy_seckill_access`;
CREATE TABLE `lfy_seckill_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '访问记录⁯ID',
  `weixin_id` varchar(100) NOT NULL DEFAULT '' COMMENT '用户微信ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问时间',
  `create_date` date DEFAULT NULL COMMENT '访问日期',
  `seckill_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '秒杀活动ID 0-为秒杀活动首页',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`create_time`,`create_date`,`seckill_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1717 DEFAULT CHARSET=utf8 COMMENT='秒杀活动浏览记录';

-- ----------------------------
-- Records of lfy_seckill_access
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_seckill_duihuan
-- ----------------------------
DROP TABLE IF EXISTS `lfy_seckill_duihuan`;
CREATE TABLE `lfy_seckill_duihuan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '兑换记录ID',
  `weixin_id` varchar(100) NOT NULL DEFAULT '' COMMENT '微信用户ID',
  `seckill_record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '微信秒杀成功记录ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '兑换时间',
  `create_date` date DEFAULT NULL COMMENT '兑换日期',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `user_telephone` varchar(50) NOT NULL DEFAULT '' COMMENT '用户联系电话',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`seckill_record_id`,`create_time`,`create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='微信秒杀兑换记录';

-- ----------------------------
-- Records of lfy_seckill_duihuan
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_seckill_goods
-- ----------------------------
DROP TABLE IF EXISTS `lfy_seckill_goods`;
CREATE TABLE `lfy_seckill_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '秒杀活动编号',
  `goods_title` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '秒杀活动标题',
  `goods_name` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '秒杀商品名称',
  `goods_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '秒杀商品数量',
  `goods_cost_price` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '商品原价',
  `goods_price` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '商品秒杀价格',
  `pic_url` varchar(300) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '秒杀活动封面',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `stop_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `exchange_stop_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '兑换结束时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示状态，0-隐藏 1-显示',
  `sort` int(10) unsigned NOT NULL DEFAULT '99999' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `goods_explain` text CHARACTER SET utf8 COMMENT '商品说明',
  `remark` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '备注',
  `exchange_explain` text CHARACTER SET utf8 COMMENT '兑换说明',
  `wx_user_num` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '限制没用户参与次数，0-不限制 其他数字为限制数量',
  `code_num` int(11) unsigned NOT NULL DEFAULT '10' COMMENT '兑换码位数',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`begin_time`,`stop_time`,`exchange_stop_time`,`status`,`sort`,`create_time`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='微信秒杀活动商品信息表';

-- ----------------------------
-- Records of lfy_seckill_goods
-- ----------------------------
INSERT INTO `lfy_seckill_goods` VALUES ('1', '换季全网低价小衫', '达芙妮小衫', '10', '150.2', '80.0', '/weixin_api/Public/upload/pic/big/20131101/52734a3e9f229.jpg', '1378795427', '1478795427', '0', '1', '99999', '0', '<p>换季全网低价小</p>', '', '每人仅限参与1次', '1', '10');
INSERT INTO `lfy_seckill_goods` VALUES ('2', '打折大清仓特价商品', '以纯牛仔裤', '0', '220.0', '90.0', '/weixin_api/Public/images/tmp/img3.jpg', '2013', '2016', '0', '0', '99999', '0', '打折大清仓特价商品', '', '每人仅限参与1次', '1', '10');
INSERT INTO `lfy_seckill_goods` VALUES ('3', 'dfdsfdsfdsf', 'ffdfsdf', '5', '50.0', '2.0', '/weixin_api/Public/images/tmp/img3.jpg', '1380499200', '1380505020', '0', '1', '99999', '0', '<p>hfghgfhghg</p>', '1231321', '1231321', '0', '10');
INSERT INTO `lfy_seckill_goods` VALUES ('4', '', '', '0', '0.0', '0.0', '', '0', '0', '0', '1', '9999', '1382586101', '<p>111111111111111111111111111gfdgdfgdfgfghhgfhgfh</p>', ' ', ' ', '1', '10');

-- ----------------------------
-- Table structure for lfy_seckill_record
-- ----------------------------
DROP TABLE IF EXISTS `lfy_seckill_record`;
CREATE TABLE `lfy_seckill_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '秒杀成功ID',
  `weixin_id` varchar(100) NOT NULL DEFAULT '' COMMENT '微信用户ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `create_date` date DEFAULT NULL,
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '兑换码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '兑换状态 0-未兑换 1-已经兑换',
  `seckill_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '秒杀活动ID',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`create_time`,`create_date`,`status`,`seckill_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='微信秒杀活动秒杀成功记录表';

-- ----------------------------
-- Records of lfy_seckill_record
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_sign_in
-- ----------------------------
DROP TABLE IF EXISTS `lfy_sign_in`;
CREATE TABLE `lfy_sign_in` (
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '签到标题',
  `sign_instructions` text COMMENT '签到说明',
  `business_description` text COMMENT '商家宣传语'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信每日签到基础信息表';

-- ----------------------------
-- Records of lfy_sign_in
-- ----------------------------
INSERT INTO `lfy_sign_in` VALUES ('微信每日签到', '签到说明', '商家宣传语');

-- ----------------------------
-- Table structure for lfy_sign_in_description
-- ----------------------------
DROP TABLE IF EXISTS `lfy_sign_in_description`;
CREATE TABLE `lfy_sign_in_description` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '宣传语ID',
  `business_description` text COMMENT '商家宣传语',
  `use_date` date DEFAULT NULL COMMENT '使用日期',
  PRIMARY KEY (`id`),
  KEY `main` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='微信每日签到定义日期宣传语';

-- ----------------------------
-- Records of lfy_sign_in_description
-- ----------------------------
INSERT INTO `lfy_sign_in_description` VALUES ('1', '今天天气不错呀', '2013-09-22');

-- ----------------------------
-- Table structure for lfy_sign_in_record
-- ----------------------------
DROP TABLE IF EXISTS `lfy_sign_in_record`;
CREATE TABLE `lfy_sign_in_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weixin_id` varchar(50) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `create_date` date NOT NULL,
  `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '获得的积分数量',
  `client_ip` varchar(50) NOT NULL DEFAULT '' COMMENT '客户ip地址',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_id`,`create_time`,`create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='微信每日签到记录';

-- ----------------------------
-- Records of lfy_sign_in_record
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_sign_up
-- ----------------------------
DROP TABLE IF EXISTS `lfy_sign_up`;
CREATE TABLE `lfy_sign_up` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `remark` varchar(200) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `create_ip` varchar(50) NOT NULL DEFAULT '',
  `weixin_id` varchar(100) NOT NULL DEFAULT '' COMMENT '微信ID',
  `kind` varchar(50) NOT NULL DEFAULT '' COMMENT '报名项目',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`create_time`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='微信在线报名信息';

-- ----------------------------
-- Records of lfy_sign_up
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_subscribe
-- ----------------------------
DROP TABLE IF EXISTS `lfy_subscribe`;
CREATE TABLE `lfy_subscribe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '标题',
  `contents` text COMMENT '内容',
  `description` varchar(200) NOT NULL DEFAULT '' COMMENT '描述信息',
  `msg_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '消息类型，1-文本 2-单条图文 3-多条图文',
  `pic_url_big` varchar(200) NOT NULL DEFAULT '' COMMENT '大封面图片链接',
  `pic_url_small` varchar(200) NOT NULL DEFAULT '' COMMENT '小图片封面url',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建事件',
  `click_url` varchar(200) NOT NULL DEFAULT '' COMMENT '点击跳转链接，如果为空则自动生成当前链接',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态，0-隐藏 1-显示',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `main` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '适用于多条图文的标识父指令信息',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '请求数量',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`msg_type`,`create_time`,`status`,`sort`,`main`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='新订阅配置';

-- ----------------------------
-- Records of lfy_subscribe
-- ----------------------------
INSERT INTO `lfy_subscribe` VALUES ('1', '文本回复22222', '<p><img src=\"http://127.0.0.1/weixin_api/uploadfiles/20130627/78571372327701.jpg\" style=\"float:none;\" title=\"微信公众平台自定义菜单.jpg\" border=\"0\" hspace=\"0\" vspace=\"0\" width=\"291\" height=\"500\" /><br /></p>', 'ghgjgjgj', '2', '/weixin_api/public/upload/pic/small/20130627/51cc0f0c52c53.jpg', '', '1372300501', 'jhgjg', '0', '10', '0', 'fdfsdf', '0');

-- ----------------------------
-- Table structure for lfy_unsubscrib
-- ----------------------------
DROP TABLE IF EXISTS `lfy_unsubscrib`;
CREATE TABLE `lfy_unsubscrib` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `weixin_name` varchar(100) NOT NULL DEFAULT '' COMMENT '微信用户名(加密值)',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_date` date NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_name`,`create_time`,`create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=1334 DEFAULT CHARSET=utf8 COMMENT='微信取消关注用户记录';

-- ----------------------------
-- Records of lfy_unsubscrib
-- ----------------------------

-- ----------------------------
-- Table structure for lfy_user
-- ----------------------------
DROP TABLE IF EXISTS `lfy_user`;
CREATE TABLE `lfy_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '中文昵称',
  `user_pwd` char(32) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `lastlogin_ip` varchar(50) NOT NULL DEFAULT '',
  `lastlogin_time` int(10) unsigned NOT NULL DEFAULT '0',
  `admin` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否为系统管理员，0-否 1-是',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0-禁用 1-启用',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`user_name`,`admin`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lfy_user
-- ----------------------------
INSERT INTO `lfy_user` VALUES ('1', 'admin', '管理员', 'db69fc039dcbd2962cb4d28f5891aae1', '0', '127.0.0.1', '1399597558', '1', '1', '管理员');
INSERT INTO `lfy_user` VALUES ('10', '0101', '兑奖操作1', '3093ac5f0f832395bb4664d0625d747b', '1383203093', '', '0', '1', '1', '');

-- ----------------------------
-- Table structure for lfy_user_message
-- ----------------------------
DROP TABLE IF EXISTS `lfy_user_message`;
CREATE TABLE `lfy_user_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wx_name` varchar(50) NOT NULL DEFAULT '' COMMENT '微信用户识别码',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '内容',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_date` date NOT NULL COMMENT '创建日期',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `main` (`wx_name`,`create_time`,`create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=utf8 COMMENT='用户会话消息记录表';

-- ----------------------------
-- Records of lfy_user_message
-- ----------------------------
INSERT INTO `lfy_user_message` VALUES ('2', 'oDsx8jic7wYbkwBH-yRFDXO4vgGA', '谢谢小编 继续支持/:,@-D', '1399539238', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('3', 'oDsx8jqhj2dvmqpLPjrr89f8Lb5k', '曹丽，18640569097', '1399539677', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('4', 'oDsx8jhLT6b56mPbmMo3pS8YDU9o', '陈焕13654053660', '1399540810', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('5', 'oDsx8jk6OIdL_A-8H0luMto9twyg', '曹晨 18602447720', '1399541222', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('6', 'oDsx8jtZoZ9R4b9BqzsCSmQpk5Mo', '石蕾  13897957210', '1399541233', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('7', 'oDsx8jgcSDmT5D6kCwT-tqt27Hbc', '杨玥 13940440740', '1399541296', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('8', 'oDsx8jp_tFlvSBJr0I94xzPWI4wE', '马景旗，13644001566', '1399541350', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('9', 'oDsx8jjuDIZjrPKMAi_sFqIB9aQA', '朴馨  15998238705', '1399541356', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('10', 'oDsx8jvhfXN7w3fCYY5TQQk2JvQw', '15204033012       王永欣', '1399541363', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('11', 'oDsx8jiRRKqmWlybR1-rSBoto92s', '陈科如18624061167', '1399541423', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('12', 'oDsx8jv8cSVg7jIDS6B2z6fjkp34', '郭蕊15040225386', '1399541475', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('13', 'oDsx8js57o6UcD8FVM4TAVqqAtFQ', '梁晓光15942303269', '1399541550', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('14', 'oDsx8jrWI5_3RPJG-ZmL6voxVWh8', '刘丽，14704062887', '1399541581', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('15', 'oDsx8ju14oHdmS136hT-feaKiKWg', '吴丽梅13614011288', '1399541603', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('16', 'oDsx8juHVpzkUjVgnYSne8PMWuh8', '李佳佳+13194201824', '1399541701', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('17', 'oDsx8jg0bz3_hMnIeeoqR3qLg8Fs', '张鑫18940022511', '1399541830', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('18', 'oDsx8jnuJrSecWrhN6VAiXMWFRbU', '刘宏杰13909833925', '1399541838', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('19', 'oDsx8jmOyS5KgX0u6xQBeM3T-hLk', '刘洋15640067848', '1399541870', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('20', 'oDsx8jjPvY3IeMLiFUwH3NCGU53U', '曹善军15142803418', '1399541873', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('21', 'oDsx8js8oUot8ZLDNjXI7RULSWlU', '胡彩霞手机号13386877527', '1399541963', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('22', 'oDsx8joNYh_8zCZ_d48GbN9EPC1w', '田仲云13804026021', '1399542012', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('23', 'oDsx8jpjqDkMEBQnOFtTxj5z0ByM', '刘岩13644975560', '1399542022', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('24', 'oDsx8jiPdtOsL2y542FFGxCVxiBw', '王江15640576040', '1399542027', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('25', 'oDsx8jl0dUc-dwsCYUWm8FiCEK4I', '小熙 15041216675', '1399542057', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('26', 'oDsx8jg3jbK6vHnsZfpmDfaHSh40', '霍孝莲13478322127', '1399542090', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('27', 'oDsx8jhhvhjSp6ZMnzSqCKFUSccc', '蒋丹 13889349382', '1399542149', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('28', 'oDsx8jhpePyhVkdDFEMKjyHR7GNk', '宋丹15041224109', '1399542274', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('29', 'oDsx8jrhvP4rj7EUTkA_YUcmldOU', '张平13898837071', '1399542340', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('30', 'oDsx8ju90D_r6TS2JiM70xoL6RTs', '丁梅+15998105308', '1399542343', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('31', 'oDsx8jiZtxKc6qAhN2KzzD7uIF80', '王瑶13940062795', '1399542449', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('32', 'oDsx8jnaa1w8Fe2RzlLB85q1DwKs', '王丽     15840504271', '1399542611', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('33', 'oDsx8jl241htnVvGqF2s0NQWAG7w', '孟艳红 13609873700', '1399542665', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('34', 'oDsx8jhx_dkBl-ELRZCYMcd8pbLc', 'YAODONG13870524629', '1399542980', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('35', 'oDsx8jhx_dkBl-ELRZCYMcd8pbLc', '分享动漫展门票', '1399543067', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('36', 'oDsx8juJvsbh7M1g7_QBqGvT_WBk', '李美欣13840551334', '1399543078', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('37', 'oDsx8jo6xhPQleW14yfomiD5y9mc', '任丽娜18304017666', '1399543103', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('38', 'oDsx8jqAtq9fUTzl833lGSXN35s0', '周鹏  15504142168', '1399543240', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('39', 'oDsx8jqAtq9fUTzl833lGSXN35s0', '周鹏翥  15504142168', '1399543310', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('40', 'oDsx8jtdOJHUJ0M2Mifi1xsP1-YE', '陈韵燃13709884045', '1399543353', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('41', 'oDsx8jk3OLr5XTcASOlzPOw9KVyY', '谢谢，小编，好开心啊/:,@-D', '1399543386', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('42', 'oDsx8jrKOMI_2Xxu-jWVcp5eRRrY', '曲洋 15040195907', '1399543447', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('43', 'oDsx8jpfijjQYFh6mZo8GEV-QFQI', '林楠13940432666', '1399543465', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('44', 'oDsx8jllZIw7d1F22ntvfn2LKmX4', '刘葳 18602422223', '1399543510', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('45', 'oDsx8jkjIEhftZbjGsAAQZxVaMCw', '丁晓晔  15940594495', '1399543575', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('46', 'oDsx8jqnkcVfxnvBGzIC1JG2_DBg', '韩哲15104033393', '1399543613', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('47', 'oDsx8jtvSQmlVVomTd7cZgbX-oBY', '18640133324', '1399543645', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('48', 'oDsx8jtvSQmlVVomTd7cZgbX-oBY', '袁智', '1399543692', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('49', 'oDsx8joAspIQtiTTE_ZUbZk88EU8', '朱列垚13591475741', '1399543818', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('50', 'oDsx8jp28mZ7ZTsfzczzzvsGNCgw', ' 冯新 13236648369 ', '1399543964', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('51', 'oDsx8jt176DZCTrE749VNDt_7wLs', '刘明，15940140368', '1399544036', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('52', 'oDsx8jvnmuwpQ6Ycbo1pzCsi-TTI', '王守顺\n        13998312516', '1399544211', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('53', 'oDsx8juFmr7EvihYJRy7r0F95PKQ', '弓洛川15604050617', '1399544317', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('54', 'oDsx8jpZfB38txK15LuDbQF6ROQQ', '李树昌13664144522', '1399544586', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('55', 'oDsx8jusK100zmNFMv9T7oCfOyJo', '苏晓旭15382093987', '1399544621', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('56', 'oDsx8jrSKiNr4vbUua_BqWR72MDM', '邵洁15998130792', '1399544661', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('57', 'oDsx8jlVy8bpVFFgLRcm3JHlbzEI', '刘婧瑶15040125746', '1399544673', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('58', 'oDsx8jjtzjQK9CBNJwSve3pTxuZg', '于洋 15242460631', '1399544824', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('59', 'oDsx8ju0XyMST072EGTuUdDftDds', '白雪 15904051776', '1399544976', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('60', 'oDsx8jrCC64dqc0oDg9XQG11YUl4', '姓名：贾茹   电话：13940526305', '1399545034', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('61', 'oDsx8jrVRRHoKYKD8n_z8zJefzZ0', '中街', '1399545069', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('62', 'oDsx8jrVRRHoKYKD8n_z8zJefzZ0', '串', '1399545081', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('63', 'oDsx8juc8blCFoseh5Swymf4LHRI', '动漫门票，朱盛强，13889110608', '1399545282', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('64', 'oDsx8jgiYGicj4Bdl0sDSurZlzLk', '牛春皎，13332499051', '1399545841', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('65', 'oDsx8jijFPjWOvCKwZ1dzEnRsS9o', '赵月婷', '1399545973', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('66', 'oDsx8jijFPjWOvCKwZ1dzEnRsS9o', '18240328115', '1399545980', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('67', 'oDsx8jnOJVVlNCVzHnjQRQVUPm_o', '孔祥凤15604050630', '1399546070', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('68', 'oDsx8jgwBnhf-gZWJSMMZLcMHaNI', '张非非+13804905382', '1399546126', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('69', 'oDsx8jvX2IlyWeDlFZWcnf0-fxc4', '张广莹13066555630', '1399546930', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('70', 'oDsx8jlHmL2iq4BCscUVAR8__e3Q', '李彦 15940350829', '1399546958', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('71', 'oDsx8jrXuuvLmQ7h4alKsdR-on5s', '刘琳15840259780', '1399547120', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('72', 'oDsx8jjT0xWvT_rWlGEbB2Dls6uo', '孙故事15004072816', '1399547485', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('73', 'oDsx8jjm_nBw6Z48QxCA1Bbs7-bY', '佟家栋15204013720', '1399547517', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('74', 'oDsx8jg2iJfrQ83Ah-BIgUInl8FA', '赵鑫18740042552', '1399547572', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('75', 'oDsx8jh6L1RzdvRW5z8aZoduGy48', '董娜 13840194695', '1399547604', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('76', 'oDsx8jvmzFjeR62AOGsNlH2ngL5M', '鲁东邑 13604066119', '1399547741', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('77', 'oDsx8jnqVtsLOcyLnB-4xNMX_gdQ', '周宏，13998880263', '1399548244', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('78', 'oDsx8jv8mznRbXgEtS0WLAlPG2RQ', '大学生那个小龙虾的微信号是多少呀？', '1399548311', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('79', 'oDsx8jkcFKX417GgOFqyLy81l6_A', '李鹤 13940466753', '1399548440', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('80', 'oDsx8jv8mznRbXgEtS0WLAlPG2RQ', '小龙虾', '1399548534', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('81', 'oDsx8jjHYEDX-eUaxFaWkevkzauI', '王伟楠+13897914667', '1399548683', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('82', 'oDsx8jkEpcm1PqYxczy91GH3_XsM', '浩皓15841490423', '1399548809', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('83', 'oDsx8jmtkwv3diZlMJHT2xfcONJw', '13614992912', '1399549702', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('84', 'oDsx8jmtkwv3diZlMJHT2xfcONJw', '兰威', '1399549715', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('85', 'oDsx8jr_Sa9kefopybrN8BBMVfSA', '麻欢15998367693', '1399550213', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('86', 'oDsx8jrUWCJyg1w7ZcaDzSRoT4Ls', '李焱15640021309', '1399550502', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('87', 'oDsx8jl5wPE9Vzd2GL5rD8YqHS3c', '成怀强 13304056809', '1399550700', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('88', 'oDsx8joUNfJSjNwRGxxGSZ1aog1w', '饭店', '1399550867', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('89', 'oDsx8jkaeOly1Olj06qWkSNS8mE8', '李晨旭 18602407478', '1399551041', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('90', 'oDsx8jmpruL6ZEyJty5jYlz1KrmY', '冷雪莹 13238844745', '1399551159', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('91', 'oDsx8jhpy5eYGqc3CPPQ2DOzXl2U', ' 赵慧彬15140092077', '1399551186', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('92', 'oDsx8jsJ9OFuCL43WS_9N5HtKvsI', '杨旭15840172911', '1399551298', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('93', 'oDsx8jm58VBsvWwtasMUfb_1N3Wg', '李城佑\n15640507096', '1399552044', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('94', 'oDsx8ju3kgkZ69borgb6CpAywmh0', '郑阳 13998818026', '1399552250', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('95', 'oDsx8ju0dv5PotW2i4cXB7VnrpTA', '刘海波13386855955', '1399552461', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('96', 'oDsx8jlxOeQqA710GqRCDmUa9FDc', '张岩，15040045522', '1399552868', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('97', 'oDsx8juHWmQCp4EXtjOWPUfK7T1M', '李泓泠+15802461797', '1399553145', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('98', 'oDsx8juwe3fvZR7yVaDyPUMioqH4', '13082435737', '1399553270', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('99', 'oDsx8jkiliUdB9XiOjJa1qGDMmsA', '胡家浩13352413623', '1399553399', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('100', 'oDsx8jtdp5NKDWgZF3HSqxir10qw', '孙越 18940166896', '1399554170', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('101', 'oDsx8jml9ef1Go97Q8mc-3kFYQEc', '李晓婷，手机号13998179880', '1399554195', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('102', 'oDsx8jnjAirULeQrkeO2QSf-NSUA', '金娜 15104015745', '1399554205', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('103', 'oDsx8joxSg5vjvqRQJyTuFHe0Y6g', '胡传喜13889287516', '1399554280', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('104', 'oDsx8jsmyPA9UO5W95r2kjk2-7Xo', '牛晶淼13332425088', '1399554291', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('105', 'oDsx8jny7wZwzZuYm5q8cOI7O64Q', '王茜   1384090801', '1399554440', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('106', 'oDsx8jny7wZwzZuYm5q8cOI7O64Q', '王茜13840490801', '1399554460', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('107', 'oDsx8jvB-UygQKPpNqs8wSuE0pZw', '郑艺雯\n13940066260', '1399554628', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('108', 'oDsx8jrhvP4rj7EUTkA_YUcmldOU', '张平  13898837071 谢谢', '1399555096', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('109', 'oDsx8jlsYZS3hRHP2fVh_obiZkDU', '王宁，13840319278', '1399555629', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('110', 'oDsx8jpK8LSbPw3r_UAG8HRZs73E', '马晓明 15998148060', '1399556017', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('111', 'oDsx8jgpPLBiIsws-P2DNNIGYYDY', '毛祥国 18624025245', '1399556714', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('112', 'oDsx8jlt1v-QwzYFbVpfHxm6SiFQ', '袁士军 15009884781', '1399556771', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('113', 'oDsx8jqmev989Wd8z4HEJVoYaTEM', '林芳 13604210426', '1399557885', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('114', 'oDsx8jtprUJ2EfqkAsip4aj79tMA', '王蕾      18604042497', '1399558173', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('115', 'oDsx8jnCAcO9j-EHROxFtqgdw6Vo', '陈飞13909882973', '1399559685', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('116', 'oDsx8jrpCCFC2jZmKwHB0znPCuuw', '赵楠13940128193', '1399560088', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('117', 'oDsx8jmCrBOH0fbcBsz_JQYHEMfg', '报名17号活动，聪聪，男，2013.7.8，13082497572，，不坐大巴', '1399560510', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('118', 'oDsx8jpADxTEgn6Qy9tWh-j6Y4hA', '参加17号活动，鑫鑫，男孩，生日2013.6，电话13840298129，坐大巴2大一小', '1399560816', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('119', 'oDsx8jkx-zdiVgINmoVcVWA2oy2Q', '顾婉宁\n18202404155', '1399560876', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('120', 'oDsx8jk3OLr5XTcASOlzPOw9KVyY', '小编，问下，chinajoy的地点是在保工街南九路76号的工人文化宫吗？不是开发区里的吧？也不是太原街的那个？', '1399561502', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('121', 'oDsx8jk3OLr5XTcASOlzPOw9KVyY', '谢谢，小编，打扰了', '1399561517', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('122', 'oDsx8jnEcGezUBYGN5_r60JOvs_w', '王强18624021757', '1399562478', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('123', 'oDsx8jqSxTU1LAVC41ufNLkX5U78', '贾岩13591449995', '1399564366', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('124', 'oDsx8jqSxTU1LAVC41ufNLkX5U78', '贾岩13591449995', '1399564371', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('125', 'oDsx8juIhUqtOrRGiQV2JFxGUDec', '张立蕊18809883176', '1399564436', '2014-05-08', '');
INSERT INTO `lfy_user_message` VALUES ('126', 'oDsx8jthFSlFX8GSYKTpc2I4KHgE', '陈曦13840124846', '1399565387', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('127', 'oDsx8jhE3ksyKZBTPPDuoAGXZIEk', '刘德新  15942007383', '1399565940', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('128', 'oDsx8jksdhBplxZjbhgx9_iIAQJ4', '喻子洋 13998841127', '1399573580', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('129', 'oDsx8jhMqnHqbkbwrz3dl8XpEnrE', '代强13998851714', '1399582764', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('130', 'oDsx8jrIJYVP5YGDCl2-G590gs-4', '王竹   13898807209', '1399589476', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('131', 'oDsx8jtF7sd5KuPcNwrIZYoA7s8E', '陈晓东：18604935911', '1399590122', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('132', 'oDsx8juRV7Vu8nNpOsBtLmZhpIEI', '程飞15304017357', '1399590710', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('133', 'oDsx8jnIkzLlKkETeinPQGAY2p1U', '南方   15998386855', '1399591222', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('134', 'oDsx8jsP1DT99SDVpmIDd3119qrI', '张晓薇     13940335250', '1399593829', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('135', 'oDsx8juUCZgqxHHDOv2Y_u8Ga4fM', '赵明阳 15542284989', '1399594186', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('137', 'oDsx8jnF8NnXQlzsWGGrTPyB3BPE', '韩惠宇+13940463909', '1399595470', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('138', 'oDsx8jnF8NnXQlzsWGGrTPyB3BPE', '韩惠宇+13940463909', '1399595476', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('139', 'oDsx8jnF8NnXQlzsWGGrTPyB3BPE', '韩惠宇+13940463909', '1399595486', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('140', 'oDsx8jnF8NnXQlzsWGGrTPyB3BPE', '韩惠宇+13940463909', '1399595489', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('141', 'oDsx8jnF8NnXQlzsWGGrTPyB3BPE', '韩惠宇+13940463909', '1399595493', '2014-05-09', '');
INSERT INTO `lfy_user_message` VALUES ('142', 'oDsx8jnF8NnXQlzsWGGrTPyB3BPE', '韩惠宇+13940463909', '1399595497', '2014-05-09', '');

-- ----------------------------
-- Table structure for lfy_weixin_menu
-- ----------------------------
DROP TABLE IF EXISTS `lfy_weixin_menu`;
CREATE TABLE `lfy_weixin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `menu_key` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单指令key',
  `sort` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '显示状态 0-隐藏 1-显示',
  `main` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单 0-顶级',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '点击直接跳转url',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`sort`,`status`,`main`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='自定义菜单设置表';

-- ----------------------------
-- Records of lfy_weixin_menu
-- ----------------------------
INSERT INTO `lfy_weixin_menu` VALUES ('1', '优惠券', 'main_youhuiquan', '1', '1', '0', '');
INSERT INTO `lfy_weixin_menu` VALUES ('2', '茶点卡', 'main_chadian', '2', '1', '0', '');
INSERT INTO `lfy_weixin_menu` VALUES ('3', '门店新品', 'main_news', '3', '1', '0', '');
INSERT INTO `lfy_weixin_menu` VALUES ('11', 'bbb', 'bbbb', '10', '1', '1', '');

-- ----------------------------
-- Table structure for lfy_weixin_user
-- ----------------------------
DROP TABLE IF EXISTS `lfy_weixin_user`;
CREATE TABLE `lfy_weixin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `weixin_name` varchar(100) NOT NULL DEFAULT '' COMMENT '微信用户名(加密值)',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_date` date NOT NULL COMMENT '创建日期',
  `last_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后访问时间',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `user_mobile` varchar(50) NOT NULL DEFAULT '' COMMENT '手机号码',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_name`,`create_time`,`create_date`,`last_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8603 DEFAULT CHARSET=utf8 COMMENT='微信关注用户记录';

-- ----------------------------
-- Records of lfy_weixin_user
-- ----------------------------
INSERT INTO `lfy_weixin_user` VALUES ('8601', 'fdfffDFSDFSf', '1397630991', '2014-04-16', '1397630991', 'yjhgjghj', '张三111', '15940442002y666');
INSERT INTO `lfy_weixin_user` VALUES ('8602', '2222222222', '854565222', '2014-04-17', '23564', '', '', '');

-- ----------------------------
-- Table structure for lfy_zhiling
-- ----------------------------
DROP TABLE IF EXISTS `lfy_zhiling`;
CREATE TABLE `lfy_zhiling` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '指令识别',
  `menu_key` varchar(50) NOT NULL DEFAULT '' COMMENT '自定义菜单响应key，不超过20字符，默认为空',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '标题',
  `contents` text COMMENT '内容',
  `description` varchar(200) NOT NULL DEFAULT '' COMMENT '描述信息',
  `msg_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '消息类型，1-文本 2-单条图文 3-多条图文',
  `pic_url_big` varchar(200) NOT NULL DEFAULT '' COMMENT '大封面封面url',
  `pic_url_small` varchar(200) NOT NULL DEFAULT '' COMMENT '小封面图片url',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建事件',
  `click_url` varchar(200) NOT NULL DEFAULT '' COMMENT '点击跳转链接，如果为空则自动生成当前链接',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态，0-隐藏 1-显示',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `main` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '适用于多条图文的标识父指令信息',
  `remark` varchar(200) NOT NULL DEFAULT '',
  `num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问数量',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`code`,`msg_type`,`create_time`,`status`,`sort`,`main`,`menu_key`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文本指令标识信息表';

-- ----------------------------
-- Records of lfy_zhiling
-- ----------------------------
INSERT INTO `lfy_zhiling` VALUES ('1', '中国12', 'china', '中华人民共和国', '<p><img src=\"/weixin_api/uploadfiles/20130710/56671373446972.jpg\" style=\"float:none;\" title=\"800 (10).jpg\" border=\"0\" hspace=\"0\" vspace=\"0\" /><br /></p><p>中华人民共和国地图</p>', 'fdfdff', '3', '', '', '0', '', '1', '0', '2', '', '39');
INSERT INTO `lfy_zhiling` VALUES ('2', '在线客服', 'service', 'gfgfdgfdg', '<p>878768886</p><p><img src=\"/weixin/uploadfiles/20131104/13835512308900.jpg\" title=\"IMG_20130623_131140.jpg\"/></p>', 'fgfgfgfdgfdgfgfdg', '3', '/weixin_api/public/upload/pic/small/20130628/51cd364240fc7.jpg', '', '1372403271', '', '1', '0', '0', 'gggg', '1');
