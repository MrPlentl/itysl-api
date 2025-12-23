-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               12.1.2-MariaDB - MariaDB Server
-- Server OS:                    Win64
-- HeidiSQL Version:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for itysl_api_db_dev
CREATE DATABASE IF NOT EXISTS `itysl_api_db_dev` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `itysl_api_db_dev`;

-- Dumping structure for table itysl_api_db_dev.characters
CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `actor` varchar(255) DEFAULT NULL COMMENT 'Actor who plays the character',
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `actor` (`actor`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.images
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `type` enum('static','gif') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `filename` (`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.quotes
CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(150) DEFAULT NULL,
  `quote` text DEFAULT NULL,
  `status_id` int(11) unsigned DEFAULT 1,
  `static_image_id` int(11) unsigned DEFAULT NULL,
  `gif_image_id` int(11) unsigned DEFAULT NULL,
  `sketch_info_id` int(11) unsigned DEFAULT NULL,
  `video_id` int(11) unsigned DEFAULT NULL,
  `date_posted` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) unsigned DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `status_id` (`status_id`),
  KEY `date_posted` (`date_posted`),
  KEY `sketch_info_id` (`sketch_info_id`),
  KEY `created_at` (`created_at`),
  KEY `static_image_id` (`static_image_id`),
  KEY `gif_image_id` (`gif_image_id`),
  KEY `video_id` (`video_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `1` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  CONSTRAINT `2` FOREIGN KEY (`static_image_id`) REFERENCES `images` (`id`) ON DELETE SET NULL,
  CONSTRAINT `3` FOREIGN KEY (`gif_image_id`) REFERENCES `images` (`id`) ON DELETE SET NULL,
  CONSTRAINT `4` FOREIGN KEY (`sketch_info_id`) REFERENCES `sketch_info` (`id`) ON DELETE SET NULL,
  CONSTRAINT `5` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `6` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `7` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.quote_characters
CREATE TABLE IF NOT EXISTS `quote_characters` (
  `quote_id` int(11) unsigned NOT NULL,
  `character_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`quote_id`,`character_id`),
  KEY `quote_id` (`quote_id`),
  KEY `character_id` (`character_id`),
  CONSTRAINT `1` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`character_id`) REFERENCES `characters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.quote_tags
CREATE TABLE IF NOT EXISTS `quote_tags` (
  `quote_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`quote_id`,`tag_id`),
  KEY `quote_id` (`quote_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `1` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.sketch_info
CREATE TABLE IF NOT EXISTS `sketch_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sketch_name` varchar(255) DEFAULT NULL,
  `episode` varchar(100) DEFAULT NULL COMMENT 'e.g., S01E01',
  `season` int(11) DEFAULT NULL,
  `episode_number` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL COMMENT 'https://www.netflix.com/watch/80986854',
  PRIMARY KEY (`id`),
  KEY `sketch_name` (`sketch_name`),
  KEY `episode` (`episode`),
  KEY `season` (`season`,`episode_number`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.statuses
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `role` enum('admin','editor','viewer') DEFAULT 'viewer',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table itysl_api_db_dev.videos
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL COMMENT 'Netflix link or video URL',
  `platform` enum('netflix','youtube','rumble','other') DEFAULT 'netflix',
  PRIMARY KEY (`id`),
  KEY `platform` (`platform`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
