CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_superman` tinyint(1) DEFAULT '0' COMMENT '是否管理员 0.否 1.是',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `users`(`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_superman`) VALUES 
(1, 'admin', 'admin@163.com', NULL, '$2y$10$OLz7cihokYFEx4rc/YPeHezw9FJWR5C1agT9UZ9B5dD9smYvGG6Ci', 'eF6b9GQCPCpBCstPPyIPRoRR148QcL1nX0ufFnxszyFdPjd4B6kB7n64RduE', '2024-01-24 09:10:23', '2024-01-24 09:10:23', 1);

CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书id',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '书名',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `isbn` varchar(13) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '国际标准书号',
  `stock` int(11) DEFAULT '0' COMMENT '库存数量',
  `description` text COLLATE utf8_unicode_ci COMMENT '书籍简介',
  `cover_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '封面图纸路径',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书表';


CREATE TABLE `borrow_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  `book_id` int(11) DEFAULT '0' COMMENT '图书id',
  `borrow_date` datetime DEFAULT NULL COMMENT '借阅日期',
  `return_date` datetime DEFAULT NULL COMMENT '归还日期',
  `status` tinyint(4) DEFAULT '0' COMMENT '借阅状态 0.未归还   1. 已归还',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='借阅记录表';

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书分类表';