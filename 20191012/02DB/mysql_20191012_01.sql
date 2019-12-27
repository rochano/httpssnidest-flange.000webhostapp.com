CREATE TABLE `user_info` (

  `user_id` varchar(45) NOT NULL,

  `user_name` varchar(45) DEFAULT NULL,

  `password` varchar(45) DEFAULT NULL,

  `full_name` varchar(45) DEFAULT NULL,

  `mobile_phone` varchar(45) DEFAULT NULL,

  `email` varchar(45) DEFAULT NULL,

  `line_id` varchar(45) DEFAULT NULL,

  `create_date` datetime DEFAULT NULL,

  `last_login_date` datetime DEFAULT NULL,

  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `user_credit` (

  `user_id` varchar(45) NOT NULL,

  `credit` int(11) DEFAULT NULL,

  `update_date` datetime DEFAULT NULL,

  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `admin_info` (

  `user_name` varchar(20) NOT NULL,

  `password` varchar(20) DEFAULT NULL,

  PRIMARY KEY (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
