# Host: 127.0.0.1  (Version 5.5.40-log)
# Date: 2017-02-22 11:00:48
# Generator: MySQL-Front 6.0  (Build 1.28)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ty_404"
#

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

#
# Data for table "ty_404"
#


#
# Structure for table "ty_ad"
#

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

#
# Data for table "ty_ad"
#

INSERT INTO `ty_ad` VALUES (2,'网站首页图片轮播1',14,5,0,0,'','http://www.destoon.com/','',0,'tianyi',1467860142,'tianyi',1468385623,1262275200,1577894399,0,'','','','','','','http://www.tianyi.com/file/upload/201607/13/125340421.jpg','http://www.destoon.com/','','','',1,0,0,'',0,0,3),(3,'首页旗帜A1',20,3,0,0,'','','',0,'tianyi',1467860142,'tianyi',1467860142,1262275200,1577894399,0,'','','','','','','file/image/150x60.gif','','','','',1,0,0,'',0,0,3),(4,'首页旗帜A2',21,3,0,0,'','http://idc.destoon.com/','',0,'tianyi',1467860142,'tianyi',1467860142,1262275200,1577894399,0,'','','','','','','file/image/150x60.gif','','','','',1,0,0,'',0,0,3),(5,'首页旗帜A3',22,3,0,0,'','http://www.destoon.com/','',0,'tianyi',1467860142,'tianyi',1467860142,1262275200,1577894399,0,'','','','','','','file/image/150x60.gif','','','','',1,0,0,'',0,0,3),(6,'首页旗帜A4',23,3,0,0,'','http://idc.destoon.com/','',0,'tianyi',1467860142,'tianyi',1467860142,1262275200,1577894399,0,'','','','','','','file/image/150x60.gif','','','','',1,0,0,'',0,0,3),(7,'首页旗帜A5',24,3,0,0,'','http://www.destoon.com/','',0,'tianyi',1467860142,'tianyi',1467860142,1262275200,1577894399,0,'','','','','','','file/image/150x60.gif','','','','',1,0,0,'',0,0,3),(8,'首页旗帜A6',25,3,0,0,'','http://idc.destoon.com/','',0,'tianyi',1467860142,'tianyi',1467860142,1262275200,1577894399,0,'','','','','','','file/image/150x60.gif','','','','',1,0,0,'',0,0,3),(9,'网站首页图片轮播2',14,5,0,0,'','http://www.destoon.com/','',104,'tianyi',1467860142,'tianyi',1468385634,1262275200,1577894399,0,'','','','','','','http://www.tianyi.com/file/upload/201607/13/125353611.jpg','http://www.destoon.com/','','','',1,0,0,'',0,0,3);

#
# Structure for table "ty_ad_place"
#

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

#
# Data for table "ty_ad_place"
#

INSERT INTO `ty_ad_place` VALUES (1,5,6,1,'供应排名','','','','',0,0,0,0,0,1467860142,'tianyi',1467860142,''),(2,6,6,1,'求购排名','','','','',0,0,0,0,0,1467860142,'tianyi',1467860142,''),(3,16,6,1,'商城排名','','','','',0,0,0,0,0,1467860142,'tianyi',1467860142,''),(4,4,6,1,'公司排名','','','','',0,0,0,0,0,1467860142,'tianyi',1467860142,''),(14,0,5,1,'首页图片轮播','','','','',400,160,0,2,0,1467860142,'tianyi',1467860142,''),(15,5,7,1,'供应赞助商链接','','','','',0,0,0,0,0,1467860142,'tianyi',1467860142,''),(17,4,7,1,'公司赞助商链接','','','','',0,0,0,0,0,1467860142,'tianyi',1467860142,''),(18,0,7,1,'求购赞助商链接','','','','',0,0,0,0,0,1467860142,'tianyi',1467860142,''),(19,8,7,1,'展会赞助商链接','','','','',0,0,0,0,0,1467860142,'tianyi',1467860142,''),(20,0,3,1,'首页旗帜A1','','','','',150,60,0,1,0,1467860142,'tianyi',1467860142,''),(21,0,3,1,'首页旗帜A2','','','','',150,60,0,1,0,1467860142,'tianyi',1467860142,''),(22,0,3,1,'首页旗帜A3','','','','',150,60,0,1,0,1467860142,'tianyi',1467860142,''),(23,0,3,1,'首页旗帜A4','','','','',150,60,0,1,0,1467860142,'tianyi',1467860142,''),(24,0,3,1,'首页旗帜A5','','','','',150,60,0,1,0,1467860142,'tianyi',1467860142,''),(25,0,3,1,'首页旗帜A6','','','','',150,60,0,1,0,1467860142,'tianyi',1467860142,'');

#
# Structure for table "ty_address"
#

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
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='收货地址';

#
# Data for table "ty_address"
#


#
# Structure for table "ty_admin"
#

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

#
# Data for table "ty_admin"
#

INSERT INTO `ty_admin` VALUES (1,1,0,'生成首页','?action=html','',0,'','',''),(2,1,0,'更新缓存','?action=cache','',0,'','',''),(3,1,0,'网站设置','?file=setting','',0,'','',''),(4,1,0,'模块管理','?file=module','',0,'','',''),(5,1,0,'数据维护','?file=database','',0,'','',''),(6,1,0,'模板管理','?file=template','',0,'','',''),(7,1,0,'会员管理','?moduleid=2','',0,'','',''),(8,1,0,'单页管理','?moduleid=3&file=webpage','',0,'','',''),(9,1,0,'排名推广','?moduleid=3&file=spread','',0,'','',''),(10,1,0,'广告管理','?moduleid=3&file=ad','',0,'','','');

#
# Structure for table "ty_admin_log"
#

CREATE TABLE `ty_admin_log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qstring` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `logtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理日志';

#
# Data for table "ty_admin_log"
#


#
# Structure for table "ty_admin_online"
#

CREATE TABLE `ty_admin_online` (
  `sid` varchar(32) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `qstring` varchar(255) NOT NULL DEFAULT '',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `sid` (`sid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='在线管理员';

#
# Data for table "ty_admin_online"
#


#
# Structure for table "ty_alert"
#

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

#
# Data for table "ty_alert"
#


#
# Structure for table "ty_announce"
#

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

#
# Data for table "ty_announce"
#


#
# Structure for table "ty_area"
#

