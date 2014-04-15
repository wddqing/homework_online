-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-04-15 17:06:27
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `homework_online`
--

-- --------------------------------------------------------

--
-- 表的结构 `qes_j_filling`
--

CREATE TABLE IF NOT EXISTS `qes_j_filling` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '题目编号',
  `question` varchar(500) NOT NULL COMMENT '题目内容',
  `trueAnswer` varchar(500) NOT NULL COMMENT '参考答案',
  `homeworkId` int(11) NOT NULL COMMENT '题目所属作业',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='作业填空题表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_j_grades`
--

CREATE TABLE IF NOT EXISTS `qes_j_grades` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '分数编号',
  `studentId` int(11) NOT NULL COMMENT '所属学生编号',
  `homeworkId` int(11) NOT NULL COMMENT '所属作业编号',
  `grade` int(11) NOT NULL COMMENT '所得分数',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生所得分数' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_j_homework`
--

CREATE TABLE IF NOT EXISTS `qes_j_homework` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '作业编号',
  `teacherId` int(11) NOT NULL COMMENT '所属老师编号',
  `classId` int(11) NOT NULL COMMENT '所属课程',
  `content` varchar(1000) DEFAULT NULL COMMENT '作业题题号，缓解多次连接数据，也可不用',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='作业表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_j_mulselect`
--

CREATE TABLE IF NOT EXISTS `qes_j_mulselect` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '题目编号',
  `question` varchar(500) NOT NULL COMMENT '题目内容',
  `answer` varchar(500) NOT NULL COMMENT '可选答案',
  `trueAnswer` varchar(100) NOT NULL COMMENT '正确答案',
  `homeworkId` int(11) NOT NULL COMMENT '所属作业编号',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='作业多选题表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_j_question`
--

CREATE TABLE IF NOT EXISTS `qes_j_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '问题编号',
  `question` varchar(2000) NOT NULL COMMENT '题目内容',
  `answer` varchar(5000) NOT NULL COMMENT '参考答案',
  `homeworkId` int(11) NOT NULL COMMENT '所属作业',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='作业问答题表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_j_singleselect`
--

CREATE TABLE IF NOT EXISTS `qes_j_singleselect` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '题目编号',
  `question` varchar(500) NOT NULL COMMENT '题目内容',
  `answer` varchar(500) NOT NULL COMMENT '可选答案',
  `trueAnswer` int(11) NOT NULL COMMENT '正确答案',
  `homeworkId` int(11) NOT NULL COMMENT '所属作业编号',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='作业单选题表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_o_lesson`
--

CREATE TABLE IF NOT EXISTS `qes_o_lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '下载资源编号',
  `teacherId` int(11) NOT NULL COMMENT '所属教师编号',
  `lessonId` int(11) NOT NULL COMMENT '所属课程编号',
  `location` varchar(400) NOT NULL COMMENT '课件存放位置',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提供课件下载' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_class`
--

CREATE TABLE IF NOT EXISTS `qes_u_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '班级编号',
  `classId` int(11) NOT NULL COMMENT '课程内班级编号',
  `lessonId` int(11) NOT NULL COMMENT '所属课程编号',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='班级信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_lesson`
--

