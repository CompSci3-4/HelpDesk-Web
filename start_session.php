<?php
    include("globals.php");
    session_name('HelpdeskID');
    session_start();
    if(isset($_GET['user']))
        $_SESSION['id'] = $_GET['user'];
    if(!isset($_SESSION['id'])) {
        header('Location: ' . $config['root_directory'] . '/login.php', TRUE, 302);
        die();
    }
?>
