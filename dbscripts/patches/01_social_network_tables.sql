/*Table structure for table `pk_sc_user_activities` */

CREATE TABLE IF NOT EXISTS `pk_sc_user_activities` (
  `sc_user_activity_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Reference to users.ID',
  `type` varchar(100) DEFAULT NULL,
  `object_id` bigint(20) DEFAULT NULL,
  `activity_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sc_user_activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pk_sc_user_activities` */

/*Table structure for table `pk_sc_user_friends` */

CREATE TABLE IF NOT EXISTS `pk_sc_user_friends` (
  `sc_user_friend_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL COMMENT 'Reference to users.ID',
  `friend_id` bigint(20) NOT NULL COMMENT 'Reference to users.ID',
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sc_user_friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pk_sc_user_friends` */

/*Table structure for table `pk_sc_user_groups` */

CREATE TABLE IF NOT EXISTS `pk_sc_user_groups` (
  `sc_user_groups_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL COMMENT 'Reference to users.ID',
  `group_id` bigint(20) unsigned NOT NULL COMMENT 'Reference to terms.term_id',
  PRIMARY KEY (`sc_user_groups_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pk_sc_user_groups` */

/*Table structure for table `pk_sc_user_photos` */

CREATE TABLE IF NOT EXISTS `pk_sc_user_photos` (
  `sc_user_photo_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL COMMENT 'Reference to users.ID',
  `name` varchar(150) DEFAULT NULL,
  `path` varchar(250) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`sc_user_photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pk_sc_user_photos` */
