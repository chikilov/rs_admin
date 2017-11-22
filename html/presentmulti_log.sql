/*
 Navicat Premium Data Transfer

 Source Server         : RythemStar
 Source Server Type    : MySQL
 Source Server Version : 50630
 Source Host           : 1.234.7.252
 Source Database       : rs_admin

 Target Server Type    : MySQL
 Target Server Version : 50630
 File Encoding         : utf-8

 Date: 07/25/2016 12:50:07 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `presentmulti_log`
-- ----------------------------
DROP TABLE IF EXISTS `presentmulti_log`;
CREATE TABLE `presentmulti_log` (
  `idx` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(5000) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `item_id` varchar(50) DEFAULT NULL,
  `sendtext` int(10) unsigned DEFAULT NULL,
  `admin_memo` varchar(500) DEFAULT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `admin_id` varchar(50) DEFAULT NULL,
  `reg_at` datetime DEFAULT NULL,
  `mongo_key` varchar(20) DEFAULT NULL,
  `logc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
