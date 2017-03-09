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
INSERT INTO `t_admin` VALUES ('hongbo','98b4a59cbf4d5b6293ecfc7de0db870b','洪波','产品',4103,1489040585,'127.0.0.1',1),('bit128','123456','测试账号','运营',5,0,'',0);
/*!40000 ALTER TABLE `t_admin` ENABLE KEYS */;
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
INSERT INTO `t_channel` VALUES ('1','0','站点根目录','site root','',0,1,'',2),('585615b8ed0db','1','默认文章列表','111','222',1482036664,1,'bit128',1),('58b7cc5dad71d','1','新建栏目','','',1488440413,2,'',1);
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
INSERT INTO `t_collect` VALUES ('58b53a240fdab',1,1488271908,'58aa49e288d20','589d7ecb10f35');
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
INSERT INTO `t_content` VALUES ('589be070a2b5f','585615b8ed0db','微软 Xbox 天蝎座主机将亮相 E3 游戏展','','/app/statics/files/17/02/09/589be40e2dbd5.jpeg','<h5>宝马i3 S会是一款高性能电动汽车，将依托现有i3，进行小改升级。外观上，将比i3更具动感；在性能和功能上，将采用最新技术。</h5>\n        \n        \n            <p>自 2014 年宝马发布 i3 以来，i3 凭借出色的外观设计和良好的安全性，成为市面上最受欢迎的电动汽车之一。近日，据汽车媒体 <a href=\"http://www.bmwblog.com/2017/02/07/future-bmw-i3-s-aims-sporty-electric-vehicle/\">BMWBlog 报道</a>，宝马将推出运动版 i3，该车命名为 i3 S。d</p><p>宝马\n i3 S 会是一款高性能电动汽车，将依托于现有 i3，进行小改升级。BMWBlog 认为外观上，将比 i3 \n更具动感，比如更坚固的车身、更低的底盘高度、轮胎加宽；在性能和功能上，将采用最新技术，既然 i3 S 主打性能，动力很有可能超过 168 \n马力，百公里加速将在 7.3 秒以内。</p><p>BMWBlog 预测，<font color=\"#ff4e00\">宝马 i3</font> S 很有可能在 2017 年 9 月的法兰克福车展上与消费者见面；而真正发布，则要等到 2018 年。<br>\n</p><p>去年，宝马公司已经对旗下 i3 电动汽车进行了升级，大幅提升了续航里程；并推出大电池增程版，续航达到 320 公里，解决了老款 i3 续航不佳的问题。</p><p>近年，宝马一直积极推进电动汽车发展，在 BBA 阵营，已大幅领先竞争对手奔驰、奥迪。并且，宝马在德国总部慕尼黑专门设立无人驾驶研发中心，以继续巩固自身在电动汽车领域的优势。</p><p><br></p>',1486610544,1489039870,81,2),('58aa49e288d20','585615b8ed0db','美团上线打车服务，背后的野心究竟有多大','','/app/statics/files/17/03/09/58c0c32ddf9ac.jpg','<p>在情人节当天，微信全新发布的黄金红包无疑成为了刷屏的主力军，但低调上线的美团打车业务似乎也成功捕获了媒体们的注意力。消息一经传出，「美团打车令滴滴颤抖」、「美团欲抢滴滴饭碗」这样的消息也闻风起舞。我们都知道网约车市场大局已定，美团入局真的会掀起又一阵腥风血雨吗？从极光大数据所提供的数据来看，美团的野心背后有着强大的数据基础。</p><p>在产品的体验上，美团打车和滴滴并不存在显著区别。和滴滴一样，美团采取的也是\n C2C \n模式，打车服务的入口设置在美团应用的首页。进入界面后，用户可以看到周边车辆的数量和位置，只需输入出发地和目的地即可。目前在南京上线的美团打车服务支持银联卡、微信支付和\n QQ 钱包等支付方式。</p><div class=\"medium-insert-images\"><figure>\n    <img src=\"http://qiniu.cdn-chuang.com/Rjh1487226137973.gif\" alt=\"\" class=\"\">\n        \n<figcaption class=\"\">（图片来源于网络）</figcaption></figure></div><h2><b>站在巨人肩膀上的美团打车</b></h2><p>首先在时间点的选择上，身为后来者的美团无疑作出了一个明智的选择。《网约车新政》的发布使行业的政策环境趋向于明朗，同时也对滴滴和易到等主流打车应用造成了一定影响。美团入局除了可以将试错成本降到最低以外，还成功把握住了整个行业的低点。</p><p>对于 app 而言，最重要的指标莫过于渗透率和用户活跃度。我们不妨从 app 运营表现数据上对美团和主流打车 app 进行对比。</p><div class=\"medium-insert-images\"><figure>\n    <img src=\"http://qiniu.cdn-chuang.com/Rjh1487226195022.png\" alt=\"\" class=\"\">\n        \n<figcaption class=\"\">（数据来源：极光大数据）</figcaption></figure></div><p>极光大数据 iAPP 平台的监测结果显示：和几款主流打车应用相比，美团的渗透率可谓是一马当先，高达 26.9%；目前在打车行业内一家独大的滴滴也有着 10.37% 的超高渗透率；易到和神州两款应用的渗透率则偏低，分别为 1.06% 和 0.46%。</p><div class=\"medium-insert-images\"><figure>\n    <img src=\"http://qiniu.cdn-chuang.com/Rjh1487226231956.png\" alt=\"\" class=\"\">\n        \n<figcaption class=\"\">（数据来源：极光大数据）</figcaption></figure></div><p>在 DAU 用户日活跃度方面，美团继续保持着领先优势。极光大数据 iAPP 平台的最新监测结果显示：在 Android 端上，美团在 2 月 10 日的 DAU 数量约为 1,640 万，滴滴也接近 1,000 万，神州则接近 30 万。</p><p>从上述数据可知，美团不论是在渗透率还是在 DAU 上都占据着较大优势，新推出的打车服务可以说是站在了巨人的肩膀上。有趣的是，美团和滴滴在&nbsp;DAU 的趋势上表现出了一定的相关性，这或许意味着两者所在的行业原本就存在一定的关联性。</p><h2><b>生态的整合是成功的关键</b></h2><p>目前美团的业务范围主要集中在餐饮和娱乐领域，例如餐饮、电影、酒旅和\n KTV \n等，这些业务确实和出行需求密不可分。打车业务的推出或许昭示着美团想要为用户提供更全面和更深入的服务，继而成为泛生活服务商的野心，这个逻辑也正好顺应了互联网进入下半场的玩法。即便如此，美团想要在打车行业内站稳脚跟也有不小的挑战。不论是滴滴、易到还是神州，伴随这些应用成长至今的是一次又一次的烧钱推广，也即所谓的以资本换取市场份额。而\n Uber 在中国烧掉 10 亿美元后，结局大家都知道了。</p><p>美团目前在南京所采取的也是高额补贴策略。据新浪财经报道，目前美团对司机的扣点仅为 8%，和滴滴的 22.5% 形成了鲜明对比。面对消费端的用户，美团则采取红包抵扣策略。然而，美团打车并不需要从零开始，美团的前期积累应该能让打车服务的补贴周期缩短不少。</p><p>试想一下：你在美团上订了某家餐馆的团购优惠，在订单完成后美团贴心地推送了一则打车服务，在上面设置好了起点和终点的信息并赠送你一张补贴券，你会心动吗？</p><p>我们不难想象，美团以后会在全业务的整合上下功夫。依托自身平台高渗透率、高用户活跃度以及丰富的业务范围等优势，美团大概会将打车业务整合到订餐和酒旅等业务流程中，以进一步丰富自身生态和增加用户粘性。由此可见，打车服务的开展完全符合美团立志覆盖用户全生活范围的目标。</p><p>目前要断言美团打车是否能成功还言之过早。但不论结果如何，可以肯定的是美团的野心和危机感从未因为成为 O2O 餐饮业霸主而消磨殆尽。</p>',1487555042,1489027890,12,2),('58b7cc5fb976f','58b7cc5dad71d','新建栏目内容2','在这里可以选择插入副标题2','','ewgwegwe 我是向西内从<br>',1488440415,1489025194,0,2);
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
INSERT INTO `t_content_note` VALUES ('58a29de8999f8','近年，宝马一直积极推进电动汽车发展，在 BBA 阵营，已大幅领先竞争对手奔驰、奥迪。 并且，宝马在德国总部慕尼黑专门设立无人驾驶研发中心，以继续巩固自身在电动汽车领域的优势。','谢谢您的参与！',0,1487052264,1,'','589be070a2b5f','589d7ecb10f35'),('58a2ae8873cbf','我还可以在说说这篇文章呢！','好吧，你赢了',0,1487056520,1,'','589be070a2b5f','589d7ecb10f35'),('58b7cd262d658','目前要断言美团打车是否能成功还言之过早。但不论结果如何，可以肯定的是美团的野心和危机感从未因为成为 O2O 餐饮业霸主而消磨殆尽。','',0,1488440614,1,'','58aa49e288d20','589d7ecb10f35');
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
  `dc_fid` char(13) NOT NULL,
  `dc_avatar` varchar(64) NOT NULL,
  `dc_keyword` varchar(32) NOT NULL,
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
INSERT INTO `t_dictionary` VALUES ('58b91e202a1dd','0','','物联网',0,1488526880),('58b91e2881c80','0','','人工智能',0,1488526888),('58b91e33b78f2','0','','P2P金融',0,1488526899),('58b91e3e949aa','0','','云计算',0,1488526910),('58b91e4506ce7','0','','大数据',0,1488526917),('58b91e4d651da','0','','自媒体',0,1488526925),('58b91e564f766','0','','微商',0,1488526934);
/*!40000 ALTER TABLE `t_dictionary` ENABLE KEYS */;
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
  `file_ctime` int(11) NOT NULL,
  `file_utime` int(11) NOT NULL,
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
INSERT INTO `t_file` VALUES ('58b8ebe95bff8','','57afc7ec763ac','jpg','/app/statics/files/17/03/03/58b8ebe9104fa.jpg','photo name',26304,1488514025,1488942398,0,2,''),('58c0bc7d36cc0','','58aa49e288d20','jpg','/app/statics/files/17/03/09/58c0bc7d0b4df.jpg','封面',39891,1489026173,1489037302,0,2,'');
/*!40000 ALTER TABLE `t_file` ENABLE KEYS */;
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
INSERT INTO `t_index` VALUES ('58b91f5742f54','58b91e2881c80','58aa49e288d20'),('58b91f5869015','58b91e4d651da','58aa49e288d20'),('58b91f61f0c6d','58b91e564f766','589be070a2b5f'),('58b91f6284e09','58b91e202a1dd','589be070a2b5f'),('58b91f6355847','58b91e33b78f2','589be070a2b5f'),('58c0bd58201f4','58b91e33b78f2','58aa49e288d20');
/*!40000 ALTER TABLE `t_index` ENABLE KEYS */;
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
INSERT INTO `t_user` VALUES ('589d7ecb10f35','e10adc3949ba59abbe56e057f20f883e','','hongerbo@qq.com','啵啵牛',1,'/app/statics/files/17/02/14/58a25ce84e67c.png',1486716619,1488510003,26,'',0,'','','','1024',1);
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

-- Dump completed on 2017-03-09 14:24:24
