--
-- Table structure for table `pk_sc_user_notification`
--

CREATE TABLE IF NOT EXISTS `pk_sc_user_notification` (
  `notification_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `from_user_id` bigint(20) DEFAULT NULL,
  `notification_type` varchar(45) DEFAULT NULL,
  `notification_status` tinyint(2) DEFAULT NULL,
  `reference_id` int(10) DEFAULT NULL,
  `notification_text` varchar(1024) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
