-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: dulcealhornowebpedidos
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `carrito_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`carrito_id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
INSERT INTO `carrito` VALUES (2,7),(3,8),(1,9),(5,10),(4,11),(6,13),(242,217),(243,228);
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrito_productos`
--

DROP TABLE IF EXISTS `carrito_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito_productos` (
  `carrito_productos_id` int(11) NOT NULL AUTO_INCREMENT,
  `carrito_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad_producto` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`carrito_productos_id`),
  KEY `carrito_id` (`carrito_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `carrito_productos_ibfk_1` FOREIGN KEY (`carrito_id`) REFERENCES `carrito` (`carrito_id`),
  CONSTRAINT `carrito_productos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito_productos`
--

LOCK TABLES `carrito_productos` WRITE;
/*!40000 ALTER TABLE `carrito_productos` DISABLE KEYS */;
INSERT INTO `carrito_productos` VALUES (1,1,1,1,300.00),(2,1,2,6,150.00),(3,1,3,1,600.00),(4,1,4,3,350.00),(40,3,7,1,680.00),(63,5,3,3,600.00),(64,5,1,4,300.00),(70,6,1,3,300.00),(87,2,4,1,350.00),(107,242,2,4,150.00);
/*!40000 ALTER TABLE `carrito_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cliente_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,1,'test',NULL),(2,2,'test1',NULL),(3,3,'test2',NULL),(4,4,'test2',NULL),(5,5,'test4',NULL),(6,6,'test5',NULL),(7,7,'test01','a'),(8,8,'test02','a'),(9,9,'Admin',NULL),(10,10,'test03',NULL),(11,11,'test04','aa'),(12,12,'Repostero','Dulce al horno'),(13,13,'test05',NULL),(166,1350,'Meri','R'),(178,1364,'test',NULL),(179,1366,'test',NULL),(216,1403,'Dulce','Al Horno'),(217,1404,'Dulce','Al Horno'),(218,1405,'test',NULL),(219,1406,'e','i'),(226,1413,'mer','r'),(228,1415,'mer','r');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallepedido`
--

DROP TABLE IF EXISTS `detallepedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detallepedido` (
  `detalle_id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad_producto` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`detalle_id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`),
  CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallepedido`
--

LOCK TABLES `detallepedido` WRITE;
/*!40000 ALTER TABLE `detallepedido` DISABLE KEYS */;
INSERT INTO `detallepedido` VALUES (1,1,7,2,680.00),(2,1,1,2,300.00),(3,1,3,1,600.00),(4,2,1,3,300.00),(5,3,1,2,300.00),(6,3,4,1,350.00),(7,3,5,3,680.00),(8,4,4,2,350.00),(9,5,2,3,150.00),(10,6,3,1,600.00),(11,7,1,5,300.00),(12,7,2,2,150.00),(13,8,1,2,300.00),(14,9,1,3,300.00),(15,10,3,1,600.00),(16,10,5,2,680.00),(17,11,8,1,680.00),(18,12,4,1,350.00),(19,12,1,3,300.00),(20,13,9,1,680.00),(21,14,7,1,680.00),(22,15,6,2,180.00),(23,15,4,1,350.00),(24,16,4,1,350.00),(25,16,5,1,680.00),(26,17,1,1,300.00),(27,18,5,1,680.00),(28,19,4,1,350.00),(29,20,3,1,600.00),(30,21,7,1,680.00),(31,22,5,1,680.00),(32,23,6,1,180.00),(33,24,4,3,350.00),(34,24,6,1,180.00),(35,25,2,1,150.00),(36,26,7,1,680.00),(37,27,4,1,350.00),(38,27,9,1,680.00),(39,27,2,1,150.00),(40,28,1,1,300.00),(41,29,8,1,680.00),(42,30,3,2,600.00),(43,30,8,2,680.00),(44,31,2,1,150.00),(45,32,2,1,150.00),(46,33,5,1,680.00),(47,33,7,2,680.00),(48,36,1,2,300.00),(49,36,2,1,150.00),(50,37,1,1,300.00),(51,38,4,1,350.00),(52,39,1,1,300.00),(53,39,2,2,150.00),(54,40,2,2,150.00),(55,41,2,5,150.00),(56,42,7,1,680.00),(57,43,2,4,150.00),(58,44,2,4,150.00),(59,45,1,1,300.00),(60,46,7,1,680.00),(61,46,2,2,150.00),(62,47,5,1,680.00),(63,48,2,1,150.00),(64,49,7,2,680.00);
/*!40000 ALTER TABLE `detallepedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `pedido_id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('entregado','no entregado','en espera','cancelado') NOT NULL DEFAULT 'en espera',
  PRIMARY KEY (`pedido_id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,7,'2025-04-03 20:17:58',2560.00,'cancelado'),(2,7,'2025-04-03 20:41:13',900.00,'cancelado'),(3,8,'2025-04-03 20:58:50',2990.00,'en espera'),(4,8,'2025-04-03 21:35:30',700.00,'en espera'),(5,8,'2025-04-03 21:42:43',450.00,'en espera'),(6,8,'2025-04-03 21:43:59',600.00,'en espera'),(7,8,'2025-04-03 21:53:58',1800.00,'en espera'),(8,8,'2025-04-03 22:16:44',600.00,'en espera'),(9,11,'2025-04-04 16:14:31',900.00,'en espera'),(10,11,'2025-04-04 19:58:17',1960.00,'en espera'),(11,11,'2025-04-04 20:42:39',680.00,'en espera'),(12,11,'2025-04-04 20:54:06',1250.00,'en espera'),(13,11,'2025-04-04 21:03:11',680.00,'en espera'),(14,7,'2025-04-04 22:55:43',680.00,'en espera'),(15,7,'2025-04-04 23:01:21',710.00,'cancelado'),(16,10,'2025-04-06 15:07:35',1030.00,'en espera'),(17,10,'2025-04-06 15:26:43',300.00,'en espera'),(18,10,'2025-04-06 16:48:17',680.00,'en espera'),(19,10,'2025-04-06 16:53:25',350.00,'en espera'),(20,10,'2025-04-06 16:59:08',600.00,'en espera'),(21,10,'2025-04-06 17:01:49',680.00,'en espera'),(22,10,'2025-04-06 17:03:36',680.00,'en espera'),(23,10,'2025-04-06 17:04:32',180.00,'en espera'),(24,11,'2025-04-06 17:10:41',1230.00,'en espera'),(25,11,'2025-04-06 17:15:16',150.00,'en espera'),(26,7,'2025-04-06 17:17:38',680.00,'entregado'),(27,13,'2025-04-06 18:51:35',1180.00,'en espera'),(28,11,'2025-04-06 18:52:40',300.00,'en espera'),(29,13,'2025-04-06 18:54:37',680.00,'en espera'),(30,13,'2025-04-06 21:41:43',2560.00,'en espera'),(31,11,'2025-04-08 01:12:44',150.00,'en espera'),(32,11,'2025-04-08 01:13:49',150.00,'en espera'),(33,7,'2025-05-29 23:29:40',2040.00,'no entregado'),(36,228,'2026-06-04 22:30:09',750.00,'cancelado'),(37,228,'2026-06-04 22:53:04',300.00,'cancelado'),(38,228,'2026-06-04 23:22:06',350.00,'entregado'),(39,217,'2026-06-05 12:52:22',600.00,'entregado'),(40,217,'2026-06-05 12:58:19',300.00,'no entregado'),(41,217,'2026-06-05 13:27:44',750.00,'entregado'),(42,228,'2026-06-05 13:38:58',680.00,'cancelado'),(43,228,'2026-06-05 13:40:00',600.00,'cancelado'),(44,228,'2026-06-05 13:42:44',600.00,'cancelado'),(45,228,'2026-06-05 13:50:32',300.00,'cancelado'),(46,228,'2026-06-05 14:12:59',980.00,'cancelado'),(47,217,'2026-06-05 14:20:34',680.00,'cancelado'),(48,228,'2026-06-05 14:22:16',150.00,'cancelado'),(49,228,'2026-06-05 22:09:28',1360.00,'cancelado');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `producto_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `estado` enum('disponible','no disponible') NOT NULL DEFAULT 'disponible',
  `descripcion` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Cheesecake',300.00,'resources/img/cheesecake.jpg','disponible','Un cremoso y delicioso cheesecake con una base de galleta crujiente y un suave relleno de queso, perfecto para cualquier ocasión.',1),(2,'Docena de conchas',150.00,'resources/img/conchas.jpg','disponible','Clásicas conchas recién horneadas, con una cubierta dulce y crujiente en sabores de vainilla.',7),(3,'Pastel de 3 leches con fruta',600.00,'resources/img/pastel_3leches_fruta.jpg','disponible','Un esponjoso pastel de tres leches decorado con una selección de frutas frescas, ideal para los amantes de los postres húmedos y dulces.',0),(4,'Pastel chico con fruta',350.00,'resources/img/pastel_chico_fruta_3.jpg','disponible','Un pastel pequeño y delicioso decorado con frutas frescas, ideal para reuniones o celebraciones pequeñas.',2),(5,'Pastel blanco grande',680.00,'resources/img/pastel_chico_2.jpg','disponible','Un pastel suave y esponjoso adornado con una crema blanca, perfecto para celebraciones.',1),(6,'Docena de galletas de corazon',180.00,'resources/img/galletas_corazon_4.jpg','disponible','Tiernas galletas con forma de corazón, con un toque de vainilla y mantequilla, ideales para regalar o compartir.',2),(7,'Pastel grande de hello kitty',680.00,'resources/img/pastel_grande_hello_kitty.jpg','disponible','Un pastel temático de Hello Kitty, decorado con detalles personalizados y un sabor delicioso que encantará a todos.',2),(8,'Pastel grande con frambuesa',680.00,'resources/img/pastel_chico_fruta_1.jpg','disponible','Un pastel suave con relleno y decoración de frambuesas frescas, con un equilibrio perfecto entre dulzura y acidez.',0),(9,'Pastel grande con zanahoria',680.00,'resources/img/pastel_chico_fruta_2.jpg','disponible','Un pastel único con trozos de papaya fresca, aportando un sabor tropical y una textura jugosa en cada bocado.',4);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `mfa_codigo` varchar(6) DEFAULT NULL,
  `mfa_expira` datetime DEFAULT NULL,
  `verificado` tinyint(1) DEFAULT 0,
  `verificacion_codigo` varchar(6) DEFAULT NULL,
  `verificacion_expira` datetime DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=1416 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'test@gmail.com',NULL,NULL,NULL,NULL,1,NULL,NULL),(2,'test1@gmail.com','$2y$10$W571pXwuz6m5D8NUnFuL3erGyFIFLn/KcTaHyB9zMJmaVjGKDzvze',NULL,NULL,NULL,1,NULL,NULL),(3,'test2@gmail.com','$2y$10$ZmBIsbU9hqiXpWMWbxSH/O3X2PL.9A1Xp8joATWbiKNfhz5norwnG',NULL,NULL,NULL,1,NULL,NULL),(4,'test3@gmail.com','$2y$10$D63NRqLHJrmrw8vuFfC8jemW.54XRSNSfpZWPlzduWeTHuOmXGUtO',NULL,NULL,NULL,1,NULL,NULL),(5,'test4@g.com','$2y$10$dUB6936KFGcickHHV9ZBDuW8KnG5kLp3AKCQlQ1AcAFhmSR07ZSy6',NULL,NULL,NULL,0,NULL,NULL),(6,'test5@g.com','$2y$10$deES6iT80CKZCDl52xLUMOQqFDbTzdtvnEfjCuLQHd513YdyHkLV2',NULL,NULL,NULL,0,NULL,NULL),(7,'test01@gmail.com','$2y$10$Uyb7Z3keLx0K1ZOWL7OKvORQGUVV4E8Y08VAIFrsm0Pcl6LkmGxka',NULL,NULL,NULL,1,NULL,NULL),(8,'test02@gmail.com','$2y$10$PvMtLV08/ByRhACfDr2o1.YpNmqX9Vu/Z0f67rVR3x33ubgX8Ix8C',NULL,NULL,NULL,0,NULL,NULL),(9,'admin@gmail.com','$2y$10$0vdC01ci3EcuwGgwjcGqY.GaNuK5ZBRan9FX0Q1z/P0hmIol4Z2Je',NULL,NULL,NULL,0,NULL,NULL),(10,'test03@gmail.com','$2y$10$lz9EfrQoXa45TtFGkKQtUurtYhfLhzggJFaVj1e5ISkZqozts1V5e',NULL,NULL,NULL,0,NULL,NULL),(11,'test04@gmail.com','$2y$10$cm3gzPbI5.f0PPBHpv4w9uzO1gafMYmRCulgOMwNfU/xtVR6Xfz8u',NULL,NULL,NULL,0,NULL,NULL),(12,'repostero@gmail.com','$2y$10$YHxwBEJn/C3XzkRpPqk4v.gYxeWLzv3VKpLpUF4.DjGsG7vKtCKmm',NULL,'11111',NULL,1,NULL,NULL),(13,'test05@gmail.com','$2y$10$TWgC5Hpx8lODW9XcV45ohu2UV6xnPYm4Nu9xB2ung1wb29NoPDZJa',NULL,NULL,NULL,0,NULL,NULL),(1350,'mw@gmail.com','$2y$10$RxNWL36GUDVnP8i0t6K9i.U5hUCgCpuY3NHT3trpFy77fp3GaNrIm',NULL,'868410','2025-05-28 08:50:26',0,NULL,NULL),(1364,'m@gmail.com','$2y$10$l4hD1SS7fJTrbvdrPw4gEuxmOOsTr6WKVzthSEjqOH/m5f3mAfiNi',NULL,NULL,NULL,0,'579920','2025-05-28 11:47:39'),(1366,'rui@gmail.com','$2y$10$OR0JrNHVg9KabkzJjXporOwd4T2Im79uF.au2E.uj0NuRPgiyE3rm',NULL,NULL,NULL,0,'375284','2025-05-28 12:08:57'),(1403,'orno@gmail.com','$2y$10$XFtzViNk5MQRMSaKo/v9Ouu4QzfbjSrK0UUXQHJpDdJMoehWwswCq',NULL,NULL,NULL,0,'208078','2025-05-29 06:11:14'),(1404,'dulcealhorno@gmail.com','$2y$10$NqDHOoSdAj5t7YWfo/jTW.ySV5vUzhl15M2zTQIHZ7vRm8Ci/kRri',NULL,NULL,NULL,1,NULL,NULL),(1405,'test011@gmail.com','$2y$10$49SGSQyqg7F3reLTsIBwD.JIzGnyPxNUIvvNKjWZFOV2WwVD.MDfO',NULL,NULL,NULL,0,'653222','2025-05-29 06:42:33'),(1406,'r@gmail.com','$2y$10$HRs.Nvi0GaHE5CqBSMKGh.JPMvq2INxqm9E4Zl5MlTt7tyilnOXiK',NULL,NULL,NULL,0,'506539','2025-05-29 07:11:06'),(1413,'m.@gmail.com','$2y$10$xZ3g4FdDsE3OsIlKZ09CY.zW9iX4nCxgP4kBVJJRrzsVN5wOHfSmC',NULL,NULL,NULL,1,NULL,NULL),(1415,'testing.01yioi@gmail.com','$2y$10$kEwQvg95v/dMleUfxgQjI.c5tAloW.uEOJgzjh8AnokFhLJVvk0QC',NULL,NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'dulcealhornowebpedidos'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-05 22:25:09
