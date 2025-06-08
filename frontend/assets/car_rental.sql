-- MySQL dump 10.13  Distrib 9.3.0, for macos14.7 (x86_64)
--
-- Host: localhost    Database: car_rental_mysql
-- ------------------------------------------------------
-- Server version	8.0.32

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
-- Table structure for table `Booking`
--

DROP TABLE IF EXISTS `Booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Booking` (
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` double NOT NULL,
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `fk_payment` int DEFAULT NULL,
  `fk_car_id` int DEFAULT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Booking`
--

LOCK TABLES `Booking` WRITE;
/*!40000 ALTER TABLE `Booking` DISABLE KEYS */;
INSERT INTO `Booking` VALUES ('2025-05-18','2025-05-19',200,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Cars`
--

DROP TABLE IF EXISTS `Cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Cars` (
  `Brand` varchar(100) NOT NULL,
  `car_id` int NOT NULL AUTO_INCREMENT,
  `Model` varchar(100) NOT NULL,
  `Year` int NOT NULL,
  `License_plate` varchar(100) NOT NULL,
  `availablity_status` tinyint(1) NOT NULL,
  `engine` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kilometers` varchar(16) NOT NULL,
  `fueltype` varchar(9) NOT NULL,
  `transmissions` varchar(45) NOT NULL,
  `seats` int NOT NULL,
  `cartype` varchar(45) NOT NULL,
  `imgurl` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Price` float NOT NULL,
  `Location` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`car_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cars`
--

LOCK TABLES `Cars` WRITE;
/*!40000 ALTER TABLE `Cars` DISABLE KEYS */;
INSERT INTO `Cars` VALUES ('Audi',4,'RS7',2019,'AMINA<3',1,'3990','120','Petrol','Automatic',5,'Coupe','https://editorial.pxcrush.net/carsales/general/editorial/audi-rs7-render-01.jpg?width=1024&height=682',200.1,'Sarajevo'),('Volkswagen',5,'Golf',2021,'Ivox-004',1,'2.0L TFSI','34000','Petrol','Automatic',5,'Hatchback','https://www.motortrend.com/uploads/sites/5/2020/02/2021-Volkwagen-Golf-GTD-02.jpg',139.99,'Sarajevo International Airport'),('Ford',6,'Focus',2019,'Ivox-092',1,'1.0L EcoBoost','48000','Petrol','Manual',5,'Hatchback','https://res.cloudinary.com/total-dealer/image/upload/w_3840,f_auto,q_75/v1/production/3e2krdy92u98613nmy6m7uhx6p0b',125,'Mostar'),('Porsche',8,'911 Carrera',2022,'Ivox-4821',1,'3.0L Twin-Turbo','8700','Petrol','Automatic',2,'Sport','https://cdn.jdpower.com/Models/640x480/2022-Porsche-911-Carrera4GTS.jpg',300,'Sarajevo'),('Chevrolet',9,'Camaro SS',2021,'Ivox-2198',1,'6.2L V8','15000','Petrol','Manual',4,'Sport','https://hips.hearstapps.com/hmg-prod/images/2024-chevrolet-camaro-ss-collectors-edition-1-647e1933c6c20.jpg?crop=0.827xw:0.853xh;0.0946xw,0.129xh&resize=1200:*',220,'Banja Luka'),('Toyota',10,'GR Supra',2023,'Ivox-7345',1,'3.0L Turbocharged','5000','Petrol','Automatic',2,'Sport','https://www.automobili.ba/wp-content/uploads/2023/06/Toyota-GR_Supra_45th_Anniversary_Edition-1.jpg',260,'Mostar'),('VW',11,'Golf',2003,'AMOGUS',1,'1.9 TDI ','500000','Diesel','Manual',5,'Wagon','https://img.autoabc.lv/volkswagen-golf/volkswagen-golf_1999_Universals_15111120631_4.jpg',35,'Klokotnica'),('VW',12,'Avion',1994,'2003',0,'123','3123','Petrol','Manual',5,'Wagon','sad',11,'ksma'),('VW',13,'sa',2003,'213',1,'21','23414','Petrol','Manual',32,'fsaf','sa',21,'sa');
/*!40000 ALTER TABLE `Cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Forms`
--

DROP TABLE IF EXISTS `Forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Forms` (
  `FullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `Message` varchar(1000) NOT NULL,
  `Status` varchar(15) NOT NULL,
  `form_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Forms`
--

LOCK TABLES `Forms` WRITE;
/*!40000 ALTER TABLE `Forms` DISABLE KEYS */;
INSERT INTO `Forms` VALUES ('John Doe','john@example.com','+38761123456','Hello, this is a message.','closed',1);
/*!40000 ALTER TABLE `Forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Location`
--

DROP TABLE IF EXISTS `Location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Location` (
  `location_id` int NOT NULL AUTO_INCREMENT,
  `Country` varchar(45) NOT NULL,
  `State` varchar(45) NOT NULL,
  `City` varchar(45) NOT NULL,
  `Street` varchar(45) NOT NULL,
  `Zip` varchar(45) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Location`
--

LOCK TABLES `Location` WRITE;
/*!40000 ALTER TABLE `Location` DISABLE KEYS */;
INSERT INTO `Location` VALUES (1,'Qatar','//','Doha','Al-Hitmi 21','Q192'),(2,'Canada','BC','Onterio','123 Ocean Ave','92101');
/*!40000 ALTER TABLE `Location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment`
--

DROP TABLE IF EXISTS `Payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `currency` varchar(4) NOT NULL,
  `amount` double NOT NULL,
  `payment_status` varchar(10) NOT NULL,
  `booking_id` int NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `fk_payment_booking` (`booking_id`),
  CONSTRAINT `fk_payment_booking` FOREIGN KEY (`booking_id`) REFERENCES `Booking` (`booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment`
--

LOCK TABLES `Payment` WRITE;
/*!40000 ALTER TABLE `Payment` DISABLE KEYS */;
INSERT INTO `Payment` VALUES (2,'2025-03-31','EURO',100.5,'Lst',1);
/*!40000 ALTER TABLE `Payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(45) DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `DriverLicense` varchar(10) DEFAULT NULL,
  `Email` varchar(55) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'USER',
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `zip` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (23,'Asaad','212121','$2y$10$263smglJpdqytgNXbf8wxOS1HL92X1fjk8tt81/VXP5IQ9uPhVi86','21','21','najt@test.com','USER','21','21','21','21'),(30,'AMINa','aMINA','$2y$10$ZwxHjLLJu/zRUCLgxNpaguBQxEFUC1ff4c21jer3JHvY3OFzjYa6i','3333','21','najt.admin@test.com','ADMIN','Qatar','London','Al hitmi','2309'),(32,NULL,NULL,'$2y$10$YQK4T1f801BKfqO4Fuhrm.jW5Uo78dVroe8Ut30vBzcjqm2TGP2Qa',NULL,NULL,'john@example.com','ADMIN',NULL,NULL,NULL,NULL),(34,NULL,NULL,'$2y$10$UHiJMo2D8hD6M2qMHxANUegADPhjw/LyWWej49OZxPA0WxRcE4W.2',NULL,NULL,'imran.kocan@stu.ibu.edu.ba','USER',NULL,NULL,NULL,NULL),(35,'Najt','aMINA','$2y$10$.i5sN8buo1wcdlOpfBMSAeKw83Pmz39xaznNDyjx0jlnEqbgvSz9y','3333','21','najt@ivoxadmin.ba','ADMIN','21','London','21','2309');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'car_rental_mysql'
--

--
-- Dumping routines for database 'car_rental_mysql'
--
