/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : mmsys

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-09-12 16:25:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `realname` varchar(30) NOT NULL COMMENT '名字',
  `sex` tinyint(4) DEFAULT NULL COMMENT '性别',
  `telephone` varchar(11) NOT NULL COMMENT '电话',
  `remark` varchar(50) DEFAULT NULL COMMENT '备注',
  `money` decimal(8,2) NOT NULL COMMENT '余额',
  `is_vip` tinyint(10) NOT NULL COMMENT '是否vip',
  `photo` varchar(100) NOT NULL COMMENT '头像',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '刘亦菲', '1', '1234545232', '明星', '10000.00', '1', '');
