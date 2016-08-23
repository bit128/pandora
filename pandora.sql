-- MySQL dump 10.13  Distrib 5.6.21, for osx10.8 (x86_64)
--
-- Host: localhost    Database: pandora
-- ------------------------------------------------------
-- Server version	5.6.21

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
INSERT INTO `t_admin` VALUES ('hongbo','98b4a59cbf4d5b6293ecfc7de0db870b','洪波','产品',4159,1471223225,'127.0.0.1',1);
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
  `al_image` char(17) NOT NULL,
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
INSERT INTO `t_album` VALUES ('57ac1a115edd3','57ac19eba6e00','product','','57ac1a1132ea4.jpg',1,1),('57ac194b9d383','57abe7f60eef6','product','','57ac194b7eefe.jpg',2,1),('57ac190b28b16','57abe7f60eef6','product','','57ac190ae7269.jpg',1,1),('57ac1a1c93712','57ac19eba6e00','product','','57ac1a1c63bdb.jpg',2,1),('57ac1b889ce39','57ac1b5acd3a4','product','','57ac1b8871eee.jpg',1,1),('57ac1b8f2d62c','57ac1b5acd3a4','product','','57ac1b8ee8da0.jpg',2,1),('57ac1b94cab79','57ac1b5acd3a4','product','','57ac1b94a063a.jpg',3,1),('57ac1c76506f1','57ac1c3ef3547','product','','57ac1c761bf95.jpg',1,1),('57ac1c7d79af0','57ac1c3ef3547','product','','57ac1c7d46676.jpg',2,1),('57ac1c83c4761','57ac1c3ef3547','product','','57ac1c8388571.jpg',3,1),('57ac1d5304188','57ac1d12914cf','product','','57ac1d52bc858.jpg',1,1),('57ac1d5951c48','57ac1d12914cf','product','','57ac1d5923091.jpg',2,1),('57ac1d5eb09f3','57ac1d12914cf','product','','57ac1d5e8a674.jpg',3,1),('57ac1e0ea9e02','57ac1dd7c93f1','product','','57ac1e0e758de.jpg',1,1),('57ac1e15a898c','57ac1dd7c93f1','product','','57ac1e1580f65.jpg',2,1),('57ac1f0a7f755','57ac1ee799e95','product','','57ac1f0a49a5c.jpg',1,1),('57ac1f119d110','57ac1ee799e95','product','','57ac1f116e930.jpg',2,1),('57ac1f185eba6','57ac1ee799e95','product','','57ac1f1824eb9.jpg',3,1),('57ac1f1ed3691','57ac1ee799e95','product','','57ac1f1e9d464.jpg',4,1),('57ac20294afbb','57ac2005017af','product','','57ac202907099.jpg',2,1),('57ac202ced064','57ac2005017af','product','','57ac202cc23a3.jpg',1,1),('57ac2075873f8','57ac2045a63c0','product','','57ac20754a27c.jpg',1,1),('57b3c78d4b858','57afc7ec763ac','struct','','57b3c78cab38e.jpg',1,1),('57b3c8fb88ed4','57afc7ec763ac','struct','','57b3c8fb57950.jpg',2,1),('57b3c90d9b0d1','57afc7ec763ac','struct','','57b3c90d6be9b.jpg',3,1);
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
  `cn_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`cn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_channel`
--

LOCK TABLES `t_channel` WRITE;
/*!40000 ALTER TABLE `t_channel` DISABLE KEYS */;
INSERT INTO `t_channel` VALUES ('579b4eff66da9','0','站点根栏目','网站根目录','',1469796095,1,1),('57ad781c81ccf','57ad76d2a739f','意大利菜','','',1470986268,2,1),('57ad780541144','57ad76d2a739f','法国菜','','',1470986245,1,1),('57ad76d2a739f','579b4eff66da9','美食博客','','',1470985938,2,1),('57ad782bac6f4','57ad76d2a739f','中华料理','','',1470986283,3,1),('57ad7851297b0','57ad76d2a739f','日式料理','','',1470986321,4,1),('57ae9a6b2a96b','579b4eff66da9','网站公告','','',1471060587,3,1);
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
  `ct_image` varchar(17) NOT NULL,
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
INSERT INTO `t_content` VALUES ('57abe7f60eef6','','新建扩展内容','','','','沙朗牛排：也译作西冷，英文sirloin。是指肉质鲜嫩又带油花嫩筋的牛肉，基本上取自于牛背脊一带最柔嫩的牛肉，具体位置不同，风味也各有千秋。比较正宗的沙朗取自后腰脊肉，含一定肥油，尤其是外延有一圈呈白色的肉筋，上口相比<a target=\"_blank\" href=\"http://baike.baidu.com/view/374643.htm\">菲力牛排</a>更有韧性、有嚼劲，适合年轻人和牙口好的人。不建议全熟食用，因为全熟肉质会较韧，一般7、8成熟较为推荐。但特殊的品种例如纽约客，则是取自于类似菲力的前腰脊肉。',1470883830,1470905929,0,1),('57ac19eba6e00','','新建扩展内容','','','','',1470896619,1470896619,0,1),('57ac1b5acd3a4','','新建扩展内容','','','','<h3 class=\"title-text\">面团</h3>\n\n<div class=\"para\">食用面团最初出现时的制造方法<br><br><a class=\"lemma-album layout-right nslog:10000206\" title=\"意大利面成品\" href=\"http://baike.baidu.com/pic/%E6%84%8F%E5%A4%A7%E5%88%A9%E9%9D%A2/2845613/1670704/4bac30730c02c6508601b000?fr=lemma&amp;ct=cover\" target=\"_blank\" style=\"width:222px;\"><div class=\"description\">\n意大利面成品<span class=\"number\">(20张)</span>\n</div>\n<div class=\"albumBg\">\n\n\n</div>\n</a>\n是将面粉团压成薄纸状，然后覆盖在食物上，放入焗炉内烹煮食用。其后，人们想到将面团切成小块状或条棒状的细长面条，而<a target=\"_blank\" href=\"http://baike.baidu.com/subview/18648/12119022.htm\" data-lemmaid=\"363372\">阿拉伯人</a>更想到了将面条风干储存的做法。</div>\n<div class=\"para\">除了原味面条外，其他色彩缤纷的面条都是用蔬果混制而成的，如：番红花面、黑墨鱼面及<a target=\"_blank\" href=\"http://baike.baidu.com/view/1093982.htm\">蛋黄面</a>等。</div>\n<div class=\"para\">意大利南部的人喜爱食用干意粉，而新鲜意粉则在北部较为流行。一般来说，意粉多用作头菜，海鲜意粉配以白酒，而酱料浓的则配红酒。</div><div class=\"anchor-list\">\n<a name=\"1_2\" class=\"lemma-anchor para-title\"></a>\n<a name=\"sub157612_1_2\" class=\"lemma-anchor \"></a>\n<a name=\"酱料\" class=\"lemma-anchor \"></a>\n</div><div class=\"para-title level-3\">\n<h3 class=\"title-text\">酱料</h3>\n</div>\n<div class=\"para\">正宗的原料是意大利面具有上好口感的重要条件。除此之外，拌意大利面的酱也是比较重要的。</div>\n<div class=\"para\">意大利面的酱料基本来说可分为红酱和白酱，红酱是用番茄为底的红色酱汁，白酱则是由面粉、牛奶及奶油为底的白酱汁，此外，还有用橄榄油调味的面和用香草类调配的香草酱、<a target=\"_blank\" href=\"http://baike.baidu.com/view/1166397.htm\">青酱</a>(Pesto Sauce)，和黑酱(Squid-Ink Sauce)。</div>\n<div class=\"para\"><a target=\"_blank\" href=\"http://baike.baidu.com/view/5993845.htm\">红酱</a>是主要以番茄为主制成的酱汁，目前是见得最多的。</div>\n<div class=\"para\"><a target=\"_blank\" href=\"http://baike.baidu.com/view/1166397.htm\">青酱</a>以<a target=\"_blank\" href=\"http://baike.baidu.com/view/57646.htm\">罗勒</a>、松子粒、<a target=\"_blank\" href=\"http://baike.baidu.com/view/8052.htm\">橄榄油</a>等制成的酱汁，其口味较为特殊与浓郁。</div>\n<div class=\"para\"><a target=\"_blank\" href=\"http://baike.baidu.com/item/%E7%99%BD%E9%85%B1\">白酱</a>以无盐奶油为主制成的酱汁，主要用于焗面、<a target=\"_blank\" href=\"http://baike.baidu.com/view/665766.htm\">千层面</a>及海鲜类的意大利面。</div>\n<div class=\"para\">黑酱是以墨鱼汁所制成的酱汁，其主要佐于墨鱼等海鲜意大利面。</div>\n<div class=\"para\">而意大利面用的面粉和我们中国做面用的面粉不同，它用的是一种“硬杜林小麦”，所以久煮不糊，这就是最大的区别。<sup>[1]</sup><a class=\"sup-anchor\" name=\"ref_[1]_157612\">&nbsp;</a>\n</div>',1470896986,1471063178,0,1),('57ac1c3ef3547','','新建扩展内容','','','','',1470897214,1470897214,0,1),('57ac1d12914cf','','新建扩展内容','','','','',1470897426,1470897426,0,1),('57ac1dd7c93f1','','新建扩展内容','','','','',1470897623,1470897623,0,1),('57ac1ee799e95','','新建扩展内容','','','','',1470897895,1470897895,0,1),('57ac2005017af','','新建扩展内容','','','','',1470898181,1470898181,0,1),('57ac2045a63c0','','新建扩展内容','','','','',1470898245,1470898245,0,1),('57ae9a845f7df','57ae9a6b2a96b','2016国庆放假安排','','','','<p><strong>尊敬客户：</strong></p>\n    <p>春节临近，根据当前形势，敝司重新调整2015年度春节休假时间如下： </p>\n    <p class=\"text-red\">2015月2月11日（星期三）全厂放假，春节假期时长为19天，3月02（周一）正式上班。</p>\n    <p>假日期间，我司暂停正常的业务咨询、销售出货、售后服务等工作，不便之处多多包含！如需购买产品，请联络我司全国各大销售商，货源充足，敬请放心。</p>\n    <p>以上给您带来不便，请您谅解，再次感谢您对VANCL一如既往的支持与理解！</p>\n    <p class=\"text-right\">深圳市碧河电气有限公司 <br>2015年02月10日</p>',1471060612,1471060649,0,0),('57ae9aad8be2b','57ae9a6b2a96b','第三季度生产率报告','','','','<p>尊敬客户：</p>\n    <p>为保证您的货物安全，现就签收流程进行调整，具体如下：</p>\n    <p>请您在签收商品前与配送员当面核对商品种类、数量、规格、赠品、金额是否与订单一致，产品包装是否完好无损，准确无误再进行签收，签收内容请注明\"已验货、验货人签字、收货人或订购人身份证号后四位\"，感谢您的配合与理解！</p>\n    <p>以上给您带来不便，请您谅解，再次感谢您对VANCL一如既往的支持与理解！</p>\n    <p>凡客诚品（北京）科技有限公司 客户服务中心</p>',1471060653,1471060691,0,0),('57ad79425ddbb','57ad780541144','学做金桔柠檬茶','','57ad79715eb62.jpg','','<p>不吃羊肉的人也会爱上的羊肉的滋味，没的膻味。牛肉比猪肉的肉质要细嫩，而且比猪肉和牛肉的脂肪、胆固醇含量都要少。相对猪肉而言，羊肉蛋白质含量\n较多，脂肪含量较少。维生素B1、B2、B6以及铁、锌、硒的含量颇为丰富。此外，羊肉肉质细嫩，容易消化吸收，多吃羊肉有助于提高身体免疫力。羊肉热量\n比牛肉要高，历来被当做秋冬御寒和进补的重要食品之一。</p>\n        <p>不吃羊肉的人也会爱上的羊肉的滋味，没的膻味。牛肉比猪肉的肉质要细嫩，而且比猪肉和牛肉的脂肪、胆固醇含量都要少。相对猪肉而\n言，羊肉蛋白质含量较多，脂肪含量较少。维生素B1、B2、B6以及铁、锌、硒的含量颇为丰富。此外，羊肉肉质细嫩，容易消化吸收，多吃羊肉有助于提高身\n体免疫力。羊肉热量比牛肉要高，历来被当做秋冬御寒和进补的重要食品之一。不吃羊肉的人也会爱上的羊肉的滋味，没的膻味。牛肉比猪肉的肉质要细嫩，而且比\n猪肉和牛肉的脂肪、胆固醇含量都要少。相对猪肉而言，羊肉蛋白质含量较多，脂肪含量较少。维生素B1、B2、B6以及铁、锌、硒的含量颇为丰富。此外，羊\n肉肉质细嫩，容易消化吸收，多吃羊肉有助于提高身体免疫力。羊肉热量比牛肉要高，历来被当做秋冬御寒和进补的重要食品之一。不吃羊肉的人也会爱上的羊肉的\n滋味，没的膻味。牛肉比猪肉的肉质要细嫩，而且比猪肉和牛肉的脂肪、胆固醇含量都要少。相对猪肉而言，羊肉蛋白质含量较多，脂肪含量较少。维生素B1、\nB2、B6以及铁、锌、硒的含量颇为丰富。此外，羊肉肉质细嫩，容易消化吸收，多吃羊肉有助于提高身体免疫力。羊肉热量比牛肉要高，历来被当做秋冬御寒和\n进补的重要食品之一。</p>\n        <blockquote>不吃羊肉的人也会爱上的羊肉的滋味，没的膻味。牛肉比猪肉的肉质要细嫩，而且比猪肉和牛肉的脂肪、胆固醇含量都要少。相对猪肉而言，羊肉蛋白质含量较多，脂肪含量较少。维生素B1、B2、B6以及铁、锌、硒的含量颇为丰富。</blockquote>\n        <p>不吃羊肉的人也会爱上的羊肉的滋味，没的膻味。牛肉比猪肉的肉质要细嫩，而且比猪肉和牛肉的脂肪、胆固醇含量都要少。相对猪肉而\n言，羊肉蛋白质含量较多，脂肪含量较少。维生素B1、B2、B6以及铁、锌、硒的含量颇为丰富。此外，羊肉肉质细嫩，容易消化吸收，多吃羊肉有助于提高身\n体免疫力。羊肉热量比牛肉要高，历来被当做秋冬御寒和进补的重要食品之一。</p>',1470986562,1470987023,0,2),('57ad79786f00e','57ad781c81ccf','意大利菜的故事','','57ad7aefa9e15.jpg','','<span style=\"COLOR: rgb(15,36,62)\">有人问西餐之母是哪国菜？我想大部分人会说是法国菜吧，在这里要郑重地告诉大\n家，西餐之母是意大利菜！意大利民族是一个美食家的民族，他们在饮食方面有着悠久历史如同他们的艺术、时装和汽车，总是喜欢精心制作。意大利美食典雅高\n贵，且浓重朴实讲究原汁原味。意大利菜系非常丰富，菜品成千上万，除了大家耳熟能详的比萨饼和意大利粉，它的海鲜和甜品都闻名遐迩。源远流长的意大利餐，\n对欧美国家的餐饮产生了深厚影响，并发展出包括法餐、美国餐在内的多种派系，故有“西餐之母”之美称。<br><br></span><span style=\"COLOR: rgb(15,36,62)\">锡拉库萨蜿蜒在西西里岛东岸一座风和日丽的港湾深处，周围环境十分迷人。风景秀\n丽的锚地以玛德莱娜半岛和奥尔蒂吉小岛为界小岛基本上与陆地相连。 \n两千多年前，锡拉库萨身为古希腊的城邦之一，便矢志取代当时的文化之都雅典，不但在军事上打败过雅典，还致力于建设一个优雅社会，因而当地出现过柏拉图等\n 大人物的身影。</span><br>',1470986616,1471059385,0,1),('57ad7a67bef1a','57ad781c81ccf','意大利菜和黑手党','','57ad7ae55f088.jpg','','<span style=\"COLOR: rgb(15,36,62)\">拜电影《教父》之赐,西西里的黑手党成为了世界最知名的黑社会组织.提到意大利\n西西里岛,黑手党甚至是所有资讯排名的首位,超过其他旅游、美食、建筑、古迹等等所有相关讯息,也可以说是世人所认定的西西里代名词回想电影里面的情节,\n那几个黑手党大家族,其实老早在几十年前就跑到海外发展去了,毕竟只有像是纽约那种的大都会地区才有所谓的油水可捞.~<br>但是，另一个像是黑手党般充满隐忧,看似平静却又随时可能爆发的,就是埃特纳火山!<br><br></span><span style=\"COLOR: rgb(15,36,62)\">拉丁语作Aetna，西西里语作Mongibello。面积1,600平方公里\n ( 600平方米 ) 。基座周长约150 ( 93里 ) \n。埃特纳火山是欧洲最高的活火山。在意大利的西西里岛东岸，南距卡塔尼亚29公里。周长约160公里，喷发物质覆盖面积达1165平方公里。主要喷火口海\n拔3，323米，直径500米；常积雪。</span><br>',1470986855,1470987030,0,2),('57a30601cf479','','新建扩展内容','','','','',1470301697,1470301697,0,1);
/*!40000 ALTER TABLE `t_content` ENABLE KEYS */;
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
INSERT INTO `t_index` VALUES ('57ac1b77601fe','57abced71644c','57ac1b5acd3a4'),('57abe8042a37d','57abced71644c','57abe7f60eef6'),('57ac1c6d6a6fb','57abced71644c','57ac1c3ef3547'),('57ac1a08d613f','57abced71644c','57ac19eba6e00'),('57ac1d405d2ea','57abcee3ec452','57ac1d12914cf'),('57ac1e060132a','57abcee3ec452','57ac1dd7c93f1'),('57ac20a10d782','57abcf379a8b3','57ac1ee799e95'),('57ac205dac295','57abcefdf101d','57ac2005017af'),('57ac20666666a','57abcefdf101d','57ac2045a63c0');
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
  `od_paytype` tinyint(4) NOT NULL,
  `od_flowid` varchar(64) NOT NULL,
  `od_ctime` int(11) NOT NULL,
  `od_ptime` int(11) NOT NULL,
  `od_utime` int(11) NOT NULL,
  `od_note` varchar(64) NOT NULL,
  `od_status` tinyint(4) NOT NULL,
  `user_id` char(13) NOT NULL,
  PRIMARY KEY (`od_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_order`
--

LOCK TABLES `t_order` WRITE;
/*!40000 ALTER TABLE `t_order` DISABLE KEYS */;
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
  `pd_image` varchar(17) NOT NULL,
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
INSERT INTO `t_product` VALUES ('57abe7f60eef6','M-1201','','佛罗伦萨沙朗牛排','57ac190ae7269.jpg',78.00,1470883830,0,1),('57ac1b5acd3a4','M-1203','','经典海鲜意大利面','57ac1b8871eee.jpg',45.00,1470896986,0,1),('57ac19eba6e00','M-1202','','法式香煎鹅肝','57ac1a1132ea4.jpg',82.00,1470896619,0,1),('57ac1c3ef3547','M-1204','','意大利香草鸭腿','57ac1c761bf95.jpg',36.00,1470897214,0,1),('57ac1d12914cf','D-2307','','可可马卡龙（意式）','57ac1d52bc858.jpg',28.00,1470897426,0,1),('57ac1dd7c93f1','D-2308','','全蛋纸杯海绵蛋糕','57ac1e0e758de.jpg',26.00,1470897623,0,1),('57ac1ee799e95','B-3306','','黑芝麻奶油曲奇','57ac1f0a49a5c.jpg',19.00,1470897895,0,1),('57ac2005017af','Y-1406','','芒果慕斯杯','57ac202cc23a3.jpg',18.00,1470898181,0,1),('57ac2045a63c0','Y-1407','','巧克力饮品','57ac20754a27c.jpg',18.00,1470898245,0,1);
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
  `st_image` varchar(17) NOT NULL,
  `st_size` varchar(10) NOT NULL,
  `st_count` int(11) NOT NULL,
  `st_price` float(8,2) NOT NULL,
  `st_discount` float(3,2) NOT NULL,
  `st_time` int(11) NOT NULL,
  `st_status` tinyint(4) NOT NULL,
  `pd_id` char(13) NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_stock`
