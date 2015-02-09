/*Table structure for table `pk_lb_products` */

CREATE TABLE IF NOT EXISTS `pk_lb_products` (
  `lb_product_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(150) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `length` double DEFAULT NULL,
  `width` double DEFAULT NULL,
  `area` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '1: deposited, 2: sold, 3: unsold',
  `lb_project_id` bigint(20) unsigned DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`lb_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `pk_lb_projects` */

CREATE TABLE IF NOT EXISTS `pk_lb_projects` (
  `lb_project_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '1: sold, 2: selling, 3: unsold',
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`lb_project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
