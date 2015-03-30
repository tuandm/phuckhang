DROP TABLE IF EXISTS `pk_user_feed`;
DROP TABLE IF EXISTS `pk_user_status`;

--
-- Table structure for table `pk_sc_user_feed`
--

CREATE TABLE IF NOT EXISTS `pk_sc_user_feed` (
  `feed_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `reference_type` varchar(45) DEFAULT NULL,
  `reference_id` int(10) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`feed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `pk_sc_user_status`
--

CREATE TABLE IF NOT EXISTS `pk_sc_user_status` (
  `status_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `status` varchar(1000) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
