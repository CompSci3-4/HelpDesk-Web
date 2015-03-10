<?php
$config = parse_ini_file("server.conf");
$db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", "{$config['user']}", "{$config['password']}");
?>
