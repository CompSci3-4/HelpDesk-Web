<?php
    require_once('globals.php');
    require_once('database/user.php');
    $username = $_POST['user'];
    $password = $_POST['password'];
    $user = new User($username);
    if($user->passwordMatches($password)) {
        session_name('HelpdeskID');
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $username;
        header('Location: ' . $config['root_directory'] . '/tickets/list.php', TRUE, 302);
    }
    else {
        header('Location: ' . $config['root_directory'] . '/index.html', TRUE, 302);
    }
?>
