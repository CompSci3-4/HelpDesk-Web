-- MySQL dump 10.15  Distrib 10.0.17-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: helpdesk_testing
-- ------------------------------------------------------
-- Server version	10.0.17-MariaDB-log

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
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ticket` (`ticket`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`ticket`) REFERENCES `tickets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'user'),(2,'consultant'),(3,'manager'),(4,'admin');
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (5,'In Progress'),(6,'Completed');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `consultant` int(11) DEFAULT NULL,
  `manager` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `status` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `consultant` (`consultant`),
  KEY `manager` (`manager`),
  KEY `status` (`status`),
  CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`consultant`) REFERENCES `users` (`id`),
  CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`manager`) REFERENCES `users` (`id`),
  CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (2,5,5,5,'computer exploded',5,'0000-00-00 00:00:00','help me pls'),(3,6,5,5,'CAPS LOCK IS STUCK',5,'0000-00-00 00:00:00','help me pls'),(5,5,NULL,NULL,'test',5,'2015-01-11 07:41:42','help me pls'),(6,5,7,5,'my printer is broken',5,'2015-01-11 07:43:55','help me pls'),(7,5,7,5,'It exploded',5,'2015-02-20 16:37:50','printer problems'),(8,5,7,NULL,'test',5,'2015-02-20 16:40:01','testing'),(9,5,5,8,'doesnt work',6,'2015-02-20 16:40:35','promethean board'),(10,5,7,8,'please fix my problem.',5,'2015-02-26 23:39:52','php will not install'),(11,5,7,8,'I don\'t have any real problems.',5,'2015-02-27 00:29:22','Testing'),(12,5,5,8,'test',5,'2015-03-03 07:10:14','Testing'),(13,5,5,8,'test',5,'2015-03-03 07:10:17','Testing'),(14,5,7,8,'test',6,'2015-03-03 07:11:43','Testing'),(15,6,5,5,'test',5,'2015-03-15 01:02:06','test'),(16,6,5,5,'fsdfsdfs',5,'2015-03-15 04:29:59','Testing'),(17,6,5,5,'',5,'2015-03-15 04:30:12','sfsdf'),(18,6,5,5,'',5,'2015-03-15 04:30:15','d'),(19,6,5,5,'',5,'2015-03-15 04:30:17',''),(20,6,5,5,'',5,'2015-03-15 04:30:19',''),(21,6,5,5,'',5,'2015-03-15 04:30:21','sdfdsfsf'),(22,6,5,5,'dfsf',5,'2015-03-15 04:30:54','sdfsdf'),(23,6,5,5,'',5,'2015-03-15 04:31:37','d'),(24,6,5,5,'',5,'2015-03-15 04:32:21','d'),(25,6,5,5,'',5,'2015-03-15 04:32:40','sds'),(26,6,5,5,'d',5,'2015-03-15 05:10:48','Testing'),(27,5,7,8,'first ticket made over API',5,'2015-05-05 18:01:11','hello world!'),(28,5,7,8,'first ticket made over API',5,'2015-05-05 18:01:46','hello world!'),(29,5,7,8,'first ticket made over API',5,'2015-05-05 18:01:49','hello world!'),(30,5,7,8,'first ticket made over API',5,'2015-05-05 18:05:10','hello world!'),(31,5,7,8,'first ticket made over API',5,'2015-05-05 18:06:50','hello world!'),(32,5,7,8,'first ticket made over API',5,'2015-05-05 18:07:52','hello world!'),(33,5,7,8,'first ticket made over API',5,'2015-05-05 18:08:44','hello world!'),(34,5,7,8,'first ticket made over API',5,'2015-05-05 18:09:06','hello world!'),(35,5,7,8,'first ticket made over API',5,'2015-05-05 18:09:14','hello world!'),(36,5,7,8,'first ticket made over API',5,'2015-05-05 18:10:48','hello world!'),(37,5,7,8,'testing',5,'2015-05-06 05:33:31','hello'),(38,5,7,8,'testing',5,'2015-05-06 05:33:32','hello'),(39,5,7,8,'testing',5,'2015-05-06 05:33:33','hello');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first` varchar(255) NOT NULL,
  `last` varchar(255) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `room` int(11) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`position`) REFERENCES `positions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'tom','garcia',4,'',0,'$2y$07$DARJKF7Ep6B0J4mHxCHlsOyWl7olbbbtINs2Fm3zvmCHM6TcI3l3m','tgarcia'),(6,'john','doe',1,'johndoe@example.com',101,'$2y$07$89eTTt8d7VKd3TCnvBLt4utX3CESra7Bv4PapTFgd7Oak0vzLcxD6','jdoe'),(7,'Consultant','Charles',2,'charles@example.com',200,'$2y$07$5qf7DNJJhd7f3oBHyG8dweSLjoKybHMP3/RVjdODCO7J.KTIeAkIe','charles'),(8,'Manager','Moe',3,'charles@example.com',200,'$2y$07$JZhXg8EDNA8Q7PkA3toMmuDnOt61q62ultOOq2gUZ8DrR.aK3pG7y','moe');
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

-- Dump completed on 2015-05-06 21:07:23
