<?php
    include("globals.php");
    session_name('HelpdeskID');
    session_start();
    if(!isset($_SESSION['username'])) {
        header('Location: ' . $config['root_directory'] . '/login.php', TRUE, 302);
        die();
    }
?>
