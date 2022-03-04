

CREATE DATABASE IF NOT EXISTS `base02` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `base02`;

CREATE TABLE `comments` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `body` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `body` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_fk1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
