/*
SQLyog Trial v12.4.3 (64 bit)
MySQL - 5.7.19-0ubuntu0.16.04.1 : Database - my.tool
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`my.tool` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `my.tool`;

/*Table structure for table `yt_history` */

DROP TABLE IF EXISTS `yt_history`;

CREATE TABLE `yt_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `room_id` int(10) NOT NULL DEFAULT '0' COMMENT '房间号',
  `send_id` int(10) NOT NULL DEFAULT '0' COMMENT '发送人',
  `body` varchar(500) NOT NULL DEFAULT '' COMMENT '内容',
  `created_tim` int(10) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `msg_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.文本2.图片3.文件',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `yt_history` */

/*Table structure for table `yt_room` */

DROP TABLE IF EXISTS `yt_room`;

CREATE TABLE `yt_room` (
  `room_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `room_name` varchar(100) NOT NULL DEFAULT '' COMMENT '房间名称',
  `created_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `users` varchar(500) NOT NULL DEFAULT '' COMMENT '用户ids',
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `yt_room` */

insert  into `yt_room`(`room_id`,`room_name`,`created_time`,`users`) values 
(1,'测试房间',1500688235,'1,2');

/*Table structure for table `yt_user` */

DROP TABLE IF EXISTS `yt_user`;

CREATE TABLE `yt_user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `nick_name` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `true_name` varchar(20) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `qq` varchar(20) NOT NULL DEFAULT '' COMMENT 'QQ号码',
  `user_password` varchar(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `created_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `salt` char(4) NOT NULL DEFAULT '' COMMENT '盐',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未填写1男2女',
  `birthday` char(10) NOT NULL DEFAULT '' COMMENT '出生日期',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `yt_user` */

insert  into `yt_user`(`user_id`,`user_name`,`nick_name`,`true_name`,`email`,`qq`,`user_password`,`created_time`,`salt`,`sex`,`birthday`) values 
(1,'admin','admin','我叫管理员','admin@yt.com','admin.qq','e5e23e78180c3e185df07116cd2ed38d',1500688235,'8888',1,'2017-07-22'),
(2,'test','test','我叫测试','test@yt.com','test.qq','d6c90d64f90b2ebda6692bf7325ef6cf',1500688235,'6666',1,'2017-07-22');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
