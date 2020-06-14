-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2020 �?02 �?21 �?00:46
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `test_stu`
--

-- --------------------------------------------------------

--
-- 表的结构 `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `student_id` varchar(20) NOT NULL,
  `Compulsory_bool` int(11) NOT NULL,
  `agree` int(11) NOT NULL,
  `file_url` text,
  `reason_for_application` varchar(100) DEFAULT NULL,
  `time` varchar(12) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `student_name` varchar(15) NOT NULL,
  `project_name` varchar(20) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `function` int(11) NOT NULL,
  `tc_data` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `application`
--

INSERT INTO `application` (`student_id`, `Compulsory_bool`, `agree`, `file_url`, `reason_for_application`, `time`, `id`, `project_id`, `student_name`, `project_name`, `class_name`, `function`, `tc_data`) VALUES
('201861011903023', 1, 2, 'public\\uploads/20200217\\da3ad9f842f441d65da8bc03c08ba153.png', '????', '1581911675', 6, 1, 'test', '遵规守纪', '移动1802', 10, NULL),
('201861011903023', 1, 1, '', '12312312312', '1581905079', 7, 2, 'test', 'test', '移动1802', 10, NULL),
('201861011903023', 1, 0, '', '12323', '1581910936', 8, 1, 'test', '遵规守纪', '移动1802', 10, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_main_name` varchar(30) NOT NULL,
  `college_id` int(11) NOT NULL,
  `class_name` varchar(10) NOT NULL,
  `college_name` varchar(50) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `class`
--

INSERT INTO `class` (`class_id`, `class_main_name`, `college_id`, `class_name`, `college_name`) VALUES
(1, '罗梦婷', 2, '移动1802', '信息工程学院'),
(2, '罗梦婷', 2, '移动1803', '信息工程学院'),
(4, 'hell', 2, 'test', '信息工程学院'),
(3, '罗梦婷', 2, '移动1803', '信息工程学院'),
(5, 'supr', 2, '移动1903', '信息工程学院'),
(6, '罗梦婷', 2, '移动1802', '信息工程学院');

-- --------------------------------------------------------

--
-- 表的结构 `college`
--

CREATE TABLE IF NOT EXISTS `college` (
  `college_name` varchar(20) NOT NULL,
  `college_id` int(11) NOT NULL AUTO_INCREMENT,
  `college_main_name` varchar(20) NOT NULL,
  PRIMARY KEY (`college_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `college`
--

INSERT INTO `college` (`college_name`, `college_id`, `college_main_name`) VALUES
('信息工程学院', 12, '石向飞');

-- --------------------------------------------------------

--
-- 表的结构 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `fraction` int(11) NOT NULL,
  `obligatory` int(11) NOT NULL,
  `proiject_class` varchar(20) NOT NULL,
  `project` varchar(30) NOT NULL,
  `introduction` varchar(100) NOT NULL,
  `semester` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `project`
--

INSERT INTO `project` (`project_id`, `fraction`, `obligatory`, `proiject_class`, `project`, `introduction`, `semester`) VALUES
(1, 10, 1, '职业道德规范', '遵规守纪', '遵章守纪，无违规违纪现象10分；受到“警告”、“ 严重警告”处分5分、受到“记过”及以上处分0分。（月考评）', '2019上'),
(2, 10, 1, '艺术人文_test', 'test', '这是一个测试', '2019上'),
(3, 10, 1, '理想信念 ', '信息工程学院', '', NULL),
(4, 12, 0, '身心健康 ', '移动1803', '类了111', '2019上'),
(5, 10, 1, 'helll', '测试项目', '红红火火恍恍惚惚', '2019下'),
(6, 10, 1, 'helll', '测试项目', '红红火火恍恍惚惚', '2019下'),
(7, 10, 1, 'helll', '测试项目', '红红火火恍恍惚惚', '2019下'),
(8, 10, 1, 'helll', '测试项目', '红红火火恍恍惚惚', '2019下'),
(9, 10, 1, 'helll', '测试项目', '红红火火恍恍惚惚', '2019下'),
(10, 10, 1, 'helll', '测试项目', '红红火火恍恍惚惚', '2019下');

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `Role_id` int(11) NOT NULL,
  `Role_name` varchar(20) NOT NULL,
  PRIMARY KEY (`Role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`Role_id`, `Role_name`) VALUES
(1, '蜜罐'),
(2, '班级辅导员'),
(3, '二级学院'),
(4, '学生工作处'),
(5, '超级管理员');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_name` varchar(10) NOT NULL,
  `student_id` varchar(30) NOT NULL,
  `student_pass` varchar(50) NOT NULL,
  `compulsory_score` int(11) NOT NULL,
  `Elective_score` int(11) NOT NULL,
  `Professional_grade` varchar(20) NOT NULL,
  `student_bool` int(11) NOT NULL DEFAULT '1',
  `class_name` varchar(30) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`student_name`, `student_id`, `student_pass`, `compulsory_score`, `Elective_score`, `Professional_grade`, `student_bool`, `class_name`) VALUES
('test', '201861011903023', '770229684c9efa7a8b390019eda82125', 20, 30, '移动18', 1, '移动1802'),
('test', '201861011903024', '770229684c9efa7a8b390019eda82125', 20, 40, '移动19', 1, '移动1902'),
('admin', '201861011903025', '770229684c9efa7a8b390019eda82125', 20, 33, '移动18', 1, '移动1802'),
('xxx', '1234567890', '25f9e794323b453885f5181f1b624d0b', 0, 0, '移动18', 1, '移动1802');

-- --------------------------------------------------------

--
-- 表的结构 `summary`
--

CREATE TABLE IF NOT EXISTS `summary` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `compulsory_score` int(11) NOT NULL,
  `Elective_score` int(11) NOT NULL,
  `score` float NOT NULL,
  `class_name` varchar(20) NOT NULL,
  `Semester` varchar(20) NOT NULL,
  `student_name` varchar(20) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `summary`
--

INSERT INTO `summary` (`id`, `compulsory_score`, `Elective_score`, `score`, `class_name`, `Semester`, `student_name`, `student_id`) VALUES
(1, 12, 12, 13, '移动1802', '2019上', 'test', '201861011903023'),
(2, 20, 30, 96.3636, '移动1802', '2019上', 'test', '201861011903023'),
(3, 20, 33, 100, '移动1802', '2019上', 'admin', '201861011903025'),
(4, 20, 40, 100, '移动1902', '2019上', 'test', '201861011903024');

-- --------------------------------------------------------

--
-- 表的结构 `time`
--

CREATE TABLE IF NOT EXISTS `time` (
  `Current_semester` varchar(20) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `time`
--

INSERT INTO `time` (`Current_semester`, `id`) VALUES
('2019上', 1),
('2019下', 5),
('2019上', 6);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_login` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(15) NOT NULL,
  `role_id` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `roli_name` varchar(30) NOT NULL COMMENT 'role_name 写错了',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_login`, `user_id`, `user_name`, `role_id`, `password`, `roli_name`) VALUES
('', 1, 'super', 5, 'b5032a96c72c2998848b5f1f0044b344', '超级管理员'),
('', 3, 'super2', 1, 'e10adc3949ba59abbe56e057f20f883e', '蜜罐'),
('', 4, 'super3', 3, 'e10adc3949ba59abbe56e057f20f883e', '二级学院'),
('', 5, 'test_admin', 2, 'e10adc3949ba59abbe56e057f20f883e', '班级辅导员');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