CREATE TABLE IF NOT EXISTS `qes_u_lesson` (
  `lessonId` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程编号',
  `lessonName` varchar(200) NOT NULL COMMENT '课程名',
  `belongTo` int(11) NOT NULL COMMENT '课程是否属于该教师，1表示属于，0表示不属于',
  `teacherid` int(11) NOT NULL COMMENT '任课老师编号',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`lessonId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课程信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_main`
--

CREATE TABLE IF NOT EXISTS `qes_u_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `email` varchar(100) NOT NULL COMMENT '登录邮箱',
  `password` varchar(200) NOT NULL COMMENT '登录密码',
  `vaild` tinyint(4) NOT NULL COMMENT '表示用户是否通过邮箱验证 1表示验证通过 0表示未验证',
  `vaildCode` varchar(20) NOT NULL COMMENT '注册码验证',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userId` (`id`,`email`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户登录相关信息' AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `qes_u_main`
--

INSERT INTO `qes_u_main` (`id`, `email`, `password`, `vaild`, `vaildCode`, `updated_at`, `created_at`, `deleted_at`) VALUES
(15, 'wang@qq.com', '$2y$10$4vaLw5yN8dHEmSOGTi/0J.FLXlgDqLh.FaNRJ0jRCZXPt7dDQffE6', 0, '2701', '2014-03-27 04:12:47', '2014-03-27 04:12:47', '0000-00-00 00:00:00'),
(18, 'wer@qqq.com', '$2y$10$z2uaJb5dF/N9RNy/cRO7mePAT/L/KuHRBDCHHpRjhq6xh2hjWhqB6', 0, 'cd51', '2014-03-28 02:27:10', '2014-03-28 02:27:10', '0000-00-00 00:00:00'),
(19, 'wer@qqqd.com', '$2y$10$S/HjPqBpbktBr3vQLXQjouk9ePmg0wzhuWd.AK4fkMdYJcqF1NIgu', 0, '4769', '2014-03-28 02:27:52', '2014-03-28 02:27:52', '0000-00-00 00:00:00'),
(20, 'wear@qqqd.com', '$2y$10$N5lCUL1FYopUthv2hzQR9.qpXy8/oKyXUbIfMS4KnORDsznIaOcgW', 0, '3a67', '2014-03-28 02:30:00', '2014-03-28 02:30:00', '0000-00-00 00:00:00'),
(21, 'we12ar@qqqd.com', '$2y$10$ZWTVj9m3e.vUAP1pZZxwduGA6jvEK8nSFXTKuxRNw2c.DJ6G9nmty', 0, '46fa', '2014-03-28 02:33:38', '2014-03-28 02:33:38', '0000-00-00 00:00:00'),
(25, 'wsdlkla@gg.com', '$2y$10$NqPSOpSUTOkQrcgAK5kdVubk3FgcoTzcbNWfTjY0f/A5zCxuOLS56', 0, '674f', '2014-03-28 02:41:15', '2014-03-28 02:41:15', '0000-00-00 00:00:00'),
(27, 'asdfsak@q.com', '$2y$10$10T09nekg.O4t3qqUL1/k.4qKxMXaty0rER6zaCUhtHtQSjNkmh/m', 0, 'b18e', '2014-03-28 02:47:58', '2014-03-28 02:47:58', '0000-00-00 00:00:00'),
(28, 'asdfsawk@q.com', '$2y$10$I/usdwhC761aK7cW02vnneptbeeJLeq9Ol.sTS4rEe0q02FN1QZT2', 0, 'd010', '2014-03-28 02:50:45', '2014-03-28 02:50:45', '0000-00-00 00:00:00'),
(29, 'asdfsawewk@q.com', '$2y$10$A24Ujnta36p6rJ8qePXPGe583T/u/guLEh20.IVtbcRUn8H9a/lji', 0, 'aa0b', '2014-03-28 02:57:57', '2014-03-28 02:57:57', '0000-00-00 00:00:00'),
(30, 'wang@q.com', '$2y$10$qVYz3gUyvYDLYZfrtXKUgukbuUf.IAbLLP8t0m.V33Gi7bdEYg2uS', 1, '19f1', '2014-04-06 10:03:03', '2014-04-06 01:59:17', '0000-00-00 00:00:00'),
(31, 'wddqing@gmail.com', '$2y$10$FTbvcs8s2FJ2h3CcswRLo.kdoZmZG7/HOF7iOWtGAC6o8BFkZE9D2', 1, 'ba16', '2014-04-07 12:43:05', '2014-04-07 04:41:03', '0000-00-00 00:00:00'),
(32, 'wddqing@qq.com', '$2y$10$C8U8nmc04fFSoqozf71hOuhR/MRuX3pFBzzIXYp9Z2Jmmc/DmAUY2', 0, '8b7b', '2014-04-07 04:44:01', '2014-04-07 04:44:01', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_manager`
--

CREATE TABLE IF NOT EXISTS `qes_u_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `loginName` varchar(100) NOT NULL COMMENT '登录账号',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `type` tinyint(4) NOT NULL COMMENT '管理员类型，1为普通管理员，可以执行除了更改管理员之外的一切操作，2为超级管理员，可以执行所有操作',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员用户表' AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `qes_u_manager`
--

INSERT INTO `qes_u_manager` (`id`, `loginName`, `password`, `type`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, 'super@hm.com', '$2y$10$1Kj1/4ifaVlYtCSehtkRFeQQwOkaLT9podJUoZ1G2a9e12P/DuKbq', 2, '2014-04-09 05:38:04', '2014-04-09 05:38:04', NULL),
(15, 'wang@qq.com', '$2y$10$4vaLw5yN8dHEmSOGTi/0J.FLXlgDqLh.FaNRJ0jRCZXPt7dDQffE6', 1, '2014-04-09 06:13:48', '2014-04-09 06:13:48', NULL),
(25, 'wsdlkla@gg.com', '$2y$10$NqPSOpSUTOkQrcgAK5kdVubk3FgcoTzcbNWfTjY0f/A5zCxuOLS56', 1, '2014-04-09 06:14:10', '2014-04-09 06:14:10', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_profiles`
--

CREATE TABLE IF NOT EXISTS `qes_u_profiles` (
  `id` int(11) NOT NULL COMMENT '用户编码，跟qes_u_main的userId对应',
  `nickName` varchar(45) NOT NULL COMMENT '用户的昵称',
  `jobId` varchar(50) NOT NULL COMMENT '学生编号，教师编号，允许匿名用户为空',
  `trueName` varchar(50) NOT NULL COMMENT '真实姓名',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户的个人信息';

--
-- 转存表中的数据 `qes_u_profiles`
--

INSERT INTO `qes_u_profiles` (`id`, `nickName`, `jobId`, `trueName`, `updated_at`, `created_at`, `deleted_at`) VALUES
(30, '王东青', '2010051751', '王东青', '2014-04-07 00:36:49', '2014-04-07 00:36:49', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_question`
--

CREATE TABLE IF NOT EXISTS `qes_u_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '问题编号',
  `question` varchar(200) NOT NULL COMMENT '问题内容',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='安全问题' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `qes_u_question`
--

INSERT INTO `qes_u_question` (`id`, `question`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1, '您母亲的姓名是？', '2014-02-28 16:00:00', '2014-02-28 16:00:00', NULL),
(2, '您父亲的姓名是？', NULL, NULL, NULL),
(3, '您配偶的姓名是？', NULL, NULL, NULL),
(4, '您的出生地是？', NULL, NULL, NULL),
(5, '您高中班主任的名字是？', NULL, NULL, NULL),
(6, '您初中班主任的名字是？', NULL, NULL, NULL),
(7, '您小学班主任的名字是？', NULL, NULL, NULL),
(8, '您的小学校名是？', NULL, NULL, NULL),
(9, '您的学号（或工号）是？', NULL, NULL, NULL),
(10, '您父亲的生日是？', NULL, NULL, NULL),
(11, '您母亲的生日是？', NULL, NULL, NULL),
(12, '您配偶的生日是？', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_relation`
--

CREATE TABLE IF NOT EXISTS `qes_u_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `studentId` int(11) NOT NULL COMMENT '学生编号',
  `classId` int(11) NOT NULL COMMENT '所属班级编号',
  `vaild` int(11) NOT NULL COMMENT '当前课程信息是否有效，1为有效，0为无效。修课中为有效，修完课为无效',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='班级与学生的关系' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_security`
--

CREATE TABLE IF NOT EXISTS `qes_u_security` (
  `userId` int(11) NOT NULL COMMENT '用户编号',
  `questionId` int(11) NOT NULL COMMENT '安全问题编号',
  `answer` varchar(200) NOT NULL COMMENT '安全问题答案',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账号安全相关';

--
-- 转存表中的数据 `qes_u_security`
--

INSERT INTO `qes_u_security` (`userId`, `questionId`, `answer`, `updated_at`, `created_at`, `deleted_at`) VALUES
(14, 12, '1124', '2014-03-29 22:56:51', '2014-03-29 22:56:51', NULL),
(15, 1, 'nimei', NULL, NULL, NULL),
(30, 1, 'yin', '2014-04-06 02:03:19', '2014-04-06 02:03:19', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `qes_u_type`
--

CREATE TABLE IF NOT EXISTS `qes_u_type` (
  `id` int(11) NOT NULL COMMENT '用户的编号，跟qes_u_main的userIdea对应',
  `type` int(11) NOT NULL COMMENT '表示用户类型 注册用户为0 学生为1 老师为2',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户的类型，匿名用户，老师，或者学生';

--
-- 转存表中的数据 `qes_u_type`
--

INSERT INTO `qes_u_type` (`id`, `type`, `updated_at`, `created_at`, `deleted_at`) VALUES
(21, 2, '2014-04-12 23:35:04', '2014-04-12 23:35:04', NULL),
(25, 0, '2014-04-12 23:29:33', '2014-04-12 23:29:28', NULL),
(31, 0, '2014-04-07 04:41:03', '2014-04-07 04:41:03', NULL),
(32, 0, '2014-04-07 04:44:01', '2014-04-07 04:44:01', NULL);

--
-- 限制导出的表
--

--
-- 限制表 `qes_u_profiles`
--
ALTER TABLE `qes_u_profiles`
  ADD CONSTRAINT `qes_u_profiles_ibfk_1` FOREIGN KEY (`id`) REFERENCES `qes_u_main` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `qes_u_type`
--
ALTER TABLE `qes_u_type`
  ADD CONSTRAINT `qes_u_type_ibfk_1` FOREIGN KEY (`id`) REFERENCES `qes_u_main` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
