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
ALTER TABLE `users` 
ADD COLUMN `is_disable` tinyint(1) NULL DEFAULT 0 COMMENT '是否禁用 0.否 1.是' AFTER `is_superman`;

CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书id',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '书名',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `isbn` varchar(13) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '国际标准书号',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存数量',
  `description` text COLLATE utf8_unicode_ci NOT NULL COMMENT '书籍简介',
  `image_id` int(11) DEFAULT '0' COMMENT '封面图纸路径',
  `is_delete` tinyint(2) DEFAULT '0' COMMENT '是否删除 0. 否  1.是',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书表';

INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('文学的魅力', '作者A', 1, '9781234567001', 10, '一本关于文学的书籍', 'path/to/image1.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('科学的未来', '作者B', 2, '9781234567002', 8, '探索科学发展的趋势', 'path/to/image2.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('历史的回响', '作者C', 3, '9781234567003', 6, '历史的重要性和影响', 'path/to/image3.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('技术的变迁', '作者D', 4, '9781234567004', 5, '技术如何改变我们的生活', 'path/to/image4.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('艺术的光辉', '作者E', 5, '9781234567005', 9, '艺术作品背后的故事', 'path/to/image5.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('经济学简史', '作者F', 6, '9781234567006', 12, '一本浅显易懂的经济学书籍', 'path/to/image6.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('哲学的奥秘', '作者G', 7, '9781234567007', 7, '关于哲学问题的讨论', 'path/to/image7.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('医学入门', '作者H', 8, '9781234567008', 15, '医学初学者的指导书', 'path/to/image8.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('心理学探索', '作者I', 9, '9781234567009', 20, '心理学领域的入门书籍', 'path/to/image9.jpg', NULL);
INSERT INTO `book`( `title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`) VALUES ('计算机科学导论', '作者J', 10, '9781234567010', 10, '计算机科学基础知识', 'path/to/image10.jpg', NULL);


-- 1. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('The Great Gatsby', 'F. Scott Fitzgerald', 1, '9780743273565', 10, 'A classic novel about the American Dream.', '/images/great_gatsby.jpg', NOW());

-- 2. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('To Kill a Mockingbird', 'Harper Lee', 1, '9780061120084', 15, 'A powerful story of racial injustice.', '/images/mockingbird.jpg', NOW());

-- 3. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('1984', 'George Orwell', 2, '9780451524935', 20, 'A dystopian novel about totalitarianism.', '/images/1984.jpg', NOW());

-- 4. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('Pride and Prejudice', 'Jane Austen', 3, '9780141439518', 12, 'A romantic novel set in 19th century England.', '/images/pride_prejudice.jpg', NOW());

-- 5. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('The Catcher in the Rye', 'J.D. Salinger', 1, '9780316769488', 8, 'A story of teenage rebellion and alienation.', '/images/catcher_rye.jpg', NOW());

-- 6. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('The Hobbit', 'J.R.R. Tolkien', 4, '9780547928227', 25, 'A fantasy novel about Bilbo Baggins.', '/images/hobbit.jpg', NOW());

-- 7. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('Brave New World', 'Aldous Huxley', 2, '9780060850524', 18, 'A dystopian novel about a futuristic society.', '/images/brave_new_world.jpg', NOW());

-- 8. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('The Lord of the Rings', 'J.R.R. Tolkien', 4, '9780544003415', 30, 'An epic fantasy trilogy.', '/images/lord_of_rings.jpg', NOW());

-- 9. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('Moby Dick', 'Herman Melville', 5, '9781503280786', 5, 'A novel about the voyage of the whaling ship Pequod.', '/images/moby_dick.jpg', NOW());

-- 10. 插入一本图书
INSERT INTO `book` (`title`, `author`, `category_id`, `isbn`, `stock`, `description`, `cover_image`, `create_time`)
VALUES ('War and Peace', 'Leo Tolstoy', 6, '9781400079988', 22, 'A historical novel set during the Napoleonic Wars.', '/images/war_peace.jpg', NOW());
ALTER TABLE `book` 
ADD COLUMN `publisher` varchar(50) NOT NULL DEFAULT '' COMMENT '出版社' AFTER `isbn`,
ADD COLUMN `publish_date` datetime(0) DEFAULT NULL COMMENT '出版时间' AFTER `publisher`;

CREATE TABLE `book_borrow_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '图书id',
  `borrow_date` datetime DEFAULT NULL COMMENT '借阅日期',
  `return_date` datetime DEFAULT NULL COMMENT '归还日期',
  `borrow_status` tinyint(4) DEFAULT '0' COMMENT '借阅状态 0.未归还   1. 已归还',
  `audit_atatus` tinyint(4) DEFAULT '0' COMMENT '审核状态 0.未审核  1.已审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='借阅记录表';

CREATE TABLE `book_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图书分类表';


INSERT INTO `book_category` (`name`) VALUES 
('文学'),
('科技'),
('历史'),
('艺术'),
('哲学'),
('经济');



CREATE TABLE `book_favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `book_id` int(11) NOT NULL DEFAULT '0' COMMENT '图书id',
  `create_at` datetime DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='收藏记录表';


CREATE TABLE `book_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '图片名称',
  `image_orgin_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '图片上传之前的名称',
  `image_path` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '图片路径',
  `extension` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '图片后缀',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT= DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图纸记录表';