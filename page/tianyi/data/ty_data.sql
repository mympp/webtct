/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : ty_data

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-05-16 16:51:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ty_404
-- ----------------------------
DROP TABLE IF EXISTS `ty_404`;
CREATE TABLE `ty_404` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '',
  `refer` varchar(255) NOT NULL,
  `robot` varchar(20) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='404日志';

-- ----------------------------
-- Records of ty_404
-- ----------------------------

-- ----------------------------
-- Table structure for ty_ad
-- ----------------------------
DROP TABLE IF EXISTS `ty_ad`;
CREATE TABLE `ty_ad` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `typeid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` float NOT NULL DEFAULT '0',
  `currency` varchar(20) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `stat` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  `code` text NOT NULL,
  `text_name` varchar(100) NOT NULL DEFAULT '',
  `text_url` varchar(255) NOT NULL DEFAULT '',
  `text_title` varchar(100) NOT NULL DEFAULT '',
  `text_style` varchar(50) NOT NULL DEFAULT '',
  `image_src` varchar(255) NOT NULL DEFAULT '',
  `image_url` varchar(255) NOT NULL DEFAULT '',
  `image_alt` varchar(100) NOT NULL DEFAULT '',
  `flash_src` varchar(255) NOT NULL DEFAULT '',
  `flash_url` varchar(255) NOT NULL DEFAULT '',
  `flash_loop` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `key_moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `key_catid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `key_word` varchar(100) NOT NULL DEFAULT '',
  `key_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='广告';

-- ----------------------------
-- Records of ty_ad
-- ----------------------------
INSERT INTO `ty_ad` VALUES ('2', '网站首页图片轮播1', '14', '5', '0', '0', '', 'http://www.destoon.com/', '', '0', 'tianyi', '1467860142', 'tianyi', '1468385623', '1262275200', '1577894399', '0', '', '', '', '', '', '', 'http://www.tianyi.com/file/upload/201607/13/125340421.jpg', 'http://www.destoon.com/', '', '', '', '1', '0', '0', '', '0', '0', '3');
INSERT INTO `ty_ad` VALUES ('3', '首页旗帜A1', '20', '3', '0', '0', '', '', '', '0', 'tianyi', '1467860142', 'tianyi', '1467860142', '1262275200', '1577894399', '0', '', '', '', '', '', '', 'file/image/150x60.gif', '', '', '', '', '1', '0', '0', '', '0', '0', '3');
INSERT INTO `ty_ad` VALUES ('4', '首页旗帜A2', '21', '3', '0', '0', '', 'http://idc.destoon.com/', '', '0', 'tianyi', '1467860142', 'tianyi', '1467860142', '1262275200', '1577894399', '0', '', '', '', '', '', '', 'file/image/150x60.gif', '', '', '', '', '1', '0', '0', '', '0', '0', '3');
INSERT INTO `ty_ad` VALUES ('5', '首页旗帜A3', '22', '3', '0', '0', '', 'http://www.destoon.com/', '', '0', 'tianyi', '1467860142', 'tianyi', '1467860142', '1262275200', '1577894399', '0', '', '', '', '', '', '', 'file/image/150x60.gif', '', '', '', '', '1', '0', '0', '', '0', '0', '3');
INSERT INTO `ty_ad` VALUES ('6', '首页旗帜A4', '23', '3', '0', '0', '', 'http://idc.destoon.com/', '', '0', 'tianyi', '1467860142', 'tianyi', '1467860142', '1262275200', '1577894399', '0', '', '', '', '', '', '', 'file/image/150x60.gif', '', '', '', '', '1', '0', '0', '', '0', '0', '3');
INSERT INTO `ty_ad` VALUES ('7', '首页旗帜A5', '24', '3', '0', '0', '', 'http://www.destoon.com/', '', '0', 'tianyi', '1467860142', 'tianyi', '1467860142', '1262275200', '1577894399', '0', '', '', '', '', '', '', 'file/image/150x60.gif', '', '', '', '', '1', '0', '0', '', '0', '0', '3');
INSERT INTO `ty_ad` VALUES ('8', '首页旗帜A6', '25', '3', '0', '0', '', 'http://idc.destoon.com/', '', '0', 'tianyi', '1467860142', 'tianyi', '1467860142', '1262275200', '1577894399', '0', '', '', '', '', '', '', 'file/image/150x60.gif', '', '', '', '', '1', '0', '0', '', '0', '0', '3');
INSERT INTO `ty_ad` VALUES ('9', '网站首页图片轮播2', '14', '5', '0', '0', '', 'http://www.destoon.com/', '', '104', 'tianyi', '1467860142', 'tianyi', '1468385634', '1262275200', '1577894399', '0', '', '', '', '', '', '', 'http://www.tianyi.com/file/upload/201607/13/125353611.jpg', 'http://www.destoon.com/', '', '', '', '1', '0', '0', '', '0', '0', '3');

-- ----------------------------
-- Table structure for ty_address
-- ----------------------------
DROP TABLE IF EXISTS `ty_address`;
CREATE TABLE `ty_address` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `truename` varchar(30) NOT NULL DEFAULT '',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL DEFAULT '',
  `postcode` varchar(10) NOT NULL DEFAULT '',
  `telephone` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否默认地址0->否 1->是',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='收货地址';

-- ----------------------------
-- Records of ty_address
-- ----------------------------
INSERT INTO `ty_address` VALUES ('1', '水水水水', '84', '测试23123123123123132', '510100', '', '13789545521', 'xinxin', '1494489212', 'xinxin', '1494489272', '0', '', '0');
INSERT INTO `ty_address` VALUES ('2', '123123', '1', '213123', '510000', '', '13845696565', 'xinxin', '1494489333', 'xinxin', '1494489333', '0', '', '0');

-- ----------------------------
-- Table structure for ty_admin
-- ----------------------------
DROP TABLE IF EXISTS `ty_admin`;
CREATE TABLE `ty_admin` (
  `adminid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `file` varchar(20) NOT NULL DEFAULT '',
  `action` varchar(255) NOT NULL DEFAULT '',
  `catid` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Records of ty_admin
-- ----------------------------
INSERT INTO `ty_admin` VALUES ('1', '1', '0', '生成首页', '?action=html', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('2', '1', '0', '更新缓存', '?action=cache', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('3', '1', '0', '网站设置', '?file=setting', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('4', '1', '0', '模块管理', '?file=module', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('5', '1', '0', '数据维护', '?file=database', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('6', '1', '0', '模板管理', '?file=template', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('7', '1', '0', '会员管理', '?moduleid=2', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('8', '1', '0', '单页管理', '?moduleid=3&file=webpage', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('9', '1', '0', '排名推广', '?moduleid=3&file=spread', '', '0', '', '', '');
INSERT INTO `ty_admin` VALUES ('10', '1', '0', '广告管理', '?moduleid=3&file=ad', '', '0', '', '', '');

-- ----------------------------
-- Table structure for ty_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `ty_admin_log`;
CREATE TABLE `ty_admin_log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qstring` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `logtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理日志';

-- ----------------------------
-- Records of ty_admin_log
-- ----------------------------

-- ----------------------------
-- Table structure for ty_admin_online
-- ----------------------------
DROP TABLE IF EXISTS `ty_admin_online`;
CREATE TABLE `ty_admin_online` (
  `sid` varchar(32) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `qstring` varchar(255) NOT NULL DEFAULT '',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `sid` (`sid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='在线管理员';

-- ----------------------------
-- Records of ty_admin_online
-- ----------------------------
INSERT INTO `ty_admin_online` VALUES ('fst400deqshct21iuhghcj3rr7', 'tianyi', '127.0.0.1', '2', 'moduleid=2&action=login&userid=14', '1494923934');

-- ----------------------------
-- Table structure for ty_ad_place
-- ----------------------------
DROP TABLE IF EXISTS `ty_ad_place`;
CREATE TABLE `ty_ad_place` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `typeid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `open` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `code` text NOT NULL,
  `width` smallint(5) unsigned NOT NULL DEFAULT '0',
  `height` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` float unsigned NOT NULL DEFAULT '0',
  `ads` smallint(4) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `template` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='广告位';

-- ----------------------------
-- Records of ty_ad_place
-- ----------------------------
INSERT INTO `ty_ad_place` VALUES ('1', '5', '6', '1', '供应排名', '', '', '', '', '0', '0', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('2', '6', '6', '1', '求购排名', '', '', '', '', '0', '0', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('3', '16', '6', '1', '商城排名', '', '', '', '', '0', '0', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('4', '4', '6', '1', '公司排名', '', '', '', '', '0', '0', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('14', '0', '5', '1', '首页图片轮播', '', '', '', '', '400', '160', '0', '2', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('15', '5', '7', '1', '供应赞助商链接', '', '', '', '', '0', '0', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('17', '4', '7', '1', '公司赞助商链接', '', '', '', '', '0', '0', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('18', '0', '7', '1', '求购赞助商链接', '', '', '', '', '0', '0', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('19', '8', '7', '1', '展会赞助商链接', '', '', '', '', '0', '0', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('20', '0', '3', '1', '首页旗帜A1', '', '', '', '', '150', '60', '0', '1', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('21', '0', '3', '1', '首页旗帜A2', '', '', '', '', '150', '60', '0', '1', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('22', '0', '3', '1', '首页旗帜A3', '', '', '', '', '150', '60', '0', '1', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('23', '0', '3', '1', '首页旗帜A4', '', '', '', '', '150', '60', '0', '1', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('24', '0', '3', '1', '首页旗帜A5', '', '', '', '', '150', '60', '0', '1', '0', '1467860142', 'tianyi', '1467860142', '');
INSERT INTO `ty_ad_place` VALUES ('25', '0', '3', '1', '首页旗帜A6', '', '', '', '', '150', '60', '0', '1', '0', '1467860142', 'tianyi', '1467860142', '');

-- ----------------------------
-- Table structure for ty_alert
-- ----------------------------
DROP TABLE IF EXISTS `ty_alert`;
CREATE TABLE `ty_alert` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `word` varchar(100) NOT NULL DEFAULT '',
  `rate` smallint(4) unsigned NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '0',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='贸易提醒';

-- ----------------------------
-- Records of ty_alert
-- ----------------------------

-- ----------------------------
-- Table structure for ty_announce
-- ----------------------------
DROP TABLE IF EXISTS `ty_announce`;
CREATE TABLE `ty_announce` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `template` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公告';

-- ----------------------------
-- Records of ty_announce
-- ----------------------------

-- ----------------------------
-- Table structure for ty_area
-- ----------------------------
DROP TABLE IF EXISTS `ty_area`;
CREATE TABLE `ty_area` (
  `areaid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `areaname` varchar(50) NOT NULL DEFAULT '',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL DEFAULT '',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` varchar(1000) NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `resumecount` int(10) DEFAULT '0',
  `jobcount` int(10) DEFAULT '0',
  PRIMARY KEY (`areaid`)
) ENGINE=MyISAM AUTO_INCREMENT=392 DEFAULT CHARSET=utf8 COMMENT='地区';

-- ----------------------------
-- Records of ty_area
-- ----------------------------
INSERT INTO `ty_area` VALUES ('1', '北京', '0', '0', '0', '1', '1', '687', '588');
INSERT INTO `ty_area` VALUES ('2', '上海', '0', '0', '0', '2', '2', '341', '280');
INSERT INTO `ty_area` VALUES ('3', '天津', '0', '0', '0', '3', '3', '66', '146');
INSERT INTO `ty_area` VALUES ('4', '重庆', '0', '0', '0', '4', '4', '167', '308');
INSERT INTO `ty_area` VALUES ('5', '河北', '0', '0', '1', '5,35,36,37,38,39,40,41,42,43,44,45', '5', '246', '395');
INSERT INTO `ty_area` VALUES ('6', '山西', '0', '0', '1', '6,46,47,48,49,50,51,52,53,54,55,56', '6', '114', '154');
INSERT INTO `ty_area` VALUES ('7', '内蒙古', '0', '0', '1', '7,57,58,59,60,61,62,63,64,65,66,67,68', '7', '81', '82');
INSERT INTO `ty_area` VALUES ('8', '辽宁', '0', '0', '1', '8,69,70,71,72,73,74,75,76,77,78,79,80,81,82', '8', '226', '183');
INSERT INTO `ty_area` VALUES ('9', '吉林', '0', '0', '1', '9,83,84,85,86,87,88,89,90,91', '9', '80', '105');
INSERT INTO `ty_area` VALUES ('10', '黑龙江', '0', '0', '1', '10,92,93,94,95,96,97,98,99,100,101,102,103,104', '10', '126', '132');
INSERT INTO `ty_area` VALUES ('11', '江苏', '0', '0', '1', '11,105,106,107,108,109,110,111,112,113,114,115,116,117', '11', '596', '474');
INSERT INTO `ty_area` VALUES ('12', '浙江', '0', '0', '1', '12,118,119,120,121,122,123,124,125,126,127,128', '12', '304', '226');
INSERT INTO `ty_area` VALUES ('13', '安徽', '0', '0', '1', '13,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145', '13', '164', '291');
INSERT INTO `ty_area` VALUES ('14', '福建', '0', '0', '1', '14,146,147,148,149,150,151,152,153,154', '14', '316', '208');
INSERT INTO `ty_area` VALUES ('15', '江西', '0', '0', '1', '15,155,156,157,158,159,160,161,162,163,164,165', '15', '230', '202');
INSERT INTO `ty_area` VALUES ('16', '山东', '0', '0', '1', '16,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182', '16', '489', '467');
INSERT INTO `ty_area` VALUES ('17', '河南', '0', '0', '1', '17,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199', '17', '373', '571');
INSERT INTO `ty_area` VALUES ('18', '湖北', '0', '0', '1', '18,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216', '18', '342', '242');
INSERT INTO `ty_area` VALUES ('19', '湖南', '0', '0', '1', '19,217,218,219,220,221,222,223,224,225,226,227,228,229,230', '19', '446', '452');
INSERT INTO `ty_area` VALUES ('20', '广东', '0', '0', '1', '20,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251', '20', '2367', '5590');
INSERT INTO `ty_area` VALUES ('21', '广西', '0', '0', '1', '21,252,253,254,255,256,257,258,259,260,261,262,263,264,265', '21', '171', '116');
INSERT INTO `ty_area` VALUES ('22', '海南', '0', '0', '1', '22,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283', '22', '752', '52');
INSERT INTO `ty_area` VALUES ('23', '四川', '0', '0', '1', '23,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304', '23', '484', '552');
INSERT INTO `ty_area` VALUES ('24', '贵州', '0', '0', '1', '24,305,306,307,308,309,310,311,312,313', '24', '118', '69');
INSERT INTO `ty_area` VALUES ('25', '云南', '0', '0', '1', '25,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329', '25', '251', '181');
INSERT INTO `ty_area` VALUES ('26', '西藏', '0', '0', '1', '26,330,331,332,333,334,335,336', '26', '7', '12');
INSERT INTO `ty_area` VALUES ('27', '陕西', '0', '0', '1', '27,337,338,339,340,341,342,343,344,345,346', '27', '240', '253');
INSERT INTO `ty_area` VALUES ('28', '甘肃', '0', '0', '1', '28,347,348,349,350,351,352,353,354,355,356,357,358,359,360', '28', '57', '74');
INSERT INTO `ty_area` VALUES ('29', '青海', '0', '0', '1', '29,361,362,363,364,365,366,367,368', '29', '8', '21');
INSERT INTO `ty_area` VALUES ('30', '宁夏', '0', '0', '1', '30,369,370,371,372,373', '30', '24', '19');
INSERT INTO `ty_area` VALUES ('31', '新疆', '0', '0', '1', '31,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,390,391', '31', '77', '34');
INSERT INTO `ty_area` VALUES ('32', '台湾', '0', '0', '0', '32', '32', '1', '3');
INSERT INTO `ty_area` VALUES ('33', '香港', '0', '0', '0', '33', '33', '2', '10');
INSERT INTO `ty_area` VALUES ('34', '澳门', '0', '0', '0', '34', '34', '5', '10');
INSERT INTO `ty_area` VALUES ('35', '石家庄市', '5', '0,5', '0', '35', '35', '43', '5');
INSERT INTO `ty_area` VALUES ('36', '唐山市', '5', '0,5', '0', '36', '36', '9', '2');
INSERT INTO `ty_area` VALUES ('37', '秦皇岛市', '5', '0,5', '0', '37', '37', '4', '1');
INSERT INTO `ty_area` VALUES ('38', '邯郸市', '5', '0,5', '0', '38', '38', '8', '2');
INSERT INTO `ty_area` VALUES ('39', '邢台市', '5', '0,5', '0', '39', '39', '3', '0');
INSERT INTO `ty_area` VALUES ('40', '保定市', '5', '0,5', '0', '40', '40', '12', '0');
INSERT INTO `ty_area` VALUES ('41', '张家口市', '5', '0,5', '0', '41', '41', '4', '1');
INSERT INTO `ty_area` VALUES ('42', '承德市', '5', '0,5', '0', '42', '42', '0', '0');
INSERT INTO `ty_area` VALUES ('43', '沧州市', '5', '0,5', '0', '43', '43', '7', '3');
INSERT INTO `ty_area` VALUES ('44', '廊坊市', '5', '0,5', '0', '44', '44', '5', '0');
INSERT INTO `ty_area` VALUES ('45', '衡水市', '5', '0,5', '0', '45', '45', '6', '0');
INSERT INTO `ty_area` VALUES ('46', '太原市', '6', '0,6', '0', '46', '46', '23', '4');
INSERT INTO `ty_area` VALUES ('47', '大同市', '6', '0,6', '0', '47', '47', '2', '0');
INSERT INTO `ty_area` VALUES ('48', '阳泉市', '6', '0,6', '0', '48', '48', '0', '0');
INSERT INTO `ty_area` VALUES ('49', '长治市', '6', '0,6', '0', '49', '49', '3', '0');
INSERT INTO `ty_area` VALUES ('50', '晋城市', '6', '0,6', '0', '50', '50', '0', '0');
INSERT INTO `ty_area` VALUES ('51', '朔州市', '6', '0,6', '0', '51', '51', '0', '0');
INSERT INTO `ty_area` VALUES ('52', '晋中市', '6', '0,6', '0', '52', '52', '2', '0');
INSERT INTO `ty_area` VALUES ('53', '运城市', '6', '0,6', '0', '53', '53', '7', '1');
INSERT INTO `ty_area` VALUES ('54', '忻州市', '6', '0,6', '0', '54', '54', '1', '4');
INSERT INTO `ty_area` VALUES ('55', '临汾市', '6', '0,6', '0', '55', '55', '5', '0');
INSERT INTO `ty_area` VALUES ('56', '吕梁市', '6', '0,6', '0', '56', '56', '3', '1');
INSERT INTO `ty_area` VALUES ('57', '呼和浩特市', '7', '0,7', '0', '57', '57', '9', '0');
INSERT INTO `ty_area` VALUES ('58', '包头市', '7', '0,7', '0', '58', '58', '2', '0');
INSERT INTO `ty_area` VALUES ('59', '乌海市', '7', '0,7', '0', '59', '59', '2', '0');
INSERT INTO `ty_area` VALUES ('60', '赤峰市', '7', '0,7', '0', '60', '60', '4', '1');
INSERT INTO `ty_area` VALUES ('61', '通辽市', '7', '0,7', '0', '61', '61', '1', '0');
INSERT INTO `ty_area` VALUES ('62', '鄂尔多斯市', '7', '0,7', '0', '62', '62', '0', '0');
INSERT INTO `ty_area` VALUES ('63', '呼伦贝尔市', '7', '0,7', '0', '63', '63', '1', '0');
INSERT INTO `ty_area` VALUES ('64', '巴彦淖尔市', '7', '0,7', '0', '64', '64', '1', '0');
INSERT INTO `ty_area` VALUES ('65', '乌兰察布市', '7', '0,7', '0', '65', '65', '1', '0');
INSERT INTO `ty_area` VALUES ('66', '兴安盟', '7', '0,7', '0', '66', '66', '1', '0');
INSERT INTO `ty_area` VALUES ('67', '锡林郭勒盟', '7', '0,7', '0', '67', '67', '0', '0');
INSERT INTO `ty_area` VALUES ('68', '阿拉善盟', '7', '0,7', '0', '68', '68', '0', '0');
INSERT INTO `ty_area` VALUES ('69', '沈阳市', '8', '0,8', '0', '69', '69', '39', '28');
INSERT INTO `ty_area` VALUES ('70', '大连市', '8', '0,8', '0', '70', '70', '14', '7');
INSERT INTO `ty_area` VALUES ('71', '鞍山市', '8', '0,8', '0', '71', '71', '8', '0');
INSERT INTO `ty_area` VALUES ('72', '抚顺市', '8', '0,8', '0', '72', '72', '1', '0');
INSERT INTO `ty_area` VALUES ('73', '本溪市', '8', '0,8', '0', '73', '73', '0', '4');
INSERT INTO `ty_area` VALUES ('74', '丹东市', '8', '0,8', '0', '74', '74', '0', '0');
INSERT INTO `ty_area` VALUES ('75', '锦州市', '8', '0,8', '0', '75', '75', '1', '0');
INSERT INTO `ty_area` VALUES ('76', '营口市', '8', '0,8', '0', '76', '76', '0', '0');
INSERT INTO `ty_area` VALUES ('77', '阜新市', '8', '0,8', '0', '77', '77', '0', '0');
INSERT INTO `ty_area` VALUES ('78', '辽阳市', '8', '0,8', '0', '78', '78', '0', '0');
INSERT INTO `ty_area` VALUES ('79', '盘锦市', '8', '0,8', '0', '79', '79', '0', '0');
INSERT INTO `ty_area` VALUES ('80', '铁岭市', '8', '0,8', '0', '80', '80', '0', '0');
INSERT INTO `ty_area` VALUES ('81', '朝阳市', '8', '0,8', '0', '81', '81', '1', '4');
INSERT INTO `ty_area` VALUES ('82', '葫芦岛市', '8', '0,8', '0', '82', '82', '0', '0');
INSERT INTO `ty_area` VALUES ('83', '长春市', '9', '0,9', '0', '83', '83', '17', '1');
INSERT INTO `ty_area` VALUES ('84', '吉林市', '9', '0,9', '0', '84', '84', '4', '1');
INSERT INTO `ty_area` VALUES ('85', '四平市', '9', '0,9', '0', '85', '85', '1', '1');
INSERT INTO `ty_area` VALUES ('86', '辽源市', '9', '0,9', '0', '86', '86', '1', '0');
INSERT INTO `ty_area` VALUES ('87', '通化市', '9', '0,9', '0', '87', '87', '0', '0');
INSERT INTO `ty_area` VALUES ('88', '白山市', '9', '0,9', '0', '88', '88', '1', '0');
INSERT INTO `ty_area` VALUES ('89', '松原市', '9', '0,9', '0', '89', '89', '2', '0');
INSERT INTO `ty_area` VALUES ('90', '白城市', '9', '0,9', '0', '90', '90', '1', '0');
INSERT INTO `ty_area` VALUES ('91', '延边朝鲜族自治州', '9', '0,9', '0', '91', '91', '1', '0');
INSERT INTO `ty_area` VALUES ('92', '哈尔滨市', '10', '0,10', '0', '92', '92', '27', '2');
INSERT INTO `ty_area` VALUES ('93', '齐齐哈尔市', '10', '0,10', '0', '93', '93', '9', '0');
INSERT INTO `ty_area` VALUES ('94', '鸡西市', '10', '0,10', '0', '94', '94', '2', '0');
INSERT INTO `ty_area` VALUES ('95', '鹤岗市', '10', '0,10', '0', '95', '95', '0', '0');
INSERT INTO `ty_area` VALUES ('96', '双鸭山市', '10', '0,10', '0', '96', '96', '0', '0');
INSERT INTO `ty_area` VALUES ('97', '大庆市', '10', '0,10', '0', '97', '97', '6', '0');
INSERT INTO `ty_area` VALUES ('98', '伊春市', '10', '0,10', '0', '98', '98', '1', '0');
INSERT INTO `ty_area` VALUES ('99', '佳木斯市', '10', '0,10', '0', '99', '99', '0', '0');
INSERT INTO `ty_area` VALUES ('100', '七台河市', '10', '0,10', '0', '100', '100', '0', '0');
INSERT INTO `ty_area` VALUES ('101', '牡丹江市', '10', '0,10', '0', '101', '101', '0', '0');
INSERT INTO `ty_area` VALUES ('102', '黑河市', '10', '0,10', '0', '102', '102', '0', '0');
INSERT INTO `ty_area` VALUES ('103', '绥化市', '10', '0,10', '0', '103', '103', '1', '0');
INSERT INTO `ty_area` VALUES ('104', '大兴安岭地区', '10', '0,10', '0', '104', '104', '1', '0');
INSERT INTO `ty_area` VALUES ('105', '南京市', '11', '0,11', '0', '105', '105', '78', '9');
INSERT INTO `ty_area` VALUES ('106', '无锡市', '11', '0,11', '0', '106', '106', '23', '0');
INSERT INTO `ty_area` VALUES ('107', '徐州市', '11', '0,11', '0', '107', '107', '34', '1');
INSERT INTO `ty_area` VALUES ('108', '常州市', '11', '0,11', '0', '108', '108', '11', '3');
INSERT INTO `ty_area` VALUES ('109', '苏州市', '11', '0,11', '0', '109', '109', '33', '2');
INSERT INTO `ty_area` VALUES ('110', '南通市', '11', '0,11', '0', '110', '110', '11', '1');
INSERT INTO `ty_area` VALUES ('111', '连云港市', '11', '0,11', '0', '111', '111', '6', '0');
INSERT INTO `ty_area` VALUES ('112', '淮安市', '11', '0,11', '0', '112', '112', '4', '0');
INSERT INTO `ty_area` VALUES ('113', '盐城市', '11', '0,11', '0', '113', '113', '8', '0');
INSERT INTO `ty_area` VALUES ('114', '扬州市', '11', '0,11', '0', '114', '114', '6', '0');
INSERT INTO `ty_area` VALUES ('115', '镇江市', '11', '0,11', '0', '115', '115', '3', '1');
INSERT INTO `ty_area` VALUES ('116', '泰州市', '11', '0,11', '0', '116', '116', '12', '3');
INSERT INTO `ty_area` VALUES ('117', '宿迁市', '11', '0,11', '0', '117', '117', '1', '0');
INSERT INTO `ty_area` VALUES ('118', '杭州市', '12', '0,12', '0', '118', '118', '47', '6');
INSERT INTO `ty_area` VALUES ('119', '宁波市', '12', '0,12', '0', '119', '119', '15', '1');
INSERT INTO `ty_area` VALUES ('120', '温州市', '12', '0,12', '0', '120', '120', '10', '0');
INSERT INTO `ty_area` VALUES ('121', '嘉兴市', '12', '0,12', '0', '121', '121', '9', '1');
INSERT INTO `ty_area` VALUES ('122', '湖州市', '12', '0,12', '0', '122', '122', '2', '1');
INSERT INTO `ty_area` VALUES ('123', '绍兴市', '12', '0,12', '0', '123', '123', '3', '1');
INSERT INTO `ty_area` VALUES ('124', '金华市', '12', '0,12', '0', '124', '124', '4', '3');
INSERT INTO `ty_area` VALUES ('125', '衢州市', '12', '0,12', '0', '125', '125', '2', '2');
INSERT INTO `ty_area` VALUES ('126', '舟山市', '12', '0,12', '0', '126', '126', '2', '1');
INSERT INTO `ty_area` VALUES ('127', '台州市', '12', '0,12', '0', '127', '127', '4', '1');
INSERT INTO `ty_area` VALUES ('128', '丽水市', '12', '0,12', '0', '128', '128', '1', '0');
INSERT INTO `ty_area` VALUES ('129', '合肥市', '13', '0,13', '0', '129', '129', '50', '8');
INSERT INTO `ty_area` VALUES ('130', '芜湖市', '13', '0,13', '0', '130', '130', '3', '1');
INSERT INTO `ty_area` VALUES ('131', '蚌埠市', '13', '0,13', '0', '131', '131', '3', '4');
INSERT INTO `ty_area` VALUES ('132', '淮南市', '13', '0,13', '0', '132', '132', '1', '0');
INSERT INTO `ty_area` VALUES ('133', '马鞍山市', '13', '0,13', '0', '133', '133', '1', '0');
INSERT INTO `ty_area` VALUES ('134', '淮北市', '13', '0,13', '0', '134', '134', '2', '1');
INSERT INTO `ty_area` VALUES ('135', '铜陵市', '13', '0,13', '0', '135', '135', '0', '1');
INSERT INTO `ty_area` VALUES ('136', '安庆市', '13', '0,13', '0', '136', '136', '1', '0');
INSERT INTO `ty_area` VALUES ('137', '黄山市', '13', '0,13', '0', '137', '137', '0', '0');
INSERT INTO `ty_area` VALUES ('138', '滁州市', '13', '0,13', '0', '138', '138', '2', '3');
INSERT INTO `ty_area` VALUES ('139', '阜阳市', '13', '0,13', '0', '139', '139', '6', '1');
INSERT INTO `ty_area` VALUES ('140', '宿州市', '13', '0,13', '0', '140', '140', '1', '1');
INSERT INTO `ty_area` VALUES ('141', '巢湖市', '13', '0,13', '0', '141', '141', '1', '0');
INSERT INTO `ty_area` VALUES ('142', '六安市', '13', '0,13', '0', '142', '142', '2', '0');
INSERT INTO `ty_area` VALUES ('143', '亳州市', '13', '0,13', '0', '143', '143', '0', '0');
INSERT INTO `ty_area` VALUES ('144', '池州市', '13', '0,13', '0', '144', '144', '0', '1');
INSERT INTO `ty_area` VALUES ('145', '宣城市', '13', '0,13', '0', '145', '145', '1', '3');
INSERT INTO `ty_area` VALUES ('146', '福州市', '14', '0,14', '0', '146', '146', '29', '2');
INSERT INTO `ty_area` VALUES ('147', '厦门市', '14', '0,14', '0', '147', '147', '13', '0');
INSERT INTO `ty_area` VALUES ('148', '莆田市', '14', '0,14', '0', '148', '148', '13', '6');
INSERT INTO `ty_area` VALUES ('149', '三明市', '14', '0,14', '0', '149', '149', '5', '0');
INSERT INTO `ty_area` VALUES ('150', '泉州市', '14', '0,14', '0', '150', '150', '8', '2');
INSERT INTO `ty_area` VALUES ('151', '漳州市', '14', '0,14', '0', '151', '151', '3', '2');
INSERT INTO `ty_area` VALUES ('152', '南平市', '14', '0,14', '0', '152', '152', '4', '0');
INSERT INTO `ty_area` VALUES ('153', '龙岩市', '14', '0,14', '0', '153', '153', '2', '4');
INSERT INTO `ty_area` VALUES ('154', '宁德市', '14', '0,14', '0', '154', '154', '2', '4');
INSERT INTO `ty_area` VALUES ('155', '南昌市', '15', '0,15', '0', '155', '155', '46', '8');
INSERT INTO `ty_area` VALUES ('156', '景德镇市', '15', '0,15', '0', '156', '156', '1', '0');
INSERT INTO `ty_area` VALUES ('157', '萍乡市', '15', '0,15', '0', '157', '157', '2', '0');
INSERT INTO `ty_area` VALUES ('158', '九江市', '15', '0,15', '0', '158', '158', '3', '2');
INSERT INTO `ty_area` VALUES ('159', '新余市', '15', '0,15', '0', '159', '159', '0', '2');
INSERT INTO `ty_area` VALUES ('160', '鹰潭市', '15', '0,15', '0', '160', '160', '1', '0');
INSERT INTO `ty_area` VALUES ('161', '赣州市', '15', '0,15', '0', '161', '161', '6', '3');
INSERT INTO `ty_area` VALUES ('162', '吉安市', '15', '0,15', '0', '162', '162', '5', '3');
INSERT INTO `ty_area` VALUES ('163', '宜春市', '15', '0,15', '0', '163', '163', '2', '2');
INSERT INTO `ty_area` VALUES ('164', '抚州市', '15', '0,15', '0', '164', '164', '3', '0');
INSERT INTO `ty_area` VALUES ('165', '上饶市', '15', '0,15', '0', '165', '165', '2', '0');
INSERT INTO `ty_area` VALUES ('166', '济南市', '16', '0,16', '0', '166', '166', '55', '4');
INSERT INTO `ty_area` VALUES ('167', '青岛市', '16', '0,16', '0', '167', '167', '22', '6');
INSERT INTO `ty_area` VALUES ('168', '淄博市', '16', '0,16', '0', '168', '168', '12', '0');
INSERT INTO `ty_area` VALUES ('169', '枣庄市', '16', '0,16', '0', '169', '169', '3', '2');
INSERT INTO `ty_area` VALUES ('170', '东营市', '16', '0,16', '0', '170', '170', '1', '0');
INSERT INTO `ty_area` VALUES ('171', '烟台市', '16', '0,16', '0', '171', '171', '7', '3');
INSERT INTO `ty_area` VALUES ('172', '潍坊市', '16', '0,16', '0', '172', '172', '11', '3');
INSERT INTO `ty_area` VALUES ('173', '济宁市', '16', '0,16', '0', '173', '173', '14', '0');
INSERT INTO `ty_area` VALUES ('174', '泰安市', '16', '0,16', '0', '174', '174', '8', '1');
INSERT INTO `ty_area` VALUES ('175', '威海市', '16', '0,16', '0', '175', '175', '7', '0');
INSERT INTO `ty_area` VALUES ('176', '日照市', '16', '0,16', '0', '176', '176', '2', '1');
INSERT INTO `ty_area` VALUES ('177', '莱芜市', '16', '0,16', '0', '177', '177', '2', '0');
INSERT INTO `ty_area` VALUES ('178', '临沂市', '16', '0,16', '0', '178', '178', '3', '1');
INSERT INTO `ty_area` VALUES ('179', '德州市', '16', '0,16', '0', '179', '179', '4', '0');
INSERT INTO `ty_area` VALUES ('180', '聊城市', '16', '0,16', '0', '180', '180', '4', '2');
INSERT INTO `ty_area` VALUES ('181', '滨州市', '16', '0,16', '0', '181', '181', '0', '1');
INSERT INTO `ty_area` VALUES ('182', '荷泽市', '16', '0,16', '0', '182', '182', '5', '0');
INSERT INTO `ty_area` VALUES ('183', '郑州市', '17', '0,17', '0', '183', '183', '87', '11');
INSERT INTO `ty_area` VALUES ('184', '开封市', '17', '0,17', '0', '184', '184', '5', '0');
INSERT INTO `ty_area` VALUES ('185', '洛阳市', '17', '0,17', '0', '185', '185', '10', '1');
INSERT INTO `ty_area` VALUES ('186', '平顶山市', '17', '0,17', '0', '186', '186', '1', '0');
INSERT INTO `ty_area` VALUES ('187', '安阳市', '17', '0,17', '0', '187', '187', '2', '0');
INSERT INTO `ty_area` VALUES ('188', '鹤壁市', '17', '0,17', '0', '188', '188', '2', '1');
INSERT INTO `ty_area` VALUES ('189', '新乡市', '17', '0,17', '0', '189', '189', '7', '4');
INSERT INTO `ty_area` VALUES ('190', '焦作市', '17', '0,17', '0', '190', '190', '2', '4');
INSERT INTO `ty_area` VALUES ('191', '濮阳市', '17', '0,17', '0', '191', '191', '2', '1');
INSERT INTO `ty_area` VALUES ('192', '许昌市', '17', '0,17', '0', '192', '192', '1', '0');
INSERT INTO `ty_area` VALUES ('193', '漯河市', '17', '0,17', '0', '193', '193', '4', '1');
INSERT INTO `ty_area` VALUES ('194', '三门峡市', '17', '0,17', '0', '194', '194', '1', '0');
INSERT INTO `ty_area` VALUES ('195', '南阳市', '17', '0,17', '0', '195', '195', '7', '5');
INSERT INTO `ty_area` VALUES ('196', '商丘市', '17', '0,17', '0', '196', '196', '3', '1');
INSERT INTO `ty_area` VALUES ('197', '信阳市', '17', '0,17', '0', '197', '197', '1', '5');
INSERT INTO `ty_area` VALUES ('198', '周口市', '17', '0,17', '0', '198', '198', '1', '5');
INSERT INTO `ty_area` VALUES ('199', '驻马店市', '17', '0,17', '0', '199', '199', '0', '1');
INSERT INTO `ty_area` VALUES ('200', '武汉市', '18', '0,18', '0', '200', '200', '86', '3');
INSERT INTO `ty_area` VALUES ('201', '黄石市', '18', '0,18', '0', '201', '201', '1', '2');
INSERT INTO `ty_area` VALUES ('202', '十堰市', '18', '0,18', '0', '202', '202', '2', '0');
INSERT INTO `ty_area` VALUES ('203', '宜昌市', '18', '0,18', '0', '203', '203', '4', '1');
INSERT INTO `ty_area` VALUES ('204', '襄樊市', '18', '0,18', '0', '204', '204', '1', '0');
INSERT INTO `ty_area` VALUES ('205', '鄂州市', '18', '0,18', '0', '205', '205', '0', '1');
INSERT INTO `ty_area` VALUES ('206', '荆门市', '18', '0,18', '0', '206', '206', '1', '0');
INSERT INTO `ty_area` VALUES ('207', '孝感市', '18', '0,18', '0', '207', '207', '1', '0');
INSERT INTO `ty_area` VALUES ('208', '荆州市', '18', '0,18', '0', '208', '208', '2', '0');
INSERT INTO `ty_area` VALUES ('209', '黄冈市', '18', '0,18', '0', '209', '209', '4', '0');
INSERT INTO `ty_area` VALUES ('210', '咸宁市', '18', '0,18', '0', '210', '210', '1', '0');
INSERT INTO `ty_area` VALUES ('211', '随州市', '18', '0,18', '0', '211', '211', '1', '0');
INSERT INTO `ty_area` VALUES ('212', '恩施土家族苗族自治州', '18', '0,18', '0', '212', '212', '2', '0');
INSERT INTO `ty_area` VALUES ('213', '仙桃市', '18', '0,18', '0', '213', '213', '1', '1');
INSERT INTO `ty_area` VALUES ('214', '潜江市', '18', '0,18', '0', '214', '214', '1', '0');
INSERT INTO `ty_area` VALUES ('215', '天门市', '18', '0,18', '0', '215', '215', '1', '1');
INSERT INTO `ty_area` VALUES ('216', '神农架林区', '18', '0,18', '0', '216', '216', '0', '0');
INSERT INTO `ty_area` VALUES ('217', '长沙市', '19', '0,19', '0', '217', '217', '73', '5');
INSERT INTO `ty_area` VALUES ('218', '株洲市', '19', '0,19', '0', '218', '218', '5', '1');
INSERT INTO `ty_area` VALUES ('219', '湘潭市', '19', '0,19', '0', '219', '219', '5', '1');
INSERT INTO `ty_area` VALUES ('220', '衡阳市', '19', '0,19', '0', '220', '220', '8', '4');
INSERT INTO `ty_area` VALUES ('221', '邵阳市', '19', '0,19', '0', '221', '221', '8', '2');
INSERT INTO `ty_area` VALUES ('222', '岳阳市', '19', '0,19', '0', '222', '222', '3', '2');
INSERT INTO `ty_area` VALUES ('223', '常德市', '19', '0,19', '0', '223', '223', '3', '3');
INSERT INTO `ty_area` VALUES ('224', '张家界市', '19', '0,19', '0', '224', '224', '0', '1');
INSERT INTO `ty_area` VALUES ('225', '益阳市', '19', '0,19', '0', '225', '225', '1', '1');
INSERT INTO `ty_area` VALUES ('226', '郴州市', '19', '0,19', '0', '226', '226', '1', '2');
INSERT INTO `ty_area` VALUES ('227', '永州市', '19', '0,19', '0', '227', '227', '4', '1');
INSERT INTO `ty_area` VALUES ('228', '怀化市', '19', '0,19', '0', '228', '228', '5', '0');
INSERT INTO `ty_area` VALUES ('229', '娄底市', '19', '0,19', '0', '229', '229', '2', '1');
INSERT INTO `ty_area` VALUES ('230', '湘西土家族苗族自治州', '19', '0,19', '0', '230', '230', '0', '0');
INSERT INTO `ty_area` VALUES ('231', '广州市', '20', '0,20', '0', '231', '231', '322', '117');
INSERT INTO `ty_area` VALUES ('232', '韶关市', '20', '0,20', '0', '232', '232', '3', '2');
INSERT INTO `ty_area` VALUES ('233', '深圳市', '20', '0,20', '0', '233', '233', '251', '15');
INSERT INTO `ty_area` VALUES ('234', '珠海市', '20', '0,20', '0', '234', '234', '29', '0');
INSERT INTO `ty_area` VALUES ('235', '汕头市', '20', '0,20', '0', '235', '235', '6', '0');
INSERT INTO `ty_area` VALUES ('236', '佛山市', '20', '0,20', '0', '236', '236', '11', '4');
INSERT INTO `ty_area` VALUES ('237', '江门市', '20', '0,20', '0', '237', '237', '4', '1');
INSERT INTO `ty_area` VALUES ('238', '湛江市', '20', '0,20', '0', '238', '238', '9', '2');
INSERT INTO `ty_area` VALUES ('239', '茂名市', '20', '0,20', '0', '239', '239', '8', '2');
INSERT INTO `ty_area` VALUES ('240', '肇庆市', '20', '0,20', '0', '240', '240', '2', '0');
INSERT INTO `ty_area` VALUES ('241', '惠州市', '20', '0,20', '0', '241', '241', '16', '4');
INSERT INTO `ty_area` VALUES ('242', '梅州市', '20', '0,20', '0', '242', '242', '8', '0');
INSERT INTO `ty_area` VALUES ('243', '汕尾市', '20', '0,20', '0', '243', '243', '1', '0');
INSERT INTO `ty_area` VALUES ('244', '河源市', '20', '0,20', '0', '244', '244', '1', '1');
INSERT INTO `ty_area` VALUES ('245', '阳江市', '20', '0,20', '0', '245', '245', '0', '0');
INSERT INTO `ty_area` VALUES ('246', '清远市', '20', '0,20', '0', '246', '246', '3', '4');
INSERT INTO `ty_area` VALUES ('247', '东莞市', '20', '0,20', '0', '247', '247', '34', '6');
INSERT INTO `ty_area` VALUES ('248', '中山市', '20', '0,20', '0', '248', '248', '16', '5');
INSERT INTO `ty_area` VALUES ('249', '潮州市', '20', '0,20', '0', '249', '249', '5', '1');
INSERT INTO `ty_area` VALUES ('250', '揭阳市', '20', '0,20', '0', '250', '250', '2', '0');
INSERT INTO `ty_area` VALUES ('251', '云浮市', '20', '0,20', '0', '251', '251', '3', '1');
INSERT INTO `ty_area` VALUES ('252', '南宁市', '21', '0,21', '0', '252', '252', '30', '1');
INSERT INTO `ty_area` VALUES ('253', '柳州市', '21', '0,21', '0', '253', '253', '5', '2');
INSERT INTO `ty_area` VALUES ('254', '桂林市', '21', '0,21', '0', '254', '254', '8', '5');
INSERT INTO `ty_area` VALUES ('255', '梧州市', '21', '0,21', '0', '255', '255', '2', '1');
INSERT INTO `ty_area` VALUES ('256', '北海市', '21', '0,21', '0', '256', '256', '1', '0');
INSERT INTO `ty_area` VALUES ('257', '防城港市', '21', '0,21', '0', '257', '257', '0', '0');
INSERT INTO `ty_area` VALUES ('258', '钦州市', '21', '0,21', '0', '258', '258', '0', '3');
INSERT INTO `ty_area` VALUES ('259', '贵港市', '21', '0,21', '0', '259', '259', '0', '1');
INSERT INTO `ty_area` VALUES ('260', '玉林市', '21', '0,21', '0', '260', '260', '2', '0');
INSERT INTO `ty_area` VALUES ('261', '百色市', '21', '0,21', '0', '261', '261', '0', '0');
INSERT INTO `ty_area` VALUES ('262', '贺州市', '21', '0,21', '0', '262', '262', '0', '1');
INSERT INTO `ty_area` VALUES ('263', '河池市', '21', '0,21', '0', '263', '263', '0', '0');
INSERT INTO `ty_area` VALUES ('264', '来宾市', '21', '0,21', '0', '264', '264', '0', '0');
INSERT INTO `ty_area` VALUES ('265', '崇左市', '21', '0,21', '0', '265', '265', '0', '0');
INSERT INTO `ty_area` VALUES ('266', '海口市', '22', '0,22', '0', '266', '266', '5', '0');
INSERT INTO `ty_area` VALUES ('267', '三亚市', '22', '0,22', '0', '267', '267', '0', '1');
INSERT INTO `ty_area` VALUES ('268', '五指山市', '22', '0,22', '0', '268', '268', '0', '0');
INSERT INTO `ty_area` VALUES ('269', '琼海市', '22', '0,22', '0', '269', '269', '1', '0');
INSERT INTO `ty_area` VALUES ('270', '儋州市', '22', '0,22', '0', '270', '270', '0', '0');
INSERT INTO `ty_area` VALUES ('271', '文昌市', '22', '0,22', '0', '271', '271', '0', '0');
INSERT INTO `ty_area` VALUES ('272', '万宁市', '22', '0,22', '0', '272', '272', '0', '0');
INSERT INTO `ty_area` VALUES ('273', '东方市', '22', '0,22', '0', '273', '273', '0', '0');
INSERT INTO `ty_area` VALUES ('274', '定安县', '22', '0,22', '0', '274', '274', '0', '0');
INSERT INTO `ty_area` VALUES ('275', '屯昌县', '22', '0,22', '0', '275', '275', '0', '0');
INSERT INTO `ty_area` VALUES ('276', '澄迈县', '22', '0,22', '0', '276', '276', '0', '0');
INSERT INTO `ty_area` VALUES ('277', '临高县', '22', '0,22', '0', '277', '277', '0', '0');
INSERT INTO `ty_area` VALUES ('278', '白沙黎族自治县', '22', '0,22', '0', '278', '278', '0', '0');
INSERT INTO `ty_area` VALUES ('279', '昌江黎族自治县', '22', '0,22', '0', '279', '279', '0', '0');
INSERT INTO `ty_area` VALUES ('280', '乐东黎族自治县', '22', '0,22', '0', '280', '280', '0', '2');
INSERT INTO `ty_area` VALUES ('281', '陵水黎族自治县', '22', '0,22', '0', '281', '281', '0', '0');
INSERT INTO `ty_area` VALUES ('282', '保亭黎族苗族自治县', '22', '0,22', '0', '282', '282', '0', '0');
INSERT INTO `ty_area` VALUES ('283', '琼中黎族苗族自治县', '22', '0,22', '0', '283', '283', '0', '0');
INSERT INTO `ty_area` VALUES ('284', '成都市', '23', '0,23', '0', '284', '284', '123', '12');
INSERT INTO `ty_area` VALUES ('285', '自贡市', '23', '0,23', '0', '285', '285', '4', '0');
INSERT INTO `ty_area` VALUES ('286', '攀枝花市', '23', '0,23', '0', '286', '286', '0', '2');
INSERT INTO `ty_area` VALUES ('287', '泸州市', '23', '0,23', '0', '287', '287', '5', '0');
INSERT INTO `ty_area` VALUES ('288', '德阳市', '23', '0,23', '0', '288', '288', '4', '0');
INSERT INTO `ty_area` VALUES ('289', '绵阳市', '23', '0,23', '0', '289', '289', '5', '2');
INSERT INTO `ty_area` VALUES ('290', '广元市', '23', '0,23', '0', '290', '290', '0', '1');
INSERT INTO `ty_area` VALUES ('291', '遂宁市', '23', '0,23', '0', '291', '291', '2', '1');
INSERT INTO `ty_area` VALUES ('292', '内江市', '23', '0,23', '0', '292', '292', '2', '1');
INSERT INTO `ty_area` VALUES ('293', '乐山市', '23', '0,23', '0', '293', '293', '3', '0');
INSERT INTO `ty_area` VALUES ('294', '南充市', '23', '0,23', '0', '294', '294', '7', '2');
INSERT INTO `ty_area` VALUES ('295', '眉山市', '23', '0,23', '0', '295', '295', '0', '0');
INSERT INTO `ty_area` VALUES ('296', '宜宾市', '23', '0,23', '0', '296', '296', '2', '5');
INSERT INTO `ty_area` VALUES ('297', '广安市', '23', '0,23', '0', '297', '297', '6', '2');
INSERT INTO `ty_area` VALUES ('298', '达州市', '23', '0,23', '0', '298', '298', '3', '0');
INSERT INTO `ty_area` VALUES ('299', '雅安市', '23', '0,23', '0', '299', '299', '2', '0');
INSERT INTO `ty_area` VALUES ('300', '巴中市', '23', '0,23', '0', '300', '300', '4', '0');
INSERT INTO `ty_area` VALUES ('301', '资阳市', '23', '0,23', '0', '301', '301', '0', '0');
INSERT INTO `ty_area` VALUES ('302', '阿坝藏族羌族自治州', '23', '0,23', '0', '302', '302', '1', '0');
INSERT INTO `ty_area` VALUES ('303', '甘孜藏族自治州', '23', '0,23', '0', '303', '303', '0', '0');
INSERT INTO `ty_area` VALUES ('304', '凉山彝族自治州', '23', '0,23', '0', '304', '304', '2', '0');
INSERT INTO `ty_area` VALUES ('305', '贵阳市', '24', '0,24', '0', '305', '305', '12', '4');
INSERT INTO `ty_area` VALUES ('306', '六盘水市', '24', '0,24', '0', '306', '306', '0', '0');
INSERT INTO `ty_area` VALUES ('307', '遵义市', '24', '0,24', '0', '307', '307', '3', '2');
INSERT INTO `ty_area` VALUES ('308', '安顺市', '24', '0,24', '0', '308', '308', '0', '0');
INSERT INTO `ty_area` VALUES ('309', '铜仁地区', '24', '0,24', '0', '309', '309', '0', '0');
INSERT INTO `ty_area` VALUES ('310', '黔西南布依族苗族自治州', '24', '0,24', '0', '310', '310', '2', '1');
INSERT INTO `ty_area` VALUES ('311', '毕节地区', '24', '0,24', '0', '311', '311', '1', '0');
INSERT INTO `ty_area` VALUES ('312', '黔东南苗族侗族自治州', '24', '0,24', '0', '312', '312', '0', '0');
INSERT INTO `ty_area` VALUES ('313', '黔南布依族苗族自治州', '24', '0,24', '0', '313', '313', '2', '0');
INSERT INTO `ty_area` VALUES ('314', '昆明市', '25', '0,25', '0', '314', '314', '46', '12');
INSERT INTO `ty_area` VALUES ('315', '曲靖市', '25', '0,25', '0', '315', '315', '2', '0');
INSERT INTO `ty_area` VALUES ('316', '玉溪市', '25', '0,25', '0', '316', '316', '3', '0');
INSERT INTO `ty_area` VALUES ('317', '保山市', '25', '0,25', '0', '317', '317', '1', '1');
INSERT INTO `ty_area` VALUES ('318', '昭通市', '25', '0,25', '0', '318', '318', '1', '0');
INSERT INTO `ty_area` VALUES ('319', '丽江市', '25', '0,25', '0', '319', '319', '0', '0');
INSERT INTO `ty_area` VALUES ('320', '思茅市', '25', '0,25', '0', '320', '320', '0', '0');
INSERT INTO `ty_area` VALUES ('321', '临沧市', '25', '0,25', '0', '321', '321', '1', '2');
INSERT INTO `ty_area` VALUES ('322', '楚雄彝族自治州', '25', '0,25', '0', '322', '322', '2', '0');
INSERT INTO `ty_area` VALUES ('323', '红河哈尼族彝族自治州', '25', '0,25', '0', '323', '323', '2', '2');
INSERT INTO `ty_area` VALUES ('324', '文山壮族苗族自治州', '25', '0,25', '0', '324', '324', '0', '0');
INSERT INTO `ty_area` VALUES ('325', '西双版纳傣族自治州', '25', '0,25', '0', '325', '325', '0', '0');
INSERT INTO `ty_area` VALUES ('326', '大理白族自治州', '25', '0,25', '0', '326', '326', '2', '0');
INSERT INTO `ty_area` VALUES ('327', '德宏傣族景颇族自治州', '25', '0,25', '0', '327', '327', '0', '0');
INSERT INTO `ty_area` VALUES ('328', '怒江傈僳族自治州', '25', '0,25', '0', '328', '328', '0', '0');
INSERT INTO `ty_area` VALUES ('329', '迪庆藏族自治州', '25', '0,25', '0', '329', '329', '0', '0');
INSERT INTO `ty_area` VALUES ('330', '拉萨市', '26', '0,26', '0', '330', '330', '1', '0');
INSERT INTO `ty_area` VALUES ('331', '昌都地区', '26', '0,26', '0', '331', '331', '0', '0');
INSERT INTO `ty_area` VALUES ('332', '山南地区', '26', '0,26', '0', '332', '332', '0', '0');
INSERT INTO `ty_area` VALUES ('333', '日喀则地区', '26', '0,26', '0', '333', '333', '1', '0');
INSERT INTO `ty_area` VALUES ('334', '那曲地区', '26', '0,26', '0', '334', '334', '0', '0');
INSERT INTO `ty_area` VALUES ('335', '阿里地区', '26', '0,26', '0', '335', '335', '0', '0');
INSERT INTO `ty_area` VALUES ('336', '林芝地区', '26', '0,26', '0', '336', '336', '0', '0');
INSERT INTO `ty_area` VALUES ('337', '西安市', '27', '0,27', '0', '337', '337', '67', '6');
INSERT INTO `ty_area` VALUES ('338', '铜川市', '27', '0,27', '0', '338', '338', '1', '4');
INSERT INTO `ty_area` VALUES ('339', '宝鸡市', '27', '0,27', '0', '339', '339', '4', '0');
INSERT INTO `ty_area` VALUES ('340', '咸阳市', '27', '0,27', '0', '340', '340', '4', '1');
INSERT INTO `ty_area` VALUES ('341', '渭南市', '27', '0,27', '0', '341', '341', '6', '0');
INSERT INTO `ty_area` VALUES ('342', '延安市', '27', '0,27', '0', '342', '342', '0', '1');
INSERT INTO `ty_area` VALUES ('343', '汉中市', '27', '0,27', '0', '343', '343', '4', '0');
INSERT INTO `ty_area` VALUES ('344', '榆林市', '27', '0,27', '0', '344', '344', '0', '1');
INSERT INTO `ty_area` VALUES ('345', '安康市', '27', '0,27', '0', '345', '345', '2', '0');
INSERT INTO `ty_area` VALUES ('346', '商洛市', '27', '0,27', '0', '346', '346', '0', '0');
INSERT INTO `ty_area` VALUES ('347', '兰州市', '28', '0,28', '0', '347', '347', '28', '0');
INSERT INTO `ty_area` VALUES ('348', '嘉峪关市', '28', '0,28', '0', '348', '348', '0', '0');
INSERT INTO `ty_area` VALUES ('349', '金昌市', '28', '0,28', '0', '349', '349', '0', '0');
INSERT INTO `ty_area` VALUES ('350', '白银市', '28', '0,28', '0', '350', '350', '0', '0');
INSERT INTO `ty_area` VALUES ('351', '天水市', '28', '0,28', '0', '351', '351', '3', '0');
INSERT INTO `ty_area` VALUES ('352', '武威市', '28', '0,28', '0', '352', '352', '2', '0');
INSERT INTO `ty_area` VALUES ('353', '张掖市', '28', '0,28', '0', '353', '353', '2', '1');
INSERT INTO `ty_area` VALUES ('354', '平凉市', '28', '0,28', '0', '354', '354', '0', '0');
INSERT INTO `ty_area` VALUES ('355', '酒泉市', '28', '0,28', '0', '355', '355', '0', '0');
INSERT INTO `ty_area` VALUES ('356', '庆阳市', '28', '0,28', '0', '356', '356', '5', '0');
INSERT INTO `ty_area` VALUES ('357', '定西市', '28', '0,28', '0', '357', '357', '2', '0');
INSERT INTO `ty_area` VALUES ('358', '陇南市', '28', '0,28', '0', '358', '358', '0', '0');
INSERT INTO `ty_area` VALUES ('359', '临夏回族自治州', '28', '0,28', '0', '359', '359', '1', '0');
INSERT INTO `ty_area` VALUES ('360', '甘南藏族自治州', '28', '0,28', '0', '360', '360', '0', '0');
INSERT INTO `ty_area` VALUES ('361', '西宁市', '29', '0,29', '0', '361', '361', '2', '0');
INSERT INTO `ty_area` VALUES ('362', '海东地区', '29', '0,29', '0', '362', '362', '1', '1');
INSERT INTO `ty_area` VALUES ('363', '海北藏族自治州', '29', '0,29', '0', '363', '363', '0', '0');
INSERT INTO `ty_area` VALUES ('364', '黄南藏族自治州', '29', '0,29', '0', '364', '364', '0', '0');
INSERT INTO `ty_area` VALUES ('365', '海南藏族自治州', '29', '0,29', '0', '365', '365', '0', '0');
INSERT INTO `ty_area` VALUES ('366', '果洛藏族自治州', '29', '0,29', '0', '366', '366', '0', '0');
INSERT INTO `ty_area` VALUES ('367', '玉树藏族自治州', '29', '0,29', '0', '367', '367', '0', '0');
INSERT INTO `ty_area` VALUES ('368', '海西蒙古族藏族自治州', '29', '0,29', '0', '368', '368', '0', '0');
INSERT INTO `ty_area` VALUES ('369', '银川市', '30', '0,30', '0', '369', '369', '5', '0');
INSERT INTO `ty_area` VALUES ('370', '石嘴山市', '30', '0,30', '0', '370', '370', '3', '0');
INSERT INTO `ty_area` VALUES ('371', '吴忠市', '30', '0,30', '0', '371', '371', '1', '0');
INSERT INTO `ty_area` VALUES ('372', '固原市', '30', '0,30', '0', '372', '372', '0', '0');
INSERT INTO `ty_area` VALUES ('373', '中卫市', '30', '0,30', '0', '373', '373', '0', '0');
INSERT INTO `ty_area` VALUES ('374', '乌鲁木齐市', '31', '0,31', '0', '374', '374', '14', '1');
INSERT INTO `ty_area` VALUES ('375', '克拉玛依市', '31', '0,31', '0', '375', '375', '0', '0');
INSERT INTO `ty_area` VALUES ('376', '吐鲁番地区', '31', '0,31', '0', '376', '376', '0', '0');
INSERT INTO `ty_area` VALUES ('377', '哈密地区', '31', '0,31', '0', '377', '377', '0', '0');
INSERT INTO `ty_area` VALUES ('378', '昌吉回族自治州', '31', '0,31', '0', '378', '378', '1', '0');
INSERT INTO `ty_area` VALUES ('379', '博尔塔拉蒙古自治州', '31', '0,31', '0', '379', '379', '0', '0');
INSERT INTO `ty_area` VALUES ('380', '巴音郭楞蒙古自治州', '31', '0,31', '0', '380', '380', '2', '0');
INSERT INTO `ty_area` VALUES ('381', '阿克苏地区', '31', '0,31', '0', '381', '381', '0', '0');
INSERT INTO `ty_area` VALUES ('382', '克孜勒苏柯尔克孜自治州', '31', '0,31', '0', '382', '382', '0', '0');
INSERT INTO `ty_area` VALUES ('383', '喀什地区', '31', '0,31', '0', '383', '383', '0', '0');
INSERT INTO `ty_area` VALUES ('384', '和田地区', '31', '0,31', '0', '384', '384', '0', '0');
INSERT INTO `ty_area` VALUES ('385', '伊犁哈萨克自治州', '31', '0,31', '0', '385', '385', '1', '0');
INSERT INTO `ty_area` VALUES ('386', '塔城地区', '31', '0,31', '0', '386', '386', '0', '0');
INSERT INTO `ty_area` VALUES ('387', '阿勒泰地区', '31', '0,31', '0', '387', '387', '0', '0');
INSERT INTO `ty_area` VALUES ('388', '石河子市', '31', '0,31', '0', '388', '388', '0', '0');
INSERT INTO `ty_area` VALUES ('389', '阿拉尔市', '31', '0,31', '0', '389', '389', '0', '0');
INSERT INTO `ty_area` VALUES ('390', '图木舒克市', '31', '0,31', '0', '390', '390', '0', '0');
INSERT INTO `ty_area` VALUES ('391', '五家渠市', '31', '0,31', '0', '391', '391', '0', '0');

-- ----------------------------
-- Table structure for ty_article_21
-- ----------------------------
DROP TABLE IF EXISTS `ty_article_21`;
CREATE TABLE `ty_article_21` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `subtitle` mediumtext NOT NULL,
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(50) NOT NULL DEFAULT '',
  `copyfrom` varchar(30) NOT NULL DEFAULT '',
  `fromurl` varchar(255) NOT NULL DEFAULT '',
  `voteid` varchar(100) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='资讯';

-- ----------------------------
-- Records of ty_article_21
-- ----------------------------
INSERT INTO `ty_article_21` VALUES ('1', '52', '0', '1', '互联网医疗哪些“阵亡” 哪些“还在路上”', '', '0', '', '核心提示 泡沫破灭后，一些互联网医疗企业因找不到更好盈利模式，投资人兴致阑珊；不过，也有一些企业熬过寒冬，更有一些医疗机构探索总结经验，开始互联网医疗服务的“深耕细作”。1231231231231231231', '', '互联网医疗哪些“阵亡” 哪些“还在路上”,行业资讯', '', '', '', '', '', '7', 'http://www.tctianyi.com/file/upload/201705/13/122107281.jpg', 'tianyi', '1494401901', 'tianyi', '1494655462', '127.0.0.1', '', '3', '0', 'show.php?itemid=1', '', '');
INSERT INTO `ty_article_21` VALUES ('2', '52', '0', '0', '大是互联网医疗，几年前曾是最被看好的蓝海，如今正经历', '', '0', '', '核心提示 泡沫破灭后，一些互联网医疗企业因找不到更好盈利模式，投资人兴致阑珊；不过，也有一些企业熬过寒冬，更有一些医疗机构探索总结经验，开始互联网医疗服务的“深耕细作”。', '', '大是互联网医疗，几年前曾是最被看好的蓝海，如今正经历,行业资讯', '', '', '', '', '', '8', '', 'shandongpingyi', '1494402030', 'tianyi', '1494405442', '127.0.0.1', '', '3', '0', 'show.php?itemid=2', '', '');
INSERT INTO `ty_article_21` VALUES ('3', '52', '0', '0', '1111111111', '', '0', '', '1111111111111111111111', '', '1111111111,行业资讯', '', '', '', '', '', '1', '', 'tianyi', '1494407770', 'tianyi', '1494407800', '127.0.0.1', '', '3', '0', 'show.php?itemid=3', '', '');
INSERT INTO `ty_article_21` VALUES ('4', '52', '0', '0', '111111111111', '', '0', '', '111111111111111111111', '', '111111111111,行业资讯', '', '', '', '', '', '1', '', 'tianyi', '1494407800', 'tianyi', '1494407808', '127.0.0.1', '', '3', '0', 'show.php?itemid=4', '', '');
INSERT INTO `ty_article_21` VALUES ('5', '52', '0', '0', '1111111111111111', '', '0', '', '11111111111', '', '1111111111111111,行业资讯', '', '', '', '', '', '0', '', 'tianyi', '1494407808', 'tianyi', '1494407814', '127.0.0.1', '', '3', '0', 'show.php?itemid=5', '', '');
INSERT INTO `ty_article_21` VALUES ('6', '52', '0', '0', '11111', '', '0', '', '111111', '', '11111,行业资讯', '', '', '', '', '', '0', '', 'tianyi', '1494407814', 'tianyi', '1494407817', '127.0.0.1', '', '3', '0', 'show.php?itemid=6', '', '');
INSERT INTO `ty_article_21` VALUES ('7', '52', '0', '0', 'asdasdasd', '', '0', '', 'asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd', '', 'asdasdasd,行业资讯', '', '', '', '', '', '0', '', 'tianyi', '1494407817', 'tianyi', '1494407823', '127.0.0.1', '', '3', '0', 'show.php?itemid=7', '', '');
INSERT INTO `ty_article_21` VALUES ('8', '56', '0', '1', 'asdasdasd', '', '0', '', 'asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd', '', 'asdasdasd,政策法规', '', '', '', '', '', '0', 'http://www.tctianyi.com/file/upload/201705/13/141438821.png', 'tianyi', '1494407823', 'tianyi', '1494656080', '127.0.0.1', '', '3', '0', 'show.php?itemid=8', '', '');
INSERT INTO `ty_article_21` VALUES ('9', '55', '0', '1', 'asdasdasd', '', '0', '', 'asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd', '', 'asdasdasd,技术文库', '', '', '', '', '', '0', 'http://www.tctianyi.com/file/upload/201705/13/141423151.png', 'tianyi', '1494407827', 'tianyi', '1494656065', '127.0.0.1', '', '3', '0', 'show.php?itemid=9', '', '');
INSERT INTO `ty_article_21` VALUES ('10', '54', '0', '2', 'asdasdasd', '', '0', '', 'asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd', '', 'asdasdasd,最新活动', '', '', '', '', '', '0', 'http://www.tctianyi.com/file/upload/201705/13/141359831.jpg', 'tianyi', '1494407831', 'tianyi', '1494656040', '127.0.0.1', '', '3', '0', 'show.php?itemid=10', '', '');
INSERT INTO `ty_article_21` VALUES ('11', '54', '0', '1', 'asdasdasdasdasdasd', '', '0', '', 'asdasdasdasdasdasdasdasdasd', '', 'asdasdasdasdasdasd,最新活动', '', '', '', '', '', '1', 'http://www.tctianyi.com/file/upload/201705/13/141345361.jpg', 'tianyi', '1494407843', 'tianyi', '1494656026', '127.0.0.1', '', '3', '0', 'show.php?itemid=11', '', '');
INSERT INTO `ty_article_21` VALUES ('12', '53', '0', '2', 'asdasdasdasdasdasdasdasdasdasdasdasd', '', '0', '', 'asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd', '', 'asdasdasdasdasdasdasdasdasdasdasdasd,展会信息', '', '', '', '', '', '5', 'http://www.tctianyi.com/file/upload/201705/13/141330861.png', 'tianyi', '1494407845', 'tianyi', '1494656012', '127.0.0.1', '', '3', '0', 'show.php?itemid=12', '', '');
INSERT INTO `ty_article_21` VALUES ('13', '53', '0', '1', '大是互联网医疗，几年前曾是最被看好的蓝海，如今正经历', '', '0', '', '是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。', '', '大是互联网医疗，几年前曾是最被看好的蓝海，如今正经历,展会信息', '', '', '', '', '', '9', 'http://www.tctianyi.com/file/upload/201705/13/141251531.png', 'tianyi', '1494464946', 'tianyi', '1494655973', '127.0.0.1', '', '3', '0', 'show.php?itemid=13', '', '');
INSERT INTO `ty_article_21` VALUES ('14', '52', '0', '2', '好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：', '', '0', '', '是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分', '', '好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：,行业资讯', '', '', '', '', '', '29', 'http://www.tctianyi.com/file/upload/201705/13/135715381.gif', 'tianyi', '1494465143', 'tianyi', '1494655037', '127.0.0.1', '', '3', '0', 'show.php?itemid=14', '', '');
INSERT INTO `ty_article_21` VALUES ('15', '52', '0', '2', '好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：', '', '0', '', '好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：', '', '好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：,行业资讯', '', '', '', '', '', '126', 'http://www.tctianyi.com/file/upload/201705/13/122842421.jpg', 'tianyi', '1494465155', 'tianyi', '1494649727', '127.0.0.1', '', '3', '0', 'show.php?itemid=15', '', '');
INSERT INTO `ty_article_21` VALUES ('16', '53', '0', '2', '好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：', '', '0', '', '好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如', '', '好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：,展会信息', '', '', '', '', '', '25', 'http://www.tctianyi.com/file/upload/201705/13/141659471.png', 'tianyi', '1494465160', 'tianyi', '1494656220', '127.0.0.1', '', '3', '0', 'show.php?itemid=16', '', '');
INSERT INTO `ty_article_21` VALUES ('17', '53', '0', '0', '水水水水', '', '0', '', '111111111111111爱的', '', '水水水水,展会信息', '', '', '', '', '', '0', '', 'tianyi', '1494656387', 'tianyi', '1494656399', '127.0.0.1', '', '3', '0', 'show.php?itemid=17', '', '');
INSERT INTO `ty_article_21` VALUES ('18', '54', '0', '2', '爱上大沙发上反复阿萨德hi爱hi合法if年', '', '0', '', '爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上', '', '爱上大沙发上反复阿萨德hi爱hi合法if年,最新活动', '', '', '', '', '', '0', 'http://www.tctianyi.com/file/upload/201705/13/142232451.png', 'tianyi', '1494656530', 'tianyi', '1494656554', '127.0.0.1', '', '3', '0', 'show.php?itemid=18', '', '');

-- ----------------------------
-- Table structure for ty_article_data_21
-- ----------------------------
DROP TABLE IF EXISTS `ty_article_data_21`;
CREATE TABLE `ty_article_data_21` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资讯内容';

-- ----------------------------
-- Records of ty_article_data_21
-- ----------------------------
INSERT INTO `ty_article_data_21` VALUES ('1', '&nbsp;互联网医疗，几年前曾是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。互联网医疗，几年前曾是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。互联网医疗，几年前曾是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。互联网医疗，几年前曾是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。互联网医疗，几年前曾是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。');
INSERT INTO `ty_article_data_21` VALUES ('2', '保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。');
INSERT INTO `ty_article_data_21` VALUES ('3', '&nbsp;1111111111111111111111');
INSERT INTO `ty_article_data_21` VALUES ('4', '&nbsp;111111111111111111111');
INSERT INTO `ty_article_data_21` VALUES ('5', '&nbsp;11111111111');
INSERT INTO `ty_article_data_21` VALUES ('6', '&nbsp;111111');
INSERT INTO `ty_article_data_21` VALUES ('7', '&nbsp;asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd');
INSERT INTO `ty_article_data_21` VALUES ('8', '&nbsp;asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd');
INSERT INTO `ty_article_data_21` VALUES ('9', '&nbsp;asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd');
INSERT INTO `ty_article_data_21` VALUES ('10', '&nbsp;asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd');
INSERT INTO `ty_article_data_21` VALUES ('11', '&nbsp;asdasdasdasdasdasdasdasdasd');
INSERT INTO `ty_article_data_21` VALUES ('12', '&nbsp;asdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasdasd');
INSERT INTO `ty_article_data_21` VALUES ('13', '联网医疗，几年前曾是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。');
INSERT INTO `ty_article_data_21` VALUES ('14', '&nbsp;是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。是最被看好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：2011年至2016年5年间，国内共有1134家互联网+医疗企业诞生，分别分布在健康保健、寻医诊疗、专科服务、医疗信息化、生物技术等领域。5年间，获融资的企业为533家，其中已死亡的企业为66家，行业死亡率大致为12.38%。');
INSERT INTO `ty_article_data_21` VALUES ('15', '&nbsp;好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：');
INSERT INTO `ty_article_data_21` VALUES ('16', '&nbsp;好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：好的蓝海，如今正经历一波大浪淘沙。根据动脉网研究显示：');
INSERT INTO `ty_article_data_21` VALUES ('17', '&nbsp;111111111111111爱的');
INSERT INTO `ty_article_data_21` VALUES ('18', '&nbsp;爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年<br />\r\n爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年<br />\r\n<br />\r\n<br />\r\n爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年<br />\r\n爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年<br />\r\n爱上大沙发上反复阿萨德hi爱hi合法if年<br />\r\n<br />\r\n<br />\r\n<br />\r\n爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年爱上大沙发上反复阿萨德hi爱hi合法if年');

-- ----------------------------
-- Table structure for ty_ask
-- ----------------------------
DROP TABLE IF EXISTS `ty_ask`;
CREATE TABLE `ty_ask` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `qid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL,
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reply` mediumtext NOT NULL,
  `star` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='客服中心';

-- ----------------------------
-- Records of ty_ask
-- ----------------------------

-- ----------------------------
-- Table structure for ty_banip
-- ----------------------------
DROP TABLE IF EXISTS `ty_banip`;
CREATE TABLE `ty_banip` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='IP禁止';

-- ----------------------------
-- Records of ty_banip
-- ----------------------------

-- ----------------------------
-- Table structure for ty_banword
-- ----------------------------
DROP TABLE IF EXISTS `ty_banword`;
CREATE TABLE `ty_banword` (
  `bid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `replacefrom` varchar(255) NOT NULL DEFAULT '',
  `replaceto` varchar(255) NOT NULL DEFAULT '',
  `deny` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='词语过滤';

-- ----------------------------
-- Records of ty_banword
-- ----------------------------

-- ----------------------------
-- Table structure for ty_brand_13
-- ----------------------------
DROP TABLE IF EXISTS `ty_brand_13`;
CREATE TABLE `ty_brand_13` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `fax` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`),
  KEY `edittime` (`edittime`),
  KEY `editdate` (`editdate`,`vip`,`edittime`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='品牌';

-- ----------------------------
-- Records of ty_brand_13
-- ----------------------------
INSERT INTO `ty_brand_13` VALUES ('1', '51', '0', '彩钢板', '', '0', '彩钢板,,装修主材全国', '', '1', 'http://www.tctianyi.com/file/upload/201704/06/140030671.png', '', 'hulunbeier', '6', '1491458414', '2017-04-06', '0', '63', '呼伦贝尔市晨光灯具厂', '0', '0', '呼', '13800138000', '', '', '内蒙古呼伦贝尔', '', '', '', '', '', '阿萨飒飒飒飒撒', 'tianyi', '1491458439', '2017-04-06', '127.0.0.1', '', '3', 'show.php?itemid=1', '', '');

-- ----------------------------
-- Table structure for ty_brand_26
-- ----------------------------
DROP TABLE IF EXISTS `ty_brand_26`;
CREATE TABLE `ty_brand_26` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `fax` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`),
  KEY `edittime` (`edittime`),
  KEY `editdate` (`editdate`,`vip`,`edittime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='找施工';

-- ----------------------------
-- Records of ty_brand_26
-- ----------------------------

-- ----------------------------
-- Table structure for ty_brand_data_13
-- ----------------------------
DROP TABLE IF EXISTS `ty_brand_data_13`;
CREATE TABLE `ty_brand_data_13` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='品牌内容';

-- ----------------------------
-- Records of ty_brand_data_13
-- ----------------------------
INSERT INTO `ty_brand_data_13` VALUES ('1', '<br />\r\n阿萨飒飒飒飒撒');

-- ----------------------------
-- Table structure for ty_brand_data_26
-- ----------------------------
DROP TABLE IF EXISTS `ty_brand_data_26`;
CREATE TABLE `ty_brand_data_26` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='找施工内容';

-- ----------------------------
-- Records of ty_brand_data_26
-- ----------------------------

-- ----------------------------
-- Table structure for ty_buy_6
-- ----------------------------
DROP TABLE IF EXISTS `ty_buy_6`;
CREATE TABLE `ty_buy_6` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(100) NOT NULL,
  `v2` varchar(100) NOT NULL,
  `v3` varchar(100) NOT NULL,
  `amount` varchar(10) NOT NULL DEFAULT '',
  `price` varchar(10) NOT NULL DEFAULT '',
  `pack` varchar(20) NOT NULL DEFAULT '',
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='求购';

-- ----------------------------
-- Records of ty_buy_6
-- ----------------------------

-- ----------------------------
-- Table structure for ty_buy_data_6
-- ----------------------------
DROP TABLE IF EXISTS `ty_buy_data_6`;
CREATE TABLE `ty_buy_data_6` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='求购内容';

-- ----------------------------
-- Records of ty_buy_data_6
-- ----------------------------

-- ----------------------------
-- Table structure for ty_cache
-- ----------------------------
DROP TABLE IF EXISTS `ty_cache`;
CREATE TABLE `ty_cache` (
  `cacheid` varchar(32) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `cacheid` (`cacheid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件缓存';

-- ----------------------------
-- Records of ty_cache
-- ----------------------------

-- ----------------------------
-- Table structure for ty_category
-- ----------------------------
DROP TABLE IF EXISTS `ty_category`;
CREATE TABLE `ty_category` (
  `catid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `catname` varchar(50) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `catdir` varchar(255) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `letter` varchar(4) NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `item` bigint(20) unsigned NOT NULL DEFAULT '0',
  `property` smallint(6) unsigned NOT NULL DEFAULT '0',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL DEFAULT '',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` text NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `template` varchar(30) NOT NULL DEFAULT '',
  `show_template` varchar(30) NOT NULL DEFAULT '',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `group_list` varchar(255) NOT NULL DEFAULT '',
  `group_show` varchar(255) NOT NULL DEFAULT '',
  `group_add` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='栏目分类';

-- ----------------------------
-- Records of ty_category
-- ----------------------------
INSERT INTO `ty_category` VALUES ('1', '5', '供应默认分类', '', '1', 'list.php?catid=1', '', '1', '0', '0', '0', '0', '0', '', '1', '', '', '', '', '', '', '', '');
INSERT INTO `ty_category` VALUES ('2', '6', '求购默认分类', '', '1', 'list.php?catid=2', '', '1', '0', '0', '0', '0', '0', '', '1', '', '', '', '', '', '', '', '');
INSERT INTO `ty_category` VALUES ('3', '4', '装修主材', '', 'zhuangxiuzhucai', 'list.php?catid=3', '', '1', '2', '0', '0', '0', '0', '3', '1', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6,7');
INSERT INTO `ty_category` VALUES ('4', '16', '装修主材', '', 'zhuangxiu', 'list.php?catid=4', 'z', '1', '24', '0', '0', '0', '1', '4,12,13,14,15', '4', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('5', '16', '通风空调', '', 'tongfengkongdiao', 'list.php?catid=5', 't', '1', '8', '0', '0', '0', '1', '5,16,17,18,19', '5', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('6', '16', '电工电气/安防', '', 'diangongdianqi', 'list.php?catid=6', 'd', '1', '0', '0', '0', '0', '1', '6,20,21,22,23', '6', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('7', '16', '管材管件', '', 'guancaiguanjian', 'list.php?catid=7', 'g', '1', '0', '0', '0', '0', '1', '7,24,25,26,27', '7', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('8', '16', '实验室家具', '', 'shiyanshi', 'list.php?catid=8', 's', '1', '6', '0', '0', '0', '1', '8,28,29,30,31', '8', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('9', '16', '仪器设备', '', 'yiqishebei', 'list.php?catid=9', 'y', '1', '0', '0', '0', '0', '1', '9,32,33,34,35', '9', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('10', '16', '采暖/热泵', '', 'cainuan', 'list.php?catid=10', 'c', '1', '0', '0', '0', '0', '1', '10,36,37,38,39', '10', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('11', '16', '辅材/工具', '', 'gongju', 'list.php?catid=11', 'g', '1', '6', '0', '0', '0', '1', '11,40,41,42,43', '11', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('12', '16', '彩钢板', '', 'caigangban', 'list.php?catid=12', 'c', '1', '6', '0', '4', '0,4', '0', '12', '12', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('13', '16', '铝扣板', '', 'lvkouban', 'list.php?catid=13', 'l', '1', '7', '0', '4', '0,4', '0', '13', '13', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('14', '16', '瓷砖地板', '', 'cizhuandiban', 'list.php?catid=14', 'c', '1', '7', '0', '4', '0,4', '0', '14', '14', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('15', '16', 'PVC地板', '', 'PVCdiban', 'list.php?catid=15', 'p', '1', '4', '0', '4', '0,4', '0', '15', '15', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('16', '16', '空调主机', '', 'kongdiaozhuji', 'list.php?catid=16', 'k', '1', '2', '0', '5', '0,5', '0', '16', '16', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('17', '16', '空调末端', '', 'kongdiaomoduan', 'list.php?catid=17', 'k', '1', '2', '0', '5', '0,5', '0', '17', '17', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('18', '16', '商用空调', '', 'shangyongkongdiao', 'list.php?catid=18', 's', '1', '3', '0', '5', '0,5', '0', '18', '18', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('19', '16', '风机', '', 'fengji', 'list.php?catid=19', 'f', '1', '0', '0', '5', '0,5', '0', '19', '19', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('20', '16', '电缆', '', 'dianlan', 'list.php?catid=20', 'd', '1', '2', '0', '6', '0,6', '0', '20', '20', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('21', '16', '电线', '', 'dianxian', 'list.php?catid=21', 'd', '1', '1', '0', '6', '0,6', '0', '21', '21', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('22', '16', '开关', '', 'kaiguan', 'list.php?catid=22', 'k', '1', '2', '0', '6', '0,6', '0', '22', '22', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('23', '16', '灯具', '', 'dengju', 'list.php?catid=23', 'd', '1', '1', '0', '6', '0,6', '0', '23', '23', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('24', '16', '镀锌钢管', '', 'duxingangguan', 'list.php?catid=24', 'd', '1', '0', '0', '7', '0,7', '0', '24', '24', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('25', '16', '不锈钢钢管', '', 'buxiuganggangguan', 'list.php?catid=25', 'b', '1', '2', '0', '7', '0,7', '0', '25', '25', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('26', '16', 'PPR钢管', '', 'PPRgangguan', 'list.php?catid=26', 'p', '1', '0', '0', '7', '0,7', '0', '26', '26', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('27', '16', 'PVC管', '', 'PVCguan', 'list.php?catid=27', 'p', '1', '0', '0', '7', '0,7', '0', '27', '27', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('28', '16', '中央台', '', 'zhongyangtai', 'list.php?catid=28', 'z', '1', '0', '0', '8', '0,8', '0', '28', '28', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('29', '16', '边台', '', 'biantai', 'list.php?catid=29', 'b', '1', '0', '0', '8', '0,8', '0', '29', '29', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('30', '16', '取材台', '', 'qucaitai', 'list.php?catid=30', 'q', '1', '0', '0', '8', '0,8', '0', '30', '30', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('31', '16', '办公家具', '', 'bangongjiaju', 'list.php?catid=31', 'b', '1', '0', '0', '8', '0,8', '0', '31', '31', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('32', '16', 'PCR仪', '', 'PCRyi', 'list.php?catid=32', 'p', '1', '0', '0', '9', '0,9', '0', '32', '32', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('33', '16', '免疫仪', '', 'mianyiyi', 'list.php?catid=33', 'm', '1', '0', '0', '9', '0,9', '0', '33', '33', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('34', '16', '通风柜', '', 'tongfenggui', 'list.php?catid=34', 't', '1', '0', '0', '9', '0,9', '0', '34', '34', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('35', '16', '生物安全柜', '', 'shengwuanquangui', 'list.php?catid=35', 's', '1', '0', '0', '9', '0,9', '0', '35', '35', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('36', '16', '电采暖', '', 'diancainuan', 'list.php?catid=36', 'd', '1', '0', '0', '10', '0,10', '0', '36', '36', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('37', '16', '水源热泵机组', '', 'shuiyuanrebengjizu', 'list.php?catid=37', 's', '1', '0', '0', '10', '0,10', '0', '37', '37', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('38', '16', '商用热泵', '', 'shangyongrebeng', 'list.php?catid=38', 's', '1', '0', '0', '10', '0,10', '0', '38', '38', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('39', '16', '伸缩器', '', 'shensuoqi', 'list.php?catid=39', 's', '1', '0', '0', '10', '0,10', '0', '39', '39', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('40', '16', '切割机', '', 'qiegeji', 'list.php?catid=40', 'q', '1', '1', '0', '11', '0,11', '0', '40', '40', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('41', '16', '手电钻', '', 'shoudianzuan', 'list.php?catid=41', 's', '1', '2', '0', '11', '0,11', '0', '41', '41', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('42', '16', '激光测距仪', '', 'jiguangcejuyi', 'list.php?catid=42', 'j', '1', '2', '0', '11', '0,11', '0', '42', '42', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('43', '16', '万用表', '', 'wanyongbiao', 'list.php?catid=43', 'w', '1', '1', '0', '11', '0,11', '0', '43', '43', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '');
INSERT INTO `ty_category` VALUES ('44', '4', '通风空调', '', 'tongfengkongdiao', 'list.php?catid=44', 't', '1', '1', '0', '0', '0', '0', '44', '44', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6,7');
INSERT INTO `ty_category` VALUES ('45', '4', '电工电气/安防', '', 'diangongdianqi', 'list.php?catid=45', 'd', '1', '0', '0', '0', '0', '0', '45', '45', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6,7');
INSERT INTO `ty_category` VALUES ('46', '4', '管材管件', '', 'guancaiguanjian', 'list.php?catid=46', 'g', '1', '0', '0', '0', '0', '0', '46', '46', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6,7');
INSERT INTO `ty_category` VALUES ('47', '4', '实验室家具', '', 'shiyanshijiaju', 'list.php?catid=47', 's', '1', '0', '0', '0', '0', '0', '47', '47', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6,7');
INSERT INTO `ty_category` VALUES ('48', '4', '仪器设备', '', 'yiqishebei', 'list.php?catid=48', 'y', '1', '0', '0', '0', '0', '0', '48', '48', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6');
INSERT INTO `ty_category` VALUES ('49', '4', '采暖/热泵', '', 'cainuanrebeng', 'list.php?catid=49', 'c', '1', '0', '0', '0', '0', '0', '49', '49', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6,7');
INSERT INTO `ty_category` VALUES ('50', '4', '辅材/工具', '', 'fucai/gongju', 'list.php?catid=50', 'f', '1', '0', '0', '0', '0', '0', '50', '50', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6,7');
INSERT INTO `ty_category` VALUES ('51', '13', '装修主材', '', 'zhuangxiuzhucai', 'list.php?catid=51', 'z', '1', '1', '0', '0', '0', '0', '51', '51', '', '', '', '', '', '3,5,6,7', '3,5,6,7', '6,7');
INSERT INTO `ty_category` VALUES ('52', '21', '行业资讯', '', 'xingyezixun', 'list.php?catid=52', 'x', '1', '9', '0', '0', '0', '0', '52', '52', '', '', '', '', '', '', '', '');
INSERT INTO `ty_category` VALUES ('53', '21', '展会信息', '', 'zhanhuixinxi', 'list.php?catid=53', 'z', '1', '1', '0', '0', '0', '0', '53', '53', '', '', '', '', '', '', '', '');
INSERT INTO `ty_category` VALUES ('54', '21', '最新活动', '', 'zuixinhuodong', 'list.php?catid=54', 'z', '1', '0', '0', '0', '0', '0', '54', '54', '', '', '', '', '', '', '', '');
INSERT INTO `ty_category` VALUES ('55', '21', '技术文库', '', 'jishuwenku', 'list.php?catid=55', 'j', '1', '0', '0', '0', '0', '0', '55', '55', '', '', '', '', '', '', '', '');
INSERT INTO `ty_category` VALUES ('56', '21', '政策法规', '', 'zhengcefagui', 'list.php?catid=56', 'z', '1', '1', '0', '0', '0', '0', '56', '56', '', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for ty_category_option
-- ----------------------------
DROP TABLE IF EXISTS `ty_category_option`;
CREATE TABLE `ty_category_option` (
  `oid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `search` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `extend` text NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`oid`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类属性';

-- ----------------------------
-- Records of ty_category_option
-- ----------------------------

-- ----------------------------
-- Table structure for ty_category_value
-- ----------------------------
DROP TABLE IF EXISTS `ty_category_value`;
CREATE TABLE `ty_category_value` (
  `oid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `value` text NOT NULL,
  KEY `moduleid` (`moduleid`,`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类属性值';

-- ----------------------------
-- Records of ty_category_value
-- ----------------------------

-- ----------------------------
-- Table structure for ty_chat
-- ----------------------------
DROP TABLE IF EXISTS `ty_chat`;
CREATE TABLE `ty_chat` (
  `chatid` varchar(32) NOT NULL,
  `fromuser` varchar(30) NOT NULL,
  `fgettime` int(10) unsigned NOT NULL DEFAULT '0',
  `freadtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fnew` int(10) unsigned NOT NULL DEFAULT '0',
  `touser` varchar(30) NOT NULL,
  `tgettime` int(10) unsigned NOT NULL DEFAULT '0',
  `treadtime` int(10) unsigned NOT NULL DEFAULT '0',
  `tnew` int(10) unsigned NOT NULL DEFAULT '0',
  `lastmsg` varchar(255) NOT NULL,
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  `forward` varchar(255) NOT NULL,
  UNIQUE KEY `chatid` (`chatid`),
  KEY `fromuser` (`fromuser`),
  KEY `touser` (`touser`),
  KEY `lasttime` (`lasttime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='在线聊天';

-- ----------------------------
-- Records of ty_chat
-- ----------------------------

-- ----------------------------
-- Table structure for ty_city
-- ----------------------------
DROP TABLE IF EXISTS `ty_city`;
CREATE TABLE `ty_city` (
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `iparea` mediumtext NOT NULL,
  `domain` varchar(255) NOT NULL DEFAULT '',
  `letter` varchar(4) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `template` varchar(50) NOT NULL DEFAULT '',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `areaid` (`areaid`),
  KEY `domain` (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='城市分站';

-- ----------------------------
-- Records of ty_city
-- ----------------------------

-- ----------------------------
-- Table structure for ty_club
-- ----------------------------
DROP TABLE IF EXISTS `ty_club`;
CREATE TABLE `ty_club` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `gid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `video` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ontop` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `message` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `reply` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `replyuser` varchar(30) NOT NULL,
  `replyer` varchar(30) NOT NULL,
  `replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商圈帖子';

-- ----------------------------
-- Records of ty_club
-- ----------------------------

-- ----------------------------
-- Table structure for ty_club_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_club_data`;
CREATE TABLE `ty_club_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商圈帖子内容';

-- ----------------------------
-- Records of ty_club_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_club_fans
-- ----------------------------
DROP TABLE IF EXISTS `ty_club_fans`;
CREATE TABLE `ty_club_fans` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `reason` mediumtext NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `gid` (`gid`),
  KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商圈粉丝';

-- ----------------------------
-- Records of ty_club_fans
-- ----------------------------

-- ----------------------------
-- Table structure for ty_club_group
-- ----------------------------
DROP TABLE IF EXISTS `ty_club_group`;
CREATE TABLE `ty_club_group` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `style` varchar(50) NOT NULL DEFAULT '',
  `post` int(10) unsigned NOT NULL DEFAULT '0',
  `fans` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL,
  `manager` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL,
  `template` varchar(30) NOT NULL,
  `show_template` varchar(30) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `join_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `list_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `show_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `post_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reply_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reason` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商圈圈子';

-- ----------------------------
-- Records of ty_club_group
-- ----------------------------

-- ----------------------------
-- Table structure for ty_club_manage
-- ----------------------------
DROP TABLE IF EXISTS `ty_club_manage`;
CREATE TABLE `ty_club_manage` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `rid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `typeid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `reason` mediumtext NOT NULL,
  `message` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商圈管理';

-- ----------------------------
-- Records of ty_club_manage
-- ----------------------------

-- ----------------------------
-- Table structure for ty_club_reply
-- ----------------------------
DROP TABLE IF EXISTS `ty_club_reply`;
CREATE TABLE `ty_club_reply` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `gid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `tid` (`tid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商圈回复';

-- ----------------------------
-- Records of ty_club_reply
-- ----------------------------

-- ----------------------------
-- Table structure for ty_comment
-- ----------------------------
DROP TABLE IF EXISTS `ty_comment`;
CREATE TABLE `ty_comment` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_mid` smallint(6) NOT NULL DEFAULT '0',
  `item_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `item_title` varchar(255) NOT NULL DEFAULT '',
  `item_username` varchar(30) NOT NULL DEFAULT '',
  `star` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `qid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `quotation` mediumtext NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reply` mediumtext NOT NULL,
  `editor` varchar(30) NOT NULL DEFAULT '',
  `replyer` varchar(30) NOT NULL DEFAULT '',
  `replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `agree` int(10) unsigned NOT NULL DEFAULT '0',
  `against` int(10) unsigned NOT NULL DEFAULT '0',
  `quote` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `item_mid` (`item_mid`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论';

-- ----------------------------
-- Records of ty_comment
-- ----------------------------

-- ----------------------------
-- Table structure for ty_comment_ban
-- ----------------------------
DROP TABLE IF EXISTS `ty_comment_ban`;
CREATE TABLE `ty_comment_ban` (
  `bid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论禁止';

-- ----------------------------
-- Records of ty_comment_ban
-- ----------------------------

-- ----------------------------
-- Table structure for ty_comment_stat
-- ----------------------------
DROP TABLE IF EXISTS `ty_comment_stat`;
CREATE TABLE `ty_comment_stat` (
  `sid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment` int(10) unsigned NOT NULL DEFAULT '0',
  `star1` int(10) unsigned NOT NULL DEFAULT '0',
  `star2` int(10) unsigned NOT NULL DEFAULT '0',
  `star3` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论统计';

-- ----------------------------
-- Records of ty_comment_stat
-- ----------------------------

-- ----------------------------
-- Table structure for ty_company
-- ----------------------------
DROP TABLE IF EXISTS `ty_company`;
CREATE TABLE `ty_company` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `validator` varchar(100) NOT NULL DEFAULT '',
  `validtime` int(10) unsigned NOT NULL DEFAULT '0',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `vipt` smallint(2) unsigned NOT NULL DEFAULT '0',
  `vipr` smallint(2) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '',
  `catid` varchar(100) NOT NULL DEFAULT '',
  `catids` varchar(100) NOT NULL DEFAULT '',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `mode` varchar(100) NOT NULL DEFAULT '',
  `capital` float unsigned NOT NULL DEFAULT '0',
  `regunit` varchar(15) NOT NULL DEFAULT '',
  `size` varchar(100) NOT NULL DEFAULT '',
  `regyear` varchar(4) NOT NULL DEFAULT '',
  `regcity` varchar(30) NOT NULL DEFAULT '',
  `sell` varchar(255) NOT NULL DEFAULT '',
  `buy` varchar(255) NOT NULL DEFAULT '',
  `business` varchar(255) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `fax` varchar(50) NOT NULL DEFAULT '',
  `mail` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `postcode` varchar(20) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `styletime` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '',
  `skin` varchar(30) NOT NULL DEFAULT '',
  `domain` varchar(100) NOT NULL DEFAULT '',
  `icp` varchar(100) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `register` varchar(50) NOT NULL DEFAULT '' COMMENT '注册号',
  `reoffice` varchar(255) NOT NULL DEFAULT '' COMMENT '登记机关',
  `readdress` varchar(255) NOT NULL DEFAULT '' COMMENT '注册地址',
  `starttime` int(10) NOT NULL DEFAULT '0' COMMENT '营业期限开始时间',
  `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '营业期限结束时间',
  `retime` int(10) NOT NULL DEFAULT '0' COMMENT '成立时间/注册时间',
  `legalPerson` varchar(30) NOT NULL DEFAULT '' COMMENT '法定代表人',
  `annualtime` int(10) NOT NULL DEFAULT '0' COMMENT '年报时间(暂不开启)',
  `mobilePhone` varchar(50) NOT NULL DEFAULT '' COMMENT '移动电话',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '公司简介大图',
  PRIMARY KEY (`userid`),
  KEY `domain` (`domain`),
  KEY `vip` (`vip`),
  KEY `areaid` (`areaid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司';

-- ----------------------------
-- Records of ty_company
-- ----------------------------
INSERT INTO `ty_company` VALUES ('1', 'tianyi', '1', '天医', '0', '0', '', '0', '0', '0', '0', '企业单位', '', '', '1', '', '0', '人民币', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', '0', '', '', '3', '天医默认地区,,,,', '', '', '', '', 'http://www.tianyi.com/index.php?homepage=tianyi', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('3', 'hekw07', '5', '天医', '0', '0', '', '0', '0', '0', '0', '', '', '', '1', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', '0', '', '', '0', '天医', '', '', '', '', 'http://www.tianyi.com/index.php?homepage=hekw07', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('4', 'hekw08', '5', '何楷伟', '0', '0', '', '0', '0', '0', '0', '', '', '', '1', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', '0', '', '', '0', '何楷伟', '', '', '', '', 'http://www.tianyi.com/index.php?homepage=hekw08', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('5', 'zhishuai', '6', '职帅', '0', '0', '', '0', '0', '0', '0', '企业单位', ',3,', ',3,', '231', '制造商', '1000', '人民币', '500-999人', '2004', '', '', '', '装修主材', '13800138000', '', '', '广东广州', '', '', '0', '0', '0', '', '', '10', '职帅,装修主材,,,制造商', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=zhishuai', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('6', 'tianjian', '6', '天健科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',44,3,', ',44,3,', '231', '制造商,贸易商', '1000', '人民币', '500-999人', '2012', '', '', '', '空调', '13800138000', '', '', '广东广州天河', '', '', '0', '0', '0', '', '', '7', '天健科技有限公司广东,广州市,空调,,,制造商,贸易商', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=tianjian', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('7', 'tianyianfang', '6', '天翼安防器械科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',45,44,', ',45,44,', '252', '制造商,贸易商', '200', '人民币', '100-499人', '2011', '', '', '', '安防器械', '13800138000', '', '', '广西南宁市西乡塘区', '', '', '0', '0', '0', '', '', '2', '天翼安防器械科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=tianyianfang', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('8', 'hanzhongshengtu', '6', '汉中市胜途电子科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',45,', ',45,', '343', '制造商,贸易商', '1000', '人民币', '100-499人', '2014', '', '', '', '电子产品，导电滑环的技术开发及销售', '13800138000', '', '', '陕西汉中市', '', '', '0', '0', '0', '', '', '1', '汉中市胜途电子科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=hanzhongshengtu', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('9', 'zhongshankehong', '6', '中山市科鸿电子科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',45,', ',45,', '248', '', '300', '人民币', '', '2008', '', '', '', '安检门、金属探测器、全金属探测仪、检针机、X光安检机', '13800138000', '', '', '广东中山市', '', '', '0', '0', '0', '', '', '2', '中山市科鸿电子科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=zhongshankehong', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('10', 'shanghaiyante', '6', '上海研腾机电科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',45,', ',45,', '2', '制造商,贸易商', '3000', '人民币', '100-499人', '2005', '', '', '', '电机，减速机，振动器，变频器，风机水泵', '13800138000', '', '', '上海市', '', '', '0', '0', '0', '', '', '1', '上海研腾机电科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=shanghaiyante', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('11', 'zhejiangyingyang', '6', '浙江赢阳防爆电器有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',45,', ',45,', '12', '制造商,贸易商', '300', '人民币', '100-499人', '2009', '', '', '', '防爆控制箱，防爆操作柱，防爆插座箱 ，防爆电缆盘，防爆配电柜', '13800138000', '', '', '浙江温州市', '', '', '0', '0', '0', '', '', '0', '浙江赢阳防爆电器有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=zhejiangyingyang', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('12', 'kuzishiye', '6', '库兹实业（上海）有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',45,', ',45,', '2', '制造商,服务商', '500', '人民币', '100-499人', '2006', '', '', '', '15千瓦汽油发电机，15KW汽油发电机，15kw汽油发电机', '13800138000', '', '', '上海', '', '', '0', '0', '0', '', '', '0', '库兹实业（上海）有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=kuzishiye', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('13', 'shenzhenwanxi', '6', '深圳市万嘉鸿福门窗有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',3,', ',3,', '233', '制造商,贸易商', '300', '人民币', '50-99人', '2014', '', '', '', '铝合金门窗 建筑装修装饰', '13800138000', '', '', '广东深圳', '', '', '0', '0', '0', '', '', '0', '深圳市万嘉鸿福门窗有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=shenzhenwanxi', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('14', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '0', '1', '', '1491494400', '1', '1', '0', '企业单位', ',3,', ',3,', '4', '制造商', '1000', '人民币', '100-499人', '2016', '', '', '', '研发、设计、产销：医用空气消毒净化机、中空调消毒净化器装置、半导体空气消毒器、等离子空气消毒器、光氢离子空气净化装置、节能环保设备；无尘车间、环保工程的设计及施工；设计、产销：家用电器、电子产品；货物进出口、技术进出口。（依法须经批准的项目，经相关部门批准后方可开展经营活动）', '0769 81667033', '0769 81661733', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '523861', '', '1491494400', '1523091274', '0', 'http://www.tctianyi.com/file/upload/201704/07/1017535514.jpg', '', '1408', '山东省平邑县瑞泰石业有限公司中国,广东省,广州市,研发、设计、产销：医用空气消毒净化机、中空调消毒净化器装置、半导体空气消毒器、等离子空气消毒器、光氢离子空气净化装置、节能环保设备；无尘车间、环保工程的设计及施工；设计、产销：家用电器、电子产品；货物进出口、技术进出口。（依法须经批准的项目，经相关部门批准后方可开展经营活动）,,,制造商', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=shandongpingyi', '4419000018113771', '东莞市工商行政管理局', '中国广东东莞长安镇乌沙江贝新康路5号', '1491840000', '1492617600', '1388073600', '范小伟', '0', '13724415008', 'http://www.tctianyi.com/file/upload/201705/03/1120061414.gif');
INSERT INTO `ty_company` VALUES ('15', 'laizhoujieli', '6', '莱州结力工贸有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',3,', ',3,', '171', '制造商,贸易商', '0', '人民币', '100-499人', '2012', '', '', '', '树脂瓦、合成树脂瓦、PVC瓦、塑钢瓦、UPVC瓦、无动力扫地机、等产品专业生产加工', '13800138000', '', '', '山东烟台市', '', '', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0959323815.png', '', '341', '莱州结力工贸有限公司山东,烟台市,树脂瓦、合成树脂瓦、PVC瓦、塑钢瓦、UPVC瓦、无动力扫地机、等产品专业生产加工,,,制造商,贸易商', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=laizhoujieli', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('16', 'hebeixinda', '6', '河北廊坊鑫大保温材料有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',3,', ',3,', '44', '制造商,贸易商', '3000', '人民币', '100-499人', '2016', '', '', '', '聚氨酯预制保温管价格,预制聚氨酯直埋保温管价格,直埋保温管价格', '13800138000', '', '', '河北廊坊市', '', '', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0949405516.png', '', '3', '河北廊坊鑫大保温材料有限公司河北,廊坊市,聚氨酯预制保温管价格,预制聚氨酯直埋保温管价格,直埋保温管价格,,,制造商,贸易商', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=hebeixinda', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('17', 'zhongshanyayun', '6', '中山市雅云灯饰有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',3,', ',3,', '248', '制造商,服务商', '300', '人民币', '100-499人', '2006', '', '', '', '云石灯,全铜灯,西班牙云石灯,天然云石灯,全铜云石灯,红木云石灯,仿云石灯,酒店灯具', '13800138000', '', '', '广东省中山市', '', '', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0935214117.jpg', '', '13', '中山市雅云灯饰有限公司广东,中山市,云石灯,全铜灯,西班牙云石灯,天然云石灯,全铜云石灯,红木云石灯,仿云石灯,酒店灯具,,,制造商,服务商', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=zhongshanyayun', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('18', 'zhongshanxingdi', '6', '中山市星迪照明电器有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',3,', ',3,', '248', '制造商,贸易商', '0', '人民币', '50-99人', '2014', '', '', '', '壁灯;壁灯批发;壁灯价格;壁灯供应信息;壁灯多少钱;壁灯哪家最好;壁灯厂;壁灯网', '13800138000', '', '', '广东中山市', '', '', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0945139318.png', '', '26', '中山市星迪照明电器有限公司广东,中山市,壁灯;壁灯批发;壁灯价格;壁灯供应信息;壁灯多少钱;壁灯哪家最好;壁灯厂;壁灯网,,,制造商,贸易商', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=zhongshanxingdi', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('19', 'hulunbeier', '6', '呼伦贝尔市晨光灯具厂', '0', '0', '', '0', '0', '0', '0', '企业单位', ',3,', ',3,', '63', '制造商', '400', '人民币', '50-99人', '2014', '', '', '', '壁灯;壁灯批发;壁灯价格;壁灯供应信息;壁灯多少钱;壁灯哪家最好;壁灯厂;壁灯网', '13800138000', '', '', '内蒙古呼伦贝尔', '', '', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/06/1155424319.jpg', '', '93', '呼伦贝尔市晨光灯具厂内蒙古,呼伦贝尔市,壁灯;壁灯批发;壁灯价格;壁灯供应信息;壁灯多少钱;壁灯哪家最好;壁灯厂;壁灯网,,,制造商', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=hulunbeier', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('20', 'qingdaojutai', '6', '青岛聚泰净化空调有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',44,', ',44,', '167', '制造商', '0', '人民币', '100-499人', '2012', '', '', '', '承揽国际标准层流手术室； 各行业净化空调车间的设计、施工； 实验室装备', '13800138000', '', '', '山东青岛', '', '', '0', '0', '0', '', '', '0', '青岛聚泰净化空调有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=qingdaojutai', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('21', 'nanjingtianjia', '6', '南京天加空调设备有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',44,', ',44,', '105', '制造商,服务商', '3000', '人民币', '100-499人', '2012', '', '', '', '空调', '13800138000', '', '', '江苏南京', '', '', '0', '0', '0', '', '', '0', '南京天加空调设备有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=nanjingtianjia', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('22', 'jinlida', '6', '金利达空调净化设备有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',44,', ',44,', '118', '制造商', '3000', '人民币', '50-99人', '2013', '', '', '', '洁净室;净化设备', '13800138000', '', '', '浙江杭州', '', '', '0', '0', '0', '', '', '1', '金利达空调净化设备有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=jinlida', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('23', 'guangzhousutai', '6', '广州市苏泰空调净化设备有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',44,', ',44,', '231', '制造商', '4000', '人民币', '100-499人', '2008', '', '', '', '激光尘埃粒子计数器、超净间粒子监测系统、浮游菌采样器、激光粉尘仪、风速仪、微压差仪、温湿度计、声级计等净化系统测试仪器', '13800138000', '', '', '广东广州', '', '', '0', '0', '0', '', '', '0', '广州市苏泰空调净化设备有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=guangzhousutai', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('24', 'hebeihongyun', '6', '河北宏润重工股份有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',46,', ',46,', '43', '制造商,服务商', '4000', '人民币', '500-999人', '2012', '', '', '', '电力，化工，石油，石化，船舶', '13800138000', '', '', '河北沧州', '', '', '0', '0', '0', '', '', '0', '河北宏润重工股份有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=hebeihongyun', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('25', 'lizhiheng', '6', '力之恒管道科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',46,46,', ',46,', '150', '制造商,贸易商', '200', '人民币', '100-499人', '2003', '', '', '', 'PP-R、PE管材管件', '13800138000', '', '', '福建泉州', '', '', '0', '0', '0', '', '', '0', '力之恒管道科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=lizhiheng', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('26', 'shanghaiyuansu', '6', '上海源朔贸易有限公司', '0', '0', '', '0', '0', '0', '0', '个体经营', ',46,', ',46,', '2', '制造商,贸易商', '100', '人民币', '1-49人', '2012', '', '', '', '建筑、建材类管材;其他建筑、建材类管材;PPR管;PVC管;装饰建材代理加盟;水暖五金;', '13800138000', '', '', '上海市', '', '', '0', '0', '0', '', '', '0', '上海源朔贸易有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=shanghaiyuansu', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('27', 'meijiahua', '6', '衢州市美加华管业有限公司', '0', '0', '', '0', '0', '0', '0', '个体经营', ',46,', ',46,', '125', '制造商', '2000', '人民币', '100-499人', '2009', '', '', '', 'PE管;PPR管;PVC管;', '13800138000', '', '', '浙江衡州', '', '', '0', '0', '0', '', '', '0', '衢州市美加华管业有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=meijiahua', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('28', 'dengquan', '6', '邓权塑业科技（湖南）有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',46,', ',46,', '223', '制造商,贸易商', '200000', '人民币', '1000-3000人', '2001', '', '', '', 'PE管;建筑、建材类管材;PPR管;其他建筑、建材类管材;镀锌管;PVC管;', '13800138000', '', '', '湖南常德', '', '', '0', '0', '0', '', '', '0', '邓权塑业科技（湖南）有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=dengquan', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('29', 'jinhui', '6', '青岛金辉管业有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',46,', ',46,', '167', '制造商,贸易商', '2000', '人民币', '1-49人', '2003', '', '', '', 'PERT地暖管，POM管件', '13800138000', '', '', '山东青岛', '', '', '0', '0', '0', '', '', '0', '青岛金辉管业有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=jinhui', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('30', 'dimaikesi', '6', '帝麦克斯（苏州）医疗科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',47,', ',47,', '109', '制造商', '2000', '人民币', '100-499人', '2004', '', '', '', '研发、生产、销售数字显微仪器、数字病理远程诊断系统', '13084927@qq.com', '', '', '江苏苏州', '', '', '0', '0', '0', '', '', '0', '帝麦克斯（苏州）医疗科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=dimaikesi', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('31', 'lulu', '6', '上海豫沪实业限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',47,', ',47,', '2', '制造商', '3000', '人民币', '100-499人', '2012', '', '', '', '石油，医药，造纸，造船，核电，军工，机械，锅炉交换器等', '13800138000', '', '', '上海市', '', '', '0', '0', '0', '', '', '0', '上海豫沪实业限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=lulu', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('32', 'anterui', '6', '深圳市安特瑞智能科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',47,', ',47,', '233', '制造商', '2000', '人民币', '50-99人', '2013', '', '', '', '智能小区大型总线制报警系统、工厂企业围墙周界报警系统、家用\\商用电话联网报警系', '13800138000', '', '', '广东深圳', '', '', '0', '0', '0', '', '', '9', '深圳市安特瑞智能科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=anterui', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('33', 'guying', '6', '山东固赢实验设备有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',47,', ',47,', '168', '制造商,贸易商', '1000', '人民币', '50-99人', '2006', '', '', '', '全钢实验家具,钢木实验家具,pp实验家具', '13800138000', '', '', '山东淄博', '', '', '0', '0', '0', '', '', '0', '山东固赢实验设备有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=guying', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('34', 'qipu', '6', '上海气谱仪器设备有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',48,', ',48,', '2', '制造商,贸易商', '2000', '人民币', '100-499人', '2001', '', '', '', '气相色谱仪、液相色谱仪、液化气分析仪、天然气分析仪、气体发生器', '13800138000', '', '', '上海市', '', '', '0', '0', '0', '', '', '0', '上海气谱仪器设备有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=qipu', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('35', 'dongyi', '6', '山东东易日盛仪器有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',48,', ',48,', '182', '制造商,贸易商', '3000', '人民币', '50-99人', '2001', '', '', '', '实验室分析仪器', '13800138000', '', '', '山东泽和', '', '', '0', '0', '0', '', '', '0', '山东东易日盛仪器有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=dongyi', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('36', 'mengmeiyi', '6', '深圳市梦美怡美容仪器有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',48,', ',48,', '233', '制造商,贸易商', '2000', '人民币', '100-499人', '2012', '', '', '', '生产研发销售美容美体仪器', '13800138000', '', '', '广东深圳', '', '', '0', '0', '0', '', '', '0', '深圳市梦美怡美容仪器有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=mengmeiyi', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('37', 'zhongjian', '6', '沧州中建精密仪器有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',48,', ',48,', '43', '制造商', '300', '人民币', '50-99人', '2015', '', '', '', '公路试验仪器，建筑仪器，五金工具', '13800138000', '', '', '河北沧州', '', '', '0', '0', '0', '', '', '0', '沧州中建精密仪器有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=zhongjian', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('38', 'hengpu', '6', '佛山市衡普环境试验设备有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',48,', ',48,', '236', '制造商', '3000', '人民币', '50-99人', '2013', '', '', '', '变频电源;仪器仪表;安全性能综合测试仪;耐压测试仪;接地电阻测试仪;盐雾实验箱;', '13800138000', '', '', '广东佛山', '', '', '0', '0', '0', '', '', '0', '佛山市衡普环境试验设备有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=hengpu', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('39', 'deli', '6', '陕西德力能源科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',49,', ',49,', '341', '制造商,贸易商', '3000', '人民币', '50-99人', '2016', '', '', '', '模块锅炉|甲醇锅炉|冷凝模块炉|燃煤真空|', '13800138000', '', '', '陕西淮南', '', '', '0', '0', '0', '', '', '0', '陕西德力能源科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=deli', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('40', 'weinun', '6', '上海伟暖实业有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',49,', ',49,', '2', '制造商,贸易商', '100', '人民币', '100-499人', '2003', '', '', '', '地暖，电采暖，碳纤维地暖，电热膜，发热电缆', '13800138000', '', '', '上海市', '', '', '0', '0', '0', '', '', '0', '上海伟暖实业有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=weinun', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('41', 'wolu', '6', '郑州锅炉股份有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',49,', ',49,', '183', '制造商,贸易商', '200', '人民币', '1-49人', '2006', '', '', '', '燃油燃气锅炉，生物质锅炉，循环流化床锅炉，蒸压釜，硫化罐', '13800138000', '', '', '河南郑州', '', '', '0', '0', '0', '', '', '0', '郑州锅炉股份有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=wolu', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('42', 'maizhong', '6', '厦门迈众机电设备工程有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',49,', ',49,', '147', '制造商', '200', '人民币', '50-99人', '2009', '', '', '', '离心泵、排污泵、消防泵、变频供水机组、定压补水装置等', '13800138000', '', '', '福建厦门', '', '', '0', '0', '0', '', '', '0', '厦门迈众机电设备工程有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=maizhong', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('43', 'huazhicheng', '6', '济南华之成节能科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',49,', ',49,', '166', '制造商', '3000', '人民币', '50-99人', '2007', '', '', '', '空气能热水器、烘干热泵、暖通设备', '13800138000', '', '', '山东济南', '', '', '0', '0', '0', '', '', '0', '济南华之成节能科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=huazhicheng', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('44', 'fumushi', '6', '广州福姆斯绝热材料有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',50,', ',50,', '231', '制造商,贸易商', '100', '人民币', '50-99人', '2009', '', '', '', '橡塑保温材料|达科特风管|壳耐特外保护材料|米丝特玻璃棉', '13800138000', '', '', '广东广州', '', '', '0', '0', '0', '', '', '0', '广州福姆斯绝热材料有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=fumushi', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('45', 'bodun', '6', '东莞市博盾金属材料科技有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',50,', ',50,', '247', '制造商,贸易商', '200', '人民币', '50-99人', '2006', '', '', '', '金属材料.金属制品、五金模具：销售刀具、电子元器件', '13800138000', '', '', '广东东莞', '', '', '0', '0', '0', '', '', '0', '东莞市博盾金属材料科技有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=bodun', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('46', 'guangtong', '6', '霸州市城区广通线路工具厂', '0', '0', '', '0', '0', '0', '0', '企业单位', ',50,', ',50,', '44', '制造商', '500', '人民币', '50-99人', '2000', '', '', '', '户外真空断路器、高低压隔离开关、复合式绝缘子、跌落式熔断器、避雷器', '13800138000', '', '', '河北廊坊', '', '', '0', '0', '0', '', '', '0', '霸州市城区广通线路工具厂', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=guangtong', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('47', 'taihong', '6', '杭州泰宏五金工具有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',50,', ',50,', '118', '制造商', '50', '人民币', '50-99人', '2004', '', '', '', '黄油枪;汽保工具;五金工具;自行车配件;吸油枪;滤清器扳手;螺丝取出器', '13800138000', '', '', '浙江杭州', '', '', '0', '0', '0', '', '', '0', '杭州泰宏五金工具有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=taihong', '', '', '', '0', '0', '0', '', '0', '', '');
INSERT INTO `ty_company` VALUES ('48', 'xinxin', '6', '武汉鑫信合电子工具有限公司', '0', '0', '', '0', '0', '0', '0', '企业单位', ',50,', ',50,', '200', '制造商', '10', '人民币', '1-49人', '2011', '', '', '', '磁座钻;磁力钻;空心钻;空心钻头;取芯钻头;国产磁力钻;进口磁力钻;电钻;切割机;角磨', '13800138000', '', '', '湖北武汉', '', '', '0', '0', '0', '', '', '2', '武汉鑫信合电子工具有限公司', '', '', '', '', 'http://www.tctianyi.com/index.php?homepage=xinxin', '', '', '', '0', '0', '0', '', '0', '', '');

-- ----------------------------
-- Table structure for ty_company_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_company_data`;
CREATE TABLE `ty_company_data` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司内容';

-- ----------------------------
-- Records of ty_company_data
-- ----------------------------
INSERT INTO `ty_company_data` VALUES ('1', '&nbsp;');
INSERT INTO `ty_company_data` VALUES ('3', '');
INSERT INTO `ty_company_data` VALUES ('4', '');
INSERT INTO `ty_company_data` VALUES ('5', '&nbsp;是大法师发顺丰是打发斯蒂芬');
INSERT INTO `ty_company_data` VALUES ('6', '<br />\r\n是打发斯蒂芬是的发送到发放');
INSERT INTO `ty_company_data` VALUES ('7', '发送到发送到发送到发送到发送到发送到发<br />');
INSERT INTO `ty_company_data` VALUES ('8', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;胜途电子有限公司是一家拥有一支由多年从事导电滑环应用和开发的资深工程师组成的开发团队，拥有多年的导电滑环应用及开发经验，专注于研发,生产工业导电滑环的高科技公司。多年的应用开发经验，使得我们更深入的了解客户的需求，能在最短的时间为客户提供最佳旋转解决方案，协助客户缩短开发时间。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;&nbsp;&nbsp;&nbsp; 胜途电子有能力为您开发和生产光纤组合(FORJ)、电气液混合、高频组合(High frequency)、导波管(wave guides)组合滑环等，我们提供各种工作环境下的电接触装置，从水下环境到高海拔地区、从高寒地带到高温环境，目前产品应用已包含安防、工业自动化、军事、环保等领域。出色的性能和可靠的品质，使得胜途电子所生产的导电滑环批量销往工业发达国家，如日本、美国、欧洲等，获得客户的赞誉，并成为部分高可靠性要求客户的唯一滑环供应商。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;&nbsp;&nbsp; 秉承&ldquo;认真第一、忠诚做事，成为客户最可信赖的合作伙伴&rdquo;之经营理念，胜途电子将一如既往地认真做好每一件事情，忠诚于每一个客户，为客户提供高质量的导电滑环产品和最佳解决方案。</span>');
INSERT INTO `ty_company_data` VALUES ('9', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">中山市科鸿电子科技有限公司是集安检产品研发、生产、销售及服务为一体的高科技企业。公司的主要产品有金属探测安检门、手持式金属探测器、运输式全金属检测仪、分体式金属检测仪、地下金属探测器、X光行李安检机、商品防盗系统等。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司产品广泛应用于公检法部门、监狱、银行、机场、公路铁路、车站码头、海关港口、娱乐场所、各工矿企事业单位、电子厂、五金厂、超市、商场、服装店等领域。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司拥有先进的生产设备和检测设备，以此推动各项管理的系统标准化，对品质的追求以产品&ldquo;零&rdquo;缺陷为目标。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">完善的营销管理体系和售后服务体系可以为用户提供规范化的专业服务。公司将以市场需求为导向，超越自我，引导潮流，全心全意为用户提供精致、个性化产品和服务！</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">科技改变未来，安全重于泰山。科鸿电子，用科技铸造安全！</span>');
INSERT INTO `ty_company_data` VALUES ('10', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">本公司将一直致力于成为最优秀的传动服务提供者，以向我们的用户提供高效、稳定、强大的动力支持为己任。主导产品是全球领导品牌电机、减速机变速机、风机水泵、气动振动器等及其相关配件。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">我们的产品已广泛应用于电力、石化、冶金、机械、造纸、食品、轻工、纺织、制造、环保、食品、医药、化工、农药、饲料、陶瓷、玻璃、水泥、燃料等粉体加工行业、建筑机械、粮食机械、矿山机械、铸造机械等领域。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">本公司一直以诚信为本，以客户的价值为根本，建立了较为良好的口碑，并能为客户及时提供产品和售后服务。此外，为满足客户的产品需求，我们还将不断地开发新产品，为客户创造更多的价值。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">主营：意大利OLI振动电机、意大利OLI气动振动器、德国SIEMENS西门子电机、ABB电机、台湾TECO东元电机、LS LEROY-SOMER电机、巴西WEG电机。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">减速机（SEW，MOTOVARIO，VGM，PHT，CHENDA，CPG，TWT，传仕）</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">变频器（艾默生CT，SIEMENS，TECO，HOLIP，CONVO）</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">水泵（台湾光泉，台湾川源，德国西门子）</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">风机（台湾全风）及各类伺服马达、搅拌机、电机配件销售及维修服务等。</span>');
INSERT INTO `ty_company_data` VALUES ('11', '<br />\r\n<h4 style=\"widows: 2; text-transform: none; background-color: rgb(239,239,239); font-style: normal; text-indent: 0px; margin: 0px 0px 0px 10px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(51,51,51); font-size: 15px; word-break: break-all; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\"><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">本公司主要生产：防爆配电箱、防爆照明配电箱、防爆动力配电箱、防爆检修箱、防爆配电柜、防爆电源箱、防爆控制箱、防爆断路器、防爆起动器、防爆电缆盘、防爆插座箱、防爆操作柱、防爆变频器、防爆动力柜、防爆操作箱、隔爆型防爆灯、防爆荧光灯、防爆应急灯、防爆投光灯、防爆泛光灯、防爆标志灯、防爆安全出口灯、增安型防爆灯、防爆视孔灯、防爆吸顶灯、防爆路灯、防爆声光报警器等各种箱柜、灯具、开关按钮、管件附件类厂用、船用防爆电器；</span></h4>');
INSERT INTO `ty_company_data` VALUES ('12', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">库兹实业（上海）有限公司，简称：库兹</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">KURZ</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">，成立于</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">2003</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">年</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">7</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">月，总部位于德国曼海姆市（</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">Mannheim</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">），亚洲总部设在中国上海，专注、专业于小型汽油发电机、小型柴油发电机、多燃料静音发电机组，发电电焊机，汽油发电焊机，柴油发电焊机，水泵等。</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\"><span class=\"Apple-converted-space\">&nbsp;</span><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">库兹</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">(KURZ)</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">是全球最大的独立发动机制造商之一，成立于</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">1919</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">年</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">2</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">月，致力于内燃机、柴油和代用燃料发动机，发动机关键零部件（燃油系统、控制系统、进气处理、滤清系统和尾气处理系统等）以及发电系统。</span>');
INSERT INTO `ty_company_data` VALUES ('13', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">深圳市万嘉鸿福门窗有限公司是从事中高档门窗产品设计、生产、销售的现代门窗生产企业。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">万嘉鸿福门窗创立至今发展成为拥有一支的技术研发和专业生产的队伍，不断引进国外先进全套门窗加工设备，自主研发铝合金门窗系统，主要生产中高档铝合金推拉门、铝合金平开门、铝合金组合窗、铝合金折叠门、铝合金阳光房及其他类铝合金门窗配件产品。万嘉鸿福秉承以优质品质、舒适空间的研发和制造理念，致力打造一个门窗行业优质品牌形象。公司所有产品均选用优质进口材料及精良配件为客户量身定做。在不断发展的过程中，凭借时尚人性化的设计和优质真诚的服务，不断开拓门窗设计、研发新高地。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">热情的欢迎各界朋友来我司参观，洽谈，合作！</span>');
INSERT INTO `ty_company_data` VALUES ('14', '<div style=\"\">\r\n<div><img src=\"http://www.tctianyi.com/file/upload/201704/28/1416128414.gif\" width=\"463\" height=\"300\" vspace=\"5\" hspace=\"5\" align=\"right\" alt=\"\" />东莞市伟一环境科技有限公司，是香港伟一实业与中山大学达安基因股份有限公司联手组建的一家高新技术企业，专业从事医用空气消毒机、 空气消毒净化机、中央空调消毒净化装置等产品，集研发、生产、销售、售后服务为一体的股份制公司。&nbsp;</div>\r\n<div>公司以自主创新为主题，加大技术研发投入力度，着力提升技术自主创新能力，掌握产品核心技术，不断增强产品市场竞争力，公司拥有知深的空气消毒净化专家和专业从事空气消毒净化产品研发的科研人员。产品经法定权威机构检测，室内空气中自然菌消亡率达99%,净化效率&ge;90%。产品通过广东省卫生和计生委现场审核并颁发了消毒产品生产企业卫生许可证，拥有空气消毒净化核心技术&mdash;&mdash;三元半导体消毒净化技术，并荣获多项国家实用新专利和发明专利。&nbsp;</div>\r\n<div>公司自成立以来，一直坚持走自主创新的道路，坚持&ldquo;科技领先，优质高效，客户至上，尊信守约&ldquo;的理念及质量方针，不断增强公司的核心竞争力。公司目前已经汇聚了全国知名的老专家和专业从事消毒产品研发工作的科研人员。综合世界发达国家先进技术与经验，结合我国国情和医疗卫生行业的需求，自行创新设计，已经成功地研制出了性能独特，具有国内领先水平空气消毒净化设备。<br />\r\n&nbsp;&ldquo;专业精湛、优质服务&rdquo;是公司永恒的宗旨，为我们的客户提供&ldquo;零缺陷&rdquo;的产品和周到的服务是公司每位员工始终不渝的奋斗目标。&nbsp;</div>\r\n<div>在未来的3-5年内，伟一环境科技将一一坚持以医用空气消毒器的自主研发、制造、销售为主，积极巩固和加强原有国内市场的市场地位，积极拓展国内其他市场及出口市场的市场空间，并树立和巩固市场地位。是致力于改善公共场所、医疗及中央空调系统下室内环境、提供室内空气质量、集工程承接及空气净化消毒产品、过滤清净产品的研发、生产、安装及技术资讯服务与一体科技型科技企业。</div>\r\n</div>');
INSERT INTO `ty_company_data` VALUES ('15', '<h4 style=\"widows: 2; text-transform: none; background-color: rgb(239,239,239); font-style: normal; text-indent: 0px; margin: 0px 0px 0px 10px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(51,51,51); font-size: 15px; word-break: break-all; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\"><span style=\"line-height: 24px; font-family: Verdana, Arial; font-size: 16px; word-break: break-all; text-size-adjust: none\">莱州结力工贸有限公司是树脂瓦、合成树脂瓦、PVC瓦、塑钢瓦、UPVC瓦、无动力扫地机、等产品专业生产加工的公司，拥有完整、科学的质量管理体系。莱州结力工贸有限公司的诚信、实力和产品质量获得业界的认可。欢迎各界朋友莅临参观、指导和业务洽谈。</span></h4>\r\n<p style=\"widows: 2; text-transform: none; background-color: rgb(247,247,247); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: \"><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n<span style=\"line-height: 24px; font-family: Verdana, Arial; font-size: 16px; word-break: break-all; text-size-adjust: none\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 莱州结力工贸有限公司始建于1992年，1998年由莱州市属企业改制为有限责任公司，地处莱州市经济技术开发区，占地5.1万平方米，建筑面积3.8万平方米，注册资本1000万元。外设结力建材分厂一处，销售机构80余个，内设科技研发中心、国际贸易部以及生产、技术、质量、企业管理等10个综合性部室，员工500余人，其中工程技术人员36人，净资产8000余万元，年生产规模超过亿元。<br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n公司致力于 &ldquo;创一流品牌、塑百年结力&rdquo;的奋斗目标，经过十几年的不懈努力，创建了优良的生产生活环境，一流的生产设备设施，规范的检验检测手段， 先进的电子管理系统，完善的质量保证体系，为高品质产品生产提供了坚实的平台。</span></p>');
INSERT INTO `ty_company_data` VALUES ('16', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !im<em></em>portant; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">河北廊坊鑫大保温材料有限公司（http://xdjt888.jdol.com.cn/），是集科研、生产、销售、施工、服务于一体的现代化经济实体企业，公司地处京津、石三大城市中心地段，地理位置十分优越，交通便利。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !im<em></em>portant; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;&nbsp;公司占地面积28050平米，公司技术力量雄厚，拥有国内最先进的生产设备，独特的生产工艺和尖端的质量检测手段，并且还注入了大批高技术人才和管理人员，从而决定了产品的优越品质，使之企业不断壮大，蓬勃发展。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !im<em></em>portant; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;&nbsp;公司主要生产高密度聚乙烯外套管，玻璃钢缠绕管道，聚氨酯直埋保温管，钢套钢蒸汽保温管，保温外玻璃钢纱缠绕管道，聚氨酯(板管)型材等。公司可根据客户要求：&ldquo;量身定做&rdquo;各种异型产品，做到科学设计，合理施工，几年来，公司凭借着产品优越的品质、合理的价格、完善的服务，诚信的行为，铸就了鑫大自己的品牌，也成功参加了国内许多工程的建设和改造。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !im<em></em>portant; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;&nbsp;公司以客户为中心，以高新技术为先导，保持与国际先进技术同步发展，严把产品质量关，使我们的各类产品畅销全国29个省市自治区，广泛用于供热，建筑，石油、电力、化工、冷藏、船舶，航天、冶炼、中央空调等行业，产品质量在同行中处于领先地位，并得到相...<span class=\"Apple-converted-space\">&nbsp;</span></span>');
INSERT INTO `ty_company_data` VALUES ('17', '<br />\r\n<div>中山市雅云灯饰有限公司--云石灯厂家、会所别墅灯具品牌、中高端灯饰经销商首选供应厂商，专注西班牙天然云石灯,全铜云石灯,红木云石灯,全铜灯,红木灯,别墅灯具,酒店灯具,会所灯具,仿云石灯生产等。为酒店、会所、别墅、豪宅、地产、办公楼、影剧院、娱乐中心等高级场所提供各类高档灯具定制。</div>\r\n<div>雅云灯饰集灯饰设计、生产、销售于一体，运用自身生产优势，注重灯具质量控制，致力于高端灯具品牌，以完美的产品和服务，来实现回报社会和客户的目标。雅云灯饰以上等品质、亲民款式、优质服务而受到用户的一致好评。顾客满意是我们产品质量的终极标准，也是公司永恒的追求。欢迎各界朋友光临指导，合作共赢！</div>');
INSERT INTO `ty_company_data` VALUES ('18', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !im<em></em>portant; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">做到产品质量层层把关。 公司重视管理，追求完美，不仅建立了以现代企业制度为核心的企业管理机制，而且执行&ldquo;零缺陷&rdquo;的产品质量管理体系。精英化的职业经理人团队，将企业内外部资源最大化地优化整合，使企业的产品研发能力、生产制造能力、管理创新能力、决策执行能力、渠道整合能力、品牌推广能力与日俱增。 本公司属下品牌&ldquo;好到佳&rdquo;系列产品包括：LED护眼台灯、LED壁灯、LED酒店台灯、LED吊灯、LED落地灯、LED阅读壁灯、LED床头灯、LED创意台灯、LED礼品台灯，品种多样，规格齐全。全部产品已通过CE、UL、VDE、CCC等过内外认证。产品远销美国、加拿大、英国、德国、瑞典等二十多个国家和地区。我们将以&ldquo;品质保证、服务专业、顾客满意&rdquo;为经营宗旨，开拓进取，务实创新，将最好的产品与服务带给最需要的消费者。 我们在注重产品质量和企业信誉的同时，不断引进专业技术人才和现代化经营管理模式，完善的售后服务呈现于广大用户。实干、劳作是我们可靠的财富。用我们的智慧实现承诺，塑造行业的精品；用我们的真诚广交社会各界朋友；以最具竞争力的产品和最优质的服务回报广大客户对我们的厚爱。</span>');
INSERT INTO `ty_company_data` VALUES ('19', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !im<em></em>portant; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">目标：国内照明灯饰实用者给您提供最精美的家居装饰灯具饰产品，本着持续经营、产品独特、完善的售后为一体。 以现代灯具为主营：LED灯具 水晶灯 风扇灯具 搭配出&ldquo;好家装=好嫁妆&rdquo; 我们产品以：实用、健康节能、靓丽、大气、绿色、光效为主。 我们的服务：好家装=好嫁妆。服务于民生，为你做名声。 企业现有产品百余种，符合3C ROHS 等品质，我们主要生产LED灯具、风扇灯、装饰水晶吊灯、现代风格灯具 吸顶灯、欧式仿古吊灯/台灯/落地灯/壁灯.可来样板订做。我们将以&ldquo;品质保证、服务专业、顾客满意&rdquo;为经营宗旨，开拓进取，务实创新，将最好的产品与服务带给最需要的消费者。 我们在注重产品质量和企业信誉的同时，不断引进专业技术人才和现代化经营管理模式，完善的售后服务呈现于广大用户。实干、劳作是我们可靠的财富。用我们的智慧实现承诺，塑造行业的精品；用我们的真诚广交社会各界朋友；以最具竞争力的产品和最优质的服务回报广大客户对我们的厚爱。</span>');
INSERT INTO `ty_company_data` VALUES ('20', '<br />\r\n<p style=\"border-bottom: 0px; border-left: 0px; padding-bottom: 0px; widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 2em; margin: 0px; padding-left: 0px; letter-spacing: normal; padding-right: 0px; font-family: Tahoma, Arial, 宋体b8b体, sans-serif; white-space: normal; orphans: 2; color: rgb(79,79,79); font-size: 12px; border-top: 0px; font-weight: normal; border-right: 0px; word-spacing: 0px; padding-top: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">青岛聚泰净化空调有限公司是专注于净化空调设备、洁净空调系统、净水设备、专用地坪开发、生产、安装施工的高科技企业，公司下设净化项目事业部、空调事业部、专用地坪事业部、净化消毒设备事业部、水处理设备事业部、质量控制部、环保技术研发中心等生产、科研、销售实体，工程技术人员占企业职工总数的67%。</p>\r\n<p style=\"border-bottom: 0px; border-left: 0px; padding-bottom: 0px; widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 2em; margin: 0px; padding-left: 0px; letter-spacing: normal; padding-right: 0px; font-family: Tahoma, Arial, 宋体b8b体, sans-serif; white-space: normal; orphans: 2; color: rgb(79,79,79); font-size: 12px; border-top: 0px; font-weight: normal; border-right: 0px; word-spacing: 0px; padding-top: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">　　公司自创建以来，秉承&ldquo;自强不息，厚德载物&rdquo;的民族传统，坚持&ldquo;以德为基，以人为本&rdquo;的企业管理理念，以科技为先导，积极搭建人才成长的发展平台，且长年紧密与大专院校合作，使本企业之生产技术始终处于领先水平；先后成为中国制冷空调工业协会、中国电子工业协会会员单位；全面通过ISO9001国际质量管理体系和ISO14001国际环境管理体系认证。</p>\r\n<p style=\"border-bottom: 0px; border-left: 0px; padding-bottom: 0px; widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 2em; margin: 0px; padding-left: 0px; letter-spacing: normal; padding-right: 0px; font-family: Tahoma, Arial, 宋体b8b体, sans-serif; white-space: normal; orphans: 2; color: rgb(79,79,79); font-size: 12px; border-top: 0px; font-weight: normal; border-right: 0px; word-spacing: 0px; padding-top: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;</p>\r\n<p style=\"border-bottom: 0px; border-left: 0px; padding-bottom: 0px; widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 2em; margin: 0px; padding-left: 0px; letter-spacing: normal; padding-right: 0px; font-family: Tahoma, Arial, 宋体b8b体, sans-serif; white-space: normal; orphans: 2; color: rgb(79,79,79); font-size: 12px; border-top: 0px; font-weight: normal; border-right: 0px; word-spacing: 0px; padding-top: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">本公司的主营产品：承揽国际标准层流手术室； 各行业净化空调车间的设计、施工； 实验室装备； 塑胶地坪及专用地板； 净化、空调设备及配件的生产； 水处理设备的设计生产。</p>');
INSERT INTO `ty_company_data` VALUES ('21', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; float: none; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">天加是集研发、制造、销售、服务于一体的中央空调及冷冻设备的国家高新技术企业，是中国质量服 务信誉AAA级企业，注册资本1728万美元。在南京、天津、广州建有生产基地，全球70多个&nbsp; 销售和服务网点，销售年均增长30%，已成为行业内公认的最有竞争力、运营最健康的企业之一。作为中国制冷工业协会副理事长单位和中国制冷工业协会洁净技术委员会主任单位，公司生产的中央空调主机和商用机在市场上有强大的竞争力，空气处理机组市场占有率第一。天加荣获国家001号绿色工业建筑认证，在绿色节能理念和运营上赢得了示范性标杆性荣誉。公司获联合国环保署及国家环保部共同资助，成为中国空调行业首批四家环保冷媒替代示范工厂。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; float: none; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;天加一期投资4.5亿建成国内等级最高的中央空调制造研发基地。测试中心近20座国家级实验室，已获得国家认可委CNAS认证，将打造成国家级研发公共服务平台。天加代表行业正在制订中国微电子行业洁净空气处理10万风量一级净化的国家标准，将为高世代液晶产业以及中国微电子行业的发展做出贡献。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; float: none; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">人才是天加发展最重要的资本。天加需要培养一大批有学识有见识有胆识、德才兼备的人才队伍共创大业。我们以自我培养为主，同时吸引各类高科技人才加盟，并与清华、西安交大、东南大学等高校形成紧密的产学研关系。只有当建立了一个优秀人才考核体系并适合人才发展的环境机制，才可成为天加可持续发展最重要的基石。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; float: none; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">品质提升我们的世界，是天加人的使命。我们深知中国是制造大国而非强国，为此天加推行&ldquo;质量精进计划&rdquo;，引进日本高管团队，从5S、标准化、流程、执行力等基础管理工作入手，全面提升从总经理到基础员工的整体素养，通过多年的奋斗，使天加产品质量达到日本制造水准！</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; float: none; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">天加公司秉承&ldquo;唯有努力我们才能生存&rdquo;的信念。&ldquo;诚信闯天下，质量赢民心&rdquo;，以客户为中心，坚持将品质和创新作为企业行为的出发点，做专做强，实现2016年销售规模达到50亿的目标。天加发展任重而道远，天加人将坚守我们一直在努力的精神，夯实基础工作，使天加发展成具有国际竞争力的世界一流公司。</span>');
INSERT INTO `ty_company_data` VALUES ('22', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; float: none; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">彩钢板;彩钢夹芯板;岩棉夹芯板;不锈钢夹芯板;EPS夹芯板;PU聚氨酯夹芯板;烘房烘道夹芯板;净化工程;洁净室;净化设备;风淋室;洁净工作台;高效过滤器;高效送风口;自净器;防火阀;风量调节阀;传递窗;洁净地漏;散流器</span>');
INSERT INTO `ty_company_data` VALUES ('23', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 28px; letter-spacing: normal; display: inline !important; font-family: &quot;Microsoft Yahei&quot;, 微软雅黑, simsun; white-space: normal; orphans: 2; float: none; color: rgb(79,79,79); font-size: 14px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">广州市苏泰空调净化设备有限公司是专业生产销售净化产品、承接各类净化系统工程的专业公司，负责江苏苏净集团有限公司&middot;苏州安泰空气技术有限公司、苏州华泰空气过滤器有限公司、苏州苏净仪器自控设备有限公司产品在华南地区的销售及售后服务。中日合资&middot;苏州安泰空气技术有限公司是江苏苏净集团有限公司与日本AIRTECH株式会社共同组建的中日合资企业。集科研、开发、生产制造于一体，是国内空气净化设备行业规模最大、市场占有率最高的企业。产品在国家、部、省重大项目招标中，中标率名列第一。公司主要产品有洁净工作台、生物安全实验室与生物安全柜、风淋室、洁净层流罩与净化单元设备、洁净手术室洁净病房及其辅助设备。广泛应用于电子、制药、生物、食品、医疗卫生、农林、畜牧兽医、检验检疫、航空航天、汽车制造、精密仪器、大专院校和科研部门等。苏净安泰是行业中唯一的省级高新技术企业，获ISO9001-2000版质量体系认证、二类医疗器械生产企业许可证。二级生物安全柜、洁净工作台等产品曾获得国家银质奖，部级科技进步奖，国家和省级重点优秀新产品奖。中日合资。苏州华泰空气过滤器有限公司由江苏苏净集团有限公司、日本AIRTECH株式会社与吴净净化设备有限公司三方投资组建而成，是专业生产各种粗、中、高效空气过滤器及过滤纸的专业公司。华泰公司自行生产各类玻璃纤维空气过滤纸，是国内唯一一家既生产过滤器又生产滤纸的公司。公司拥有先进的滤纸、过滤器试验检测设备，可针对用户要求，采用多种试验粒子对产品进行检测。公司具有良好的品质管理体制，于1998年12月通过ISO9002质量体系认证。于2001年底通过ISO9001-2000版认证及ISO14001环境管理体系。苏州苏净仪器自控设备有限公司是江苏苏净集团有限公司的下属公司，集科研、开发、生产制造于一体，在空气净化检测行业是国内规模最大，市场占有率最高的企业之一。公司主要产品：激光尘埃粒子计数器、超净间粒子监测系统、浮游菌采样器、激光粉尘仪、风速仪、微压差仪、温湿度计、声级计等净化系统测试仪器。</span>');
INSERT INTO `ty_company_data` VALUES ('24', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">沧州昊诚管道有限公司，地处渤海之滨--盐山县蒲洼城工业区，是一家为国内外石油、炼化、化工、冶金、电力、造船、输气、管道输送等行业提供高端产品与服务的专业制造商。</span>\r\n<p style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" align=\"left\">　　　公司技术力量雄厚，生产装备先进，检测手段完备。公司产品主要包括三大系列<span style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\">100多个品种：1、弯头、三通、异径管、管帽、法兰、支吊架等高、中、低压管件及风门、人孔、罩型通气管、耐磨双芯可调缩孔、防水套管、吸水喇叭口、疏水收集器、疏水盘、水流指示器、三向位移指示器、流量测量装置、蠕胀测点、节流孔板等管道配件系列；2、无缝、直缝、螺旋钢管系列；3、保温、耐磨、防腐管道系列。产品执行标准有：GB/T、SH、HG、JB、ANSI/ASME、MSS、JIS、DIN等；材料包括碳钢、合金钢、不锈钢、低温钢、双相钢、镍基合金、哈氏合金等，也可按客户提供的技术进行生产制造。<span style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\"><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n</span>　　　公司坚持科学管理，建立了完善了质量管理体系。目前，已取得《中华人民共和国特种设备制造许可证（压力管道）》、《采用国际标准产品标志证书》和中国船级社《工厂认可证书》，《河北省高新技术企业认证证书》；《中华人民共和国进出口企业资格证书》；并先后分别通过了ISO9001、ISO14001、OHSMS18001、美国石油学会API&nbsp;6H体系认证。<span style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\"><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n</span>　　　企业始终坚持&ldquo;诚信为本，合作共赢&rdquo;的经营方针，以&ldquo;始于市场需求，终于顾客满意&rdquo;为经营目标，赢得了广阔市场。公司被中国石油天然气集团公司、选定为资源市场一级供应网络成员单位，被中国电力网批准为&ldquo;中国电力配件网网络成员厂&rdquo;，并被评为&nbsp;&ldquo;河北省工行AAA级信用企业&rdquo;、&ldquo;河北省诚信守法经营企业&rdquo;，河北省&ldquo;重合同守信用企业&rdquo;称号。<span style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\"><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n</span>　　　我们将以合理的价格，诚信的服务，过硬的质量，负责的态度，为客户提供一流的产品。</span></p>');
INSERT INTO `ty_company_data` VALUES ('25', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">力之恒管道科技有限公司始建于2003年，公司总部座落于浙江绍兴，是一家集科研、开发、生产、销售、物流为一体的创新型科技现代化企业。公司注册资金5000万，企业及工厂占地3万平方米，塑料管道年生产能力达1万多吨，产品远销欧美，中东，东南亚等40多个国家及地区。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司成立以来，一直秉承自主创新，人才兴业的发展理念，并始终坚持以产品创新为企业发展核心，向客户提供高品质产品及服务为企业责任，致力成为管材行业领导者和出口领导者的发展目标而努力。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">发展历程</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">2003年成立于绍兴</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">2011年将公司重心由外销转为内销，从国外抽调30多名专家组成员对产品进行对产品原料，产品焊接，抗爆耐压，回缩膨胀，产品硬度等多方面性能进行实验室分析研究，制定出一套严格的质量控制管理体系，为力之恒品牌快速发展奠定了坚实的基础</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司产品</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司主导产品有PP-R、PE管材管件等</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">力之恒产品特点：主要采用进口韩国晓星原料，确保产品具有高抗冲击性，高耐候性及耐腐蚀性，同时具有良好的耐温性能（耐高温&nbsp;耐低温）及抗蠕变性能。<span class=\"Apple-converted-space\">&nbsp;</span></span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">PPR管&nbsp;：力之恒产品管壁光滑透光设计，内置高密度纳米抗菌层，有效降低污垢附着，长时间堆积的弊端，饮水更加安全，卫生。采用进口阳光咖喱色母，有效地反射紫外线，使水管的耐候性能增加一倍以上。<span class=\"Apple-converted-space\">&nbsp;</span></span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">力之恒产品对比普通产品的优势</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">耐热：在规定的长期连续工作压力下，普通ppr长期耐热温度约85度，而力之恒使用的进口塑料米耐热可达约95度。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">耐腐蚀、不结垢：力之恒产品属于绿色建材，耐腐蚀、不结垢、卫生、无毒，使用的进口料米ppr管可免去管道内壁不够光滑所造成的内壁结垢、生长青苔等所引起的水质&ldquo;二次污染&rdquo;，可用于纯净饮用水管道系统，尤其是导热系数仅为金属管的二百分之一，用于热水管道保温节能效果更佳。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">重量轻，强度高：力之恒产品比重仅为金属的八分之一，耐压力试验强度达5MPa（50kg/cm2）以上，韧性好，耐冲击。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">安装方便，可靠：力之恒产品采用热熔连接，无需套丝，数秒钟即可完成一个接头连接，与金属管道及用水器连接采用优质铜嵌件，安全可靠。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">使用寿命长：力之恒产品在使用温度为80C，工作压力为1.4MPa条件下，长期连续使用，寿命可达60年以上，综合抗压耐温指数比普通水管高出20%。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">裸铜：力之恒产品采用59&mdash;1铜，经高温亚铸纯度达99.97%，具有优异的抗氧化，耐腐蚀性能。加工性能更优越。有效地解决了施工过程中由于过力而产生的胀裂的垢病。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />');
INSERT INTO `ty_company_data` VALUES ('26', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">上海源朔贸易有限公司是一家贸易，工程（大型管工程项目道系统施工安装），零售批发集于一体一家贸易公司，主要代理品牌：日丰牌，中财牌，伟星牌，主营产品：日丰管，中财管道，伟星管道，PPR、PVU、PE管材，地暖，电工套管及管件及五金、开关插座、五金、开关品种齐全、价格合理。本公司拥有专业的管道系统安装施工团队，公司经营多年，与多家零售商和代理商建立了长期稳定经销的合作关系，品牌畅销消费者市场，在消费者当中享有较高的地位；集于多年诚信经营，高品牌，高质量，诚信客户，赢得广大客户信任，是广大客户信赖的合作伙伴，如：大华集团，家数，龙元，静安招商等开发商，其中开房商&rdquo;大华集团&ldquo;建立长期战略合作关系，大华集团旗下开发楼盘，&rdquo;阳城贵都&ldquo;，&rdquo;梧桐城邦&ldquo;，&rdquo;虎城广场&ldquo;，&ldquo;虎城第三空间&rdquo;，&rdquo;锦绣花城&ldquo;，郎香花园等等大型楼房项目管系统均由安装上海源朔贸易有限公司安装，上海源朔贸易有限公司实力雄厚，重信用、守合同、保证产品质量，以多品种经营特色和薄利多销的原则，赢得了广大客户的信任。</span>\r\n<p style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">上海源朔贸易有限公司竭诚为您服务，欢迎新老客户前来洽谈。联系人：叶赛蓬，联系电话：86-021-34228419，移动电话：13311992291。</p>');
INSERT INTO `ty_company_data` VALUES ('27', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">衢州市美加华管业有限公司成立于2006年，本公司专业研发生产销售PPR、pvc管材管件。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司的主营产品，&ldquo;美加华&rdquo;牌PPR`PVC精品管材管件，本产品采用进口高级原料配置，高端品质。本产品耐高压防冻抗氧化，水工操作安全方便，质量上赢得用户信赖和好评。公司坚持走品牌路线，把质量和信誉视企业生命，产品被国家权威机构评选为【中国名优产品】和【中国绿色环保产品｝。本公司在全国各地与多家经销商建立了长期的合作关系，欢迎各界朋友光临指导。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">本公司经国家相关部门批准册， &ldquo;美加华&rdquo;品牌先后被评委【中国著名品牌】，企业也同时被评为【全国质量、服务、信誉AAA企业】。<span class=\"Apple-converted-space\">&nbsp;</span></span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">为能与你合作，公司降低费用，把最实惠的价格让利给你。使你有更大的优势去开拓市场，立足于不败之地，期待你和企业共同发展。本公司在各省市地区诚招经销商，公司本着&ldquo;诚信为本，以质量求发展&rdquo;的宗旨，为客户创建华丽舞台，共创我们美好未来！</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">服务热线：4000-223-113 QQ:370149992</span>');
INSERT INTO `ty_company_data` VALUES ('28', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">邓权塑业科技（湖南）有限公司，成立于2008年，公司位于交通便利、风景优美的湖南省常德市西洞庭管理区工业园祝丰路，是一家集塑料管道系列产品的研发、生产、销售、技术咨询与技术服务为一体的高新技术企业，注册资金3000万元，设计年生产能力5万吨，年产值6亿以上.公司现有员工 150 多人，在以人为本的管理理念引导下，始终坚持专注品质，锲而不舍，传递价值，追求卓越的企业文化理念！<span class=\"Apple-converted-space\">&nbsp;</span></span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司主要生产：PP-R/PE给水管系列、PVC-U给排水系列、PVC-U电力电缆管系列、PVC绝缘阻燃线管等产品，拥有完整、科学的质量管理体系。邓权塑业科技（湖南）有限公司的诚信、实力和产品质量获得业界的认可。欢迎各界朋友莅临参观、指导和业务洽谈。</span>');
INSERT INTO `ty_company_data` VALUES ('29', '<br />\r\n<p style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">&ldquo;青岛金辉管业有限公司&rdquo;http://www.qingdaojinhui.com位于全国优秀旅游城市。二00八年奥运会帆船比赛中心--青岛市，水、陆、空交通便利。本厂生产设备先进，研发能力强。主要生产PE-RT地暖管、UPE-RT、HDPE-80、HDPE、太阳能热水器专用管及POM管件。主要有&lsquo;绿保&rsquo;&lsquo;金辉&rsquo;&lsquo;铭绿&rsquo;等品牌系列产品。产品畅销全国各大市场，并已有较高知名度。其中&lsquo;绿保&rsquo;牌POM管件已取得设计专利，其质量优于普通铜管件，深受广大品牌用户一致好评。</p>\r\n<p style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">让每一位用户满意是我们追求的目标，真诚希望您能了解我们，让我们携手合作，共创辉煌明天。</p>');
INSERT INTO `ty_company_data` VALUES ('30', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">帝麦克斯（苏州）医疗科技有限公司是江苏省政府2012年重点引进的江苏省&ldquo;高层次创新创业领军人才&rdquo;企业。公司拥有26项发明专利，7个基金项目共530多万美元的研究经费，与美国亚利桑那大学、浙江大学、苏州大学等建立了合作关系，与达安基因达成战略合作关系。公司开发了拥有自主知识产权的全自动数字病理扫描系统，是集机械、电子、光学及自动控制为一体的国际领先产品。主要应用于医疗机构、司法鉴定机构的病理远程诊断、数字化病理科建设以及及高校、科研机构的教学及研究等领域。公司立足于病理行业，致力于为不同层次的需求的客户提供提供全信息化病理科系统解决方案。</span>');
INSERT INTO `ty_company_data` VALUES ('31', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: 宋体; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">上海豫沪实业有限公司专业生产</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" lang=\"EN-US\">BA</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: 宋体; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">不锈钢管，</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" lang=\"EN-US\">EP</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: 宋体; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">不锈钢管，不锈钢精密管，电解抛光管及相应管件接头类。公司产品广泛应用于石油、、电力、医药机械、仪器仪表、建筑等行业，产品畅销世界各地。不锈钢洁净管及管件材质</span>');
INSERT INTO `ty_company_data` VALUES ('32', '<br />\r\n<font face=\"Verdana\"><strong><font size=\"2\">深圳市安特瑞智能科技有限公司</font></strong><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">是一家专业从事RS485总线报警、TCP\\IP网络报警、机房报警产品研发、生产 、销售于一体的科技型企业。致力于发展安防事业，公司聚集了一批高新技术人才、营销精英及复合型管理人才。凭借先进的经营理念、高素质的科技队伍和营销团队，在提供整个防盗系列产品的同时，根据市场的变化和用户的需求，在不断升级完善现有产品的同时，推出更先进的产品，使产品的技术含量长久保持在行业的领先地位，在市场竞争中始终领先。</span></font><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\"><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n<br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n</span><b style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">我公司产品包括：</b><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">智能小区大型总线制报警系统、工厂企业围墙周界报警系统、家用\\商用电话联网报警系统、TCP\\IP网络报警系统、平安城市电话联网报警系统、无人机房断电\\声光报警系统、各种主动\\被动红外探测及报警系列配件等。广泛应用于住宅小区、厂矿、仓库、学校、医院、写字楼、别墅、商铺、电信\\移动机房、电力部门等相关行业。<span class=\"Apple-converted-space\">&nbsp;</span></span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\"><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n<br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">诚信、合作、发展，安特瑞人敞开自己的胸怀，迎接国内外客户和同行的热情拥抱；团结、专业、规模，安特瑞人以认真负责的态度，对待国内外客户和同行的友好合作；安特瑞人用自己的工作激情和专业精神为您提供全方位服务，为您的企业发展增添一点安特瑞人的激情。</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\"><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n<br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n</span><b style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">安特瑞的服务宗旨：</b><b style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\"><span style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\"><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n</span></b><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">专业的技术+完善的服务+良好的信誉=您的满意</span>');
INSERT INTO `ty_company_data` VALUES ('33', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">山东固赢实验设备有限公司是专业生产和销售实验台的</span><strong style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">全钢实验家具</strong><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">企业，产品包括钢木实验家具、pp实验家具等实验室设备，如果您对钢木实验室家具有意向或者想了解更多相关信息如：价格、型号、图片，欢迎来电垂询。公司自成立以来一直致力于实验室家具、设备的设计与研发。实验室家具方面：公司以实验室建设的成熟标准和先进理念，为您提供从实验室规划设计、设备安装、到提供专业性技术咨询、技术服务、客户培训等全面的解决方案。实验室设备，仪器方面：公司结合国内外的先进技术不断推出新产品。本公司生产的产品广泛应用于化学，生物、有机合成、分析测试 大中院校科研农业环保等诸多领域及各行各业不同类别的实验室。以&ldquo;一站式&rdquo;服务为宗旨，为广大用户提供更专业、优质、全面的系统化服务。更多精彩知道请登录http://www.sdshiyanshebei.com/查询。</span>');
INSERT INTO `ty_company_data` VALUES ('34', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司保持每年至少开发一到两款新产品，以市场需求为导向、以创新设计为龙头、以规范制造为基础、用户满意为准则。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp; &nbsp; 本着以&ldquo;优质、服务&rdquo;的经营理念，&ldquo;以产品性能稳定为本、以物美价廉发展方向&rdquo;的企业管理模式，想客户所想，以分担您繁重的实验分析任务和帮您选择最能适合有效的仪器为己任；以品种全、质量优、价格合理，公司集产品设计、开发、生产、销售、服务于一体，制定了长期经营战略方针，有优秀的人力资源和充足的财力，具有高级职称的技术人员占公司员工总数的三分之一以上。公司拥有一批长期从事色谱分析应用的高级工程师，在气相色谱类仪器的维护、维修和调试等方面的技术力量雄厚。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">上海气谱生产工艺</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp; &nbsp; 公司专业生产线设备精良，工艺先进，检验设备精密、全面、准确，操作人员技术精湛；采用国家级标准物质进行成品指标校检，确保符合国标要求。产品质量优良，性能稳定、可靠，赢得了广大用户的信赖，具有广泛的品牌知名度及完美的产品美誉度，受到国内色谱界专业人士的一致称赞。</span>');
INSERT INTO `ty_company_data` VALUES ('35', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">山东东易日盛仪器有限公司凭借坚持不懈的努力，拥有了专业的销售团队，完善的服务体系，拥有独立的技术服务部门，技术力量雄厚，售后服务不必单纯依靠厂方，领先世界科技的仪器咨询，解决仪器应用的完美方案。公司下设销售部、市场部、售后服务部、财务部、仓储部等部门，拥有仓储物流基地，常规分析仪器均备有现货。 山东东易日盛仪器有限公司一直与供应商保持良好的合作关系，不断引进各种优质的实验室产品。本公司主要经营实验室分析仪器，产品种类十分齐全，如电热套、电热板、原油含水快速测定仪、原油脱水仪、原油取样桶清洗机、搅拌器、水浴锅、振荡器、玻璃仪器烘干器、循环水真空泵、旋转蒸发器、干燥箱、培养箱、天平、酸度计、电导率仪、滴定仪、熔点仪、旋光仪、折射仪、水分仪、粘度计、灭菌器、纯水仪、定氮仪、色差计、分光光度计、原子吸收、色谱等等，产品涵盖计量仪器、实验台、实验室通用仪器、化学分析、物理测试等仪器，涉及到石化、精细化工、制*、日化、食品、涂料、建材、电子、汽车、农业等众多生产行业，以及高校、研究所等科研机构的实验室。 东易日盛仪器有限公司一直致力于提升中国实验室生产力水平，从提供公司购买产品之日起计算，七日内产品出现非人为的质量问题，公司提供免费换货服务，仅限于同品牌，同型号的产品，在不缺货的情况下更换周期为1-3天； b)客户从我公司购买产品之日起计算，七日后至十二个月内出现非人为质量问题，所购产品享受由 公司提供的免费维修服务。</span>');
INSERT INTO `ty_company_data` VALUES ('36', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">深圳市梦美怡美容仪器有限公司是一家集科研、生产、销售、服务为一体的高科技美容美体仪器生产厂家。目前生产的产品涵盖了美容、美体、养生、水疗、氧疗等不同系列，其领先的设计技术、优良的品质、准确的交货期、完善的技术服务为客户解决了所有的后顾之忧。　我公司拥有一批实力雄厚的工程技术人员和企业管理人员。在机械、电子、外观等多科上具有综合开发、设计能力。在生产过程中严格依照ISO9001：2000质量管理体系为标准，目前已经成功使我公司的产品畅销全国各地并远销东南亚、中东、欧洲、北美等地。本公司一贯秉承：产品创新，质量第一，客户至上，服务第一的宗旨。为适应当今美容业的发展，我们不断提高产品质量和售后服务水平，开发更多更好的产品，真正做到让顾客满意，同时为您提供销售、培训、技术等全方位的优质服务。欢迎客户来样定做、加工、生产，诚邀广大客户来电洽谈合作</span>');
INSERT INTO `ty_company_data` VALUES ('37', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">沧州中建精密仪器有限公司是一家专业生产、研发、销售公路、铁路、交通及建工行业检测仪器、设备的高新企业。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp; &nbsp; &ldquo;中建仪器&rdquo;专注于提供中高端的常用公路检测仪器，建筑仪器及衍生产品，以满足质量监督、科研机构、大专院校和各行业企业的需求。主要产品有：土工、集料、沥青、混凝土、道路工程、水泥，防水材料等多个系列三百余种检测仪器设备、其中百余种产品为自行制造。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">沧州中建精密仪器有限公司,各种计量标准等质量保证体系完整准确，产品的数据可靠。所有零部件均严 格把关，在生产的各个工序上坚决杜绝假冒伪劣零部件，产品质量可靠，市场占 有率大，售后服务及时到位。占地面积万余平方米，生产车间面积四千平方米，员工50余人。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp; &nbsp; 沧州中建精密有限仪器公司拥有六十余家代理商，把&ldquo;中建&rdquo;产品推广、应用于全国的各条公路、铁路，建筑检测单位,遍布于全国20余省市的科研院所、高校、甲级资质实验室和公路实验室。我公司立足沧州，面向全国，以灵活多样的经营理念，扎实可靠的售后服务质量，赢得了全国各地广大客户的好评。我公司愿继续与全国各大专院校、科研单位合作，开发出更多质优价廉的试验仪器服务于社会，为交通建设做出更大的贡献，愿与您共同发展共创辉煌。</span>');
INSERT INTO `ty_company_data` VALUES ('38', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">佛山市衡普电子有限公司（佛山市衡普环境试验设备有限公司）是专业生产和销售高低温试验箱，高低温交变湿热试验箱，冷热冲击试验箱，淋雨试验箱，步入室恒温恒湿试验室，紫外光耐气候试验箱，氙灯耐气候试验箱，砂尘试验箱，臭氧老化试验箱，盐雾腐蚀试验箱，鼓风干燥箱，变频电源，交流电源供应器，交流电压稳压器，直流电源供应器，安全性能综合测试仪，各类非标环境试验设备等多种电子电源仪器设备，同时代理进口国产示波器，福禄克万用表，常州蓝科仪器和扭力计，青岛仪迪仪器，横河温度测试仪，三丰量具等， 公司创建于2006年，现有职工共六十余人，其中专业技术人员占60%以上，工厂拥有许多的先进设备。本公司因业务发展需要，从2011年升级为佛山市衡普环境试验设备有限公司，衡普公司具有年产各种电子仪器电源设备2000台以上，工厂有严格的生产能力，强大的开发技术及完美的管理制度，可以接受新高技术产品的开发与研制。 本公司系列产品广泛用于视讯产品，电脑产品，家电系列，医疗器材，电子器材，电子仪器，变压器，通讯设备，五金，化工涂料，航空，船舶及军工产品，计量所，科研单位和高等院校等配套和安全参数测试。在各种产品的制造与行销，力求完美，公司设</span>');
INSERT INTO `ty_company_data` VALUES ('39', '<table style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" cellspacing=\"3\" cellpadding=\"3\" width=\"98%\" align=\"center\">\r\n    <tbody style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\">\r\n        <tr style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\">\r\n            <td style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\"><img style=\"border-bottom: rgb(192,192,192) 1px solid; border-left: rgb(192,192,192) 1px solid; padding-bottom: 5px; margin: 5px 0px 5px 10px; padding-left: 5px; padding-right: 5px; font-family: Verdana, Arial; word-break: break-all; border-top: rgb(192,192,192) 1px solid; border-right: rgb(192,192,192) 1px solid; padding-top: 5px; text-size-adjust: none\" align=\"right\" src=\"http://www.wsd114.com/file/upload/201303/21/12-24-41-80-19117.jpg\" alt=\"\" /><span style=\"font-family: Verdana, Arial; color: rgb(0,0,0); word-break: break-all; text-size-adjust: none\">陕西德力能源科技有限责任公司于2008年由渭南市临渭区德力锅炉厂改制成立。渭南市临渭区德力锅炉厂于1989年建厂，2001年经陕西省技术监督局验收批准的企业位于陕西省渭南市新型工业项目区，占地近30000平方米，是研发生产燃气、燃煤、燃甲醇（醇基燃料）燃油及液化气等主流能源。主要产品有：燃气热水锅炉、直燃模块冷凝模块系列、甲醇锅炉、燃煤环保系列、真空相变系列等,迄今为止荣获41项国家专利,服务数千用户。</span><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n            <span style=\"font-family: Verdana, Arial; color: rgb(0,0,0); word-break: break-all; text-size-adjust: none\">科研历程：</span><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n            <span style=\"font-family: Verdana, Arial; color: rgb(0,0,0); word-break: break-all; text-size-adjust: none\">1998年研制出二次多孔给氧燃煤锅炉，环保指数达标</span><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n            <span style=\"font-family: Verdana, Arial; color: rgb(0,0,0); word-break: break-all; text-size-adjust: none\">1999年研制出水管换热除垢锅炉，除垢彻底全面便捷</span><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n            <span style=\"font-family: Verdana, Arial; color: rgb(0,0,0); word-break: break-all; text-size-adjust: none\">2000年研制出等径均压横吸锅炉，换热更高效，更全面</span><br style=\"font-family: Verdana, Arial; word-break: break-all; text-size-adjust: none\" />\r\n            <span style=\"font-family: Verdana, Arial; color: rgb(0,0,0); word-break: break-all; text-size-adjust: none\">2009年研制出多区多室换热技术，排烟温度降至60-100℃</span></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<br />');
INSERT INTO `ty_company_data` VALUES ('40', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: 宋体; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 21px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">上海伟暖实业有限公司是致力于高新技术引进、环保节能新材料应用和市场开发，尤其在高分子环保节能室内采暖领域。</span>');
INSERT INTO `ty_company_data` VALUES ('41', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">郑州锅炉股份有限公司是国家大型企业，原机械部定点大型骨干生产厂，我国中西部地区最大的民营锅炉生产厂家，河南省高新技术企业，世界银行GEF项目环保高效节能生物质锅炉生产基地，拥有河南省第一家通过的A级锅炉制造许可证和A级压力容器设计、制造许可证，ISO9001质量体系认证以及美国ASME S(锅炉)&amp; ASME U(压力容器)设计和制造许可证。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">　　郑州锅炉股份有限公司是由原郑州锅炉厂2003年改制而来。企业拥有东、西两大厂区，占地面积33.3万平方米，其中东(主)厂区占地面积14万平方米，建筑面积10万平方米，固定资产1.1亿元，拥有国际一流水平的日本kkk公司制造的膜式水冷壁生产线，蛇型管生产线，120mm数控卷板机，205x5.5数控退火炉，全自动焊机等生产设备800余台套。数十年来，企业先后经过四次技术改造，三次企业兼并及资产重组，规模得到不断扩大。现有职工1500人，其中技术人员460人，具有中、高级职称的347人。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">　　郑州锅炉股份有限公司是河南省锅炉和压力容器企业技术中心、郑州市锅炉和压力容器工程技术研究中心，郑州市首批命名的产学研科研基地，长期与西安交通大学合作开办锅炉专业硕士研究生班。通过长期的产学研纵向联合和重工装备制</span>');
INSERT INTO `ty_company_data` VALUES ('42', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">厦门迈众机电设备工程有限公司成立于2011年，是一家集冷热水、暖通空调与机电安装工程的设计、安装及维护为一体的设备工程商。公司拥有一批多年从事机电安装的工程技术人员，对各个工业应用、民用场合拥有丰富的实际经验，针对用户提出的实际需求，如：暖通、生活热水、恒温泳池、余热回收、PCW系统及生产工艺系统等提供准确、可靠、高效的解决方案。&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">目前公司主要代理产品如下：&nbsp;</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;&nbsp;&nbsp;&nbsp;水泵(上海丹泉/台湾川源)：离心泵、排污泵、消防泵、变频供水机组、定压补水装置等；</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">板式换热器(派斯特PANSTAR):板式换热器、钛板换热器、全自动板式换热机组等；</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">空气源热泵(芬尼克兹PHNIX):商用热泵、泳池热泵、风冷模块机组、工业高温热泵等；</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&nbsp;&nbsp;&nbsp;公司自成立以来，始终坚持以&ldquo;诚实守信、友好合作、互惠共赢&rdquo;的经营理念,先后为众多的企业与工程提供了优质的产品与良好的服务，并深受广大合作客户的一致好评。</span>');
INSERT INTO `ty_company_data` VALUES ('43', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">佛山市顺德区华天成电器有限公司，生产：空气能热水器、烘干热泵、暖通设备，位于中国南方经济发达的珠三角佛山顺德。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">顺德是珠江三角洲中部崛起的新城市，全国重要的家电生产基地， 其中家用电器产品产销量分别占全国总产销量的三分之一。中国家用电器协会、中国轻工业联合会授予顺德为&ldquo;中国家电之都&rdquo;称号。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">成立于2005年的华天成电器是目前全球集研发、生产、销售、服务于一体的专业化热泵产品出口大型企业之一 连续三年出口额蝉联国内前三甲。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">华天成电器旗下的&ldquo;华天成&rdquo;品牌热泵产品，已远销国外，业务遍及全球多个国家和地区。 作为一家专注于热泵产品的大型电器制造商，华天成电器致力于为全球消费者提供技术领先、品质卓越的热泵产品。 在美国、英国、乌克兰、印尼、智利、南非等多个国家都有科研合作机构，至今已开发出包括家用热泵、商用热泵和中央空调在内的8大类、63个系列、380多个品种规格的产品，能充分满足不同消费群体的各种需求；拥有多项技术专利，自主研发的一系列高端产品填补了国内空白，成为从&ldquo;中国制造&rdquo;走向&ldquo;中国创造&rdquo;的典范， 在国际舞台上赢得了广泛的知名度和影响力。</span>');
INSERT INTO `ty_company_data` VALUES ('44', '<br />\r\n<div>一、以先进的生产设备，规范的生产工艺，创新的生产理念卓越的产品品质，超值的产品性价比为世界绝热材料应用提供服务和保障！</div>\r\n<div>OFAMS福姆斯--高品质源于高精分子发泡技术</div>\r\n<div>福姆斯绝热材料是引进国外最新技术和先进的全自动连续生产线，采用性能优异的橡胶为主要原材料，配以各种优质辅助材料，经特殊工艺发泡而成的柔性泡沫绝热材料。 高品质与众不同</div>\r\n<div>二、高性能管板：</div>\r\n<div>发泡充分，泡孔均匀，密度控制在最佳值60KG/m3左右</div>\r\n<div>发泡技术落后的高密度管板（众多国内品牌）：</div>\r\n<div>发泡技术不过关，发泡不充分，泡小且不均匀，闭泡率不高，密度在70-100KG/m3之间</div>\r\n<div>追求低成本的无泡低密度专用管板（部分国际品牌）：</div>\r\n<div>过度追求低成本导致无法胶连成泡，材料呈半闭孔结构，类似PEP，密度多在40-50kg/m3</div>\r\n<div>三、陈华德&nbsp;&nbsp;博士</div>\r\n<div>美籍华人陈华德博士，Ofams&nbsp;研究室创始人，一生致力于橡塑高分子材料的研究与开发，尤其在高精分子发泡技术领域取得了举世瞩目的成就。</div>\r\n<div>四、高分子精细发泡技术High-precison&nbsp; Mollecular Foaming Technology</div>\r\n<div>Dr.Chen&nbsp;的高精分子发泡技术缔造了OFAMS Insulation&nbsp;福姆斯橡塑绝热材料的&nbsp;2&nbsp;大优势：</div>\r\n<div>五、高质量均匀表面</div>\r\n<div>最大限度的提高表面放热系数，在同等材料厚度、环境温度和湿度的情况下，</div>\r\n<div>OFAMS Insulation&nbsp;福姆斯橡塑绝热材料保温性能更好。</div>\r\n<div>边缘均匀无结皮</div>');
INSERT INTO `ty_company_data` VALUES ('45', '<br />\r\n<div align=\"left\">东莞市博盾金属材料科技有限公司位于广东省 东莞市、长安镇，主要经营模具TD处理.金属表面硬化处理，TD表面覆层处理，模具拉伤，热处理，模具PVD镀钛镀鉻处理、纳米镀钛、刀具镀钛、粉末冶金镀钛,五金配件镀钛、电子产品镀钛、模具配件镀鉻、等产品。</div>\r\n<div align=\"left\"><b>TD</b>覆层处理是热扩散法碳化物覆层处理（Thermal Diffision Carbide Coating Process）的简称，英文简称TD coating。因该技术由日本丰田中央研究所首先研制成功并申请专利，又被称为Toyota Diffusion&nbsp;&nbsp;Process,简称TD Process即TD处理。我国也称作熔盐渗金属。无论其名称如何，其原理都是将工件置于熔融硼砂混合物中，通过高温扩散作用于工件表面形成金属碳化物覆层，该碳化物覆层可以是钒、铌、铬的碳化物，也可以是其复合碳化物，目前应用最广泛的是碳化钒覆层。</div>\r\n<b>PVD</b>镀钛是广泛应用的工业超硬薄膜技术，以其高硬度、低磨损率、低磨擦系数、强抗腐蚀性、抗黏着性等优越的使用性能广泛应用于模具工业中。多年来，我们以其独具特色的服务理念赢得客户的一致认同。东莞市博盾金属材料科技有限公司秉承&ldquo;诚信、专业、共赢&rdquo;的经营理念,坚持用户至上、质量第一，以科技服务客户，坚持技术进步、不断 创新、不断超越. 您的满意就是我们的追求！欢迎广大企业、和消费者和我们联系，我们将本着 最好的产品为用户提供最好的服务为宗旨，竭诚为您服务！');
INSERT INTO `ty_company_data` VALUES ('46', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">霸州市</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">城区</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">广通线路工具厂自</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">1995</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">年办厂以来凭借诚信和雄厚的技术、设备实力，赢得各方的一致好评。订单不论大小，我们都将尽心竭力为您提供服务，以严谨精确的作风、高效求实的运作，保证每一个细节都得到完善的处理。我厂本着诚信经营，质量第一，竭诚服务，客户至尊的经营理念受到了广大客户的信赖和好评。对产品严格把关，决不让不合格的产品出厂多次被评为重合同、守信誉质量信得过单位。主要产品有：玻璃钢穿孔器、电缆拖车、电缆放线架、格钩式抱杆、管式立杆机、电缆滑车、滑轮、紧线器、卡线器、电缆剥皮器等一系列电力施工工具。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">本厂经过</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">10</span><span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\">年时间，又成功的引进正规的高低压电气和安防工器具的生产技术。又经过多年坚持不懈的努力，生产技术已经成型。主要经营产品包括：高低压避雷器、跌落式熔断器、绝缘子、隔离开关等电力电气。安全带、安全帽、高低压验电器、绝缘手套、绝缘靴、绝缘围栏等安全防护工具。</span>');
INSERT INTO `ty_company_data` VALUES ('47', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">杭州泰宏五金工具有限公司，是一家专业生产中高档黄油枪及各种汽保工具的生产型企业。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">公司一贯奉承&ldquo;以诚为本、以质取胜、以才兴厂&rdquo;的原则，全面实施ISO9001:2000质量体系标准。本公司生产的黄油枪工艺先进，选料精良，产品质量稳定，美观大方，规格齐全。产品畅销全国各地并远销欧洲、北美、东南亚、日本和韩国等国家和地区。深受国内外客户的青睐。</span><br style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; font-family: Verdana, Arial; white-space: normal; orphans: 2; color: rgb(0,0,0); font-size: 13px; word-break: break-all; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px; text-size-adjust: none\" />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">&ldquo;泰宏&rdquo;诚邀为广大客户提供更加优质的产品，更优良的服务。诚意恭候国内外客户光临指导，共同携手合作，共创辉煌！</span>');
INSERT INTO `ty_company_data` VALUES ('48', '<br />\r\n<span style=\"widows: 2; text-transform: none; background-color: rgb(255,255,255); font-style: normal; text-indent: 0px; letter-spacing: normal; display: inline !important; font-family: Verdana, Arial; white-space: normal; orphans: 2; float: none; color: rgb(0,0,0); font-size: 13px; font-weight: normal; word-spacing: 0px; font-variant-ligatures: normal; font-variant-caps: normal; -webkit-text-stroke-width: 0px\">武汉鑫信合电子工具有限公司位于中国湖北武汉关山大道创业街特1号401，公司与一冶钢构，武桥，中建三局等大型公司建立了长期稳定的合作关系。公司主打产品是磁力钻，磁座钻，空心钻，日东磁力钻，台湾AirBoss磁力钻，上海锐奇磁力钻，慧丰磁力钻，空心钻头，取芯钻头，硬质空心合金钻头 ，钨钢打孔钻头及其他五金电动工具与配件，诚信待人、合作共赢，是我们公司的宗旨。</span>');

-- ----------------------------
-- Table structure for ty_company_setting
-- ----------------------------
DROP TABLE IF EXISTS `ty_company_setting`;
CREATE TABLE `ty_company_setting` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `item_key` varchar(100) NOT NULL DEFAULT '',
  `item_value` text NOT NULL,
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司设置';

-- ----------------------------
-- Records of ty_company_setting
-- ----------------------------
INSERT INTO `ty_company_setting` VALUES ('14', 'kf', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'announce', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'map', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'stats', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'intro_length', '1000');
INSERT INTO `ty_company_setting` VALUES ('14', 'seo_title', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'seo_keywords', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'seo_description', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'main_file', 'elite,introduce,sell,info,brand,photo,video,mall');
INSERT INTO `ty_company_setting` VALUES ('14', 'main_num', '10,1,10,5,3,4,4,5');
INSERT INTO `ty_company_setting` VALUES ('14', 'main_name', '推荐产品,公司介绍,最新供应,招商代理,品牌展示,公司相册,公司视频,热卖商品');
INSERT INTO `ty_company_setting` VALUES ('14', 'side_num', '1,5,10,1,1,5,5');
INSERT INTO `ty_company_setting` VALUES ('14', 'side_file', 'announce,news,type,contact,search,honor,link');
INSERT INTO `ty_company_setting` VALUES ('14', 'main_show', '1,1,1,0,0,0,0,1');
INSERT INTO `ty_company_setting` VALUES ('14', 'main_order', '0,10,20,30,40,50,60,70');
INSERT INTO `ty_company_setting` VALUES ('14', 'side_show', '1,0,1,0,1,0,0');
INSERT INTO `ty_company_setting` VALUES ('14', 'side_order', '0,10,20,30,40,50,60');
INSERT INTO `ty_company_setting` VALUES ('14', 'side_name', '网站公告,新闻中心,产品分类,联系方式,站内搜索,荣誉资质,友情链接');
INSERT INTO `ty_company_setting` VALUES ('14', 'side_pos', '0');
INSERT INTO `ty_company_setting` VALUES ('14', 'menu_file', 'introduce,mall,contact,tycase');
INSERT INTO `ty_company_setting` VALUES ('14', 'side_width', '200');
INSERT INTO `ty_company_setting` VALUES ('14', 'menu_num', '1,16,30,30');
INSERT INTO `ty_company_setting` VALUES ('14', 'menu_name', '公司简介,产品展示,联系方式,项目案例');
INSERT INTO `ty_company_setting` VALUES ('14', 'menu_order', '0,10,20,30');
INSERT INTO `ty_company_setting` VALUES ('14', 'menu_show', '1,1,1,1');
INSERT INTO `ty_company_setting` VALUES ('14', 'show_stats', '1');
INSERT INTO `ty_company_setting` VALUES ('14', 'video', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'banner5', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'banner4', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'banner3', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'banner2', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'banner1', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'bannerf', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'banner', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'bannert', '0');
INSERT INTO `ty_company_setting` VALUES ('14', 'bannerh', '200');
INSERT INTO `ty_company_setting` VALUES ('14', 'bannerw', '960');
INSERT INTO `ty_company_setting` VALUES ('14', 'css', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'logo', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'background', '');
INSERT INTO `ty_company_setting` VALUES ('14', 'bgcolor', '');

-- ----------------------------
-- Table structure for ty_cron
-- ----------------------------
DROP TABLE IF EXISTS `ty_cron`;
CREATE TABLE `ty_cron` (
  `itemid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  `nexttime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `nexttime` (`nexttime`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='计划任务';

-- ----------------------------
-- Records of ty_cron
-- ----------------------------
INSERT INTO `ty_cron` VALUES ('1', '更新在线状态', '1', 'online', '10', '1494923910', '1494924510', '0', '');
INSERT INTO `ty_cron` VALUES ('2', '内容分表创建', '1', 'split', '0,0', '1494897012', '1494950400', '0', '');
INSERT INTO `ty_cron` VALUES ('3', '清理过期文件缓存', '0', 'cache', '30', '1494923175', '1494924975', '0', '');
INSERT INTO `ty_cron` VALUES ('20', '清理过期禁止IP', '0', 'banip', '0,10', '1494897012', '1494951000', '0', '');
INSERT INTO `ty_cron` VALUES ('21', '清理系统临时文件', '0', 'temp', '0,20', '1494897012', '1494951600', '0', '');
INSERT INTO `ty_cron` VALUES ('40', '清理3天前未付款充值记录', '0', 'charge', '1,0', '1494897012', '1494954000', '0', '');
INSERT INTO `ty_cron` VALUES ('41', '清理30天前404日志', '0', '404', '1,10', '1494897012', '1494954600', '0', '');
INSERT INTO `ty_cron` VALUES ('42', '清理30天前登录日志', '0', 'loginlog', '1,20', '1494897012', '1494955200', '0', '');
INSERT INTO `ty_cron` VALUES ('43', '清理30天前管理日志', '0', 'adminlog', '1,30', '1494897012', '1494955800', '0', '');
INSERT INTO `ty_cron` VALUES ('44', '清理30天前站内交谈', '0', 'chat', '1,40', '1494897012', '1494956400', '0', '');
INSERT INTO `ty_cron` VALUES ('60', '清理90天前已读信件', '0', 'message', '2,0', '0', '0', '1', '');
INSERT INTO `ty_cron` VALUES ('61', '清理90天前资金流水', '0', 'money', '2,10', '0', '0', '1', '');
INSERT INTO `ty_cron` VALUES ('62', '清理90天前积分流水', '0', 'credit', '2,20', '0', '0', '1', '');
INSERT INTO `ty_cron` VALUES ('63', '清理90天前短信流水', '0', 'sms', '2,30', '0', '0', '1', '');
INSERT INTO `ty_cron` VALUES ('64', '清理90天前短信记录', '0', 'smssend', '2,40', '0', '0', '1', '');
INSERT INTO `ty_cron` VALUES ('65', '清理90天前邮件记录', '0', 'maillog', '2,50', '0', '0', '1', '');

-- ----------------------------
-- Table structure for ty_down_15
-- ----------------------------
DROP TABLE IF EXISTS `ty_down_15`;
CREATE TABLE `ty_down_15` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `tag` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `download` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `filesize` float NOT NULL DEFAULT '0',
  `unit` varchar(10) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='下载';

-- ----------------------------
-- Records of ty_down_15
-- ----------------------------

-- ----------------------------
-- Table structure for ty_down_data_15
-- ----------------------------
DROP TABLE IF EXISTS `ty_down_data_15`;
CREATE TABLE `ty_down_data_15` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='下载内容';

-- ----------------------------
-- Records of ty_down_data_15
-- ----------------------------

-- ----------------------------
-- Table structure for ty_exhibit
-- ----------------------------
DROP TABLE IF EXISTS `ty_exhibit`;
CREATE TABLE `ty_exhibit` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `orders` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `city` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `postcode` varchar(20) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `hallname` varchar(100) NOT NULL DEFAULT '',
  `sponsor` varchar(100) NOT NULL DEFAULT '',
  `undertaker` varchar(100) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `addr` varchar(255) NOT NULL DEFAULT '',
  `telephone` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `fax` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `remark` mediumtext NOT NULL,
  `sign` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='展会';

-- ----------------------------
-- Records of ty_exhibit
-- ----------------------------

-- ----------------------------
-- Table structure for ty_exhibit_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_exhibit_data`;
CREATE TABLE `ty_exhibit_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='展会内容';

-- ----------------------------
-- Records of ty_exhibit_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_exhibit_order
-- ----------------------------
DROP TABLE IF EXISTS `ty_exhibit_order`;
CREATE TABLE `ty_exhibit_order` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user` varchar(30) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL,
  `truename` varchar(30) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `username` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='展会报名';

-- ----------------------------
-- Records of ty_exhibit_order
-- ----------------------------

-- ----------------------------
-- Table structure for ty_favorite
-- ----------------------------
DROP TABLE IF EXISTS `ty_favorite`;
CREATE TABLE `ty_favorite` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商机收藏';

-- ----------------------------
-- Records of ty_favorite
-- ----------------------------

-- ----------------------------
-- Table structure for ty_fetch
-- ----------------------------
DROP TABLE IF EXISTS `ty_fetch`;
CREATE TABLE `ty_fetch` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(100) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `encode` varchar(30) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单页采编';

-- ----------------------------
-- Records of ty_fetch
-- ----------------------------

-- ----------------------------
-- Table structure for ty_fields
-- ----------------------------
DROP TABLE IF EXISTS `ty_fields`;
CREATE TABLE `ty_fields` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `length` smallint(4) unsigned NOT NULL DEFAULT '0',
  `html` varchar(30) NOT NULL DEFAULT '',
  `default_value` text NOT NULL,
  `option_value` text NOT NULL,
  `width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `height` smallint(4) unsigned NOT NULL DEFAULT '0',
  `input_limit` varchar(255) NOT NULL DEFAULT '',
  `addition` varchar(255) NOT NULL DEFAULT '',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `front` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `tablename` (`tb`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='自定义字段';

-- ----------------------------
-- Records of ty_fields
-- ----------------------------
INSERT INTO `ty_fields` VALUES ('1', 'mall', 'mallid', '商品编号', '', 'varchar', '155', 'text', '', '', '120', '90', '1', 'size=\"30\"', '1', '1', '0');
INSERT INTO `ty_fields` VALUES ('2', 'mall', 'type1', '规格参数1', '', 'varchar', '100', 'text', '', '', '120', '90', '', 'size=\"15\"', '1', '1', '1');
INSERT INTO `ty_fields` VALUES ('3', 'mall', 'type2', '规格参数2', '', 'varchar', '100', 'text', '', '', '120', '90', '', 'size=\"15\"', '1', '1', '3');
INSERT INTO `ty_fields` VALUES ('4', 'mall', 'type3', '规格参数3', '', 'varchar', '100', 'text', '', '', '120', '90', '', 'size=\"15\"', '1', '1', '5');
INSERT INTO `ty_fields` VALUES ('5', 'mall', 'type4', '规格参数4', '', 'varchar', '100', 'text', '', '', '120', '90', '', 'size=\"15\"', '1', '1', '7');
INSERT INTO `ty_fields` VALUES ('6', 'mall', 'type5', '规格参数5', '', 'varchar', '100', 'text', '', '', '120', '90', '', 'size=\"15\"', '1', '1', '9');
INSERT INTO `ty_fields` VALUES ('7', 'mall', 'value1', '规格参数值1', '', 'varchar', '255', 'text', '', '', '120', '90', '', 'size=\"30\"', '1', '1', '2');
INSERT INTO `ty_fields` VALUES ('8', 'mall', 'value2', '规格参数值2', '', 'varchar', '255', 'text', '', '', '120', '90', '', 'size=\"30\"', '1', '1', '4');
INSERT INTO `ty_fields` VALUES ('9', 'mall', 'value3', '规格参数值3', '', 'varchar', '255', 'text', '', '', '120', '90', '', 'size=\"30\"', '1', '1', '6');
INSERT INTO `ty_fields` VALUES ('10', 'mall', 'value4', '规格参数值4', '', 'varchar', '255', 'text', '', '', '120', '90', '', 'size=\"30\"', '1', '1', '8');
INSERT INTO `ty_fields` VALUES ('11', 'mall', 'value5', '规格参数值5', '', 'varchar', '255', 'text', '', '', '120', '90', '', 'size=\"30\"', '1', '1', '10');
INSERT INTO `ty_fields` VALUES ('13', 'mall', 'marketmoney', '市场价', '', 'float', '0', 'text', '', '', '120', '90', '[0-9]{1,}', 'size=\"15\"', '1', '1', '0');

-- ----------------------------
-- Table structure for ty_finance_card
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_card`;
CREATE TABLE `ty_finance_card` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='充值卡';

-- ----------------------------
-- Records of ty_finance_card
-- ----------------------------
INSERT INTO `ty_finance_card` VALUES ('1', '3378728651', '455654646', '4000.00', 'tianyi', '1491554909', '1586188800', 'shandongpingyi', '1491555161', '127.0.0.1');

-- ----------------------------
-- Table structure for ty_finance_cash
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_cash`;
CREATE TABLE `ty_finance_cash` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `bank` varchar(50) NOT NULL DEFAULT '',
  `banktype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `branch` varchar(100) NOT NULL,
  `account` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='申请提现';

-- ----------------------------
-- Records of ty_finance_cash
-- ----------------------------

-- ----------------------------
-- Table structure for ty_finance_charge
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_charge`;
CREATE TABLE `ty_finance_charge` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `bank` varchar(20) NOT NULL DEFAULT '',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  `receivetime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='在线充值';

-- ----------------------------
-- Records of ty_finance_charge
-- ----------------------------
INSERT INTO `ty_finance_charge` VALUES ('1', 'shandongpingyi', 'card', '4000.00', '0.00', '4000.00', '1491555161', '1491555161', 'system', '3', '', '3378728651');

-- ----------------------------
-- Table structure for ty_finance_credit
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_credit`;
CREATE TABLE `ty_finance_credit` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `amount` int(10) NOT NULL DEFAULT '0',
  `balance` int(10) NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=199 DEFAULT CHARSET=utf8 COMMENT='积分流水';

-- ----------------------------
-- Records of ty_finance_credit
-- ----------------------------
INSERT INTO `ty_finance_credit` VALUES ('1', 'tianyi', '1', '1', '1468201120', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('2', 'tianyi', '1', '2', '1468383957', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('3', 'tianyi', '1', '3', '1475897949', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('5', 'tianyi', '1', '4', '1477964440', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('6', 'hekw07', '20', '20', '1481705047', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('7', 'tianyi', '1', '5', '1481705090', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('8', 'hekw08', '20', '20', '1482717451', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('9', 'tianyi', '1', '6', '1482717501', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('10', 'tianyi', '1', '7', '1483514446', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('11', 'tianyi', '1', '8', '1483889810', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('12', 'tianyi', '1', '9', '1484463592', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('13', 'tianyi', '2', '11', '1484810894', '产品发布', 'ID:1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('14', 'tianyi', '2', '13', '1484811970', '产品发布', 'ID:2', 'system');
INSERT INTO `ty_finance_credit` VALUES ('15', 'tianyi', '2', '15', '1484812013', '产品发布', 'ID:3', 'system');
INSERT INTO `ty_finance_credit` VALUES ('16', 'tianyi', '2', '17', '1484812040', '产品发布', 'ID:4', 'system');
INSERT INTO `ty_finance_credit` VALUES ('17', 'tianyi', '2', '19', '1484812328', '产品发布', 'ID:5', 'system');
INSERT INTO `ty_finance_credit` VALUES ('18', 'tianyi', '2', '21', '1484812354', '产品发布', 'ID:6', 'system');
INSERT INTO `ty_finance_credit` VALUES ('19', 'tianyi', '2', '23', '1484815778', '产品发布', 'ID:7', 'system');
INSERT INTO `ty_finance_credit` VALUES ('20', 'tianyi', '2', '25', '1484815809', '产品发布', 'ID:8', 'system');
INSERT INTO `ty_finance_credit` VALUES ('21', 'tianyi', '1', '26', '1484881254', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('22', 'tianyi', '2', '28', '1484881636', '产品发布', 'ID:9', 'system');
INSERT INTO `ty_finance_credit` VALUES ('23', 'tianyi', '2', '30', '1484881670', '产品发布', 'ID:10', 'system');
INSERT INTO `ty_finance_credit` VALUES ('24', 'tianyi', '2', '32', '1484881711', '产品发布', 'ID:11', 'system');
INSERT INTO `ty_finance_credit` VALUES ('25', 'tianyi', '2', '34', '1484881762', '产品发布', 'ID:12', 'system');
INSERT INTO `ty_finance_credit` VALUES ('26', 'tianyi', '2', '36', '1484881931', '产品发布', 'ID:13', 'system');
INSERT INTO `ty_finance_credit` VALUES ('27', 'tianyi', '2', '38', '1484881997', '产品发布', 'ID:14', 'system');
INSERT INTO `ty_finance_credit` VALUES ('28', 'tianyi', '2', '40', '1484882144', '产品发布', 'ID:15', 'system');
INSERT INTO `ty_finance_credit` VALUES ('29', 'tianyi', '2', '42', '1484882251', '产品发布', 'ID:16', 'system');
INSERT INTO `ty_finance_credit` VALUES ('30', 'tianyi', '2', '44', '1484882305', '产品发布', 'ID:17', 'system');
INSERT INTO `ty_finance_credit` VALUES ('31', 'tianyi', '2', '46', '1484882474', '产品发布', 'ID:18', 'system');
INSERT INTO `ty_finance_credit` VALUES ('32', 'tianyi', '2', '48', '1484882736', '产品发布', 'ID:19', 'system');
INSERT INTO `ty_finance_credit` VALUES ('33', 'tianyi', '2', '50', '1484882809', '产品发布', 'ID:20', 'system');
INSERT INTO `ty_finance_credit` VALUES ('34', 'tianyi', '2', '52', '1484882921', '产品发布', 'ID:21', 'system');
INSERT INTO `ty_finance_credit` VALUES ('35', 'tianyi', '2', '54', '1484882948', '产品发布', 'ID:22', 'system');
INSERT INTO `ty_finance_credit` VALUES ('36', 'tianyi', '2', '56', '1484883147', '产品发布', 'ID:23', 'system');
INSERT INTO `ty_finance_credit` VALUES ('37', 'tianyi', '2', '58', '1484883188', '产品发布', 'ID:24', 'system');
INSERT INTO `ty_finance_credit` VALUES ('38', 'tianyi', '2', '60', '1484883325', '产品发布', 'ID:25', 'system');
INSERT INTO `ty_finance_credit` VALUES ('39', 'tianyi', '2', '62', '1484883357', '产品发布', 'ID:26', 'system');
INSERT INTO `ty_finance_credit` VALUES ('40', 'tianyi', '2', '64', '1484883489', '产品发布', 'ID:27', 'system');
INSERT INTO `ty_finance_credit` VALUES ('41', 'tianyi', '2', '66', '1484883608', '产品发布', 'ID:28', 'system');
INSERT INTO `ty_finance_credit` VALUES ('42', 'tianyi', '2', '68', '1484883765', '产品发布', 'ID:29', 'system');
INSERT INTO `ty_finance_credit` VALUES ('43', 'tianyi', '2', '70', '1484883800', '产品发布', 'ID:30', 'system');
INSERT INTO `ty_finance_credit` VALUES ('44', 'tianyi', '2', '72', '1484884344', '产品发布', 'ID:31', 'system');
INSERT INTO `ty_finance_credit` VALUES ('45', 'tianyi', '2', '74', '1484884440', '产品发布', 'ID:32', 'system');
INSERT INTO `ty_finance_credit` VALUES ('46', 'tianyi', '2', '76', '1484884499', '产品发布', 'ID:33', 'system');
INSERT INTO `ty_finance_credit` VALUES ('47', 'tianyi', '2', '78', '1484884569', '产品发布', 'ID:34', 'system');
INSERT INTO `ty_finance_credit` VALUES ('48', 'tianyi', '2', '80', '1484884615', '产品发布', 'ID:35', 'system');
INSERT INTO `ty_finance_credit` VALUES ('49', 'tianyi', '2', '82', '1484884680', '产品发布', 'ID:36', 'system');
INSERT INTO `ty_finance_credit` VALUES ('50', 'tianyi', '2', '84', '1484892357', '产品发布', 'ID:37', 'system');
INSERT INTO `ty_finance_credit` VALUES ('51', 'tianyi', '2', '86', '1484892478', '产品发布', 'ID:38', 'system');
INSERT INTO `ty_finance_credit` VALUES ('52', 'tianyi', '2', '88', '1484892617', '产品发布', 'ID:39', 'system');
INSERT INTO `ty_finance_credit` VALUES ('53', 'tianyi', '2', '90', '1484892659', '产品发布', 'ID:40', 'system');
INSERT INTO `ty_finance_credit` VALUES ('54', 'tianyi', '2', '92', '1484892798', '产品发布', 'ID:41', 'system');
INSERT INTO `ty_finance_credit` VALUES ('55', 'tianyi', '2', '94', '1484892900', '产品发布', 'ID:42', 'system');
INSERT INTO `ty_finance_credit` VALUES ('56', 'tianyi', '2', '96', '1484893067', '产品发布', 'ID:43', 'system');
INSERT INTO `ty_finance_credit` VALUES ('57', 'tianyi', '2', '98', '1484893206', '产品发布', 'ID:44', 'system');
INSERT INTO `ty_finance_credit` VALUES ('58', 'tianyi', '2', '100', '1484893233', '产品发布', 'ID:45', 'system');
INSERT INTO `ty_finance_credit` VALUES ('59', 'tianyi', '2', '102', '1484893325', '产品发布', 'ID:46', 'system');
INSERT INTO `ty_finance_credit` VALUES ('60', 'tianyi', '2', '104', '1484893363', '产品发布', 'ID:47', 'system');
INSERT INTO `ty_finance_credit` VALUES ('61', 'tianyi', '2', '106', '1484893425', '产品发布', 'ID:48', 'system');
INSERT INTO `ty_finance_credit` VALUES ('62', 'tianyi', '1', '107', '1485065713', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('63', 'tianyi', '1', '108', '1486189258', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('64', 'tianyi', '1', '109', '1486455664', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('65', 'tianyi', '1', '110', '1487733526', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('66', 'tianyi', '1', '111', '1491016437', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('67', 'zhishuai', '20', '20', '1491016776', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('68', 'tianyi', '1', '112', '1491372955', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('69', 'tianjian', '20', '20', '1491373855', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('70', 'tianyianfang', '20', '20', '1491379746', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('71', 'hanzhongshengtu', '20', '20', '1491380102', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('72', 'zhongshankehong', '20', '20', '1491380289', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('73', 'shanghaiyante', '20', '20', '1491380430', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('74', 'zhejiangyingyang', '20', '20', '1491381264', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('75', 'kuzishiye', '20', '20', '1491381406', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('76', 'shenzhenwanxi', '20', '20', '1491381893', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('77', 'shandongpingyi', '20', '20', '1491382289', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('78', 'laizhoujieli', '20', '20', '1491382456', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('79', 'hebeixinda', '20', '20', '1491382757', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('80', 'zhongshanyayun', '20', '20', '1491383078', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('81', 'zhongshanxingdi', '20', '20', '1491383210', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('82', 'hulunbeier', '20', '20', '1491383345', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('83', 'qingdaojutai', '20', '20', '1491383989', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('84', 'nanjingtianjia', '20', '20', '1491384217', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('85', 'jinlida', '20', '20', '1491442132', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('86', 'guangzhousutai', '20', '20', '1491442287', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('87', 'hebeihongyun', '20', '20', '1491442550', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('88', 'lizhiheng', '20', '20', '1491442865', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('89', 'shanghaiyuansu', '20', '20', '1491442992', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('90', 'meijiahua', '20', '20', '1491443117', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('91', 'dengquan', '20', '20', '1491443251', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('92', 'jinhui', '20', '20', '1491443991', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('93', 'dimaikesi', '20', '20', '1491444364', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('94', 'lulu', '20', '20', '1491444646', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('95', 'anterui', '20', '20', '1491444776', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('96', 'guying', '20', '20', '1491444906', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('97', 'qipu', '20', '20', '1491445277', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('98', 'dongyi', '20', '20', '1491445471', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('99', 'mengmeiyi', '20', '20', '1491447981', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('100', 'zhongjian', '20', '20', '1491448107', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('101', 'hengpu', '20', '20', '1491448445', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('102', 'deli', '20', '20', '1491448644', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('103', 'weinun', '20', '20', '1491448770', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('104', 'wolu', '20', '20', '1491448881', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('105', 'maizhong', '20', '20', '1491449024', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('106', 'huazhicheng', '20', '20', '1491449199', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('107', 'fumushi', '20', '20', '1491449837', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('108', 'bodun', '20', '20', '1491449980', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('109', 'guangtong', '20', '20', '1491450112', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('110', 'taihong', '20', '20', '1491450222', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('111', 'xinxin', '20', '20', '1491450343', '注册奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('112', 'hulunbeier', '1', '21', '1491450664', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('113', 'hulunbeier', '2', '23', '1491458439', '品牌发布', 'ID:1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('114', 'hulunbeier', '2', '25', '1491460572', '产品发布', 'ID:50', 'system');
INSERT INTO `ty_finance_credit` VALUES ('115', 'hulunbeier', '2', '27', '1491460572', '产品发布', 'ID:49', 'system');
INSERT INTO `ty_finance_credit` VALUES ('116', 'zhongshanxingdi', '1', '21', '1491468988', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('117', 'zhongshanxingdi', '2', '23', '1491470470', '产品发布', 'ID:54', 'system');
INSERT INTO `ty_finance_credit` VALUES ('118', 'zhongshanxingdi', '2', '25', '1491470470', '产品发布', 'ID:53', 'system');
INSERT INTO `ty_finance_credit` VALUES ('119', 'zhongshanxingdi', '2', '27', '1491470470', '产品发布', 'ID:52', 'system');
INSERT INTO `ty_finance_credit` VALUES ('120', 'zhongshanyayun', '1', '21', '1491528327', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('121', 'zhongshanyayun', '2', '23', '1491528623', '产品发布', 'ID:57', 'system');
INSERT INTO `ty_finance_credit` VALUES ('122', 'zhongshanyayun', '2', '25', '1491528623', '产品发布', 'ID:56', 'system');
INSERT INTO `ty_finance_credit` VALUES ('123', 'zhongshanyayun', '2', '27', '1491528623', '产品发布', 'ID:55', 'system');
INSERT INTO `ty_finance_credit` VALUES ('124', 'zhongshanxingdi', '1', '28', '1491529433', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('125', 'hebeixinda', '1', '21', '1491529625', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('126', 'hebeixinda', '2', '23', '1491530181', '产品发布', 'ID:60', 'system');
INSERT INTO `ty_finance_credit` VALUES ('127', 'hebeixinda', '2', '25', '1491530181', '产品发布', 'ID:59', 'system');
INSERT INTO `ty_finance_credit` VALUES ('128', 'hebeixinda', '2', '27', '1491530181', '产品发布', 'ID:58', 'system');
INSERT INTO `ty_finance_credit` VALUES ('129', 'laizhoujieli', '1', '21', '1491530319', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('130', 'laizhoujieli', '2', '23', '1491530981', '产品发布', 'ID:63', 'system');
INSERT INTO `ty_finance_credit` VALUES ('131', 'laizhoujieli', '2', '25', '1491530981', '产品发布', 'ID:62', 'system');
INSERT INTO `ty_finance_credit` VALUES ('132', 'laizhoujieli', '2', '27', '1491530981', '产品发布', 'ID:61', 'system');
INSERT INTO `ty_finance_credit` VALUES ('133', 'shandongpingyi', '1', '21', '1491531447', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('134', 'shandongpingyi', '2', '23', '1491531650', '产品发布', 'ID:65', 'system');
INSERT INTO `ty_finance_credit` VALUES ('135', 'shandongpingyi', '2', '25', '1491531650', '产品发布', 'ID:64', 'system');
INSERT INTO `ty_finance_credit` VALUES ('136', 'shandongpingyi', '2', '27', '1491792447', '证书上传', 'ID:1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('137', 'shandongpingyi', '1', '28', '1491808122', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('138', 'tianyi', '1', '113', '1491808173', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('139', 'shandongpingyi', '2', '30', '1491808891', '产品发布', 'ID:66', 'system');
INSERT INTO `ty_finance_credit` VALUES ('140', 'tianyi', '1', '114', '1492652024', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('141', 'shandongpingyi', '1', '31', '1492652477', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('142', 'tianyi', '1', '115', '1493348761', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('143', 'tianyi', '1', '116', '1493689858', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('144', 'shandongpingyi', '2', '33', '1493708256', '证书上传', 'ID:1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('145', 'shandongpingyi', '2', '35', '1493708311', '证书上传', 'ID:2', 'system');
INSERT INTO `ty_finance_credit` VALUES ('146', 'shandongpingyi', '2', '37', '1493708951', '证书上传', 'ID:3', 'system');
INSERT INTO `ty_finance_credit` VALUES ('147', 'shandongpingyi', '2', '39', '1493709635', '证书上传', 'ID:2', 'system');
INSERT INTO `ty_finance_credit` VALUES ('148', 'shandongpingyi', '1', '40', '1493774061', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('149', 'shandongpingyi', '2', '42', '1493782075', '产品发布', 'ID:67', 'system');
INSERT INTO `ty_finance_credit` VALUES ('150', 'shandongpingyi', '2', '44', '1493782121', '产品发布', 'ID:68', 'system');
INSERT INTO `ty_finance_credit` VALUES ('151', 'shandongpingyi', '2', '46', '1493782178', '证书上传', 'ID:3', 'system');
INSERT INTO `ty_finance_credit` VALUES ('152', 'shandongpingyi', '2', '48', '1493782192', '证书上传', 'ID:4', 'system');
INSERT INTO `ty_finance_credit` VALUES ('153', 'shandongpingyi', '2', '50', '1493782206', '证书上传', 'ID:5', 'system');
INSERT INTO `ty_finance_credit` VALUES ('154', 'shandongpingyi', '2', '52', '1493782256', '产品发布', 'ID:69', 'system');
INSERT INTO `ty_finance_credit` VALUES ('155', 'tianyi', '1', '117', '1493782408', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('156', 'shandongpingyi', '2', '54', '1493783331', '产品发布', 'ID:70', 'system');
INSERT INTO `ty_finance_credit` VALUES ('157', 'tianyi', '1', '118', '1493861506', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('158', 'shandongpingyi', '2', '56', '1493861613', '证书上传', 'ID:4', 'system');
INSERT INTO `ty_finance_credit` VALUES ('159', 'shandongpingyi', '2', '58', '1493861630', '证书上传', 'ID:5', 'system');
INSERT INTO `ty_finance_credit` VALUES ('160', 'shandongpingyi', '2', '60', '1493861668', '证书上传', 'ID:6', 'system');
INSERT INTO `ty_finance_credit` VALUES ('161', 'shandongpingyi', '2', '62', '1493861758', '证书上传', 'ID:7', 'system');
INSERT INTO `ty_finance_credit` VALUES ('162', 'shandongpingyi', '2', '64', '1493861767', '证书上传', 'ID:8', 'system');
INSERT INTO `ty_finance_credit` VALUES ('163', 'shandongpingyi', '2', '66', '1493866163', '证书上传', 'ID:6', 'system');
INSERT INTO `ty_finance_credit` VALUES ('164', 'shandongpingyi', '2', '68', '1493866175', '证书上传', 'ID:7', 'system');
INSERT INTO `ty_finance_credit` VALUES ('165', 'shandongpingyi', '2', '70', '1493866183', '证书上传', 'ID:8', 'system');
INSERT INTO `ty_finance_credit` VALUES ('166', 'shandongpingyi', '2', '72', '1493866195', '证书上传', 'ID:9', 'system');
INSERT INTO `ty_finance_credit` VALUES ('167', 'shandongpingyi', '2', '74', '1493866205', '证书上传', 'ID:10', 'system');
INSERT INTO `ty_finance_credit` VALUES ('168', 'shandongpingyi', '2', '76', '1493866213', '证书上传', 'ID:11', 'system');
INSERT INTO `ty_finance_credit` VALUES ('169', 'tianyi', '1', '119', '1493947994', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('170', 'shandongpingyi', '2', '78', '1493952843', '产品发布', 'ID:71', 'system');
INSERT INTO `ty_finance_credit` VALUES ('171', 'tianyi', '1', '120', '1494209670', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('172', 'tianyi', '1', '121', '1494295355', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('173', 'tianyi', '1', '122', '1494400747', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('174', 'tianyi', '2', '124', '1494401962', '资讯发布', 'ID:1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('175', 'shandongpingyi', '2', '80', '1494402030', '资讯发布', 'ID:2', 'system');
INSERT INTO `ty_finance_credit` VALUES ('176', 'tianyi', '2', '126', '1494407800', '资讯发布', 'ID:3', 'system');
INSERT INTO `ty_finance_credit` VALUES ('177', 'tianyi', '2', '128', '1494407808', '资讯发布', 'ID:4', 'system');
INSERT INTO `ty_finance_credit` VALUES ('178', 'tianyi', '2', '130', '1494407814', '资讯发布', 'ID:5', 'system');
INSERT INTO `ty_finance_credit` VALUES ('179', 'tianyi', '2', '132', '1494407817', '资讯发布', 'ID:6', 'system');
INSERT INTO `ty_finance_credit` VALUES ('180', 'tianyi', '2', '134', '1494407823', '资讯发布', 'ID:7', 'system');
INSERT INTO `ty_finance_credit` VALUES ('181', 'tianyi', '2', '136', '1494407827', '资讯发布', 'ID:8', 'system');
INSERT INTO `ty_finance_credit` VALUES ('182', 'tianyi', '2', '138', '1494407831', '资讯发布', 'ID:9', 'system');
INSERT INTO `ty_finance_credit` VALUES ('183', 'tianyi', '2', '140', '1494407842', '资讯发布', 'ID:10', 'system');
INSERT INTO `ty_finance_credit` VALUES ('184', 'tianyi', '2', '142', '1494407845', '资讯发布', 'ID:11', 'system');
INSERT INTO `ty_finance_credit` VALUES ('185', 'tianyi', '2', '144', '1494407852', '资讯发布', 'ID:12', 'system');
INSERT INTO `ty_finance_credit` VALUES ('186', 'tianyi', '1', '145', '1494464919', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('187', 'tianyi', '2', '147', '1494465046', '资讯发布', 'ID:13', 'system');
INSERT INTO `ty_finance_credit` VALUES ('188', 'tianyi', '2', '149', '1494465155', '资讯发布', 'ID:14', 'system');
INSERT INTO `ty_finance_credit` VALUES ('189', 'tianyi', '2', '151', '1494465160', '资讯发布', 'ID:15', 'system');
INSERT INTO `ty_finance_credit` VALUES ('190', 'tianyi', '2', '153', '1494465164', '资讯发布', 'ID:16', 'system');
INSERT INTO `ty_finance_credit` VALUES ('191', 'tianyi', '1', '154', '1494568662', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('192', 'tianyi', '1', '155', '1494640007', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('193', 'tianyi', '2', '157', '1494656399', '俱乐部发布', 'ID:17', 'system');
INSERT INTO `ty_finance_credit` VALUES ('194', 'tianyi', '2', '159', '1494656554', '俱乐部发布', 'ID:18', 'system');
INSERT INTO `ty_finance_credit` VALUES ('195', 'tianyi', '1', '160', '1494812074', '登录奖励', '127.0.0.1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('196', 'tianyi', '2', '162', '1494818105', '找施工发布', 'ID:1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('197', 'tianyi', '2', '164', '1494819194', '找施工发布', 'ID:1', 'system');
INSERT INTO `ty_finance_credit` VALUES ('198', 'tianyi', '1', '165', '1494922391', '登录奖励', '127.0.0.1', 'system');

-- ----------------------------
-- Table structure for ty_finance_deposit
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_deposit`;
CREATE TABLE `ty_finance_deposit` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL,
  `reason` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='保证金';

-- ----------------------------
-- Records of ty_finance_deposit
-- ----------------------------
INSERT INTO `ty_finance_deposit` VALUES ('1', 'laizhoujieli', '4000.00', '1491554524', 'tianyi', 'wswe', '');
INSERT INTO `ty_finance_deposit` VALUES ('2', 'shandongpingyi', '4000.00', '1491554567', 'tianyi', 'aew', '');

-- ----------------------------
-- Table structure for ty_finance_pay
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_pay`;
CREATE TABLE `ty_finance_pay` (
  `pid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `fee` float unsigned NOT NULL DEFAULT '0',
  `currency` varchar(20) NOT NULL DEFAULT '',
  `paytime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付记录';

-- ----------------------------
-- Records of ty_finance_pay
-- ----------------------------

-- ----------------------------
-- Table structure for ty_finance_promo
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_promo`;
CREATE TABLE `ty_finance_promo` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(30) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `amount` float NOT NULL DEFAULT '0',
  `reuse` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  UNIQUE KEY `number` (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='优惠码';

-- ----------------------------
-- Records of ty_finance_promo
-- ----------------------------

-- ----------------------------
-- Table structure for ty_finance_record
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_record`;
CREATE TABLE `ty_finance_record` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `bank` varchar(30) NOT NULL DEFAULT '',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='财务流水';

-- ----------------------------
-- Records of ty_finance_record
-- ----------------------------
INSERT INTO `ty_finance_record` VALUES ('1', 'shandongpingyi', '充值卡', '4000.00', '4000.00', '1491555161', '充值卡充值', '卡号:3378728651', 'system');
INSERT INTO `ty_finance_record` VALUES ('2', 'shandongpingyi', '站内', '-2000.00', '2000.00', '1491555307', '会员升级', '升级为:VIP会员', 'system');

-- ----------------------------
-- Table structure for ty_finance_sms
-- ----------------------------
DROP TABLE IF EXISTS `ty_finance_sms`;
CREATE TABLE `ty_finance_sms` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `amount` int(10) NOT NULL DEFAULT '0',
  `balance` int(10) NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信增减';

-- ----------------------------
-- Records of ty_finance_sms
-- ----------------------------

-- ----------------------------
-- Table structure for ty_form
-- ----------------------------
DROP TABLE IF EXISTS `ty_form`;
CREATE TABLE `ty_form` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `groupid` varchar(255) NOT NULL,
  `verify` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `question` int(10) unsigned NOT NULL DEFAULT '0',
  `answer` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='表单';

-- ----------------------------
-- Records of ty_form
-- ----------------------------

-- ----------------------------
-- Table structure for ty_form_answer
-- ----------------------------
DROP TABLE IF EXISTS `ty_form_answer`;
CREATE TABLE `ty_form_answer` (
  `aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `rid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `qid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `other` varchar(255) NOT NULL,
  `item` varchar(100) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='表单回复';

-- ----------------------------
-- Records of ty_form_answer
-- ----------------------------

-- ----------------------------
-- Table structure for ty_form_question
-- ----------------------------
DROP TABLE IF EXISTS `ty_form_question`;
CREATE TABLE `ty_form_question` (
  `qid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  `required` varchar(30) NOT NULL,
  `extend` mediumtext NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='表单选项';

-- ----------------------------
-- Records of ty_form_question
-- ----------------------------

-- ----------------------------
-- Table structure for ty_form_record
-- ----------------------------
DROP TABLE IF EXISTS `ty_form_record`;
CREATE TABLE `ty_form_record` (
  `rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `item` varchar(100) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='表单回复记录';

-- ----------------------------
-- Records of ty_form_record
-- ----------------------------

-- ----------------------------
-- Table structure for ty_friend
-- ----------------------------
DROP TABLE IF EXISTS `ty_friend`;
CREATE TABLE `ty_friend` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(20) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `career` varchar(20) NOT NULL DEFAULT '',
  `telephone` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `homepage` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='我的商友';

-- ----------------------------
-- Records of ty_friend
-- ----------------------------

-- ----------------------------
-- Table structure for ty_gift
-- ----------------------------
DROP TABLE IF EXISTS `ty_gift`;
CREATE TABLE `ty_gift` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `groupid` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `orders` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分换礼';

-- ----------------------------
-- Records of ty_gift
-- ----------------------------

-- ----------------------------
-- Table structure for ty_gift_order
-- ----------------------------
DROP TABLE IF EXISTS `ty_gift_order`;
CREATE TABLE `ty_gift_order` (
  `oid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`oid`),
  KEY `itemid` (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分换礼订单';

-- ----------------------------
-- Records of ty_gift_order
-- ----------------------------

-- ----------------------------
-- Table structure for ty_group
-- ----------------------------
DROP TABLE IF EXISTS `ty_group`;
CREATE TABLE `ty_group` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `marketprice` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `savemoney` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `discount` float unsigned NOT NULL DEFAULT '0',
  `minamount` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `logistic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `orders` int(10) unsigned NOT NULL DEFAULT '0',
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `process` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团购';

-- ----------------------------
-- Records of ty_group
-- ----------------------------

-- ----------------------------
-- Table structure for ty_group_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_group_data`;
CREATE TABLE `ty_group_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团购内容';

-- ----------------------------
-- Records of ty_group_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_group_order
-- ----------------------------
DROP TABLE IF EXISTS `ty_group_order`;
CREATE TABLE `ty_group_order` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `buyer` varchar(30) NOT NULL DEFAULT '',
  `seller` varchar(30) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `logistic` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `password` varchar(6) NOT NULL DEFAULT '',
  `buyer_name` varchar(30) NOT NULL DEFAULT '',
  `buyer_address` varchar(255) NOT NULL DEFAULT '',
  `buyer_postcode` varchar(10) NOT NULL DEFAULT '',
  `buyer_phone` varchar(30) NOT NULL DEFAULT '',
  `buyer_mobile` varchar(30) NOT NULL DEFAULT '',
  `send_type` varchar(50) NOT NULL DEFAULT '',
  `send_no` varchar(50) NOT NULL DEFAULT '',
  `send_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `send_time` varchar(20) NOT NULL DEFAULT '',
  `send_days` int(10) unsigned NOT NULL DEFAULT '0',
  `add_time` smallint(6) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `buyer_reason` mediumtext NOT NULL,
  `refund_reason` mediumtext NOT NULL,
  `note` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `buyer` (`buyer`),
  KEY `seller` (`seller`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团购订单';

-- ----------------------------
-- Records of ty_group_order
-- ----------------------------

-- ----------------------------
-- Table structure for ty_guestbook
-- ----------------------------
DROP TABLE IF EXISTS `ty_guestbook`;
CREATE TABLE `ty_guestbook` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(30) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言本';

-- ----------------------------
-- Records of ty_guestbook
-- ----------------------------

-- ----------------------------
-- Table structure for ty_honor
-- ----------------------------
DROP TABLE IF EXISTS `ty_honor`;
CREATE TABLE `ty_honor` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `authority` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='荣誉资质';

-- ----------------------------
-- Records of ty_honor
-- ----------------------------
INSERT INTO `ty_honor` VALUES ('1', '营业执照', '', '&nbsp;发生地方', '广州市工商局', 'http://www.tctianyi.com/file/upload/201704/10/1047224414.jpg.thumb.jpg', '1', 'shandongpingyi', '1491792447', '1468944000', '1525103999', '', '1491792447', '0', '', '');
INSERT INTO `ty_honor` VALUES ('2', '测试证书', '', '&nbsp;1111', '测试', 'http://www.tctianyi.com/file/upload/201705/02/1458205114.jpg.thumb.jpg', '0', 'shandongpingyi', '1493708311', '1493568000', '0', '', '1493708311', '3', '', '');
INSERT INTO `ty_honor` VALUES ('3', '按时大大大·1', '#008080', '&nbsp;', '啊实打实的', 'http://www.tctianyi.com/file/upload/201705/02/1509092314.jpg.thumb.jpg', '0', 'shandongpingyi', '1493708951', '1493568000', '0', '', '1493708951', '3', '', '');
INSERT INTO `ty_honor` VALUES ('4', '沙发发发', '', '&nbsp;', '22222', 'http://www.tctianyi.com/file/upload/201705/04/0933315814.jpg.thumb.jpg', '0', 'shandongpingyi', '1493861613', '1493654400', '0', '', '1493861613', '3', '', '');
INSERT INTO `ty_honor` VALUES ('5', '1111111', '', '&nbsp;', '111111', 'http://www.tctianyi.com/file/upload/201705/04/0933488814.png.thumb.png', '0', 'shandongpingyi', '1493861630', '1493568000', '1494518399', '', '1493861630', '4', '', '');
INSERT INTO `ty_honor` VALUES ('6', '1111111122222', '', '<br />', '2222222', 'http://www.tctianyi.com/file/upload/201705/04/0934046014.jpg.thumb.jpg', '0', 'shandongpingyi', '1493861668', '1493568000', '0', '', '1493861668', '3', '', '');
INSERT INTO `ty_honor` VALUES ('7', '111111', '', '&nbsp;', '11111111', 'http://www.tctianyi.com/file/upload/201705/04/0935573714.jpg.thumb.jpg', '0', 'shandongpingyi', '1493861758', '1493568000', '0', '', '1493861758', '3', '', '');
INSERT INTO `ty_honor` VALUES ('8', '1111111', '', '&nbsp;', '111111', 'http://www.tctianyi.com/file/upload/201705/04/0936069214.jpg.thumb.jpg', '0', 'shandongpingyi', '1493861767', '1493654400', '0', '', '1493861767', '3', '', '');

-- ----------------------------
-- Table structure for ty_info_22
-- ----------------------------
DROP TABLE IF EXISTS `ty_info_22`;
CREATE TABLE `ty_info_22` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `fax` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(100) NOT NULL,
  `v2` varchar(100) NOT NULL,
  `v3` varchar(100) NOT NULL,
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`),
  KEY `editdate` (`editdate`,`vip`,`edittime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='招商';

-- ----------------------------
-- Records of ty_info_22
-- ----------------------------

-- ----------------------------
-- Table structure for ty_info_data_22
-- ----------------------------
DROP TABLE IF EXISTS `ty_info_data_22`;
CREATE TABLE `ty_info_data_22` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='招商内容';

-- ----------------------------
-- Records of ty_info_data_22
-- ----------------------------

-- ----------------------------
-- Table structure for ty_job
-- ----------------------------
DROP TABLE IF EXISTS `ty_job`;
CREATE TABLE `ty_job` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `department` varchar(100) NOT NULL DEFAULT '',
  `total` smallint(4) unsigned NOT NULL DEFAULT '0',
  `minsalary` int(10) unsigned NOT NULL DEFAULT '0',
  `maxsalary` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `marriage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `education` smallint(2) unsigned NOT NULL DEFAULT '0',
  `experience` smallint(2) unsigned NOT NULL DEFAULT '0',
  `minage` smallint(2) unsigned NOT NULL DEFAULT '0',
  `maxage` smallint(2) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL,
  `apply` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='招聘';

-- ----------------------------
-- Records of ty_job
-- ----------------------------

-- ----------------------------
-- Table structure for ty_job_apply
-- ----------------------------
DROP TABLE IF EXISTS `ty_job_apply`;
CREATE TABLE `ty_job_apply` (
  `applyid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jobid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `resumeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `job_username` varchar(30) NOT NULL DEFAULT '',
  `apply_username` varchar(30) NOT NULL DEFAULT '',
  `applytime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`applyid`),
  KEY `job_username` (`job_username`),
  KEY `apply_username` (`apply_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应聘工作';

-- ----------------------------
-- Records of ty_job_apply
-- ----------------------------

-- ----------------------------
-- Table structure for ty_job_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_job_data`;
CREATE TABLE `ty_job_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='招聘内容';

-- ----------------------------
-- Records of ty_job_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_job_talent
-- ----------------------------
DROP TABLE IF EXISTS `ty_job_talent`;
CREATE TABLE `ty_job_talent` (
  `talentid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `resumeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `jointime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`talentid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='人才库';

-- ----------------------------
-- Records of ty_job_talent
-- ----------------------------

-- ----------------------------
-- Table structure for ty_keylink
-- ----------------------------
DROP TABLE IF EXISTS `ty_keylink`;
CREATE TABLE `ty_keylink` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `item` varchar(20) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关联链接';

-- ----------------------------
-- Records of ty_keylink
-- ----------------------------

-- ----------------------------
-- Table structure for ty_keyword
-- ----------------------------
DROP TABLE IF EXISTS `ty_keyword`;
CREATE TABLE `ty_keyword` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `word` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `letter` varchar(255) NOT NULL DEFAULT '',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `total_search` int(10) unsigned NOT NULL DEFAULT '0',
  `month_search` int(10) unsigned NOT NULL DEFAULT '0',
  `week_search` int(10) unsigned NOT NULL DEFAULT '0',
  `today_search` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`itemid`),
  KEY `moduleid` (`moduleid`),
  KEY `word` (`word`),
  KEY `letter` (`letter`),
  KEY `keyword` (`keyword`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='关键词';

-- ----------------------------
-- Records of ty_keyword
-- ----------------------------
INSERT INTO `ty_keyword` VALUES ('1', '21', '1111111', '1111111', '1111111', '3', '1494655914', '3', '3', '3', '3', '3');

-- ----------------------------
-- Table structure for ty_know
-- ----------------------------
DROP TABLE IF EXISTS `ty_know`;
CREATE TABLE `ty_know` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `aid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `process` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `message` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `addition` mediumtext NOT NULL,
  `comment` mediumtext NOT NULL,
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `raise` int(10) unsigned NOT NULL DEFAULT '0',
  `agree` int(10) unsigned NOT NULL DEFAULT '0',
  `against` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `answer` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `ask` varchar(30) NOT NULL,
  `expert` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='知道';

-- ----------------------------
-- Records of ty_know
-- ----------------------------

-- ----------------------------
-- Table structure for ty_know_answer
-- ----------------------------
DROP TABLE IF EXISTS `ty_know_answer`;
CREATE TABLE `ty_know_answer` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `qid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `vote` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `expert` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `qid` (`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='知道回答';

-- ----------------------------
-- Records of ty_know_answer
-- ----------------------------

-- ----------------------------
-- Table structure for ty_know_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_know_data`;
CREATE TABLE `ty_know_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='知道内容';

-- ----------------------------
-- Records of ty_know_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_know_expert
-- ----------------------------
DROP TABLE IF EXISTS `ty_know_expert`;
CREATE TABLE `ty_know_expert` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `style` varchar(50) NOT NULL DEFAULT '',
  `major` varchar(255) NOT NULL,
  `ask` int(10) unsigned NOT NULL DEFAULT '0',
  `answer` int(10) unsigned NOT NULL DEFAULT '0',
  `best` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='知道专家';

-- ----------------------------
-- Records of ty_know_expert
-- ----------------------------

-- ----------------------------
-- Table structure for ty_know_vote
-- ----------------------------
DROP TABLE IF EXISTS `ty_know_vote`;
CREATE TABLE `ty_know_vote` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `qid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `aid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='知道投票';

-- ----------------------------
-- Records of ty_know_vote
-- ----------------------------

-- ----------------------------
-- Table structure for ty_link
-- ----------------------------
DROP TABLE IF EXISTS `ty_link`;
CREATE TABLE `ty_link` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `listorder` (`listorder`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='友情链接';

-- ----------------------------
-- Records of ty_link
-- ----------------------------
INSERT INTO `ty_link` VALUES ('1', '1', '0', '天成医疗网', '', '', '天成医疗网', '', '1467860142', 'tianyi', '1468385214', '0', '1', '3', 'http://www.tecenet.com/');

-- ----------------------------
-- Table structure for ty_login
-- ----------------------------
DROP TABLE IF EXISTS `ty_login`;
CREATE TABLE `ty_login` (
  `logid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `passsalt` varchar(8) NOT NULL,
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `loginip` varchar(50) NOT NULL DEFAULT '',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL DEFAULT '',
  `agent` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='登录日志';

-- ----------------------------
-- Records of ty_login
-- ----------------------------

-- ----------------------------
-- Table structure for ty_mail
-- ----------------------------
DROP TABLE IF EXISTS `ty_mail`;
CREATE TABLE `ty_mail` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邮件订阅';

-- ----------------------------
-- Records of ty_mail
-- ----------------------------

-- ----------------------------
-- Table structure for ty_mail_list
-- ----------------------------
DROP TABLE IF EXISTS `ty_mail_list`;
CREATE TABLE `ty_mail_list` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `typeids` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订阅列表';

-- ----------------------------
-- Records of ty_mail_list
-- ----------------------------

-- ----------------------------
-- Table structure for ty_mail_log
-- ----------------------------
DROP TABLE IF EXISTS `ty_mail_log`;
CREATE TABLE `ty_mail_log` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='邮件记录';

-- ----------------------------
-- Records of ty_mail_log
-- ----------------------------
INSERT INTO `ty_mail_log` VALUES ('1', '13084901@qq.com', '天医工程网用户邮件验证码', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n<strong>尊敬的会员</strong>：<br/>\r\n您在天医工程网请求的邮件验证码为 <strong style=\"color:#FF1100;\">A5X9hpOb</strong> (有效期30分钟)<br/>请使用此验证码继续操作，切勿透露给他人。\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '1491808410', '', '0', '2', '');
INSERT INTO `ty_mail_log` VALUES ('2', '13084901@qq.com', '天医工程网邮件发送测试', '<b>恭喜！您的站点[天医工程网]邮件发送设置成功！</b><br/>------------------------------------<br><a href=\"http://www.destoon.com/\" target=\"_blank\">Send By DESTOON B2B Mail Tester</a>', '1491808472', '', '0', '2', '');
INSERT INTO `ty_mail_log` VALUES ('3', '13084901@qq.com', '天医工程网邮件发送测试', '<b>恭喜！您的站点[天医工程网]邮件发送设置成功！</b><br/>------------------------------------<br><a href=\"http://www.destoon.com/\" target=\"_blank\">Send By DESTOON B2B Mail Tester</a>', '1491808503', '', '0', '2', '');
INSERT INTO `ty_mail_log` VALUES ('4', '13084901@qq.com', '天医工程网邮件发送测试', '<b>恭喜！您的站点[天医工程网]邮件发送设置成功！</b><br/>------------------------------------<br><a href=\"http://www.destoon.com/\" target=\"_blank\">Send By DESTOON B2B Mail Tester</a>', '1491808565', '', '0', '2', '');
INSERT INTO `ty_mail_log` VALUES ('5', '13084901@qq.com', '天医工程网邮件发送测试', '<b>恭喜！您的站点[天医工程网]邮件发送设置成功！</b><br/>------------------------------------<br><a href=\"http://www.destoon.com/\" target=\"_blank\">Send By DESTOON B2B Mail Tester</a>', '1491808664', '', '0', '3', '');
INSERT INTO `ty_mail_log` VALUES ('6', '13084901@qq.com', '天医工程网邮件发送测试', '<b>恭喜！您的站点[天医工程网]邮件发送设置成功！</b><br/>------------------------------------<br><a href=\"http://www.destoon.com/\" target=\"_blank\">Send By DESTOON B2B Mail Tester</a>', '1491808688', '', '0', '3', '');
INSERT INTO `ty_mail_log` VALUES ('7', '13084901@qq.com', '天医工程网邮件发送测试', '<b>恭喜！您的站点[天医工程网]邮件发送设置成功！</b><br/>------------------------------------<br><a href=\"http://www.destoon.com/\" target=\"_blank\">Send By DESTOON B2B Mail Tester</a>', '1491808702', '', '0', '3', '');
INSERT INTO `ty_mail_log` VALUES ('8', '13084901@qq.com', '天医工程网邮件发送测试', '<b>恭喜！您的站点[天医工程网]邮件发送设置成功！</b><br/>------------------------------------<br><a href=\"http://www.destoon.com/\" target=\"_blank\">Send By DESTOON B2B Mail Tester</a>', '1491808744', '', '0', '3', '');
INSERT INTO `ty_mail_log` VALUES ('9', '13084901@qq.com', '天医工程网用户邮件验证码', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n<strong>尊敬的会员</strong>：<br/>\r\n您在天医工程网请求的邮件验证码为 <strong style=\"color:#FF1100;\">wRTC09Ml</strong> (有效期30分钟)<br/>请使用此验证码继续操作，切勿透露给他人。\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '1491808778', '', '0', '3', '');

-- ----------------------------
-- Table structure for ty_mall
-- ----------------------------
DROP TABLE IF EXISTS `ty_mall`;
CREATE TABLE `ty_mall` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `mycatid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `brand` varchar(100) NOT NULL DEFAULT '',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `step` mediumtext NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `unit` varchar(20) NOT NULL,
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `orders` int(10) unsigned NOT NULL DEFAULT '0',
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `relate_name` varchar(100) NOT NULL,
  `relate_id` varchar(255) NOT NULL,
  `relate_title` varchar(100) NOT NULL,
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(255) NOT NULL,
  `v2` varchar(255) NOT NULL,
  `v3` varchar(255) NOT NULL,
  `express_1` int(10) unsigned NOT NULL DEFAULT '0',
  `express_name_1` varchar(100) NOT NULL,
  `fee_start_1` decimal(10,2) unsigned NOT NULL,
  `fee_step_1` decimal(10,2) unsigned NOT NULL,
  `express_2` int(10) unsigned NOT NULL DEFAULT '0',
  `express_name_2` varchar(100) NOT NULL,
  `fee_start_2` decimal(10,2) unsigned NOT NULL,
  `fee_step_2` decimal(10,2) unsigned NOT NULL,
  `express_3` int(10) unsigned NOT NULL DEFAULT '0',
  `express_name_3` varchar(100) NOT NULL,
  `fee_start_3` decimal(10,2) unsigned NOT NULL,
  `fee_step_3` decimal(10,2) unsigned NOT NULL,
  `cod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `thumb3` varchar(255) NOT NULL DEFAULT '' COMMENT '图片4',
  `mfrs` varchar(255) NOT NULL DEFAULT '' COMMENT '产地',
  `mallid` varchar(155) NOT NULL,
  `type1` varchar(100) NOT NULL,
  `type2` varchar(100) NOT NULL,
  `type3` varchar(100) NOT NULL,
  `type4` varchar(100) NOT NULL,
  `type5` varchar(100) NOT NULL,
  `value1` varchar(255) NOT NULL,
  `value2` varchar(255) NOT NULL,
  `value3` varchar(255) NOT NULL,
  `value4` varchar(255) NOT NULL,
  `value5` varchar(255) NOT NULL,
  `marketmoney` float NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='商城';

-- ----------------------------
-- Records of ty_mall
-- ----------------------------
INSERT INTO `ty_mall` VALUES ('1', '12', '0', '1', '1', '1', '安普AMP 超五类非屏蔽电缆 6-219586-4 305米每箱', '', '0', '', '', '480.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"480.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '1000', '件', '', '安普AMP 超五类非屏蔽电缆 6-219586-4 305米每箱,装修主材,彩钢板', '', '6', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201705/13/144149261.png.thumb.png', 'http://www.tctianyi.com/file/upload/201701/19/152807241.png.thumb.png', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1494657712', '2017-05-13', '1484810833', '2017-01-19', '127.0.0.1', '', '3', 'show.php?itemid=1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('2', '12', '0', '1', '1', '1', '装修主材--彩钢板--测试2', '', '0', '', '', '560.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"560.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '1000', '件', '', '装修主材--彩钢板--测试2,装修主材,彩钢板', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/19/154553961.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1494657409', '2017-05-13', '1484811889', '2017-01-19', '127.0.0.1', '', '3', 'show.php?itemid=2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('3', '13', '0', '1', '1', '0', '装修主材--铝扣板--测试1', '', '0', '', '', '400.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"400.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '1000', '件', '', '装修主材--铝扣板--测试1,装修主材,铝扣板', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/19/154631131.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484812013', '2017-01-19', '1484811971', '2017-01-19', '127.0.0.1', '', '3', 'show.php?itemid=3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('4', '13', '0', '1', '1', '1', '装修主材--铝扣板--测试2', '', '0', '', '', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '10000', '件', '', '装修主材--铝扣板--测试2,装修主材,铝扣板', '', '5', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/19/154708591.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1494657416', '2017-05-13', '1484812013', '2017-01-19', '127.0.0.1', '', '3', 'show.php?itemid=4', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('5', '14', '0', '1', '1', '0', '装修主材--瓷砖地板--测试1', '', '0', '', '', '50.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"50.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '10000', '件', '', '装修主材--瓷砖地板--测试1,装修主材,瓷砖地板', '', '22', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/19/155200531.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484812328', '2017-01-19', '1484812224', '2017-01-19', '127.0.0.1', '', '3', 'show.php?itemid=5', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('6', '14', '0', '1', '1', '0', '装修主材--瓷砖地板--测试2', '', '0', '', '', '45.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"45.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '100000', '件', '', '装修主材--瓷砖地板--测试2,装修主材,瓷砖地板', '', '3', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/19/155225661.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484812354', '2017-01-19', '1484812328', '2017-01-19', '127.0.0.1', '', '3', 'show.php?itemid=6', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('7', '16', '0', '1', '1', '0', '通风空调--空调主机--测试1', '', '0', '', '', '3800.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3800.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200', '件', '', '通风空调--空调主机--测试1,通风空调,空调主机', '', '3', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/19/164930471.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484815778', '2017-01-19', '1484815583', '2017-01-19', '127.0.0.1', '', '3', 'show.php?itemid=7', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('8', '16', '0', '1', '1', '0', '通风空调--空调主机--测试2', '', '0', '', '', '4000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"4000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200', '件', '', '通风空调--空调主机--测试2,通风空调,空调主机', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/19/165000481.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484815809', '2017-01-19', '1484815778', '2017-01-19', '127.0.0.1', '', '3', 'show.php?itemid=8', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('9', '17', '0', '1', '1', '0', '通风空调--空调末端--测试1', '', '0', '', '', '10000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"10000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '100', '件', '', '通风空调--空调末端--测试1,通风空调,空调末端', '', '3', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/110702451.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484881636', '2017-01-20', '1484881586', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=9', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('10', '18', '0', '1', '1', '0', '通风空调--商用空调--测试1', '', '0', '', '', '12000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"12000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '1000', '件', '', '通风空调--商用空调--测试1,通风空调,商用空调', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/110742761.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484881670', '2017-01-20', '1484881636', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=10', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('11', '19', '0', '1', '1', '0', '通风空调--风机--测试1', '', '0', '', '', '50000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"50000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200', '件', '', '通风空调--风机--测试1,通风空调,风机', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/110819481.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484881711', '2017-01-20', '1484881670', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=11', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('12', '17', '0', '1', '1', '0', '通风空调--空调末端--测试2', '', '0', '', '', '60000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"60000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '2000', '件', '', '通风空调--空调末端--测试2,通风空调,空调末端', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/110857771.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484881775', '2017-01-20', '1484881727', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=12', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('13', '20', '0', '1', '1', '0', '电工电气/安防---电缆--测试1', '', '0', '', '', '100.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"100.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '3000', '件', '', '电工电气/安防---电缆--测试1,电工电气/安防,电缆', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/111146231.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201701/20/111158581.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484881931', '2017-01-20', '1484881844', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=13', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('14', '20', '0', '1', '1', '0', '电工电气/安防---电缆--测试2', '', '0', '', '', '3000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '3000', '件', '', '电工电气/安防---电缆--测试2,电工电气/安防,电缆', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/111302171.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484881997', '2017-01-20', '1484881931', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=14', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('15', '21', '0', '1', '1', '0', '电工电气/安防---电线--测试1', '', '0', '', '', '300.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"300.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '4000', '件', '', '电工电气/安防---电线--测试1,电工电气/安防,电线', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/111528731.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201701/20/111534741.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484882144', '2017-01-20', '1484881997', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=15', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('16', '22', '0', '1', '1', '0', '电工电气/安防---开关--测试1', '', '0', '', '', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '4000', '件', '', '电工电气/安防---开关--测试1,电工电气/安防,开关', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/111715341.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484882251', '2017-01-20', '1484882144', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=16', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('17', '22', '0', '1', '1', '0', '电工电气/安防---开关--测试2', '', '0', '', '', '100.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"100.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '5000', '件', '', '电工电气/安防---开关--测试2,电工电气/安防,开关', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/111812951.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484882305', '2017-01-20', '1484882251', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=17', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('18', '23', '0', '1', '1', '0', '电工电气/安防---灯具--测试1', '', '0', '', '', '5000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '100', '件', '', '电工电气/安防---灯具--测试1,电工电气/安防,灯具', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/112106911.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484882474', '2017-01-20', '1484882305', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=18', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('19', '24', '0', '1', '1', '0', '管材管件--镀锌钢管--测试商品1', '', '0', '', '', '4000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"4000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200000', '件', '', '管材管件--镀锌钢管--测试商品1,管材管件,镀锌钢管', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/112458441.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201701/20/112513561.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484882736', '2017-01-20', '1484882474', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=19', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('20', '24', '0', '1', '1', '0', '管材管件--镀锌钢管--测试商品2', '', '0', '', '', '30000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"30000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200000', '件', '', '管材管件--镀锌钢管--测试商品2,管材管件,镀锌钢管', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/112641371.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484882809', '2017-01-20', '1484882736', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('21', '25', '0', '1', '1', '0', '管材管件--不锈钢钢管--测试商品2', '', '0', '', '', '4000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"4000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '300000', '件', '', '管材管件--不锈钢钢管--测试商品2,管材管件,不锈钢钢管', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/112837121.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484882921', '2017-01-20', '1484882809', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=21', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('22', '25', '0', '1', '1', '0', '管材管件--不锈钢钢管--测试商品1', '', '0', '', '', '2000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"2000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '300000', '件', '', '管材管件--不锈钢钢管--测试商品1,管材管件,不锈钢钢管', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/112858981.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484882948', '2017-01-20', '1484882921', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=22', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('23', '26', '0', '1', '1', '0', '管材管件--PPR管--测试商品1', '', '0', '', '', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '20000', '件', '', '管材管件--PPR管--测试商品1,管材管件,PPR钢管', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/113150101.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201701/20/113214431.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484883147', '2017-01-20', '1484882949', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=23', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('24', '27', '0', '1', '1', '0', '管材管件--PVC管--测试商品1', '', '0', '', '', '400.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"400.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '3000', '件', '', '管材管件--PVC管--测试商品1,管材管件,PVC管', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/113252661.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201701/20/113255801.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484883188', '2017-01-20', '1484883147', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=24', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('25', '28', '0', '1', '1', '0', '实验室家具----中央台---测试商品1', '', '0', '', '', '6000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200', '件', '', '实验室家具----中央台---测试商品1,实验室家具,中央台', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/113518971.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484883325', '2017-01-20', '1484883188', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=25', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('26', '28', '0', '1', '1', '0', '实验室家具----中央台---测试商品2', '', '0', '', '', '5000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200', '件', '', '实验室家具----中央台---测试商品2,实验室家具,中央台', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/113548921.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484883357', '2017-01-20', '1484883325', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=26', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('27', '29', '0', '1', '1', '0', '实验室家具----边台---测试商品1', '', '0', '', '', '5000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '100', '件', '', '实验室家具----边台---测试商品1,实验室家具,边台', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/113756271.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484883489', '2017-01-20', '1484883357', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=27', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('28', '30', '0', '1', '1', '0', '实验室家具----取材台---测试商品1', '', '0', '', '', '5000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '300', '件', '', '实验室家具----取材台---测试商品1,实验室家具,取材台', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/113954471.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484883608', '2017-01-20', '1484883489', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=28', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('29', '31', '0', '1', '1', '0', '实验室家具----办公桌---测试商品1', '', '0', '', '', '3000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '4000', '件', '', '实验室家具----办公桌---测试商品1,实验室家具,办公家具', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/114234481.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484883765', '2017-01-20', '1484883608', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=29', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('30', '31', '0', '1', '1', '0', '实验室家具----家具---测试商品1', '', '0', '', '', '60000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"60000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '4000', '件', '', '实验室家具----家具---测试商品1,实验室家具,办公家具', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/114306371.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484883800', '2017-01-20', '1484883765', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=30', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('31', '32', '0', '1', '1', '0', '仪器设备-----PCR仪---测试商品1', '', '0', '', '', '5000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '300', '件', '', '仪器设备-----PCR仪---测试商品1,仪器设备,PCR仪', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/115211881.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201701/20/115215651.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484884344', '2017-01-20', '1484883800', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=31', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('32', '33', '0', '1', '1', '0', '仪器设备-----免疫仪---测试商品1', '', '0', '', '', '4000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"4000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '400', '件', '', '仪器设备-----免疫仪---测试商品1,仪器设备,免疫仪', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/115346881.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201701/20/115351731.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484884440', '2017-01-20', '1484884344', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=32', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('33', '33', '0', '1', '1', '0', '仪器设备-----免疫仪---测试商品2', '', '0', '', '', '6000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '300', '件', '', '仪器设备-----免疫仪---测试商品2,仪器设备,免疫仪', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/115447411.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484884499', '2017-01-20', '1484884440', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=33', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('34', '34', '0', '1', '1', '0', '仪器设备-----通风柜---测试商品1', '', '0', '', '', '50000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"50000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '44', '件', '', '仪器设备-----通风柜---测试商品1,仪器设备,通风柜', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/115557351.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484884569', '2017-01-20', '1484884499', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=34', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('35', '34', '0', '1', '1', '0', '仪器设备-----通风柜---测试商品2', '', '0', '', '', '5000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '600', '件', '', '仪器设备-----通风柜---测试商品2,仪器设备,通风柜', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/115645561.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484884615', '2017-01-20', '1484884569', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=35', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('36', '35', '0', '1', '1', '0', '仪器设备-----生物安全柜---测试商品1', '', '0', '', '', '6000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '500', '件', '', '仪器设备-----生物安全柜---测试商品1,仪器设备,生物安全柜', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/115749121.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484884680', '2017-01-20', '1484884615', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=36', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('37', '36', '0', '1', '1', '0', '采暖/热泵------电采暖----测试商品1', '', '0', '', '', '7000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"7000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '300', '件', '', '采暖/热泵------电采暖----测试商品1,采暖/热泵,电采暖', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/140549401.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484892357', '2017-01-20', '1484884680', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=37', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('38', '36', '0', '1', '1', '0', '采暖/热泵------电采暖----测试商品2', '', '0', '', '', '15000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"15000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200', '件', '', '采暖/热泵------电采暖----测试商品2,采暖/热泵,电采暖', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/140745281.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484892505', '2017-01-20', '1484892357', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=38', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('39', '37', '0', '1', '1', '0', '采暖/热泵----水源热泵机组---测试商品1', '', '0', '', '', '20000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"20000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '10', '件', '', '采暖/热泵----水源热泵机组---测试商品1,采暖/热泵,水源热泵机组', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/141009551.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484892617', '2017-01-20', '1484892571', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=39', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('40', '37', '0', '1', '1', '0', '采暖/热泵----水源热泵机组---测试商品2', '', '0', '', '', '18000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"18000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '200', '件', '', '采暖/热泵----水源热泵机组---测试商品2,采暖/热泵,水源热泵机组', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/141039231.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484892659', '2017-01-20', '1484892617', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=40', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('41', '38', '0', '1', '1', '0', '采暖/热泵-----商用热泵----测试商品1', '', '0', '', '', '6000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '100', '件', '', '采暖/热泵-----商用热泵----测试商品1,采暖/热泵,商用热泵', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/141258601.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484892798', '2017-01-20', '1484892659', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=41', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('42', '39', '0', '1', '1', '0', '采暖/热泵----伸缩器------测试商品1', '', '0', '', '', '5000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '400', '件', '', '采暖/热泵----伸缩器------测试商品1,采暖/热泵,伸缩器', '', '0', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/141442951.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484892900', '2017-01-20', '1484892798', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=42', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('43', '40', '0', '1', '1', '0', '辅材/工具 ----- 切割机----测试商品1', '', '0', '', '', '60000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"60000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '300', '件', '', '辅材/工具 ----- 切割机----测试商品1,辅材/工具,切割机', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/141739721.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484893067', '2017-01-20', '1484892900', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=43', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('44', '41', '0', '1', '1', '0', '辅材/工具 ----- 手电钻----测试商品1', '', '0', '', '', '390.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"390.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '100', '件', '', '辅材/工具 ----- 手电钻----测试商品1,辅材/工具,手电钻', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/141931671.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201701/20/141957911.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484893206', '2017-01-20', '1484893067', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=44', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('45', '41', '0', '1', '1', '0', '辅材/工具 ----- 手电钻----测试商品2', '', '0', '', '', '500.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"500.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '3000', '件', '', '辅材/工具 ----- 手电钻----测试商品2,辅材/工具,手电钻', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/142026551.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484893233', '2017-01-20', '1484893206', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=45', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('46', '42', '0', '1', '1', '0', '辅材/工具------激光测距仪-----测试商品1', '', '0', '', '', '6000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '6000', '件', '', '辅材/工具------激光测距仪-----测试商品1,辅材/工具,激光测距仪', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/142158581.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484893325', '2017-01-20', '1484893233', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=46', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('47', '42', '0', '1', '1', '0', '辅材/工具------激光测距仪-----测试商品2', '', '0', '', '', '5800.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5800.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '400', '件', '', '辅材/工具------激光测距仪-----测试商品2,辅材/工具,激光测距仪', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/142235211.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484893363', '2017-01-20', '1484893325', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=47', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('48', '43', '0', '1', '1', '0', '辅材/工具----万用表-----测试商品1', '', '0', '', '', '600.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"600.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '600', '件', '', '辅材/工具----万用表-----测试商品1,辅材/工具,万用表', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201701/20/142337471.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'tianyi', '1', '天医', '0', '0', '嘉客', '', '', '', '', '', '', '', '', 'tianyi', '1484893425', '2017-01-20', '1484893363', '2017-01-20', '127.0.0.1', '', '3', 'show.php?itemid=48', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('49', '15', '0', '63', '0', '1', '阿姆斯壮地板PVC片材地板', '', '0', '', '阿姆斯壮', '50.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"50.00\";s:2:\"a2\";s:3:\"100\";s:2:\"p2\";s:5:\"48.00\";s:2:\"a3\";s:4:\"1000\";s:2:\"p3\";s:5:\"46.00\";s:2:\"is\";s:1:\"Y\";}', '100000', '件', '', '阿姆斯壮地板PVC片材地板,阿姆斯壮,装修主材,PVC地板', '', '6', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/06/1411057419.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/06/1412048819.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'hulunbeier', '6', '呼伦贝尔市晨光灯具厂', '0', '0', '呼', '13800138000', '', '内蒙古呼伦贝尔', '', '', '', '', '', 'tianyi', '1491460572', '2017-04-06', '1491459160', '2017-04-06', '127.0.0.1', '', '3', 'show.php?itemid=49', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('50', '14', '0', '63', '0', '0', '耐磨通体砖外墙砖100*200防冻砖', '', '0', '', '', '36.00', 'a:7:{s:2:\"a1\";s:3:\"100\";s:2:\"p1\";s:5:\"36.00\";s:2:\"a2\";s:4:\"1000\";s:2:\"p2\";s:5:\"35.00\";s:2:\"a3\";s:5:\"10000\";s:2:\"p3\";s:5:\"34.00\";s:2:\"is\";s:1:\"Y\";}', '10000000', '件', '', '耐磨通体砖外墙砖100*200防冻砖,装修主材,瓷砖地板', '', '3', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/06/1416324219.png.thumb.png', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'hulunbeier', '6', '呼伦贝尔市晨光灯具厂', '0', '0', '呼', '13800138000', '', '内蒙古呼伦贝尔', '', '', '', '', '', 'tianyi', '1491460572', '2017-04-06', '1491459431', '2017-04-06', '127.0.0.1', '', '3', 'show.php?itemid=50', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('51', '13', '0', '63', '0', '1', '美乐镁铝扣板', '', '0', '', '美乐镁', '22.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"22.00\";s:2:\"a2\";s:3:\"100\";s:2:\"p2\";s:5:\"21.00\";s:2:\"a3\";s:4:\"1000\";s:2:\"p3\";s:5:\"20.00\";s:2:\"is\";s:1:\"Y\";}', '100000', '件', '', '美乐镁铝扣板,美乐镁,装修主材,铝扣板', '', '12', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/06/1424249519.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/06/1424289919.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/06/1424318719.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'hulunbeier', '6', '呼伦贝尔市晨光灯具厂', '0', '0', '呼', '13800138000', '', '内蒙古呼伦贝尔', '', '', '', '', '', 'tianyi', '1491460565', '2017-04-06', '1491459900', '2017-04-06', '127.0.0.1', '', '3', 'show.php?itemid=51', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('52', '12', '0', '248', '0', '1', '联合彩钢板卷', '', '0', '', '', '3600.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3600.00\";s:2:\"a2\";s:3:\"100\";s:2:\"p2\";s:7:\"3500.00\";s:2:\"a3\";s:4:\"1000\";s:2:\"p3\";s:7:\"3400.00\";s:2:\"is\";s:1:\"Y\";}', '10000', '件', '', '联合彩钢板卷,装修主材,彩钢板', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/06/1704309518.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/06/1704356118.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'zhongshanxingdi', '6', '中山市星迪照明电器有限公司', '0', '0', '星', '13800138000', '', '广东中山市', '', '', '', '', '', 'tianyi', '1491470470', '2017-04-06', '1491469516', '2017-04-06', '127.0.0.1', '', '3', 'show.php?itemid=52', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('53', '13', '0', '248', '0', '1', '星迪铝扣板', '', '0', '', '', '100.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"100.00\";s:2:\"a2\";s:4:\"1000\";s:2:\"p2\";s:5:\"99.00\";s:2:\"a3\";s:5:\"10000\";s:2:\"p3\";s:5:\"98.00\";s:2:\"is\";s:1:\"Y\";}', '100000', '件', '', '星迪铝扣板,装修主材,铝扣板', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/06/1716558618.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/06/1716598118.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'zhongshanxingdi', '6', '中山市星迪照明电器有限公司', '0', '0', '星', '13800138000', '', '广东中山市', '', '', '', '', '', 'tianyi', '1491470470', '2017-04-06', '1491470236', '2017-04-06', '127.0.0.1', '', '3', 'show.php?itemid=53', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('54', '23', '0', '248', '0', '1', '星迪灯具1', '', '0', '', '', '80.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"80.00\";s:2:\"a2\";s:3:\"100\";s:2:\"p2\";s:5:\"78.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:4:\"0.00\";s:2:\"is\";s:1:\"Y\";}', '10000', '件', '', '星迪灯具1,电工电气/安防,灯具', '', '3', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/06/1720175718.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/06/1720215818.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'zhongshanxingdi', '6', '中山市星迪照明电器有限公司', '0', '0', '星', '13800138000', '', '广东中山市', '', '', '', '', '', 'tianyi', '1491470470', '2017-04-06', '1491470436', '2017-04-06', '127.0.0.1', '', '3', 'show.php?itemid=54', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('55', '15', '0', '248', '0', '1', '雅云PVC地板', '', '0', '', '雅云', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:3:\"100\";s:2:\"p2\";s:6:\"199.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:4:\"0.00\";s:2:\"is\";s:1:\"Y\";}', '100000', '件', '', '雅云PVC地板,雅云,装修主材,PVC地板', '', '23', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0926475917.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/07/0926553617.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'zhongshanyayun', '6', '中山市雅云灯饰有限公司', '0', '0', '雅', '13800138000', '', '广东省中山市', '', '', '', '', '', 'tianyi', '1491528623', '2017-04-07', '1491528437', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=55', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('56', '13', '0', '248', '0', '1', '雅云铝扣板', '', '0', '', '雅云', '3000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3000.00\";s:2:\"a2\";s:4:\"1000\";s:2:\"p2\";s:7:\"2900.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:4:\"0.00\";s:2:\"is\";s:1:\"Y\";}', '1000000', '件', '', '雅云铝扣板,雅云,装修主材,铝扣板', '', '6', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0928071817.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/07/0928134617.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'zhongshanyayun', '6', '中山市雅云灯饰有限公司', '0', '0', '雅', '13800138000', '', '广东省中山市', '', '', '', '', '', 'tianyi', '1491528623', '2017-04-07', '1491528513', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=56', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('57', '12', '0', '248', '0', '0', '雅云彩钢板', '', '0', '', '雅云', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:4:\"1000\";s:2:\"p2\";s:6:\"199.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:4:\"0.00\";s:2:\"is\";s:1:\"Y\";}', '20000', '件', '', '雅云彩钢板,雅云,装修主材,彩钢板', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0929169817.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/07/0929264517.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'zhongshanyayun', '6', '中山市雅云灯饰有限公司', '0', '0', '雅', '13800138000', '', '广东省中山市', '', '', '', '', '', 'tianyi', '1491528623', '2017-04-07', '1491528613', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=57', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('58', '12', '0', '44', '0', '1', '鑫大彩钢板', '', '0', '', '', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:3:\"300\";s:2:\"p2\";s:6:\"199.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:4:\"0.00\";s:2:\"is\";s:1:\"Y\";}', '10000', '件', '', '鑫大彩钢板,装修主材,彩钢板', '', '5', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0950486216.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/07/0950528716.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'hebeixinda', '6', '河北廊坊鑫大保温材料有限公司', '0', '0', '鑫', '13800138000', '', '河北廊坊市', '', '', '', '', '', 'tianyi', '1491530181', '2017-04-07', '1491529879', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=58', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('59', '14', '0', '44', '0', '1', '鑫大地板', '', '0', '', '', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:4:\"1000\";s:2:\"p2\";s:6:\"199.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:4:\"0.00\";s:2:\"is\";s:1:\"Y\";}', '1000000', '件', '', '鑫大地板,装修主材,瓷砖地板', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0952248616.png.thumb.png', 'http://www.tctianyi.com/file/upload/201704/07/0952415916.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'hebeixinda', '6', '河北廊坊鑫大保温材料有限公司', '0', '0', '鑫', '13800138000', '', '河北廊坊市', '', '', '', '', '', 'tianyi', '1491530181', '2017-04-07', '1491530006', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=59', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('60', '13', '0', '44', '0', '1', '鑫大铝扣板', '', '0', '', '', '100.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"100.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '100000', '件', '', '鑫大铝扣板,装修主材,铝扣板', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/0955493816.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'hebeixinda', '6', '河北廊坊鑫大保温材料有限公司', '0', '0', '鑫', '13800138000', '', '河北廊坊市', '', '', '', '', '', 'tianyi', '1491530181', '2017-04-07', '1491530163', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=60', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('61', '12', '0', '171', '0', '1', '结力彩钢板', '', '0', '', '', '100.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"100.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '10000', '件', '', '结力彩钢板,装修主材,彩钢板', '', '2', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/1000236815.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/07/1000286315.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'laizhoujieli', '6', '莱州结力工贸有限公司', '0', '0', '莱', '13800138000', '', '山东烟台市', '', '', '', '', '', 'tianyi', '1491530981', '2017-04-07', '1491530446', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=61', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('62', '14', '0', '171', '0', '0', '洁力地板', '', '0', '', '', '100.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"100.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '100000', '件', '', '洁力地板,装修主材,瓷砖地板', '', '6', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/1007489215.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/07/1007577615.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'laizhoujieli', '6', '莱州结力工贸有限公司', '0', '0', '莱', '13800138000', '', '山东烟台市', '', '', '', '', '', 'tianyi', '1491530981', '2017-04-07', '1491530881', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=62', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('63', '14', '0', '171', '0', '1', '洁力优质地板', '', '0', '', '洁力', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '20000', '件', '', '洁力优质地板,洁力,装修主材,瓷砖地板', '', '5', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/1009172015.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/07/1009224515.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'laizhoujieli', '6', '莱州结力工贸有限公司', '0', '0', '莱', '13800138000', '', '山东烟台市', '', '', '', '', '', 'tianyi', '1491530981', '2017-04-07', '1491530974', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=63', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('64', '13', '0', '4', '0', '1', '瑞泰铝扣板', '', '0', '', '', '2000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"2000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '10000', '件', '', '瑞泰铝扣板,装修主材,铝扣板', '', '5', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/1019087714.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '1', '1', '平请求', '0769 81667033', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '', '', '', '', '', 'shandongpingyi', '1494662375', '2017-05-13', '1491531566', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=64', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('65', '14', '0', '178', '0', '1', '瑞泰瓷砖地板', '', '0', '', '', '300.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"300.00\";s:2:\"a2\";s:4:\"1000\";s:2:\"p2\";s:6:\"299.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:4:\"0.00\";s:2:\"is\";s:1:\"Y\";}', '1000', '件', '', '瑞泰瓷砖地板,装修主材,瓷砖地板', '', '17', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/07/1019543114.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/07/1019585614.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '1', '1', '平请求', '0769 81667033', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '', '', '', '', '', 'tianyi', '1491531650', '2017-04-07', '1491531642', '2017-04-07', '127.0.0.1', '', '3', 'show.php?itemid=65', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('66', '15', '0', '178', '0', '1', '瑞泰pvc地板', '', '0', '', '', '3000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3000.00\";s:2:\"a2\";s:5:\"20000\";s:2:\"p2\";s:7:\"2900.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:4:\"0.00\";s:2:\"is\";s:1:\"Y\";}', '20000', '件', '', '瑞泰pvc地板,装修主材,PVC地板', '', '9', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201704/10/1521187314.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201704/10/1521249314.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '1', '1', '平请求', '0769 81667033', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '', '', '', '', '', 'shandongpingyi', '1491808891', '2017-04-10', '1491808891', '2017-04-10', '127.0.0.1', '', '3', 'show.php?itemid=66', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('67', '18', '0', '178', '0', '0', '不会动', '', '0', '', '', '200.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:2:\"10\";s:2:\"p2\";s:6:\"100.00\";s:2:\"a3\";s:2:\"20\";s:2:\"p3\";s:5:\"50.00\";s:2:\"is\";s:1:\"Y\";}', '50', '件', '', '不会动,通风空调,商用空调', '', '1', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201705/03/1127263514.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201705/03/1127295814.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201705/03/1127351714.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '1', '1', '平请求', '0769 81667033', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '', '', '', '', '', 'shandongpingyi', '1493782075', '2017-05-03', '1493782075', '2017-05-03', '127.0.0.1', '', '3', 'show.php?itemid=67', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('68', '15', '0', '4', '0', '0', '测试3', '', '0', '', '', '500.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"500.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '20', '件', '', '测试3,装修主材,PVC地板', '', '4', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201705/03/1128316514.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201705/03/1128346314.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201705/03/1128377814.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '1', '1', '平请求', '0769 81667033', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '', '', '', '', '', 'shandongpingyi', '1494661802', '2017-05-13', '1493782121', '2017-05-03', '127.0.0.1', '', '3', 'show.php?itemid=68', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('69', '18', '0', '4', '0', '1', '安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱', '', '0', '', 'AMP NETCONNECT', '22.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"22.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '22', '件', '', '安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱,AMP NETCONNECT,通风空调,商用空调', '', '501', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201705/08/1519599314.jpg.thumb.jpg', 'http://www.tctianyi.com/file/upload/201705/08/1520064114.gif.thumb.gif', 'http://www.tctianyi.com/file/upload/201705/08/1520123014.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '2', '快递22222', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '1', '1', '平请求', '0769 81667033', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '', '', '', '', '', 'shandongpingyi', '1494815942', '2017-05-15', '1493782256', '2017-05-03', '127.0.0.1', '', '3', 'show.php?itemid=69', '', '', '', '中国', '11262100598', '商品毛重', '类型', '线长', '布线工程', '特性', '1.6kg', '网线', '305米', '六类网线', '安普公司原装产品，质量稳定，性能优异。一箱为一个销售单位，线长：不低于300米。备注：超五类非屏蔽网线。', '0');
INSERT INTO `ty_mall` VALUES ('70', '14', '0', '178', '0', '0', '11111111', '', '0', '', '', '11.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"11.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '11', '件', '', '11111111,装修主材,瓷砖地板', '', '5', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201705/03/1148472114.jpg.thumb.jpg', '', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '1', '1', '平请求', '0769 81667033', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '', '', '', '', '', 'shandongpingyi', '1493783331', '2017-05-03', '1493783331', '2017-05-03', '127.0.0.1', '', '0', 'show.php?itemid=70', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `ty_mall` VALUES ('71', '22', '0', '4', '0', '0', 'dfsdfsdfsdfds420', '', '0', '', '', '1000.00', 'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"1000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}', '23', '件', '', 'dfsdfsdfsdfds420,电工电气/安防,开关', '', '3', '0', '0', '0', 'http://www.tctianyi.com/file/upload/201705/05/1123441314.png.thumb.png', 'http://www.tctianyi.com/file/upload/201705/05/1123499514.gif.thumb.gif', '', '', '', '', '', '', '', '', '', '', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', '', '0.00', '0.00', '0', 'shandongpingyi', '7', '山东省平邑县瑞泰石业有限公司', '1', '1', '平请求', '0769 81667033', '', '中国 广东 东莞市 长安镇乌沙江贝新康路5号', '', '', '', '', '', 'shandongpingyi', '1494814875', '2017-05-15', '1493952843', '2017-05-05', '127.0.0.1', '', '3', 'show.php?itemid=71', '', '', '', '加拿大', '', '', '', '', '', '', '', '', '', '', '', '13');

-- ----------------------------
-- Table structure for ty_mall_cart
-- ----------------------------
DROP TABLE IF EXISTS `ty_mall_cart`;
CREATE TABLE `ty_mall_cart` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='购物车';

-- ----------------------------
-- Records of ty_mall_cart
-- ----------------------------
INSERT INTO `ty_mall_cart` VALUES ('14', 'a:1:{s:8:\"51-0-0-0\";i:1;}', '1494827181');
INSERT INTO `ty_mall_cart` VALUES ('48', 'a:2:{s:8:\"69-0-0-0\";i:22;s:8:\"62-0-0-0\";i:1;}', '1494488737');
INSERT INTO `ty_mall_cart` VALUES ('1', 'a:5:{s:8:\"59-0-0-0\";i:1;s:8:\"56-0-0-0\";i:1;s:8:\"66-0-0-0\";i:1;s:8:\"60-0-0-0\";i:1;s:8:\"57-0-0-0\";i:1;}', '1494579188');

-- ----------------------------
-- Table structure for ty_mall_comment
-- ----------------------------
DROP TABLE IF EXISTS `ty_mall_comment`;
CREATE TABLE `ty_mall_comment` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `mallid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `buyer` varchar(30) NOT NULL DEFAULT '',
  `seller` varchar(30) NOT NULL DEFAULT '',
  `buyer_star` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `buyer_comment` text NOT NULL,
  `buyer_ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `buyer_reply` text NOT NULL,
  `buyer_rtime` int(10) unsigned NOT NULL DEFAULT '0',
  `seller_star` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `seller_comment` text NOT NULL,
  `seller_ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `seller_reply` text NOT NULL,
  `seller_rtime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `itemid` (`itemid`),
  KEY `buyer` (`buyer`),
  KEY `seller` (`seller`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单评论';

-- ----------------------------
-- Records of ty_mall_comment
-- ----------------------------
INSERT INTO `ty_mall_comment` VALUES ('1', '64', 'tianyi', 'shandongpingyi', '0', '', '0', '', '0', '0', '', '0', '', '0');
INSERT INTO `ty_mall_comment` VALUES ('2', '64', 'tianyi', 'shandongpingyi', '0', '', '0', '', '0', '0', '', '0', '', '0');
INSERT INTO `ty_mall_comment` VALUES ('3', '64', 'tianyi', 'shandongpingyi', '0', '', '0', '', '0', '0', '', '0', '', '0');
INSERT INTO `ty_mall_comment` VALUES ('4', '64', 'tianyi', 'shandongpingyi', '0', '', '0', '', '0', '0', '', '0', '', '0');
INSERT INTO `ty_mall_comment` VALUES ('5', '66', 'tianyi', 'shandongpingyi', '0', '', '0', '', '0', '0', '', '0', '', '0');
INSERT INTO `ty_mall_comment` VALUES ('6', '58', 'tianyi', 'hebeixinda', '0', '', '0', '', '0', '0', '', '0', '', '0');
INSERT INTO `ty_mall_comment` VALUES ('7', '69', 'tianyi', 'shandongpingyi', '0', '', '0', '', '0', '0', '', '0', '', '0');
INSERT INTO `ty_mall_comment` VALUES ('8', '63', 'tianyi', 'laizhoujieli', '0', '', '0', '', '0', '0', '', '0', '', '0');
INSERT INTO `ty_mall_comment` VALUES ('9', '55', 'tianyi', 'zhongshanyayun', '0', '', '0', '', '0', '0', '', '0', '', '0');

-- ----------------------------
-- Table structure for ty_mall_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_mall_data`;
CREATE TABLE `ty_mall_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商城内容';

-- ----------------------------
-- Records of ty_mall_data
-- ----------------------------
INSERT INTO `ty_mall_data` VALUES ('1', '&nbsp;安普AMP 超五类非屏蔽电缆\r\n<div>6-219586-4 305米每箱安普AMP 超五类非屏蔽电缆</div>\r\n<div>6-219586-4 305米每箱安普AMP 超五类非屏蔽电缆</div>\r\n<div>6-219586-4 305米每箱</div>');
INSERT INTO `ty_mall_data` VALUES ('2', '&nbsp;装修主材--彩钢板--测试2装修主材--彩钢板--测试2装修主材--彩钢板--测试2装修主材--彩钢板--测试2装修主材--彩钢板--测试2');
INSERT INTO `ty_mall_data` VALUES ('3', '&nbsp;装修主材--铝扣板--测试1装修主材--铝扣板--测试1装修主材--铝扣板--测试1');
INSERT INTO `ty_mall_data` VALUES ('4', '&nbsp;装修主材--铝扣板--测试2装修主材--铝扣板--测试2装修主材--铝扣板--测试2装修主材--铝扣板--测试2');
INSERT INTO `ty_mall_data` VALUES ('5', '&nbsp;装修主材--瓷砖地板--测试1装修主材--瓷砖地板--测试1装修主材--瓷砖地板--测试1装修主材--瓷砖地板--测试1');
INSERT INTO `ty_mall_data` VALUES ('6', '&nbsp;装修主材--瓷砖地板--测试2装修主材--瓷砖地板--测试2装修主材--瓷砖地板--测试2装修主材--瓷砖地板--测试2装修主材--瓷砖地板--测试2');
INSERT INTO `ty_mall_data` VALUES ('7', '&nbsp;通风空调--空调主机--测试1通风空调--空调主机--测试1通风空调--空调主机--测试1');
INSERT INTO `ty_mall_data` VALUES ('8', '&nbsp;通风空调--空调主机--测试2通风空调--空调主机--测试2通风空调--空调主机--测试2');
INSERT INTO `ty_mall_data` VALUES ('9', '&nbsp;通风空调--空调末端--测试1通风空调--空调末端--测试1通风空调--空调末端--测试1通风空调--空调末端--测试1通风空调--空调末端--测试1通风空调--空调末端--测试1');
INSERT INTO `ty_mall_data` VALUES ('10', '&nbsp;通风空调--商用空调--测试1通风空调--商用空调--测试1通风空调--商用空调--测试1通风空调--商用空调--测试1通风空调--商用空调--测试1');
INSERT INTO `ty_mall_data` VALUES ('11', '&nbsp;通风空调--风机--测试1通风空调--风机--测试1通风空调--风机--测试1通风空调--风机--测试1通风空调--风机--测试1');
INSERT INTO `ty_mall_data` VALUES ('12', '&nbsp;通风空调--空调末端--测试2通风空调--空调末端--测试2通风空调--空调末端--测试2通风空调--空调末端--测试2');
INSERT INTO `ty_mall_data` VALUES ('13', '&nbsp;电工电气/安防---电缆--测试1电工电气/安防---电缆--测试1电工电气/安防---电缆--测试1电工电气/安防---电缆--测试1');
INSERT INTO `ty_mall_data` VALUES ('14', '&nbsp;电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2');
INSERT INTO `ty_mall_data` VALUES ('15', '&nbsp;电工电气/安防---电线--测试1电工电气/安防---电线--测试1电工电气/安防---电线--测试1电工电气/安防---电线--测试1');
INSERT INTO `ty_mall_data` VALUES ('16', '&nbsp;电工电气/安防---开关--测试1电工电气/安防---开关--测试1电工电气/安防---开关--测试1电工电气/安防---开关--测试1电工电气/安防---开关--测试1');
INSERT INTO `ty_mall_data` VALUES ('17', '&nbsp;电工电气/安防---开关--测试2&nbsp;电工电气/安防---开关--测试2&nbsp;电工电气/安防---开关--测试2&nbsp;电工电气/安防---开关--测试2&nbsp;电工电气/安防---开关--测试2');
INSERT INTO `ty_mall_data` VALUES ('18', '&nbsp;&nbsp;电工电气/安防---灯具--测试1&nbsp;电工电气/安防---灯具--测试1&nbsp;电工电气/安防---灯具--测试1&nbsp;电工电气/安防---灯具--测试1&nbsp;电工电气/安防---灯具--测试1');
INSERT INTO `ty_mall_data` VALUES ('19', '&nbsp;管材管件--镀锌钢管--测试1管材管件--镀锌钢管--测试1管材管件--镀锌钢管--测试1管材管件--镀锌钢管--测试1管材管件--镀锌钢管--测试1');
INSERT INTO `ty_mall_data` VALUES ('20', '&nbsp;管材管件--镀锌钢管--测试商品2管材管件--镀锌钢管--测试商品2管材管件--镀锌钢管--测试商品2管材管件--镀锌钢管--测试商品2管材管件--镀锌钢管--测试商品2');
INSERT INTO `ty_mall_data` VALUES ('21', '&nbsp;管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2');
INSERT INTO `ty_mall_data` VALUES ('22', '&nbsp;管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2');
INSERT INTO `ty_mall_data` VALUES ('23', '&nbsp;管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1');
INSERT INTO `ty_mall_data` VALUES ('24', '&nbsp;管材管件--PVC管--测试商品1管材管件--PVC管--测试商品1管材管件--PVC管--测试商品1管材管件--PVC管--测试商品1管材管件--PVC管--测试商品1');
INSERT INTO `ty_mall_data` VALUES ('25', '&nbsp;实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('26', '&nbsp;实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2');
INSERT INTO `ty_mall_data` VALUES ('27', '&nbsp;实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('28', '&nbsp;实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('29', '&nbsp;实验室家具----办公桌---测试商品1实验室家具----办公桌---测试商品1实验室家具----办公桌---测试商品1实验室家具----办公桌---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('30', '&nbsp;实验室家具----家具---测试商品1实验室家具----家具---测试商品1实验室家具----家具---测试商品1实验室家具----家具---测试商品1实验室家具----家具---测试商品1实验室家具----家具---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('31', '&nbsp;仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('32', '&nbsp;仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('33', '&nbsp;仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2');
INSERT INTO `ty_mall_data` VALUES ('34', '&nbsp;仪器设备-----通风柜---测试商品1仪器设备-----通风柜---测试商品1仪器设备-----通风柜---测试商品1仪器设备-----通风柜---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('35', '&nbsp;仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2');
INSERT INTO `ty_mall_data` VALUES ('36', '&nbsp;仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('37', '&nbsp;采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1');
INSERT INTO `ty_mall_data` VALUES ('38', '&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2');
INSERT INTO `ty_mall_data` VALUES ('39', '&nbsp;采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1');
INSERT INTO `ty_mall_data` VALUES ('40', '&nbsp;采暖/热泵----水源热泵机组---测试商品2采暖/热泵----水源热泵机组---测试商品2采暖/热泵----水源热泵机组---测试商品2采暖/热泵----水源热泵机组---测试商品2采暖/热泵----水源热泵机组---测试商品2');
INSERT INTO `ty_mall_data` VALUES ('41', '&nbsp;采暖/热泵-----商用热泵----测试商品1采暖/热泵-----商用热泵----测试商品1采暖/热泵-----商用热泵----测试商品1采暖/热泵-----商用热泵----测试商品1');
INSERT INTO `ty_mall_data` VALUES ('42', '&nbsp;采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1');
INSERT INTO `ty_mall_data` VALUES ('43', '&nbsp;辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1');
INSERT INTO `ty_mall_data` VALUES ('44', '&nbsp;辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1');
INSERT INTO `ty_mall_data` VALUES ('45', '&nbsp;辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1');
INSERT INTO `ty_mall_data` VALUES ('46', '&nbsp;辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1');
INSERT INTO `ty_mall_data` VALUES ('47', '&nbsp;辅材/工具------激光测距仪-----测试商品2辅材/工具------激光测距仪-----测试商品2辅材/工具------激光测距仪-----测试商品2辅材/工具------激光测距仪-----测试商品2辅材/工具------激光测距仪-----测试商品2');
INSERT INTO `ty_mall_data` VALUES ('48', '&nbsp;辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1');
INSERT INTO `ty_mall_data` VALUES ('49', '&nbsp;<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">拥有独特的无方向性花纹，提供无限创意，并拥有更多的设计选择</span>\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">&nbsp;■卓越的修边及直角，使片材安装后可以接近无缝效果</p>\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">&nbsp;■具有阿更好的弯曲性能，使安装更容易、损耗更小</p>\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">表面，寿命更长久，历久如新</p>\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">&nbsp;■表面致密，易保养且不易藏污</p>\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">&nbsp;■极佳耐久性及耐磨</p>\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">&nbsp;■适用于办公室、零售业、教育环境、医护环境及轻工业</p>\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">阿姆斯壮磨石彩花色&nbsp;7T762082浅灰&nbsp;7T762102杏白&nbsp;7T772012赤红&nbsp;7T772062深灰&nbsp;7T772152雾蓝&nbsp;7T772162淡蓝&nbsp;7T772172淡绿&nbsp;7T772202石白&nbsp;7T772212米棕&nbsp;</p>\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">&nbsp;多种花色选择欢迎来电索取！<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b>供应阿姆斯壮系列地板<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b><b style=\"word-break: break-all; text-size-adjust: none;\">商用片材</b><b style=\"word-break: break-all; text-size-adjust: none;\">地板</b>----阿姆斯壮威牛系列、&nbsp;&nbsp;阿美国姆斯壮龙彩系列、&nbsp;&nbsp;阿姆斯壮魔石彩系列<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;阿姆斯壮洞石彩系列、&nbsp;&nbsp;阿姆斯壮梦彩系列、&nbsp;&nbsp;阿姆斯壮纯彩系列<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;阿姆斯壮晶彩系列<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b><b style=\"word-break: break-all; text-size-adjust: none;\">同质透心卷材</b>----阿姆斯壮保健龙系列、&nbsp;&nbsp;阿姆斯壮澳威龙系列、&nbsp;&nbsp;阿姆斯壮中意龙系列<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;阿姆斯壮健丽龙系列、&nbsp;&nbsp;阿姆斯壮雅丽龙系列、&nbsp;&nbsp;阿姆斯壮坚利龙系列<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;阿姆斯壮新意龙系列、<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\">&nbsp;&nbsp;</span>阿姆斯壮瑞丽龙系列<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b><b style=\"word-break: break-all; text-size-adjust: none;\">叠压结构卷材</b>----阿姆斯壮吸音翠丽龙系列、&nbsp;&nbsp;阿姆斯壮印象龙系列、阿姆斯壮新丽龙系列<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b><b style=\"word-break: break-all; text-size-adjust: none;\">嵌入颗粒卷材</b>----阿姆斯壮宝石龙II系列<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b><b style=\"word-break: break-all; text-size-adjust: none;\">环保亚麻地板</b>----阿姆斯壮美莱亚麻、&nbsp;阿姆斯壮美奥亚麻、&nbsp;阿姆斯壮美格亚麻<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b>&nbsp;公司代理和销售国内外多种知名品牌PVC塑胶地板，主要公司代理和销售国内外多种知名品牌PVC塑胶地板，主要经营品牌有：美国的阿姆斯壮、法国的洁福、荷兰的福尔波、韩国的LG、法国的得嘉等PVC塑胶地板，公司拥有充足的仓储，销售辐射整个西南、华北地区，公司将以合理的市场价格，国际品牌的质量，完善的市场服务，期待与斯壮、法国的洁福、荷兰的福尔波、韩国的LG、法国的得嘉等PVC塑胶地板，公司拥有充足的仓储，销售辐射整个西南、华北地区，公司将以合理的市场价格，国际品牌的质量，完善的市场服务，期待与您的合作，共同发展。<b style=\"word-break: break-all; text-size-adjust: none;\"><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\"><br style=\"word-break: break-all; text-size-adjust: none;\" />\r\n</span></b>山西总代理宗轩装饰设计工程有限公司专业的销售、设计、施工、维护为您服务，欢迎您的到来，期待您的合作。</p>');
INSERT INTO `ty_mall_data` VALUES ('50', '&nbsp;\r\n<ul class=\"attributes-list list-paddingleft-2\" style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; list-style-type: none;\">\r\n    <p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\">型号:&nbsp;厂标</p>\r\n    <p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\">适用场所:&nbsp;外墙</p>\r\n    <p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\">计价单位:&nbsp;片</p>\r\n    <p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\">瓷砖尺寸（平方毫米）:&nbsp;100*200</p>\r\n    <p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px;\">同城服务2:&nbsp;同城买家上门提货</p>\r\n</ul>');
INSERT INTO `ty_mall_data` VALUES ('51', '&nbsp;<a style=\"font-family: 宋体, arial, sans-serif; color: rgb(214,14,33); font-size: 12px; text-decoration: none\" class=\"Themefont\" target=\"_blank\" href=\"http://www.258.com/hots/1000321931.html\">铝扣板</a><span style=\"font-family: 宋体, arial, sans-serif; color: rgb(102,102,102); font-size: 12px\">是以铝合金板材为基底，通过开料，剪角，模压成型得到，铝扣板表面使用各种不同的涂层加工得到各种铝扣板产品，铝扣板。</span>\r\n<p style=\"padding-bottom: 0px; text-indent: 0px; margin: 0px; padding-left: 0px; padding-right: 0px; font-family: 宋体, arial, sans-serif; color: rgb(102,102,102); font-size: 12px; padding-top: 0px\">&nbsp; &nbsp;主要分两种类型，一种是家装集成铝扣板，另一种则是工程铝扣板，家装铝扣板开始主要以滚涂和磨砂两大系列为主，随着发展，家装集成铝扣板已经五花八门，各种不同的加工工艺都运用到其中，像<a style=\"color: rgb(214,14,33); text-decoration: none\" class=\"Themefont\" target=\"_blank\" href=\"http://www.258.com/hots/1000295149.html\">热转印</a>，釉面，油墨印花，镜面，3D等等系列是近年来受欢迎的家装集成铝扣板。</p>\r\n<p style=\"padding-bottom: 0px; text-indent: 0px; margin: 0px; padding-left: 0px; padding-right: 0px; font-family: 宋体, arial, sans-serif; color: rgb(102,102,102); font-size: 12px; padding-top: 0px\">&nbsp; &nbsp;家装集成铝扣板是以<a style=\"color: rgb(214,14,33); text-decoration: none\" class=\"Themefont\" target=\"_blank\" href=\"http://www.258.com/hots/1000625892.html\">板面</a>花式，使用寿命，板面优势等取得市场认可，工程铝扣板常用的是滚涂，粉末喷涂，覆膜，磨砂等几种表面涂层，表面较为简单，颜色都是纯色为主，其中，乳白色是工程铝扣板使用得多的，工程铝扣板选购主要是要看涂层，涂层颜色的保障是首要考虑因素，涂层的使用寿命延长才能保证业主利益。</p>');
INSERT INTO `ty_mall_data` VALUES ('52', '&nbsp;<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.326*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.35*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.40*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.426*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.45*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.476*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.50*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">0.60*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿；</p>');
INSERT INTO `ty_mall_data` VALUES ('53', '&nbsp;<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.326*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.35*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.40*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.426*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.45*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.476*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\">0.50*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<p style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;; text-indent: 0px;\">0.60*1000/1200*C海蓝/白灰/绯红/象牙白/瓷蓝/深豆绿；</p>');
INSERT INTO `ty_mall_data` VALUES ('54', '&nbsp;大是的发送到发送到发是的发送到发送到');
INSERT INTO `ty_mall_data` VALUES ('55', '&nbsp;dfasdfasdfdsgfh法规发生的无色若群翁人情味儿翁');
INSERT INTO `ty_mall_data` VALUES ('56', '&nbsp;啥都发送到发送到发送到发送到发送到发送到发的说法是大法师');
INSERT INTO `ty_mall_data` VALUES ('57', '&nbsp;<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('58', '<a href=\"http://www.tctianyi.com/index.php?homepage=hebeixinda\" target=\"_blank\" style=\"font-family: Verdana, Arial; font-size: 12px; text-align: center; word-break: break-all; text-size-adjust: none; color: rgb(51, 51, 51); text-decoration: none;\"><br />\r\n</a><span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('59', '&nbsp;<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('60', '&nbsp;<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('61', '<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('62', '&nbsp;<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('63', '&nbsp;<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('64', '&nbsp;<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: \" microsoft=\"\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: \" microsoft=\"\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('65', '&nbsp;<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板大致可分为普通岩棉板、防火岩棉板、憎水岩棉板、高温岩棉板、高密度岩棉板、墙体岩棉板、民用岩棉板、无土栽培岩棉板等几大类别.</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">岩棉彩钢板的制作流程如下:</span><br style=\"word-break: break-all; text-size-adjust: none; color: rgb(68, 68, 68); font-family: &quot;Microsoft YaHei&quot;, SimSun, &quot;Arial, Helvetica, sans-serif&quot;;\" />\r\n<span style=\"word-break: break-all; text-size-adjust: none; margin: 0px; padding: 0px; color: rgb(85, 85, 85); font-family: 宋体; font-size: 12px; line-height: 21px;\">彩钢板是由玄武岩经高炉融化成液状,经高速离心棍甩丝,经高速风流喷吹,构成纤维细度小,柔韧性强的岩棉板纤维,经喷吹布棉法,用岩棉板组成专用胶将其喷入岩棉纤维中,将岩棉纤维组成,然后经定速摆锤,匀速布棉法将岩棉纤维布棉,经履带转速操控,上下履带压制法,压制成岩棉板,岩棉板的密度凹凸由履带转速操控,及摆锤落棉量决议.岩棉经摆锤布棉后,由履带上下压制法,传送至高温烘干炉中,将其烘干,制作成岩棉板后.传送出烘干炉,经高速切开锯纵向切开变成宽度均匀的岩棉板长板,后经高速切开锯由微电脑操控,横向切开成长度一样的岩棉板.红经传送带传送至包装设备.由设备自取法将岩棉板单板重叠成固定包装数量的岩棉板.后经传送带将岩棉板送至包装平台,经传送至热塑模包装进程,设备自动用岩棉板热缩专用膜将岩棉板包裹,由传送设备将热缩膜包裹岩棉板送至热缩缩短炉,经高温烘制使其缩短膜自然缩短,将岩棉板严紧包裹,再由传送设备传送至运输车,运输至岩棉板寄存库.这样全部彩钢板制作过程就已完成.</span>');
INSERT INTO `ty_mall_data` VALUES ('66', '&nbsp;啥水电费水电费是打发斯蒂芬孤胆特工');
INSERT INTO `ty_mall_data` VALUES ('67', '&nbsp;没有');
INSERT INTO `ty_mall_data` VALUES ('68', '&nbsp;按时打算发的');
INSERT INTO `ty_mall_data` VALUES ('69', '<img src=\"http://www.tctianyi.com/file/upload/201705/08/1659393714.jpg\" width=\"160\" height=\"225\" alt=\"\" /><br />\r\n21341231231<br />\r\n<img src=\"http://www.tctianyi.com/file/upload/201705/08/1659051014.png\" alt=\"未标题-2\" width=\"930\" height=\"1163\" /><br type=\"_moz\" />');
INSERT INTO `ty_mall_data` VALUES ('70', '&nbsp;1111111');
INSERT INTO `ty_mall_data` VALUES ('71', '&nbsp;222222222222222');

-- ----------------------------
-- Table structure for ty_mall_express
-- ----------------------------
DROP TABLE IF EXISTS `ty_mall_express`;
CREATE TABLE `ty_mall_express` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `express` varchar(30) NOT NULL,
  `fee_start` decimal(10,2) unsigned NOT NULL,
  `fee_step` decimal(10,2) unsigned NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='运费模板';

-- ----------------------------
-- Records of ty_mall_express
-- ----------------------------
INSERT INTO `ty_mall_express` VALUES ('1', '0', '0', 'shandongpingyi', '测试快递1', '快递1', '8.00', '0.00', '1493971453', '0', '0', '国内快递（1-7天送达）');
INSERT INTO `ty_mall_express` VALUES ('2', '0', '0', 'shandongpingyi', '快递2', '快递22222', '3.00', '0.00', '1493973276', '0', '0', '123123131321测试1wcoin');
INSERT INTO `ty_mall_express` VALUES ('3', '0', '0', 'xinxin', '另一个用户', '123123', '123123.00', '0.00', '1493973341', '0', '0', '');

-- ----------------------------
-- Table structure for ty_mall_order
-- ----------------------------
DROP TABLE IF EXISTS `ty_mall_order`;
CREATE TABLE `ty_mall_order` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(6) unsigned NOT NULL DEFAULT '16',
  `mallid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `buyer` varchar(30) NOT NULL DEFAULT '',
  `seller` varchar(30) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fee_name` varchar(30) NOT NULL DEFAULT '',
  `buyer_name` varchar(30) NOT NULL DEFAULT '',
  `buyer_address` varchar(255) NOT NULL DEFAULT '',
  `buyer_postcode` varchar(10) NOT NULL DEFAULT '',
  `buyer_phone` varchar(30) NOT NULL DEFAULT '',
  `buyer_mobile` varchar(30) NOT NULL DEFAULT '',
  `buyer_star` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `seller_star` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `send_type` varchar(50) NOT NULL DEFAULT '',
  `send_no` varchar(50) NOT NULL DEFAULT '',
  `send_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `send_time` varchar(20) NOT NULL DEFAULT '',
  `send_days` int(10) unsigned NOT NULL DEFAULT '0',
  `cod` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `trade_no` varchar(50) NOT NULL DEFAULT '',
  `add_time` smallint(6) NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `buyer_reason` mediumtext NOT NULL,
  `refund_reason` mediumtext NOT NULL,
  `note` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `buyer` (`buyer`),
  KEY `seller` (`seller`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商城订单';

-- ----------------------------
-- Records of ty_mall_order
-- ----------------------------
INSERT INTO `ty_mall_order` VALUES ('1', '16', '64', 'tianyi', 'shandongpingyi', '瑞泰铝扣板', 'http://www.tctianyi.com/file/upload/201704/07/1019087714.jpg.thumb.jpg', '2000.00', '1', '2000.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494552187', '1494579023', '', '', '', '|', '8');
INSERT INTO `ty_mall_order` VALUES ('2', '16', '64', 'tianyi', 'shandongpingyi', '瑞泰铝扣板', 'http://www.tctianyi.com/file/upload/201704/07/1019087714.jpg.thumb.jpg', '2000.00', '1', '2000.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494552191', '1494579021', '', '', '', '|', '8');
INSERT INTO `ty_mall_order` VALUES ('3', '16', '64', 'tianyi', 'shandongpingyi', '瑞泰铝扣板', 'http://www.tctianyi.com/file/upload/201704/07/1019087714.jpg.thumb.jpg', '2000.00', '1', '2000.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494555240', '1494579001', '', '', '', '|', '8');
INSERT INTO `ty_mall_order` VALUES ('4', '16', '64', 'tianyi', 'shandongpingyi', '瑞泰铝扣板', 'http://www.tctianyi.com/file/upload/201704/07/1019087714.jpg.thumb.jpg', '2000.00', '2', '4000.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494556173', '1494579020', '', '', '', '|', '8');
INSERT INTO `ty_mall_order` VALUES ('5', '16', '66', 'tianyi', 'shandongpingyi', '瑞泰pvc地板', 'http://www.tctianyi.com/file/upload/201704/10/1521187314.jpg.thumb.jpg', '3000.00', '2', '6000.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494556173', '1494579018', '', '', '', '|', '8');
INSERT INTO `ty_mall_order` VALUES ('6', '16', '58', 'tianyi', 'hebeixinda', '鑫大彩钢板', 'http://www.tctianyi.com/file/upload/201704/07/0950486216.jpg.thumb.jpg', '200.00', '1', '200.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494557455', '1494579017', '', '', '', '|', '8');
INSERT INTO `ty_mall_order` VALUES ('7', '16', '69', 'tianyi', 'shandongpingyi', '安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱', 'http://www.tctianyi.com/file/upload/201705/08/1519599314.jpg.thumb.jpg', '22.00', '1', '22.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494557902', '1494579010', '', '', '', '|', '8');
INSERT INTO `ty_mall_order` VALUES ('8', '16', '63', 'tianyi', 'laizhoujieli', '洁力优质地板', 'http://www.tctianyi.com/file/upload/201704/07/1009172015.jpg.thumb.jpg', '200.00', '1', '200.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494557902', '1494579008', '', '', '', '|', '8');
INSERT INTO `ty_mall_order` VALUES ('9', '16', '55', 'tianyi', 'zhongshanyayun', '雅云PVC地板', 'http://www.tctianyi.com/file/upload/201704/07/0926475917.jpg.thumb.jpg', '200.00', '1', '200.00', '0.00', '', '嘉客', '北京测试23123123123123132', '510100', '', '13789545521', '0', '0', '', '', '0', '', '0', '0', '', '0', '1494557902', '1494579004', '', '', '', '|', '8');

-- ----------------------------
-- Table structure for ty_mall_stat
-- ----------------------------
DROP TABLE IF EXISTS `ty_mall_stat`;
CREATE TABLE `ty_mall_stat` (
  `mallid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `seller` varchar(30) NOT NULL DEFAULT '',
  `scomment` int(10) unsigned NOT NULL DEFAULT '0',
  `s1` int(10) unsigned NOT NULL DEFAULT '0',
  `s2` int(10) unsigned NOT NULL DEFAULT '0',
  `s3` int(10) unsigned NOT NULL DEFAULT '0',
  `buyer` varchar(30) NOT NULL DEFAULT '',
  `bcomment` int(10) unsigned NOT NULL DEFAULT '0',
  `b1` int(10) unsigned NOT NULL DEFAULT '0',
  `b2` int(10) unsigned NOT NULL DEFAULT '0',
  `b3` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `mallid` (`mallid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评分统计';

-- ----------------------------
-- Records of ty_mall_stat
-- ----------------------------
INSERT INTO `ty_mall_stat` VALUES ('64', 'shandongpingyi', '0', '0', '0', '0', 'tianyi', '0', '0', '0', '0');
INSERT INTO `ty_mall_stat` VALUES ('66', 'shandongpingyi', '0', '0', '0', '0', 'tianyi', '0', '0', '0', '0');
INSERT INTO `ty_mall_stat` VALUES ('58', 'hebeixinda', '0', '0', '0', '0', 'tianyi', '0', '0', '0', '0');
INSERT INTO `ty_mall_stat` VALUES ('69', 'shandongpingyi', '0', '0', '0', '0', 'tianyi', '0', '0', '0', '0');
INSERT INTO `ty_mall_stat` VALUES ('63', 'laizhoujieli', '0', '0', '0', '0', 'tianyi', '0', '0', '0', '0');
INSERT INTO `ty_mall_stat` VALUES ('55', 'zhongshanyayun', '0', '0', '0', '0', 'tianyi', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for ty_member
-- ----------------------------
DROP TABLE IF EXISTS `ty_member`;
CREATE TABLE `ty_member` (
  `userid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `passport` varchar(30) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `passsalt` varchar(8) NOT NULL,
  `payword` varchar(32) NOT NULL DEFAULT '',
  `paysalt` varchar(8) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `message` smallint(6) unsigned NOT NULL DEFAULT '0',
  `chat` smallint(6) unsigned NOT NULL DEFAULT '0',
  `sound` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `avatar` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `truename` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `department` varchar(30) NOT NULL DEFAULT '',
  `career` varchar(30) NOT NULL DEFAULT '',
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `role` varchar(255) NOT NULL DEFAULT '',
  `aid` int(10) unsigned NOT NULL DEFAULT '0',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '4',
  `regid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `sms` int(10) NOT NULL DEFAULT '0',
  `credit` int(10) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deposit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `bank` varchar(30) NOT NULL DEFAULT '',
  `banktype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `branch` varchar(100) NOT NULL,
  `account` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `regip` varchar(50) NOT NULL DEFAULT '',
  `regtime` int(10) unsigned NOT NULL DEFAULT '0',
  `loginip` varchar(50) NOT NULL DEFAULT '',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `logintimes` int(10) unsigned NOT NULL DEFAULT '1',
  `black` varchar(255) NOT NULL DEFAULT '',
  `send` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `auth` varchar(32) NOT NULL DEFAULT '',
  `authvalue` varchar(100) NOT NULL DEFAULT '',
  `authtime` int(10) unsigned NOT NULL DEFAULT '0',
  `vemail` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vmobile` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vtruename` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vbank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vcompany` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vtrade` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `trade` varchar(50) NOT NULL DEFAULT '',
  `support` varchar(50) NOT NULL DEFAULT '',
  `inviter` varchar(30) NOT NULL DEFAULT '',
  `note` text NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `passport` (`passport`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='会员';

-- ----------------------------
-- Records of ty_member
-- ----------------------------
INSERT INTO `ty_member` VALUES ('1', 'tianyi', 'tianyi', '天医', '513664ef7984d0945364d4a38e2891b5', 'eMIAHVJw', 'c8cd0ed022317b3a13ad94369f3cd6ea', 'YqdtMWbW', 'mail@yourdomain.com', '0', '0', '0', '1', '0', '1', '嘉客', '', '', '', '', '', '', '', '1', '', '0', '1', '6', '1', '0', '165', '0.00', '0.00', '', '1', '', '', '1468385760', '127.0.0.1', '1467860142', '127.0.0.1', '1494923175', '60', '', '1', '', '', '1436723402', '0', '0', '0', '0', '0', '0', '', '', '', '');
INSERT INTO `ty_member` VALUES ('5', 'zhishuai', 'zhishuai', '职帅', '2fd43abc2cb77d37932e150ce57ace20', 'NYseEFvw', '314a717cc7ba47e279920a247ed3a81e', 'vi6TQHgb', '130849001@qq.com', '1', '0', '1', '1', '0', '1', 'zhishuai', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '231', '0', '20', '0.00', '0.00', '', '0', '', '', '1491017462', '127.0.0.1', '1491016776', '127.0.0.1', '1491017586', '2', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'zhishuai', '');
INSERT INTO `ty_member` VALUES ('6', 'tianjian', 'tianjian', '天健科技有限公司', '5cd031f6fc5d0cc2f4ce6bdb391aeddc', 'qVmdA6Mq', '13336f2debf2b5e7ed090dd831ce7860', 'zvHjKi3c', '215868785@qq.com', '1', '0', '1', '1', '0', '1', '天', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '231', '0', '20', '0.00', '0.00', '', '0', '', '', '1491375407', '127.0.0.1', '1491373855', '127.0.0.1', '1491373855', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'tianjian', '');
INSERT INTO `ty_member` VALUES ('7', 'tianyianfang', 'tianyianfang', '天翼安防器械科技有限公司', '43ea03344e5ea9ac5be9d1253de2c2c5', 'vD48vAZ5', '1e289a82fcd736c68d1936cc18c9bc22', 'WmcAxJCP', '13084902@qq.com', '1', '0', '1', '1', '0', '1', '天翼', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '252', '0', '20', '0.00', '0.00', '', '0', '', '', '1491379746', '127.0.0.1', '1491379746', '127.0.0.1', '1491379746', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'tianyianfang', '');
INSERT INTO `ty_member` VALUES ('8', 'hanzhongshengtu', 'hanzhongshengtu', '汉中市胜途电子科技有限公司', '6a0ffec9f19dc8b6e13be62a05d0ad15', 'Wetllked', '4b653016fc0be803321adbf9d847374f', 'wdQ504qG', '13084903@qq.com', '1', '0', '1', '1', '0', '1', '汉', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '343', '0', '20', '0.00', '0.00', '', '0', '', '', '1491380102', '127.0.0.1', '1491380102', '127.0.0.1', '1491380102', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'hanzhongshengtu', '');
INSERT INTO `ty_member` VALUES ('9', 'zhongshankehong', 'zhongshankehong', '中山市科鸿电子科技有限公司', '8f6341fd5e51b9bcddeed862e4c13e73', 'uJ3IOLjs', '7e5fbc984dc5b9d2418335e6ecb352f4', 'UZGWWFV5', '13084904@qq.com', '1', '0', '1', '1', '0', '2', '中', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '248', '0', '20', '0.00', '0.00', '', '0', '', '', '1491380289', '127.0.0.1', '1491380289', '127.0.0.1', '1491380289', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'zhongshankehong', '');
INSERT INTO `ty_member` VALUES ('10', 'shanghaiyante', 'shanghaiyante', '上海研腾机电科技有限公司', '62c9a4722fc3dd708738e2b66d0677fe', 'gga8Qcqt', 'efa9cef0a85865072e7ae91b5c74bf1f', 'BHCH9luC', '13084905@qq.com', '1', '0', '1', '1', '0', '1', '上', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '2', '0', '20', '0.00', '0.00', '', '0', '', '', '1491380430', '127.0.0.1', '1491380430', '127.0.0.1', '1491380430', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'shanghaiyante', '');
INSERT INTO `ty_member` VALUES ('11', 'zhejiangyingyang', 'zhejiangyingyang', '浙江赢阳防爆电器有限公司', '30820be17b0851b92a3b5adec34cb888', 'RngjRq15', '8bbcc2d501d09653bced620ad24e907b', 'TgcywUmn', '13084906@qq.com', '1', '0', '1', '1', '0', '1', '浙', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '12', '0', '20', '0.00', '0.00', '', '0', '', '', '1491381264', '127.0.0.1', '1491381264', '127.0.0.1', '1491381264', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'zhejiangyingyang', '');
INSERT INTO `ty_member` VALUES ('12', 'kuzishiye', 'kuzishiye', '库兹实业（上海）有限公司', '47b39e6e675c2cfb05ba291f9e7ddf7b', 'kaf0wIH8', 'd37c583e78347b9114cd95de6b765c78', 'NpfRCnw6', '13084907@qq.com', '1', '0', '1', '1', '0', '1', '库', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '2', '0', '20', '0.00', '0.00', '', '0', '', '', '1491381406', '127.0.0.1', '1491381406', '127.0.0.1', '1491381406', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'kuzishiye', '');
INSERT INTO `ty_member` VALUES ('13', 'shenzhenwanxi', 'shenzhenwanxi', '深圳市万嘉鸿福门窗有限公司', 'ef20d0bef870cd46df7eed513d36ab62', 'kZ9nxk2M', 'a2eb0440d46f65d911b830b28e4391ea', 'HbJlPcoz', '13080908@qq.com', '1', '0', '1', '1', '0', '1', '嘉', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '233', '0', '20', '0.00', '0.00', '', '0', '', '', '1491381893', '127.0.0.1', '1491381893', '127.0.0.1', '1491381893', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'shenzhenwanxi', '');
INSERT INTO `ty_member` VALUES ('14', 'shandongpingyi', 'shandongpingyi', '山东省平邑县瑞泰石业有限公司', '887bea1d0de354187ce719e586ad12e4', 'UpgTUx9H', '641408cdacc1a17f57d4c0b94bf691b5', 'CtGC5uQC', '13084901@qq.com', '14', '0', '1', '1', '1', '1', '平请求', '', '', '', '', '', '', '', '0', '', '0', '7', '6', '4', '0', '80', '2000.00', '4000.00', '', '0', '', '', '1494661435', '127.0.0.1', '1491382289', '127.0.0.1', '1493782593', '7', '', '1', '', '', '0', '1', '0', '1', '0', '0', '0', '', '', 'shandongpingyi', '');
INSERT INTO `ty_member` VALUES ('15', 'laizhoujieli', 'laizhoujieli', '莱州结力工贸有限公司', 'd5ebc344767d3f5e548a7347c8b0e1e6', 'hM61kAKy', 'f554fecf6163f5d629eba2ece34ce70f', '6CnXZenA', '13084910@qq.com', '2', '0', '1', '1', '1', '1', '莱', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '171', '0', '27', '0.00', '4000.00', '', '0', '', '', '1491530385', '127.0.0.1', '1491382456', '127.0.0.1', '1491530319', '2', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'laizhoujieli', '');
INSERT INTO `ty_member` VALUES ('16', 'hebeixinda', 'hebeixinda', '河北廊坊鑫大保温材料有限公司', '4053888da2e1ff721aaa70d21b605215', '5cpE6zOM', 'c14d949e503a1522dac279131360f4b1', 'gTy1VAok', '13084911@qq.com', '2', '0', '1', '1', '0', '1', '鑫', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '44', '0', '27', '0.00', '0.00', '', '0', '', '', '1491529790', '127.0.0.1', '1491382757', '127.0.0.1', '1491529625', '2', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'hebeixinda', '');
INSERT INTO `ty_member` VALUES ('17', 'zhongshanyayun', 'zhongshanyayun', '中山市雅云灯饰有限公司', '6343aa290ddb8d33a151bd6b3b34a226', 'M3TR1tfg', 'b1fd5429c20613fa43d9bd1084a2a7e1', 'IzlVyzk7', '13084912@qq.com', '1', '0', '1', '1', '1', '1', '雅', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '248', '0', '27', '0.00', '0.00', '', '0', '', '', '1491528936', '127.0.0.1', '1491383078', '127.0.0.1', '1491528327', '2', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'zhongshanyayun', '');
INSERT INTO `ty_member` VALUES ('18', 'zhongshanxingdi', 'zhongshanxingdi', '中山市星迪照明电器有限公司', '876285a302c40f3cd3f9d349bf7cdfee', 'aksTGnKa', '5906f394f9cf6bdaba9b04f1fb79ad99', 'EmWtVS3H', '13084913@qq.com', '1', '0', '1', '1', '1', '1', '星', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '248', '0', '28', '0.00', '0.00', '', '0', '', '', '1491529516', '127.0.0.1', '1491383210', '127.0.0.1', '1491529433', '3', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'zhongshanxingdi', '');
INSERT INTO `ty_member` VALUES ('19', 'hulunbeier', '呼伦贝尔王子', '呼伦贝尔市晨光灯具厂', '5c6b5a6aa49a6c11661d1f088663b3d8', 'ZVKOWAg8', 'e941300bb754d277901642e40dd82934', 'dYEtEsld', '13084914@qq.com', '0', '0', '1', '1', '1', '1', '呼', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '63', '0', '27', '0.00', '0.00', '', '0', '', '', '1491450951', '127.0.0.1', '1491383345', '127.0.0.1', '1491450664', '2', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'hulunbeier', '');
INSERT INTO `ty_member` VALUES ('20', 'qingdaojutai', 'qingdaojutai', '青岛聚泰净化空调有限公司', 'dd0d682d9e8d6e64bdece6d85f9813da', '6FO1Ya26', '6e30cb727bb9f653f89f021b3543f48e', 'qvxF5b9p', '13084915@qq.com', '1', '0', '1', '1', '0', '1', '青', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '167', '0', '20', '0.00', '0.00', '', '0', '', '', '1491383989', '127.0.0.1', '1491383989', '127.0.0.1', '1491383989', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'qingdaojutai', '');
INSERT INTO `ty_member` VALUES ('21', 'nanjingtianjia', 'nanjingtianjia', '南京天加空调设备有限公司', '09a90c98579fafce6383c71659049fcd', 'e7In5hby', '939036c72d0fc4d36fd1651ff2c2af74', 'ng6mtJzG', '13084916@qq.com', '1', '0', '1', '1', '0', '1', '南', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '105', '0', '20', '0.00', '0.00', '', '0', '', '', '1491384217', '127.0.0.1', '1491384217', '127.0.0.1', '1491384217', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'nanjingtianjia', '');
INSERT INTO `ty_member` VALUES ('22', 'jinlida', 'jinlida', '金利达空调净化设备有限公司', '2c1584c48af43ba9d63eaaf8b0610af9', 'M2wedOLV', '400100303700d4e3f79816c911a9a028', '8ELwFcRW', '13084918@qq.com', '1', '0', '1', '1', '0', '1', '金', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '118', '0', '20', '0.00', '0.00', '', '0', '', '', '1491442132', '127.0.0.1', '1491442132', '127.0.0.1', '1491442132', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'jinlida', '');
INSERT INTO `ty_member` VALUES ('23', 'guangzhousutai', 'guangzhousutai', '广州市苏泰空调净化设备有限公司', 'c9760987de1fdf7b4b7678a185fc4d6d', 'pm4jbmKl', 'aa61be4137b5d53ed6c83070fc6be3e4', 'tKfjWGDb', '13084919@qq.com', '1', '0', '1', '1', '0', '2', '苏', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '231', '0', '20', '0.00', '0.00', '', '0', '', '', '1491442287', '127.0.0.1', '1491442287', '127.0.0.1', '1491442287', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'guangzhousutai', '');
INSERT INTO `ty_member` VALUES ('24', 'hebeihongyun', 'hebeihongyun', '河北宏润重工股份有限公司', '65718b5f333f72538ad4f9b90fd32754', '8ZL0skBL', 'a59c3cde75d4add6d7d38547fca4c980', 'uWfbEGRb', '13084920@qq.com', '1', '0', '1', '1', '0', '1', '河', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '43', '0', '20', '0.00', '0.00', '', '0', '', '', '1491442550', '127.0.0.1', '1491442550', '127.0.0.1', '1491442550', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'hebeihongyun', '');
INSERT INTO `ty_member` VALUES ('25', 'lizhiheng', 'lizhiheng', '力之恒管道科技有限公司', 'db35c8fd0cbc2adda8c1f53cb7a366ec', 'rfcX6jQv', '59a0b8293744eb13c6be65cddd1ff8d0', 'jNsKeMot', '13084921@qq.com', '1', '0', '1', '1', '0', '2', '力', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '150', '0', '20', '0.00', '0.00', '', '0', '', '', '1491442865', '127.0.0.1', '1491442865', '127.0.0.1', '1491442865', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'lizhiheng', '');
INSERT INTO `ty_member` VALUES ('26', 'shanghaiyuansu', 'shanghaiyuansu', '上海源朔贸易有限公司', 'c9bb5f0160dad616a7e971d898ff5413', 'wzCtnX0q', 'c8324be9e60595d070d28aba0fe1ef9b', 'grw67IWQ', '13084922@qq.com', '1', '0', '1', '1', '0', '2', '源', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '2', '0', '20', '0.00', '0.00', '', '0', '', '', '1491442992', '127.0.0.1', '1491442992', '127.0.0.1', '1491442992', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'shanghaiyuansu', '');
INSERT INTO `ty_member` VALUES ('27', 'meijiahua', 'meijiahua', '衢州市美加华管业有限公司', 'ec38f622084a65e520d7be246ea9f734', '9hQvXmoj', '5c1bb0da204d0c55c98ff2c1176721bd', 'ujRspycY', '13084923@qq.com', '1', '0', '1', '1', '0', '2', '美', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '125', '0', '20', '0.00', '0.00', '', '0', '', '', '1491443117', '127.0.0.1', '1491443117', '127.0.0.1', '1491443117', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'meijiahua', '');
INSERT INTO `ty_member` VALUES ('28', 'dengquan', 'dengquan', '邓权塑业科技（湖南）有限公司', '3fdc13b1ed0e6ee7e823a121e090560e', 'sVzfI5Ne', 'b6a8de901721138b4ebf834afecbed26', 'Nj41T3qf', '13084924@qq.com', '1', '0', '1', '1', '0', '1', '邓', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '223', '0', '20', '0.00', '0.00', '', '0', '', '', '1491443251', '127.0.0.1', '1491443251', '127.0.0.1', '1491443251', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'dengquan', '');
INSERT INTO `ty_member` VALUES ('29', 'jinhui', 'jinhui', '青岛金辉管业有限公司', 'f396f846adb1419eb31c4b9a74a400de', 'YwG1WSiG', 'ebc1ee26570242ffc277b324657a078e', 'FsG5mOWE', '13084925@qq.com', '1', '0', '1', '1', '0', '1', '金', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '167', '0', '20', '0.00', '0.00', '', '0', '', '', '1491443991', '127.0.0.1', '1491443991', '127.0.0.1', '1491443991', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'jinhui', '');
INSERT INTO `ty_member` VALUES ('30', 'dimaikesi', 'dimaikesi', '帝麦克斯（苏州）医疗科技有限公司', '66d5712ab9666ec7bd3b49ce3a7996d6', 'x8cjLLgi', '56c1d6428ff1625f98645f2c7487b7a3', 'KxlnQyz5', '13084926@qq.com', '1', '0', '1', '1', '0', '1', '帝', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '109', '0', '20', '0.00', '0.00', '', '0', '', '', '1491444364', '127.0.0.1', '1491444364', '127.0.0.1', '1491444364', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'dimaikesi', '');
INSERT INTO `ty_member` VALUES ('31', 'lulu', 'lulu', '上海豫沪实业限公司', 'da53c1611c7bdae5b178f4537e2e5b6b', 'fx3NKhve', '5e4dc6dd175834b1a1374554b14b858c', 'Ax2Jn0LW', '13084927@qq.com', '1', '0', '1', '1', '0', '1', '鲁', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '2', '0', '20', '0.00', '0.00', '', '0', '', '', '1491444646', '127.0.0.1', '1491444646', '127.0.0.1', '1491444646', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'lulu', '');
INSERT INTO `ty_member` VALUES ('32', 'anterui', 'anterui', '深圳市安特瑞智能科技有限公司', 'ae165c6cb2c9b2060ff5c2d5d7e69c8f', 'l8LMiBDx', '4496990b1b05e1b8b3b516b4bc5e3984', 'ZBN7yIht', '13084928@qq.com', '1', '0', '1', '1', '0', '1', '安', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '233', '0', '20', '0.00', '0.00', '', '0', '', '', '1491444776', '127.0.0.1', '1491444776', '127.0.0.1', '1491444776', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'anterui', '');
INSERT INTO `ty_member` VALUES ('33', 'guying', 'guying', '山东固赢实验设备有限公司', '9d477dda53574c69435f6110e6550ce2', 'A2j7CGLt', '10c35ce75bcc3b176efabdc98d2dbcac', 'aXYkPkfE', '13084929@qq.com', '1', '0', '1', '1', '0', '1', '固', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '168', '0', '20', '0.00', '0.00', '', '0', '', '', '1491444906', '127.0.0.1', '1491444906', '127.0.0.1', '1491444906', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'guying', '');
INSERT INTO `ty_member` VALUES ('34', 'qipu', 'qipu', '上海气谱仪器设备有限公司', '7e3e2880812f930a6e95b26d87a8ea39', 'EszruTwi', '9a339a0cb632dad0455f5bd957d2caaa', 'hBLMjA24', '13084930@qq.com', '1', '0', '1', '1', '0', '1', '气', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '2', '0', '20', '0.00', '0.00', '', '0', '', '', '1491445277', '127.0.0.1', '1491445277', '127.0.0.1', '1491445277', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'qipu', '');
INSERT INTO `ty_member` VALUES ('35', 'dongyi', 'dongyi', '山东东易日盛仪器有限公司', '5f14276367a8b608203438a8e0b4c5e2', 'p0ykdZWO', 'c0c3d7d467efebb851a2ba1840c40018', 'usQOTSI9', '13084931@qq.com', '1', '0', '1', '1', '0', '1', '东', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '182', '0', '20', '0.00', '0.00', '', '0', '', '', '1491445471', '127.0.0.1', '1491445471', '127.0.0.1', '1491445471', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'dongyi', '');
INSERT INTO `ty_member` VALUES ('36', 'mengmeiyi', 'mengmeiyi', '深圳市梦美怡美容仪器有限公司', '8df14d662fada8b976ab294b50f5b6bf', 'xP9jQs9N', 'a34e2d6d6da4cec6bf375899e0bd4372', 'z3OP50bA', '13084932@qq.com', '1', '0', '1', '1', '0', '1', '梦', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '233', '0', '20', '0.00', '0.00', '', '0', '', '', '1491447981', '127.0.0.1', '1491447981', '127.0.0.1', '1491447981', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'mengmeiyi', '');
INSERT INTO `ty_member` VALUES ('37', 'zhongjian', 'zhongjian', '沧州中建精密仪器有限公司', 'de2ebd58917043b68382b643b4cd5b08', 'U8TcNE3X', 'cad9e069f859579372939a0e794c2cea', 'QsnsBm4D', '13084933@qq.com', '1', '0', '1', '1', '0', '1', '中', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '43', '0', '20', '0.00', '0.00', '', '0', '', '', '1491448107', '127.0.0.1', '1491448107', '127.0.0.1', '1491448107', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'zhongjian', '');
INSERT INTO `ty_member` VALUES ('38', 'hengpu', 'hengpu', '佛山市衡普环境试验设备有限公司', '6cc23f21e0bb1fd865520d301c014d67', '6nWfWCzw', '11c236636332109e4228c72d5c4aab4e', 'RFPsot77', '13084934@qq.com', '1', '0', '1', '1', '0', '1', '衡', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '236', '0', '20', '0.00', '0.00', '', '0', '', '', '1491448445', '127.0.0.1', '1491448445', '127.0.0.1', '1491448445', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'hengpu', '');
INSERT INTO `ty_member` VALUES ('39', 'deli', 'deli', '陕西德力能源科技有限公司', 'f1743eb2d500877571b94844602946c9', 'R8jplLXu', 'f17a9dbb499bbf17d51fb4aa1e51c9c0', 'OjTrqABg', '13084935@qq.com', '1', '0', '1', '1', '0', '1', '德', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '341', '0', '20', '0.00', '0.00', '', '0', '', '', '1491448644', '127.0.0.1', '1491448644', '127.0.0.1', '1491448644', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'deli', '');
INSERT INTO `ty_member` VALUES ('40', 'weinun', 'weinun', '上海伟暖实业有限公司', '02cdf5e6fcb9afc4cd421999e74a1493', 'pqDsVu7c', '1d8666d95eedf48dbf0829311c2554c8', 'eBE5zvrj', '13084936@qq.com', '1', '0', '1', '1', '0', '1', '伟', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '2', '0', '20', '0.00', '0.00', '', '0', '', '', '1491448770', '127.0.0.1', '1491448770', '127.0.0.1', '1491448770', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'weinun', '');
INSERT INTO `ty_member` VALUES ('41', 'wolu', 'wolu', '郑州锅炉股份有限公司', '6f1c9c70ee8eebc9b3bdf831197beb4a', 'r9mM4Nhd', '0e6413cad99a8d630dcafb44e5e6bb2b', '9Hd9Puil', '13084937@qq.com', '1', '0', '1', '1', '0', '1', '窝', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '183', '0', '20', '0.00', '0.00', '', '0', '', '', '1491448881', '127.0.0.1', '1491448881', '127.0.0.1', '1491448881', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'wolu', '');
INSERT INTO `ty_member` VALUES ('42', 'maizhong', 'maizhong', '厦门迈众机电设备工程有限公司', '72c3e5fe7c8d4b5bb00acb7a606aada1', '6Pk4LBUa', '1d4a4928e0f97a175ab19c045c3b0b05', 'ql9nZZPU', '13084938@qq.com', '1', '0', '1', '1', '0', '1', '迈', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '147', '0', '20', '0.00', '0.00', '', '0', '', '', '1491449024', '127.0.0.1', '1491449024', '127.0.0.1', '1491449024', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'maizhong', '');
INSERT INTO `ty_member` VALUES ('43', 'huazhicheng', 'huazhicheng', '济南华之成节能科技有限公司', '5b929bf5ed9723e2e4e26b0bc93ef321', 'RM7Fp1AY', '2e7e21d8ac06a196094fba3513ac7612', 'CRB3SQHZ', '13084939@qq.com', '1', '0', '1', '1', '0', '1', '华', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '166', '0', '20', '0.00', '0.00', '', '0', '', '', '1491449199', '127.0.0.1', '1491449199', '127.0.0.1', '1491449199', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'huazhicheng', '');
INSERT INTO `ty_member` VALUES ('44', 'fumushi', 'fumushi', '广州福姆斯绝热材料有限公司', 'dcf5cc48fc155e25173bee117ba8698b', 'GKZ0Mg7Y', 'f9da4ba43f9579a56fb7b850e3ac4a0d', '1q4fbvR6', '13084940@qq.com', '1', '0', '1', '1', '0', '1', '福', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '231', '0', '20', '0.00', '0.00', '', '0', '', '', '1491449837', '127.0.0.1', '1491449837', '127.0.0.1', '1491449837', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'fumushi', '');
INSERT INTO `ty_member` VALUES ('45', 'bodun', 'bodun', '东莞市博盾金属材料科技有限公司', '1f0bcdeca310319435aa034844befe9c', '5dwRJm2P', 'c418258d991cc5e03e7ee18dce84571b', 'd5ImbL6S', '13084941@qq.com', '1', '0', '1', '1', '0', '1', '博', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '247', '0', '20', '0.00', '0.00', '', '0', '', '', '1491449980', '127.0.0.1', '1491449980', '127.0.0.1', '1491449980', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'bodun', '');
INSERT INTO `ty_member` VALUES ('46', 'guangtong', 'guangtong', '霸州市城区广通线路工具厂', '31b6063264e73742d07136c1b37747f2', 'yy0eVxRo', '04bac3f52b872c8060487b0ceb0b7235', 'Dd0ImDyR', '13084942@qq.com', '1', '0', '1', '1', '0', '1', '通', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '44', '0', '20', '0.00', '0.00', '', '0', '', '', '1491450112', '127.0.0.1', '1491450112', '127.0.0.1', '1491450112', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'guangtong', '');
INSERT INTO `ty_member` VALUES ('47', 'taihong', 'taihong', '杭州泰宏五金工具有限公司', 'f1ae083a7c6461cf42e99c4eecf420eb', '5M9RaNZV', '75476c250705c2b5483ef26804f63dbc', 'K8DQXbtg', '13084943@qq.com', '1', '0', '1', '1', '0', '1', '泰', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '118', '0', '20', '0.00', '0.00', '', '0', '', '', '1491450222', '127.0.0.1', '1491450222', '127.0.0.1', '1491450222', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'taihong', '');
INSERT INTO `ty_member` VALUES ('48', 'xinxin', 'xinxin', '武汉鑫信合电子工具有限公司', 'a9b4a1a9a3129bc6daa19d485004cadc', '8okwv4Fi', '110d414eafc2df521f5b6efaddc80c50', '7hOIX1tB', '13084944@qq.com', '1', '0', '1', '1', '0', '1', '鑫', '', '', '', '', '', '', '', '0', '', '0', '6', '6', '200', '0', '20', '0.00', '0.00', '', '0', '', '', '1491450343', '127.0.0.1', '1491450343', '127.0.0.1', '1491450343', '1', '', '1', '', '', '0', '0', '0', '0', '0', '0', '0', '', '', 'xinxin', '');

-- ----------------------------
-- Table structure for ty_member_check
-- ----------------------------
DROP TABLE IF EXISTS `ty_member_check`;
CREATE TABLE `ty_member_check` (
  `userid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='会员资料审核';

-- ----------------------------
-- Records of ty_member_check
-- ----------------------------

-- ----------------------------
-- Table structure for ty_member_group
-- ----------------------------
DROP TABLE IF EXISTS `ty_member_group`;
CREATE TABLE `ty_member_group` (
  `groupid` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(50) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='会员组';

-- ----------------------------
-- Records of ty_member_group
-- ----------------------------
INSERT INTO `ty_member_group` VALUES ('1', '管理员', '0', '1');
INSERT INTO `ty_member_group` VALUES ('2', '禁止访问', '0', '2');
INSERT INTO `ty_member_group` VALUES ('3', '游客', '0', '3');
INSERT INTO `ty_member_group` VALUES ('4', '待审核会员', '0', '4');
INSERT INTO `ty_member_group` VALUES ('5', '个人会员', '0', '5');
INSERT INTO `ty_member_group` VALUES ('6', '企业会员', '0', '6');
INSERT INTO `ty_member_group` VALUES ('7', 'VIP会员', '1', '7');

-- ----------------------------
-- Table structure for ty_message
-- ----------------------------
DROP TABLE IF EXISTS `ty_message`;
CREATE TABLE `ty_message` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `typeid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `fromuser` varchar(30) NOT NULL DEFAULT '',
  `touser` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `isread` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `issend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `feedback` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `groupids` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `touser` (`touser`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='站内信件';

-- ----------------------------
-- Records of ty_message
-- ----------------------------
INSERT INTO `ty_message` VALUES ('2', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tianyi.com/\" target=\"_blank\"><img src=\"http://www.tianyi.com/file/upload/201607/07/142346151.jpg\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hekw07<br/>\r\n<strong>密码：</strong>tianyi<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'hekw07', '1481705047', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('3', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tianyi.com/\" target=\"_blank\"><img src=\"http://www.tianyi.com/file/upload/201607/07/142346151.jpg\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hekw08<br/>\r\n<strong>密码：</strong>GbK2312<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'hekw08', '1482717451', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('4', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>zhishuai<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'zhishuai', '1491016776', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('5', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>tianjian<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'tianjian', '1491373855', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('6', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>tianyianfang<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'tianyianfang', '1491379746', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('7', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hanzhongshengtu<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'hanzhongshengtu', '1491380102', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('8', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>zhongshankehong<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'zhongshankehong', '1491380289', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('9', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>shanghaiyante<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'shanghaiyante', '1491380430', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('10', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>zhejiangyingyang<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'zhejiangyingyang', '1491381264', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('11', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>kuzishiye<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'kuzishiye', '1491381406', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('12', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>shenzhenwanxi<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'shenzhenwanxi', '1491381893', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('68', '站内交易提醒，您有一笔交易需要确认(T2)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, shandongpingyi：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=64\" target=\"_blank\" class=\"t\"><strong>瑞泰铝扣板</strong></a><br/>订单编号：<span class=\"f_red\">T2</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">2000元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=2\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'shandongpingyi', '1494552191', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('14', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>laizhoujieli<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'laizhoujieli', '1491382456', '127.0.0.1', '1', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('15', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hebeixinda<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'hebeixinda', '1491382757', '127.0.0.1', '1', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('16', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>zhongshanyayun<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'zhongshanyayun', '1491383078', '127.0.0.1', '1', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('17', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>zhongshanxingdi<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'zhongshanxingdi', '1491383210', '127.0.0.1', '1', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('18', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hulunbeier<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'hulunbeier', '1491383345', '127.0.0.1', '1', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('19', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>qingdaojutai<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'qingdaojutai', '1491383989', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('20', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>nanjingtianjia<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'nanjingtianjia', '1491384217', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('21', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>jinlida<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'jinlida', '1491442132', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('22', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>guangzhousutai<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'guangzhousutai', '1491442287', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('23', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hebeihongyun<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'hebeihongyun', '1491442550', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('24', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>lizhiheng<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'lizhiheng', '1491442865', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('25', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>shanghaiyuansu<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'shanghaiyuansu', '1491442992', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('26', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>meijiahua<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'meijiahua', '1491443117', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('27', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>dengquan<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'dengquan', '1491443251', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('28', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>jinhui<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'jinhui', '1491443991', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('29', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>dimaikesi<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'dimaikesi', '1491444364', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('30', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>lulu<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'lulu', '1491444646', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('31', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>anterui<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'anterui', '1491444776', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('32', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>guying<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'guying', '1491444906', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('33', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>qipu<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'qipu', '1491445277', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('34', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>dongyi<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'dongyi', '1491445471', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('35', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>mengmeiyi<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'mengmeiyi', '1491447981', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('36', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>zhongjian<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'zhongjian', '1491448107', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('37', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hengpu<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'hengpu', '1491448445', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('38', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>deli<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'deli', '1491448644', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('39', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>weinun<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'weinun', '1491448770', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('40', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>wolu<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'wolu', '1491448881', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('41', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>maizhong<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'maizhong', '1491449024', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('42', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>huazhicheng<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'huazhicheng', '1491449199', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('43', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>fumushi<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'fumushi', '1491449837', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('44', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>bodun<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'bodun', '1491449980', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('45', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>guangtong<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'guangtong', '1491450112', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('46', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>taihong<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'taihong', '1491450222', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('47', '欢迎加入天医工程网', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>xinxin<br/>\r\n<strong>密码：</strong>qwe123<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>', '', 'xinxin', '1491450343', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('48', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>形象图片 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'hulunbeier', '1491457410', '127.0.0.1', '1', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('49', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>形象图片 ---------- <span style=\"color:green;\">已通过</span><br/>公司地址 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'zhongshanyayun', '1491528973', '127.0.0.1', '1', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('50', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>形象图片 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'zhongshanxingdi', '1491529524', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('51', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>形象图片 ---------- <span style=\"color:green;\">已通过</span><br/>公司地址 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'hebeixinda', '1491529802', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('52', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>形象图片 ---------- <span style=\"color:green;\">已通过</span><br/>公司地址 ---------- <span style=\"color:green;\">已通过</span><br/>公司介绍 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'laizhoujieli', '1491531010', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('67', '站内交易提醒，您有一笔交易需要确认(T1)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, shandongpingyi：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=64\" target=\"_blank\" class=\"t\"><strong>瑞泰铝扣板</strong></a><br/>订单编号：<span class=\"f_red\">T1</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">2000元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=1\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'shandongpingyi', '1494552187', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('65', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>移动电话 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1493368945', '127.0.0.1', '1', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('66', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>公司地址 ---------- <span style=\"color:green;\">已通过</span><br/>联系电话 ---------- <span style=\"color:green;\">已通过</span><br/>公司移动电话 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1493369494', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('62', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>公司介绍 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1493360000', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('63', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>公司介绍 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1493360191', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('64', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>经营范围 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1493360356', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('59', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>公司介绍 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1493359129', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('60', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>公司介绍 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1493359681', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('61', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>公司介绍 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1493359853', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('69', '站内交易提醒，您有一笔交易需要确认(T3)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, shandongpingyi：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=64\" target=\"_blank\" class=\"t\"><strong>瑞泰铝扣板</strong></a><br/>订单编号：<span class=\"f_red\">T3</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">2000元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=3\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'shandongpingyi', '1494555240', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('70', '站内交易提醒，您有一笔交易需要确认(T4)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, shandongpingyi：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=64\" target=\"_blank\" class=\"t\"><strong>瑞泰铝扣板</strong></a><br/>订单编号：<span class=\"f_red\">T4</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">4000元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=4\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'shandongpingyi', '1494556173', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('71', '站内交易提醒，您有一笔交易需要确认(T5)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, shandongpingyi：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=66\" target=\"_blank\" class=\"t\"><strong>瑞泰pvc地板</strong></a><br/>订单编号：<span class=\"f_red\">T5</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">6000元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=5\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'shandongpingyi', '1494556173', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('72', '站内交易提醒，您有一笔交易需要确认(T6)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, hebeixinda：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=58\" target=\"_blank\" class=\"t\"><strong>鑫大彩钢板</strong></a><br/>订单编号：<span class=\"f_red\">T6</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">200元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=6\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'hebeixinda', '1494557455', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('73', '站内交易提醒，您有一笔交易需要确认(T7)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, shandongpingyi：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=69\" target=\"_blank\" class=\"t\"><strong>安普AMP 超五类非屏蔽电缆6-219586-4 305米每箱</strong></a><br/>订单编号：<span class=\"f_red\">T7</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">22元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=7\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'shandongpingyi', '1494557902', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('74', '站内交易提醒，您有一笔交易需要确认(T8)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, laizhoujieli：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=63\" target=\"_blank\" class=\"t\"><strong>洁力优质地板</strong></a><br/>订单编号：<span class=\"f_red\">T8</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">200元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=8\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'laizhoujieli', '1494557902', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('75', '站内交易提醒，您有一笔交易需要确认(T9)', '', '4', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tctianyi.com/\" target=\"_blank\"><img src=\"http://www.tctianyi.com/file/upload/201701/04/230523441.png\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\nHi, zhongshanyayun：<br/>\r\n<a href=\"http://www.tctianyi.com/index.php?homepage=tianyi\" class=\"t\">tianyi</a> 于 <span class=\"f_gray\">2017-05-12</span> 向您订购了：<br/><a href=\"http://www.tctianyi.com/mall/show.php?itemid=55\" target=\"_blank\" class=\"t\"><strong>雅云PVC地板</strong></a><br/>订单编号：<span class=\"f_red\">T9</span> &nbsp;订单金额为：<span class=\"f_blue f_b\">200元</span><br/><a href=\"http://www.tctianyi.com/member/trade.php?itemid=9\" class=\"t\" target=\"_blank\">&raquo; 请点这里立即处理或查看详情</a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此信件系<a href=\"http://www.tctianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a>系统信使自动发送，请勿直接回复\r\n</td>\r\n</tr>\r\n</table>', '', 'zhongshanyayun', '1494557902', '127.0.0.1', '0', '0', '0', '3', '');
INSERT INTO `ty_message` VALUES ('76', '会员资料修改审核结果', '', '4', '尊敬的会员：<br/>您的会员资料修改已经审核，现将结果通知如下：<br/>所在地区 ---------- <span style=\"color:green;\">已通过</span><br/>', '', 'shandongpingyi', '1494661384', '127.0.0.1', '0', '0', '0', '3', '');

-- ----------------------------
-- Table structure for ty_mfrs
-- ----------------------------
DROP TABLE IF EXISTS `ty_mfrs`;
CREATE TABLE `ty_mfrs` (
  `mfrsname` varchar(150) NOT NULL DEFAULT '' COMMENT '产地',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ty_mfrs
-- ----------------------------
INSERT INTO `ty_mfrs` VALUES ('中国', '1', '1');
INSERT INTO `ty_mfrs` VALUES ('加拿大', '35', '35');

-- ----------------------------
-- Table structure for ty_module
-- ----------------------------
DROP TABLE IF EXISTS `ty_module`;
CREATE TABLE `ty_module` (
  `moduleid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `moduledir` varchar(20) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isblank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `logo` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `installtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='模型';

-- ----------------------------
-- Records of ty_module
-- ----------------------------
INSERT INTO `ty_module` VALUES ('1', 'destoon', '核心', '', 'http://demo.destoon.com/v6.0/', 'http://www.tctianyi.com/', '', '1', '0', '0', '0', '0', '0', '1467860142');
INSERT INTO `ty_module` VALUES ('2', 'member', '会员', 'member', '', 'http://www.tctianyi.com/member/', '', '2', '0', '0', '0', '0', '0', '1467860142');
INSERT INTO `ty_module` VALUES ('3', 'extend', '扩展', 'extend', '', 'http://www.tctianyi.com/extend/', '', '0', '0', '0', '0', '0', '0', '1467860142');
INSERT INTO `ty_module` VALUES ('4', 'company', '找品牌', 'company', '', 'http://www.tctianyi.com/company/', '', '7', '0', '1', '0', '0', '0', '1467860142');
INSERT INTO `ty_module` VALUES ('5', 'sell', '供应', 'sell', '', 'http://www.tctianyi.com/sell/', '', '5', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('6', 'buy', '求购', 'buy', '', 'http://www.tctianyi.com/buy/', '', '6', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('7', 'quote', '行情', 'quote', '', 'http://www.tctianyi.com/quote/', '', '9', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('8', 'exhibit', '展会', 'exhibit', '', 'http://www.tctianyi.com/exhibit/', '', '10', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('9', 'job', '工程', 'job', '', 'http://www.tctianyi.com/job/', '', '14', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('10', 'know', '交流', 'know', '', 'http://www.tctianyi.com/know/', '', '15', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('11', 'special', '专题', 'special', '', 'http://www.tianyi.com/special/', '', '16', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('12', 'photo', '图库', 'photo', '', 'http://www.tianyi.com/photo/', '', '17', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('13', 'brand', '品牌', 'brand', '', 'http://www.tctianyi.com/brand/', '', '13', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('14', 'video', '视频', 'video', '', 'http://www.tianyi.com/video/', '', '18', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('15', 'down', '下载', 'down', '', 'http://www.tianyi.com/down/', '', '19', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('16', 'mall', '产品', 'mall', '', 'http://www.tctianyi.com/mall/', '', '4', '0', '1', '0', '0', '0', '1467860142');
INSERT INTO `ty_module` VALUES ('17', 'group', '团购', 'group', '', 'http://www.tianyi.com/group/', '', '8', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('18', 'club', '商圈', 'club', '', 'http://www.tianyi.com/club/', '', '20', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('21', 'article', '俱乐部', 'news', '', 'http://www.tctianyi.com/news/', '', '11', '0', '1', '0', '0', '0', '1467860142');
INSERT INTO `ty_module` VALUES ('22', 'info', '招商', 'invest', '', 'http://www.tianyi.com/invest/', '', '12', '0', '1', '0', '0', '1', '1467860142');
INSERT INTO `ty_module` VALUES ('26', 'brand', '找施工', 'construction', '', 'http://www.tctianyi.com/construction/', '', '26', '0', '1', '0', '0', '0', '1494830557');

-- ----------------------------
-- Table structure for ty_news
-- ----------------------------
DROP TABLE IF EXISTS `ty_news`;
CREATE TABLE `ty_news` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司新闻';

-- ----------------------------
-- Records of ty_news
-- ----------------------------

-- ----------------------------
-- Table structure for ty_news_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_news_data`;
CREATE TABLE `ty_news_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司新闻内容';

-- ----------------------------
-- Records of ty_news_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_oauth
-- ----------------------------
DROP TABLE IF EXISTS `ty_oauth`;
CREATE TABLE `ty_oauth` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `site` varchar(30) NOT NULL DEFAULT '',
  `openid` varchar(255) NOT NULL DEFAULT '',
  `nickname` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `logintimes` int(10) unsigned NOT NULL DEFAULT '0',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `site` (`site`,`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='一键登录';

-- ----------------------------
-- Records of ty_oauth
-- ----------------------------

-- ----------------------------
-- Table structure for ty_online
-- ----------------------------
DROP TABLE IF EXISTS `ty_online`;
CREATE TABLE `ty_online` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='在线会员';

-- ----------------------------
-- Records of ty_online
-- ----------------------------
INSERT INTO `ty_online` VALUES ('1', 'tianyi', '127.0.0.1', '1', '1', '1494923927');
INSERT INTO `ty_online` VALUES ('14', 'shandongpingyi', '127.0.0.1', '2', '1', '1494923942');

-- ----------------------------
-- Table structure for ty_page
-- ----------------------------
DROP TABLE IF EXISTS `ty_page`;
CREATE TABLE `ty_page` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司单页';

-- ----------------------------
-- Records of ty_page
-- ----------------------------

-- ----------------------------
-- Table structure for ty_page_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_page_data`;
CREATE TABLE `ty_page_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司单页内容';

-- ----------------------------
-- Records of ty_page_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_photo_12
-- ----------------------------
DROP TABLE IF EXISTS `ty_photo_12`;
CREATE TABLE `ty_photo_12` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `open` tinyint(1) unsigned NOT NULL DEFAULT '3',
  `password` varchar(30) NOT NULL DEFAULT '',
  `question` varchar(30) NOT NULL DEFAULT '',
  `answer` varchar(30) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图库';

-- ----------------------------
-- Records of ty_photo_12
-- ----------------------------

-- ----------------------------
-- Table structure for ty_photo_data_12
-- ----------------------------
DROP TABLE IF EXISTS `ty_photo_data_12`;
CREATE TABLE `ty_photo_data_12` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图库内容';

-- ----------------------------
-- Records of ty_photo_data_12
-- ----------------------------

-- ----------------------------
-- Table structure for ty_photo_item_12
-- ----------------------------
DROP TABLE IF EXISTS `ty_photo_item_12`;
CREATE TABLE `ty_photo_item_12` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item` bigint(20) unsigned NOT NULL DEFAULT '0',
  `introduce` text NOT NULL,
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `listorder` (`listorder`),
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图库图片';

-- ----------------------------
-- Records of ty_photo_item_12
-- ----------------------------

-- ----------------------------
-- Table structure for ty_poll
-- ----------------------------
DROP TABLE IF EXISTS `ty_poll`;
CREATE TABLE `ty_poll` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `groupid` varchar(255) NOT NULL,
  `verify` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thumb_width` smallint(6) unsigned NOT NULL DEFAULT '0',
  `thumb_height` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll_max` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll_page` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll_cols` smallint(6) unsigned NOT NULL DEFAULT '0',
  `poll_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `polls` int(10) unsigned NOT NULL DEFAULT '0',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `template_poll` varchar(30) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='票选';

-- ----------------------------
-- Records of ty_poll
-- ----------------------------

-- ----------------------------
-- Table structure for ty_poll_item
-- ----------------------------
DROP TABLE IF EXISTS `ty_poll_item`;
CREATE TABLE `ty_poll_item` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pollid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `polls` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `pollid` (`pollid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='票选选项';

-- ----------------------------
-- Records of ty_poll_item
-- ----------------------------

-- ----------------------------
-- Table structure for ty_poll_record
-- ----------------------------
DROP TABLE IF EXISTS `ty_poll_record`;
CREATE TABLE `ty_poll_record` (
  `rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pollid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `polltime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='票选记录';

-- ----------------------------
-- Records of ty_poll_record
-- ----------------------------

-- ----------------------------
-- Table structure for ty_question
-- ----------------------------
DROP TABLE IF EXISTS `ty_question`;
CREATE TABLE `ty_question` (
  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='验证问题';

-- ----------------------------
-- Records of ty_question
-- ----------------------------
INSERT INTO `ty_question` VALUES ('1', '5+6=?', '11');
INSERT INTO `ty_question` VALUES ('2', '7+8=?', '15');
INSERT INTO `ty_question` VALUES ('3', '11*11=?', '121');
INSERT INTO `ty_question` VALUES ('4', '12-5=?', '7');
INSERT INTO `ty_question` VALUES ('5', '21-9=?', '12');

-- ----------------------------
-- Table structure for ty_quote
-- ----------------------------
DROP TABLE IF EXISTS `ty_quote`;
CREATE TABLE `ty_quote` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='行情';

-- ----------------------------
-- Records of ty_quote
-- ----------------------------

-- ----------------------------
-- Table structure for ty_quote_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_quote_data`;
CREATE TABLE `ty_quote_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='行情内容';

-- ----------------------------
-- Records of ty_quote_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_quote_price
-- ----------------------------
DROP TABLE IF EXISTS `ty_quote_price`;
CREATE TABLE `ty_quote_price` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `market` smallint(6) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL,
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `qq` varchar(20) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='行情报价';

-- ----------------------------
-- Records of ty_quote_price
-- ----------------------------

-- ----------------------------
-- Table structure for ty_quote_product
-- ----------------------------
DROP TABLE IF EXISTS `ty_quote_product`;
CREATE TABLE `ty_quote_product` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL,
  `minprice` decimal(10,2) unsigned NOT NULL,
  `maxprice` decimal(10,2) unsigned NOT NULL,
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(100) NOT NULL,
  `v2` varchar(100) NOT NULL,
  `v3` varchar(100) NOT NULL,
  `market` varchar(255) NOT NULL,
  `item` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `seo_title` varchar(255) NOT NULL,
  `seo_keywords` varchar(255) NOT NULL,
  `seo_description` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='行情产品';

-- ----------------------------
-- Records of ty_quote_product
-- ----------------------------

-- ----------------------------
-- Table structure for ty_resume
-- ----------------------------
DROP TABLE IF EXISTS `ty_resume`;
CREATE TABLE `ty_resume` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `age` smallint(2) unsigned NOT NULL DEFAULT '0',
  `marriage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `height` smallint(2) unsigned NOT NULL DEFAULT '0',
  `weight` smallint(2) unsigned NOT NULL DEFAULT '0',
  `education` smallint(2) unsigned NOT NULL DEFAULT '0',
  `school` varchar(100) NOT NULL DEFAULT '',
  `major` varchar(100) NOT NULL DEFAULT '',
  `skill` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(255) NOT NULL DEFAULT '',
  `minsalary` int(10) unsigned NOT NULL DEFAULT '0',
  `maxsalary` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `experience` smallint(2) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `situation` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `open` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='简历';

-- ----------------------------
-- Records of ty_resume
-- ----------------------------

-- ----------------------------
-- Table structure for ty_resume_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_resume_data`;
CREATE TABLE `ty_resume_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='简历内容';

-- ----------------------------
-- Records of ty_resume_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_sell_5
-- ----------------------------
DROP TABLE IF EXISTS `ty_sell_5`;
CREATE TABLE `ty_sell_5` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `mycatid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `n1` varchar(100) NOT NULL,
  `n2` varchar(100) NOT NULL,
  `n3` varchar(100) NOT NULL,
  `v1` varchar(100) NOT NULL,
  `v2` varchar(100) NOT NULL,
  `v3` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL DEFAULT '',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `minamount` float unsigned NOT NULL DEFAULT '0',
  `amount` float unsigned NOT NULL DEFAULT '0',
  `days` smallint(3) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `editdate` date NOT NULL DEFAULT '0000-00-00',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `adddate` date NOT NULL DEFAULT '0000-00-00',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `edittime` (`edittime`),
  KEY `catid` (`catid`),
  KEY `mycatid` (`mycatid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='供应';

-- ----------------------------
-- Records of ty_sell_5
-- ----------------------------

-- ----------------------------
-- Table structure for ty_sell_data_5
-- ----------------------------
DROP TABLE IF EXISTS `ty_sell_data_5`;
CREATE TABLE `ty_sell_data_5` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='供应内容';

-- ----------------------------
-- Records of ty_sell_data_5
-- ----------------------------

-- ----------------------------
-- Table structure for ty_sell_search_5
-- ----------------------------
DROP TABLE IF EXISTS `ty_sell_search_5`;
CREATE TABLE `ty_sell_search_5` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sorttime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='供应搜索';

-- ----------------------------
-- Records of ty_sell_search_5
-- ----------------------------

-- ----------------------------
-- Table structure for ty_session
-- ----------------------------
DROP TABLE IF EXISTS `ty_session`;
CREATE TABLE `ty_session` (
  `sessionid` varchar(32) NOT NULL DEFAULT '',
  `data` text NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `sessionid` (`sessionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SESSION';

-- ----------------------------
-- Records of ty_session
-- ----------------------------

-- ----------------------------
-- Table structure for ty_setting
-- ----------------------------
DROP TABLE IF EXISTS `ty_setting`;
CREATE TABLE `ty_setting` (
  `item` varchar(30) NOT NULL DEFAULT '',
  `item_key` varchar(100) NOT NULL DEFAULT '',
  `item_value` text NOT NULL,
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站设置';

-- ----------------------------
-- Records of ty_setting
-- ----------------------------
INSERT INTO `ty_setting` VALUES ('1', 'page_price', '12');
INSERT INTO `ty_setting` VALUES ('1', 'page_quote', '5');
INSERT INTO `ty_setting` VALUES ('1', 'page_mall', '10');
INSERT INTO `ty_setting` VALUES ('1', 'page_sell', '10');
INSERT INTO `ty_setting` VALUES ('1', 'page_com', '20');
INSERT INTO `ty_setting` VALUES ('1', 'page_trade', '10');
INSERT INTO `ty_setting` VALUES ('1', 'page_catalog', '1');
INSERT INTO `ty_setting` VALUES ('1', 'page_bigcat', '');
INSERT INTO `ty_setting` VALUES ('1', 'message_weixin', '0');
INSERT INTO `ty_setting` VALUES ('1', 'message_type', '1,2,3');
INSERT INTO `ty_setting` VALUES ('1', 'message_time', '60');
INSERT INTO `ty_setting` VALUES ('1', 'message_group', '6,7');
INSERT INTO `ty_setting` VALUES ('1', 'message_email', '0');
INSERT INTO `ty_setting` VALUES ('1', 'mail_log', '1');
INSERT INTO `ty_setting` VALUES ('1', 'mail_name', '天医工程网');
INSERT INTO `ty_setting` VALUES ('1', 'mail_sender', 'wangyidj@126.com');
INSERT INTO `ty_setting` VALUES ('1', 'mail_sign', 'sdf');
INSERT INTO `ty_setting` VALUES ('1', 'smtp_pass', 'deng02185714');
INSERT INTO `ty_setting` VALUES ('1', 'smtp_user', 'wangyidj@126.com');
INSERT INTO `ty_setting` VALUES ('1', 'smtp_auth', '1');
INSERT INTO `ty_setting` VALUES ('1', 'smtp_port', '25');
INSERT INTO `ty_setting` VALUES ('1', 'smtp_host', 'smtp.126.com');
INSERT INTO `ty_setting` VALUES ('1', 'mail_delimiter', '1');
INSERT INTO `ty_setting` VALUES ('1', 'mail_type', 'smtp');
INSERT INTO `ty_setting` VALUES ('1', 'max_image', '1024');
INSERT INTO `ty_setting` VALUES ('1', 'thumb_title', '0');
INSERT INTO `ty_setting` VALUES ('1', 'thumb_album', '1');
INSERT INTO `ty_setting` VALUES ('1', 'middle_h', '408');
INSERT INTO `ty_setting` VALUES ('1', 'middle_w', '408');
INSERT INTO `ty_setting` VALUES ('1', 'water_middle', '0');
INSERT INTO `ty_setting` VALUES ('1', 'water_com', '1');
INSERT INTO `ty_setting` VALUES ('1', 'gif_ani', '1');
INSERT INTO `ty_setting` VALUES ('1', 'bmp_jpg', '1');
INSERT INTO `ty_setting` VALUES ('1', 'water_pos', '9');
INSERT INTO `ty_setting` VALUES ('1', 'water_min_wh', '180');
INSERT INTO `ty_setting` VALUES ('1', 'water_margin', '10');
INSERT INTO `ty_setting` VALUES ('1', 'water_fontsize', '20');
INSERT INTO `ty_setting` VALUES ('1', 'water_fontcolor', '#000000');
INSERT INTO `ty_setting` VALUES ('2', 'ex_rate', '');
INSERT INTO `ty_setting` VALUES ('2', 'ex_fdnm', '');
INSERT INTO `ty_setting` VALUES ('2', 'ex_prex', '');
INSERT INTO `ty_setting` VALUES ('2', 'ex_data', '');
INSERT INTO `ty_setting` VALUES ('2', 'ex_pass', '');
INSERT INTO `ty_setting` VALUES ('2', 'ex_user', 'root');
INSERT INTO `ty_setting` VALUES ('2', 'ex_host', 'localhost');
INSERT INTO `ty_setting` VALUES ('2', 'ex_type', 'PW');
INSERT INTO `ty_setting` VALUES ('2', 'credit_exchange', '0');
INSERT INTO `ty_setting` VALUES ('2', 'credit_price', '5|10|45|85');
INSERT INTO `ty_setting` VALUES ('2', 'credit_buy', '30|100|500|1000');
INSERT INTO `ty_setting` VALUES ('2', 'credit_del_page', '5');
INSERT INTO `ty_setting` VALUES ('2', 'credit_add_page', '2');
INSERT INTO `ty_setting` VALUES ('2', 'credit_del_news', '5');
INSERT INTO `ty_setting` VALUES ('2', 'credit_add_news', '2');
INSERT INTO `ty_setting` VALUES ('2', 'credit_del_credit', '5');
INSERT INTO `ty_setting` VALUES ('2', 'credit_add_credit', '2');
INSERT INTO `ty_setting` VALUES ('2', 'credit_charge', '1');
INSERT INTO `ty_setting` VALUES ('2', 'credit_maxip', '50');
INSERT INTO `ty_setting` VALUES ('2', 'credit_ip', '2');
INSERT INTO `ty_setting` VALUES ('2', 'credit_less', '0');
INSERT INTO `ty_setting` VALUES ('2', 'credit_edit', '10');
INSERT INTO `ty_setting` VALUES ('2', 'credit_login', '1');
INSERT INTO `ty_setting` VALUES ('2', 'credit_user', '20');
INSERT INTO `ty_setting` VALUES ('2', 'send_types', '不需要物流|平邮|EMS|顺丰快递|申通E物流|圆通速递|中通速递|宅急送|韵达快运|天天快递|联邦快递|汇通快运|华强物流|其它');
INSERT INTO `ty_setting` VALUES ('2', 'pay_banks', '现金|网银在线|贝宝|支付宝|财付通|招商银行|中国工商银行|中国农业银行|中国建设银行|中国交通银行|中国银行|邮政储蓄|邮政汇款');
INSERT INTO `ty_setting` VALUES ('2', 'trade_day', '10');
INSERT INTO `ty_setting` VALUES ('2', 'deposit', '1000');
INSERT INTO `ty_setting` VALUES ('2', 'cash_fee_max', '50');
INSERT INTO `ty_setting` VALUES ('2', 'cash_fee', '1');
INSERT INTO `ty_setting` VALUES ('2', 'cash_fee_min', '1');
INSERT INTO `ty_setting` VALUES ('2', 'cash_times', '3');
INSERT INTO `ty_setting` VALUES ('2', 'cash_min', '50');
INSERT INTO `ty_setting` VALUES ('2', 'cash_max', '10000');
INSERT INTO `ty_setting` VALUES ('2', 'cash_banks', '招商银行|中国工商银行|中国农业银行|中国建设银行|中国交通银行|中国银行|邮政储蓄|贝宝|支付宝|财付通');
INSERT INTO `ty_setting` VALUES ('2', 'cash_enable', '1');
INSERT INTO `ty_setting` VALUES ('2', 'pay_url', '');
INSERT INTO `ty_setting` VALUES ('2', 'mincharge', '0');
INSERT INTO `ty_setting` VALUES ('2', 'pay_online', '1');
INSERT INTO `ty_setting` VALUES ('2', 'link_check', '2');
INSERT INTO `ty_setting` VALUES ('2', 'credit_clear', '0');
INSERT INTO `ty_setting` VALUES ('2', 'credit_save', '0');
INSERT INTO `ty_setting` VALUES ('2', 'credit_check', '2');
INSERT INTO `ty_setting` VALUES ('2', 'page_clear', '0');
INSERT INTO `ty_setting` VALUES ('2', 'page_save', '0');
INSERT INTO `ty_setting` VALUES ('2', 'page_check', '2');
INSERT INTO `ty_setting` VALUES ('2', 'news_clear', '0');
INSERT INTO `ty_setting` VALUES ('2', 'news_save', '0');
INSERT INTO `ty_setting` VALUES ('2', 'news_check', '2');
INSERT INTO `ty_setting` VALUES ('2', 'introduce_clear', '0');
INSERT INTO `ty_setting` VALUES ('2', 'introduce_save', '0');
INSERT INTO `ty_setting` VALUES ('2', 'introduce_length', '0');
INSERT INTO `ty_setting` VALUES ('2', 'thumb_height', '180');
INSERT INTO `ty_setting` VALUES ('2', 'cate_max', '6');
INSERT INTO `ty_setting` VALUES ('2', 'thumb_width', '180');
INSERT INTO `ty_setting` VALUES ('2', 'mode_max', '2');
INSERT INTO `ty_setting` VALUES ('2', 'com_mode', '制造商|贸易商|服务商|其他机构');
INSERT INTO `ty_setting` VALUES ('2', 'money_unit', '人民币|港元|台币|美元|欧元|英镑');
INSERT INTO `ty_setting` VALUES ('2', 'com_size', '1-49人|50-99人|100-499人|500-999人|1000-3000人|3000-5000人|5000-10000人|10000人以上');
INSERT INTO `ty_setting` VALUES ('2', 'com_type', '集体企业|联营企业|私营企业|股份合作企业|外商投资企业|中外合作经营企业|中外合资经营企业|港、澳、台商投资企业|合资经营企业(港或澳、台资)|合作经营企业(港或澳、台资)|港、澳、台商独资经营企业|港、澳、台商投资股份有限公司|有限责任公司|股份有限公司|外商投资股份有限公司|企业单位|事业单位或社会团体|其他企业');
INSERT INTO `ty_setting` VALUES ('2', 'login_goto', '0');
INSERT INTO `ty_setting` VALUES ('2', 'login_remember', '1');
INSERT INTO `ty_setting` VALUES ('2', 'captcha_login', '0');
INSERT INTO `ty_setting` VALUES ('2', 'show_menu', '1');
INSERT INTO `ty_setting` VALUES ('2', 'editor', 'Basic');
INSERT INTO `ty_setting` VALUES ('2', 'vfax', '');
INSERT INTO `ty_setting` VALUES ('2', 'vcompany', '1');
INSERT INTO `ty_setting` VALUES ('2', 'vbank', '1');
INSERT INTO `ty_setting` VALUES ('2', 'vtruename', '1');
INSERT INTO `ty_setting` VALUES ('2', 'vmobile', '1');
INSERT INTO `ty_setting` VALUES ('2', 'vemail', '1');
INSERT INTO `ty_setting` VALUES ('2', 'vmember', '1');
INSERT INTO `ty_setting` VALUES ('2', 'chat_img', '1');
INSERT INTO `ty_setting` VALUES ('2', 'chat_url', '1');
INSERT INTO `ty_setting` VALUES ('2', 'chat_ext', 'jpg|gif|png|rar|zip|pdf|doc|xls|ppt|docx|xlsx|pptx');
INSERT INTO `ty_setting` VALUES ('2', 'chat_file', '1');
INSERT INTO `ty_setting` VALUES ('2', 'chat_mintime', '3');
INSERT INTO `ty_setting` VALUES ('2', 'chat_poll', '3');
INSERT INTO `ty_setting` VALUES ('2', 'chat_timeout', '600');
INSERT INTO `ty_setting` VALUES ('2', 'chat_maxlen', '300');
INSERT INTO `ty_setting` VALUES ('2', 'alert_check', '2');
INSERT INTO `ty_setting` VALUES ('2', 'alertid', '5|6|22');
INSERT INTO `ty_setting` VALUES ('2', 'lock_hour', '1');
INSERT INTO `ty_setting` VALUES ('2', 'auth_days', '3');
INSERT INTO `ty_setting` VALUES ('2', 'login_times', '10');
INSERT INTO `ty_setting` VALUES ('2', 'maxtouser', '5');
INSERT INTO `ty_setting` VALUES ('2', 'captcha_sendmessage', '2');
INSERT INTO `ty_setting` VALUES ('2', 'edit_check', 'thumb,areaid,business,regyear,capital,address,telephone,content,register,readdress,reoffice,retime,legalPerson,mobilePhone');
INSERT INTO `ty_setting` VALUES ('2', 'usernote', '欢迎使用DESTOON B2B网站管理系统www.destoon.com');
INSERT INTO `ty_setting` VALUES ('2', 'iptimeout', '24');
INSERT INTO `ty_setting` VALUES ('2', 'banagent', '');
INSERT INTO `ty_setting` VALUES ('2', 'defend_proxy', '0');
INSERT INTO `ty_setting` VALUES ('2', 'sms_register', '0');
INSERT INTO `ty_setting` VALUES ('2', 'credit_register', '20');
INSERT INTO `ty_setting` VALUES ('2', 'money_register', '0');
INSERT INTO `ty_setting` VALUES ('2', 'question_register', '0');
INSERT INTO `ty_setting` VALUES ('2', 'welcome_sms', '1');
INSERT INTO `ty_setting` VALUES ('2', 'emailcode_register', '0');
INSERT INTO `ty_setting` VALUES ('2', 'mobilecode_register', '0');
INSERT INTO `ty_setting` VALUES ('2', 'captcha_register', '1');
INSERT INTO `ty_setting` VALUES ('2', 'welcome_email', '1');
INSERT INTO `ty_setting` VALUES ('2', 'welcome_message', '1');
INSERT INTO `ty_setting` VALUES ('2', 'checkuser', '0');
INSERT INTO `ty_setting` VALUES ('2', 'banemail', '');
INSERT INTO `ty_setting` VALUES ('2', 'banmodec', '0');
INSERT INTO `ty_setting` VALUES ('2', 'bancompany', '');
INSERT INTO `ty_setting` VALUES ('2', 'banmodeu', '0');
INSERT INTO `ty_setting` VALUES ('2', 'banusername', 'admin|system|master|web|sell|buy|company|quote|job|article|info|page|bbs|club');
INSERT INTO `ty_setting` VALUES ('2', 'maxpassword', '20');
INSERT INTO `ty_setting` VALUES ('2', 'minpassword', '6');
INSERT INTO `ty_setting` VALUES ('2', 'maxusername', '20');
INSERT INTO `ty_setting` VALUES ('2', 'minusername', '4');
INSERT INTO `ty_setting` VALUES ('2', 'enable_register', '1');
INSERT INTO `ty_setting` VALUES ('2', 'ex_name', '');
INSERT INTO `ty_setting` VALUES ('2', 'passport', '0');
INSERT INTO `ty_setting` VALUES ('2', 'passport_charset', 'gbk');
INSERT INTO `ty_setting` VALUES ('2', 'passport_url', '');
INSERT INTO `ty_setting` VALUES ('2', 'passport_key', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_api', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_ip', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_mysql', '1');
INSERT INTO `ty_setting` VALUES ('2', 'uc_dbhost', 'localhost');
INSERT INTO `ty_setting` VALUES ('2', 'uc_dbuser', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_dbpwd', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_dbname', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_dbpre', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_charset', 'utf8');
INSERT INTO `ty_setting` VALUES ('2', 'uc_appid', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_key', '');
INSERT INTO `ty_setting` VALUES ('2', 'uc_bbs', '1');
INSERT INTO `ty_setting` VALUES ('2', 'uc_bbspre', '');
INSERT INTO `ty_setting` VALUES ('2', 'oauth', '0');
INSERT INTO `ty_setting` VALUES ('2', 'module', 'member');
INSERT INTO `ty_setting` VALUES ('3', 'sitemaps_priority', '0.8');
INSERT INTO `ty_setting` VALUES ('3', 'sitemaps_changefreq', 'monthly');
INSERT INTO `ty_setting` VALUES ('3', 'sitemaps', '1');
INSERT INTO `ty_setting` VALUES ('3', 'feed_pagesize', '50');
INSERT INTO `ty_setting` VALUES ('3', 'feed_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'feed_enable', '2');
INSERT INTO `ty_setting` VALUES ('3', 'archiver_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'archiver_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'form_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'form_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'poll_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'poll_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'vote_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'gift_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'gift_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'vote_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'guestbook_captcha', '1');
INSERT INTO `ty_setting` VALUES ('3', 'guestbook_type', '业务合作|意见建议|使用问题|页面错误|不良信息|其他');
INSERT INTO `ty_setting` VALUES ('3', 'guestbook_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'guestbook_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'comment_am', '网友');
INSERT INTO `ty_setting` VALUES ('3', 'credit_del_comment', '5');
INSERT INTO `ty_setting` VALUES ('3', 'credit_add_comment', '2');
INSERT INTO `ty_setting` VALUES ('3', 'comment_limit', '30');
INSERT INTO `ty_setting` VALUES ('3', 'comment_pagesize', '10');
INSERT INTO `ty_setting` VALUES ('3', 'comment_time', '30');
INSERT INTO `ty_setting` VALUES ('3', 'comment_max', '500');
INSERT INTO `ty_setting` VALUES ('3', 'comment_min', '5');
INSERT INTO `ty_setting` VALUES ('3', 'comment_vote', '1');
INSERT INTO `ty_setting` VALUES ('3', 'comment_admin_del', '1');
INSERT INTO `ty_setting` VALUES ('3', 'comment_user_del', '4');
INSERT INTO `ty_setting` VALUES ('3', 'comment_captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('3', 'comment_check', '2');
INSERT INTO `ty_setting` VALUES ('3', 'comment_vote_group', '5,6,7');
INSERT INTO `ty_setting` VALUES ('3', 'comment_group', '5,6,7');
INSERT INTO `ty_setting` VALUES ('3', 'comment_show', '1');
INSERT INTO `ty_setting` VALUES ('3', 'comment_api_key', '');
INSERT INTO `ty_setting` VALUES ('3', 'comment_api_id', '');
INSERT INTO `ty_setting` VALUES ('3', 'comment_api', '');
INSERT INTO `ty_setting` VALUES ('3', 'comment_module', '5,6,4,7,8,21,22,13,9,11,12,14,15');
INSERT INTO `ty_setting` VALUES ('3', 'comment_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'link_request', '');
INSERT INTO `ty_setting` VALUES ('3', 'link_reg', '1');
INSERT INTO `ty_setting` VALUES ('3', 'link_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'link_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'announce_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'announce_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'ad_currency', 'money');
INSERT INTO `ty_setting` VALUES ('3', 'ad_buy', '1');
INSERT INTO `ty_setting` VALUES ('3', 'ad_view', '1');
INSERT INTO `ty_setting` VALUES ('3', 'ad_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'ad_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'spread_currency', 'money');
INSERT INTO `ty_setting` VALUES ('3', 'spread_list', '1');
INSERT INTO `ty_setting` VALUES ('3', 'spread_check', '1');
INSERT INTO `ty_setting` VALUES ('3', 'spread_max', '10');
INSERT INTO `ty_setting` VALUES ('3', 'spread_month', '6');
INSERT INTO `ty_setting` VALUES ('3', 'spread_step', '100');
INSERT INTO `ty_setting` VALUES ('3', 'spread_company_price', '500');
INSERT INTO `ty_setting` VALUES ('3', 'spread_buy_price', '500');
INSERT INTO `ty_setting` VALUES ('3', 'spread_sell_price', '500');
INSERT INTO `ty_setting` VALUES ('3', 'spread_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_goto', '1');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_pagesize', '30');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_sitename', '');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_pid', '14');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_domain', '');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_enable', '1');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_ajax', '1');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_ios', '');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_adr', '');
INSERT INTO `ty_setting` VALUES ('3', 'show_url', '0');
INSERT INTO `ty_setting` VALUES ('3', 'list_url', '0');
INSERT INTO `ty_setting` VALUES ('3', 'weixin', '');
INSERT INTO `ty_setting` VALUES ('3', 'oauth', '0');
INSERT INTO `ty_setting` VALUES ('3', 'sitemaps_module', '16,5,6,4,17,7,8,21,22,13,9,10,11,12,14,15,18');
INSERT INTO `ty_setting` VALUES ('3', 'sitemaps_update', '60');
INSERT INTO `ty_setting` VALUES ('3', 'sitemaps_items', '10000');
INSERT INTO `ty_setting` VALUES ('3', 'baidunews', '1');
INSERT INTO `ty_setting` VALUES ('3', 'baidunews_email', 'mail@yourdomain.com');
INSERT INTO `ty_setting` VALUES ('3', 'baidunews_update', '60');
INSERT INTO `ty_setting` VALUES ('3', 'baidunews_items', '90');
INSERT INTO `ty_setting` VALUES ('3', 'module', 'extend');
INSERT INTO `ty_setting` VALUES ('3', 'feed_url', 'http://www.tianyi.com/feed/');
INSERT INTO `ty_setting` VALUES ('3', 'archiver_url', 'http://www.tianyi.com/archiver/');
INSERT INTO `ty_setting` VALUES ('3', 'form_url', 'http://www.tianyi.com/form/');
INSERT INTO `ty_setting` VALUES ('3', 'poll_url', 'http://www.tianyi.com/poll/');
INSERT INTO `ty_setting` VALUES ('3', 'vote_url', 'http://www.tianyi.com/vote/');
INSERT INTO `ty_setting` VALUES ('3', 'gift_url', 'http://www.tianyi.com/gift/');
INSERT INTO `ty_setting` VALUES ('3', 'guestbook_url', 'http://www.tianyi.com/guestbook/');
INSERT INTO `ty_setting` VALUES ('3', 'comment_url', 'http://www.tianyi.com/comment/');
INSERT INTO `ty_setting` VALUES ('3', 'link_url', 'http://www.tianyi.com/link/');
INSERT INTO `ty_setting` VALUES ('3', 'announce_url', 'http://www.tianyi.com/announce/');
INSERT INTO `ty_setting` VALUES ('3', 'ad_url', 'http://www.tianyi.com/ad/');
INSERT INTO `ty_setting` VALUES ('3', 'spread_url', 'http://www.tianyi.com/spread/');
INSERT INTO `ty_setting` VALUES ('3', 'mobile_url', 'http://www.tianyi.com/mobile/');
INSERT INTO `ty_setting` VALUES ('26', 'linkurl', 'http://demo.destoon.com/v6.0/brand/');
INSERT INTO `ty_setting` VALUES ('26', 'domain', '');
INSERT INTO `ty_setting` VALUES ('26', 'ismenu', '1');
INSERT INTO `ty_setting` VALUES ('26', 'module', 'brand');
INSERT INTO `ty_setting` VALUES ('4', 'group_price', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('4', 'group_inquiry', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('4', 'group_message', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('4', 'group_buy', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('4', 'group_contact', '5,6,7');
INSERT INTO `ty_setting` VALUES ('4', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('4', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('4', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('4', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('4', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('4', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('4', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('4', 'seo_title_show', '{内容标题}{分类名称}{分类SEO标题}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('4', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('4', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('4', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('4', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('4', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('4', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('4', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('4', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('4', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('4', 'page_subcat', '6');
INSERT INTO `ty_setting` VALUES ('4', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('4', 'page_inew', '10');
INSERT INTO `ty_setting` VALUES ('4', 'page_inews', '10');
INSERT INTO `ty_setting` VALUES ('4', 'page_ivip', '10');
INSERT INTO `ty_setting` VALUES ('4', 'page_irec', '10');
INSERT INTO `ty_setting` VALUES ('4', 'level', '推荐公司');
INSERT INTO `ty_setting` VALUES ('4', 'map', 'baidu');
INSERT INTO `ty_setting` VALUES ('4', 'vip_honor', '1');
INSERT INTO `ty_setting` VALUES ('4', 'vip_maxyear', '5');
INSERT INTO `ty_setting` VALUES ('4', 'vip_year', '1');
INSERT INTO `ty_setting` VALUES ('4', 'vip_cominfo', '1');
INSERT INTO `ty_setting` VALUES ('4', 'vip_maxgroupvip', '3');
INSERT INTO `ty_setting` VALUES ('4', 'delvip', '1');
INSERT INTO `ty_setting` VALUES ('4', 'openall', '0');
INSERT INTO `ty_setting` VALUES ('4', 'homeurl', '0');
INSERT INTO `ty_setting` VALUES ('4', 'comment', '1');
INSERT INTO `ty_setting` VALUES ('4', 'split', '0');
INSERT INTO `ty_setting` VALUES ('4', 'order', 'vip desc,userid desc');
INSERT INTO `ty_setting` VALUES ('4', 'fields', 'userid,username,company,linkurl,thumb,catid,areaid,vip,groupid,validated,business,mode');
INSERT INTO `ty_setting` VALUES ('5', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('5', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('5', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('5', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('5', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('5', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('5', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('5', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('5', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('5', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('5', 'captcha_inquiry', '2');
INSERT INTO `ty_setting` VALUES ('5', 'question_inquiry', '2');
INSERT INTO `ty_setting` VALUES ('5', 'group_elite', '6,7');
INSERT INTO `ty_setting` VALUES ('5', 'group_compare', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('5', 'group_refresh', '7');
INSERT INTO `ty_setting` VALUES ('5', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('5', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('5', 'group_contact', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('5', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('5', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('5', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('5', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('5', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('5', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('5', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('5', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('5', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('5', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('5', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('5', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('5', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('5', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('5', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('5', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('5', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('5', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('5', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('5', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('5', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('5', 'page_subcat', '5');
INSERT INTO `ty_setting` VALUES ('5', 'max_width', '900');
INSERT INTO `ty_setting` VALUES ('5', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('5', 'upload_thumb', '0');
INSERT INTO `ty_setting` VALUES ('5', 'swfu', '2');
INSERT INTO `ty_setting` VALUES ('5', 'checkorder', '1');
INSERT INTO `ty_setting` VALUES ('5', 'level', '推荐信息');
INSERT INTO `ty_setting` VALUES ('5', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('5', 'sphinx_name', 'destoon,delta');
INSERT INTO `ty_setting` VALUES ('5', 'sphinx_port', '');
INSERT INTO `ty_setting` VALUES ('5', 'sphinx_host', '');
INSERT INTO `ty_setting` VALUES ('5', 'sphinx', '0');
INSERT INTO `ty_setting` VALUES ('5', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('5', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('5', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('5', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('5', 'split', '0');
INSERT INTO `ty_setting` VALUES ('5', 'inquiry_ask', '我对贵公司的产品非常感兴趣，能否发一些详细资料给我参考？|请您发一份比较详细的产品规格说明，谢谢！|请问贵公司产品是否可以代理？代理条件是什么？|我公司有意购买此产品，可否提供此产品的报价单和最小起订量？');
INSERT INTO `ty_setting` VALUES ('5', 'type', '供应|提供服务|供应二手|提供加工|提供合作|库存');
INSERT INTO `ty_setting` VALUES ('5', 'inquiry_type', '单价|产品规格|型号|价格条款|原产地|能否提供样品|最小订货量|交货期|供货能力|销售条款及附加条件|包装方式|质量/安全认证 ');
INSERT INTO `ty_setting` VALUES ('5', 'fields', 'itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,price,unit,minamount,amount');
INSERT INTO `ty_setting` VALUES ('5', 'order', 'editdate desc,vip desc,edittime desc');
INSERT INTO `ty_setting` VALUES ('5', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('5', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('5', 'thumb_height', '100');
INSERT INTO `ty_setting` VALUES ('5', 'thumb_width', '100');
INSERT INTO `ty_setting` VALUES ('5', 'template_inquiry', '');
INSERT INTO `ty_setting` VALUES ('5', 'template_compare', '');
INSERT INTO `ty_setting` VALUES ('5', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('5', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('5', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('5', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('5', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('5', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('5', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('5', 'credit_elite', '100');
INSERT INTO `ty_setting` VALUES ('5', 'credit_refresh', '1');
INSERT INTO `ty_setting` VALUES ('5', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('5', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('5', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('5', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('5', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('5', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('5', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('5', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('5', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('5', 'module', 'sell');
INSERT INTO `ty_setting` VALUES ('6', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('6', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('6', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('6', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('6', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('6', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('6', 'question_price', '2');
INSERT INTO `ty_setting` VALUES ('6', 'captcha_price', '2');
INSERT INTO `ty_setting` VALUES ('6', 'group_refresh', '7');
INSERT INTO `ty_setting` VALUES ('6', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('6', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('6', 'group_contact', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('6', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('6', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('6', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('6', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('6', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('6', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('6', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('6', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('6', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('6', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('6', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('6', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('6', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('6', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('6', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('6', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('6', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('6', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('6', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('6', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('6', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('6', 'page_subcat', '6');
INSERT INTO `ty_setting` VALUES ('6', 'max_width', '900');
INSERT INTO `ty_setting` VALUES ('6', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('6', 'level', '推荐信息');
INSERT INTO `ty_setting` VALUES ('6', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('6', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('6', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('6', 'split', '0');
INSERT INTO `ty_setting` VALUES ('6', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('6', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('6', 'type', '求购|紧急求购|求购二手|寻求加工|寻求合作|招标');
INSERT INTO `ty_setting` VALUES ('6', 'price_ask', '请您发一份比较详细的产品规格说明，谢谢！|请问您对此产品是长期有需求吗？|请问您对此产品有多大的需求量？');
INSERT INTO `ty_setting` VALUES ('6', 'fields', 'itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,price');
INSERT INTO `ty_setting` VALUES ('6', 'order', 'editdate desc,vip desc,edittime desc');
INSERT INTO `ty_setting` VALUES ('6', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('6', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('6', 'thumb_height', '100');
INSERT INTO `ty_setting` VALUES ('6', 'thumb_width', '100');
INSERT INTO `ty_setting` VALUES ('6', 'template_price', '');
INSERT INTO `ty_setting` VALUES ('6', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('6', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('6', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('6', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('6', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('6', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('6', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('6', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('6', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('6', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('6', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('6', 'credit_refresh', '1');
INSERT INTO `ty_setting` VALUES ('6', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('6', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('6', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('6', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('6', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('6', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('6', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('6', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('6', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('6', 'module', 'buy');
INSERT INTO `ty_setting` VALUES ('7', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('7', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('7', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('7', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('7', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('7', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('7', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('7', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('7', 'group_add_price', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('7', 'group_show_price', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('7', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('7', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('7', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('7', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('7', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('7', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('7', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('7', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('7', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('7', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('7', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('7', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('7', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('7', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('7', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('7', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('7', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('7', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('7', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('7', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('7', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('7', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('7', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('7', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('7', 'page_child', '5');
INSERT INTO `ty_setting` VALUES ('7', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('7', 'page_icat', '5');
INSERT INTO `ty_setting` VALUES ('7', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('7', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('7', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('7', 'split', '0');
INSERT INTO `ty_setting` VALUES ('7', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('7', 'level', '推荐行情|暂未指定|推荐图文|头条相关|头条推荐');
INSERT INTO `ty_setting` VALUES ('7', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('7', 'fields', 'itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username');
INSERT INTO `ty_setting` VALUES ('7', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('7', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('7', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('7', 'thumb_height', '90');
INSERT INTO `ty_setting` VALUES ('7', 'thumb_width', '120');
INSERT INTO `ty_setting` VALUES ('7', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('7', 'pre_view', '500');
INSERT INTO `ty_setting` VALUES ('7', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('7', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('7', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('7', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('7', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('7', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('7', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('7', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('7', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('7', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('7', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('7', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('7', 'module', 'quote');
INSERT INTO `ty_setting` VALUES ('8', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('8', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('8', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('8', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('8', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('8', 'captcha_sign', '2');
INSERT INTO `ty_setting` VALUES ('8', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('8', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('8', 'group_contact', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('8', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('8', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('8', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('8', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('8', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('8', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('8', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('8', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('8', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('8', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('8', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('8', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('8', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('8', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('8', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('8', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('8', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('8', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('8', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('8', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('8', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('8', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('8', 'pagesize', '10');
INSERT INTO `ty_setting` VALUES ('8', 'cat_hall_num', '2');
INSERT INTO `ty_setting` VALUES ('8', 'cat_hall', '0');
INSERT INTO `ty_setting` VALUES ('8', 'cat_service_num', '8');
INSERT INTO `ty_setting` VALUES ('8', 'cat_service', '0');
INSERT INTO `ty_setting` VALUES ('8', 'cat_news_num', '10');
INSERT INTO `ty_setting` VALUES ('8', 'page_icat', '10');
INSERT INTO `ty_setting` VALUES ('8', 'news_id', '21');
INSERT INTO `ty_setting` VALUES ('8', 'cat_news', '0');
INSERT INTO `ty_setting` VALUES ('8', 'page_islide', '3');
INSERT INTO `ty_setting` VALUES ('8', 'level', '推荐展会|展会幻灯');
INSERT INTO `ty_setting` VALUES ('8', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('8', 'split', '0');
INSERT INTO `ty_setting` VALUES ('8', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('8', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('8', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('8', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('8', 'fields', 'itemid,title,thumb,linkurl,style,catid,addtime,edittime,username,fromtime,totime,city,address,sponsor');
INSERT INTO `ty_setting` VALUES ('8', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('8', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('8', 'introduce_length', '0');
INSERT INTO `ty_setting` VALUES ('8', 'thumb_height', '100');
INSERT INTO `ty_setting` VALUES ('8', 'thumb_width', '100');
INSERT INTO `ty_setting` VALUES ('8', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('8', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('8', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('8', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('8', 'pre_view', '500');
INSERT INTO `ty_setting` VALUES ('8', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('8', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('8', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('8', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('8', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('8', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('8', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('8', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('8', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('8', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('8', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('8', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('8', 'module', 'exhibit');
INSERT INTO `ty_setting` VALUES ('9', 'check_add_resume', '2');
INSERT INTO `ty_setting` VALUES ('9', 'group_apply', '5');
INSERT INTO `ty_setting` VALUES ('9', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('9', 'group_contact', '5,6,7');
INSERT INTO `ty_setting` VALUES ('9', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('9', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('9', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('9', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('9', 'fee_view_resume', '0');
INSERT INTO `ty_setting` VALUES ('9', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('9', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('9', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('9', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('9', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('9', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('9', 'group_talent', '7');
INSERT INTO `ty_setting` VALUES ('9', 'group_search_resume', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('9', 'group_contact_resume', '7');
INSERT INTO `ty_setting` VALUES ('9', 'group_show_resume', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('9', 'group_refresh', '7');
INSERT INTO `ty_setting` VALUES ('9', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('9', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('9', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('9', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('9', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('9', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('9', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('9', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('9', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('9', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('9', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('9', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('9', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('9', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('9', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('9', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('9', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('9', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('9', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('9', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('9', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('9', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('9', 'page_iresume', '10');
INSERT INTO `ty_setting` VALUES ('9', 'page_ijob', '10');
INSERT INTO `ty_setting` VALUES ('9', 'level', '推荐');
INSERT INTO `ty_setting` VALUES ('9', 'split', '0');
INSERT INTO `ty_setting` VALUES ('9', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('9', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('9', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('9', 'situation', '目前正在找工作|观望有好机会再考虑|半年内无换工作计划');
INSERT INTO `ty_setting` VALUES ('9', 'education', '不限|初中|高中|大专|本科|硕士|博士');
INSERT INTO `ty_setting` VALUES ('9', 'marriage', '不限|未婚|已婚');
INSERT INTO `ty_setting` VALUES ('9', 'gender', '不限|男士|女士');
INSERT INTO `ty_setting` VALUES ('9', 'type', '不限|全职|兼职|实习');
INSERT INTO `ty_setting` VALUES ('9', 'order', 'editdate desc,vip desc,edittime desc');
INSERT INTO `ty_setting` VALUES ('9', 'fields', 'itemid,title,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,minsalary,maxsalary');
INSERT INTO `ty_setting` VALUES ('9', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('9', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('9', 'thumb_height', '140');
INSERT INTO `ty_setting` VALUES ('9', 'thumb_width', '100');
INSERT INTO `ty_setting` VALUES ('9', 'captcha_add_resume', '2');
INSERT INTO `ty_setting` VALUES ('9', 'question_add_resume', '2');
INSERT INTO `ty_setting` VALUES ('9', 'fee_add_resume', '0');
INSERT INTO `ty_setting` VALUES ('9', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('9', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('9', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('9', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('9', 'credit_refresh', '1');
INSERT INTO `ty_setting` VALUES ('9', 'credit_add_resume', '2');
INSERT INTO `ty_setting` VALUES ('9', 'credit_del_resume', '5');
INSERT INTO `ty_setting` VALUES ('9', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('9', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('9', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('9', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('9', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('9', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('9', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('9', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('9', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('9', 'module', 'job');
INSERT INTO `ty_setting` VALUES ('10', 'credit_answer', '2');
INSERT INTO `ty_setting` VALUES ('10', 'credit_best', '20');
INSERT INTO `ty_setting` VALUES ('10', 'credit_hidden', '10');
INSERT INTO `ty_setting` VALUES ('10', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('10', 'credit_del', '20');
INSERT INTO `ty_setting` VALUES ('10', 'credit_add', '0');
INSERT INTO `ty_setting` VALUES ('10', 'pre_view', '500');
INSERT INTO `ty_setting` VALUES ('10', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('10', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('10', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('10', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('10', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('10', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('10', 'question_answer', '2');
INSERT INTO `ty_setting` VALUES ('10', 'captcha_answer', '2');
INSERT INTO `ty_setting` VALUES ('10', 'check_answer', '2');
INSERT INTO `ty_setting` VALUES ('10', 'group_vote', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('10', 'group_answer', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('10', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('10', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('10', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('10', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('10', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('10', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('10', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('10', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('10', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('10', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('10', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('10', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('10', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('10', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('10', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('10', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('10', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('10', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('10', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('10', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('10', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('10', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('10', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('10', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('10', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('10', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('10', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('10', 'answer_pagesize', '10');
INSERT INTO `ty_setting` VALUES ('10', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('10', 'page_iexpert', '2');
INSERT INTO `ty_setting` VALUES ('10', 'page_iresolve', '8');
INSERT INTO `ty_setting` VALUES ('10', 'page_ivote', '8');
INSERT INTO `ty_setting` VALUES ('10', 'page_isolve', '8');
INSERT INTO `ty_setting` VALUES ('10', 'page_irec', '8');
INSERT INTO `ty_setting` VALUES ('10', 'messagedays', '14');
INSERT INTO `ty_setting` VALUES ('10', 'highcredit', '20');
INSERT INTO `ty_setting` VALUES ('10', 'raisecredit', '20');
INSERT INTO `ty_setting` VALUES ('10', 'raisedays', '3');
INSERT INTO `ty_setting` VALUES ('10', 'maxraise', '2');
INSERT INTO `ty_setting` VALUES ('10', 'overdays', '15');
INSERT INTO `ty_setting` VALUES ('10', 'votedays', '5');
INSERT INTO `ty_setting` VALUES ('10', 'minvote', '3');
INSERT INTO `ty_setting` VALUES ('10', 'answer_message', '1');
INSERT INTO `ty_setting` VALUES ('10', 'credits', '0|5|10|15|20|30|50|80|100');
INSERT INTO `ty_setting` VALUES ('10', 'level', '精彩推荐');
INSERT INTO `ty_setting` VALUES ('10', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('10', 'split', '0');
INSERT INTO `ty_setting` VALUES ('10', 'keylink', '1');
INSERT INTO `ty_setting` VALUES ('10', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('10', 'clear_alink', '1');
INSERT INTO `ty_setting` VALUES ('10', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('10', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('10', 'fields', 'itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,passport,answer,process,credit');
INSERT INTO `ty_setting` VALUES ('10', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('10', 'editor', 'Simple');
INSERT INTO `ty_setting` VALUES ('10', 'introduce_length', '0');
INSERT INTO `ty_setting` VALUES ('10', 'thumb_height', '90');
INSERT INTO `ty_setting` VALUES ('10', 'thumb_width', '120');
INSERT INTO `ty_setting` VALUES ('10', 'credit_maxanswer', '50');
INSERT INTO `ty_setting` VALUES ('10', 'credit_vote', '1');
INSERT INTO `ty_setting` VALUES ('10', 'credit_maxvote', '30');
INSERT INTO `ty_setting` VALUES ('10', 'credit_del_answer', '5');
INSERT INTO `ty_setting` VALUES ('10', 'credit_deal', '20');
INSERT INTO `ty_setting` VALUES ('10', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('10', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('10', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('10', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('10', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('10', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('10', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('10', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('10', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('10', 'module', 'know');
INSERT INTO `ty_setting` VALUES ('11', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('11', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('11', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('11', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('11', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('11', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('11', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('11', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('11', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('11', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('11', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('11', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('11', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('11', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('11', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('11', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('11', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('11', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('11', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('11', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('11', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('11', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('11', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('11', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('11', 'page_icat', '8');
INSERT INTO `ty_setting` VALUES ('11', 'level_item', '推荐信息|幻灯图片|推荐图文|头条相关|头条推荐|视频报道');
INSERT INTO `ty_setting` VALUES ('11', 'level', '推荐专题|暂未指定|推荐图文|头条相关|头条推荐');
INSERT INTO `ty_setting` VALUES ('11', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('11', 'split', '0');
INSERT INTO `ty_setting` VALUES ('11', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('11', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('11', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('11', 'fields', 'itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime');
INSERT INTO `ty_setting` VALUES ('11', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('11', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('11', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('11', 'banner_height', '200');
INSERT INTO `ty_setting` VALUES ('11', 'banner_width', '960');
INSERT INTO `ty_setting` VALUES ('11', 'thumb_height', '90');
INSERT INTO `ty_setting` VALUES ('11', 'thumb_width', '120');
INSERT INTO `ty_setting` VALUES ('11', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('11', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('11', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('11', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('11', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('11', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('11', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('11', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('11', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('11', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('11', 'module', 'special');
INSERT INTO `ty_setting` VALUES ('12', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('12', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('12', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('12', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('12', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('12', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('12', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('12', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('12', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('12', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('12', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('12', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('12', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('12', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('12', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('12', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('12', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('12', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('12', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('12', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('12', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('12', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('12', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('12', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('12', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('12', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('12', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('12', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('12', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('12', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('12', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('12', 'swfu_max', '20');
INSERT INTO `ty_setting` VALUES ('12', 'max_width', '800');
INSERT INTO `ty_setting` VALUES ('12', 'pagesize', '18');
INSERT INTO `ty_setting` VALUES ('12', 'page_irec', '4');
INSERT INTO `ty_setting` VALUES ('12', 'page_icat', '2');
INSERT INTO `ty_setting` VALUES ('12', 'page_islide', '3');
INSERT INTO `ty_setting` VALUES ('12', 'level', '推荐图库|幻灯图片|推荐图文|头条相关|头条推荐');
INSERT INTO `ty_setting` VALUES ('12', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('12', 'split', '0');
INSERT INTO `ty_setting` VALUES ('12', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('12', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('12', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('12', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('12', 'fields', 'itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,items,open');
INSERT INTO `ty_setting` VALUES ('12', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('12', 'editor', 'Simple');
INSERT INTO `ty_setting` VALUES ('12', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('12', 'maxitem', '30');
INSERT INTO `ty_setting` VALUES ('12', 'thumb_height', '90');
INSERT INTO `ty_setting` VALUES ('12', 'thumb_width', '120');
INSERT INTO `ty_setting` VALUES ('12', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('12', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('12', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('12', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('12', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('12', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('12', 'pre_view', '500');
INSERT INTO `ty_setting` VALUES ('12', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('12', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('12', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('12', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('12', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('12', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('12', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('12', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('12', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('12', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('12', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('12', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('12', 'module', 'photo');
INSERT INTO `ty_setting` VALUES ('13', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('13', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('13', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('13', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('13', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('13', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('13', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('13', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('13', 'question_message', '2');
INSERT INTO `ty_setting` VALUES ('13', 'captcha_message', '2');
INSERT INTO `ty_setting` VALUES ('13', 'group_refresh', '7');
INSERT INTO `ty_setting` VALUES ('13', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('13', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('13', 'group_contact', '6,7');
INSERT INTO `ty_setting` VALUES ('13', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('13', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('13', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('13', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('13', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('13', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('13', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('13', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('13', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('13', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('13', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('13', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('13', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('13', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('13', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('13', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('13', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('13', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('13', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('13', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('13', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('13', 'page_subcat', '6');
INSERT INTO `ty_setting` VALUES ('13', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('13', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('13', 'page_icat', '6');
INSERT INTO `ty_setting` VALUES ('13', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('13', 'split', '0');
INSERT INTO `ty_setting` VALUES ('13', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('13', 'level', '推荐品牌');
INSERT INTO `ty_setting` VALUES ('13', 'page_irec', '20');
INSERT INTO `ty_setting` VALUES ('13', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('13', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('13', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('13', 'message_ask', '请问我这个地方有加盟商了吗？|我想加盟，请来电话告诉我具体细节。|初步打算加盟贵公司，请寄资料。|请问贵公司哪里有样板店或直营店？|想了解加盟细节，请尽快寄一份资料。 ');
INSERT INTO `ty_setting` VALUES ('13', 'fields', 'itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated');
INSERT INTO `ty_setting` VALUES ('13', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('13', 'order', 'editdate desc,vip desc,edittime desc');
INSERT INTO `ty_setting` VALUES ('13', 'thumb_height', '60');
INSERT INTO `ty_setting` VALUES ('13', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('13', 'thumb_width', '180');
INSERT INTO `ty_setting` VALUES ('13', 'template_message', '');
INSERT INTO `ty_setting` VALUES ('13', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('13', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('13', 'template_product', '');
INSERT INTO `ty_setting` VALUES ('13', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('13', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('13', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('13', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('13', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('13', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('13', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('13', 'credit_refresh', '1');
INSERT INTO `ty_setting` VALUES ('13', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('13', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('13', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('13', 'keywords_index', '{$seo_modulename}{$seo_sitename}{$seo_sitetitle}');
INSERT INTO `ty_setting` VALUES ('13', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('13', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('13', 'description_index', '{$seo_modulename}{$seo_sitename}{$seo_sitetitle}');
INSERT INTO `ty_setting` VALUES ('13', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('13', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('13', 'module', 'brand');
INSERT INTO `ty_setting` VALUES ('14', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('14', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('14', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('14', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('14', 'question_message', '2');
INSERT INTO `ty_setting` VALUES ('14', 'captcha_message', '2');
INSERT INTO `ty_setting` VALUES ('14', 'group_upload', '6,7');
INSERT INTO `ty_setting` VALUES ('14', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('14', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('14', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('14', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('14', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('14', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('14', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('14', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('14', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('14', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('14', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('14', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('14', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('14', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('14', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('14', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('14', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('14', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('14', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('14', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('14', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('14', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('14', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('14', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('14', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('14', 'page_icat', '4');
INSERT INTO `ty_setting` VALUES ('14', 'page_irec', '8');
INSERT INTO `ty_setting` VALUES ('14', 'swfu', '1');
INSERT INTO `ty_setting` VALUES ('14', 'flvstart', '');
INSERT INTO `ty_setting` VALUES ('14', 'flvend', '');
INSERT INTO `ty_setting` VALUES ('14', 'upload', 'mp4|flv|wmv');
INSERT INTO `ty_setting` VALUES ('14', 'flvlink', '');
INSERT INTO `ty_setting` VALUES ('14', 'flvmargin', '10 auto auto 10');
INSERT INTO `ty_setting` VALUES ('14', 'flvlogo', 'video.png');
INSERT INTO `ty_setting` VALUES ('14', 'autostart', '1');
INSERT INTO `ty_setting` VALUES ('14', 'player', 'FlashPlayer|MediaPlayer|RealPlayer');
INSERT INTO `ty_setting` VALUES ('14', 'level', '推荐视频');
INSERT INTO `ty_setting` VALUES ('14', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('14', 'split', '0');
INSERT INTO `ty_setting` VALUES ('14', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('14', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('14', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('14', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('14', 'fields', 'itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,hits');
INSERT INTO `ty_setting` VALUES ('14', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('14', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('14', 'video_width', '480');
INSERT INTO `ty_setting` VALUES ('14', 'video_height', '400');
INSERT INTO `ty_setting` VALUES ('14', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('14', 'thumb_height', '90');
INSERT INTO `ty_setting` VALUES ('14', 'thumb_width', '120');
INSERT INTO `ty_setting` VALUES ('14', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('14', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('14', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('14', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('14', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('14', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('14', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('14', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('14', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('14', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('14', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('14', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('14', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('14', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('14', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('14', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('14', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('14', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('14', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('14', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('14', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('14', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('14', 'module', 'video');
INSERT INTO `ty_setting` VALUES ('15', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('15', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('15', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('15', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('15', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('15', 'question_message', '2');
INSERT INTO `ty_setting` VALUES ('15', 'captcha_message', '2');
INSERT INTO `ty_setting` VALUES ('15', 'group_upload', '6,7');
INSERT INTO `ty_setting` VALUES ('15', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('15', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('15', 'group_contact', '5,6,7');
INSERT INTO `ty_setting` VALUES ('15', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('15', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('15', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('15', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('15', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('15', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('15', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('15', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('15', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('15', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('15', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('15', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('15', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('15', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('15', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('15', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('15', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('15', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('15', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('15', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('15', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('15', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('15', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('15', 'page_icat', '10');
INSERT INTO `ty_setting` VALUES ('15', 'page_irec', '8');
INSERT INTO `ty_setting` VALUES ('15', 'swfu', '0');
INSERT INTO `ty_setting` VALUES ('15', 'upload', 'rar|zip|pdf|jpg|gif|png|doc|ppt|xls|docx|pptx|xlsx');
INSERT INTO `ty_setting` VALUES ('15', 'readsize', '10');
INSERT INTO `ty_setting` VALUES ('15', 'level', '推荐下载');
INSERT INTO `ty_setting` VALUES ('15', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('15', 'split', '0');
INSERT INTO `ty_setting` VALUES ('15', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('15', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('15', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('15', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('15', 'fields', 'itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,fileext,filesize,unit');
INSERT INTO `ty_setting` VALUES ('15', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('15', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('15', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('15', 'thumb_height', '90');
INSERT INTO `ty_setting` VALUES ('15', 'thumb_width', '120');
INSERT INTO `ty_setting` VALUES ('15', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('15', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('15', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('15', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('15', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('15', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('15', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('15', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('15', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('15', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('15', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('15', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('15', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('15', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('15', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('15', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('15', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('15', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('15', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('15', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('15', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('15', 'module', 'down');
INSERT INTO `ty_setting` VALUES ('16', 'credit_refresh', '1');
INSERT INTO `ty_setting` VALUES ('16', 'credit_elite', '100');
INSERT INTO `ty_setting` VALUES ('16', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('16', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('16', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('16', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('16', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('16', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('16', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('16', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('16', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('16', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('16', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('16', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('16', 'question_inquiry', '2');
INSERT INTO `ty_setting` VALUES ('16', 'captcha_inquiry', '2');
INSERT INTO `ty_setting` VALUES ('16', 'group_elite', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('16', 'group_compare', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('16', 'group_refresh', '7');
INSERT INTO `ty_setting` VALUES ('16', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('16', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('16', 'group_contact', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('16', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('16', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('16', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('16', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('16', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('16', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('16', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('16', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('16', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('16', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('16', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('16', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('16', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('16', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('16', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('16', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('16', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('16', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('16', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('16', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('16', 'index_html', '1');
INSERT INTO `ty_setting` VALUES ('16', 'page_subcat', '5');
INSERT INTO `ty_setting` VALUES ('16', 'max_width', '900');
INSERT INTO `ty_setting` VALUES ('16', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('16', 'checkorder', '1');
INSERT INTO `ty_setting` VALUES ('16', 'max_cart', '30');
INSERT INTO `ty_setting` VALUES ('16', 'page_irec', '5');
INSERT INTO `ty_setting` VALUES ('16', 'page_inew', '12');
INSERT INTO `ty_setting` VALUES ('16', 'swfu', '2');
INSERT INTO `ty_setting` VALUES ('16', 'level', '推荐商品');
INSERT INTO `ty_setting` VALUES ('16', 'split', '0');
INSERT INTO `ty_setting` VALUES ('16', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('16', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('16', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('16', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('16', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('16', 'fields', 'itemid,title,thumb,linkurl,style,catid,areaid,brand,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,price,amount,orders,comments');
INSERT INTO `ty_setting` VALUES ('16', 'order', 'editdate desc,vip desc,edittime desc');
INSERT INTO `ty_setting` VALUES ('16', 'thumb_height', '100');
INSERT INTO `ty_setting` VALUES ('16', 'introduce_length', '0');
INSERT INTO `ty_setting` VALUES ('16', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('16', 'thumb_width', '100');
INSERT INTO `ty_setting` VALUES ('17', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('17', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('17', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('17', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('17', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('17', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('17', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('17', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('17', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('17', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('17', 'question_inquiry', '2');
INSERT INTO `ty_setting` VALUES ('17', 'captcha_inquiry', '2');
INSERT INTO `ty_setting` VALUES ('17', 'group_refresh', '7');
INSERT INTO `ty_setting` VALUES ('17', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('17', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('17', 'group_contact', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('17', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('17', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('17', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('17', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('17', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('17', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('17', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('17', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('17', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('17', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('17', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('17', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('17', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('17', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('17', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('17', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('17', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('17', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('17', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('17', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('17', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('17', 'page_subcat', '9');
INSERT INTO `ty_setting` VALUES ('17', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('17', 'pagesize', '9');
INSERT INTO `ty_setting` VALUES ('17', 'swfu', '2');
INSERT INTO `ty_setting` VALUES ('17', 'level', '推荐团购');
INSERT INTO `ty_setting` VALUES ('17', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('17', 'split', '0');
INSERT INTO `ty_setting` VALUES ('17', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('17', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('17', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('17', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('17', 'fields', 'itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,price,marketprice,savemoney,discount,sales,orders,minamount,amount');
INSERT INTO `ty_setting` VALUES ('17', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('17', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('17', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('17', 'thumb_height', '300');
INSERT INTO `ty_setting` VALUES ('17', 'thumb_width', '400');
INSERT INTO `ty_setting` VALUES ('17', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('17', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('17', 'credit_refresh', '1');
INSERT INTO `ty_setting` VALUES ('17', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('17', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('17', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('17', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('17', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('17', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('17', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('17', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('17', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('17', 'module', 'group');
INSERT INTO `ty_setting` VALUES ('18', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('18', 'credit_level', '10');
INSERT INTO `ty_setting` VALUES ('18', 'credit_add', '3');
INSERT INTO `ty_setting` VALUES ('18', 'pre_view', '5');
INSERT INTO `ty_setting` VALUES ('18', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('18', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('18', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('18', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('18', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('18', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('18', 'question_reply', '2');
INSERT INTO `ty_setting` VALUES ('18', 'captcha_reply', '2');
INSERT INTO `ty_setting` VALUES ('18', 'check_reply', '2');
INSERT INTO `ty_setting` VALUES ('18', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('18', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('18', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('18', 'question_group', '2');
INSERT INTO `ty_setting` VALUES ('18', 'captcha_group', '2');
INSERT INTO `ty_setting` VALUES ('18', 'check_group', '2');
INSERT INTO `ty_setting` VALUES ('18', 'group_reply', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('18', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('18', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('18', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('18', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('18', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('18', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('18', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('18', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('18', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('18', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('18', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('18', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('18', 'seo_name', '圈');
INSERT INTO `ty_setting` VALUES ('18', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('18', 'htm_item_urlid', '4');
INSERT INTO `ty_setting` VALUES ('18', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('18', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('18', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('18', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('18', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('18', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('18', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('18', 'max_width', '750');
INSERT INTO `ty_setting` VALUES ('18', 'reply_pagesize', '10');
INSERT INTO `ty_setting` VALUES ('18', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('18', 'maxontop', '5');
INSERT INTO `ty_setting` VALUES ('18', 'manage_reason', '1');
INSERT INTO `ty_setting` VALUES ('18', 'manage_message', '1');
INSERT INTO `ty_setting` VALUES ('18', 'page_icat', '8');
INSERT INTO `ty_setting` VALUES ('18', 'page_islide', '3');
INSERT INTO `ty_setting` VALUES ('18', 'floor', '沙发|藤椅|板凳|马扎|地板');
INSERT INTO `ty_setting` VALUES ('18', 'manage_reasons', '广告/SPAM|恶意灌水|违规内容|文不对题|重复发帖|我很赞同|精品文章|原创内容|感谢分享');
INSERT INTO `ty_setting` VALUES ('18', 'swfu', '2');
INSERT INTO `ty_setting` VALUES ('18', 'level', '精华1|精华2');
INSERT INTO `ty_setting` VALUES ('18', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('18', 'split', '0');
INSERT INTO `ty_setting` VALUES ('18', 'keylink', '1');
INSERT INTO `ty_setting` VALUES ('18', 'clear_alink', '1');
INSERT INTO `ty_setting` VALUES ('18', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('18', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('18', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('18', 'fields', 'itemid,title,ontop,video,level,thumb,linkurl,style,catid,introduce,hits,addtime,edittime,username,reply,replyer,replytime ');
INSERT INTO `ty_setting` VALUES ('18', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('18', 'editor', 'Simple');
INSERT INTO `ty_setting` VALUES ('18', 'introduce_length', '0');
INSERT INTO `ty_setting` VALUES ('18', 'thumb_height', '90');
INSERT INTO `ty_setting` VALUES ('18', 'thumb_width', '120');
INSERT INTO `ty_setting` VALUES ('18', 'credit_reply', '1');
INSERT INTO `ty_setting` VALUES ('18', 'credit_del_reply', '2');
INSERT INTO `ty_setting` VALUES ('18', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('18', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('18', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('18', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('18', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('18', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('18', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('18', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('18', 'module', 'club');
INSERT INTO `ty_setting` VALUES ('21', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('21', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('21', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('21', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('21', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('21', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('21', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('21', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('21', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('21', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('21', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('21', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('21', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('21', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('21', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('21', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('21', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('21', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('21', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('21', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('21', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('21', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('21', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('21', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('21', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('21', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('21', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('21', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('21', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('21', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('21', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('21', 'show_np', '1');
INSERT INTO `ty_setting` VALUES ('21', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('21', 'page_shits', '10');
INSERT INTO `ty_setting` VALUES ('21', 'page_srec', '10');
INSERT INTO `ty_setting` VALUES ('21', 'page_srecimg', '4');
INSERT INTO `ty_setting` VALUES ('21', 'page_srelate', '10');
INSERT INTO `ty_setting` VALUES ('21', 'page_lhits', '10');
INSERT INTO `ty_setting` VALUES ('21', 'page_lrec', '10');
INSERT INTO `ty_setting` VALUES ('21', 'page_lrecimg', '4');
INSERT INTO `ty_setting` VALUES ('21', 'show_lcat', '1');
INSERT INTO `ty_setting` VALUES ('21', 'page_child', '6');
INSERT INTO `ty_setting` VALUES ('21', 'pagesize', '5');
INSERT INTO `ty_setting` VALUES ('21', 'page_ihits', '10');
INSERT INTO `ty_setting` VALUES ('21', 'page_irecimg', '6');
INSERT INTO `ty_setting` VALUES ('21', 'page_icat', '6');
INSERT INTO `ty_setting` VALUES ('21', 'show_icat', '1');
INSERT INTO `ty_setting` VALUES ('21', 'page_islide', '3');
INSERT INTO `ty_setting` VALUES ('21', 'swfu', '2');
INSERT INTO `ty_setting` VALUES ('21', 'level', '推荐文章|头条推荐|');
INSERT INTO `ty_setting` VALUES ('21', 'fulltext', '1');
INSERT INTO `ty_setting` VALUES ('21', 'split', '0');
INSERT INTO `ty_setting` VALUES ('21', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('21', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('21', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('21', 'keylink', '1');
INSERT INTO `ty_setting` VALUES ('22', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('22', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('22', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('22', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('22', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('22', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('22', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('22', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('22', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('22', 'question_message', '2');
INSERT INTO `ty_setting` VALUES ('22', 'captcha_message', '2');
INSERT INTO `ty_setting` VALUES ('22', 'group_refresh', '7');
INSERT INTO `ty_setting` VALUES ('22', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('22', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('22', 'group_contact', '6,7');
INSERT INTO `ty_setting` VALUES ('22', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('22', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('22', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('22', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('22', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('22', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('22', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('22', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('22', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('22', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('22', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('22', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('22', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('22', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('22', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('22', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('22', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('22', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('22', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('22', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('22', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('22', 'page_subcat', '5');
INSERT INTO `ty_setting` VALUES ('22', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('22', 'page_srelate', '10');
INSERT INTO `ty_setting` VALUES ('22', 'show_message', '1');
INSERT INTO `ty_setting` VALUES ('22', 'page_lkw', '10');
INSERT INTO `ty_setting` VALUES ('22', 'show_larea', '1');
INSERT INTO `ty_setting` VALUES ('22', 'show_lcat', '1');
INSERT INTO `ty_setting` VALUES ('22', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('22', 'page_ihits', '10');
INSERT INTO `ty_setting` VALUES ('22', 'show_iarea', '1');
INSERT INTO `ty_setting` VALUES ('22', 'show_icat', '1');
INSERT INTO `ty_setting` VALUES ('22', 'page_icat', '8');
INSERT INTO `ty_setting` VALUES ('22', 'page_irec', '8');
INSERT INTO `ty_setting` VALUES ('22', 'swfu', '2');
INSERT INTO `ty_setting` VALUES ('22', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('22', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('22', 'split', '0');
INSERT INTO `ty_setting` VALUES ('22', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('22', 'level', '推荐信息');
INSERT INTO `ty_setting` VALUES ('22', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('22', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('22', 'message_ask', '请问我这个地方有加盟商了吗？|我想加盟，请来电话告诉我具体细节。|初步打算加盟贵公司，请寄资料。|请问贵公司哪里有样板店或直营店？|想了解加盟细节，请尽快寄一份资料。 ');
INSERT INTO `ty_setting` VALUES ('22', 'order', 'edittime desc');
INSERT INTO `ty_setting` VALUES ('22', 'fields', 'itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,islink');
INSERT INTO `ty_setting` VALUES ('22', 'thumb_height', '100');
INSERT INTO `ty_setting` VALUES ('22', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('22', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('22', 'thumb_width', '100');
INSERT INTO `ty_setting` VALUES ('22', 'template_message', '');
INSERT INTO `ty_setting` VALUES ('22', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('22', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('22', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('22', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('22', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('22', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('22', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('22', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('22', 'credit_refresh', '1');
INSERT INTO `ty_setting` VALUES ('22', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('22', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('22', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('22', 'keywords_index', '');
INSERT INTO `ty_setting` VALUES ('22', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('22', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('22', 'description_index', '');
INSERT INTO `ty_setting` VALUES ('22', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('22', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('22', 'module', 'info');
INSERT INTO `ty_setting` VALUES ('pay-tenpay', 'percent', '1');
INSERT INTO `ty_setting` VALUES ('pay-tenpay', 'notify', '');
INSERT INTO `ty_setting` VALUES ('pay-tenpay', 'keycode', '');
INSERT INTO `ty_setting` VALUES ('pay-tenpay', 'partnerid', '');
INSERT INTO `ty_setting` VALUES ('pay-tenpay', 'order', '1');
INSERT INTO `ty_setting` VALUES ('pay-tenpay', 'name', '财付通');
INSERT INTO `ty_setting` VALUES ('pay-tenpay', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('pay-weixin', 'percent', '1');
INSERT INTO `ty_setting` VALUES ('pay-weixin', 'notify', '');
INSERT INTO `ty_setting` VALUES ('pay-weixin', 'keycode', '');
INSERT INTO `ty_setting` VALUES ('pay-weixin', 'appid', '');
INSERT INTO `ty_setting` VALUES ('pay-weixin', 'partnerid', '');
INSERT INTO `ty_setting` VALUES ('pay-weixin', 'name', '微信');
INSERT INTO `ty_setting` VALUES ('pay-weixin', 'order', '2');
INSERT INTO `ty_setting` VALUES ('pay-weixin', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('pay-alipay', 'percent', '1');
INSERT INTO `ty_setting` VALUES ('pay-alipay', 'notify', '');
INSERT INTO `ty_setting` VALUES ('pay-alipay', 'keycode', '');
INSERT INTO `ty_setting` VALUES ('pay-alipay', 'partnerid', '');
INSERT INTO `ty_setting` VALUES ('pay-alipay', 'email', '');
INSERT INTO `ty_setting` VALUES ('pay-alipay', 'order', '3');
INSERT INTO `ty_setting` VALUES ('pay-alipay', 'name', '支付宝');
INSERT INTO `ty_setting` VALUES ('pay-alipay', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('pay-chinabank', 'percent', '1');
INSERT INTO `ty_setting` VALUES ('pay-chinabank', 'notify', '');
INSERT INTO `ty_setting` VALUES ('pay-chinabank', 'keycode', '');
INSERT INTO `ty_setting` VALUES ('pay-chinabank', 'partnerid', '');
INSERT INTO `ty_setting` VALUES ('pay-chinabank', 'name', '网银在线');
INSERT INTO `ty_setting` VALUES ('pay-chinabank', 'order', '4');
INSERT INTO `ty_setting` VALUES ('pay-chinabank', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('pay-yeepay', 'percent', '1');
INSERT INTO `ty_setting` VALUES ('pay-yeepay', 'keycode', '');
INSERT INTO `ty_setting` VALUES ('pay-yeepay', 'partnerid', '');
INSERT INTO `ty_setting` VALUES ('pay-yeepay', 'order', '5');
INSERT INTO `ty_setting` VALUES ('pay-yeepay', 'name', '易宝支付');
INSERT INTO `ty_setting` VALUES ('pay-yeepay', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('pay-kq99bill', 'percent', '1');
INSERT INTO `ty_setting` VALUES ('pay-kq99bill', 'notify', '');
INSERT INTO `ty_setting` VALUES ('pay-kq99bill', 'cert', '');
INSERT INTO `ty_setting` VALUES ('pay-kq99bill', 'partnerid', '');
INSERT INTO `ty_setting` VALUES ('pay-kq99bill', 'order', '6');
INSERT INTO `ty_setting` VALUES ('pay-kq99bill', 'name', '快钱支付');
INSERT INTO `ty_setting` VALUES ('pay-kq99bill', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('pay-chinapay', 'percent', '1');
INSERT INTO `ty_setting` VALUES ('pay-chinapay', 'partnerid', '');
INSERT INTO `ty_setting` VALUES ('pay-chinapay', 'order', '7');
INSERT INTO `ty_setting` VALUES ('pay-chinapay', 'name', '中国银联');
INSERT INTO `ty_setting` VALUES ('pay-chinapay', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('pay-paypal', 'percent', '0');
INSERT INTO `ty_setting` VALUES ('pay-paypal', 'currency', 'USD');
INSERT INTO `ty_setting` VALUES ('pay-paypal', 'keycode', '');
INSERT INTO `ty_setting` VALUES ('pay-paypal', 'notify', '');
INSERT INTO `ty_setting` VALUES ('pay-paypal', 'partnerid', '');
INSERT INTO `ty_setting` VALUES ('pay-paypal', 'order', '8');
INSERT INTO `ty_setting` VALUES ('pay-paypal', 'name', '贝宝');
INSERT INTO `ty_setting` VALUES ('pay-paypal', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('oauth-qq', 'sync', '0');
INSERT INTO `ty_setting` VALUES ('oauth-qq', 'key', '');
INSERT INTO `ty_setting` VALUES ('oauth-qq', 'id', '');
INSERT INTO `ty_setting` VALUES ('oauth-qq', 'order', '1');
INSERT INTO `ty_setting` VALUES ('oauth-qq', 'name', 'QQ登录');
INSERT INTO `ty_setting` VALUES ('oauth-qq', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('oauth-sina', 'sync', '0');
INSERT INTO `ty_setting` VALUES ('oauth-sina', 'key', '');
INSERT INTO `ty_setting` VALUES ('oauth-sina', 'id', '');
INSERT INTO `ty_setting` VALUES ('oauth-sina', 'order', '2');
INSERT INTO `ty_setting` VALUES ('oauth-sina', 'name', '新浪微博');
INSERT INTO `ty_setting` VALUES ('oauth-sina', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('oauth-baidu', 'key', '');
INSERT INTO `ty_setting` VALUES ('oauth-baidu', 'id', '');
INSERT INTO `ty_setting` VALUES ('oauth-baidu', 'order', '3');
INSERT INTO `ty_setting` VALUES ('oauth-baidu', 'name', '百度');
INSERT INTO `ty_setting` VALUES ('oauth-baidu', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('oauth-netease', 'key', '');
INSERT INTO `ty_setting` VALUES ('oauth-netease', 'id', '');
INSERT INTO `ty_setting` VALUES ('oauth-netease', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('oauth-netease', 'order', '4');
INSERT INTO `ty_setting` VALUES ('oauth-netease', 'name', '网易通行证');
INSERT INTO `ty_setting` VALUES ('oauth-wechat', 'key', '');
INSERT INTO `ty_setting` VALUES ('oauth-wechat', 'id', '');
INSERT INTO `ty_setting` VALUES ('oauth-wechat', 'order', '5');
INSERT INTO `ty_setting` VALUES ('oauth-wechat', 'name', '微信');
INSERT INTO `ty_setting` VALUES ('oauth-wechat', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('oauth-taobao', 'id', '');
INSERT INTO `ty_setting` VALUES ('oauth-taobao', 'order', '6');
INSERT INTO `ty_setting` VALUES ('oauth-taobao', 'name', '淘宝');
INSERT INTO `ty_setting` VALUES ('oauth-taobao', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('oauth-taobao', 'key', '');
INSERT INTO `ty_setting` VALUES ('oauth-msn', 'key', '');
INSERT INTO `ty_setting` VALUES ('oauth-msn', 'id', '');
INSERT INTO `ty_setting` VALUES ('oauth-msn', 'order', '7');
INSERT INTO `ty_setting` VALUES ('oauth-msn', 'name', 'MSN');
INSERT INTO `ty_setting` VALUES ('oauth-msn', 'enable', '0');
INSERT INTO `ty_setting` VALUES ('weixin', 'credit', '10');
INSERT INTO `ty_setting` VALUES ('weixin', 'bind', '点击可绑定会员帐号、查看会员信息、收发站内信件、管理我的订单等服务内容');
INSERT INTO `ty_setting` VALUES ('weixin', 'weixin', '');
INSERT INTO `ty_setting` VALUES ('weixin', 'welcome', '感谢您的关注，请点击菜单查看相应的服务');
INSERT INTO `ty_setting` VALUES ('weixin', 'aeskey', '');
INSERT INTO `ty_setting` VALUES ('weixin', 'appsecret', '');
INSERT INTO `ty_setting` VALUES ('weixin', 'apptoken', '');
INSERT INTO `ty_setting` VALUES ('weixin', 'appid', '');
INSERT INTO `ty_setting` VALUES ('weixin-menu', 'menu', '0,1,12,3,4,6,7');
INSERT INTO `ty_setting` VALUES ('1', 'water_type', '0');
INSERT INTO `ty_setting` VALUES ('1', 'water_font', 'simhei.ttf');
INSERT INTO `ty_setting` VALUES ('1', 'water_text', 'www.tianyi.com');
INSERT INTO `ty_setting` VALUES ('1', 'water_jpeg_quality', '90');
INSERT INTO `ty_setting` VALUES ('1', 'water_transition', '60');
INSERT INTO `ty_setting` VALUES ('1', 'file_register', 'register.php');
INSERT INTO `ty_setting` VALUES ('1', 'file_login', 'login.php');
INSERT INTO `ty_setting` VALUES ('1', 'file_my', 'my.php');
INSERT INTO `ty_setting` VALUES ('1', 'water_mark', 'watermark.png');
INSERT INTO `ty_setting` VALUES ('1', 'defend_proxy', '0');
INSERT INTO `ty_setting` VALUES ('1', 'defend_reload', '0');
INSERT INTO `ty_setting` VALUES ('1', 'defend_cc', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'listorder', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'reg', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'exhibit_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'exhibit_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'group_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'group_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'mall_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'mall_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'buy_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'buy_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'sell_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'sell_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'edit_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'refresh_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'day_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'add_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'copy', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'delete', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'vdeposit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'vcompany', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'vtruename', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'vmobile', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'vemail', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'moduleids', '16,5,6,17,7,8,21,22,13,9,10,12,14,15,18');
INSERT INTO `ty_setting` VALUES ('group-1', 'link_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'honor_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'page_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'news_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'kf', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'stats', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'map', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'style', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'main_d', '1,5');
INSERT INTO `ty_setting` VALUES ('group-1', 'main_c', '1,5');
INSERT INTO `ty_setting` VALUES ('group-1', 'home_main', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'side_d', '0,3,6');
INSERT INTO `ty_setting` VALUES ('group-1', 'side_c', '0,3,6');
INSERT INTO `ty_setting` VALUES ('group-1', 'home_side', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'menu_d', '0,6,7,11');
INSERT INTO `ty_setting` VALUES ('group-1', 'menu_c', '0,6,7,11');
INSERT INTO `ty_setting` VALUES ('group-1', 'home_menu', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'home', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'styleid', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'homepage', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'type_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'price_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'inquiry_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'message_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'express_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'address_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'alert_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'favorite_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'friend_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'inbox_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'chat', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'ad', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'spread', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'trade_sell', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'sendmail', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'sms', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'mail', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'ask', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'cash', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'question', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'captcha', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'check', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'uploadpt', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'uploadcredit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'uploadday', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'uploadlimit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'uploadsize', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'uploadtype', '');
INSERT INTO `ty_setting` VALUES ('group-1', 'upload', '1');
INSERT INTO `ty_setting` VALUES ('group-1', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('group-1', 'grade', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'commission', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'discount', '100');
INSERT INTO `ty_setting` VALUES ('group-1', 'fee', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'fee_mode', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'quote_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'quote_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'job_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'job_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'resume_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'resume_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'article_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'article_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'info_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'info_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'know_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'know_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'brand_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'brand_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'photo_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'photo_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'video_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'video_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'down_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'down_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-1', 'club_group_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'club_reply_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'club_join_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'club_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'club_free_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'listorder', '2');
INSERT INTO `ty_setting` VALUES ('group-2', 'reg', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'quote_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'exhibit_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'exhibit_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'group_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'group_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'mall_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'mall_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'buy_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'buy_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'sell_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'sell_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'edit_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'refresh_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'day_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'add_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'copy', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'delete', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'vdeposit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'vcompany', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'vtruename', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'vmobile', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'vemail', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'moduleids', '6');
INSERT INTO `ty_setting` VALUES ('group-2', 'link_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'honor_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'page_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'news_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'kf', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'stats', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'map', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'style', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'main_d', '5');
INSERT INTO `ty_setting` VALUES ('group-2', 'main_c', '5');
INSERT INTO `ty_setting` VALUES ('group-2', 'home_main', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'side_d', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'side_c', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'home_side', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'menu_d', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'menu_c', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'home_menu', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'home', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'styleid', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'homepage', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'type_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'price_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'inquiry_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'message_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'express_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'address_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'alert_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'favorite_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'friend_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'inbox_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'chat', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'ad', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'spread', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'trade_sell', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'sendmail', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'sms', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'mail', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'ask', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'cash', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'question', '1');
INSERT INTO `ty_setting` VALUES ('group-2', 'captcha', '1');
INSERT INTO `ty_setting` VALUES ('group-2', 'check', '1');
INSERT INTO `ty_setting` VALUES ('group-2', 'uploadpt', '1');
INSERT INTO `ty_setting` VALUES ('group-2', 'uploadcredit', '1');
INSERT INTO `ty_setting` VALUES ('group-2', 'uploadday', '10');
INSERT INTO `ty_setting` VALUES ('group-2', 'uploadlimit', '2');
INSERT INTO `ty_setting` VALUES ('group-2', 'uploadsize', '200');
INSERT INTO `ty_setting` VALUES ('group-2', 'uploadtype', '');
INSERT INTO `ty_setting` VALUES ('group-2', 'upload', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'editor', 'Basic');
INSERT INTO `ty_setting` VALUES ('group-2', 'grade', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'commission', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'discount', '100');
INSERT INTO `ty_setting` VALUES ('group-2', 'fee', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'fee_mode', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'quote_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'job_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'job_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'resume_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'resume_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'article_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'article_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'info_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'info_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'know_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'know_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'brand_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'brand_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'photo_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'photo_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'video_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'video_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'down_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'down_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-2', 'club_group_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'club_reply_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'club_join_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'club_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-2', 'club_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'listorder', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'reg', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'exhibit_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'exhibit_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'group_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'group_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'mall_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'mall_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'buy_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'buy_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'sell_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'sell_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'edit_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'refresh_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'day_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'add_limit', '30');
INSERT INTO `ty_setting` VALUES ('group-3', 'copy', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'delete', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'vdeposit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'vcompany', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'vtruename', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'vmobile', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'vemail', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'moduleids', '5,6,8,22,9,-9');
INSERT INTO `ty_setting` VALUES ('group-3', 'link_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'honor_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'page_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'news_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'kf', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'stats', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'map', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'style', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'main_d', '5');
INSERT INTO `ty_setting` VALUES ('group-3', 'main_c', '5');
INSERT INTO `ty_setting` VALUES ('group-3', 'home_main', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'side_d', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'side_c', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'home_side', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'menu_d', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'menu_c', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'home_menu', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'home', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'styleid', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'homepage', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'type_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'price_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-3', 'inquiry_limit', '30');
INSERT INTO `ty_setting` VALUES ('group-3', 'message_limit', '30');
INSERT INTO `ty_setting` VALUES ('group-3', 'express_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'address_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'alert_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'favorite_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'friend_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'inbox_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'chat', '1');
INSERT INTO `ty_setting` VALUES ('group-3', 'ad', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'spread', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'trade_sell', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'sendmail', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'sms', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'mail', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'ask', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'cash', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'question', '1');
INSERT INTO `ty_setting` VALUES ('group-3', 'captcha', '1');
INSERT INTO `ty_setting` VALUES ('group-3', 'check', '1');
INSERT INTO `ty_setting` VALUES ('group-3', 'uploadpt', '1');
INSERT INTO `ty_setting` VALUES ('group-3', 'uploadcredit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'uploadday', '10');
INSERT INTO `ty_setting` VALUES ('group-3', 'uploadlimit', '5');
INSERT INTO `ty_setting` VALUES ('group-3', 'uploadsize', '500');
INSERT INTO `ty_setting` VALUES ('group-3', 'uploadtype', '');
INSERT INTO `ty_setting` VALUES ('group-3', 'upload', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'editor', 'Basic');
INSERT INTO `ty_setting` VALUES ('group-3', 'grade', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'commission', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'discount', '100');
INSERT INTO `ty_setting` VALUES ('group-3', 'fee', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'fee_mode', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'quote_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'quote_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'job_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'job_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'resume_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'resume_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'article_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'article_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'info_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'info_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'know_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'know_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'brand_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'brand_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'photo_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'photo_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'video_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'video_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'down_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-3', 'down_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-3', 'club_group_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'club_reply_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'club_join_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'club_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-3', 'club_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'listorder', '4');
INSERT INTO `ty_setting` VALUES ('group-4', 'reg', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'job_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'quote_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'quote_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'exhibit_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'exhibit_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'group_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'group_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'mall_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'mall_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'buy_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'buy_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'sell_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'sell_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'edit_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'refresh_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'day_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'add_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'copy', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'delete', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'vdeposit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'vcompany', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'vtruename', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'vmobile', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'vemail', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'moduleids', '6');
INSERT INTO `ty_setting` VALUES ('group-4', 'link_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'honor_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'page_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'news_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'kf', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'stats', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'map', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'style', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'main_d', '5');
INSERT INTO `ty_setting` VALUES ('group-4', 'main_c', '5');
INSERT INTO `ty_setting` VALUES ('group-4', 'home_main', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'side_d', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'side_c', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'home_side', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'menu_d', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'menu_c', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'home_menu', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'home', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'styleid', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'homepage', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'type_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'price_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'inquiry_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'message_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'express_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'address_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'alert_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'favorite_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'friend_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'inbox_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'chat', '1');
INSERT INTO `ty_setting` VALUES ('group-4', 'ad', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'spread', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'trade_sell', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'sendmail', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'sms', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'mail', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'ask', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'cash', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'question', '1');
INSERT INTO `ty_setting` VALUES ('group-4', 'captcha', '1');
INSERT INTO `ty_setting` VALUES ('group-4', 'check', '1');
INSERT INTO `ty_setting` VALUES ('group-4', 'uploadpt', '1');
INSERT INTO `ty_setting` VALUES ('group-4', 'uploadcredit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'uploadday', '10');
INSERT INTO `ty_setting` VALUES ('group-4', 'uploadlimit', '5');
INSERT INTO `ty_setting` VALUES ('group-4', 'uploadsize', '500');
INSERT INTO `ty_setting` VALUES ('group-4', 'uploadtype', '');
INSERT INTO `ty_setting` VALUES ('group-4', 'upload', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'editor', 'Basic');
INSERT INTO `ty_setting` VALUES ('group-4', 'grade', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'commission', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'discount', '100');
INSERT INTO `ty_setting` VALUES ('group-4', 'fee', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'fee_mode', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'job_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'resume_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'resume_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'article_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'article_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'info_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'info_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'know_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'know_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'brand_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'brand_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'photo_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'photo_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'video_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'video_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'down_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'down_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-4', 'club_group_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'club_reply_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'club_join_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'club_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'club_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'listorder', '5');
INSERT INTO `ty_setting` VALUES ('group-5', 'reg', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'info_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'article_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'article_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'resume_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'resume_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'job_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'job_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'quote_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'quote_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'exhibit_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'exhibit_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'group_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'group_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'mall_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'mall_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'buy_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'buy_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'sell_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'sell_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'edit_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'refresh_limit', '600');
INSERT INTO `ty_setting` VALUES ('group-5', 'day_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'add_limit', '30');
INSERT INTO `ty_setting` VALUES ('group-5', 'copy', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'delete', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'vdeposit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'vcompany', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'vtruename', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'vmobile', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'vemail', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'moduleids', '5,6,-9,10,12,18');
INSERT INTO `ty_setting` VALUES ('group-5', 'link_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'honor_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'page_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'news_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'kf', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'stats', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'map', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'style', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'main_d', '5');
INSERT INTO `ty_setting` VALUES ('group-5', 'main_c', '5');
INSERT INTO `ty_setting` VALUES ('group-5', 'home_main', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'side_d', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'side_c', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'home_side', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'menu_d', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'menu_c', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'home_menu', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'home', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'styleid', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'homepage', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'type_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-5', 'price_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'inquiry_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'message_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-5', 'express_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'address_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-5', 'alert_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'favorite_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-5', 'friend_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-5', 'inbox_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-5', 'chat', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'ad', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'spread', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'trade_sell', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'sendmail', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'sms', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'mail', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'ask', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'cash', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'question', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'captcha', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'check', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'uploadpt', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'uploadcredit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'uploadday', '20');
INSERT INTO `ty_setting` VALUES ('group-5', 'uploadlimit', '5');
INSERT INTO `ty_setting` VALUES ('group-5', 'uploadsize', '');
INSERT INTO `ty_setting` VALUES ('group-5', 'uploadtype', '');
INSERT INTO `ty_setting` VALUES ('group-5', 'upload', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'editor', 'Simple');
INSERT INTO `ty_setting` VALUES ('group-5', 'grade', '1');
INSERT INTO `ty_setting` VALUES ('group-5', 'commission', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'discount', '100');
INSERT INTO `ty_setting` VALUES ('group-5', 'fee', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'fee_mode', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'info_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'know_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'know_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'brand_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'brand_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'photo_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'photo_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'video_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'video_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'down_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-5', 'down_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'club_group_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'club_reply_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-5', 'club_join_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-5', 'club_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-5', 'club_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'know_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'know_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'info_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'info_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'article_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'article_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'resume_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'resume_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'job_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'job_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'quote_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'quote_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'exhibit_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'exhibit_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'group_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'group_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'mall_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'mall_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'buy_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'buy_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'sell_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'sell_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'edit_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'refresh_limit', '600');
INSERT INTO `ty_setting` VALUES ('group-6', 'day_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'add_limit', '60');
INSERT INTO `ty_setting` VALUES ('group-6', 'copy', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'delete', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'vdeposit', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'vcompany', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'vtruename', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'vmobile', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'vemail', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'moduleids', '16');
INSERT INTO `ty_setting` VALUES ('group-6', 'link_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-6', 'honor_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-6', 'page_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'news_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-6', 'kf', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'stats', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'map', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'style', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'main_d', '0,1,2');
INSERT INTO `ty_setting` VALUES ('group-6', 'main_c', '0,1,2,3,4,5,6');
INSERT INTO `ty_setting` VALUES ('group-6', 'home_main', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'side_d', '0,2,4,6');
INSERT INTO `ty_setting` VALUES ('group-6', 'side_c', '0,1,2,3,4,5,6');
INSERT INTO `ty_setting` VALUES ('group-6', 'home_side', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'menu_d', '0,1,2,3');
INSERT INTO `ty_setting` VALUES ('group-6', 'menu_c', '0,1,2,3');
INSERT INTO `ty_setting` VALUES ('group-6', 'home_menu', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'home', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'styleid', '2');
INSERT INTO `ty_setting` VALUES ('group-6', 'homepage', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'type_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-6', 'price_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-6', 'inquiry_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-6', 'message_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-6', 'express_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'address_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-6', 'alert_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'favorite_limit', '50');
INSERT INTO `ty_setting` VALUES ('group-6', 'friend_limit', '50');
INSERT INTO `ty_setting` VALUES ('group-6', 'inbox_limit', '50');
INSERT INTO `ty_setting` VALUES ('group-6', 'chat', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'ad', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'job_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'quote_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'quote_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'exhibit_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'exhibit_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'group_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'group_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'mall_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'mall_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'buy_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'buy_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'sell_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'sell_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'edit_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'refresh_limit', '60');
INSERT INTO `ty_setting` VALUES ('group-7', 'day_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-7', 'add_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'delete', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'copy', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'vdeposit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'vcompany', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'vtruename', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'vmobile', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'vemail', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'moduleids', '16,21');
INSERT INTO `ty_setting` VALUES ('group-7', 'link_limit', '50');
INSERT INTO `ty_setting` VALUES ('group-7', 'honor_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-7', 'page_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-7', 'news_limit', '100');
INSERT INTO `ty_setting` VALUES ('group-7', 'kf', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'stats', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'map', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'style', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'main_d', '0,1,2,7');
INSERT INTO `ty_setting` VALUES ('group-7', 'main_c', '0,1,2,4,5,6,7');
INSERT INTO `ty_setting` VALUES ('group-7', 'home_main', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'side_d', '0,2,4');
INSERT INTO `ty_setting` VALUES ('group-7', 'side_c', '0,2,3,4,5');
INSERT INTO `ty_setting` VALUES ('group-7', 'home_side', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'menu_d', '0,1,2,3');
INSERT INTO `ty_setting` VALUES ('group-7', 'menu_c', '0,1,2,3');
INSERT INTO `ty_setting` VALUES ('group-7', 'home_menu', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'home', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'styleid', '2');
INSERT INTO `ty_setting` VALUES ('group-7', 'homepage', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'type_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-7', 'price_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-7', 'inquiry_limit', '50');
INSERT INTO `ty_setting` VALUES ('group-7', 'message_limit', '100');
INSERT INTO `ty_setting` VALUES ('group-7', 'express_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-7', 'address_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-7', 'alert_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-7', 'favorite_limit', '100');
INSERT INTO `ty_setting` VALUES ('group-7', 'friend_limit', '200');
INSERT INTO `ty_setting` VALUES ('group-7', 'inbox_limit', '500');
INSERT INTO `ty_setting` VALUES ('group-7', 'chat', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'ad', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'spread', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'trade_sell', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'sendmail', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'sms', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'mail', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'ask', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'cash', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'question', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'captcha', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'check', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'uploadpt', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'uploadcredit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'uploadday', '100');
INSERT INTO `ty_setting` VALUES ('group-7', 'uploadlimit', '10');
INSERT INTO `ty_setting` VALUES ('group-7', 'uploadsize', '');
INSERT INTO `ty_setting` VALUES ('group-7', 'uploadtype', '');
INSERT INTO `ty_setting` VALUES ('group-7', 'upload', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('group-7', 'reg', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'grade', '1');
INSERT INTO `ty_setting` VALUES ('group-7', 'commission', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'discount', '');
INSERT INTO `ty_setting` VALUES ('group-7', 'fee', '2000');
INSERT INTO `ty_setting` VALUES ('group-7', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('destoon', 'backtime', '1467860142');
INSERT INTO `ty_setting` VALUES ('1', 'safe_domain', '');
INSERT INTO `ty_setting` VALUES ('1', 'check_referer', '1');
INSERT INTO `ty_setting` VALUES ('1', 'uploaddir', 'Ym/d');
INSERT INTO `ty_setting` VALUES ('1', 'uploadsize', '2048');
INSERT INTO `ty_setting` VALUES ('1', 'uploadtype', 'jpg|jpeg|gif|png|rar|zip|pdf|doc|xls|ppt|flv|mp4|docx|ppts|xlsx');
INSERT INTO `ty_setting` VALUES ('1', 'uploadlog', '1');
INSERT INTO `ty_setting` VALUES ('1', 'anticopy', '0');
INSERT INTO `ty_setting` VALUES ('1', 'ip_login', '0');
INSERT INTO `ty_setting` VALUES ('1', 'login_log', '0');
INSERT INTO `ty_setting` VALUES ('1', 'admin_log', '0');
INSERT INTO `ty_setting` VALUES ('1', 'admin_online', '1');
INSERT INTO `ty_setting` VALUES ('1', 'md5_pass', '1');
INSERT INTO `ty_setting` VALUES ('1', 'captcha_admin', '0');
INSERT INTO `ty_setting` VALUES ('1', 'captcha_cn', '0');
INSERT INTO `ty_setting` VALUES ('1', 'captcha_chars', '');
INSERT INTO `ty_setting` VALUES ('1', 'check_hour', '');
INSERT INTO `ty_setting` VALUES ('1', 'admin_hour', '');
INSERT INTO `ty_setting` VALUES ('1', 'admin_ip', '');
INSERT INTO `ty_setting` VALUES ('1', 'admin_area', '');
INSERT INTO `ty_setting` VALUES ('1', 'remote_url', '');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_path', '');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_save', '0');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_pasv', '0');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_ssl', '0');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_pass', '');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_user', '');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_port', '21');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_host', '');
INSERT INTO `ty_setting` VALUES ('1', 'ftp_remote', '0');
INSERT INTO `ty_setting` VALUES ('1', 'max_len', '20000');
INSERT INTO `ty_setting` VALUES ('1', 'schcate_limit', '10');
INSERT INTO `ty_setting` VALUES ('1', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('1', 'pushtime', '0');
INSERT INTO `ty_setting` VALUES ('1', 'online', '1200');
INSERT INTO `ty_setting` VALUES ('1', 'search_limit', '1');
INSERT INTO `ty_setting` VALUES ('1', 'max_kw', '30');
INSERT INTO `ty_setting` VALUES ('1', 'min_kw', '3');
INSERT INTO `ty_setting` VALUES ('1', 'search_check_kw', '0');
INSERT INTO `ty_setting` VALUES ('1', 'search_kw', '1');
INSERT INTO `ty_setting` VALUES ('1', 'save_draft', '0');
INSERT INTO `ty_setting` VALUES ('1', 'search_tips', '1');
INSERT INTO `ty_setting` VALUES ('1', 'anti_spam', '1');
INSERT INTO `ty_setting` VALUES ('1', 'log_credit', '1');
INSERT INTO `ty_setting` VALUES ('1', 'pages_mode', '0');
INSERT INTO `ty_setting` VALUES ('1', 'lazy', '1');
INSERT INTO `ty_setting` VALUES ('1', 'gzip_enable', '0');
INSERT INTO `ty_setting` VALUES ('1', 'cache_hits', '0');
INSERT INTO `ty_setting` VALUES ('1', 'task_index', '600');
INSERT INTO `ty_setting` VALUES ('1', 'task_list', '1800');
INSERT INTO `ty_setting` VALUES ('1', 'task_item', '7200');
INSERT INTO `ty_setting` VALUES ('1', 'cache_search', '0');
INSERT INTO `ty_setting` VALUES ('1', 'log_404', '0');
INSERT INTO `ty_setting` VALUES ('1', 'pcharset', '0');
INSERT INTO `ty_setting` VALUES ('1', 'com_www', '0');
INSERT INTO `ty_setting` VALUES ('1', 'rewrite', '0');
INSERT INTO `ty_setting` VALUES ('1', 'index_html', '1');
INSERT INTO `ty_setting` VALUES ('1', 'file_ext', 'html');
INSERT INTO `ty_setting` VALUES ('1', 'index', 'index');
INSERT INTO `ty_setting` VALUES ('group-6', 'spread', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'trade_sell', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'sendmail', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'sms', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'mail', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'ask', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'cash', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'question', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'captcha', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'check', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'uploadpt', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'uploadcredit', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'uploadday', '50');
INSERT INTO `ty_setting` VALUES ('group-6', 'uploadlimit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'uploadsize', '');
INSERT INTO `ty_setting` VALUES ('group-6', 'uploadtype', '');
INSERT INTO `ty_setting` VALUES ('group-6', 'upload', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('group-6', 'reg', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'grade', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'commission', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'discount', '100');
INSERT INTO `ty_setting` VALUES ('group-6', 'fee', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'job_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'resume_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'resume_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'article_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'article_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'info_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'info_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'know_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'know_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'brand_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'brand_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'photo_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'photo_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'video_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'video_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'down_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'down_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'club_group_limit', '3');
INSERT INTO `ty_setting` VALUES ('group-7', 'club_reply_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'club_join_limit', '50');
INSERT INTO `ty_setting` VALUES ('group-7', 'club_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'club_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', 'tycase_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-1', '', '');
INSERT INTO `ty_setting` VALUES ('group-3', 'tycase_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-4', 'tycase_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-5', 'tycase_limit', '-1');
INSERT INTO `ty_setting` VALUES ('group-6', 'fee_mode', '0');
INSERT INTO `ty_setting` VALUES ('group-7', 'tycase_limit', '20');
INSERT INTO `ty_setting` VALUES ('group-6', 'brand_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'brand_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'photo_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'photo_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'video_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'video_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'down_limit', '5');
INSERT INTO `ty_setting` VALUES ('group-6', 'down_free_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'club_group_limit', '1');
INSERT INTO `ty_setting` VALUES ('group-6', 'club_reply_limit', '50');
INSERT INTO `ty_setting` VALUES ('group-6', 'club_join_limit', '10');
INSERT INTO `ty_setting` VALUES ('group-6', 'club_limit', '0');
INSERT INTO `ty_setting` VALUES ('group-6', 'club_free_limit', '0');
INSERT INTO `ty_setting` VALUES ('1', 'seo_description', '');
INSERT INTO `ty_setting` VALUES ('1', 'seo_keywords', '');
INSERT INTO `ty_setting` VALUES ('1', 'seo_title', '天医工程网');
INSERT INTO `ty_setting` VALUES ('1', 'seo_delimiter', '_');
INSERT INTO `ty_setting` VALUES ('1', 'trade_nu', 'notify.php');
INSERT INTO `ty_setting` VALUES ('1', 'trade_tp', '0');
INSERT INTO `ty_setting` VALUES ('1', 'trade_ac', '');
INSERT INTO `ty_setting` VALUES ('1', 'trade_id', '');
INSERT INTO `ty_setting` VALUES ('1', 'trade_pw', '');
INSERT INTO `ty_setting` VALUES ('1', 'trade_hm', 'http://www.alipay.com/');
INSERT INTO `ty_setting` VALUES ('1', 'trade_nm', '支付宝');
INSERT INTO `ty_setting` VALUES ('1', 'im_ali', '1');
INSERT INTO `ty_setting` VALUES ('1', 'im_msn', '0');
INSERT INTO `ty_setting` VALUES ('1', 'im_skype', '0');
INSERT INTO `ty_setting` VALUES ('1', 'trade', '');
INSERT INTO `ty_setting` VALUES ('1', 'im_web', '1');
INSERT INTO `ty_setting` VALUES ('1', 'im_qq', '1');
INSERT INTO `ty_setting` VALUES ('1', 'admin_left', '188');
INSERT INTO `ty_setting` VALUES ('1', 'credit_unit', '点');
INSERT INTO `ty_setting` VALUES ('1', 'credit_name', '积分');
INSERT INTO `ty_setting` VALUES ('1', 'money_sign', '￥');
INSERT INTO `ty_setting` VALUES ('1', 'money_unit', '元');
INSERT INTO `ty_setting` VALUES ('1', 'money_name', '资金');
INSERT INTO `ty_setting` VALUES ('1', 'city_ip', '0');
INSERT INTO `ty_setting` VALUES ('1', 'city', '0');
INSERT INTO `ty_setting` VALUES ('1', 'close_reason', '网站维护中，请稍候访问...');
INSERT INTO `ty_setting` VALUES ('1', 'close', '0');
INSERT INTO `ty_setting` VALUES ('1', 'icpno', '');
INSERT INTO `ty_setting` VALUES ('1', 'telephone', '');
INSERT INTO `ty_setting` VALUES ('1', 'copyright', 'sd');
INSERT INTO `ty_setting` VALUES ('1', 'logo', 'http://www.tctianyi.com/file/upload/201701/04/230523441.png');
INSERT INTO `ty_setting` VALUES ('1', 'sitename', '天医工程网');
INSERT INTO `ty_setting` VALUES ('1', 'page_group', '3');
INSERT INTO `ty_setting` VALUES ('1', 'page_rank', '5');
INSERT INTO `ty_setting` VALUES ('1', 'page_special', '1');
INSERT INTO `ty_setting` VALUES ('1', 'page_comnews', '5');
INSERT INTO `ty_setting` VALUES ('1', 'page_newsh', '1');
INSERT INTO `ty_setting` VALUES ('1', 'page_news', '5');
INSERT INTO `ty_setting` VALUES ('1', 'page_photo', '6');
INSERT INTO `ty_setting` VALUES ('1', 'page_video', '3');
INSERT INTO `ty_setting` VALUES ('1', 'page_post', '8');
INSERT INTO `ty_setting` VALUES ('1', 'page_club', '8');
INSERT INTO `ty_setting` VALUES ('1', 'page_know', '6');
INSERT INTO `ty_setting` VALUES ('1', 'page_exhibit', '6');
INSERT INTO `ty_setting` VALUES ('1', 'page_brand', '4');
INSERT INTO `ty_setting` VALUES ('1', 'page_job', '5');
INSERT INTO `ty_setting` VALUES ('1', 'page_down', '5');
INSERT INTO `ty_setting` VALUES ('1', 'page_logo', '18');
INSERT INTO `ty_setting` VALUES ('1', 'page_text', '18');
INSERT INTO `ty_setting` VALUES ('1', 'sms', '0');
INSERT INTO `ty_setting` VALUES ('1', 'sms_fee', '0.1');
INSERT INTO `ty_setting` VALUES ('1', 'sms_max', '');
INSERT INTO `ty_setting` VALUES ('1', 'sms_len', '70');
INSERT INTO `ty_setting` VALUES ('1', 'sms_ok', '成功');
INSERT INTO `ty_setting` VALUES ('1', 'sms_sign', '【签名】');
INSERT INTO `ty_setting` VALUES ('1', 'cloud_express', '0');
INSERT INTO `ty_setting` VALUES ('1', 'admin_week', '');
INSERT INTO `ty_setting` VALUES ('1', 'check_week', '');
INSERT INTO `ty_setting` VALUES ('21', 'fields', 'itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,islink,hits');
INSERT INTO `ty_setting` VALUES ('21', 'order', 'addtime desc');
INSERT INTO `ty_setting` VALUES ('21', 'editor', 'Default');
INSERT INTO `ty_setting` VALUES ('21', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('26', 'moduleid', '13');
INSERT INTO `ty_setting` VALUES ('26', 'name', '品牌');
INSERT INTO `ty_setting` VALUES ('26', 'moduledir', 'brand');
INSERT INTO `ty_setting` VALUES ('26', 'description_show', '');
INSERT INTO `ty_setting` VALUES ('26', 'description_list', '');
INSERT INTO `ty_setting` VALUES ('26', 'keywords_list', '');
INSERT INTO `ty_setting` VALUES ('26', 'keywords_show', '');
INSERT INTO `ty_setting` VALUES ('26', 'description_index', '{$seo_modulename}{$seo_sitename}{$seo_sitetitle}');
INSERT INTO `ty_setting` VALUES ('26', 'keywords_index', '{$seo_modulename}{$seo_sitename}{$seo_sitetitle}');
INSERT INTO `ty_setting` VALUES ('26', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('26', 'credit_refresh', '1');
INSERT INTO `ty_setting` VALUES ('26', 'title_index', '{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('26', 'title_show', '{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('26', 'title_list', '{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}');
INSERT INTO `ty_setting` VALUES ('26', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('26', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('26', 'fee_view', '0');
INSERT INTO `ty_setting` VALUES ('26', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('26', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('26', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('26', 'template_product', '');
INSERT INTO `ty_setting` VALUES ('26', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('26', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('26', 'template_message', '');
INSERT INTO `ty_setting` VALUES ('26', 'thumb_width', '180');
INSERT INTO `ty_setting` VALUES ('26', 'introduce_length', '120');
INSERT INTO `ty_setting` VALUES ('26', 'editor', 'Destoon');
INSERT INTO `ty_setting` VALUES ('26', 'order', 'editdate desc,vip desc,edittime desc');
INSERT INTO `ty_setting` VALUES ('26', 'thumb_height', '60');
INSERT INTO `ty_setting` VALUES ('26', 'fields', 'itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated');
INSERT INTO `ty_setting` VALUES ('26', 'message_ask', '请问我这个地方有加盟商了吗？|我想加盟，请来电话告诉我具体细节。|初步打算加盟贵公司，请寄资料。|请问贵公司哪里有样板店或直营店？|想了解加盟细节，请尽快寄一份资料。 ');
INSERT INTO `ty_setting` VALUES ('26', 'clear_link', '0');
INSERT INTO `ty_setting` VALUES ('26', 'save_remotepic', '0');
INSERT INTO `ty_setting` VALUES ('26', 'cat_property', '0');
INSERT INTO `ty_setting` VALUES ('26', 'page_irec', '20');
INSERT INTO `ty_setting` VALUES ('26', 'level', '推荐品牌');
INSERT INTO `ty_setting` VALUES ('26', 'fulltext', '0');
INSERT INTO `ty_setting` VALUES ('26', 'split', '0');
INSERT INTO `ty_setting` VALUES ('26', 'keylink', '0');
INSERT INTO `ty_setting` VALUES ('26', 'page_icat', '6');
INSERT INTO `ty_setting` VALUES ('26', 'pagesize', '20');
INSERT INTO `ty_setting` VALUES ('26', 'max_width', '550');
INSERT INTO `ty_setting` VALUES ('26', 'page_subcat', '6');
INSERT INTO `ty_setting` VALUES ('26', 'index_html', '0');
INSERT INTO `ty_setting` VALUES ('26', 'list_html', '0');
INSERT INTO `ty_setting` VALUES ('26', 'htm_list_prefix', '');
INSERT INTO `ty_setting` VALUES ('26', 'htm_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('26', 'php_list_urlid', '0');
INSERT INTO `ty_setting` VALUES ('26', 'show_html', '0');
INSERT INTO `ty_setting` VALUES ('26', 'htm_item_prefix', '');
INSERT INTO `ty_setting` VALUES ('26', 'htm_item_urlid', '1');
INSERT INTO `ty_setting` VALUES ('26', 'php_item_urlid', '0');
INSERT INTO `ty_setting` VALUES ('26', 'seo_title_index', '{模块名称}{分隔符}{页码}{网站名称}');
INSERT INTO `ty_setting` VALUES ('26', 'seo_keywords_index', '');
INSERT INTO `ty_setting` VALUES ('26', 'seo_description_index', '');
INSERT INTO `ty_setting` VALUES ('26', 'seo_title_list', '{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('26', 'seo_description_list', '');
INSERT INTO `ty_setting` VALUES ('26', 'seo_keywords_list', '');
INSERT INTO `ty_setting` VALUES ('26', 'seo_title_show', '{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}');
INSERT INTO `ty_setting` VALUES ('21', 'thumb_height', '90');
INSERT INTO `ty_setting` VALUES ('21', 'thumb_width', '120');
INSERT INTO `ty_setting` VALUES ('21', 'template_my', '');
INSERT INTO `ty_setting` VALUES ('21', 'template_search', '');
INSERT INTO `ty_setting` VALUES ('21', 'template_show', '');
INSERT INTO `ty_setting` VALUES ('21', 'template_list', '');
INSERT INTO `ty_setting` VALUES ('21', 'template_index', '');
INSERT INTO `ty_setting` VALUES ('26', 'seo_keywords_show', '');
INSERT INTO `ty_setting` VALUES ('26', 'seo_description_show', '');
INSERT INTO `ty_setting` VALUES ('26', 'group_index', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('26', 'group_list', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('26', 'group_show', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('26', 'group_contact', '6,7');
INSERT INTO `ty_setting` VALUES ('26', 'group_search', '3,5,6,7');
INSERT INTO `ty_setting` VALUES ('26', 'group_color', '6,7');
INSERT INTO `ty_setting` VALUES ('26', 'group_refresh', '7');
INSERT INTO `ty_setting` VALUES ('26', 'captcha_message', '2');
INSERT INTO `ty_setting` VALUES ('26', 'question_message', '2');
INSERT INTO `ty_setting` VALUES ('26', 'check_add', '2');
INSERT INTO `ty_setting` VALUES ('26', 'captcha_add', '2');
INSERT INTO `ty_setting` VALUES ('26', 'question_add', '2');
INSERT INTO `ty_setting` VALUES ('26', 'fee_mode', '1');
INSERT INTO `ty_setting` VALUES ('26', 'fee_currency', 'money');
INSERT INTO `ty_setting` VALUES ('26', 'fee_add', '0');
INSERT INTO `ty_setting` VALUES ('21', 'fee_back', '0');
INSERT INTO `ty_setting` VALUES ('21', 'pre_view', '500');
INSERT INTO `ty_setting` VALUES ('21', 'credit_add', '2');
INSERT INTO `ty_setting` VALUES ('21', 'credit_del', '5');
INSERT INTO `ty_setting` VALUES ('21', 'credit_color', '100');
INSERT INTO `ty_setting` VALUES ('26', 'fee_period', '0');
INSERT INTO `ty_setting` VALUES ('26', 'fee_back', '0');

-- ----------------------------
-- Table structure for ty_sms
-- ----------------------------
DROP TABLE IF EXISTS `ty_sms`;
CREATE TABLE `ty_sms` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `word` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `sendtime` int(10) unsigned NOT NULL DEFAULT '0',
  `code` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信记录';

-- ----------------------------
-- Records of ty_sms
-- ----------------------------

-- ----------------------------
-- Table structure for ty_special
-- ----------------------------
DROP TABLE IF EXISTS `ty_special`;
CREATE TABLE `ty_special` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `items` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `banner` varchar(255) NOT NULL DEFAULT '',
  `cfg_photo` smallint(4) unsigned NOT NULL DEFAULT '0',
  `cfg_video` smallint(4) unsigned NOT NULL DEFAULT '0',
  `cfg_type` smallint(4) unsigned NOT NULL DEFAULT '0',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题';

-- ----------------------------
-- Records of ty_special
-- ----------------------------

-- ----------------------------
-- Table structure for ty_special_data
-- ----------------------------
DROP TABLE IF EXISTS `ty_special_data`;
CREATE TABLE `ty_special_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题内容';

-- ----------------------------
-- Records of ty_special_data
-- ----------------------------

-- ----------------------------
-- Table structure for ty_special_item
-- ----------------------------
DROP TABLE IF EXISTS `ty_special_item`;
CREATE TABLE `ty_special_item` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `specialid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `addtime` (`addtime`),
  KEY `specialid` (`specialid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题信息';

-- ----------------------------
-- Records of ty_special_item
-- ----------------------------

-- ----------------------------
-- Table structure for ty_sphinx
-- ----------------------------
DROP TABLE IF EXISTS `ty_sphinx`;
CREATE TABLE `ty_sphinx` (
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `maxid` bigint(20) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `moduleid` (`moduleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Sphinx';

-- ----------------------------
-- Records of ty_sphinx
-- ----------------------------

-- ----------------------------
-- Table structure for ty_spread
-- ----------------------------
DROP TABLE IF EXISTS `ty_spread`;
CREATE TABLE `ty_spread` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `tid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `word` varchar(50) NOT NULL DEFAULT '',
  `price` float NOT NULL DEFAULT '0',
  `currency` varchar(30) NOT NULL DEFAULT '',
  `company` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='排名推广';

-- ----------------------------
-- Records of ty_spread
-- ----------------------------

-- ----------------------------
-- Table structure for ty_spread_price
-- ----------------------------
DROP TABLE IF EXISTS `ty_spread_price`;
CREATE TABLE `ty_spread_price` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(50) NOT NULL DEFAULT '',
  `sell_price` float NOT NULL DEFAULT '0',
  `buy_price` float NOT NULL DEFAULT '0',
  `company_price` float NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='排名起价';

-- ----------------------------
-- Records of ty_spread_price
-- ----------------------------

-- ----------------------------
-- Table structure for ty_style
-- ----------------------------
DROP TABLE IF EXISTS `ty_style`;
CREATE TABLE `ty_style` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `skin` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(50) NOT NULL DEFAULT '',
  `author` varchar(30) NOT NULL DEFAULT '',
  `groupid` varchar(30) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `currency` varchar(20) NOT NULL DEFAULT '',
  `money` float NOT NULL DEFAULT '0',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='公司主页模板';

-- ----------------------------
-- Records of ty_style
-- ----------------------------
INSERT INTO `ty_style` VALUES ('2', '0', '深蓝模板', 'blue', 'homepage', 'Destoon.COM', ',6,7,', '0', 'money', '0', '0', '1', '1467860142', 'tianyi', '1467860142', '0');
INSERT INTO `ty_style` VALUES ('3', '0', '绿色模板', 'green', 'homepage', 'Destoon.COM', ',6,7,', '0', 'money', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '0');
INSERT INTO `ty_style` VALUES ('4', '0', '紫色模板', 'purple', 'homepage', 'Destoon.COM', ',6,7,', '0', 'credit', '0', '5', '2', '1467860142', 'tianyi', '1467860142', '0');
INSERT INTO `ty_style` VALUES ('5', '0', '橙色模板', 'orange', 'homepage', 'Destoon.COM', ',6,7,', '0', 'credit', '120', '0', '1', '1467860142', 'tianyi', '1467860142', '0');
INSERT INTO `ty_style` VALUES ('6', '99', '默认模板', 'default', 'homepage', 'Destoon.COM', ',6,7,', '0', 'money', '0', '0', '0', '1467860142', 'tianyi', '1467860142', '0');

-- ----------------------------
-- Table structure for ty_tycase
-- ----------------------------
DROP TABLE IF EXISTS `ty_tycase`;
CREATE TABLE `ty_tycase` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `companyid` bigint(20) NOT NULL COMMENT '公司id',
  `username` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '公司名',
  `title` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '标题',
  `content` mediumtext CHARACTER SET utf8 NOT NULL COMMENT '内容',
  `thumb` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '图片',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `edittime` int(10) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `editor` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '编辑',
  `totime` int(10) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `hits` int(10) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`) USING BTREE,
  KEY `addtime` (`addtime`) USING BTREE,
  KEY `edittime` (`edittime`) USING BTREE,
  KEY `companyid` (`companyid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ty_tycase
-- ----------------------------
INSERT INTO `ty_tycase` VALUES ('1', '0', 'shandongpingyi', '项目案例测试1', '&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1', 'http://www.tctianyi.com/file/upload/201705/02/1457247414.png.thumb.png', '1493709592', '1493709592', 'shandongpingyi', '0', '0', '0');
INSERT INTO `ty_tycase` VALUES ('2', '0', 'shandongpingyi', '谁谁谁水水水水', '&nbsp;11111111容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1&nbsp;我是内容1', 'http://www.tctianyi.com/file/upload/201705/02/1520299314.png.thumb.png', '1493709635', '1493709635', '', '0', '0', '3');
INSERT INTO `ty_tycase` VALUES ('3', '0', 'shandongpingyi', '阿达撒大大', '&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复&nbsp;方法反反复复反复反复反复反复反复反复反复反复', 'http://www.tctianyi.com/file/upload/201705/03/1129302414.png.thumb.png', '1493782178', '1493782178', '', '0', '0', '3');
INSERT INTO `ty_tycase` VALUES ('4', '0', 'shandongpingyi', '按时发发', '&nbsp;阿萨法', 'http://www.tctianyi.com/file/upload/201705/03/1129505414.png.thumb.png', '1493782192', '1493782192', '', '0', '0', '3');
INSERT INTO `ty_tycase` VALUES ('5', '0', 'shandongpingyi', '大发发', '&nbsp;12312313132', 'http://www.tctianyi.com/file/upload/201705/03/1130034214.png.thumb.png', '1493782206', '1493782206', '', '1494345599', '0', '3');
INSERT INTO `ty_tycase` VALUES ('6', '0', 'shandongpingyi', '11111', '&nbsp;', 'http://www.tctianyi.com/file/upload/201705/04/1049207814.png.thumb.png', '1493866163', '1493866163', '', '1494259199', '0', '3');
INSERT INTO `ty_tycase` VALUES ('7', '0', 'shandongpingyi', '生发乌发·1', '&nbsp;', 'http://www.tctianyi.com/file/upload/201705/04/1049331614.png.thumb.png', '1493866175', '1493866175', '', '1494345599', '0', '3');
INSERT INTO `ty_tycase` VALUES ('8', '0', 'shandongpingyi', '21313123', '&nbsp;', 'http://www.tctianyi.com/file/upload/201705/04/1049424914.png.thumb.png', '1493866183', '1493866183', '', '1494345599', '0', '3');
INSERT INTO `ty_tycase` VALUES ('9', '0', 'shandongpingyi', '113123', '&nbsp;213123123', 'http://www.tctianyi.com/file/upload/201705/04/1049534014.gif.thumb.gif', '1493866195', '1493866195', '', '1494345599', '0', '3');
INSERT INTO `ty_tycase` VALUES ('10', '0', 'shandongpingyi', '123123', '&nbsp;123', 'http://www.tctianyi.com/file/upload/201705/04/1050031114.png.thumb.png', '1493866205', '1493866205', '', '1494950399', '0', '3');
INSERT INTO `ty_tycase` VALUES ('11', '0', 'shandongpingyi', '113123', '&nbsp;', 'http://www.tctianyi.com/file/upload/201705/04/1050128714.png.thumb.png', '1493866213', '1493866213', '', '0', '0', '3');

-- ----------------------------
-- Table structure for ty_type
-- ----------------------------
DROP TABLE IF EXISTS `ty_type`;
CREATE TABLE `ty_type` (
  `typeid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) NOT NULL DEFAULT '0',
  `typename` varchar(255) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `item` varchar(20) NOT NULL DEFAULT '',
  `cache` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`typeid`),
  KEY `listorder` (`listorder`),
  KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='分类';

-- ----------------------------
-- Records of ty_type
-- ----------------------------
INSERT INTO `ty_type` VALUES ('1', '0', '0', '医疗行业', '', 'link', '1');

-- ----------------------------
-- Table structure for ty_upgrade
-- ----------------------------
DROP TABLE IF EXISTS `ty_upgrade`;
CREATE TABLE `ty_upgrade` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `groupid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `amount` float NOT NULL DEFAULT '0',
  `message` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `msn` varchar(50) NOT NULL DEFAULT '',
  `qq` varchar(30) NOT NULL DEFAULT '',
  `ali` varchar(30) NOT NULL DEFAULT '',
  `skype` varchar(30) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `promo_code` varchar(30) NOT NULL DEFAULT '',
  `promo_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `promo_amount` float NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='会员升级';

-- ----------------------------
-- Records of ty_upgrade
-- ----------------------------
INSERT INTO `ty_upgrade` VALUES ('1', '14', 'shandongpingyi', '7', '0', '1', '山东省平邑县瑞泰石业有限公司', '平问问', '13800138000', '', '13084909@qq.com', '', '', '', '', '', '1491553558', '127.0.0.1', '', '0', '0', 'tianyi', '1491555307', '3', '');

-- ----------------------------
-- Table structure for ty_upload_0
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_0`;
CREATE TABLE `ty_upload_0` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录0';

-- ----------------------------
-- Records of ty_upload_0
-- ----------------------------

-- ----------------------------
-- Table structure for ty_upload_1
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_1`;
CREATE TABLE `ty_upload_1` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COMMENT='上传记录1';

-- ----------------------------
-- Records of ty_upload_1
-- ----------------------------
INSERT INTO `ty_upload_1` VALUES ('2', 'a5dd1eb5e755eaadbe1dcf29b8d2ef2f', '3', '0', 'http://www.tianyi.com/file/upload/201607/13/125340421.jpg', '28804', 'jpg', 'thumb', '400', '160', '1468385620', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('3', '762d42ace78058908da3278ba765a017', '3', '0', 'http://www.tianyi.com/file/upload/201607/13/125353611.jpg', '63265', 'jpg', 'thumb', '400', '160', '1468385633', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('4', '06901770934a118de75abc24bc44b396', '1', '0', 'http://www.tctianyi.com/file/upload/201701/04/230523441.png', '5017', 'png', 'thumb', '119', '71', '1483542323', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('6', '1ccea23a4f2444372e11f1315b16e89a', '16', '1', 'http://www.tctianyi.com/file/upload/201701/19/152807241.png.thumb.png', '14978', 'png', 'album', '213', '79', '1484810887', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('7', 'd83cd3b15eaf17db3082970df3ecfc97', '16', '2', 'http://www.tctianyi.com/file/upload/201701/19/154553961.jpg.thumb.jpg', '7298', 'jpg', 'album', '403', '220', '1484811953', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('8', '7e32e1d8c2aa1c8c53988e826a7cb5a3', '16', '3', 'http://www.tctianyi.com/file/upload/201701/19/154631131.jpg.thumb.jpg', '7285', 'jpg', 'album', '266', '161', '1484811991', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('9', 'fd0f480aa6426b73e7b50ab96f32d2cb', '16', '4', 'http://www.tctianyi.com/file/upload/201701/19/154708591.jpg.thumb.jpg', '10135', 'jpg', 'album', '264', '175', '1484812028', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('10', '61a7ef0d2204c9f9456a29c92e38ab54', '16', '5', 'http://www.tctianyi.com/file/upload/201701/19/155200531.jpg.thumb.jpg', '9242', 'jpg', 'album', '338', '178', '1484812320', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('11', '807d961babf1e219de7c0d99fab4681e', '16', '6', 'http://www.tctianyi.com/file/upload/201701/19/155225661.jpg.thumb.jpg', '9949', 'jpg', 'album', '317', '174', '1484812345', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('12', 'fae57564b8c20109fa0dc2523767ba71', '16', '7', 'http://www.tctianyi.com/file/upload/201701/19/164930471.jpg.thumb.jpg', '14292', 'jpg', 'album', '454', '269', '1484815770', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('13', '17283a69dd7ea505472048f9ddd83672', '16', '8', 'http://www.tctianyi.com/file/upload/201701/19/165000481.jpg.thumb.jpg', '13545', 'jpg', 'album', '643', '344', '1484815800', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('14', 'da117960e04a88a252e1a9197fdf15a0', '16', '9', 'http://www.tctianyi.com/file/upload/201701/20/110702451.jpg.thumb.jpg', '35441', 'jpg', 'album', '690', '457', '1484881622', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('15', '2a81d4a3e723e2a2474456b3cb9988f8', '16', '10', 'http://www.tctianyi.com/file/upload/201701/20/110742761.jpg.thumb.jpg', '10647', 'jpg', 'album', '250', '250', '1484881662', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('16', '55d9d873e636247ad98a643a0dce9fe9', '16', '11', 'http://www.tctianyi.com/file/upload/201701/20/110819481.jpg.thumb.jpg', '22354', 'jpg', 'album', '533', '300', '1484881699', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('17', 'cb19324a74066e852df947a3845f01b7', '16', '12', 'http://www.tctianyi.com/file/upload/201701/20/110857771.jpg.thumb.jpg', '31792', 'jpg', 'album', '580', '435', '1484881737', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('18', '85486ecd91306204b38953b2ba2804c8', '16', '13', 'http://www.tctianyi.com/file/upload/201701/20/111146231.jpg.thumb.jpg', '9062', 'jpg', 'album', '392', '220', '1484881906', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('20', '6e06fa5239138879484ce3fe6437598a', '16', '13', 'http://www.tctianyi.com/file/upload/201701/20/111158581.jpg.thumb.jpg', '11890', 'jpg', 'album', '397', '300', '1484881918', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('21', 'd65b04e69fe305475040352517043606', '16', '14', 'http://www.tctianyi.com/file/upload/201701/20/111302171.jpg.thumb.jpg', '180192', 'jpg', 'album', '800', '359', '1484881982', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('22', '8a51fe975a528c363a65f1173d191651', '16', '15', 'http://www.tctianyi.com/file/upload/201701/20/111528731.jpg.thumb.jpg', '15819', 'jpg', 'album', '399', '300', '1484882128', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('23', 'f1831fa0cb44204594bd50c04798a0af', '16', '15', 'http://www.tctianyi.com/file/upload/201701/20/111534741.jpg.thumb.jpg', '17118', 'jpg', 'album', '362', '300', '1484882134', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('24', 'eb0d060f3fb79460e2f934fcbe04ea58', '16', '16', 'http://www.tctianyi.com/file/upload/201701/20/111715341.jpg.thumb.jpg', '19424', 'jpg', 'album', '650', '384', '1484882235', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('25', '3c2b1d365bd0d49d7904624d35a0304c', '16', '17', 'http://www.tctianyi.com/file/upload/201701/20/111812951.jpg.thumb.jpg', '9059', 'jpg', 'album', '330', '300', '1484882292', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('26', 'e1ebfc998ec5d7766b40d96865f3064a', '16', '18', 'http://www.tctianyi.com/file/upload/201701/20/112106911.jpg.thumb.jpg', '17005', 'jpg', 'album', '250', '248', '1484882466', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('27', 'a989e0fd1e9213b2fb52d692682ee20c', '16', '19', 'http://www.tctianyi.com/file/upload/201701/20/112458441.jpg.thumb.jpg', '167362', 'jpg', 'album', '800', '599', '1484882698', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('28', '5ff9b20d64b105a25f35cee2a85e3ccf', '16', '19', 'http://www.tctianyi.com/file/upload/201701/20/112513561.jpg.thumb.jpg', '42442', 'jpg', 'album', '435', '300', '1484882713', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('29', '765d41dda249114cff78ab6736f46850', '16', '20', 'http://www.tctianyi.com/file/upload/201701/20/112641371.jpg.thumb.jpg', '48788', 'jpg', 'album', '500', '303', '1484882801', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('30', '96edd49aee81f8f756639a2156657562', '16', '21', 'http://www.tctianyi.com/file/upload/201701/20/112837121.jpg.thumb.jpg', '47414', 'jpg', 'album', '349', '252', '1484882917', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('31', 'f0195d958462335671af216a9926609f', '16', '22', 'http://www.tctianyi.com/file/upload/201701/20/112858981.jpg.thumb.jpg', '78939', 'jpg', 'album', '750', '486', '1484882938', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('32', '60e888eccba1ee4086c57993ebcf2f39', '16', '23', 'http://www.tctianyi.com/file/upload/201701/20/113150101.jpg.thumb.jpg', '13754', 'jpg', 'album', '440', '300', '1484883110', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('33', '5eee51fe283ceb10cfbadfd818c9279a', '16', '23', 'http://www.tctianyi.com/file/upload/201701/20/113214431.jpg.thumb.jpg', '16724', 'jpg', 'album', '319', '220', '1484883134', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('34', 'e905d195ee98502e38d6a3b6bdda09bb', '16', '24', 'http://www.tctianyi.com/file/upload/201701/20/113252661.jpg.thumb.jpg', '31573', 'jpg', 'album', '356', '267', '1484883172', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('35', 'b0454e17d515d1742dd5bea77c5b4577', '16', '24', 'http://www.tctianyi.com/file/upload/201701/20/113255801.jpg.thumb.jpg', '7298', 'jpg', 'album', '403', '220', '1484883175', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('36', '4c4659e4225fe1468f584ffa459f18dc', '16', '25', 'http://www.tctianyi.com/file/upload/201701/20/113518971.jpg.thumb.jpg', '29069', 'jpg', 'album', '700', '466', '1484883318', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('37', '56ceea0cc948b6f9160d18984388ee69', '16', '26', 'http://www.tctianyi.com/file/upload/201701/20/113548921.jpg.thumb.jpg', '29809', 'jpg', 'album', '400', '300', '1484883348', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('38', '1acbe4683766c3b525490405633e4a66', '16', '27', 'http://www.tctianyi.com/file/upload/201701/20/113756271.jpg.thumb.jpg', '72650', 'jpg', 'album', '800', '600', '1484883476', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('39', '63a3b0ae0b490a72f36b01318b1c7cef', '16', '28', 'http://www.tctianyi.com/file/upload/201701/20/113954471.jpg.thumb.jpg', '31885', 'jpg', 'album', '400', '400', '1484883594', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('40', '8ecb422d6165c6a32913c3f7d8c0a595', '16', '29', 'http://www.tctianyi.com/file/upload/201701/20/114234481.jpg.thumb.jpg', '14990', 'jpg', 'album', '330', '220', '1484883754', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('41', '874313f5e3b96719e538a7ff3ed7da95', '16', '30', 'http://www.tctianyi.com/file/upload/201701/20/114306371.jpg.thumb.jpg', '10035', 'jpg', 'album', '291', '194', '1484883786', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('42', '1de6966f222a7b1ab6113c7e9e460796', '16', '31', 'http://www.tctianyi.com/file/upload/201701/20/115211881.jpg.thumb.jpg', '20496', 'jpg', 'album', '411', '307', '1484884331', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('43', 'dcf7a7262bcd6cb53b415b7e12ee4998', '16', '31', 'http://www.tctianyi.com/file/upload/201701/20/115215651.jpg.thumb.jpg', '36106', 'jpg', 'album', '568', '240', '1484884335', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('44', 'a2f876539ee5de5b2acb03fc2141392f', '16', '32', 'http://www.tctianyi.com/file/upload/201701/20/115346881.jpg.thumb.jpg', '9587', 'jpg', 'album', '361', '220', '1484884426', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('45', 'ff2e9ac007d1773ec4f403f846e21783', '16', '32', 'http://www.tctianyi.com/file/upload/201701/20/115351731.jpg.thumb.jpg', '13279', 'jpg', 'album', '400', '300', '1484884431', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('46', 'ed4d5dbba6547f7ee05c138dec42ebc0', '16', '33', 'http://www.tctianyi.com/file/upload/201701/20/115447411.jpg.thumb.jpg', '144678', 'jpg', 'album', '800', '530', '1484884487', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('47', '954485b5a275942a74eb369be87eafeb', '16', '34', 'http://www.tctianyi.com/file/upload/201701/20/115557351.jpg.thumb.jpg', '13548', 'jpg', 'album', '400', '300', '1484884557', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('48', '7283b872e4d4ce1e8ec339dddaee1f58', '16', '35', 'http://www.tctianyi.com/file/upload/201701/20/115645561.jpg.thumb.jpg', '52009', 'jpg', 'album', '800', '533', '1484884605', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('49', 'fd8af25873d6809c0ed6adfae2f1d9a0', '16', '36', 'http://www.tctianyi.com/file/upload/201701/20/115749121.jpg.thumb.jpg', '10537', 'jpg', 'album', '260', '300', '1484884669', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('50', 'db9b9da8b268a0092e1ad97ea0b7fd12', '16', '37', 'http://www.tctianyi.com/file/upload/201701/20/140549401.jpg.thumb.jpg', '37314', 'jpg', 'album', '690', '414', '1484892349', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('51', '4eb9ee1445f9f5c5653d6fa61ebeac66', '16', '38', 'http://www.tctianyi.com/file/upload/201701/20/140745281.jpg.thumb.jpg', '16862', 'jpg', 'album', '435', '300', '1484892465', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('52', 'ba4395cc002eeed0e14ef5ca15b924b5', '16', '39', 'http://www.tctianyi.com/file/upload/201701/20/141009551.jpg.thumb.jpg', '67146', 'jpg', 'album', '600', '287', '1484892609', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('53', '4b426a1cf18ccd9ee04f285e0f4aefb8', '16', '40', 'http://www.tctianyi.com/file/upload/201701/20/141039231.jpg.thumb.jpg', '17794', 'jpg', 'album', '449', '300', '1484892639', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('54', 'de9e4ce9bfe3cac2e96f56bd0dc8e6af', '16', '41', 'http://www.tctianyi.com/file/upload/201701/20/141258601.jpg.thumb.jpg', '252292', 'jpg', 'album', '536', '468', '1484892778', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('55', '8d8165a0c256beb35d45920a7296ff57', '16', '42', 'http://www.tctianyi.com/file/upload/201701/20/141442951.jpg.thumb.jpg', '10088', 'jpg', 'album', '262', '220', '1484892882', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('56', '155197c63e9ca3d1093fb4cfe31af4f3', '16', '43', 'http://www.tctianyi.com/file/upload/201701/20/141739721.jpg.thumb.jpg', '11314', 'jpg', 'album', '330', '300', '1484893059', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('57', '58fed0235841625d77108bee3283d76e', '16', '44', 'http://www.tctianyi.com/file/upload/201701/20/141931671.jpg.thumb.jpg', '9931', 'jpg', 'album', '329', '287', '1484893171', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('58', '0c9370b398d416f572c86a3c5ed09a16', '16', '44', 'http://www.tctianyi.com/file/upload/201701/20/141957911.jpg.thumb.jpg', '8982', 'jpg', 'album', '300', '300', '1484893197', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('59', '736b8d1368fc85b1181827d5861dc01e', '16', '45', 'http://www.tctianyi.com/file/upload/201701/20/142026551.jpg.thumb.jpg', '9186', 'jpg', 'album', '390', '300', '1484893226', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('60', 'a8a22158e6de7ebb0244062f058d669a', '16', '46', 'http://www.tctianyi.com/file/upload/201701/20/142158581.jpg.thumb.jpg', '36933', 'jpg', 'album', '590', '534', '1484893318', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('61', '2d0834c4b8b1430a2613a84d7d80fb53', '16', '47', 'http://www.tctianyi.com/file/upload/201701/20/142235211.jpg.thumb.jpg', '103058', 'jpg', 'album', '800', '524', '1484893355', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('62', '6eb426cc9bf506b094864cc9bfb3a977', '16', '48', 'http://www.tctianyi.com/file/upload/201701/20/142337471.jpg.thumb.jpg', '17075', 'jpg', 'album', '452', '300', '1484893417', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('63', '60350e8a3c236ffd78a15b096b86a5ee', '13', '1', 'http://www.tctianyi.com/file/upload/201704/06/140030671.png', '10315', 'png', 'thumb', '180', '60', '1491458430', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('67', 'f009f595a5397018a597487fb91f1f94', '21', '1', 'http://www.tctianyi.com/file/upload/201705/13/122107281.jpg', '27202', 'jpg', 'thumb', '250', '300', '1494649267', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('68', '36e599b37a440245f2102446e4801676', '21', '15', 'http://www.tctianyi.com/file/upload/201705/13/122842421.jpg', '5130', 'jpg', 'thumb', '330', '250', '1494649722', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('71', '0d61dc32a039aa985814f105b428c244', '21', '14', 'http://www.tctianyi.com/file/upload/201705/13/135715381.gif', '48737', 'gif', 'thumb', '330', '250', '1494655035', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('72', 'ab8e815ae1f7e4d3ae6f2ce6078471a5', '21', '13', 'http://www.tctianyi.com/file/upload/201705/13/141251531.png', '21537', 'png', 'thumb', '120', '90', '1494655971', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('73', '6a4695936f97fe4452ab842d8d94bff5', '21', '12', 'http://www.tctianyi.com/file/upload/201705/13/141330861.png', '108373', 'png', 'thumb', '330', '250', '1494656010', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('74', '33401fd4df59bf06a9818be4baad11f6', '21', '11', 'http://www.tctianyi.com/file/upload/201705/13/141345361.jpg', '6082', 'jpg', 'thumb', '120', '90', '1494656025', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('75', '1248ffba6115b26b9cedbc08be61dc77', '21', '10', 'http://www.tctianyi.com/file/upload/201705/13/141359831.jpg', '16617', 'jpg', 'thumb', '330', '250', '1494656039', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('76', '14f22e85bc48b692ba8ae21da46d2d34', '21', '9', 'http://www.tctianyi.com/file/upload/201705/13/141423151.png', '21600', 'png', 'thumb', '120', '90', '1494656063', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('77', 'c5cb1a0727dec80f3236f80a23add24a', '21', '8', 'http://www.tctianyi.com/file/upload/201705/13/141438821.png', '23265', 'png', 'thumb', '120', '90', '1494656078', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('78', '08cb96aa8e2e074ca4a631419fa2897f', '21', '16', 'http://www.tctianyi.com/file/upload/201705/13/141659471.png', '74536', 'png', 'thumb', '330', '250', '1494656219', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('79', 'c13b0eed54e3046fb6620eb990ffe011', '21', '18', 'http://www.tctianyi.com/file/upload/201705/13/142232451.png', '79590', 'png', 'thumb', '330', '250', '1494656552', 'tianyi', '127.0.0.1');
INSERT INTO `ty_upload_1` VALUES ('80', '0b9cc815d2ee2bacf0d6836a452a8282', '16', '1', 'http://www.tctianyi.com/file/upload/201705/13/144149261.png.thumb.png', '14978', 'png', 'album', '213', '79', '1494657709', 'tianyi', '127.0.0.1');

-- ----------------------------
-- Table structure for ty_upload_2
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_2`;
CREATE TABLE `ty_upload_2` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录2';

-- ----------------------------
-- Records of ty_upload_2
-- ----------------------------

-- ----------------------------
-- Table structure for ty_upload_3
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_3`;
CREATE TABLE `ty_upload_3` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录3';

-- ----------------------------
-- Records of ty_upload_3
-- ----------------------------

-- ----------------------------
-- Table structure for ty_upload_4
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_4`;
CREATE TABLE `ty_upload_4` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COMMENT='上传记录4';

-- ----------------------------
-- Records of ty_upload_4
-- ----------------------------
INSERT INTO `ty_upload_4` VALUES ('1', '4a55a99ee22152d3594caadadce44291', '2', '14', 'http://www.tctianyi.com/file/upload/201704/07/1017535514.jpg', '10894', 'jpg', 'thumb', '180', '180', '1491531473', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('2', '79e3ec59479343e161113298142e7c32', '16', '64', 'http://www.tctianyi.com/file/upload/201704/07/1019087714.jpg.thumb.jpg', '26361', 'jpg', 'album', '399', '314', '1491531548', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('3', '425b6b3dc40004f5ddf0ee292a5288cb', '16', '65', 'http://www.tctianyi.com/file/upload/201704/07/1019543114.jpg.thumb.jpg', '12793', 'jpg', 'album', '300', '300', '1491531594', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('4', '3548f6d136af323d81b2b12876c4cde2', '16', '65', 'http://www.tctianyi.com/file/upload/201704/07/1019585614.jpg.thumb.jpg', '15273', 'jpg', 'album', '309', '300', '1491531598', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('5', '979aa7964ee25dd5242c90bfb911f4eb', '2', '0', 'http://www.tctianyi.com/file/upload/201704/07/1643217814.jpg', '13108', 'jpg', 'thumb', '295', '300', '1491554601', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('6', 'c3d7ece023c110521b65d14d1e532fd8', '2', '0', 'http://www.tctianyi.com/file/upload/201704/07/1643266214.jpg', '14652', 'jpg', 'thumb', '444', '300', '1491554606', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('7', '2f20c69e08743d14f1ef7b62d42e294d', '2', '0', 'http://www.tctianyi.com/file/upload/201704/07/1643312014.jpg', '15273', 'jpg', 'thumb', '309', '300', '1491554611', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('18', '109bb9f932a4f9f75a9750b7280aab0f', '2', '0', 'http://www.tctianyi.com/file/upload/201705/02/1457247414.png.thumb.png', '403229', 'png', 'album', '700', '466', '1493708244', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('17', 'b4b3d06f603a7281e7c9eb2319880ae9', '2', '14', 'http://www.tctianyi.com/file/upload/201704/28/1416128414.gif', '98449', 'gif', 'editor', '540', '350', '1493360172', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('16', 'a02055478fd7143e2517d1892d8fcc29', '2', '14', 'http://www.tctianyi.com/file/upload/201704/28/1410326514.gif', '98449', 'gif', 'editor', '540', '350', '1493359832', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('15', 'de33051c4a0eb9df41271fb01282693e', '2', '14', 'http://www.tctianyi.com/file/upload/201704/28/1407188414.gif', '98449', 'gif', 'editor', '540', '350', '1493359638', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('12', '8e06569fefd24b6a42592c6b2e5b37ff', '2', '0', 'http://www.tctianyi.com/file/upload/201704/10/1047224414.jpg.thumb.jpg', '34130', 'jpg', 'album', '297', '431', '1491792442', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('13', 'b25a6b19e7167f3087337669e68dd0b3', '16', '66', 'http://www.tctianyi.com/file/upload/201704/10/1521187314.jpg.thumb.jpg', '16619', 'jpg', 'album', '405', '300', '1491808878', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('14', '9d80686d39f917ee65900b5063d87ac9', '16', '66', 'http://www.tctianyi.com/file/upload/201704/10/1521249314.jpg.thumb.jpg', '21315', 'jpg', 'album', '328', '351', '1491808884', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('19', '77ca28fd42b7d4f1f4b43744129ab0ac', '2', '0', 'http://www.tctianyi.com/file/upload/201705/02/1458205114.jpg.thumb.jpg', '20075', 'jpg', 'album', '160', '225', '1493708300', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('20', 'da3a2827c136ad1b9bf26ed4cede8ead', '2', '0', 'http://www.tctianyi.com/file/upload/201705/02/1509092314.jpg.thumb.jpg', '20333', 'jpg', 'album', '160', '225', '1493708949', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('21', 'd437d1152d1939076287119d22193066', '2', '0', 'http://www.tctianyi.com/file/upload/201705/02/1520299314.png.thumb.png', '403229', 'png', 'album', '700', '466', '1493709629', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('58', '76dbc2907829f34535b36b0cd8bc818c', '16', '67', 'http://www.tctianyi.com/file/upload/201705/03/1127295814.jpg.thumb.jpg', '20333', 'jpg', 'album', '160', '225', '1493782049', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('56', 'e3501cb68224ea27a4d529666eed19eb', '2', '14', 'http://www.tctianyi.com/file/upload/201705/03/1120061414.gif', '98449', 'gif', 'thumb', '540', '350', '1493781606', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('57', '2368bc4bd8dc0e26b94da74327ac531a', '16', '67', 'http://www.tctianyi.com/file/upload/201705/03/1127263514.jpg.thumb.jpg', '20333', 'jpg', 'album', '160', '225', '1493782046', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('59', '54ad3cef08a822b97d5e15efc708379e', '16', '67', 'http://www.tctianyi.com/file/upload/201705/03/1127351714.jpg.thumb.jpg', '20075', 'jpg', 'album', '160', '225', '1493782055', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('60', 'c7dc7cd8c82f1b535e59e31582827998', '16', '68', 'http://www.tctianyi.com/file/upload/201705/03/1128316514.jpg.thumb.jpg', '20075', 'jpg', 'album', '160', '225', '1493782111', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('61', 'dd1912b0edab3b6253f47ed00e5c47af', '16', '68', 'http://www.tctianyi.com/file/upload/201705/03/1128346314.jpg.thumb.jpg', '44766', 'jpg', 'album', '550', '407', '1493782114', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('62', '56665c0df604b05f7783b344502d435f', '16', '68', 'http://www.tctianyi.com/file/upload/201705/03/1128377814.jpg.thumb.jpg', '44766', 'jpg', 'album', '550', '407', '1493782117', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('63', 'f76fd0cf0ae94357d3cb49f62fe82225', '2', '0', 'http://www.tctianyi.com/file/upload/201705/03/1129302414.png.thumb.png', '142558', 'png', 'album', '380', '300', '1493782170', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('64', '6ab78c60274f8e6ca1e0011231314738', '2', '0', 'http://www.tctianyi.com/file/upload/201705/03/1129505414.png.thumb.png', '147119', 'png', 'album', '380', '300', '1493782190', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('65', 'bdf105cb626345d66ebd02a5c98b24eb', '2', '0', 'http://www.tctianyi.com/file/upload/201705/03/1130034214.png.thumb.png', '142558', 'png', 'album', '380', '300', '1493782203', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('94', '2ef18901196c1cefcd7c83a9d303d047', '16', '69', 'http://www.tctianyi.com/file/upload/201705/08/1520064114.gif.thumb.gif', '98449', 'gif', 'album', '540', '350', '1494228006', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('93', '7fc071d39e230b8d0e5bc0424144b4dc', '16', '69', 'http://www.tctianyi.com/file/upload/201705/08/1519599314.jpg.thumb.jpg', '110906', 'jpg', 'album', '785', '785', '1494227999', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('69', '36f1d1f821a7e9d37c7b0e2de15acb8c', '16', '70', 'http://www.tctianyi.com/file/upload/201705/03/1148472114.jpg.thumb.jpg', '20333', 'jpg', 'album', '160', '225', '1493783327', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('70', '75d76998a5cb9cf14c1da066898b2668', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/0933315814.jpg.thumb.jpg', '267515', 'jpg', 'album', '480', '700', '1493861611', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('71', '850c11f9b70c39d2fc21123605e9f1f4', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/0933488814.png.thumb.png', '46106', 'png', 'album', '124', '182', '1493861628', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('72', '5fa882e198a5c5483fbb6b85ff109890', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/0934046014.jpg.thumb.jpg', '267515', 'jpg', 'album', '480', '700', '1493861644', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('73', '1d76f3336ea7eede23de7776a13ee5e0', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/0935573714.jpg.thumb.jpg', '20313', 'jpg', 'album', '160', '225', '1493861757', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('74', '84ff65c0619c71bdc2370e6f5ccadf03', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/0936069214.jpg.thumb.jpg', '20333', 'jpg', 'album', '160', '225', '1493861766', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('75', 'ae0f68e754eb70f750309e5fd671cbcd', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/1049207814.png.thumb.png', '157910', 'png', 'album', '400', '314', '1493866160', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('76', 'd1a4031eb78b9d59067087134a2133e5', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/1049331614.png.thumb.png', '142558', 'png', 'album', '380', '300', '1493866173', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('77', '986ae48279a9a4a7effc55064bce2903', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/1049424914.png.thumb.png', '29365', 'png', 'album', '218', '219', '1493866182', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('78', 'cea47d303f448bd5ffe34c0d4af6ec2b', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/1049534014.gif.thumb.gif', '98449', 'gif', 'album', '540', '350', '1493866193', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('79', 'dbb421ed488075b0d5a857fdce8fdf90', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/1050031114.png.thumb.png', '29365', 'png', 'album', '218', '219', '1493866203', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('80', '482e4d11295a7215f683d59057fdd2e3', '2', '0', 'http://www.tctianyi.com/file/upload/201705/04/1050128714.png.thumb.png', '403229', 'png', 'album', '700', '466', '1493866212', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('116', '501c5a8609d493ef6f3f9de4362a54e6', '16', '69', 'http://www.tctianyi.com/file/upload/201705/08/1659393714.jpg', '20313', 'jpg', 'editor', '160', '225', '1494233979', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('84', '7a1aef975c452d45797d82c0a6ef72c4', '16', '71', 'http://www.tctianyi.com/file/upload/201705/05/1123441314.png.thumb.png', '100325', 'png', 'album', '680', '250', '1493954624', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('85', '1501a327ea2250cd78734beab2ab929c', '16', '71', 'http://www.tctianyi.com/file/upload/201705/05/1123499514.gif.thumb.gif', '98449', 'gif', 'album', '540', '350', '1493954629', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('117', 'c8fdb71e4172c01031eaa5360a6ca9cb', '24', '0', 'http://www.tctianyi.com/file/upload/201705/15/1133085514.jpg', '3603', 'jpg', 'thumb', '180', '60', '1494819188', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('95', 'a337dfb8a6e82081564caed43ff77bd7', '16', '69', 'http://www.tctianyi.com/file/upload/201705/08/1520123014.jpg.thumb.jpg', '23349', 'jpg', 'album', '454', '340', '1494228012', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('105', 'c359b9f7ebd49718eee9bdbe3664f1ae', '16', '69', 'http://www.tctianyi.com/file/upload/201705/08/1547575414.jpg.thumb.jpg', '110906', 'jpg', 'album', '785', '785', '1494229677', 'shandongpingyi', '127.0.0.1');
INSERT INTO `ty_upload_4` VALUES ('115', 'fbfcdff8924e73ef8d5ed6a796043fb1', '16', '69', 'http://www.tctianyi.com/file/upload/201705/08/1659051014.png', '608699', 'png', 'editor', '930', '1163', '1494233945', 'shandongpingyi', '127.0.0.1');

-- ----------------------------
-- Table structure for ty_upload_5
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_5`;
CREATE TABLE `ty_upload_5` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='上传记录5';

-- ----------------------------
-- Records of ty_upload_5
-- ----------------------------
INSERT INTO `ty_upload_5` VALUES ('1', '163064e0904729613d11562dbb807663', '2', '15', 'http://www.tctianyi.com/file/upload/201704/07/0959323815.png', '15703', 'png', 'thumb', '180', '180', '1491530372', 'laizhoujieli', '127.0.0.1');
INSERT INTO `ty_upload_5` VALUES ('2', '4ff454b52450388724860ae24c7bb9e9', '16', '61', 'http://www.tctianyi.com/file/upload/201704/07/1000236815.jpg.thumb.jpg', '83196', 'jpg', 'album', '719', '422', '1491530423', 'laizhoujieli', '127.0.0.1');
INSERT INTO `ty_upload_5` VALUES ('3', '7d19145cb0eb2ea1b4051cd783a7128a', '16', '61', 'http://www.tctianyi.com/file/upload/201704/07/1000286315.jpg.thumb.jpg', '120912', 'jpg', 'album', '800', '478', '1491530428', 'laizhoujieli', '127.0.0.1');
INSERT INTO `ty_upload_5` VALUES ('7', '513bb179598c01f81a20d1e64c6ac5b4', '16', '63', 'http://www.tctianyi.com/file/upload/201704/07/1009172015.jpg.thumb.jpg', '13108', 'jpg', 'album', '295', '300', '1491530957', 'laizhoujieli', '127.0.0.1');
INSERT INTO `ty_upload_5` VALUES ('5', '626a6878ef3691cce81e0250976f3d62', '16', '62', 'http://www.tctianyi.com/file/upload/201704/07/1007489215.jpg.thumb.jpg', '29126', 'jpg', 'album', '533', '300', '1491530868', 'laizhoujieli', '127.0.0.1');
INSERT INTO `ty_upload_5` VALUES ('6', '581b3ae9e72b0b40372a2ed9809d9e6d', '16', '62', 'http://www.tctianyi.com/file/upload/201704/07/1007577615.jpg.thumb.jpg', '36807', 'jpg', 'album', '404', '300', '1491530877', 'laizhoujieli', '127.0.0.1');
INSERT INTO `ty_upload_5` VALUES ('8', 'c8cbe2d77b8a694c33f7d1bd5af77913', '16', '63', 'http://www.tctianyi.com/file/upload/201704/07/1009224515.jpg.thumb.jpg', '12793', 'jpg', 'album', '300', '300', '1491530962', 'laizhoujieli', '127.0.0.1');

-- ----------------------------
-- Table structure for ty_upload_6
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_6`;
CREATE TABLE `ty_upload_6` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='上传记录6';

-- ----------------------------
-- Records of ty_upload_6
-- ----------------------------
INSERT INTO `ty_upload_6` VALUES ('3', '978c93802ad37f676752ed66b9e04e93', '16', '58', 'http://www.tctianyi.com/file/upload/201704/07/0950486216.jpg.thumb.jpg', '32913', 'jpg', 'album', '500', '400', '1491529848', 'hebeixinda', '127.0.0.1');
INSERT INTO `ty_upload_6` VALUES ('2', '688ffcaa25532d3d9e55caf3d0dce588', '2', '16', 'http://www.tctianyi.com/file/upload/201704/07/0949405516.png', '17273', 'png', 'thumb', '180', '180', '1491529780', 'hebeixinda', '127.0.0.1');
INSERT INTO `ty_upload_6` VALUES ('4', '9c5557f0b1e244f404952fe847d83ac9', '16', '58', 'http://www.tctianyi.com/file/upload/201704/07/0950528716.jpg.thumb.jpg', '56821', 'jpg', 'album', '800', '800', '1491529852', 'hebeixinda', '127.0.0.1');
INSERT INTO `ty_upload_6` VALUES ('5', '394eeb6d81bee3137e052a2207492f8d', '16', '59', 'http://www.tctianyi.com/file/upload/201704/07/0952248616.png.thumb.png', '27076', 'png', 'album', '181', '133', '1491529944', 'hebeixinda', '127.0.0.1');
INSERT INTO `ty_upload_6` VALUES ('6', 'db285a9bfeb8d29fe9478153fd6d4d44', '16', '59', 'http://www.tctianyi.com/file/upload/201704/07/0952415916.jpg.thumb.jpg', '8393', 'jpg', 'album', '240', '180', '1491529961', 'hebeixinda', '127.0.0.1');
INSERT INTO `ty_upload_6` VALUES ('7', '63d17b635639602f21d457b240f9cde9', '16', '60', 'http://www.tctianyi.com/file/upload/201704/07/0955493816.jpg.thumb.jpg', '39884', 'jpg', 'album', '800', '795', '1491530149', 'hebeixinda', '127.0.0.1');

-- ----------------------------
-- Table structure for ty_upload_7
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_7`;
CREATE TABLE `ty_upload_7` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='上传记录7';

-- ----------------------------
-- Records of ty_upload_7
-- ----------------------------
INSERT INTO `ty_upload_7` VALUES ('1', '720d573e5adb91973a7d94f02aca6971', '16', '55', 'http://www.tctianyi.com/file/upload/201704/07/0926475917.jpg.thumb.jpg', '54496', 'jpg', 'album', '567', '424', '1491528407', 'zhongshanyayun', '127.0.0.1');
INSERT INTO `ty_upload_7` VALUES ('2', '0131efd982f111d836396958549de873', '16', '55', 'http://www.tctianyi.com/file/upload/201704/07/0926553617.jpg.thumb.jpg', '16619', 'jpg', 'album', '405', '300', '1491528415', 'zhongshanyayun', '127.0.0.1');
INSERT INTO `ty_upload_7` VALUES ('3', '3da9142f1b2a4ee6242b764d60b412d8', '16', '56', 'http://www.tctianyi.com/file/upload/201704/07/0928071817.jpg.thumb.jpg', '16470', 'jpg', 'album', '400', '300', '1491528487', 'zhongshanyayun', '127.0.0.1');
INSERT INTO `ty_upload_7` VALUES ('4', 'efc1d7b271f8bbc3ae7321130b197ecf', '16', '56', 'http://www.tctianyi.com/file/upload/201704/07/0928134617.jpg.thumb.jpg', '83732', 'jpg', 'album', '400', '312', '1491528493', 'zhongshanyayun', '127.0.0.1');
INSERT INTO `ty_upload_7` VALUES ('5', '100579aea71c58973a40272ff5ec5c98', '16', '57', 'http://www.tctianyi.com/file/upload/201704/07/0929169817.jpg.thumb.jpg', '56485', 'jpg', 'album', '500', '327', '1491528556', 'zhongshanyayun', '127.0.0.1');
INSERT INTO `ty_upload_7` VALUES ('6', '03c31ab9c6b9c769f319caca2bc0627c', '16', '57', 'http://www.tctianyi.com/file/upload/201704/07/0929264517.jpg.thumb.jpg', '8920', 'jpg', 'album', '366', '300', '1491528566', 'zhongshanyayun', '127.0.0.1');
INSERT INTO `ty_upload_7` VALUES ('7', '7c29b785be9246c0dc8248db72c9effe', '2', '17', 'http://www.tctianyi.com/file/upload/201704/07/0935214117.jpg', '3410', 'jpg', 'thumb', '180', '180', '1491528921', 'zhongshanyayun', '127.0.0.1');

-- ----------------------------
-- Table structure for ty_upload_8
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_8`;
CREATE TABLE `ty_upload_8` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='上传记录8';

-- ----------------------------
-- Records of ty_upload_8
-- ----------------------------
INSERT INTO `ty_upload_8` VALUES ('1', 'fa9ec22e7b57ad52e797896130c54526', '16', '52', 'http://www.tctianyi.com/file/upload/201704/06/1704309518.jpg.thumb.jpg', '56485', 'jpg', 'album', '500', '327', '1491469470', 'zhongshanxingdi', '127.0.0.1');
INSERT INTO `ty_upload_8` VALUES ('2', '786652ad7db9179a6467fb6782144db0', '16', '52', 'http://www.tctianyi.com/file/upload/201704/06/1704356118.jpg.thumb.jpg', '21705', 'jpg', 'album', '300', '300', '1491469475', 'zhongshanxingdi', '127.0.0.1');
INSERT INTO `ty_upload_8` VALUES ('3', 'ca45835f7fd1100dcfce80db713a2bab', '16', '53', 'http://www.tctianyi.com/file/upload/201704/06/1716558618.jpg.thumb.jpg', '12728', 'jpg', 'album', '500', '364', '1491470215', 'zhongshanxingdi', '127.0.0.1');
INSERT INTO `ty_upload_8` VALUES ('4', 'abe16edf1b71923f4a82de065bc6c97c', '16', '53', 'http://www.tctianyi.com/file/upload/201704/06/1716598118.jpg.thumb.jpg', '83732', 'jpg', 'album', '400', '312', '1491470219', 'zhongshanxingdi', '127.0.0.1');
INSERT INTO `ty_upload_8` VALUES ('5', 'd9c286d617ee7a4b862d841aeb414f49', '16', '54', 'http://www.tctianyi.com/file/upload/201704/06/1720175718.jpg.thumb.jpg', '16924', 'jpg', 'album', '470', '300', '1491470417', 'zhongshanxingdi', '127.0.0.1');
INSERT INTO `ty_upload_8` VALUES ('6', 'b34e138d6874054449f1259bf96bdb42', '16', '54', 'http://www.tctianyi.com/file/upload/201704/06/1720215818.jpg.thumb.jpg', '16702', 'jpg', 'album', '400', '300', '1491470421', 'zhongshanxingdi', '127.0.0.1');
INSERT INTO `ty_upload_8` VALUES ('7', '8ae6aced16b1126e930daa202e161d04', '2', '18', 'http://www.tctianyi.com/file/upload/201704/07/0945139318.png', '6305', 'png', 'thumb', '180', '180', '1491529513', 'zhongshanxingdi', '127.0.0.1');

-- ----------------------------
-- Table structure for ty_upload_9
-- ----------------------------
DROP TABLE IF EXISTS `ty_upload_9`;
CREATE TABLE `ty_upload_9` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(32) NOT NULL DEFAULT '',
  `moduleid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `fileext` varchar(10) NOT NULL DEFAULT '',
  `upfrom` varchar(10) NOT NULL DEFAULT '',
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='上传记录9';

-- ----------------------------
-- Records of ty_upload_9
-- ----------------------------
INSERT INTO `ty_upload_9` VALUES ('1', '7c166bc9d50e0b267cf4f323a668ee5e', '2', '19', 'http://www.tctianyi.com/file/upload/201704/06/1155424319.jpg', '11308', 'jpg', 'thumb', '180', '180', '1491450942', 'hulunbeier', '127.0.0.1');
INSERT INTO `ty_upload_9` VALUES ('2', '63740a3b9581ee021da098a8d7b9f156', '16', '49', 'http://www.tctianyi.com/file/upload/201704/06/1411057419.jpg.thumb.jpg', '6788', 'jpg', 'album', '260', '185', '1491459065', 'hulunbeier', '127.0.0.1');
INSERT INTO `ty_upload_9` VALUES ('3', '729b15704f13a06bd278abc89a8b12b4', '16', '49', 'http://www.tctianyi.com/file/upload/201704/06/1412048819.jpg.thumb.jpg', '8393', 'jpg', 'album', '240', '180', '1491459124', 'hulunbeier', '127.0.0.1');
INSERT INTO `ty_upload_9` VALUES ('6', '845495702a37612d5e17684c2bc36208', '16', '51', 'http://www.tctianyi.com/file/upload/201704/06/1424249519.jpg.thumb.jpg', '12728', 'jpg', 'album', '500', '364', '1491459864', 'hulunbeier', '127.0.0.1');
INSERT INTO `ty_upload_9` VALUES ('5', '9043588527140b10267ab7ed218733db', '16', '50', 'http://www.tctianyi.com/file/upload/201704/06/1416324219.png.thumb.png', '50299', 'png', 'album', '285', '207', '1491459392', 'hulunbeier', '127.0.0.1');
INSERT INTO `ty_upload_9` VALUES ('7', 'd1c522579c98be045e3f1c7fb51af0a8', '16', '51', 'http://www.tctianyi.com/file/upload/201704/06/1424289919.jpg.thumb.jpg', '21563', 'jpg', 'album', '651', '426', '1491459868', 'hulunbeier', '127.0.0.1');
INSERT INTO `ty_upload_9` VALUES ('8', 'a401c26705bf7c7ce6ca1a4750208b0a', '16', '51', 'http://www.tctianyi.com/file/upload/201704/06/1424318719.jpg.thumb.jpg', '39266', 'jpg', 'album', '650', '491', '1491459871', 'hulunbeier', '127.0.0.1');

-- ----------------------------
-- Table structure for ty_validate
-- ----------------------------
DROP TABLE IF EXISTS `ty_validate`;
CREATE TABLE `ty_validate` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(30) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `thumb1` varchar(255) NOT NULL DEFAULT '',
  `thumb2` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='资料认证';

-- ----------------------------
-- Records of ty_validate
-- ----------------------------
INSERT INTO `ty_validate` VALUES ('1', '平请求', 'truename', 'http://www.tctianyi.com/file/upload/201704/07/1643217814.jpg', 'http://www.tctianyi.com/file/upload/201704/07/1643266214.jpg', 'http://www.tctianyi.com/file/upload/201704/07/1643312014.jpg', 'shandongpingyi', '1491554623', 'tianyi', '1491554635', '127.0.0.1', '3');
INSERT INTO `ty_validate` VALUES ('2', '13084901@qq.com', 'email', '', '', '', 'shandongpingyi', '1491808802', 'system', '1491808802', '127.0.0.1', '3');

-- ----------------------------
-- Table structure for ty_video_14
-- ----------------------------
DROP TABLE IF EXISTS `ty_video_14`;
CREATE TABLE `ty_video_14` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `fee` float NOT NULL DEFAULT '0',
  `tag` varchar(255) NOT NULL DEFAULT '',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `pptword` varchar(255) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `video` varchar(255) NOT NULL DEFAULT '',
  `mobile` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `width` smallint(4) unsigned NOT NULL DEFAULT '0',
  `height` smallint(4) unsigned NOT NULL DEFAULT '0',
  `player` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `filepath` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `addtime` (`addtime`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频';

-- ----------------------------
-- Records of ty_video_14
-- ----------------------------

-- ----------------------------
-- Table structure for ty_video_data_14
-- ----------------------------
DROP TABLE IF EXISTS `ty_video_data_14`;
CREATE TABLE `ty_video_data_14` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频内容';

-- ----------------------------
-- Records of ty_video_data_14
-- ----------------------------

-- ----------------------------
-- Table structure for ty_vote
-- ----------------------------
DROP TABLE IF EXISTS `ty_vote`;
CREATE TABLE `ty_vote` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(10) unsigned NOT NULL DEFAULT '0',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `groupid` varchar(255) NOT NULL,
  `verify` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `choose` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vote_min` smallint(2) unsigned NOT NULL DEFAULT '0',
  `vote_max` smallint(2) unsigned NOT NULL DEFAULT '0',
  `votes` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fromtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `linkto` varchar(255) NOT NULL DEFAULT '',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `template_vote` varchar(30) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '',
  `s1` varchar(255) NOT NULL DEFAULT '',
  `s2` varchar(255) NOT NULL DEFAULT '',
  `s3` varchar(255) NOT NULL DEFAULT '',
  `s4` varchar(255) NOT NULL DEFAULT '',
  `s5` varchar(255) NOT NULL DEFAULT '',
  `s6` varchar(255) NOT NULL DEFAULT '',
  `s7` varchar(255) NOT NULL DEFAULT '',
  `s8` varchar(255) NOT NULL DEFAULT '',
  `s9` varchar(255) NOT NULL DEFAULT '',
  `s10` varchar(255) NOT NULL DEFAULT '',
  `v1` int(10) unsigned NOT NULL DEFAULT '0',
  `v2` int(10) unsigned NOT NULL DEFAULT '0',
  `v3` int(10) unsigned NOT NULL DEFAULT '0',
  `v4` int(10) unsigned NOT NULL DEFAULT '0',
  `v5` int(10) unsigned NOT NULL DEFAULT '0',
  `v6` int(10) unsigned NOT NULL DEFAULT '0',
  `v7` int(10) unsigned NOT NULL DEFAULT '0',
  `v8` int(10) unsigned NOT NULL DEFAULT '0',
  `v9` int(10) unsigned NOT NULL DEFAULT '0',
  `v10` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='投票';

-- ----------------------------
-- Records of ty_vote
-- ----------------------------

-- ----------------------------
-- Table structure for ty_vote_record
-- ----------------------------
DROP TABLE IF EXISTS `ty_vote_record`;
CREATE TABLE `ty_vote_record` (
  `rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `votetime` int(10) unsigned NOT NULL DEFAULT '0',
  `votes` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`rid`),
  KEY `itemid` (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='投票记录';

-- ----------------------------
-- Records of ty_vote_record
-- ----------------------------

-- ----------------------------
-- Table structure for ty_webpage
-- ----------------------------
DROP TABLE IF EXISTS `ty_webpage`;
CREATE TABLE `ty_webpage` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(30) NOT NULL DEFAULT '',
  `areaid` int(10) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(50) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `template` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='单网页';

-- ----------------------------
-- Records of ty_webpage
-- ----------------------------
INSERT INTO `ty_webpage` VALUES ('1', '1', '0', '0', '关于我们', '', '关于我们', '', '', '', 'destoon', '1319006891', '5', '0', '0', 'about/index.html', '', '');
INSERT INTO `ty_webpage` VALUES ('3', '1', '0', '0', '联系方式', '', '联系方式', '', '', '', 'destoon', '1310696453', '4', '0', '0', 'about/contact.html', '', '');
INSERT INTO `ty_webpage` VALUES ('4', '1', '0', '0', '使用协议', '', '使用协议', '', '', '', 'destoon', '1310696460', '3', '0', '0', 'about/agreement.html', '', '');
INSERT INTO `ty_webpage` VALUES ('5', '1', '0', '0', '版权隐私', '', '版权隐私', '', '', '', 'destoon', '1310696468', '2', '0', '0', 'about/copyright.html', '', '');

-- ----------------------------
-- Table structure for ty_weixin_bind
-- ----------------------------
DROP TABLE IF EXISTS `ty_weixin_bind`;
CREATE TABLE `ty_weixin_bind` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信扫码绑定';

-- ----------------------------
-- Records of ty_weixin_bind
-- ----------------------------

-- ----------------------------
-- Table structure for ty_weixin_chat
-- ----------------------------
DROP TABLE IF EXISTS `ty_weixin_chat`;
CREATE TABLE `ty_weixin_chat` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `editor` varchar(30) NOT NULL,
  `openid` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL,
  `event` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `misc` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`),
  KEY `openid` (`openid`),
  KEY `addtime` (`addtime`),
  KEY `event` (`event`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信消息';

-- ----------------------------
-- Records of ty_weixin_chat
-- ----------------------------

-- ----------------------------
-- Table structure for ty_weixin_user
-- ----------------------------
DROP TABLE IF EXISTS `ty_weixin_user`;
CREATE TABLE `ty_weixin_user` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `openid` varchar(255) NOT NULL DEFAULT '',
  `nickname` varchar(255) NOT NULL DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `headimgurl` varchar(255) NOT NULL,
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `visittime` int(10) unsigned NOT NULL DEFAULT '0',
  `credittime` int(10) unsigned NOT NULL DEFAULT '0',
  `subscribe` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `push` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`itemid`),
  UNIQUE KEY `openid` (`openid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信用户';

-- ----------------------------
-- Records of ty_weixin_user
-- ----------------------------
