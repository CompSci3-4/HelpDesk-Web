<?php
    require_once("../database/user.php");
    require_once("../database/position.php");
    session_name('HelpdeskID');
    session_start();
    if(!isset($_SESSION['username'])) {
        http_response_code(401);
        echo json_encode(['error' => 'InvalidSessionCookie']);
        die();
    }
    $user = new User($_SESSION['username']);
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        /**
         * @api {get} /account.php Account Info
         * @apiName GetAccount
         * @apiGroup Account
         * @apiSuccess {String} username the user's username.
         * @apiSuccess {String} first the user's first name.
         * @apiSuccess {String} last the user's last name.
         * @apiSuccess {String} email the user's email.
         * @apiSuccess {String} position the user's position (e.g. User, Admin, Consultant).
         * @apiSuccess {Number} room the user's room number.
         * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
         */
        echo json_encode($user);
    }
    else if($_SERVER['REQUEST_METHOD'] == 'PATCH') {
        /**
         * @api {patch} /account.php Edit Account Info
         * @apiName PatchAccount
         * @apiGroup Account
         * @apiParam {String} [first] the user's new first name.
         * @apiParam {String} [last] the user's new last name.
         * @apiParam {String} [email] the user's new email.
         * @apiParam {String} [password] the user's new password.
         * @apiParam {Number} [room] the user's new room number.
         * @apiSuccess {String} username the user's username.
         * @apiSuccess {String} first the user's first name.
         * @apiSuccess {String} last the user's last name.
         * @apiSuccess {String} email the user's email.
         * @apiSuccess {String} position the user's position (e.g. User, Admin, Consultant).
         * @apiSuccess {Number} room the user's room number.
         * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
         */
        #Fills $_POST with the content of the request body, because
        #PHP does not automatically do this for PATCH requests.
        parse_str(file_get_contents('php://input'), $_POST);
        if(isset($_POST['first'])) {
            $user->setFirst($_POST['first']);
        }
        if(isset($_POST['last'])) {
            $user->setLast($_POST['last']);
        }
        if(isset($_POST['email'])) {
            $user->setEmail($_POST['email']);
        }
        if(isset($_POST['room'])) {
            $user->setRoom($_POST['room']);
        }
        if(isset($_POST['password'])) {
            $user->setPassword($_POST['password']);
        }
        echo json_encode($user);
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'UnsupportedRequestMethod']);
    }
?>
