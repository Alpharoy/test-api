/*
 Navicat Premium Data Transfer

 Source Server         : 192.168.99.45
 Source Server Type    : MySQL
 Source Server Version : 80017
 Source Host           : 192.168.99.45:3306
 Source Schema         : dev_ojms

 Target Server Type    : MySQL
 Target Server Version : 80017
 File Encoding         : 65001

 Date: 17/10/2019 14:55:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for 1_demo
-- ----------------------------
DROP TABLE IF EXISTS `1_demo`;
CREATE TABLE `1_demo`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `admin_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理公司UUID',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  `user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户姓名',
  `user_phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户手机号码',
  `user_type` tinyint(3) UNSIGNED NOT NULL COMMENT '管理员类型',
  `is_open` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, '2019-09-20 15:50:14', '2019-09-23 20:12:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11314892421432', '10314892421441', 'OJMS1', '18999999999', 10, 1);
INSERT INTO `admin_users` VALUES (2, '2019-09-23 17:48:11', '2019-10-16 14:49:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11314919049122', '10314919049142', 'OJMS211', '18888888888', 10, 1);
INSERT INTO `admin_users` VALUES (3, '2019-09-24 11:26:30', '2019-09-24 11:26:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11314919049122', '10314925399105', '1567', '16777777777', 20, 1);

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `admin_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '管理公司UUID',
  `admin_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '管理企业名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, '2019-09-20 15:50:14', '2019-09-20 16:50:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11314892421432', 'OJMS管理平台');
INSERT INTO `admins` VALUES (2, '2019-09-23 17:48:10', '2019-09-23 17:48:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11314919049122', 'OJMS管理平台2');

-- ----------------------------
-- Table structure for contracts
-- ----------------------------
DROP TABLE IF EXISTS `contracts`;
CREATE TABLE `contracts`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `contract_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '合同UUID',
  `contract_no` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '合同编码',
  `contract_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '合同名称',
  `supplier_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商UUID',
  `supplier_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商名称',
  `enterprise_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '企业UUID',
  `enterprise_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '企业名称',
  `self_employ_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '个体工商户UUID',
  `self_employ_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '个体工商户名称',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '自然人用户UUID',
  `user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户姓名',
  `group` tinyint(3) NOT NULL COMMENT '签约分组（企业/个体户/自然人）',
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '签约状态',
  `attachment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '附件内容',
  `introduce` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '详细描述',
  `valid_time` timestamp(0) NULL DEFAULT NULL COMMENT '合约有效期',
  `applicant_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '申请人姓名',
  `is_valid` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '当前合约是否有效（展示最新合约）',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '供应商与企业的合同记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contracts
-- ----------------------------
INSERT INTO `contracts` VALUES (1, '2019-09-25 11:37:38', '2019-09-27 10:55:06', NULL, NULL, '11414934105873', '2222', '合同1', '11214919007392', '供应商1', '11114926757511', '天霸111', NULL, '', NULL, NULL, 0, 30, NULL, NULL, '2019-09-26 17:44:57', 'huwenjun', NULL);
INSERT INTO `contracts` VALUES (2, '2019-09-26 17:35:08', '2019-09-27 10:55:08', NULL, NULL, '20114944890848', '22323', '22', '11214926728184', '有棵树', '11114926757511', '天霸111', NULL, '', NULL, NULL, 0, 30, NULL, NULL, NULL, '2342', NULL);
INSERT INTO `contracts` VALUES (3, '2019-09-26 17:37:55', '2019-09-26 17:37:55', NULL, NULL, '20114944907563', NULL, '111333', '11214926728184', '有棵树', '11114926757511', '天霸111', NULL, '', NULL, NULL, 0, 10, NULL, NULL, NULL, '444', NULL);
INSERT INTO `contracts` VALUES (4, '2019-09-26 17:38:49', '2019-09-26 17:38:49', NULL, NULL, '20114944913037', NULL, '222', '11214926728184', '有棵树', '11114926757511', '天霸111', NULL, '', NULL, NULL, 0, 10, NULL, NULL, NULL, '676', NULL);
INSERT INTO `contracts` VALUES (5, '2019-09-26 17:40:37', '2019-09-26 17:40:37', NULL, NULL, '20114944923847', NULL, '3434', '11214926728184', '有棵树', '11114926757511', '天霸111', NULL, '', NULL, NULL, 0, 10, NULL, NULL, NULL, '4545', NULL);
INSERT INTO `contracts` VALUES (6, '2019-09-26 17:44:08', '2019-09-26 17:44:08', NULL, NULL, '20114944944886', '12313', 'heheeh', '11214919007392', '供应商1', '11114926757511', '天霸111', NULL, '', NULL, NULL, 0, 10, NULL, NULL, NULL, '333', NULL);
INSERT INTO `contracts` VALUES (7, '2019-09-26 17:45:56', '2019-09-26 17:45:56', NULL, NULL, '20114944955722', '2323', 'eeee', '11214926728184', '有棵树', '11114926757511', '天霸111', NULL, '', NULL, NULL, 0, 10, NULL, NULL, NULL, '2323', NULL);
INSERT INTO `contracts` VALUES (8, '2019-09-28 18:55:43', '2019-09-28 19:13:13', NULL, NULL, '20114962654441', '11', 'ht', '11214962643427', '2', '11114954432048', '1', NULL, '', NULL, NULL, 0, 99, '[{\"name\":\"bugs.png\",\"code\":\"97a50dcc86e8fde154c0c23c553934cb\"}]', NULL, '2019-09-30 00:00:00', '22', 1);
INSERT INTO `contracts` VALUES (9, '2019-10-14 10:48:38', '2019-10-14 11:01:57', NULL, NULL, '20115097971919', '233', '111', '11214962643427', '2', '11114926751800', '天霸', NULL, NULL, NULL, NULL, 10, 99, '[]', NULL, '2019-10-31 00:00:00', '22', 1);

-- ----------------------------
-- Table structure for enterprise_relation_natural_person
-- ----------------------------
DROP TABLE IF EXISTS `enterprise_relation_natural_person`;
CREATE TABLE `enterprise_relation_natural_person`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `enterprise_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '企业UUID',
  `enterprise_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '企业名称',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '保存企业是否有记录可查看自然人的信息记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of enterprise_relation_natural_person
-- ----------------------------
INSERT INTO `enterprise_relation_natural_person` VALUES (1, '2019-10-09 17:45:07', '2019-10-09 17:45:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926757511', '天吧', '10315056743882');

-- ----------------------------
-- Table structure for enterprise_relation_self_employ
-- ----------------------------
DROP TABLE IF EXISTS `enterprise_relation_self_employ`;
CREATE TABLE `enterprise_relation_self_employ`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `enterprise_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '企业UUID',
  `enterprise_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '企业名称',
  `self_employ_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '个体工商户UUID',
  `self_employ_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '个体工商户名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '保存企业是否有记录可查看个体户的信息记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of enterprise_relation_self_employ
-- ----------------------------
INSERT INTO `enterprise_relation_self_employ` VALUES (1, '2019-10-08 18:50:09', '2019-10-08 19:02:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926757511', '天霸111', '11515047579708', '11111');

-- ----------------------------
-- Table structure for enterprise_users
-- ----------------------------
DROP TABLE IF EXISTS `enterprise_users`;
CREATE TABLE `enterprise_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `enterprise_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '企业UUID',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  `user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户姓名',
  `user_phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户手机号码',
  `user_type` tinyint(3) UNSIGNED NOT NULL COMMENT '管理员类型',
  `is_open` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of enterprise_users
-- ----------------------------
INSERT INTO `enterprise_users` VALUES (1, '2019-09-24 14:50:54', '2019-09-24 14:50:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926625430', '10114926625461', NULL, '18271266261', 10, 1);
INSERT INTO `enterprise_users` VALUES (2, '2019-09-24 14:53:21', '2019-09-24 14:53:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926640155', '10114926640200', NULL, '18271266262', 10, 1);
INSERT INTO `enterprise_users` VALUES (3, '2019-09-24 15:11:57', '2019-09-24 15:11:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926751800', '10114926751820', NULL, '18209090909', 10, 1);
INSERT INTO `enterprise_users` VALUES (4, '2019-09-24 15:12:54', '2019-09-24 15:12:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926757511', '10114926757520', NULL, '18209090908', 10, 1);
INSERT INTO `enterprise_users` VALUES (5, '2019-09-25 18:42:57', '2019-10-16 14:58:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926751800', '10114936657826', '12223', '18212341234', 20, 1);
INSERT INTO `enterprise_users` VALUES (6, '2019-09-25 19:40:03', '2019-09-26 10:30:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926757511', '10114937000403', '2233', '13000000000', 20, 1);
INSERT INTO `enterprise_users` VALUES (7, '2019-09-26 11:15:35', '2019-09-26 11:15:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926757511', '10114942613643', '11111444', '13412121212', 20, 1);
INSERT INTO `enterprise_users` VALUES (8, '2019-09-26 11:44:23', '2019-09-26 11:44:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926757511', '10114942786447', '4444', '18011111111', 20, 1);
INSERT INTO `enterprise_users` VALUES (9, '2019-09-26 14:10:51', '2019-09-26 14:10:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114943665207', '10114943665261', 'ttt', '18211111111', 10, 1);
INSERT INTO `enterprise_users` VALUES (10, '2019-09-26 14:44:22', '2019-09-26 14:44:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114926757511', '10114943866388', '胡文軍1', '13477474643', 20, 1);
INSERT INTO `enterprise_users` VALUES (11, '2019-09-27 20:05:19', '2019-09-27 20:11:15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114954432048', '10114954432115', '233', '12222222222', 10, 1);
INSERT INTO `enterprise_users` VALUES (12, '2019-09-27 20:11:30', '2019-09-27 20:11:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11114954432048', '10114954469233', '1', '13211111111', 20, 1);

-- ----------------------------
-- Table structure for enterprises
-- ----------------------------
DROP TABLE IF EXISTS `enterprises`;
CREATE TABLE `enterprises`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `enterprise_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '企业UUID',
  `enterprise_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '企业名称',
  `industry_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型编码',
  `industry_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型名称',
  `location_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '所在区域编码',
  `location_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '所在区域名称',
  `usci_number` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '统一信用代码',
  `artificial_person_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人姓名',
  `artificial_person_phone_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人手机号码',
  `artificial_person_certificate_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件类型编码',
  `artificial_person_certificate_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件类型名称',
  `artificial_person_certificate_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件号码',
  `business_scope` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '经营范围',
  `business_address` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '经营地址',
  `telephone` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '企业电话',
  `contact_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人姓名',
  `contact_phone_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人手机号码',
  `introduce` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '介绍',
  `tax_identification_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '纳税人识别号',
  `invoice_title` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发票抬头',
  `bank_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行名称',
  `bank_account` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行账号',
  `bank_reserve_mobile_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行预留手机号码',
  `invoice_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发票单位地址',
  `artificial_person_certificate_photo_front` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件照正面',
  `artificial_person_certificate_photo_back` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件照背面',
  `business_license_photo` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '营业执照照片',
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '状态',
  `email` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '邮箱',
  `source_from` tinyint(3) UNSIGNED NOT NULL COMMENT '创建来源',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建者UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建者姓名',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改者UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改者姓名',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '企业记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of enterprises
-- ----------------------------
INSERT INTO `enterprises` VALUES (1, '2019-09-24 14:50:54', '2019-10-14 17:34:13', NULL, NULL, '11114926625430', '企业1', 'B', '采矿业', '110000', '北京', '78475847543', 'erere', '18271266261', '10', '社会团体法人登记证书(社会团体 )', '53849583945839453', 'dfd', 'sz', '18271266261', 'erer', '18271266261', 'erewrwer', NULL, '3453', 'esfsdfsadf', '3453534535', '18271266261', 'sdfsadf', 'd223d300f36305e0e4a8775241a06a57', '0f14f0145efec81606ed6c40be0053d8', 'd223d300f36305e0e4a8775241a06a57', 99, NULL, 10, '10314892421441', 'OJMS1', NULL, NULL, '2019-09-24 14:50:54');
INSERT INTO `enterprises` VALUES (2, '2019-09-24 14:53:21', '2019-10-14 17:34:15', NULL, NULL, '11114926640155', '企业111', 'B', '采矿业', '110000', '北京', '7847584754322', 'erere', '18271266261', '10', '社会团体法人登记证书(社会团体 )', '53849583945839453', 'dfd', 'sz', '18271266261', 'erer', '18271266261', 'erewrwer', NULL, '3453', 'esfsdfsadf', '3453534535', '18271266261', 'sdfsadf', 'd223d300f36305e0e4a8775241a06a57', '0f14f0145efec81606ed6c40be0053d8', 'd223d300f36305e0e4a8775241a06a57', 99, NULL, 10, '10314892421441', 'OJMS1', NULL, NULL, '2019-09-24 14:53:21');
INSERT INTO `enterprises` VALUES (3, '2019-09-24 15:11:57', '2019-10-14 17:34:17', NULL, NULL, '11114926751800', '天霸', 'B', '采矿业', '110000', '北京', '546456546', '56566', '13409898990', '20', '居民身份证(个人)', '889612313131', '123213', '231231', '18209090909', '12313', '18209090909', '让34', NULL, '34535', '34232', '4353', '18209090909', '23424', 'd223d300f36305e0e4a8775241a06a57', 'fb23c744947b2d15aa0693cc6dca2470', 'd223d300f36305e0e4a8775241a06a57', 99, NULL, 10, '10314892421441', 'OJMS1', NULL, NULL, '2019-09-24 15:11:57');
INSERT INTO `enterprises` VALUES (4, '2019-09-24 15:12:54', '2019-10-14 17:34:19', NULL, NULL, '11114926757511', '天霸111', 'B', '采矿业', '110000', '北京', '54645654644', '56566', '13409898990', '20', '居民身份证(个人)', '889612313131', '123213', '231231', '18209090909', '12313', '18209090909', '让34', NULL, '34535', '34232', '4353', '18209090909', '23424222', 'd223d300f36305e0e4a8775241a06a57', 'fb23c744947b2d15aa0693cc6dca2470', 'd223d300f36305e0e4a8775241a06a57', 99, NULL, 10, '10314892421441', 'OJMS1', '10314892421441', 'OJMS1', '2019-09-25 13:40:19');
INSERT INTO `enterprises` VALUES (5, '2019-09-26 14:10:51', '2019-09-26 14:10:51', NULL, NULL, '11114943665207', '2222', NULL, NULL, '110000', '北京', '333', '333', '13411111111', NULL, NULL, '232323', '222', '232323', '13411111111', '2323', '13411111111', '111', NULL, '2323', '211231', '2323', '13433333333', '2323', NULL, NULL, NULL, 99, NULL, 10, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `enterprises` VALUES (6, '2019-09-27 20:05:19', '2019-09-29 17:42:05', NULL, NULL, '11114954432048', '1', NULL, NULL, NULL, NULL, '2', '3', NULL, '20', '港澳通行证', '111', NULL, '2222', NULL, '4', '13222222222', NULL, '5', '5', '5', '5', '12222222222', '5', NULL, NULL, '19dca4800a8da2975570fb34d02463cb', 80, NULL, 10, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for login_logs
-- ----------------------------
DROP TABLE IF EXISTS `login_logs`;
CREATE TABLE `login_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户UUID',
  `ip` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '登录IP',
  `login_type` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '登录方式',
  `login_group` char(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '登录分组',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '登录记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of login_logs
-- ----------------------------
INSERT INTO `login_logs` VALUES (1, '2019-09-20 15:53:44', '2019-09-20 15:53:44', NULL, NULL, '10314892421441', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (2, '2019-09-21 10:00:55', '2019-09-21 10:00:55', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (3, '2019-09-23 17:48:28', '2019-09-23 17:48:28', NULL, NULL, '10314919049142', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (4, '2019-09-24 08:55:44', '2019-09-24 08:55:44', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (5, '2019-09-24 09:52:18', '2019-09-24 09:52:18', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (6, '2019-09-24 10:04:04', '2019-09-24 10:04:04', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (7, '2019-09-24 13:36:21', '2019-09-24 13:36:21', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (8, '2019-09-24 14:08:22', '2019-09-24 14:08:22', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (9, '2019-09-24 14:10:47', '2019-09-24 14:10:47', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (10, '2019-09-24 14:13:52', '2019-09-24 14:13:52', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (11, '2019-09-24 14:54:48', '2019-09-24 14:54:48', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (12, '2019-09-24 15:09:22', '2019-09-24 15:09:22', NULL, NULL, '10214926732838', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (13, '2019-09-24 15:13:27', '2019-09-24 15:13:27', NULL, NULL, '10114926757520', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (14, '2019-09-24 16:08:44', '2019-09-24 16:08:44', NULL, NULL, '10114926757520', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (15, '2019-09-25 11:24:51', '2019-09-25 11:24:51', NULL, NULL, '10114926757520', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (16, '2019-09-26 18:23:08', '2019-09-26 18:23:08', NULL, NULL, '10114926757520', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (17, '2019-09-27 11:01:17', '2019-09-27 11:01:17', NULL, NULL, '10214926732838', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (18, '2019-09-28 15:12:55', '2019-09-28 15:12:55', NULL, NULL, '10114954469233', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (19, '2019-09-28 18:53:02', '2019-09-28 18:53:02', NULL, NULL, '10314892421441', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (20, '2019-09-28 18:54:13', '2019-09-28 18:54:13', NULL, NULL, '10214962643458', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (21, '2019-10-08 18:02:49', '2019-10-08 18:02:49', NULL, NULL, '10114926757520', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (22, '2019-10-08 19:09:17', '2019-10-08 19:09:17', NULL, NULL, '10214926732838', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (23, '2019-10-09 13:39:05', '2019-10-09 13:39:05', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (24, '2019-10-09 15:16:27', '2019-10-09 15:16:27', NULL, NULL, '10314892421441', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (25, '2019-10-09 15:29:22', '2019-10-09 15:29:22', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (26, '2019-10-11 15:55:56', '2019-10-11 15:55:56', NULL, NULL, '10314892421441', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (27, '2019-10-11 15:57:49', '2019-10-11 15:57:49', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (28, '2019-10-11 15:57:57', '2019-10-11 15:57:57', NULL, NULL, '10314892421441', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (29, '2019-10-11 15:58:19', '2019-10-11 15:58:19', NULL, NULL, '10314892421441', '192.168.33.1', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (30, '2019-10-11 15:58:27', '2019-10-11 15:58:27', NULL, NULL, '10314919049142', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (31, '2019-10-12 17:43:02', '2019-10-12 17:43:02', NULL, NULL, '10214962643458', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (32, '2019-10-14 10:37:13', '2019-10-14 10:37:13', NULL, NULL, '10114936657826', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (33, '2019-10-16 14:47:42', '2019-10-16 14:47:42', NULL, NULL, '10314919049142', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (34, '2019-10-16 14:55:52', '2019-10-16 14:55:52', NULL, NULL, '10314919049142', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (35, '2019-10-16 14:56:20', '2019-10-16 14:56:20', NULL, NULL, '10314919049142', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (36, '2019-10-16 14:58:03', '2019-10-16 14:58:03', NULL, NULL, '10214962643458', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (37, '2019-10-16 14:59:48', '2019-10-16 14:59:48', NULL, NULL, '10114936657826', '192.168.99.199', '密码登录', 'web');
INSERT INTO `login_logs` VALUES (38, '2019-10-17 14:13:48', '2019-10-17 14:13:48', NULL, NULL, '10214962643458', '192.168.99.199', '密码登录', 'web');

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `group` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分组',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '操作用户UUID',
  `ip` char(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '操作者IP',
  `method` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '请求方式',
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '请求完整的url',
  `request` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '请求完整的参数',
  `use_time` double UNSIGNED NULL DEFAULT NULL COMMENT '请求用时',
  `route_uri` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路由请求uri',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 303 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '日志记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES (1, '2019-10-09 15:16:27', '2019-10-09 15:16:27', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.620182991027832, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (2, '2019-10-09 15:16:30', '2019-10-09 15:16:30', NULL, '', 'admin.web', '10314892421441', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises', '[]', 0.27748918533325195, 'admin-api/enterprises');
INSERT INTO `logs` VALUES (3, '2019-10-11 15:55:44', '2019-10-11 15:55:44', NULL, '', 'admin.web', '', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises', '[]', 0.8530168533325195, 'admin-api/enterprises');
INSERT INTO `logs` VALUES (4, '2019-10-11 15:55:56', '2019-10-11 15:55:56', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.7683510780334473, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (5, '2019-10-11 15:57:50', '2019-10-11 15:57:50', NULL, '', 'admin.web', '', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs', '[]', 0.22200393676757812, 'admin-api/self-employs');
INSERT INTO `logs` VALUES (6, '2019-10-11 15:57:57', '2019-10-11 15:57:57', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.6223869323730469, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (7, '2019-10-11 15:58:00', '2019-10-11 15:58:00', NULL, '', 'admin.web', '10314892421441', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs', '[]', 0.25621795654296875, 'admin-api/self-employs');
INSERT INTO `logs` VALUES (8, '2019-10-11 15:58:06', '2019-10-11 15:58:06', NULL, '', 'admin.web', '10314892421441', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/admins', '[]', 0.2440791130065918, 'admin-api/admins');
INSERT INTO `logs` VALUES (9, '2019-10-11 15:58:09', '2019-10-11 15:58:09', NULL, '', 'admin.web', '10314892421441', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/admin-users', '[]', 0.2029120922088623, 'admin-api/admin-users');
INSERT INTO `logs` VALUES (10, '2019-10-11 15:58:12', '2019-10-11 15:58:12', NULL, '', 'admin.web', '10314892421441', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/admin-users/10314892421441/login-logs?page=1', '{\"page\":\"1\"}', 0.21782302856445312, 'admin-api/admin-users/{userUUID}/login-logs');
INSERT INTO `logs` VALUES (11, '2019-10-11 15:58:21', '2019-10-11 15:58:21', NULL, '', 'admin.web', '', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/admin-users/10314919049142/login-logs?page=1', '{\"page\":\"1\"}', 0.17804813385009766, 'admin-api/admin-users/{userUUID}/login-logs');
INSERT INTO `logs` VALUES (12, '2019-10-11 15:58:27', '2019-10-11 15:58:27', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.548353910446167, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (13, '2019-10-11 15:58:30', '2019-10-11 15:58:30', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs', '[]', 0.20785307884216309, 'admin-api/self-employs');
INSERT INTO `logs` VALUES (14, '2019-10-11 15:58:38', '2019-10-11 15:58:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs/11515064918100', '[]', 0.19514107704162598, 'admin-api/self-employs/{selfEmployUUID}');
INSERT INTO `logs` VALUES (15, '2019-10-12 17:42:36', '2019-10-12 17:42:36', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/suppliers', '[]', 0.29043102264404297, 'admin-api/suppliers');
INSERT INTO `logs` VALUES (16, '2019-10-12 17:42:39', '2019-10-12 17:42:39', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/suppliers/11214919007392/supplier-users', '[]', 0.30719804763793945, 'admin-api/suppliers/{supplierUUID}/supplier-users');
INSERT INTO `logs` VALUES (17, '2019-10-12 17:42:42', '2019-10-12 17:42:42', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/suppliers/11214962643427/supplier-users', '[]', 0.21369099617004395, 'admin-api/suppliers/{supplierUUID}/supplier-users');
INSERT INTO `logs` VALUES (18, '2019-10-12 17:42:54', '2019-10-12 17:42:54', NULL, '', 'supplier.web', '', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.1805419921875, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (19, '2019-10-12 17:43:02', '2019-10-12 17:43:02', NULL, '', 'supplier.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/login-tokens', '[]', 0.7548220157623291, 'supplier-api/login-tokens');
INSERT INTO `logs` VALUES (20, '2019-10-12 17:43:06', '2019-10-12 17:43:06', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.21161389350891113, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (21, '2019-10-12 17:43:50', '2019-10-12 17:43:50', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.20498895645141602, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (22, '2019-10-12 17:44:53', '2019-10-12 17:44:53', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.2030649185180664, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (23, '2019-10-12 17:46:05', '2019-10-12 17:46:05', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.2019820213317871, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (24, '2019-10-12 17:46:17', '2019-10-12 17:46:17', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.28203582763671875, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (25, '2019-10-12 17:46:21', '2019-10-12 17:46:21', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.20666193962097168, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (26, '2019-10-12 17:46:40', '2019-10-12 17:46:40', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.20361709594726562, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (27, '2019-10-12 17:50:09', '2019-10-12 17:50:09', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.2051689624786377, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (28, '2019-10-12 17:50:38', '2019-10-12 17:50:38', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.19953417778015137, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (29, '2019-10-12 17:51:16', '2019-10-12 17:51:16', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.20795702934265137, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (30, '2019-10-12 17:51:20', '2019-10-12 17:51:20', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":\"A\",\"is_open\":true,\"supplier_subject_name\":\"1\",\"introduce\":\"2\"}', 0.348513126373291, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (31, '2019-10-12 17:57:45', '2019-10-12 17:57:45', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":\"A\",\"is_open\":true,\"supplier_subject_name\":\"1\",\"introduce\":\"2\"}', 0.4286208152770996, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (32, '2019-10-12 17:57:46', '2019-10-12 17:57:46', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.2074589729309082, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (33, '2019-10-12 17:58:20', '2019-10-12 17:58:20', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.20835113525390625, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (34, '2019-10-12 17:59:01', '2019-10-12 17:59:01', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.29813194274902344, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (35, '2019-10-12 17:59:07', '2019-10-12 17:59:07', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/supplier-subjects/12015083266597', '{\"supplier_uuid\":\"11214962643427\",\"supplier_subject_uuid\":\"12015083266597\",\"supplier_subject_name\":\"1\",\"industry_type_code\":\"A\",\"industry_type_name\":\"\\u519c\\u3001\\u6797\\u3001\\u7267\\u3001\\u6e14\\u4e1a\",\"introduce\":\"3333\",\"is_open\":false}', 0.3801710605621338, 'supplier-api/supplier-subjects/{supplierSubjectUUID}');
INSERT INTO `logs` VALUES (36, '2019-10-12 18:00:19', '2019-10-12 18:00:19', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.23209881782531738, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (37, '2019-10-12 18:00:23', '2019-10-12 18:00:23', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/supplier-subjects/12015083266597', '{\"supplier_uuid\":\"11214962643427\",\"supplier_subject_uuid\":\"12015083266597\",\"supplier_subject_name\":\"1\",\"industry_type_code\":\"A\",\"industry_type_name\":\"\\u519c\\u3001\\u6797\\u3001\\u7267\\u3001\\u6e14\\u4e1a\",\"introduce\":\"2\",\"is_open\":true}', 0.3716440200805664, 'supplier-api/supplier-subjects/{supplierSubjectUUID}');
INSERT INTO `logs` VALUES (38, '2019-10-12 18:00:57', '2019-10-12 18:00:57', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/supplier-subjects/12015083266597', '{\"supplier_uuid\":\"11214962643427\",\"supplier_subject_uuid\":\"12015083266597\",\"supplier_subject_name\":\"1\",\"industry_type_code\":\"A\",\"industry_type_name\":\"\\u519c\\u3001\\u6797\\u3001\\u7267\\u3001\\u6e14\\u4e1a\",\"introduce\":\"333\",\"is_open\":false}', 0.2811579704284668, 'supplier-api/supplier-subjects/{supplierSubjectUUID}');
INSERT INTO `logs` VALUES (39, '2019-10-12 18:03:52', '2019-10-12 18:03:52', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.2612650394439697, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (40, '2019-10-12 18:03:58', '2019-10-12 18:03:58', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/supplier-subjects/12015083266597', '{\"supplier_uuid\":\"11214962643427\",\"supplier_subject_uuid\":\"12015083266597\",\"supplier_subject_name\":\"1\",\"industry_type_code\":\"A\",\"industry_type_name\":\"\\u519c\\u3001\\u6797\\u3001\\u7267\\u3001\\u6e14\\u4e1a\",\"introduce\":\"22\",\"is_open\":true}', 0.40181589126586914, 'supplier-api/supplier-subjects/{supplierSubjectUUID}');
INSERT INTO `logs` VALUES (41, '2019-10-12 18:15:08', '2019-10-12 18:15:08', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/supplier-subjects/12015083266597', '{\"supplier_uuid\":\"11214962643427\",\"supplier_subject_uuid\":\"12015083266597\",\"supplier_subject_name\":\"1\",\"industry_type_code\":\"A\",\"industry_type_name\":\"\\u519c\\u3001\\u6797\\u3001\\u7267\\u3001\\u6e14\\u4e1a\",\"introduce\":\"22\",\"is_open\":true}', 0.2986481189727783, 'supplier-api/supplier-subjects/{supplierSubjectUUID}');
INSERT INTO `logs` VALUES (42, '2019-10-12 18:15:08', '2019-10-12 18:15:08', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.2106339931488037, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (43, '2019-10-12 18:15:13', '2019-10-12 18:15:13', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/supplier-subjects/12015083266597', '{\"supplier_uuid\":\"11214962643427\",\"supplier_subject_uuid\":\"12015083266597\",\"supplier_subject_name\":\"1\",\"industry_type_code\":\"A\",\"industry_type_name\":\"\\u519c\\u3001\\u6797\\u3001\\u7267\\u3001\\u6e14\\u4e1a\",\"introduce\":\"3333\",\"is_open\":false}', 0.2745859622955322, 'supplier-api/supplier-subjects/{supplierSubjectUUID}');
INSERT INTO `logs` VALUES (44, '2019-10-12 18:15:14', '2019-10-12 18:15:14', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.2080681324005127, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (45, '2019-10-12 18:24:58', '2019-10-12 18:24:58', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":\"A\",\"is_open\":true,\"supplier_subject_name\":\"1\",\"introduce\":\"222\"}', 0.26944804191589355, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (46, '2019-10-12 18:25:01', '2019-10-12 18:25:01', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":\"B\",\"is_open\":true,\"supplier_subject_name\":\"1\",\"introduce\":\"222\"}', 0.49639391899108887, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (47, '2019-10-12 18:25:02', '2019-10-12 18:25:02', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.326646089553833, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (48, '2019-10-12 18:51:27', '2019-10-12 18:51:27', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.20691704750061035, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (49, '2019-10-14 09:33:30', '2019-10-14 09:33:30', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.42923998832702637, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (50, '2019-10-14 09:33:46', '2019-10-14 09:33:46', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/suppliers', '[]', 0.38680410385131836, 'admin-api/suppliers');
INSERT INTO `logs` VALUES (51, '2019-10-14 10:36:32', '2019-10-14 10:36:32', NULL, '', 'enterprise.web', '', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/suppliers?audit_status=99&with_contract=1', '{\"audit_status\":\"99\",\"with_contract\":\"1\"}', 0.2559778690338135, 'enterprise-api/suppliers');
INSERT INTO `logs` VALUES (52, '2019-10-14 10:36:37', '2019-10-14 10:36:37', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises', '[]', 0.23005890846252441, 'admin-api/enterprises');
INSERT INTO `logs` VALUES (53, '2019-10-14 10:36:41', '2019-10-14 10:36:41', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises/11114926625430/enterprise-users', '[]', 0.3021810054779053, 'admin-api/enterprises/{enterpriseUUID}/enterprise-users');
INSERT INTO `logs` VALUES (54, '2019-10-14 10:36:53', '2019-10-14 10:36:53', NULL, '', 'enterprise.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/enterprise-api/login-tokens', '[]', 0.3597579002380371, 'enterprise-api/login-tokens');
INSERT INTO `logs` VALUES (55, '2019-10-14 10:36:58', '2019-10-14 10:36:58', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises/11114926640155/enterprise-users', '[]', 0.2079920768737793, 'admin-api/enterprises/{enterpriseUUID}/enterprise-users');
INSERT INTO `logs` VALUES (56, '2019-10-14 10:37:00', '2019-10-14 10:37:00', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises/11114926625430/enterprise-users', '[]', 0.22501802444458008, 'admin-api/enterprises/{enterpriseUUID}/enterprise-users');
INSERT INTO `logs` VALUES (57, '2019-10-14 10:37:03', '2019-10-14 10:37:03', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises/11114926640155/enterprise-users', '[]', 0.20150089263916016, 'admin-api/enterprises/{enterpriseUUID}/enterprise-users');
INSERT INTO `logs` VALUES (58, '2019-10-14 10:37:05', '2019-10-14 10:37:05', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises/11114926751800/enterprise-users', '[]', 0.2174668312072754, 'admin-api/enterprises/{enterpriseUUID}/enterprise-users');
INSERT INTO `logs` VALUES (59, '2019-10-14 10:37:13', '2019-10-14 10:37:13', NULL, '', 'enterprise.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/enterprise-api/login-tokens', '[]', 0.6382710933685303, 'enterprise-api/login-tokens');
INSERT INTO `logs` VALUES (60, '2019-10-14 10:37:17', '2019-10-14 10:37:17', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/suppliers?audit_status=99&with_contract=1', '{\"audit_status\":\"99\",\"with_contract\":\"1\"}', 0.30009007453918457, 'enterprise-api/suppliers');
INSERT INTO `logs` VALUES (61, '2019-10-14 10:37:20', '2019-10-14 10:37:20', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.24957799911499023, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (62, '2019-10-14 10:37:21', '2019-10-14 10:37:21', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts', '[]', 0.19773197174072266, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (63, '2019-10-14 10:37:33', '2019-10-14 10:37:33', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.2574880123138428, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (64, '2019-10-14 10:37:35', '2019-10-14 10:37:35', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/suppliers?audit_status=99&with_contract=1', '{\"audit_status\":\"99\",\"with_contract\":\"1\"}', 0.23757004737854004, 'enterprise-api/suppliers');
INSERT INTO `logs` VALUES (65, '2019-10-14 10:37:39', '2019-10-14 10:37:39', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises', '[]', 0.2421131134033203, 'enterprise-api/enterprises');
INSERT INTO `logs` VALUES (66, '2019-10-14 10:37:40', '2019-10-14 10:37:40', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.1974630355834961, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (67, '2019-10-14 10:37:43', '2019-10-14 10:37:43', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts', '[]', 0.20238494873046875, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (68, '2019-10-14 10:45:59', '2019-10-14 10:45:59', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/suppliers?audit_status=99&with_contract=1', '{\"audit_status\":\"99\",\"with_contract\":\"1\"}', 0.2986738681793213, 'enterprise-api/suppliers');
INSERT INTO `logs` VALUES (69, '2019-10-14 10:46:03', '2019-10-14 10:46:03', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers', '[]', 0.21737289428710938, 'supplier-api/suppliers');
INSERT INTO `logs` VALUES (70, '2019-10-14 10:46:14', '2019-10-14 10:46:14', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'POST', 'http://ojms-api.com/enterprise-api/contracts', '{\"supplier_name\":\"2\",\"attachment\":[],\"can_update\":true,\"supplier_uuid\":\"11214962643427\",\"contract_name\":\"111\",\"applicant_name\":\"22\",\"contract_no\":\"233\",\"valid_time\":\"2019-10-31T00:00:00+08:00\"}', 0.2886991500854492, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (71, '2019-10-14 10:46:55', '2019-10-14 10:46:55', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'POST', 'http://ojms-api.com/enterprise-api/contracts', '{\"supplier_name\":\"2\",\"attachment\":[],\"can_update\":true,\"supplier_uuid\":\"11214962643427\",\"contract_name\":\"111\",\"applicant_name\":\"22\",\"contract_no\":\"233\",\"valid_time\":\"2019-10-31T00:00:00+08:00\"}', 0.2264699935913086, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (72, '2019-10-14 10:48:38', '2019-10-14 10:48:38', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'POST', 'http://ojms-api.com/enterprise-api/contracts', '{\"supplier_name\":\"2\",\"attachment\":[],\"can_update\":true,\"supplier_uuid\":\"11214962643427\",\"contract_name\":\"111\",\"applicant_name\":\"22\",\"contract_no\":\"233\",\"valid_time\":\"2019-10-31T00:00:00+08:00\"}', 0.3690369129180908, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (73, '2019-10-14 10:48:38', '2019-10-14 10:48:38', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/suppliers?audit_status=99&with_contract=1', '{\"audit_status\":\"99\",\"with_contract\":\"1\"}', 0.20902514457702637, 'enterprise-api/suppliers');
INSERT INTO `logs` VALUES (74, '2019-10-14 10:48:42', '2019-10-14 10:48:42', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.19481587409973145, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (75, '2019-10-14 10:48:44', '2019-10-14 10:48:44', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts', '[]', 0.20568394660949707, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (76, '2019-10-14 10:48:45', '2019-10-14 10:48:45', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/supplier-subjects?supplier_uuid=11214962643427', '{\"supplier_uuid\":\"11214962643427\"}', 0.21674180030822754, 'enterprise-api/supplier-subjects');
INSERT INTO `logs` VALUES (77, '2019-10-14 10:49:45', '2019-10-14 10:49:45', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.19711804389953613, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (78, '2019-10-14 10:49:46', '2019-10-14 10:49:46', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts', '[]', 0.21178102493286133, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (79, '2019-10-14 10:50:17', '2019-10-14 10:50:17', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.2018570899963379, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (80, '2019-10-14 10:50:19', '2019-10-14 10:50:19', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts', '[]', 0.21055006980895996, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (81, '2019-10-14 10:50:21', '2019-10-14 10:50:21', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/supplier-subjects?supplier_uuid=11214962643427', '{\"supplier_uuid\":\"11214962643427\"}', 0.22691106796264648, 'enterprise-api/supplier-subjects');
INSERT INTO `logs` VALUES (82, '2019-10-14 10:51:23', '2019-10-14 10:51:23', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.7030777931213379, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (83, '2019-10-14 10:51:24', '2019-10-14 10:51:24', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts?audit_status=99&is_valid=1', '{\"audit_status\":\"99\",\"is_valid\":\"1\"}', 0.20104098320007324, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (84, '2019-10-14 11:01:52', '2019-10-14 11:01:52', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/contracts', '[]', 0.354079008102417, 'supplier-api/contracts');
INSERT INTO `logs` VALUES (85, '2019-10-14 11:01:55', '2019-10-14 11:01:55', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/contracts/20115097971919', '[]', 0.25680112838745117, 'supplier-api/contracts/{contractUUID}');
INSERT INTO `logs` VALUES (86, '2019-10-14 11:01:58', '2019-10-14 11:01:58', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/contracts/20115097971919/audit-status', '{\"audit_status\":99}', 0.3029608726501465, 'supplier-api/contracts/{contractUUID}/audit-status');
INSERT INTO `logs` VALUES (87, '2019-10-14 11:01:58', '2019-10-14 11:01:58', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/contracts', '[]', 0.2166731357574463, 'supplier-api/contracts');
INSERT INTO `logs` VALUES (88, '2019-10-14 11:02:00', '2019-10-14 11:02:00', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers', '[]', 0.23629093170166016, 'supplier-api/suppliers');
INSERT INTO `logs` VALUES (89, '2019-10-14 11:02:01', '2019-10-14 11:02:01', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.46892499923706055, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (90, '2019-10-14 11:02:06', '2019-10-14 11:02:06', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.22188711166381836, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (91, '2019-10-14 11:02:07', '2019-10-14 11:02:07', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts?audit_status=99&is_valid=1', '{\"audit_status\":\"99\",\"is_valid\":\"1\"}', 0.2572591304779053, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (92, '2019-10-14 11:02:09', '2019-10-14 11:02:09', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/supplier-subjects?supplier_uuid=11214962643427', '{\"supplier_uuid\":\"11214962643427\"}', 0.19469308853149414, 'enterprise-api/supplier-subjects');
INSERT INTO `logs` VALUES (93, '2019-10-14 11:02:31', '2019-10-14 11:02:31', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/supplier-subjects/12015083266597', '{\"supplier_uuid\":\"11214962643427\",\"supplier_subject_uuid\":\"12015083266597\",\"supplier_subject_name\":\"1\",\"industry_type_code\":\"A\",\"industry_type_name\":\"\\u519c\\u3001\\u6797\\u3001\\u7267\\u3001\\u6e14\\u4e1a\",\"introduce\":\"3333\",\"is_open\":true}', 2.5356180667877197, 'supplier-api/supplier-subjects/{supplierSubjectUUID}');
INSERT INTO `logs` VALUES (94, '2019-10-14 11:02:31', '2019-10-14 11:02:31', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.2519869804382324, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (95, '2019-10-14 11:02:35', '2019-10-14 11:02:35', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts?audit_status=99&is_valid=1', '{\"audit_status\":\"99\",\"is_valid\":\"1\"}', 0.33481717109680176, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (96, '2019-10-14 11:02:36', '2019-10-14 11:02:36', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/supplier-subjects?supplier_uuid=11214962643427', '{\"supplier_uuid\":\"11214962643427\"}', 0.2154831886291504, 'enterprise-api/supplier-subjects');
INSERT INTO `logs` VALUES (97, '2019-10-14 11:02:45', '2019-10-14 11:02:45', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":\"A\",\"is_open\":true,\"supplier_subject_name\":\"333\",\"introduce\":\"444\"}', 0.431318998336792, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (98, '2019-10-14 11:02:48', '2019-10-14 11:02:48', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":null,\"is_open\":true}', 0.2906208038330078, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (99, '2019-10-14 11:02:54', '2019-10-14 11:02:54', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":\"B\",\"is_open\":true,\"supplier_subject_name\":\"3344\",\"introduce\":\"55\"}', 0.24707698822021484, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (100, '2019-10-14 11:03:06', '2019-10-14 11:03:06', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":\"B\",\"is_open\":true,\"supplier_subject_name\":\"3344\",\"introduce\":\"444\"}', 0.5128087997436523, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (101, '2019-10-14 11:03:50', '2019-10-14 11:03:50', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/supplier-subjects', '{\"industry_type_code\":\"B\",\"is_open\":true,\"supplier_subject_name\":\"3344\",\"introduce\":\"444\"}', 0.5570111274719238, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (102, '2019-10-14 11:03:51', '2019-10-14 11:03:51', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/supplier-subjects', '[]', 0.4231910705566406, 'supplier-api/supplier-subjects');
INSERT INTO `logs` VALUES (103, '2019-10-14 11:03:54', '2019-10-14 11:03:54', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/projects', '[]', 0.27544188499450684, 'enterprise-api/projects');
INSERT INTO `logs` VALUES (104, '2019-10-14 11:03:56', '2019-10-14 11:03:56', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/contracts?audit_status=99&is_valid=1', '{\"audit_status\":\"99\",\"is_valid\":\"1\"}', 0.3570699691772461, 'enterprise-api/contracts');
INSERT INTO `logs` VALUES (105, '2019-10-14 11:03:58', '2019-10-14 11:03:58', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/supplier-subjects?supplier_uuid=11214962643427', '{\"supplier_uuid\":\"11214962643427\"}', 0.2978329658508301, 'enterprise-api/supplier-subjects');
INSERT INTO `logs` VALUES (106, '2019-10-14 11:17:44', '2019-10-14 11:17:44', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/suppliers?audit_status=99&with_contract=1', '{\"audit_status\":\"99\",\"with_contract\":\"1\"}', 0.21849703788757324, 'enterprise-api/suppliers');
INSERT INTO `logs` VALUES (107, '2019-10-14 11:17:46', '2019-10-14 11:17:46', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises', '[]', 0.2410430908203125, 'enterprise-api/enterprises');
INSERT INTO `logs` VALUES (108, '2019-10-14 13:43:05', '2019-10-14 13:43:05', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises', '[]', 0.2818429470062256, 'admin-api/enterprises');
INSERT INTO `logs` VALUES (109, '2019-10-14 16:32:07', '2019-10-14 16:32:07', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises', '[]', 0.29234790802001953, 'enterprise-api/enterprises');
INSERT INTO `logs` VALUES (110, '2019-10-14 16:32:15', '2019-10-14 16:32:15', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprise-users', '[]', 0.3967280387878418, 'enterprise-api/enterprise-users');
INSERT INTO `logs` VALUES (111, '2019-10-14 16:32:19', '2019-10-14 16:32:19', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises/11114926751800', '[]', 0.22600889205932617, 'enterprise-api/enterprises/{enterpriseUUID}');
INSERT INTO `logs` VALUES (112, '2019-10-14 16:33:15', '2019-10-14 16:33:15', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises', '[]', 0.23709797859191895, 'enterprise-api/enterprises');
INSERT INTO `logs` VALUES (113, '2019-10-14 16:34:22', '2019-10-14 16:34:22', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises', '[]', 0.23501086235046387, 'enterprise-api/enterprises');
INSERT INTO `logs` VALUES (114, '2019-10-14 16:34:24', '2019-10-14 16:34:24', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises', '[]', 0.34304189682006836, 'enterprise-api/enterprises');
INSERT INTO `logs` VALUES (115, '2019-10-14 16:34:25', '2019-10-14 16:34:25', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprise-users', '[]', 0.23232197761535645, 'enterprise-api/enterprise-users');
INSERT INTO `logs` VALUES (116, '2019-10-14 16:34:28', '2019-10-14 16:34:28', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises/11114926751800', '[]', 0.301149845123291, 'enterprise-api/enterprises/{enterpriseUUID}');
INSERT INTO `logs` VALUES (117, '2019-10-14 16:35:00', '2019-10-14 16:35:00', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises/11114926751800', '[]', 0.3276820182800293, 'enterprise-api/enterprises/{enterpriseUUID}');
INSERT INTO `logs` VALUES (118, '2019-10-14 16:35:46', '2019-10-14 16:35:46', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises/11114926751800', '[]', 0.21909213066101074, 'enterprise-api/enterprises/{enterpriseUUID}');
INSERT INTO `logs` VALUES (119, '2019-10-14 16:41:51', '2019-10-14 16:41:51', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers', '[]', 0.5937118530273438, 'supplier-api/suppliers');
INSERT INTO `logs` VALUES (120, '2019-10-14 16:41:53', '2019-10-14 16:41:53', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers/11214962643427', '[]', 0.232558012008667, 'supplier-api/suppliers/{supplierUUID}');
INSERT INTO `logs` VALUES (121, '2019-10-14 16:41:59', '2019-10-14 16:41:59', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PUT', 'http://ojms-api.com/supplier-api/suppliers/11214962643427', '{\"supplier_uuid\":\"11214962643427\",\"supplier_name\":\"2\",\"industry_type_code\":null,\"industry_type_name\":null,\"location_code\":null,\"location_name\":null,\"usci_number\":\"334545\",\"artificial_person_name\":\"4\",\"artificial_person_phone_number\":null,\"artificial_person_certificate_type_code\":\"30\",\"artificial_person_certificate_type_name\":null,\"artificial_person_certificate_number\":\"1122\",\"business_scope\":null,\"business_address\":null,\"telephone\":null,\"contact_name\":\"2\",\"contact_phone_number\":\"14333333333\",\"introduce\":null,\"tax_identification_number\":\"1\",\"invoice_title\":\"2\",\"create_time\":\"2019-09-28T18:53:53+08:00\",\"bank_name\":\"4\",\"bank_account\":\"6\",\"bank_reserve_mobile_number\":\"13555555555\",\"invoice_address\":\"3\",\"artificial_person_certificate_photo_front\":null,\"artificial_person_certificate_photo_back\":null,\"business_license_photo\":\"19dca4800a8da2975570fb34d02463cb\",\"status\":99,\"status_name\":\"\\u5df2\\u901a\\u8fc7\",\"source_from\":10,\"can_audit_failed\":false,\"can_audit_passed\":false,\"can_reverse_audit\":false}', 0.2725660800933838, 'supplier-api/suppliers/{supplierUUID}');
INSERT INTO `logs` VALUES (122, '2019-10-14 16:42:07', '2019-10-14 16:42:07', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PUT', 'http://ojms-api.com/supplier-api/suppliers/11214962643427', '{\"supplier_uuid\":\"11214962643427\",\"supplier_name\":\"2\",\"industry_type_code\":null,\"industry_type_name\":null,\"location_code\":null,\"location_name\":null,\"usci_number\":\"334545\",\"artificial_person_name\":\"4\",\"artificial_person_phone_number\":null,\"artificial_person_certificate_type_code\":\"30\",\"artificial_person_certificate_type_name\":null,\"artificial_person_certificate_number\":\"1122\",\"business_scope\":null,\"business_address\":null,\"telephone\":null,\"contact_name\":\"2\",\"contact_phone_number\":\"14333333333\",\"introduce\":null,\"tax_identification_number\":\"1\",\"invoice_title\":\"2\",\"create_time\":\"2019-09-28T18:53:53+08:00\",\"bank_name\":\"4\",\"bank_account\":null,\"bank_reserve_mobile_number\":\"13555555555\",\"invoice_address\":\"3\",\"artificial_person_certificate_photo_front\":null,\"artificial_person_certificate_photo_back\":null,\"business_license_photo\":\"19dca4800a8da2975570fb34d02463cb\",\"status\":99,\"status_name\":\"\\u5df2\\u901a\\u8fc7\",\"source_from\":10,\"can_audit_failed\":false,\"can_audit_passed\":false,\"can_reverse_audit\":false}', 0.24440479278564453, 'supplier-api/suppliers/{supplierUUID}');
INSERT INTO `logs` VALUES (123, '2019-10-14 16:42:47', '2019-10-14 16:42:47', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PUT', 'http://ojms-api.com/supplier-api/suppliers/11214962643427', '{\"supplier_uuid\":\"11214962643427\",\"supplier_name\":\"2\",\"industry_type_code\":null,\"industry_type_name\":null,\"location_code\":null,\"location_name\":null,\"usci_number\":\"334545\",\"artificial_person_name\":\"4\",\"artificial_person_phone_number\":null,\"artificial_person_certificate_type_code\":\"30\",\"artificial_person_certificate_type_name\":null,\"artificial_person_certificate_number\":\"1122\",\"business_scope\":null,\"business_address\":null,\"telephone\":null,\"contact_name\":\"2\",\"contact_phone_number\":\"14333333333\",\"introduce\":null,\"tax_identification_number\":\"1\",\"invoice_title\":\"2\",\"create_time\":\"2019-09-28T18:53:53+08:00\",\"bank_name\":\"4\",\"bank_account\":null,\"bank_reserve_mobile_number\":\"13555555555\",\"invoice_address\":\"3\",\"artificial_person_certificate_photo_front\":null,\"artificial_person_certificate_photo_back\":null,\"business_license_photo\":\"19dca4800a8da2975570fb34d02463cb\",\"status\":99,\"status_name\":\"\\u5df2\\u901a\\u8fc7\",\"source_from\":10,\"can_audit_failed\":false,\"can_audit_passed\":false,\"can_reverse_audit\":false}', 0.22182607650756836, 'supplier-api/suppliers/{supplierUUID}');
INSERT INTO `logs` VALUES (124, '2019-10-14 16:42:50', '2019-10-14 16:42:50', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PUT', 'http://ojms-api.com/supplier-api/suppliers/11214962643427', '{\"supplier_uuid\":\"11214962643427\",\"supplier_name\":\"2\",\"industry_type_code\":null,\"industry_type_name\":null,\"location_code\":null,\"location_name\":null,\"usci_number\":\"334545\",\"artificial_person_name\":\"4\",\"artificial_person_phone_number\":null,\"artificial_person_certificate_type_code\":\"30\",\"artificial_person_certificate_type_name\":null,\"artificial_person_certificate_number\":\"1122\",\"business_scope\":null,\"business_address\":null,\"telephone\":null,\"contact_name\":\"2\",\"contact_phone_number\":\"14333333333\",\"introduce\":null,\"tax_identification_number\":\"1\",\"invoice_title\":\"2\",\"create_time\":\"2019-09-28T18:53:53+08:00\",\"bank_name\":\"4\",\"bank_account\":\"1\",\"bank_reserve_mobile_number\":\"13555555555\",\"invoice_address\":\"3\",\"artificial_person_certificate_photo_front\":null,\"artificial_person_certificate_photo_back\":null,\"business_license_photo\":\"19dca4800a8da2975570fb34d02463cb\",\"status\":99,\"status_name\":\"\\u5df2\\u901a\\u8fc7\",\"source_from\":10,\"can_audit_failed\":false,\"can_audit_passed\":false,\"can_reverse_audit\":false}', 0.4991879463195801, 'supplier-api/suppliers/{supplierUUID}');
INSERT INTO `logs` VALUES (125, '2019-10-14 16:42:50', '2019-10-14 16:42:50', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers', '[]', 0.24008798599243164, 'supplier-api/suppliers');
INSERT INTO `logs` VALUES (126, '2019-10-14 16:42:51', '2019-10-14 16:42:51', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers/11214962643427', '[]', 0.22993206977844238, 'supplier-api/suppliers/{supplierUUID}');
INSERT INTO `logs` VALUES (127, '2019-10-14 16:42:56', '2019-10-14 16:42:56', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PUT', 'http://ojms-api.com/supplier-api/suppliers/11214962643427', '{\"supplier_uuid\":\"11214962643427\",\"supplier_name\":\"2\",\"industry_type_code\":null,\"industry_type_name\":null,\"location_code\":null,\"location_name\":null,\"usci_number\":\"334545\",\"artificial_person_name\":\"4\",\"artificial_person_phone_number\":null,\"artificial_person_certificate_type_code\":\"30\",\"artificial_person_certificate_type_name\":\"\\u62a4\\u7167\",\"artificial_person_certificate_number\":\"1122\",\"business_scope\":null,\"business_address\":null,\"telephone\":null,\"contact_name\":\"2\",\"contact_phone_number\":\"14333333333\",\"introduce\":null,\"tax_identification_number\":\"1\",\"invoice_title\":\"2\",\"create_time\":\"2019-09-28T18:53:53+08:00\",\"bank_name\":\"4\",\"bank_account\":\"1234567890\",\"bank_reserve_mobile_number\":\"13555555555\",\"invoice_address\":\"3\",\"artificial_person_certificate_photo_front\":null,\"artificial_person_certificate_photo_back\":null,\"business_license_photo\":\"19dca4800a8da2975570fb34d02463cb\",\"status\":99,\"status_name\":\"\\u5df2\\u901a\\u8fc7\",\"source_from\":10,\"can_audit_failed\":false,\"can_audit_passed\":false,\"can_reverse_audit\":false}', 0.2780427932739258, 'supplier-api/suppliers/{supplierUUID}');
INSERT INTO `logs` VALUES (128, '2019-10-14 16:42:57', '2019-10-14 16:42:57', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers', '[]', 0.22260618209838867, 'supplier-api/suppliers');
INSERT INTO `logs` VALUES (129, '2019-10-14 16:42:58', '2019-10-14 16:42:58', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers/11214962643427', '[]', 0.2121729850769043, 'supplier-api/suppliers/{supplierUUID}');
INSERT INTO `logs` VALUES (130, '2019-10-14 17:24:16', '2019-10-14 17:24:16', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises', '[]', 0.45940494537353516, 'admin-api/enterprises');
INSERT INTO `logs` VALUES (131, '2019-10-14 17:47:51', '2019-10-14 17:47:51', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/enterprises', '[]', 0.24579405784606934, 'enterprise-api/enterprises');
INSERT INTO `logs` VALUES (132, '2019-10-14 17:47:54', '2019-10-14 17:47:54', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/self-employs', '[]', 0.2101888656616211, 'enterprise-api/self-employs');
INSERT INTO `logs` VALUES (133, '2019-10-14 17:48:02', '2019-10-14 17:48:02', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers', '[]', 0.21364712715148926, 'supplier-api/suppliers');
INSERT INTO `logs` VALUES (134, '2019-10-14 17:52:51', '2019-10-14 17:52:51', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises', '[]', 0.22071194648742676, 'admin-api/enterprises');
INSERT INTO `logs` VALUES (135, '2019-10-14 17:52:58', '2019-10-14 17:52:58', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/suppliers', '[]', 0.3079209327697754, 'admin-api/suppliers');
INSERT INTO `logs` VALUES (136, '2019-10-14 17:53:04', '2019-10-14 17:53:04', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs', '[]', 0.2095179557800293, 'admin-api/self-employs');
INSERT INTO `logs` VALUES (137, '2019-10-14 17:53:09', '2019-10-14 17:53:09', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs/11515074423568', '[]', 0.2047410011291504, 'admin-api/self-employs/{selfEmployUUID}');
INSERT INTO `logs` VALUES (138, '2019-10-14 17:54:10', '2019-10-14 17:54:10', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises', '[]', 0.2130730152130127, 'admin-api/enterprises');
INSERT INTO `logs` VALUES (139, '2019-10-14 17:54:12', '2019-10-14 17:54:12', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises/11114943665207', '[]', 0.20490503311157227, 'admin-api/enterprises/{enterpriseUUID}');
INSERT INTO `logs` VALUES (140, '2019-10-14 17:54:19', '2019-10-14 17:54:19', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/enterprises/11114926757511', '[]', 0.23930692672729492, 'admin-api/enterprises/{enterpriseUUID}');
INSERT INTO `logs` VALUES (141, '2019-10-14 17:55:19', '2019-10-14 17:55:19', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs', '[]', 0.20818781852722168, 'admin-api/self-employs');
INSERT INTO `logs` VALUES (142, '2019-10-14 17:55:23', '2019-10-14 17:55:23', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs/11515074423568', '[]', 0.1970529556274414, 'admin-api/self-employs/{selfEmployUUID}');
INSERT INTO `logs` VALUES (143, '2019-10-15 10:12:16', '2019-10-15 10:12:16', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/self-employs', '[]', 0.2112259864807129, 'enterprise-api/self-employs');
INSERT INTO `logs` VALUES (144, '2019-10-15 17:41:47', '2019-10-15 17:41:47', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers', '[]', 0.44939517974853516, 'supplier-api/suppliers');
INSERT INTO `logs` VALUES (145, '2019-10-15 17:42:01', '2019-10-15 17:42:01', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs', '[]', 0.36676597595214844, 'admin-api/self-employs');
INSERT INTO `logs` VALUES (146, '2019-10-15 20:24:34', '2019-10-15 20:24:34', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/self-employs', '[]', 0.22321486473083496, 'admin-api/self-employs');
INSERT INTO `logs` VALUES (147, '2019-10-15 20:24:37', '2019-10-15 20:24:37', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21041512489318848, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (148, '2019-10-15 20:42:14', '2019-10-15 20:42:14', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.45777010917663574, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (149, '2019-10-15 20:42:47', '2019-10-15 20:42:47', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.23249006271362305, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (150, '2019-10-15 20:42:54', '2019-10-15 20:42:54', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.2380671501159668, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (151, '2019-10-15 20:43:22', '2019-10-15 20:43:22', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.22536706924438477, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (152, '2019-10-15 20:43:23', '2019-10-15 20:43:23', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.20040607452392578, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (153, '2019-10-15 20:43:26', '2019-10-15 20:43:26', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.25650978088378906, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (154, '2019-10-15 20:43:30', '2019-10-15 20:43:30', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.23805594444274902, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (155, '2019-10-15 20:43:41', '2019-10-15 20:43:41', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PUT', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '{\"create_time\":\"2019-10-10T17:11:14+08:00\",\"user_uuid\":\"10315065707455\",\"user_name\":\"\\u674e\\u56db\",\"user_phone\":\"18278781212\",\"id_card_number\":\"429008888987865754\",\"sex\":\"1\",\"sex_name\":\"\\u7537\",\"birthday\":\"1930-02-02T00:00:00+08:00\",\"contact_address\":\"\\u9f99\\u534e\",\"certificate_photo_front\":null,\"certificate_photo_back\":\"fb23c744947b2d15aa0693cc6dca2470\",\"is_name_verified\":null,\"status\":10,\"status_name\":\"\\u672a\\u5ba1\\u6838\",\"source_from\":10,\"source_from_name\":\"\\u540e\\u53f0\\u6dfb\\u52a0\",\"can_audit_failed\":true,\"can_audit_passed\":true,\"can_reverse_audit\":false}', 0.37415194511413574, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (156, '2019-10-15 21:01:38', '2019-10-15 21:01:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.23429512977600098, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (157, '2019-10-15 21:02:00', '2019-10-15 21:02:00', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21801996231079102, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (158, '2019-10-15 21:02:05', '2019-10-15 21:02:05', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.23459887504577637, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (159, '2019-10-16 10:45:59', '2019-10-16 10:45:59', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/suppliers', '[]', 0.350139856338501, 'supplier-api/suppliers');
INSERT INTO `logs` VALUES (160, '2019-10-16 10:46:04', '2019-10-16 10:46:04', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/natural-persons', '[]', 0.25904393196105957, 'supplier-api/natural-persons');
INSERT INTO `logs` VALUES (161, '2019-10-16 10:46:05', '2019-10-16 10:46:05', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.24527716636657715, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (162, '2019-10-16 10:46:18', '2019-10-16 10:46:18', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/natural-persons', '[]', 0.3287231922149658, 'supplier-api/natural-persons');
INSERT INTO `logs` VALUES (163, '2019-10-16 10:46:32', '2019-10-16 10:46:32', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.20780491828918457, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (164, '2019-10-16 10:46:33', '2019-10-16 10:46:33', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/natural-persons', '[]', 0.20159602165222168, 'supplier-api/natural-persons');
INSERT INTO `logs` VALUES (165, '2019-10-16 10:46:35', '2019-10-16 10:46:35', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.2039811611175537, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (166, '2019-10-16 10:48:32', '2019-10-16 10:48:32', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21602702140808105, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (167, '2019-10-16 10:49:26', '2019-10-16 10:49:26', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21408700942993164, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (168, '2019-10-16 10:50:20', '2019-10-16 10:50:20', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.20436501502990723, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (169, '2019-10-16 10:50:31', '2019-10-16 10:50:31', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315063560795', '[]', 0.23549199104309082, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (170, '2019-10-16 10:50:36', '2019-10-16 10:50:36', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.24409699440002441, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (171, '2019-10-16 10:50:38', '2019-10-16 10:50:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315063560795', '[]', 0.23556089401245117, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (172, '2019-10-16 10:51:12', '2019-10-16 10:51:12', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21709394454956055, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (173, '2019-10-16 10:51:16', '2019-10-16 10:51:16', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.22878193855285645, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (174, '2019-10-16 10:51:16', '2019-10-16 10:51:16', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.3214149475097656, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (175, '2019-10-16 10:51:42', '2019-10-16 10:51:42', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.24324607849121094, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (176, '2019-10-16 10:51:44', '2019-10-16 10:51:44', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.22654485702514648, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (177, '2019-10-16 10:51:44', '2019-10-16 10:51:44', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.22723913192749023, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (178, '2019-10-16 10:52:03', '2019-10-16 10:52:03', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.20716285705566406, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (179, '2019-10-16 10:52:05', '2019-10-16 10:52:05', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.23617291450500488, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (180, '2019-10-16 10:52:05', '2019-10-16 10:52:05', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.22658014297485352, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (181, '2019-10-16 10:52:12', '2019-10-16 10:52:12', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'DELETE', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards/80015074173305', '[]', 0.2924368381500244, 'admin-api/natural-persons/{userUUID}/bank-cards/{bankCardUUID}');
INSERT INTO `logs` VALUES (182, '2019-10-16 10:52:12', '2019-10-16 10:52:12', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.20827007293701172, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (183, '2019-10-16 10:52:15', '2019-10-16 10:52:15', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315063560795/bank-cards', '[]', 0.24171900749206543, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (184, '2019-10-16 10:52:15', '2019-10-16 10:52:15', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315063560795', '[]', 0.2622649669647217, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (185, '2019-10-16 10:52:17', '2019-10-16 10:52:17', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315056743882/bank-cards', '[]', 0.230820894241333, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (186, '2019-10-16 10:52:17', '2019-10-16 10:52:17', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315056743882', '[]', 0.22219109535217285, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (187, '2019-10-16 10:52:21', '2019-10-16 10:52:21', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.2879331111907959, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (188, '2019-10-16 10:52:21', '2019-10-16 10:52:21', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.33730006217956543, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (189, '2019-10-16 10:52:39', '2019-10-16 10:52:39', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.24878191947937012, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (190, '2019-10-16 10:55:36', '2019-10-16 10:55:36', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.24304795265197754, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (191, '2019-10-16 10:55:36', '2019-10-16 10:55:36', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.22921204566955566, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (192, '2019-10-16 10:58:38', '2019-10-16 10:58:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.24262785911560059, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (193, '2019-10-16 10:58:40', '2019-10-16 10:58:40', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.2142500877380371, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (194, '2019-10-16 10:58:40', '2019-10-16 10:58:40', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.23206686973571777, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (195, '2019-10-16 10:58:45', '2019-10-16 10:58:45', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.270474910736084, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (196, '2019-10-16 10:58:45', '2019-10-16 10:58:45', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.259807825088501, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (197, '2019-10-16 11:01:01', '2019-10-16 11:01:01', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.2082979679107666, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (198, '2019-10-16 11:01:02', '2019-10-16 11:01:02', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.35296106338500977, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (199, '2019-10-16 11:01:02', '2019-10-16 11:01:02', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.35463905334472656, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (200, '2019-10-16 11:43:23', '2019-10-16 11:43:23', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21429800987243652, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (201, '2019-10-16 11:44:19', '2019-10-16 11:44:19', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.3532907962799072, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (202, '2019-10-16 11:44:19', '2019-10-16 11:44:19', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.3667919635772705, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (203, '2019-10-16 11:47:22', '2019-10-16 11:47:22', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21336817741394043, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (204, '2019-10-16 11:54:05', '2019-10-16 11:54:05', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21993207931518555, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (205, '2019-10-16 13:44:10', '2019-10-16 13:44:10', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.22534680366516113, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (206, '2019-10-16 13:44:28', '2019-10-16 13:44:28', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.22809696197509766, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (207, '2019-10-16 13:44:28', '2019-10-16 13:44:28', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.2305760383605957, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (208, '2019-10-16 13:44:31', '2019-10-16 13:44:31', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.21505379676818848, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (209, '2019-10-16 13:44:31', '2019-10-16 13:44:31', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.21788597106933594, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (210, '2019-10-16 13:44:38', '2019-10-16 13:44:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.21843910217285156, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (211, '2019-10-16 13:44:38', '2019-10-16 13:44:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.22715210914611816, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (212, '2019-10-16 13:44:43', '2019-10-16 13:44:43', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '{\"card_holder\":\"\\u674e\\u56db\",\"card_holder_phone\":\"18278781212\",\"bank_identity\":\"ICBC\",\"is_verified\":false,\"is_default\":true,\"card_number\":\"111\"}', 0.3009960651397705, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (213, '2019-10-16 13:45:09', '2019-10-16 13:45:09', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '{\"card_holder\":\"\\u674e\\u56db\",\"card_holder_phone\":\"18278781212\",\"bank_identity\":\"BCOM\",\"is_verified\":false,\"is_default\":true,\"card_number\":\"6217858000081188306\"}', 0.5561208724975586, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (214, '2019-10-16 13:45:49', '2019-10-16 13:45:49', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '{\"card_holder\":\"\\u674e\\u56db\",\"card_holder_phone\":\"18278781212\",\"bank_identity\":\"BCOM\",\"is_verified\":false,\"is_default\":true,\"card_number\":\"6217858000081188306\"}', 0.2993810176849365, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (215, '2019-10-16 13:46:56', '2019-10-16 13:46:56', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '{\"card_holder\":\"\\u674e\\u56db\",\"card_holder_phone\":\"18278781212\",\"bank_identity\":\"BCOM\",\"is_verified\":false,\"is_default\":true,\"card_number\":\"6217858000081188306\"}', 0.5008378028869629, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (216, '2019-10-16 13:46:57', '2019-10-16 13:46:57', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.23244881629943848, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (217, '2019-10-16 13:48:23', '2019-10-16 13:48:23', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.20860004425048828, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (218, '2019-10-16 13:48:30', '2019-10-16 13:48:30', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.2949540615081787, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (219, '2019-10-16 13:48:30', '2019-10-16 13:48:30', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.28278422355651855, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (220, '2019-10-16 13:54:05', '2019-10-16 13:54:05', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.2187049388885498, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (221, '2019-10-16 13:54:07', '2019-10-16 13:54:07', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.21243596076965332, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (222, '2019-10-16 13:54:07', '2019-10-16 13:54:07', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.24229907989501953, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (223, '2019-10-16 13:54:19', '2019-10-16 13:54:19', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315063560795', '[]', 0.23041701316833496, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (224, '2019-10-16 13:54:19', '2019-10-16 13:54:19', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315063560795/bank-cards', '[]', 0.23076200485229492, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (225, '2019-10-16 13:54:26', '2019-10-16 13:54:26', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"natural_person\":{\"password\":\"123456\"}}', 0.19959115982055664, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (226, '2019-10-16 13:54:34', '2019-10-16 13:54:34', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"natural_person\":{\"password\":\"123456\",\"user_name\":\"1\",\"user_phone\":\"13222222222\"}}', 0.20774316787719727, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (227, '2019-10-16 13:54:43', '2019-10-16 13:54:43', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"natural_person\":{\"password\":\"123456\",\"user_name\":\"1\",\"user_phone\":\"13222222222\",\"id_card_number\":\"442222222222222222\",\"contact_address\":\"22222222222222222\"}}', 0.2071690559387207, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (228, '2019-10-16 13:55:22', '2019-10-16 13:55:22', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.2428288459777832, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (229, '2019-10-16 13:55:22', '2019-10-16 13:55:22', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.2275547981262207, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (230, '2019-10-16 13:55:31', '2019-10-16 13:55:31', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.2270970344543457, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (231, '2019-10-16 13:55:31', '2019-10-16 13:55:31', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.23130297660827637, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (232, '2019-10-16 13:55:36', '2019-10-16 13:55:36', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PUT', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '{\"create_time\":\"2019-10-10T17:11:14+08:00\",\"user_uuid\":\"10315065707455\",\"user_name\":\"\\u674e\\u56db\",\"user_phone\":\"18278781212\",\"id_card_number\":\"429008888987865754\",\"sex\":\"1\",\"sex_name\":\"\\u7537\",\"birthday\":\"1930-02-02T00:00:00+08:00\",\"contact_address\":\"\\u9f99\\u534ejj\",\"certificate_photo_front\":\"0f14f0145efec81606ed6c40be0053d8\",\"certificate_photo_back\":\"fb23c744947b2d15aa0693cc6dca2470\",\"is_name_verified\":null,\"status\":10,\"status_name\":\"\\u672a\\u5ba1\\u6838\",\"source_from\":10,\"source_from_name\":\"\\u540e\\u53f0\\u6dfb\\u52a0\",\"can_audit_failed\":true,\"can_audit_passed\":true,\"can_reverse_audit\":false}', 0.2663309574127197, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (233, '2019-10-16 13:55:36', '2019-10-16 13:55:36', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.20988011360168457, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (234, '2019-10-16 13:55:38', '2019-10-16 13:55:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.23119401931762695, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (235, '2019-10-16 13:55:38', '2019-10-16 13:55:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.2067430019378662, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (236, '2019-10-16 13:55:50', '2019-10-16 13:55:50', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PUT', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '{\"create_time\":\"2019-10-10T17:11:14+08:00\",\"user_uuid\":\"10315065707455\",\"user_name\":\"\\u674e\\u56db\",\"user_phone\":\"18278781212\",\"id_card_number\":\"429008888987865754\",\"sex\":\"1\",\"sex_name\":\"\\u7537\",\"birthday\":\"1930-02-02T00:00:00+08:00\",\"contact_address\":\"\\u9f99\\u534ejj\",\"certificate_photo_front\":\"0f14f0145efec81606ed6c40be0053d8\",\"certificate_photo_back\":\"36c6d42da70a994542c36b6871145ef5\",\"is_name_verified\":null,\"status\":10,\"status_name\":\"\\u672a\\u5ba1\\u6838\",\"source_from\":10,\"source_from_name\":\"\\u540e\\u53f0\\u6dfb\\u52a0\",\"can_audit_failed\":true,\"can_audit_passed\":true,\"can_reverse_audit\":false}', 0.38474297523498535, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (237, '2019-10-16 13:55:51', '2019-10-16 13:55:51', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.21511507034301758, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (238, '2019-10-16 13:55:52', '2019-10-16 13:55:52', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455', '[]', 0.22697901725769043, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (239, '2019-10-16 13:55:52', '2019-10-16 13:55:52', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315065707455/bank-cards', '[]', 0.2326650619506836, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (240, '2019-10-16 13:55:57', '2019-10-16 13:55:57', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.25208306312561035, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (241, '2019-10-16 13:56:00', '2019-10-16 13:56:00', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"password\":\"123456\",\"user_name\":\"1\"}', 0.21976304054260254, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (242, '2019-10-16 13:56:03', '2019-10-16 13:56:03', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"password\":\"123456\",\"user_name\":\"1\",\"user_phone\":\"13222222222\"}', 0.20831704139709473, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (243, '2019-10-16 13:56:07', '2019-10-16 13:56:07', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"password\":\"123456\",\"user_name\":\"1\",\"user_phone\":\"13222222222\",\"id_card_number\":\"222222222222222222\"}', 0.2044229507446289, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (244, '2019-10-16 13:56:11', '2019-10-16 13:56:11', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"password\":\"123456\",\"user_name\":\"1\",\"user_phone\":\"13222222222\",\"id_card_number\":\"222222222222222222\",\"contact_address\":\"2222\"}', 0.2029430866241455, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (245, '2019-10-16 13:56:20', '2019-10-16 13:56:20', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"password\":\"123456\",\"user_name\":\"1\",\"user_phone\":\"13222222222\",\"id_card_number\":\"222222222222222222\",\"contact_address\":\"2222\",\"certificate_photo_front\":\"6414d88158b426ad309b052235e2b7b5\",\"certificate_photo_back\":\"19dca4800a8da2975570fb34d02463cb\"}', 0.29422903060913086, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (246, '2019-10-16 13:56:28', '2019-10-16 13:56:28', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/natural-persons', '{\"password\":\"123456\",\"user_name\":\"1\",\"user_phone\":\"13222222222\",\"id_card_number\":\"44132319910923851X\",\"contact_address\":\"2222\",\"certificate_photo_front\":\"6414d88158b426ad309b052235e2b7b5\",\"certificate_photo_back\":\"19dca4800a8da2975570fb34d02463cb\"}', 0.8452999591827393, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (247, '2019-10-16 13:56:28', '2019-10-16 13:56:28', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons', '[]', 0.20543694496154785, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (248, '2019-10-16 13:56:31', '2019-10-16 13:56:31', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315116378877', '[]', 0.2675199508666992, 'admin-api/natural-persons/{userUUID}');
INSERT INTO `logs` VALUES (249, '2019-10-16 13:56:31', '2019-10-16 13:56:31', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons/10315116378877/bank-cards', '[]', 0.28696513175964355, 'admin-api/natural-persons/{userUUID}/bank-cards');
INSERT INTO `logs` VALUES (250, '2019-10-16 13:58:28', '2019-10-16 13:58:28', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?id_card_number=290&page=1', '{\"id_card_number\":\"290\",\"page\":\"1\"}', 0.2124619483947754, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (251, '2019-10-16 13:58:30', '2019-10-16 13:58:30', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?page=1', '{\"page\":\"1\"}', 0.217789888381958, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (252, '2019-10-16 13:58:35', '2019-10-16 13:58:35', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?page=1&user_name=1', '{\"user_name\":\"1\",\"page\":\"1\"}', 0.2975728511810303, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (253, '2019-10-16 13:58:38', '2019-10-16 13:58:38', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?page=1', '{\"page\":\"1\"}', 0.21385502815246582, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (254, '2019-10-16 13:58:44', '2019-10-16 13:58:44', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?page=1&user_phone=2222', '{\"user_phone\":\"2222\",\"page\":\"1\"}', 0.24132895469665527, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (255, '2019-10-16 13:58:45', '2019-10-16 13:58:45', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?page=1&user_phone=2', '{\"user_phone\":\"2\",\"page\":\"1\"}', 0.21721601486206055, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (256, '2019-10-16 13:58:50', '2019-10-16 13:58:50', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?audit_status=99&page=1', '{\"audit_status\":\"99\",\"page\":\"1\"}', 0.21999692916870117, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (257, '2019-10-16 13:58:52', '2019-10-16 13:58:52', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?audit_status=10&page=1', '{\"audit_status\":\"10\",\"page\":\"1\"}', 0.21461009979248047, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (258, '2019-10-16 14:29:17', '2019-10-16 14:29:17', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?audit_status=10&page=1', '{\"audit_status\":\"10\",\"page\":\"1\"}', 0.22188186645507812, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (259, '2019-10-16 14:47:06', '2019-10-16 14:47:06', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?audit_status=10&page=1', '{\"audit_status\":\"10\",\"page\":\"1\"}', 0.22234678268432617, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (260, '2019-10-16 14:47:11', '2019-10-16 14:47:11', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/natural-persons?audit_status=10&page=1', '{\"audit_status\":\"10\",\"page\":\"1\"}', 0.2156209945678711, 'admin-api/natural-persons');
INSERT INTO `logs` VALUES (261, '2019-10-16 14:47:28', '2019-10-16 14:47:28', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/me', '[]', 0.19780516624450684, 'admin-api/me');
INSERT INTO `logs` VALUES (262, '2019-10-16 14:47:34', '2019-10-16 14:47:34', NULL, '', 'admin.web', '', '192.168.99.199', 'DELETE', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.16302084922790527, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (263, '2019-10-16 14:47:42', '2019-10-16 14:47:42', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.625683069229126, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (264, '2019-10-16 14:47:46', '2019-10-16 14:47:46', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/me', '[]', 0.23713207244873047, 'admin-api/me');
INSERT INTO `logs` VALUES (265, '2019-10-16 14:47:48', '2019-10-16 14:47:48', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PUT', 'http://ojms-api.com/admin-api/me', '{\"user_uuid\":\"10314919049142\",\"user_name\":\"OJMS2111\",\"user_phone\":\"18888888888\",\"create_time\":\"2019-09-23T17:48:11+08:00\",\"can_lock\":false,\"can_update_role\":false}', 0.28492116928100586, 'admin-api/me');
INSERT INTO `logs` VALUES (266, '2019-10-16 14:47:50', '2019-10-16 14:47:50', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/me', '[]', 0.19180893898010254, 'admin-api/me');
INSERT INTO `logs` VALUES (267, '2019-10-16 14:49:41', '2019-10-16 14:49:41', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/me', '[]', 0.1926560401916504, 'admin-api/me');
INSERT INTO `logs` VALUES (268, '2019-10-16 14:49:43', '2019-10-16 14:49:43', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PUT', 'http://ojms-api.com/admin-api/me', '{\"user_uuid\":\"10314919049142\",\"user_name\":\"OJMS211\",\"user_phone\":\"18888888888\",\"create_time\":\"2019-09-23T17:48:11+08:00\",\"can_lock\":false,\"can_update_role\":false}', 0.41689205169677734, 'admin-api/me');
INSERT INTO `logs` VALUES (269, '2019-10-16 14:49:46', '2019-10-16 14:49:46', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/me', '[]', 0.1960151195526123, 'admin-api/me');
INSERT INTO `logs` VALUES (270, '2019-10-16 14:53:02', '2019-10-16 14:53:02', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/me', '[]', 0.30475807189941406, 'admin-api/me');
INSERT INTO `logs` VALUES (271, '2019-10-16 14:55:01', '2019-10-16 14:55:01', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/me', '[]', 0.19439196586608887, 'admin-api/me');
INSERT INTO `logs` VALUES (272, '2019-10-16 14:55:07', '2019-10-16 14:55:07', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PATCH', 'http://ojms-api.com/admin-api/me/password', '[]', 0.20477509498596191, 'admin-api/me/password');
INSERT INTO `logs` VALUES (273, '2019-10-16 14:55:11', '2019-10-16 14:55:11', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PATCH', 'http://ojms-api.com/admin-api/me/password', '[]', 0.23085308074951172, 'admin-api/me/password');
INSERT INTO `logs` VALUES (274, '2019-10-16 14:55:19', '2019-10-16 14:55:19', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PATCH', 'http://ojms-api.com/admin-api/me/password', '[]', 0.33704495429992676, 'admin-api/me/password');
INSERT INTO `logs` VALUES (275, '2019-10-16 14:55:28', '2019-10-16 14:55:28', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PATCH', 'http://ojms-api.com/admin-api/me/password', '[]', 0.20106887817382812, 'admin-api/me/password');
INSERT INTO `logs` VALUES (276, '2019-10-16 14:55:35', '2019-10-16 14:55:35', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PATCH', 'http://ojms-api.com/admin-api/me/password', '[]', 0.5869760513305664, 'admin-api/me/password');
INSERT INTO `logs` VALUES (277, '2019-10-16 14:55:48', '2019-10-16 14:55:48', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.1751399040222168, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (278, '2019-10-16 14:55:53', '2019-10-16 14:55:53', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.6888089179992676, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (279, '2019-10-16 14:55:57', '2019-10-16 14:55:57', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/me', '[]', 0.2019209861755371, 'admin-api/me');
INSERT INTO `logs` VALUES (280, '2019-10-16 14:56:04', '2019-10-16 14:56:04', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'PATCH', 'http://ojms-api.com/admin-api/me/password', '[]', 0.7012569904327393, 'admin-api/me/password');
INSERT INTO `logs` VALUES (281, '2019-10-16 14:56:15', '2019-10-16 14:56:15', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.18215203285217285, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (282, '2019-10-16 14:56:20', '2019-10-16 14:56:20', NULL, '', 'admin.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/admin-api/login-tokens', '[]', 0.46486496925354004, 'admin-api/login-tokens');
INSERT INTO `logs` VALUES (283, '2019-10-16 14:57:21', '2019-10-16 14:57:21', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.20998001098632812, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (284, '2019-10-16 14:57:23', '2019-10-16 14:57:23', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/me', '[]', 0.19420814514160156, 'supplier-api/me');
INSERT INTO `logs` VALUES (285, '2019-10-16 14:57:27', '2019-10-16 14:57:27', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/me', '[]', 0.21784591674804688, 'supplier-api/me');
INSERT INTO `logs` VALUES (286, '2019-10-16 14:57:29', '2019-10-16 14:57:29', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PUT', 'http://ojms-api.com/supplier-api/me', '{\"user_uuid\":\"10214962643458\",\"user_name\":\"13222\",\"user_phone\":\"13200000000\",\"create_time\":\"2019-09-28T18:53:53+08:00\",\"can_lock\":false,\"can_update_role\":false}', 0.2760350704193115, 'supplier-api/me');
INSERT INTO `logs` VALUES (287, '2019-10-16 14:57:31', '2019-10-16 14:57:31', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.20587396621704102, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (288, '2019-10-16 14:57:36', '2019-10-16 14:57:36', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/me', '[]', 0.21472978591918945, 'supplier-api/me');
INSERT INTO `logs` VALUES (289, '2019-10-16 14:57:43', '2019-10-16 14:57:43', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/me/password', '[]', 0.19708895683288574, 'supplier-api/me/password');
INSERT INTO `logs` VALUES (290, '2019-10-16 14:57:51', '2019-10-16 14:57:51', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/me/password', '[]', 0.32434988021850586, 'supplier-api/me/password');
INSERT INTO `logs` VALUES (291, '2019-10-16 14:57:54', '2019-10-16 14:57:54', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/me/password', '[]', 0.5762531757354736, 'supplier-api/me/password');
INSERT INTO `logs` VALUES (292, '2019-10-16 14:58:04', '2019-10-16 14:58:04', NULL, '', 'supplier.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/login-tokens', '[]', 0.5422658920288086, 'supplier-api/login-tokens');
INSERT INTO `logs` VALUES (293, '2019-10-16 14:58:11', '2019-10-16 14:58:11', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/me', '[]', 0.19903206825256348, 'supplier-api/me');
INSERT INTO `logs` VALUES (294, '2019-10-16 14:58:20', '2019-10-16 14:58:20', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'PATCH', 'http://ojms-api.com/supplier-api/me/password', '[]', 0.7076289653778076, 'supplier-api/me/password');
INSERT INTO `logs` VALUES (295, '2019-10-16 14:58:33', '2019-10-16 14:58:33', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/me', '[]', 0.19541192054748535, 'enterprise-api/me');
INSERT INTO `logs` VALUES (296, '2019-10-16 14:58:37', '2019-10-16 14:58:37', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/me', '[]', 0.19094395637512207, 'enterprise-api/me');
INSERT INTO `logs` VALUES (297, '2019-10-16 14:58:40', '2019-10-16 14:58:40', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'PUT', 'http://ojms-api.com/enterprise-api/me', '{\"user_uuid\":\"10114936657826\",\"user_name\":\"12223\",\"user_phone\":\"18212341234\",\"create_time\":\"2019-09-25T18:42:57+08:00\",\"can_lock\":true,\"can_update_role\":true}', 0.24857592582702637, 'enterprise-api/me');
INSERT INTO `logs` VALUES (298, '2019-10-16 14:58:45', '2019-10-16 14:58:45', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'GET', 'http://ojms-api.com/enterprise-api/me', '[]', 0.2403090000152588, 'enterprise-api/me');
INSERT INTO `logs` VALUES (299, '2019-10-16 14:59:30', '2019-10-16 14:59:30', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'PATCH', 'http://ojms-api.com/enterprise-api/me/password', '[]', 0.322735071182251, 'enterprise-api/me/password');
INSERT INTO `logs` VALUES (300, '2019-10-16 14:59:40', '2019-10-16 14:59:40', NULL, '', 'enterprise.web', '10114936657826', '192.168.99.199', 'PATCH', 'http://ojms-api.com/enterprise-api/me/password', '[]', 0.5929780006408691, 'enterprise-api/me/password');
INSERT INTO `logs` VALUES (301, '2019-10-16 14:59:48', '2019-10-16 14:59:48', NULL, '', 'enterprise.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/enterprise-api/login-tokens', '[]', 0.4744119644165039, 'enterprise-api/login-tokens');
INSERT INTO `logs` VALUES (302, '2019-10-16 17:56:35', '2019-10-16 17:56:35', NULL, '', 'supplier.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/registers/verify-sms-code', '{\"user_phone\":null}', 0.1786208152770996, 'supplier-api/registers/verify-sms-code');
INSERT INTO `logs` VALUES (303, '2019-10-17 14:13:27', '2019-10-17 14:13:27', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/suppliers', '[]', 0.22043395042419434, 'admin-api/suppliers');
INSERT INTO `logs` VALUES (304, '2019-10-17 14:13:33', '2019-10-17 14:13:33', NULL, '', 'admin.web', '10314919049142', '192.168.99.199', 'GET', 'http://ojms-api.com/admin-api/suppliers/11214962643427/supplier-users', '[]', 0.2171168327331543, 'admin-api/suppliers/{supplierUUID}/supplier-users');
INSERT INTO `logs` VALUES (305, '2019-10-17 14:13:41', '2019-10-17 14:13:41', NULL, '', 'supplier.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/login-tokens', '[]', 0.17052292823791504, 'supplier-api/login-tokens');
INSERT INTO `logs` VALUES (306, '2019-10-17 14:13:45', '2019-10-17 14:13:45', NULL, '', 'supplier.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/login-tokens', '[]', 0.19753193855285645, 'supplier-api/login-tokens');
INSERT INTO `logs` VALUES (307, '2019-10-17 14:13:49', '2019-10-17 14:13:49', NULL, '', 'supplier.web', '', '192.168.99.199', 'POST', 'http://ojms-api.com/supplier-api/login-tokens', '[]', 0.556480884552002, 'supplier-api/login-tokens');
INSERT INTO `logs` VALUES (308, '2019-10-17 14:13:52', '2019-10-17 14:13:52', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.1995079517364502, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (309, '2019-10-17 14:13:53', '2019-10-17 14:13:53', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/natural-persons', '[]', 0.20383000373840332, 'supplier-api/natural-persons');
INSERT INTO `logs` VALUES (310, '2019-10-17 14:13:55', '2019-10-17 14:13:55', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.24454689025878906, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (311, '2019-10-17 14:14:56', '2019-10-17 14:14:56', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.22491192817687988, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (312, '2019-10-17 14:14:58', '2019-10-17 14:14:58', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs/11515064918100', '[]', 0.21630287170410156, 'supplier-api/self-employs/{selfEmployUUID}');
INSERT INTO `logs` VALUES (313, '2019-10-17 14:15:05', '2019-10-17 14:15:05', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.2256450653076172, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (314, '2019-10-17 14:15:07', '2019-10-17 14:15:07', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs/11515064918100', '[]', 0.20784997940063477, 'supplier-api/self-employs/{selfEmployUUID}');
INSERT INTO `logs` VALUES (315, '2019-10-17 14:27:26', '2019-10-17 14:27:26', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.22103285789489746, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (316, '2019-10-17 14:30:46', '2019-10-17 14:30:46', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs/11515064918100', '[]', 0.2272789478302002, 'supplier-api/self-employs/{selfEmployUUID}');
INSERT INTO `logs` VALUES (317, '2019-10-17 14:31:01', '2019-10-17 14:31:01', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs', '[]', 0.23451495170593262, 'supplier-api/self-employs');
INSERT INTO `logs` VALUES (318, '2019-10-17 14:31:02', '2019-10-17 14:31:02', NULL, '', 'supplier.web', '10214962643458', '192.168.99.199', 'GET', 'http://ojms-api.com/supplier-api/self-employs/11515064918100', '[]', 0.3861708641052246, 'supplier-api/self-employs/{selfEmployUUID}');

-- ----------------------------
-- Table structure for menu_node
-- ----------------------------
DROP TABLE IF EXISTS `menu_node`;
CREATE TABLE `menu_node`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '角色节点自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `menu_id` int(11) UNSIGNED NOT NULL COMMENT '菜单ID',
  `node_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '节点ID',
  `sign` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '节点标志',
  `node_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '节点所属（通用/各平台web端/各平台各版本app端）',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '菜单关联节点 记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu_node
-- ----------------------------
INSERT INTO `menu_node` VALUES (9, '2019-09-24 19:00:47', '2019-09-24 19:00:47', NULL, '', 7, 4, 'GET admins', 99);
INSERT INTO `menu_node` VALUES (10, '2019-09-24 19:00:47', '2019-09-24 19:00:47', NULL, '', 7, 8, 'POST admin-users', 99);

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '权限角色自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `parent_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '父级ID',
  `name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '菜单名称',
  `description` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '菜单简介',
  `group` tinyint(3) UNSIGNED NOT NULL COMMENT '所属分组（通用/管理/企业/供应商）',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, '2019-09-20 15:50:13', '2019-09-20 15:50:13', NULL, '', NULL, '超级角色', '拥有所有权限', 0);
INSERT INTO `menus` VALUES (2, '2019-09-20 15:50:13', '2019-09-20 15:50:13', NULL, '', NULL, '超级角色（只读）', '拥有所有只读权限', 0);
INSERT INTO `menus` VALUES (5, '2019-09-24 17:14:46', '2019-09-24 17:14:46', NULL, '', NULL, '2', '3', 99);
INSERT INTO `menus` VALUES (6, '2019-09-24 17:15:47', '2019-09-24 17:15:47', NULL, '', 5, '2', '3', 99);
INSERT INTO `menus` VALUES (7, '2019-09-24 17:15:56', '2019-09-24 17:15:56', NULL, '', NULL, '3', '4', 99);

-- ----------------------------
-- Table structure for natural_person_bank_cards
-- ----------------------------
DROP TABLE IF EXISTS `natural_person_bank_cards`;
CREATE TABLE `natural_person_bank_cards`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  `bank_card_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行卡UUID',
  `bank_identity` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行域名识别号',
  `bank_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行名称',
  `card_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行卡卡号',
  `card_holder` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '持卡人',
  `card_holder_phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '持卡人手机号码',
  `is_default` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '是否为默认卡',
  `is_verified` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '是否通过三要素',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of natural_person_bank_cards
-- ----------------------------
INSERT INTO `natural_person_bank_cards` VALUES (1, '2019-10-10 10:53:59', '2019-10-10 10:53:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10315056743882', '1111111', '1111', '12323', '11', '12312', NULL, 1, NULL);
INSERT INTO `natural_person_bank_cards` VALUES (2, '2019-10-10 17:11:14', '2019-10-16 13:46:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10315065707455', '80015065707459', '2312312111', '中国银行2', '690999987788', '哈哈', NULL, 0, NULL);
INSERT INTO `natural_person_bank_cards` VALUES (3, '2019-10-11 16:42:12', '2019-10-16 11:52:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10315065707455', '80015074173305', '11', '22', '333', '44', NULL, 0, NULL);
INSERT INTO `natural_person_bank_cards` VALUES (4, '2019-10-16 13:45:49', '2019-10-16 13:45:49', '2019-10-16 13:45:49', NULL, NULL, NULL, NULL, NULL, NULL, '10315065707455', NULL, 'BCOM', '交通银行', '6217858000081188306', '李四', '18278781212', 1, 0);
INSERT INTO `natural_person_bank_cards` VALUES (5, '2019-10-16 13:46:56', '2019-10-16 13:46:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10315065707455', '80015116321726', 'BCOM', '交通银行', '6217858000081188306', '李四', '18278781212', 1, 0);

-- ----------------------------
-- Table structure for natural_persons
-- ----------------------------
DROP TABLE IF EXISTS `natural_persons`;
CREATE TABLE `natural_persons`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  `user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户姓名',
  `user_phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户手机号码',
  `id_card_number` char(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '身份证号码',
  `sex` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '性别',
  `birthday` date NULL DEFAULT NULL COMMENT '生日日期',
  `contact_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系地址',
  `certificate_photo_front` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '证件照正面',
  `certificate_photo_back` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '证件照背面',
  `is_name_verified` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '是否实名认证',
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '状态',
  `source_from` tinyint(3) UNSIGNED NOT NULL COMMENT '创建来源',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of natural_persons
-- ----------------------------
INSERT INTO `natural_persons` VALUES (1, '2019-10-08 16:57:39', '2019-10-09 12:13:17', '2019-10-08 16:57:42', NULL, '2019-10-08 16:57:45', '11515047579708', '1111', '11515047579708', '22', '10315047579708', '呼呼呼', '13005445474', '343434341231', '1', '2019-10-08', 'eewrwerw', NULL, NULL, 1, 1, 1);
INSERT INTO `natural_persons` VALUES (2, '2019-10-09 16:17:18', '2019-10-11 17:42:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10315056743882', '华为1', '18271266261', '42900899887676', '1', '2019-10-09', '232322', 'd223d300f36305e0e4a8775241a06a57', '0f14f0145efec81606ed6c40be0053d8', NULL, 99, 10);
INSERT INTO `natural_persons` VALUES (3, '2019-10-10 11:13:27', '2019-10-11 18:39:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10315063560795', '胡文俊', '18271266562', '429001988921238765', '3', '2019-10-31', '深圳龙华区1', 'd223d300f36305e0e4a8775241a06a57', 'fb23c744947b2d15aa0693cc6dca2470', NULL, 10, 10);
INSERT INTO `natural_persons` VALUES (4, '2019-10-10 17:11:14', '2019-10-16 13:55:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10315065707455', '李四', '18278781212', '429008888987865754', '1', '1930-02-02', '龙华jj', '0f14f0145efec81606ed6c40be0053d8', '36c6d42da70a994542c36b6871145ef5', NULL, 10, 10);
INSERT INTO `natural_persons` VALUES (5, '2019-10-16 13:56:28', '2019-10-16 13:56:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10315116378877', '1', '13222222222', '44132319910923851X', '1', '1991-09-23', '2222', '6414d88158b426ad309b052235e2b7b5', '19dca4800a8da2975570fb34d02463cb', 0, 10, 10);

-- ----------------------------
-- Table structure for nodes
-- ----------------------------
DROP TABLE IF EXISTS `nodes`;
CREATE TABLE `nodes`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '权限节点自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `method` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '请求方式',
  `uri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '请求uri',
  `module_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模块名称',
  `function_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '方法名称',
  `sign` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '节点标志',
  `type` tinyint(3) UNSIGNED NOT NULL COMMENT '节点所属（通用/各平台web端/各平台各版本app端）',
  `type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '节点所属类型',
  `group` tinyint(3) UNSIGNED NOT NULL COMMENT '节点所属分组（通用/管理/企业/供应商）',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 96 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nodes
-- ----------------------------
INSERT INTO `nodes` VALUES (1, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', '__ALL__', '', '全部模块', '全部节点', '__ALL__ __ALL__', 0, '', 0);
INSERT INTO `nodes` VALUES (2, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'GET', '', '全部模块', '全部节点（只读）', 'GET __ALL__', 0, '', 0);
INSERT INTO `nodes` VALUES (3, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'GET', 'nodes', '权限节点管理', '获取全部节点列表', 'GET nodes', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (4, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'GET', 'admins', '管理公司模块', '获取管理公司列表', 'GET admins', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (5, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'GET', 'admins/{adminUUID}', '管理公司模块', '获取公司信息', 'GET admins/{adminUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (6, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'PUT', 'admins/{adminUUID}', '管理公司模块', '更新管理公司', 'PUT admins/{adminUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (7, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'GET', 'admin-users', '管理公司管理员模块', '管理员列表', 'GET admin-users', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (8, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'POST', 'admin-users', '管理公司管理员模块', '新增管理员', 'POST admin-users', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (9, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'GET', 'admin-users/{userUUID}', '管理公司管理员模块', '管理员详情', 'GET admin-users/{userUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (10, '2019-10-11 18:17:53', '2019-10-11 18:17:53', NULL, '', 'PUT', 'admin-users/{userUUID}', '管理公司管理员模块', '更新管理员', 'PUT admin-users/{userUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (11, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'GET', 'admin-users/{userUUID}/login-logs', '管理公司管理员模块', '查看登录记录', 'GET admin-users/{userUUID}/login-logs', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (12, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'PATCH', 'admin-users/{userUUID}/lock', '管理公司管理员模块', '锁定管理员', 'PATCH admin-users/{userUUID}/lock', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (13, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'PATCH', 'admin-users/{userUUID}/unlock', '管理公司管理员模块', '解锁管理员', 'PATCH admin-users/{userUUID}/unlock', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (14, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'PATCH', 'admin-users/{userUUID}/reset-password', '管理公司管理员模块', '重置管理员密码', 'PATCH admin-users/{userUUID}/reset-password', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (15, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'GET', 'admin-users/{userUUID}/roles', '用户权限管理', '获取用户的菜单列表', 'GET admin-users/{userUUID}/roles', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (16, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'GET', 'enterprises/{enterpriseUUID}/enterprise-users/{userUUID}/roles', '用户权限管理', '获取用户的菜单列表', 'GET enterprises/{enterpriseUUID}/enterprise-users/{userUUID}/roles', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (17, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'GET', 'suppliers/{supplierUUID}/supplier-users/{userUUID}/roles', '用户权限管理', '获取用户的菜单列表', 'GET suppliers/{supplierUUID}/supplier-users/{userUUID}/roles', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (18, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'GET', 'enterprises/{enterpriseUUID}/enterprise-users', '企业管理员模块', '企业管理员列表', 'GET enterprises/{enterpriseUUID}/enterprise-users', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (19, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'POST', 'enterprises/{enterpriseUUID}/enterprise-users', '企业管理员模块', '新增企业管理员', 'POST enterprises/{enterpriseUUID}/enterprise-users', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (20, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'GET', 'enterprises/{enterpriseUUID}/enterprise-users/{userUUID}', '企业管理员模块', '管理员详情', 'GET enterprises/{enterpriseUUID}/enterprise-users/{userUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (21, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'PUT', 'enterprises/{enterpriseUUID}/enterprise-users/{userUUID}', '企业管理员模块', '更新管理员', 'PUT enterprises/{enterpriseUUID}/enterprise-users/{userUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (22, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'GET', 'enterprises/{enterpriseUUID}/enterprise-users/{userUUID}/login-logs', '企业管理员模块', '登录历史', 'GET enterprises/{enterpriseUUID}/enterprise-users/{userUUID}/login-logs', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (23, '2019-10-11 18:17:54', '2019-10-11 18:17:54', NULL, '', 'GET', 'suppliers/{supplierUUID}/supplier-users', '供应商管理员管理', '供应商管理员列表', 'GET suppliers/{supplierUUID}/supplier-users', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (24, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'POST', 'suppliers/{supplierUUID}/supplier-users', '供应商管理员管理', '新增供应商管理员', 'POST suppliers/{supplierUUID}/supplier-users', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (25, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'GET', 'suppliers/{supplierUUID}/supplier-users/{userUUID}', '供应商管理员管理', '管理员详情', 'GET suppliers/{supplierUUID}/supplier-users/{userUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (26, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'PUT', 'suppliers/{supplierUUID}/supplier-users/{userUUID}', '供应商管理员管理', '更新管理员', 'PUT suppliers/{supplierUUID}/supplier-users/{userUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (27, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'GET', 'suppliers/{supplierUUID}/supplier-users/{userUUID}/login-logs', '供应商管理员管理', '登录历史', 'GET suppliers/{supplierUUID}/supplier-users/{userUUID}/login-logs', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (28, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'GET', 'roles', '权限角色管理', '角色列表', 'GET roles', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (29, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'POST', 'roles', '权限角色管理', '创建角色', 'POST roles', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (30, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'GET', 'roles/{id}', '权限角色管理', '获取角色详情', 'GET roles/{id}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (31, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'PUT', 'roles/{id}', '权限角色管理', '更新角色', 'PUT roles/{id}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (32, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'DELETE', 'roles/{id}', '权限角色管理', '删除角色', 'DELETE roles/{id}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (33, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'GET', 'menus', '权限菜单管理', '获取菜单列表', 'GET menus', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (34, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'POST', 'menus', '权限菜单管理', '创建菜单', 'POST menus', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (35, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'GET', 'menus/{id}', '权限菜单管理', '显示菜单详情', 'GET menus/{id}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (36, '2019-10-11 18:17:55', '2019-10-11 18:17:55', NULL, '', 'PUT', 'menus/{id}', '权限菜单管理', '更新菜单', 'PUT menus/{id}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (37, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'DELETE', 'menus/{id}', '权限菜单管理', '删除菜单', 'DELETE menus/{id}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (38, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'POST', 'enterprises/{enterpriseUUID}/audit-status', '企业管理', '企业审核', 'POST enterprises/{enterpriseUUID}/audit-status', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (39, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'GET', 'enterprises', '企业管理', '企业列表', 'GET enterprises', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (40, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'POST', 'enterprises', '企业管理', '新增企业', 'POST enterprises', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (41, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'GET', 'enterprises/{enterpriseUUID}', '企业管理', '获取企业信息', 'GET enterprises/{enterpriseUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (42, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'PUT', 'enterprises/{enterpriseUUID}', '企业管理', '更新企业', 'PUT enterprises/{enterpriseUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (43, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'POST', 'suppliers/{supplierUUID}/audit-status', '供应商管理', '供应商审核', 'POST suppliers/{supplierUUID}/audit-status', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (44, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'GET', 'suppliers', '供应商管理', '供应商列表', 'GET suppliers', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (45, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'POST', 'suppliers', '供应商管理', '新增企业', 'POST suppliers', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (46, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'GET', 'suppliers/{supplierUUID}', '供应商管理', '获取企业信息', 'GET suppliers/{supplierUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (47, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'PUT', 'suppliers/{supplierUUID}', '供应商管理', '更新供应商', 'PUT suppliers/{supplierUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (48, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'GET', 'contracts', '签约管理', '签约列表', 'GET contracts', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (49, '2019-10-11 18:17:56', '2019-10-11 18:17:56', NULL, '', 'GET', 'contracts/{contractUUID}', '签约管理', '签约详情', 'GET contracts/{contractUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (50, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'GET', 'projects', '项目管理', '项目列表', 'GET projects', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (51, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'GET', 'projects/{projectUUID}', '项目管理', '获取项目信息', 'GET projects/{projectUUID}', 99, '管理公司WEB', 99);
INSERT INTO `nodes` VALUES (52, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'GET', 'enterprises', '企业管理', '企业列表', 'GET enterprises', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (53, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'GET', 'enterprises/{enterpriseUUID}', '企业管理', '获取企业信息', 'GET enterprises/{enterpriseUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (54, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'PUT', 'enterprises/{enterpriseUUID}', '企业管理', '更新企业', 'PUT enterprises/{enterpriseUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (55, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'GET', 'enterprise-users', '企业管理员', '管理员列表', 'GET enterprise-users', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (56, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'POST', 'enterprise-users', '企业管理员', '新增管理员', 'POST enterprise-users', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (57, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'GET', 'enterprise-users/{userUUID}', '企业管理员', '管理员详情', 'GET enterprise-users/{userUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (58, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'PUT', 'enterprise-users/{userUUID}', '企业管理员', '更新管理员', 'PUT enterprise-users/{userUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (59, '2019-10-11 18:17:57', '2019-10-11 18:17:57', NULL, '', 'GET', 'enterprise-users/{userUUID}/login-logs', '企业管理员', '查看登录记录', 'GET enterprise-users/{userUUID}/login-logs', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (60, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'PATCH', 'enterprise-users/{userUUID}/lock', '企业管理员', '锁定管理员', 'PATCH enterprise-users/{userUUID}/lock', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (61, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'PATCH', 'enterprise-users/{userUUID}/unlock', '企业管理员', '解锁管理员', 'PATCH enterprise-users/{userUUID}/unlock', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (62, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'PATCH', 'enterprise-users/{userUUID}/reset-password', '企业管理员', '重置管理员密码', 'PATCH enterprise-users/{userUUID}/reset-password', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (63, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'GET', 'enterprise-users/{userUUID}/roles', '用户权限管理', '获取用户的菜单列表', 'GET enterprise-users/{userUUID}/roles', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (64, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'GET', 'roles', '权限角色管理', '角色列表', 'GET roles', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (65, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'GET', 'contracts', '合同管理(企业端)', '签约列表', 'GET contracts', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (66, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'POST', 'contracts', '合同管理(企业端)', '申请签约', 'POST contracts', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (67, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'GET', 'contracts/{contractUUID}', '合同管理(企业端)', '签约详情', 'GET contracts/{contractUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (68, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'PUT', 'contracts/{contractUUID}', '合同管理(企业端)', '更新合同', 'PUT contracts/{contractUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (69, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'DELETE', 'contracts/{contractUUID}', '合同管理(企业端)', '删除签约', 'DELETE contracts/{contractUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (70, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'GET', 'projects', '项目管理', '项目列表', 'GET projects', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (71, '2019-10-11 18:17:58', '2019-10-11 18:17:58', NULL, '', 'POST', 'projects', '项目管理', '创建项目', 'POST projects', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (72, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'GET', 'projects/{projectUUID}', '项目管理', '获取项目信息', 'GET projects/{projectUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (73, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'PUT', 'projects/{projectUUID}', '项目管理', '修改项目', 'PUT projects/{projectUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (74, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'DELETE', 'projects/{projectUUID}', '项目管理', '删除项目', 'DELETE projects/{projectUUID}', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (75, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'GET', 'suppliers', '供应商', '供应商列表', 'GET suppliers', 10, '企业WEB', 10);
INSERT INTO `nodes` VALUES (76, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'GET', 'suppliers', '供应商管理', '', 'GET suppliers', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (77, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'GET', 'suppliers/{supplierUUID}', '供应商管理', '供应商信息', 'GET suppliers/{supplierUUID}', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (78, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'PUT', 'suppliers/{supplierUUID}', '供应商管理', '更新供应商', 'PUT suppliers/{supplierUUID}', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (79, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'GET', 'supplier-users', '供应商管理员', '供应商管理员', 'GET supplier-users', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (80, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'POST', 'supplier-users', '供应商管理员', '新增供应商管理员', 'POST supplier-users', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (81, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'GET', 'supplier-users/{userUUID}', '供应商管理员', '管理员详情', 'GET supplier-users/{userUUID}', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (82, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'PUT', 'supplier-users/{userUUID}', '供应商管理员', '更新管理员', 'PUT supplier-users/{userUUID}', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (83, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'GET', 'supplier-users/{userUUID}/login-logs', '供应商管理员', '登录历史', 'GET supplier-users/{userUUID}/login-logs', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (84, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'PATCH', 'supplier-users/{userUUID}/lock', '供应商管理员', '锁定', 'PATCH supplier-users/{userUUID}/lock', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (85, '2019-10-11 18:17:59', '2019-10-11 18:17:59', NULL, '', 'PATCH', 'supplier-users/{userUUID}/unlock', '供应商管理员', '', 'PATCH supplier-users/{userUUID}/unlock', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (86, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'PATCH', 'supplier-users/{userUUID}/reset-password', '供应商管理员', '重置管理员密码', 'PATCH supplier-users/{userUUID}/reset-password', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (87, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'GET', 'supplier-users/{userUUID}/roles', '用户权限管理', '获取用户的菜单列表', 'GET supplier-users/{userUUID}/roles', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (88, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'GET', 'roles', '权限角色管理', '角色列表', 'GET roles', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (89, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'GET', 'contracts', '签约管理', '签约列表', 'GET contracts', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (90, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'GET', 'contracts/{contractUUID}', '签约管理', '签约详情', 'GET contracts/{contractUUID}', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (91, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'POST', 'contracts/{contractUUID}/audit-status', '签约管理', '更改签约状态', 'POST contracts/{contractUUID}/audit-status', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (92, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'GET', 'projects', '项目管理', '项目列表', 'GET projects', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (93, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'GET', 'projects/{projectUUID}', '项目管理', '项目详情', 'GET projects/{projectUUID}', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (94, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'PUT', 'projects/{projectUUID}', '项目管理', '修改项目服务费率', 'PUT projects/{projectUUID}', 20, '供应商WEB', 20);
INSERT INTO `nodes` VALUES (95, '2019-10-11 18:18:00', '2019-10-11 18:18:00', NULL, '', 'POST', 'projects/{projectUUID}/audit-status', '项目管理', '项目审核', 'POST projects/{projectUUID}/audit-status', 20, '供应商WEB', 20);

-- ----------------------------
-- Table structure for projects
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `supplier_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商UUID',
  `supplier_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商名称',
  `enterprise_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '企业UUID',
  `enterprise_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '企业名称',
  `contract_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '合同名称',
  `contract_no` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '合同编号',
  `contract_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '合同UUID',
  `project_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '项目UUID',
  `project_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '项目名称',
  `charge_person_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '负责人姓名',
  `charge_person_phone_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '负责人手机号码',
  `industry_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '行业类型编码',
  `industry_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '行业类型名称',
  `employment_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用工类型编码',
  `employment_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用工类型名称',
  `service_charge` mediumint(7) UNSIGNED NOT NULL DEFAULT 0 COMMENT '服务费率（万分比）',
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '状态',
  `permission` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '权限控制，采用二进制 与或 方式判断',
  `address_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '项目地区编码',
  `address_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '项目地区名称',
  `address_detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '项目详细地址',
  `introduce` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '详细描述',
  `attachment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '附件内容',
  `is_open` tinyint(3) UNSIGNED NOT NULL COMMENT '是否启用',
  `is_industry_type_open` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '供应商行业类型是否启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '企业的项目记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of projects
-- ----------------------------
INSERT INTO `projects` VALUES (1, '2019-09-27 14:10:39', '2019-09-28 16:02:35', NULL, NULL, '11214919007392', '供应商1', '11114926757511', '天霸111', '合同1', '22222', '11414934105873', '21114952303971', '测试项目1', '胡文俊', '18271266564', '', '', '10', '全日制', 100, 99, 1, '120000', NULL, '测试地址', '323232', NULL, 1, NULL);
INSERT INTO `projects` VALUES (2, '2019-09-27 16:57:34', '2019-09-29 11:11:55', NULL, NULL, '11214926728184', '有棵树', '11114926757511', '天霸111', NULL, NULL, '20114944890848', '21114953305500', '測試2', '哈哈哈', '13412341234', 'B', '采矿业', '10', '全日制', 11, 99, 2, '210681104', '辽宁省丹东市东港市前阳镇', '東北', '1111', 'fb23c744947b2d15aa0693cc6dca2470', 1, NULL);
INSERT INTO `projects` VALUES (3, '2019-09-27 17:01:26', '2019-09-27 18:21:16', NULL, NULL, '11214919007392', '供应商1', '11114926757511', '天霸111', NULL, NULL, '11414934105873', '21114953328665', '111', '22', '13412121212', 'C', '制造业', '20', '劳务派遣', 0, 10, 3, '210000', '辽宁省', '222', '3333', NULL, 1, NULL);
INSERT INTO `projects` VALUES (4, '2019-09-27 17:06:41', '2019-09-27 17:06:41', NULL, NULL, '11214919007392', '供应商1', '11114926757511', '天霸111', '合同1', '2222', '11414934105873', '21114953360165', '555', '2222', '13412344321', 'C', '制造业', '10', '全日制', 0, 10, 0, '210000', '辽宁省', '222', '333', 'fb23c744947b2d15aa0693cc6dca2470', 1, NULL);
INSERT INTO `projects` VALUES (5, '2019-09-29 17:43:30', '2019-09-29 17:45:11', '2019-09-29 17:45:11', NULL, '11214962643427', '2', '11114954432048', '1', 'ht', '11', '20114962654441', '21114970861076', '1', '2', '13222222222', 'E', '建筑业', '20', '个人独资', 0, 10, 3, NULL, NULL, NULL, NULL, '[]', 1, NULL);
INSERT INTO `projects` VALUES (6, '2019-09-29 17:45:27', '2019-09-29 17:47:47', NULL, NULL, '11214962643427', '2', '11114954432048', '1', 'ht', '11', '20114962654441', '21114970872865', '122', '1', '13222222222', 'A', '农、林、牧、渔业', '20', '个人独资', 1000, 99, 3, NULL, NULL, NULL, '3345456', '[]', 0, NULL);

-- ----------------------------
-- Table structure for role_menu
-- ----------------------------
DROP TABLE IF EXISTS `role_menu`;
CREATE TABLE `role_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '角色对应菜单自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `role_id` int(11) UNSIGNED NOT NULL COMMENT '角色ID',
  `menu_id` int(11) UNSIGNED NOT NULL COMMENT '菜单ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '角色对应菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_menu
-- ----------------------------
INSERT INTO `role_menu` VALUES (1, '2019-09-20 15:46:21', '2019-09-20 15:46:21', NULL, '', 1, 1);
INSERT INTO `role_menu` VALUES (2, '2019-09-20 15:48:14', '2019-09-20 15:48:14', NULL, '', 1, 1);
INSERT INTO `role_menu` VALUES (3, '2019-09-20 15:48:15', '2019-09-20 15:48:15', NULL, '', 2, 2);
INSERT INTO `role_menu` VALUES (4, '2019-09-20 15:49:28', '2019-09-20 15:49:28', NULL, '', 1, 1);
INSERT INTO `role_menu` VALUES (5, '2019-09-20 15:49:28', '2019-09-20 15:49:28', NULL, '', 2, 2);
INSERT INTO `role_menu` VALUES (6, '2019-09-20 15:50:13', '2019-09-20 15:50:13', NULL, '', 1, 1);
INSERT INTO `role_menu` VALUES (7, '2019-09-20 15:50:13', '2019-09-20 15:50:13', NULL, '', 2, 2);
INSERT INTO `role_menu` VALUES (8, '2019-09-25 15:34:53', '2019-09-25 15:34:53', NULL, '', 5, 5);
INSERT INTO `role_menu` VALUES (9, '2019-09-25 15:34:53', '2019-09-25 15:34:53', NULL, '', 5, 6);
INSERT INTO `role_menu` VALUES (10, '2019-09-25 15:34:53', '2019-09-25 15:34:53', NULL, '', 5, 7);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '权限角色自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色名称',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '角色简介',
  `group` tinyint(3) UNSIGNED NOT NULL COMMENT '角色所属（通用/管理/企业/供应商）',
  `use_object_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '适用对象UUID',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, '2019-09-20 15:50:13', '2019-09-20 15:50:13', NULL, '', '超级角色', '拥有所有权限', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `roles` VALUES (2, '2019-09-20 15:50:13', '2019-09-20 15:50:13', NULL, '', '超级角色（只读）', '拥有所有只读权限', 0, '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `roles` VALUES (4, '2019-09-24 16:20:34', '2019-09-24 16:20:34', NULL, '', '1', '2', 99, '', '2019-09-24 16:20:34', '10314919049142', 'OJMS2', NULL, NULL);
INSERT INTO `roles` VALUES (5, '2019-09-24 16:20:57', '2019-09-25 14:34:52', NULL, '', '2', 'w', 99, '', '2019-09-25 14:34:52', '10314919049142', 'OJMS2', '10314919049142', 'OJMS2');

-- ----------------------------
-- Table structure for self_employ_users
-- ----------------------------
DROP TABLE IF EXISTS `self_employ_users`;
CREATE TABLE `self_employ_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `self_employ_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '个体工商户UUID',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  `user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户姓名',
  `user_phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户手机号码',
  `user_type` tinyint(3) UNSIGNED NOT NULL COMMENT '管理员类型',
  `is_open` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of self_employ_users
-- ----------------------------
INSERT INTO `self_employ_users` VALUES (1, '2019-10-08 14:49:56', '2019-10-08 15:26:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11515047579708', '10415047579716', '1111222', '13012121212', 10, 1);
INSERT INTO `self_employ_users` VALUES (2, '2019-10-10 14:59:40', '2019-10-11 17:19:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11515064918100', '10415064918141', 'self111', '18209099090', 10, 1);
INSERT INTO `self_employ_users` VALUES (3, '2019-10-11 17:23:55', '2019-10-11 18:41:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11515074423568', '10415074423587', 'roy1', '13012121219', 10, 1);

-- ----------------------------
-- Table structure for self_employs
-- ----------------------------
DROP TABLE IF EXISTS `self_employs`;
CREATE TABLE `self_employs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `self_employ_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '个体工商户UUID',
  `self_employ_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '个体工商户名称',
  `industry_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型编码',
  `industry_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型名称',
  `location_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '所在区域编码',
  `location_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '所在区域名称',
  `usci_number` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '统一信用代码',
  `artificial_person_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人姓名',
  `artificial_person_phone_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人手机号码',
  `artificial_person_certificate_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件类型编码',
  `artificial_person_certificate_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件类型名称',
  `artificial_person_certificate_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件号码',
  `business_scope` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '经营范围',
  `business_address` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '经营地址',
  `telephone` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '企业电话',
  `contact_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人姓名',
  `contact_phone_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人手机号码',
  `introduce` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '介绍',
  `tax_identification_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '纳税人识别号',
  `invoice_title` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发票抬头',
  `bank_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行名称',
  `bank_account` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行账号',
  `bank_reserve_mobile_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行预留手机号码',
  `invoice_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发票单位地址',
  `artificial_person_certificate_photo_front` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件照正面',
  `artificial_person_certificate_photo_back` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件照背面',
  `business_license_photo` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '营业执照照片',
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '状态',
  `email` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '邮箱',
  `source_from` tinyint(3) UNSIGNED NOT NULL COMMENT '创建来源',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建者UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建者姓名',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改者UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改者姓名',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '个体工商户记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of self_employs
-- ----------------------------
INSERT INTO `self_employs` VALUES (1, '2019-10-08 14:49:56', '2019-10-11 18:53:26', NULL, NULL, '11515047579708', '深圳市最前沿', 'B', '采矿业', '110000', '北京', '54645646', 'hu111', '13012121212', '40', '其他', '3453453', '4545', '深圳', '18271266261', '4545', '13012121212', '3333', '4343', '3434', '43234', '3434', '13012121212', '43242', NULL, NULL, 'd223d300f36305e0e4a8775241a06a57', 99, '2222', 10, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `self_employs` VALUES (2, '2019-10-10 14:59:40', '2019-10-10 18:39:33', NULL, NULL, '11515064918100', '深圳市物流科技', 'B', '采矿业', '120103002', '天津天津市河西区下瓦房街道', '5887664552222111', '呼呼呼', '13212121212', '30', '护照', '8808791897876878', '快递', '深圳', '18271266261', '酷酷酷', '13091212121', '配送国内公司', '67789755678566767', '物料1', '农业银行', '69009888232323', '18271266261', '龙华', NULL, NULL, 'd223d300f36305e0e4a8775241a06a57', 99, '599744613@qq.com', 10, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `self_employs` VALUES (3, '2019-10-11 17:23:55', '2019-10-11 17:24:29', NULL, NULL, '11515074423568', '深圳市天保达', 'I', '信息传输、软件和信息技术服务业', '440305007', '广东省深圳市南山区粤海街道', '887434343', '华为', '13008909898', '10', '身份证', '429008999012560987', '物流', '深圳', '18271266261', '胡', '18271266565', NULL, '5563435345', '677', '民生银行', '564646464', '18271266261', '深圳', NULL, NULL, 'fb23c744947b2d15aa0693cc6dca2470', 99, '5997446513@qq.com', 10, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for sms_logs
-- ----------------------------
DROP TABLE IF EXISTS `sms_logs`;
CREATE TABLE `sms_logs`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '短信记录自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '短信内容',
  `template` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '模版ID',
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '短信内容参数（JSON）',
  `receive_phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '接收短信号码',
  `send_status` tinyint(3) NULL DEFAULT NULL COMMENT '是否发送成功',
  `gateway` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发送渠道',
  `result` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for supplier_relation_natural_person
-- ----------------------------
DROP TABLE IF EXISTS `supplier_relation_natural_person`;
CREATE TABLE `supplier_relation_natural_person`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `supplier_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '供应商UUID',
  `supplier_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商名称',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '保存供应商是否有记录可查看自然人的信息记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier_relation_natural_person
-- ----------------------------
INSERT INTO `supplier_relation_natural_person` VALUES (1, '2019-10-09 17:37:05', '2019-10-09 17:37:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214926732818', '11', '10315056743882');

-- ----------------------------
-- Table structure for supplier_relation_self_employ
-- ----------------------------
DROP TABLE IF EXISTS `supplier_relation_self_employ`;
CREATE TABLE `supplier_relation_self_employ`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `supplier_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '供应商UUID',
  `supplier_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商名称',
  `self_employ_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '个体工商户UUID',
  `self_employ_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '个体工商户名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '保存供应商是否有记录可查看个体户的信息记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier_relation_self_employ
-- ----------------------------
INSERT INTO `supplier_relation_self_employ` VALUES (1, '2019-10-08 20:09:11', '2019-10-08 20:09:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214926732818', '供應商', '11515047579708', '深圳市最前沿');
INSERT INTO `supplier_relation_self_employ` VALUES (2, '2019-10-17 15:14:42', '2019-10-17 15:14:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214962643427', '1', '11515047579708', '2');
INSERT INTO `supplier_relation_self_employ` VALUES (3, '2019-10-17 15:14:52', '2019-10-17 15:14:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214962643427', '1', '11515064918100', '2');

-- ----------------------------
-- Table structure for supplier_subjects
-- ----------------------------
DROP TABLE IF EXISTS `supplier_subjects`;
CREATE TABLE `supplier_subjects`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `supplier_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商UUID',
  `supplier_subject_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '科目UUID',
  `supplier_subject_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '科目名称',
  `industry_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型编码',
  `industry_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型名称',
  `introduce` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '科目描述',
  `is_open` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '是否启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '供应商端的业务类型' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier_subjects
-- ----------------------------
INSERT INTO `supplier_subjects` VALUES (1, '2019-10-12 17:57:45', '2019-10-14 11:02:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214962643427', '12015083266597', '1', 'A', '农、林、牧、渔业', '3333', 1);
INSERT INTO `supplier_subjects` VALUES (2, '2019-10-12 18:25:01', '2019-10-12 18:25:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214962643427', '12015083430197', '1', 'B', '采矿业', '222', 1);
INSERT INTO `supplier_subjects` VALUES (3, '2019-10-14 11:03:50', '2019-10-14 11:03:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214962643427', '12015098063117', '3344', 'B', '采矿业', '444', 1);

-- ----------------------------
-- Table structure for supplier_users
-- ----------------------------
DROP TABLE IF EXISTS `supplier_users`;
CREATE TABLE `supplier_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `supplier_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商UUID',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  `user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户姓名',
  `user_phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户手机号码',
  `user_type` tinyint(3) UNSIGNED NOT NULL COMMENT '管理员类型',
  `is_open` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier_users
-- ----------------------------
INSERT INTO `supplier_users` VALUES (1, '2019-09-23 17:41:13', '2019-09-23 17:41:13', NULL, NULL, NULL, '10314892421441', 'OJMS', NULL, NULL, '11214919007392', '10214919007414', NULL, '18271266262', 10, 1);
INSERT INTO `supplier_users` VALUES (2, '2019-09-24 15:08:01', '2019-09-24 15:08:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214926728184', '10214926728206', NULL, '18271266264', 10, 1);
INSERT INTO `supplier_users` VALUES (3, '2019-09-24 15:08:47', '2019-09-24 15:08:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214926732818', '10214926732838', NULL, '18271266266', 10, 1);
INSERT INTO `supplier_users` VALUES (4, '2019-09-25 18:52:34', '2019-09-25 18:52:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214926732818', '10214936715521', '55', '18000000000', 20, 1);
INSERT INTO `supplier_users` VALUES (5, '2019-09-26 14:47:04', '2019-09-26 14:47:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214926732818', '10214943882517', '文君', '16688888888', 20, 1);
INSERT INTO `supplier_users` VALUES (6, '2019-09-26 16:54:32', '2019-09-26 16:54:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214944647332', '10214944647385', 'gys', '18290900908', 10, 1);
INSERT INTO `supplier_users` VALUES (7, '2019-09-27 20:22:21', '2019-09-27 20:22:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214954534224', '10214954534255', '1', '13222222222', 10, 1);
INSERT INTO `supplier_users` VALUES (8, '2019-09-28 18:53:53', '2019-10-16 14:57:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11214962643427', '10214962643458', '13222', '13200000000', 10, 1);

-- ----------------------------
-- Table structure for suppliers
-- ----------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `supplier_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '供应商UUID',
  `supplier_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商名称',
  `industry_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型编码',
  `industry_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型名称',
  `location_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '所在区域编码',
  `location_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '所在区域名称',
  `usci_number` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '统一信用代码',
  `artificial_person_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人姓名',
  `artificial_person_phone_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人手机号码',
  `artificial_person_certificate_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件类型编码',
  `artificial_person_certificate_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件类型名称',
  `artificial_person_certificate_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件号码',
  `business_scope` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '经营范围',
  `business_address` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '经营地址',
  `telephone` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '企业电话',
  `contact_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人姓名',
  `contact_phone_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人手机号码',
  `introduce` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '介绍',
  `tax_identification_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '纳税人识别号',
  `invoice_title` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发票抬头',
  `bank_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行名称',
  `bank_account` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行账号',
  `bank_reserve_mobile_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行预留手机号码',
  `invoice_address` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发票单位地址',
  `artificial_person_certificate_photo_front` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件照正面',
  `artificial_person_certificate_photo_back` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '法人证件照背面',
  `business_license_photo` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '营业执照照片',
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '状态',
  `email` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '邮箱',
  `source_from` tinyint(3) UNSIGNED NOT NULL COMMENT '创建来源',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建者UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建者姓名',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改者UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改者姓名',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '供应商记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of suppliers
-- ----------------------------
INSERT INTO `suppliers` VALUES (1, '2019-09-23 17:41:13', '2019-09-23 17:41:13', NULL, NULL, '11214919007392', '供应商1', 'B', '采矿业', '130303001', '河北省秦皇岛市山海关区南关街道', '7665575676', '胡', '18217767667', '2', '居民身份证(个人)', '42900899887876', '矿产', '三峡', '18278789898', '测试', '18278789898', '矿', NULL, 'dfgdsfgsdfg', '龙华', '34344634534', '18271266262', '龙华', 'd223d300f36305e0e4a8775241a06a57', 'fb23c744947b2d15aa0693cc6dca2470', 'd223d300f36305e0e4a8775241a06a57', 99, NULL, 1, '10314892421441', 'OJMS', NULL, NULL, '2019-09-23 17:41:13');
INSERT INTO `suppliers` VALUES (2, '2019-09-24 15:08:01', '2019-09-24 15:08:01', NULL, NULL, '11214926728184', '有棵树', 'B', '采矿业', '130000', '河北省', '898911231123', '小事情', '13400001234', '2', '居民身份证(个人)', '223232321', 'frsdf', 'dsfs', '13400000000', 'sdfsad', '13400000000', 'ddd', NULL, 'dddf', '中国银行', '6902313213131', '13400000000', '南山', 'd223d300f36305e0e4a8775241a06a57', 'fb23c744947b2d15aa0693cc6dca2470', 'd223d300f36305e0e4a8775241a06a57', 99, NULL, 10, '10314892421441', 'OJMS1', NULL, NULL, '2019-09-24 15:08:01');
INSERT INTO `suppliers` VALUES (3, '2019-09-24 15:08:47', '2019-09-24 15:08:47', NULL, NULL, '11214926732818', '有棵树1', 'B', '采矿业', '130000', '河北省', '8989112311231', '小事情', '13400001234', '2', '居民身份证(个人)', '223232321', 'frsdf', 'dsfs', '13400000000', 'sdfsad', '13400000000', 'ddd', NULL, 'dddf', '中国银行', '6902313213131', '13400000000', '南山', 'd223d300f36305e0e4a8775241a06a57', 'fb23c744947b2d15aa0693cc6dca2470', 'd223d300f36305e0e4a8775241a06a57', 99, NULL, 10, '10314892421441', 'OJMS1', NULL, NULL, '2019-09-24 15:08:47');
INSERT INTO `suppliers` VALUES (4, '2019-09-26 16:54:32', '2019-09-27 21:21:18', NULL, NULL, '11214944647332', '供应商111', 'C', '制造业', '110000', '北京', '223213', '12313', '18271266261', '10', '身份证', '7878787878', '2323', '2323', '18290900908', '333', '18276767676', '33333', NULL, '33', '4545', '222', '18290900908', NULL, '0f14f0145efec81606ed6c40be0053d8', '0f14f0145efec81606ed6c40be0053d8', 'd223d300f36305e0e4a8775241a06a57', 99, NULL, 20, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `suppliers` VALUES (5, '2019-09-27 20:22:21', '2019-09-27 20:22:21', NULL, NULL, '11214954534224', '1', 'B', '采矿业', '110000', '北京', '3', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5', '13555555555', NULL, '4', '4', '4', '4', '13444444444', '4', NULL, NULL, '6f2c97f045ba988851b02056c01c8d62', 99, NULL, 10, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `suppliers` VALUES (6, '2019-09-28 18:53:53', '2019-10-14 16:42:56', NULL, NULL, '11214962643427', '2', NULL, NULL, NULL, NULL, '334545', '4', NULL, '30', '护照', '1122', NULL, NULL, NULL, '2', '14333333333', NULL, '1', '2', '4', '1234567890', '13555555555', '3', NULL, NULL, '19dca4800a8da2975570fb34d02463cb', 99, NULL, 10, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for task_relation_bank_card
-- ----------------------------
DROP TABLE IF EXISTS `task_relation_bank_card`;
CREATE TABLE `task_relation_bank_card`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `task_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '任务UUID',
  `task_handle_object_type` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '指定派单人类型',
  `task_handle_object_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '接单自然人/个体户 UUID',
  `bank_identity` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行域名识别号',
  `bank_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行名称',
  `card_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '银行卡卡号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '任务收款银行卡' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tasks
-- ----------------------------
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  `create_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人UUID',
  `create_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建人',
  `update_user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人UUID',
  `update_user_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '修改人',
  `task_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '任务UUID',
  `task_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '任务名称',
  `project_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '项目UUID',
  `project_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '项目名称',
  `supplier_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商UUID',
  `supplier_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '供应商名称',
  `enterprise_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '企业UUID',
  `enterprise_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '企业名称',
  `address_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '任务地址编码',
  `address_name` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '任务地址名称',
  `address_detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '任务地址详细地址',
  `contact_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人姓名',
  `contact_phone_number` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '联系人手机号码',
  `introduce` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '任务描述',
  `start_time` timestamp(0) NULL DEFAULT NULL COMMENT '任务开始时间',
  `end_time` timestamp(0) NULL DEFAULT NULL COMMENT '结束时间',
  `industry_type_code` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型编码',
  `industry_type_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '行业类型名称',
  `supplier_subject_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '科目UUID',
  `supplier_subject_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '科目名称',
  `handle_object_type` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '指定派单人类型',
  `handle_object_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '接单自然人/个体户 UUID',
  `handle_object_name` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '接单自然人姓名/个体户公司名称',
  `handle_object_certificate_number` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '接单自然人身份证号码/个体户法人证件号码',
  `task_fees` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '任务订单金额',
  `task_fee_pay_status` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '任务订单金额支付状态',
  `service_charge_fees` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '服务费（分）',
  `service_charge_fee_pay_status` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '任务服务费支付状态',
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '状态',
  `attachment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '附件内容',
  `pictures` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '图片列表',
  `source_from` tinyint(3) UNSIGNED NOT NULL COMMENT '创建来源',
  `source_from_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '来源uuid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_login_pwd
-- ----------------------------
DROP TABLE IF EXISTS `user_login_pwd`;
CREATE TABLE `user_login_pwd`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  `pwd_type` tinyint(3) NULL DEFAULT NULL COMMENT '密码类型',
  `pwd_stat` tinyint(3) NULL DEFAULT NULL COMMENT '密码状态',
  `log_pwd` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '密码密文',
  `salt_pwd` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '加密盐值',
  `init_pwd` tinyint(3) NULL DEFAULT NULL COMMENT '初始密码标志',
  `cha_pwd` tinyint(3) NULL DEFAULT NULL COMMENT '是否强制修改密码',
  `lock_time` timestamp(0) NULL DEFAULT NULL COMMENT '锁定时间',
  `unlock_time` timestamp(0) NULL DEFAULT NULL COMMENT '解锁时间',
  `lock_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '锁定原因',
  `last_modified_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_login_pwd
-- ----------------------------
INSERT INTO `user_login_pwd` VALUES (1, '2019-09-20 15:50:14', '2019-09-24 10:05:15', NULL, '', '10314892421441', 1, 0, '$2y$10$zwJb3Jlh8tbw10b6gy1GWuHtYSkZTB7/09lLwl4EstKaUv4dOK9E2', '', 1, 1, '2019-09-24 10:05:09', NULL, '1', NULL);
INSERT INTO `user_login_pwd` VALUES (2, '2019-09-23 11:20:58', '2019-09-23 11:20:58', NULL, '', NULL, 1, 0, '$2y$10$htebxyhi7Z2lEYvW31kBAeOZ1n0pqt8OSaI/4Gul/upe.zzR3tZy.', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (3, '2019-09-23 11:23:38', '2019-09-23 11:23:38', NULL, '', '10314892421441', 1, 0, '$2y$10$92iY48flUQLX5LIUiUKsXug1TOXwn2xP9cufw36zKFULRNtGNAVp.', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (4, '2019-09-23 13:58:27', '2019-09-23 13:58:27', NULL, '', '10314892421441', 1, 0, '$2y$10$6oJOFhGwpcWfeHZiBgvhPufHY9GouRjddsZHcFVR8JWKWN8BL9Ysm', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (5, '2019-09-23 14:48:54', '2019-09-23 14:48:54', NULL, '', '10314892421441', 1, 0, '$2y$10$mEScQUfmgm0os5GhVGBLvehznWLo0flTaZBcC7k6dz60pP8Zrkjdq', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (6, '2019-09-23 14:56:19', '2019-09-23 14:56:19', NULL, '', '10314892421441', 1, 0, '$2y$10$hhgKEsoXlFjIcZ5k9TkdhOWWD2UPVQM88mqe2.vTI/WWWEDKZ7Agu', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (7, '2019-09-23 17:41:14', '2019-09-23 17:41:14', NULL, '', '10314892421441', 1, 0, '$2y$10$3YISkxmYTYzYffEVnoy3yuKOutSN1EJ45Rk//svmG6PVfEiSLunpS', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (8, '2019-09-23 17:48:11', '2019-10-16 14:56:04', NULL, '', '10314919049142', 1, 0, '$2y$10$c5aTCkfxfzrO8wnuVM1PeuiuuMAYjgdo9wpvgTo1miE1D6E/DdjQm', '', 0, 0, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (9, '2019-09-24 09:36:04', '2019-09-24 09:36:04', NULL, '', '10314892421441', 1, 0, '$2y$10$cKFWCtlKZGFDk49Apjk/Feo56zNhsZixpk45VuCZFoOoU5AWAyv6C', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (10, '2019-09-24 11:26:30', '2019-09-25 11:34:45', NULL, '', '10314925399105', 1, 0, '$2y$10$Eg2joVGIBEvHAjVBQr2nWuyGCXJ.MuLS.bfziLKESxsExkTr3tVRK', '', 1, 1, '2019-09-24 11:27:32', NULL, '1', NULL);
INSERT INTO `user_login_pwd` VALUES (11, '2019-09-24 14:50:54', '2019-09-24 14:50:54', NULL, '', NULL, 1, 0, '$2y$10$gqJgw4HWuMmCqwWJXTahu.XKfuOC8O1nyLErYXDgg/krJLN2w/THq', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (12, '2019-09-24 14:53:21', '2019-09-24 14:53:21', NULL, '', '10114926640200', 1, 0, '$2y$10$NbrvCzaQCY8rE3AiePo/N.eos1ReZzPoSR907sHPHB6D29FYB7ci2', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (13, '2019-09-24 15:08:48', '2019-09-24 15:08:48', NULL, '', '10214926732838', 1, 0, '$2y$10$e35HW7dJUbKMCOgXwuOvCOGTd/7KplmEa9qFPzOBgD6rKPw8aUCRi', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (14, '2019-09-24 15:12:54', '2019-09-24 15:12:54', NULL, '', '10114926757520', 1, 0, '$2y$10$8mrmhZjaatUxe5kQqF0VEumIpOkvkwPYq58lUlnwlO.AM5CXRMTDC', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (15, '2019-09-25 18:42:57', '2019-10-16 14:59:40', NULL, '', '10114936657826', 1, 0, '$2y$10$PvlkPPsmf6wIC4BHnBrdJ.Zn1WaeWovG2fzXrGXSiUstSPVeVqi6a', '', 0, 0, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (16, '2019-09-25 18:52:35', '2019-09-25 18:52:35', NULL, '', '10214936715521', 1, 0, '$2y$10$uBiKCHjBSfAFNHsIhmay3O0dojIKJOMd1ptolzlF8Xw4pcpq7BnYm', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (17, '2019-09-25 19:40:03', '2019-09-25 19:40:03', NULL, '', '10114937000403', 1, 0, '$2y$10$UzTRhfDnzqoHolcc2PxoJueJl1BmwJ8qSOq2UDpx109o3Puo.S/TK', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (18, '2019-09-26 11:15:35', '2019-09-26 11:15:35', NULL, '', '10114942613643', 1, 0, '$2y$10$zRWDQy8.CvkEIuXKi8NWy.IyL3xCYPBmG7RVOrhVSumGP3SUcTPOu', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (19, '2019-09-26 11:44:23', '2019-09-26 11:44:23', NULL, '', '10114942786447', 1, 0, '$2y$10$vSJM/1AyoEEzpJ0vcmTnaOag2gFB2D/vdQtpLkyoQ3tKN9qJl080W', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (20, '2019-09-26 14:10:51', '2019-09-26 14:10:51', NULL, '', '10114943665261', 1, 0, '$2y$10$C/vEn35KnC8GjD6kC0cDVef5j6EV0sFRkMPf04c2kM8qbPawfJDIe', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (21, '2019-09-26 14:44:22', '2019-09-26 14:45:12', NULL, '', '10114943866388', 1, 0, '$2y$10$38LKJSa4e3/SGEDGl52fc.PHPHArnpLtQUHa94E1RnUO0q55lSZD2', '', 0, 0, '2019-09-26 14:45:12', '2019-09-27 14:45:12', '測試', NULL);
INSERT INTO `user_login_pwd` VALUES (22, '2019-09-26 14:47:04', '2019-09-26 14:47:04', NULL, '', '10214943882517', 1, 0, '$2y$10$Uf06H3on4Q0.GWgWnMVl0.Z9/Mj0Yl8bNN7rijHrLx2PHB/cvQMLO', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (23, '2019-09-26 16:54:33', '2019-09-26 16:54:33', NULL, '', '10214944647385', 1, 0, '$2y$10$1uiUE9L2GDxuaUgsKAH/eembFePJ8HP8HO8TLxMDuKEYyYYfF2z0G', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (24, '2019-09-27 20:05:20', '2019-09-27 20:05:20', NULL, '', '10114954432115', 1, 0, '$2y$10$bt8P.Te9dNaIelHWy/neZeHGIzBS6zxMIdeGP9lM.qdEREmEidyCO', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (25, '2019-09-27 20:11:31', '2019-09-27 20:11:31', NULL, '', '10114954469233', 1, 0, '$2y$10$8D.H1VWiLgeFNEpTu489.uxzjoME/gaF7VE.dUxbRqt9U7XQFrN3S', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (26, '2019-09-27 20:22:21', '2019-09-27 20:22:21', NULL, '', '10214954534255', 1, 0, '$2y$10$dkDeUlVVq/ltO1S41.Sy7OY1DuulwMmcOMCnPCcUcEpPPMyON8sRW', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (27, '2019-09-28 18:53:54', '2019-10-16 14:58:20', NULL, '', '10214962643458', 1, 0, '$2y$10$qfopM9/M3F3A7FlF4l0j5O45RFQFget8Kq1iZ2bIwZXAvYmERE8gq', '', 0, 0, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (28, '2019-10-08 14:49:57', '2019-10-08 14:49:57', NULL, '', '10415047579716', 1, 0, '$2y$10$LObuK0NC58EzD5UupHn68.jAZjPQ9maaTtZvv1xa3wOU.5.QTMbo2', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (29, '2019-10-10 14:59:41', '2019-10-10 14:59:41', NULL, '', '10415064918141', 1, 0, '$2y$10$FW6A.9y/.f0ujTEN/0Fzj.lkPfpBaFuAY0xcvJWrvCPZM0vTotjm.', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (30, '2019-10-11 17:23:55', '2019-10-11 17:23:55', NULL, '', '10415074423587', 1, 0, '$2y$10$ujyapugYIyogybBddcjHqu07VRpB5dvifeNZ7y2rJGXqudHu7uSce', '', 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `user_login_pwd` VALUES (31, '2019-10-16 13:56:28', '2019-10-16 13:56:28', NULL, '', '10315116378877', 1, 0, '$2y$10$OesKVRFgHjqyVRcC0sBJC.lULPaVRA35fRgAe1p4n1oGemD5jCgPW', '', 1, 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for user_logins
-- ----------------------------
DROP TABLE IF EXISTS `user_logins`;
CREATE TABLE `user_logins`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '登录标志自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `user_group` tinyint(3) UNSIGNED NOT NULL COMMENT '用户分组',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户UUID',
  `login_type` tinyint(3) NULL DEFAULT NULL COMMENT '标识类型（1.手机号、2.邮箱、3.昵称）',
  `login_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '登录标识内容',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_logins
-- ----------------------------
INSERT INTO `user_logins` VALUES (1, '2019-09-20 15:50:14', '2019-09-20 15:50:14', NULL, '', 99, '10314892421441', 1, '18999999999');
INSERT INTO `user_logins` VALUES (2, '2019-09-23 11:20:58', '2019-09-23 11:20:58', NULL, '', 10, NULL, 1, '18272166252');
INSERT INTO `user_logins` VALUES (3, '2019-09-23 11:23:38', '2019-09-23 11:23:38', NULL, '', 10, '10314892421441', 1, '18272166251');
INSERT INTO `user_logins` VALUES (4, '2019-09-23 13:58:27', '2019-09-23 13:58:27', NULL, '', 20, '10314892421441', 1, '18271266261');
INSERT INTO `user_logins` VALUES (5, '2019-09-23 14:48:54', '2019-09-23 14:48:54', NULL, '', 10, '10314892421441', 1, '18271266262');
INSERT INTO `user_logins` VALUES (6, '2019-09-23 14:56:19', '2019-09-23 14:56:19', NULL, '', 10, '10314892421441', 1, '18271266262');
INSERT INTO `user_logins` VALUES (7, '2019-09-23 17:41:14', '2019-09-23 17:41:14', NULL, '', 20, '10314892421441', 1, '18271266262');
INSERT INTO `user_logins` VALUES (8, '2019-09-23 17:48:11', '2019-09-23 17:48:11', NULL, '', 99, '10314919049142', 1, '18888888888');
INSERT INTO `user_logins` VALUES (9, '2019-09-24 09:36:04', '2019-09-24 09:36:04', NULL, '', 10, '10314892421441', 1, '18866666666');
INSERT INTO `user_logins` VALUES (10, '2019-09-24 11:26:30', '2019-09-24 11:26:30', NULL, '', 99, '10314925399105', 1, '16777777777');
INSERT INTO `user_logins` VALUES (11, '2019-09-24 14:50:54', '2019-09-24 14:50:54', NULL, '', 10, NULL, 1, '18271266261');
INSERT INTO `user_logins` VALUES (12, '2019-09-24 14:53:22', '2019-09-24 14:53:22', NULL, '', 10, '10114926640200', 1, '18271266262');
INSERT INTO `user_logins` VALUES (13, '2019-09-24 15:08:48', '2019-09-24 15:08:48', NULL, '', 20, '10214926732838', 1, '18271266266');
INSERT INTO `user_logins` VALUES (14, '2019-09-24 15:12:54', '2019-09-24 15:12:54', NULL, '', 10, '10114926757520', 1, '18209090908');
INSERT INTO `user_logins` VALUES (15, '2019-09-25 18:42:57', '2019-09-25 18:42:57', NULL, '', 10, '10114936657826', 1, '18212341234');
INSERT INTO `user_logins` VALUES (16, '2019-09-25 18:52:35', '2019-09-25 18:52:35', NULL, '', 20, '10214936715521', 1, '18000000000');
INSERT INTO `user_logins` VALUES (17, '2019-09-25 19:40:03', '2019-09-25 19:40:03', NULL, '', 10, '10114937000403', 1, '13000000000');
INSERT INTO `user_logins` VALUES (18, '2019-09-26 11:15:35', '2019-09-26 11:15:35', NULL, '', 10, '10114942613643', 1, '13412121212');
INSERT INTO `user_logins` VALUES (19, '2019-09-26 11:44:23', '2019-09-26 11:44:23', NULL, '', 10, '10114942786447', 1, '18011111111');
INSERT INTO `user_logins` VALUES (20, '2019-09-26 14:10:51', '2019-09-26 14:10:51', NULL, '', 10, '10114943665261', 1, '18211111111');
INSERT INTO `user_logins` VALUES (21, '2019-09-26 14:44:23', '2019-09-26 14:44:23', NULL, '', 10, '10114943866388', 1, '13477474643');
INSERT INTO `user_logins` VALUES (22, '2019-09-26 14:47:04', '2019-09-26 14:47:04', NULL, '', 20, '10214943882517', 1, '16688888888');
INSERT INTO `user_logins` VALUES (23, '2019-09-26 16:54:33', '2019-09-26 16:54:33', NULL, '', 20, '10214944647385', 1, '18290900908');
INSERT INTO `user_logins` VALUES (24, '2019-09-27 20:05:20', '2019-09-27 20:05:20', NULL, '', 10, '10114954432115', 1, '12222222222');
INSERT INTO `user_logins` VALUES (25, '2019-09-27 20:11:31', '2019-09-27 20:11:31', NULL, '', 10, '10114954469233', 1, '13211111111');
INSERT INTO `user_logins` VALUES (26, '2019-09-27 20:22:22', '2019-09-27 20:22:22', NULL, '', 20, '10214954534255', 1, '13222222222');
INSERT INTO `user_logins` VALUES (27, '2019-09-28 18:53:54', '2019-09-28 18:53:54', NULL, '', 20, '10214962643458', 1, '13200000000');
INSERT INTO `user_logins` VALUES (28, '2019-10-08 14:49:57', '2019-10-08 14:49:57', NULL, '', 40, '10415047579716', 1, '13012121212');
INSERT INTO `user_logins` VALUES (29, '2019-10-10 14:59:41', '2019-10-10 14:59:41', NULL, '', 40, '10415064918141', 1, '18209099090');
INSERT INTO `user_logins` VALUES (30, '2019-10-11 17:23:55', '2019-10-11 17:23:55', NULL, '', 40, '10415074423587', 1, '13012121219');
INSERT INTO `user_logins` VALUES (31, '2019-10-16 13:56:28', '2019-10-16 13:56:28', NULL, '', 30, '10315116378877', 1, '13222222222');

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户角色自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户UUID',
  `role_id` int(11) UNSIGNED NOT NULL COMMENT '权限角色ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES (1, '2019-09-20 15:50:14', '2019-09-20 15:50:14', NULL, '', '10314892421441', 1);
INSERT INTO `user_role` VALUES (2, '2019-09-23 11:23:38', '2019-09-23 11:23:38', NULL, '', '10314892421441', 1);
INSERT INTO `user_role` VALUES (3, '2019-09-23 13:58:27', '2019-09-23 13:58:27', NULL, '', '10314892421441', 1);
INSERT INTO `user_role` VALUES (4, '2019-09-23 14:48:54', '2019-09-23 14:48:54', NULL, '', '10314892421441', 1);
INSERT INTO `user_role` VALUES (5, '2019-09-23 14:56:19', '2019-09-23 14:56:19', NULL, '', '10314892421441', 1);
INSERT INTO `user_role` VALUES (6, '2019-09-23 17:41:14', '2019-09-23 17:41:14', NULL, '', '10314892421441', 1);
INSERT INTO `user_role` VALUES (7, '2019-09-23 17:48:11', '2019-09-23 17:48:11', NULL, '', '10314919049142', 1);
INSERT INTO `user_role` VALUES (8, '2019-09-24 09:36:04', '2019-09-24 09:36:04', NULL, '', '10314892421441', 1);
INSERT INTO `user_role` VALUES (9, '2019-09-24 14:53:22', '2019-09-24 14:53:22', NULL, '', '10114926640200', 1);
INSERT INTO `user_role` VALUES (10, '2019-09-24 15:08:48', '2019-09-24 15:08:48', NULL, '', '10214926732838', 1);
INSERT INTO `user_role` VALUES (11, '2019-09-24 15:12:55', '2019-09-24 15:12:55', NULL, '', '10114926757520', 1);
INSERT INTO `user_role` VALUES (14, '2019-09-25 12:34:03', '2019-09-25 12:34:03', NULL, '', '10314925399105', 4);
INSERT INTO `user_role` VALUES (15, '2019-09-26 14:10:51', '2019-09-26 14:10:51', NULL, '', '10114943665261', 1);
INSERT INTO `user_role` VALUES (16, '2019-09-26 16:54:33', '2019-09-26 16:54:33', NULL, '', '10214944647385', 1);
INSERT INTO `user_role` VALUES (17, '2019-09-27 20:05:20', '2019-09-27 20:05:20', NULL, '', '10114954432115', 1);
INSERT INTO `user_role` VALUES (18, '2019-09-27 20:22:22', '2019-09-27 20:22:22', NULL, '', '10214954534255', 1);
INSERT INTO `user_role` VALUES (19, '2019-09-28 18:53:54', '2019-09-28 18:53:54', NULL, '', '10214962643458', 1);
INSERT INTO `user_role` VALUES (20, '2019-10-08 14:49:57', '2019-10-08 14:49:57', NULL, '', '10415047579716', 1);
INSERT INTO `user_role` VALUES (21, '2019-10-10 14:59:41', '2019-10-10 14:59:41', NULL, '', '10415064918141', 1);
INSERT INTO `user_role` VALUES (22, '2019-10-11 17:23:55', '2019-10-11 17:23:55', NULL, '', '10415074423587', 1);

-- ----------------------------
-- Table structure for user_tokens
-- ----------------------------
DROP TABLE IF EXISTS `user_tokens`;
CREATE TABLE `user_tokens`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户登录自增ID',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '最后更新时间',
  `delete_time` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',
  `memo` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '备注',
  `user_group` tinyint(3) UNSIGNED NOT NULL COMMENT '用户分组（管理/企业/供应商）',
  `user_uuid` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户UUID',
  `token` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '登录后返回的用户标志',
  `last_activity_time` timestamp(0) NOT NULL COMMENT '最后活动时间',
  `token_group` char(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'token分组（登录来源）',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `token`(`token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_tokens
-- ----------------------------
INSERT INTO `user_tokens` VALUES (1, '2019-09-20 15:50:26', '2019-10-11 15:58:19', NULL, '', 99, '10314892421441', 'JU7L7JhjwQ3gtan7Q06PDspN47k9gCjJ', '2019-10-26 15:58:19', 'web');
INSERT INTO `user_tokens` VALUES (2, '2019-09-23 17:48:28', '2019-10-16 14:56:20', NULL, '', 99, '10314919049142', 'TKldKGqs6vVz1a11v0QU6PZ4ALhirxGC', '2019-10-31 14:56:20', 'web');
INSERT INTO `user_tokens` VALUES (3, '2019-09-24 14:08:22', '2019-09-24 14:54:48', NULL, '', 10, '10314892421441', 'bt8iD3A9YaUyw1TPLvltEsdUUS2qzYoG', '2019-10-09 14:54:48', 'web');
INSERT INTO `user_tokens` VALUES (4, '2019-09-24 15:09:22', '2019-10-08 19:09:17', NULL, '', 20, '10214926732838', 'FdBiEIihd7kOGEBenJWArMy1DgVOfWHO', '2019-10-23 19:09:17', 'web');
INSERT INTO `user_tokens` VALUES (5, '2019-09-24 15:13:27', '2019-10-08 18:02:49', NULL, '', 10, '10114926757520', 'xsX0ZKE6PhnnWMtKCgxQK1ccGezjCp3h', '2019-10-23 18:02:49', 'web');
INSERT INTO `user_tokens` VALUES (6, '2019-09-28 15:12:55', '2019-09-28 15:12:55', NULL, '', 10, '10114954469233', 'HtTfQMIcaEqGw3LlEaO83w5h3uKp41Fc', '2019-10-13 15:12:55', 'web');
INSERT INTO `user_tokens` VALUES (7, '2019-09-28 18:53:02', '2019-09-28 18:53:02', NULL, '', 20, '10314892421441', 'wLUoiaYB5pd9WhRaYTbSZLDKKtrogCuC', '2019-10-13 18:53:02', 'web');
INSERT INTO `user_tokens` VALUES (8, '2019-09-28 18:54:12', '2019-10-17 14:13:48', NULL, '', 20, '10214962643458', 'PzTvmDuTsTEAPlslh9e0GGmyikCbLSyR', '2019-11-01 14:13:48', 'web');
INSERT INTO `user_tokens` VALUES (9, '2019-10-14 10:37:13', '2019-10-16 14:59:48', NULL, '', 10, '10114936657826', 'CBaym4ggnxvx7prYvgrm0veLrEGz5N89', '2019-10-31 14:59:48', 'web');

SET FOREIGN_KEY_CHECKS = 1;
