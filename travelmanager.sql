-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 10 月 08 日 19:55
-- 服务器版本: 5.5.32
-- PHP 版本: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `travelmanager`
--

-- --------------------------------------------------------

--
-- 表的结构 `tm_access`
--

CREATE TABLE IF NOT EXISTS `tm_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tm_access`
--

INSERT INTO `tm_access` (`role_id`, `node_id`, `level`, `module`) VALUES
(16, 27, 3, NULL),
(16, 28, 3, NULL),
(5, 8, 3, NULL),
(1, 10, 2, NULL),
(5, 7, 3, NULL),
(17, 30, 3, NULL),
(17, 31, 3, NULL),
(17, 18, 2, NULL),
(5, 4, 2, NULL),
(5, 1, 1, NULL),
(1, 8, 3, NULL),
(1, 7, 3, NULL),
(1, 4, 2, NULL),
(1, 1, 1, NULL),
(16, 17, 2, NULL),
(16, 32, 3, NULL),
(16, 19, 2, NULL),
(16, 15, 1, NULL),
(18, 35, 3, NULL),
(18, 34, 2, NULL),
(18, 15, 1, NULL),
(16, 26, 3, NULL),
(17, 29, 3, NULL),
(17, 32, 3, NULL),
(17, 19, 2, NULL),
(17, 15, 1, NULL),
(18, 36, 3, NULL),
(18, 37, 3, NULL),
(18, 38, 3, NULL),
(18, 19, 2, NULL),
(18, 32, 3, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tm_blackboard`
--

CREATE TABLE IF NOT EXISTS `tm_blackboard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '',
  `content` varchar(255) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `tm_guide`
--

CREATE TABLE IF NOT EXISTS `tm_guide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(32) DEFAULT NULL,
  `phone` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tm_guide`
--

INSERT INTO `tm_guide` (`id`, `name`, `phone`) VALUES
(1, 'aa', '11111'),
(2, 'bb', '111111');

-- --------------------------------------------------------

--
-- 表的结构 `tm_node`
--

CREATE TABLE IF NOT EXISTS `tm_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- 转存表中的数据 `tm_node`
--

INSERT INTO `tm_node` (`id`, `name`, `title`, `status`, `remark`, `sort`, `pid`, `level`) VALUES
(23, 'addUser', '添加用户', 1, NULL, 1, 16, 3),
(15, 'Admin', '后台管理', 1, NULL, 1, 0, 1),
(16, 'Rbac', '管理员操作', 1, NULL, 1, 15, 2),
(17, 'JiDiao', '计调操作', 1, NULL, 1, 15, 2),
(18, 'GuideDepartment', '导游部', 1, NULL, 1, 15, 2),
(22, 'node', '节点列表', 1, NULL, 1, 16, 3),
(21, 'role', '角色列表', 1, NULL, 1, 16, 3),
(20, 'index', '用户列表', 1, NULL, 1, 16, 3),
(19, 'PersonalCenter', '个人中心', 1, NULL, 1, 15, 2),
(24, 'addRole', '添加角色', 1, NULL, 1, 16, 3),
(25, 'addNode', '添加节点', 1, NULL, 1, 16, 3),
(46, 'queryGroup', '所有团队信息', 1, NULL, 1, 17, 3),
(45, 'manageGroup', '我的团队信息', 1, NULL, 1, 17, 3),
(44, 'addGroup', '团队信息录入', 1, NULL, 1, 17, 3),
(29, 'addGuide', '导游录入', 1, NULL, 1, 18, 3),
(30, 'manageGuide', '导游管理', 1, NULL, 1, 18, 3),
(31, 'dispatchGuide', '导游部排团', 1, NULL, 1, 18, 3),
(32, 'resetPwd', '密码修改', 1, NULL, 1, 19, 3),
(34, 'GeneralManager', '总经理操作', 1, NULL, 1, 15, 2),
(41, 'manageGroups', '团队信息管理', 1, NULL, 1, 34, 3),
(42, 'userList', '用户列表', 1, NULL, 1, 34, 3),
(40, 'checkGroupInfo', '团队信息审核', 1, NULL, 1, 34, 3),
(39, 'selfInfo', '个人资料', 1, NULL, 1, 19, 3),
(43, 'addUser', '添加用户', 1, NULL, 1, 34, 3);

-- --------------------------------------------------------

--
-- 表的结构 `tm_office`
--

CREATE TABLE IF NOT EXISTS `tm_office` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `phone` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tm_office`
--

INSERT INTO `tm_office` (`id`, `name`, `phone`) VALUES
(1, '九江办事处', '18628381377'),
(2, '成都办事处', '18628381377');

-- --------------------------------------------------------

--
-- 表的结构 `tm_role`
--

CREATE TABLE IF NOT EXISTS `tm_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `tm_role`
--

INSERT INTO `tm_role` (`id`, `name`, `pid`, `status`, `remark`) VALUES
(18, '总经理', NULL, 1, '总经理'),
(17, '导游部经理', NULL, 1, '导游部经理'),
(16, '计调', NULL, 1, '计调'),
(15, '导游', NULL, 1, '导游');

-- --------------------------------------------------------

--
-- 表的结构 `tm_role_user`
--

CREATE TABLE IF NOT EXISTS `tm_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tm_role_user`
--

INSERT INTO `tm_role_user` (`role_id`, `user_id`) VALUES
(15, '29'),
(15, '28'),
(15, '27'),
(15, '26'),
(15, '25'),
(15, '24'),
(15, '30'),
(15, '31'),
(15, '32'),
(15, '33'),
(15, '34'),
(15, '35'),
(16, '36'),
(17, '37'),
(16, '38'),
(16, '39'),
(15, '40'),
(15, '41'),
(15, '42'),
(15, '43'),
(15, '44');

-- --------------------------------------------------------

--
-- 表的结构 `tm_tourgroup`
--

CREATE TABLE IF NOT EXISTS `tm_tourgroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `members` varchar(32) DEFAULT NULL,
  `shop` int(10) unsigned DEFAULT '0',
  `senddate` varchar(32) DEFAULT NULL,
  `recvdate` varchar(32) DEFAULT NULL,
  `routetitle` varchar(32) DEFAULT NULL,
  `routedays` int(10) unsigned DEFAULT '0',
  `route` varchar(255) DEFAULT NULL,
  `offices` varchar(32) DEFAULT NULL,
  `type` varchar(32) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `jidiao` varchar(32) DEFAULT NULL,
  `guides` varchar(255) DEFAULT NULL,
  `isshop` tinyint(4) NOT NULL DEFAULT '0',
  `audittype` tinyint(4) NOT NULL,
  `time` date NOT NULL,
  `log` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `tm_tourgroup`
--

INSERT INTO `tm_tourgroup` (`id`, `members`, `shop`, `senddate`, `recvdate`, `routetitle`, `routedays`, `route`, `offices`, `type`, `remark`, `jidiao`, `guides`, `isshop`, `audittype`, `time`, `log`) VALUES
(18, '33', 3, '06-02-2012', '14-02-2012', '北京三日游', 0, '北京-天安门-长城', '成都办事处', '团队', '嗷嗷', 'admin', '导游004 ', 1, 2, '0000-00-00', '13-10-04 14:43:14录入团队信息<br>13-10-04 14:43:21 审核通过<br>'),
(19, '22', 3, '12-02-2012', '12-02-2012', '九寨沟三日游', 3, '成都-上海-九寨沟', '成都办事处', '团队', '哎哎', 'admin', '导游004', 1, 2, '0000-00-00', '13-10-04 15:16:56录入团队信息<br>13-10-04 15:18:24 审核通过<br>'),
(20, '22', 3, '12-02-2012', '12-02-2012', '九寨沟', 3, '北京-成都-九寨沟', '九江办事处', '团队', '', 'admin', '导游004 ', 1, 2, '0000-00-00', '13-10-04 15:17:24录入团队信息<br>13-10-04 15:18:27 审核通过<br>'),
(21, '22', 0, '12-02-2012', '12-02-2012', '九寨沟三日游', 3, '九寨沟三日游噢噢噢噢', '九江办事处', '散客', '', 'admin', '导游002 ', 0, 2, '0000-00-00', '13-10-04 15:17:52录入团队信息<br>13-10-04 15:18:30 审核通过<br>'),
(22, '3', 3, '12-02-2012', '12-02-2012', '北京三日游', 3, '北京三日游北京三日游', '成都办事处', '散客', '', 'admin', '导游003 ', 1, 2, '0000-00-00', '13-10-04 15:18:16录入团队信息<br>13-10-04 15:18:33 审核通过<br>');

-- --------------------------------------------------------

--
-- 表的结构 `tm_user`
--

CREATE TABLE IF NOT EXISTS `tm_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `loginip` char(20) NOT NULL DEFAULT '',
  `lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phone` varchar(32) DEFAULT NULL,
  `nickname` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- 转存表中的数据 `tm_user`
--

INSERT INTO `tm_user` (`id`, `username`, `password`, `logintime`, `loginip`, `lock`, `phone`, `nickname`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1381231587, '127.0.0.1', 0, '18628381377', 'yeshu'),
(41, 'guide1380694551', '2684112dd3bae4666c43def3972e9b8a', 1380694551, '182.151.90.52', 0, '18628381377', '导游002'),
(42, 'guide1380694557', 'a7b9aa64393b7ac3fc26069191c8e49b', 1380694557, '182.151.90.52', 0, '18628381377', '导游003'),
(43, 'guide1380694567', '6c407513f570455aff8f10d2b8c6630b', 1380694567, '182.151.90.52', 0, '18628381378', '导游004'),
(44, 'guide1380694576', '726ff806e78ca30890973d5fcbac2022', 1380694576, '182.151.90.52', 0, '18628381377', '导游005'),
(40, 'guide1380694544', '5f482473ddef8fef31fe6ea2d78e2e89', 1380694544, '182.151.90.52', 0, '18628381377', '导游001'),
(39, 'jidiao001', '96e79218965eb72c92a549dd5a330112', 1380694502, '182.151.90.52', 0, NULL, '计调一号');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
