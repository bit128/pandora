-- MySQL dump 10.13  Distrib 5.7.15, for osx10.11 (x86_64)
--
-- Host: localhost    Database: 1doc
-- ------------------------------------------------------
-- Server version	5.7.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `t_address`
--

DROP TABLE IF EXISTS `t_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_address` (
  `ad_id` char(13) NOT NULL,
  `ad_title` varchar(16) NOT NULL,
  `ad_content` varchar(64) NOT NULL,
  `ad_post` char(6) NOT NULL,
  `ad_phone` varchar(15) NOT NULL,
  `ad_name` varchar(16) NOT NULL,
  `ad_status` tinyint(4) NOT NULL,
  `user_id` char(13) NOT NULL,
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_address`
--

LOCK TABLES `t_address` WRITE;
/*!40000 ALTER TABLE `t_address` DISABLE KEYS */;
INSERT INTO `t_address` VALUES ('57d676247f382','我的地址','海曙路128号仓溢绿苑','000000','18814887668','波哥',0,'57ad684337eee');
/*!40000 ALTER TABLE `t_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_admin`
--

DROP TABLE IF EXISTS `t_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_admin` (
  `am_account` varchar(32) NOT NULL,
  `am_password` char(32) NOT NULL,
  `am_name` varchar(16) NOT NULL,
  `am_group` varchar(16) NOT NULL,
  `am_role` int(11) NOT NULL,
  `am_time` int(11) NOT NULL,
  `am_ip` varchar(15) NOT NULL,
  `am_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`am_account`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_admin`
--

LOCK TABLES `t_admin` WRITE;
/*!40000 ALTER TABLE `t_admin` DISABLE KEYS */;
INSERT INTO `t_admin` VALUES ('hongbo','98b4a59cbf4d5b6293ecfc7de0db870b','洪波','产品',4159,1487553000,'127.0.0.1',1),('bit128','123456','测试账号','运营',5,0,'',0);
/*!40000 ALTER TABLE `t_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_album`
--

DROP TABLE IF EXISTS `t_album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_album` (
  `al_id` char(13) NOT NULL,
  `by_id` char(13) NOT NULL,
  `al_type` varchar(10) NOT NULL,
  `al_name` varchar(32) NOT NULL,
  `al_image` varchar(64) NOT NULL,
  `al_sort` int(11) NOT NULL,
  `al_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`al_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_album`
--

LOCK TABLES `t_album` WRITE;
/*!40000 ALTER TABLE `t_album` DISABLE KEYS */;
INSERT INTO `t_album` VALUES ('5852585b9c752','585257db18c75','product','','/app/statics/files/16/12/15/5852585b6fe50.jpg',1,1),('5852586182fdd','585257db18c75','product','','/app/statics/files/16/12/15/5852586157423.jpg',2,1);
/*!40000 ALTER TABLE `t_album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_cart`
--

DROP TABLE IF EXISTS `t_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_cart` (
  `cr_id` char(13) NOT NULL,
  `cr_count` int(11) NOT NULL,
  `cr_price` float(8,2) NOT NULL,
  `cr_discount` float(3,2) NOT NULL,
  `cr_time` int(11) NOT NULL,
  `pd_id` char(13) NOT NULL,
  `st_id` char(13) NOT NULL,
  `od_id` char(16) NOT NULL,
  `user_id` char(13) NOT NULL,
  PRIMARY KEY (`cr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_cart`
--

LOCK TABLES `t_cart` WRITE;
/*!40000 ALTER TABLE `t_cart` DISABLE KEYS */;
INSERT INTO `t_cart` VALUES ('57c0f147b8b6b',2,98.00,1.00,1472262471,'57ac19eba6e00','57ae9e18d6cfc','1609110951403537','57ad684337eee'),('57c0f181aa71b',3,38.00,1.00,1472262529,'57ac1b5acd3a4','57ae9d81a7dc9','1609110951403537','57ad684337eee');
/*!40000 ALTER TABLE `t_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_channel`
--

DROP TABLE IF EXISTS `t_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_channel` (
  `cn_id` char(13) NOT NULL,
  `cn_fid` char(13) NOT NULL,
  `cn_name` varchar(64) NOT NULL,
  `cn_nick` varchar(64) NOT NULL,
  `cn_url` varchar(255) NOT NULL,
  `cn_time` int(11) NOT NULL,
  `cn_sort` int(11) NOT NULL,
  `cn_admin` varchar(32) NOT NULL,
  `cn_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`cn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_channel`
--

LOCK TABLES `t_channel` WRITE;
/*!40000 ALTER TABLE `t_channel` DISABLE KEYS */;
INSERT INTO `t_channel` VALUES ('1','0','站点根目录','site root','',0,1,'',2),('585615b8ed0db','1','普通课程列表','111','222',1482036664,1,'bit128',1),('589c018e1b677','1','PHP框架Laravel学习','','',1486619022,2,'',1);
/*!40000 ALTER TABLE `t_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_collect`
--

DROP TABLE IF EXISTS `t_collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_collect` (
  `cl_id` char(13) NOT NULL,
  `cl_type` tinyint(4) NOT NULL,
  `cl_time` int(11) NOT NULL,
  `by_id` char(13) NOT NULL,
  `user_id` char(13) NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_collect`
--

LOCK TABLES `t_collect` WRITE;
/*!40000 ALTER TABLE `t_collect` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_collect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_content`
--

DROP TABLE IF EXISTS `t_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_content` (
  `ct_id` char(13) NOT NULL,
  `cn_id` char(13) NOT NULL,
  `ct_title` varchar(128) NOT NULL,
  `ct_subtit` varchar(64) NOT NULL,
  `ct_image` varchar(64) NOT NULL,
  `ct_detail` text NOT NULL,
  `ct_ctime` int(11) NOT NULL,
  `ct_utime` int(11) NOT NULL,
  `ct_view` int(11) NOT NULL,
  `ct_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`ct_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_content`
--

LOCK TABLES `t_content` WRITE;
/*!40000 ALTER TABLE `t_content` DISABLE KEYS */;
INSERT INTO `t_content` VALUES ('589be070a2b5f','585615b8ed0db','ubuntu linux下apache php mysql环境搭建','','/app/statics/files/17/02/09/589be40e2dbd5.jpeg','<h6>宝马i3 S会是一款高性能电动汽车，将依托现有i3，进行小改升级。外观上，将比i3更具动感；在性能和功能上，将采用最新技术。</h6>\n        \n        \n            <p>自 2014 年宝马发布 i3 以来，i3 凭借出色的外观设计和良好的安全性，成为市面上最受欢迎的电动汽车之一。近日，据汽车媒体 <a href=\"http://www.bmwblog.com/2017/02/07/future-bmw-i3-s-aims-sporty-electric-vehicle/\">BMWBlog 报道</a>，宝马将推出运动版 i3，该车命名为 i3 S。</p><p>宝马\n i3 S 会是一款高性能电动汽车，将依托于现有 i3，进行小改升级。BMWBlog 认为外观上，将比 i3 \n更具动感，比如更坚固的车身、更低的底盘高度、轮胎加宽；在性能和功能上，将采用最新技术，既然 i3 S 主打性能，动力很有可能超过 168 \n马力，百公里加速将在 7.3 秒以内。</p><p>BMWBlog 预测，宝马 i3 S 很有可能在 2017 年 9 月的法兰克福车展上与消费者见面；而真正发布，则要等到 2018 年。</p><p>去年，宝马公司已经对旗下 i3 电动汽车进行了升级，大幅提升了续航里程；并推出大电池增程版，续航达到 320 公里，解决了老款 i3 续航不佳的问题。</p><p>近年，宝马一直积极推进电动汽车发展，在 BBA 阵营，已大幅领先竞争对手奔驰、奥迪。并且，宝马在德国总部慕尼黑专门设立无人驾驶研发中心，以继续巩固自身在电动汽车领域的优势。</p>',1486610544,1486611470,75,1),('589d6e5948970','589c018e1b677','新建栏目内容','','','',1486712409,1487137117,0,1);
/*!40000 ALTER TABLE `t_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_content_note`
--

DROP TABLE IF EXISTS `t_content_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_content_note` (
  `tn_id` char(13) NOT NULL,
  `tn_content` varchar(512) NOT NULL,
  `tn_remark` varchar(256) NOT NULL,
  `tn_great` int(11) NOT NULL,
  `tn_time` int(11) NOT NULL,
  `tn_status` tinyint(4) NOT NULL,
  `cn_id` char(13) NOT NULL,
  `ct_id` char(13) NOT NULL,
  `user_id` char(13) NOT NULL,
  PRIMARY KEY (`tn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_content_note`
--

LOCK TABLES `t_content_note` WRITE;
/*!40000 ALTER TABLE `t_content_note` DISABLE KEYS */;
INSERT INTO `t_content_note` VALUES ('58a29de8999f8','近年，宝马一直积极推进电动汽车发展，在 BBA 阵营，已大幅领先竞争对手奔驰、奥迪。 并且，宝马在德国总部慕尼黑专门设立无人驾驶研发中心，以继续巩固自身在电动汽车领域的优势。','谢谢您的参与！',0,1487052264,1,'','589be070a2b5f','589d7ecb10f35'),('58a2ae8873cbf','我还可以在说说这篇文章呢！','好吧，你赢了',0,1487056520,1,'','589be070a2b5f','589d7ecb10f35');
/*!40000 ALTER TABLE `t_content_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_dictionary`
--

DROP TABLE IF EXISTS `t_dictionary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_dictionary` (
  `dc_id` char(13) NOT NULL,
  `dc_keyword` varchar(32) NOT NULL,
  `dc_type` int(11) NOT NULL,
  `dc_count` int(11) NOT NULL,
  `dc_time` int(11) NOT NULL,
  PRIMARY KEY (`dc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_dictionary`
--

LOCK TABLES `t_dictionary` WRITE;
/*!40000 ALTER TABLE `t_dictionary` DISABLE KEYS */;
INSERT INTO `t_dictionary` VALUES ('589c310d116d7','php',1,0,1486631181),('589c3100a0916','python',1,0,1486631168),('589c30f5c0915','linux',1,0,1486631157),('589c30ec9eb5e','ubuntu',1,0,1486631148),('57abd83255c90','你猜猜',0,0,1470879794),('589c30e55f1f6','android',1,0,1486631141),('589c30db5c825','java',1,0,1486631131),('589c31142cee4','mysql',1,0,1486631188);
/*!40000 ALTER TABLE `t_dictionary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_index`
--

DROP TABLE IF EXISTS `t_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_index` (
  `id_id` char(13) NOT NULL,
  `dc_id` char(13) NOT NULL,
  `by_id` char(13) NOT NULL,
  PRIMARY KEY (`id_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_index`
--

LOCK TABLES `t_index` WRITE;
/*!40000 ALTER TABLE `t_index` DISABLE KEYS */;
INSERT INTO `t_index` VALUES ('589d2ca359313','589c30ec9eb5e','589be070a2b5f'),('589d2c8f440c8','589c31142cee4','589be070a2b5f'),('589d2a809226a','589c3100a0916','589be070a2b5f'),('589d2c906cc5d','589c310d116d7','589be070a2b5f');
/*!40000 ALTER TABLE `t_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_order`
--

DROP TABLE IF EXISTS `t_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_order` (
  `od_id` char(16) NOT NULL,
  `od_total` float(8,2) NOT NULL,
  `od_paytype` varchar(10) NOT NULL,
  `od_flowid` varchar(64) NOT NULL,
  `od_ctime` int(11) NOT NULL,
  `od_ptime` int(11) NOT NULL,
  `od_utime` int(11) NOT NULL,
  `od_note` varchar(64) NOT NULL,
  `od_status` tinyint(4) NOT NULL,
  `user_id` char(13) NOT NULL,
  `ad_id` char(13) NOT NULL,
  PRIMARY KEY (`od_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_order`
--

LOCK TABLES `t_order` WRITE;
/*!40000 ALTER TABLE `t_order` DISABLE KEYS */;
INSERT INTO `t_order` VALUES ('1609110951403537',310.00,'alipay','20160913100202620659',1473558700,0,0,'',2,'57ad684337eee','');
/*!40000 ALTER TABLE `t_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_product`
--

DROP TABLE IF EXISTS `t_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_product` (
  `pd_id` char(13) NOT NULL,
  `pd_no` varchar(10) NOT NULL,
  `pd_category` char(13) NOT NULL,
  `pd_name` varchar(64) NOT NULL,
  `pd_image` varchar(64) NOT NULL,
  `pd_price` float(8,2) NOT NULL,
  `pd_time` int(11) NOT NULL,
  `pd_sort` int(11) NOT NULL,
  `pd_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`pd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_product`
--

LOCK TABLES `t_product` WRITE;
/*!40000 ALTER TABLE `t_product` DISABLE KEYS */;
INSERT INTO `t_product` VALUES ('585257db18c75','AAAAAA','','新上架商品','/app/statics/files/16/12/15/5852585b6fe50.jpg',0.00,1481791451,0,1);
/*!40000 ALTER TABLE `t_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_stock`
--

DROP TABLE IF EXISTS `t_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_stock` (
  `st_id` char(13) NOT NULL,
  `st_name` varchar(32) NOT NULL,
  `st_image` varchar(64) NOT NULL,
  `st_size` varchar(10) NOT NULL,
  `st_count` int(11) NOT NULL,
  `st_price` float(8,2) NOT NULL,
  `st_discount` float(3,2) NOT NULL,
  `st_time` int(11) NOT NULL,
  `st_status` tinyint(4) NOT NULL,
  `pd_id` char(13) NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_stock`
--

LOCK TABLES `t_stock` WRITE;
/*!40000 ALTER TABLE `t_stock` DISABLE KEYS */;
INSERT INTO `t_stock` VALUES ('5852584fcb752','默认库存','/app/statics/files/16/12/15/5852586157423.jpg','默认规格',50,18.00,1.00,1481791567,1,'585257db18c75');
/*!40000 ALTER TABLE `t_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_user`
--

DROP TABLE IF EXISTS `t_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_user` (
  `user_id` char(13) NOT NULL,
  `user_password` char(32) NOT NULL,
  `user_phone` varchar(32) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_name` varchar(16) NOT NULL,
  `user_gender` tinyint(4) NOT NULL,
  `user_avatar` varchar(64) NOT NULL,
  `user_ctime` int(11) NOT NULL,
  `user_ltime` int(11) NOT NULL,
  `user_count` int(11) NOT NULL,
  `user_ip` varchar(15) NOT NULL,
  `user_device` tinyint(4) NOT NULL,
  `user_devid` varchar(64) NOT NULL,
  `user_devname` varchar(64) NOT NULL,
  `user_version` varchar(16) NOT NULL,
  `user_note` varchar(128) NOT NULL,
  `user_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_user`
--

LOCK TABLES `t_user` WRITE;
/*!40000 ALTER TABLE `t_user` DISABLE KEYS */;
INSERT INTO `t_user` VALUES ('589d7ecb10f35','e10adc3949ba59abbe56e057f20f883e','','hongerbo@qq.com','洪波',1,'/app/statics/files/17/02/14/58a25ce84e67c.png',1486716619,1487124901,18,'',0,'','','','1222',1);
/*!40000 ALTER TABLE `t_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-20  9:18:14
