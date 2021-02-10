-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: octopus
-- ------------------------------------------------------
-- Server version	8.0.23-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20210210175107','2021-02-10 19:02:36',5911);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profondeur`
--

DROP TABLE IF EXISTS `profondeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profondeur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `correspond_id` int DEFAULT NULL,
  `profondeur` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E3804DEA98DE379A` (`correspond_id`),
  CONSTRAINT `FK_E3804DEA98DE379A` FOREIGN KEY (`correspond_id`) REFERENCES `tableplongee` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profondeur`
--

LOCK TABLES `profondeur` WRITE;
/*!40000 ALTER TABLE `profondeur` DISABLE KEYS */;
INSERT INTO `profondeur` VALUES (1,1,12),(2,1,15),(3,1,18),(4,1,21),(5,1,24),(6,1,27),(7,1,30),(8,1,33),(9,1,36),(10,1,39),(11,1,42),(12,1,45),(13,1,48),(14,1,51),(15,1,54),(16,1,57),(17,2,6),(18,2,8),(19,2,10),(20,2,12),(21,2,15),(22,2,18),(23,2,20),(24,2,22),(25,2,25),(26,2,28),(27,2,30),(28,2,32),(29,2,35),(30,2,38),(31,2,40),(32,2,42),(33,2,45),(34,2,48),(35,2,50),(36,2,52),(37,2,55),(38,2,58),(39,2,60);
/*!40000 ALTER TABLE `profondeur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tableplongee`
--

DROP TABLE IF EXISTS `tableplongee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tableplongee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tableplongee`
--

LOCK TABLES `tableplongee` WRITE;
/*!40000 ALTER TABLE `tableplongee` DISABLE KEYS */;
INSERT INTO `tableplongee` VALUES (1,'Bullman'),(2,'MN90');
/*!40000 ALTER TABLE `tableplongee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temps`
--

DROP TABLE IF EXISTS `temps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `esta_id` int NOT NULL,
  `temps` int NOT NULL,
  `palier15` int DEFAULT NULL,
  `palier12` int DEFAULT NULL,
  `palier9` int DEFAULT NULL,
  `palier6` int DEFAULT NULL,
  `palier3` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_60B4B720DF9C0918` (`esta_id`),
  CONSTRAINT `FK_60B4B720DF9C0918` FOREIGN KEY (`esta_id`) REFERENCES `profondeur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temps`
--

LOCK TABLES `temps` WRITE;
/*!40000 ALTER TABLE `temps` DISABLE KEYS */;
INSERT INTO `temps` VALUES (1,1,125,0,0,0,0,1),(2,2,75,0,0,0,0,1),(3,2,90,0,0,0,0,7),(4,3,51,0,0,0,0,1),(5,3,70,0,0,0,0,11),(6,4,35,0,0,0,0,1),(7,4,50,0,0,0,0,8),(8,4,60,0,0,0,0,16),(9,5,25,0,0,0,0,1),(10,5,35,0,0,0,0,4),(11,5,40,0,0,0,0,8),(12,5,50,0,0,0,0,17),(13,5,60,0,0,0,4,24),(14,6,20,0,0,0,0,1),(15,6,30,0,0,0,0,5),(16,6,35,0,0,0,0,10),(17,6,40,0,0,0,2,13),(18,6,45,0,0,0,3,18),(19,6,50,0,0,0,6,22),(20,7,17,0,0,0,0,1),(21,7,25,0,0,0,0,5),(22,7,30,0,0,0,2,7),(23,7,35,0,0,0,3,14),(24,7,40,0,0,0,5,17),(25,7,45,0,0,0,9,23),(26,8,14,0,0,0,0,1),(27,8,20,0,0,0,0,4),(28,8,25,0,0,0,2,7),(29,8,30,0,0,0,4,11),(30,8,35,0,0,0,6,17),(31,8,40,0,0,2,8,23),(32,9,12,0,0,0,0,1),(33,9,20,0,0,0,2,5),(34,9,25,0,0,0,4,9),(35,9,30,0,0,2,5,15),(36,9,35,0,0,2,8,23),(37,10,10,0,0,0,0,1),(38,10,15,0,0,0,0,4),(39,10,20,0,0,0,3,7),(40,10,25,0,0,2,4,12),(41,10,30,0,0,3,7,18),(42,10,35,0,0,5,9,28),(43,11,9,0,0,0,0,1),(44,11,12,0,0,0,0,4),(45,11,15,0,0,0,1,5),(46,11,18,0,0,0,4,6),(47,11,21,0,0,2,4,10),(48,11,24,0,0,3,6,16),(49,11,27,0,0,4,7,19),(50,12,12,0,0,0,0,5),(51,12,15,0,0,0,3,5),(52,12,18,0,0,2,4,9),(53,12,21,0,0,3,5,13),(54,12,24,0,0,4,6,18),(55,13,9,0,0,0,0,3),(56,13,12,0,0,0,2,5),(57,13,15,0,0,0,4,6),(58,13,18,0,0,3,4,10),(59,13,21,0,0,4,6,16),(60,14,9,0,0,0,0,4),(61,14,12,0,0,0,3,6),(62,14,15,0,0,2,4,8),(63,14,18,0,0,4,5,13),(64,14,21,0,3,4,7,18),(65,15,9,0,0,0,1,5),(66,15,12,0,0,1,4,6),(67,15,15,0,0,3,4,10),(68,15,18,0,1,3,6,17),(69,16,9,0,0,0,2,5),(70,16,12,0,0,2,4,8),(71,16,15,0,1,4,5,11),(72,16,18,0,3,4,7,18),(73,17,75,0,0,0,0,0),(74,17,105,0,0,0,0,0),(75,17,135,0,0,0,0,0),(76,18,30,0,0,0,0,0),(77,18,60,0,0,0,0,0),(78,18,90,0,0,0,0,0),(79,18,135,0,0,0,0,0),(80,19,30,0,0,0,0,0),(81,19,60,0,0,0,0,0),(82,19,90,0,0,0,0,0),(83,19,105,0,0,0,0,0),(84,19,135,0,0,0,0,0),(85,20,45,0,0,0,0,0),(86,20,55,0,0,0,0,0),(87,20,65,0,0,0,0,0),(88,20,80,0,0,0,0,0),(89,20,90,0,0,0,0,0),(90,20,105,0,0,0,0,0),(91,20,120,0,0,0,0,0),(92,20,140,0,0,0,0,2),(93,21,20,0,0,0,0,0),(94,21,30,0,0,0,0,0),(95,21,40,0,0,0,0,0),(96,21,50,0,0,0,0,0),(97,21,60,0,0,0,0,0),(98,21,70,0,0,0,0,0),(99,21,80,0,0,0,0,2),(100,21,85,0,0,0,0,4),(101,21,90,0,0,0,0,6),(102,22,20,0,0,0,0,0),(103,22,30,0,0,0,0,0),(104,22,40,0,0,0,0,0),(105,22,50,0,0,0,0,0),(106,22,55,0,0,0,0,1),(107,22,60,0,0,0,0,5),(108,22,65,0,0,0,0,8),(109,22,70,0,0,0,0,11),(110,22,75,0,0,0,0,14),(111,23,20,0,0,0,0,0),(112,23,25,0,0,0,0,0),(113,23,30,0,0,0,0,0),(114,23,35,0,0,0,0,0),(115,23,40,0,0,0,0,1),(116,23,45,0,0,0,0,4),(117,23,50,0,0,0,0,9),(118,23,55,0,0,0,0,13),(119,23,60,0,0,0,0,0),(120,24,15,0,0,0,0,0),(121,24,20,0,0,0,0,0),(122,24,25,0,0,0,0,0),(123,24,30,0,0,0,0,0),(124,24,35,0,0,0,0,0),(125,24,40,0,0,0,0,2),(126,24,45,0,0,0,0,7),(127,24,50,0,0,0,0,12),(128,24,55,0,0,0,0,16),(129,24,60,0,0,0,0,20),(130,25,15,0,0,0,0,0),(131,25,20,0,0,0,0,0),(132,25,25,0,0,0,0,1),(133,25,30,0,0,0,0,2),(134,25,35,0,0,0,0,5),(135,25,40,0,0,0,0,10),(136,25,45,0,0,0,0,16),(137,25,50,0,0,0,0,21),(138,25,55,0,0,0,0,27),(139,25,60,0,0,0,0,32),(140,26,15,0,0,0,0,0),(141,26,20,0,0,0,0,1),(142,26,25,0,0,0,0,2),(143,26,30,0,0,0,0,6),(144,26,35,0,0,0,0,12),(145,26,40,0,0,0,0,19),(146,26,45,0,0,0,0,25),(147,26,50,0,0,0,0,32),(148,26,55,0,0,0,2,36),(149,27,10,0,0,0,0,0),(150,27,15,0,0,0,0,1),(151,27,20,0,0,0,0,2),(152,27,25,0,0,0,0,4),(153,27,30,0,0,0,0,9),(154,27,35,0,0,0,0,17),(155,27,40,0,0,0,0,24),(156,27,45,0,0,0,1,31),(157,27,50,0,0,0,3,36),(158,28,10,0,0,0,0,0),(159,28,15,0,0,0,0,1),(160,28,20,0,0,0,0,3),(161,28,25,0,0,0,0,6),(162,28,30,0,0,0,0,14),(163,28,35,0,0,0,0,22),(164,28,40,0,0,0,1,29),(165,29,10,0,0,0,0,0),(166,29,15,0,0,0,0,2),(167,29,20,0,0,0,0,5),(168,29,25,0,0,0,0,11),(169,29,30,0,0,0,1,20),(170,29,35,0,0,0,2,27),(171,29,40,0,0,0,5,34),(172,30,5,0,0,0,0,0),(173,30,10,0,0,0,0,1),(174,30,15,0,0,0,0,4),(175,30,20,0,0,0,1,8),(176,30,25,0,0,0,2,16),(177,30,30,0,0,0,4,24),(178,30,35,0,0,0,8,33),(179,31,5,0,0,0,0,0),(180,31,10,0,0,0,0,2),(181,31,15,0,0,0,0,4),(182,31,20,0,0,0,1,9),(183,31,25,0,0,0,3,19),(184,31,30,0,0,0,6,28),(185,31,35,0,0,0,11,35),(186,32,5,0,0,0,0,0),(187,32,10,0,0,0,0,2),(188,32,15,0,0,0,1,5),(189,32,20,0,0,0,3,12),(190,32,25,0,0,0,5,22),(191,32,30,0,0,0,9,31),(192,32,35,0,0,0,15,37),(193,33,5,0,0,0,0,0),(194,33,10,0,0,0,0,3),(195,33,15,0,0,0,2,6),(196,33,20,0,0,0,4,15),(197,33,25,0,0,0,7,25),(198,33,30,0,0,0,12,35),(199,33,35,0,0,1,18,40),(200,34,5,0,0,0,0,0),(201,34,10,0,0,0,0,4),(202,34,15,0,0,0,2,7),(203,34,20,0,0,0,3,19),(204,34,25,0,0,0,8,30),(205,34,30,0,0,1,14,37),(206,34,35,0,0,3,20,44),(207,35,5,0,0,0,0,1),(208,35,10,0,0,0,1,4),(209,35,15,0,0,0,3,9),(210,35,20,0,0,0,6,22),(211,35,25,0,0,1,9,32),(212,35,30,0,0,2,15,39),(213,35,35,0,0,5,22,45),(214,36,5,0,0,0,0,1),(215,36,10,0,0,0,1,4),(216,36,15,0,0,0,3,10),(217,36,20,0,0,1,6,23),(218,36,25,0,0,2,9,34),(219,36,30,0,0,4,15,41),(220,36,35,0,0,6,22,47),(221,37,5,0,0,0,0,1),(222,37,10,0,0,0,1,5),(223,37,15,0,0,0,2,13),(224,37,20,0,0,1,6,27),(225,37,25,0,0,3,11,37),(226,37,30,0,0,6,18,44),(227,38,5,0,0,0,0,2),(228,38,10,0,0,0,2,5),(229,38,15,0,0,1,4,16),(230,38,20,0,0,2,7,30),(231,38,25,0,0,4,13,40),(232,39,5,0,0,0,0,2),(233,39,10,0,0,0,2,6),(234,39,15,0,0,1,4,19),(235,39,20,0,0,3,8,32);
/*!40000 ALTER TABLE `temps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','[\"ROLE_USER\"]','$argon2i$v=19$m=16,t=2,p=1$MEZTOGJDMmNQM2VEOHNUVQ$syuI5YGrVZC84oE8uThZWg');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-10 19:07:34
