/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 10.4.28-MariaDB : Database - orca_odds
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`orca_odds` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `orca_odds`;

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `admin_access` longtext DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`name`,`username`,`email`,`password`,`image`,`phone`,`address`,`admin_access`,`last_login`,`status`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin','admin','admin@gmail.com','$2y$10$5QyKJcLo0H46lsWuwWSrmeBb8vt9cKYT0HBRq.BMslefmEs6fLkn2','64dd180ec0ccb1692211214.jpg','+5641 455646','TX, USA','[\"admin.dashboard\",\"admin.staff\",\"admin.storeStaff\",\"admin.updateStaff\",\"admin.identify-form\",\"admin.identify-form.store\",\"admin.identify-form.action\",\"admin.listCategory\",\"admin.listTournament\",\"admin.listTeam\",\"admin.listMatch\",\"admin.infoMatch\",\"admin.addQuestion\",\"admin.optionList\",\"admin.storeCategory\",\"admin.updateCategory\",\"admin.deleteCategory\",\"admin.storeTournament\",\"admin.storeTeam\",\"admin.storeMatch\",\"admin.storeQuestion\",\"admin.optionAdd\",\"admin.updateTournament\",\"admin.updateTeam\",\"admin.updateMatch\",\"admin.locker\",\"admin.updateQuestion\",\"admin.optionUpdate\",\"admin.deleteTournament\",\"admin.deleteTeam\",\"admin.deleteMatch\",\"admin.deleteQuestion\",\"admin.optionDelete\",\"admin.resultList.pending\",\"admin.resultList.complete\",\"admin.searchResult\",\"admin.resultWinner\",\"admin.betUser\",\"admin.makeWinner\",\"admin.refundQuestion\",\"admin.referral-commission\",\"admin.referral-commission.store\",\"admin.referral-commission.action\",\"admin.transaction\",\"admin.transaction.search\",\"admin.commissions\",\"admin.commissions.search\",\"admin.bet-history\",\"admin.searchBet\",\"admin.refundBet\",\"admin.users\",\"admin.users.search\",\"admin.email-send\",\"admin.user.transaction\",\"admin.user.fundLog\",\"admin.user.withdrawal\",\"admin.user.userKycHistory\",\"admin.kyc.users.pending\",\"admin.kyc.users\",\"admin.user-edit\",\"admin.user-multiple-active\",\"admin.user-multiple-inactive\",\"admin.send-email\",\"admin.user.userKycHistory\",\"admin.user-balance-update\",\"admin.payment.methods\",\"admin.deposit.manual.index\",\"admin.deposit.manual.create\",\"admin.edit.payment.methods\",\"admin.deposit.manual.edit\",\"admin.payment.pending\",\"admin.payment.log\",\"admin.payment.search\",\"admin.payment.action\",\"admin.payout-method\",\"admin.payout-log\",\"admin.payout-request\",\"admin.payout-log.search\",\"admin.payout-method.create\",\"admin.payout-method.edit\",\"admin.payout-action\",\"admin.ticket\",\"admin.ticket.view\",\"admin.ticket.reply\",\"admin.ticket.delete\",\"admin.subscriber.index\",\"admin.subscriber.sendEmail\",\"admin.subscriber.remove\",\"admin.basic-controls\",\"admin.email-controls\",\"admin.email-template.show\",\"admin.sms.config\",\"admin.sms-template\",\"admin.notify-config\",\"admin.notify-template.show\",\"admin.notify-template.edit\",\"admin.plugin.config\",\"admin.tawk.control\",\"admin.fb.messenger.control\",\"admin.google.recaptcha.control\",\"admin.google.analytics.control\",\"admin.basic-controls.update\",\"admin.email-controls.update\",\"admin.email-template.edit\",\"admin.sms-template.edit\",\"admin.notify-config.update\",\"admin.notify-template.update\",\"admin.language.index\",\"admin.language.create\",\"admin.language.edit\",\"admin.language.keywordEdit\",\"admin.language.delete\",\"admin.manage.theme\",\"admin.logo-seo\",\"admin.breadcrumb\",\"admin.template.show\",\"admin.content.index\",\"admin.content.create\",\"admin.logoUpdate\",\"admin.seoUpdate\",\"admin.breadcrumbUpdate\",\"admin.content.show\",\"admin.content.delete\"]','2023-08-17 08:47:34',1,'Te9F0uCKusNW8p7AGmLlJWHmG68zV5mPM0CZeV2Uu6MCFsJmB7QeH1hnO9sZ','2021-12-17 05:00:01','2023-08-17 08:47:34');

/*Table structure for table `bet_invest_logs` */

DROP TABLE IF EXISTS `bet_invest_logs`;

CREATE TABLE `bet_invest_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bet_invest_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `match_id` bigint(20) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `bet_option_id` bigint(20) unsigned NOT NULL,
  `ratio` varchar(30) DEFAULT NULL,
  `category_icon` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `tournament_name` varchar(191) DEFAULT NULL,
  `match_name` varchar(255) DEFAULT NULL,
  `question_name` varchar(191) DEFAULT NULL,
  `option_name` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'default=>0\r\nwin => 2,\r\nlose=> -2,\r\nrefund=3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bet_multis_bet_invest_id_foreign` (`bet_invest_id`),
  CONSTRAINT `bet_multis_bet_invest_id_foreign` FOREIGN KEY (`bet_invest_id`) REFERENCES `bet_invests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bet_invest_logs` */

insert  into `bet_invest_logs`(`id`,`bet_invest_id`,`user_id`,`match_id`,`question_id`,`bet_option_id`,`ratio`,`category_icon`,`category_name`,`tournament_name`,`match_name`,`question_name`,`option_name`,`status`,`created_at`,`updated_at`) values 
(1,1,1,4,6,6,'2','<i class=\"far fa-field-hockey\" aria-hidden=\"true\"></i>','Hockey','Asia Cup','Paris vs NFL','Who will win?','Yes',0,'2023-08-16 19:30:33','2023-08-16 19:30:33'),
(2,1,1,3,5,5,'1.5','<i class=\"far fa-cricket\" aria-hidden=\"true\"></i>','Cricket','Big Bash','Champion Soccer vs Fc Porto','Who will win?','Yes',0,'2023-08-16 19:30:33','2023-08-16 19:30:33'),
(3,1,1,1,3,3,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Real Madrid will win?','Yes',0,'2023-08-16 19:30:33','2023-08-16 19:30:33'),
(4,2,1,1,1,11,'3.5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','C.Ronaldo',0,'2023-08-16 19:30:42','2023-08-16 19:30:42'),
(5,3,1,5,8,8,'3','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Ac Milano will win?','Yes',0,'2023-08-16 19:30:55','2023-08-16 19:30:55'),
(6,3,1,1,1,1,'3','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Yes',0,'2023-08-16 19:30:55','2023-08-16 19:30:55'),
(7,4,1,3,5,5,'1.5','<i class=\"far fa-cricket\" aria-hidden=\"true\"></i>','Cricket','Big Bash','Champion Soccer vs Fc Porto','Who will win?','Yes',0,'2023-08-16 19:31:01','2023-08-16 19:31:01'),
(8,5,1,4,6,6,'2','<i class=\"far fa-field-hockey\" aria-hidden=\"true\"></i>','Hockey','Asia Cup','Paris vs NFL','Who will win?','Yes',0,'2023-08-16 19:52:02','2023-08-16 19:52:02'),
(9,6,1,4,6,6,'2','<i class=\"far fa-field-hockey\" aria-hidden=\"true\"></i>','Hockey','Asia Cup','Paris vs NFL','Who will win?','Yes',0,'2023-08-16 19:52:09','2023-08-16 19:52:09'),
(10,7,1,3,5,5,'1.5','<i class=\"far fa-cricket\" aria-hidden=\"true\"></i>','Cricket','Big Bash','Champion Soccer vs Fc Porto','Who will win?','Yes',0,'2023-08-16 19:52:14','2023-08-16 19:52:14'),
(11,8,1,5,8,8,'3','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Ac Milano will win?','Yes',0,'2023-08-16 19:52:21','2023-08-16 19:52:21'),
(12,9,1,5,9,9,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Atlentico M will win?','Yes',0,'2023-08-16 19:52:28','2023-08-16 19:52:28'),
(13,10,1,1,1,1,'3','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Yes',0,'2023-08-16 19:52:35','2023-08-16 19:52:35'),
(14,11,1,1,1,10,'2.5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Neymar',0,'2023-08-16 19:52:39','2023-08-16 19:52:39'),
(15,12,1,1,1,11,'3.5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','C.Ronaldo',0,'2023-08-16 19:52:44','2023-08-16 19:52:44'),
(16,13,1,1,1,12,'2.5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Bengzema',0,'2023-08-16 19:52:48','2023-08-16 19:52:48'),
(17,14,1,1,2,2,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Barcelona will win?','Yes',0,'2023-08-16 19:52:53','2023-08-16 19:52:53'),
(18,15,1,1,3,3,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Real Madrid will win?','Yes',0,'2023-08-16 19:52:57','2023-08-16 19:52:57'),
(19,16,1,5,9,9,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Atlentico M will win?','Yes',0,'2023-08-16 19:53:10','2023-08-16 19:53:10'),
(20,17,1,5,8,8,'3','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Ac Milano will win?','Yes',0,'2023-08-16 19:53:15','2023-08-16 19:53:15'),
(21,18,1,1,1,11,'3.5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','C.Ronaldo',0,'2023-08-16 19:53:36','2023-08-16 19:53:36'),
(22,19,1,1,1,12,'2.5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Bengzema',0,'2023-08-16 19:53:44','2023-08-16 19:53:44'),
(23,20,1,1,2,2,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Barcelona will win?','Yes',0,'2023-08-16 19:53:52','2023-08-16 19:53:52'),
(24,21,1,1,3,3,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Real Madrid will win?','Yes',0,'2023-08-16 19:53:58','2023-08-16 19:53:58'),
(25,22,1,1,1,1,'5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Messi',0,'2023-08-16 19:54:44','2023-08-16 19:54:44'),
(26,23,1,4,6,6,'2','<i class=\"far fa-field-hockey\" aria-hidden=\"true\"></i>','Hockey','Asia Cup','Paris vs NFL','Who will win?','Yes',0,'2023-08-16 20:48:35','2023-08-16 20:48:35'),
(27,23,1,3,5,5,'1.5','<i class=\"far fa-cricket\" aria-hidden=\"true\"></i>','Cricket','Big Bash','Champion Soccer vs Fc Porto','Who will win?','Yes',0,'2023-08-16 20:48:35','2023-08-16 20:48:35'),
(28,24,1,1,1,10,'2.5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Neymar',0,'2023-08-16 20:58:33','2023-08-16 20:58:33'),
(29,25,2,4,6,6,'2','<i class=\"far fa-field-hockey\" aria-hidden=\"true\"></i>','Hockey','Asia Cup','Paris vs NFL','Who will win?','Yes',0,'2023-08-17 08:28:29','2023-08-17 08:28:29'),
(30,25,2,3,5,5,'1.5','<i class=\"far fa-cricket\" aria-hidden=\"true\"></i>','Cricket','Big Bash','Champion Soccer vs Fc Porto','Who will win?','Yes',0,'2023-08-17 08:28:29','2023-08-17 08:28:29'),
(31,26,2,3,5,5,'1.5','<i class=\"far fa-cricket\" aria-hidden=\"true\"></i>','Cricket','Big Bash','Champion Soccer vs Fc Porto','Who will win?','Yes',0,'2023-08-17 08:28:35','2023-08-17 08:28:35'),
(32,27,2,5,8,8,'3','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Ac Milano will win?','Yes',0,'2023-08-17 08:28:46','2023-08-17 08:28:46'),
(33,28,2,5,9,9,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Atlentico M will win?','Yes',0,'2023-08-17 08:28:52','2023-08-17 08:28:52'),
(34,29,2,5,9,9,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Atlentico M will win?','Yes',0,'2023-08-17 08:29:10','2023-08-17 08:29:10'),
(35,30,2,5,8,8,'3','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','UFFA','Ac-Milano vs Atlentico Madrid','Ac Milano will win?','Yes',0,'2023-08-17 08:29:16','2023-08-17 08:29:16'),
(36,31,2,1,1,1,'5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Messi',0,'2023-08-17 08:29:40','2023-08-17 08:29:40'),
(37,32,2,1,2,2,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Barcelona will win?','Yes',0,'2023-08-17 08:29:46','2023-08-17 08:29:46'),
(38,33,2,1,3,3,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Real Madrid will win?','Yes',0,'2023-08-17 08:29:53','2023-08-17 08:29:53'),
(39,34,2,1,1,1,'5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','Messi',0,'2023-08-17 08:30:07','2023-08-17 08:30:07'),
(40,35,2,1,1,11,'3.5','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Who will win?','C.Ronaldo',0,'2023-08-17 08:30:14','2023-08-17 08:30:14'),
(41,36,2,1,2,2,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Barcelona will win?','Yes',0,'2023-08-17 08:30:19','2023-08-17 08:30:19'),
(42,37,2,1,3,3,'2','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>','Football','World Cup','Barcelona vs Real Madrid','Real Madrid will win?','Yes',0,'2023-08-17 08:30:24','2023-08-17 08:30:24');

/*Table structure for table `bet_invests` */

DROP TABLE IF EXISTS `bet_invests`;

CREATE TABLE `bet_invests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(30) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `creator_id` bigint(20) unsigned DEFAULT NULL,
  `invest_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `return_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `charge` decimal(8,2) NOT NULL DEFAULT 0.00,
  `remaining_balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `ratio` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'default 0, win 1, lose -1, refund 2',
  `isMultiBet` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bet_invests` */

insert  into `bet_invests`(`id`,`transaction_id`,`user_id`,`creator_id`,`invest_amount`,`return_amount`,`charge`,`remaining_balance`,`ratio`,`status`,`isMultiBet`,`created_at`,`updated_at`) values 
(1,'MV5CCH2M4B8Q',1,NULL,10.00,60.00,0.00,9990.00,'6',0,1,'2023-08-16 19:30:33','2023-08-16 19:30:33'),
(2,'8O2FZ79D262B',1,NULL,253.00,885.50,0.00,9737.00,'3.5',0,0,'2023-08-16 19:30:42','2023-08-16 19:30:42'),
(3,'9FHUEFS65O5N',1,NULL,300.00,2700.00,0.00,9437.00,'9',0,1,'2023-08-16 19:30:55','2023-08-16 19:30:55'),
(4,'PHQYBCYMXJ5R',1,NULL,478.00,717.00,0.00,8959.00,'1.5',0,0,'2023-08-16 19:31:01','2023-08-16 19:31:01'),
(5,'EJN5Z5WSOGZ6',1,NULL,1231.00,2462.00,0.00,117728.00,'2',0,0,'2023-08-16 19:52:02','2023-08-16 19:52:02'),
(6,'DZH3M5R4DEUF',1,NULL,567.00,1134.00,0.00,117161.00,'2',0,0,'2023-08-16 19:52:09','2023-08-16 19:52:09'),
(7,'1Y3QWXPCKNUQ',1,NULL,4567.00,6850.50,0.00,112594.00,'1.5',0,0,'2023-08-16 19:52:14','2023-08-16 19:52:14'),
(8,'18Y282YP18A1',1,NULL,3421.00,10263.00,0.00,109173.00,'3',0,0,'2023-08-16 19:52:21','2023-08-16 19:52:21'),
(9,'RZR5FJK36ZSZ',1,NULL,232.00,464.00,0.00,108941.00,'2',0,0,'2023-08-16 19:52:28','2023-08-16 19:52:28'),
(10,'A9AGTH7Y6OYK',1,NULL,500.00,1500.00,0.00,108441.00,'3',0,0,'2023-08-16 19:52:35','2023-08-16 19:52:35'),
(11,'K7W26RH1PPJM',1,NULL,700.00,1750.00,0.00,107741.00,'2.5',0,0,'2023-08-16 19:52:39','2023-08-16 19:52:39'),
(12,'HBZFBXGNYKMA',1,NULL,5000.00,17500.00,0.00,102741.00,'3.5',0,0,'2023-08-16 19:52:44','2023-08-16 19:52:44'),
(13,'95XCQUFQAATH',1,NULL,4200.00,10500.00,0.00,98541.00,'2.5',0,0,'2023-08-16 19:52:48','2023-08-16 19:52:48'),
(14,'19XKE684XPKP',1,NULL,8000.00,16000.00,0.00,90541.00,'2',0,0,'2023-08-16 19:52:53','2023-08-16 19:52:53'),
(15,'BE2Q4S5HO59F',1,NULL,7000.00,14000.00,0.00,83541.00,'2',0,0,'2023-08-16 19:52:57','2023-08-16 19:52:57'),
(16,'EAKV1RCJRZ7B',1,NULL,7000.00,14000.00,0.00,76541.00,'2',0,0,'2023-08-16 19:53:10','2023-08-16 19:53:10'),
(17,'N6386BOD5XUE',1,NULL,5000.00,15000.00,0.00,71541.00,'3',0,0,'2023-08-16 19:53:15','2023-08-16 19:53:15'),
(18,'G4M789GXA7XT',1,NULL,10000.00,35000.00,0.00,61541.00,'3.5',0,0,'2023-08-16 19:53:36','2023-08-16 19:53:36'),
(19,'DJBPBK956NBJ',1,NULL,5000.00,12500.00,0.00,56541.00,'2.5',0,0,'2023-08-16 19:53:44','2023-08-16 19:53:44'),
(20,'YXW5NZJTBAE7',1,NULL,20000.00,40000.00,0.00,36541.00,'2',0,0,'2023-08-16 19:53:52','2023-08-16 19:53:52'),
(21,'GBRHSYUQ7BYK',1,NULL,300.00,600.00,0.00,36241.00,'2',0,0,'2023-08-16 19:53:58','2023-08-16 19:53:58'),
(22,'MBYV4Q427GN8',1,NULL,30000.00,150000.00,0.00,6241.00,'5',0,0,'2023-08-16 19:54:44','2023-08-16 19:54:44'),
(23,'TMK4JAS42NTY',1,NULL,600.00,1800.00,0.00,5641.00,'3',0,1,'2023-08-16 20:48:35','2023-08-16 20:48:35'),
(24,'9ONKHFNONJS1',1,NULL,5000.00,12500.00,0.00,641.00,'2.5',0,0,'2023-08-16 20:58:33','2023-08-16 20:58:33'),
(25,'G7PAC9GFWUAT',2,NULL,100.00,300.00,0.00,9900.00,'3',0,1,'2023-08-17 08:28:29','2023-08-17 08:28:29'),
(26,'D7WPK4YWCSFP',2,NULL,600.00,900.00,0.00,9300.00,'1.5',0,0,'2023-08-17 08:28:35','2023-08-17 08:28:35'),
(27,'3BKVJZ3XX252',2,NULL,500.00,1500.00,0.00,8800.00,'3',0,0,'2023-08-17 08:28:46','2023-08-17 08:28:46'),
(28,'C7ZQZOHMD4FT',2,NULL,550.00,1100.00,0.00,8250.00,'2',0,0,'2023-08-17 08:28:52','2023-08-17 08:28:52'),
(29,'B21KXZ22KRSZ',2,NULL,250.00,500.00,0.00,8000.00,'2',0,0,'2023-08-17 08:29:10','2023-08-17 08:29:10'),
(30,'NPQCVBQAAS2Y',2,NULL,700.00,2100.00,0.00,7300.00,'3',0,0,'2023-08-17 08:29:16','2023-08-17 08:29:16'),
(31,'85D345T3U28U',2,NULL,100.00,500.00,0.00,7200.00,'5',0,0,'2023-08-17 08:29:40','2023-08-17 08:29:40'),
(32,'ZON794A46HDO',2,NULL,620.00,1240.00,0.00,6580.00,'2',0,0,'2023-08-17 08:29:46','2023-08-17 08:29:46'),
(33,'T721FUGFM2RP',2,NULL,400.00,800.00,0.00,6180.00,'2',0,0,'2023-08-17 08:29:53','2023-08-17 08:29:53'),
(34,'G9G7KD1G8NOO',2,NULL,700.00,3500.00,0.00,5480.00,'5',0,0,'2023-08-17 08:30:07','2023-08-17 08:30:07'),
(35,'KF1WAQBBPVCO',2,NULL,1000.00,3500.00,0.00,4480.00,'3.5',0,0,'2023-08-17 08:30:14','2023-08-17 08:30:14'),
(36,'N1V126Q248MC',2,NULL,200.00,400.00,0.00,4280.00,'2',0,0,'2023-08-17 08:30:19','2023-08-17 08:30:19'),
(37,'24VANOGMKU8T',2,NULL,500.00,1000.00,0.00,3780.00,'2',0,0,'2023-08-17 08:30:24','2023-08-17 08:30:24');

/*Table structure for table `configures` */

DROP TABLE IF EXISTS `configures`;

CREATE TABLE `configures` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_title` varchar(20) DEFAULT NULL,
  `base_color` varchar(10) NOT NULL DEFAULT '',
  `time_zone` varchar(30) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `currency_symbol` varchar(20) DEFAULT NULL,
  `theme` varchar(60) DEFAULT NULL,
  `theme_mode` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=> light, 0 => Dark',
  `fraction_number` int(11) DEFAULT NULL,
  `paginate` int(11) DEFAULT NULL,
  `email_verification` tinyint(1) NOT NULL DEFAULT 0,
  `email_notification` tinyint(1) NOT NULL DEFAULT 0,
  `sms_verification` tinyint(1) NOT NULL DEFAULT 0,
  `sms_notification` tinyint(1) NOT NULL DEFAULT 0,
  `sender_email` varchar(60) DEFAULT NULL,
  `sender_email_name` varchar(91) DEFAULT NULL,
  `email_description` longtext DEFAULT NULL,
  `email_configuration` text DEFAULT NULL,
  `push_notification` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `error_log` tinyint(1) NOT NULL,
  `strong_password` tinyint(1) NOT NULL,
  `registration` tinyint(1) NOT NULL,
  `address_verification` tinyint(1) NOT NULL,
  `identity_verification` tinyint(1) NOT NULL,
  `maintenance` tinyint(1) NOT NULL,
  `is_active_cron_notification` tinyint(1) NOT NULL DEFAULT 0,
  `tawk_id` varchar(191) DEFAULT NULL,
  `tawk_status` tinyint(4) NOT NULL DEFAULT 1,
  `fb_messenger_status` tinyint(4) NOT NULL DEFAULT 1,
  `fb_app_id` varchar(191) DEFAULT NULL,
  `fb_page_id` varchar(191) DEFAULT NULL,
  `reCaptcha_status_login` tinyint(4) NOT NULL DEFAULT 1,
  `reCaptcha_status_registration` tinyint(4) NOT NULL DEFAULT 1,
  `MEASUREMENT_ID` varchar(255) DEFAULT NULL,
  `analytic_status` tinyint(4) NOT NULL DEFAULT 1,
  `refund_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `win_charge` decimal(11,2) NOT NULL DEFAULT 0.00,
  `minimum_bet` decimal(11,2) NOT NULL DEFAULT 10.00,
  `deposit_commission` tinyint(1) NOT NULL DEFAULT 0,
  `bet_commission` tinyint(1) NOT NULL DEFAULT 0,
  `bet_win_commission` tinyint(1) NOT NULL DEFAULT 0,
  `currency_layer_access_key` varchar(255) DEFAULT NULL,
  `currency_layer_auto_update` tinyint(4) NOT NULL DEFAULT 0,
  `currency_layer_auto_update_at` varchar(255) DEFAULT NULL,
  `coin_market_cap_app_key` varchar(255) DEFAULT NULL,
  `coin_market_cap_auto_update` tinyint(4) NOT NULL DEFAULT 0,
  `coin_market_cap_auto_update_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `configures` */

insert  into `configures`(`id`,`site_title`,`base_color`,`time_zone`,`currency`,`currency_symbol`,`theme`,`theme_mode`,`fraction_number`,`paginate`,`email_verification`,`email_notification`,`sms_verification`,`sms_notification`,`sender_email`,`sender_email_name`,`email_description`,`email_configuration`,`push_notification`,`created_at`,`updated_at`,`error_log`,`strong_password`,`registration`,`address_verification`,`identity_verification`,`maintenance`,`is_active_cron_notification`,`tawk_id`,`tawk_status`,`fb_messenger_status`,`fb_app_id`,`fb_page_id`,`reCaptcha_status_login`,`reCaptcha_status_registration`,`MEASUREMENT_ID`,`analytic_status`,`refund_charge`,`win_charge`,`minimum_bet`,`deposit_commission`,`bet_commission`,`bet_win_commission`,`currency_layer_access_key`,`currency_layer_auto_update`,`currency_layer_auto_update_at`,`coin_market_cap_app_key`,`coin_market_cap_auto_update`,`coin_market_cap_auto_update_at`) values 
(1,'Orca Odds','#99d260','UTC','USD','$','betting',0,0,20,0,0,0,0,'support@mail.com','Bug Finder','<h1>\r\n                            </h1><h1></h1><p style=\"font-style:normal;font-weight:normal;color:rgb(68,168,199);font-size:36px;font-family:bitter, georgia, serif;text-align:center;\"> <br /></p>\r\n                        \r\n\r\n                        \r\n\r\n                            <p><strong>Hello [[name]],</strong></p>\r\n                            <p><strong>[[message]]</strong></p>\r\n                            <p><br /></p>\r\n                        \r\n\r\n                    \r\n                \r\n            \r\n\r\n            \r\n                \r\n                    \r\n                        <p style=\"font-style:normal;font-weight:normal;color:#ffffff;font-size:16px;font-family:bitter, georgia, serif;text-align:center;\">\r\n                            2021 ©  All Right Reserved\r\n                        </p>','{\"name\":\"smtp\",\"smtp_host\":\"smtp.mailtrap.io\",\"smtp_port\":\"2525\",\"smtp_encryption\":\"ssl\",\"smtp_username\":\"b75b1a5bfa5d58\",\"smtp_password\":\"f89fbe0495a7fc\"}',1,NULL,'2023-08-17 09:00:30',0,1,1,0,0,0,1,'58dd135ef7bbaa72709c3470/default',1,1,NULL,NULL,0,0,NULL,1,5.00,0.00,5.00,0,0,0,NULL,0,NULL,NULL,0,NULL);

/*Table structure for table `content_details` */

DROP TABLE IF EXISTS `content_details`;

CREATE TABLE `content_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) unsigned DEFAULT NULL,
  `language_id` int(11) unsigned DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_details_content_id_foreign` (`content_id`),
  KEY `content_details_language_id_foreign` (`language_id`),
  CONSTRAINT `content_details_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`),
  CONSTRAINT `content_details_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=267 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `content_details` */

insert  into `content_details`(`id`,`content_id`,`language_id`,`description`,`created_at`,`updated_at`) values 
(225,83,1,'{\"name\":\"selena gomez\",\"designation\":\"Director, BAT\",\"description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius voluptas distinctio hic commodi itaque aperiam aliquam ullam adipisci laborum eum.\"}','2022-08-31 03:05:14','2022-08-31 03:05:14'),
(226,84,1,'{\"name\":\"selena gomez\",\"designation\":\"Director, BAT\",\"description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius voluptas distinctio hic commodi itaque aperiam aliquam ullam adipisci laborum eum.\"}','2022-08-31 03:05:52','2022-08-31 03:05:52'),
(227,85,1,'{\"name\":\"selena gomez\",\"designation\":\"Director, BAT\",\"description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius voluptas distinctio hic commodi itaque aperiam aliquam ullam adipisci laborum eum.\"}','2022-08-31 03:06:20','2022-08-31 03:06:20'),
(228,86,1,'{\"title\":\"What is Partial status?\",\"description\":\"Partial Status is when we partially refund the remains of an order. Sometimes for some reasons we are unable to deliver a full order, so we refund you the remaining undelivered amount. Example: You bought an order with quantity 10 000 and charges 10$, let\'s say we delivered 9 000 and the remaining 1 000 we couldn\'t deliver, then we will \\\"Partial\\\" the order and refund you the remaining 1000 (1$ in this example.\"}','2022-08-31 03:19:51','2022-08-31 03:19:51'),
(229,87,1,'{\"title\":\"What is Drip Feed?\",\"description\":\"Drip Feed is a service that we are offering so you would be able to put the same order multiple times automatically. Example: let\'s say you want to get 1000 likes on your Instagram Post but you want to get 100 likes each 30 minutes, you will put Link: Your Post Link Quantity: 100 Runs: 10 (as you want to run this order 10 times, if you want to get 2000 likes, you will run it 20 times, etc\\u2026) Interval: 30 (because you want to get 100 likes on your post each 30 minutes, if you want each hour, you will put 60 because the time is in minutes) P.S: Never order more quantity than the maximum which is written on the service name (Quantity x Runs), Example if the service\'s max is 4000, you don\\u2019t put Quantity: 500 and Run: 10, because total quantity will be 500x10 = 5000 which is bigger than the service max (4000). Also never put the Interval below the actual start time (some services need 60 minutes to start, don\\u2019t put Interval less than the service start time or it will cause a fail in your order\"}','2022-08-31 03:22:10','2022-08-31 03:22:10'),
(234,92,1,'{\"title\":\"Learn about UI8 coin and earn an All-Access Pass\",\"description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt quas, asperiores sed itaque officiis quae est nulla dolores voluptatem accusantium quisquam tempore quasi, nihil totam perspiciatis! Dicta nesciunt suscipit maxime. Alias pariatur eum fuga corporis aperiam sit.\"}','2022-08-31 03:56:45','2022-08-31 03:56:45'),
(237,95,1,'{\"title\":\"Terms &amp; Conditions\",\"description\":\"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy.\\u00a0\"}','2022-08-31 20:03:53','2023-08-16 19:47:54'),
(239,97,1,'{\"name\":\"facebook\"}','2022-08-31 20:39:36','2022-08-31 20:39:36'),
(240,98,1,'{\"name\":\"twitter\"}','2022-08-31 20:40:39','2022-08-31 20:40:39'),
(241,99,1,'{\"name\":\"linkein\"}','2022-08-31 20:41:48','2022-08-31 20:41:48'),
(242,100,1,'{\"name\":\"Football\",\"short_description\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit.Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit unde.\",\"button_name\":\"place a bet\"}','2022-09-15 03:01:00','2022-09-15 03:01:00'),
(243,101,1,'{\"name\":\"Cricket\",\"short_description\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit unde.\",\"button_name\":\"find out more\"}','2022-09-15 03:02:31','2022-09-15 03:02:31'),
(244,102,1,'{\"name\":\"Casino\",\"short_description\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit.Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit unde.\",\"button_name\":\"play now\"}','2022-09-15 03:03:45','2022-09-15 03:03:45'),
(245,100,18,'{\"name\":\"F\\u00fatbol\",\"short_description\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit.Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit unde.\",\"button_name\":\"hacer una apuesta\"}','2022-09-18 01:01:39','2022-09-18 01:01:39'),
(246,101,18,'{\"name\":\"Grillo\",\"short_description\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit unde.\",\"button_name\":\"Saber m\\u00e1s\"}','2022-09-18 01:02:31','2022-09-18 01:02:31'),
(247,102,18,'{\"name\":\"Casino\",\"short_description\":\"Lorem ipsum, dolor sit amet consectetur adipisicing elit.Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit unde.\",\"button_name\":\"reproducir ahora\"}','2022-09-18 01:03:22','2022-09-18 01:03:22'),
(248,83,18,'{\"name\":\"selena gomez\",\"designation\":\"Director, BAT\",\"description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius voluptas distinctio hic commodi itaque aperiam aliquam ullam adipisci laborum eum.\"}','2022-09-18 01:08:03','2022-09-18 01:08:03'),
(249,84,18,'{\"name\":\"selena gomez\",\"designation\":\"Director, BAT\",\"description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius voluptas distinctio hic commodi itaque aperiam aliquam ullam adipisci laborum eum.\"}','2022-09-18 01:08:30','2022-09-18 01:08:30'),
(250,85,18,'{\"name\":\"selena gomez\",\"designation\":\"Director, BAT\",\"description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius voluptas distinctio hic commodi itaque aperiam aliquam ullam adipisci laborum eum.\"}','2022-09-18 01:08:59','2022-09-18 01:08:59'),
(251,86,18,'{\"title\":\"Qu\\u00e9 es el estado parcial?\",\"description\":\"Partial Status is when we partially refund the remains of an order. Sometimes for some reasons we are unable to deliver a full order, so we refund you the remaining undelivered amount. Example: You bought an order with quantity 10 000 and charges 10$, let\'s say we delivered 9 000 and the remaining 1 000 we couldn\'t deliver, then we will \\\"Partial\\\" the order and refund you the remaining 1000 (1$ in this example.\"}','2022-09-18 01:09:35','2022-09-18 01:09:35'),
(252,87,18,'{\"title\":\"Qu\\u00e9 es la alimentaci\\u00f3n por goteo?\",\"description\":\"Drip Feed is a service that we are offering so you would be able to put the same order multiple times automatically. Example: let\'s say you want to get 1000 likes on your Instagram Post but you want to get 100 likes each 30 minutes, you will put Link: Your Post Link Quantity: 100 Runs: 10 (as you want to run this order 10 times, if you want to get 2000 likes, you will run it 20 times, etc\\u2026) Interval: 30 (because you want to get 100 likes on your post each 30 minutes, if you want each hour, you will put 60 because the time is in minutes) P.S: Never order more quantity than the maximum which is written on the service name (Quantity x Runs), Example if the service\'s max is 4000, you don\\u2019t put Quantity: 500 and Run: 10, because total quantity will be 500x10 = 5000 which is bigger than the service max (4000). Also never put the Interval below the actual start time (some services need 60 minutes to start, don\\u2019t put Interval less than the service start time or it will cause a fail in your order\"}','2022-09-18 01:10:01','2022-09-18 01:10:01'),
(257,92,18,'{\"title\":\"Aprenda sobre la moneda UI8 y gane un pase de acceso completo\",\"description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt quas, asperiores sed itaque officiis quae est nulla dolores voluptatem accusantium quisquam tempore quasi, nihil totam perspiciatis! Dicta nesciunt suscipit maxime. Alias pariatur eum fuga corporis aperiam sit.\"}','2022-09-18 01:13:55','2022-09-18 01:13:55'),
(260,97,18,'{\"name\":\"facebook\"}','2022-09-18 01:15:21','2022-09-18 01:15:21'),
(261,98,18,'{\"name\":\"gorjeo\"}','2022-09-18 01:15:37','2022-09-18 01:15:37'),
(262,99,18,'{\"name\":\"linkein\"}','2022-09-18 01:15:45','2022-09-18 01:15:45'),
(263,95,18,'{\"title\":\"T\\u00e9rminos y condiciones\",\"description\":\"It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose injected humour and the like\"}','2022-09-18 01:16:14','2022-09-18 01:16:14'),
(265,103,1,'{\"name\":\"youtube\"}','2023-08-16 19:47:17','2023-08-16 19:47:17'),
(266,104,1,'{\"name\":\"instagram\"}','2023-08-16 19:47:25','2023-08-16 19:47:25');

/*Table structure for table `content_media` */

DROP TABLE IF EXISTS `content_media`;

CREATE TABLE `content_media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) unsigned DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_media_content_id_foreign` (`content_id`),
  CONSTRAINT `content_media_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `content_media` */

insert  into `content_media`(`id`,`content_id`,`description`,`created_at`,`updated_at`) values 
(60,83,'{\"image\":\"64dd275d5fde11692215133.jpg\"}','2022-08-31 03:05:14','2023-08-16 19:45:33'),
(61,84,'{\"image\":\"64dd276ae7dfe1692215146.jpg\"}','2022-08-31 03:05:53','2023-08-16 19:45:46'),
(62,85,'{\"image\":\"64dd27852f7021692215173.jpg\"}','2022-08-31 03:06:20','2023-08-16 19:46:13'),
(63,92,'{\"image\":\"630f689d875941661954205.jpg\"}','2022-08-31 03:56:45','2022-08-31 03:56:45'),
(66,97,'{\"link\":\"https:\\/\\/www.facebook.com\\/\",\"icon\":\"fab fa-facebook\"}','2022-08-31 20:39:36','2022-08-31 20:39:36'),
(67,98,'{\"link\":\"https:\\/\\/twitter.com\\/\",\"icon\":\"fab fa-twitter\"}','2022-08-31 20:40:39','2022-08-31 20:40:39'),
(68,99,'{\"link\":\"https:\\/\\/www.linkedin.com\\/\",\"icon\":\"fab fa-linkedin\"}','2022-08-31 20:41:48','2022-08-31 20:41:48'),
(69,100,'{\"image\":\"6323220cbcb231663246860.jpg\",\"button_link\":\"http:\\/\\/home\"}','2022-09-15 03:01:01','2023-08-16 20:00:58'),
(70,101,'{\"image\":\"63232267df3401663246951.jpg\",\"button_link\":\"http:\\/\\/home\"}','2022-09-15 03:02:32','2023-08-16 20:01:10'),
(71,102,'{\"image\":\"632322b1c7bcb1663247025.jpg\",\"button_link\":\"http:\\/\\/home\"}','2022-09-15 03:03:45','2023-08-16 20:01:19'),
(72,103,'{\"link\":\"https:\\/\\/embed\\/www.youtube.com\",\"icon\":\"embed\\/fab fa-youtube\"}','2023-08-16 19:47:17','2023-08-16 19:47:17'),
(73,104,'{\"link\":\"https:\\/\\/www.instagram.com\\/\",\"icon\":\"fab fa-instagram\"}','2023-08-16 19:47:25','2023-08-16 19:47:25');

/*Table structure for table `contents` */

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contents_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `contents` */

insert  into `contents`(`id`,`name`,`created_at`,`updated_at`) values 
(83,'testimonial','2022-08-31 03:05:14','2022-08-31 03:05:14'),
(84,'testimonial','2022-08-31 03:05:52','2022-08-31 03:05:52'),
(85,'testimonial','2022-08-31 03:06:20','2022-08-31 03:06:20'),
(86,'faq','2022-08-31 03:19:51','2022-08-31 03:19:51'),
(87,'faq','2022-08-31 03:22:10','2022-08-31 03:22:10'),
(92,'blog','2022-08-31 03:56:45','2022-08-31 03:56:45'),
(95,'support','2022-08-31 20:03:53','2022-08-31 20:03:53'),
(97,'social','2022-08-31 20:39:36','2022-08-31 20:39:36'),
(98,'social','2022-08-31 20:40:39','2022-08-31 20:40:39'),
(99,'social','2022-08-31 20:41:48','2022-08-31 20:41:48'),
(100,'slider','2022-09-15 03:01:00','2022-09-15 03:01:00'),
(101,'slider','2022-09-15 03:02:31','2022-09-15 03:02:31'),
(102,'slider','2022-09-15 03:03:45','2022-09-15 03:03:45'),
(103,'social','2023-08-16 19:47:17','2023-08-16 19:47:17'),
(104,'social','2023-08-16 19:47:25','2023-08-16 19:47:25');

/*Table structure for table `email_templates` */

DROP TABLE IF EXISTS `email_templates`;

CREATE TABLE `email_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) unsigned DEFAULT NULL,
  `template_key` varchar(120) DEFAULT NULL,
  `email_from` varchar(191) DEFAULT 'support@exampl.com',
  `name` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `template` text DEFAULT NULL,
  `sms_body` text DEFAULT NULL,
  `short_keys` text DEFAULT NULL,
  `mail_status` tinyint(1) NOT NULL DEFAULT 0,
  `sms_status` tinyint(1) NOT NULL DEFAULT 0,
  `lang_code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_templates_language_id_foreign` (`language_id`),
  CONSTRAINT `email_templates_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `email_templates` */

insert  into `email_templates`(`id`,`language_id`,`template_key`,`email_from`,`name`,`subject`,`template`,`sms_body`,`short_keys`,`mail_status`,`sms_status`,`lang_code`,`created_at`,`updated_at`) values 
(1,1,'PROFILE_UPDATE','support@mail.com','Profile has been updated','Profile has been updated','Your first name [[firstname]]\r\n\r\nlast name [[lastname]]\r\n\r\nemail [[email]]\r\n\r\nphone number [[phone]]\r\n','Your first name [[firstname]]\r\n\r\nlast name [[lastname]]\r\n\r\nemail [[email]]\r\n\r\nphone number [[phone]]\r\n','{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(2,1,'ADMIN_SUPPORT_REPLY','support@mail.com','Support Ticket Reply ','Support Ticket Reply','<p>Ticket ID [[ticket_id]]\r\n</p><p><span><br /></span></p><p><span>Subject [[ticket_subject]]\r\n</span></p><p><span>-----Replied------</span></p><p><span>\r\n[[reply]]</span><br /></p>','Ticket ID [[ticket_id]]\r\n\r\n\r\n\r\nSubject [[ticket_subject]]\r\n\r\n-----Replied------\r\n\r\n[[reply]]','{\"ticket_id\":\"Support Ticket ID\",\"ticket_subject\":\"Subject Of Support Ticket\",\"reply\":\"Reply from Staff\\/Admin\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(3,1,'PASSWORD_CHANGED','support@mail.com','PASSWORD CHANGED ','Your password changed ','Your password changed \r\n\r\nNew password [[password]]\r\n\r\n','Your password changed\r\n\r\nNew password [[password]]\r\n\r\n\r\nNews [[test]]','{\"password\":\"password\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(4,1,'ADD_BALANCE','support@mail.com','Balance Add by Admin','Your Account has been credited','[[amount]] [[currency]] credited in your account.\r\n\r\nYour Current Balance [[main_balance]][[currency]]\r\n\r\nTransaction: #[[transaction]]','[[amount]] [[currency]] credited in your account. \r\n\r\n\r\nYour Current Balance [[main_balance]][[currency]]\r\n\r\nTransaction: #[[transaction]]','{\"transaction\":\"Transaction Number\",\"amount\":\"Request Amount By Admin\",\"currency\":\"Site Currency\", \"main_balance\":\"Users Balance After this operation\"}',0,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(6,1,'DEDUCTED_BALANCE','support@mail.com','Balance deducted by Admin','Your Account has been debited','[[amount]] [[currency]] debited in your account.\r\n\r\nYour Current Balance [[main_balance]][[currency]]\r\n\r\nTransaction: #[[transaction]]','[[amount]] [[currency]] debited in your account.\r\n\r\nYour Current Balance [[main_balance]][[currency]]\r\n\r\nTransaction: #[[transaction]]','{\"transaction\":\"Transaction Number\",\"amount\":\"Request Amount By Admin\",\"currency\":\"Site Currency\", \"main_balance\":\"Users Balance After this operation\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(9,1,'PAYMENT_COMPLETE','support@mail.com','Payment Completed','Your Payment Has Been Completed','[[amount]] [[currency]] Payment Has Been successful via [[gateway_name]]\r\n\r\nCharge[[charge]] [[currency]]\r\n\r\nTranaction [[transaction]]\r\n\r\nYour Main Balance [[remaining_balance]] [[currency]]\r\n\r\n','[[amount]] [[currency]] Payment Has Been successful via [[gateway_name]]\n\nCharge[[charge]] [[currency]]\n\nTranaction [[transaction]]\n\nYour Main Balance [[remaining_balance]] [[currency]]\n\n','{\"gateway_name\":\"gateway name\",\"amount\":\"amount\",\"charge\":\"charge\", \"currency\":\"currency\",\"transaction\":\"transaction\",\"remaining_balance\":\"remaining balance\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(11,1,'PASSWORD_RESET','support@mail.com','Reset Password Notification','Reset Password Notification','You are receiving this email because we received a password reset request for your account.[[message]]\r\n\r\n\r\nThis password reset link will expire in 60 minutes.\r\n\r\nIf you did not request a password reset, no further action is required.','You are receiving this email because we received a password reset request for your account. [[message]]','{\"message\":\"message\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(12,1,'VERIFICATION_CODE','support@mail.com','Verification Code','Verify Your Email ','Your Email verification Code  [[code]]','Your SMS verification Code  [[code]]','{\"code\":\"code\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(21,1,'TWO_STEP_ENABLED','support@mail.com','TWO STEP ENABLED','TWO STEP ENABLED','Your verification code is: [[code]]','Your verification code is: [[code]]','{\"action\":\"Enabled Or Disable\",\"ip\":\"Device Ip\",\"browser\":\"browser and Operating System \",\"time\":\"Time\",\"code\":\"code\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(22,1,'TWO_STEP_DISABLED','support@mail.com','TWO STEP DISABLED','TWO STEP DISABLED','Google two factor verification is disabled','Google two factor verification is disabled','{\"action\":\"Enabled Or Disable\",\"ip\":\"Device Ip\",\"browser\":\"browser and Operating System \",\"time\":\"Time\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(24,1,'PAYOUT_REQUEST','support@mail.com','Withdraw request has been sent','Withdraw request has been sent','[[amount]] [[currency]] withdraw requested by [[method_name]]\r\n\r\n\r\nCharge [[charge]] [[currency]]\r\n\r\nTransaction [[trx]]\r\n','[[amount]] [[currency]] withdraw requested by [[method_name]]\r\n\r\n\r\nCharge [[charge]] [[currency]]\r\n\r\nTransaction [[trx]]\r\n','{\"method_name\":\"method name\",\"amount\":\"amount\",\"charge\":\"charge\",\"currency\":\"currency\",\"trx\":\"transaction\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(27,1,'PAYOUT_REJECTED','support@mail.com','Withdraw request has been rejected','Withdraw request has been rejected','[[amount]] [[currency]] withdraw has been rejeced\n\nPayout Method [[method]]\nCharge [[charge]] [[currency]]\nTransaction [[transaction]]\n\n\nAdmin feedback [[feedback]]\n\n','[[amount]] [[currency]] withdraw has been rejeced\r\n\r\nPayout Method [[method]]\r\nCharge [[charge]] [[currency]]\r\nTransaction [[transaction]]\r\n\r\n\r\nAdmin feedback [[feedback]]\r\n\r\n','{\"method\":\"Payout method\",\"amount\":\"amount\",\"charge\":\"charge\",\"currency\":\"currency\",\"transaction\":\"transaction\",\"feedback\":\"Admin feedback\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(28,1,'PAYOUT_APPROVE ','support@mail.com','Withdraw request has been approved','Withdraw request has been approved','[[amount]] [[currency]] withdraw has been approved\r\n\r\nPayout Method [[method]]\r\nCharge [[charge]] [[currency]]\r\nTransaction [[transaction]]\r\n\r\n\r\nAdmin feedback [[feedback]]\r\n\r\n','[[amount]] [[currency]] withdraw has been approved\n\nPayout Method [[method]]\nCharge [[charge]] [[currency]]\nTransaction [[transaction]]\n\n\nAdmin feedback [[feedback]]\n\n','{\"method\":\"Payout method\",\"amount\":\"amount\",\"charge\":\"charge\",\"currency\":\"currency\",\"transaction\":\"transaction\",\"feedback\":\"Admin feedback\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(40,1,'KYC_APPROVED','support@mail.com','KYC has been approved','KYC has been approved','[[kyc_type]] has been approved\r\n\r\n','[[kyc_type]] has been approved\r\n','{\"kyc_type\":\"kyc type\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(41,1,'KYC_REJECTED','support@mail.com','KYC has been rejected','KYC has been rejected','[[kyc_type]] has been rejected\r\n\r\n','[[kyc_type]] has been rejected\r\n','{\"kyc_type\":\"kyc type\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(42,1,'NEW_REGISTER','support@mail.com','Register Completed','Profile has been completed','Hey [[name]],\r\n\r\n[[site_name]] like to thank you for signing up.\r\n','Hey [[name]],\r\n\r\n[[site_name]] like to thank you for signing up.\r\n','{\"name\":\"name\",\"site_name\":\"site name\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(43,1,'USER_REFUND','support@mail.com','Refund Amount','Refund Amount','Your Refund Amount [[amount]]','Your Refund Amount [[amount]]\r\n','{\"amount\":\"Amount\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(44,1,'REFERRAL_BONUS','support@mail.com','REFERRAL BONUS','REFERRAL BONUS','You got [[amount]] [[currency]]  Referral bonus From  [[bonus_from]] \r\n','You got [[amount]] [[currency]]  Referral bonus From  [[bonus_from]] \r\n','{\"bonus_from\":\"bonus from User\",\"amount\":\"amount\",\"currency\":\"currency\",\"level\":\"level\",\"transaction_id\":\"transaction id\",\"final_balance\":\"final balance\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25'),
(45,1,'BET_WIN','support@mail.com','BET WIN','BET WIN','You win [[amount]] [[currency]]  on [[transaction_id]] \r\n\r\nMain Balance [[final_balance]] [[currency]]\r\n','You win [[amount]] [[currency]]  on [[transaction_id]] \r\n\r\nMain Balance [[final_balance]] [[currency]]\r\n','{\"amount\":\"amount\",\"currency\":\"currency\",\"transaction_id\":\"transaction id\",\"final_balance\":\"final balance\"}',1,1,'en','2021-12-17 05:00:26','2022-08-31 21:26:25');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `funds` */

DROP TABLE IF EXISTS `funds`;

CREATE TABLE `funds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `gateway_id` int(11) unsigned DEFAULT NULL,
  `gateway_currency` varchar(191) DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `final_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `btc_amount` decimal(18,8) DEFAULT NULL,
  `btc_wallet` varchar(191) DEFAULT NULL,
  `transaction` varchar(25) DEFAULT NULL,
  `try` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=> Complete, 2=> Pending, 3 => Cancel',
  `detail` text DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `funds_user_id_foreign` (`user_id`),
  KEY `funds_gateway_id_foreign` (`gateway_id`),
  CONSTRAINT `funds_gateway_id_foreign` FOREIGN KEY (`gateway_id`) REFERENCES `gateways` (`id`),
  CONSTRAINT `funds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `funds` */

insert  into `funds`(`id`,`user_id`,`gateway_id`,`gateway_currency`,`amount`,`charge`,`rate`,`final_amount`,`btc_amount`,`btc_wallet`,`transaction`,`try`,`status`,`detail`,`feedback`,`created_at`,`updated_at`,`payment_id`) values 
(1,1,1,'USD',500.00000000,5.50000000,0.01200000,6.06600000,0.00000000,'','2S1SNRAYM8DR',0,0,NULL,NULL,'2023-08-17 08:20:31','2023-08-17 08:20:31',NULL);

/*Table structure for table `game_categories` */

DROP TABLE IF EXISTS `game_categories`;

CREATE TABLE `game_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=>deActive, 1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `game_categories` */

insert  into `game_categories`(`id`,`name`,`icon`,`status`,`created_at`,`updated_at`) values 
(1,'Badminton','<i class=\"far fa-shuttlecock\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:04:50','2023-08-16 18:04:50'),
(2,'Baseball','<i class=\"far fa-baseball\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:04:59','2023-08-16 18:04:59'),
(3,'Basketball','<i class=\"far fa-basketball-ball\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:05:09','2023-08-16 18:05:09'),
(4,'Boxing','<i class=\"far fa-boxing-glove\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:05:19','2023-08-16 18:05:19'),
(5,'Chess','<i class=\"far fa-chess\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:05:28','2023-08-16 18:05:28'),
(6,'Cricket','<i class=\"far fa-cricket\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:05:39','2023-08-16 18:05:39'),
(8,'Esports','<i class=\"far fa-gamepad-alt\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:06:02','2023-08-16 18:06:02'),
(9,'Football','<i class=\"far fa-futbol\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:06:10','2023-08-16 18:06:10'),
(11,'Golf','<i class=\"far fa-golf-club\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:06:29','2023-08-16 18:06:29'),
(12,'Hockey','<i class=\"far fa-field-hockey\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:06:38','2023-08-16 18:06:38'),
(15,'Table Tennis','<i class=\"far fa-table-tennis\" aria-hidden=\"true\"></i>',1,'2023-08-16 18:07:12','2023-08-16 18:07:12');

/*Table structure for table `game_matches` */

DROP TABLE IF EXISTS `game_matches`;

CREATE TABLE `game_matches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `tournament_id` bigint(20) unsigned NOT NULL,
  `team1_id` bigint(20) unsigned NOT NULL,
  `team2_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=> deactive 1=>active, 2=>closed',
  `is_unlock` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>unlock 1=>lock',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_matches_category_id_foreign` (`category_id`),
  KEY `game_matches_tournament_id_foreign` (`tournament_id`),
  KEY `game_matches_team1_id_foreign` (`team1_id`),
  KEY `game_matches_team2_id_foreign` (`team2_id`),
  CONSTRAINT `game_matches_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `game_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `game_matches_team1_id_foreign` FOREIGN KEY (`team1_id`) REFERENCES `game_teams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `game_matches_team2_id_foreign` FOREIGN KEY (`team2_id`) REFERENCES `game_teams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `game_matches_tournament_id_foreign` FOREIGN KEY (`tournament_id`) REFERENCES `game_tournaments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `game_matches` */

insert  into `game_matches`(`id`,`category_id`,`tournament_id`,`team1_id`,`team2_id`,`name`,`start_date`,`end_date`,`status`,`is_unlock`,`created_at`,`updated_at`) values 
(1,9,1,1,2,'','2023-08-01 00:00:00','2024-08-01 00:00:00',1,0,'2023-08-16 19:07:28','2023-08-16 19:07:28'),
(2,3,6,7,8,'','2023-08-31 15:10:00','2023-10-16 15:10:00',1,0,'2023-08-16 19:10:34','2023-08-16 19:10:34'),
(3,6,7,11,12,'','2023-07-01 12:11:00','2023-09-01 00:00:00',1,0,'2023-08-16 19:11:47','2023-08-16 19:11:47'),
(4,12,4,13,14,'','2023-06-27 16:00:00','2023-11-22 16:00:00',1,0,'2023-08-16 19:13:03','2023-08-16 19:13:03'),
(5,9,2,4,10,'','2023-07-11 20:18:00','2023-10-30 05:17:00',1,0,'2023-08-16 19:15:15','2023-08-16 19:23:45'),
(6,9,2,3,6,'','2023-06-07 18:25:00','2023-07-26 19:27:00',1,0,'2023-08-16 19:23:17','2023-08-16 20:03:37');

/*Table structure for table `game_options` */

DROP TABLE IF EXISTS `game_options`;

CREATE TABLE `game_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` bigint(20) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `creator_id` bigint(20) unsigned NOT NULL,
  `option_name` varchar(255) DEFAULT NULL,
  `invest_amount` decimal(8,2) NOT NULL,
  `return_amount` decimal(8,2) NOT NULL,
  `minimum_amount` decimal(8,2) NOT NULL,
  `ratio` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT 'pending=>1 ,win=>2, deActive=>0, refunded=>3, Lost=> -2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_options_match_id_foreign` (`match_id`),
  KEY `game_options_question_id_foreign` (`question_id`),
  CONSTRAINT `game_options_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `game_matches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `game_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `game_questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `game_options` */

insert  into `game_options`(`id`,`match_id`,`question_id`,`creator_id`,`option_name`,`invest_amount`,`return_amount`,`minimum_amount`,`ratio`,`status`,`created_at`,`updated_at`) values 
(1,1,1,1,'Messi',0.00,0.00,0.00,'5',1,'2023-08-16 19:09:48','2023-08-16 19:54:30'),
(2,1,2,1,'Yes',0.00,0.00,0.00,'2',1,'2023-08-16 19:09:48','2023-08-16 19:09:48'),
(3,1,3,1,'Yes',0.00,0.00,0.00,'2',1,'2023-08-16 19:09:48','2023-08-16 19:09:48'),
(4,2,4,1,'Yes',0.00,0.00,0.00,'3',1,'2023-08-16 19:10:59','2023-08-16 19:10:59'),
(5,3,5,1,'Yes',0.00,0.00,0.00,'1.5',1,'2023-08-16 19:12:10','2023-08-16 19:12:10'),
(6,4,6,1,'Yes',0.00,0.00,0.00,'2',1,'2023-08-16 19:14:36','2023-08-16 19:14:36'),
(7,5,7,1,'Yes',0.00,0.00,0.00,'2.5',1,'2023-08-16 19:16:25','2023-08-16 19:16:25'),
(8,5,8,1,'Yes',0.00,0.00,0.00,'3',1,'2023-08-16 19:16:25','2023-08-16 19:16:25'),
(9,5,9,1,'Yes',0.00,0.00,0.00,'2',1,'2023-08-16 19:16:25','2023-08-16 19:16:25'),
(10,1,1,1,'Neymar',0.00,0.00,0.00,'2.5',1,'2023-08-16 19:17:16','2023-08-16 19:19:35'),
(11,1,1,1,'C.Ronaldo',0.00,0.00,0.00,'3.5',1,'2023-08-16 19:17:32','2023-08-16 19:17:32'),
(12,1,1,1,'Bengzema',0.00,0.00,0.00,'2.5',1,'2023-08-16 19:18:15','2023-08-16 19:19:41'),
(13,1,10,1,'Yes',0.00,0.00,0.00,'1',1,'2023-08-16 19:20:28','2023-08-16 19:20:28'),
(14,1,11,1,'Yes',0.00,0.00,0.00,'2.5',0,'2023-08-16 19:21:11','2023-08-16 19:21:11'),
(15,6,12,1,'Goal',0.00,0.00,0.00,'4',2,'2023-08-16 19:25:12','2023-08-16 20:12:52'),
(16,6,12,1,'Rachel',0.00,0.00,0.00,'2',-2,'2023-08-16 19:25:12','2023-08-16 20:12:52'),
(17,6,12,1,'WIn',0.00,0.00,0.00,'2.5',-2,'2023-08-16 19:25:12','2023-08-16 20:12:52');

/*Table structure for table `game_questions` */

DROP TABLE IF EXISTS `game_questions`;

CREATE TABLE `game_questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` bigint(20) unsigned NOT NULL,
  `result_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=> pending, 1=> active, 2=> closed',
  `is_unlock` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>unlock 1=>lock',
  `result` tinyint(4) NOT NULL DEFAULT 0,
  `limit` int(11) NOT NULL DEFAULT 100,
  `creator_id` bigint(20) unsigned NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_questions_match_id_foreign` (`match_id`),
  CONSTRAINT `game_questions_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `game_matches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `game_questions` */

insert  into `game_questions`(`id`,`match_id`,`result_id`,`name`,`status`,`is_unlock`,`result`,`limit`,`creator_id`,`end_time`,`created_at`,`updated_at`) values 
(1,1,NULL,'Who will win?',1,0,0,100,1,'2023-08-30 15:08:00','2023-08-16 19:09:48','2023-08-16 19:09:48'),
(2,1,NULL,'Barcelona will win?',1,0,0,100,1,'2023-10-16 19:13:00','2023-08-16 19:09:48','2023-08-16 19:09:48'),
(3,1,NULL,'Real Madrid will win?',1,0,0,100,1,'2023-10-16 09:15:00','2023-08-16 19:09:48','2023-08-16 19:09:48'),
(4,2,NULL,'Who will win?',1,0,0,100,1,'2023-09-14 08:14:00','2023-08-16 19:10:59','2023-08-16 19:10:59'),
(5,3,NULL,'Who will win?',1,0,0,100,1,'2023-08-31 04:17:00','2023-08-16 19:12:10','2023-08-16 19:12:10'),
(6,4,NULL,'Who will win?',1,0,0,100,1,'2023-09-01 05:15:00','2023-08-16 19:14:36','2023-08-16 19:14:36'),
(7,5,NULL,'Who will win?',1,1,0,100,1,'2023-08-23 17:18:00','2023-08-16 19:16:25','2023-08-16 19:24:05'),
(8,5,NULL,'Ac Milano will win?',1,0,0,100,1,'2023-08-21 17:18:00','2023-08-16 19:16:25','2023-08-16 19:16:25'),
(9,5,NULL,'Atlentico M will win?',1,0,0,100,1,'2023-08-30 05:18:00','2023-08-16 19:16:25','2023-08-16 19:24:02'),
(10,1,NULL,'Ansu',0,0,0,100,1,'2023-08-09 17:21:00','2023-08-16 19:20:28','2023-08-16 19:20:28'),
(11,1,NULL,'Goal?',2,0,0,100,1,'2023-08-06 15:20:00','2023-08-16 19:21:11','2023-08-16 19:21:24'),
(12,6,NULL,'Who will win?',1,0,1,100,1,'2023-07-12 19:28:00','2023-08-16 19:25:12','2023-08-16 20:12:52');

/*Table structure for table `game_teams` */

DROP TABLE IF EXISTS `game_teams`;

CREATE TABLE `game_teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=>deActive, 1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `game_teams_category_id_foreign` (`category_id`),
  CONSTRAINT `game_teams_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `game_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `game_teams` */

insert  into `game_teams`(`id`,`name`,`image`,`status`,`created_at`,`updated_at`,`category_id`) values 
(1,'Barcelona','64dd1c0c41d161692212236.png',1,'2023-08-16 18:56:27','2023-08-16 18:57:16',9),
(2,'Real Madrid','64dd1bff239ec1692212223.png',1,'2023-08-16 18:57:03','2023-08-16 18:57:03',9),
(3,'FC Bayern','64dd1c2e1369c1692212270.png',1,'2023-08-16 18:57:50','2023-08-16 18:57:50',9),
(4,'Ac-Milano','64dd1c5110e331692212305.png',1,'2023-08-16 18:58:25','2023-08-16 18:58:25',9),
(5,'Napoli','64dd1c998e0391692212377.png',1,'2023-08-16 18:59:37','2023-08-16 18:59:37',9),
(6,'Naigeria','64dd1cea6df811692212458.png',1,'2023-08-16 19:00:58','2023-08-16 19:00:58',9),
(7,'Aregentia','64dd1d1e9af5a1692212510.png',1,'2023-08-16 19:01:50','2023-08-16 19:02:12',3),
(8,'Barcelona','64dd1d2f82dac1692212527.png',1,'2023-08-16 19:02:07','2023-08-16 19:02:07',3),
(9,'Chile','64dd1d5c2d7651692212572.png',1,'2023-08-16 19:02:52','2023-08-16 19:02:52',1),
(10,'Atlentico Madrid','64dd1d73634281692212595.png',1,'2023-08-16 19:03:15','2023-08-16 19:03:15',9),
(11,'Champion Soccer','64dd1d94400e01692212628.png',1,'2023-08-16 19:03:48','2023-08-16 19:03:48',6),
(12,'Fc Porto','64dd1dad4b4711692212653.png',1,'2023-08-16 19:04:13','2023-08-16 19:04:13',6),
(13,'Paris','64dd1dc7e87861692212679.png',1,'2023-08-16 19:04:39','2023-08-16 19:04:39',12),
(14,'NFL','64dd1ddea558e1692212702.png',1,'2023-08-16 19:05:02','2023-08-16 19:05:02',12);

/*Table structure for table `game_tournaments` */

DROP TABLE IF EXISTS `game_tournaments`;

CREATE TABLE `game_tournaments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=>deActive, 1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_tournaments_category_id_foreign` (`category_id`),
  CONSTRAINT `game_tournaments_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `game_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `game_tournaments` */

insert  into `game_tournaments`(`id`,`category_id`,`name`,`status`,`created_at`,`updated_at`) values 
(1,9,'World Cup',1,'2023-08-16 18:51:27','2023-08-16 18:51:27'),
(2,9,'UFFA',1,'2023-08-16 18:52:01','2023-08-16 18:52:01'),
(3,15,'Asia Cup',1,'2023-08-16 18:52:16','2023-08-16 18:52:16'),
(4,12,'Asia Cup',1,'2023-08-16 18:52:31','2023-08-16 18:52:31'),
(5,3,'Basketball League',1,'2023-08-16 18:53:02','2023-08-16 18:53:02'),
(6,3,'Ball on track',1,'2023-08-16 18:53:15','2023-08-16 18:53:15'),
(7,6,'Big Bash',1,'2023-08-16 18:53:30','2023-08-16 18:53:30'),
(8,5,'World Cup',1,'2023-08-16 18:53:47','2023-08-16 18:53:47'),
(9,1,'World Cup',1,'2023-08-16 18:54:00','2023-08-16 18:54:00'),
(10,1,'BWF Uber Cup',1,'2023-08-16 18:54:19','2023-08-16 18:54:19'),
(11,6,'IPL',1,'2023-08-16 18:54:49','2023-08-16 18:54:49'),
(12,4,'WMBA',1,'2023-08-16 18:55:00','2023-08-16 18:55:00');

/*Table structure for table `gateways` */

DROP TABLE IF EXISTS `gateways`;

CREATE TABLE `gateways` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `code` varchar(191) NOT NULL,
  `currency` varchar(191) NOT NULL,
  `symbol` varchar(191) NOT NULL,
  `parameters` text DEFAULT NULL,
  `extra_parameters` text DEFAULT NULL,
  `convention_rate` decimal(18,8) NOT NULL DEFAULT 1.00000000,
  `currencies` text DEFAULT NULL,
  `min_amount` decimal(18,8) NOT NULL,
  `max_amount` decimal(18,8) NOT NULL,
  `percentage_charge` decimal(8,4) NOT NULL DEFAULT 0.0000,
  `fixed_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: inactive, 1: active',
  `note` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `sort_by` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gateways_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `gateways` */

insert  into `gateways`(`id`,`name`,`code`,`currency`,`symbol`,`parameters`,`extra_parameters`,`convention_rate`,`currencies`,`min_amount`,`max_amount`,`percentage_charge`,`fixed_charge`,`status`,`note`,`image`,`sort_by`,`created_at`,`updated_at`) values 
(1,'Paypal','paypal','USD','USD','{\"cleint_id\":\"\",\"secret\":\"\"}',NULL,0.01200000,'{\"0\":{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"USD\"}}',1.00000000,10000.00000000,1.0000,0.50000000,1,'','5f637b5622d23.jpg',14,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(2,'Stripe ','stripe','USD','USD','{\"secret_key\":\"\",\"publishable_key\":\"\"}',NULL,1.00000000,'{\"0\":{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f645d432b9c0.jpg',23,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(3,'Skrill','skrill','USD','USD','{\"pay_to_email\":\"\",\"secret_key\":\"\"}',NULL,1.00000000,'{\"0\":{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637c7fcb9ef.jpg',22,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(4,'Perfect Money','perfectmoney','USD','USD','{\"passphrase\":\"\",\"payee_account\":\"\"}',NULL,1.00000000,'{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f64d522d8bea.jpg',18,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(5,'PayTM','paytm','INR','INR','{\"MID\":\"\",\"merchant_key\":\"\",\"WEBSITE\":\"WEBSTAGING\",\"INDUSTRY_TYPE_ID\":\"Retail\",\"CHANNEL_ID\":\"WEB\"}',NULL,1.00000000,'{\"0\":{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637cbfb4d4c.jpg',16,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(6,'Payeer','payeer','RUB','USD','{\"merchant_id\":\"\",\"secret_key\":\"\"}','{\"status\":\"ipn\"}',1.00000000,'{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f64d52d09e13.jpg',13,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(7,'PayStack','paystack','NGN','NGN','{\"public_key\":\"\",\"secret_key\":\"\"}','{\"callback\":\"ipn\",\"webhook\":\"ipn\"}\r\n',1.00000000,'{\"0\":{\"USD\":\"USD\",\"NGN\":\"NGN\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637d069177e.jpg',15,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(8,'VoguePay','voguepay','USD','USD','{\"merchant_id\":\"\"}',NULL,1.00000000,'{\"0\":{\"NGN\":\"NGN\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"ZAR\":\"ZAR\",\"JPY\":\"JPY\",\"INR\":\"INR\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PLN\":\"PLN\"}}\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637d53da3e7.jpg',21,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(9,'Flutterwave','flutterwave','USD','USD','{\"public_key\":\"\",\"secret_key\":\"\",\"encryption_key\":\"\"}',NULL,0.01200000,'{\"0\":{\"KES\":\"KES\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"UGX\":\"UGX\",\"TZS\":\"TZS\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637d6a0b22d.jpg',8,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(10,'RazorPay','razorpay','INR','INR','{\"key_id\":\"\",\"key_secret\":\"\"}',NULL,1.00000000,'{\"0\": {\"INR\": \"INR\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637d80b68e0.jpg',19,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(11,'instamojo','instamojo','INR','INR','{\"api_key\":\"\",\"auth_token\":\"\",\"salt\":\"\"}',NULL,73.51000000,'{\"0\":{\"INR\":\"INR\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637da3c44d2.jpg',9,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(12,'Mollie','mollie','USD','USD','{\"api_key\":\"\"}',NULL,0.01200000,'{\"0\":{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637db537958.jpg',11,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(13,'2checkout','twocheckout','USD','USD','{\"merchant_code\":\"\",\"secret_key\":\"\"}','{\"approved_url\":\"ipn\"}',1.00000000,'{\"0\":{\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"DZD\":\"DZD\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AZN\":\"AZN\",\"BSD\":\"BSD\",\"BDT\":\"BDT\",\"BBD\":\"BBD\",\"BZD\":\"BZD\",\"BMD\":\"BMD\",\"BOB\":\"BOB\",\"BWP\":\"BWP\",\"BRL\":\"BRL\",\"GBP\":\"GBP\",\"BND\":\"BND\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"XCD\":\"XCD\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"GTQ\":\"GTQ\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JMD\":\"JMD\",\"JPY\":\"JPY\",\"KZT\":\"KZT\",\"KES\":\"KES\",\"LAK\":\"LAK\",\"MMK\":\"MMK\",\"LBP\":\"LBP\",\"LRD\":\"LRD\",\"MOP\":\"MOP\",\"MYR\":\"MYR\",\"MVR\":\"MVR\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PGK\":\"PGK\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"WST\":\"WST\",\"SAR\":\"SAR\",\"SCR\":\"SCR\",\"SGD\":\"SGD\",\"SBD\":\"SBD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"SYP\":\"SYP\",\"THB\":\"THB\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TRY\":\"TRY\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"USD\":\"USD\",\"VUV\":\"VUV\",\"VND\":\"VND\",\"XOF\":\"XOF\",\"YER\":\"YER\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637e7eae68b.jpg',24,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(14,'Authorize.Net','authorizenet','USD','USD','{\"login_id\":\"\",\"current_transaction_key\":\"\"}',NULL,0.01200000,'{\"0\":{\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"USD\":\"USD\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637de6d9fef.jpg',3,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(15,'SecurionPay','securionpay','USD','USD','{\"public_key\":\"\",\"secret_key\":\"\"}',NULL,1.00000000,'{\"0\":{\"AFN\":\"AFN\", \"DZD\":\"DZD\", \"ARS\":\"ARS\", \"AUD\":\"AUD\", \"BHD\":\"BHD\", \"BDT\":\"BDT\", \"BYR\":\"BYR\", \"BAM\":\"BAM\", \"BWP\":\"BWP\", \"BRL\":\"BRL\", \"BND\":\"BND\", \"BGN\":\"BGN\", \"CAD\":\"CAD\", \"CLP\":\"CLP\", \"CNY\":\"CNY\", \"COP\":\"COP\", \"KMF\":\"KMF\", \"HRK\":\"HRK\", \"CZK\":\"CZK\", \"DKK\":\"DKK\", \"DJF\":\"DJF\", \"DOP\":\"DOP\", \"EGP\":\"EGP\", \"ETB\":\"ETB\", \"ERN\":\"ERN\", \"EUR\":\"EUR\", \"GEL\":\"GEL\", \"HKD\":\"HKD\", \"HUF\":\"HUF\", \"ISK\":\"ISK\", \"INR\":\"INR\", \"IDR\":\"IDR\", \"IRR\":\"IRR\", \"IQD\":\"IQD\", \"ILS\":\"ILS\", \"JMD\":\"JMD\", \"JPY\":\"JPY\", \"JOD\":\"JOD\", \"KZT\":\"KZT\", \"KES\":\"KES\", \"KWD\":\"KWD\", \"KGS\":\"KGS\", \"LVL\":\"LVL\", \"LBP\":\"LBP\", \"LTL\":\"LTL\", \"MOP\":\"MOP\", \"MKD\":\"MKD\", \"MGA\":\"MGA\", \"MWK\":\"MWK\", \"MYR\":\"MYR\", \"MUR\":\"MUR\", \"MXN\":\"MXN\", \"MDL\":\"MDL\", \"MAD\":\"MAD\", \"MZN\":\"MZN\", \"NAD\":\"NAD\", \"NPR\":\"NPR\", \"ANG\":\"ANG\", \"NZD\":\"NZD\", \"NOK\":\"NOK\", \"OMR\":\"OMR\", \"PKR\":\"PKR\", \"PEN\":\"PEN\", \"PHP\":\"PHP\", \"PLN\":\"PLN\", \"QAR\":\"QAR\", \"RON\":\"RON\", \"RUB\":\"RUB\", \"SAR\":\"SAR\", \"RSD\":\"RSD\", \"SGD\":\"SGD\", \"ZAR\":\"ZAR\", \"KRW\":\"KRW\", \"IKR\":\"IKR\", \"LKR\":\"LKR\", \"SEK\":\"SEK\", \"CHF\":\"CHF\", \"SYP\":\"SYP\", \"TWD\":\"TWD\", \"TZS\":\"TZS\", \"THB\":\"THB\", \"TND\":\"TND\", \"TRY\":\"TRY\", \"UAH\":\"UAH\", \"AED\":\"AED\", \"GBP\":\"GBP\", \"USD\":\"USD\", \"VEB\":\"VEB\", \"VEF\":\"VEF\", \"VND\":\"VND\", \"XOF\":\"XOF\", \"YER\":\"YER\", \"ZMK\":\"ZMK\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f637e002d11b.jpg',20,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(16,'PayUmoney','payumoney','INR','INR','{\"merchant_key\":\"\",\"salt\":\"\"}',NULL,0.87000000,'{\"0\":{\"INR\":\"INR\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f6390dbaa6ff.jpg',17,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(17,'Mercado Pago','mercadopago','BRL','BRL','{\"access_token\":\"\"}',NULL,0.06300000,'{\"0\":{\"ARS\":\"ARS\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"DOP\":\"DOP\",\"EUR\":\"EUR\",\"GTQ\":\"GTQ\",\"HNL\":\"HNL\",\"MXN\":\"MXN\",\"NIO\":\"NIO\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PYG\":\"PYG\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"VEF\":\"VEF\",\"VES\":\"VES\"}}',3715.12000000,371500000.12000000,0.0000,0.50000000,1,'','5f645d1bc1f24.jpg',10,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(18,'Coingate','coingate','USD','USD','{\"api_key\":\"\",\"secret\":\"\"}',NULL,1.00000000,'{\"0\":{\"USD\":\"USD\",\"EUR\":\"EUR\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f659e5355859.jpg',7,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(19,'Coinbase Commerce','coinbasecommerce','USD','USD','{\"api_key\":\"\",\"secret\":\"\"}','{\"webhook\":\"ipn\"}',1.00000000,'{\"0\":{\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CHF\":\"CHF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GBP\":\"GBP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"INR\":\"INR\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RUB\":\"RUB\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TRY\":\"TRY\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZAR\":\"ZAR\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5f6703145a5ca.jpg',2,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(20,'Monnify','monnify','NGN','NGN','{\"api_key\":\"\",\"secret_key\":\"\",\"contract_code\":\"\"}',NULL,4.52000000,'{\"0\":{\"NGN\":\"NGN\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','5fbca5d05057f.jpg',12,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(21,'Block.io','blockio','BTC','BTC','{\"api_key\":\"\",\"api_pin\":\"\"}','{\"cron\":\"ipn\"}',0.00004200,'{\"1\":{\"BTC\":\"BTC\",\"LTC\":\"LTC\",\"DOGE\":\"DOGE\"}}',10.10004200,10000.00000000,0.0000,0.50000000,1,'','5fe038332ad52.jpg',1,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(22,'CoinPayments','coinpayments','BTC','BTC','{\"merchant_id\":\"\",\"private_key\":\"\",\"public_key\":\"\"}','{\"callback\":\"ipn\"}',0.00000000,'{\"0\":{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"},\"1\":{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}}',10.00000000,99999.00000000,1.0000,0.50000000,1,'','5ffd7d962985e1610448278.jpg',6,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(23,'Blockchain','blockchain','BTC','BTC','{\"api_key\":\"\",\"xpub_code\":\"\"}',NULL,0.00000000,'{\"1\":{\"BTC\":\"BTC\"}}',100.00000000,10000.00000000,0.0000,0.50000000,1,'','5fe439f477bb7.jpg',4,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(25,'cashmaal','cashmaal','PKR','PKR','{\"web_id\":\"\",\"ipn_key\":\"\"}','{\"ipn_url\":\"ipn\"}',0.85000000,'{\"0\":{\"PKR\":\"PKR\",\"USD\":\"USD\"}}',100.00000000,10000.00000000,0.0000,0.50000000,1,'','cashmaal.jpg',5,'2020-09-10 05:05:02','2023-01-28 20:53:27'),
(26,'Midtrans','midtrans','IDR','IDR','{\"client_key\":\"SB-Mid-client-jsBzAGzoAL0sml3M\",\"server_key\":\"SB-Mid-server-b4bO6W6a8GP9rqrEFKVzUn5G\"}','{\"payment_notification_url\":\"ipn\", \"finish redirect_url\":\"ipn\", \"unfinish redirect_url\":\"failed\",\"error redirect_url\":\"failed\"}',14835.20000000,'{\"0\":{\"IDR\":\"IDR\"}}',1.00000000,10000.00000000,0.0000,0.05000000,1,'','64a90482b80de1688798338.png',1,'2020-09-08 17:05:02','2023-07-07 14:38:58'),
(27,'peachpayments','peachpayments','USD','USD','{\"Authorization_Bearer\":\"OGE4Mjk0MTc0ZTczNWQwYzAxNGU3OGNmMjY2YjE3OTR8cXl5ZkhDTjgzZQ==\",\"Entity_ID\":\"8a8294174e735d0c014e78cf26461790\",\"Recur_Channel\":\"8ac7a4c77accc72d017ace4729440fd9\"}',NULL,1.00000000,'{\"0\":{\"AED\":\"AED\",\"AFA\":\"AFA\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"AWG\":\"AWG\",\"AZM\":\"AZM\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYR\":\"BYR\",\"BZD\":\"BZD\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CYP\":\"CYP\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EEK\":\"EEK\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"EUR\":\"EUR\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GBP\":\"GBP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHC\":\"GHC\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HKD\":\"HKD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"INR\":\"INR\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LTL\":\"LTL\",\"LVL\":\"LVL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MTL\":\"MTL\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"MZM\":\"MZM\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NOK\":\"NOK\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PTS\":\"PTS\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDD\":\"SDD\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"SHP\":\"SHP\",\"SIT\":\"SIT\",\"SKK\":\"SKK\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SPL\":\"SPL\",\"SRD\":\"SRD\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMM\":\"TMM\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TRL\":\"TRL\",\"TRY\":\"TRY\",\"TTD\":\"TTD\",\"TVD\":\"TVD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZAR\":\"ZAR\",\"ZMK\":\"ZMK\",\"ZWD\":\"ZWD\"}}',1.00000000,10000.00000000,0.0000,0.50000000,1,'','64a904a589e191688798373.png',24,'2020-09-08 23:05:02','2023-07-07 14:58:17'),
(28,'Nowpayments','nowpayments','BTC','BTC','{\"api_key\":\"7X96BPB-3JN4RWK-QXNEHFQ-AAJ61TY\"}','{\"cron\":\"ipn\"}',1.00000000,'{\"1\":{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}}',10.10000000,10000.00000000,0.0000,0.50000000,1,'','64a904b8ae2281688798392.jpg',16,'2020-09-08 17:05:02','2023-07-07 14:39:52'),
(29,'Khalti Payment','khalti','NPR','NPR','{\"secret_key\":\"test_secret_key_e241fa0cf56e44b3a5e55a20f6a45e84\",\"public_key\":\"test_public_key_d4d1c327935749508ee25b52e22ebabb\"}',NULL,132.04000000,'{\"0\":{\"NPR\":\"NPR\"}}',1.00000000,10000.00000000,0.0000,0.00000000,1,'','64a904cfc55351688798415.webp',20,'2020-09-08 17:05:02','2023-07-07 15:06:22'),
(30,'MAGUA PAY','swagger','EUR','EUR','{\"MAGUA_PAY_ACCOUNT\":\"EUR-sandbox\",\"MerchantKey\":\"Turbogames\",\"Secret\":\"m3X4SrY2404HN8bm01eTG82M7R8oEtF4\"}',NULL,1.00000000,'{\"0\":{\"EUR\":\"EUR\"}}',1.00000000,10000.00000000,0.0000,0.00000000,1,'','64a904e49c80a1688798436.png',18,'2020-09-08 17:05:02','2023-07-07 15:07:08'),
(31,'Free kassa','freekassa','RUB','RUB','{\"merchant_id\":\"8896\",\"merchant_key\":\"21b1f9f32162cdd5e59df622d0c28db5\",\"secret_word\":\"lGkk+6464848\",\"secret_word2\":\"lGkk6464848\"}','{\"ipn_url\":\"ipn\"}',1.00000000,'{\"0\":{\"RUB\":\"RUB\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"UAH\":\"UAH\",\"KZT\":\"KZT\"}}',10.00000000,10000.00000000,0.1000,0.00000000,1,'','64a90509c1fbd1688798473.jpg',13,'2020-09-08 17:05:02','2023-07-07 14:41:13'),
(32,'Konnect','konnect','USD','USD','{\"api_key\":\"6399ed9208ec811bcda4af6d:9WNA3dfjmDq6ynKb5RsRTYM7dIpq9\",\"receiver_wallet_Id\":\"6399ed9208ec811bcda4af6e\"}','{\"webhook\":\"ipn\"}',1.00000000,'{\"0\":{\"TND\":\"TND\",\"EUR\":\"EUR\",\"USD\":\"USD\"}}',1.00000000,10000.00000000,0.0000,0.00000000,1,'','64a905273ae9e1688798503.jpg',11,'2020-09-08 17:05:02','2023-07-07 14:41:43'),
(33,'Mypay Np','mypay','NPR','NPR','{\"merchant_username\":\"mjthapa\",\"merchant_api_password\":\"A3T3VHDDFLLJRHN\",\"merchant_id\":\"MER26879689\",\"api_key\":\"tE8clmiMy1z35XAiU/w1byEAjikHR/1muYa4PmxyfssZcu6UO3yPo+DyEKWxFYQb\"}',NULL,1.00000000,'{\"0\":{\"NPR\":\"NPR\"}}',1.00000000,100000.00000000,1.5000,0.00000000,1,'','64a9054056ac11688798528.png',22,'2020-09-08 17:05:02','2023-07-07 14:42:08'),
(35,'IME PAY','imepay','NPR','NPR','{\"MerchantModule\":\"GAMINGCEN\",\"MerchantCode\":\"GAMINGCEN\",\"username\":\"gamingcenter\",\"password\":\"ime@1234\"}',NULL,1.00000000,'{\"0\":{\"NPR\":\"NPR\"}}',1.00000000,100000.00000000,1.5000,0.00000000,1,'','64a9088b014171688799371.png',4,'2020-09-08 17:05:02','2023-07-07 14:56:11'),
(36,'Cashonex Hosted','cashonexHosted','USD','USD','{\"idempotency_key\":\"727649-0h76ac-467573-fxoxli-141433-c5ugg1\",\"salt\":\"67a8d2c1548c1ddb616bdc27e31fbd5e385f7872204043df7219498f08e4dcda\"}',NULL,1.00000000,'{\"0\":{\"USD\":\"USD\"}}',1.00000000,1000.00000000,0.0000,0.00000000,1,'','64a9055b3a4141688798555.jpg',6,'2023-04-02 14:31:33','2023-07-07 14:42:35'),
(37,'cashonex','cashonex','USD','USD','{\"idempotency_key\":\"155228-ck-651971-ody-329243-h6i\",\"salt\":\"5a05d0f7336738460c4d098785cd0f2785bd60631bec019ea2ca61ed195ea8b5\"}',NULL,1.00000000,'{\"0\":{\"USD\":\"USD\"}}',1.00000000,1000.00000000,0.0000,0.00000000,1,'','64a9056b129a21688798571.jpg',7,'2023-04-02 14:34:54','2023-07-07 14:42:51'),
(38,'Binance','binance','USDT','USDT','{\"mercent_api_key\":\"li4shwwt5ugfbboiq1q75dstbmwrgoaetylc7cmulmahh6qxs3clmbytrb7gk2ky\",\"mercent_secret\":\"5elpmjmwvjjsee7kwqqwzcabhtznl0ja8o3pvfsavqrobclsjxamq5kf93uhwcqm\"}',NULL,1.00000000,'{\"1\":{\"ADA\":\"ADA\",\"ATOM\":\"ATOM\",\"AVA\":\"AVA\",\"BCH\":\"BCH\",\"BNB\":\"BNB\",\"BTC\":\"BTC\",\"BUSD\":\"BUSD\",\"CTSI\":\"CTSI\",\"DASH\":\"DASH\",\"DOGE\":\"DOGE\",\"DOT\":\"DOT\",\"EGLD\":\"EGLD\",\"EOS\":\"EOS\",\"ETC\":\"ETC\",\"ETH\":\"ETH\",\"FIL\":\"FIL\",\"FRONT\":\"FRONT\",\"FTM\":\"FTM\",\"GRS\":\"GRS\",\"HBAR\":\"HBAR\",\"IOTX\":\"IOTX\",\"LINK\":\"LINK\",\"LTC\":\"LTC\",\"MANA\":\"MANA\",\"MATIC\":\"MATIC\",\"NEO\":\"NEO\",\"OM\":\"OM\",\"ONE\":\"ONE\",\"PAX\":\"PAX\",\"QTUM\":\"QTUM\",\"STRAX\":\"STRAX\",\"SXP\":\"SXP\",\"TRX\":\"TRX\",\"TUSD\":\"TUSD\",\"UNI\":\"UNI\",\"USDC\":\"USDC\",\"USDT\":\"USDT\",\"WRX\":\"WRX\",\"XLM\":\"XLM\",\"XMR\":\"XMR\",\"XRP\":\"XRP\",\"XTZ\":\"XTZ\",\"XVS\":\"XVS\",\"ZEC\":\"ZEC\",\"ZIL\":\"ZIL\"}}',1.00000000,1000.00000000,0.0000,0.00000000,1,'','64a9057f0bec51688798591.png',5,'2023-04-02 15:36:14','2023-07-07 14:43:11'),
(1000,'Bank Transfer','bank-transfer','BDT','BDT','{\"AccountNumber\":{\"field_name\":\"AccountNumber\",\"field_level\":\"Account Number\",\"type\":\"text\",\"validation\":\"required\"},\"BeneficiaryName\":{\"field_name\":\"BeneficiaryName\",\"field_level\":\"Beneficiary Name\",\"type\":\"text\",\"validation\":\"required\"},\"NID\":{\"field_name\":\"NID\",\"field_level\":\"NID\",\"type\":\"file\",\"validation\":\"nullable\"},\"Address\":{\"field_name\":\"Address\",\"field_level\":\"Address\",\"type\":\"textarea\",\"validation\":\"nullable\"}}',NULL,84.00000000,NULL,10.00000000,10000.00000000,0.0000,5.00000000,0,'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).','61d16f5313ee41641115475.jpg',1,'2022-01-01 22:18:56','2022-09-09 21:03:51');

/*Table structure for table `identify_forms` */

DROP TABLE IF EXISTS `identify_forms`;

CREATE TABLE `identify_forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `services_form` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `identify_forms` */

insert  into `identify_forms`(`id`,`name`,`slug`,`services_form`,`status`,`created_at`,`updated_at`) values 
(1,'Driving License','driving-license','{\"FrontPage\":{\"field_name\":\"FrontPage\",\"field_level\":\"Front Page\",\"type\":\"file\",\"field_length\":\"2500\",\"length_type\":\"max\",\"validation\":\"required\"},\"RearPage\":{\"field_name\":\"RearPage\",\"field_level\":\"Rear Page\",\"type\":\"file\",\"field_length\":\"2500\",\"length_type\":\"max\",\"validation\":\"required\"},\"PassportNumber\":{\"field_name\":\"PassportNumber\",\"field_level\":\"Passport Number\",\"type\":\"text\",\"field_length\":\"20\",\"length_type\":\"max\",\"validation\":\"required\"},\"Address\":{\"field_name\":\"Address\",\"field_level\":\"Address\",\"type\":\"textarea\",\"field_length\":\"300\",\"length_type\":\"max\",\"validation\":\"required\"}}',1,'2021-09-30 18:07:40','2022-05-17 02:29:36'),
(2,'Passport','passport','{\"PassportNumber\":{\"field_name\":\"PassportNumber\",\"field_level\":\"Passport Number\",\"type\":\"text\",\"field_length\":\"25\",\"length_type\":\"max\",\"validation\":\"required\"},\"PassportImage\":{\"field_name\":\"PassportImage\",\"field_level\":\"Passport Image\",\"type\":\"file\",\"field_length\":\"1040\",\"length_type\":\"max\",\"validation\":\"required\"}}',1,'2021-09-30 18:16:23','2022-05-17 02:29:40'),
(4,'National ID','national-id','{\"FrontPage\":{\"field_name\":\"FrontPage\",\"field_level\":\"Front Page\",\"type\":\"file\",\"field_length\":\"500\",\"length_type\":\"max\",\"validation\":\"required\"},\"RearPage\":{\"field_name\":\"RearPage\",\"field_level\":\"Rear Page\",\"type\":\"file\",\"field_length\":\"500\",\"length_type\":\"max\",\"validation\":\"required\"},\"NidNumber\":{\"field_name\":\"NidNumber\",\"field_level\":\"Nid Number\",\"type\":\"text\",\"field_length\":\"10\",\"length_type\":\"digits\",\"validation\":\"required\"},\"Address\":{\"field_name\":\"Address\",\"field_level\":\"Address\",\"type\":\"textarea\",\"field_length\":\"300\",\"length_type\":\"max\",\"validation\":\"required\"}}',1,'2021-10-01 03:58:40','2022-05-17 02:29:48');

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

insert  into `jobs`(`id`,`queue`,`payload`,`attempts`,`reserved_at`,`available_at`,`created_at`) values 
(1,'default','{\"uuid\":\"3aa13179-d20c-4c1d-963e-a273b82be957\",\"displayName\":\"App\\\\Mail\\\\SendMail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":13:{s:8:\\\"mailable\\\";O:17:\\\"App\\\\Mail\\\\SendMail\\\":31:{s:10:\\\"from_email\\\";s:16:\\\"support@mail.com\\\";s:10:\\\"site_title\\\";s:7:\\\"Betting\\\";s:7:\\\"subject\\\";s:15:\\\"Football player\\\";s:7:\\\"message\\\";s:818:\\\"<h1>\\r\\n                            <\\/h1><h1><\\/h1><p style=\\\"font-style:normal;font-weight:normal;color:rgb(68,168,199);font-size:36px;font-family:bitter, georgia, serif;text-align:center;\\\"> <br \\/><\\/p>\\r\\n                        \\r\\n\\r\\n                        \\r\\n\\r\\n                            <p><strong>Hello pdeveloper10,<\\/strong><\\/p>\\r\\n                            <p><strong><p>hello<\\/p><\\/strong><\\/p>\\r\\n                            <p><br \\/><\\/p>\\r\\n                        \\r\\n\\r\\n                    \\r\\n                \\r\\n            \\r\\n\\r\\n            \\r\\n                \\r\\n                    \\r\\n                        <p style=\\\"font-style:normal;font-weight:normal;color:#ffffff;font-size:16px;font-family:bitter, georgia, serif;text-align:center;\\\">\\r\\n                            2021 ©  All Right Reserved\\r\\n                        <\\/p>\\\";s:6:\\\"locale\\\";N;s:4:\\\"from\\\";a:0:{}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:22:\\\"pdeveloper10@gmail.com\\\";}}s:2:\\\"cc\\\";a:0:{}s:3:\\\"bcc\\\";a:0:{}s:7:\\\"replyTo\\\";a:0:{}s:8:\\\"markdown\\\";N;s:7:\\\"\\u0000*\\u0000html\\\";N;s:4:\\\"view\\\";N;s:8:\\\"textView\\\";N;s:8:\\\"viewData\\\";a:0:{}s:11:\\\"attachments\\\";a:0:{}s:14:\\\"rawAttachments\\\";a:0:{}s:15:\\\"diskAttachments\\\";a:0:{}s:9:\\\"callbacks\\\";a:0:{}s:5:\\\"theme\\\";N;s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";s:29:\\\"\\u0000*\\u0000assertionableRenderStrings\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}',0,NULL,1692262330,1692262330);

/*Table structure for table `kycs` */

DROP TABLE IF EXISTS `kycs`;

CREATE TABLE `kycs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `kyc_type` varchar(20) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=> Approved, 2 => Reject',
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `kycs` */

/*Table structure for table `languages` */

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `flag` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `rtl` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `languages` */

insert  into `languages`(`id`,`name`,`short_name`,`flag`,`is_active`,`rtl`,`created_at`,`updated_at`) values 
(1,'English','US',NULL,1,0,'2021-12-17 05:00:55','2021-12-17 05:00:55'),
(18,'Spanish','ES',NULL,1,0,'2021-12-17 05:00:55','2021-12-17 05:31:02'),
(21,'Hindi','IN',NULL,1,1,'2023-08-16 19:51:26','2023-08-16 19:51:26'),
(22,'Germany','DE',NULL,1,1,'2023-08-17 09:04:21','2023-08-17 09:04:21');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(8,'2020_09_29_074810_create_jobs_table',1),
(32,'2020_11_12_075639_create_transactions_table',6),
(36,'2020_10_14_113046_create_admins_table',9),
(42,'2020_11_24_064711_create_email_templates_table',11),
(48,'2014_10_12_000000_create_users_table',13),
(51,'2020_09_16_103709_create_controls_table',15),
(59,'2021_01_03_061604_create_tickets_table',17),
(60,'2021_01_03_061834_create_ticket_messages_table',18),
(61,'2021_01_03_065607_create_ticket_attachments_table',18),
(62,'2021_01_07_095019_create_funds_table',19),
(66,'2021_01_21_050226_create_languages_table',21),
(69,'2020_12_17_075238_create_sms_controls_table',23),
(70,'2021_01_26_051716_create_site_notifications_table',24),
(72,'2021_01_26_075451_create_notify_templates_table',25),
(73,'2021_01_28_074544_create_contents_table',26),
(74,'2021_01_28_074705_create_content_details_table',26),
(75,'2021_01_28_074829_create_content_media_table',26),
(76,'2021_01_28_074847_create_templates_table',26),
(77,'2021_01_28_074905_create_template_media_table',26),
(83,'2021_02_03_100945_create_subscribers_table',27),
(86,'2021_01_21_101641_add_language_to_email_templates_table',28),
(87,'2021_02_14_064722_create_manage_plans_table',28),
(88,'2021_02_14_072251_create_manage_times_table',29),
(89,'2021_03_09_100340_create_investments_table',30),
(90,'2021_03_13_132414_create_payout_methods_table',31),
(91,'2021_03_13_133534_create_payout_logs_table',32),
(93,'2021_03_18_091710_create_referral_bonuses_table',33),
(94,'2021_10_25_060950_create_money_transfers_table',34),
(96,'2021_03_18_091710_create_users_table',35),
(97,'2022_08_31_054441_create_categories_table',36),
(98,'2022_09_03_045836_create_game_tournaments_table',37),
(99,'2022_09_03_073817_create_game_teams_table',38),
(100,'2022_09_03_100900_add_category_id_to_game_teams_table',39),
(101,'2022_09_07_054503_create_game_matches_table',40),
(102,'2022_09_08_072041_create_game_questions_table',41),
(104,'2022_09_08_100329_create_game_options_table',42),
(105,'2022_09_13_114549_create_bet_invests_table',43),
(106,'2022_09_13_120143_create_bet_multis_table',43),
(107,'2023_07_10_124102_alter_rows_to_table',44);

/*Table structure for table `notify_templates` */

DROP TABLE IF EXISTS `notify_templates`;

CREATE TABLE `notify_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `template_key` varchar(191) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `short_keys` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `notify_for` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=> Admin, 0=> User',
  `lang_code` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notify_templates_language_id_foreign` (`language_id`),
  CONSTRAINT `notify_templates_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notify_templates` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `payout_logs` */

DROP TABLE IF EXISTS `payout_logs`;

CREATE TABLE `payout_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `method_id` int(11) unsigned DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `charge` decimal(11,2) DEFAULT NULL,
  `net_amount` decimal(11,2) DEFAULT NULL,
  `information` text DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `trx_id` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=> pending, 2=> success, 3=> cancel,',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `response_id` varchar(255) DEFAULT NULL,
  `meta_field` text DEFAULT NULL,
  `currency_code` varchar(255) DEFAULT NULL,
  `last_error` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `payout_logs` */

insert  into `payout_logs`(`id`,`user_id`,`method_id`,`amount`,`charge`,`net_amount`,`information`,`feedback`,`trx_id`,`status`,`created_at`,`updated_at`,`response_id`,`meta_field`,`currency_code`,`last_error`) values 
(1,2,1005,2600.00,36.00,2636.00,'{\"receiver\":{\"fieldValue\":\"Joel shaw\",\"type\":\"text\"},\"amount\":{\"fieldValue\":26780.000000000004,\"type\":\"text\"},\"recipient_type\":{\"fieldValue\":\"PAYPAL_ID\",\"type\":\"text\"}}',NULL,'5WK1DFHAASBS',1,'2023-08-17 08:36:11','2023-08-17 08:36:44',NULL,NULL,'SEK',NULL);

/*Table structure for table `payout_methods` */

DROP TABLE IF EXISTS `payout_methods`;

CREATE TABLE `payout_methods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `minimum_amount` decimal(11,2) DEFAULT NULL,
  `maximum_amount` decimal(11,2) DEFAULT NULL,
  `fixed_charge` decimal(11,2) DEFAULT NULL,
  `percent_charge` decimal(11,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `input_form` text NOT NULL,
  `duration` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `bank_name` text DEFAULT NULL,
  `banks` text DEFAULT NULL,
  `parameters` text DEFAULT NULL,
  `extra_parameters` text DEFAULT NULL,
  `currency_lists` text DEFAULT NULL,
  `supported_currency` text DEFAULT NULL,
  `convert_rate` text DEFAULT NULL,
  `is_automatic` tinyint(4) NOT NULL DEFAULT 0,
  `is_sandbox` tinyint(4) NOT NULL DEFAULT 0,
  `environment` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=>test, 1=>live',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1007 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `payout_methods` */

insert  into `payout_methods`(`id`,`name`,`image`,`minimum_amount`,`maximum_amount`,`fixed_charge`,`percent_charge`,`status`,`input_form`,`duration`,`created_at`,`updated_at`,`code`,`description`,`bank_name`,`banks`,`parameters`,`extra_parameters`,`currency_lists`,`supported_currency`,`convert_rate`,`is_automatic`,`is_sandbox`,`environment`) values 
(1,'Wire Transfer','606418e821ad01617172712.jpg',20.00,2000.00,10.00,0.00,1,'{\"email\":{\"field_name\":\"email\",\"field_level\":\"Email\",\"type\":\"text\",\"validation\":\"required\"},\"nid_number\":{\"field_name\":\"nid_number\",\"field_level\":\"NID Number\",\"type\":\"text\",\"validation\":\"required\"},\"passport_number\":{\"field_name\":\"passport_number\",\"field_level\":\"Passport Number\",\"type\":\"text\",\"validation\":\"nullable\"}}','1-2 Hours','2021-12-17 05:02:14','2021-12-17 05:02:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1),
(2,'Bank Transfer','6064181b137c91617172507.jpg',10.00,100.00,10.00,1.00,1,'{\"bank_name\":{\"field_name\":\"bank_name\",\"field_level\":\"Bank Name\",\"type\":\"text\",\"validation\":\"required\"},\"transaction_prove\":{\"field_name\":\"transaction_prove\",\"field_level\":\"Transaction Prove\",\"type\":\"file\",\"validation\":\"required\"},\"your_address\":{\"field_name\":\"your_address\",\"field_level\":\"Your Address\",\"type\":\"textarea\",\"validation\":\"required\"}}','1-2 hours maximum','2021-12-17 05:02:14','2021-12-17 05:02:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,1),
(1000,'Flutterwave','64a911fa47d4f1688801786.jpg',10.00,200000.00,10.00,1.00,1,'[]','1-2 hours maximum','2021-12-16 23:02:14','2023-07-07 15:36:26','flutterwave','Payment will receive within 1 days','{\"0\":{\"NGN BANK\":\"NGN BANK\",\"NGN DOM\":\"NGN DOM\",\"GHS BANK\":\"GHS BANK\",\"KES BANK\":\"KES BANK\",\"ZAR BANK\":\"ZAR BANK\",\"INTL EUR & GBP\":\"INTL EUR & GBP\",\"INTL USD\":\"INTL USD\",\"INTL OTHERS\":\"INTL OTHERS\",\"FRANCOPGONE\":\"FRANCOPGONE\",\"XAF/XOF MOMO\":\"XAF/XOF MOMO\",\"mPesa\":\"mPesa\",\"Rwanda Momo\":\"Rwanda Momo\",\"Uganda Momo\":\"Uganda Momo\",\"Zambia Momo\":\"Zambia Momo\",\"Barter\":\"Barter\",\"FLW\":\"FLW\"}}','[\"NGN BANK\",\"NGN DOM\",\"GHS BANK\",\"INTL USD\"]','{\"Public_Key\":\"FLWPUBK_TEST-5003321b93b251536fd2e7e05232004f-X\",\"Secret_Key\":\"FLWSECK_TEST-d604361e2d4962f4bb2a400c5afefab1-X\",\"Encryption_Key\":\"FLWSECK_TEST817a365e142b\"}',NULL,'{\"USD\":\"USD\",\"KES\":\"KES\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"UGX\":\"UGX\",\"TZS\":\"TZS\"}','{\"USD\":\"USD\",\"KES\":\"KES\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"TZS\":\"TZS\"}','{\"USD\":\"1\",\"KES\":\"124.1\",\"GHS\":\"12.3\",\"NGN\":\"455.06\",\"GBP\":\"0.81\",\"EUR\":\"0.92\",\"TZS\":\"2335\"}',1,0,1),
(1001,'Razorpay','64a912261ac0f1688801830.jpg',10.00,200000.00,10.00,1.00,1,'{\"name\":{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\",\"validation\":\"required\"},\"email\":{\"name\":\"email\",\"label\":\"Email\",\"type\":\"text\",\"validation\":\"required\"},\"ifsc\":{\"name\":\"ifsc\",\"label\":\"IFSC\",\"type\":\"text\",\"validation\":\"required\"},\"account_number\":{\"name\":\"account_number\",\"label\":\"Account number\",\"type\":\"text\",\"validation\":\"required\"}}','1-2 hours maximum','2021-12-16 23:02:14','2023-07-07 15:37:10','razorpay','Payment will receive within 1 days','',NULL,'{\"account_number\":\"7878780080316316\",\"Key_Id\":\"rzp_test_kiOtejPbRZU90E\",\"Key_Secret\":\"osRDebzEqbsE1kbyQJ4y0re7\"}','{\"webhook\":\"payout\"}','{\"INR\":\"INR\"}','{\"INR\":\"INR\"}','{\"INR\":\"70.98\"}',1,0,1),
(1002,'Paystack','64a9120f09adb1688801807.jpg',10.00,200000.00,10.00,1.00,1,'{\"name\":{\"name\":\"name\",\"label\":\"Name\",\"type\":\"text\",\"validation\":\"required\"},\"account_number\":{\"name\":\"account_number\",\"label\":\"Account  Number\",\"type\":\"text\",\"validation\":\"required\"}}','1-2 hours maximum','2021-12-16 23:02:14','2023-07-07 15:36:47','paystack','Payment will receive within 1 days','',NULL,'{\"Public_key\":\"pk_test_60368e68f65e34c4c3076334de0350fdb78c942b\",\"Secret_key\":\"sk_test_afe163363398a752b856d01e2b7be2554d9a2330\"}','{\"webhook\":\"payout\"}','{\"NGN\":\"NGN\",\"GHS\":\"GHS\",\"ZAR\":\"ZAR\"}','{\"NGN\":\"NGN\",\"GHS\":\"GHS\",\"ZAR\":\"ZAR\"}','{\"NGN\":\"455\",\"GHS\":\"2.3\",\"ZAR\":\"17.2\"}',1,0,1),
(1003,'Coinbase','64a911e2ae88b1688801762.png',10.00,200000.00,1.20,1.00,1,'{\"crypto_address\":{\"name\":\"crypto_address\",\"label\":\"Crypto Address\",\"type\":\"text\",\"validation\":\"required\"}}','1-2 hours maximum','2021-12-16 23:02:14','2023-07-07 15:36:05','coinbase','Payment will receive within 1 days','',NULL,'{\"API_Key\":\"5328e8ff2f7fe0bbc7fd6ea593038b08\",\"API_Secret\":\"ACWAncjv2fbMdvPfeJq9U/blqEx1FiItqbUGn+kEPCLbKGP4/iJlPIQDzMmJHHz/Inv1jYANsWDnh3RhHi6HLw==\",\"Api_Passphrase\":\"23xe3opufifi\"}','{\"webhook\":\"payout\"}','{\"BNB\":\"BNB\",\"BTC\":\"BTC\",\"XRP\":\"XRP\",\"ETH\":\"ETH\",\"ETH2\":\"ETH2\",\"USDT\":\"USDT\",\"BCH\":\"BCH\",\"LTC\":\"LTC\",\"XMR\":\"XMR\",\"TON\":\"TON\"}','{\"BNB\":\"BNB\",\"BTC\":\"BTC\",\"XRP\":\"XRP\",\"ETH\":\"ETH\",\"ETH2\":\"ETH2\",\"USDT\":\"USDT\",\"BCH\":\"BCH\",\"LTC\":\"LTC\",\"XMR\":\"XMR\",\"TON\":\"TON\"}','{\"BNB\":\"0.0032866584364651\",\"BTC\":\"4.3438047580189E-5\",\"XRP\":\"2.4317656276014\",\"ETH\":\"0.00060498363899103\",\"ETH2\":\"1\",\"USDT\":\"0.99970684227142\",\"BCH\":\"0.0077663435649339\",\"LTC\":\"0.011189496085365\",\"XMR\":\"0.0056633319909619\",\"TON\":\"0.43646828144729\"}',1,0,1),
(1004,'Perfect Money','64a9121aab5bd1688801818.jpg',10.00,200000.00,10.00,1.00,1,'{\"account_number\":{\"name\":\"account_number\",\"label\":\"Account  Number\",\"type\":\"text\",\"validation\":\"required\"}}','1-2 hours maximum','2021-12-16 23:02:14','2023-07-07 15:36:58','perfectmoney','Payment will receive within 1 days','',NULL,'{\"Passphrase\":\"45P7GN1T8TlRfMRAPCqLArVHz\",\"Account_ID\":\"90016052\",\"Payer_Account\":\"U41722458\"}','','{\"USD\":\"USD\",\"EUR\":\"EUR\"}','{\"USD\":\"USD\",\"EUR\":\"EUR\"}','{\"USD\":\"1\",\"EUR\":\"0.93\"}',1,0,1),
(1005,'Paypal','64a91204424f91688801796.png',10.00,200000.00,10.00,1.00,1,'{\"receiver\":{\"name\":\"receiver\",\"label\":\"Receiver\",\"type\":\"text\",\"validation\":\"required\"}}','1-2 hours maximum','2021-12-16 23:02:14','2023-07-07 15:36:36','paypal','Payment will receive within 1 days','',NULL,'{\"cleint_id\":\"AUrvcotEVWZkksiGir6Ih4PyalQcguQgGN-7We5O1wBny3tg1w6srbQzi6GQEO8lP3yJVha2C6lyivK9\",\"secret\":\"EPx-YEgvjKDRFFu3FAsMue_iUMbMH6jHu408rHdn4iGrUCM8M12t7mX8hghUBAWwvWErBOa4Uppfp0Eh\"}','{\"webhook\":\"payout\"}','{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"USD\"}','{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"USD\"}','{\"AUD\":\"1.44\",\"BRL\":\"5.21\",\"CAD\":\"1.34\",\"CZK\":\"21.99\",\"DKK\":\"6.85\",\"EUR\":\"0.92\",\"HKD\":\"7.83\",\"HUF\":\"361.73\",\"INR\":\"80.98\",\"ILS\":\"3.4\",\"JPY\":\"129.56\",\"MYR\":\"4.29\",\"MXN\":\"18.87\",\"TWD\":\"30.33\",\"NZD\":\"1.55\",\"NOK\":\"9.79\",\"PHP\":\"54.46\",\"PLN\":\"4.14\",\"GBP\":\"0.81\",\"RUB\":\"68.25\",\"SGD\":\"1.32\",\"SEK\":\"10.3\",\"CHF\":\"0.92\",\"THB\":\"32.64\",\"USD\":\"1\"}',1,1,1),
(1006,'Binance','64a9119db33511688801693.png',10.00,200000.00,3.00,2.00,1,'{\"network\":{\"name\":\"network\",\"label\":\"Network\",\"type\":\"text\",\"validation\":\"required\"},\"address\":{\"name\":\"address\",\"label\":\"Address\",\"type\":\"text\",\"validation\":\"required\"}}','1-2 hours maximum','2021-12-16 23:02:14','2023-07-07 15:36:15','binance','Payment will receive within 1 days','',NULL,'{\"API_Key\":\"u7UxJbqJvYKlhygtR0wlC5xOfWWIuNMUHqZrPXkwLC0neRRrC5HHq7CnbdKWacBI\",\"KEY_Secret\":\"5Z00Ecib1MBnGoHs2LxdqPCE4c4UvQ4vZKEweLmySWhvw5jM4BV2nnk0sWL9gNEL\"}','','{\"BNB\":\"BNB\",\"BTC\":\"BTC\",\"XRP\":\"XRP\",\"ETH\":\"ETH\",\"ETH2\":\"ETH2\",\"USDT\":\"USDT\",\"BCH\":\"BCH\",\"LTC\":\"LTC\",\"XMR\":\"XMR\",\"TON\":\"TON\"}','{\"BNB\":\"BNB\",\"BTC\":\"BTC\",\"XRP\":\"XRP\",\"ETH\":\"ETH\",\"ETH2\":\"ETH2\",\"USDT\":\"USDT\",\"BCH\":\"BCH\",\"LTC\":\"LTC\",\"XMR\":\"XMR\",\"TON\":\"TON\"}','{\"BNB\":\"0.0032866584364651\",\"BTC\":\"4.3438047580189E-5\",\"XRP\":\"2.4317656276014\",\"ETH\":\"0.00060498363899103\",\"ETH2\":\"1\",\"USDT\":\"0.99970684227142\",\"BCH\":\"0.0077663435649339\",\"LTC\":\"0.011189496085365\",\"XMR\":\"0.0056633319909619\",\"TON\":\"0.43646828144729\"}',1,1,1);

/*Table structure for table `razorpay_contacts` */

DROP TABLE IF EXISTS `razorpay_contacts`;

CREATE TABLE `razorpay_contacts` (
  `contact_id` varchar(255) DEFAULT NULL,
  `entity` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `razorpay_contacts` */

/*Table structure for table `referral_bonuses` */

DROP TABLE IF EXISTS `referral_bonuses`;

CREATE TABLE `referral_bonuses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) unsigned DEFAULT NULL,
  `to_user_id` int(11) unsigned DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `main_balance` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `transaction` varchar(20) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `remarks` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `referral_bonuses` */

/*Table structure for table `referrals` */

DROP TABLE IF EXISTS `referrals`;

CREATE TABLE `referrals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `commission_type` varchar(30) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `percent` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `referrals` */

/*Table structure for table `site_notifications` */

DROP TABLE IF EXISTS `site_notifications`;

CREATE TABLE `site_notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_notificational_id` int(11) NOT NULL,
  `site_notificational_type` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `site_notifications` */

/*Table structure for table `sms_controls` */

DROP TABLE IF EXISTS `sms_controls`;

CREATE TABLE `sms_controls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `actionMethod` varchar(191) DEFAULT NULL,
  `actionUrl` varchar(191) DEFAULT NULL,
  `headerData` text DEFAULT NULL,
  `paramData` text DEFAULT NULL,
  `formData` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sms_controls` */

insert  into `sms_controls`(`id`,`actionMethod`,`actionUrl`,`headerData`,`paramData`,`formData`,`created_at`,`updated_at`) values 
(1,'POST','https://rest.nexmo.com/sms/json','{\"Content-Type\":\"application\\/x-www-form-urlencoded\"}',NULL,'{\"from\":\"Rownak\",\"text\":\"[[message]]\",\"to\":\"[[receiver]]\",\"api_key\":\"930cc608\",\"api_secret\":\"2pijsaMOUw5YKOK5\"}','2021-12-17 05:02:43','2021-12-17 05:02:43');

/*Table structure for table `subscribers` */

DROP TABLE IF EXISTS `subscribers`;

CREATE TABLE `subscribers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `subscribers` */

insert  into `subscribers`(`id`,`email`,`created_at`,`updated_at`) values 
(12,'pdeveloper10@gmail.com','2023-08-16 20:05:56','2023-08-16 20:05:56');

/*Table structure for table `template_media` */

DROP TABLE IF EXISTS `template_media`;

CREATE TABLE `template_media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section_name` varchar(191) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `template_media_section_name_index` (`section_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `template_media` */

insert  into `template_media`(`id`,`section_name`,`description`,`created_at`,`updated_at`) values 
(6,'about-us','{\"image\":\"630f5985a94bb1661950341.png\"}','2022-08-31 02:52:21','2022-08-31 02:52:21'),
(7,'hero','{\"image\":\"63104bb3103231662012339.jpg\"}','2022-08-31 20:05:39','2022-08-31 20:05:39');

/*Table structure for table `templates` */

DROP TABLE IF EXISTS `templates`;

CREATE TABLE `templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) unsigned DEFAULT NULL,
  `section_name` varchar(191) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `templates` */

insert  into `templates`(`id`,`language_id`,`section_name`,`description`,`created_at`,`updated_at`) values 
(81,1,'about-us','{\"title\":\"A Next-Level Sports Betting\",\"sub_title\":\"Know About Us\",\"description\":\"Our platform has been designed from the ground up to be tailored to the unique form of betting and settlement offered by the blockchain. Follow these simple steps and make profits! Our platform has been designed from the ground up to be tailored to the unique form of betting and settlement offered by the blockchain. Follow these simple steps and make profits!\\r\\n\\r\\nOur platform has been designed from the ground up to be tailored to the unique form of betting and settlement offered by the blockchain. Follow these simple steps and make profits!\\r\\nOur platform has been designed from the ground up to be tailored to the unique form of betting and settlement offered by the blockchain. Follow these simple steps and make profits!\"}','2022-08-31 02:52:21','2022-08-31 02:52:21'),
(82,1,'testimonial','{\"title\":\"Testimonials\",\"sub_title\":\"What Clients Say\",\"short_description\":\"Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deleniti impedit molestias ipsa quo deserunt ipsam eveniet temporibus cupiditate natus praesentium?\"}','2022-08-31 03:02:22','2022-08-31 03:02:22'),
(83,1,'faq','{\"title\":\"Frequently Asked Questions\"}','2022-08-31 03:53:39','2022-08-31 03:53:39'),
(84,1,'blog','{\"title\":\"Our Blogs\"}','2022-08-31 04:01:13','2022-08-31 04:01:13'),
(85,1,'contact-us','{\"heading\":\"Contact Us\",\"sub_heading\":\"Get In Touch With Us\",\"short_description\":\"Give us a call or drop by anytime, we endeavour to answer all enquiries within 24 hours on business days. We will be happy to answer your questions.\",\"address\":\"22 Baker, Germany\",\"house\":\"22 Baker, Germany\",\"email\":\"admin@website.com\",\"phone\":\"+91 86309 33827\",\"footer_short_details\":\"Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore\"}','2022-08-31 19:39:30','2023-08-16 19:43:02'),
(86,1,'hero',NULL,'2022-08-31 20:05:39','2022-08-31 20:05:39'),
(87,18,'about-us','{\"title\":\"Una apuesta deportiva de siguiente nivel\",\"sub_title\":\"Sepa Sobre nosotras\",\"description\":\"Nuestra plataforma ha sido dise\\u00f1ada desde cero para adaptarse a la forma \\u00fanica de apuestas y liquidaci\\u00f3n que ofrece la cadena de bloques. \\u00a1Siga estos sencillos pasos y obtenga beneficios! Nuestra plataforma ha sido dise\\u00f1ada desde cero para adaptarse a la forma \\u00fanica de apuestas y liquidaci\\u00f3n que ofrece la cadena de bloques. \\u00a1Siga estos sencillos pasos y obtenga beneficios! Nuestra plataforma ha sido dise\\u00f1ada desde cero para adaptarse a la forma \\u00fanica de apuestas y liquidaci\\u00f3n que ofrece la cadena de bloques. \\u00a1Siga estos sencillos pasos y obtenga beneficios! Nuestra plataforma ha sido dise\\u00f1ada desde cero para adaptarse a la forma \\u00fanica de apuestas y liquidaci\\u00f3n que ofrece la cadena de bloques. \\u00a1Siga estos sencillos pasos y obtenga beneficios!\"}','2022-09-18 00:55:43','2022-09-18 00:55:43'),
(88,18,'faq','{\"title\":\"Preguntas frecuentes\"}','2022-09-18 00:56:01','2022-09-18 00:56:01'),
(89,18,'blog','{\"title\":\"Nuestras Blogs\"}','2022-09-18 00:57:34','2022-09-18 00:57:34'),
(90,18,'testimonial','{\"title\":\"Testimonios\",\"sub_title\":\"Lo que dicen las clientes\",\"short_description\":\"Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deleniti impedit molestias ipsa quo deserunt ipsam eveniet temporibus cupiditate natus praesentium?\"}','2022-09-18 00:58:47','2022-09-18 00:58:47'),
(91,18,'contact-us','{\"heading\":\"Contacta con nosotras\",\"sub_heading\":\"P\\u00f3ngase en contacto con nosotros\",\"short_description\":\"Ll\\u00e1menos o vis\\u00edtenos en cualquier momento, nos esforzamos por responder todas las consultas dentro de las 24 horas en d\\u00edas h\\u00e1biles. Estaremos encantados de responder a sus preguntas.\",\"address\":\"22 Baker Street, Londres\",\"house\":\"22 Baker Street, London\",\"email\":\"hello@website.com\",\"phone\":\"+44-20-4526-2356\",\"footer_short_details\":\"Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore\"}','2022-09-18 01:00:54','2022-09-18 01:00:54');

/*Table structure for table `ticket_attachments` */

DROP TABLE IF EXISTS `ticket_attachments`;

CREATE TABLE `ticket_attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_message_id` int(11) unsigned DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_attachments_ticket_message_id_foreign` (`ticket_message_id`),
  CONSTRAINT `ticket_attachments_ticket_message_id_foreign` FOREIGN KEY (`ticket_message_id`) REFERENCES `ticket_messages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ticket_attachments` */

/*Table structure for table `ticket_messages` */

DROP TABLE IF EXISTS `ticket_messages`;

CREATE TABLE `ticket_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) unsigned DEFAULT NULL,
  `admin_id` int(11) unsigned DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_messages_ticket_id_foreign` (`ticket_id`),
  KEY `ticket_messages_admin_id_foreign` (`admin_id`),
  CONSTRAINT `ticket_messages_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  CONSTRAINT `ticket_messages_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ticket_messages` */

/*Table structure for table `tickets` */

DROP TABLE IF EXISTS `tickets`;

CREATE TABLE `tickets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(91) DEFAULT NULL,
  `ticket` varchar(191) DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed	',
  `last_reply` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_user_id_foreign` (`user_id`),
  CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tickets` */

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` double(11,2) DEFAULT NULL,
  `charge` decimal(11,2) NOT NULL DEFAULT 0.00,
  `final_balance` varchar(30) DEFAULT NULL,
  `trx_type` varchar(10) DEFAULT NULL,
  `remarks` varchar(191) NOT NULL,
  `trx_id` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `transactions` */

insert  into `transactions`(`id`,`user_id`,`amount`,`charge`,`final_balance`,`trx_type`,`remarks`,`trx_id`,`created_at`,`updated_at`) values 
(1,1,10.00,0.00,'9990','-','Bet in 3 Matches By Bet slip','BYNYVHWVQW7B','2023-08-16 19:30:33','2023-08-16 19:30:33'),
(2,1,253.00,0.00,'9737','-','Bet in 1 Matches By Bet slip','71TQGSUY2GOW','2023-08-16 19:30:42','2023-08-16 19:30:42'),
(3,1,300.00,0.00,'9437','-','Bet in 2 Matches By Bet slip','5PPJE6UA7WDN','2023-08-16 19:30:55','2023-08-16 19:30:55'),
(4,1,478.00,0.00,'8959','-','Bet in 1 Matches By Bet slip','7DEARUGNKT43','2023-08-16 19:31:01','2023-08-16 19:31:01'),
(5,1,1231.00,0.00,'117728','-','Bet in 1 Matches By Bet slip','HHRSNZKQDUOX','2023-08-16 19:52:02','2023-08-16 19:52:02'),
(6,1,567.00,0.00,'117161','-','Bet in 1 Matches By Bet slip','QOVA79SOWJW3','2023-08-16 19:52:09','2023-08-16 19:52:09'),
(7,1,4567.00,0.00,'112594','-','Bet in 1 Matches By Bet slip','TZOBA48G8V9C','2023-08-16 19:52:14','2023-08-16 19:52:14'),
(8,1,3421.00,0.00,'109173','-','Bet in 1 Matches By Bet slip','THFNPDN1SQ71','2023-08-16 19:52:21','2023-08-16 19:52:21'),
(9,1,232.00,0.00,'108941','-','Bet in 1 Matches By Bet slip','BVDNR668RBHU','2023-08-16 19:52:28','2023-08-16 19:52:28'),
(10,1,500.00,0.00,'108441','-','Bet in 1 Matches By Bet slip','XAYXSAOP1GSP','2023-08-16 19:52:35','2023-08-16 19:52:35'),
(11,1,700.00,0.00,'107741','-','Bet in 1 Matches By Bet slip','U2O7HHX5JYD3','2023-08-16 19:52:39','2023-08-16 19:52:39'),
(12,1,5000.00,0.00,'102741','-','Bet in 1 Matches By Bet slip','QJ4ZP5YE8JRD','2023-08-16 19:52:44','2023-08-16 19:52:44'),
(13,1,4200.00,0.00,'98541','-','Bet in 1 Matches By Bet slip','YOGQBOSFGOXT','2023-08-16 19:52:48','2023-08-16 19:52:48'),
(14,1,8000.00,0.00,'90541','-','Bet in 1 Matches By Bet slip','CNSR5EYXDK4M','2023-08-16 19:52:53','2023-08-16 19:52:53'),
(15,1,7000.00,0.00,'83541','-','Bet in 1 Matches By Bet slip','KJTQD24GZGA8','2023-08-16 19:52:57','2023-08-16 19:52:57'),
(16,1,7000.00,0.00,'76541','-','Bet in 1 Matches By Bet slip','F5SY7WMP1192','2023-08-16 19:53:10','2023-08-16 19:53:10'),
(17,1,5000.00,0.00,'71541','-','Bet in 1 Matches By Bet slip','N9NTY2EFG6VW','2023-08-16 19:53:15','2023-08-16 19:53:15'),
(18,1,10000.00,0.00,'61541','-','Bet in 1 Matches By Bet slip','Z1EVUMARKKXB','2023-08-16 19:53:36','2023-08-16 19:53:36'),
(19,1,5000.00,0.00,'56541','-','Bet in 1 Matches By Bet slip','VKKCE1XSYYCE','2023-08-16 19:53:44','2023-08-16 19:53:44'),
(20,1,20000.00,0.00,'36541','-','Bet in 1 Matches By Bet slip','DPVDCRBYDHWG','2023-08-16 19:53:52','2023-08-16 19:53:52'),
(21,1,300.00,0.00,'36241','-','Bet in 1 Matches By Bet slip','SKKYDO7J2WC8','2023-08-16 19:53:58','2023-08-16 19:53:58'),
(22,1,30000.00,0.00,'6241','-','Bet in 1 Matches By Bet slip','GX7OG49ZBVC4','2023-08-16 19:54:44','2023-08-16 19:54:44'),
(23,1,600.00,0.00,'5641','-','Bet in 2 Matches By Bet slip','6UTTONU67CAM','2023-08-16 20:48:35','2023-08-16 20:48:35'),
(24,1,5000.00,0.00,'641','-','Bet in 1 Matches By Bet slip','75XO48S1PRCY','2023-08-16 20:58:33','2023-08-16 20:58:33'),
(25,2,100.00,0.00,'9900','-','Bet in 2 Matches By Bet slip','M8311EWGG7DB','2023-08-17 08:28:29','2023-08-17 08:28:29'),
(26,2,600.00,0.00,'9300','-','Bet in 1 Matches By Bet slip','84KRR5EGVNJS','2023-08-17 08:28:35','2023-08-17 08:28:35'),
(27,2,500.00,0.00,'8800','-','Bet in 1 Matches By Bet slip','B84BNY6GENZT','2023-08-17 08:28:46','2023-08-17 08:28:46'),
(28,2,550.00,0.00,'8250','-','Bet in 1 Matches By Bet slip','WEMCKOOM9ACR','2023-08-17 08:28:52','2023-08-17 08:28:52'),
(29,2,250.00,0.00,'8000','-','Bet in 1 Matches By Bet slip','8ZAQH12W1R5H','2023-08-17 08:29:10','2023-08-17 08:29:10'),
(30,2,700.00,0.00,'7300','-','Bet in 1 Matches By Bet slip','PV17FJXG3KXT','2023-08-17 08:29:16','2023-08-17 08:29:16'),
(31,2,100.00,0.00,'7200','-','Bet in 1 Matches By Bet slip','KZV5RMVFXFRM','2023-08-17 08:29:40','2023-08-17 08:29:40'),
(32,2,620.00,0.00,'6580','-','Bet in 1 Matches By Bet slip','3WT45OQS4GB7','2023-08-17 08:29:46','2023-08-17 08:29:46'),
(33,2,400.00,0.00,'6180','-','Bet in 1 Matches By Bet slip','WZUA925MRB76','2023-08-17 08:29:53','2023-08-17 08:29:53'),
(34,2,700.00,0.00,'5480','-','Bet in 1 Matches By Bet slip','R3GET3EBSUNR','2023-08-17 08:30:07','2023-08-17 08:30:07'),
(35,2,1000.00,0.00,'4480','-','Bet in 1 Matches By Bet slip','39VEQVG6CED2','2023-08-17 08:30:14','2023-08-17 08:30:14'),
(36,2,200.00,0.00,'4280','-','Bet in 1 Matches By Bet slip','YC3XA77BSEBC','2023-08-17 08:30:19','2023-08-17 08:30:19'),
(37,2,500.00,0.00,'3780','-','Bet in 1 Matches By Bet slip','GPSP2J31N4FF','2023-08-17 08:30:24','2023-08-17 08:30:24'),
(38,2,2600.00,36.00,'1144','-','Withdraw Via Paypal','5WK1DFHAASBS','2023-08-17 08:36:44','2023-08-17 08:36:44');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(60) DEFAULT NULL,
  `lastname` varchar(60) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `referral_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `country_code` varchar(20) DEFAULT NULL,
  `phone_code` varchar(20) DEFAULT NULL,
  `phone` varchar(91) DEFAULT NULL,
  `balance` decimal(11,2) NOT NULL DEFAULT 0.00,
  `image` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL,
  `provider_id` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `identity_verify` tinyint(4) NOT NULL COMMENT '	0 => Not Applied, 1=> Applied, 2=> Approved, 3 => Rejected	',
  `address_verify` tinyint(4) NOT NULL COMMENT '0 => Not Applied, 1=> Applied, 2=> Approved, 3 => Rejected	',
  `two_fa` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: two-FA off, 1: two-FA on',
  `two_fa_verify` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: two-FA unverified, 1: two-FA verified',
  `two_fa_code` varchar(50) DEFAULT NULL,
  `email_verification` tinyint(1) NOT NULL DEFAULT 1,
  `sms_verification` tinyint(1) NOT NULL DEFAULT 1,
  `verify_code` varchar(50) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`firstname`,`lastname`,`username`,`referral_id`,`language_id`,`email`,`country_code`,`phone_code`,`phone`,`balance`,`image`,`address`,`provider`,`provider_id`,`status`,`identity_verify`,`address_verify`,`two_fa`,`two_fa_verify`,`two_fa_code`,`email_verification`,`sms_verification`,`verify_code`,`sent_at`,`last_login`,`password`,`email_verified_at`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Joel','Shaw','jacktom',NULL,NULL,'pdeveloper10@gmail.com',NULL,'+1','+1 (804) 706-6419',9641.00,'64dd1159d008a1692209497.jpg',NULL,NULL,NULL,1,0,0,0,1,NULL,1,1,NULL,NULL,'2023-08-17 08:41:32','$2y$10$tMIfxGyzeyxkdYgGwNaHvubbQC.NyENPQX1Aq2E8OdMudo6rttsl6',NULL,NULL,'2023-08-16 18:11:19','2023-08-17 08:41:32'),
(2,'Jack','Tom','demouser',NULL,NULL,'user@gmail.com',NULL,'+49','+49 54522585221',1144.00,'64ddd908e4e131692260616.jpg',NULL,NULL,NULL,1,0,0,0,1,NULL,1,1,NULL,NULL,'2023-08-17 09:18:16','$2y$10$xYTtVOVf1R21DppVCumqZeA9i08Do.T5DDfHuxQz7g4TPCRL.4Xvy',NULL,NULL,'2023-08-17 08:23:23','2023-08-17 09:18:16');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
