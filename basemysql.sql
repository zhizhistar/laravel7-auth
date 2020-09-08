-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-09-08 19:18:40
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `zhuangshi`
--

-- --------------------------------------------------------

--
-- 表的结构 `sw_group`
--

CREATE TABLE `sw_group` (
  `gid` int(11) NOT NULL COMMENT '用户组ID',
  `status` tinyint(4) NOT NULL COMMENT '权限分组状态',
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户组名称',
  `rights` text COLLATE utf8_unicode_ci NOT NULL COMMENT '用户组权限',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `sw_group`
--

INSERT INTO `sw_group` (`gid`, `status`, `title`, `rights`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 0, '超级管理员', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"29\",\"31\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"18\",\"15\",\"16\",\"17\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"30\"]', NULL, 1599484948, NULL),
(2, 0, '测试角色', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"29\"]', 1599221192, 1599563774, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sw_manager`
--

CREATE TABLE `sw_manager` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `name` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT '登录名称',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '登录密码',
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '登陆邮箱',
  `gid` int(11) NOT NULL COMMENT '用户组',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `sw_manager`
--

INSERT INTO `sw_manager` (`id`, `status`, `name`, `password`, `email`, `gid`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 0, 'admin', '$2y$10$CuoFF6L1JfWGju3aZW7FCuRquZRGS8AfCxyhHCBs2E7X6U6gnsP9q', 'star@cqzhizhi.com', 1, 1599051771, 1599051771, NULL),
(2, 0, '半壶水', '$2y$10$l1Fy2JKMXUaOvcov97jWvul14PkOATL.NgKJjsrwP8pMPgOEddOXi', '1037067594@qq.com', 1, 1599463286, 1599464294, NULL),
(3, 0, '李星星', '$2y$10$e/r4dyY22laBsb2hmRFyEeHency4sqMRvG1cV0/uwp.0sO/slER4W', 'admin@cloudreve.org', 2, 1599463326, 1599464274, NULL),
(4, 0, '孤鸿寡鹄', '$2y$10$fllXdFt4COw0ClAno4m4yOiHQJ1D8GSMM1yA1UbkF.NLO5GVsQ21u', 'enterprise-housekeeper@cqzhizhi.com', 2, 1599464785, 1599464928, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sw_menu`
--

CREATE TABLE `sw_menu` (
  `mid` int(11) NOT NULL COMMENT '菜单ID',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '菜单状态',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级菜单',
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '菜单标题',
  `controller` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '菜单控制器',
  `action` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '菜单方法',
  `icon` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '图标',
  `target` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '打开方式',
  `ishidden` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否隐藏菜单',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `sw_menu`
--

INSERT INTO `sw_menu` (`mid`, `status`, `pid`, `title`, `controller`, `action`, `icon`, `target`, `ishidden`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 0, 0, '后台登陆', 'Account', 'login', '', '', 1, NULL, NULL, NULL),
(2, 0, 0, '员工注册', 'Account', 'register', '', '', 1, NULL, NULL, NULL),
(3, 0, 0, '常规管理', '', '', '', '', 0, NULL, NULL, NULL),
(4, 0, 3, '后台首页', 'Home', 'index', 'fa fa-home', '', 1, NULL, NULL, NULL),
(5, 0, 3, '获取管理菜单', 'Home', 'init_menu', '', '', 1, NULL, NULL, NULL),
(6, 0, 3, '后台欢迎页', 'Home', 'welcome', '', '', 0, NULL, NULL, NULL),
(7, 0, 0, '账号管理', '', '', '', '', 0, NULL, NULL, NULL),
(8, 0, 7, '权限菜单', 'Menu', 'index', '', '', 0, NULL, NULL, NULL),
(9, 0, 8, '获取所有权限菜单', 'Menu', 'all_menus', '', '', 1, NULL, NULL, NULL),
(10, 0, 8, '新增权限菜单', 'Menu', 'add', '', '_self', 1, NULL, NULL, NULL),
(11, 0, 8, '保存权限菜单', 'Menu', 'save', '', '_self', 1, NULL, 1599156771, NULL),
(12, 0, 8, '修改权限菜单', 'Menu', 'edit', '', '_self', 1, 1599134140, 1599156764, NULL),
(13, 0, 8, '启用权限菜单', 'Menu', 'enable', '', '_self', 1, 1599146608, 1599156758, NULL),
(14, 0, 8, '禁用权限菜单', 'Menu', 'disable', '', '_self', 1, 1599151793, 1599156750, NULL),
(15, 0, 7, '权限分组', 'Group', 'index', '', '_self', 0, 1599156990, 1599156990, NULL),
(16, 0, 15, '获取所有权限组', 'Group', 'all_group', '', '_self', 1, 1599157320, 1599459643, NULL),
(17, 0, 15, '新增权限组', 'Group', 'add', '', '_self', 1, 1599157873, 1599157873, NULL),
(18, 0, 8, '权限菜单树', 'Menu', 'menus_tree', '', '_self', 1, 1599163067, 1599163067, NULL),
(19, 0, 15, '保存权限组', 'Group', 'save', '', '_self', 1, 1599220451, 1599459628, NULL),
(20, 0, 15, '编辑权限组', 'Group', 'edit', '', '_self', 1, 1599221599, 1599221599, NULL),
(21, 0, 15, '禁用权限组', 'Group', 'disable', '', '_self', 1, 1599459075, 1599459615, NULL),
(22, 0, 15, '启用权限组', 'Group', 'enable', '', '_self', 1, 1599459606, 1599459606, NULL),
(23, 0, 7, '管理员管理', 'Manager', 'index', '', '_self', 0, 1599461004, 1599461754, NULL),
(24, 0, 23, '新增管理员', 'Manager', 'add', '', '_self', 1, 1599462424, 1599462424, NULL),
(25, 0, 23, '保存管理员', 'Manager', 'save', '', '_self', 1, 1599463266, 1599463266, NULL),
(26, 0, 23, '编辑管理员', 'Manager', 'edit', '', '_self', 1, 1599464184, 1599464184, NULL),
(27, 0, 23, '禁用管理员', 'Manager', 'disable', '', '_self', 1, 1599464822, 1599464822, NULL),
(28, 0, 23, '启用管理员', 'Manager', 'enable', '', '_self', 1, 1599464837, 1599464837, NULL),
(29, 0, 3, '站点设置', 'Setting', 'index', '', '_self', 0, 1599466049, 1599466049, NULL),
(30, 0, 0, '退出登录', 'Account', 'logout', '', '_self', 1, 1599473446, 1599473446, NULL),
(31, 0, 29, '保存站点设置', 'Setting', 'save', '', '_self', 1, 1599484926, 1599484926, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `sw_setting`
--

CREATE TABLE `sw_setting` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'KEY',
  `value` text COLLATE utf8_unicode_ci COMMENT '对应json值',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `sw_setting`
--

INSERT INTO `sw_setting` (`id`, `name`, `value`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 'site_info', '{\"title\":\"Laravel7\\u516c\\u5171\\u6743\\u9650\\u7ba1\\u7406\\u7cfb\\u7edf\",\"des\":\"Laravel7\\u516c\\u5171\\u6743\\u9650\\u7ba1\\u7406\\u7cfb\\u7edf\",\"keywords\":\"laravel7,\\u6743\\u9650\\u7ba1\\u7406\\u7cfb\\u7edf,PHP\\u6846\\u67b6\",\"url\":\"www.zhuangshi.com\",\"open_register\":0,\"close_register_des\":null,\"open_status\":0,\"close_des\":null,\"update_time\":1599487253}', NULL, NULL, NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `sw_group`
--
ALTER TABLE `sw_group`
  ADD PRIMARY KEY (`gid`);

--
-- 表的索引 `sw_manager`
--
ALTER TABLE `sw_manager`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `email` (`email`);

--
-- 表的索引 `sw_menu`
--
ALTER TABLE `sw_menu`
  ADD PRIMARY KEY (`mid`);

--
-- 表的索引 `sw_setting`
--
ALTER TABLE `sw_setting`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `sw_group`
--
ALTER TABLE `sw_group`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户组ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `sw_manager`
--
ALTER TABLE `sw_manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `sw_menu`
--
ALTER TABLE `sw_menu`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单ID', AUTO_INCREMENT=32;

--
-- 使用表AUTO_INCREMENT `sw_setting`
--
ALTER TABLE `sw_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
