/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: blog
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-5 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Technologie','technologie','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(2,'Tutoriels','tutoriels','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(3,'Lifestyle','lifestyle','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(4,'Voyages','voyages','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(5,'Cuisine','cuisine','2026-06-07 12:53:28','2026-06-07 12:53:28');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_post_id_foreign` (`post_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES
(1,1,2,NULL,'Article très complet, félicitations !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(2,1,3,1,'Oui, c\'est un sujet passionnant.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(3,2,3,NULL,'J\'attends avec impatience vos prochains articles.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(4,2,3,NULL,'Excellent article ! Merci pour le partage.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(5,2,3,4,'Merci pour ton retour !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(6,2,2,NULL,'J\'attends avec impatience vos prochains articles.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(7,2,2,NULL,'Article très complet, félicitations !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(8,2,3,7,'Merci pour ton commentaire !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(9,3,2,NULL,'C\'est exactement ce que je cherchais, merci !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(10,3,2,9,'Merci pour ton retour !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(11,3,4,NULL,'C\'est exactement ce que je cherchais, merci !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(12,3,3,11,'Je suis d\'accord avec toi !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(13,3,3,NULL,'Très bon article, bien écrit et instructif.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(14,4,4,NULL,'Super contenu, continuez comme ça !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(15,4,4,NULL,'Excellent article ! Merci pour le partage.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(16,4,3,NULL,'Super contenu, continuez comme ça !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(17,4,3,16,'Merci pour ton commentaire !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(18,4,3,NULL,'C\'est exactement ce que je cherchais, merci !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(19,5,4,NULL,'Excellent article ! Merci pour le partage.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(20,5,2,NULL,'Excellent article ! Merci pour le partage.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(21,5,2,20,'Je suis d\'accord avec toi !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(22,5,4,NULL,'Très bon article, bien écrit et instructif.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(23,5,2,NULL,'Très bon article, bien écrit et instructif.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(24,5,4,23,'Oui, c\'est un sujet passionnant.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(25,6,3,NULL,'Article très complet, félicitations !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(26,7,3,NULL,'C\'est exactement ce que je cherchais, merci !','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(27,7,3,NULL,'Merci pour ces explications claires et précises.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(28,7,4,NULL,'Merci pour ces explications claires et précises.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(29,8,3,NULL,'Excellent article ! Merci pour le partage.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(30,8,4,NULL,'Merci pour ces explications claires et précises.','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(31,8,2,30,'Oui, c\'est un sujet passionnant.','2026-06-07 12:53:28','2026-06-07 12:53:28');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `likes_user_id_post_id_unique` (`user_id`,`post_id`),
  KEY `likes_post_id_foreign` (`post_id`),
  CONSTRAINT `likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES
(1,2,1,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(2,4,1,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(3,2,2,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(4,3,2,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(5,2,3,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(6,4,3,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(7,3,4,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(8,4,4,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(9,2,5,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(10,3,5,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(11,2,6,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(12,3,6,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(13,4,6,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(14,2,7,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(15,3,7,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(16,3,8,'2026-06-07 12:53:28','2026-06-07 12:53:28'),
(17,4,8,'2026-06-07 12:53:28','2026-06-07 12:53:28');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_06_06_145224_create_categories_table',1),
(5,'2026_06_06_145225_create_posts_table',1),
(6,'2026_06_06_145226_create_likes_table',1),
(7,'2026_06_06_145227_create_comments_table',1),
(8,'2026_06_07_033203_add_image_to_posts_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_category_id_foreign` (`category_id`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES
(1,'Introduction à Laravel 11','introduction-a-laravel-11-6a2577d825034','images/php-blog.svg','Laravel 11 apporte de nombreuses améliorations et fonctionnalités. Dans cet article, nous allons explorer les principales nouveautés.\n\nLaravel continue d\'être le framework PHP le plus populaire grâce à son élégance et sa simplicité. Les développeurs apprécient particulièrement son système de routing, son ORM Eloquent, et son système de templates Blade.\n\nLes nouveautés de Laravel 11 incluent des améliorations de performances, une meilleure gestion des files d\'attente, et de nouveaux helpers utiles pour le développement quotidien.','Découvrez les nouveautés de Laravel 11 et comment elles peuvent améliorer vos projets.',1,1,'2026-05-25 12:53:28','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(2,'Les meilleures pratiques en PHP moderne','les-meilleures-pratiques-en-php-moderne-6a2577d82967e','images/tutoriel-blog.svg','PHP a beaucoup évolué ces dernières années. Voici les meilleures pratiques à adopter en 2026.\n\nL\'utilisation des types stricts, des attributs PHP 8+, et des fonctionnalités modernes comme les enums et les propriétés readonly permet d\'écrire du code plus robuste et maintenable.\n\nN\'oubliez pas d\'utiliser Composer pour gérer vos dépendances, PHPUnit pour vos tests, et PHPStan ou Psalm pour l\'analyse statique de votre code.','Guide complet des meilleures pratiques PHP pour écrire du code moderne et maintenable.',2,1,'2026-06-03 12:53:28','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(3,'Comment optimiser les performances de votre site','comment-optimiser-les-performances-de-votre-site-6a2577d82f231','images/web-blog.svg','Les performances web sont cruciales pour l\'expérience utilisateur. Voici comment optimiser votre site.\n\nCommencez par optimiser vos images en utilisant des formats modernes comme WebP. Minimisez vos fichiers CSS et JavaScript. Utilisez un CDN pour servir vos ressources statiques.\n\nN\'oubliez pas la mise en cache ! Laravel offre d\'excellents outils de cache que vous devriez utiliser pour améliorer les temps de chargement.','Astuces et techniques pour optimiser les performances de votre application web.',1,1,'2026-05-09 12:53:28','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(4,'Mon voyage au Japon','mon-voyage-au-japon-6a2577d833db7','images/lifestyle-blog.svg','Le Japon est un pays fascinant qui mélange tradition et modernité. Voici mon récit de voyage.\n\nDe Tokyo à Kyoto, en passant par Osaka, chaque ville a son charme unique. La nourriture est exceptionnelle, les gens sont accueillants, et la culture est riche.\n\nJe recommande de visiter les temples de Kyoto tôt le matin pour éviter la foule. Le Mont Fuji est également un incontournable si vous aimez la randonnée.','Récit de mon voyage inoubliable au pays du soleil levant.',4,1,'2026-05-10 12:53:28','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(5,'Recette : Tarte aux pommes maison','recette-tarte-aux-pommes-maison-6a2577d83a165','images/productivity-blog.svg','Rien de mieux qu\'une tarte aux pommes faite maison. Voici ma recette secrète !\n\nPour la pâte : 250g de farine, 125g de beurre, 1 œuf, une pincée de sel. Pour la garniture : 6 pommes, 100g de sucre, cannelle.\n\nPréchauffez le four à 180°C. Étalez la pâte dans un moule, disposez les pommes en tranches, saupoudrez de sucre et de cannelle. Enfournez 40 minutes. C\'est prêt !','La recette parfaite pour une tarte aux pommes croustillante et savoureuse.',5,1,'2026-06-01 12:53:28','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(6,'Guide complet de Git pour débutants','guide-complet-de-git-pour-debutants-6a2577d83f2a6','images/tutoriel-blog.svg','Git est un outil essentiel pour tout développeur. Ce guide vous apprendra les bases.\n\nCommencez par comprendre les concepts de commit, branch, et merge. Utilisez git init pour créer un nouveau dépôt, git add pour ajouter des fichiers, et git commit pour enregistrer vos changements.\n\nLes branches sont puissantes : créez une branche avec git branch, changez de branche avec git checkout, et fusionnez avec git merge.','Apprenez à maîtriser Git et le contrôle de version en quelques étapes simples.',2,1,'2026-05-25 12:53:28','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(7,'Minimalisme : vivre avec moins','minimalisme-vivre-avec-moins-6a2577d842266','images/lifestyle-blog.svg','Le minimalisme n\'est pas seulement une tendance, c\'est un mode de vie qui apporte sérénité et clarté.\n\nCommencez par désencombrer votre espace. Gardez seulement ce qui vous apporte de la joie ou est réellement utile. Un espace épuré aide à clarifier l\'esprit.\n\nLe minimalisme s\'applique aussi au numérique : désabonnez-vous des newsletters inutiles, supprimez les applications que vous n\'utilisez pas.','Découvrez comment le minimalisme peut transformer votre vie et vous apporter plus de bonheur.',3,1,'2026-06-03 12:53:28','2026-06-07 12:53:28','2026-06-07 12:53:28'),
(8,'Docker pour les développeurs PHP','docker-pour-les-developpeurs-php-6a2577d846bea','images/tech-blog.svg','Docker révolutionne la façon dont nous développons et déployons nos applications. Voici pourquoi.\n\nAvec Docker, vous pouvez créer des environnements de développement reproductibles. Plus de \'ça marche sur ma machine\' ! Utilisez docker-compose pour orchestrer plusieurs conteneurs.\n\nPour PHP, créez un Dockerfile avec PHP-FPM, Nginx, et MySQL. Vous aurez un environnement complet et isolé.','Maîtrisez Docker pour créer des environnements de développement modernes et efficaces.',2,1,'2026-05-14 12:53:28','2026-06-07 12:53:28','2026-06-07 12:53:28');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Admin Blog','admin@blog.com',NULL,'$2y$12$XiXZ8n9CQ5OS3ogeWHcxEOmhNeWxnc.jZUYkFzbk217nLl7Fy1ZfS',NULL,'2026-06-07 12:53:27','2026-06-07 12:53:27','admin'),
(2,'GBABLI Nahine','nahine@example.com',NULL,'$2y$12$XPYZye7eMrqw7n6GCnHH5e9uKDmH00h2gaHcxNokkQ09it6c6nkk6',NULL,'2026-06-07 12:53:27','2026-06-07 12:53:27','user'),
(3,'Sophie Leclerc','sophie@example.com',NULL,'$2y$12$YW/qCy0gCzahuIvwc3V9R.auI7tS0pej1fL4ZPgo/XEvVOgq.mC/S',NULL,'2026-06-07 12:53:27','2026-06-07 12:53:27','user'),
(4,'Lucas Bernard','lucas@example.com',NULL,'$2y$12$x3Dfwtni751mhmJjY4BuCeStY.7FpAMWkqVuFzzvJqPRy21aYfxpu',NULL,'2026-06-07 12:53:28','2026-06-07 12:53:28','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-07 15:56:15
