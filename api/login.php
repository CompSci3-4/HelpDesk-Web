<?php
    require_once('../globals.php');
    require_once('../database/user.php');
    $username = $_GET['user'];
    echo $id;
    $password = $_GET['password'];
    $user = new User($username);
    if($user->passwordMatches($password)) {
        session_name('HelpdeskID');
        session_start();
        $_SESSION['username'] = $username;
    }
    else {
        http_response_code(401);
        echo json_encode(['error' => 'IncorrectUserOrPassword']);
    }
?>
