--
-- Table structure for table `pk_sc_user_messages`
--

CREATE TABLE IF NOT EXISTS `pk_sc_user_messages` (
  `message_id` int(10) NOT NULL AUTO_INCREMENT,
  `sender_id` int(20) DEFAULT NULL,
  `receiver_id` int(20) DEFAULT NULL,
  `sender_name` varchar(45) DEFAULT NULL,
  `receiver_name` varchar(45) DEFAULT NULL,
  `message` varchar(1024) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `is_deleted` boolean DEFAULT false,
  `status` tinyint(1) DEFAULT '0' COMMENT '0: unread, 1: read',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;