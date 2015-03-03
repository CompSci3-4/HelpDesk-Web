<?php
session_start();
session_destroy();
$config = parse_ini_file("server.conf");
header('Location: http://' . $config['root_directory'] . '/login.php', TRUE, 302);
?>
