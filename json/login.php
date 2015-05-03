<?php
    include('../globals.php');
    $user = $_GET['user'];
    $password = $_GET['password'];
    $query = $db->prepare('SELECT hash FROM users WHERE id = :id');
    $query->bindValue(':id', $user);
    $query->execute();
    $hash = $query->fetch()['hash'];
    if($hash === crypt($password, $hash)) {
        session_start();
        $_SESSION['id'] = $user;
    }
    else {
        http_response_code(403);
    }
?>