--

LOCK TABLES `t_stock` WRITE;
/*!40000 ALTER TABLE `t_stock` DISABLE KEYS */;
INSERT INTO `t_stock` VALUES ('57ac2ed696ee6','番茄酱','57ac194b7eefe.jpg','七分熟',60,76.00,1.00,1470901974,1,'57abe7f60eef6'),('57ac2e9b90a20','黑胡椒酱','57ac190ae7269.jpg','七分熟',30,78.00,1.00,1470901915,1,'57abe7f60eef6'),('57ac2f45004dd','黑胡椒酱','57ac190ae7269.jpg','五分熟',30,78.00,1.00,1470902084,1,'57abe7f60eef6'),('57ae9d81a7dc9','套餐A','57ac1b8871eee.jpg','默认规格',30,38.00,1.00,1471061377,1,'57ac1b5acd3a4'),('57ae9dc4a0845','套餐B','57ac1b8ee8da0.jpg','默认规格',0,48.00,1.00,1471061444,0,'57ac1b5acd3a4'),('57ae9df1bdb24','套餐A','57ac1a1132ea4.jpg','果酱',20,98.00,1.00,1471061489,1,'57ac19eba6e00'),('57ae9e18d6cfc','套餐B','57ac1a1132ea4.jpg','豆瓣酱',20,98.00,1.00,1471061528,1,'57ac19eba6e00'),('57ae9e438c6ed','儿童套餐','57ac1a1c63bdb.jpg','默认规格',10,78.00,1.00,1471061571,0,'57ac19eba6e00'),('57b3cd7adee64','A套餐','57ac1c761bf95.jpg','黑胡椒味',0,58.00,1.00,1471401338,1,'57ac1c3ef3547'),('57b3cdb3ef93c','B套餐','57ac1c7d46676.jpg','黑胡椒味',0,68.00,1.00,1471401395,1,'57ac1c3ef3547'),('57b3cde20fdb7','B套餐','57ac1c7d46676.jpg','孜然味',0,68.00,1.00,1471401442,1,'57ac1c3ef3547');
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
  `user_avatar` varchar(17) NOT NULL,
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
INSERT INTO `t_user` VALUES ('57ad448e02ee1','202cb962ac59075b964b07152d234b70','13761497959','','银莹',0,'',1470973070,1470973070,0,'127.0.0.1',4,'','','1.2','',1),('57ad684337eee','98b4a59cbf4d5b6293ecfc7de0db870b','18814887668','','hongbo',0,'',1470982211,1471060230,7,'127.0.0.1',0,'','','','',1);
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

-- Dump completed on 2016-08-23 13:45:04
