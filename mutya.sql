# MySQL-Front 3.2  (Build 10.6)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40111 SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT */;

/*!40101 SET NAMES latin1 */;
/*!40103 SET TIME_ZONE='SYSTEM' */;
SET AUTOCOMMIT=0;
BEGIN;

# Host: localhost    Database: mutya
# ------------------------------------------------------
# Server version 5.0.19-nt

#
# Table structure for table admin
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL auto_increment,
  `username` varchar(12) default NULL,
  `password` varchar(12) default NULL,
  PRIMARY KEY  (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table admin
#

INSERT INTO `admin` VALUES (2,'zaldy','secret');
INSERT INTO `admin` VALUES (3,'bbcs','secrets');


#
# Table structure for table computation
#

DROP TABLE IF EXISTS `computation`;
CREATE TABLE `computation` (
  `computation_id` int(11) NOT NULL auto_increment,
  `computation` varchar(11) default NULL,
  `info` varchar(30) default NULL,
  PRIMARY KEY  (`computation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table computation
#

INSERT INTO `computation` VALUES (1,'rank','compute result by ranking');
INSERT INTO `computation` VALUES (2,'average','compute result by average');
INSERT INTO `computation` VALUES (3,'percentage','compute result by weighted avg');


#
# Table structure for table contestants
#

DROP TABLE IF EXISTS `contestants`;
CREATE TABLE `contestants` (
  `contestant_id` int(11) NOT NULL auto_increment,
  `contestant_num` int(11) default NULL,
  `firstname` varchar(30) default NULL,
  `lastname` varchar(30) default NULL,
  `middlename` varchar(20) default NULL,
  `birthdate` date default NULL,
  `municipality` varchar(30) default NULL,
  `address` varchar(30) default NULL,
  `finalist` int(11) default '0',
  `photo1` varchar(20) default NULL,
  `photo2` varchar(20) default NULL,
  `photo3` varchar(20) default NULL,
  `photo4` varchar(20) default NULL,
  `photo5` varchar(20) default NULL,
  PRIMARY KEY  (`contestant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table contestants
#

INSERT INTO `contestants` VALUES (1,1,'Jelith','De Jesus',NULL,NULL,'Almagro',NULL,1,'cons1',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (2,2,'Jonna Valle','Samson',NULL,NULL,'Calbayog',NULL,0,'cons2',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (3,3,'Migzy Lou Arian','Quintos',NULL,NULL,'Calbiga',NULL,0,'cons3',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (4,4,'Divine','Yangzon',NULL,NULL,'Catblogan',NULL,1,'cons4',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (5,5,'Adona April Mary','Figer',NULL,NULL,'Gandara',NULL,0,'cons5',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (6,6,'Maricar','Abanag',NULL,NULL,'Hinabangan',NULL,0,'cons6',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (7,7,'Carissa','Lobigas',NULL,NULL,'Jiabong',NULL,0,'cons7',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (8,8,'Ma. Loriza','Obregon',NULL,NULL,'Matuguinao',NULL,0,'cons8',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (9,9,'Mylene','Orabeles',NULL,NULL,'Paranas',NULL,0,'cons9',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (10,10,'Phoebe Catherine','Geroy',NULL,NULL,'Pinabacdao',NULL,0,'cons10',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (11,11,'Ester','Repol',NULL,NULL,'Sta. Rita',NULL,1,'cons11',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (12,12,'Ma. Carina Rosita','Angel',NULL,NULL,'Talalora',NULL,0,'cons12',NULL,NULL,NULL,NULL);
INSERT INTO `contestants` VALUES (13,13,'Reena Angelique','Española',NULL,NULL,'Tarangnan',NULL,0,'cons13',NULL,NULL,NULL,NULL);


#
# Table structure for table criteria_flag
#

DROP TABLE IF EXISTS `criteria_flag`;
CREATE TABLE `criteria_flag` (
  `active_id` int(11) NOT NULL auto_increment,
  `used_id` int(11) default NULL,
  `criteria_id` int(11) default NULL,
  `status_id` int(11) default NULL,
  `active_cons` int(11) default NULL,
  PRIMARY KEY  (`active_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table criteria_flag
#

INSERT INTO `criteria_flag` VALUES (1,1,2,2,1);


#
# Table structure for table criteria_table_used
#

DROP TABLE IF EXISTS `criteria_table_used`;
CREATE TABLE `criteria_table_used` (
  `used_id` int(11) NOT NULL auto_increment,
  `table_name` varchar(20) default NULL,
  PRIMARY KEY  (`used_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table criteria_table_used
#

INSERT INTO `criteria_table_used` VALUES (1,'pre_criteria');
INSERT INTO `criteria_table_used` VALUES (2,'semi_criteria');
INSERT INTO `criteria_table_used` VALUES (3,'final_criteria');


#
# Table structure for table final_criteria
#

DROP TABLE IF EXISTS `final_criteria`;
CREATE TABLE `final_criteria` (
  `criteria_id` int(11) NOT NULL auto_increment,
  `criteria_name` varchar(30) default NULL,
  `criteria_perc` int(11) default NULL,
  `start_flag` int(11) default NULL,
  `end_flag` int(11) default NULL,
  `info` varchar(20) default NULL,
  PRIMARY KEY  (`criteria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table final_criteria
#

INSERT INTO `final_criteria` VALUES (1,'Question and Answer',NULL,NULL,NULL,'Question and Answer');
INSERT INTO `final_criteria` VALUES (2,'Final Impression',NULL,NULL,NULL,'Personality & Beauty');


#
# Table structure for table final_scores
#

DROP TABLE IF EXISTS `final_scores`;
CREATE TABLE `final_scores` (
  `score_id` int(11) NOT NULL auto_increment,
  `judge_id` int(11) default NULL,
  `contestant_id` int(11) default NULL,
  `criteria_id` int(11) default NULL,
  `rating` float(11,2) default '0.00',
  PRIMARY KEY  (`score_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table final_scores
#

INSERT INTO `final_scores` VALUES (1,1,1,1,0);
INSERT INTO `final_scores` VALUES (2,1,1,2,0);
INSERT INTO `final_scores` VALUES (3,1,2,1,0);
INSERT INTO `final_scores` VALUES (4,1,2,2,0);
INSERT INTO `final_scores` VALUES (5,1,3,1,0);
INSERT INTO `final_scores` VALUES (6,1,3,2,0);
INSERT INTO `final_scores` VALUES (7,1,4,1,0);
INSERT INTO `final_scores` VALUES (8,1,4,2,0);
INSERT INTO `final_scores` VALUES (9,1,5,1,0);
INSERT INTO `final_scores` VALUES (10,1,5,2,0);
INSERT INTO `final_scores` VALUES (11,1,6,1,0);
INSERT INTO `final_scores` VALUES (12,1,6,2,0);
INSERT INTO `final_scores` VALUES (13,1,7,1,0);
INSERT INTO `final_scores` VALUES (14,1,7,2,0);
INSERT INTO `final_scores` VALUES (15,1,8,1,0);
INSERT INTO `final_scores` VALUES (16,1,8,2,0);
INSERT INTO `final_scores` VALUES (17,1,9,1,0);
INSERT INTO `final_scores` VALUES (18,1,9,2,0);
INSERT INTO `final_scores` VALUES (19,1,10,1,0);
INSERT INTO `final_scores` VALUES (20,1,10,2,0);
INSERT INTO `final_scores` VALUES (21,1,11,1,0);
INSERT INTO `final_scores` VALUES (22,1,11,2,0);
INSERT INTO `final_scores` VALUES (23,1,12,1,0);
INSERT INTO `final_scores` VALUES (24,1,12,2,0);
INSERT INTO `final_scores` VALUES (25,1,13,1,0);
INSERT INTO `final_scores` VALUES (26,1,13,2,0);
INSERT INTO `final_scores` VALUES (29,2,1,1,0);
INSERT INTO `final_scores` VALUES (30,2,1,2,0);
INSERT INTO `final_scores` VALUES (31,2,2,1,0);
INSERT INTO `final_scores` VALUES (32,2,2,2,0);
INSERT INTO `final_scores` VALUES (33,2,3,1,0);
INSERT INTO `final_scores` VALUES (34,2,3,2,0);
INSERT INTO `final_scores` VALUES (35,2,4,1,0);
INSERT INTO `final_scores` VALUES (36,2,4,2,0);
INSERT INTO `final_scores` VALUES (37,2,5,1,0);
INSERT INTO `final_scores` VALUES (38,2,5,2,0);
INSERT INTO `final_scores` VALUES (39,2,6,1,0);
INSERT INTO `final_scores` VALUES (40,2,6,2,0);
INSERT INTO `final_scores` VALUES (41,2,7,1,0);
INSERT INTO `final_scores` VALUES (42,2,7,2,0);
INSERT INTO `final_scores` VALUES (43,2,8,1,0);
INSERT INTO `final_scores` VALUES (44,2,8,2,0);
INSERT INTO `final_scores` VALUES (45,2,9,1,0);
INSERT INTO `final_scores` VALUES (46,2,9,2,0);
INSERT INTO `final_scores` VALUES (47,2,10,1,0);
INSERT INTO `final_scores` VALUES (48,2,10,2,0);
INSERT INTO `final_scores` VALUES (49,2,11,1,0);
INSERT INTO `final_scores` VALUES (50,2,11,2,0);
INSERT INTO `final_scores` VALUES (51,2,12,1,0);
INSERT INTO `final_scores` VALUES (52,2,12,2,0);
INSERT INTO `final_scores` VALUES (53,2,13,1,0);
INSERT INTO `final_scores` VALUES (54,2,13,2,0);
INSERT INTO `final_scores` VALUES (57,3,1,1,0);
INSERT INTO `final_scores` VALUES (58,3,1,2,0);
INSERT INTO `final_scores` VALUES (59,3,2,1,0);
INSERT INTO `final_scores` VALUES (60,3,2,2,0);
INSERT INTO `final_scores` VALUES (61,3,3,1,0);
INSERT INTO `final_scores` VALUES (62,3,3,2,0);
INSERT INTO `final_scores` VALUES (63,3,4,1,0);
INSERT INTO `final_scores` VALUES (64,3,4,2,0);
INSERT INTO `final_scores` VALUES (65,3,5,1,0);
INSERT INTO `final_scores` VALUES (66,3,5,2,0);
INSERT INTO `final_scores` VALUES (67,3,6,1,0);
INSERT INTO `final_scores` VALUES (68,3,6,2,0);
INSERT INTO `final_scores` VALUES (69,3,7,1,0);
INSERT INTO `final_scores` VALUES (70,3,7,2,0);
INSERT INTO `final_scores` VALUES (71,3,8,1,0);
INSERT INTO `final_scores` VALUES (72,3,8,2,0);
INSERT INTO `final_scores` VALUES (73,3,9,1,0);
INSERT INTO `final_scores` VALUES (74,3,9,2,0);
INSERT INTO `final_scores` VALUES (75,3,10,1,0);
INSERT INTO `final_scores` VALUES (76,3,10,2,0);
INSERT INTO `final_scores` VALUES (77,3,11,1,0);
INSERT INTO `final_scores` VALUES (78,3,11,2,0);
INSERT INTO `final_scores` VALUES (79,3,12,1,0);
INSERT INTO `final_scores` VALUES (80,3,12,2,0);
INSERT INTO `final_scores` VALUES (81,3,13,1,0);
INSERT INTO `final_scores` VALUES (82,3,13,2,0);
INSERT INTO `final_scores` VALUES (85,4,1,1,0);
INSERT INTO `final_scores` VALUES (86,4,1,2,0);
INSERT INTO `final_scores` VALUES (87,4,2,1,0);
INSERT INTO `final_scores` VALUES (88,4,2,2,0);
INSERT INTO `final_scores` VALUES (89,4,3,1,0);
INSERT INTO `final_scores` VALUES (90,4,3,2,0);
INSERT INTO `final_scores` VALUES (91,4,4,1,0);
INSERT INTO `final_scores` VALUES (92,4,4,2,0);
INSERT INTO `final_scores` VALUES (93,4,5,1,0);
INSERT INTO `final_scores` VALUES (94,4,5,2,0);
INSERT INTO `final_scores` VALUES (95,4,6,1,0);
INSERT INTO `final_scores` VALUES (96,4,6,2,0);
INSERT INTO `final_scores` VALUES (97,4,7,1,0);
INSERT INTO `final_scores` VALUES (98,4,7,2,0);
INSERT INTO `final_scores` VALUES (99,4,8,1,0);
INSERT INTO `final_scores` VALUES (100,4,8,2,0);
INSERT INTO `final_scores` VALUES (101,4,9,1,0);
INSERT INTO `final_scores` VALUES (102,4,9,2,0);
INSERT INTO `final_scores` VALUES (103,4,10,1,0);
INSERT INTO `final_scores` VALUES (104,4,10,2,0);
INSERT INTO `final_scores` VALUES (105,4,11,1,0);
INSERT INTO `final_scores` VALUES (106,4,11,2,0);
INSERT INTO `final_scores` VALUES (107,4,12,1,0);
INSERT INTO `final_scores` VALUES (108,4,12,2,0);
INSERT INTO `final_scores` VALUES (109,4,13,1,0);
INSERT INTO `final_scores` VALUES (110,4,13,2,0);
INSERT INTO `final_scores` VALUES (113,5,1,1,0);
INSERT INTO `final_scores` VALUES (114,5,1,2,0);
INSERT INTO `final_scores` VALUES (115,5,2,1,0);
INSERT INTO `final_scores` VALUES (116,5,2,2,0);
INSERT INTO `final_scores` VALUES (117,5,3,1,0);
INSERT INTO `final_scores` VALUES (118,5,3,2,0);
INSERT INTO `final_scores` VALUES (119,5,4,1,0);
INSERT INTO `final_scores` VALUES (120,5,4,2,0);
INSERT INTO `final_scores` VALUES (121,5,5,1,0);
INSERT INTO `final_scores` VALUES (122,5,5,2,0);
INSERT INTO `final_scores` VALUES (123,5,6,1,0);
INSERT INTO `final_scores` VALUES (124,5,6,2,0);
INSERT INTO `final_scores` VALUES (125,5,7,1,0);
INSERT INTO `final_scores` VALUES (126,5,7,2,0);
INSERT INTO `final_scores` VALUES (127,5,8,1,0);
INSERT INTO `final_scores` VALUES (128,5,8,2,0);
INSERT INTO `final_scores` VALUES (129,5,9,1,0);
INSERT INTO `final_scores` VALUES (130,5,9,2,0);
INSERT INTO `final_scores` VALUES (131,5,10,1,0);
INSERT INTO `final_scores` VALUES (132,5,10,2,0);
INSERT INTO `final_scores` VALUES (133,5,11,1,0);
INSERT INTO `final_scores` VALUES (134,5,11,2,0);
INSERT INTO `final_scores` VALUES (135,5,12,1,0);
INSERT INTO `final_scores` VALUES (136,5,12,2,0);
INSERT INTO `final_scores` VALUES (137,5,13,1,0);
INSERT INTO `final_scores` VALUES (138,5,13,2,0);
INSERT INTO `final_scores` VALUES (141,6,1,1,0);
INSERT INTO `final_scores` VALUES (142,6,1,2,0);
INSERT INTO `final_scores` VALUES (143,6,2,1,0);
INSERT INTO `final_scores` VALUES (144,6,2,2,0);
INSERT INTO `final_scores` VALUES (145,6,3,1,0);
INSERT INTO `final_scores` VALUES (146,6,3,2,0);
INSERT INTO `final_scores` VALUES (147,6,4,1,0);
INSERT INTO `final_scores` VALUES (148,6,4,2,0);
INSERT INTO `final_scores` VALUES (149,6,5,1,0);
INSERT INTO `final_scores` VALUES (150,6,5,2,0);
INSERT INTO `final_scores` VALUES (151,6,6,1,0);
INSERT INTO `final_scores` VALUES (152,6,6,2,0);
INSERT INTO `final_scores` VALUES (153,6,7,1,0);
INSERT INTO `final_scores` VALUES (154,6,7,2,0);
INSERT INTO `final_scores` VALUES (155,6,8,1,0);
INSERT INTO `final_scores` VALUES (156,6,8,2,0);
INSERT INTO `final_scores` VALUES (157,6,9,1,0);
INSERT INTO `final_scores` VALUES (158,6,9,2,0);
INSERT INTO `final_scores` VALUES (159,6,10,1,0);
INSERT INTO `final_scores` VALUES (160,6,10,2,0);
INSERT INTO `final_scores` VALUES (161,6,11,1,0);
INSERT INTO `final_scores` VALUES (162,6,11,2,0);
INSERT INTO `final_scores` VALUES (163,6,12,1,0);
INSERT INTO `final_scores` VALUES (164,6,12,2,0);
INSERT INTO `final_scores` VALUES (165,6,13,1,0);
INSERT INTO `final_scores` VALUES (166,6,13,2,0);
INSERT INTO `final_scores` VALUES (169,7,1,1,0);
INSERT INTO `final_scores` VALUES (170,7,1,2,0);
INSERT INTO `final_scores` VALUES (171,7,2,1,0);
INSERT INTO `final_scores` VALUES (172,7,2,2,0);
INSERT INTO `final_scores` VALUES (173,7,3,1,0);
INSERT INTO `final_scores` VALUES (174,7,3,2,0);
INSERT INTO `final_scores` VALUES (175,7,4,1,0);
INSERT INTO `final_scores` VALUES (176,7,4,2,0);
INSERT INTO `final_scores` VALUES (177,7,5,1,0);
INSERT INTO `final_scores` VALUES (178,7,5,2,0);
INSERT INTO `final_scores` VALUES (179,7,6,1,0);
INSERT INTO `final_scores` VALUES (180,7,6,2,0);
INSERT INTO `final_scores` VALUES (181,7,7,1,0);
INSERT INTO `final_scores` VALUES (182,7,7,2,0);
INSERT INTO `final_scores` VALUES (183,7,8,1,0);
INSERT INTO `final_scores` VALUES (184,7,8,2,0);
INSERT INTO `final_scores` VALUES (185,7,9,1,0);
INSERT INTO `final_scores` VALUES (186,7,9,2,0);
INSERT INTO `final_scores` VALUES (187,7,10,1,0);
INSERT INTO `final_scores` VALUES (188,7,10,2,0);
INSERT INTO `final_scores` VALUES (189,7,11,1,0);
INSERT INTO `final_scores` VALUES (190,7,11,2,0);
INSERT INTO `final_scores` VALUES (191,7,12,1,0);
INSERT INTO `final_scores` VALUES (192,7,12,2,0);
INSERT INTO `final_scores` VALUES (193,7,13,1,0);
INSERT INTO `final_scores` VALUES (194,7,13,2,0);


#
# Table structure for table judges
#

DROP TABLE IF EXISTS `judges`;
CREATE TABLE `judges` (
  `judgeid` int(11) NOT NULL auto_increment,
  `account` varchar(11) default NULL,
  `password` varchar(11) default NULL,
  `firstname` varchar(30) default NULL,
  `lastname` varchar(30) default NULL,
  `middlename` varchar(20) default NULL,
  `sex` varchar(8) default NULL,
  `profession` varchar(20) default NULL,
  `company_name` varchar(30) default NULL,
  `company_address` varchar(30) default NULL,
  PRIMARY KEY  (`judgeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table judges
#

INSERT INTO `judges` VALUES (1,'judge1','judge1','judge1','judge1',NULL,'Male',NULL,NULL,NULL);
INSERT INTO `judges` VALUES (2,'judge2','judge2','judge2','judge2',NULL,'Male',NULL,NULL,NULL);
INSERT INTO `judges` VALUES (3,'judge3','judge3','judge3','judge3',NULL,NULL,NULL,NULL,NULL);
INSERT INTO `judges` VALUES (4,'judge4','judge4','judge4','judge4',NULL,NULL,NULL,NULL,NULL);
INSERT INTO `judges` VALUES (5,'judge5','judge5','judge5','judge5',NULL,NULL,NULL,NULL,NULL);
INSERT INTO `judges` VALUES (6,'judge6','judge6','judge6','judge6',NULL,'Male',NULL,NULL,NULL);
INSERT INTO `judges` VALUES (7,'judge7','judge7','judge7','judge7',NULL,'Male',NULL,NULL,NULL);


#
# Table structure for table messages
#

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL auto_increment,
  `judge_id` int(11) default NULL,
  `message` varchar(50) default NULL,
  `start_flag` int(11) default NULL,
  `end_flag` int(11) default NULL,
  PRIMARY KEY  (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table messages
#



#
# Table structure for table pre_criteria
#

DROP TABLE IF EXISTS `pre_criteria`;
CREATE TABLE `pre_criteria` (
  `criteria_id` int(11) NOT NULL auto_increment,
  `criteria_name` varchar(40) default NULL,
  `criteria_perc` int(11) default NULL,
  `info` varchar(20) default NULL,
  PRIMARY KEY  (`criteria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table pre_criteria
#

INSERT INTO `pre_criteria` VALUES (1,'Interview',NULL,'Table Hopping');
INSERT INTO `pre_criteria` VALUES (2,'Beauty ',NULL,'Close-Up');
INSERT INTO `pre_criteria` VALUES (3,'Stage Decurom',NULL,'Attitude');
INSERT INTO `pre_criteria` VALUES (4,'Swimsuit',NULL,'Outdoor Swimsuit');
INSERT INTO `pre_criteria` VALUES (5,'Fashion',NULL,'rated by lens men');


#
# Table structure for table pre_scores
#

DROP TABLE IF EXISTS `pre_scores`;
CREATE TABLE `pre_scores` (
  `score_id` int(11) NOT NULL auto_increment,
  `contestant_id` int(11) default NULL,
  `criteria_id` int(11) default NULL,
  `rating` float(11,2) default '0.00',
  PRIMARY KEY  (`score_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table pre_scores
#

INSERT INTO `pre_scores` VALUES (1,1,1,84);
INSERT INTO `pre_scores` VALUES (2,1,2,98);
INSERT INTO `pre_scores` VALUES (3,1,3,94);
INSERT INTO `pre_scores` VALUES (4,1,4,84);
INSERT INTO `pre_scores` VALUES (5,1,5,86);
INSERT INTO `pre_scores` VALUES (6,2,1,0);
INSERT INTO `pre_scores` VALUES (7,2,2,95);
INSERT INTO `pre_scores` VALUES (8,2,3,0);
INSERT INTO `pre_scores` VALUES (9,2,4,0);
INSERT INTO `pre_scores` VALUES (10,2,5,6);
INSERT INTO `pre_scores` VALUES (11,3,1,85);
INSERT INTO `pre_scores` VALUES (12,3,2,90);
INSERT INTO `pre_scores` VALUES (13,3,3,91);
INSERT INTO `pre_scores` VALUES (14,3,4,87);
INSERT INTO `pre_scores` VALUES (15,3,5,86);
INSERT INTO `pre_scores` VALUES (16,4,1,0);
INSERT INTO `pre_scores` VALUES (17,4,2,87);
INSERT INTO `pre_scores` VALUES (18,4,3,0);
INSERT INTO `pre_scores` VALUES (19,4,4,0);
INSERT INTO `pre_scores` VALUES (20,4,5,80);
INSERT INTO `pre_scores` VALUES (21,5,1,0);
INSERT INTO `pre_scores` VALUES (22,5,2,0);
INSERT INTO `pre_scores` VALUES (23,5,3,0);
INSERT INTO `pre_scores` VALUES (24,5,4,0);
INSERT INTO `pre_scores` VALUES (25,5,5,0);
INSERT INTO `pre_scores` VALUES (26,6,1,0);
INSERT INTO `pre_scores` VALUES (27,6,2,0);
INSERT INTO `pre_scores` VALUES (28,6,3,0);
INSERT INTO `pre_scores` VALUES (29,6,4,0);
INSERT INTO `pre_scores` VALUES (30,6,5,0);
INSERT INTO `pre_scores` VALUES (31,7,1,0);
INSERT INTO `pre_scores` VALUES (32,7,2,0);
INSERT INTO `pre_scores` VALUES (33,7,3,0);
INSERT INTO `pre_scores` VALUES (34,7,4,0);
INSERT INTO `pre_scores` VALUES (35,7,5,0);
INSERT INTO `pre_scores` VALUES (36,8,1,0);
INSERT INTO `pre_scores` VALUES (37,8,2,0);
INSERT INTO `pre_scores` VALUES (38,8,3,0);
INSERT INTO `pre_scores` VALUES (39,8,4,0);
INSERT INTO `pre_scores` VALUES (40,8,5,0);
INSERT INTO `pre_scores` VALUES (41,9,1,0);
INSERT INTO `pre_scores` VALUES (42,9,2,0);
INSERT INTO `pre_scores` VALUES (43,9,3,0);
INSERT INTO `pre_scores` VALUES (44,9,4,0);
INSERT INTO `pre_scores` VALUES (45,9,5,0);
INSERT INTO `pre_scores` VALUES (46,10,1,0);
INSERT INTO `pre_scores` VALUES (47,10,2,0);
INSERT INTO `pre_scores` VALUES (48,10,3,0);
INSERT INTO `pre_scores` VALUES (49,10,4,0);
INSERT INTO `pre_scores` VALUES (50,10,5,0);
INSERT INTO `pre_scores` VALUES (51,11,1,0);
INSERT INTO `pre_scores` VALUES (52,11,2,0);
INSERT INTO `pre_scores` VALUES (53,11,3,0);
INSERT INTO `pre_scores` VALUES (54,11,4,0);
INSERT INTO `pre_scores` VALUES (55,11,5,0);
INSERT INTO `pre_scores` VALUES (56,12,1,0);
INSERT INTO `pre_scores` VALUES (57,12,2,0);
INSERT INTO `pre_scores` VALUES (58,12,3,0);
INSERT INTO `pre_scores` VALUES (59,12,4,0);
INSERT INTO `pre_scores` VALUES (60,12,5,0);
INSERT INTO `pre_scores` VALUES (61,13,1,0);
INSERT INTO `pre_scores` VALUES (62,13,2,0);
INSERT INTO `pre_scores` VALUES (63,13,3,0);
INSERT INTO `pre_scores` VALUES (64,13,4,0);
INSERT INTO `pre_scores` VALUES (65,13,5,0);


#
# Table structure for table semi_criteria
#

DROP TABLE IF EXISTS `semi_criteria`;
CREATE TABLE `semi_criteria` (
  `criteria_id` int(11) NOT NULL auto_increment,
  `criteria_name` varchar(30) default NULL,
  `criteria_perc` int(11) default NULL,
  `start_flag` int(11) default NULL,
  `end_flag` int(11) default NULL,
  `info` varchar(20) default NULL,
  PRIMARY KEY  (`criteria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table semi_criteria
#

INSERT INTO `semi_criteria` VALUES (1,'Baro\'t Saya',NULL,NULL,NULL,'Baro\'t Saya Competit');
INSERT INTO `semi_criteria` VALUES (2,'Swimsuit',NULL,NULL,NULL,'Swimsuit Competition');
INSERT INTO `semi_criteria` VALUES (3,'Casual Wear',NULL,NULL,NULL,'Casual Wear');
INSERT INTO `semi_criteria` VALUES (4,'Evening Gown',NULL,NULL,NULL,'Evening Gown');


#
# Table structure for table semi_scores
#

DROP TABLE IF EXISTS `semi_scores`;
CREATE TABLE `semi_scores` (
  `score_id` int(11) NOT NULL auto_increment,
  `judge_id` int(11) default NULL,
  `contestant_id` int(11) default NULL,
  `criteria_id` int(11) default NULL,
  `rating` float(11,2) default '0.00',
  PRIMARY KEY  (`score_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table semi_scores
#

INSERT INTO `semi_scores` VALUES (1,1,1,1,0);
INSERT INTO `semi_scores` VALUES (2,1,1,2,80);
INSERT INTO `semi_scores` VALUES (3,1,1,3,0);
INSERT INTO `semi_scores` VALUES (4,1,1,4,0);
INSERT INTO `semi_scores` VALUES (5,1,2,1,0);
INSERT INTO `semi_scores` VALUES (6,1,2,2,90);
INSERT INTO `semi_scores` VALUES (7,1,2,3,0);
INSERT INTO `semi_scores` VALUES (8,1,2,4,0);
INSERT INTO `semi_scores` VALUES (9,1,3,1,0);
INSERT INTO `semi_scores` VALUES (10,1,3,2,99);
INSERT INTO `semi_scores` VALUES (11,1,3,3,0);
INSERT INTO `semi_scores` VALUES (12,1,3,4,0);
INSERT INTO `semi_scores` VALUES (13,1,4,1,0);
INSERT INTO `semi_scores` VALUES (14,1,4,2,100);
INSERT INTO `semi_scores` VALUES (15,1,4,3,0);
INSERT INTO `semi_scores` VALUES (16,1,4,4,0);
INSERT INTO `semi_scores` VALUES (17,1,5,1,0);
INSERT INTO `semi_scores` VALUES (18,1,5,2,0);
INSERT INTO `semi_scores` VALUES (19,1,5,3,0);
INSERT INTO `semi_scores` VALUES (20,1,5,4,0);
INSERT INTO `semi_scores` VALUES (21,1,6,1,0);
INSERT INTO `semi_scores` VALUES (22,1,6,2,0);
INSERT INTO `semi_scores` VALUES (23,1,6,3,0);
INSERT INTO `semi_scores` VALUES (24,1,6,4,0);
INSERT INTO `semi_scores` VALUES (25,1,7,1,0);
INSERT INTO `semi_scores` VALUES (26,1,7,2,0);
INSERT INTO `semi_scores` VALUES (27,1,7,3,0);
INSERT INTO `semi_scores` VALUES (28,1,7,4,0);
INSERT INTO `semi_scores` VALUES (29,1,8,1,0);
INSERT INTO `semi_scores` VALUES (30,1,8,2,0);
INSERT INTO `semi_scores` VALUES (31,1,8,3,0);
INSERT INTO `semi_scores` VALUES (32,1,8,4,0);
INSERT INTO `semi_scores` VALUES (33,1,9,1,0);
INSERT INTO `semi_scores` VALUES (34,1,9,2,0);
INSERT INTO `semi_scores` VALUES (35,1,9,3,0);
INSERT INTO `semi_scores` VALUES (36,1,9,4,0);
INSERT INTO `semi_scores` VALUES (37,1,10,1,0);
INSERT INTO `semi_scores` VALUES (38,1,10,2,0);
INSERT INTO `semi_scores` VALUES (39,1,10,3,0);
INSERT INTO `semi_scores` VALUES (40,1,10,4,0);
INSERT INTO `semi_scores` VALUES (41,1,11,1,0);
INSERT INTO `semi_scores` VALUES (42,1,11,2,0);
INSERT INTO `semi_scores` VALUES (43,1,11,3,0);
INSERT INTO `semi_scores` VALUES (44,1,11,4,0);
INSERT INTO `semi_scores` VALUES (45,1,12,1,0);
INSERT INTO `semi_scores` VALUES (46,1,12,2,0);
INSERT INTO `semi_scores` VALUES (47,1,12,3,0);
INSERT INTO `semi_scores` VALUES (48,1,12,4,0);
INSERT INTO `semi_scores` VALUES (49,1,13,1,0);
INSERT INTO `semi_scores` VALUES (50,1,13,2,0);
INSERT INTO `semi_scores` VALUES (51,1,13,3,0);
INSERT INTO `semi_scores` VALUES (52,1,13,4,0);
INSERT INTO `semi_scores` VALUES (57,2,1,1,0);
INSERT INTO `semi_scores` VALUES (58,2,1,2,98);
INSERT INTO `semi_scores` VALUES (59,2,1,3,0);
INSERT INTO `semi_scores` VALUES (60,2,1,4,0);
INSERT INTO `semi_scores` VALUES (61,2,2,1,0);
INSERT INTO `semi_scores` VALUES (62,2,2,2,85);
INSERT INTO `semi_scores` VALUES (63,2,2,3,0);
INSERT INTO `semi_scores` VALUES (64,2,2,4,0);
INSERT INTO `semi_scores` VALUES (65,2,3,1,0);
INSERT INTO `semi_scores` VALUES (66,2,3,2,87);
INSERT INTO `semi_scores` VALUES (67,2,3,3,0);
INSERT INTO `semi_scores` VALUES (68,2,3,4,0);
INSERT INTO `semi_scores` VALUES (69,2,4,1,0);
INSERT INTO `semi_scores` VALUES (70,2,4,2,91);
INSERT INTO `semi_scores` VALUES (71,2,4,3,0);
INSERT INTO `semi_scores` VALUES (72,2,4,4,0);
INSERT INTO `semi_scores` VALUES (73,2,5,1,0);
INSERT INTO `semi_scores` VALUES (74,2,5,2,100);
INSERT INTO `semi_scores` VALUES (75,2,5,3,0);
INSERT INTO `semi_scores` VALUES (76,2,5,4,0);
INSERT INTO `semi_scores` VALUES (77,2,6,1,0);
INSERT INTO `semi_scores` VALUES (78,2,6,2,0);
INSERT INTO `semi_scores` VALUES (79,2,6,3,0);
INSERT INTO `semi_scores` VALUES (80,2,6,4,0);
INSERT INTO `semi_scores` VALUES (81,2,7,1,0);
INSERT INTO `semi_scores` VALUES (82,2,7,2,0);
INSERT INTO `semi_scores` VALUES (83,2,7,3,0);
INSERT INTO `semi_scores` VALUES (84,2,7,4,0);
INSERT INTO `semi_scores` VALUES (85,2,8,1,0);
INSERT INTO `semi_scores` VALUES (86,2,8,2,0);
INSERT INTO `semi_scores` VALUES (87,2,8,3,0);
INSERT INTO `semi_scores` VALUES (88,2,8,4,0);
INSERT INTO `semi_scores` VALUES (89,2,9,1,0);
INSERT INTO `semi_scores` VALUES (90,2,9,2,0);
INSERT INTO `semi_scores` VALUES (91,2,9,3,0);
INSERT INTO `semi_scores` VALUES (92,2,9,4,0);
INSERT INTO `semi_scores` VALUES (93,2,10,1,0);
INSERT INTO `semi_scores` VALUES (94,2,10,2,0);
INSERT INTO `semi_scores` VALUES (95,2,10,3,0);
INSERT INTO `semi_scores` VALUES (96,2,10,4,0);
INSERT INTO `semi_scores` VALUES (97,2,11,1,0);
INSERT INTO `semi_scores` VALUES (98,2,11,2,0);
INSERT INTO `semi_scores` VALUES (99,2,11,3,0);
INSERT INTO `semi_scores` VALUES (100,2,11,4,0);
INSERT INTO `semi_scores` VALUES (101,2,12,1,0);
INSERT INTO `semi_scores` VALUES (102,2,12,2,0);
INSERT INTO `semi_scores` VALUES (103,2,12,3,0);
INSERT INTO `semi_scores` VALUES (104,2,12,4,0);
INSERT INTO `semi_scores` VALUES (105,2,13,1,0);
INSERT INTO `semi_scores` VALUES (106,2,13,2,0);
INSERT INTO `semi_scores` VALUES (107,2,13,3,0);
INSERT INTO `semi_scores` VALUES (108,2,13,4,0);
INSERT INTO `semi_scores` VALUES (113,3,1,1,0);
INSERT INTO `semi_scores` VALUES (114,3,1,2,0);
INSERT INTO `semi_scores` VALUES (115,3,1,3,0);
INSERT INTO `semi_scores` VALUES (116,3,1,4,0);
INSERT INTO `semi_scores` VALUES (117,3,2,1,0);
INSERT INTO `semi_scores` VALUES (118,3,2,2,0);
INSERT INTO `semi_scores` VALUES (119,3,2,3,0);
INSERT INTO `semi_scores` VALUES (120,3,2,4,0);
INSERT INTO `semi_scores` VALUES (121,3,3,1,0);
INSERT INTO `semi_scores` VALUES (122,3,3,2,0);
INSERT INTO `semi_scores` VALUES (123,3,3,3,0);
INSERT INTO `semi_scores` VALUES (124,3,3,4,0);
INSERT INTO `semi_scores` VALUES (125,3,4,1,0);
INSERT INTO `semi_scores` VALUES (126,3,4,2,0);
INSERT INTO `semi_scores` VALUES (127,3,4,3,0);
INSERT INTO `semi_scores` VALUES (128,3,4,4,0);
INSERT INTO `semi_scores` VALUES (129,3,5,1,0);
INSERT INTO `semi_scores` VALUES (130,3,5,2,0);
INSERT INTO `semi_scores` VALUES (131,3,5,3,0);
INSERT INTO `semi_scores` VALUES (132,3,5,4,0);
INSERT INTO `semi_scores` VALUES (133,3,6,1,0);
INSERT INTO `semi_scores` VALUES (134,3,6,2,0);
INSERT INTO `semi_scores` VALUES (135,3,6,3,0);
INSERT INTO `semi_scores` VALUES (136,3,6,4,0);
INSERT INTO `semi_scores` VALUES (137,3,7,1,0);
INSERT INTO `semi_scores` VALUES (138,3,7,2,0);
INSERT INTO `semi_scores` VALUES (139,3,7,3,0);
INSERT INTO `semi_scores` VALUES (140,3,7,4,0);
INSERT INTO `semi_scores` VALUES (141,3,8,1,0);
INSERT INTO `semi_scores` VALUES (142,3,8,2,0);
INSERT INTO `semi_scores` VALUES (143,3,8,3,0);
INSERT INTO `semi_scores` VALUES (144,3,8,4,0);
INSERT INTO `semi_scores` VALUES (145,3,9,1,0);
INSERT INTO `semi_scores` VALUES (146,3,9,2,0);
INSERT INTO `semi_scores` VALUES (147,3,9,3,0);
INSERT INTO `semi_scores` VALUES (148,3,9,4,0);
INSERT INTO `semi_scores` VALUES (149,3,10,1,0);
INSERT INTO `semi_scores` VALUES (150,3,10,2,0);
INSERT INTO `semi_scores` VALUES (151,3,10,3,0);
INSERT INTO `semi_scores` VALUES (152,3,10,4,0);
INSERT INTO `semi_scores` VALUES (153,3,11,1,0);
INSERT INTO `semi_scores` VALUES (154,3,11,2,0);
INSERT INTO `semi_scores` VALUES (155,3,11,3,0);
INSERT INTO `semi_scores` VALUES (156,3,11,4,0);
INSERT INTO `semi_scores` VALUES (157,3,12,1,0);
INSERT INTO `semi_scores` VALUES (158,3,12,2,0);
INSERT INTO `semi_scores` VALUES (159,3,12,3,0);
INSERT INTO `semi_scores` VALUES (160,3,12,4,0);
INSERT INTO `semi_scores` VALUES (161,3,13,1,0);
INSERT INTO `semi_scores` VALUES (162,3,13,2,0);
INSERT INTO `semi_scores` VALUES (163,3,13,3,0);
INSERT INTO `semi_scores` VALUES (164,3,13,4,0);
INSERT INTO `semi_scores` VALUES (169,4,1,1,0);
INSERT INTO `semi_scores` VALUES (170,4,1,2,0);
INSERT INTO `semi_scores` VALUES (171,4,1,3,0);
INSERT INTO `semi_scores` VALUES (172,4,1,4,0);
INSERT INTO `semi_scores` VALUES (173,4,2,1,0);
INSERT INTO `semi_scores` VALUES (174,4,2,2,0);
INSERT INTO `semi_scores` VALUES (175,4,2,3,0);
INSERT INTO `semi_scores` VALUES (176,4,2,4,0);
INSERT INTO `semi_scores` VALUES (177,4,3,1,0);
INSERT INTO `semi_scores` VALUES (178,4,3,2,0);
INSERT INTO `semi_scores` VALUES (179,4,3,3,0);
INSERT INTO `semi_scores` VALUES (180,4,3,4,0);
INSERT INTO `semi_scores` VALUES (181,4,4,1,0);
INSERT INTO `semi_scores` VALUES (182,4,4,2,0);
INSERT INTO `semi_scores` VALUES (183,4,4,3,0);
INSERT INTO `semi_scores` VALUES (184,4,4,4,0);
INSERT INTO `semi_scores` VALUES (185,4,5,1,0);
INSERT INTO `semi_scores` VALUES (186,4,5,2,0);
INSERT INTO `semi_scores` VALUES (187,4,5,3,0);
INSERT INTO `semi_scores` VALUES (188,4,5,4,0);
INSERT INTO `semi_scores` VALUES (189,4,6,1,0);
INSERT INTO `semi_scores` VALUES (190,4,6,2,0);
INSERT INTO `semi_scores` VALUES (191,4,6,3,0);
INSERT INTO `semi_scores` VALUES (192,4,6,4,0);
INSERT INTO `semi_scores` VALUES (193,4,7,1,0);
INSERT INTO `semi_scores` VALUES (194,4,7,2,0);
INSERT INTO `semi_scores` VALUES (195,4,7,3,0);
INSERT INTO `semi_scores` VALUES (196,4,7,4,0);
INSERT INTO `semi_scores` VALUES (197,4,8,1,0);
INSERT INTO `semi_scores` VALUES (198,4,8,2,0);
INSERT INTO `semi_scores` VALUES (199,4,8,3,0);
INSERT INTO `semi_scores` VALUES (200,4,8,4,0);
INSERT INTO `semi_scores` VALUES (201,4,9,1,0);
INSERT INTO `semi_scores` VALUES (202,4,9,2,0);
INSERT INTO `semi_scores` VALUES (203,4,9,3,0);
INSERT INTO `semi_scores` VALUES (204,4,9,4,0);
INSERT INTO `semi_scores` VALUES (205,4,10,1,0);
INSERT INTO `semi_scores` VALUES (206,4,10,2,0);
INSERT INTO `semi_scores` VALUES (207,4,10,3,0);
INSERT INTO `semi_scores` VALUES (208,4,10,4,0);
INSERT INTO `semi_scores` VALUES (209,4,11,1,0);
INSERT INTO `semi_scores` VALUES (210,4,11,2,0);
INSERT INTO `semi_scores` VALUES (211,4,11,3,0);
INSERT INTO `semi_scores` VALUES (212,4,11,4,0);
INSERT INTO `semi_scores` VALUES (213,4,12,1,0);
INSERT INTO `semi_scores` VALUES (214,4,12,2,0);
INSERT INTO `semi_scores` VALUES (215,4,12,3,0);
INSERT INTO `semi_scores` VALUES (216,4,12,4,0);
INSERT INTO `semi_scores` VALUES (217,4,13,1,0);
INSERT INTO `semi_scores` VALUES (218,4,13,2,0);
INSERT INTO `semi_scores` VALUES (219,4,13,3,0);
INSERT INTO `semi_scores` VALUES (220,4,13,4,0);
INSERT INTO `semi_scores` VALUES (225,5,1,1,0);
INSERT INTO `semi_scores` VALUES (226,5,1,2,0);
INSERT INTO `semi_scores` VALUES (227,5,1,3,0);
INSERT INTO `semi_scores` VALUES (228,5,1,4,0);
INSERT INTO `semi_scores` VALUES (229,5,2,1,0);
INSERT INTO `semi_scores` VALUES (230,5,2,2,0);
INSERT INTO `semi_scores` VALUES (231,5,2,3,0);
INSERT INTO `semi_scores` VALUES (232,5,2,4,0);
INSERT INTO `semi_scores` VALUES (233,5,3,1,0);
INSERT INTO `semi_scores` VALUES (234,5,3,2,0);
INSERT INTO `semi_scores` VALUES (235,5,3,3,0);
INSERT INTO `semi_scores` VALUES (236,5,3,4,0);
INSERT INTO `semi_scores` VALUES (237,5,4,1,0);
INSERT INTO `semi_scores` VALUES (238,5,4,2,0);
INSERT INTO `semi_scores` VALUES (239,5,4,3,0);
INSERT INTO `semi_scores` VALUES (240,5,4,4,0);
INSERT INTO `semi_scores` VALUES (241,5,5,1,0);
INSERT INTO `semi_scores` VALUES (242,5,5,2,0);
INSERT INTO `semi_scores` VALUES (243,5,5,3,0);
INSERT INTO `semi_scores` VALUES (244,5,5,4,0);
INSERT INTO `semi_scores` VALUES (245,5,6,1,0);
INSERT INTO `semi_scores` VALUES (246,5,6,2,0);
INSERT INTO `semi_scores` VALUES (247,5,6,3,0);
INSERT INTO `semi_scores` VALUES (248,5,6,4,0);
INSERT INTO `semi_scores` VALUES (249,5,7,1,0);
INSERT INTO `semi_scores` VALUES (250,5,7,2,0);
INSERT INTO `semi_scores` VALUES (251,5,7,3,0);
INSERT INTO `semi_scores` VALUES (252,5,7,4,0);
INSERT INTO `semi_scores` VALUES (253,5,8,1,0);
INSERT INTO `semi_scores` VALUES (254,5,8,2,0);
INSERT INTO `semi_scores` VALUES (255,5,8,3,0);
INSERT INTO `semi_scores` VALUES (256,5,8,4,0);
INSERT INTO `semi_scores` VALUES (257,5,9,1,0);
INSERT INTO `semi_scores` VALUES (258,5,9,2,0);
INSERT INTO `semi_scores` VALUES (259,5,9,3,0);
INSERT INTO `semi_scores` VALUES (260,5,9,4,0);
INSERT INTO `semi_scores` VALUES (261,5,10,1,0);
INSERT INTO `semi_scores` VALUES (262,5,10,2,0);
INSERT INTO `semi_scores` VALUES (263,5,10,3,0);
INSERT INTO `semi_scores` VALUES (264,5,10,4,0);
INSERT INTO `semi_scores` VALUES (265,5,11,1,0);
INSERT INTO `semi_scores` VALUES (266,5,11,2,0);
INSERT INTO `semi_scores` VALUES (267,5,11,3,0);
INSERT INTO `semi_scores` VALUES (268,5,11,4,0);
INSERT INTO `semi_scores` VALUES (269,5,12,1,0);
INSERT INTO `semi_scores` VALUES (270,5,12,2,0);
INSERT INTO `semi_scores` VALUES (271,5,12,3,0);
INSERT INTO `semi_scores` VALUES (272,5,12,4,0);
INSERT INTO `semi_scores` VALUES (273,5,13,1,0);
INSERT INTO `semi_scores` VALUES (274,5,13,2,0);
INSERT INTO `semi_scores` VALUES (275,5,13,3,0);
INSERT INTO `semi_scores` VALUES (276,5,13,4,0);
INSERT INTO `semi_scores` VALUES (281,6,1,1,0);
INSERT INTO `semi_scores` VALUES (282,6,1,2,0);
INSERT INTO `semi_scores` VALUES (283,6,1,3,0);
INSERT INTO `semi_scores` VALUES (284,6,1,4,0);
INSERT INTO `semi_scores` VALUES (285,6,2,1,0);
INSERT INTO `semi_scores` VALUES (286,6,2,2,0);
INSERT INTO `semi_scores` VALUES (287,6,2,3,0);
INSERT INTO `semi_scores` VALUES (288,6,2,4,0);
INSERT INTO `semi_scores` VALUES (289,6,3,1,0);
INSERT INTO `semi_scores` VALUES (290,6,3,2,0);
INSERT INTO `semi_scores` VALUES (291,6,3,3,0);
INSERT INTO `semi_scores` VALUES (292,6,3,4,0);
INSERT INTO `semi_scores` VALUES (293,6,4,1,0);
INSERT INTO `semi_scores` VALUES (294,6,4,2,0);
INSERT INTO `semi_scores` VALUES (295,6,4,3,0);
INSERT INTO `semi_scores` VALUES (296,6,4,4,0);
INSERT INTO `semi_scores` VALUES (297,6,5,1,0);
INSERT INTO `semi_scores` VALUES (298,6,5,2,0);
INSERT INTO `semi_scores` VALUES (299,6,5,3,0);
INSERT INTO `semi_scores` VALUES (300,6,5,4,0);
INSERT INTO `semi_scores` VALUES (301,6,6,1,0);
INSERT INTO `semi_scores` VALUES (302,6,6,2,0);
INSERT INTO `semi_scores` VALUES (303,6,6,3,0);
INSERT INTO `semi_scores` VALUES (304,6,6,4,0);
INSERT INTO `semi_scores` VALUES (305,6,7,1,0);
INSERT INTO `semi_scores` VALUES (306,6,7,2,0);
INSERT INTO `semi_scores` VALUES (307,6,7,3,0);
INSERT INTO `semi_scores` VALUES (308,6,7,4,0);
INSERT INTO `semi_scores` VALUES (309,6,8,1,0);
INSERT INTO `semi_scores` VALUES (310,6,8,2,0);
INSERT INTO `semi_scores` VALUES (311,6,8,3,0);
INSERT INTO `semi_scores` VALUES (312,6,8,4,0);
INSERT INTO `semi_scores` VALUES (313,6,9,1,0);
INSERT INTO `semi_scores` VALUES (314,6,9,2,0);
INSERT INTO `semi_scores` VALUES (315,6,9,3,0);
INSERT INTO `semi_scores` VALUES (316,6,9,4,0);
INSERT INTO `semi_scores` VALUES (317,6,10,1,0);
INSERT INTO `semi_scores` VALUES (318,6,10,2,0);
INSERT INTO `semi_scores` VALUES (319,6,10,3,0);
INSERT INTO `semi_scores` VALUES (320,6,10,4,0);
INSERT INTO `semi_scores` VALUES (321,6,11,1,0);
INSERT INTO `semi_scores` VALUES (322,6,11,2,0);
INSERT INTO `semi_scores` VALUES (323,6,11,3,0);
INSERT INTO `semi_scores` VALUES (324,6,11,4,0);
INSERT INTO `semi_scores` VALUES (325,6,12,1,0);
INSERT INTO `semi_scores` VALUES (326,6,12,2,0);
INSERT INTO `semi_scores` VALUES (327,6,12,3,0);
INSERT INTO `semi_scores` VALUES (328,6,12,4,0);
INSERT INTO `semi_scores` VALUES (329,6,13,1,0);
INSERT INTO `semi_scores` VALUES (330,6,13,2,0);
INSERT INTO `semi_scores` VALUES (331,6,13,3,0);
INSERT INTO `semi_scores` VALUES (332,6,13,4,0);
INSERT INTO `semi_scores` VALUES (337,7,1,1,0);
INSERT INTO `semi_scores` VALUES (338,7,1,2,0);
INSERT INTO `semi_scores` VALUES (339,7,1,3,0);
INSERT INTO `semi_scores` VALUES (340,7,1,4,0);
INSERT INTO `semi_scores` VALUES (341,7,2,1,0);
INSERT INTO `semi_scores` VALUES (342,7,2,2,0);
INSERT INTO `semi_scores` VALUES (343,7,2,3,0);
INSERT INTO `semi_scores` VALUES (344,7,2,4,0);
INSERT INTO `semi_scores` VALUES (345,7,3,1,0);
INSERT INTO `semi_scores` VALUES (346,7,3,2,0);
INSERT INTO `semi_scores` VALUES (347,7,3,3,0);
INSERT INTO `semi_scores` VALUES (348,7,3,4,0);
INSERT INTO `semi_scores` VALUES (349,7,4,1,0);
INSERT INTO `semi_scores` VALUES (350,7,4,2,0);
INSERT INTO `semi_scores` VALUES (351,7,4,3,0);
INSERT INTO `semi_scores` VALUES (352,7,4,4,0);
INSERT INTO `semi_scores` VALUES (353,7,5,1,0);
INSERT INTO `semi_scores` VALUES (354,7,5,2,0);
INSERT INTO `semi_scores` VALUES (355,7,5,3,0);
INSERT INTO `semi_scores` VALUES (356,7,5,4,0);
INSERT INTO `semi_scores` VALUES (357,7,6,1,0);
INSERT INTO `semi_scores` VALUES (358,7,6,2,0);
INSERT INTO `semi_scores` VALUES (359,7,6,3,0);
INSERT INTO `semi_scores` VALUES (360,7,6,4,0);
INSERT INTO `semi_scores` VALUES (361,7,7,1,0);
INSERT INTO `semi_scores` VALUES (362,7,7,2,0);
INSERT INTO `semi_scores` VALUES (363,7,7,3,0);
INSERT INTO `semi_scores` VALUES (364,7,7,4,0);
INSERT INTO `semi_scores` VALUES (365,7,8,1,0);
INSERT INTO `semi_scores` VALUES (366,7,8,2,0);
INSERT INTO `semi_scores` VALUES (367,7,8,3,0);
INSERT INTO `semi_scores` VALUES (368,7,8,4,0);
INSERT INTO `semi_scores` VALUES (369,7,9,1,0);
INSERT INTO `semi_scores` VALUES (370,7,9,2,0);
INSERT INTO `semi_scores` VALUES (371,7,9,3,0);
INSERT INTO `semi_scores` VALUES (372,7,9,4,0);
INSERT INTO `semi_scores` VALUES (373,7,10,1,0);
INSERT INTO `semi_scores` VALUES (374,7,10,2,0);
INSERT INTO `semi_scores` VALUES (375,7,10,3,0);
INSERT INTO `semi_scores` VALUES (376,7,10,4,0);
INSERT INTO `semi_scores` VALUES (377,7,11,1,0);
INSERT INTO `semi_scores` VALUES (378,7,11,2,0);
INSERT INTO `semi_scores` VALUES (379,7,11,3,0);
INSERT INTO `semi_scores` VALUES (380,7,11,4,0);
INSERT INTO `semi_scores` VALUES (381,7,12,1,0);
INSERT INTO `semi_scores` VALUES (382,7,12,2,0);
INSERT INTO `semi_scores` VALUES (383,7,12,3,0);
INSERT INTO `semi_scores` VALUES (384,7,12,4,0);
INSERT INTO `semi_scores` VALUES (385,7,13,1,0);
INSERT INTO `semi_scores` VALUES (386,7,13,2,0);
INSERT INTO `semi_scores` VALUES (387,7,13,3,0);
INSERT INTO `semi_scores` VALUES (388,7,13,4,0);


#
# Table structure for table settings
#

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL auto_increment,
  `computation_id` int(11) default NULL,
  PRIMARY KEY  (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table settings
#



#
# Table structure for table temp_finalist
#

DROP TABLE IF EXISTS `temp_finalist`;
CREATE TABLE `temp_finalist` (
  `id` int(11) NOT NULL auto_increment,
  `contestant_id` int(11) default NULL,
  `contestant_num` int(11) default NULL,
  `municipality` varchar(50) default NULL,
  `name` varchar(50) default NULL,
  `scores` float(11,2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table temp_finalist
#


COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