CREATE TABLE `ty_area` (
  `areaid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `areaname` varchar(50) NOT NULL DEFAULT '',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL DEFAULT '',
  `child` tinyint(1) NOT NULL DEFAULT '0',
  `arrchildid` text NOT NULL,
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`areaid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='地区';

#
# Data for table "ty_area"
#

INSERT INTO `ty_area` VALUES (1,'默认地区',0,'0',0,'1',1);

#
# Structure for table "ty_article_21"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资讯';

#
# Data for table "ty_article_21"
#


#
# Structure for table "ty_article_data_21"
#

CREATE TABLE `ty_article_data_21` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资讯内容';

#
# Data for table "ty_article_data_21"
#


#
# Structure for table "ty_ask"
#

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

#
# Data for table "ty_ask"
#


#
# Structure for table "ty_banip"
#

CREATE TABLE `ty_banip` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='IP禁止';

#
# Data for table "ty_banip"
#


#
# Structure for table "ty_banword"
#

CREATE TABLE `ty_banword` (
  `bid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `replacefrom` varchar(255) NOT NULL DEFAULT '',
  `replaceto` varchar(255) NOT NULL DEFAULT '',
  `deny` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='词语过滤';

#
# Data for table "ty_banword"
#


#
# Structure for table "ty_brand_13"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='品牌';

#
# Data for table "ty_brand_13"
#


#
# Structure for table "ty_brand_data_13"
#

CREATE TABLE `ty_brand_data_13` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='品牌内容';

#
# Data for table "ty_brand_data_13"
#


#
# Structure for table "ty_buy_6"
#

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

#
# Data for table "ty_buy_6"
#


#
# Structure for table "ty_buy_data_6"
#

CREATE TABLE `ty_buy_data_6` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='求购内容';

#
# Data for table "ty_buy_data_6"
#


#
# Structure for table "ty_cache"
#

CREATE TABLE `ty_cache` (
  `cacheid` varchar(32) NOT NULL DEFAULT '',
  `totime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `cacheid` (`cacheid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件缓存';

#
# Data for table "ty_cache"
#


#
# Structure for table "ty_category"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='栏目分类';

#
# Data for table "ty_category"
#

INSERT INTO `ty_category` VALUES (1,5,'供应默认分类','','1','list.php?catid=1','',1,0,0,0,'0',0,'',1,'','','','','','','',''),(2,6,'求购默认分类','','1','list.php?catid=2','',1,0,0,0,'0',0,'',1,'','','','','','','',''),(3,4,'公司默认分类','','1','list.php?catid=3','',1,0,0,0,'0',0,'',1,'','','','','','','',''),(4,16,'装修主材','','zhuangxiu','list.php?catid=4','z',1,6,0,0,'0',1,'4,12,13,14,15',4,'','','','','','3,5,6,7','3,5,6,7',''),(5,16,'通风空调','','tongfengkongdiao','list.php?catid=5','t',1,0,0,0,'0',1,'5,16,17,18,19',5,'','','','','','3,5,6,7','3,5,6,7',''),(6,16,'电工电气/安防','','diangongdianqi','list.php?catid=6','d',1,0,0,0,'0',1,'6,20,21,22,23',6,'','','','','','3,5,6,7','3,5,6,7',''),(7,16,'管材管件','','guancaiguanjian','list.php?catid=7','g',1,0,0,0,'0',1,'7,24,25,26,27',7,'','','','','','3,5,6,7','3,5,6,7',''),(8,16,'实验室家具','','shiyanshi','list.php?catid=8','s',1,0,0,0,'0',1,'8,28,29,30,31',8,'','','','','','3,5,6,7','3,5,6,7',''),(9,16,'仪器设备','','yiqishebei','list.php?catid=9','y',1,0,0,0,'0',1,'9,32,33,34,35',9,'','','','','','3,5,6,7','3,5,6,7',''),(10,16,'采暖/热泵','','cainuan','list.php?catid=10','c',1,0,0,0,'0',1,'10,36,37,38,39',10,'','','','','','3,5,6,7','3,5,6,7',''),(11,16,'辅材/工具','','gongju','list.php?catid=11','g',1,0,0,0,'0',1,'11,40,41,42,43',11,'','','','','','3,5,6,7','3,5,6,7',''),(12,16,'彩钢板','','caigangban','list.php?catid=12','c',1,2,0,4,'0,4',0,'12',12,'','','','','','3,5,6,7','3,5,6,7',''),(13,16,'铝扣板','','lvkouban','list.php?catid=13','l',1,0,0,4,'0,4',0,'13',13,'','','','','','3,5,6,7','3,5,6,7',''),(14,16,'瓷砖地板','','cizhuandiban','list.php?catid=14','c',1,0,0,4,'0,4',0,'14',14,'','','','','','3,5,6,7','3,5,6,7',''),(15,16,'PVC地板','','PVCdiban','list.php?catid=15','p',1,0,0,4,'0,4',0,'15',15,'','','','','','3,5,6,7','3,5,6,7',''),(16,16,'空调主机','','kongdiaozhuji','list.php?catid=16','k',1,0,0,5,'0,5',0,'16',16,'','','','','','3,5,6,7','3,5,6,7',''),(17,16,'空调末端','','kongdiaomoduan','list.php?catid=17','k',1,0,0,5,'0,5',0,'17',17,'','','','','','3,5,6,7','3,5,6,7',''),(18,16,'商用空调','','shangyongkongdiao','list.php?catid=18','s',1,0,0,5,'0,5',0,'18',18,'','','','','','3,5,6,7','3,5,6,7',''),(19,16,'风机','','fengji','list.php?catid=19','f',1,0,0,5,'0,5',0,'19',19,'','','','','','3,5,6,7','3,5,6,7',''),(20,16,'电缆','','dianlan','list.php?catid=20','d',1,2,0,6,'0,6',0,'20',20,'','','','','','3,5,6,7','3,5,6,7',''),(21,16,'电线','','dianxian','list.php?catid=21','d',1,1,0,6,'0,6',0,'21',21,'','','','','','3,5,6,7','3,5,6,7',''),(22,16,'开关','','kaiguan','list.php?catid=22','k',1,2,0,6,'0,6',0,'22',22,'','','','','','3,5,6,7','3,5,6,7',''),(23,16,'灯具','','dengju','list.php?catid=23','d',1,1,0,6,'0,6',0,'23',23,'','','','','','3,5,6,7','3,5,6,7',''),(24,16,'镀锌钢管','','duxingangguan','list.php?catid=24','d',1,0,0,7,'0,7',0,'24',24,'','','','','','3,5,6,7','3,5,6,7',''),(25,16,'不锈钢钢管','','buxiuganggangguan','list.php?catid=25','b',1,2,0,7,'0,7',0,'25',25,'','','','','','3,5,6,7','3,5,6,7',''),(26,16,'PPR钢管','','PPRgangguan','list.php?catid=26','p',1,0,0,7,'0,7',0,'26',26,'','','','','','3,5,6,7','3,5,6,7',''),(27,16,'PVC管','','PVCguan','list.php?catid=27','p',1,0,0,7,'0,7',0,'27',27,'','','','','','3,5,6,7','3,5,6,7',''),(28,16,'中央台','','zhongyangtai','list.php?catid=28','z',1,0,0,8,'0,8',0,'28',28,'','','','','','3,5,6,7','3,5,6,7',''),(29,16,'边台','','biantai','list.php?catid=29','b',1,0,0,8,'0,8',0,'29',29,'','','','','','3,5,6,7','3,5,6,7',''),(30,16,'取材台','','qucaitai','list.php?catid=30','q',1,0,0,8,'0,8',0,'30',30,'','','','','','3,5,6,7','3,5,6,7',''),(31,16,'办公家具','','bangongjiaju','list.php?catid=31','b',1,0,0,8,'0,8',0,'31',31,'','','','','','3,5,6,7','3,5,6,7',''),(32,16,'PCR仪','','PCRyi','list.php?catid=32','p',1,0,0,9,'0,9',0,'32',32,'','','','','','3,5,6,7','3,5,6,7',''),(33,16,'免疫仪','','mianyiyi','list.php?catid=33','m',1,0,0,9,'0,9',0,'33',33,'','','','','','3,5,6,7','3,5,6,7',''),(34,16,'通风柜','','tongfenggui','list.php?catid=34','t',1,0,0,9,'0,9',0,'34',34,'','','','','','3,5,6,7','3,5,6,7',''),(35,16,'生物安全柜','','shengwuanquangui','list.php?catid=35','s',1,0,0,9,'0,9',0,'35',35,'','','','','','3,5,6,7','3,5,6,7',''),(36,16,'电采暖','','diancainuan','list.php?catid=36','d',1,0,0,10,'0,10',0,'36',36,'','','','','','3,5,6,7','3,5,6,7',''),(37,16,'水源热泵机组','','shuiyuanrebengjizu','list.php?catid=37','s',1,0,0,10,'0,10',0,'37',37,'','','','','','3,5,6,7','3,5,6,7',''),(38,16,'商用热泵','','shangyongrebeng','list.php?catid=38','s',1,0,0,10,'0,10',0,'38',38,'','','','','','3,5,6,7','3,5,6,7',''),(39,16,'伸缩器','','shensuoqi','list.php?catid=39','s',1,0,0,10,'0,10',0,'39',39,'','','','','','3,5,6,7','3,5,6,7',''),(40,16,'切割机','','qiegeji','list.php?catid=40','q',1,0,0,11,'0,11',0,'40',40,'','','','','','3,5,6,7','3,5,6,7',''),(41,16,'手电钻','','shoudianzuan','list.php?catid=41','s',1,0,0,11,'0,11',0,'41',41,'','','','','','3,5,6,7','3,5,6,7',''),(42,16,'激光测距仪','','jiguangcejuyi','list.php?catid=42','j',1,0,0,11,'0,11',0,'42',42,'','','','','','3,5,6,7','3,5,6,7',''),(43,16,'万用表','','wanyongbiao','list.php?catid=43','w',1,1,0,11,'0,11',0,'43',43,'','','','','','3,5,6,7','3,5,6,7','');

#
# Structure for table "ty_category_option"
#

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

#
# Data for table "ty_category_option"
#


#
# Structure for table "ty_category_value"
#

CREATE TABLE `ty_category_value` (
  `oid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `value` text NOT NULL,
  KEY `moduleid` (`moduleid`,`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类属性值';

#
# Data for table "ty_category_value"
#


#
# Structure for table "ty_chat"
#

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

#
# Data for table "ty_chat"
#


#
# Structure for table "ty_city"
#

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

#
# Data for table "ty_city"
#


#
# Structure for table "ty_club"
#

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

#
# Data for table "ty_club"
#


#
# Structure for table "ty_club_data"
#

CREATE TABLE `ty_club_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商圈帖子内容';

#
# Data for table "ty_club_data"
#


#
# Structure for table "ty_club_fans"
#

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

#
# Data for table "ty_club_fans"
#


#
# Structure for table "ty_club_group"
#

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

#
# Data for table "ty_club_group"
#


#
# Structure for table "ty_club_manage"
#

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

#
# Data for table "ty_club_manage"
#


#
# Structure for table "ty_club_reply"
#

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

#
# Data for table "ty_club_reply"
#


#
# Structure for table "ty_comment"
#

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

#
# Data for table "ty_comment"
#


#
# Structure for table "ty_comment_ban"
#

CREATE TABLE `ty_comment_ban` (
  `bid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `moduleid` smallint(6) NOT NULL DEFAULT '0',
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `editor` varchar(30) NOT NULL DEFAULT '',
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论禁止';

#
# Data for table "ty_comment_ban"
#


#
# Structure for table "ty_comment_stat"
#

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

#
# Data for table "ty_comment_stat"
#


#
# Structure for table "ty_company"
#

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
  PRIMARY KEY (`userid`),
  KEY `domain` (`domain`),
  KEY `vip` (`vip`),
  KEY `areaid` (`areaid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司';

#
# Data for table "ty_company"
#

INSERT INTO `ty_company` VALUES (1,'tianyi',1,'天医',0,0,'',0,0,0,0,'企业单位','','',1,'',0,'人民币','','','','','','','','','','','','',0,0,0,'','',3,'天医默认地区,,,,','','','','','http://www.tianyi.com/index.php?homepage=tianyi'),(3,'hekw07',5,'天医',0,0,'',0,0,0,0,'','','',1,'',0,'','','','','','','','','','','','','',0,0,0,'','',0,'天医','','','','','http://www.tianyi.com/index.php?homepage=hekw07'),(4,'hekw08',5,'何楷伟',0,0,'',0,0,0,0,'','','',1,'',0,'','','','','','','','','','','','','',0,0,0,'','',0,'何楷伟','','','','','http://www.tianyi.com/index.php?homepage=hekw08');

#
# Structure for table "ty_company_data"
#

CREATE TABLE `ty_company_data` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司内容';

#
# Data for table "ty_company_data"
#

INSERT INTO `ty_company_data` VALUES (1,'&nbsp;'),(3,''),(4,'');

#
# Structure for table "ty_company_setting"
#

CREATE TABLE `ty_company_setting` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `item_key` varchar(100) NOT NULL DEFAULT '',
  `item_value` text NOT NULL,
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司设置';

#
# Data for table "ty_company_setting"
#


#
# Structure for table "ty_cron"
#

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

#
# Data for table "ty_cron"
#

INSERT INTO `ty_cron` VALUES (1,'更新在线状态',1,'online','10',1487731617,1487732217,0,''),(2,'内容分表创建',1,'split','0,0',1487731617,1487779200,0,''),(3,'清理过期文件缓存',0,'cache','30',1487731617,1487733417,0,''),(20,'清理过期禁止IP',0,'banip','0,10',1487731617,1487779800,0,''),(21,'清理系统临时文件',0,'temp','0,20',1487731617,1487780400,0,''),(40,'清理3天前未付款充值记录',0,'charge','1,0',1487731617,1487782800,0,''),(41,'清理30天前404日志',0,'404','1,10',1487731617,1487783400,0,''),(42,'清理30天前登录日志',0,'loginlog','1,20',1487731617,1487784000,0,''),(43,'清理30天前管理日志',0,'adminlog','1,30',1487731617,1487784600,0,''),(44,'清理30天前站内交谈',0,'chat','1,40',1487731617,1487785200,0,''),(60,'清理90天前已读信件',0,'message','2,0',0,0,1,''),(61,'清理90天前资金流水',0,'money','2,10',0,0,1,''),(62,'清理90天前积分流水',0,'credit','2,20',0,0,1,''),(63,'清理90天前短信流水',0,'sms','2,30',0,0,1,''),(64,'清理90天前短信记录',0,'smssend','2,40',0,0,1,''),(65,'清理90天前邮件记录',0,'maillog','2,50',0,0,1,'');

#
# Structure for table "ty_down_15"
#

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

#
# Data for table "ty_down_15"
#


#
# Structure for table "ty_down_data_15"
#

CREATE TABLE `ty_down_data_15` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='下载内容';

#
# Data for table "ty_down_data_15"
#


#
# Structure for table "ty_exhibit"
#

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

#
# Data for table "ty_exhibit"
#


#
# Structure for table "ty_exhibit_data"
#

CREATE TABLE `ty_exhibit_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='展会内容';

#
# Data for table "ty_exhibit_data"
#


#
# Structure for table "ty_exhibit_order"
#

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

#
# Data for table "ty_exhibit_order"
#


#
# Structure for table "ty_favorite"
#

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

#
# Data for table "ty_favorite"
#


#
# Structure for table "ty_fetch"
#

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

#
# Data for table "ty_fetch"
#


#
# Structure for table "ty_fields"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='自定义字段';

#
# Data for table "ty_fields"
#


#
# Structure for table "ty_finance_card"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='充值卡';

#
# Data for table "ty_finance_card"
#


#
# Structure for table "ty_finance_cash"
#

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

#
# Data for table "ty_finance_cash"
#


#
# Structure for table "ty_finance_charge"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='在线充值';

#
# Data for table "ty_finance_charge"
#


#
# Structure for table "ty_finance_credit"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COMMENT='积分流水';

#
# Data for table "ty_finance_credit"
#

INSERT INTO `ty_finance_credit` VALUES (1,'tianyi',1,1,1468201120,'登录奖励','127.0.0.1','system'),(2,'tianyi',1,2,1468383957,'登录奖励','127.0.0.1','system'),(3,'tianyi',1,3,1475897949,'登录奖励','127.0.0.1','system'),(5,'tianyi',1,4,1477964440,'登录奖励','127.0.0.1','system'),(6,'hekw07',20,20,1481705047,'注册奖励','127.0.0.1','system'),(7,'tianyi',1,5,1481705090,'登录奖励','127.0.0.1','system'),(8,'hekw08',20,20,1482717451,'注册奖励','127.0.0.1','system'),(9,'tianyi',1,6,1482717501,'登录奖励','127.0.0.1','system'),(10,'tianyi',1,7,1483514446,'登录奖励','127.0.0.1','system'),(11,'tianyi',1,8,1483889810,'登录奖励','127.0.0.1','system'),(12,'tianyi',1,9,1484463592,'登录奖励','127.0.0.1','system'),(13,'tianyi',2,11,1484810894,'产品发布','ID:1','system'),(14,'tianyi',2,13,1484811970,'产品发布','ID:2','system'),(15,'tianyi',2,15,1484812013,'产品发布','ID:3','system'),(16,'tianyi',2,17,1484812040,'产品发布','ID:4','system'),(17,'tianyi',2,19,1484812328,'产品发布','ID:5','system'),(18,'tianyi',2,21,1484812354,'产品发布','ID:6','system'),(19,'tianyi',2,23,1484815778,'产品发布','ID:7','system'),(20,'tianyi',2,25,1484815809,'产品发布','ID:8','system'),(21,'tianyi',1,26,1484881254,'登录奖励','127.0.0.1','system'),(22,'tianyi',2,28,1484881636,'产品发布','ID:9','system'),(23,'tianyi',2,30,1484881670,'产品发布','ID:10','system'),(24,'tianyi',2,32,1484881711,'产品发布','ID:11','system'),(25,'tianyi',2,34,1484881762,'产品发布','ID:12','system'),(26,'tianyi',2,36,1484881931,'产品发布','ID:13','system'),(27,'tianyi',2,38,1484881997,'产品发布','ID:14','system'),(28,'tianyi',2,40,1484882144,'产品发布','ID:15','system'),(29,'tianyi',2,42,1484882251,'产品发布','ID:16','system'),(30,'tianyi',2,44,1484882305,'产品发布','ID:17','system'),(31,'tianyi',2,46,1484882474,'产品发布','ID:18','system'),(32,'tianyi',2,48,1484882736,'产品发布','ID:19','system'),(33,'tianyi',2,50,1484882809,'产品发布','ID:20','system'),(34,'tianyi',2,52,1484882921,'产品发布','ID:21','system'),(35,'tianyi',2,54,1484882948,'产品发布','ID:22','system'),(36,'tianyi',2,56,1484883147,'产品发布','ID:23','system'),(37,'tianyi',2,58,1484883188,'产品发布','ID:24','system'),(38,'tianyi',2,60,1484883325,'产品发布','ID:25','system'),(39,'tianyi',2,62,1484883357,'产品发布','ID:26','system'),(40,'tianyi',2,64,1484883489,'产品发布','ID:27','system'),(41,'tianyi',2,66,1484883608,'产品发布','ID:28','system'),(42,'tianyi',2,68,1484883765,'产品发布','ID:29','system'),(43,'tianyi',2,70,1484883800,'产品发布','ID:30','system'),(44,'tianyi',2,72,1484884344,'产品发布','ID:31','system'),(45,'tianyi',2,74,1484884440,'产品发布','ID:32','system'),(46,'tianyi',2,76,1484884499,'产品发布','ID:33','system'),(47,'tianyi',2,78,1484884569,'产品发布','ID:34','system'),(48,'tianyi',2,80,1484884615,'产品发布','ID:35','system'),(49,'tianyi',2,82,1484884680,'产品发布','ID:36','system'),(50,'tianyi',2,84,1484892357,'产品发布','ID:37','system'),(51,'tianyi',2,86,1484892478,'产品发布','ID:38','system'),(52,'tianyi',2,88,1484892617,'产品发布','ID:39','system'),(53,'tianyi',2,90,1484892659,'产品发布','ID:40','system'),(54,'tianyi',2,92,1484892798,'产品发布','ID:41','system'),(55,'tianyi',2,94,1484892900,'产品发布','ID:42','system'),(56,'tianyi',2,96,1484893067,'产品发布','ID:43','system'),(57,'tianyi',2,98,1484893206,'产品发布','ID:44','system'),(58,'tianyi',2,100,1484893233,'产品发布','ID:45','system'),(59,'tianyi',2,102,1484893325,'产品发布','ID:46','system'),(60,'tianyi',2,104,1484893363,'产品发布','ID:47','system'),(61,'tianyi',2,106,1484893425,'产品发布','ID:48','system'),(62,'tianyi',1,107,1485065713,'登录奖励','127.0.0.1','system'),(63,'tianyi',1,108,1486189258,'登录奖励','127.0.0.1','system'),(64,'tianyi',1,109,1486455664,'登录奖励','127.0.0.1','system');

#
# Structure for table "ty_finance_deposit"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保证金';

#
# Data for table "ty_finance_deposit"
#


#
# Structure for table "ty_finance_pay"
#

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

#
# Data for table "ty_finance_pay"
#


#
# Structure for table "ty_finance_promo"
#

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

#
# Data for table "ty_finance_promo"
#


#
# Structure for table "ty_finance_record"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='财务流水';

#
# Data for table "ty_finance_record"
#


#
# Structure for table "ty_finance_sms"
#

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

#
# Data for table "ty_finance_sms"
#


#
# Structure for table "ty_form"
#

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

#
# Data for table "ty_form"
#


#
# Structure for table "ty_form_answer"
#

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

#
# Data for table "ty_form_answer"
#


#
# Structure for table "ty_form_question"
#

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

#
# Data for table "ty_form_question"
#


#
# Structure for table "ty_form_record"
#

CREATE TABLE `ty_form_record` (
  `rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `item` varchar(100) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='表单回复记录';

#
# Data for table "ty_form_record"
#


#
# Structure for table "ty_friend"
#

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

#
# Data for table "ty_friend"
#


#
# Structure for table "ty_gift"
#

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

#
# Data for table "ty_gift"
#


#
# Structure for table "ty_gift_order"
#

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

#
# Data for table "ty_gift_order"
#


#
# Structure for table "ty_group"
#

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

#
# Data for table "ty_group"
#


#
# Structure for table "ty_group_data"
#

CREATE TABLE `ty_group_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团购内容';

#
# Data for table "ty_group_data"
#


#
# Structure for table "ty_group_order"
#

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

#
# Data for table "ty_group_order"
#


#
# Structure for table "ty_guestbook"
#

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

#
# Data for table "ty_guestbook"
#


#
# Structure for table "ty_honor"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='荣誉资质';

#
# Data for table "ty_honor"
#


#
# Structure for table "ty_info_22"
#

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

#
# Data for table "ty_info_22"
#


#
# Structure for table "ty_info_data_22"
#

CREATE TABLE `ty_info_data_22` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='招商内容';

#
# Data for table "ty_info_data_22"
#


#
# Structure for table "ty_job"
#

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

#
# Data for table "ty_job"
#


#
# Structure for table "ty_job_apply"
#

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

#
# Data for table "ty_job_apply"
#


#
# Structure for table "ty_job_data"
#

CREATE TABLE `ty_job_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='招聘内容';

#
# Data for table "ty_job_data"
#


#
# Structure for table "ty_job_talent"
#

CREATE TABLE `ty_job_talent` (
  `talentid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `resumeid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `jointime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`talentid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='人才库';

#
# Data for table "ty_job_talent"
#


#
# Structure for table "ty_keylink"
#

CREATE TABLE `ty_keylink` (
  `itemid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `item` varchar(20) NOT NULL DEFAULT '',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`),
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关联链接';

#
# Data for table "ty_keylink"
#


#
# Structure for table "ty_keyword"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关键词';

#
# Data for table "ty_keyword"
#


#
# Structure for table "ty_know"
#

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

#
# Data for table "ty_know"
#


#
# Structure for table "ty_know_answer"
#

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

#
# Data for table "ty_know_answer"
#


#
# Structure for table "ty_know_data"
#

CREATE TABLE `ty_know_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='知道内容';

#
# Data for table "ty_know_data"
#


#
# Structure for table "ty_know_expert"
#

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

#
# Data for table "ty_know_expert"
#


#
# Structure for table "ty_know_vote"
#

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

#
# Data for table "ty_know_vote"
#


#
# Structure for table "ty_link"
#

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

#
# Data for table "ty_link"
#

INSERT INTO `ty_link` VALUES (1,1,0,'天成医疗网','','','天成医疗网','',1467860142,'tianyi',1468385214,0,1,3,'http://www.tecenet.com/');

#
# Structure for table "ty_login"
#

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

#
# Data for table "ty_login"
#


#
# Structure for table "ty_mail"
#

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

#
# Data for table "ty_mail"
#


#
# Structure for table "ty_mail_list"
#

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

#
# Data for table "ty_mail_list"
#


#
# Structure for table "ty_mail_log"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邮件记录';

#
# Data for table "ty_mail_log"
#


#
# Structure for table "ty_mall"
#

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
  PRIMARY KEY (`itemid`),
  KEY `username` (`username`),
  KEY `editdate` (`editdate`,`vip`,`edittime`),
  KEY `catid` (`catid`),
  KEY `areaid` (`areaid`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='商城';

#
# Data for table "ty_mall"
#

INSERT INTO `ty_mall` VALUES (1,12,0,1,1,0,'安普AMP 超五类非屏蔽电缆 6-219586-4 305米每箱','',0,'','',480.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"480.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',1000,'件','','安普AMP 超五类非屏蔽电缆 6-219586-4 305米每箱,装修主材,彩钢板','',3,0,0,0,'http://www.tctianyi.com/file/upload/201701/19/152759561.png.thumb.png','http://www.tctianyi.com/file/upload/201701/19/152807241.png.thumb.png','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484810894,'2017-01-19',1484810833,'2017-01-19','127.0.0.1','',3,'show.php?itemid=1','',''),(2,12,0,1,1,0,'装修主材--彩钢板--测试2','',0,'','',560.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"560.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',1000,'件','','装修主材--彩钢板--测试2,装修主材,彩钢板','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/19/154553961.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484811970,'2017-01-19',1484811889,'2017-01-19','127.0.0.1','',3,'show.php?itemid=2','',''),(3,13,0,1,1,0,'装修主材--铝扣板--测试1','',0,'','',400.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"400.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',1000,'件','','装修主材--铝扣板--测试1,装修主材,铝扣板','',1,0,0,0,'http://www.tctianyi.com/file/upload/201701/19/154631131.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484812013,'2017-01-19',1484811971,'2017-01-19','127.0.0.1','',3,'show.php?itemid=3','',''),(4,13,0,1,1,0,'装修主材--铝扣板--测试2','',0,'','',200.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',10000,'件','','装修主材--铝扣板--测试2,装修主材,铝扣板','',1,0,0,0,'http://www.tctianyi.com/file/upload/201701/19/154708591.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484812050,'2017-01-19',1484812013,'2017-01-19','127.0.0.1','',3,'show.php?itemid=4','',''),(5,14,0,1,1,0,'装修主材--瓷砖地板--测试1','',0,'','',50.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"50.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',10000,'件','','装修主材--瓷砖地板--测试1,装修主材,瓷砖地板','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/19/155200531.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484812328,'2017-01-19',1484812224,'2017-01-19','127.0.0.1','',3,'show.php?itemid=5','',''),(6,14,0,1,1,0,'装修主材--瓷砖地板--测试2','',0,'','',45.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:5:\"45.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',100000,'件','','装修主材--瓷砖地板--测试2,装修主材,瓷砖地板','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/19/155225661.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484812354,'2017-01-19',1484812328,'2017-01-19','127.0.0.1','',3,'show.php?itemid=6','',''),(7,16,0,1,1,0,'通风空调--空调主机--测试1','',0,'','',3800.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3800.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200,'件','','通风空调--空调主机--测试1,通风空调,空调主机','',1,0,0,0,'http://www.tctianyi.com/file/upload/201701/19/164930471.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484815778,'2017-01-19',1484815583,'2017-01-19','127.0.0.1','',3,'show.php?itemid=7','',''),(8,16,0,1,1,0,'通风空调--空调主机--测试2','',0,'','',4000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"4000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200,'件','','通风空调--空调主机--测试2,通风空调,空调主机','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/19/165000481.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484815809,'2017-01-19',1484815778,'2017-01-19','127.0.0.1','',3,'show.php?itemid=8','',''),(9,17,0,1,1,0,'通风空调--空调末端--测试1','',0,'','',10000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"10000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',100,'件','','通风空调--空调末端--测试1,通风空调,空调末端','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/110702451.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484881636,'2017-01-20',1484881586,'2017-01-20','127.0.0.1','',3,'show.php?itemid=9','',''),(10,18,0,1,1,0,'通风空调--商用空调--测试1','',0,'','',12000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"12000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',1000,'件','','通风空调--商用空调--测试1,通风空调,商用空调','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/110742761.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484881670,'2017-01-20',1484881636,'2017-01-20','127.0.0.1','',3,'show.php?itemid=10','',''),(11,19,0,1,1,0,'通风空调--风机--测试1','',0,'','',50000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"50000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200,'件','','通风空调--风机--测试1,通风空调,风机','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/110819481.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484881711,'2017-01-20',1484881670,'2017-01-20','127.0.0.1','',3,'show.php?itemid=11','',''),(12,17,0,1,1,0,'通风空调--空调末端--测试2','',0,'','',60000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"60000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',2000,'件','','通风空调--空调末端--测试2,通风空调,空调末端','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/110857771.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484881775,'2017-01-20',1484881727,'2017-01-20','127.0.0.1','',3,'show.php?itemid=12','',''),(13,20,0,1,1,0,'电工电气/安防---电缆--测试1','',0,'','',100.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"100.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',3000,'件','','电工电气/安防---电缆--测试1,电工电气/安防,电缆','',1,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/111146231.jpg.thumb.jpg','http://www.tctianyi.com/file/upload/201701/20/111158581.jpg.thumb.jpg','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484881931,'2017-01-20',1484881844,'2017-01-20','127.0.0.1','',3,'show.php?itemid=13','',''),(14,20,0,1,1,0,'电工电气/安防---电缆--测试2','',0,'','',3000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',3000,'件','','电工电气/安防---电缆--测试2,电工电气/安防,电缆','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/111302171.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484881997,'2017-01-20',1484881931,'2017-01-20','127.0.0.1','',3,'show.php?itemid=14','',''),(15,21,0,1,1,0,'电工电气/安防---电线--测试1','',0,'','',300.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"300.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',4000,'件','','电工电气/安防---电线--测试1,电工电气/安防,电线','',1,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/111528731.jpg.thumb.jpg','http://www.tctianyi.com/file/upload/201701/20/111534741.jpg.thumb.jpg','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484882144,'2017-01-20',1484881997,'2017-01-20','127.0.0.1','',3,'show.php?itemid=15','',''),(16,22,0,1,1,0,'电工电气/安防---开关--测试1','',0,'','',200.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',4000,'件','','电工电气/安防---开关--测试1,电工电气/安防,开关','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/111715341.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484882251,'2017-01-20',1484882144,'2017-01-20','127.0.0.1','',3,'show.php?itemid=16','',''),(17,22,0,1,1,0,'电工电气/安防---开关--测试2','',0,'','',100.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"100.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',5000,'件','','电工电气/安防---开关--测试2,电工电气/安防,开关','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/111812951.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484882305,'2017-01-20',1484882251,'2017-01-20','127.0.0.1','',3,'show.php?itemid=17','',''),(18,23,0,1,1,0,'电工电气/安防---灯具--测试1','',0,'','',5000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',100,'件','','电工电气/安防---灯具--测试1,电工电气/安防,灯具','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/112106911.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484882474,'2017-01-20',1484882305,'2017-01-20','127.0.0.1','',3,'show.php?itemid=18','',''),(19,24,0,1,1,0,'管材管件--镀锌钢管--测试商品1','',0,'','',4000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"4000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200000,'件','','管材管件--镀锌钢管--测试商品1,管材管件,镀锌钢管','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/112458441.jpg.thumb.jpg','http://www.tctianyi.com/file/upload/201701/20/112513561.jpg.thumb.jpg','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484882736,'2017-01-20',1484882474,'2017-01-20','127.0.0.1','',3,'show.php?itemid=19','',''),(20,24,0,1,1,0,'管材管件--镀锌钢管--测试商品2','',0,'','',30000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"30000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200000,'件','','管材管件--镀锌钢管--测试商品2,管材管件,镀锌钢管','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/112641371.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484882809,'2017-01-20',1484882736,'2017-01-20','127.0.0.1','',3,'show.php?itemid=20','',''),(21,25,0,1,1,0,'管材管件--不锈钢钢管--测试商品2','',0,'','',4000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"4000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',300000,'件','','管材管件--不锈钢钢管--测试商品2,管材管件,不锈钢钢管','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/112837121.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484882921,'2017-01-20',1484882809,'2017-01-20','127.0.0.1','',3,'show.php?itemid=21','',''),(22,25,0,1,1,0,'管材管件--不锈钢钢管--测试商品1','',0,'','',2000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"2000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',300000,'件','','管材管件--不锈钢钢管--测试商品1,管材管件,不锈钢钢管','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/112858981.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484882948,'2017-01-20',1484882921,'2017-01-20','127.0.0.1','',3,'show.php?itemid=22','',''),(23,26,0,1,1,0,'管材管件--PPR管--测试商品1','',0,'','',200.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"200.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',20000,'件','','管材管件--PPR管--测试商品1,管材管件,PPR钢管','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/113150101.jpg.thumb.jpg','http://www.tctianyi.com/file/upload/201701/20/113214431.jpg.thumb.jpg','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484883147,'2017-01-20',1484882949,'2017-01-20','127.0.0.1','',3,'show.php?itemid=23','',''),(24,27,0,1,1,0,'管材管件--PVC管--测试商品1','',0,'','',400.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"400.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',3000,'件','','管材管件--PVC管--测试商品1,管材管件,PVC管','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/113252661.jpg.thumb.jpg','http://www.tctianyi.com/file/upload/201701/20/113255801.jpg.thumb.jpg','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484883188,'2017-01-20',1484883147,'2017-01-20','127.0.0.1','',3,'show.php?itemid=24','',''),(25,28,0,1,1,0,'实验室家具----中央台---测试商品1','',0,'','',6000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200,'件','','实验室家具----中央台---测试商品1,实验室家具,中央台','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/113518971.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484883325,'2017-01-20',1484883188,'2017-01-20','127.0.0.1','',3,'show.php?itemid=25','',''),(26,28,0,1,1,0,'实验室家具----中央台---测试商品2','',0,'','',5000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200,'件','','实验室家具----中央台---测试商品2,实验室家具,中央台','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/113548921.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484883357,'2017-01-20',1484883325,'2017-01-20','127.0.0.1','',3,'show.php?itemid=26','',''),(27,29,0,1,1,0,'实验室家具----边台---测试商品1','',0,'','',5000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',100,'件','','实验室家具----边台---测试商品1,实验室家具,边台','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/113756271.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484883489,'2017-01-20',1484883357,'2017-01-20','127.0.0.1','',3,'show.php?itemid=27','',''),(28,30,0,1,1,0,'实验室家具----取材台---测试商品1','',0,'','',5000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',300,'件','','实验室家具----取材台---测试商品1,实验室家具,取材台','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/113954471.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484883608,'2017-01-20',1484883489,'2017-01-20','127.0.0.1','',3,'show.php?itemid=28','',''),(29,31,0,1,1,0,'实验室家具----办公桌---测试商品1','',0,'','',3000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"3000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',4000,'件','','实验室家具----办公桌---测试商品1,实验室家具,办公家具','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/114234481.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484883765,'2017-01-20',1484883608,'2017-01-20','127.0.0.1','',3,'show.php?itemid=29','',''),(30,31,0,1,1,0,'实验室家具----家具---测试商品1','',0,'','',60000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"60000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',4000,'件','','实验室家具----家具---测试商品1,实验室家具,办公家具','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/114306371.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484883800,'2017-01-20',1484883765,'2017-01-20','127.0.0.1','',3,'show.php?itemid=30','',''),(31,32,0,1,1,0,'仪器设备-----PCR仪---测试商品1','',0,'','',5000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',300,'件','','仪器设备-----PCR仪---测试商品1,仪器设备,PCR仪','',1,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/115211881.jpg.thumb.jpg','http://www.tctianyi.com/file/upload/201701/20/115215651.jpg.thumb.jpg','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484884344,'2017-01-20',1484883800,'2017-01-20','127.0.0.1','',3,'show.php?itemid=31','',''),(32,33,0,1,1,0,'仪器设备-----免疫仪---测试商品1','',0,'','',4000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"4000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',400,'件','','仪器设备-----免疫仪---测试商品1,仪器设备,免疫仪','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/115346881.jpg.thumb.jpg','http://www.tctianyi.com/file/upload/201701/20/115351731.jpg.thumb.jpg','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484884440,'2017-01-20',1484884344,'2017-01-20','127.0.0.1','',3,'show.php?itemid=32','',''),(33,33,0,1,1,0,'仪器设备-----免疫仪---测试商品2','',0,'','',6000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',300,'件','','仪器设备-----免疫仪---测试商品2,仪器设备,免疫仪','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/115447411.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484884499,'2017-01-20',1484884440,'2017-01-20','127.0.0.1','',3,'show.php?itemid=33','',''),(34,34,0,1,1,0,'仪器设备-----通风柜---测试商品1','',0,'','',50000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"50000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',44,'件','','仪器设备-----通风柜---测试商品1,仪器设备,通风柜','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/115557351.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484884569,'2017-01-20',1484884499,'2017-01-20','127.0.0.1','',3,'show.php?itemid=34','',''),(35,34,0,1,1,0,'仪器设备-----通风柜---测试商品2','',0,'','',5000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',600,'件','','仪器设备-----通风柜---测试商品2,仪器设备,通风柜','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/115645561.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484884615,'2017-01-20',1484884569,'2017-01-20','127.0.0.1','',3,'show.php?itemid=35','',''),(36,35,0,1,1,0,'仪器设备-----生物安全柜---测试商品1','',0,'','',6000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',500,'件','','仪器设备-----生物安全柜---测试商品1,仪器设备,生物安全柜','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/115749121.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484884680,'2017-01-20',1484884615,'2017-01-20','127.0.0.1','',3,'show.php?itemid=36','',''),(37,36,0,1,1,0,'采暖/热泵------电采暖----测试商品1','',0,'','',7000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"7000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',300,'件','','采暖/热泵------电采暖----测试商品1,采暖/热泵,电采暖','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/140549401.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484892357,'2017-01-20',1484884680,'2017-01-20','127.0.0.1','',3,'show.php?itemid=37','',''),(38,36,0,1,1,0,'采暖/热泵------电采暖----测试商品2','',0,'','',15000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"15000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200,'件','','采暖/热泵------电采暖----测试商品2,采暖/热泵,电采暖','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/140745281.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484892505,'2017-01-20',1484892357,'2017-01-20','127.0.0.1','',3,'show.php?itemid=38','',''),(39,37,0,1,1,0,'采暖/热泵----水源热泵机组---测试商品1','',0,'','',20000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"20000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',10,'件','','采暖/热泵----水源热泵机组---测试商品1,采暖/热泵,水源热泵机组','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/141009551.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484892617,'2017-01-20',1484892571,'2017-01-20','127.0.0.1','',3,'show.php?itemid=39','',''),(40,37,0,1,1,0,'采暖/热泵----水源热泵机组---测试商品2','',0,'','',18000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"18000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',200,'件','','采暖/热泵----水源热泵机组---测试商品2,采暖/热泵,水源热泵机组','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/141039231.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484892659,'2017-01-20',1484892617,'2017-01-20','127.0.0.1','',3,'show.php?itemid=40','',''),(41,38,0,1,1,0,'采暖/热泵-----商用热泵----测试商品1','',0,'','',6000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',100,'件','','采暖/热泵-----商用热泵----测试商品1,采暖/热泵,商用热泵','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/141258601.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484892798,'2017-01-20',1484892659,'2017-01-20','127.0.0.1','',3,'show.php?itemid=41','',''),(42,39,0,1,1,0,'采暖/热泵----伸缩器------测试商品1','',0,'','',5000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',400,'件','','采暖/热泵----伸缩器------测试商品1,采暖/热泵,伸缩器','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/141442951.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484892900,'2017-01-20',1484892798,'2017-01-20','127.0.0.1','',3,'show.php?itemid=42','',''),(43,40,0,1,1,0,'辅材/工具 ----- 切割机----测试商品1','',0,'','',60000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:8:\"60000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',300,'件','','辅材/工具 ----- 切割机----测试商品1,辅材/工具,切割机','',0,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/141739721.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484893067,'2017-01-20',1484892900,'2017-01-20','127.0.0.1','',3,'show.php?itemid=43','',''),(44,41,0,1,1,0,'辅材/工具 ----- 手电钻----测试商品1','',0,'','',390.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"390.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',100,'件','','辅材/工具 ----- 手电钻----测试商品1,辅材/工具,手电钻','',1,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/141931671.jpg.thumb.jpg','http://www.tctianyi.com/file/upload/201701/20/141957911.jpg.thumb.jpg','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484893206,'2017-01-20',1484893067,'2017-01-20','127.0.0.1','',3,'show.php?itemid=44','',''),(45,41,0,1,1,0,'辅材/工具 ----- 手电钻----测试商品2','',0,'','',500.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"500.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',3000,'件','','辅材/工具 ----- 手电钻----测试商品2,辅材/工具,手电钻','',1,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/142026551.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484893233,'2017-01-20',1484893206,'2017-01-20','127.0.0.1','',3,'show.php?itemid=45','',''),(46,42,0,1,1,0,'辅材/工具------激光测距仪-----测试商品1','',0,'','',6000.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"6000.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',6000,'件','','辅材/工具------激光测距仪-----测试商品1,辅材/工具,激光测距仪','',2,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/142158581.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484893325,'2017-01-20',1484893233,'2017-01-20','127.0.0.1','',3,'show.php?itemid=46','',''),(47,42,0,1,1,0,'辅材/工具------激光测距仪-----测试商品2','',0,'','',5800.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:7:\"5800.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',400,'件','','辅材/工具------激光测距仪-----测试商品2,辅材/工具,激光测距仪','',2,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/142235211.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484893363,'2017-01-20',1484893325,'2017-01-20','127.0.0.1','',3,'show.php?itemid=47','',''),(48,43,0,1,1,0,'辅材/工具----万用表-----测试商品1','',0,'','',600.00,'a:7:{s:2:\"a1\";s:1:\"1\";s:2:\"p1\";s:6:\"600.00\";s:2:\"a2\";s:1:\"0\";s:2:\"p2\";s:4:\"0.00\";s:2:\"a3\";s:1:\"0\";s:2:\"p3\";s:1:\"0\";s:2:\"is\";s:1:\"N\";}',600,'件','','辅材/工具----万用表-----测试商品1,辅材/工具,万用表','',2,0,0,0,'http://www.tctianyi.com/file/upload/201701/20/142337471.jpg.thumb.jpg','','','','','','','','','','','',0,'',0.00,0.00,0,'',0.00,0.00,0,'',0.00,0.00,0,'tianyi',1,'天医',0,0,'嘉客','','','','','','','','','tianyi',1484893425,'2017-01-20',1484893363,'2017-01-20','127.0.0.1','',3,'show.php?itemid=48','','');

#
# Structure for table "ty_mall_cart"
#

CREATE TABLE `ty_mall_cart` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `edittime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='购物车';

#
# Data for table "ty_mall_cart"
#


#
# Structure for table "ty_mall_comment"
#

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

#
# Data for table "ty_mall_comment"
#


#
# Structure for table "ty_mall_data"
#

CREATE TABLE `ty_mall_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商城内容';

#
# Data for table "ty_mall_data"
#

INSERT INTO `ty_mall_data` VALUES (1,'&nbsp;安普AMP 超五类非屏蔽电缆\r\n<div>6-219586-4 305米每箱安普AMP 超五类非屏蔽电缆</div>\r\n<div>6-219586-4 305米每箱安普AMP 超五类非屏蔽电缆</div>\r\n<div>6-219586-4 305米每箱</div>'),(2,'&nbsp;装修主材--彩钢板--测试2装修主材--彩钢板--测试2装修主材--彩钢板--测试2装修主材--彩钢板--测试2装修主材--彩钢板--测试2'),(3,'&nbsp;装修主材--铝扣板--测试1装修主材--铝扣板--测试1装修主材--铝扣板--测试1'),(4,'&nbsp;装修主材--铝扣板--测试2装修主材--铝扣板--测试2装修主材--铝扣板--测试2装修主材--铝扣板--测试2'),(5,'&nbsp;装修主材--瓷砖地板--测试1装修主材--瓷砖地板--测试1装修主材--瓷砖地板--测试1装修主材--瓷砖地板--测试1'),(6,'&nbsp;装修主材--瓷砖地板--测试2装修主材--瓷砖地板--测试2装修主材--瓷砖地板--测试2装修主材--瓷砖地板--测试2装修主材--瓷砖地板--测试2'),(7,'&nbsp;通风空调--空调主机--测试1通风空调--空调主机--测试1通风空调--空调主机--测试1'),(8,'&nbsp;通风空调--空调主机--测试2通风空调--空调主机--测试2通风空调--空调主机--测试2'),(9,'&nbsp;通风空调--空调末端--测试1通风空调--空调末端--测试1通风空调--空调末端--测试1通风空调--空调末端--测试1通风空调--空调末端--测试1通风空调--空调末端--测试1'),(10,'&nbsp;通风空调--商用空调--测试1通风空调--商用空调--测试1通风空调--商用空调--测试1通风空调--商用空调--测试1通风空调--商用空调--测试1'),(11,'&nbsp;通风空调--风机--测试1通风空调--风机--测试1通风空调--风机--测试1通风空调--风机--测试1通风空调--风机--测试1'),(12,'&nbsp;通风空调--空调末端--测试2通风空调--空调末端--测试2通风空调--空调末端--测试2通风空调--空调末端--测试2'),(13,'&nbsp;电工电气/安防---电缆--测试1电工电气/安防---电缆--测试1电工电气/安防---电缆--测试1电工电气/安防---电缆--测试1'),(14,'&nbsp;电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2电工电气/安防---电缆--测试2'),(15,'&nbsp;电工电气/安防---电线--测试1电工电气/安防---电线--测试1电工电气/安防---电线--测试1电工电气/安防---电线--测试1'),(16,'&nbsp;电工电气/安防---开关--测试1电工电气/安防---开关--测试1电工电气/安防---开关--测试1电工电气/安防---开关--测试1电工电气/安防---开关--测试1'),(17,'&nbsp;电工电气/安防---开关--测试2&nbsp;电工电气/安防---开关--测试2&nbsp;电工电气/安防---开关--测试2&nbsp;电工电气/安防---开关--测试2&nbsp;电工电气/安防---开关--测试2'),(18,'&nbsp;&nbsp;电工电气/安防---灯具--测试1&nbsp;电工电气/安防---灯具--测试1&nbsp;电工电气/安防---灯具--测试1&nbsp;电工电气/安防---灯具--测试1&nbsp;电工电气/安防---灯具--测试1'),(19,'&nbsp;管材管件--镀锌钢管--测试1管材管件--镀锌钢管--测试1管材管件--镀锌钢管--测试1管材管件--镀锌钢管--测试1管材管件--镀锌钢管--测试1'),(20,'&nbsp;管材管件--镀锌钢管--测试商品2管材管件--镀锌钢管--测试商品2管材管件--镀锌钢管--测试商品2管材管件--镀锌钢管--测试商品2管材管件--镀锌钢管--测试商品2'),(21,'&nbsp;管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2'),(22,'&nbsp;管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2管材管件--不锈钢钢管--测试商品2'),(23,'&nbsp;管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1管材管件--PPR管--测试商品1'),(24,'&nbsp;管材管件--PVC管--测试商品1管材管件--PVC管--测试商品1管材管件--PVC管--测试商品1管材管件--PVC管--测试商品1管材管件--PVC管--测试商品1'),(25,'&nbsp;实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1实验室家具----中央台---测试商品1'),(26,'&nbsp;实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2实验室家具----中央台---测试商品2'),(27,'&nbsp;实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1实验室家具----边台---测试商品1'),(28,'&nbsp;实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1实验室家具----取材台---测试商品1'),(29,'&nbsp;实验室家具----办公桌---测试商品1实验室家具----办公桌---测试商品1实验室家具----办公桌---测试商品1实验室家具----办公桌---测试商品1'),(30,'&nbsp;实验室家具----家具---测试商品1实验室家具----家具---测试商品1实验室家具----家具---测试商品1实验室家具----家具---测试商品1实验室家具----家具---测试商品1实验室家具----家具---测试商品1'),(31,'&nbsp;仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1仪器设备-----PCR仪---测试商品1'),(32,'&nbsp;仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1仪器设备-----免疫仪---测试商品1'),(33,'&nbsp;仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2仪器设备-----免疫仪---测试商品2'),(34,'&nbsp;仪器设备-----通风柜---测试商品1仪器设备-----通风柜---测试商品1仪器设备-----通风柜---测试商品1仪器设备-----通风柜---测试商品1'),(35,'&nbsp;仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2仪器设备-----通风柜---测试商品2'),(36,'&nbsp;仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1仪器设备-----生物安全柜---测试商品1'),(37,'&nbsp;采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1采暖/热泵------电采暖----测试商品1'),(38,'&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2&nbsp;采暖/热泵------电采暖----测试商品2'),(39,'&nbsp;采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1采暖/热泵----水源热泵机组---测试商品1'),(40,'&nbsp;采暖/热泵----水源热泵机组---测试商品2采暖/热泵----水源热泵机组---测试商品2采暖/热泵----水源热泵机组---测试商品2采暖/热泵----水源热泵机组---测试商品2采暖/热泵----水源热泵机组---测试商品2'),(41,'&nbsp;采暖/热泵-----商用热泵----测试商品1采暖/热泵-----商用热泵----测试商品1采暖/热泵-----商用热泵----测试商品1采暖/热泵-----商用热泵----测试商品1'),(42,'&nbsp;采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1采暖/热泵----伸缩器------测试商品1'),(43,'&nbsp;辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1辅材/工具 ----- 切割机----测试商品1'),(44,'&nbsp;辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1'),(45,'&nbsp;辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1辅材/工具 ----- 手电钻----测试商品1'),(46,'&nbsp;辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1辅材/工具------激光测距仪-----测试商品1'),(47,'&nbsp;辅材/工具------激光测距仪-----测试商品2辅材/工具------激光测距仪-----测试商品2辅材/工具------激光测距仪-----测试商品2辅材/工具------激光测距仪-----测试商品2辅材/工具------激光测距仪-----测试商品2'),(48,'&nbsp;辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1辅材/工具----万用表-----测试商品1');

#
# Structure for table "ty_mall_express"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='运费模板';

#
# Data for table "ty_mall_express"
#


#
# Structure for table "ty_mall_order"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商城订单';

#
# Data for table "ty_mall_order"
#


#
# Structure for table "ty_mall_stat"
#

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

#
# Data for table "ty_mall_stat"
#


#
# Structure for table "ty_member"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员';

#
# Data for table "ty_member"
#

INSERT INTO `ty_member` VALUES (1,'tianyi','tianyi','天医','513664ef7984d0945364d4a38e2891b5','eMIAHVJw','c8cd0ed022317b3a13ad94369f3cd6ea','YqdtMWbW','mail@yourdomain.com',0,0,0,1,0,1,'嘉客','','','','','','','',1,'',0,1,6,1,0,109,0.00,0.00,'',1,'','',1468385760,'127.0.0.1',1467860142,'127.0.0.1',1486455664,19,'',1,'','',1436723402,0,0,0,0,0,0,'','','','');

#
# Structure for table "ty_member_check"
#

CREATE TABLE `ty_member_check` (
  `userid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员资料审核';

#
# Data for table "ty_member_check"
#


#
# Structure for table "ty_member_group"
#

CREATE TABLE `ty_member_group` (
  `groupid` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(50) NOT NULL DEFAULT '',
  `vip` smallint(2) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='会员组';

#
# Data for table "ty_member_group"
#

INSERT INTO `ty_member_group` VALUES (1,'管理员',0,1),(2,'禁止访问',0,2),(3,'游客',0,3),(4,'待审核会员',0,4),(5,'个人会员',0,5),(6,'企业会员',0,6),(7,'VIP会员',1,7);

#
# Structure for table "ty_message"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='站内信件';

#
# Data for table "ty_message"
#

INSERT INTO `ty_message` VALUES (2,'欢迎加入天医工程网','',4,'<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tianyi.com/\" target=\"_blank\"><img src=\"http://www.tianyi.com/file/upload/201607/07/142346151.jpg\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hekw07<br/>\r\n<strong>密码：</strong>tianyi<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>','','hekw07',1481705047,'127.0.0.1',0,0,0,3,''),(3,'欢迎加入天医工程网','',4,'<table cellpadding=\"0\" cellspacing=\"0\" width=\"700\" align=\"center\">\r\n<tr>\r\n<td><a href=\"http://www.tianyi.com/\" target=\"_blank\"><img src=\"http://www.tianyi.com/file/upload/201607/07/142346151.jpg\" style=\"margin:10px 0;border:none;\" alt=\"天医工程网 LOGO\" title=\"天医工程网\"/></a></td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-top:solid 1px #DDDDDD;border-bottom:solid 1px #DDDDDD;padding:10px 0;line-height:200%;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:14px;color:#333333;\">\r\n尊敬的会员：<br/>\r\n恭喜您成功注册成为天医工程网会员！<br/>\r\n以下为您的会员帐号信息：<br/>\r\n<strong>户名：</strong>hekw08<br/>\r\n<strong>密码：</strong>GbK2312<br/>\r\n请您妥善保存，切勿告诉他人。<br/>\r\n如果您在使用过程中遇到任何问题，欢迎随时与我们取得联系。<br/>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style=\"line-height:22px;padding:10px 0;font-family:\'Microsoft YaHei\',Verdana,Arial;font-size:12px;color:#666666;\">\r\n请注意：此邮件系 <a href=\"http://www.tianyi.com/\" target=\"_blank\" style=\"color:#005590;\">天医工程网</a> 自动发送，请勿直接回复。如果此邮件不是您请求的，请忽略并删除\r\n</td>\r\n</tr>\r\n</table>','','hekw08',1482717451,'127.0.0.1',0,0,0,3,'');

#
# Structure for table "ty_module"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='模型';

#
# Data for table "ty_module"
#

INSERT INTO `ty_module` VALUES (1,'destoon','核心','','http://demo.destoon.com/v6.0/','http://www.tctianyi.com/','',1,0,0,0,0,0,1467860142),(2,'member','会员','member','','http://www.tctianyi.com/member/','',2,0,0,0,0,0,1467860142),(3,'extend','扩展','extend','','http://www.tctianyi.com/extend/','',0,0,0,0,0,0,1467860142),(4,'company','公司','company','','http://www.tctianyi.com/company/','',7,0,1,0,0,0,1467860142),(5,'sell','供应','sell','','http://www.tctianyi.com/sell/','',5,0,1,0,0,0,1467860142),(6,'buy','求购','buy','','http://www.tctianyi.com/buy/','',6,0,1,0,0,0,1467860142),(7,'quote','行情','quote','','http://www.tianyi.com/quote/','',9,0,1,0,0,1,1467860142),(8,'exhibit','展会','exhibit','','http://www.tctianyi.com/exhibit/','',10,0,1,0,0,0,1467860142),(9,'job','工程','job','','http://www.tctianyi.com/job/','',14,0,1,0,0,0,1467860142),(10,'know','交流','know','','http://www.tctianyi.com/know/','',15,0,1,0,0,0,1467860142),(11,'special','专题','special','','http://www.tianyi.com/special/','',16,0,1,0,0,1,1467860142),(12,'photo','图库','photo','','http://www.tianyi.com/photo/','',17,0,1,0,0,1,1467860142),(13,'brand','品牌','brand','','http://www.tianyi.com/brand/','',13,0,1,0,0,1,1467860142),(14,'video','视频','video','','http://www.tianyi.com/video/','',18,0,1,0,0,1,1467860142),(15,'down','下载','down','','http://www.tianyi.com/down/','',19,0,1,0,0,1,1467860142),(16,'mall','产品','mall','','http://www.tctianyi.com/mall/','',4,0,1,0,0,0,1467860142),(17,'group','团购','group','','http://www.tianyi.com/group/','',8,0,1,0,0,1,1467860142),(18,'club','商圈','club','','http://www.tianyi.com/club/','',20,0,1,0,0,1,1467860142),(21,'article','资讯','news','','http://www.tctianyi.com/news/','',11,0,1,0,0,0,1467860142),(22,'info','招商','invest','','http://www.tianyi.com/invest/','',12,0,1,0,0,1,1467860142);

#
# Structure for table "ty_news"
#

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

#
# Data for table "ty_news"
#


#
# Structure for table "ty_news_data"
#

CREATE TABLE `ty_news_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司新闻内容';

#
# Data for table "ty_news_data"
#


#
# Structure for table "ty_oauth"
#

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

#
# Data for table "ty_oauth"
#


#
# Structure for table "ty_online"
#

CREATE TABLE `ty_online` (
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='在线会员';

#
# Data for table "ty_online"
#


#
# Structure for table "ty_page"
#

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

#
# Data for table "ty_page"
#


#
# Structure for table "ty_page_data"
#

CREATE TABLE `ty_page_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司单页内容';

#
# Data for table "ty_page_data"
#


#
# Structure for table "ty_photo_12"
#

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

#
# Data for table "ty_photo_12"
#


#
# Structure for table "ty_photo_data_12"
#

CREATE TABLE `ty_photo_data_12` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图库内容';

#
# Data for table "ty_photo_data_12"
#


#
# Structure for table "ty_photo_item_12"
#

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

#
# Data for table "ty_photo_item_12"
#


#
# Structure for table "ty_poll"
#

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

#
# Data for table "ty_poll"
#


#
# Structure for table "ty_poll_item"
#

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

#
# Data for table "ty_poll_item"
#


#
# Structure for table "ty_poll_record"
#

CREATE TABLE `ty_poll_record` (
  `rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pollid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '',
  `polltime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='票选记录';

#
# Data for table "ty_poll_record"
#


#
# Structure for table "ty_question"
#

CREATE TABLE `ty_question` (
  `qid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='验证问题';

#
# Data for table "ty_question"
#

INSERT INTO `ty_question` VALUES (1,'5+6=?','11'),(2,'7+8=?','15'),(3,'11*11=?','121'),(4,'12-5=?','7'),(5,'21-9=?','12');

#
# Structure for table "ty_quote"
#

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

#
# Data for table "ty_quote"
#


#
# Structure for table "ty_quote_data"
#

CREATE TABLE `ty_quote_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='行情内容';

#
# Data for table "ty_quote_data"
#


#
# Structure for table "ty_quote_price"
#

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

#
# Data for table "ty_quote_price"
#


#
# Structure for table "ty_quote_product"
#

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

#
# Data for table "ty_quote_product"
#


#
# Structure for table "ty_resume"
#

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

#
# Data for table "ty_resume"
#


#
# Structure for table "ty_resume_data"
#

CREATE TABLE `ty_resume_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='简历内容';

#
# Data for table "ty_resume_data"
#


#
# Structure for table "ty_sell_5"
#

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

#
# Data for table "ty_sell_5"
#


#
# Structure for table "ty_sell_data_5"
#

CREATE TABLE `ty_sell_data_5` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='供应内容';

#
# Data for table "ty_sell_data_5"
#


#
# Structure for table "ty_sell_search_5"
#

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

#
# Data for table "ty_sell_search_5"
#


#
# Structure for table "ty_session"
#

CREATE TABLE `ty_session` (
  `sessionid` varchar(32) NOT NULL DEFAULT '',
  `data` text NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `sessionid` (`sessionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='SESSION';

#
# Data for table "ty_session"
#


#
# Structure for table "ty_setting"
#

CREATE TABLE `ty_setting` (
  `item` varchar(30) NOT NULL DEFAULT '',
  `item_key` varchar(100) NOT NULL DEFAULT '',
  `item_value` text NOT NULL,
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站设置';

#
# Data for table "ty_setting"
#

INSERT INTO `ty_setting` VALUES ('1','check_week',''),('1','admin_week',''),('1','cloud_express','0'),('1','sms_sign','【签名】'),('1','sms_ok','成功'),('1','sms_len','70'),('1','sms_max',''),('1','sms','0'),('1','sms_fee','0.1'),('1','page_text','18'),('1','page_logo','18'),('1','page_down','5'),('1','page_job','5'),('1','page_brand','4'),('1','page_exhibit','6'),('1','page_know','6'),('1','page_club','8'),('1','page_post','8'),('1','page_video','3'),('1','page_photo','6'),('1','page_news','5'),('1','page_newsh','1'),('1','page_comnews','5'),('1','page_special','1'),('1','page_rank','5'),('1','page_group','3'),('1','page_price','12'),('1','page_quote','5'),('1','page_mall','10'),('1','page_sell','10'),('1','page_com','20'),('1','page_trade','10'),('1','page_catalog','1'),('1','page_bigcat',''),('1','message_weixin','0'),('1','message_type','1,2,3'),('1','message_time','60'),('1','message_group','6,7'),('1','message_email','0'),('1','mail_log','1'),('1','mail_name',''),('1','mail_sender',''),('1','smtp_pass',''),('1','mail_sign',''),('1','smtp_user',''),('1','smtp_auth','1'),('1','smtp_port','25'),('1','smtp_host',''),('1','mail_delimiter','1'),('1','mail_type','close'),('1','max_image','800'),('1','thumb_title','0'),('1','thumb_album','1'),('1','middle_h','180'),('1','middle_w','240'),('1','water_middle','0'),('1','water_com','1'),('1','bmp_jpg','1'),('1','gif_ani','1'),('1','water_pos','9'),('1','water_min_wh','180'),('1','water_margin','10'),('1','water_type','0'),('1','water_fontcolor','#000000'),('1','water_fontsize','20'),('1','water_font','simhei.ttf'),('1','water_text','www.tianyi.com'),('1','water_jpeg_quality','90'),('1','water_transition','60'),('1','water_mark','watermark.png'),('1','file_my','my.php'),('1','file_login','login.php'),('1','file_register','register.php'),('1','defend_proxy','0'),('1','defend_reload','0'),('1','defend_cc','0'),('1','safe_domain',''),('1','check_referer','1'),('1','uploadsize','2048'),('1','uploaddir','Ym/d'),('1','uploadtype','jpg|jpeg|gif|png|rar|zip|pdf|doc|xls|ppt|flv|mp4|docx|ppts|xlsx'),('1','uploadlog','1'),('1','anticopy','0'),('1','ip_login','0'),('1','login_log','0'),('1','admin_log','0'),('1','admin_online','1'),('1','md5_pass','1'),('1','captcha_admin','0'),('1','captcha_cn','0'),('1','captcha_chars',''),('1','check_hour',''),('2','ex_rate',''),('2','ex_fdnm',''),('2','ex_prex',''),('2','ex_data',''),('2','ex_pass',''),('2','ex_user','root'),('2','ex_host','localhost'),('2','ex_type','PW'),('2','credit_exchange','0'),('2','credit_price','5|10|45|85'),('2','credit_buy','30|100|500|1000'),('2','credit_del_page','5'),('2','credit_add_page','2'),('2','credit_del_news','5'),('2','credit_add_news','2'),('2','credit_del_credit','5'),('2','credit_add_credit','2'),('2','credit_charge','1'),('2','credit_maxip','50'),('2','credit_ip','2'),('2','credit_less','0'),('2','credit_edit','10'),('2','credit_login','1'),('2','credit_user','20'),('2','send_types','不需要物流|平邮|EMS|顺丰快递|申通E物流|圆通速递|中通速递|宅急送|韵达快运|天天快递|联邦快递|汇通快运|华强物流|其它'),('2','pay_banks','现金|网银在线|贝宝|支付宝|财付通|招商银行|中国工商银行|中国农业银行|中国建设银行|中国交通银行|中国银行|邮政储蓄|邮政汇款'),('2','trade_day','10'),('2','deposit','1000'),('2','cash_fee_max','50'),('2','cash_fee','1'),('2','cash_fee_min','1'),('2','cash_times','3'),('2','cash_min','50'),('2','cash_max','10000'),('2','cash_banks','招商银行|中国工商银行|中国农业银行|中国建设银行|中国交通银行|中国银行|邮政储蓄|贝宝|支付宝|财付通'),('2','cash_enable','1'),('2','pay_url',''),('2','mincharge','0'),('2','pay_online','1'),('2','link_check','2'),('2','credit_clear','0'),('2','credit_save','0'),('2','credit_check','2'),('2','page_clear','0'),('2','page_save','0'),('2','page_check','2'),('2','news_clear','0'),('2','news_save','0'),('2','news_check','2'),('2','introduce_clear','0'),('2','introduce_save','0'),('2','introduce_length','0'),('2','thumb_height','180'),('2','cate_max','6'),('2','thumb_width','180'),('2','mode_max','2'),('2','com_mode','制造商|贸易商|服务商|其他机构'),('2','money_unit','人民币|港元|台币|美元|欧元|英镑'),('2','com_size','1-49人|50-99人|100-499人|500-999人|1000-3000人|3000-5000人|5000-10000人|10000人以上'),('2','com_type','企业单位|事业单位或社会团体|个体经营|其他'),('2','login_goto','0'),('2','login_remember','1'),('2','captcha_login','0'),('2','show_menu','1'),('2','editor','Basic'),('2','vfax',''),('2','vcompany','1'),('2','vbank','1'),('2','vtruename','1'),('2','vmobile','1'),('2','vemail','1'),('2','vmember','1'),('2','chat_img','1'),('2','chat_url','1'),('2','chat_ext','jpg|gif|png|rar|zip|pdf|doc|xls|ppt|docx|xlsx|pptx'),('2','chat_file','1'),('2','chat_mintime','3'),('2','chat_poll','3'),('2','chat_timeout','600'),('2','chat_maxlen','300'),('2','alert_check','2'),('2','alertid','5|6|22'),('2','lock_hour','1'),('2','auth_days','3'),('2','login_times','10'),('2','maxtouser','5'),('2','captcha_sendmessage','2'),('2','edit_check','thumb,areaid,business,regyear,capital,address,telephone,content'),('2','usernote','欢迎使用DESTOON B2B网站管理系统www.destoon.com'),('2','iptimeout','24'),('2','banagent',''),('2','defend_proxy','0'),('2','sms_register','0'),('2','credit_register','20'),('2','money_register','0'),('2','question_register','0'),('2','welcome_sms','1'),('2','emailcode_register','0'),('2','mobilecode_register','0'),('2','captcha_register','1'),('2','welcome_email','1'),('2','welcome_message','1'),('2','checkuser','0'),('2','banemail',''),('2','banmodec','0'),('2','bancompany',''),('2','banmodeu','0'),('2','banusername','admin|system|master|web|sell|buy|company|quote|job|article|info|page|bbs|club'),('2','maxpassword','20'),('2','minpassword','6'),('2','maxusername','20'),('2','minusername','4'),('2','enable_register','1'),('2','ex_name',''),('2','passport','0'),('2','passport_charset','gbk'),('2','passport_url',''),('2','passport_key',''),('2','uc_api',''),('2','uc_ip',''),('2','uc_mysql','1'),('2','uc_dbhost','localhost'),('2','uc_dbuser',''),('2','uc_dbpwd',''),('2','uc_dbname',''),('2','uc_dbpre',''),('2','uc_charset','utf8'),('2','uc_appid',''),('2','uc_key',''),('2','uc_bbs','1'),('2','uc_bbspre',''),('2','oauth','0'),('2','module','member'),('3','sitemaps_priority','0.8'),('3','sitemaps_changefreq','monthly'),('3','sitemaps','1'),('3','feed_pagesize','50'),('3','feed_domain',''),('3','feed_enable','2'),('3','archiver_domain',''),('3','archiver_enable','1'),('3','form_domain',''),('3','form_enable','1'),('3','poll_domain',''),('3','poll_enable','1'),('3','vote_domain',''),('3','gift_enable','1'),('3','gift_domain',''),('3','vote_enable','1'),('3','guestbook_captcha','1'),('3','guestbook_type','业务合作|意见建议|使用问题|页面错误|不良信息|其他'),('3','guestbook_domain',''),('3','guestbook_enable','1'),('3','comment_am','网友'),('3','credit_del_comment','5'),('3','credit_add_comment','2'),('3','comment_limit','30'),('3','comment_pagesize','10'),('3','comment_time','30'),('3','comment_max','500'),('3','comment_min','5'),('3','comment_vote','1'),('3','comment_admin_del','1'),('3','comment_user_del','4'),('3','comment_captcha_add','2'),('3','comment_check','2'),('3','comment_vote_group','5,6,7'),('3','comment_group','5,6,7'),('3','comment_show','1'),('3','comment_api_key',''),('3','comment_api_id',''),('3','comment_api',''),('3','comment_module','5,6,4,7,8,21,22,13,9,11,12,14,15'),('3','comment_domain',''),('3','link_request',''),('3','link_reg','1'),('3','link_domain',''),('3','link_enable','1'),('3','announce_domain',''),('3','announce_enable','1'),('3','ad_currency','money'),('3','ad_buy','1'),('3','ad_view','1'),('3','ad_domain',''),('3','ad_enable','1'),('3','spread_currency','money'),('3','spread_list','1'),('3','spread_check','1'),('3','spread_max','10'),('3','spread_month','6'),('3','spread_step','100'),('3','spread_company_price','500'),('3','spread_buy_price','500'),('3','spread_sell_price','500'),('3','spread_domain',''),('3','mobile_goto','1'),('3','mobile_pagesize','30'),('3','mobile_sitename',''),('3','mobile_pid','14'),('3','mobile_domain',''),('3','mobile_enable','1'),('3','mobile_ajax','1'),('3','mobile_ios',''),('3','mobile_adr',''),('3','show_url','0'),('3','list_url','0'),('3','weixin',''),('3','oauth','0'),('3','sitemaps_module','16,5,6,4,17,7,8,21,22,13,9,10,11,12,14,15,18'),('3','sitemaps_update','60'),('3','sitemaps_items','10000'),('3','baidunews','1'),('3','baidunews_email','mail@yourdomain.com'),('3','baidunews_update','60'),('3','baidunews_items','90'),('3','module','extend'),('3','feed_url','http://www.tianyi.com/feed/'),('3','archiver_url','http://www.tianyi.com/archiver/'),('3','form_url','http://www.tianyi.com/form/'),('3','poll_url','http://www.tianyi.com/poll/'),('3','vote_url','http://www.tianyi.com/vote/'),('3','gift_url','http://www.tianyi.com/gift/'),('3','guestbook_url','http://www.tianyi.com/guestbook/'),('3','comment_url','http://www.tianyi.com/comment/'),('3','link_url','http://www.tianyi.com/link/'),('3','announce_url','http://www.tianyi.com/announce/'),('3','ad_url','http://www.tianyi.com/ad/'),('3','spread_url','http://www.tianyi.com/spread/'),('3','mobile_url','http://www.tianyi.com/mobile/'),('4','group_inquiry','3,5,6,7'),('4','group_price','3,5,6,7'),('4','group_message','3,5,6,7'),('4','group_buy','3,5,6,7'),('4','group_contact','5,6,7'),('4','group_search','3,5,6,7'),('4','group_list','3,5,6,7'),('4','group_index','3,5,6,7'),('4','seo_description_show',''),('4','seo_keywords_show',''),('4','seo_title_show','{内容标题}{分类名称}{分类SEO标题}{模块名称}{分隔符}{网站名称}'),('4','seo_description_list',''),('4','seo_keywords_list',''),('4','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('4','seo_description_index',''),('4','seo_keywords_index',''),('4','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('4','php_list_urlid','0'),('4','htm_list_urlid','0'),('4','list_html','0'),('4','htm_list_prefix',''),('4','index_html','0'),('4','pagesize','20'),('4','page_subcat','6'),('4','page_inews','10'),('4','page_inew','10'),('4','level','推荐公司'),('4','page_irec','10'),('4','page_ivip','10'),('4','stats',''),('4','kf',''),('4','vip_maxyear','5'),('4','vip_honor','1'),('4','map','baidu'),('4','vip_maxgroupvip','3'),('4','vip_cominfo','1'),('4','vip_year','1'),('4','openall','0'),('4','delvip','1'),('4','split','0'),('4','comment','1'),('4','homeurl','0'),('4','fields','userid,username,company,linkurl,thumb,catid,areaid,vip,groupid,validated,business,mode'),('4','order','vip desc,userid desc'),('4','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('4','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('4','title_show','{$seo_showtitle}{$seo_catname}{$seo_cattitle}{$seo_modulename}{$seo_sitename}{$seo_sitetitle}{$seo_delimiter}'),('4','keywords_index','{$seo_modulename}{$seo_sitename}{$seo_sitetitle}'),('4','keywords_list','{$seo_catname}{$seo_catkeywords}{$seo_modulename}{$seo_sitename}{$seo_sitekeywords}'),('4','keywords_show','{$seo_showtitle}{$seo_catname}{$seo_catkeywords}{$seo_modulename}{$seo_sitekeywords}'),('4','description_index','{$seo_modulename}{$seo_sitename}{$seo_sitetitle}'),('4','description_list','{$seo_sitedescription}{$seo_sitename}{$seo_modulename}{$seo_catdescription}{$seo_catname}'),('4','description_show','{$seo_showtitle}{$seo_showintroduce}{$seo_catname}{$seo_catdescription}{$seo_modulename}{$seo_sitename}{$seo_sitedescription}'),('4','module','company'),('5','credit_add','2'),('5','fee_back','0'),('5','fee_period','0'),('5','fee_view','0'),('5','fee_add','0'),('5','fee_currency','money'),('5','fee_mode','1'),('5','question_add','2'),('5','captcha_add','2'),('5','check_add','2'),('5','captcha_inquiry','2'),('5','question_inquiry','2'),('5','group_elite','6,7'),('5','group_compare','3,5,6,7'),('5','group_refresh','7'),('5','group_color','6,7'),('5','group_search','3,5,6,7'),('5','group_contact','3,5,6,7'),('5','group_show','3,5,6,7'),('5','group_list','3,5,6,7'),('5','group_index','3,5,6,7'),('5','seo_keywords_show',''),('5','seo_description_show',''),('5','seo_description_list',''),('5','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('5','seo_keywords_list',''),('5','seo_description_index',''),('5','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('5','seo_keywords_index',''),('5','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('5','php_item_urlid','0'),('5','htm_item_urlid','1'),('5','htm_item_prefix',''),('5','show_html','0'),('5','php_list_urlid','0'),('5','htm_list_urlid','0'),('5','htm_list_prefix',''),('5','list_html','0'),('5','index_html','0'),('5','page_subcat','5'),('5','max_width','900'),('5','pagesize','20'),('5','upload_thumb','0'),('5','swfu','2'),('5','checkorder','1'),('5','level','推荐信息'),('5','fulltext','0'),('5','sphinx_name','destoon,delta'),('5','sphinx_port',''),('5','sphinx_host',''),('5','sphinx','0'),('5','cat_property','0'),('5','save_remotepic','0'),('5','clear_link','0'),('5','keylink','0'),('5','split','0'),('5','inquiry_ask','我对贵公司的产品非常感兴趣，能否发一些详细资料给我参考？|请您发一份比较详细的产品规格说明，谢谢！|请问贵公司产品是否可以代理？代理条件是什么？|我公司有意购买此产品，可否提供此产品的报价单和最小起订量？'),('5','type','供应|提供服务|供应二手|提供加工|提供合作|库存'),('5','inquiry_type','单价|产品规格|型号|价格条款|原产地|能否提供样品|最小订货量|交货期|供货能力|销售条款及附加条件|包装方式|质量/安全认证 '),('5','fields','itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,price,unit,minamount,amount'),('5','order','editdate desc,vip desc,edittime desc'),('5','editor','Destoon'),('5','introduce_length','120'),('5','thumb_height','100'),('5','thumb_width','100'),('5','template_inquiry',''),('5','template_compare',''),('5','template_my',''),('5','template_search',''),('5','template_show',''),('5','template_list',''),('5','template_index',''),('5','credit_del','5'),('5','credit_color','100'),('5','credit_elite','100'),('5','credit_refresh','1'),('5','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('5','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('5','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('5','keywords_index',''),('5','keywords_list',''),('5','keywords_show',''),('5','description_index',''),('5','description_list',''),('5','description_show',''),('5','module','sell'),('6','fee_add','0'),('6','fee_currency','money'),('6','fee_mode','1'),('6','question_add','2'),('6','captcha_add','2'),('6','check_add','2'),('6','question_price','2'),('6','captcha_price','2'),('6','group_refresh','7'),('6','group_color','6,7'),('6','group_search','3,5,6,7'),('6','group_contact','3,5,6,7'),('6','group_show','3,5,6,7'),('6','group_list','3,5,6,7'),('6','group_index','3,5,6,7'),('6','seo_description_show',''),('6','seo_keywords_show',''),('6','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('6','seo_description_list',''),('6','seo_keywords_list',''),('6','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('6','seo_description_index',''),('6','seo_keywords_index',''),('6','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('6','php_item_urlid','0'),('6','htm_item_urlid','1'),('6','htm_item_prefix',''),('6','show_html','0'),('6','php_list_urlid','0'),('6','htm_list_urlid','0'),('6','htm_list_prefix',''),('6','list_html','0'),('6','index_html','0'),('6','page_subcat','6'),('6','max_width','900'),('6','pagesize','20'),('6','level','推荐信息'),('6','save_remotepic','0'),('6','clear_link','0'),('6','keylink','0'),('6','split','0'),('6','fulltext','0'),('6','cat_property','0'),('6','type','求购|紧急求购|求购二手|寻求加工|寻求合作|招标'),('6','price_ask','请您发一份比较详细的产品规格说明，谢谢！|请问您对此产品是长期有需求吗？|请问您对此产品有多大的需求量？'),('6','fields','itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,price'),('6','order','editdate desc,vip desc,edittime desc'),('6','editor','Destoon'),('6','introduce_length','120'),('6','thumb_height','100'),('6','thumb_width','100'),('6','template_price',''),('6','template_my',''),('6','template_search',''),('6','template_show',''),('6','template_list',''),('6','template_index',''),('6','fee_view','0'),('6','fee_period','0'),('6','fee_back','0'),('6','credit_add','2'),('6','credit_del','5'),('6','credit_color','100'),('6','credit_refresh','1'),('6','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('6','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('6','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('6','keywords_index',''),('6','keywords_list',''),('6','keywords_show',''),('6','description_index',''),('6','description_list',''),('6','description_show',''),('6','module','buy'),('7','fee_period','0'),('7','fee_view','0'),('7','fee_add','0'),('7','fee_currency','money'),('7','question_add','2'),('7','fee_mode','1'),('7','captcha_add','2'),('7','check_add','2'),('7','group_add_price','3,5,6,7'),('7','group_show_price','3,5,6,7'),('7','group_color','6,7'),('7','group_search','3,5,6,7'),('7','group_show','3,5,6,7'),('7','seo_keywords_show',''),('7','seo_description_show',''),('7','group_index','3,5,6,7'),('7','group_list','3,5,6,7'),('7','seo_description_list',''),('7','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('7','seo_keywords_list',''),('7','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('7','seo_description_index',''),('7','seo_keywords_index',''),('7','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('7','php_item_urlid','0'),('7','htm_item_urlid','1'),('7','htm_item_prefix',''),('7','show_html','0'),('7','php_list_urlid','0'),('7','index_html','0'),('7','list_html','0'),('7','htm_list_prefix',''),('7','htm_list_urlid','0'),('7','max_width','550'),('7','page_child','5'),('7','pagesize','20'),('7','page_icat','5'),('7','save_remotepic','0'),('7','clear_link','0'),('7','keylink','0'),('7','split','0'),('7','fulltext','0'),('7','level','推荐行情|暂未指定|推荐图文|头条相关|头条推荐'),('7','cat_property','0'),('7','fields','itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username'),('7','order','addtime desc'),('7','editor','Destoon'),('7','introduce_length','120'),('7','thumb_height','90'),('7','thumb_width','120'),('7','fee_back','0'),('7','pre_view','500'),('7','credit_add','2'),('7','credit_del','5'),('7','credit_color','100'),('7','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('7','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('7','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('7','keywords_index',''),('7','keywords_list',''),('7','keywords_show',''),('7','description_index',''),('7','description_list',''),('7','description_show',''),('7','module','quote'),('8','fee_currency','money'),('8','fee_mode','1'),('8','question_add','2'),('8','captcha_add','2'),('8','check_add','2'),('8','captcha_sign','2'),('8','group_color','6,7'),('8','group_search','3,5,6,7'),('8','group_contact','3,5,6,7'),('8','group_show','3,5,6,7'),('8','group_list','3,5,6,7'),('8','group_index','3,5,6,7'),('8','seo_description_show',''),('8','seo_keywords_show',''),('8','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('8','seo_description_list',''),('8','seo_keywords_list',''),('8','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('8','seo_description_index',''),('8','seo_keywords_index',''),('8','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('8','php_item_urlid','0'),('8','htm_item_urlid','1'),('8','htm_item_prefix',''),('8','show_html','0'),('8','php_list_urlid','0'),('8','htm_list_urlid','0'),('8','htm_list_prefix',''),('8','list_html','0'),('8','index_html','0'),('8','max_width','550'),('8','pagesize','10'),('8','cat_hall_num','2'),('8','cat_hall','0'),('8','cat_service_num','8'),('8','cat_service','0'),('8','cat_news_num','10'),('8','page_icat','10'),('8','news_id','21'),('8','cat_news','0'),('8','page_islide','3'),('8','level','推荐展会|展会幻灯'),('8','fulltext','0'),('8','split','0'),('8','keylink','0'),('8','save_remotepic','0'),('8','clear_link','0'),('8','cat_property','0'),('8','fields','itemid,title,thumb,linkurl,style,catid,addtime,edittime,username,fromtime,totime,city,address,sponsor'),('8','order','addtime desc'),('8','editor','Destoon'),('8','introduce_length','0'),('8','thumb_height','100'),('8','thumb_width','100'),('8','fee_add','0'),('8','fee_view','0'),('8','fee_period','0'),('8','fee_back','0'),('8','pre_view','500'),('8','credit_add','2'),('8','credit_del','5'),('8','credit_color','100'),('8','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('8','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('8','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('8','keywords_index',''),('8','keywords_list',''),('8','keywords_show',''),('8','description_index',''),('8','description_list',''),('8','description_show',''),('8','module','exhibit'),('9','check_add_resume','2'),('9','group_apply','5'),('9','group_search','3,5,6,7'),('9','group_contact','5,6,7'),('9','group_show','3,5,6,7'),('9','group_list','3,5,6,7'),('9','fee_back','0'),('9','fee_period','0'),('9','fee_view_resume','0'),('9','fee_add','0'),('9','fee_currency','money'),('9','fee_mode','1'),('9','question_add','2'),('9','captcha_add','2'),('9','check_add','2'),('9','group_talent','7'),('9','group_search_resume','3,5,6,7'),('9','group_contact_resume','7'),('9','group_show_resume','3,5,6,7'),('9','group_refresh','7'),('9','group_color','6,7'),('9','group_index','3,5,6,7'),('9','seo_description_show',''),('9','seo_keywords_show',''),('9','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('9','seo_description_list',''),('9','seo_keywords_list',''),('9','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('9','seo_description_index',''),('9','seo_keywords_index',''),('9','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('9','php_item_urlid','0'),('9','htm_item_urlid','1'),('9','htm_item_prefix',''),('9','show_html','0'),('9','php_list_urlid','0'),('9','htm_list_urlid','0'),('9','htm_list_prefix',''),('9','list_html','0'),('9','index_html','0'),('9','pagesize','20'),('9','max_width','550'),('9','page_iresume','10'),('9','page_ijob','10'),('9','level','推荐'),('9','split','0'),('9','cat_property','0'),('9','save_remotepic','0'),('9','clear_link','0'),('9','situation','目前正在找工作|观望有好机会再考虑|半年内无换工作计划'),('9','education','不限|初中|高中|大专|本科|硕士|博士'),('9','marriage','不限|未婚|已婚'),('9','gender','不限|男士|女士'),('9','type','不限|全职|兼职|实习'),('9','order','editdate desc,vip desc,edittime desc'),('9','fields','itemid,title,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,minsalary,maxsalary'),('9','editor','Destoon'),('9','introduce_length','120'),('9','thumb_height','140'),('9','thumb_width','100'),('9','captcha_add_resume','2'),('9','question_add_resume','2'),('9','fee_add_resume','0'),('9','fee_view','0'),('9','credit_add','2'),('9','credit_del','5'),('9','credit_color','100'),('9','credit_refresh','1'),('9','credit_add_resume','2'),('9','credit_del_resume','5'),('9','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('9','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('9','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('9','keywords_index',''),('9','keywords_list',''),('9','keywords_show',''),('9','description_index',''),('9','description_list',''),('9','description_show',''),('9','module','job'),('10','credit_answer','2'),('10','credit_best','20'),('10','credit_hidden','10'),('10','credit_color','100'),('10','credit_del','20'),('10','credit_add','0'),('10','pre_view','500'),('10','fee_back','0'),('10','fee_period','0'),('10','fee_view','0'),('10','fee_add','0'),('10','fee_currency','money'),('10','fee_mode','1'),('10','question_answer','2'),('10','captcha_answer','2'),('10','check_answer','2'),('10','group_vote','3,5,6,7'),('10','group_answer','3,5,6,7'),('10','question_add','2'),('10','captcha_add','2'),('10','check_add','2'),('10','group_color','6,7'),('10','group_search','3,5,6,7'),('10','group_show','3,5,6,7'),('10','group_list','3,5,6,7'),('10','group_index','3,5,6,7'),('10','seo_description_show',''),('10','seo_keywords_show',''),('10','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('10','seo_description_list',''),('10','seo_keywords_list',''),('10','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('10','seo_description_index',''),('10','seo_keywords_index',''),('10','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('10','php_item_urlid','0'),('10','htm_item_urlid','1'),('10','htm_item_prefix',''),('10','show_html','0'),('10','php_list_urlid','0'),('10','htm_list_urlid','0'),('10','htm_list_prefix',''),('10','list_html','0'),('10','index_html','0'),('10','max_width','550'),('10','answer_pagesize','10'),('10','pagesize','20'),('10','page_iexpert','2'),('10','page_iresolve','8'),('10','page_ivote','8'),('10','page_isolve','8'),('10','page_irec','8'),('10','messagedays','14'),('10','highcredit','20'),('10','raisecredit','20'),('10','raisedays','3'),('10','maxraise','2'),('10','overdays','15'),('10','votedays','5'),('10','minvote','3'),('10','answer_message','1'),('10','credits','0|5|10|15|20|30|50|80|100'),('10','level','精彩推荐'),('10','fulltext','0'),('10','split','0'),('10','keylink','1'),('10','clear_link','0'),('10','clear_alink','1'),('10','cat_property','0'),('10','save_remotepic','0'),('10','fields','itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,passport,answer,process,credit'),('10','order','addtime desc'),('10','editor','Simple'),('10','introduce_length','0'),('10','thumb_height','90'),('10','thumb_width','120'),('10','credit_maxanswer','50'),('10','credit_vote','1'),('10','credit_maxvote','30'),('10','credit_del_answer','5'),('10','credit_deal','20'),('10','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('10','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('10','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('10','keywords_index',''),('10','keywords_list',''),('10','keywords_show',''),('10','description_index',''),('10','description_list',''),('10','description_show',''),('10','module','know'),('11','credit_add','2'),('11','group_search','3,5,6,7'),('11','group_show','3,5,6,7'),('11','group_list','3,5,6,7'),('11','group_index','3,5,6,7'),('11','seo_description_show',''),('11','seo_keywords_show',''),('11','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('11','seo_description_list',''),('11','seo_keywords_list',''),('11','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('11','seo_description_index',''),('11','seo_keywords_index',''),('11','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('11','php_item_urlid','0'),('11','htm_item_urlid','1'),('11','htm_item_prefix',''),('11','show_html','0'),('11','htm_list_urlid','0'),('11','php_list_urlid','0'),('11','htm_list_prefix',''),('11','list_html','0'),('11','index_html','0'),('11','pagesize','20'),('11','page_icat','8'),('11','level_item','推荐信息|幻灯图片|推荐图文|头条相关|头条推荐|视频报道'),('11','level','推荐专题|暂未指定|推荐图文|头条相关|头条推荐'),('11','fulltext','0'),('11','split','0'),('11','clear_link','0'),('11','cat_property','0'),('11','save_remotepic','0'),('11','fields','itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime'),('11','editor','Destoon'),('11','order','addtime desc'),('11','introduce_length','120'),('11','banner_height','200'),('11','banner_width','960'),('11','thumb_height','90'),('11','thumb_width','120'),('11','credit_del','5'),('11','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('11','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('11','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('11','keywords_index',''),('11','keywords_list',''),('11','keywords_show',''),('11','description_index',''),('11','description_list',''),('11','description_show',''),('11','module','special'),('12','fee_period','0'),('12','fee_view','0'),('12','fee_add','0'),('12','fee_currency','money'),('12','fee_mode','1'),('12','question_add','2'),('12','captcha_add','2'),('12','check_add','2'),('12','group_color','6,7'),('12','group_search','3,5,6,7'),('12','group_show','3,5,6,7'),('12','group_list','3,5,6,7'),('12','group_index','3,5,6,7'),('12','seo_description_show',''),('12','seo_keywords_show',''),('12','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('12','seo_description_list',''),('12','seo_keywords_list',''),('12','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('12','seo_description_index',''),('12','seo_keywords_index',''),('12','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('12','php_item_urlid','0'),('12','htm_item_urlid','1'),('12','htm_item_prefix',''),('12','show_html','0'),('12','php_list_urlid','0'),('12','htm_list_urlid','0'),('12','htm_list_prefix',''),('12','list_html','0'),('12','index_html','0'),('12','swfu_max','20'),('12','max_width','800'),('12','pagesize','18'),('12','page_irec','4'),('12','page_icat','2'),('12','page_islide','3'),('12','level','推荐图库|幻灯图片|推荐图文|头条相关|头条推荐'),('12','fulltext','0'),('12','split','0'),('12','keylink','0'),('12','clear_link','0'),('12','save_remotepic','0'),('12','cat_property','0'),('12','fields','itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,items,open'),('12','introduce_length','120'),('12','editor','Simple'),('12','order','addtime desc'),('12','maxitem','30'),('12','thumb_height','90'),('12','thumb_width','120'),('12','template_my',''),('12','template_search',''),('12','template_show',''),('12','template_list',''),('12','template_index',''),('12','fee_back','0'),('12','pre_view','500'),('12','credit_add','2'),('12','credit_del','5'),('12','credit_color','100'),('12','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('12','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('12','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('12','keywords_index',''),('12','keywords_list',''),('12','keywords_show',''),('12','description_index',''),('12','description_list',''),('12','description_show',''),('12','module','photo'),('13','fee_back','0'),('13','fee_period','0'),('13','fee_add','0'),('13','fee_currency','money'),('13','fee_mode','1'),('13','question_add','2'),('13','captcha_add','2'),('13','check_add','2'),('13','question_message','2'),('13','captcha_message','2'),('13','group_refresh','7'),('13','group_color','6,7'),('13','group_search','3,5,6,7'),('13','group_contact','6,7'),('13','group_show','3,5,6,7'),('13','group_list','3,5,6,7'),('13','group_index','3,5,6,7'),('13','seo_description_show',''),('13','seo_keywords_show',''),('13','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('13','seo_description_list',''),('13','seo_keywords_list',''),('13','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('13','seo_description_index',''),('13','seo_keywords_index',''),('13','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('13','php_item_urlid','0'),('13','htm_item_urlid','1'),('13','htm_item_prefix',''),('13','show_html','0'),('13','php_list_urlid','0'),('13','htm_list_urlid','0'),('13','htm_list_prefix',''),('13','list_html','0'),('13','index_html','0'),('13','page_subcat','6'),('13','max_width','550'),('13','pagesize','20'),('13','page_icat','6'),('13','keylink','0'),('13','split','0'),('13','fulltext','0'),('13','level','推荐品牌'),('13','page_irec','20'),('13','cat_property','0'),('13','save_remotepic','0'),('13','clear_link','0'),('13','message_ask','请问我这个地方有加盟商了吗？|我想加盟，请来电话告诉我具体细节。|初步打算加盟贵公司，请寄资料。|请问贵公司哪里有样板店或直营店？|想了解加盟细节，请尽快寄一份资料。 '),('13','fields','itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated'),('13','editor','Destoon'),('13','order','editdate desc,vip desc,edittime desc'),('13','thumb_height','60'),('13','introduce_length','120'),('13','thumb_width','180'),('13','template_message',''),('13','template_my',''),('13','template_search',''),('13','template_product',''),('13','template_show',''),('13','template_list',''),('13','template_index',''),('13','fee_view','0'),('13','credit_add','2'),('13','credit_del','5'),('13','credit_color','100'),('13','credit_refresh','1'),('13','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('13','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('13','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('13','keywords_index','{$seo_modulename}{$seo_sitename}{$seo_sitetitle}'),('13','keywords_list',''),('13','keywords_show',''),('13','description_index','{$seo_modulename}{$seo_sitename}{$seo_sitetitle}'),('13','description_list',''),('13','description_show',''),('13','module','brand'),('14','fee_mode','1'),('14','question_add','2'),('14','captcha_add','2'),('14','check_add','2'),('14','question_message','2'),('14','captcha_message','2'),('14','group_upload','6,7'),('14','group_color','6,7'),('14','group_search','3,5,6,7'),('14','group_show','3,5,6,7'),('14','group_list','3,5,6,7'),('14','group_index','3,5,6,7'),('14','seo_keywords_show',''),('14','seo_description_show',''),('14','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('14','seo_description_list',''),('14','seo_keywords_list',''),('14','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('14','seo_description_index',''),('14','seo_keywords_index',''),('14','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('14','php_item_urlid','0'),('14','htm_item_urlid','1'),('14','htm_item_prefix',''),('14','show_html','0'),('14','php_list_urlid','0'),('14','htm_list_urlid','0'),('14','htm_list_prefix',''),('14','list_html','0'),('14','index_html','0'),('14','max_width','550'),('14','pagesize','20'),('14','page_icat','4'),('14','page_irec','8'),('14','swfu','1'),('14','flvstart',''),('14','flvend',''),('14','upload','mp4|flv|wmv'),('14','flvlink',''),('14','flvmargin','10 auto auto 10'),('14','flvlogo','video.png'),('14','autostart','1'),('14','player','FlashPlayer|MediaPlayer|RealPlayer'),('14','level','推荐视频'),('14','fulltext','0'),('14','split','0'),('14','keylink','0'),('14','clear_link','0'),('14','save_remotepic','0'),('14','cat_property','0'),('14','fields','itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,hits'),('14','editor','Destoon'),('14','order','addtime desc'),('14','video_width','480'),('14','video_height','400'),('14','introduce_length','120'),('14','thumb_height','90'),('14','thumb_width','120'),('14','template_my',''),('14','template_search',''),('14','template_show',''),('14','template_list',''),('14','template_index',''),('14','fee_currency','money'),('14','fee_add','0'),('14','fee_view','0'),('14','fee_period','0'),('14','fee_back','0'),('14','credit_add','2'),('14','credit_del','5'),('14','credit_color','100'),('14','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('14','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('14','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('14','keywords_index',''),('14','keywords_list',''),('14','keywords_show',''),('14','description_index',''),('14','description_list',''),('14','description_show',''),('14','module','video'),('15','fee_currency','money'),('15','fee_mode','1'),('15','question_add','2'),('15','captcha_add','2'),('15','check_add','2'),('15','question_message','2'),('15','captcha_message','2'),('15','group_upload','6,7'),('15','group_color','6,7'),('15','group_search','3,5,6,7'),('15','group_contact','5,6,7'),('15','group_show','3,5,6,7'),('15','group_list','3,5,6,7'),('15','group_index','3,5,6,7'),('15','seo_description_show',''),('15','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('15','seo_keywords_show',''),('15','seo_description_list',''),('15','seo_keywords_list',''),('15','seo_description_index',''),('15','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('15','seo_keywords_index',''),('15','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('15','php_item_urlid','0'),('15','htm_item_urlid','1'),('15','htm_item_prefix',''),('15','show_html','0'),('15','php_list_urlid','0'),('15','htm_list_urlid','0'),('15','htm_list_prefix',''),('15','list_html','0'),('15','index_html','0'),('15','max_width','550'),('15','pagesize','20'),('15','page_icat','10'),('15','page_irec','8'),('15','swfu','0'),('15','upload','rar|zip|pdf|jpg|gif|png|doc|ppt|xls|docx|pptx|xlsx'),('15','readsize','10'),('15','level','推荐下载'),('15','fulltext','0'),('15','split','0'),('15','keylink','0'),('15','cat_property','0'),('15','save_remotepic','0'),('15','clear_link','0'),('15','fields','itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,fileext,filesize,unit'),('15','order','addtime desc'),('15','editor','Destoon'),('15','introduce_length','120'),('15','thumb_height','90'),('15','thumb_width','120'),('15','template_my',''),('15','template_search',''),('15','template_show',''),('15','template_list',''),('15','template_index',''),('15','fee_add','0'),('15','fee_view','0'),('15','fee_period','0'),('15','fee_back','0'),('15','credit_add','2'),('15','credit_del','5'),('15','credit_color','100'),('15','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('15','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('15','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('15','keywords_index',''),('15','keywords_list',''),('15','keywords_show',''),('15','description_index',''),('15','description_list',''),('15','description_show',''),('15','module','down'),('16','credit_refresh','1'),('16','credit_elite','100'),('16','credit_color','100'),('16','credit_del','5'),('16','credit_add','2'),('16','fee_back','0'),('16','fee_period','0'),('16','fee_view','0'),('16','fee_add','0'),('16','fee_currency','money'),('16','fee_mode','1'),('16','question_add','2'),('16','captcha_add','2'),('16','check_add','2'),('16','question_inquiry','2'),('16','captcha_inquiry','2'),('16','group_elite','3,5,6,7'),('16','group_compare','3,5,6,7'),('16','group_refresh','7'),('16','group_color','6,7'),('16','group_search','3,5,6,7'),('16','group_contact','3,5,6,7'),('16','group_show','3,5,6,7'),('16','group_list','3,5,6,7'),('16','seo_description_show',''),('16','group_index','3,5,6,7'),('16','seo_keywords_show',''),('16','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('16','seo_description_list',''),('16','seo_keywords_list',''),('16','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('16','seo_description_index',''),('16','seo_keywords_index',''),('16','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('16','php_item_urlid','0'),('16','htm_item_urlid','1'),('16','htm_item_prefix',''),('16','show_html','0'),('16','php_list_urlid','0'),('16','htm_list_urlid','0'),('16','htm_list_prefix',''),('16','list_html','0'),('16','index_html','1'),('16','page_subcat','5'),('16','max_width','900'),('16','pagesize','20'),('16','checkorder','1'),('16','max_cart','30'),('16','page_irec','5'),('16','page_inew','12'),('16','swfu','2'),('16','level','推荐商品'),('16','split','0'),('16','fulltext','0'),('16','cat_property','0'),('16','save_remotepic','0'),('16','clear_link','0'),('16','keylink','0'),('16','fields','itemid,title,thumb,linkurl,style,catid,areaid,brand,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,price,amount,orders,comments'),('16','order','editdate desc,vip desc,edittime desc'),('16','thumb_height','100'),('16','introduce_length','0'),('16','editor','Destoon'),('16','thumb_width','100'),('17','credit_add','2'),('17','fee_back','0'),('17','fee_period','0'),('17','fee_view','0'),('17','fee_add','0'),('17','fee_currency','money'),('17','fee_mode','1'),('17','question_add','2'),('17','captcha_add','2'),('17','check_add','2'),('17','question_inquiry','2'),('17','captcha_inquiry','2'),('17','group_refresh','7'),('17','group_color','6,7'),('17','group_search','3,5,6,7'),('17','group_contact','3,5,6,7'),('17','group_show','3,5,6,7'),('17','group_list','3,5,6,7'),('17','group_index','3,5,6,7'),('17','seo_description_show',''),('17','seo_keywords_show',''),('17','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('17','seo_description_list',''),('17','seo_keywords_list',''),('17','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('17','seo_description_index',''),('17','seo_keywords_index',''),('17','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('17','php_item_urlid','0'),('17','htm_item_urlid','1'),('17','htm_item_prefix',''),('17','show_html','0'),('17','php_list_urlid','0'),('17','htm_list_urlid','0'),('17','htm_list_prefix',''),('17','list_html','0'),('17','index_html','0'),('17','page_subcat','9'),('17','max_width','550'),('17','pagesize','9'),('17','swfu','2'),('17','level','推荐团购'),('17','fulltext','0'),('17','split','0'),('17','keylink','0'),('17','clear_link','0'),('17','cat_property','0'),('17','save_remotepic','0'),('17','fields','itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,price,marketprice,savemoney,discount,sales,orders,minamount,amount'),('17','order','addtime desc'),('17','editor','Destoon'),('17','introduce_length','120'),('17','thumb_height','300'),('17','thumb_width','400'),('17','credit_del','5'),('17','credit_color','100'),('17','credit_refresh','1'),('17','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('17','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('17','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('17','keywords_index',''),('17','keywords_list',''),('17','keywords_show',''),('17','description_index',''),('17','description_list',''),('17','description_show',''),('17','module','group'),('18','credit_del','5'),('18','credit_level','10'),('18','credit_add','3'),('18','pre_view','5'),('18','fee_back','0'),('18','fee_period','0'),('18','fee_view','0'),('18','fee_add','0'),('18','fee_currency','money'),('18','fee_mode','1'),('18','question_reply','2'),('18','captcha_reply','2'),('18','check_reply','2'),('18','question_add','2'),('18','captcha_add','2'),('18','check_add','2'),('18','question_group','2'),('18','captcha_group','2'),('18','check_group','2'),('18','group_reply','3,5,6,7'),('18','group_search','3,5,6,7'),('18','group_show','3,5,6,7'),('18','group_list','3,5,6,7'),('18','group_index','3,5,6,7'),('18','seo_description_show',''),('18','seo_keywords_show',''),('18','seo_description_list',''),('18','seo_keywords_list',''),('18','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('18','seo_keywords_index',''),('18','seo_description_index',''),('18','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('18','seo_name','圈'),('18','php_item_urlid','0'),('18','htm_item_urlid','4'),('18','htm_item_prefix',''),('18','show_html','0'),('18','php_list_urlid','0'),('18','htm_list_urlid','0'),('18','htm_list_prefix',''),('18','list_html','0'),('18','index_html','0'),('18','max_width','750'),('18','reply_pagesize','10'),('18','pagesize','20'),('18','maxontop','5'),('18','manage_reason','1'),('18','manage_message','1'),('18','page_icat','8'),('18','page_islide','3'),('18','floor','沙发|藤椅|板凳|马扎|地板'),('18','manage_reasons','广告/SPAM|恶意灌水|违规内容|文不对题|重复发帖|我很赞同|精品文章|原创内容|感谢分享'),('18','swfu','2'),('18','level','精华1|精华2'),('18','fulltext','0'),('18','split','0'),('18','keylink','1'),('18','clear_alink','1'),('18','cat_property','0'),('18','save_remotepic','0'),('18','clear_link','0'),('18','fields','itemid,title,ontop,video,level,thumb,linkurl,style,catid,introduce,hits,addtime,edittime,username,reply,replyer,replytime '),('18','order','addtime desc'),('18','editor','Simple'),('18','introduce_length','0'),('18','thumb_height','90'),('18','thumb_width','120'),('18','credit_reply','1'),('18','credit_del_reply','2'),('18','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('18','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('18','keywords_index',''),('18','keywords_list',''),('18','keywords_show',''),('18','description_index',''),('18','description_list',''),('18','description_show',''),('18','module','club'),('21','fee_currency','money'),('21','fee_mode','1'),('21','question_add','2'),('21','captcha_add','2'),('21','check_add','2'),('21','group_color','6,7'),('21','group_search','3,5,6,7'),('21','group_show','3,5,6,7'),('21','group_list','3,5,6,7'),('21','group_index','3,5,6,7'),('21','seo_description_show',''),('21','seo_keywords_show',''),('21','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('21','seo_description_list',''),('21','seo_keywords_list',''),('21','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('21','seo_description_index',''),('21','seo_keywords_index',''),('21','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('21','php_item_urlid','0'),('21','htm_item_urlid','1'),('21','htm_item_prefix',''),('21','show_html','0'),('21','php_list_urlid','0'),('21','htm_list_urlid','0'),('21','htm_list_prefix',''),('21','list_html','0'),('21','index_html','0'),('21','show_np','1'),('21','max_width','550'),('21','page_shits','10'),('21','page_srec','10'),('21','page_srecimg','4'),('21','page_srelate','10'),('21','page_lhits','10'),('21','page_lrec','10'),('21','page_lrecimg','4'),('21','show_lcat','1'),('21','page_child','6'),('21','pagesize','20'),('21','page_ihits','10'),('21','page_irecimg','6'),('21','page_icat','6'),('21','show_icat','1'),('21','page_islide','3'),('21','swfu','2'),('21','level','推荐文章|幻灯图片|推荐图文|头条相关|头条推荐'),('21','fulltext','1'),('21','split','0'),('21','keylink','1'),('21','clear_link','0'),('21','cat_property','0'),('21','save_remotepic','0'),('21','fields','itemid,title,thumb,linkurl,style,catid,introduce,addtime,edittime,username,islink'),('21','editor','Default'),('21','order','addtime desc'),('21','introduce_length','120'),('21','thumb_height','90'),('21','thumb_width','120'),('21','template_my',''),('21','template_search',''),('21','template_show',''),('21','template_list',''),('21','template_index',''),('21','fee_add','0'),('21','fee_view','0'),('21','fee_period','0'),('21','fee_back','0'),('21','pre_view','500'),('21','credit_add','2'),('21','credit_del','5'),('21','credit_color','100'),('21','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('21','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}{$catname}'),('21','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}{$seo_sitetitle}'),('21','keywords_index',''),('21','keywords_list',''),('21','keywords_show',''),('21','description_index',''),('21','description_list',''),('21','description_show',''),('21','module','article'),('22','fee_back','0'),('22','fee_period','0'),('22','fee_view','0'),('22','fee_add','0'),('22','fee_currency','money'),('22','fee_mode','1'),('22','question_add','2'),('22','captcha_add','2'),('22','check_add','2'),('22','question_message','2'),('22','captcha_message','2'),('22','group_refresh','7'),('22','group_color','6,7'),('22','group_search','3,5,6,7'),('22','group_contact','6,7'),('22','group_show','3,5,6,7'),('22','group_list','3,5,6,7'),('22','group_index','3,5,6,7'),('22','seo_description_show',''),('22','seo_keywords_show',''),('22','seo_title_show','{内容标题}{分隔符}{分类名称}{模块名称}{分隔符}{网站名称}'),('22','seo_description_list',''),('22','seo_keywords_list',''),('22','seo_title_list','{分类SEO标题}{页码}{模块名称}{分隔符}{网站名称}'),('22','seo_description_index',''),('22','seo_keywords_index',''),('22','seo_title_index','{模块名称}{分隔符}{页码}{网站名称}'),('22','php_item_urlid','0'),('22','htm_item_urlid','1'),('22','htm_item_prefix',''),('22','show_html','0'),('22','php_list_urlid','0'),('22','htm_list_urlid','0'),('22','htm_list_prefix',''),('22','list_html','0'),('22','index_html','0'),('22','page_subcat','5'),('22','max_width','550'),('22','page_srelate','10'),('22','show_message','1'),('22','page_lkw','10'),('22','show_larea','1'),('22','show_lcat','1'),('22','pagesize','20'),('22','page_ihits','10'),('22','show_iarea','1'),('22','show_icat','1'),('22','page_icat','8'),('22','page_irec','8'),('22','swfu','2'),('22','clear_link','0'),('22','keylink','0'),('22','split','0'),('22','fulltext','0'),('22','level','推荐信息'),('22','cat_property','0'),('22','save_remotepic','0'),('22','message_ask','请问我这个地方有加盟商了吗？|我想加盟，请来电话告诉我具体细节。|初步打算加盟贵公司，请寄资料。|请问贵公司哪里有样板店或直营店？|想了解加盟细节，请尽快寄一份资料。 '),('22','order','edittime desc'),('22','fields','itemid,title,thumb,linkurl,style,catid,areaid,introduce,addtime,edittime,username,company,groupid,vip,qq,msn,ali,skype,validated,islink'),('22','thumb_height','100'),('22','introduce_length','120'),('22','editor','Destoon'),('22','thumb_width','100'),('22','template_message',''),('22','template_my',''),('22','template_search',''),('22','template_show',''),('22','template_list',''),('22','template_index',''),('22','credit_add','2'),('22','credit_del','5'),('22','credit_color','100'),('22','credit_refresh','1'),('22','title_index','{$seo_modulename}{$seo_delimiter}{$seo_page}{$seo_sitename}'),('22','title_list','{$seo_cattitle}{$seo_page}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('22','title_show','{$seo_showtitle}{$seo_delimiter}{$seo_catname}{$seo_modulename}{$seo_delimiter}{$seo_sitename}'),('22','keywords_index',''),('22','keywords_list',''),('22','keywords_show',''),('22','description_index',''),('22','description_list',''),('22','description_show',''),('22','module','info'),('pay-tenpay','percent','1'),('pay-tenpay','notify',''),('pay-tenpay','keycode',''),('pay-tenpay','partnerid',''),('pay-tenpay','order','1'),('pay-tenpay','name','财付通'),('pay-tenpay','enable','0'),('pay-weixin','percent','1'),('pay-weixin','notify',''),('pay-weixin','keycode',''),('pay-weixin','appid',''),('pay-weixin','partnerid',''),('pay-weixin','name','微信'),('pay-weixin','order','2'),('pay-weixin','enable','0'),('pay-alipay','percent','1'),('pay-alipay','notify',''),('pay-alipay','keycode',''),('pay-alipay','partnerid',''),('pay-alipay','email',''),('pay-alipay','order','3'),('pay-alipay','name','支付宝'),('pay-alipay','enable','0'),('pay-chinabank','percent','1'),('pay-chinabank','notify',''),('pay-chinabank','keycode',''),('pay-chinabank','partnerid',''),('pay-chinabank','name','网银在线'),('pay-chinabank','order','4'),('pay-chinabank','enable','0'),('pay-yeepay','percent','1'),('pay-yeepay','keycode',''),('pay-yeepay','partnerid',''),('pay-yeepay','order','5'),('pay-yeepay','name','易宝支付'),('pay-yeepay','enable','0'),('pay-kq99bill','percent','1'),('pay-kq99bill','notify',''),('pay-kq99bill','cert',''),('pay-kq99bill','partnerid',''),('pay-kq99bill','order','6'),('pay-kq99bill','name','快钱支付'),('pay-kq99bill','enable','0'),('pay-chinapay','percent','1'),('pay-chinapay','partnerid',''),('pay-chinapay','order','7'),('pay-chinapay','name','中国银联'),('pay-chinapay','enable','0'),('pay-paypal','percent','0'),('pay-paypal','currency','USD'),('pay-paypal','keycode',''),('pay-paypal','notify',''),('pay-paypal','partnerid',''),('pay-paypal','order','8'),('pay-paypal','name','贝宝'),('pay-paypal','enable','0'),('oauth-qq','sync','0'),('oauth-qq','key',''),('oauth-qq','id',''),('oauth-qq','order','1'),('oauth-qq','name','QQ登录'),('oauth-qq','enable','0'),('oauth-sina','sync','0'),('oauth-sina','key',''),('oauth-sina','id',''),('oauth-sina','order','2'),('oauth-sina','name','新浪微博'),('oauth-sina','enable','0'),('oauth-baidu','key',''),('oauth-baidu','id',''),('oauth-baidu','order','3'),('oauth-baidu','name','百度'),('oauth-baidu','enable','0'),('oauth-netease','key',''),('oauth-netease','id',''),('oauth-netease','enable','0'),('oauth-netease','order','4'),('oauth-netease','name','网易通行证'),('oauth-wechat','key',''),('oauth-wechat','id',''),('oauth-wechat','order','5'),('oauth-wechat','name','微信'),('oauth-wechat','enable','0'),('oauth-taobao','id',''),('oauth-taobao','order','6'),('oauth-taobao','name','淘宝'),('oauth-taobao','enable','0'),('oauth-taobao','key',''),('oauth-msn','key',''),('oauth-msn','id',''),('oauth-msn','order','7'),('oauth-msn','name','MSN'),('oauth-msn','enable','0'),('weixin','credit','10'),('weixin','bind','点击可绑定会员帐号、查看会员信息、收发站内信件、管理我的订单等服务内容'),('weixin','weixin',''),('weixin','welcome','感谢您的关注，请点击菜单查看相应的服务'),('weixin','aeskey',''),('weixin','appsecret',''),('weixin','apptoken',''),('weixin','appid',''),('weixin-menu','menu','a:3:{i:0;a:6:{i:0;a:2:{s:4:\"name\";s:6:\"最新\";s:3:\"key\";s:0:\"\";}i:1;a:2:{s:4:\"name\";s:6:\"资讯\";s:3:\"key\";s:7:\"V_mid21\";}i:2;a:2:{s:4:\"name\";s:6:\"供应\";s:3:\"key\";s:6:\"V_mid5\";}i:3;a:2:{s:4:\"name\";s:6:\"求购\";s:3:\"key\";s:6:\"V_mid6\";}i:4;a:2:{s:4:\"name\";s:6:\"商城\";s:3:\"key\";s:7:\"V_mid16\";}i:5;a:2:{s:4:\"name\";s:6:\"招商\";s:3:\"key\";s:7:\"V_mid22\";}}i:1;a:6:{i:0;a:2:{s:4:\"name\";s:6:\"会员\";s:3:\"key\";s:8:\"V_member\";}i:1;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}i:2;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}i:3;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}i:4;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}i:5;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}}i:2;a:6:{i:0;a:2:{s:4:\"name\";s:6:\"更多\";s:3:\"key\";s:29:\"http://www.tianyi.com/mobile/\";}i:1;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}i:2;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}i:3;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}i:4;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}i:5;a:2:{s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}}}'),('group-1','listorder','1'),('group-1','reg','0'),('group-1','exhibit_free_limit','-1'),('group-1','exhibit_limit','0'),('group-1','group_free_limit','-1'),('group-1','group_limit','0'),('group-1','mall_free_limit','-1'),('group-1','mall_limit','0'),('group-1','buy_free_limit','-1'),('group-1','buy_limit','0'),('group-1','sell_free_limit','-1'),('group-1','sell_limit','0'),('group-1','edit_limit','0'),('group-1','refresh_limit','0'),('group-1','day_limit','0'),('group-1','add_limit','0'),('group-1','copy','1'),('group-1','delete','1'),('group-1','vdeposit','0'),('group-1','vcompany','0'),('group-1','vtruename','0'),('group-1','vmobile','0'),('group-1','vemail','0'),('group-1','moduleids','16,5,6,17,7,8,21,22,13,9,10,12,14,15,18'),('group-1','link_limit','0'),('group-1','honor_limit','0'),('group-1','page_limit','0'),('group-1','news_limit','0'),('group-1','kf','1'),('group-1','stats','1'),('group-1','map','1'),('group-1','style','0'),('group-1','main_d','1,5'),('group-1','main_c','1,5'),('group-1','home_main','0'),('group-1','side_d','0,3,6'),('group-1','side_c','0,3,6'),('group-1','home_side','0'),('group-1','menu_d','0,6,7,11'),('group-1','menu_c','0,6,7,11'),('group-1','home_menu','0'),('group-1','home','0'),('group-1','styleid','0'),('group-1','homepage','0'),('group-1','type_limit','0'),('group-1','price_limit','0'),('group-1','inquiry_limit','0'),('group-1','message_limit','0'),('group-1','express_limit','0'),('group-1','address_limit','0'),('group-1','alert_limit','0'),('group-1','favorite_limit','0'),('group-1','friend_limit','0'),('group-1','inbox_limit','0'),('group-1','chat','1'),('group-1','ad','1'),('group-1','spread','1'),('group-1','trade_sell','1'),('group-1','sendmail','1'),('group-1','sms','1'),('group-1','mail','1'),('group-1','ask','1'),('group-1','cash','1'),('group-1','question','0'),('group-1','captcha','0'),('group-1','check','0'),('group-1','uploadpt','0'),('group-1','uploadcredit','0'),('group-1','uploadday','0'),('group-1','uploadlimit','0'),('group-1','uploadsize','0'),('group-1','uploadtype',''),('group-1','upload','1'),('group-1','editor','Destoon'),('group-1','grade','0'),('group-1','commission','0'),('group-1','discount','100'),('group-1','fee','0'),('group-1','fee_mode','0'),('group-1','quote_limit','0'),('group-1','quote_free_limit','-1'),('group-1','job_limit','0'),('group-1','job_free_limit','-1'),('group-1','resume_limit','0'),('group-1','resume_free_limit','-1'),('group-1','article_limit','0'),('group-1','article_free_limit','-1'),('group-1','info_limit','0'),('group-1','info_free_limit','-1'),('group-1','know_limit','0'),('group-1','know_free_limit','-1'),('group-1','brand_limit','0'),('group-1','brand_free_limit','-1'),('group-1','photo_limit','0'),('group-1','photo_free_limit','-1'),('group-1','video_limit','0'),('group-1','video_free_limit','-1'),('group-1','down_limit','0'),('group-1','down_free_limit','-1'),('group-1','club_group_limit','0'),('group-1','club_reply_limit','0'),('group-1','club_join_limit','0'),('group-1','club_limit','0'),('group-1','club_free_limit','-1'),('group-2','listorder','2'),('group-2','reg','0'),('group-2','quote_limit','-1'),('group-2','exhibit_free_limit','0'),('group-2','exhibit_limit','-1'),('group-2','group_free_limit','0'),('group-2','group_limit','-1'),('group-2','mall_free_limit','0'),('group-2','mall_limit','-1'),('group-2','buy_free_limit','0'),('group-2','buy_limit','-1'),('group-2','sell_free_limit','0'),('group-2','sell_limit','-1'),('group-2','edit_limit','-1'),('group-2','refresh_limit','-1'),('group-2','day_limit','-1'),('group-2','add_limit','-1'),('group-2','copy','0'),('group-2','delete','0'),('group-2','vdeposit','0'),('group-2','vcompany','0'),('group-2','vtruename','0'),('group-2','vmobile','0'),('group-2','vemail','0'),('group-2','moduleids','6'),('group-2','link_limit','-1'),('group-2','honor_limit','-1'),('group-2','page_limit','-1'),('group-2','news_limit','-1'),('group-2','kf','0'),('group-2','stats','0'),('group-2','map','0'),('group-2','style','0'),('group-2','main_d','5'),('group-2','main_c','5'),('group-2','home_main','0'),('group-2','side_d','0'),('group-2','side_c','0'),('group-2','home_side','0'),('group-2','menu_d','0'),('group-2','menu_c','0'),('group-2','home_menu','0'),('group-2','home','0'),('group-2','styleid','0'),('group-2','homepage','0'),('group-2','type_limit','-1'),('group-2','price_limit','-1'),('group-2','inquiry_limit','-1'),('group-2','message_limit','-1'),('group-2','express_limit','-1'),('group-2','address_limit','-1'),('group-2','alert_limit','-1'),('group-2','favorite_limit','-1'),('group-2','friend_limit','-1'),('group-2','inbox_limit','-1'),('group-2','chat','0'),('group-2','ad','0'),('group-2','spread','0'),('group-2','trade_sell','0'),('group-2','sendmail','0'),('group-2','sms','0'),('group-2','mail','0'),('group-2','ask','0'),('group-2','cash','0'),('group-2','question','1'),('group-2','captcha','1'),('group-2','check','1'),('group-2','uploadpt','1'),('group-2','uploadcredit','1'),('group-2','uploadday','10'),('group-2','uploadlimit','2'),('group-2','uploadsize','200'),('group-2','uploadtype',''),('group-2','upload','0'),('group-2','editor','Basic'),('group-2','grade','0'),('group-2','commission','0'),('group-2','discount','100'),('group-2','fee','0'),('group-2','fee_mode','0'),('group-2','quote_free_limit','0'),('group-2','job_limit','-1'),('group-2','job_free_limit','0'),('group-2','resume_limit','-1'),('group-2','resume_free_limit','0'),('group-2','article_limit','-1'),('group-2','article_free_limit','0'),('group-2','info_limit','-1'),('group-2','info_free_limit','0'),('group-2','know_limit','-1'),('group-2','know_free_limit','0'),('group-2','brand_limit','-1'),('group-2','brand_free_limit','0'),('group-2','photo_limit','-1'),('group-2','photo_free_limit','0'),('group-2','video_limit','-1'),('group-2','video_free_limit','0'),('group-2','down_limit','-1'),('group-2','down_free_limit','0'),('group-2','club_group_limit','-1'),('group-2','club_reply_limit','-1'),('group-2','club_join_limit','-1'),('group-2','club_limit','-1'),('group-2','club_free_limit','0'),('group-3','listorder','3'),('group-3','reg','0'),('group-3','exhibit_free_limit','0'),('group-3','exhibit_limit','3'),('group-3','group_free_limit','0'),('group-3','group_limit','-1'),('group-3','mall_free_limit','0'),('group-3','mall_limit','-1'),('group-3','buy_free_limit','0'),('group-3','buy_limit','3'),('group-3','sell_free_limit','0'),('group-3','sell_limit','3'),('group-3','edit_limit','-1'),('group-3','refresh_limit','-1'),('group-3','day_limit','3'),('group-3','add_limit','30'),('group-3','copy','0'),('group-3','delete','0'),('group-3','vdeposit','0'),('group-3','vcompany','0'),('group-3','vtruename','0'),('group-3','vmobile','0'),('group-3','vemail','0'),('group-3','moduleids','5,6,8,22,9,-9'),('group-3','link_limit','-1'),('group-3','honor_limit','-1'),('group-3','page_limit','-1'),('group-3','news_limit','-1'),('group-3','kf','0'),('group-3','stats','0'),('group-3','map','0'),('group-3','style','0'),('group-3','main_d','5'),('group-3','main_c','5'),('group-3','home_main','0'),('group-3','side_d','0'),('group-3','side_c','0'),('group-3','home_side','0'),('group-3','menu_d','0'),('group-3','menu_c','0'),('group-3','home_menu','0'),('group-3','home','0'),('group-3','styleid','0'),('group-3','homepage','0'),('group-3','type_limit','-1'),('group-3','price_limit','10'),('group-3','inquiry_limit','30'),('group-3','message_limit','30'),('group-3','express_limit','-1'),('group-3','address_limit','-1'),('group-3','alert_limit','-1'),('group-3','favorite_limit','-1'),('group-3','friend_limit','-1'),('group-3','inbox_limit','-1'),('group-3','chat','1'),('group-3','ad','0'),('group-3','spread','0'),('group-3','trade_sell','0'),('group-3','sendmail','0'),('group-3','sms','0'),('group-3','mail','0'),('group-3','ask','0'),('group-3','cash','0'),('group-3','question','1'),('group-3','captcha','1'),('group-3','check','1'),('group-3','uploadpt','1'),('group-3','uploadcredit','0'),('group-3','uploadday','10'),('group-3','uploadlimit','5'),('group-3','uploadsize','500'),('group-3','uploadtype',''),('group-3','upload','0'),('group-3','editor','Basic'),('group-3','grade','0'),('group-3','commission','0'),('group-3','discount','100'),('group-3','fee','0'),('group-3','fee_mode','0'),('group-3','quote_limit','3'),('group-3','quote_free_limit','0'),('group-3','job_limit','3'),('group-3','job_free_limit','0'),('group-3','resume_limit','3'),('group-3','resume_free_limit','0'),('group-3','article_limit','3'),('group-3','article_free_limit','0'),('group-3','info_limit','3'),('group-3','info_free_limit','0'),('group-3','know_limit','3'),('group-3','know_free_limit','0'),('group-3','brand_limit','3'),('group-3','brand_free_limit','0'),('group-3','photo_limit','3'),('group-3','photo_free_limit','0'),('group-3','video_limit','3'),('group-3','video_free_limit','0'),('group-3','down_limit','3'),('group-3','down_free_limit','0'),('group-3','club_group_limit','-1'),('group-3','club_reply_limit','-1'),('group-3','club_join_limit','-1'),('group-3','club_limit','-1'),('group-3','club_free_limit','0'),('group-4','listorder','4'),('group-4','reg','0'),('group-4','job_limit','-1'),('group-4','quote_free_limit','0'),('group-4','quote_limit','-1'),('group-4','exhibit_free_limit','0'),('group-4','exhibit_limit','-1'),('group-4','group_free_limit','0'),('group-4','group_limit','-1'),('group-4','mall_free_limit','0'),('group-4','mall_limit','-1'),('group-4','buy_free_limit','0'),('group-4','buy_limit','-1'),('group-4','sell_free_limit','0'),('group-4','sell_limit','-1'),('group-4','edit_limit','-1'),('group-4','refresh_limit','-1'),('group-4','day_limit','-1'),('group-4','add_limit','-1'),('group-4','copy','0'),('group-4','delete','0'),('group-4','vdeposit','0'),('group-4','vcompany','0'),('group-4','vtruename','0'),('group-4','vmobile','0'),('group-4','vemail','0'),('group-4','moduleids','6'),('group-4','link_limit','-1'),('group-4','honor_limit','-1'),('group-4','page_limit','-1'),('group-4','news_limit','-1'),('group-4','kf','0'),('group-4','stats','0'),('group-4','map','0'),('group-4','style','0'),('group-4','main_d','5'),('group-4','main_c','5'),('group-4','home_main','0'),('group-4','side_d','0'),('group-4','side_c','0'),('group-4','home_side','0'),('group-4','menu_d','0'),('group-4','menu_c','0'),('group-4','home_menu','0'),('group-4','home','0'),('group-4','styleid','0'),('group-4','homepage','0'),('group-4','type_limit','-1'),('group-4','price_limit','-1'),('group-4','inquiry_limit','-1'),('group-4','message_limit','-1'),('group-4','express_limit','-1'),('group-4','address_limit','-1'),('group-4','alert_limit','-1'),('group-4','favorite_limit','-1'),('group-4','friend_limit','-1'),('group-4','inbox_limit','-1'),('group-4','chat','1'),('group-4','ad','0'),('group-4','spread','0'),('group-4','trade_sell','0'),('group-4','sendmail','0'),('group-4','sms','0'),('group-4','mail','0'),('group-4','ask','0'),('group-4','cash','0'),('group-4','question','1'),('group-4','captcha','1'),('group-4','check','1'),('group-4','uploadpt','1'),('group-4','uploadcredit','0'),('group-4','uploadday','10'),('group-4','uploadlimit','5'),('group-4','uploadsize','500'),('group-4','uploadtype',''),('group-4','upload','0'),('group-4','editor','Basic'),('group-4','grade','0'),('group-4','commission','0'),('group-4','discount','100'),('group-4','fee','0'),('group-4','fee_mode','0'),('group-4','job_free_limit','0'),('group-4','resume_limit','-1'),('group-4','resume_free_limit','0'),('group-4','article_limit','-1'),('group-4','article_free_limit','0'),('group-4','info_limit','-1'),('group-4','info_free_limit','0'),('group-4','know_limit','-1'),('group-4','know_free_limit','0'),('group-4','brand_limit','-1'),('group-4','brand_free_limit','0'),('group-4','photo_limit','-1'),('group-4','photo_free_limit','0'),('group-4','video_limit','-1'),('group-4','video_free_limit','0'),('group-4','down_limit','-1'),('group-4','down_free_limit','0'),('group-4','club_group_limit','-1'),('group-4','club_reply_limit','-1'),('group-4','club_join_limit','-1'),('group-4','club_limit','-1'),('group-4','club_free_limit','0'),('group-5','listorder','5'),('group-5','reg','1'),('group-5','info_limit','3'),('group-5','article_free_limit','0'),('group-5','article_limit','3'),('group-5','resume_free_limit','0'),('group-5','resume_limit','3'),('group-5','job_free_limit','0'),('group-5','job_limit','3'),('group-5','quote_free_limit','0'),('group-5','quote_limit','3'),('group-5','exhibit_free_limit','0'),('group-5','exhibit_limit','3'),('group-5','group_free_limit','0'),('group-5','group_limit','-1'),('group-5','mall_free_limit','0'),('group-5','mall_limit','-1'),('group-5','buy_free_limit','0'),('group-5','buy_limit','3'),('group-5','sell_free_limit','0'),('group-5','sell_limit','3'),('group-5','edit_limit','3'),('group-5','refresh_limit','600'),('group-5','day_limit','3'),('group-5','add_limit','30'),('group-5','copy','1'),('group-5','delete','1'),('group-5','vdeposit','0'),('group-5','vcompany','0'),('group-5','vtruename','0'),('group-5','vmobile','0'),('group-5','vemail','0'),('group-5','moduleids','5,6,-9,10,12,18'),('group-5','link_limit','-1'),('group-5','honor_limit','-1'),('group-5','page_limit','-1'),('group-5','news_limit','-1'),('group-5','kf','0'),('group-5','stats','0'),('group-5','map','0'),('group-5','style','0'),('group-5','main_d','5'),('group-5','main_c','5'),('group-5','home_main','0'),('group-5','side_d','0'),('group-5','side_c','0'),('group-5','home_side','0'),('group-5','menu_d','0'),('group-5','menu_c','0'),('group-5','home_menu','0'),('group-5','home','0'),('group-5','styleid','0'),('group-5','homepage','0'),('group-5','type_limit','10'),('group-5','price_limit','-1'),('group-5','inquiry_limit','3'),('group-5','message_limit','10'),('group-5','express_limit','-1'),('group-5','address_limit','10'),('group-5','alert_limit','3'),('group-5','favorite_limit','20'),('group-5','friend_limit','10'),('group-5','inbox_limit','20'),('group-5','chat','1'),('group-5','ad','1'),('group-5','spread','0'),('group-5','trade_sell','0'),('group-5','sendmail','1'),('group-5','sms','1'),('group-5','mail','1'),('group-5','ask','0'),('group-5','cash','0'),('group-5','question','1'),('group-5','captcha','1'),('group-5','check','1'),('group-5','uploadpt','1'),('group-5','uploadcredit','0'),('group-5','uploadday','20'),('group-5','uploadlimit','5'),('group-5','uploadsize',''),('group-5','uploadtype',''),('group-5','upload','1'),('group-5','editor','Simple'),('group-5','grade','1'),('group-5','commission','0'),('group-5','discount','100'),('group-5','fee','0'),('group-5','fee_mode','0'),('group-5','info_free_limit','0'),('group-5','know_limit','0'),('group-5','know_free_limit','0'),('group-5','brand_limit','3'),('group-5','brand_free_limit','0'),('group-5','photo_limit','3'),('group-5','photo_free_limit','0'),('group-5','video_limit','3'),('group-5','video_free_limit','0'),('group-5','down_limit','3'),('group-5','down_free_limit','0'),('group-5','club_group_limit','-1'),('group-5','club_reply_limit','10'),('group-5','club_join_limit','10'),('group-5','club_limit','0'),('group-5','club_free_limit','0'),('group-6','listorder','6'),('group-6','reg','1'),('group-6','quote_limit','5'),('group-6','exhibit_free_limit','1'),('group-6','exhibit_limit','5'),('group-6','group_free_limit','1'),('group-6','group_limit','5'),('group-6','mall_free_limit','1'),('group-6','mall_limit','5'),('group-6','buy_free_limit','1'),('group-6','buy_limit','5'),('group-6','sell_free_limit','1'),('group-6','sell_limit','5'),('group-6','edit_limit','0'),('group-6','refresh_limit','600'),('group-6','day_limit','5'),('group-6','add_limit','60'),('group-6','copy','1'),('group-6','delete','1'),('group-6','vdeposit','0'),('group-6','vcompany','0'),('group-6','vtruename','0'),('group-6','vmobile','0'),('group-6','vemail','0'),('group-6','moduleids','16,5,6,17,7,8,22,13,9,10,12,18'),('group-6','link_limit','20'),('group-6','honor_limit','10'),('group-6','page_limit','5'),('group-6','news_limit','20'),('group-6','kf','0'),('group-6','stats','0'),('group-6','map','1'),('group-6','style','0'),('group-6','main_d','0,1,2'),('group-6','main_c','0,1,2,3,4,5,6'),('group-6','home_main','0'),('group-6','side_d','0,2,4,6'),('group-6','side_c','0,1,2,3,4,5,6'),('group-6','home_side','0'),('group-6','menu_d','0,1,2,3,4,6,7'),('group-6','menu_c','0,1,2,3,4,5,6,7,8,9,10,11'),('group-6','home_menu','0'),('group-6','home','0'),('group-6','styleid','0'),('group-6','homepage','1'),('group-6','type_limit','10'),('group-6','price_limit','3'),('group-6','inquiry_limit','10'),('group-6','message_limit','20'),('group-6','express_limit','5'),('group-6','address_limit','10'),('group-6','alert_limit','5'),('group-6','favorite_limit','50'),('group-6','friend_limit','50'),('group-6','inbox_limit','50'),('group-6','chat','1'),('group-6','ad','1'),('group-6','spread','0'),('group-6','trade_sell','1'),('group-6','sendmail','1'),('group-6','sms','1'),('group-6','mail','1'),('group-6','ask','1'),('group-6','cash','0'),('group-6','question','1'),('group-6','captcha','1'),('group-6','check','1'),('group-6','uploadpt','0'),('group-6','uploadcredit','0'),('group-6','uploadday','50'),('group-6','uploadlimit','5'),('group-6','uploadsize',''),('group-6','uploadtype',''),('group-6','upload','1'),('group-6','editor','Destoon'),('group-6','grade','1'),('group-6','commission','0'),('group-6','discount','100'),('group-6','fee','0'),('group-6','fee_mode','0'),('group-6','quote_free_limit','1'),('group-6','job_limit','5'),('group-6','job_free_limit','1'),('group-6','resume_limit','5'),('group-6','resume_free_limit','1'),('group-6','article_limit','5'),('group-6','article_free_limit','1'),('group-6','info_limit','5'),('group-6','info_free_limit','1'),('group-6','know_limit','0'),('group-6','know_free_limit','1'),('group-6','brand_limit','5'),('group-6','brand_free_limit','1'),('group-6','photo_limit','5'),('group-6','photo_free_limit','1'),('group-6','video_limit','5'),('group-6','video_free_limit','1'),('group-6','down_limit','5'),('group-6','down_free_limit','1'),('group-6','club_group_limit','1'),('group-6','club_reply_limit','50'),('group-6','club_join_limit','10'),('group-6','club_limit','0'),('group-6','club_free_limit','0'),('group-7','listorder','7'),('group-7','reg','0'),('group-7','quote_free_limit','0'),('group-7','quote_limit','0'),('group-7','exhibit_free_limit','0'),('group-7','exhibit_limit','0'),('group-7','group_free_limit','0'),('group-7','group_limit','0'),('group-7','mall_free_limit','0'),('group-7','mall_limit','0'),('group-7','buy_free_limit','0'),('group-7','buy_limit','0'),('group-7','sell_free_limit','0'),('group-7','sell_limit','0'),('group-7','edit_limit','0'),('group-7','refresh_limit','60'),('group-7','day_limit','10'),('group-7','add_limit','0'),('group-7','copy','1'),('group-7','delete','1'),('group-7','vdeposit','0'),('group-7','vcompany','0'),('group-7','vtruename','0'),('group-7','vmobile','0'),('group-7','vemail','1'),('group-7','moduleids','16,5,6,17,7,8,21,22,13,9,-9,10,12,14,15,18'),('group-7','link_limit','50'),('group-7','honor_limit','20'),('group-7','page_limit','5'),('group-7','news_limit','100'),('group-7','kf','1'),('group-7','stats','1'),('group-7','map','1'),('group-7','style','1'),('group-7','main_d','0,1,2,7'),('group-7','main_c','0,1,2,4,5,6,7'),('group-7','home_main','1'),('group-7','side_d','0,1,2,4,6'),('group-7','side_c','0,1,2,3,4,5,6'),('group-7','home_side','1'),('group-7','menu_d','0,1,2,3,4,5,6,7,8,9,10,11,12,13'),('group-7','menu_c','0,1,2,3,4,5,6,7,8,9,10,11,12,13'),('group-7','home_menu','1'),('group-7','home','1'),('group-7','styleid','2'),('group-7','homepage','1'),('group-7','type_limit','20'),('group-7','price_limit','20'),('group-7','inquiry_limit','50'),('group-7','message_limit','100'),('group-7','express_limit','10'),('group-7','address_limit','10'),('group-7','alert_limit','10'),('group-7','favorite_limit','100'),('group-7','friend_limit','200'),('group-7','inbox_limit','500'),('group-7','chat','1'),('group-7','ad','1'),('group-7','spread','1'),('group-7','trade_sell','1'),('group-7','sendmail','1'),('group-7','sms','1'),('group-7','mail','1'),('group-7','ask','1'),('group-7','cash','1'),('group-7','question','0'),('group-7','captcha','0'),('group-7','check','0'),('group-7','uploadpt','0'),('group-7','uploadcredit','0'),('group-7','uploadday','100'),('group-7','uploadlimit','10'),('group-7','uploadsize',''),('group-7','uploadtype',''),('group-7','upload','1'),('group-7','editor','Destoon'),('group-7','grade','1'),('group-7','commission','0'),('group-7','discount',''),('group-7','fee','2000'),('group-7','fee_mode','1'),('group-7','job_limit','0'),('group-7','job_free_limit','0'),('group-7','resume_limit','0'),('group-7','resume_free_limit','0'),('group-7','article_limit','0'),('group-7','article_free_limit','0'),('group-7','info_limit','0'),('group-7','info_free_limit','0'),('group-7','know_limit','0'),('group-7','know_free_limit','0'),('group-7','brand_limit','0'),('group-7','brand_free_limit','0'),('group-7','photo_limit','0'),('group-7','photo_free_limit','0'),('group-7','video_limit','0'),('group-7','video_free_limit','0'),('group-7','down_limit','0'),('group-7','down_free_limit','0'),('group-7','club_group_limit','3'),('group-7','club_reply_limit','0'),('group-7','club_join_limit','50'),('group-7','club_limit','0'),('group-7','club_free_limit','0'),('destoon','backtime','1467860142'),('1','admin_hour',''),('1','admin_ip',''),('1','admin_area',''),('1','remote_url',''),('1','ftp_path',''),('1','ftp_save','0'),('1','ftp_pasv','0'),('1','ftp_ssl','0'),('1','ftp_user',''),('1','ftp_pass',''),('1','ftp_port','21'),('1','ftp_host',''),('1','max_len','20000'),('1','ftp_remote','0'),('1','schcate_limit','10'),('1','pagesize','20'),('1','pushtime','0'),('1','online','1200'),('1','search_limit','1'),('1','max_kw','30'),('1','min_kw','3'),('1','search_check_kw','0'),('1','search_kw','1'),('1','save_draft','0'),('1','search_tips','1'),('1','anti_spam','1'),('1','log_credit','1'),('1','pages_mode','0'),('1','lazy','1'),('1','gzip_enable','0'),('1','cache_hits','0'),('1','cache_search','0'),('1','task_item','7200'),('1','task_list','1800'),('1','task_index','600'),('1','log_404','0'),('1','pcharset','0'),('1','com_www','0'),('1','rewrite','0'),('1','index_html','1'),('1','file_ext','html'),('1','index','index'),('1','seo_description',''),('1','seo_keywords',''),('1','seo_title','天医工程网'),('1','seo_delimiter','_'),('1','trade_nu','notify.php'),('1','trade_tp','0'),('1','trade_ac',''),('1','trade_pw',''),('1','trade_id',''),('1','trade_hm','http://www.alipay.com/'),('1','trade_nm','支付宝'),('1','trade',''),('1','im_skype','0'),('1','im_msn','0'),('1','im_ali','1'),('1','im_qq','1'),('1','credit_name','积分'),('1','im_web','1'),('1','admin_left','188'),('1','credit_unit','点'),('1','money_sign','￥'),('1','money_name','资金'),('1','money_unit','元'),('1','city_ip','0'),('1','city','0'),('1','close_reason','网站维护中，请稍候访问...'),('1','copyright','sd'),('1','telephone',''),('1','icpno',''),('1','close','0'),('1','logo','http://www.tctianyi.com/file/upload/201701/04/230523441.png'),('1','sitename','天医工程网');

#
# Structure for table "ty_sms"
#

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

#
# Data for table "ty_sms"
#


#
# Structure for table "ty_special"
#

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

#
# Data for table "ty_special"
#


#
# Structure for table "ty_special_data"
#

CREATE TABLE `ty_special_data` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题内容';

#
# Data for table "ty_special_data"
#


#
# Structure for table "ty_special_item"
#

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

#
# Data for table "ty_special_item"
#


#
# Structure for table "ty_sphinx"
#

CREATE TABLE `ty_sphinx` (
  `moduleid` int(10) unsigned NOT NULL DEFAULT '0',
  `maxid` bigint(20) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `moduleid` (`moduleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Sphinx';

#
# Data for table "ty_sphinx"
#


#
# Structure for table "ty_spread"
#

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

#
# Data for table "ty_spread"
#


#
# Structure for table "ty_spread_price"
#

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

#
# Data for table "ty_spread_price"
#


#
# Structure for table "ty_style"
#

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

#
# Data for table "ty_style"
#

INSERT INTO `ty_style` VALUES (2,0,'深蓝模板','blue','homepage','Destoon.COM',',6,7,',0,'money',0,0,1,1467860142,'tianyi',1467860142,0),(3,0,'绿色模板','green','homepage','Destoon.COM',',6,7,',0,'money',0,0,0,1467860142,'tianyi',1467860142,0),(4,0,'紫色模板','purple','homepage','Destoon.COM',',6,7,',0,'credit',0,5,2,1467860142,'tianyi',1467860142,0),(5,0,'橙色模板','orange','homepage','Destoon.COM',',6,7,',0,'credit',120,0,1,1467860142,'tianyi',1467860142,0),(6,99,'默认模板','default','homepage','Destoon.COM',',6,7,',0,'money',0,0,0,1467860142,'tianyi',1467860142,0);

#
# Structure for table "ty_type"
#

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

#
# Data for table "ty_type"
#

INSERT INTO `ty_type` VALUES (1,0,0,'医疗行业','','link',1);

#
# Structure for table "ty_upgrade"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员升级';

#
# Data for table "ty_upgrade"
#


#
# Structure for table "ty_upload_0"
#

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

#
# Data for table "ty_upload_0"
#


#
# Structure for table "ty_upload_1"
#

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
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='上传记录1';

#
# Data for table "ty_upload_1"
#

INSERT INTO `ty_upload_1` VALUES (2,'a5dd1eb5e755eaadbe1dcf29b8d2ef2f',3,0,'http://www.tianyi.com/file/upload/201607/13/125340421.jpg',28804,'jpg','thumb',400,160,1468385620,'tianyi','127.0.0.1'),(3,'762d42ace78058908da3278ba765a017',3,0,'http://www.tianyi.com/file/upload/201607/13/125353611.jpg',63265,'jpg','thumb',400,160,1468385633,'tianyi','127.0.0.1'),(4,'06901770934a118de75abc24bc44b396',1,0,'http://www.tctianyi.com/file/upload/201701/04/230523441.png',5017,'png','thumb',119,71,1483542323,'tianyi','127.0.0.1'),(5,'3849361380434d9b3fe04d8a8b15e220',16,1,'http://www.tctianyi.com/file/upload/201701/19/152759561.png.thumb.png',14978,'png','album',213,79,1484810879,'tianyi','127.0.0.1'),(6,'1ccea23a4f2444372e11f1315b16e89a',16,1,'http://www.tctianyi.com/file/upload/201701/19/152807241.png.thumb.png',14978,'png','album',213,79,1484810887,'tianyi','127.0.0.1'),(7,'d83cd3b15eaf17db3082970df3ecfc97',16,2,'http://www.tctianyi.com/file/upload/201701/19/154553961.jpg.thumb.jpg',7298,'jpg','album',403,220,1484811953,'tianyi','127.0.0.1'),(8,'7e32e1d8c2aa1c8c53988e826a7cb5a3',16,3,'http://www.tctianyi.com/file/upload/201701/19/154631131.jpg.thumb.jpg',7285,'jpg','album',266,161,1484811991,'tianyi','127.0.0.1'),(9,'fd0f480aa6426b73e7b50ab96f32d2cb',16,4,'http://www.tctianyi.com/file/upload/201701/19/154708591.jpg.thumb.jpg',10135,'jpg','album',264,175,1484812028,'tianyi','127.0.0.1'),(10,'61a7ef0d2204c9f9456a29c92e38ab54',16,5,'http://www.tctianyi.com/file/upload/201701/19/155200531.jpg.thumb.jpg',9242,'jpg','album',338,178,1484812320,'tianyi','127.0.0.1'),(11,'807d961babf1e219de7c0d99fab4681e',16,6,'http://www.tctianyi.com/file/upload/201701/19/155225661.jpg.thumb.jpg',9949,'jpg','album',317,174,1484812345,'tianyi','127.0.0.1'),(12,'fae57564b8c20109fa0dc2523767ba71',16,7,'http://www.tctianyi.com/file/upload/201701/19/164930471.jpg.thumb.jpg',14292,'jpg','album',454,269,1484815770,'tianyi','127.0.0.1'),(13,'17283a69dd7ea505472048f9ddd83672',16,8,'http://www.tctianyi.com/file/upload/201701/19/165000481.jpg.thumb.jpg',13545,'jpg','album',643,344,1484815800,'tianyi','127.0.0.1'),(14,'da117960e04a88a252e1a9197fdf15a0',16,9,'http://www.tctianyi.com/file/upload/201701/20/110702451.jpg.thumb.jpg',35441,'jpg','album',690,457,1484881622,'tianyi','127.0.0.1'),(15,'2a81d4a3e723e2a2474456b3cb9988f8',16,10,'http://www.tctianyi.com/file/upload/201701/20/110742761.jpg.thumb.jpg',10647,'jpg','album',250,250,1484881662,'tianyi','127.0.0.1'),(16,'55d9d873e636247ad98a643a0dce9fe9',16,11,'http://www.tctianyi.com/file/upload/201701/20/110819481.jpg.thumb.jpg',22354,'jpg','album',533,300,1484881699,'tianyi','127.0.0.1'),(17,'cb19324a74066e852df947a3845f01b7',16,12,'http://www.tctianyi.com/file/upload/201701/20/110857771.jpg.thumb.jpg',31792,'jpg','album',580,435,1484881737,'tianyi','127.0.0.1'),(18,'85486ecd91306204b38953b2ba2804c8',16,13,'http://www.tctianyi.com/file/upload/201701/20/111146231.jpg.thumb.jpg',9062,'jpg','album',392,220,1484881906,'tianyi','127.0.0.1'),(20,'6e06fa5239138879484ce3fe6437598a',16,13,'http://www.tctianyi.com/file/upload/201701/20/111158581.jpg.thumb.jpg',11890,'jpg','album',397,300,1484881918,'tianyi','127.0.0.1'),(21,'d65b04e69fe305475040352517043606',16,14,'http://www.tctianyi.com/file/upload/201701/20/111302171.jpg.thumb.jpg',180192,'jpg','album',800,359,1484881982,'tianyi','127.0.0.1'),(22,'8a51fe975a528c363a65f1173d191651',16,15,'http://www.tctianyi.com/file/upload/201701/20/111528731.jpg.thumb.jpg',15819,'jpg','album',399,300,1484882128,'tianyi','127.0.0.1'),(23,'f1831fa0cb44204594bd50c04798a0af',16,15,'http://www.tctianyi.com/file/upload/201701/20/111534741.jpg.thumb.jpg',17118,'jpg','album',362,300,1484882134,'tianyi','127.0.0.1'),(24,'eb0d060f3fb79460e2f934fcbe04ea58',16,16,'http://www.tctianyi.com/file/upload/201701/20/111715341.jpg.thumb.jpg',19424,'jpg','album',650,384,1484882235,'tianyi','127.0.0.1'),(25,'3c2b1d365bd0d49d7904624d35a0304c',16,17,'http://www.tctianyi.com/file/upload/201701/20/111812951.jpg.thumb.jpg',9059,'jpg','album',330,300,1484882292,'tianyi','127.0.0.1'),(26,'e1ebfc998ec5d7766b40d96865f3064a',16,18,'http://www.tctianyi.com/file/upload/201701/20/112106911.jpg.thumb.jpg',17005,'jpg','album',250,248,1484882466,'tianyi','127.0.0.1'),(27,'a989e0fd1e9213b2fb52d692682ee20c',16,19,'http://www.tctianyi.com/file/upload/201701/20/112458441.jpg.thumb.jpg',167362,'jpg','album',800,599,1484882698,'tianyi','127.0.0.1'),(28,'5ff9b20d64b105a25f35cee2a85e3ccf',16,19,'http://www.tctianyi.com/file/upload/201701/20/112513561.jpg.thumb.jpg',42442,'jpg','album',435,300,1484882713,'tianyi','127.0.0.1'),(29,'765d41dda249114cff78ab6736f46850',16,20,'http://www.tctianyi.com/file/upload/201701/20/112641371.jpg.thumb.jpg',48788,'jpg','album',500,303,1484882801,'tianyi','127.0.0.1'),(30,'96edd49aee81f8f756639a2156657562',16,21,'http://www.tctianyi.com/file/upload/201701/20/112837121.jpg.thumb.jpg',47414,'jpg','album',349,252,1484882917,'tianyi','127.0.0.1'),(31,'f0195d958462335671af216a9926609f',16,22,'http://www.tctianyi.com/file/upload/201701/20/112858981.jpg.thumb.jpg',78939,'jpg','album',750,486,1484882938,'tianyi','127.0.0.1'),(32,'60e888eccba1ee4086c57993ebcf2f39',16,23,'http://www.tctianyi.com/file/upload/201701/20/113150101.jpg.thumb.jpg',13754,'jpg','album',440,300,1484883110,'tianyi','127.0.0.1'),(33,'5eee51fe283ceb10cfbadfd818c9279a',16,23,'http://www.tctianyi.com/file/upload/201701/20/113214431.jpg.thumb.jpg',16724,'jpg','album',319,220,1484883134,'tianyi','127.0.0.1'),(34,'e905d195ee98502e38d6a3b6bdda09bb',16,24,'http://www.tctianyi.com/file/upload/201701/20/113252661.jpg.thumb.jpg',31573,'jpg','album',356,267,1484883172,'tianyi','127.0.0.1'),(35,'b0454e17d515d1742dd5bea77c5b4577',16,24,'http://www.tctianyi.com/file/upload/201701/20/113255801.jpg.thumb.jpg',7298,'jpg','album',403,220,1484883175,'tianyi','127.0.0.1'),(36,'4c4659e4225fe1468f584ffa459f18dc',16,25,'http://www.tctianyi.com/file/upload/201701/20/113518971.jpg.thumb.jpg',29069,'jpg','album',700,466,1484883318,'tianyi','127.0.0.1'),(37,'56ceea0cc948b6f9160d18984388ee69',16,26,'http://www.tctianyi.com/file/upload/201701/20/113548921.jpg.thumb.jpg',29809,'jpg','album',400,300,1484883348,'tianyi','127.0.0.1'),(38,'1acbe4683766c3b525490405633e4a66',16,27,'http://www.tctianyi.com/file/upload/201701/20/113756271.jpg.thumb.jpg',72650,'jpg','album',800,600,1484883476,'tianyi','127.0.0.1'),(39,'63a3b0ae0b490a72f36b01318b1c7cef',16,28,'http://www.tctianyi.com/file/upload/201701/20/113954471.jpg.thumb.jpg',31885,'jpg','album',400,400,1484883594,'tianyi','127.0.0.1'),(40,'8ecb422d6165c6a32913c3f7d8c0a595',16,29,'http://www.tctianyi.com/file/upload/201701/20/114234481.jpg.thumb.jpg',14990,'jpg','album',330,220,1484883754,'tianyi','127.0.0.1'),(41,'874313f5e3b96719e538a7ff3ed7da95',16,30,'http://www.tctianyi.com/file/upload/201701/20/114306371.jpg.thumb.jpg',10035,'jpg','album',291,194,1484883786,'tianyi','127.0.0.1'),(42,'1de6966f222a7b1ab6113c7e9e460796',16,31,'http://www.tctianyi.com/file/upload/201701/20/115211881.jpg.thumb.jpg',20496,'jpg','album',411,307,1484884331,'tianyi','127.0.0.1'),(43,'dcf7a7262bcd6cb53b415b7e12ee4998',16,31,'http://www.tctianyi.com/file/upload/201701/20/115215651.jpg.thumb.jpg',36106,'jpg','album',568,240,1484884335,'tianyi','127.0.0.1'),(44,'a2f876539ee5de5b2acb03fc2141392f',16,32,'http://www.tctianyi.com/file/upload/201701/20/115346881.jpg.thumb.jpg',9587,'jpg','album',361,220,1484884426,'tianyi','127.0.0.1'),(45,'ff2e9ac007d1773ec4f403f846e21783',16,32,'http://www.tctianyi.com/file/upload/201701/20/115351731.jpg.thumb.jpg',13279,'jpg','album',400,300,1484884431,'tianyi','127.0.0.1'),(46,'ed4d5dbba6547f7ee05c138dec42ebc0',16,33,'http://www.tctianyi.com/file/upload/201701/20/115447411.jpg.thumb.jpg',144678,'jpg','album',800,530,1484884487,'tianyi','127.0.0.1'),(47,'954485b5a275942a74eb369be87eafeb',16,34,'http://www.tctianyi.com/file/upload/201701/20/115557351.jpg.thumb.jpg',13548,'jpg','album',400,300,1484884557,'tianyi','127.0.0.1'),(48,'7283b872e4d4ce1e8ec339dddaee1f58',16,35,'http://www.tctianyi.com/file/upload/201701/20/115645561.jpg.thumb.jpg',52009,'jpg','album',800,533,1484884605,'tianyi','127.0.0.1'),(49,'fd8af25873d6809c0ed6adfae2f1d9a0',16,36,'http://www.tctianyi.com/file/upload/201701/20/115749121.jpg.thumb.jpg',10537,'jpg','album',260,300,1484884669,'tianyi','127.0.0.1'),(50,'db9b9da8b268a0092e1ad97ea0b7fd12',16,37,'http://www.tctianyi.com/file/upload/201701/20/140549401.jpg.thumb.jpg',37314,'jpg','album',690,414,1484892349,'tianyi','127.0.0.1'),(51,'4eb9ee1445f9f5c5653d6fa61ebeac66',16,38,'http://www.tctianyi.com/file/upload/201701/20/140745281.jpg.thumb.jpg',16862,'jpg','album',435,300,1484892465,'tianyi','127.0.0.1'),(52,'ba4395cc002eeed0e14ef5ca15b924b5',16,39,'http://www.tctianyi.com/file/upload/201701/20/141009551.jpg.thumb.jpg',67146,'jpg','album',600,287,1484892609,'tianyi','127.0.0.1'),(53,'4b426a1cf18ccd9ee04f285e0f4aefb8',16,40,'http://www.tctianyi.com/file/upload/201701/20/141039231.jpg.thumb.jpg',17794,'jpg','album',449,300,1484892639,'tianyi','127.0.0.1'),(54,'de9e4ce9bfe3cac2e96f56bd0dc8e6af',16,41,'http://www.tctianyi.com/file/upload/201701/20/141258601.jpg.thumb.jpg',252292,'jpg','album',536,468,1484892778,'tianyi','127.0.0.1'),(55,'8d8165a0c256beb35d45920a7296ff57',16,42,'http://www.tctianyi.com/file/upload/201701/20/141442951.jpg.thumb.jpg',10088,'jpg','album',262,220,1484892882,'tianyi','127.0.0.1'),(56,'155197c63e9ca3d1093fb4cfe31af4f3',16,43,'http://www.tctianyi.com/file/upload/201701/20/141739721.jpg.thumb.jpg',11314,'jpg','album',330,300,1484893059,'tianyi','127.0.0.1'),(57,'58fed0235841625d77108bee3283d76e',16,44,'http://www.tctianyi.com/file/upload/201701/20/141931671.jpg.thumb.jpg',9931,'jpg','album',329,287,1484893171,'tianyi','127.0.0.1'),(58,'0c9370b398d416f572c86a3c5ed09a16',16,44,'http://www.tctianyi.com/file/upload/201701/20/141957911.jpg.thumb.jpg',8982,'jpg','album',300,300,1484893197,'tianyi','127.0.0.1'),(59,'736b8d1368fc85b1181827d5861dc01e',16,45,'http://www.tctianyi.com/file/upload/201701/20/142026551.jpg.thumb.jpg',9186,'jpg','album',390,300,1484893226,'tianyi','127.0.0.1'),(60,'a8a22158e6de7ebb0244062f058d669a',16,46,'http://www.tctianyi.com/file/upload/201701/20/142158581.jpg.thumb.jpg',36933,'jpg','album',590,534,1484893318,'tianyi','127.0.0.1'),(61,'2d0834c4b8b1430a2613a84d7d80fb53',16,47,'http://www.tctianyi.com/file/upload/201701/20/142235211.jpg.thumb.jpg',103058,'jpg','album',800,524,1484893355,'tianyi','127.0.0.1'),(62,'6eb426cc9bf506b094864cc9bfb3a977',16,48,'http://www.tctianyi.com/file/upload/201701/20/142337471.jpg.thumb.jpg',17075,'jpg','album',452,300,1484893417,'tianyi','127.0.0.1');

#
# Structure for table "ty_upload_2"
#

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

#
# Data for table "ty_upload_2"
#


#
# Structure for table "ty_upload_3"
#

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

#
# Data for table "ty_upload_3"
#


#
# Structure for table "ty_upload_4"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录4';

#
# Data for table "ty_upload_4"
#


#
# Structure for table "ty_upload_5"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录5';

#
# Data for table "ty_upload_5"
#


#
# Structure for table "ty_upload_6"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录6';

#
# Data for table "ty_upload_6"
#


#
# Structure for table "ty_upload_7"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录7';

#
# Data for table "ty_upload_7"
#


#
# Structure for table "ty_upload_8"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录8';

#
# Data for table "ty_upload_8"
#


#
# Structure for table "ty_upload_9"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='上传记录9';

#
# Data for table "ty_upload_9"
#


#
# Structure for table "ty_validate"
#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='资料认证';

#
# Data for table "ty_validate"
#


#
# Structure for table "ty_video_14"
#

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

#
# Data for table "ty_video_14"
#


#
# Structure for table "ty_video_data_14"
#

CREATE TABLE `ty_video_data_14` (
  `itemid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频内容';

#
# Data for table "ty_video_data_14"
#


#
# Structure for table "ty_vote"
#

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

#
# Data for table "ty_vote"
#


#
# Structure for table "ty_vote_record"
#

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

#
# Data for table "ty_vote_record"
#


#
# Structure for table "ty_webpage"
#

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

#
# Data for table "ty_webpage"
#

INSERT INTO `ty_webpage` VALUES (1,'1',0,0,'关于我们','','关于我们','','','','destoon',1319006891,5,0,0,'about/index.html','',''),(3,'1',0,0,'联系方式','','联系方式','','','','destoon',1310696453,4,0,0,'about/contact.html','',''),(4,'1',0,0,'使用协议','','使用协议','','','','destoon',1310696460,3,0,0,'about/agreement.html','',''),(5,'1',0,0,'版权隐私','','版权隐私','','','','destoon',1310696468,2,0,0,'about/copyright.html','','');

#
# Structure for table "ty_weixin_bind"
#

CREATE TABLE `ty_weixin_bind` (
  `username` varchar(30) NOT NULL DEFAULT '',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信扫码绑定';

#
# Data for table "ty_weixin_bind"
#


#
# Structure for table "ty_weixin_chat"
#

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

#
# Data for table "ty_weixin_chat"
#


#
# Structure for table "ty_weixin_user"
#

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

#
# Data for table "ty_weixin_user"
#

