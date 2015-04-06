--
-- Table structure for table `pk_sc_user_like`
--

CREATE TABLE IF NOT EXISTS `pk_sc_user_like` (
  `like_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `reference_type` varchar(45) DEFAULT NULL,
  `reference_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`like_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
