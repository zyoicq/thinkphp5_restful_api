-- MySQL dump 10.13  Distrib 5.5.47, for Win32 (x86)
--
-- Host: localhost    Database: api
-- ------------------------------------------------------
-- Server version	5.5.47

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
-- Table structure for table `api_article`
--

DROP TABLE IF EXISTS `api_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_article` (
  `article_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_title` varchar(255) NOT NULL,
  `article_uid` int(11) unsigned NOT NULL,
  `article_content` text NOT NULL,
  `article_ctime` int(11) NOT NULL,
  `article_isdel` tinyint(11) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_article`
--

LOCK TABLES `api_article` WRITE;
/*!40000 ALTER TABLE `api_article` DISABLE KEYS */;
INSERT INTO `api_article` VALUES (1,'test_update1',2,'*********************************************',1521473242,0),(2,'title2',2,'',1521473298,0),(4,'title',2,'&lt;script&gt;alert(\'hello\')&lt;script/&gt;',1521510836,0);
/*!40000 ALTER TABLE `api_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_user`
--

DROP TABLE IF EXISTS `api_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_phone` char(11) NOT NULL,
  `user_nickname` varchar(255) NOT NULL COMMENT '昵称',
  `user_email` varchar(255) NOT NULL,
  `user_rtime` int(11) NOT NULL COMMENT 'register time',
  `user_pwd` char(32) NOT NULL,
  `user_icon` varchar(255) NOT NULL COMMENT '用户图像',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_user`
--

LOCK TABLES `api_user` WRITE;
/*!40000 ALTER TABLE `api_user` DISABLE KEYS */;
INSERT INTO `api_user` VALUES (2,'13671178137','zhangy1','zy123_zy123@163.com',1333333333,'',''),(3,'','','zy123zhangyong@163.com',0,'25D55AD283AA400AF464C76D713C07AD',''),(4,'13671267603','','',1520953183,'25D55AD283AA400AF464C76D713C07AD','/uploads/20180314/e27e366d7801688c1d0328be80bc5859.png');
/*!40000 ALTER TABLE `api_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-20 11:13:07
