-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: oauth
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.13.04.1

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
-- Table structure for table `oa_user`
--

DROP TABLE IF EXISTS `oa_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oa_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oa_user`
--

LOCK TABLES `oa_user` WRITE;
/*!40000 ALTER TABLE `oa_user` DISABLE KEYS */;
INSERT INTO `oa_user` VALUES (7,'user','password',0);
/*!40000 ALTER TABLE `oa_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parameters`
--

DROP TABLE IF EXISTS `parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `uniqueId` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parameters`
--

LOCK TABLES `parameters` WRITE;
/*!40000 ALTER TABLE `parameters` DISABLE KEYS */;
/*!40000 ALTER TABLE `parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sample`
--

DROP TABLE IF EXISTS `sample`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sample` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sample`
--

LOCK TABLES `sample` WRITE;
/*!40000 ALTER TABLE `sample` DISABLE KEYS */;
INSERT INTO `sample` VALUES (1,'aName');
/*!40000 ALTER TABLE `sample` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `session_id` varchar(255) NOT NULL,
  `session_value` text NOT NULL,
  `session_time` int(11) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES ('3em4fmdjdrermnbj14q9vi3u41','X3NmMl9hdHRyaWJ1dGVzfGE6MTp7czo1OiJzdGF0ZSI7czozMjoiZjlhZWYyNzQwZmY0YmZiNzc1OGNiY2Q0ZjA1NGVhYjIiO31fc2YyX2ZsYXNoZXN8YTowOnt9X3NmMl9tZXRhfGE6Mzp7czoxOiJ1IjtpOjEzNzk4NzMyMDM7czoxOiJjIjtpOjEzNzk4NzMyMDM7czoxOiJsIjtzOjE6IjAiO30=',1379873203),('4bpbsc3fq9f1gjs35t5uvdlkn5','X3NmMl9hdHRyaWJ1dGVzfGE6MTp7czo1OiJzdGF0ZSI7czozMjoiNTQyNTdjYzM1ZjZjNjNkZDIwNDQ4NWVhYmE1NTg4NzEiO31fc2YyX2ZsYXNoZXN8YTowOnt9X3NmMl9tZXRhfGE6Mzp7czoxOiJ1IjtpOjEzNzk4Nzg1MzM7czoxOiJjIjtpOjEzNzk4Nzg1MzE7czoxOiJsIjtzOjE6IjAiO30=',1379878533),('4e0p617jcot83166kdbedok8j2','X3NmMl9hdHRyaWJ1dGVzfGE6MTp7czo1OiJzdGF0ZSI7czozMjoiNWZiNjUyZmY4ZDk4NDUyMjhlMTNlYmNkMDZlZDAyZDciO31fc2YyX2ZsYXNoZXN8YTowOnt9X3NmMl9tZXRhfGE6Mzp7czoxOiJ1IjtpOjEzNzk4NzM3MjU7czoxOiJjIjtpOjEzNzk4NzM3MjQ7czoxOiJsIjtzOjE6IjAiO30=',1379873726),('4k9fl2l86d45t856jh8nnaduv1','X3NmMl9hdHRyaWJ1dGVzfGE6MTp7czo1OiJzdGF0ZSI7czozMjoiZjlkNjllMjdhMTliNzI5NzY1ZDBiMTA0N2Q4ZGQxN2IiO31fc2YyX2ZsYXNoZXN8YTowOnt9X3NmMl9tZXRhfGE6Mzp7czoxOiJ1IjtpOjEzNzk4NzI5OTA7czoxOiJjIjtpOjEzNzk4NzI5OTA7czoxOiJsIjtzOjE6IjAiO30=',1379872990),('km10nu04huts6t9khu6tqhgn83','X3NmMl9hdHRyaWJ1dGVzfGE6MTp7czo1OiJzdGF0ZSI7czozMjoiZmI1ZmJmYmJhNDMwNmIzYjU5ZDQ3OTJlNTlmMDY2ZDAiO31fc2YyX2ZsYXNoZXN8YTowOnt9X3NmMl9tZXRhfGE6Mzp7czoxOiJ1IjtpOjEzNzk4ODAxODM7czoxOiJjIjtpOjEzNzk4ODAxODE7czoxOiJsIjtzOjE6IjAiO30=',1379880183);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `roles` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'johann','BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w==','ROLE_USER');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-22 17:09:40
