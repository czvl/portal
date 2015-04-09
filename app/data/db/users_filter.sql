CREATE TABLE `users_filter` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filter` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users_filter`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

 ALTER TABLE `users_filter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users_filter`
ADD CONSTRAINT `users_filter_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;