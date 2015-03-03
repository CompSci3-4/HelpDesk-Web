<?php
    session_start();
    if(isset($_GET['user']))
        $_SESSION['id'] = $_GET['user'];
    $config = parse_ini_file("server.conf");
    if(!isset($_SESSION['id'])) {
        header('Location: http://' . $config['root_directory'] . '/login.php', TRUE, 302);
        die();
    }
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", "{$config['user']}", "{$config['password']}");
?>
