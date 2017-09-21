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
INSERT INTO `t_admin` VALUES ('hongbo','98b4a59cbf4d5b6293ecfc7de0db870b','洪波','产品',4103,1505971290,'127.0.0.1',1),('bit128','123456','测试账号2','运营',5,0,'',0);
/*!40000 ALTER TABLE `t_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_category`
--

DROP TABLE IF EXISTS `t_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_category` (
  `ca_id` int(11) NOT NULL AUTO_INCREMENT,
  `ca_fid` int(11) NOT NULL,
  `ca_image` varchar(64) NOT NULL,
  `ca_name` varchar(64) NOT NULL,
  PRIMARY KEY (`ca_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_category`
--

LOCK TABLES `t_category` WRITE;
/*!40000 ALTER TABLE `t_category` DISABLE KEYS */;
INSERT INTO `t_category` VALUES (1,0,'','新关键词1'),(2,1,'','新关键词1-2'),(3,0,'/app/statics/files/17/09/21/59c3643ad3198.png','新关键词2'),(4,0,'','新关键词3'),(5,4,'','新关键词3-1');
/*!40000 ALTER TABLE `t_category` ENABLE KEYS */;
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
  `cn_image` varchar(64) NOT NULL,
  `cn_name` varchar(64) NOT NULL,
  `cn_data` varchar(500) NOT NULL,
  `cn_content` text NOT NULL,
  `cn_sort` int(11) NOT NULL,
  `cn_admin` varchar(32) NOT NULL,
  `cn_ctime` int(11) NOT NULL,
  `cn_utime` int(11) NOT NULL,
  PRIMARY KEY (`cn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_channel`
--

LOCK TABLES `t_channel` WRITE;
/*!40000 ALTER TABLE `t_channel` DISABLE KEYS */;
INSERT INTO `t_channel` VALUES ('59bb850fa6c77','0','','新建栏目aaa，上海合作','{\"area\":\"上海2\",\"address\":\"浦东新区\"}','这里是内容',5,'',1505461519,1505971307),('59bba8b19b70e','0','','新建栏目','{}','',2,'',1505470641,1505470719),('59c352920de2d','0','','我是一条空内容','{}','',6,'',1505972882,1505972890),('59c3531122b6f','59c352920de2d','','ok,我是一条子内容','{}','',1,'',1505973009,1505973019);
/*!40000 ALTER TABLE `t_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_file`
--

DROP TABLE IF EXISTS `t_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_file` (
  `file_id` char(13) NOT NULL,
  `file_fid` char(13) NOT NULL,
  `file_bid` char(13) NOT NULL,
  `file_type` char(4) NOT NULL,
  `file_path` varchar(64) NOT NULL,
  `file_name` varchar(64) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_time` int(11) NOT NULL,
  `file_sort` int(11) NOT NULL,
  `file_status` tinyint(4) NOT NULL,
  `user_id` char(13) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_file`
--

LOCK TABLES `t_file` WRITE;
/*!40000 ALTER TABLE `t_file` DISABLE KEYS */;
INSERT INTO `t_file` VALUES ('58b8ebe95bff8','','57afc7ec763ac','jpg','/app/statics/files/17/03/03/58b8ebe9104fa.jpg','photo name',26304,1488514025,0,2,''),('58c0bc7d36cc0','','58aa49e288d20','jpg','/app/statics/files/17/03/09/58c0bc7d0b4df.jpg','封面',39891,1489026173,0,2,''),('59bb81068c984','','59bb7b15f2d19','jpg','/app/statics/files/17/09/15/59bb81067cd81.jpg','ccc',26304,1505460486,0,2,''),('58c7b4192b632','','58aa49e288d20','jpg','/app/statics/files/17/03/14/58c7b4190cdbb.jpg','数字风标',194223,1489482777,0,2,''),('59bb80f287537','','59bb7b15f2d19','jpg','/app/statics/files/17/09/15/59bb80f27e19a.jpg','lss',39891,1505460466,0,2,''),('59c35d5507063','','58b91e4506ce7','jpg','/app/statics/files/17/09/21/59c35d54ed140.jpg','',19552,1505975637,0,2,''),('59c3643ae23c5','','3','png','/app/statics/files/17/09/21/59c3643ad3198.png','',35426,1505977402,0,2,'');
/*!40000 ALTER TABLE `t_file` ENABLE KEYS */;
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
  `user_token` char(32) NOT NULL,
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
INSERT INTO `t_user` VALUES ('589d7ecb10f35','e10adc3949ba59abbe56e057f20f883e','1797e27e384352f69e335887d0ca954e','18814880000','hongerbo@qq.com','啵啵牛',1,'/app/statics/files/17/02/14/58a25ce84e67c.png',1486716619,1504075672,27,'',0,'','','','1024',1);
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

-- Dump completed on 2017-09-21 15:07:30
