/*
Navicat MySQL Data Transfer

Source Server         : 本地mysql
Source Server Version : 50533
Source Host           : localhost:3308
Source Database       : weixin

Target Server Type    : MYSQL
Target Server Version : 50533
File Encoding         : 65001

Date: 2013-11-21 11:01:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lfy_auth_group`
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
INSERT INTO `lfy_auth_group` VALUES ('1', '默认用户组', '1', '2,1,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,79,80,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,58,59,57,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,81,82,83,84,85,86', '默认全部权限');
INSERT INTO `lfy_auth_group` VALUES ('2', '兑奖管理', '1', '2,1,3', '');

-- ----------------------------
-- Table structure for `lfy_auth_group_access`
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
-- Table structure for `lfy_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `lfy_auth_rule`;
CREATE TABLE `lfy_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT ' 状态 0-禁用 1-正常',
  `condition` varchar(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `main` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单 0-为一级主菜单',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`main`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COMMENT='权限规则表';

-- ----------------------------
-- Records of lfy_auth_rule
-- ----------------------------
INSERT INTO `lfy_auth_rule` VALUES ('1', 'Main/index_census', '首页统计', '1', '', '2');
INSERT INTO `lfy_auth_rule` VALUES ('2', 'Main', '首页', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('11', 'Config', '基础配置', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('12', 'Config/sys_con', '系统配置', '1', '', '11');
INSERT INTO `lfy_auth_rule` VALUES ('13', 'Config/Subscribe', '新订阅管理', '1', '', '11');
INSERT INTO `lfy_auth_rule` VALUES ('14', 'Config/Subscribe/add', '新增', '1', '', '13');
INSERT INTO `lfy_auth_rule` VALUES ('15', 'Config/Subscribe/edit', '编辑', '1', '', '13');
INSERT INTO `lfy_auth_rule` VALUES ('16', 'Config/Subscribe/delete', '删除', '1', '', '13');
INSERT INTO `lfy_auth_rule` VALUES ('17', 'Config/WeixinMenu', '微信菜单管理', '1', '', '11');
INSERT INTO `lfy_auth_rule` VALUES ('18', 'Config/WeixinMenu/add', '新增菜单', '1', '', '17');
INSERT INTO `lfy_auth_rule` VALUES ('19', 'Config/WeixinMenu/edit', '编辑菜单', '1', '', '17');
INSERT INTO `lfy_auth_rule` VALUES ('20', 'Config/WeixinMenu/delete', '删除菜单', '1', '', '17');
INSERT INTO `lfy_auth_rule` VALUES ('21', 'Config/WeixinMenu/upload_server', '上传到服务器', '1', '', '17');
INSERT INTO `lfy_auth_rule` VALUES ('22', 'Config/WeixinMenu/delete_server', '删除服务器菜单', '1', '', '17');
INSERT INTO `lfy_auth_rule` VALUES ('23', 'Config/WeixinMenu/submenu', '子菜单管理', '1', '', '17');
INSERT INTO `lfy_auth_rule` VALUES ('24', 'Reply', '回复管理', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('25', 'Reply/Zhiling', '文本指令管理', '1', '', '24');
INSERT INTO `lfy_auth_rule` VALUES ('26', 'Reply/Zhiling/add', '新增', '1', '', '25');
INSERT INTO `lfy_auth_rule` VALUES ('27', 'Reply/Zhiling/edit', '编辑', '1', '', '25');
INSERT INTO `lfy_auth_rule` VALUES ('28', 'Reply/Zhiling/delete', '删除', '1', '', '25');
INSERT INTO `lfy_auth_rule` VALUES ('29', 'Reply/ReplyDatabase', '智能回复管理', '1', '', '24');
INSERT INTO `lfy_auth_rule` VALUES ('30', 'Reply/ReplyDatabase/add', '新增', '1', '', '29');
INSERT INTO `lfy_auth_rule` VALUES ('31', 'Reply/ReplyDatabase/edit', '编辑', '1', '', '29');
INSERT INTO `lfy_auth_rule` VALUES ('32', 'Reply/ReplyDatabase/delete', '删除', '1', '', '29');
INSERT INTO `lfy_auth_rule` VALUES ('33', 'Activities', '活动管理', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('34', 'Activities/Choujiang', '活动管理', '1', '', '33');
INSERT INTO `lfy_auth_rule` VALUES ('35', 'Activities/Choujiang/add', '新增', '1', '', '34');
INSERT INTO `lfy_auth_rule` VALUES ('36', 'Activities/Choujiang/edit', '编辑', '1', '', '34');
INSERT INTO `lfy_auth_rule` VALUES ('37', 'Activities/Choujiang/delete', '删除', '1', '', '34');
INSERT INTO `lfy_auth_rule` VALUES ('38', 'Activities/Choujiang/award', '奖品管理', '1', '', '33');
INSERT INTO `lfy_auth_rule` VALUES ('39', 'Activities/Choujiang/award/add', '新增', '1', '', '38');
INSERT INTO `lfy_auth_rule` VALUES ('40', 'Activities/Choujiang/award/edit', '编辑', '1', '', '38');
INSERT INTO `lfy_auth_rule` VALUES ('41', 'Activities/Choujiang/award/delete', '删除', '1', '', '38');
INSERT INTO `lfy_auth_rule` VALUES ('42', 'Seckill', '微信秒杀管理', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('43', 'Seckill/SeckillGoods', '秒杀商品管理', '1', '', '42');
INSERT INTO `lfy_auth_rule` VALUES ('44', 'Seckill/SeckillGoods/add', '新增', '1', '', '43');
INSERT INTO `lfy_auth_rule` VALUES ('45', 'Seckill/SeckillGoods/edit', '编辑', '1', '', '43');
INSERT INTO `lfy_auth_rule` VALUES ('46', 'Seckill/SeckillGoods/delete', '删除', '1', '', '43');
INSERT INTO `lfy_auth_rule` VALUES ('47', 'Seckill/duihuan', '兑换记录', '1', '', '42');
INSERT INTO `lfy_auth_rule` VALUES ('48', 'Seckill/SeckillDuihuan', '秒杀兑换', '1', '', '42');
INSERT INTO `lfy_auth_rule` VALUES ('49', 'Member', '会员管理', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('50', 'Member/config', '基础配置', '1', '', '49');
INSERT INTO `lfy_auth_rule` VALUES ('51', 'Member/config/edit', '编辑', '1', '', '50');
INSERT INTO `lfy_auth_rule` VALUES ('52', 'Member/MemberSales', '会员优惠', '1', '', '49');
INSERT INTO `lfy_auth_rule` VALUES ('53', 'Member/MemberSales/add', '新增', '1', '', '52');
INSERT INTO `lfy_auth_rule` VALUES ('54', 'Member/MemberSales/edit', '编辑', '1', '', '52');
INSERT INTO `lfy_auth_rule` VALUES ('55', 'Member/MemberSales/delete', ' 删除', '1', '', '52');
INSERT INTO `lfy_auth_rule` VALUES ('56', 'Member/MemberCard', '会员名单', '1', '', '49');
INSERT INTO `lfy_auth_rule` VALUES ('57', 'Member/identity', '会员验证', '1', '', '49');
INSERT INTO `lfy_auth_rule` VALUES ('58', 'Member/MemberCard/edit', '编辑', '1', '', '56');
INSERT INTO `lfy_auth_rule` VALUES ('59', 'Member/MemberCard/delete', '删除', '1', '', '56');
INSERT INTO `lfy_auth_rule` VALUES ('60', 'Coupon', '优惠券管理', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('61', 'Coupon/Index', '优惠券活动', '1', '', '60');
INSERT INTO `lfy_auth_rule` VALUES ('62', 'Coupon/Index/add', '新增', '1', '', '61');
INSERT INTO `lfy_auth_rule` VALUES ('63', 'Coupon/Index/edit', '编辑', '1', '', '61');
INSERT INTO `lfy_auth_rule` VALUES ('64', 'Coupon/Index/delete', '删除', '1', '', '61');
INSERT INTO `lfy_auth_rule` VALUES ('65', 'Coupon/CouponDuihuan', '兑换记录', '1', '', '60');
INSERT INTO `lfy_auth_rule` VALUES ('66', 'Coupon/CouponDuihuan/duihuan', '优惠券兑换', '1', '', '60');
INSERT INTO `lfy_auth_rule` VALUES ('67', 'User', '用户管理', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('68', 'User/Index', '用户管理', '1', '', '67');
INSERT INTO `lfy_auth_rule` VALUES ('69', 'User/Index/add', '新增', '1', '', '68');
INSERT INTO `lfy_auth_rule` VALUES ('70', 'User/Index/edit', '编辑', '1', '', '68');
INSERT INTO `lfy_auth_rule` VALUES ('71', 'User/Index/delete', '删除', '1', '', '68');
INSERT INTO `lfy_auth_rule` VALUES ('72', 'User/Index/edit_user_group', '授权', '1', '', '68');
INSERT INTO `lfy_auth_rule` VALUES ('73', 'User/Group', '权限组管理', '1', '', '67');
INSERT INTO `lfy_auth_rule` VALUES ('74', 'User/Group/add', '新增', '1', '', '73');
INSERT INTO `lfy_auth_rule` VALUES ('75', 'User/Group/edit', '编辑', '1', '', '73');
INSERT INTO `lfy_auth_rule` VALUES ('76', 'User/Group/delete', '删除', '1', '', '73');
INSERT INTO `lfy_auth_rule` VALUES ('77', 'User/Group/authorize_manage', '授权管理', '1', '', '73');
INSERT INTO `lfy_auth_rule` VALUES ('78', 'User/Group/user_manage', '成员管理', '1', '', '73');
INSERT INTO `lfy_auth_rule` VALUES ('79', 'Activities/Choujiang/award/duihuan', '奖品兑换', '1', '', '33');
INSERT INTO `lfy_auth_rule` VALUES ('80', 'Activities/Choujiang/award/duihuanjilu', '奖品兑换记录', '1', '', '79');
INSERT INTO `lfy_auth_rule` VALUES ('81', 'User/change_password', '修改密码', '1', '', '67');
INSERT INTO `lfy_auth_rule` VALUES ('82', 'Mobile', '手机微信控制', '1', '', '0');
INSERT INTO `lfy_auth_rule` VALUES ('83', 'Mobile/mobile_con', '基础配置', '1', '', '82');
INSERT INTO `lfy_auth_rule` VALUES ('84', 'Mobile/mobile_bind', '绑定管理', '1', '', '82');
INSERT INTO `lfy_auth_rule` VALUES ('85', 'Mobile/mobile_bind/delete', '删除', '1', '', '84');
INSERT INTO `lfy_auth_rule` VALUES ('86', 'Mobile/mobile_bind/edit', '编辑', '1', '', '84');

-- ----------------------------
-- Table structure for `lfy_cache_version`
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
-- Table structure for `lfy_choujiang`
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
-- Table structure for `lfy_choujiang_access`
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
INSERT INTO `lfy_choujiang_access` VALUES ('3298', '123456', '1383636240', '2013-11-05', '3');
INSERT INTO `lfy_choujiang_access` VALUES ('3299', '123456', '1383636251', '2013-11-05', '3');
INSERT INTO `lfy_choujiang_access` VALUES ('3300', '123456', '1383636253', '2013-11-05', '3');

-- ----------------------------
-- Table structure for `lfy_choujiang_award`
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
INSERT INTO `lfy_choujiang_award` VALUES ('1', '2', '200元现金券', '200元现金券', '10', '2', '20', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('2', '2', '100元现金券', '100元现金券', '10', '5', '50', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('3', '2', '50元现金券', '50元现金券', '10', '10', '100', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('4', '2', '30元现金券', '30元现金券', '10', '50', '200', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('5', '2', '10元现金券', '10元现金券', '10', '40', '400', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('6', '2', '谢谢惠顾', '谢谢惠顾', '10', '0', '1330', '0');
INSERT INTO `lfy_choujiang_award` VALUES ('7', '3', '音乐枕', '音乐枕', '1', '0', '100', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('8', '3', '电影票一张', '电影票一张', '2', '0', '200', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('9', '3', '笑脸餐具', '笑脸餐具', '3', '600', '300', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('10', '3', '啤酒', '啤酒', '4', '100', '400', '1');
INSERT INTO `lfy_choujiang_award` VALUES ('12', '3', '谢谢惠顾', '谢谢惠顾', '5', '0', '5000', '0');

-- ----------------------------
-- Table structure for `lfy_choujiang_duijiang`
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
INSERT INTO `lfy_choujiang_duijiang` VALUES ('1', 'b4f1d031e032b1e3addc50745052923e', '2277', '1374656841', '2013-07-24', '');
INSERT INTO `lfy_choujiang_duijiang` VALUES ('2', 'b4f1d031e032b1e3addc50745052923e', '2276', '1374657174', '2013-07-24', '');
INSERT INTO `lfy_choujiang_duijiang` VALUES ('3', 'b4f1d031e032b1e3addc50745052923e', '2262', '1374657433', '2013-07-24', '');
INSERT INTO `lfy_choujiang_duijiang` VALUES ('4', '', '13', '1380509468', '2013-09-30', '');

-- ----------------------------
-- Table structure for `lfy_choujiang_liushuihao`
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
INSERT INTO `lfy_choujiang_liushuihao` VALUES ('1', 'b4f1d031e032b1e3addc50745052923e', '12345', '1', '1374652779', '2013-07-24');
INSERT INTO `lfy_choujiang_liushuihao` VALUES ('2', 'b4f1d031e032b1e3addc50745052923e', '11111', '2', '1374652980', '2013-07-24');
INSERT INTO `lfy_choujiang_liushuihao` VALUES ('3', 'e99ebd2f7b0f6413603813f87595e0d9', '12345', '2', '1374724390', '2013-07-25');
INSERT INTO `lfy_choujiang_liushuihao` VALUES ('4', 'b4f1d031e032b1e3addc50745052923e', '12345', '2', '1374728997', '2013-07-25');
INSERT INTO `lfy_choujiang_liushuihao` VALUES ('5', 'b4f1d031e032b1e3addc50745052923e', '12346', '2', '1374747012', '2013-07-25');
INSERT INTO `lfy_choujiang_liushuihao` VALUES ('6', 'b4f1d031e032b1e3addc50745052923e', '12348', '1', '1375685032', '2013-08-05');
INSERT INTO `lfy_choujiang_liushuihao` VALUES ('7', 'b4f1d031e032b1e3addc50745052923e', '12343', '2', '1375685042', '2013-08-05');
INSERT INTO `lfy_choujiang_liushuihao` VALUES ('8', '1010', '12589', '2', '1377156473', '2013-08-22');

-- ----------------------------
-- Table structure for `lfy_choujiang_record`
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
INSERT INTO `lfy_choujiang_record` VALUES ('2983', '123456', '1383636252', '2013-11-05', '3', '', '12', '0');
INSERT INTO `lfy_choujiang_record` VALUES ('2984', '123456', '1383636253', '2013-11-05', '3', 'GMBAMYM2KNX3E959', '8', '0');

-- ----------------------------
-- Table structure for `lfy_config`
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
INSERT INTO `lfy_config` VALUES ('list_return_count', '图文列表返回数量', '图文列表最大返回数量，最大设置10', '101uyutyu', '1', '5', '0', '', '1');
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
-- Table structure for `lfy_coupon`
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
-- Table structure for `lfy_coupon_duihuan`
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
-- Table structure for `lfy_coupon_record`
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
INSERT INTO `lfy_coupon_record` VALUES ('2', '123456', '1382668562', '2013-10-25', '1', 'MVBJ8G', '1', '127.0.0.1');
INSERT INTO `lfy_coupon_record` VALUES ('3', '9bf27ad185dd05f8d6930f9395adc0c3', '1382671908', '2013-10-25', '1', 'YXLSUQ', '1', '0.0.0.0');
INSERT INTO `lfy_coupon_record` VALUES ('4', '123456', '1382691061', '2013-10-25', '1', 'V8AEE4', '1', '127.0.0.1');
INSERT INTO `lfy_coupon_record` VALUES ('5', '123456', '1382691088', '2013-10-25', '1', 'GMCLKT', '0', '127.0.0.1');
INSERT INTO `lfy_coupon_record` VALUES ('6', '123456', '1382691141', '2013-10-25', '1', '9J6WB4', '0', '127.0.0.1');

-- ----------------------------
-- Table structure for `lfy_member_card`
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
INSERT INTO `lfy_member_card` VALUES ('29', '123456', '1383631152', '2013-11-05', '', '', '0', '', '1000000029');

-- ----------------------------
-- Table structure for `lfy_member_sales`
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
-- Table structure for `lfy_mobile_bind_list`
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
INSERT INTO `lfy_mobile_bind_list` VALUES ('5', '54543543', '0', 'fff', '1', 'fff');
INSERT INTO `lfy_mobile_bind_list` VALUES ('3', '111111', '0', '', '1', '');

-- ----------------------------
-- Table structure for `lfy_reply_database`
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
-- Table structure for `lfy_seckill_access`
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
INSERT INTO `lfy_seckill_access` VALUES ('1709', 'a0220cd5b5cb5126f968382b766b6ee9', '1383206102', '2013-10-31', '0');
INSERT INTO `lfy_seckill_access` VALUES ('1710', 'd19a3cdc71334e6d147e7d21cbe25a86', '1383286516', '2013-11-01', '0');
INSERT INTO `lfy_seckill_access` VALUES ('1711', 'd19a3cdc71334e6d147e7d21cbe25a86', '1383286571', '2013-11-01', '0');
INSERT INTO `lfy_seckill_access` VALUES ('1712', 'd19a3cdc71334e6d147e7d21cbe25a86', '1383286575', '2013-11-01', '1');
INSERT INTO `lfy_seckill_access` VALUES ('1713', 'd19a3cdc71334e6d147e7d21cbe25a86', '1383286586', '2013-11-01', '0');
INSERT INTO `lfy_seckill_access` VALUES ('1714', 'd19a3cdc71334e6d147e7d21cbe25a86', '1383287342', '2013-11-01', '0');
INSERT INTO `lfy_seckill_access` VALUES ('1715', 'd19a3cdc71334e6d147e7d21cbe25a86', '1383287375', '2013-11-01', '0');
INSERT INTO `lfy_seckill_access` VALUES ('1716', 'd19a3cdc71334e6d147e7d21cbe25a86', '1383528888', '2013-11-04', '0');

-- ----------------------------
-- Table structure for `lfy_seckill_duihuan`
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
INSERT INTO `lfy_seckill_duihuan` VALUES ('1', 'dfdf', '0', '0', '2013-09-09', '', '');
INSERT INTO `lfy_seckill_duihuan` VALUES ('5', '123456', '9', '1380509564', '2013-09-30', '', '');
INSERT INTO `lfy_seckill_duihuan` VALUES ('6', '1acf3b3c931e50ea84153f5374c868d4', '15', '1380509587', '2013-09-30', '', '');
INSERT INTO `lfy_seckill_duihuan` VALUES ('7', '123456', '12', '1380510859', '2013-09-30', '', '');
INSERT INTO `lfy_seckill_duihuan` VALUES ('8', '123456', '11', '1380510941', '2013-09-30', '窦子滨', '15940442002');
INSERT INTO `lfy_seckill_duihuan` VALUES ('9', '48b0c41d59750da652032c9c7652bde8', '16', '1382689014', '2013-10-25', '', '');

-- ----------------------------
-- Table structure for `lfy_seckill_goods`
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
-- Table structure for `lfy_seckill_record`
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
INSERT INTO `lfy_seckill_record` VALUES ('8', '123456', '1380178870', '2013-09-26', 'WYPQ3AVB73', '1', '1');
INSERT INTO `lfy_seckill_record` VALUES ('9', '123456', '1380265188', '2013-09-27', 'BN9U7TXXBW', '1', '1');
INSERT INTO `lfy_seckill_record` VALUES ('10', 'a538ff4e48f85884e820df1296fc9d35', '1380267062', '2013-09-27', 'KTD4V7X32H', '0', '1');
INSERT INTO `lfy_seckill_record` VALUES ('11', '123456', '1380267125', '2013-09-27', 'RGKH4MSFW6', '1', '3');
INSERT INTO `lfy_seckill_record` VALUES ('12', '123456', '1380267139', '2013-09-27', 'UEPSBYCUJH', '1', '3');
INSERT INTO `lfy_seckill_record` VALUES ('13', '8c041571fecd0ac29a0e3757ffd6b1b3', '1380267393', '2013-09-27', 'R9MCCFCU3J', '0', '1');
INSERT INTO `lfy_seckill_record` VALUES ('14', '123456', '1380270129', '2013-09-27', 'H5LRQA7W2L', '0', '3');
INSERT INTO `lfy_seckill_record` VALUES ('15', '1acf3b3c931e50ea84153f5374c868d4', '1380270621', '2013-09-27', '2XCAELYMAN', '1', '1');
INSERT INTO `lfy_seckill_record` VALUES ('16', '48b0c41d59750da652032c9c7652bde8', '1380271099', '2013-09-27', '63YNG892VU', '1', '1');

-- ----------------------------
-- Table structure for `lfy_sign_in`
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
-- Table structure for `lfy_sign_in_description`
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
-- Table structure for `lfy_sign_in_record`
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
INSERT INTO `lfy_sign_in_record` VALUES ('1', '1010', '1378262006', '2013-09-04', '2', '127.0.0.1');
INSERT INTO `lfy_sign_in_record` VALUES ('2', '1010', '1378262303', '2013-09-04', '2', '127.0.0.1');
INSERT INTO `lfy_sign_in_record` VALUES ('3', '1010', '1378262306', '2013-09-04', '2', '127.0.0.1');
INSERT INTO `lfy_sign_in_record` VALUES ('4', '1010', '1378689448', '2013-09-09', '2', '127.0.0.1');
INSERT INTO `lfy_sign_in_record` VALUES ('17', '1010', '1378793253', '2013-09-10', '2', '127.0.0.1');
INSERT INTO `lfy_sign_in_record` VALUES ('18', '123456', '1378794762', '2013-09-10', '2', '127.0.0.1');
INSERT INTO `lfy_sign_in_record` VALUES ('19', '123456', '1379834090', '2013-09-22', '2', '127.0.0.1');
INSERT INTO `lfy_sign_in_record` VALUES ('20', 'a538ff4e48f85884e820df1296fc9d35', '1379917885', '2013-09-23', '2', '192.168.0.189');
INSERT INTO `lfy_sign_in_record` VALUES ('21', '123456', '1380101798', '2013-09-25', '2', '127.0.0.1');

-- ----------------------------
-- Table structure for `lfy_sign_up`
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
-- Table structure for `lfy_subscribe`
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
-- Table structure for `lfy_unsubscrib`
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
-- Table structure for `lfy_user`
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
INSERT INTO `lfy_user` VALUES ('1', 'admin', '管理员', 'db69fc039dcbd2962cb4d28f5891aae1', '0', '127.0.0.1', '1385000140', '1', '1', '管理员');
INSERT INTO `lfy_user` VALUES ('10', '0101', '兑奖操作1', '3093ac5f0f832395bb4664d0625d747b', '1383203093', '', '0', '1', '1', '');

-- ----------------------------
-- Table structure for `lfy_weixin_menu`
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
-- Table structure for `lfy_weixin_user`
-- ----------------------------
DROP TABLE IF EXISTS `lfy_weixin_user`;
CREATE TABLE `lfy_weixin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `weixin_name` varchar(100) NOT NULL DEFAULT '' COMMENT '微信用户名(加密值)',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_date` date NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`),
  KEY `main` (`id`,`weixin_name`,`create_time`,`create_date`)
) ENGINE=MyISAM AUTO_INCREMENT=8601 DEFAULT CHARSET=utf8 COMMENT='微信关注用户记录';

-- ----------------------------
-- Records of lfy_weixin_user
-- ----------------------------
INSERT INTO `lfy_weixin_user` VALUES ('8600', '', '1384764919', '2013-11-18');

-- ----------------------------
-- Table structure for `lfy_zhiling`
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
