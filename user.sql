/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.137
Source Server Version : 50550
Source Host           : 192.168.1.137:3306
Source Database       : sample

Target Server Type    : MYSQL
Target Server Version : 50550
File Encoding         : 65001

Date: 2016-11-11 16:20:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(32) DEFAULT NULL,
  `passwd` varchar(128) DEFAULT NULL,
  `ip_address` varchar(255) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_update` datetime NOT NULL,
  `active` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '22352352235235@qq.com', '1242142141241241', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `user` VALUES ('2', '2235235@sina.com', '495908dc1862d3be50030d5660b5bc51', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `user` VALUES ('3', '12412412@sina.com', '495908dc1862d3be50030d5660b5bc51', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `user` VALUES ('4', '7470@sina.com', '495908dc1862d3be50030d5660b5bc51', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `user` VALUES ('5', 'Flight10@qq.com', null, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `user` VALUES ('6', 'Flight10@qq11.com', null, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `user` VALUES ('8', 'Flight10@qq.com', null, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `user` VALUES ('9', 'Flight10@qq.com', null, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `user` VALUES ('10', 'Flight10@qq.com', null, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
