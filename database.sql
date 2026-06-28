-- College Management System - Clean Database Export
-- Generated: 2026-04-26 21:50:05
-- Database: graduation_project_clacet2

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `graduation_project_clacet2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `graduation_project_clacet2`;

-- Table: activities
DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: competitions
DROP TABLE IF EXISTS `competitions`;
CREATE TABLE `competitions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: contact_submissions
DROP TABLE IF EXISTS `contact_submissions`;
CREATE TABLE `contact_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: deans
DROP TABLE IF EXISTS `deans`;
CREATE TABLE `deans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `welcome_text` text COLLATE utf8mb4_unicode_ci,
  `education` text COLLATE utf8mb4_unicode_ci,
  `experience` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: departments
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: events
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: external_protocols
DROP TABLE IF EXISTS `external_protocols`;
CREATE TABLE `external_protocols` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `organization_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: faculty_members
DROP TABLE IF EXISTS `faculty_members`;
CREATE TABLE `faculty_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint unsigned DEFAULT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faculty_members_department_id_foreign` (`department_id`),
  CONSTRAINT `faculty_members_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: galleries
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: graduates
DROP TABLE IF EXISTS `graduates`;
CREATE TABLE `graduates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: internal_protocols
DROP TABLE IF EXISTS `internal_protocols`;
CREATE TABLE `internal_protocols` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `organization_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: media
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_uploaded_by_foreign` (`uploaded_by`),
  CONSTRAINT `media_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: news
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: page_sections
DROP TABLE IF EXISTS `page_sections`;
CREATE TABLE `page_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint unsigned NOT NULL,
  `section_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_content` longtext COLLATE utf8mb4_unicode_ci,
  `section_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_sections_page_id_foreign` (`page_id`),
  CONSTRAINT `page_sections_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: pages
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `hero_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_subtitle` text COLLATE utf8mb4_unicode_ci,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: president_contents
DROP TABLE IF EXISTS `president_contents`;
CREATE TABLE `president_contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `welcome_text` text COLLATE utf8mb4_unicode_ci,
  `education` text COLLATE utf8mb4_unicode_ci,
  `postdoctoral` text COLLATE utf8mb4_unicode_ci,
  `administrative` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: site_settings
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` enum('text','textarea','image','boolean') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: testimonials
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testimonial` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: trainings
DROP TABLE IF EXISTS `trainings`;
CREATE TABLE `trainings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: tuition_fees
DROP TABLE IF EXISTS `tuition_fees`;
CREATE TABLE `tuition_fees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `year_range` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: users (Admin users)
INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Admin', 'admin@admin.com', 'admin', NULL, '$2y$12$mlfjF3ZTVO.lcQE4l5ue1uG5O3EbaJrquT4SSC67vl/pHfehPle76', 'nEKVIdRdwDpiqjTmeh07z3B0jiBdnrNxrePWvBtjxyfjeZ3AYkSKcUH16lev', '2026-04-06 22:14:44', '2026-04-18 15:51:07');

-- Data for table: deans (Dean profiles)
INSERT INTO `deans` (`id`, `full_name`, `title`, `position`, `faculty`, `image`, `welcome_text`, `education`, `experience`, `order`, `created_at`, `updated_at`) VALUES ('1', 'Professor Dr. Walid Al-Khatam', 'Professor', 'Dean of Industrial and Energy Technology', 'Faculty of Industrial and Energy Technology', NULL, 'We are pleased to welcome you to the Faculty of Industrial and Energy Technology, where we believe that education is the foundation for building a better future.
Our faculty is committed to preparing highly qualified graduates who combine strong academic knowledge with practical skills that meet the needs of the labor market.
We strive to provide a modern and inspiring learning environment that encourages creativity and innovation.
We look forward to seeing our students become active partners in success and continuous development.', 'Ph.D. in Electrical Engineering, University of Waterloo, Canada – June 2005
Master\'s Degree in Electrical Engineering (Power and Electrical Machines), Ain Shams University, Egypt – 1996
Bachelor\'s Degree in Electrical Engineering (Power and Electrical Machines), Ain Shams University, Egypt – 1996', 'Professor, Department of Electrical Power and Machines Engineering, Faculty of Engineering, Ain Shams University, Egypt.
Consultant for Electricity and Renewable Energy Development Programs in Egypt and Arab countries (since 2014).
Technical Consultant, Energy Excellence Center, Faculty of Engineering, Ain Shams University (2021-2023)
Vice Chairman, IEEE Power Engineering Society (PES) – Egypt Chapter (2020 – 2022)
Director, Energy Excellence Center, Faculty of Engineering, Ain Shams University (2019 - 2021)', '1', '2026-04-25 20:16:47', '2026-04-25 20:16:47');
INSERT INTO `deans` (`id`, `full_name`, `title`, `position`, `faculty`, `image`, `welcome_text`, `education`, `experience`, `order`, `created_at`, `updated_at`) VALUES ('2', 'Professor Dr. Ahmed Hassan', 'Professor', 'Dean of Applied Health Sciences Technology', 'Faculty of Applied Health Sciences Technology', NULL, 'Welcome to the Faculty of Applied Health Sciences Technology. We are dedicated to advancing healthcare education through innovative technology and practical training.
Our mission is to prepare healthcare professionals who can meet the evolving challenges of modern medicine.
We combine theoretical knowledge with hands-on experience to ensure our graduates are ready to make a meaningful impact in the healthcare sector.', 'Ph.D. in Biomedical Engineering, Cairo University, Egypt – 2008
Master\'s Degree in Medical Technology, Alexandria University, Egypt – 2003
Bachelor\'s Degree in Biomedical Engineering, Cairo University, Egypt – 1999', 'Professor, Department of Biomedical Engineering, Cairo University
Consultant for Healthcare Technology Development Programs (since 2015)
Member of the Egyptian Society for Biomedical Engineering
Director of Medical Technology Research Center (2018-2020)', '2', '2026-04-25 20:16:47', '2026-04-25 20:16:47');
INSERT INTO `deans` (`id`, `full_name`, `title`, `position`, `faculty`, `image`, `welcome_text`, `education`, `experience`, `order`, `created_at`, `updated_at`) VALUES ('3', 'Dr. Mahmoud Ibrahim', 'Dr.', 'Students Affairs Vice Dean', 'Student Affairs Office', 'deans/zJPfKCV1DSIeeiSzF6dhbS9DIBg22x1jPxMWfK0q.png', 'Welcome to the Student Affairs Office at New Cairo Technological University.
We are here to support you throughout your academic journey and ensure you have the best possible university experience.
Our team is dedicated to providing comprehensive student services, organizing activities, and fostering a vibrant campus community.
We believe in developing well-rounded individuals who excel both academically and personally.', 'Ph.D. in Educational Administration, Helwan University, Egypt – 2012
Master\'s Degree in Student Affairs Management, Cairo University, Egypt – 2007
Bachelor\'s Degree in Education, Ain Shams University, Egypt – 2002', 'Vice Dean for Student Affairs, New Cairo Technological University
Student Services Coordinator, Cairo University (2015-2020)
Member of the Egyptian Association for Student Development
Organizer of National Student Leadership Programs', '3', '2026-04-25 20:16:47', '2026-04-25 20:24:39');

-- Data for table: departments (Department information)
INSERT INTO `departments` (`id`, `name`, `slug`, `description`, `image`, `icon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Mechatronics', 'mechatronics', 'Mechatronics Technology combines mechanical engineering, electronics, computer science, and control engineering.', 'departments/gsSKSB6NyArszGuGdU6xT48XyfWjsu71vFluYlAT.jpg', NULL, '1', '1', '2026-04-06 22:14:45', '2026-04-19 18:15:17');
INSERT INTO `departments` (`id`, `name`, `slug`, `description`, `image`, `icon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Auto-tronics', 'auto-tronics', 'Automotive Technology focuses on the design, development, and maintenance of automotive systems.', 'departments/XOlgyfuPHF602wE8LeMe7YM7CIgMMRst3sol6r9Q.jpg', NULL, '2', '1', '2026-04-06 22:14:45', '2026-04-26 16:23:50');
INSERT INTO `departments` (`id`, `name`, `slug`, `description`, `image`, `icon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Information Technology', 'information-technology', 'Information Technology covers software development, networking, cybersecurity, and data management.', 'departments/llxPYIg99HJVr1MzPoJOV58MxsQdUVm22p6pL4Zu.jpg', NULL, '3', '1', '2026-04-06 22:14:45', '2026-04-26 16:37:11');
INSERT INTO `departments` (`id`, `name`, `slug`, `description`, `image`, `icon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'Petroleum', 'petroleum', 'Petroleum Technology focuses on exploration, extraction, and processing of petroleum resources.', 'departments/FbO0sjusmhJ6bTMlj2GRWOmovYHPJH7sOspN3UCL.jpg', NULL, '4', '1', '2026-04-06 22:14:45', '2026-04-26 16:37:01');
INSERT INTO `departments` (`id`, `name`, `slug`, `description`, `image`, `icon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('5', 'Renewable Energy', 'renewable-energy', 'Renewable Energy Technology covers solar, wind, and other sustainable energy sources.', 'departments/808C25Nezc6g395QiE8nTXibWZZBbyAp620VNEFl.jpg', NULL, '5', '1', '2026-04-06 22:14:45', '2026-04-26 16:36:49');
INSERT INTO `departments` (`id`, `name`, `slug`, `description`, `image`, `icon`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('6', 'Prosthetics', 'prosthetics', 'Prosthetics & Orthotics Technology focuses on designing and manufacturing artificial limbs and orthotic devices.', 'departments/6cMaSmnNV0QzCPeGytDAEaGWjwYqG4xS6f3qnIyD.jpg', NULL, '6', '1', '2026-04-06 22:14:45', '2026-04-26 16:36:38');

-- Data for table: president_contents (President content)
INSERT INTO `president_contents` (`id`, `full_name`, `title`, `position`, `image`, `welcome_text`, `education`, `postdoctoral`, `administrative`, `created_at`, `updated_at`) VALUES ('2', 'Professor Dr. Tarek Abdelmalak', 'Professor', 'President of New Cairo Technological University', NULL, 'On behalf of all faculty members and their assistants at New Cairo Technological University (NCT), I warmly welcome you as new members of our university family.
We believe that true success is not limited to academics but also includes building character, developing skills, and broadening horizons.', 'PhD (Mechanical Power Engineering), Shanghai University, China – 2002
Master\'s Degree (Mechanical Power Engineering), Cairo University, Egypt – 1996
Bachelor\'s Degree (Mechanical Power Engineering), Menoufia University, Egypt – 1991', '2003-2005: Scientific mission at KAIST, South Korea
2017: Short research visit at Kumamoto University, Japan', 'Consultant at Niaf Paper Products Company (2005-2006)
Consultant at Ramen Paper Products Company (2008-2012)
Project Manager for Training Centers – Funded by Korean Government (2015-2017)
Member of the Advisory Committee at the Science and Technology Development Fund (STDF)
Honored as one of the Top Ten Directors of Technological Education Centers in Africa by the African Union (2015)', '2026-04-25 19:52:50', '2026-04-25 19:59:10');

-- Data for table: testimonials (Student testimonials)
INSERT INTO `testimonials` (`id`, `student_name`, `department`, `photo`, `testimonial`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Fatima (Tomi)', 'ICT Department', NULL, 'The practical training at NCTU helped me master Laravel and web development.', '3', '1', '2026-04-26 17:26:14', '2026-04-26 17:39:07');
INSERT INTO `testimonials` (`id`, `student_name`, `department`, `photo`, `testimonial`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Ahmed Hassan', 'Mechatronics Department', NULL, 'NCTU provided me with hands-on experience in robotics and automation that prepared me for my career.', '1', '1', '2026-04-26 17:26:15', '2026-04-26 17:39:07');
INSERT INTO `testimonials` (`id`, `student_name`, `department`, `photo`, `testimonial`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Sara Mohamed', 'Petroleum Department', NULL, 'The field training program gave me real-world experience in the oil and gas industry.', '2', '1', '2026-04-26 17:26:15', '2026-04-26 17:39:07');

-- Data for table: tuition_fees (Fee structure)
INSERT INTO `tuition_fees` (`id`, `year_range`, `amount`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Year 1 & Year 2', '15000.00', '1', '1', '2026-04-26 15:36:03', '2026-04-26 15:36:03');
INSERT INTO `tuition_fees` (`id`, `year_range`, `amount`, `order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Year 3 & Year 4', '20000.00', '2', '1', '2026-04-26 15:36:03', '2026-04-26 15:36:03');

-- Data for table: site_settings (Site configuration)
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('1', 'site_name', 'New Cairo University of Technology', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('2', 'site_tagline', 'Leading Technological Education in Egypt', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('3', 'contact_email', 'info@nctu.edu.eg', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('4', 'contact_phone', '0225390250', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('5', 'contact_mobile', '+20 111 133 5725', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('6', 'contact_address', 'El Lotus, First New Cairo, New Cairo', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('7', 'facebook_url', 'https://www.facebook.com/nctu.edu.eg/?locale=ar_AR', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('8', 'instagram_url', 'https://www.instagram.com/explore/locations/113014853445529/new-cairo-technological-university/', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('9', 'linkedin_url', 'https://www.linkedin.com/school/nct-uni/', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('10', 'telegram_url', 'https://t.me/+hu88qUXmcXNlNmQ0', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('11', 'website_url', 'nctu.edu.eg', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('12', 'logo', 'img/sub-logo.png', 'image', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('13', 'footer_text', '© 2025 New Cairo Technological University. All Rights Reserved.', 'text', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('14', 'competitions_video_url', 'http://localhost/img/videos/comptions.mp4', 'text', '2026-04-26 14:17:21', '2026-04-26 14:17:21');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('15', 'graduates_hero_image', 'http://localhost/img/kk.png', 'text', '2026-04-26 14:45:14', '2026-04-26 14:45:14');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('16', 'graduates_hero_title', 'Outstanding Students at New Cairo Technological University', 'text', '2026-04-26 14:45:14', '2026-04-26 14:45:14');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('17', 'academic_year', '2025–2026', 'text', '2026-04-26 15:36:03', '2026-04-26 15:36:03');
INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES ('18', 'fees_announcement', 'As announced in August 2025, there will be no increase in tuition fees for the upcoming year.', 'text', '2026-04-26 15:36:03', '2026-04-26 15:36:03');

-- Data for table: pages (Static pages)
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'home', 'New Cairo University of Technology', 'New Cairo University of Technology - Leading technological education in Egypt', 'NCTU, technology, university, Cairo, Egypt, education', 'New Cairo University of Technology', 'The university has established the basic infrastructure of human resources necessary for the technical plans for social development in particular.', 'img/unvircity1.jpg', '<p>Welcome to New Cairo University of Technology</p>', '1', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'about', 'About NCT', 'Learn about New Cairo University of Technology', 'about, NCTU, history, mission, vision', 'About Us', 'Discover our mission and vision', 'img/univercty2.jpg', '<p>We bring you the latest updates regarding your future and the opportunities provided by the New Technological University.</p>', '1', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'contact', 'Contact Us', 'Get in touch with New Cairo University of Technology', 'contact, NCTU, address, phone, email', 'Contacts', 'Contact us for any inquiries', 'img/univercty2.jpg', '<p>This website helps you easily access the Technology College at Cairo University.</p>', '1', '2026-04-06 22:14:45', '2026-04-06 22:14:45');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('15', 'quality-intro-to-quality', 'Introduction to the Quality Assurance Unit', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!-- Main Content Start -->
    <div class=\"container my-5\">
        <!-- Opening Statement -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Opening Statement</h4>
            <p class=\"custom-text\">
                In line with New Cairo Technological University’s commitment to fostering a culture of quality and institutional excellence,
                and its continuous pursuit to enhance academic and administrative performance in accordance with national and international
                accreditation and quality standards, this internal regulation of the Quality Assurance Unit serves as the guiding framework
                for the unit’s operations.
            </p>
            <p class=\"custom-text\">
                This regulation aims to define the unit’s objectives, responsibilities, organizational structure, and operational mechanisms
                to ensure its active role in monitoring and developing quality assurance systems, as well as promoting continuous improvement
                in academic programs, educational services, and research and community activities.
            </p>
            <p class=\"custom-text\">
                By putting this regulation into effect, the University reaffirms its commitment to transparency, accountability, and
                continuous improvement, and to building a modern educational system capable of competing regionally and internationally,
                thereby fulfilling its vision and mission of graduating distinguished professionals who meet the evolving demands of the
                labor market.
            </p>
            <p class=\"fw-bold mt-3\">Director of Quality Management<br>Dr. Sherif Hassan Al-Hosary</p>
        </div>

        <!-- Introduction -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Introduction</h4>
            <p class=\"custom-text\">
                In alignment with the Egyptian state’s commitment to considering technological education as one of the main pillars of
                sustainable development within the framework of Egypt’s Vision 2030, and in recognition of the need to enhance the quality
                of higher education and its institutions to meet the demands of the local, regional, and international labor markets, the
                establishment of the Quality Assurance Unit at New Cairo Technological University (NCTU) represents a true embodiment of
                this national priority. It also reflects the university’s dedication to its mission of delivering distinguished technological
                education that keeps pace with scientific and technological advancements.
            </p>
            <p class=\"custom-text\">
                This internal regulation serves as the organizational framework governing the operations of the Quality Assurance Unit at the
                university. It complements the university’s strategic plan to achieve excellence, leadership, and innovation, while aligning
                with the National Authority for Quality Assurance and Accreditation of Education (NAQAAE) standards, to:
            </p>
            <ul class=\"custom-text\">
                <li>Build an effective system that ensures continuous improvement of academic and administrative performance.</li>
                <li>Support the university’s technological programs — such as Mechatronics Technology, Automotive Technology, New and Renewable Energy Technology, Information and Communication Technology, Petroleum Production and Processing Technology, and Prosthetics and Orthotics Technology — to meet local and international academic accreditation standards.</li>
                <li>Strengthening societal and labor market confidence in the university’s outputs and graduates, who possess the skills and competencies to compete globally.</li>
            </ul>
            <p class=\"custom-text\">
                The Quality Assurance Unit at New Cairo Technological University serves as the main instrument for implementing and activating
                quality systems and mechanisms, thereby achieving the university’s vision and mission, and contributing to building a leading
                institutional image that enhances the university’s standing locally, regionally, and internationally.
            </p>
        </div>
    </div>
    <!-- Main Content End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('16', 'quality-vision-mission', 'Vision and Mission', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!--------------------------- Navbar Start ------------------------------->
       <style>
                    /* Hover effect for dropdown items */
                    .dropdown-item:hover {
                        background-color: #D08301 !important;
                        color: #fff !important;
                        border-radius: 6px;
                        transition: 0.3s;
                    }

                    /* Dropdown headers spacing */
                    .dropdown-menu h5 {
                        margin-bottom: 12px;
                        font-size: 1.1rem;
                    }

                    /* Optional: add spacing between links */
                    .dropdown-links a {
                        display: block;
                        margin-bottom: 5px;
                        font-weight: 500;
                    }
                </style>
                
    <nav class=\"navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0\">
        <a href=\"{{ asset(\'home.html\') }}\" class=\"logo\">
            <img src=\"{{ asset(\'uni/img.png\') }}\" alt=\"logo\" width=auto height=auto>
        </a>
        <button type=\"button\" class=\"navbar-toggler me-4\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarCollapse\">
            <span class=\"navbar-toggler-icon\"></span>
        </button>
        <div class=\"collapse navbar-collapse\" id=\"navbarCollapse\">
            <div class=\"navbar-nav ms-auto p-4 p-lg-0\">
                <!-- Dropdown 1: Home -->
                <a href=\"{{ asset(\'index.html\') }}\" class=\"nav-item nav-link \">Home</a>    

               <!-- Dropdown 2: About -->
                <div class=\"nav-item dropdown \">
                    <a href=\"#\" class=\"nav-link dropdown-toggle \"  id=\"qualityDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\"> About
                    </a>

                    <div class=\"dropdown-menu fade-down m-0 p-3\" aria-labelledby=\"qualityDropdown\" style=\"width: 700px; left: 0;\">
                        <!-- صف أول -->
                        <div class=\"d-flex flex-wrap justify-content-start\">
                         <!--   <div class=\"col-6\"> </div>-->
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'about.html\') }}\" style=\"color: #1a096e;\">About NCT</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'president.html\') }}\" style=\"color: #1a096e;\">University President</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'Deans.html\') }}\" style=\"color: #1a096e;\">University Deans</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'campus.html\') }}\" style=\"color: #1a096e;\">Campus Tour</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'Internalprotocols.html\') }}\" style=\"color: #1a096e;\">Internal Protocols</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'Externalprotocols.html\') }}\" style=\"color: #1a096e;\">External Protocols</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'reasons.html\') }}\" style=\"color: #1a096e;\">Top 10 Reasons</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'Competitions.html\') }}\" style=\"color: #1a096e;\">Competitions</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'graduates.html\') }}\" style=\"color: #1a096e;\">Graduate Achievements</a>
                                      
                        </div>
                    </div>
                </div>

                <!-- Dropdown 3: Units -->
                <div class=\"nav-item dropdown\">
                    <a href=\"#\" class=\"nav-link dropdown-toggle active\" id=\"qualityDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\"> Units
                    </a>

                    <div class=\"dropdown-menu fade-down m-0 p-3\" aria-labelledby=\"qualityDropdown\" style=\"width: 700px; left: 0;\">
                        <!-- صف أول -->
                        <div class=\"d-flex flex-wrap justify-content-start\">
                         <!--   <div class=\"col-6\"> </div>-->
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'DigitalTrans.html\') }}\"      style=\"color: #1a096e;\"> Digital Transformation</a>
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'InternationalCoop.html\') }}\" style=\"color: #1a096e;\"> International Cooperation</a>
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'Quality.html\') }}\" style=\"color: #1a096e;\"> Quality Assurance</a>
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'Evaluation.html\') }}\"           style=\"color: #1a096e;\">Measurement and Evaluation</a>
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'Women.html\') }}\"                style=\"color: #1a096e;\">Combating Violence Against Women</a>
                                      
                        </div>
                    </div>
                </div>
                   <!-- Dropdown 4: Departments -->
                <a href=\"{{ asset(\'Departments.html\') }}\" class=\"nav-item nav-link\">Departments</a>
                   <!-- Dropdown 5: Events -->
                <a href=\"{{ asset(\'Events.html\') }}\" class=\"nav-item nav-link\"> Events</a>
                   <!-- Dropdown 6: Contacts -->
                <a href=\"{{ asset(\'contact.html\') }}\" class=\"nav-item nav-link\">Contacts</a>
                <!-- Dropdown 7: Admissions-->
                <div class=\"nav-item dropdown\">
                    <a href=\"{{ asset(\'Admissions.html\') }}\" class=\"nav-link dropdown-toggle\" id=\"admissionsDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        Admissions
                    </a>
                    <div class=\"dropdown-menu fade-down m-0\" aria-labelledby=\"admissionsDropdown\">
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Admissions.html\') }}\"            style=\"color: #1a096e;\">Admission Requirements</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'howapply.html\') }}\"              style=\"color: #1a096e;\">How to Apply Online</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Faculties Requirements.html\') }}\"style=\"color: #1a096e;\">Faculties Requirements</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Postgraduate_Studies.html\') }}\"  style=\"color: #1a096e;\"> Postgraduate Programs</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'fees.html\') }}\"                  style=\"color: #1a096e;\" >Tuition Fees & Scholarships</a>
                    </div>
                </div>

                   <!-- Dropdown 8: Services-->
                <div class=\"nav-item dropdown\">
                    <a href=\"#\" class=\"nav-link dropdown-toggle\" id=\"admissionsDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        Services
                    </a>
                    <div class=\"dropdown-menu fade-down m-0\" aria-labelledby=\"admissionsDropdown\">
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Student Service.html\') }}\"  style=\"color: #1a096e;\">Student Services</a> <!--هناخدو منهم-->
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'HR.html\') }}\"               style=\"color: #1a096e;\">Staff Services</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Student Booking.html\') }}\"  style=\"color: #1a096e;\">Student Affairs Services</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Faculty Members.html\') }}\"  style=\"color: #1a096e;\">Faculty Members </a>

                    </div>
                </div>

                   <!-- Dropdown 9: LoginOption-->
                <div class=\"nav-item dropdown\">
                    <a href=\"#\" class=\"nav-link dropdown-toggle\" id=\"admissionsDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        Login Options
                    </a>
                    <div class=\"dropdown-menu fade-down m-0\" aria-labelledby=\"admissionsDropdown\">
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Student_Login.html\') }}\" style=\"color: #1a096e;\">Student Login</a> <!--هناخدو منهم-->
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Admin_login.html\') }}\" style=\"color: #1a096e;\">Admin Access</a>
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <!-------------------------- Navbar End ----------------------------->

    <!-- Main Content Start -->
    <div class=\"container my-5\">
        <!-- Vision of the Quality Assurance Unit -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Vision of the Quality Assurance Unit</h4>
            <p class=\"custom-text\">
                The Quality Assurance Unit at New Cairo Technological University (NCTU) aspires to become a leading
                center locally, regionally, and internationally in implementing quality and academic accreditation
                standards — thereby strengthening the university’s position as a distinguished technological institution
                and enabling
                it to achieve global leadership in education, research, innovation, and community service.
        </div>
        <!-- Mission of the Quality Assurance Unit -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Mission of the Quality Assurance Unit</h4>
            <p class=\"custom-text\">
                The Quality Assurance Unit is committed to developing and implementing a comprehensive and integrated
                quality assurance system that promotes continuous improvement across all academic, research,
                <br>
                administrative, and community activities of the university, through:
                <br>
                • Supporting the university in achieving local and international academic accreditation.
                <br>
                • Aligning technological programs with global standards and labor market requirements.
                <br>
                • Promoting a culture of quality and excellence among students, faculty members, and staff.
                <br>
                • Activating monitoring and evaluation mechanisms to ensure the effectiveness of academic and
                administrative performance.
                <br>
                • Expanding international partnerships and collaborations to enhance institutional excellence and global
                recognition of the university’s outcomes.
            </p>
        </div>
    </div>
    <!-- Main Content End -->


    
 <!-- Footer Start -->
     
    <!-- Footer End -->



    <!-- JavaScript Libraries -->
    <script src=\"https://code.jquery.com/jquery-3.4.1.min.js\"></script>
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js\"></script>
    <script src=\"{{ asset(\'lib/wow/wow.min.js\') }}\"></script>
    <script src=\"{{ asset(\'lib/easing/easing.min.js\') }}\"></script>
    <script src=\"{{ asset(\'lib/waypoints/waypoints.min.js\') }}\"></script>
    <script src=\"{{ asset(\'lib/owlcarousel/owl.carousel.min.js\') }}\"></script>

    <!-- Template Javascript -->
    <script src=\"{{ asset(\'js/main.js\') }}\"></script>
    <script>
        (function () { if (!window.chatbase || window.chatbase(\"getState\") !== \"initialized\") { window.chatbase = (...arguments) => { if (!window.chatbase.q) { window.chatbase.q = [] } window.chatbase.q.push(arguments) }; window.chatbase = new Proxy(window.chatbase, { get(target, prop) { if (prop === \"q\") { return target.q } return (...args) => target(prop, ...args) } }) } const onLoad = function () { const script = document.createElement(\"script\"); script.src = \"https://www.chatbase.co/embed.min.js\"; script.id = \"vCJaS-Ai1Hgccr-hIzTuu\"; script.domain = \"www.chatbase.co\"; document.body.appendChild(script) }; if (document.readyState === \"complete\") { onLoad() } else { window.addEventListener(\"load\", onLoad) } })();
    </script>', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('17', 'quality-periodical-pub', 'The unit\'s periodical publication', NULL, NULL, NULL, NULL, NULL, '<style>
                    /* Hover effect for dropdown items */
                    .dropdown-item:hover {
                        background-color: #D08301 !important;
                        color: #fff !important;
                        border-radius: 6px;
                        transition: 0.3s;
                    }

                    /* Dropdown headers spacing */
                    .dropdown-menu h5 {
                        margin-bottom: 12px;
                        font-size: 1.1rem;
                    }

                    /* Optional: add spacing between links */
                    .dropdown-links a {
                        display: block;
                        margin-bottom: 5px;
                        font-weight: 500;
                    }
                </style><!DOCTYPE html>
<html lang=\"en\">

<head>
    <meta charset=\"utf-8\">
    <title>New Cairo University of Technology</title>
    <link rel=\"icon\" href=\"{{ asset(\'img/sub-logo.png\') }}\" type=\"image/png\">
    <meta content=\"\" name=\"keywords\">
    <meta content=\"\" name=\"description\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

    <!-- Favicon -->
    <link href=\"{{ asset(\'img/favicon.ico\') }}\" rel=\"icon\">

    <!-- Google Web Fonts -->
    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
    <link
        href=\"https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap\"
        rel=\"stylesheet\">

    <!-- Icon Font Stylesheet -->
    <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css\" rel=\"stylesheet\">
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css\" rel=\"stylesheet\">

    <!-- Libraries Stylesheet -->
    <link href=\"{{ asset(\'lib/animate/animate.min.css\') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset(\'lib/owlcarousel/assets/owl.carousel.min.css\') }}\" rel=\"stylesheet\">

    <!-- Customized Bootstrap Stylesheet -->
    <link href=\"{{ asset(\'css/bootstrap.min.css\') }}\" rel=\"stylesheet\">

    <!-- Template Stylesheet -->
    <link href=\"{{ asset(\'css/style.css\') }}\" rel=\"stylesheet\">
</head>

<body>



    <!--------------------------- Navbar Start ------------------------------->
       <style>
                    /* Hover effect for dropdown items */
                    .dropdown-item:hover {
                        background-color: #D08301 !important;
                        color: #fff !important;
                        border-radius: 6px;
                        transition: 0.3s;
                    }

                    /* Dropdown headers spacing */
                    .dropdown-menu h5 {
                        margin-bottom: 12px;
                        font-size: 1.1rem;
                    }

                    /* Optional: add spacing between links */
                    .dropdown-links a {
                        display: block;
                        margin-bottom: 5px;
                        font-weight: 500;
                    }
                </style>
                
    <nav class=\"navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0\">
        <a href=\"{{ asset(\'home.html\') }}\" class=\"logo\">
            <img src=\"{{ asset(\'uni/img.png\') }}\" alt=\"logo\" width=auto height=auto>
        </a>
        <button type=\"button\" class=\"navbar-toggler me-4\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarCollapse\">
            <span class=\"navbar-toggler-icon\"></span>
        </button>
        <div class=\"collapse navbar-collapse\" id=\"navbarCollapse\">
            <div class=\"navbar-nav ms-auto p-4 p-lg-0\">
                <!-- Dropdown 1: Home -->
                <a href=\"{{ asset(\'index.html\') }}\" class=\"nav-item nav-link \">Home</a>    

               <!-- Dropdown 2: About -->
                <div class=\"nav-item dropdown \">
                    <a href=\"#\" class=\"nav-link dropdown-toggle \"  id=\"qualityDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\"> About
                    </a>

                    <div class=\"dropdown-menu fade-down m-0 p-3\" aria-labelledby=\"qualityDropdown\" style=\"width: 700px; left: 0;\">
                        <!-- صف أول -->
                        <div class=\"d-flex flex-wrap justify-content-start\">
                         <!--   <div class=\"col-6\"> </div>-->
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'about.html\') }}\" style=\"color: #1a096e;\">About NCT</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'president.html\') }}\" style=\"color: #1a096e;\">University President</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'Deans.html\') }}\" style=\"color: #1a096e;\">University Deans</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'campus.html\') }}\" style=\"color: #1a096e;\">Campus Tour</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'Internalprotocols.html\') }}\" style=\"color: #1a096e;\">Internal Protocols</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'Externalprotocols.html\') }}\" style=\"color: #1a096e;\">External Protocols</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'reasons.html\') }}\" style=\"color: #1a096e;\">Top 10 Reasons</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'Competitions.html\') }}\" style=\"color: #1a096e;\">Competitions</a>
                                    <a class=\"dropdown-item\" href=\"{{ asset(\'graduates.html\') }}\" style=\"color: #1a096e;\">Graduate Achievements</a>
                                      
                        </div>
                    </div>
                </div>

                <!-- Dropdown 3: Units -->
                <div class=\"nav-item dropdown\">
                    <a href=\"#\" class=\"nav-link dropdown-toggle active\" id=\"qualityDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\"> Units
                    </a>

                    <div class=\"dropdown-menu fade-down m-0 p-3\" aria-labelledby=\"qualityDropdown\" style=\"width: 700px; left: 0;\">
                        <!-- صف أول -->
                        <div class=\"d-flex flex-wrap justify-content-start\">
                         <!--   <div class=\"col-6\"> </div>-->
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'DigitalTrans.html\') }}\"      style=\"color: #1a096e;\"> Digital Transformation</a>
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'InternationalCoop.html\') }}\" style=\"color: #1a096e;\"> International Cooperation</a>
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'Quality.html\') }}\" style=\"color: #1a096e;\"> Quality Assurance</a>
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'Evaluation.html\') }}\"           style=\"color: #1a096e;\">Measurement and Evaluation</a>
                                 <a  class=\"dropdown-item\" href=\"{{ asset(\'Women.html\') }}\"                style=\"color: #1a096e;\">Combating Violence Against Women</a>
                                      
                        </div>
                    </div>
                </div>
                   <!-- Dropdown 4: Departments -->
                <a href=\"{{ asset(\'Departments.html\') }}\" class=\"nav-item nav-link\">Departments</a>
                   <!-- Dropdown 5: Events -->
                <a href=\"{{ asset(\'Events.html\') }}\" class=\"nav-item nav-link\"> Events</a>
                   <!-- Dropdown 6: Contacts -->
                <a href=\"{{ asset(\'contact.html\') }}\" class=\"nav-item nav-link\">Contacts</a>
                <!-- Dropdown 7: Admissions-->
                <div class=\"nav-item dropdown\">
                    <a href=\"{{ asset(\'Admissions.html\') }}\" class=\"nav-link dropdown-toggle\" id=\"admissionsDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        Admissions
                    </a>
                    <div class=\"dropdown-menu fade-down m-0\" aria-labelledby=\"admissionsDropdown\">
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Admissions.html\') }}\"            style=\"color: #1a096e;\">Admission Requirements</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'howapply.html\') }}\"              style=\"color: #1a096e;\">How to Apply Online</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Faculties Requirements.html\') }}\"style=\"color: #1a096e;\">Faculties Requirements</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Postgraduate_Studies.html\') }}\"  style=\"color: #1a096e;\"> Postgraduate Programs</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'fees.html\') }}\"                  style=\"color: #1a096e;\" >Tuition Fees & Scholarships</a>
                    </div>
                </div>

                   <!-- Dropdown 8: Services-->
                <div class=\"nav-item dropdown\">
                    <a href=\"#\" class=\"nav-link dropdown-toggle\" id=\"admissionsDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        Services
                    </a>
                    <div class=\"dropdown-menu fade-down m-0\" aria-labelledby=\"admissionsDropdown\">
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Student Service.html\') }}\"  style=\"color: #1a096e;\">Student Services</a> <!--هناخدو منهم-->
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'HR.html\') }}\"               style=\"color: #1a096e;\">Staff Services</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Student Booking.html\') }}\"  style=\"color: #1a096e;\">Student Affairs Services</a>
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Faculty Members.html\') }}\"  style=\"color: #1a096e;\">Faculty Members </a>

                    </div>
                </div>

                   <!-- Dropdown 9: LoginOption-->
                <div class=\"nav-item dropdown\">
                    <a href=\"#\" class=\"nav-link dropdown-toggle\" id=\"admissionsDropdown\" role=\"button\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        Login Options
                    </a>
                    <div class=\"dropdown-menu fade-down m-0\" aria-labelledby=\"admissionsDropdown\">
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Student_Login.html\') }}\" style=\"color: #1a096e;\">Student Login</a> <!--هناخدو منهم-->
                        <a  class=\"dropdown-item\" href=\"{{ asset(\'Admin_login.html\') }}\" style=\"color: #1a096e;\">Admin Access</a>
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <!-------------------------- Navbar End ----------------------------->

 <div class=\"container my-5\">
        <h4 class=\"faq-item\" >Board Meetings</h4>
        <ul>
            <li>The Board shall convene regularly at least once every three months, and extraordinary meetings may be held upon the invitation of the Chairperson or at the request of one-third of the members.</li>
            <li>Meetings of the Board shall be considered valid when attended by most members (50% + 1).</li>
            <li>Decisions shall be adopted by a majority vote of the attending members; in the event of a tie, the Chairperson’s side shall prevail.</li>
            <li>Minutes of each meeting shall be recorded, signed by the Chairperson, the Unit Director, and the Board Secretary, and shall be kept in a dedicated register maintained at the Unit’s premises.</li>
            <li>Membership in the Board shall be terminated if a member fails to attend three consecutive meetings or five separate meetings without an acceptable excuse.</li>
        </ul>

        <h4 class=\"faq-item\" >Formation of Specialized Committees</h4>
        <p>The specialized committees established under the Quality Assurance Unit consist of qualified directors and several subcommittees that assist in carrying out the Unit’s mission. The formation of these committees shall be approved by a decision of the University President, based on the recommendation of the Unit Director and the approval of the Board of Directors.</p>
        
        <h5  style=\"text-align: left;\">1. Curriculum Development Unit</h5>
        <ul>
            <li><strong>Director:</strong> A faculty member with experience in academic program development.</li>
            <li><strong>Affiliated Subcommittees:</strong> A Curriculum Development Committee for each academic program within the university’s colleges.</li>
        </ul>
        <p><strong>Responsibilities:</strong></p>
        <ul>
            <li>Review and update curricula and academic programs in accordance with quality and accreditation standards.</li>
            <li>Align programs with the needs of local and international labor markets.</li>
            <li>Prepare periodic reports on curriculum development and submit them to the Board.</li>
        </ul>

        <h5 style=\"text-align: left;\">2. Monitoring and Technical Support Unit</h5>
        <ul>
            <li><strong>Director:</strong> A faculty member with experience in quality and institutional evaluation.</li>
            <li><strong>Affiliated Subcommittees:</strong>
                <ul>
                    <li>Committee for Supporting Standard Implementation</li>
                    <li>Committee for Organizing Workshops</li>
                    <li>Technical Support Committee for Colleges</li>
                    <li>Field Monitoring and Evaluation Committee</li>
                </ul>
            </li>
        </ul>
        <p><strong>Responsibilities:</strong></p>
        <ul>
            <li>Monitor the implementation of quality plans and continuous improvement in colleges and programs.</li>
            <li>Provide technical and administrative support to units and programs.</li>
            <li>Organize workshops and training programs.</li>
            <li>Conduct follow-up visits and prepare periodic reports.</li>
        </ul>

       <h5 style=\"text-align: left;\">3. Database, Information Systems, and Media Unit</h5>
        <ul>
            <li><strong>Director:</strong> A faculty member or expert in information systems and databases.</li>
            <li><strong>Affiliated Subcommittees:</strong>
                <ul>
                    <li>Media and Documentation Committee</li>
                    <li>Information Systems and Reporting Committee</li>
                    <li>Data Collection and Organization Committee</li>
                    <li>Quality Awareness and Media Committee</li>
                </ul>
            </li>
        </ul>
        <p><strong>Responsibilities:</strong></p>
        <ul>
            <li>Establish and manage quality and accreditation databases.</li>
            <li>Prepare and analyze periodic reports.</li>
            <li>Manage media campaigns and awareness activities of the university.</li>
            <li>Document quality and accreditation activities.</li>
        </ul>

        <h5 style=\"text-align: left;\"> 4. Performance Evaluation and Continuous Improvement Unit</h5>
        <ul>
            <li><strong>Director:</strong> A faculty member with experience in academic and administrative evaluation.</li>
            <li><strong>Affiliated Subcommittees:</strong>
                <ul>
                    <li>Academic Performance Evaluation Committee</li>
                    <li>Administrative Performance Evaluation Committee</li>
                    <li>Continuous Improvement and Performance Enhancement Committee</li>
                </ul>
            </li>
        </ul>
        <p><strong>Responsibilities:</strong></p>
        <ul>
            <li>Evaluate the academic performance of programs and faculty members.</li>
            <li>Monitor and assess administrative and technical performance in the university.</li>
            <li>Propose continuous improvement plans and institutional performance development.</li>
        </ul>
    </div>
    

      <!-- Footer Start -->
            
           <!-- Footer End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('18', 'quality-tasks', 'Unit Tasks and Objectives', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!-- Main Content Start -->
    <div class=\"container my-5\">
        <!-- Vision of the Quality Assurance Unit -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Objectives of the Quality Assurance Unit</h4>
            <p class=\"custom-text\">
                1. Promote and institutionalize a culture of quality and organizational excellence among all university
                members.
                <br>
                2. Develop and maintain integrated internal systems for quality assurance and accreditation in
                accordance with national and international standards.
                <br>
                3. Prepare and monitor strategic and continuous improvement plans for academic programs and research
                activities.
                 <br>
                4. Support colleges and programs in obtaining international academic accreditation in addition to local
                accreditation.
                 <br>
                5. Monitor academic and administrative performance indicators and align them with global labor market
                needs.
                 <br>
                6. Build the capacities of faculty members, staff, and students in the areas of quality, research, and
                innovation.
                 <br>
                7. Enhance the global reputation of the university through adopting best international practices and
                developing strategic partnerships with renowned educational and research institutions.

            </p>
        </div>
    </div>
    <!-- Main Content End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('19', 'quality-internal-regulations', 'Internal Regulations of the Unit', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!-- Main Content Start -->
    <div class=\"container my-5 text-center\">
        <img src=\"{{ asset(\'img/الهيكل التنظيمى.png\') }}\" alt=\"Quality Assurance Introduction\" 
             class=\"img-fluid rounded shadow-lg\" style=\"max-width: 90%; border: 5px solid #D08301;\">
    </div>
    <!-- Main Content End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('20', 'quality-org-structure', 'Organizational Structure and Responsibilities', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!-- Main Content Start -->
    <div class=\"container my-5 text-center\">
        <img src=\"{{ asset(\'img/الهيكل التنظيمى.png\') }}\" alt=\"Quality Assurance Introduction\" 
             class=\"img-fluid rounded shadow-lg\" style=\"max-width: 90%; border: 5px solid #D08301;\">
    </div>
    <!-- Main Content End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('21', 'quality-executive-council', 'Executive Council', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!-- Main Content Start -->
    <div class=\"container my-5\">
        <!-- Quality Assurance Unit Board of Directors -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Quality Assurance Unit Board of Directors</h4>
            <p class=\"custom-text\">
                The activities of the Quality Assurance Unit are managed by a Board of Directors, formed by a decision
                of the University President for a renewable term of three years, and composed as follows:
                <br>
                1. University President – Chairperson of the Board
                <br>
                2. Vice President for Education and Student Affairs – Deputy Chairperson
                <br>
                3. Vice President for Postgraduate Studies and Research – Member
                <br>
                4. Vice President for Community Service and Environmental Development – Member
                <br>
                5. Deans of the Colleges – Members
                <br>
                6. Director of the Quality Assurance Unit – Rapporteur of the Board
                <br>
                7. Deputy Director of the Unit – Member
                <br>
                8. Quality Coordinators at the Colleges – Members
                <br>
                9. Quality Coordinators of Academic Programs – Members
                <br>
                10. Representative of Faculty Members from Each College – Member
                <br>
                11. University Secretary-General or his/her delegate – Member
                <br>
                12. Student Representative (President of the Student Union or nominee approved by the Board) – Member
                <br>
                13. Graduate Representative (selected among distinguished alumni) – Member
                <br>
                14. Representative of the Labor Market / Industry (from the university’s strategic partners) – Member
                <br>
                The Board may invite experts or consultants in the field of quality assurance and accreditation to
                attend its meetings without voting rights.

        </div>
        <!-- Mission of the Quality Assurance Unit -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Functions of the Quality Assurance Unit Board of Directors</h4>
            <p class=\"custom-text\">
                The Board of Directors of the Quality Assurance Unit at the university shall be responsible for the
                following:
                <br>
                1. Approving the general policies of the Unit in line with the university’s mission and strategic plan.
                <br>
                2. Approving the strategic plan and annual work plans of the Unit.
                <br>
                3. Monitoring the implementation of quality and continuous improvement plans across the university, its
                colleges, and programs.
                <br>
                4. Approving the formation of specialized subcommittees under the Unit.
                <br>
                5. Approving periodic reports, self-evaluation studies, and the annual report before submission to the
                University Council.
                <br>
                6. Considering proposals submitted by the Unit Director or specialized committees regarding the
                development of academic and administrative performance.
                <br>
                7. Coordinating with the University Quality Assurance Center and the National Authority for Quality
                Assurance and Accreditation (NAQAAE).
                <br>
                8. Approving the financial and administrative regulations of the Unit within the framework of the
                governing laws.
                <br>
                9. Considering any other matters referred by the University President or the Unit Director.

            </p>
        </div>
    </div>
    <!-- Main Content End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('22', 'quality-administrative-council', 'Formation of the Administrative Council', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!-- Main Content Start -->
    <div class=\"container my-5\">
        <!-- Board Meetings -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Board Meetings</h4>
            <p class=\"custom-text\">
                • The Board shall convene regularly at least once every three months, and extraordinary meetings may be
                held upon the invitation of the Chairperson or at the request of one-third of the members.
                <br>
                • Meetings of the Board shall be considered valid when attended by most members (50% + 1).
                <br>
                • Decisions shall be adopted by a majority vote of the attending members; in the event of a tie, the
                Chairperson’s side shall prevail.
                <br>
                • Minutes of each meeting shall be recorded, signed by the Chairperson, the Unit Director, and the Board
                Secretary, and shall be kept in a dedicated register maintained at the Unit’s premises.
                <br>
                • Membership in the Board shall be terminated if a member fails to attend three consecutive meetings or
                five separate meetings without an acceptable excuse.
            </p>
        </div>
        <!-- Formation of Specialized Committees -->
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">Formation of Specialized Committees</h4>
            <p class=\"custom-text\">
                The specialized committees established under the Quality Assurance Unit consist of qualified directors
                and several subcommittees that assist in carrying out the Unit’s mission. The formation of these
                committees shall be approved by a decision of the University President, based on the recommendation of
                the Unit Director and the approval of the Board of Directors.
            </p>
        </div>
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">1.Curriculum Development Unit</h4>
            <p class=\"custom-text\">
                • Director: A faculty member with experience in academic program development.
                <br>
                • Affiliated Subcommittees: A Curriculum Development Committee for each academic program within the
                university’s colleges.
                <br>
                Responsibilities:
                <br>
                • Review and update curricula and academic programs in accordance with quality and accreditation
                standards.
                <br>
                • Align programs with the needs of local and international labor markets.
                <br>
                • Prepare periodic reports on curriculum development and submit them to the Board of Directors.
            </p>
        </div>
        <div class=\"custom-card\">
            <h4 class=\"custom-title\">2. Monitoring and Technical Support Unit</h4>
            <p class=\"custom-text\">
                • Director: A faculty member with expertise in quality assurance and institutional assessment.
                <br>
                • Affiliated Subcommittees:
                <br>
                o Committee for Standards Implementation Support.
                <br>
                o Committee for Workshops and Training Organization.
                <br>
                o Committee for Technical Support to Colleges.
                <br>
                o Committee for Field Monitoring and Evaluation.
                <br>
                Responsibilities:
                <br>
                • Monitor the implementation of quality and continuous improvement plans within colleges and programs.
                <br>
                • Provide technical and administrative support to quality units and programs.
                <br>
                • Organize workshops and training programs on quality and accreditation.
                <br>
                • Conduct follow-up visits and prepare periodic evaluation reports.

            </p>
        </div>


        <div class=\"custom-card\">
            <h4 class=\"custom-title\">3. Database, Information Systems, and Media Unit</h4>
            <p class=\"custom-text\">
                • Director: A faculty member or specialist with expertise in information systems and databases.
                <br>
                • Affiliated Subcommittees:
                <br>
                o Media and Documentation Committee.
                <br>
                o Information Systems and Reporting Committee.
                <br>
                o Data Collection and Organization Committee.
                <br>
                o Quality Awareness and Communication Committee.
                <br>
                Responsibilities:
                <br>
                • Establish and manage quality and accreditation databases.
                <br>
                • Prepare and analyze periodic performance reports.
                <br>
                • Manage media campaigns and awareness activities related to university quality initiatives.
                <br>
                • Document all quality assurance and accreditation activities.
            </p>
        </div>


        <div class=\"custom-card\">
            <h4 class=\"custom-title\">4. Performance Evaluation and Continuous Improvement Unit</h4>
            <p class=\"custom-text\">
                • Director: A faculty member with experience in academic and administrative performance evaluation.
                <br>
                • Affiliated Subcommittees:
                <br>
                o Academic Performance Evaluation Committee.
                <br>
                o Administrative Performance Evaluation Committee.
                <br>
                o Continuous Improvement and Institutional Development Committee.
                <br>
                Responsibilities:
                <br>
                • Evaluate the academic performance of study programs and faculty members.
                <br>
                • Monitor and assess administrative and technical performance within the university.
                <br>
                • Propose continuous improvement and institutional development plans to enhance overall performance.


            </p>
        </div>

    </div>




    </div>
    <!-- Main Content End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('23', 'quality-academic-standards', 'Academic Standards', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!-- Main Content Start -->
    <div class=\"container my-5\">
     
       <!--  Commitment to Quality and Academic Accreditation Standards -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Commitment to Quality and Academic Accreditation Standards</h4>
  <p class=\"custom-text\">
    1. Ensure compliance with national and international quality assurance standards in all university activities.
    <br>
    2. Implement a comprehensive internal system for continuous quality improvement and accreditation.
    <br>
    3. Conduct regular self-evaluations to maintain and enhance academic excellence.
    <br>
    4. Develop quality manuals and documentation aligned with accreditation requirements.
    <br>
    5. Provide technical support to academic departments to prepare for accreditation reviews.
    <br>
    6. Foster transparency and accountability across all institutional processes.
  </p>
</div>

<!--  Development of Academic Programs and Learning Outcomes -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Development of Academic Programs and Learning Outcomes</h4>
  <p class=\"custom-text\">
    1. Design and update academic programs according to national academic reference standards (NARS).
    <br>
    2. Ensure alignment between program objectives, learning outcomes, and teaching strategies.
    <br>
    3. Review curricula regularly to meet evolving market and community needs.
    <br>
    4. Promote interdisciplinary learning and integration of modern technologies.
    <br>
    5. Use measurable indicators to assess the achievement of learning outcomes.
  </p>
</div>

<!--  Teaching, Learning, and Student Assessment -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Teaching, Learning, and Student Assessment</h4>
  <p class=\"custom-text\">
    1. Implement innovative, student-centered teaching methods.
    <br>
    2. Use varied assessment tools that accurately measure learning outcomes.
    <br>
    3. Ensure fairness and transparency in grading and feedback.
    <br>
    4. Provide continuous training for faculty in teaching and assessment skills.
    <br>
    5. Integrate technology into learning and digital evaluation systems.
    <br>
    6. Encourage active learning, teamwork, and creative problem-solving.
  </p>
</div>

<!--  Scientific Research and Innovation -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Scientific Research and Innovation</h4>
  <p class=\"custom-text\">
    1. Promote a culture of scientific research and innovation among faculty and students.
    <br>
    2. Support applied research addressing national and regional development challenges.
    <br>
    3. Provide incentives and funding for high-quality publications and patents.
    <br>
    4. Encourage interdisciplinary research and collaboration with industry partners.
    <br>
    5. Ensure ethical standards and integrity in all research activities.
  </p>
</div>

<!--  Community Service and Environmental Development -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Community Service and Environmental Development</h4>
  <p class=\"custom-text\">
    1. Strengthen partnerships with local and national community organizations.
    <br>
    2. Develop projects that serve society and promote sustainable development.
    <br>
    3. Encourage faculty and students to engage in volunteer and outreach programs.
    <br>
    4. Monitor the social and environmental impact of university activities.
    <br>
    5. Raise awareness of environmental issues and green campus initiatives.
  </p>
</div>

<!--  Leadership, Governance, and Institutional Efficiency -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Leadership, Governance, and Institutional Efficiency</h4>
  <p class=\"custom-text\">
    1. Apply principles of good governance, transparency, and accountability.
    <br>
    2. Establish clear organizational structures that support decision-making and efficiency.
    <br>
    3. Promote participatory leadership involving faculty, staff, and students.
    <br>
    4. Evaluate administrative performance regularly and implement improvement plans.
    <br>
    5. Ensure strategic alignment between university goals and national higher education policies.
  </p>
</div>

<!--  Faculty Members and Human Resources -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Faculty Members and Human Resources</h4>
  <p class=\"custom-text\">
    1. Recruit highly qualified faculty and provide continuous professional development.
    <br>
    2. Establish fair promotion and evaluation systems based on performance and contribution.
    <br>
    3. Encourage research, training, and participation in academic conferences.
    <br>
    4. Support a positive and motivating work environment for academic and administrative staff.
  </p>
</div>

<!--  Students and Graduate Support -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Students and Graduate Support</h4>
  <p class=\"custom-text\">
    1. Provide comprehensive academic, psychological, and career guidance for students.
    <br>
    2. Develop systems to monitor student satisfaction and respond to their needs.
    <br>
    3. Strengthen alumni relations and establish mechanisms for graduate follow-up.
    <br>
    4. Offer training and internship programs to enhance employability skills.
  </p>
</div>

<!-- Resources and Infrastructure -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Resources and Infrastructure</h4>
  <p class=\"custom-text\">
    1. Provide adequate financial, human, and material resources to support academic operations.
    <br>
    2. Maintain safe, accessible, and technologically advanced facilities.
    <br>
    3. Develop and update digital infrastructure to support e-learning and research.
    <br>
    4. Ensure sustainability and optimal use of institutional resources.
  </p>
</div>

<!-- Continuous Development and Strategic Planning -->
<div class=\"custom-card\">
  <h4 class=\"custom-title\">Continuous Development and Strategic Planning</h4>
  <p class=\"custom-text\">
    1. Implement evidence-based strategic plans aligned with the university’s mission and vision.
    <br>
    2. Conduct periodic reviews to assess goal achievement and update priorities.
    <br>
    3. Foster a culture of continuous improvement through data-driven decision-making.
    <br>
    4. Monitor key performance indicators (KPIs) to measure progress and success.
  </p>
</div>

    </div>
    <!-- Main Content End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('24', 'quality-unit-activities', 'Unit Activities', NULL, NULL, NULL, NULL, NULL, '<style>
        .custom-card {
            border-left: 6px solid #D08301;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .custom-title {
            color: #1a096e;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: left;
        }

        .custom-text {
            text-align: justify;
            color: #333;
            line-height: 1.8;
        }

        ul.custom-text li {
            margin-bottom: 8px;
        }
    </style><!-- Hero Video Card Start -->
<div class=\"container mt-5 position-relative\">
    <div class=\"card shadow-lg border-0 rounded-4 overflow-hidden wow fadeInUp\"
        data-wow-delay=\"0.2s\">

        <video class=\"w-100\"
            autoplay muted loop controls
            style=\"max-height: 550px; object-fit: cover;\">
            <source src=\"{{ asset(\'img/Unit_Activities.mp4\') }}\" type=\"video/mp4\">
            Your browser does not support the video tag.
        </video>

    </div>
</div>
<!-- Hero Video Card End -->


    <!-- Main Content Start -->
    <div class=\"container my-5\">
     

    <!-- Card 1 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Internal Auditing and Evaluation</h4>
        <p class=\"custom-text\">
            1. Conduct regular internal audits for academic, administrative, and service activities across the university. 
            <br>
            2. Assess compliance with quality standards and identify areas for continuous improvement. 
            <br>
            3. Provide reports with findings and recommendations to improve institutional performance.
        </p>
    </div>

    <!-- Card 2 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Performance Indicators and Data Analysis</h4>
        <p class=\"custom-text\">
            1. Develop and analyze Key Performance Indicators (KPIs) to measure progress toward institutional and program objectives.
            <br>
            2. Update KPIs periodically to align with national and international standards.
            <br>
            3. Use data analysis results to guide decision-making and strategic planning.
        </p>
    </div>

    <!-- Card 3 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Continuous Improvement Plans</h4>
        <p class=\"custom-text\">
            1. Follow up on the implementation of continuous improvement plans in academic, research, and service activities.
            <br>
            2. Prepare semi-annual and annual reports including results, performance indicators, and future recommendations.
            <br>
            3. Ensure all departments commit to continuous development and excellence.
        </p>
    </div>

    <!-- Card 4 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Annual Reporting</h4>
        <p class=\"custom-text\">
            1. Prepare the annual quality report and submit it to the Quality Assurance Council and the University Board.
            <br>
            2. Include all key findings, performance summaries, and improvement recommendations.
            <br>
            3. Support decision-makers with data-driven insights to enhance university outcomes.
        </p>
    </div>

    <!-- Card 5 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Specialized Quality Committees</h4>
        <p class=\"custom-text\">
            1. Establish specialized committees such as Curriculum Development, Monitoring & Technical Support, Database Systems, and Continuous Improvement.
            <br>
            2. Define committee roles, responsibilities, and ensure effective collaboration.
            <br>
            3. Monitor their progress and provide technical guidance.
        </p>
    </div>

    <!-- Card 6 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Training and Capacity Building</h4>
        <p class=\"custom-text\">
            1. Organize workshops and training sessions for faculty, staff, and students on quality assurance and accreditation practices.
            <br>
            2. Develop skills in research, innovation, and continuous improvement.
            <br>
            3. Foster a university-wide culture of quality and excellence.
        </p>
    </div>

    <!-- Card 7 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Quality Database Management</h4>
        <p class=\"custom-text\">
            1. Build and maintain the university’s quality and accreditation database.
            <br>
            2. Collect, analyze, and document all quality-related data and activities.
            <br>
            3. Prepare reports and awareness materials on quality performance.
        </p>
    </div>

    <!-- Card 8 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Community and Industry Engagement</h4>
        <p class=\"custom-text\">
            1. Strengthen collaboration between the university, industry, and the community.
            <br>
            2. Involve external stakeholders and alumni in quality development and program enhancement.
            <br>
            3. Align university outcomes with labor market and community needs.
        </p>
    </div>

    <!-- Card 9 -->
    <div class=\"custom-card\">
        <h4 class=\"custom-title\">Spreading Quality Culture</h4>
        <p class=\"custom-text\">
            1. Promote awareness of quality and accreditation among students, faculty, and administrative staff.
            <br>
            2. Encourage transparency, accountability, and participation in quality-related initiatives.
            <br>
            3. Foster a culture of excellence and institutional integrity across all departments.
        </p>
    </div>





    </div>
    <!-- Main Content End -->', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('25', 'quality-courses-workshops', 'Courses and Workshops', NULL, NULL, NULL, NULL, NULL, '<style>
        .competition-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 40px;
            border-left: 5px solid #D08301;
        }

        .competition-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .competition-content {
            display: flex;
            align-items: stretch;
            padding: 0;
            min-height: 400px;
        }

        .competition-img {
            width: 40%;
            height: auto;
            object-fit: cover;
            align-self: stretch;
        }

        .competition-info {
            width: 60%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .competition-info h3 {
            color: #1a096e;
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .competition-date {
            background: #D08301;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .competition-location {
            color: #5d6d7e;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .competition-location i {
            color: #D08301;
            margin-right: 8px;
        }

        .competition-description {
            color: #5d6d7e;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 1rem;
            flex-grow: 1;
        }

        .btn-competition {
            background: #D08301;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 600;
            align-self: flex-start;
        }

        .btn-competition:hover {
            background: #b36f00;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(210, 131, 1, 0.4);
        }

        /* للكروت اللي الصورة على الشمال */
        .competition-reverse .competition-content {
            flex-direction: row-reverse;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .competition-content {
                flex-direction: column;
                min-height: auto;
            }

            .competition-img,
            .competition-info {
                width: 100%;
            }

            .competition-img {
                height: 200px;
            }

            .competition-info {
                padding: 20px;
            }
        }
    </style><!-- المسابقات Content -->
    <div class=\"container-xxl py-5\">
        <div class=\"container\">
            <div class=\"text-center wow fadeInUp\" data-wow-delay=\"0.1s\">
               
            </div>

    
    <!-- Workshop 1 -->
    <div class=\"competition-card wow fadeInUp\" data-wow-delay=\"0.1s\">
        <div class=\"competition-content\">
            <img src=\"{{ asset(\'img/workshop1.png\') }}\" class=\"competition-img\" alt=\"Quality Management Workshop\">
            <div class=\"competition-info\">
                <span class=\"competition-date\">January 15, 2025</span>
                <h3>Workshop on Academic Program Standards and Quality Management</h3>
                <p class=\"competition-description\">
                    The Quality Assurance Unit organized a training workshop titled 
                    <strong>\"Academic Program Standards and Quality Management\"</strong>, 
                    focusing on aligning educational programs with national academic reference standards (NARS).  
                    The session provided hands-on activities on designing learning outcomes, course mapping, 
                    and assessment strategies.  
                    <br><br>
                    The workshop was attended by program coordinators and faculty members across all departments, 
                    aiming to enhance awareness of accreditation requirements and internal evaluation methods.
                </p>
            </div>
        </div>
    </div>

    <!-- Workshop 2 -->
    <!-- Workshop: Professional Competencies -->
<div class=\"competition-card wow fadeInUp\" data-wow-delay=\"0.5s\">
    <div class=\"competition-content\">
        <img src=\"{{ asset(\'img/workshop2.png\') }}\" class=\"competition-img\" alt=\"Professional Competencies Workshop\">
        <div class=\"competition-info\">
            <span class=\"competition-date\">July 14, 2025</span>
            <h3>Workshop on “Professional Competencies and Their Applications for Teaching Assistants”</h3>
            <p class=\"competition-description\">
                Under the patronage of <strong>Prof. Dr. Tarek Abdel Malak</strong> – President of New Cairo Technological University,  
                <strong>Prof. Dr. Walid El Khetam</strong> – Dean of the Faculty of Industry and Energy Technology, and  
                <strong>Prof. Dr. Mohamed Fawzy</strong> – Dean of the Faculty of Applied Health Sciences,  
                the university organized its second workshop titled  
                <strong>“Professional Competencies and Their Applications for Teaching Assistants.”</strong>  
                <br><br>
                The workshop took place on <strong>Monday, July 14, 2025, at 11:00 AM</strong> at the university campus,  
                as part of the university’s ongoing efforts to develop academic and professional skills.  
                The event was organized under the supervision of <strong>Dr. Sherif El Hosary</strong>,  
                Director of the Quality Assurance Unit.
                <br><br>
                The workshop addressed several key themes aimed at enhancing the professional competencies of teaching assistants, including:
                <ul>
                    <li>Introduction to professional competencies and the competency matrix.</li>
                    <li>Strategies and methods for practical and theoretical assessment.</li>
                    <li>How to integrate competencies into course design, particularly in practical components.</li>
                </ul>
                <br>
                This workshop was conducted within the framework of the project  
                <strong>“Establishment of the Quality Assurance Unit”</strong>, funded by the Projects Management Unit  
                of the Ministry of Higher Education.
            </p>
        </div>
    </div>
</div>


    <!-- Workshop 3 -->
   <!-- Workshop: Spreading Quality Culture -->
<div class=\"competition-card wow fadeInUp\" data-wow-delay=\"0.6s\">
    <div class=\"competition-content\">
        <img src=\"{{ asset(\'img/workshop3.png\') }}\" class=\"competition-img\" alt=\"Workshop on Quality Culture and Professional Competencies\">
        <div class=\"competition-info\">
            <span class=\"competition-date\">July 13, 2025</span>
            <h3>Workshop on “Spreading Quality Culture and Professional Competencies among Faculty Members”</h3>
            <p class=\"competition-description\">
                In line with <strong>New Cairo Technological University’s</strong> commitment to promoting quality principles  
                and enhancing academic excellence, the <strong>Faculty of Industry and Energy Technology</strong> organized  
                a workshop titled <strong>“Spreading Quality Culture and Professional Competencies among Faculty Members”</strong>  
                on <strong>Sunday, July 13, 2025</strong>.
                <br><br>
                The event was held under the patronage of:
                <ul>
                    <li><strong>Prof. Dr. Tarek Abdel Malak</strong> – President of the University</li>
                    <li><strong>Prof. Dr. Walid El Khetam</strong> – Dean of the Faculty of Industry and Energy Technology</li>
                </ul>
                Supervised by <strong>Prof. Dr. Tamer Abu El Naga</strong> – Vice Dean for Education and Student Affairs,  
                and organized by <strong>Dr. Sherif El Hosary</strong> – Director of the Quality Assurance Unit.
                <br><br>
                The workshop began at <strong>11:00 AM</strong> and was attended by a number of faculty members  
                from various programs. It aimed to strengthen awareness and practical application of academic quality standards.
                <br><br>
                The main themes discussed included:
                <ul>
                    <li>Introduction to the Quality Assurance Unit: its roles, tasks, and documentation requirements.</li>
                    <li>Practical activity for analyzing and evaluating exam models (Good / Poor).</li>
                    <li>Explanation of the Key Performance Indicators (KPI) system and review of performance results related to quality standards.</li>
                </ul>
                <br>
                The workshop targeted faculty members from different programs,  
                aiming to equip them with the fundamental knowledge and skills required  
                to apply quality systems and academic accreditation standards —  
                contributing to improved educational outcomes and institutional excellence.  
                <br><br>
                This workshop is part of a continuous series of activities organized  
                by the <strong>Quality Assurance Unit</strong> to spread a culture of excellence and quality  
                across the faculty and the university.
            </p>
        </div>
    </div>
</div>


    <!-- Workshop 4 -->
   <!-- Dual Workshop on Quality Assurance and Professional Competencies -->
<div class=\"competition-card wow fadeInUp\" data-wow-delay=\"0.7s\">
    <div class=\"competition-content\">
        <img src=\"{{ asset(\'img/workshop5.png\') }}\" class=\"competition-img\" alt=\"Workshops on Quality Assurance and Professional Competencies\">
        <div class=\"competition-info\">
            <span class=\"competition-date\">July 13–14, 2025</span>
            <h3>Workshops on “Promoting Quality Assurance and Professional Competencies among Faculty Members”</h3>

            <p class=\"competition-description\">
                Under the auspices of:
                <ul>
                    <li><strong>Prof. Dr. Tarek Abdel-Malak</strong> – President of New Cairo Technological University</li>
                    <li><strong>Prof. Dr. Walid El Khatam</strong> – Dean of the Faculty of Industry and Energy Technology</li>
                    <li><strong>Prof. Dr. Mohamed Fawzy</strong> – Dean of the Faculty of Health Applied Sciences</li>
                </ul>
                Organized and supervised by:
                <strong>Dr. Sherif El-Hosary</strong> – Director of the Quality Assurance Unit.
                <br><br>

                The university organized two consecutive workshops as part of its continuous efforts  
                to strengthen the culture of quality and enhance academic performance across faculties.
                <br><br>

                <strong>FIRST WORKSHOP:</strong> <em>Promoting Quality Assurance and Their Applications among Faculty Members</em><br>
                <strong>Sunday, July 13, 2025 – 11:00 AM</strong><br>
                 Building A, Third Floor – Meeting Room
                <br><br>
                <strong>Agenda:</strong>
                <ul>
                    <li><strong>11:00–12:00:</strong> Introduction to the Quality Assurance Unit – its roles, tasks, and paper quality requirements.</li>
                    <li><strong>12:00–1:00:</strong> Practical activity on analysis and evaluation of exam samples (Good/Poor).</li>
                    <li>Explanation of the <strong>KPI System</strong> and review of performance results and quality standards achievement.</li>
                </ul>

                <hr>

                <strong>SECOND WORKSHOP:</strong> <em>Promoting Quality Culture and Professional Competencies among Faculty Members</em><br>
                 <strong>Monday, July 14, 2025 – 11:00 AM</strong><br>
                 Building A, Third Floor – Meeting Room
                <br><br>
                <strong>Target Group:</strong> Faculty and Teaching Assistants
                <br><br>
                <strong>Topics Covered:</strong>
                <ul>
                    <li>Introducing professional capabilities and competency matrices.</li>
                    <li>Practical and theoretical assessment strategies.</li>
                    <li>Integration of competencies into curricula, with emphasis on practical components.</li>
                </ul>
                <br>
                This workshop was held as part of the <strong>Quality Assurance Unit Establishment Project</strong>,  
                funded by the <strong>Projects Management Unit (PMU)</strong> at the Ministry of Higher Education.
                <br><br>
                <strong>For inquiries and coordination:</strong><br>
                 <a href=\"{{ asset(\'mailto:Sherif.Alhosary@nctu.edu.eg\') }}\">Sherif.Alhosary@nctu.edu.eg</a><br>
                📞 01016263625
            </p>
        </div>
    </div>
</div>

        </div>
    </div>', '1', '2026-04-07 01:05:17', '2026-04-07 01:05:17');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('32', 'how-to-apply', 'How to Apply Online', NULL, NULL, NULL, NULL, NULL, '<style>
    :root {
      --blue: #1a096e;
      --orange: #D08301;
    }

    body {
      font-family: \'Heebo\', sans-serif;
      background-color: #f8f9fc;
      color: #333;
      scroll-behavior: smooth;
    }

    /* Header Section */
    .header-banner {
      background: linear-gradient(135deg, var(--blue), #3a2ba0);
      color: #fff;
      text-align: center;
      padding: 100px 20px 80px;
    }

    .header-banner h1 {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 15px;
      color: var(--orange);
    }

    .header-banner p {
      font-size: 1.2rem;
      max-width: 800px;
      margin: 0 auto;
    }

    /* Boxes Section */
    .admission-section {
      padding: 80px 20px;
      text-align: center;
    }

    .admission-box {
      background: #fff;
      border-left: 6px solid var(--orange);
      border-radius: 12px;
      padding: 35px;
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.07);
      transition: 0.3s;
      margin-bottom: 40px;
      max-width: 900px;
      margin-left: auto;
      margin-right: auto;
      text-align: left;
    }

    .admission-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .admission-box i {
      font-size: 2.5rem;
      color: var(--orange);
      margin-bottom: 15px;
      display: block;
    }

    .admission-box h3 {
      color: var(--blue);
      margin-bottom: 15px;
      font-weight: 700;
    }

    .admission-box p {
      font-size: 1rem;
      color: #555;
      line-height: 1.7;
    }

    /* Button */
    .apply-btn {
      display: inline-block;
      background-color: var(--orange);
      color: #fff;
      font-size: 1.2rem;
      font-weight: 700;
      padding: 12px 45px;
      border-radius: 8px;
      text-decoration: none;
      margin-top: 20px;
      transition: 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .apply-btn:hover {
      background-color: var(--blue);
      color: #FFD700;
      /* Gold on hover */
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    @media(max-width: 768px) {
      .header-banner h1 {
        font-size: 2.2rem;
      }

      .admission-box {
        padding: 25px;
      }
    }
  </style><!-- Admission Boxes -->
  <section class=\"admission-section container\">

    <div class=\"admission-box\">
      <i class=\"fa-solid fa-gear\"></i>
      <h3>General Secondary Students (Science & Math)</h3>
      <p>
        • Applicants must hold a recognized General Secondary Education Certificate or its equivalent.<br>
        • The total grade must meet the minimum score determined annually by the university or by the national
        coordination office.<br>
        • Applicants must submit all required documents, including the original certificate, birth certificate, personal
        photos, national ID,
        and a medical report if requested.
      </p>
    </div>

    <div class=\"admission-box\">
      <i class=\"fa-solid fa-gear\"></i>
      <h3>Technical Diploma Students (3 or 5-Year Systems)</h3>
      <p>
        • Applicants must hold an officially recognized Technical Diploma (3 or 5 years) or an equivalent
        qualification.<br>
        • Admission depends on achieving the minimum percentage or score set by the university or national coordination
        each year.<br>
        • These criteria may vary annually based on applicant numbers and fields of study.
        <br><br>
        * The details above are based on published educational and media sources and may not represent official
        university documents.
      </p>
    </div>

    <a href=\"{{ asset(\'howapply.html\') }}\" class=\"apply-btn\">Apply Now</a>

  </section>', '1', '2026-04-07 02:20:51', '2026-04-07 02:20:51');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('33', 'tuition-fees', 'Tuition Fees & Scholarships', NULL, NULL, NULL, NULL, NULL, '<style>
    :root {
      --brand-blue: #1a096e;
      --accent-color: #D08301;
      --accent-hover: #b36a00;
    }

    body {
      font-family: \'Heebo\', sans-serif;
      background-color: #f8f9fc;
      color: #333;
      scroll-behavior: smooth;
    }

    h1,
    h2,
    h3,
    h4,
    h5 {
      color: var(--brand-blue);
      font-weight: 700;
      position: relative;
    }

    /* Animations */
    @keyframes slideUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animated {
      animation: slideUp 1s ease forwards;
    }

    /* Navbar */
    .navbar {
      transition: background 0.3s, padding 0.3s;
    }

    .navbar.sticky-top.scrolled {
      background: #fff;
      padding: 10px 0;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    /* Header Banner */
    .header-banner {
      text-align: center;
      padding: 80px 20px;
      background: linear-gradient(135deg, var(--brand-blue) 0%, #3d2bb7 100%);
      color: white;
      overflow: hidden;
    }

    .header-banner h1 {
      font-size: 3rem;
      margin-bottom: 15px;
      animation: slideUp 1s ease forwards;
    }

    .header-banner p {
      font-size: 1.2rem;
      max-width: 800px;
      margin: 0 auto;
      animation: slideUp 1.5s ease forwards;
    }

    /* Buttons */
    .btn-accent {
      background-color: var(--accent-color);
      color: #fff;
      border: none;
      transition: 0.3s;
      position: relative;
      overflow: hidden;
    }

    .btn-accent::after {
      content: \"\";
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: -100%;
      background: rgba(255, 255, 255, 0.2);
      transition: 0.4s;
    }

    .btn-accent:hover::after {
      left: 0;
    }

    .btn-accent:hover {
      background-color: var(--accent-hover);
    }

    /* Content Section */
    .content-section {
      max-width: 1100px;
      margin: 0 auto;
      padding: 60px 20px;
      animation: slideUp 1s ease forwards;
    }

    /* Fee Table */
    .fee-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
      background: white;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.3s;
    }

    .fee-table:hover {
      transform: translateY(-5px);
    }

    .fee-table th,
    .fee-table td {
      border: 1px solid #eee;
      padding: 15px;
      text-align: left;
    }

    .fee-table th {
      background: var(--accent-color);
      font-weight: 600;
      color: var(--brand-blue);
      transition: background 0.3s;
    }

    .fee-table th:hover {
      background: var(--accent-hover);
      color: #fff;
    }

    /* Info Boxes */
    .info-box {
      background: #fff9f0;
      padding: 25px;
      border-left: 6px solid var(--accent-color);
      margin-top: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .info-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .info-box h3 {
      margin-bottom: 15px;
      position: relative;
    }

    .info-box h3::after {
      content: \'\';
      display: block;
      width: 50px;
      height: 3px;
      background: var(--accent-color);
      margin-top: 5px;
      border-radius: 2px;
    }

    .info-box ul {
      padding-left: 20px;
      line-height: 1.8;
    }

    /* Subtitle */
    .subtitle {
      text-align: center;
      font-size: 1.1rem;
      max-width: 900px;
      margin: 20px auto 60px auto;
      animation: slideUp 1.2s ease forwards;
    }

    /* Responsive */
    @media(max-width: 768px) {
      .header-banner h1 {
        font-size: 2.2rem;
      }

      .subtitle {
        font-size: 1rem;
      }
    }
  </style><div class=\"container-xxl py-5\">
    <div class=\"container\">
      <div class=\"text-center wow fadeInUp\" data-wow-delay=\"0.1s\">
        <h6 class=\"section-title bg-white text-center text-orange px-3\">Tuition Fees & Scholarships</h6>
        <h1 class=\"mB-5\">New Applicant Tuition Fees Categories </h1>
      </div>
    </div>
    <p class=\"subtitle\">
      \"Transparent and continuously updated information about tuition fees, financial aid programs, and the wide range
      of scholarship opportunities designed to support talented and ambitious students at New Cairo University of
      Technology, ensuring equal access to quality education for everyone.\"
    </p>

  </div>



  <!-- Main Content -->
  <div class=\"content-section\">
    <h2>Tuition Fees for Academic Year 2025–2026</h2>
    <p>As announced in August 2025, there will be <strong>no increase</strong> in tuition fees for the upcoming academic
      year.</p>
    <p>The annual tuition fees for the Faculty of Industrial and Energy Technology are as follows:</p>

    <table class=\"fee-table\">
      <thead>
        <tr>
          <th>Year / Category</th>
          <th>Annual Tuition (EGP)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Year 1 & Year 2</td>
          <td><strong>15,000 EGP</strong></td>
        </tr>
        <tr>
          <td>Year 3 & Year 4</td>
          <td><strong>20,000 EGP</strong></td>
        </tr>
      </tbody>
    </table>

    <div class=\"info-box\">
      <h3>Scholarship Programs</h3>
      <ul>
        <li><strong>Merit Scholarships:</strong> For students with outstanding academic performance.</li>
        <li><strong>Scholarships for Students with Disabilities:</strong> Dedicated support for students with special
          needs.</li>
        <li><strong>Criteria:</strong> Some scholarships require maintaining a high GPA and may cover specific academic
          terms.</li>
      </ul>
    </div>

    <div class=\"info-box\">
      <h3>Important Notes</h3>
      <ul>
        <li>Students are encouraged to follow the <strong>official university website</strong> and social media pages
          for the latest announcements.</li>
        <li>For detailed information, students may directly contact the <strong>Scholarship Office</strong> or the
          <strong>Admissions & Registration Office</strong>.</li>
        <li>Tuition payments are made in Egyptian Pounds through the university’s official bank branches.</li>
        <li>Scholarship discounts are applied by the Admissions & Registration Office after eligibility verification.
        </li>
      </ul>
    </div>

    <div style=\"margin-top:40px; text-align:center;\">
      <a href=\"{{ asset(\'Faculties Requirements.html\') }}\" class=\"btn btn-accent btn-lg\">Check Required Documents &raquo;</a>
    </div>
  </div>', '1', '2026-04-07 02:20:51', '2026-04-07 02:20:51');
INSERT INTO `pages` (`id`, `slug`, `title`, `meta_description`, `meta_keywords`, `hero_title`, `hero_subtitle`, `hero_image`, `content`, `is_active`, `created_at`, `updated_at`) VALUES ('34', 'faculties-requirements', 'Faculties Requirements', NULL, NULL, NULL, NULL, NULL, '<style>
    body {
      background-color: #fff;
      font-family: \'Poppins\', sans-serif;
      color: #040faa;
      overflow-x: hidden;
    }

    header {
      background: linear-gradient(135deg, #040faa, #0a18b8);
      color: white;
      text-align: center;
      padding: 100px 20px;
      position: relative;
      overflow: hidden;
    }

    header h1 {
      font-size: 3rem;
      font-weight: 700;
      color: #D08301;
      text-shadow: 0 0 25px rgba(208, 131, 1, 0.7);
    }

    header p {
      font-size: 1.3rem;
      margin-top: 15px;
      color: #f8f9fa;
    }

    section {
      padding: 80px 10%;
      border-bottom: 1px solid #eee;
    }

    section h2 {
      font-size: 2.2rem;
      font-weight: 700;
      color: #040faa;
      margin-bottom: 25px;
      position: relative;
    }

    section h2::after {
      content: \"\";
      width: 100px;
      height: 4px;
      background: #D08301;
      position: absolute;
      bottom: -10px;
      left: 0;
      border-radius: 2px;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .doc-card {
      background: #f6f8ff;
      border-left: 6px solid #D08301;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      flex: 1 1 calc(45% - 20px);
      min-width: 280px;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .doc-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(208, 131, 1, 0.2);
    }

    .back-btn {
      display: inline-block;
      margin: 60px auto 40px;
      padding: 12px 35px;
      background: #D08301;
      color: white;
      border-radius: 50px;
      font-weight: 600;
      text-decoration: none;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
    }

    .back-btn:hover {
      background: #040faa;
      color: #fff;
      box-shadow: 0 0 15px rgba(4, 15, 170, 0.5);
    }
  </style><!--------------------------- Navbar Start ------------------------------->

  
    <!-------------------------- Navbar End ----------------------------->






  <section>
    <h2>Required Documents</h2>
    <div class=\"card-container\">
      <div class=\"doc-card\">
        <p>Original high school certificate or equivalent + 5 digital copies.</p>
      </div>
      <div class=\"doc-card\">
        <p>Final college nomination form after coordination results.</p>
      </div>
      <div class=\"doc-card\">
        <p>Original birth certificate + 5 digital copies.</p>
      </div>
      <div class=\"doc-card\">
        <p>Form 2 and 6 / Military status certificate (for male students).</p>
      </div>
      <div class=\"doc-card\">
        <p>6 recent personal photos (size 4×6) with the student’s name on them.</p>
      </div>
      <div class=\"doc-card\">
        <p>3 copies of the student’s national ID card.</p>
      </div>
      <div class=\"doc-card\">
        <p>3 copies of the guardian’s national ID card.</p>
      </div>
      <div class=\"doc-card\">
        <p>Copy of the payment receipt for tuition and file opening fees.</p>
      </div>
      <div class=\"doc-card\">
        <p>Black capsule plastic file folder.</p>
      </div>
    </div>
  </section>

  <div class=\"text-center\">
    <a href=\"{{ asset(\'Admissions.html\') }}\" class=\"back-btn\">Go to Admissions &raquo;</a>
  </div>

  <!-- Footer Start -->
            
           <!-- Footer End -->

  <!-- JavaScript Libraries -->
  <script src=\"https://code.jquery.com/jquery-3.4.1.min.js\"></script>
  <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js\"></script>
  <script src=\"{{ asset(\'lib/wow/wow.min.js\') }}\"></script>
  <script src=\"{{ asset(\'lib/easing/easing.min.js\') }}\"></script>
  <script src=\"{{ asset(\'lib/waypoints/waypoints.min.js\') }}\"></script>
  <script src=\"{{ asset(\'lib/owlcarousel/owl.carousel.min.js\') }}\"></script>

  <!-- Template Javascript -->
  <script src=\"{{ asset(\'js/main.js\') }}\"></script>', '1', '2026-04-07 02:20:51', '2026-04-07 02:20:51');

-- Data for table: page_sections (Page sections)
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', '2', 'faq', 'What is New Cairo Technological University (NCTU)?', 'It\'s a public technological university in Egypt that offers advanced applied education, focusing on linking studies directly to the job market.', NULL, '1', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', '2', 'faq', 'How is it different from regular universities?', 'Education here is more practical and hands-on. It prepares students directly for the job market and accepts students after high school or diploma.', NULL, '2', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', '2', 'faq', 'What majors or programs are available?', 'Programs vary by year, but usually include: Mechatronics, Information Technology, New and Renewable Energy, Prosthetics Technology, Control and Monitoring Systems, Equipment Operation and Maintenance Technology.', NULL, '3', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('4', '2', 'faq', 'How many years is the study program?', 'It\'s a 4-year program divided into two stages: First 2 years: Higher Technological Diploma, Last 2 years: Technological Bachelor\'s Degree (with certain conditions).', NULL, '4', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('5', '2', 'faq', 'Is the Technological Bachelor\'s degree recognized?', 'Yes, it is officially recognized by the Supreme Council of Universities and is equivalent to any bachelor\'s degree from other universities. You can also pursue postgraduate studies.', NULL, '5', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('6', '2', 'faq', 'Is there practical training?', 'Yes, practical training is a key part of the program and takes place both inside the university and at companies/factories.', NULL, '6', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('7', '2', 'faq', 'Is it part of the national admission system (Thanaweya Amma)?', 'Yes, the university is included in the national coordination system, and admission depends on the yearly minimum grade requirements.', NULL, '7', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('8', '2', 'faq', 'Does the university accept diploma holders?', 'Yes, it accepts graduates of technical diplomas (3 or 5-year systems) and technical institutes, but applicants must pass entrance exams.', NULL, '8', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('9', '2', 'faq', 'Is there on-campus housing?', 'Currently, there\'s no dormitory, but there are nearby housing options in areas like New Cairo or Katameya.', NULL, '9', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('10', '2', 'faq', 'Are there tuition fees?', 'Yes, there are fees. They\'re slightly higher than traditional public universities, but still much cheaper than private universities.', NULL, '10', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');
INSERT INTO `page_sections` (`id`, `page_id`, `section_key`, `section_title`, `section_content`, `section_image`, `section_order`, `is_active`, `created_at`, `updated_at`) VALUES ('11', '2', 'faq', 'What are the job opportunities after graduation from NCTU?', 'Graduates are qualified for technical and engineering-related jobs in both public and private sectors. The university focuses on practical skills, so students can work in industries like automation, IT, energy, manufacturing, or even start their own business.', NULL, '11', '1', '2026-04-07 01:05:34', '2026-04-07 01:05:34');

SET FOREIGN_KEY_CHECKS = 1;

-- End of export