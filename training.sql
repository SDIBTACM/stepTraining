create table `user` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_name` varchar(64) NOT NULL UNIQUE,
	`nick_name` varchar(64),
    `class` varchar(64) NOT NULL default '',
	`registere_time` datetime DEFAULT NULL,
	`identity` tinyint NOT NULL DEFAULT 0,
	`password` varchar(255) NOT NULL,
	`status` tinyint DEFAULT 0 COMMENT '0 is normal, -1 is locked, 1 is deleted',
	`is_update` tinyint DEFAULT 1 COMMENT '1 is will update , 0 is no update',
	`is_show` tinyint DEFAULT 1 COMMENT '1 is will show , 0 is no update',
	primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = 'manager table';

insert into user(`user_name`, `identity`, `password`) value('admin', 1, '$2y$10$wyt3sQdZWIxn/RJxLaPRy.PvxX7t8TdI6ubW/OZSNZIvHyAAeODGe');

CREATE TABLE `user_account` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`origin_oj` varchar(16) NOT NULL,
	`origin_id` varchar(100) NOT NULL,
	primary key(`id`),
	key `user_id` (`user_id`),
	key `origin_id` (`origin_id`),
    unique(`user_id`, `origin_oj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = 'user origin oj account';

CREATE TABLE `category` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(32) DEFAULT NULL,
    `status` tinyint NOT NULL DEFAULT 0 COMMENT '0 is normal, -1 is deleted',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = 'problem categoty';

insert into `category`(`name`) values ('uncategorized');

create table `problem` (
	`id` int(11) AUTO_INCREMENT,
	`origin_oj` varchar(16) NOT NULL COMMENT 'problem origin oj',
	`origin_id` varchar(16) NOT NULL COMMENT 'problem origin id',
	`category_id` int(11) NOT NULL DEFAULT 1 COMMENT '',
	`description` varchar(100) NOT NULL DEFAULT '',
    `status` tinyint NOT NULL DEFAULT 0 COMMENT '0 is normal, -1 is deleted',
	primary key(`id`),
	key `origin_id` (`origin_id`),
	key `origin_oj` (`origin_oj`),
	key `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = 'problem list';

CREATE TABLE `problem_ac_time` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`problem_id` int(11) NOT NULL,
	`ac_time` datetime NOT NULL,
	PRIMARY KEY (`id`),
    key `user_id` (`user_id`),
    key `problem_id` (`problem_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = 'a problem ac time';

CREATE TABLE `student_ac_num` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`catch_time` datetime NOT NULL,
	`origin_oj` varchar(16) NOT NULL,
	`num` int(11),
    PRIMARY KEY (`id`),
    key `user_id` (`user_id`),
    key `origin_oj` (`origin_oj`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = 'a student ac problem num';

CREATE TABLE `plan` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(64) NOT NULL DEFAULT '',
    `status` tinyint NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = 'plan list';

CREATE TABLE `plan_problem` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
    `plan_id` int(11) NOT NULL,
    `problem_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    key `plan_id` (`plan_id`),
    key `problem_id` (`problem_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT = 'problem in plan';

