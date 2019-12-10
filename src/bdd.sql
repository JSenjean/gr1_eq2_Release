-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 30 Novembre 2019 à 18:02
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `cdp`
--

-- Create DB
CREATE DATABASE IF NOT EXISTS `cdp` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `cdp`;

-- --------------------------------------------------------

--
-- Structure de la table `doc_section`
--

CREATE TABLE IF NOT EXISTS `doc_section` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `category` varchar(50) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `last_update` date NOT NULL,
  `state` enum('done','todo','deprecated') collate utf8_unicode_ci NOT NULL,
  `files` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL auto_increment,
  `id_category` int(11) NOT NULL,
  `question` text collate utf8_unicode_ci NOT NULL,
  `answer` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `faq_category`
--

CREATE TABLE IF NOT EXISTS `faq_category` (
  `id` int(11) NOT NULL auto_increment,
  `category` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `inside_project_role`
--

CREATE TABLE IF NOT EXISTS `inside_project_role` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `inside_sprint_task_us`
--

CREATE TABLE IF NOT EXISTS `inside_sprint_task_us` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL,
  `inside_sprint_us_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `task_id` (`task_id`,`inside_sprint_us_id`),
  KEY `inside_sprint_us_id` (`inside_sprint_us_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;


-- --------------------------------------------------------

--
-- Structure de la table `inside_sprint_us`
--

CREATE TABLE IF NOT EXISTS `inside_sprint_us` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sprint_id` int(10) unsigned NOT NULL,
  `user_story_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `sprint_id` (`sprint_id`,`user_story_id`),
  KEY `user_story_id` (`user_story_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `visibility` tinyint(1) NOT NULL default '1',
  `release_git` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `project_commit`
--

CREATE TABLE IF NOT EXISTS `project_commit` (
  `id` int(16) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL,
  `sha` varchar(40) NOT NULL,
  `committerName` text NOT NULL,
  `commitMessage` text NOT NULL,
  `commitUrl` text NOT NULL,
  `commitDate` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `project_invitation`
--

CREATE TABLE IF NOT EXISTS `project_invitation` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `project_id` int(11) unsigned NOT NULL,
  `request` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`,`project_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `project_member`
--

CREATE TABLE IF NOT EXISTS `project_member` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `role` enum('member','master') collate utf8_unicode_ci NOT NULL,
  `project_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `sprint`
--

CREATE TABLE IF NOT EXISTS `sprint` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sprint_id` int(10) unsigned NOT NULL,
  `member_id` int(10) unsigned default NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `predecessor` text collate utf8_unicode_ci,
  `description` text collate utf8_unicode_ci,
  `dod` text collate utf8_unicode_ci,
  `state` enum('todo','onGoing','done') collate utf8_unicode_ci NOT NULL default 'todo',
  `time` enum('0.5','1','1.5','2','2.5','3','3.5','4','4.5','5') collate utf8_unicode_ci NOT NULL default '0.5',
  `maquette` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `sprint_id` (`sprint_id`,`member_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `last_run` date NOT NULL,
  `state` enum('passed','deprecated','failed','never_run') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(50) collate utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(75) collate utf8_unicode_ci NOT NULL,
  `password` varchar(255) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `role` enum('admin','user') collate utf8_unicode_ci NOT NULL,
  `reg_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `users`
--

INSERT INTO `user` (`id`, `username`, `first_name`, `last_name`, `password`, `email`, `role`, `reg_date`) VALUES
(0, 'admin', 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@mail.com', 'admin', NOW());

-- --------------------------------------------------------

--
-- Structure de la table `user_story`
--

CREATE TABLE IF NOT EXISTS `user_story` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `priority` enum('low','medium','high','very high') collate utf8_unicode_ci NOT NULL,
  `effort` enum('0','1','2','3','5','8','13','21','34') collate utf8_unicode_ci NOT NULL,
  `i_can` text collate utf8_unicode_ci,
  `so_that` text collate utf8_unicode_ci,
  `role_id` int(10) unsigned default NULL,
  `done` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `doc_section`
--
ALTER TABLE `doc_section`
  ADD CONSTRAINT `doc_section_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `faq_category` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inside_project_role`
--
ALTER TABLE `inside_project_role`
  ADD CONSTRAINT `inside_project_role_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inside_sprint_task_us`
--
ALTER TABLE `inside_sprint_task_us`
  ADD CONSTRAINT `inside_sprint_task_us_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inside_sprint_task_us_ibfk_2` FOREIGN KEY (`inside_sprint_us_id`) REFERENCES `inside_sprint_us` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inside_sprint_us`
--
ALTER TABLE `inside_sprint_us`
  ADD CONSTRAINT `inside_sprint_us_ibfk_3` FOREIGN KEY (`sprint_id`) REFERENCES `sprint` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inside_sprint_us_ibfk_4` FOREIGN KEY (`user_story_id`) REFERENCES `user_story` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `project_invitation`
--
ALTER TABLE `project_invitation`
  ADD CONSTRAINT `project_invitation_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_invitation_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `project_member`
--
ALTER TABLE `project_member`
  ADD CONSTRAINT `project_member_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_member_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sprint`
--
ALTER TABLE `sprint`
  ADD CONSTRAINT `sprint_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_4` FOREIGN KEY (`sprint_id`) REFERENCES `sprint` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_ibfk_5` FOREIGN KEY (`member_id`) REFERENCES `project_member` (`id`);

--
-- Contraintes pour la table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_story`
--
ALTER TABLE `user_story`
  ADD CONSTRAINT `user_story_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_story_ibfk_4` FOREIGN KEY (`role_id`) REFERENCES `inside_project_role` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

