/*
SQLyog Community Edition- MySQL GUI v6.5 Beta1
MySQL - 5.5.20-log : Database - oa_315
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

create database if not exists `oa_315`;

USE `oa_315`;

/*Table structure for table `sys_account` */

DROP TABLE IF EXISTS `sys_account`;

CREATE TABLE `sys_account` (
  `a_id` varchar(40) NOT NULL DEFAULT '',
  `a_login_id` varchar(40) DEFAULT NULL COMMENT '账号',
  `a_name` varchar(80) DEFAULT NULL COMMENT '显示名称',
  `a_password` varchar(80) DEFAULT NULL COMMENT '密码',
  `a_status` tinyint(3) unsigned DEFAULT NULL COMMENT '状态',
  `a_note` text COMMENT '备注',
  `a_login_type` tinyint(3) unsigned DEFAULT '0' COMMENT '登陆验证类型',
  `db_time_update` datetime DEFAULT NULL COMMENT '数据更新时间',
  `db_time_create` datetime DEFAULT NULL COMMENT '数据创建时间',
  `db_person_create` varchar(40) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_account` */

insert  into `sys_account`(`a_id`,`a_login_id`,`a_name`,`a_password`,`a_status`,`a_note`,`a_login_type`,`db_time_update`,`db_time_create`,`db_person_create`) values ('D7D3F9ED5BE45E07055D2731A48537D3','admin','管理员','478f1079a9bcb61360802c727aa8abbf',2,'管理员账户',1,'2017-07-06 14:25:17',NULL,NULL);

/*Table structure for table `sys_acl` */

DROP TABLE IF EXISTS `sys_acl`;

CREATE TABLE `sys_acl` (
  `op_id` varchar(40) NOT NULL DEFAULT '',
  `ra_id` varchar(40) NOT NULL DEFAULT '',
  `a_acl` int(11) DEFAULT '0' COMMENT '权限',
  `db_time_update` datetime DEFAULT NULL,
  `a_login_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`op_id`,`ra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_acl` */

insert  into `sys_acl`(`op_id`,`ra_id`,`a_acl`,`db_time_update`,`a_login_id`) values ('proc_back','ADDAF09C938EE8EBFEF131A14E51B857',6,'2017-07-04 16:49:15',NULL),('proc_back','D7D3F9ED5BE45E07055D2731A48537D3',2,'2017-07-04 16:46:28','admin');

/*Table structure for table `sys_back_task` */

DROP TABLE IF EXISTS `sys_back_task`;

CREATE TABLE `sys_back_task` (
  `bt_id` varchar(40) NOT NULL DEFAULT '',
  `bt_name` varchar(80) DEFAULT NULL COMMENT '任务名称',
  `bt_param` text COMMENT '参数',
  `db_time_create` datetime DEFAULT NULL COMMENT '数据创建时间',
  `db_time_update` datetime DEFAULT NULL COMMENT '数据更新时间',
  `db_person_create` varchar(40) DEFAULT NULL COMMENT '创建人',
  `bt_type` varchar(40) DEFAULT NULL COMMENT '类型',
  `bt_result` tinyint(3) unsigned DEFAULT '0' COMMENT '结果',
  PRIMARY KEY (`bt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_back_task` */

/*Table structure for table `sys_contact` */

DROP TABLE IF EXISTS `sys_contact`;

CREATE TABLE `sys_contact` (
  `c_id` varchar(40) NOT NULL DEFAULT '',
  `c_name` varchar(80) DEFAULT NULL COMMENT '姓名',
  `c_login_id` varchar(40) DEFAULT NULL COMMENT '关联账户',
  `c_sex_type` tinyint(3) NOT NULL COMMENT '性别',
  `c_tele` varchar(20) DEFAULT NULL COMMENT '手机',
  `c_email` varchar(20) DEFAULT NULL COMMENT 'EMAIL',
  `c_type` tinyint(3) DEFAULT NULL COMMENT '人员类型',
  `db_time_update` datetime DEFAULT NULL COMMENT '数据更新时间',
  `db_time_create` datetime DEFAULT NULL COMMENT '数据创建时间',
  `db_person_create` varchar(40) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_contact` */

insert  into `sys_contact`(`c_id`,`c_name`,`c_login_id`,`c_sex_type`,`c_tele`,`c_email`,`c_type`,`db_time_update`,`db_time_create`,`db_person_create`) values ('D7D3F9ED5BE45E07055D2731A48537D3','管理员','admin',1,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `sys_link` */

DROP TABLE IF EXISTS `sys_link`;

CREATE TABLE `sys_link` (
  `op_id` varchar(40) NOT NULL,
  `op_table` varchar(80) NOT NULL,
  `op_field` varchar(80) NOT NULL,
  `sn` int(11) NOT NULL DEFAULT '0',
  `link_id` varchar(40) NOT NULL,
  `link_table` varchar(80) NOT NULL,
  `link_field` varchar(80) NOT NULL,
  `content` varchar(120) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`op_id`,`link_id`,`sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_link` */

/*Table structure for table `sys_log_login` */

DROP TABLE IF EXISTS `sys_log_login`;

CREATE TABLE `sys_log_login` (
  `log_id` varchar(40) NOT NULL,
  `log_time` datetime DEFAULT NULL,
  `a_id` varchar(40) DEFAULT NULL,
  `a_login_id` varchar(80) DEFAULT NULL,
  `c_id` varchar(40) DEFAULT NULL,
  `c_name` varchar(80) DEFAULT NULL,
  `log_result` tinyint(3) unsigned DEFAULT '0',
  `log_note` text,
  `log_client_ip` varchar(40) DEFAULT NULL,
  `log_user_agent` varchar(200) DEFAULT NULL,
  `log_ua_type` tinyint(3) unsigned DEFAULT '0',
  `log_ua_name` varchar(200) DEFAULT NULL,
  `db_time_update` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MRG_MyISAM DEFAULT CHARSET=utf8 INSERT_METHOD=LAST UNION=(`sys_log_login2017`);

/*Data for the table `sys_log_login` */

/*Table structure for table `sys_log_login2017` */

DROP TABLE IF EXISTS `sys_log_login2017`;

CREATE TABLE `sys_log_login2017` (
  `log_id` varchar(40) NOT NULL,
  `log_time` datetime DEFAULT NULL,
  `a_id` varchar(40) DEFAULT NULL,
  `a_login_id` varchar(80) DEFAULT NULL,
  `c_id` varchar(40) DEFAULT NULL,
  `c_name` varchar(80) DEFAULT NULL,
  `log_result` tinyint(3) unsigned DEFAULT '0',
  `log_note` text,
  `log_client_ip` varchar(40) DEFAULT NULL,
  `log_user_agent` varchar(200) DEFAULT NULL,
  `log_ua_type` tinyint(3) unsigned DEFAULT '0',
  `log_ua_name` varchar(200) DEFAULT NULL,
  `db_time_update` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `sys_log_login2017` */

/*Table structure for table `sys_log_operate` */

DROP TABLE IF EXISTS `sys_log_operate`;

CREATE TABLE `sys_log_operate` (
  `log_id` varchar(40) NOT NULL,
  `op_id` varchar(40) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `c_id` varchar(40) DEFAULT NULL,
  `c_name` varchar(80) DEFAULT NULL,
  `log_act` tinyint(3) unsigned DEFAULT '0',
  `log_note` text,
  `log_client_ip` varchar(40) DEFAULT NULL,
  `log_user_agent` varchar(200) DEFAULT NULL,
  `a_id` varchar(40) DEFAULT NULL,
  `a_login_id` varchar(40) DEFAULT NULL,
  `log_url` varchar(200) DEFAULT NULL,
  `log_module` varchar(200) DEFAULT NULL,
  `log_content` text,
  `db_time_update` datetime DEFAULT NULL,
  `log_p_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `op_id` (`op_id`,`log_time`,`c_id`,`c_name`,`a_id`,`a_login_id`,`log_act`,`log_p_id`)
) ENGINE=MRG_MyISAM DEFAULT CHARSET=utf8 INSERT_METHOD=LAST UNION=(`sys_log_operate2017`);

/*Data for the table `sys_log_operate` */

/*Table structure for table `sys_log_operate2017` */

DROP TABLE IF EXISTS `sys_log_operate2017`;

CREATE TABLE `sys_log_operate2017` (
  `log_id` varchar(40) NOT NULL,
  `op_id` varchar(40) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `c_id` varchar(40) DEFAULT NULL,
  `c_name` varchar(80) DEFAULT NULL,
  `log_act` tinyint(3) unsigned DEFAULT '0',
  `log_note` text,
  `log_client_ip` varchar(40) DEFAULT NULL,
  `log_user_agent` varchar(200) DEFAULT NULL,
  `a_id` varchar(40) DEFAULT NULL,
  `a_login_id` varchar(40) DEFAULT NULL,
  `log_url` varchar(200) DEFAULT NULL,
  `log_module` varchar(200) DEFAULT NULL,
  `log_content` text,
  `db_time_update` datetime DEFAULT NULL,
  `log_p_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `op_id` (`op_id`,`log_time`,`c_id`,`c_name`,`a_id`,`a_login_id`,`log_act`,`log_p_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `sys_log_operate2017` */

/*Table structure for table `sys_proc` */

DROP TABLE IF EXISTS `sys_proc`;

CREATE TABLE `sys_proc` (
  `p_id` varchar(40) NOT NULL DEFAULT '',
  `p_name` varchar(80) DEFAULT NULL COMMENT '流程名称',
  `p_note` text COMMENT '流程描述',
  `db_time_create` datetime DEFAULT NULL COMMENT '创建时间',
  `db_time_update` datetime DEFAULT NULL COMMENT '数据更新时间',
  `p_status_run` tinyint(3) unsigned DEFAULT '0' COMMENT '流程启用状态',
  `p_class` tinytext COMMENT '类型',
  `p_url` text COMMENT 'url',
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_proc` */

insert  into `sys_proc`(`p_id`,`p_name`,`p_note`,`db_time_create`,`db_time_update`,`p_status_run`,`p_class`,`p_url`) values ('proc_back','后台管理','后台管理','2017-06-26 10:52:12','2017-06-26 10:52:12',1,'OA','proc_back/main/index.html'),('proc_contact','联系人管理','联系人管理','2017-06-27 09:58:52','2017-06-27 09:58:52',1,'OA','proc_contact/contact/index.html');

/*Table structure for table `sys_ra_link` */

DROP TABLE IF EXISTS `sys_ra_link`;

CREATE TABLE `sys_ra_link` (
  `a_id` varchar(40) DEFAULT NULL,
  `ra_id` varchar(40) NOT NULL DEFAULT '',
  `role_id` varchar(40) DEFAULT NULL COMMENT '角色',
  `ra_note` text COMMENT '备注',
  PRIMARY KEY (`ra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_ra_link` */

insert  into `sys_ra_link`(`a_id`,`ra_id`,`role_id`,`ra_note`) values ('D7D3F9ED5BE45E07055D2731A48537D3','7af49b3fc172a0554127c75177e5bb17','ADDAF09C938EE8EBFEF131A14E51B857','');

/*Table structure for table `sys_role` */

DROP TABLE IF EXISTS `sys_role`;

CREATE TABLE `sys_role` (
  `role_id` varchar(40) NOT NULL DEFAULT '',
  `role_name` varchar(80) DEFAULT NULL COMMENT '角色名称',
  `role_note` text COMMENT '角色描述',
  `db_time_update` datetime DEFAULT NULL COMMENT '数据更新时间',
  `db_time_create` datetime DEFAULT NULL COMMENT '数据创建时间',
  `role_default` tinyint(4) DEFAULT NULL COMMENT '默认角色',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `sys_role` */

insert  into `sys_role`(`role_id`,`role_name`,`role_note`,`db_time_update`,`db_time_create`,`role_default`) values ('ADDAF09C938EE8EBFEF131A14E51B857','一般用户','','2017-07-06 10:32:31','2017-07-04 15:43:11',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
