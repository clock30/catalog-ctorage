<?php
$host = 'localhost'; // имя хоста
$user = 'root';      // имя пользователя
$pas = '';          // пароль
$nam = 'site-catalog';      // имя базы данных

$link = mysqli_connect($host, $user, $pas, $nam);
mysqli_query($link, "SET NAMES 'utf8'");