-- MySQL dump 10.13  Distrib 5.1.49, for Win32 (ia32)
--
-- Host: localhost    Database: helpdesk_testing
-- ------------------------------------------------------
-- Server version	5.1.49-community

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
  KEY `ticket` (`ticket`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
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
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (2,6,7,9,'computer exploded',5,'0000-00-00 00:00:00','help me pls'),(3,6,7,9,'CAPS LOCK IS STUCK',5,'0000-00-00 00:00:00','help me pls'),(5,6,7,9,'test',5,'2015-01-11 07:41:42','help me pls'),(6,6,7,9,'my printer is broken',5,'2015-01-11 07:43:55','help me pls'),(7,6,7,9,'It exploded',5,'2015-02-20 16:37:50','printer problems'),(8,6,7,9,'test',5,'2015-02-20 16:40:01','testing'),(9,6,7,9,'doesnt work',5,'2015-02-20 16:40:35','promethean board'),(10,6,7,9,'please fix my problem.',5,'2015-02-26 23:39:52','php will not install'),(11,6,7,9,'I don\'t have any real problems.',5,'2015-02-27 00:29:22','Testing'),(12,6,7,9,'no problems, please give us all A+s.',5,'2015-02-27 18:45:29','Website DOES work'),(13,6,7,9,'just kidding, fail us all.',5,'2015-02-27 18:47:07','Website doesn\'t work'),(14,6,7,9,'why would I know?',5,'2015-02-27 18:50:08','maybe it does work'),(15,6,7,9,'His name isn\'t there.',5,'2015-02-27 19:00:47','How do I contact my consultant?'),(16,6,7,9,'My computer will not turn on. Please assist me soon.',5,'2015-02-27 19:04:01','Power Problems'),(17,6,7,9,'for real this time.',5,'2015-02-27 19:12:09','it works!'),(18,6,7,9,'what is happening',5,'2015-02-27 19:13:46','heloo'),(19,6,7,9,'I cannot find the button.',5,'2015-02-27 19:22:21','where is internet?'),(20,6,7,9,'He is sailing too much',5,'2015-02-27 19:27:31','Thomas is being annoying'),(21,6,7,9,'AAAAAAAAAAHHHHHHH',5,'2015-02-27 19:28:07','help'),(40,6,7,9,'',5,'2015-02-27 19:31:04','\"Hi\"'),(41,6,7,9,'Hope this works!',6,'2015-02-27 20:11:00','From Volger'),(42,6,7,8,'',5,'2015-03-02 18:43:44','Thomas is sooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo annoying'),(44,6,7,8,'My computer was hit by a bowling ball in a controlled explosion gone wrong. I BLAME MENDERS!!!!! Unfortunately the screen was separated from the computer. CAUSING THE PAINT TO CHIP !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! How do I paint a computer?  ',5,'2015-03-04 17:32:17','Bowling Ball'),(48,6,7,9,'Volger\r\n',6,'2015-03-20 17:54:37','Greg'),(102,6,7,8,'Just testing',5,'2015-04-10 17:50:19','Hi'),(101,7,7,8,'fixes\r\n',5,'2015-04-10 17:46:57','Testing'),(103,6,7,8,'are redirects working again?',6,'2015-04-10 17:52:52','Testing');
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
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (6,'john','doe',1,'johndoe@example.com',101),(7,'Consultant','Charlie',2,'charlie@example.com',102),(8,'Manager','Moe',3,'moe@example.com',103),(9,'Admin','Alex',4,'alex@example.com',104);
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

-- Dump completed on 2015-04-10 10:55:40
