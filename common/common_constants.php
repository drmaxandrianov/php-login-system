<?php
	// DB credentials
    $DB_HOST = '';
	$DB_USER = '';
	$DB_PASSWORD = '';
	$DB_NAME = '';

    // Users DB credentials
    $DB_USERS_HOST = 'localhost';
    $DB_USERS_USER = 'root';
    $DB_USERS_PASSWORD = '';
    $DB_USERS_NAME = 'php-login-system';
    $DB_USERS_TABLE = 'users';

/*
    CREATE TABLE IF NOT EXISTS `users` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `login` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `password` char(40) COLLATE utf8_unicode_ci NOT NULL,
    `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `registration_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `login` (`login`,`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
*/

    // reCAPTCHA
	$RECAPTCHA_PUBLIC_KEY = "";
	$RECAPTCHA_PRIVATE_KEY = "";
?>
