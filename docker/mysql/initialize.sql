CREATE DATABASE IF NOT EXISTS `backend_test`;
CREATE DATABASE IF NOT EXISTS `backend`;

USE `backend`;

DROP TABLE IF EXISTS `backend`.`users`;
CREATE TABLE `users` (
   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `login` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
   `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
   `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
   `html_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
   `created_at` timestamp NULL DEFAULT NULL,
   `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `users_login_unique` (`login`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `backend`.`repos`;
CREATE TABLE `repos` (
   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `users_id` int(10) unsigned NOT NULL,
   `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
   `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
   `html_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
   `created_at` timestamp NULL DEFAULT NULL,
   `updated_at` timestamp NULL DEFAULT NULL,
   PRIMARY KEY (`id`),
   KEY `repos_users_id_foreign` (`users_id`),
   CONSTRAINT `repos_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
   `batch` int(11) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2019_02_06_011639_create_repos_table', 1);

INSERT INTO `users` (`id`, `login`, `name`, `avatar_url`, `html_url`, `created_at`) VALUES (1, 'testesilva', 'Teste da Silva', '/avatar/testesilva.png', '/users/testesilva', NOW());

INSERT INTO `repos` (`users_id`, `name`, `description`, `html_url`) VALUES (1, 'Repo 1', 'Description repos 1', '/users/testesilva/repos/repo_1');
INSERT INTO `repos` (`users_id`, `name`, `description`, `html_url`) VALUES (1, 'Repo 2', 'Description repos 2', '/users/testesilva/repos/repo_2');
