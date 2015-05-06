<?php
    require_once('../globals.php');
    require_once('../database/user.php');
    $id = $_GET['user'];
    $password = $_GET['password'];
    $user = new User($id);
    if($user->passwordMatches($password)) {
        session_start();
        $_SESSION['id'] = $id;
    }
    else {
        http_response_code(403);
        echo json_encode(['error' => 'IncorrectUserOrPassword']);
    }
?>
