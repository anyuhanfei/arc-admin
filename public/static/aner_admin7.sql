/*
 Navicat MySQL Data Transfer

 Source Server         : 本地-aner_admin7
 Source Server Type    : MySQL
 Source Server Version : 80032
 Source Host           : localhost:3306
 Source Schema         : aner_admin7

 Target Server Type    : MySQL
 Target Server Version : 80032
 File Encoding         : 65001

 Date: 17/11/2023 15:22:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_extension_histories
-- ----------------------------
DROP TABLE IF EXISTS `admin_extension_histories`;
CREATE TABLE `admin_extension_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL DEFAULT '1',
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_extension_histories_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for admin_extensions
-- ----------------------------
DROP TABLE IF EXISTS `admin_extensions`;
CREATE TABLE `admin_extensions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_enabled` tinyint NOT NULL DEFAULT '0',
  `options` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_extensions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `show` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_menu` VALUES (1, 0, 1, '主页', 'feather icon-bar-chart-2', '/', '', 1, '2023-10-30 08:41:34', '2023-11-17 15:20:59');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '后台系统管理', 'feather icon-settings', NULL, '', 1, '2023-10-30 08:41:34', '2023-11-17 15:21:10');
INSERT INTO `admin_menu` VALUES (3, 2, 3, '管理员管理', NULL, 'auth/users', '', 1, '2023-10-30 08:41:34', '2023-11-17 15:21:21');
INSERT INTO `admin_menu` VALUES (4, 2, 4, '角色管理', NULL, 'auth/roles', '', 1, '2023-10-30 08:41:34', '2023-11-17 15:21:28');
INSERT INTO `admin_menu` VALUES (5, 2, 5, '权限管理', NULL, 'auth/permissions', '', 1, '2023-10-30 08:41:34', '2023-11-17 15:21:34');
INSERT INTO `admin_menu` VALUES (6, 2, 6, '目录管理', NULL, 'auth/menu', '', 1, '2023-10-30 08:41:34', '2023-11-17 15:21:40');
INSERT INTO `admin_menu` VALUES (7, 2, 7, '扩展管理', NULL, 'auth/extensions', '', 1, '2023-10-30 08:41:34', '2023-11-17 15:21:47');
INSERT INTO `admin_menu` VALUES (8, 0, 8, '网站设置', 'fa-connectdevelop', NULL, '', 1, '2023-10-31 09:58:11', '2023-10-31 09:58:11');
INSERT INTO `admin_menu` VALUES (9, 8, 9, '轮播图管理', NULL, 'idx/banner', '', 1, '2023-10-31 10:01:18', '2023-10-31 10:01:18');
INSERT INTO `admin_menu` VALUES (10, 8, 10, '系统设置管理', NULL, 'sys/setting/set', '', 1, '2023-10-31 10:59:34', '2023-10-31 11:55:10');
INSERT INTO `admin_menu` VALUES (11, 8, 11, '系统公告管理', NULL, 'sys/notice', '', 1, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_menu` VALUES (12, 0, 12, '会员管理', 'fa-address-book', NULL, '', 1, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_menu` VALUES (13, 12, 13, '会员管理', NULL, 'users/users', '', 1, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_menu` VALUES (14, 0, 14, '内容管理', 'fa-book', NULL, '', 1, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_menu` VALUES (15, 14, 15, '文章管理', NULL, 'article/article', '', 1, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_menu` VALUES (16, 14, 16, '文章分类管理', NULL, 'article/category', '', 1, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_menu` VALUES (17, 0, 17, '财务管理', 'fa-dollar', NULL, '', 1, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_menu` VALUES (18, 17, 18, '会员资金记录', NULL, 'log/userfund', '', 1, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_menu` VALUES (19, 8, 19, '系统消息管理', NULL, 'log/sysmessage', '', 1, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_menu` VALUES (20, 17, 20, '会员提现管理', NULL, 'log/userwithdraw', '', 1, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
COMMIT;

-- ----------------------------
-- Table structure for admin_permission_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_permission_menu`;
CREATE TABLE `admin_permission_menu` (
  `permission_id` bigint NOT NULL,
  `menu_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_permission_menu_permission_id_menu_id_unique` (`permission_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_permission_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_permission_menu` VALUES (1, 8, '2023-10-31 09:58:11', '2023-10-31 09:58:11');
INSERT INTO `admin_permission_menu` VALUES (1, 9, '2023-10-31 10:01:18', '2023-10-31 10:01:18');
INSERT INTO `admin_permission_menu` VALUES (1, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_permission_menu` VALUES (1, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_permission_menu` VALUES (1, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_permission_menu` VALUES (1, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_permission_menu` VALUES (1, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_permission_menu` VALUES (1, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_permission_menu` VALUES (1, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_permission_menu` VALUES (1, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_permission_menu` VALUES (1, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_permission_menu` VALUES (1, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_permission_menu` VALUES (1, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
INSERT INTO `admin_permission_menu` VALUES (2, 8, '2023-10-31 09:58:11', '2023-10-31 09:58:11');
INSERT INTO `admin_permission_menu` VALUES (2, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_permission_menu` VALUES (2, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_permission_menu` VALUES (2, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_permission_menu` VALUES (2, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_permission_menu` VALUES (2, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_permission_menu` VALUES (2, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_permission_menu` VALUES (2, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_permission_menu` VALUES (2, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_permission_menu` VALUES (2, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_permission_menu` VALUES (2, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_permission_menu` VALUES (2, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
INSERT INTO `admin_permission_menu` VALUES (3, 8, '2023-10-31 09:58:11', '2023-10-31 09:58:11');
INSERT INTO `admin_permission_menu` VALUES (3, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_permission_menu` VALUES (3, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_permission_menu` VALUES (3, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_permission_menu` VALUES (3, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_permission_menu` VALUES (3, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_permission_menu` VALUES (3, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_permission_menu` VALUES (3, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_permission_menu` VALUES (3, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_permission_menu` VALUES (3, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_permission_menu` VALUES (3, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_permission_menu` VALUES (3, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
INSERT INTO `admin_permission_menu` VALUES (4, 8, '2023-10-31 09:58:11', '2023-10-31 09:58:11');
INSERT INTO `admin_permission_menu` VALUES (4, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_permission_menu` VALUES (4, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_permission_menu` VALUES (4, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_permission_menu` VALUES (4, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_permission_menu` VALUES (4, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_permission_menu` VALUES (4, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_permission_menu` VALUES (4, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_permission_menu` VALUES (4, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_permission_menu` VALUES (4, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_permission_menu` VALUES (4, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_permission_menu` VALUES (4, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
INSERT INTO `admin_permission_menu` VALUES (5, 8, '2023-10-31 09:58:11', '2023-10-31 09:58:11');
INSERT INTO `admin_permission_menu` VALUES (5, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_permission_menu` VALUES (5, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_permission_menu` VALUES (5, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_permission_menu` VALUES (5, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_permission_menu` VALUES (5, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_permission_menu` VALUES (5, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_permission_menu` VALUES (5, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_permission_menu` VALUES (5, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_permission_menu` VALUES (5, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_permission_menu` VALUES (5, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_permission_menu` VALUES (5, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
INSERT INTO `admin_permission_menu` VALUES (6, 8, '2023-10-31 09:58:11', '2023-10-31 09:58:11');
INSERT INTO `admin_permission_menu` VALUES (6, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_permission_menu` VALUES (6, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_permission_menu` VALUES (6, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_permission_menu` VALUES (6, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_permission_menu` VALUES (6, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_permission_menu` VALUES (6, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_permission_menu` VALUES (6, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_permission_menu` VALUES (6, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_permission_menu` VALUES (6, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_permission_menu` VALUES (6, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_permission_menu` VALUES (6, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
INSERT INTO `admin_permission_menu` VALUES (7, 8, '2023-10-31 10:02:25', '2023-10-31 10:02:25');
INSERT INTO `admin_permission_menu` VALUES (7, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_permission_menu` VALUES (7, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_permission_menu` VALUES (7, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_permission_menu` VALUES (7, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_permission_menu` VALUES (7, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_permission_menu` VALUES (7, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_permission_menu` VALUES (7, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_permission_menu` VALUES (7, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_permission_menu` VALUES (7, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_permission_menu` VALUES (7, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_permission_menu` VALUES (7, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
INSERT INTO `admin_permission_menu` VALUES (8, 9, '2023-10-31 10:03:05', '2023-10-31 10:03:05');
INSERT INTO `admin_permission_menu` VALUES (8, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_permission_menu` VALUES (8, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_permission_menu` VALUES (8, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_permission_menu` VALUES (8, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_permission_menu` VALUES (8, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_permission_menu` VALUES (8, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_permission_menu` VALUES (8, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_permission_menu` VALUES (8, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_permission_menu` VALUES (8, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_permission_menu` VALUES (8, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_permission_menu` VALUES (8, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
INSERT INTO `admin_permission_menu` VALUES (9, 8, '2023-11-17 15:13:33', '2023-11-17 15:13:33');
INSERT INTO `admin_permission_menu` VALUES (9, 10, '2023-11-17 15:13:33', '2023-11-17 15:13:33');
INSERT INTO `admin_permission_menu` VALUES (10, 8, '2023-11-17 15:14:01', '2023-11-17 15:14:01');
INSERT INTO `admin_permission_menu` VALUES (10, 11, '2023-11-17 15:14:01', '2023-11-17 15:14:01');
INSERT INTO `admin_permission_menu` VALUES (11, 8, '2023-11-17 15:14:32', '2023-11-17 15:14:32');
INSERT INTO `admin_permission_menu` VALUES (11, 19, '2023-11-17 15:14:32', '2023-11-17 15:14:32');
INSERT INTO `admin_permission_menu` VALUES (12, 12, '2023-11-17 15:14:58', '2023-11-17 15:14:58');
INSERT INTO `admin_permission_menu` VALUES (13, 8, '2023-11-17 15:15:39', '2023-11-17 15:15:39');
INSERT INTO `admin_permission_menu` VALUES (13, 19, '2023-11-17 15:15:39', '2023-11-17 15:15:39');
INSERT INTO `admin_permission_menu` VALUES (14, 14, '2023-11-17 15:15:59', '2023-11-17 15:15:59');
INSERT INTO `admin_permission_menu` VALUES (15, 14, '2023-11-17 15:16:27', '2023-11-17 15:16:27');
INSERT INTO `admin_permission_menu` VALUES (15, 15, '2023-11-17 15:16:27', '2023-11-17 15:16:27');
INSERT INTO `admin_permission_menu` VALUES (16, 14, '2023-11-17 15:17:05', '2023-11-17 15:17:05');
INSERT INTO `admin_permission_menu` VALUES (16, 16, '2023-11-17 15:17:05', '2023-11-17 15:17:05');
INSERT INTO `admin_permission_menu` VALUES (17, 17, '2023-11-17 15:17:28', '2023-11-17 15:17:28');
INSERT INTO `admin_permission_menu` VALUES (18, 17, '2023-11-17 15:18:08', '2023-11-17 15:18:08');
INSERT INTO `admin_permission_menu` VALUES (18, 18, '2023-11-17 15:18:08', '2023-11-17 15:18:08');
INSERT INTO `admin_permission_menu` VALUES (19, 17, '2023-11-17 15:18:37', '2023-11-17 15:18:37');
INSERT INTO `admin_permission_menu` VALUES (19, 20, '2023-11-17 15:18:37', '2023-11-17 15:18:37');
COMMIT;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `parent_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_permissions` VALUES (1, '后台系统设置', '后台系统设置', '', '', 1, 0, '2023-10-30 08:41:34', '2023-11-17 15:19:28');
INSERT INTO `admin_permissions` VALUES (2, '管理员管理', '管理员管理', '', '/auth/users*', 2, 1, '2023-10-30 08:41:34', '2023-11-17 15:19:40');
INSERT INTO `admin_permissions` VALUES (3, '角色管理', '角色管理', '', '/auth/roles*', 3, 1, '2023-10-30 08:41:34', '2023-11-17 15:19:54');
INSERT INTO `admin_permissions` VALUES (4, '权限管理', '权限管理', '', '/auth/permissions*', 4, 1, '2023-10-30 08:41:34', '2023-11-17 15:20:05');
INSERT INTO `admin_permissions` VALUES (5, '菜单管理', '菜单管理', '', '/auth/menu*', 5, 1, '2023-10-30 08:41:34', '2023-11-17 15:20:24');
INSERT INTO `admin_permissions` VALUES (6, '扩展管理', '扩展管理', '', '/auth/extensions*', 6, 1, '2023-10-30 08:41:34', '2023-11-17 15:20:35');
INSERT INTO `admin_permissions` VALUES (7, '网站设置', '网站设置', '', '', 7, 0, '2023-10-31 10:02:25', '2023-10-31 10:02:25');
INSERT INTO `admin_permissions` VALUES (8, '轮播图管理', '轮播图管理', '', '/idx/banner/*,/idx/banner', 8, 7, '2023-10-31 10:03:05', '2023-10-31 10:09:02');
INSERT INTO `admin_permissions` VALUES (9, '系统设置管理', '系统设置管理', '', '/sys/setting*,/sys/setting/*', 9, 7, '2023-11-17 15:13:33', '2023-11-17 15:13:33');
INSERT INTO `admin_permissions` VALUES (10, '系统公告管理', '系统公告管理', '', '/sys/notice*,/sys/notice/*', 10, 7, '2023-11-17 15:14:01', '2023-11-17 15:14:01');
INSERT INTO `admin_permissions` VALUES (11, '系统消息管理', '系统消息管理', '', '/log/sysmessage*,/log/sysmessage/*', 11, 7, '2023-11-17 15:14:32', '2023-11-17 15:14:32');
INSERT INTO `admin_permissions` VALUES (12, '会员管理', '会员管理', '', '', 12, 0, '2023-11-17 15:14:58', '2023-11-17 15:14:58');
INSERT INTO `admin_permissions` VALUES (13, '会员列表', '会员列表', '', '/auth/users*,/auth/users/*', 13, 12, '2023-11-17 15:15:39', '2023-11-17 15:15:39');
INSERT INTO `admin_permissions` VALUES (14, '内容管理', '内容管理', '', '', 14, 0, '2023-11-17 15:15:59', '2023-11-17 15:15:59');
INSERT INTO `admin_permissions` VALUES (15, '文章管理', '文章管理', '', '/article/article*,/article/article/*', 15, 14, '2023-11-17 15:16:27', '2023-11-17 15:16:27');
INSERT INTO `admin_permissions` VALUES (16, '文章分类管理', '文章分类管理', '', '/article/category*,/article/category/*', 16, 14, '2023-11-17 15:17:05', '2023-11-17 15:17:05');
INSERT INTO `admin_permissions` VALUES (17, '财务管理', '财务管理', '', '', 17, 0, '2023-11-17 15:17:28', '2023-11-17 15:17:28');
INSERT INTO `admin_permissions` VALUES (18, '会员资金记录', '会员资金记录', '', '/log/userfund*,/log/userfund/*', 18, 17, '2023-11-17 15:18:08', '2023-11-17 15:18:08');
INSERT INTO `admin_permissions` VALUES (19, '会员提现管理', '会员提现管理', '', '/log/userwithdraw*,/log/userwithdraw/*', 19, 17, '2023-11-17 15:18:37', '2023-11-17 15:18:37');
COMMIT;

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu` (
  `role_id` bigint NOT NULL,
  `menu_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_menu_role_id_menu_id_unique` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_menu` VALUES (1, 1, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_menu` VALUES (1, 2, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_menu` VALUES (1, 3, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_menu` VALUES (1, 4, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_menu` VALUES (1, 5, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_menu` VALUES (1, 6, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_menu` VALUES (1, 7, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_menu` VALUES (1, 8, '2023-10-31 09:58:11', '2023-10-31 09:58:11');
INSERT INTO `admin_role_menu` VALUES (1, 9, '2023-10-31 10:01:18', '2023-10-31 10:01:18');
INSERT INTO `admin_role_menu` VALUES (1, 10, '2023-10-31 10:59:34', '2023-10-31 10:59:34');
INSERT INTO `admin_role_menu` VALUES (1, 11, '2023-10-31 13:24:18', '2023-10-31 13:24:18');
INSERT INTO `admin_role_menu` VALUES (1, 12, '2023-10-31 15:11:58', '2023-10-31 15:11:58');
INSERT INTO `admin_role_menu` VALUES (1, 13, '2023-10-31 15:12:21', '2023-10-31 15:12:21');
INSERT INTO `admin_role_menu` VALUES (1, 14, '2023-11-01 09:24:19', '2023-11-01 09:24:19');
INSERT INTO `admin_role_menu` VALUES (1, 15, '2023-11-01 09:24:37', '2023-11-01 09:24:37');
INSERT INTO `admin_role_menu` VALUES (1, 16, '2023-11-01 09:24:55', '2023-11-01 09:24:55');
INSERT INTO `admin_role_menu` VALUES (1, 17, '2023-11-01 11:28:13', '2023-11-01 11:28:13');
INSERT INTO `admin_role_menu` VALUES (1, 18, '2023-11-01 11:28:35', '2023-11-01 11:28:35');
INSERT INTO `admin_role_menu` VALUES (1, 19, '2023-11-03 10:29:08', '2023-11-03 10:29:08');
INSERT INTO `admin_role_menu` VALUES (1, 20, '2023-11-04 14:21:32', '2023-11-04 14:21:32');
COMMIT;

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions` (
  `role_id` bigint NOT NULL,
  `permission_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_permissions` VALUES (1, 2, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_permissions` VALUES (1, 3, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_permissions` VALUES (1, 4, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_permissions` VALUES (1, 5, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_permissions` VALUES (1, 6, '2023-10-31 09:58:47', '2023-10-31 09:58:47');
INSERT INTO `admin_role_permissions` VALUES (1, 8, '2023-10-31 10:03:26', '2023-10-31 10:03:26');
INSERT INTO `admin_role_permissions` VALUES (1, 9, '2023-11-17 15:18:52', '2023-11-17 15:18:52');
INSERT INTO `admin_role_permissions` VALUES (1, 10, '2023-11-17 15:18:52', '2023-11-17 15:18:52');
INSERT INTO `admin_role_permissions` VALUES (1, 11, '2023-11-17 15:18:52', '2023-11-17 15:18:52');
INSERT INTO `admin_role_permissions` VALUES (1, 13, '2023-11-17 15:18:52', '2023-11-17 15:18:52');
INSERT INTO `admin_role_permissions` VALUES (1, 15, '2023-11-17 15:18:52', '2023-11-17 15:18:52');
INSERT INTO `admin_role_permissions` VALUES (1, 16, '2023-11-17 15:18:52', '2023-11-17 15:18:52');
INSERT INTO `admin_role_permissions` VALUES (1, 18, '2023-11-17 15:18:52', '2023-11-17 15:18:52');
INSERT INTO `admin_role_permissions` VALUES (1, 19, '2023-11-17 15:18:52', '2023-11-17 15:18:52');
COMMIT;

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users` (
  `role_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_users_role_id_user_id_unique` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_users` VALUES (1, 1, '2023-10-30 08:41:34', '2023-10-30 08:41:34');
COMMIT;

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
BEGIN;
INSERT INTO `admin_roles` VALUES (1, '超级管理员', 'administrator', '2023-10-30 08:41:34', '2023-10-31 10:56:08');
COMMIT;

-- ----------------------------
-- Table structure for admin_settings
-- ----------------------------
DROP TABLE IF EXISTS `admin_settings`;
CREATE TABLE `admin_settings` (
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
BEGIN;
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$mw5BgR9OBfoX/qFMk.sDDOtTCQzR.WqdeNWYOqjCvER/vo.PcSga2', 'Administrator', NULL, NULL, '2023-10-30 08:41:34', '2023-11-01 09:06:40');
COMMIT;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL COMMENT '文章分类id',
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '简介',
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片',
  `author` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '作者',
  `keyword` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `content` longtext COLLATE utf8mb4_general_ci NOT NULL COMMENT '内容',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章表';

-- ----------------------------
-- Records of article
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES (1, 1, '分类1文章1', '', 'http://localhost/uploads/images/d8a359a7bda285f65990f921f7ca3bbb.jpg', 'admin', '啊打扑克,撒大', '<p>asdasd</p>', '2023-11-01 10:30:32', '2023-11-01 10:30:32', NULL);
INSERT INTO `article` VALUES (2, 2, '分类2文章1', '年前花了点时间，对Yar的性能做了一些做了一些提升，但是也遇到一个让我有点不舒服的当初没有良好设计遗留的问题，就是在并行调用RPC的时候，现在的方法原型是:', 'http://localhost/uploads/images/1250a3bb56b01b8b521e5dc2fe697612.jpg', 'aner', 'PHP5.6,RFC', '<p style=\"box-sizing: border-box; margin: 1.5em 0px; line-height: 1.8em; color: #333333; font-family: font-regular, \'Helvetica Neue\', sans-serif; font-size: 16px; background-color: #ffffff;\">但强迫症让我觉得这样做，遗祸无穷， 今天早上我突然想起以前曾经看到过的一个RFC，于是找了半天，发现早在PHP5.6的时候，就commit了, 但反正我比较老派，新特性研究的少，也是没怎么用过，就不知道大家是否会用过了。 🙂</p>\r\n<p style=\"box-sizing: border-box; margin: 1.5em 0px; line-height: 1.8em; color: #333333; font-family: font-regular, \'Helvetica Neue\', sans-serif; font-size: 16px; background-color: #ffffff;\">就是今天要介绍的第一个特性:Argument unpacking。</p>\r\n<h3 style=\"box-sizing: border-box; margin: 0px; padding: 0px; font-weight: 100; font-size: 1.125em; line-height: 1.333; font-family: font-bold; color: #333333; background-color: #ffffff;\">Argument unpacking</h3>\r\n<p style=\"box-sizing: border-box; margin: 1.5em 0px; line-height: 1.8em; color: #333333; font-family: font-regular, \'Helvetica Neue\', sans-serif; font-size: 16px; background-color: #ffffff;\">我们知道PHP支持可变参数，也就是variadic function. 比如对于如下的函数定义:</p>', '2023-11-01 10:32:08', '2023-11-01 10:32:08', NULL);
COMMIT;

-- ----------------------------
-- Table structure for article_category
-- ----------------------------
DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分类图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='文章分类表';

-- ----------------------------
-- Records of article_category
-- ----------------------------
BEGIN;
INSERT INTO `article_category` VALUES (1, '分类1', 'http://localhost/uploads/images/810b0c2f040dbf412efd78f50bf4fa70.jpg', '2023-11-01 09:34:49', '2023-11-01 09:34:49', NULL);
INSERT INTO `article_category` VALUES (2, '分类2', 'http://localhost/uploads/images/9ebbf66588278e53f7d7025e3f2d8173.jpg', '2023-11-01 10:00:56', '2023-11-01 10:00:56', NULL);
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
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

-- ----------------------------
-- Table structure for idx_banner
-- ----------------------------
DROP TABLE IF EXISTS `idx_banner`;
CREATE TABLE `idx_banner` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '位置',
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '图片',
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '链接',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='轮播图表';

-- ----------------------------
-- Records of idx_banner
-- ----------------------------
BEGIN;
INSERT INTO `idx_banner` VALUES (1, '首页', 'http://localhost/storage/images/08c9855cd21ffd42e8cd7773f2da6bd7.jpg', 'http://www.baidu.com', '2023-10-31 10:10:45', '2023-10-31 10:26:21', '2023-10-31 10:26:21');
INSERT INTO `idx_banner` VALUES (2, '测试页', 'http://localhost/storage/images/b05c9a811a95db977b54dacd16a93a43.jpg', 'http://www.baidu.com', '2023-10-31 10:13:42', '2023-10-31 10:13:42', NULL);
INSERT INTO `idx_banner` VALUES (3, '测试页', 'http://localhost/storage/images/ca2059eb97d1fbc7da846e3ae298c4a6.jpg', 'http://www.baicu.dom', '2023-10-31 10:14:52', '2023-10-31 10:14:52', NULL);
INSERT INTO `idx_banner` VALUES (4, '首页', 'http://localhost/uploads/images/15b4b650e5b2572cd8c1cfa219acf0b3.jpg', '', '2023-10-31 10:20:14', '2023-10-31 10:20:14', NULL);
COMMIT;

-- ----------------------------
-- Table structure for log_sys_message
-- ----------------------------
DROP TABLE IF EXISTS `log_sys_message`;
CREATE TABLE `log_sys_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_ids` varchar(2550) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '会员id集',
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片',
  `content` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '内容',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='系统消息表';

-- ----------------------------
-- Records of log_sys_message
-- ----------------------------
BEGIN;
INSERT INTO `log_sys_message` VALUES (1, '3,4', '测试', 'https://qiniu.tbq11.com/images/cd9905d07f7086106ab3224379a5dbbb.jpg', '<p><img src=\"https://qiniu.tbq11.com/tinymce/images/d23ebe200c7c20483af9dff261018b4e654466e70b9cc.jpg\" alt=\"\" width=\"500\" height=\"500\" />123123</p>', '2023-11-03 11:21:57', '2023-11-04 11:35:13', NULL);
INSERT INTO `log_sys_message` VALUES (2, '3', '', '', '<p>的送i家粉丝哦风景送哦身份哦身份哦色反，顺德评价粉丝搜福袋哦。</p>', '2023-11-03 13:06:19', '2023-11-03 13:06:19', NULL);
INSERT INTO `log_sys_message` VALUES (3, '4', '', '', '递送就是佛is家哦上帝飞机哦死服，撒大积分i哦上帝积分。', '2023-11-03 13:06:45', '2023-11-03 13:06:45', NULL);
INSERT INTO `log_sys_message` VALUES (4, '0', '', '', 'asdadd', '2023-11-04 09:44:01', '2023-11-17 13:06:59', NULL);
INSERT INTO `log_sys_message` VALUES (5, '3,4', '', '', 'asdaasdaasdasdadas', '2023-11-04 11:19:09', '2023-11-04 11:19:09', NULL);
COMMIT;

-- ----------------------------
-- Table structure for log_user_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `log_user_withdraw`;
CREATE TABLE `log_user_withdraw` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL COMMENT '会员id',
  `coin_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '币种',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `content` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '提现说明',
  `remark` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '会员备注',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0=申请中、1=通过、2=驳回',
  `alipay_account` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '支付宝账号',
  `alipay_username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '支付宝实名',
  `wx_account` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '微信账号',
  `wx_username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '微信实名',
  `wx_openid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '微信openid',
  `bank_card_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '银行卡卡号',
  `bank_card_username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '银行卡实名',
  `bank_card_bank` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '银行卡所属银行',
  `bank_card_sub_bank` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '银行卡支行',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='会员提现记录';

-- ----------------------------
-- Records of log_user_withdraw
-- ----------------------------
BEGIN;
INSERT INTO `log_user_withdraw` VALUES (1, 4, 'money', 100.00, 0.00, '', '', 2, '', '', '13939390001', '张三', '', '', '', '', '', '2023-11-06 14:21:48', '2023-11-07 10:30:48', NULL);
INSERT INTO `log_user_withdraw` VALUES (2, 4, 'money', 101.00, 0.00, '资金提现', '', 2, '', '', '13939390001', '张三', '', '', '', '', '', '2023-11-07 10:39:48', '2023-11-07 10:45:43', NULL);
INSERT INTO `log_user_withdraw` VALUES (3, 4, 'money', 102.00, 0.00, '资金提现', '', 3, '', '', '13939390001', '张三', '', '', '', '', '', '2023-11-07 10:39:52', '2023-11-07 10:46:58', NULL);
COMMIT;

-- ----------------------------
-- Table structure for log_users_fund
-- ----------------------------
DROP TABLE IF EXISTS `log_users_fund`;
CREATE TABLE `log_users_fund` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0' COMMENT '会员id',
  `coin_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '币种',
  `fund_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '记录说明',
  `relevance` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '关联数据',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `before_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作前余额',
  `after_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作后余额',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='会员资金记录';

-- ----------------------------
-- Records of log_users_fund
-- ----------------------------
BEGIN;
INSERT INTO `log_users_fund` VALUES (1, 4, 'money', '测试', '', '', 100.00, 200.00, 300.00, '2023-11-01 16:07:05', '2023-11-01 16:07:05', NULL);
INSERT INTO `log_users_fund` VALUES (2, 4, 'money', '测试', '', '', 100.00, 300.00, 400.00, '2023-11-03 10:01:26', '2023-11-03 10:01:26', NULL);
INSERT INTO `log_users_fund` VALUES (3, 4, 'money', '提现申请', '1', '', -100.00, 400.00, 500.00, '2023-11-06 14:21:48', '2023-11-06 14:21:48', NULL);
INSERT INTO `log_users_fund` VALUES (4, 4, 'money', '提现申请', '2', '', -101.00, 500.00, 601.00, '2023-11-07 10:39:48', '2023-11-07 10:39:48', NULL);
INSERT INTO `log_users_fund` VALUES (5, 4, 'money', '提现申请', '3', '', -102.00, 601.00, 703.00, '2023-11-07 10:39:52', '2023-11-07 10:39:52', NULL);
INSERT INTO `log_users_fund` VALUES (9, 4, 'money', '提现申请驳回', '3', '', 102.00, 703.00, 805.00, '2023-11-07 10:46:58', '2023-11-07 10:46:58', NULL);
COMMIT;

-- ----------------------------
-- Table structure for log_users_pay
-- ----------------------------
DROP TABLE IF EXISTS `log_users_pay`;
CREATE TABLE `log_users_pay` (
  `out_trade_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT '支付流水号',
  `user_id` int NOT NULL DEFAULT '0' COMMENT '会员id',
  `pay_method` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '支付方式',
  `pay_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '支付用途',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `status` tinyint(1) NOT NULL COMMENT '状态(0=未支付、1=已支付、2=已退款)',
  `relevance` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '关联数据',
  `out_refund_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '退款流水号',
  `refund_at` datetime DEFAULT NULL COMMENT '退款时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`out_trade_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户支付记录';

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_01_04_173148_create_admin_tables', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (6, '2020_09_07_090635_create_admin_settings_table', 1);
INSERT INTO `migrations` VALUES (7, '2020_09_22_015815_create_admin_extensions_table', 1);
INSERT INTO `migrations` VALUES (8, '2020_11_01_083237_update_admin_menu_table', 1);
COMMIT;

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for sys_notice
-- ----------------------------
DROP TABLE IF EXISTS `sys_notice`;
CREATE TABLE `sys_notice` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '公告id',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '内容',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='系统公告表';

-- ----------------------------
-- Records of sys_notice
-- ----------------------------
BEGIN;
INSERT INTO `sys_notice` VALUES (15, '测试', '<p>12313</p>\r\n<p>asdfasfsdfsf</p>', 'http://localhost/uploads/images/5eb2f99df67a44110ecf167fac665b10.jpg', '2023-10-31 13:38:34', '2023-10-31 14:26:22', NULL);
INSERT INTO `sys_notice` VALUES (16, '撒大', '', 'http://localhost/uploads/images/a03f4d00b35f523a74cd33b8ab59a307.jpg', '2023-10-31 14:34:34', '2023-10-31 14:34:34', NULL);
COMMIT;

-- ----------------------------
-- Table structure for sys_setting
-- ----------------------------
DROP TABLE IF EXISTS `sys_setting`;
CREATE TABLE `sys_setting` (
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '键',
  `value` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '值',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='网站设置表';

-- ----------------------------
-- Records of sys_setting
-- ----------------------------
BEGIN;
INSERT INTO `sys_setting` VALUES ('', '', '2023-10-31 13:10:53', '2023-10-31 13:10:53', NULL);
INSERT INTO `sys_setting` VALUES ('t1', 'a1', '2023-10-31 13:03:04', '2023-10-31 13:04:36', NULL);
INSERT INTO `sys_setting` VALUES ('test1', '12343535111', '2023-10-31 11:41:08', '2023-10-31 13:04:36', NULL);
INSERT INTO `sys_setting` VALUES ('test_image', 'https://qiniu.tbq11.com/images/66dc246588b61bb0213498361607a6b2.jpg', '2023-10-31 13:09:46', '2023-11-17 11:40:04', NULL);
INSERT INTO `sys_setting` VALUES ('test_number', '3', '2023-10-31 13:09:46', '2023-11-17 11:40:04', NULL);
INSERT INTO `sys_setting` VALUES ('test_onoff', '1', '2023-10-31 13:09:46', '2023-11-17 11:40:04', NULL);
INSERT INTO `sys_setting` VALUES ('test_radio', '选项1', '2023-10-31 13:09:46', '2023-11-17 11:40:04', NULL);
INSERT INTO `sys_setting` VALUES ('test_select', '选项1', '2023-10-31 13:09:46', '2023-11-17 11:40:04', NULL);
INSERT INTO `sys_setting` VALUES ('test_text', '123123', '2023-10-31 13:09:05', '2023-11-17 11:40:04', NULL);
INSERT INTO `sys_setting` VALUES ('withdraw_minimum_amount', '100', '2023-11-06 10:31:26', '2023-11-17 11:40:04', NULL);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `account` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '账号',
  `phone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `parent_user_id` int NOT NULL DEFAULT '0' COMMENT '上级会员id',
  `unionid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `openid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `login_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '登录状态(0=冻结、1=正常)',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='会员表';

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (3, 'http://localhost/uploads/images/a44988c4d0613843ad1c971e80d5bf3d.jpg', '测试001', '13939390001', '13939390001', '', '$2y$10$SsPpG4PiTuQWt18Am/.kVuFh9khHUq6zV9uWy/KSVtav5ZzU5zz2G', 0, '', '', 1, '2023-11-06 16:25:25', '2023-10-31 16:30:29', NULL);
INSERT INTO `users` VALUES (4, 'https://qiniu.tbq11.com/images/aa1a08ba1eeac3bfabfdf405b22c68fb.jpg', 'testtest', 'testtest', '', '', '$2y$10$mliww4ufYBg67OOizWP3sueAuJ9gxW.MhhoWNZgq5e9cFFobcQNxu', 0, '', '', 0, '2023-11-07 15:27:26', '2023-11-17 10:40:52', NULL);
INSERT INTO `users` VALUES (5, 'https://qiniu.tbq11.com/images/8755b2af58875b1fb128193235413dd3.jpg', '13939390002', '', '13939390002', '', '$2y$10$crycFHX2aq1HoRtm9g0ujOwjdv8xbIpxqwA6Y4qitMiceGKcmH4Zu', 0, '', '', 1, '2023-11-07 15:29:03', '2023-11-09 10:41:05', NULL);
INSERT INTO `users` VALUES (6, 'https://qiniu.tbq11.com/images/c1863ff9aaaccd3f2c25a7375753dbfe.jpg', '13939390003', '', '13939390003', '', '$2y$10$TOrNKWL0AHKlXdMy3iNJb.H/SQzbOQXDtR4BQ1dU1wqEfO9a4OKaC', 0, '', '', 0, '2023-11-08 15:34:15', '2023-11-09 10:46:19', NULL);
COMMIT;

-- ----------------------------
-- Table structure for users_detail
-- ----------------------------
DROP TABLE IF EXISTS `users_detail`;
CREATE TABLE `users_detail` (
  `id` int NOT NULL,
  `sex` enum('未知','男','女') COLLATE utf8mb4_general_ci DEFAULT '未知' COMMENT '性别',
  `birthday` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '生日',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='会员信息详情表';

-- ----------------------------
-- Records of users_detail
-- ----------------------------
BEGIN;
INSERT INTO `users_detail` VALUES (3, '未知', NULL);
INSERT INTO `users_detail` VALUES (4, '未知', NULL);
INSERT INTO `users_detail` VALUES (5, '未知', NULL);
INSERT INTO `users_detail` VALUES (6, '未知', NULL);
COMMIT;

-- ----------------------------
-- Table structure for users_fund
-- ----------------------------
DROP TABLE IF EXISTS `users_fund`;
CREATE TABLE `users_fund` (
  `id` int NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `integral` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='会员资金表';

-- ----------------------------
-- Records of users_fund
-- ----------------------------
BEGIN;
INSERT INTO `users_fund` VALUES (3, 10000.00, 1000.00);
INSERT INTO `users_fund` VALUES (4, 805.00, 0.00);
INSERT INTO `users_fund` VALUES (5, 0.00, 0.00);
INSERT INTO `users_fund` VALUES (6, 0.00, 0.00);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
