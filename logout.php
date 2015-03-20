<?php
session_start();
session_destroy();
$config = parse_ini_file("server.conf");
header('Location: ' . $config['root_directory'] . '/login.php', TRUE, 302);
?>
