CREATE TABLE IF NOT EXISTS `comments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(256) NOT NULL,
    `comment` text NOT NULL,
    `created` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
