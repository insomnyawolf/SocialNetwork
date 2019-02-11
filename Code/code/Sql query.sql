DROP DATABASE `SocialNetwork`;
CREATE DATABASE IF NOT EXISTS `SocialNetwork`;
USE `SocialNetwork`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `user` varchar(30) NOT NULL UNIQUE,
  `nombre` varchar(30),
  `apellido` varchar(30),
  `domicilio` varchar(30),
  `fecha_nac` int(11),
  `telefono` varchar(30),
  `movil` varchar(30),
  `dni` varchar(30),
  `isActive` boolean DEFAULT TRUE,
  `isCAT` boolean DEFAULT FALSE,
  `passwd` varchar(128) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `accounts` (
  `accounts_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `balance` decimal(12,2) NOT NULL,
  PRIMARY KEY  (`accounts_id`, `user_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(user_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `indices` (
  `indices_id` int(11) NOT NULL auto_increment,
  `name` varchar(11) NOT NULL,
  `value` decimal(12,2)DEFAULT 1,
  `last_refresh` int(11)DEFAULT 0,
  PRIMARY KEY  (`indices_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `indices`(`name`) values("AENA");
INSERT INTO `indices`(`name`) values("IBERDROLA");
INSERT INTO `indices`(`name`) values("INDITEX");

CREATE TABLE IF NOT EXISTS `indices_compra` (
  `indices_compra_id` int(11) NOT NULL auto_increment,
  `indices_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) DEFAULT 0,
  PRIMARY KEY  (`indices_compra_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(user_id),
  FOREIGN KEY (`indices_id`) REFERENCES indices(indices_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `historico` (
  `trans_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `cantidad` decimal(12,2) NOT NULL,
  `comision` decimal(12,2) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY  (`trans_id`, `user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;