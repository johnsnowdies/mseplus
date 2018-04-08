# ************************************************************
# Sequel Pro SQL dump
# Версия 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Адрес: 192.168.59.103 (MySQL 5.6.39)
# Схема: funds
# Время создания: 2018-04-08 10:23:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Дамп таблицы currencies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `currencies`;

CREATE TABLE `currencies` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `currency_short_name` varchar(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;

INSERT INTO `currencies` (`id`, `country`, `currency`, `currency_short_name`, `created_at`, `updated_at`)
VALUES
	(1,'','','EU',NULL,NULL),
	(2,'СЛЗ','Динар','DR',NULL,NULL),
	(3,'Республика Энерия','Энерго-кредит','MP',NULL,NULL),
	(4,'Нова','Нова-Кредит','NC',NULL,NULL),
	(5,'Ирландия','Золотой Дублон','GD',NULL,NULL),
	(6,'РКВ','Золотой дракон','SGD',NULL,NULL);

/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы currency_delta
# ------------------------------------------------------------

DROP VIEW IF EXISTS `currency_delta`;

CREATE TABLE `currency_delta` (
   `currency` VARCHAR(11) NULL DEFAULT NULL,
   `delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы currency_falling
# ------------------------------------------------------------

DROP VIEW IF EXISTS `currency_falling`;

CREATE TABLE `currency_falling` (
   `currency_short_name` VARCHAR(11) NULL DEFAULT NULL,
   `behavior` ENUM('GROWTH','FALLING') NULL DEFAULT NULL,
   `market_delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы currency_growth
# ------------------------------------------------------------

DROP VIEW IF EXISTS `currency_growth`;

CREATE TABLE `currency_growth` (
   `currency_short_name` VARCHAR(11) NULL DEFAULT NULL,
   `behavior` ENUM('GROWTH','FALLING') NULL DEFAULT NULL,
   `market_delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы currency_union
# ------------------------------------------------------------

DROP VIEW IF EXISTS `currency_union`;

CREATE TABLE `currency_union` (
   `currency_short_name` VARCHAR(11) NULL DEFAULT NULL,
   `delta1` DOUBLE NULL DEFAULT NULL,
   `delta2` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы markets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `markets`;

CREATE TABLE `markets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_currency` int(11) unsigned NOT NULL,
  `type` enum('INTERNAL','EXTERNAL') NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `market_short_name` varchar(255) NOT NULL,
  `max_companies` int(11) DEFAULT NULL,
  `max_agents` int(11) DEFAULT NULL,
  `max_capitalization` double DEFAULT NULL,
  `min_capitalization` double(255,0) DEFAULT NULL,
  `min_amount` double(255,0) DEFAULT NULL,
  `max_amount` double(255,0) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `rate_agri` int(11) DEFAULT NULL,
  `rate_indus` int(11) DEFAULT NULL,
  `rate_serv` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `markets_id_uindex` (`id`),
  KEY `markets_currencies_id_fk` (`fk_currency`),
  CONSTRAINT `markets_currencies_id_fk` FOREIGN KEY (`fk_currency`) REFERENCES `currencies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `markets` WRITE;
/*!40000 ALTER TABLE `markets` DISABLE KEYS */;

INSERT INTO `markets` (`id`, `fk_currency`, `type`, `name`, `logo`, `market_short_name`, `max_companies`, `max_agents`, `max_capitalization`, `min_capitalization`, `min_amount`, `max_amount`, `created_at`, `updated_at`, `rate_agri`, `rate_indus`, `rate_serv`)
VALUES
	(2,2,'EXTERNAL','Moon and Star union External Exchange','/resource/img/MSUEE.png','MSUEE',123,1,5000000000,1000000,100,500000,NULL,1518644325,0,50,50),
	(3,3,'EXTERNAL','Enerian Republic Exchange Service','/resource/img/ERES.png','ERES',130,1,2000000000,100000,1000,50000,NULL,1518644295,0,65,35),
	(5,4,'EXTERNAL','Nova System External Stock','/resource/img/NSES.png','NSES',18,1,20000000000,100000000,10000,100000,NULL,1518644383,0,75,25),
	(6,6,'EXTERNAL','Glory Shining Cat Overlord Market','/resource/img/GSCOM.png','GSCOM',200,1,1000000000,1000000,100,500000,NULL,1518810424,2,26,72),
	(7,5,'EXTERNAL','Federal Republic Ierland External Stock','/resource/img/FRIES.png','FRIES',99,1,50000000,10000,100,15000,NULL,1522617575,32,12,56),
	(8,2,'INTERNAL','Moon and Star union Internal Exchange','/resource/img/MSUIE.png','MSUIE',227,1,5000000000,1000000,100,500000,NULL,1518644325,5,48,47),
	(9,3,'INTERNAL','Enerian Republic Internal Exchange Service','/resource/img/ERIES.png','ERIES',304,1,2000000000,100000,1000,50000,NULL,1518644295,5,55,40),
	(10,4,'INTERNAL','Nova System Internal Stock','/resource/img/NSIS.png','NSIS',12,1,20000000000,100000000,10000,100000,NULL,1518644383,1,59,40);

/*!40000 ALTER TABLE `markets` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы markets_delta
# ------------------------------------------------------------

DROP VIEW IF EXISTS `markets_delta`;

CREATE TABLE `markets_delta` (
   `market` VARCHAR(255) NULL DEFAULT NULL,
   `delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы markets_falling
# ------------------------------------------------------------

DROP VIEW IF EXISTS `markets_falling`;

CREATE TABLE `markets_falling` (
   `currency_short_name` VARCHAR(255) NULL DEFAULT NULL,
   `behavior` ENUM('GROWTH','FALLING') NULL DEFAULT NULL,
   `market_delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы markets_growth
# ------------------------------------------------------------

DROP VIEW IF EXISTS `markets_growth`;

CREATE TABLE `markets_growth` (
   `currency_short_name` VARCHAR(255) NULL DEFAULT NULL,
   `behavior` ENUM('GROWTH','FALLING') NULL DEFAULT NULL,
   `market_delta` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы markets_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `markets_history`;

CREATE TABLE `markets_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_market` int(10) unsigned DEFAULT NULL,
  `delta` double DEFAULT NULL,
  `delta_abs` double DEFAULT NULL,
  `capitalization` double DEFAULT NULL,
  `tick` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tick` (`tick`,`fk_market`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы markets_union
# ------------------------------------------------------------

DROP VIEW IF EXISTS `markets_union`;

CREATE TABLE `markets_union` (
   `currency_short_name` VARCHAR(255) NULL DEFAULT NULL,
   `delta1` DOUBLE NULL DEFAULT NULL,
   `delta2` DOUBLE NULL DEFAULT NULL
) ENGINE=MyISAM;



# Дамп таблицы meta_news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `meta_news`;

CREATE TABLE `meta_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titl` varchar(255) DEFAULT NULL,
  `sectors` text,
  `news` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `meta_news` WRITE;
/*!40000 ALTER TABLE `meta_news` DISABLE KEYS */;

INSERT INTO `meta_news` (`id`, `titl`, `sectors`, `news`, `created_at`, `updated_at`)
VALUES
	(1,'Признание независимости ССНЭ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;}',1523126889,1523126889),
	(2,'Покупка СЛЗ кораблей у ССНЭ','a:1:{i:0;s:5:\"INDUS\";}','a:2:{i:0;i:7;i:1;i:8;}',1523126984,1523126984),
	(3,'Посольство СЛЗ в ССНЭ','a:2:{i:0;s:5:\"INDUS\";i:1;s:4:\"SERV\";}','a:4:{i:0;i:9;i:1;i:10;i:2;i:11;i:3;i:12;}',1523127060,1523127060),
	(4,'Договор на постройку врат в СЛЗ','a:2:{i:0;s:5:\"INDUS\";i:1;s:4:\"SERV\";}','a:6:{i:0;i:13;i:1;i:14;i:2;i:15;i:3;i:16;i:4;i:17;i:5;i:18;}',1523127139,1523127139),
	(5,'Договор на постройку врат с ФРИ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:9:{i:0;i:19;i:1;i:20;i:2;i:21;i:3;i:22;i:4;i:23;i:5;i:24;i:6;i:25;i:7;i:26;i:8;i:27;}',1523127198,1523127198),
	(6,'Создание Интерпола','a:1:{i:0;s:4:\"SERV\";}','a:3:{i:0;i:28;i:1;i:29;i:2;i:30;}',1523127268,1523127268),
	(7,'Создание открытого университета','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:9:{i:0;i:31;i:1;i:32;i:2;i:33;i:3;i:34;i:4;i:35;i:5;i:36;i:6;i:37;i:7;i:38;i:8;i:39;}',1523127304,1523127304),
	(8,'Посольство Новы в ССНЭ','a:2:{i:0;s:5:\"INDUS\";i:1;s:4:\"SERV\";}','a:6:{i:0;i:40;i:1;i:41;i:2;i:42;i:3;i:43;i:4;i:44;i:5;i:45;}',1523127406,1523127406),
	(9,'Посольство Новы в ФРИ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:9:{i:0;i:46;i:1;i:47;i:2;i:48;i:3;i:49;i:4;i:50;i:5;i:51;i:6;i:52;i:7;i:53;i:8;i:54;}',1523127459,1523127459),
	(10,'Посольство ССНЭ в ФРИ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:9:{i:0;i:55;i:1;i:56;i:2;i:57;i:3;i:58;i:4;i:59;i:5;i:60;i:6;i:61;i:7;i:62;i:8;i:63;}',1523127565,1523127565),
	(11,'Договор о строительстве врат на Нове','a:2:{i:0;s:5:\"INDUS\";i:1;s:4:\"SERV\";}','a:8:{i:0;i:64;i:1;i:65;i:2;i:66;i:3;i:67;i:4;i:68;i:5;i:69;i:6;i:70;i:7;i:71;}',1523127638,1523127638),
	(12,'Принятие конституции ФРИ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:3:{i:0;i:72;i:1;i:73;i:2;i:74;}',1523127705,1523127705),
	(13,'Проведение выборов в Дойл ФРИ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:3:{i:0;i:75;i:1;i:76;i:2;i:77;}',1523127747,1523127747),
	(14,'Принятие торгового законодательства ФРИ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:3:{i:0;i:78;i:1;i:79;i:2;i:80;}',1523127790,1523127790),
	(15,'Налоговая реформа ФРИ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:3:{i:0;i:81;i:1;i:82;i:2;i:83;}',1523127823,1523127823),
	(16,'Проведение аукциона на свободные земли','a:1:{i:0;s:4:\"AGRI\";}','a:1:{i:0;i:84;}',1523127866,1523127866),
	(17,'Подписание договора с Аристократами под эгидой Драконов','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:85;i:1;i:86;i:2;i:87;i:3;i:88;i:4;i:89;i:5;i:90;}',1523127916,1523127916),
	(18,'Выход на рынок: Irish Delivery 2','a:1:{i:0;s:5:\"INDUS\";}','a:3:{i:0;i:91;i:1;i:92;i:2;i:93;}',1523127983,1523127983),
	(19,'Выход на рынок: Батерстай Деливери','a:1:{i:0;s:5:\"INDUS\";}','a:1:{i:0;i:94;}',1523128022,1523128022),
	(20,'Успех Diamond +','a:2:{i:0;s:5:\"INDUS\";i:1;s:4:\"SERV\";}','a:6:{i:0;i:95;i:1;i:96;i:2;i:97;i:3;i:98;i:4;i:99;i:5;i:100;}',1523128065,1523128065),
	(21,'Теракт у 5 осколка корпорации','a:1:{i:0;s:5:\"INDUS\";}','a:2:{i:0;i:101;i:1;i:102;}',1523128109,1523128109),
	(22,'Промышленный осколок отчитался о выработке НЭ','a:1:{i:0;s:5:\"INDUS\";}','a:2:{i:0;i:103;i:1;i:104;}',1523128150,1523128150),
	(23,'Пенсионная реформа в ССНЭ','a:1:{i:0;s:4:\"SERV\";}','a:1:{i:0;i:105;}',1523128191,1523128191),
	(24,'Спортивные дотации в ССНЭ','a:1:{i:0;s:4:\"SERV\";}','a:1:{i:0;i:106;}',1523128229,1523128229),
	(25,'Релиз \"Стражбокс 1800\"','a:2:{i:0;s:5:\"INDUS\";i:1;s:4:\"SERV\";}','a:4:{i:0;i:107;i:1;i:108;i:2;i:109;i:3;i:110;}',1523128327,1523128327),
	(26,'Теракты в ФРИ','a:2:{i:0;s:5:\"INDUS\";i:1;s:4:\"SERV\";}','a:2:{i:0;i:111;i:1;i:112;}',1523128388,1523128388),
	(27,'Силовая операция в Анклаве в СЛЗ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:113;i:1;i:114;i:2;i:115;i:3;i:116;i:4;i:117;i:5;i:118;}',1523128481,1523128481),
	(28,'Нападение на столичную систему','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:119;i:1;i:120;i:2;i:121;i:3;i:122;i:4;i:123;i:5;i:124;}',1523128581,1523128581),
	(29,'Гибель столичной системы СЛЗ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:125;i:1;i:126;i:2;i:127;i:3;i:128;i:4;i:129;i:5;i:130;}',1523128626,1523128626),
	(30,'Слухи о смерти Махди (СЛЗ)','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:131;i:1;i:132;i:2;i:133;i:3;i:134;i:4;i:135;i:5;i:136;}',1523129248,1523129248),
	(31,'Обыски во дворце Махди (СЛЗ)','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:137;i:1;i:138;i:2;i:139;i:3;i:140;i:4;i:141;i:5;i:142;}',1523129313,1523129313),
	(32,'Арест главы 5 осколка (СЛЗ)','a:1:{i:0;s:5:\"INDUS\";}','a:2:{i:0;i:143;i:1;i:144;}',1523129369,1523129369),
	(33,'Уничтожение планет в Анклаве','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:145;i:1;i:146;i:2;i:147;i:3;i:148;i:4;i:149;i:5;i:150;}',1523129411,1523129411),
	(34,'Инспекции Драконов в СЛЗ','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:151;i:1;i:152;i:2;i:153;i:3;i:154;i:4;i:155;i:5;i:156;}',1523129464,1523129464),
	(35,'Официальное известие о смерти Махди','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:157;i:1;i:158;i:2;i:159;i:3;i:160;i:4;i:161;i:5;i:162;}',1523129567,1523129567),
	(36,'Опровержение о смерти Махди','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:163;i:1;i:164;i:2;i:165;i:3;i:166;i:4;i:167;i:5;i:168;}',1523129606,1523129606),
	(37,'Гибель Аль-Киндли','a:1:{i:0;s:5:\"INDUS\";}','a:2:{i:0;i:169;i:1;i:170;}',1523129642,1523129642),
	(38,'Уничтожение столичной планеты-логистического узла','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:6:{i:0;i:171;i:1;i:172;i:2;i:173;i:3;i:174;i:4;i:175;i:5;i:176;}',1523129688,1523129688),
	(39,'Отзыв посольства ССНЭ из СЛЗ','a:2:{i:0;s:5:\"INDUS\";i:1;s:4:\"SERV\";}','a:4:{i:0;i:177;i:1;i:178;i:2;i:179;i:3;i:180;}',1523129742,1523129742),
	(40,'Медийный все, ня','a:1:{i:0;s:4:\"SERV\";}','a:1:{i:0;i:181;}',1523182751,1523182751),
	(41,'Заключение ССНЭ договоров с котами','a:1:{i:0;s:5:\"INDUS\";}','a:2:{i:0;i:182;i:1;i:183;}',1523182841,1523182841),
	(42,'Объединение котов','a:3:{i:0;s:4:\"AGRI\";i:1;s:5:\"INDUS\";i:2;s:4:\"SERV\";}','a:3:{i:0;i:184;i:1;i:185;i:2;i:186;}',1523182920,1523182920);

/*!40000 ALTER TABLE `meta_news` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;

INSERT INTO `migration` (`version`, `apply_time`)
VALUES
	('m000000_000000_base',1518826153);

/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tick` int(11) DEFAULT NULL,
  `ttl` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `fk_market` int(11) unsigned DEFAULT NULL,
  `sector` enum('AGRI','INDUS','SERV') DEFAULT NULL,
  `type` enum('POSITIVE','NEGATIVE') DEFAULT NULL,
  `priority` enum('LOW','MEDIUM','HIGH','') DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_market_news` (`fk_market`),
  CONSTRAINT `fk_market_news` FOREIGN KEY (`fk_market`) REFERENCES `markets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;

INSERT INTO `news` (`id`, `tick`, `ttl`, `title`, `text`, `fk_market`, `sector`, `type`, `priority`, `created_at`, `updated_at`)
VALUES
	(1,1,10,'Признание независимости ССНЭ','Created by MetaNews: Признание независимости ССНЭ',3,'AGRI','POSITIVE','HIGH',1523126889,1523126889),
	(2,1,10,'Признание независимости ССНЭ','Created by MetaNews: Признание независимости ССНЭ',9,'AGRI','POSITIVE','HIGH',1523126889,1523126889),
	(3,1,10,'Признание независимости ССНЭ','Created by MetaNews: Признание независимости ССНЭ',3,'INDUS','POSITIVE','HIGH',1523126889,1523126889),
	(4,1,10,'Признание независимости ССНЭ','Created by MetaNews: Признание независимости ССНЭ',9,'INDUS','POSITIVE','HIGH',1523126889,1523126889),
	(5,1,10,'Признание независимости ССНЭ','Created by MetaNews: Признание независимости ССНЭ',3,'SERV','POSITIVE','HIGH',1523126889,1523126889),
	(6,1,10,'Признание независимости ССНЭ','Created by MetaNews: Признание независимости ССНЭ',9,'SERV','POSITIVE','HIGH',1523126889,1523126889),
	(7,5,3,'Покупка СЛЗ кораблей у ССНЭ','Created by MetaNews: Покупка СЛЗ кораблей у ССНЭ',3,'INDUS','POSITIVE','MEDIUM',1523126984,1523126984),
	(8,5,3,'Покупка СЛЗ кораблей у ССНЭ','Created by MetaNews: Покупка СЛЗ кораблей у ССНЭ',2,'INDUS','POSITIVE','LOW',1523126984,1523126984),
	(9,1,3,'Посольство СЛЗ в ССНЭ','Created by MetaNews: Посольство СЛЗ в ССНЭ',2,'INDUS','POSITIVE','LOW',1523127060,1523127060),
	(10,1,3,'Посольство СЛЗ в ССНЭ','Created by MetaNews: Посольство СЛЗ в ССНЭ',3,'INDUS','POSITIVE','LOW',1523127060,1523127060),
	(11,1,3,'Посольство СЛЗ в ССНЭ','Created by MetaNews: Посольство СЛЗ в ССНЭ',2,'SERV','POSITIVE','LOW',1523127060,1523127060),
	(12,1,3,'Посольство СЛЗ в ССНЭ','Created by MetaNews: Посольство СЛЗ в ССНЭ',3,'SERV','POSITIVE','LOW',1523127060,1523127060),
	(13,16,3,'Договор на постройку врат в СЛЗ','Created by MetaNews: Договор на постройку врат в СЛЗ',2,'INDUS','POSITIVE','LOW',1523127139,1523127139),
	(14,16,3,'Договор на постройку врат в СЛЗ','Created by MetaNews: Договор на постройку врат в СЛЗ',3,'INDUS','POSITIVE','LOW',1523127139,1523127139),
	(15,16,3,'Договор на постройку врат в СЛЗ','Created by MetaNews: Договор на постройку врат в СЛЗ',9,'INDUS','POSITIVE','LOW',1523127139,1523127139),
	(16,16,3,'Договор на постройку врат в СЛЗ','Created by MetaNews: Договор на постройку врат в СЛЗ',2,'SERV','POSITIVE','LOW',1523127139,1523127139),
	(17,16,3,'Договор на постройку врат в СЛЗ','Created by MetaNews: Договор на постройку врат в СЛЗ',3,'SERV','POSITIVE','LOW',1523127139,1523127139),
	(18,16,3,'Договор на постройку врат в СЛЗ','Created by MetaNews: Договор на постройку врат в СЛЗ',9,'SERV','POSITIVE','LOW',1523127139,1523127139),
	(19,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',7,'AGRI','POSITIVE','LOW',1523127198,1523127198),
	(20,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',3,'AGRI','POSITIVE','LOW',1523127198,1523127198),
	(21,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',9,'AGRI','POSITIVE','LOW',1523127198,1523127198),
	(22,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',7,'INDUS','POSITIVE','LOW',1523127198,1523127198),
	(23,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',3,'INDUS','POSITIVE','LOW',1523127198,1523127198),
	(24,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',9,'INDUS','POSITIVE','LOW',1523127198,1523127198),
	(25,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',7,'SERV','POSITIVE','LOW',1523127198,1523127198),
	(26,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',3,'SERV','POSITIVE','LOW',1523127198,1523127198),
	(27,16,3,'Договор на постройку врат с ФРИ','Created by MetaNews: Договор на постройку врат с ФРИ',9,'SERV','POSITIVE','LOW',1523127198,1523127198),
	(28,18,3,'Создание Интерпола','Created by MetaNews: Создание Интерпола',2,'SERV','POSITIVE','LOW',1523127268,1523127268),
	(29,18,3,'Создание Интерпола','Created by MetaNews: Создание Интерпола',3,'SERV','POSITIVE','LOW',1523127268,1523127268),
	(30,18,3,'Создание Интерпола','Created by MetaNews: Создание Интерпола',7,'SERV','POSITIVE','LOW',1523127268,1523127268),
	(31,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',2,'AGRI','POSITIVE','LOW',1523127304,1523127304),
	(32,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',3,'AGRI','POSITIVE','LOW',1523127304,1523127304),
	(33,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',7,'AGRI','POSITIVE','LOW',1523127304,1523127304),
	(34,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',2,'INDUS','POSITIVE','LOW',1523127304,1523127304),
	(35,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',3,'INDUS','POSITIVE','LOW',1523127304,1523127304),
	(36,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',7,'INDUS','POSITIVE','LOW',1523127304,1523127304),
	(37,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',2,'SERV','POSITIVE','LOW',1523127304,1523127304),
	(38,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',3,'SERV','POSITIVE','LOW',1523127304,1523127304),
	(39,18,3,'Создание открытого университета','Created by MetaNews: Создание открытого университета',7,'SERV','POSITIVE','LOW',1523127304,1523127304),
	(40,22,5,'Посольство Новы в ССНЭ','Created by MetaNews: Посольство Новы в ССНЭ',5,'INDUS','POSITIVE','LOW',1523127406,1523127406),
	(41,22,5,'Посольство Новы в ССНЭ','Created by MetaNews: Посольство Новы в ССНЭ',3,'INDUS','POSITIVE','LOW',1523127406,1523127406),
	(42,22,3,'Посольство Новы в ССНЭ','Created by MetaNews: Посольство Новы в ССНЭ',9,'INDUS','POSITIVE','LOW',1523127406,1523127406),
	(43,22,5,'Посольство Новы в ССНЭ','Created by MetaNews: Посольство Новы в ССНЭ',5,'SERV','POSITIVE','LOW',1523127406,1523127406),
	(44,22,5,'Посольство Новы в ССНЭ','Created by MetaNews: Посольство Новы в ССНЭ',3,'SERV','POSITIVE','LOW',1523127406,1523127406),
	(45,22,3,'Посольство Новы в ССНЭ','Created by MetaNews: Посольство Новы в ССНЭ',9,'SERV','POSITIVE','LOW',1523127406,1523127406),
	(46,15,5,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',7,'AGRI','POSITIVE','LOW',1523127459,1523127459),
	(47,15,5,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',5,'AGRI','POSITIVE','LOW',1523127459,1523127459),
	(48,15,3,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',10,'AGRI','POSITIVE','LOW',1523127459,1523127459),
	(49,15,5,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',7,'INDUS','POSITIVE','LOW',1523127459,1523127459),
	(50,15,5,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',5,'INDUS','POSITIVE','LOW',1523127459,1523127459),
	(51,15,3,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',10,'INDUS','POSITIVE','LOW',1523127459,1523127459),
	(52,15,5,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',7,'SERV','POSITIVE','LOW',1523127459,1523127459),
	(53,15,5,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',5,'SERV','POSITIVE','LOW',1523127459,1523127459),
	(54,15,3,'Посольство Новы в ФРИ','Created by MetaNews: Посольство Новы в ФРИ',10,'SERV','POSITIVE','LOW',1523127459,1523127459),
	(55,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',3,'AGRI','POSITIVE','LOW',1523127565,1523127565),
	(56,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',9,'AGRI','POSITIVE','LOW',1523127565,1523127565),
	(57,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',7,'AGRI','POSITIVE','LOW',1523127565,1523127565),
	(58,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',3,'INDUS','POSITIVE','LOW',1523127565,1523127565),
	(59,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',9,'INDUS','POSITIVE','LOW',1523127565,1523127565),
	(60,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',7,'INDUS','POSITIVE','LOW',1523127565,1523127565),
	(61,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',3,'SERV','POSITIVE','LOW',1523127565,1523127565),
	(62,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',9,'SERV','POSITIVE','LOW',1523127565,1523127565),
	(63,4,3,'Посольство ССНЭ в ФРИ','Created by MetaNews: Посольство ССНЭ в ФРИ',7,'SERV','POSITIVE','LOW',1523127565,1523127565),
	(64,17,4,'Договор о строительстве врат на Нове','Created by MetaNews: Договор о строительстве врат на Нове',3,'INDUS','POSITIVE','LOW',1523127638,1523127638),
	(65,17,3,'Договор о строительстве врат на Нове','Created by MetaNews: Договор о строительстве врат на Нове',9,'INDUS','POSITIVE','LOW',1523127638,1523127638),
	(66,17,4,'Договор о строительстве врат на Нове','Created by MetaNews: Договор о строительстве врат на Нове',5,'INDUS','POSITIVE','LOW',1523127638,1523127638),
	(67,17,3,'Договор о строительстве врат на Нове','Created by MetaNews: Договор о строительстве врат на Нове',10,'INDUS','POSITIVE','LOW',1523127638,1523127638),
	(68,17,4,'Договор о строительстве врат на Нове','Created by MetaNews: Договор о строительстве врат на Нове',3,'SERV','POSITIVE','LOW',1523127638,1523127638),
	(69,17,3,'Договор о строительстве врат на Нове','Created by MetaNews: Договор о строительстве врат на Нове',9,'SERV','POSITIVE','LOW',1523127638,1523127638),
	(70,17,4,'Договор о строительстве врат на Нове','Created by MetaNews: Договор о строительстве врат на Нове',5,'SERV','POSITIVE','LOW',1523127638,1523127638),
	(71,17,3,'Договор о строительстве врат на Нове','Created by MetaNews: Договор о строительстве врат на Нове',10,'SERV','POSITIVE','LOW',1523127638,1523127638),
	(72,10,8,'Принятие конституции ФРИ','Created by MetaNews: Принятие конституции ФРИ',7,'AGRI','POSITIVE','MEDIUM',1523127705,1523127705),
	(73,10,8,'Принятие конституции ФРИ','Created by MetaNews: Принятие конституции ФРИ',7,'INDUS','POSITIVE','MEDIUM',1523127705,1523127705),
	(74,10,8,'Принятие конституции ФРИ','Created by MetaNews: Принятие конституции ФРИ',7,'SERV','POSITIVE','MEDIUM',1523127705,1523127705),
	(75,20,3,'Проведение выборов в Дойл ФРИ','Created by MetaNews: Проведение выборов в Дойл ФРИ',7,'AGRI','POSITIVE','LOW',1523127747,1523127747),
	(76,20,3,'Проведение выборов в Дойл ФРИ','Created by MetaNews: Проведение выборов в Дойл ФРИ',7,'INDUS','POSITIVE','LOW',1523127747,1523127747),
	(77,20,3,'Проведение выборов в Дойл ФРИ','Created by MetaNews: Проведение выборов в Дойл ФРИ',7,'SERV','POSITIVE','LOW',1523127747,1523127747),
	(78,25,5,'Принятие торгового законодательства ФРИ','Created by MetaNews: Принятие торгового законодательства ФРИ',7,'AGRI','NEGATIVE','MEDIUM',1523127790,1523127790),
	(79,25,5,'Принятие торгового законодательства ФРИ','Created by MetaNews: Принятие торгового законодательства ФРИ',7,'INDUS','NEGATIVE','MEDIUM',1523127790,1523127790),
	(80,25,5,'Принятие торгового законодательства ФРИ','Created by MetaNews: Принятие торгового законодательства ФРИ',7,'SERV','NEGATIVE','MEDIUM',1523127790,1523127790),
	(81,27,3,'Налоговая реформа ФРИ','Created by MetaNews: Налоговая реформа ФРИ',7,'AGRI','NEGATIVE','LOW',1523127823,1523127823),
	(82,27,3,'Налоговая реформа ФРИ','Created by MetaNews: Налоговая реформа ФРИ',7,'INDUS','NEGATIVE','LOW',1523127823,1523127823),
	(83,27,3,'Налоговая реформа ФРИ','Created by MetaNews: Налоговая реформа ФРИ',7,'SERV','NEGATIVE','LOW',1523127823,1523127823),
	(84,32,5,'Проведение аукциона на свободные земли','Created by MetaNews: Проведение аукциона на свободные земли',7,'AGRI','POSITIVE','HIGH',1523127866,1523127866),
	(85,22,5,'Подписание договора с Аристократами под эгидой Драконов','Created by MetaNews: Подписание договора с Аристократами под эгидой Драконов',2,'AGRI','POSITIVE','HIGH',1523127916,1523127916),
	(86,22,5,'Подписание договора с Аристократами под эгидой Драконов','Created by MetaNews: Подписание договора с Аристократами под эгидой Драконов',8,'AGRI','POSITIVE','MEDIUM',1523127916,1523127916),
	(87,22,5,'Подписание договора с Аристократами под эгидой Драконов','Created by MetaNews: Подписание договора с Аристократами под эгидой Драконов',2,'INDUS','POSITIVE','HIGH',1523127916,1523127916),
	(88,22,5,'Подписание договора с Аристократами под эгидой Драконов','Created by MetaNews: Подписание договора с Аристократами под эгидой Драконов',8,'INDUS','POSITIVE','MEDIUM',1523127916,1523127916),
	(89,22,5,'Подписание договора с Аристократами под эгидой Драконов','Created by MetaNews: Подписание договора с Аристократами под эгидой Драконов',2,'SERV','POSITIVE','HIGH',1523127916,1523127916),
	(90,22,5,'Подписание договора с Аристократами под эгидой Драконов','Created by MetaNews: Подписание договора с Аристократами под эгидой Драконов',8,'SERV','POSITIVE','MEDIUM',1523127916,1523127916),
	(91,31,4,'Выход на рынок: Irish Delivery 2','Created by MetaNews: Выход на рынок: Irish Delivery 2',2,'INDUS','POSITIVE','LOW',1523127983,1523127983),
	(92,31,4,'Выход на рынок: Irish Delivery 2','Created by MetaNews: Выход на рынок: Irish Delivery 2',8,'INDUS','POSITIVE','LOW',1523127983,1523127983),
	(93,31,3,'Выход на рынок: Irish Delivery 2','Created by MetaNews: Выход на рынок: Irish Delivery 2',7,'INDUS','POSITIVE','LOW',1523127983,1523127983),
	(94,38,2,'Выход на рынок: Батерстай Деливери','Created by MetaNews: Выход на рынок: Батерстай Деливери',2,'INDUS','POSITIVE','LOW',1523128022,1523128022),
	(95,42,6,'Успех Diamond +','Created by MetaNews: Успех Diamond +',2,'INDUS','POSITIVE','MEDIUM',1523128065,1523128065),
	(96,42,6,'Успех Diamond +','Created by MetaNews: Успех Diamond +',8,'INDUS','POSITIVE','MEDIUM',1523128065,1523128065),
	(97,42,4,'Успех Diamond +','Created by MetaNews: Успех Diamond +',7,'INDUS','POSITIVE','MEDIUM',1523128065,1523128065),
	(98,42,6,'Успех Diamond +','Created by MetaNews: Успех Diamond +',2,'SERV','POSITIVE','MEDIUM',1523128065,1523128065),
	(99,42,6,'Успех Diamond +','Created by MetaNews: Успех Diamond +',8,'SERV','POSITIVE','MEDIUM',1523128065,1523128065),
	(100,42,4,'Успех Diamond +','Created by MetaNews: Успех Diamond +',7,'SERV','POSITIVE','MEDIUM',1523128065,1523128065),
	(101,55,4,'Теракт у 5 осколка корпорации','Created by MetaNews: Теракт у 5 осколка корпорации',2,'INDUS','NEGATIVE','LOW',1523128109,1523128109),
	(102,55,2,'Теракт у 5 осколка корпорации','Created by MetaNews: Теракт у 5 осколка корпорации',8,'INDUS','NEGATIVE','LOW',1523128109,1523128109),
	(103,40,2,'Промышленный осколок отчитался о выработке НЭ','Created by MetaNews: Промышленный осколок отчитался о выработке НЭ',2,'INDUS','POSITIVE','HIGH',1523128150,1523128150),
	(104,40,2,'Промышленный осколок отчитался о выработке НЭ','Created by MetaNews: Промышленный осколок отчитался о выработке НЭ',8,'INDUS','POSITIVE','HIGH',1523128150,1523128150),
	(105,40,7,'Пенсионная реформа в ССНЭ','Created by MetaNews: Пенсионная реформа в ССНЭ',9,'SERV','POSITIVE','MEDIUM',1523128191,1523128191),
	(106,42,5,'Спортивные дотации в ССНЭ','Created by MetaNews: Спортивные дотации в ССНЭ',9,'SERV','POSITIVE','LOW',1523128229,1523128229),
	(107,35,10,'Релиз \"Стражбокс 1800\"','Created by MetaNews: Релиз \"Стражбокс 1800\"',9,'INDUS','POSITIVE','MEDIUM',1523128327,1523128327),
	(108,35,10,'Релиз \"Стражбокс 1800\"','Created by MetaNews: Релиз \"Стражбокс 1800\"',3,'INDUS','POSITIVE','MEDIUM',1523128327,1523128327),
	(109,35,10,'Релиз \"Стражбокс 1800\"','Created by MetaNews: Релиз \"Стражбокс 1800\"',9,'SERV','POSITIVE','MEDIUM',1523128327,1523128327),
	(110,35,10,'Релиз \"Стражбокс 1800\"','Created by MetaNews: Релиз \"Стражбокс 1800\"',3,'SERV','POSITIVE','MEDIUM',1523128327,1523128327),
	(111,62,1,'Теракты в ФРИ','Created by MetaNews: Теракты в ФРИ',7,'INDUS','POSITIVE','MEDIUM',1523128388,1523128388),
	(112,62,1,'Теракты в ФРИ','Created by MetaNews: Теракты в ФРИ',7,'SERV','POSITIVE','MEDIUM',1523128388,1523128388),
	(113,62,3,'Силовая операция в Анклаве в СЛЗ','Created by MetaNews: Силовая операция в Анклаве в СЛЗ',2,'AGRI','NEGATIVE','HIGH',1523128480,1523128480),
	(114,62,3,'Силовая операция в Анклаве в СЛЗ','Created by MetaNews: Силовая операция в Анклаве в СЛЗ',8,'AGRI','NEGATIVE','HIGH',1523128480,1523128480),
	(115,62,3,'Силовая операция в Анклаве в СЛЗ','Created by MetaNews: Силовая операция в Анклаве в СЛЗ',2,'INDUS','NEGATIVE','HIGH',1523128480,1523128480),
	(116,62,3,'Силовая операция в Анклаве в СЛЗ','Created by MetaNews: Силовая операция в Анклаве в СЛЗ',8,'INDUS','NEGATIVE','HIGH',1523128480,1523128480),
	(117,62,3,'Силовая операция в Анклаве в СЛЗ','Created by MetaNews: Силовая операция в Анклаве в СЛЗ',2,'SERV','NEGATIVE','HIGH',1523128480,1523128480),
	(118,62,3,'Силовая операция в Анклаве в СЛЗ','Created by MetaNews: Силовая операция в Анклаве в СЛЗ',8,'SERV','NEGATIVE','HIGH',1523128480,1523128480),
	(119,62,1,'Нападение на столичную систему','Created by MetaNews: Нападение на столичную систему',2,'AGRI','NEGATIVE','HIGH',1523128581,1523128581),
	(120,62,1,'Нападение на столичную систему','Created by MetaNews: Нападение на столичную систему',8,'AGRI','NEGATIVE','HIGH',1523128581,1523128581),
	(121,62,1,'Нападение на столичную систему','Created by MetaNews: Нападение на столичную систему',2,'INDUS','NEGATIVE','HIGH',1523128581,1523128581),
	(122,62,1,'Нападение на столичную систему','Created by MetaNews: Нападение на столичную систему',8,'INDUS','NEGATIVE','HIGH',1523128581,1523128581),
	(123,62,1,'Нападение на столичную систему','Created by MetaNews: Нападение на столичную систему',2,'SERV','NEGATIVE','HIGH',1523128581,1523128581),
	(124,62,1,'Нападение на столичную систему','Created by MetaNews: Нападение на столичную систему',8,'SERV','NEGATIVE','HIGH',1523128581,1523128581),
	(125,62,10,'Гибель столичной системы СЛЗ','Created by MetaNews: Гибель столичной системы СЛЗ',2,'AGRI','NEGATIVE','HIGH',1523128626,1523128626),
	(126,62,10,'Гибель столичной системы СЛЗ','Created by MetaNews: Гибель столичной системы СЛЗ',8,'AGRI','NEGATIVE','HIGH',1523128626,1523128626),
	(127,62,10,'Гибель столичной системы СЛЗ','Created by MetaNews: Гибель столичной системы СЛЗ',2,'INDUS','NEGATIVE','HIGH',1523128626,1523128626),
	(128,62,10,'Гибель столичной системы СЛЗ','Created by MetaNews: Гибель столичной системы СЛЗ',8,'INDUS','NEGATIVE','HIGH',1523128626,1523128626),
	(129,62,10,'Гибель столичной системы СЛЗ','Created by MetaNews: Гибель столичной системы СЛЗ',2,'SERV','NEGATIVE','HIGH',1523128626,1523128626),
	(130,62,10,'Гибель столичной системы СЛЗ','Created by MetaNews: Гибель столичной системы СЛЗ',8,'SERV','NEGATIVE','HIGH',1523128626,1523128626),
	(131,64,5,'Слухи о смерти Махди (СЛЗ)','Created by MetaNews: Слухи о смерти Махди (СЛЗ)',2,'AGRI','NEGATIVE','HIGH',1523129248,1523129248),
	(132,64,5,'Слухи о смерти Махди (СЛЗ)','Created by MetaNews: Слухи о смерти Махди (СЛЗ)',8,'AGRI','NEGATIVE','MEDIUM',1523129248,1523129248),
	(133,64,5,'Слухи о смерти Махди (СЛЗ)','Created by MetaNews: Слухи о смерти Махди (СЛЗ)',2,'INDUS','NEGATIVE','HIGH',1523129248,1523129248),
	(134,64,5,'Слухи о смерти Махди (СЛЗ)','Created by MetaNews: Слухи о смерти Махди (СЛЗ)',8,'INDUS','NEGATIVE','MEDIUM',1523129248,1523129248),
	(135,64,5,'Слухи о смерти Махди (СЛЗ)','Created by MetaNews: Слухи о смерти Махди (СЛЗ)',2,'SERV','NEGATIVE','HIGH',1523129248,1523129248),
	(136,64,5,'Слухи о смерти Махди (СЛЗ)','Created by MetaNews: Слухи о смерти Махди (СЛЗ)',8,'SERV','NEGATIVE','MEDIUM',1523129248,1523129248),
	(137,64,3,'Обыски во дворце Махди (СЛЗ)','Created by MetaNews: Обыски во дворце Махди (СЛЗ)',2,'AGRI','NEGATIVE','MEDIUM',1523129313,1523129313),
	(138,64,3,'Обыски во дворце Махди (СЛЗ)','Created by MetaNews: Обыски во дворце Махди (СЛЗ)',8,'AGRI','NEGATIVE','MEDIUM',1523129313,1523129313),
	(139,64,3,'Обыски во дворце Махди (СЛЗ)','Created by MetaNews: Обыски во дворце Махди (СЛЗ)',2,'INDUS','NEGATIVE','MEDIUM',1523129313,1523129313),
	(140,64,3,'Обыски во дворце Махди (СЛЗ)','Created by MetaNews: Обыски во дворце Махди (СЛЗ)',8,'INDUS','NEGATIVE','MEDIUM',1523129313,1523129313),
	(141,64,3,'Обыски во дворце Махди (СЛЗ)','Created by MetaNews: Обыски во дворце Махди (СЛЗ)',2,'SERV','NEGATIVE','MEDIUM',1523129313,1523129313),
	(142,64,3,'Обыски во дворце Махди (СЛЗ)','Created by MetaNews: Обыски во дворце Махди (СЛЗ)',8,'SERV','NEGATIVE','MEDIUM',1523129313,1523129313),
	(143,64,5,'Арест главы 5 осколка (СЛЗ)','Created by MetaNews: Арест главы 5 осколка (СЛЗ)',2,'INDUS','NEGATIVE','HIGH',1523129369,1523129369),
	(144,64,5,'Арест главы 5 осколка (СЛЗ)','Created by MetaNews: Арест главы 5 осколка (СЛЗ)',8,'INDUS','NEGATIVE','HIGH',1523129369,1523129369),
	(145,65,5,'Уничтожение планет в Анклаве','Created by MetaNews: Уничтожение планет в Анклаве',2,'AGRI','NEGATIVE','HIGH',1523129411,1523129411),
	(146,65,5,'Уничтожение планет в Анклаве','Created by MetaNews: Уничтожение планет в Анклаве',8,'AGRI','NEGATIVE','HIGH',1523129411,1523129411),
	(147,65,5,'Уничтожение планет в Анклаве','Created by MetaNews: Уничтожение планет в Анклаве',2,'INDUS','NEGATIVE','HIGH',1523129411,1523129411),
	(148,65,5,'Уничтожение планет в Анклаве','Created by MetaNews: Уничтожение планет в Анклаве',8,'INDUS','NEGATIVE','HIGH',1523129411,1523129411),
	(149,65,5,'Уничтожение планет в Анклаве','Created by MetaNews: Уничтожение планет в Анклаве',2,'SERV','NEGATIVE','HIGH',1523129411,1523129411),
	(150,65,5,'Уничтожение планет в Анклаве','Created by MetaNews: Уничтожение планет в Анклаве',8,'SERV','NEGATIVE','HIGH',1523129411,1523129411),
	(151,66,10,'Инспекции Драконов в СЛЗ','Created by MetaNews: Инспекции Драконов в СЛЗ',2,'AGRI','NEGATIVE','MEDIUM',1523129464,1523129464),
	(152,66,10,'Инспекции Драконов в СЛЗ','Created by MetaNews: Инспекции Драконов в СЛЗ',8,'AGRI','NEGATIVE','HIGH',1523129464,1523129464),
	(153,66,10,'Инспекции Драконов в СЛЗ','Created by MetaNews: Инспекции Драконов в СЛЗ',2,'INDUS','NEGATIVE','MEDIUM',1523129464,1523129464),
	(154,66,10,'Инспекции Драконов в СЛЗ','Created by MetaNews: Инспекции Драконов в СЛЗ',8,'INDUS','NEGATIVE','HIGH',1523129464,1523129464),
	(155,66,10,'Инспекции Драконов в СЛЗ','Created by MetaNews: Инспекции Драконов в СЛЗ',2,'SERV','NEGATIVE','MEDIUM',1523129464,1523129464),
	(156,66,10,'Инспекции Драконов в СЛЗ','Created by MetaNews: Инспекции Драконов в СЛЗ',8,'SERV','NEGATIVE','HIGH',1523129464,1523129464),
	(157,69,2,'Официальное известие о смерти Махди','Created by MetaNews: Официальное известие о смерти Махди',2,'AGRI','NEGATIVE','HIGH',1523129567,1523129567),
	(158,69,2,'Официальное известие о смерти Махди','Created by MetaNews: Официальное известие о смерти Махди',8,'AGRI','NEGATIVE','HIGH',1523129567,1523129567),
	(159,69,2,'Официальное известие о смерти Махди','Created by MetaNews: Официальное известие о смерти Махди',2,'INDUS','NEGATIVE','HIGH',1523129567,1523129567),
	(160,69,2,'Официальное известие о смерти Махди','Created by MetaNews: Официальное известие о смерти Махди',8,'INDUS','NEGATIVE','HIGH',1523129567,1523129567),
	(161,69,2,'Официальное известие о смерти Махди','Created by MetaNews: Официальное известие о смерти Махди',2,'SERV','NEGATIVE','HIGH',1523129567,1523129567),
	(162,69,2,'Официальное известие о смерти Махди','Created by MetaNews: Официальное известие о смерти Махди',8,'SERV','NEGATIVE','HIGH',1523129567,1523129567),
	(163,70,3,'Опровержение о смерти Махди','Created by MetaNews: Опровержение о смерти Махди',2,'AGRI','POSITIVE','LOW',1523129606,1523129606),
	(164,70,3,'Опровержение о смерти Махди','Created by MetaNews: Опровержение о смерти Махди',8,'AGRI','POSITIVE','LOW',1523129606,1523129606),
	(165,70,3,'Опровержение о смерти Махди','Created by MetaNews: Опровержение о смерти Махди',2,'INDUS','POSITIVE','LOW',1523129606,1523129606),
	(166,70,3,'Опровержение о смерти Махди','Created by MetaNews: Опровержение о смерти Махди',8,'INDUS','POSITIVE','LOW',1523129606,1523129606),
	(167,70,3,'Опровержение о смерти Махди','Created by MetaNews: Опровержение о смерти Махди',2,'SERV','POSITIVE','LOW',1523129606,1523129606),
	(168,70,3,'Опровержение о смерти Махди','Created by MetaNews: Опровержение о смерти Махди',8,'SERV','POSITIVE','LOW',1523129606,1523129606),
	(169,70,3,'Гибель Аль-Киндли','Created by MetaNews: Гибель Аль-Киндли',2,'INDUS','NEGATIVE','MEDIUM',1523129642,1523129642),
	(170,70,3,'Гибель Аль-Киндли','Created by MetaNews: Гибель Аль-Киндли',8,'INDUS','NEGATIVE','MEDIUM',1523129642,1523129642),
	(171,79,12,'Уничтожение столичной планеты-логистического узла','Created by MetaNews: Уничтожение столичной планеты-логистического узла',2,'AGRI','NEGATIVE','HIGH',1523129688,1523129688),
	(172,79,12,'Уничтожение столичной планеты-логистического узла','Created by MetaNews: Уничтожение столичной планеты-логистического узла',8,'AGRI','NEGATIVE','HIGH',1523129688,1523129688),
	(173,79,12,'Уничтожение столичной планеты-логистического узла','Created by MetaNews: Уничтожение столичной планеты-логистического узла',2,'INDUS','NEGATIVE','HIGH',1523129688,1523129688),
	(174,79,12,'Уничтожение столичной планеты-логистического узла','Created by MetaNews: Уничтожение столичной планеты-логистического узла',8,'INDUS','NEGATIVE','HIGH',1523129688,1523129688),
	(175,79,12,'Уничтожение столичной планеты-логистического узла','Created by MetaNews: Уничтожение столичной планеты-логистического узла',2,'SERV','NEGATIVE','HIGH',1523129688,1523129688),
	(176,79,12,'Уничтожение столичной планеты-логистического узла','Created by MetaNews: Уничтожение столичной планеты-логистического узла',8,'SERV','NEGATIVE','HIGH',1523129688,1523129688),
	(177,64,3,'Отзыв посольства ССНЭ из СЛЗ','Created by MetaNews: Отзыв посольства ССНЭ из СЛЗ',2,'INDUS','NEGATIVE','LOW',1523129742,1523129742),
	(178,64,3,'Отзыв посольства ССНЭ из СЛЗ','Created by MetaNews: Отзыв посольства ССНЭ из СЛЗ',3,'INDUS','NEGATIVE','LOW',1523129742,1523129742),
	(179,64,3,'Отзыв посольства ССНЭ из СЛЗ','Created by MetaNews: Отзыв посольства ССНЭ из СЛЗ',2,'SERV','NEGATIVE','LOW',1523129742,1523129742),
	(180,64,3,'Отзыв посольства ССНЭ из СЛЗ','Created by MetaNews: Отзыв посольства ССНЭ из СЛЗ',3,'SERV','NEGATIVE','LOW',1523129742,1523129742),
	(181,11,6,'Медийный все, ня','Created by MetaNews: Медийный все, ня',6,'SERV','NEGATIVE','MEDIUM',1523182751,1523182751),
	(182,25,5,'Заключение ССНЭ договоров с котами','Created by MetaNews: Заключение ССНЭ договоров с котами',3,'INDUS','POSITIVE','LOW',1523182841,1523182841),
	(183,25,7,'Заключение ССНЭ договоров с котами','Created by MetaNews: Заключение ССНЭ договоров с котами',6,'INDUS','POSITIVE','MEDIUM',1523182841,1523182841),
	(184,80,6,'Объединение котов','Created by MetaNews: Объединение котов',6,'AGRI','POSITIVE','HIGH',1523182920,1523182920),
	(185,80,6,'Объединение котов','Created by MetaNews: Объединение котов',6,'INDUS','POSITIVE','HIGH',1523182920,1523182920),
	(186,80,6,'Объединение котов','Created by MetaNews: Объединение котов',6,'SERV','POSITIVE','HIGH',1523182920,1523182920);

/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы rates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rates`;

CREATE TABLE `rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_source_currency` int(11) unsigned NOT NULL,
  `fk_target_currency` int(11) unsigned NOT NULL,
  `exchange_rate` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source_key` (`fk_source_currency`),
  KEY `target_key` (`fk_target_currency`),
  CONSTRAINT `source_key` FOREIGN KEY (`fk_source_currency`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `target_key` FOREIGN KEY (`fk_target_currency`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `rates` WRITE;
/*!40000 ALTER TABLE `rates` DISABLE KEYS */;

INSERT INTO `rates` (`id`, `fk_source_currency`, `fk_target_currency`, `exchange_rate`)
VALUES
	(1,1,3,13),
	(2,1,2,15),
	(3,1,4,17),
	(4,1,5,18),
	(8,1,6,1),
	(9,1,1,1);

/*!40000 ALTER TABLE `rates` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы rates_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rates_history`;

CREATE TABLE `rates_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_source_currency` int(11) unsigned NOT NULL,
  `fk_target_currency` int(11) unsigned NOT NULL,
  `exchange_rate` double NOT NULL,
  `tick` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `source_key` (`fk_source_currency`),
  KEY `target_key` (`fk_target_currency`),
  CONSTRAINT `rates_history_ibfk_1` FOREIGN KEY (`fk_source_currency`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rates_history_ibfk_2` FOREIGN KEY (`fk_target_currency`) REFERENCES `currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `key`, `value`)
VALUES
	(1,'lastTick','1');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы stock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_market` int(11) unsigned NOT NULL COMMENT 'Ð’Ð½ÐµÑˆÐ½Ð¸Ð¹ ÐºÐ»ÑŽÑ‡ "Ð‘Ð¸Ñ€Ð¶Ð°"',
  `company_name` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL COMMENT 'ÐšÐ¾Ð»Ð¸Ñ‡ÐµÑÑ‚Ð²Ð¾ Ð°ÐºÑ†Ð¸Ð¹',
  `capitalization` double DEFAULT NULL COMMENT 'ÐšÐ°Ð¿Ð¸Ñ‚Ð°Ð»Ð¸Ð·Ð°Ñ†Ð¸Ñ ÐºÐ°Ð¼Ð¿Ð°Ð½Ð¸Ð¸ Ð¿Ð¾ Ð¸Ñ‚Ð¾Ð³Ð°Ð¼ Ñ‚Ð¾Ñ€Ð³Ð¾Ð²',
  `share_price` double DEFAULT NULL COMMENT 'Ð¦ÐµÐ½Ð° Ð°ÐºÑ†Ð¸Ð¸ Ð¿Ð¾ Ð¸Ñ‚Ð¾Ð³Ð°Ð¼ Ñ‚Ð¾Ñ€Ð³Ð¾Ð²',
  `delta` double DEFAULT NULL,
  `delta_abs` double DEFAULT NULL,
  `initial_share_price` double DEFAULT NULL COMMENT 'Ð£ÑÑ‚Ð°Ð½Ð¾Ð²Ð¾Ñ‡Ð½Ð°Ñ Ñ†ÐµÐ½Ð° Ð°ÐºÑ†Ð¸Ð¸',
  `initial_capitalization` double DEFAULT NULL COMMENT 'Ð£ÑÑ‚Ð°Ð½Ð¾Ð²Ð¾Ñ‡Ð½Ð°Ñ ÐºÐ°Ð¿Ð¸Ñ‚Ð°Ð»Ð¸Ð·Ð°Ñ†Ð¸Ñ',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `behavior` enum('GROWTH','FALLING') DEFAULT NULL,
  `sector` enum('AGRI','INDUS','SERV') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_id_uindex` (`id`),
  KEY `stock_markets_id_fk` (`fk_market`),
  KEY `cap` (`capitalization`),
  CONSTRAINT `stock_markets_id_fk` FOREIGN KEY (`fk_market`) REFERENCES `markets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;

INSERT INTO `stock` (`id`, `fk_market`, `company_name`, `amount`, `capitalization`, `share_price`, `delta`, `delta_abs`, `initial_share_price`, `initial_capitalization`, `created_at`, `updated_at`, `behavior`, `sector`)
VALUES
	(2,9,'ХДР Ресурсес',25000,130000003072,5200000,0,0,5200000,130000003072,1522621127,1522621160,NULL,'INDUS'),
	(3,9,'АС Банк',25000,110500003840,4420000,0,0,4420000,110500003840,1522621233,1522621233,NULL,'SERV'),
	(4,3,'Магсофт',25000,98800001024,3952000,0,0,3952000,98800001024,1522621279,1522621279,NULL,'SERV'),
	(5,3,'Магфон',25000,92300001280,3692000,0,0,3692000,92300001280,1522621344,1522621344,NULL,'SERV'),
	(6,3,'Нексус гравитранспорт',25000,88400003072,3536000,0,0,3536000,88400003072,1522621376,1522621376,NULL,'INDUS'),
	(7,2,'Северной турагенство',2500,285000007680,114000000,0,0,114000000,285000007680,1522621511,1522621511,NULL,'INDUS'),
	(8,2,'МДМ Лимитед',4000,255000002560,63750000,0,0,63750000,255000002560,1522621546,1522621546,NULL,'SERV'),
	(9,2,'НСК',22000,240000008192,10909100,0,0,10909100,240000008192,1522621570,1522621570,NULL,'INDUS'),
	(10,8,'Северное торговое общество',3000,224999997440,75000000,0,0,75000000,224999997440,1522621612,1522621612,NULL,'SERV'),
	(11,8,'Черный консалтинг',18000,210000003072,11666700,0,0,11666700,210000003072,1522621652,1522621681,NULL,'INDUS'),
	(12,2,'Магасофт',150000,210000003072,1400000,0,0,1400000,210000003072,1522621709,1522621709,NULL,'SERV'),
	(13,2,'Твердые Металические Детали',15000,149999992832,10000000,0,0,10000000,149999992832,1522621749,1522621749,NULL,'INDUS'),
	(14,2,'Новые горизонты',210000,134999998464,642857,0,0,642857,134999998464,1522621786,1522621786,NULL,'INDUS'),
	(15,7,'Трисл Транс Биолоджик',10000,89999998976,9000000,0,0,9000000,89999998976,1522621822,1522621822,NULL,'SERV'),
	(16,7,'Акваформ',15000,57600000000,3840000,0,0,3840000,57600000000,1522621851,1522621851,NULL,'INDUS'),
	(17,7,'Генезис Технолоджис',8000,44999999488,5625000,0,0,5625000,44999999488,1522621876,1522621876,NULL,'SERV'),
	(18,7,'Горное торговое общество',15000,32399998976,2160000,0,0,2160000,32399998976,1522621900,1522621900,NULL,'INDUS'),
	(19,7,'Юнайтед Фермерс',15000,21600000000,1440000,0,0,1440000,21600000000,1522621922,1522621922,NULL,'AGRI'),
	(20,6,'Новая торговая компания',200000,12999999488,65000,0,0,65000,12999999488,1522621960,1522621960,NULL,'SERV'),
	(21,6,'Коткон',50000,10000000000,200000,0,0,200000,10000000000,1522621985,1522621985,NULL,'INDUS'),
	(22,6,'Гуррен Лагган',6000,9600000000,1600000,0,0,1600000,9600000000,1522622020,1522622020,NULL,'INDUS'),
	(23,6,'М-Аналитика',1000,7000000000,7000000,0,0,7000000,7000000000,1522622043,1522622043,NULL,'SERV'),
	(24,5,'Нова электрикс',10000,985999998976,98600000,0,0,98600000,985999998976,1522622104,1522622104,NULL,'INDUS'),
	(25,5,'Спейсшип детэйлс',100000,884000030720,8840000,0,0,8840000,884000030720,1522622140,1522622140,NULL,'INDUS'),
	(26,5,'Нова импорт',25000,697000001536,27880000,0,0,27880000,697000001536,1522622162,1522622162,NULL,'SERV');

/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;


# Дамп таблицы stock_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock_history`;

CREATE TABLE `stock_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_stock` int(11) unsigned NOT NULL,
  `tickId` int(11) NOT NULL,
  `capitalization` double DEFAULT NULL,
  `share_price` double NOT NULL,
  `delta` double NOT NULL,
  `delta_abs` double DEFAULT NULL,
  `behavior` enum('GROWTH','FALLING') NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_history_id_uindex` (`id`),
  KEY `stock_history_stock_id_fk` (`fk_stock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





# Replace placeholder table for markets_growth with correct view syntax
# ------------------------------------------------------------

DROP TABLE `markets_growth`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `markets_growth`
AS SELECT
   `m`.`market_short_name` AS `currency_short_name`,
   `s`.`behavior` AS `behavior`,sum(`s`.`delta_abs`) AS `market_delta`
FROM ((`stock` `s` left join `markets` `m` on((`s`.`fk_market` = `m`.`id`))) left join `currencies` `c` on((`m`.`fk_currency` = `c`.`id`))) where (`s`.`behavior` = 'GROWTH') group by `m`.`market_short_name`,`s`.`behavior`;


# Replace placeholder table for currency_union with correct view syntax
# ------------------------------------------------------------

DROP TABLE `currency_union`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `currency_union`
AS SELECT
   `T1`.`currency_short_name` AS `currency_short_name`,
   `T1`.`market_delta` AS `delta1`,
   `T2`.`market_delta` AS `delta2`
FROM (`currency_growth` `T1` left join `currency_falling` `T2` on((`T1`.`currency_short_name` = `T2`.`currency_short_name`))) union select if(`T1`.`currency_short_name`,`T1`.`currency_short_name`,`T2`.`currency_short_name`) AS `currency_short_name`,`T1`.`market_delta` AS `delta1`,`T2`.`market_delta` AS `delta2` from (`currency_falling` `T2` left join `currency_growth` `T1` on((`T1`.`currency_short_name` = `T2`.`currency_short_name`)));


# Replace placeholder table for currency_growth with correct view syntax
# ------------------------------------------------------------

DROP TABLE `currency_growth`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `currency_growth`
AS SELECT
   `c`.`currency_short_name` AS `currency_short_name`,
   `s`.`behavior` AS `behavior`,sum(`s`.`delta_abs`) AS `market_delta`
FROM ((`stock` `s` left join `markets` `m` on((`s`.`fk_market` = `m`.`id`))) left join `currencies` `c` on((`m`.`fk_currency` = `c`.`id`))) where (`s`.`behavior` = 'GROWTH') group by `c`.`currency_short_name`,`s`.`behavior`;


# Replace placeholder table for currency_delta with correct view syntax
# ------------------------------------------------------------

DROP TABLE `currency_delta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `currency_delta`
AS SELECT
   `currency_union`.`currency_short_name` AS `currency`,if((`currency_union`.`delta2` + `currency_union`.`delta1`),(`currency_union`.`delta2` + `currency_union`.`delta1`),if(`currency_union`.`delta2`,
   `currency_union`.`delta2`,if(`currency_union`.`delta1`,
   `currency_union`.`delta1`,0))) AS `delta`
FROM `currency_union`;


# Replace placeholder table for markets_delta with correct view syntax
# ------------------------------------------------------------

DROP TABLE `markets_delta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `markets_delta`
AS SELECT
   `markets_union`.`currency_short_name` AS `market`,if((`markets_union`.`delta2` + `markets_union`.`delta1`),(`markets_union`.`delta2` + `markets_union`.`delta1`),if(`markets_union`.`delta2`,
   `markets_union`.`delta2`,if(`markets_union`.`delta1`,
   `markets_union`.`delta1`,0))) AS `delta`
FROM `markets_union`;


# Replace placeholder table for markets_union with correct view syntax
# ------------------------------------------------------------

DROP TABLE `markets_union`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `markets_union`
AS SELECT
   `T1`.`currency_short_name` AS `currency_short_name`,
   `T1`.`market_delta` AS `delta1`,
   `T2`.`market_delta` AS `delta2`
FROM (`markets_growth` `T1` left join `markets_falling` `T2` on((`T1`.`currency_short_name` = `T2`.`currency_short_name`))) union select if(`T1`.`currency_short_name`,`T1`.`currency_short_name`,`T2`.`currency_short_name`) AS `currency_short_name`,`T1`.`market_delta` AS `delta1`,`T2`.`market_delta` AS `delta2` from (`markets_falling` `T2` left join `markets_growth` `T1` on((`T1`.`currency_short_name` = `T2`.`currency_short_name`)));


# Replace placeholder table for currency_falling with correct view syntax
# ------------------------------------------------------------

DROP TABLE `currency_falling`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `currency_falling`
AS SELECT
   `c`.`currency_short_name` AS `currency_short_name`,
   `s`.`behavior` AS `behavior`,sum(`s`.`delta_abs`) AS `market_delta`
FROM ((`stock` `s` left join `markets` `m` on((`s`.`fk_market` = `m`.`id`))) left join `currencies` `c` on((`m`.`fk_currency` = `c`.`id`))) where (`s`.`behavior` = 'FALLING') group by `c`.`currency_short_name`,`s`.`behavior`;


# Replace placeholder table for markets_falling with correct view syntax
# ------------------------------------------------------------

DROP TABLE `markets_falling`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `markets_falling`
AS SELECT
   `m`.`market_short_name` AS `currency_short_name`,
   `s`.`behavior` AS `behavior`,sum(`s`.`delta_abs`) AS `market_delta`
FROM ((`stock` `s` left join `markets` `m` on((`s`.`fk_market` = `m`.`id`))) left join `currencies` `c` on((`m`.`fk_currency` = `c`.`id`))) where (`s`.`behavior` = 'FALLING') group by `m`.`market_short_name`,`s`.`behavior`;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
