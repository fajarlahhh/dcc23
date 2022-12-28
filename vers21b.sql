/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80031
 Source Host           : localhost:55000
 Source Schema         : vers21b

 Target Server Type    : MySQL
 Target Server Version : 80031
 File Encoding         : 65001

 Date: 28/12/2022 05:58:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for balance
-- ----------------------------
DROP TABLE IF EXISTS `balance`;
CREATE TABLE `balance` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `user_id` bigint DEFAULT NULL,
  `withdrawal_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `withdrawal_id` (`withdrawal_id`),
  CONSTRAINT `balance_ibfk_1` FOREIGN KEY (`withdrawal_id`) REFERENCES `withdrawal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of balance
-- ----------------------------
-- ----------------------------
-- Table structure for bonus
-- ----------------------------
DROP TABLE IF EXISTS `bonus`;
CREATE TABLE `bonus` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `description` text,
  `amount` decimal(40,2) DEFAULT NULL,
  `daily_id` bigint DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `withdrawal_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `id_withdrawal` (`withdrawal_id`) USING BTREE,
  KEY `bonus_ibfk_2` (`user_id`) USING BTREE,
  KEY `bonus_ibfk_3` (`daily_id`) USING BTREE,
  CONSTRAINT `bonus_ibfk_1` FOREIGN KEY (`withdrawal_id`) REFERENCES `withdrawal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bonus_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bonus_ibfk_3` FOREIGN KEY (`daily_id`) REFERENCES `daily` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 ROW_FORMAT=DYNAMIC;


-- ----------------------------
-- Table structure for daily
-- ----------------------------
DROP TABLE IF EXISTS `daily`;
CREATE TABLE `daily` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `date` (`date`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of daily
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for deposit
-- ----------------------------
DROP TABLE IF EXISTS `deposit`;
CREATE TABLE `deposit` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `to_wallet` varchar(255) DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `user_id` bigint DEFAULT NULL,
  `from_wallet` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `deposit_ibfk_1` (`user_id`) USING BTREE,
  CONSTRAINT `deposit_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for invalid_turnover
-- ----------------------------
DROP TABLE IF EXISTS `invalid_turnover`;
CREATE TABLE `invalid_turnover` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint DEFAULT NULL,
  `value` int DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `downline_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `invalid_turnover_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of invalid_turnover
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for package
-- ----------------------------
DROP TABLE IF EXISTS `package`;
CREATE TABLE `package` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` int DEFAULT NULL,
  `benefit` int DEFAULT NULL,
  `minimum_withdrawal` double(10,2) DEFAULT NULL,
  `maximum_withdrawal` double(10,2) DEFAULT NULL,
  `fee_withdrawal` double(10,2) DEFAULT NULL,
  `sponsorship_benefits` double(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of package
-- ----------------------------
BEGIN;
INSERT INTO `package` VALUES (1, 'Copper', 100, 250, 15.00, 50.00, 2.00, 10.00, '2022-12-21 00:00:00', '2022-12-21 00:00:00');
INSERT INTO `package` VALUES (2, 'Bronze', 200, 500, 15.00, 100.00, 2.00, 20.00, '2022-12-21 00:00:00', '2022-12-21 00:00:00');
INSERT INTO `package` VALUES (3, 'Silver', 500, 1250, 15.00, 250.00, 2.00, 50.00, '2022-12-21 00:00:00', '2022-12-21 00:00:00');
INSERT INTO `package` VALUES (4, 'Gold', 1000, 2500, 15.00, 500.00, 2.00, 100.00, '2022-12-21 00:00:00', '2022-12-21 00:00:00');
INSERT INTO `package` VALUES (5, 'Platinum', 2000, 5000, 15.00, 1000.00, 2.00, 200.00, '2022-12-21 00:00:00', '2022-12-21 00:00:00');
INSERT INTO `package` VALUES (6, 'Emerald', 5000, 12500, 15.00, 2500.00, 2.00, 500.00, '2022-12-21 00:00:00', '2022-12-21 00:00:00');
INSERT INTO `package` VALUES (7, 'Diamond', 10000, 25000, 15.00, 5000.00, 2.00, 1000.00, '2022-12-21 00:00:00', '2022-12-21 00:00:00');
COMMIT;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `wallet` varchar(255) DEFAULT NULL,
  `network` longtext,
  `phone` varchar(255) NOT NULL,
  `reinvest` tinyint DEFAULT '1',
  `upline_id` bigint DEFAULT NULL,
  `sponsor_id` bigint DEFAULT NULL,
  `package_id` bigint DEFAULT NULL,
  `pin` int DEFAULT NULL,
  `remember_token` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `activated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `member_user` (`username`) USING BTREE,
  KEY `user_ibfk_3` (`upline_id`) USING BTREE,
  KEY `email` (`email`) USING BTREE,
  KEY `user_ibfk_2` (`package_id`) USING BTREE,
  KEY `sponsor_id` (`sponsor_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `package` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`sponsor_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`upline_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES (1, 'mark', '$2y$10$QWyQeEcYXHiqAzq4.9PYV.S2yE0zz0HDV.ECzkX3Rcnh7OnhFBDbe', '1q2w3e4r5t', 'Mark Mineman', 'mark.mineman@gmail', '0x14Bf1DC530174E64B6Aa5AD368b41EBA86b677Aa', NULL, '081081081081', 1, NULL, NULL, 7, 135246, NULL, '2022-12-21 00:00:00', '2022-12-21 00:00:00', '2022-12-24 13:22:59', NULL);

COMMIT;

-- ----------------------------
-- Table structure for withdrawal
-- ----------------------------
DROP TABLE IF EXISTS `withdrawal`;
CREATE TABLE `withdrawal` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `to_wallet` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `fee` decimal(15,2) NOT NULL,
  `txid` text,
  `user_id` bigint NOT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `withdrawal_ibfk_1` (`user_id`) USING BTREE,
  CONSTRAINT `withdrawal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- View structure for user_view
-- ----------------------------
DROP VIEW IF EXISTS `user_view`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `user_view` AS select `a`.`id` AS `id`,`a`.`username` AS `username`,`a`.`name` AS `name`,`a`.`email` AS `email`,`a`.`wallet` AS `wallet`,`a`.`network` AS `network`,`a`.`first_password` AS `first_password`,`a`.`phone` AS `phone`,`a`.`reinvest` AS `reinvest`,`a`.`upline_id` AS `upline_id`,`a`.`sponsor_id` AS `sponsor_id`,`a`.`package_id` AS `package_id`,`a`.`pin` AS `pin`,`a`.`remember_token` AS `remember_token`,`a`.`activated_at` AS `activated_at`,`a`.`created_at` AS `created_at`,`a`.`updated_at` AS `updated_at`,`a`.`deleted_at` AS `deleted_at`,`b`.`value` AS `package` from (`user` `a` left join `package` `b` on((`a`.`package_id` = `b`.`id`)));

SET FOREIGN_KEY_CHECKS = 1;
