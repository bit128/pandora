-- MySQL dump 10.13  Distrib 5.7.15, for osx10.11 (x86_64)
--
-- Host: localhost    Database: pandora
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
INSERT INTO `t_admin` VALUES ('hongbo','98b4a59cbf4d5b6293ecfc7de0db870b','洪波','产品',4159,1482035551,'127.0.0.1',1),('bit128','123456','测试账号','运营',5,0,'',0);
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
INSERT INTO `t_channel` VALUES ('1','0','站点根目录','site root','',0,1,'',2),('585615b8ed0db','1','新闻列表','111','222',1482036664,1,'bit128',1);
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
  `cl_time` int(11) NOT NULL,
  `pd_id` char(13) NOT NULL,
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
  `ct_keyword` varchar(32) NOT NULL,
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
INSERT INTO `t_content` VALUES ('57abe7f60eef6','','新建扩展内容','','','','沙朗牛排：也译作西冷，英文sirloin。是指肉质鲜嫩又带油花嫩筋的牛肉，基本上取自于牛背脊一带最柔嫩的牛肉，具体位置不同，风味也各有千秋。比较正宗的沙朗取自后腰脊肉，含一定肥油，尤其是外延有一圈呈白色的肉筋，上口相比<a target=\"_blank\" href=\"http://baike.baidu.com/view/374643.htm\">菲力牛排</a>更有韧性、有嚼劲，适合年轻人和牙口好的人。不建议全熟食用，因为全熟肉质会较韧，一般7、8成熟较为推荐。但特殊的品种例如纽约客，则是取自于类似菲力的前腰脊肉。',1470883830,1470905929,0,1),('57ac1b5acd3a4','','新建扩展内容','','','','<h3 class=\"title-text\">面团</h3>\n\n<div class=\"para\">食用面团最初出现时的制造方法<br><br><a class=\"lemma-album layout-right nslog:10000206\" title=\"意大利面成品\" href=\"http://baike.baidu.com/pic/%E6%84%8F%E5%A4%A7%E5%88%A9%E9%9D%A2/2845613/1670704/4bac30730c02c6508601b000?fr=lemma&amp;ct=cover\" target=\"_blank\" style=\"width:222px;\"><div class=\"description\">\n意大利面成品<span class=\"number\">(20张)</span>\n</div>\n<div class=\"albumBg\">\n\n\n</div>\n</a>\n是将面粉团压成薄纸状，然后覆盖在食物上，放入焗炉内烹煮食用。其后，人们想到将面团切成小块状或条棒状的细长面条，而<a target=\"_blank\" href=\"http://baike.baidu.com/subview/18648/12119022.htm\" data-lemmaid=\"363372\">阿拉伯人</a>更想到了将面条风干储存的做法。</div>\n<div class=\"para\">除了原味面条外，其他色彩缤纷的面条都是用蔬果混制而成的，如：番红花面、黑墨鱼面及<a target=\"_blank\" href=\"http://baike.baidu.com/view/1093982.htm\">蛋黄面</a>等。</div>\n<div class=\"para\">意大利南部的人喜爱食用干意粉，而新鲜意粉则在北部较为流行。一般来说，意粉多用作头菜，海鲜意粉配以白酒，而酱料浓的则配红酒。</div><div class=\"anchor-list\">\n<a name=\"1_2\" class=\"lemma-anchor para-title\"></a>\n<a name=\"sub157612_1_2\" class=\"lemma-anchor \"></a>\n<a name=\"酱料\" class=\"lemma-anchor \"></a>\n</div><div class=\"para-title level-3\">\n<h3 class=\"title-text\">酱料</h3>\n</div>\n<div class=\"para\">正宗的原料是意大利面具有上好口感的重要条件。除此之外，拌意大利面的酱也是比较重要的。</div>\n<div class=\"para\">意大利面的酱料基本来说可分为红酱和白酱，红酱是用番茄为底的红色酱汁，白酱则是由面粉、牛奶及奶油为底的白酱汁，此外，还有用橄榄油调味的面和用香草类调配的香草酱、<a target=\"_blank\" href=\"http://baike.baidu.com/view/1166397.htm\">青酱</a>(Pesto Sauce)，和黑酱(Squid-Ink Sauce)。</div>\n<div class=\"para\"><a target=\"_blank\" href=\"http://baike.baidu.com/view/5993845.htm\">红酱</a>是主要以番茄为主制成的酱汁，目前是见得最多的。</div>\n<div class=\"para\"><a target=\"_blank\" href=\"http://baike.baidu.com/view/1166397.htm\">青酱</a>以<a target=\"_blank\" href=\"http://baike.baidu.com/view/57646.htm\">罗勒</a>、松子粒、<a target=\"_blank\" href=\"http://baike.baidu.com/view/8052.htm\">橄榄油</a>等制成的酱汁，其口味较为特殊与浓郁。</div>\n<div class=\"para\"><a target=\"_blank\" href=\"http://baike.baidu.com/item/%E7%99%BD%E9%85%B1\">白酱</a>以无盐奶油为主制成的酱汁，主要用于焗面、<a target=\"_blank\" href=\"http://baike.baidu.com/view/665766.htm\">千层面</a>及海鲜类的意大利面。</div>\n<div class=\"para\">黑酱是以墨鱼汁所制成的酱汁，其主要佐于墨鱼等海鲜意大利面。</div>\n<div class=\"para\">而意大利面用的面粉和我们中国做面用的面粉不同，它用的是一种“硬杜林小麦”，所以久煮不糊，这就是最大的区别。<sup>[1]</sup><a class=\"sup-anchor\" name=\"ref_[1]_157612\">&nbsp;</a>\n</div>',1470896986,1471063178,0,1),('585257db18c75','','新建扩展内容','','','','',1481791451,1481791451,0,1),('57a30601cf479','','新建扩展内容','','','','',1470301697,1470301697,0,1);
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
  `tn_phone` varchar(20) NOT NULL,
  `tn_email` varchar(64) NOT NULL,
  `tn_content` varchar(512) NOT NULL,
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
INSERT INTO `t_content_note` VALUES ('584fa96129446','18814887668','hongerbo@qq.com','测试留言',1481615713,1,'57ae9a6b2a96b','57ae9a845f7df','57ad684337eee');
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
INSERT INTO `t_dictionary` VALUES ('57abced71644c','中西主食',1,7,1470877399),('57abcee3ec452','缤纷甜点',1,3,1470877411),('57abcefdf101d','滋味饮品',1,2,1470877437),('57abcf1f9e947','手工冰淇淋',1,4,1470877471),('57abcf379a8b3','手工曲奇饼',1,2,1470877495),('57abd83255c90','你猜猜',0,0,1470879794);
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
INSERT INTO `t_index` VALUES ('57ac1b77601fe','57abced71644c','57ac1b5acd3a4'),('57abe8042a37d','57abced71644c','57abe7f60eef6');
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
INSERT INTO `t_user` VALUES ('57ad448e02ee1','202cb962ac59075b964b07152d234b70','13761497959','','银莹',0,'',1470973070,1470973070,0,'127.0.0.1',4,'','','1.2','',1),('57ad684337eee','98b4a59cbf4d5b6293ecfc7de0db870b','18814887668','','hongbo',0,'',1470982211,1481615210,10,'127.0.0.1',0,'','','','',1);
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

-- Dump completed on 2016-12-18 13:47:31
