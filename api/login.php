<?php
    require_once('../globals.php');
    require_once('../database/user.php');
    /**
     * @api {post} /login.php Login
     * @apiName Login
     * @apiGroup Login
     * @apiParam {String} user the username of the user you want to log in as.
     * @apiParam {String} password the user's password.
     * @apiSuccess {Cookie} HelpdeskID Session cookie to be used when accessing the rest of the API.
     * @apiError {String} IncorrectUserOrPassword Username or password is incorrect and/or not supplied.
     */
    if(!isset($_POST['user'])) {
        http_response_code(400);
        echo json_encode(['error' => 'MissingUsername']);
        die();
    }
    if(!isset($_POST['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'MissingPassword']);
        die();
    }
    $username = $_POST['user'];
    $password = $_POST['password'];
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
