<?php
    require_once("../database/user.php");
    require_once("../database/position.php");
    /**
     * @api {post} /users.php Create User
     * @apiName PostUser
     * @apiGroup Users
     * @apiParam {String} username the user's username. Must be unique.
     * @apiParam {String} first the user's first name.
     * @apiParam {String} last the user's last name.
     * @apiParam {String} email the user's email.
     * @apiParam {String} password the user's password.
     * @apiParam {Number} room the user's room number.
     * @apiSuccess {String} username the user's username.
     * @apiSuccess {String} first the user's first name.
     * @apiSuccess {String} last the user's last name.
     * @apiSuccess {String} email the user's email.
     * @apiSuccess {String} position the user's position (e.g. User, Admin, Consultant).
     * @apiSuccess {Number} room the user's room number.
     * @apiError {String} MissingUsername Username parameter was not supplied.
     * @apiError {String} MissingFirstName first  parameter was not supplied.
     * @apiError {String} MissingLastName last parameter was not supplied.
     * @apiError {String} MissingPassword password parameter was not supplied.
     * @apiError {String} MissingEmail email parameter was not supplied.
     * @apiError {String} MissingRoom room was not supplied.
     * @apiError {String} DuplicateUsername a user already exists with that username.
     */
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!isset($_POST['username']) or empty(trim($_POST['username']))) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingUsername']);
            die();
        }
        if(!isset($_POST['first']) or empty(trim($_POST['first']))) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingFirstName']);
            die();
        }
        if(!isset($_POST['last']) or empty(trim($_POST['last']))) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingLastName']);
            die();
        }
        if(!isset($_POST['password']) or empty(trim($_POST['password']))) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingPassword']);
            die();
        }
        if(!isset($_POST['email']) or empty(trim($_POST['email']))) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingEmail']);
            die();
        }
        if(!isset($_POST['room']) or empty(trim($_POST['room']))) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingRoom']);
            die();
        }
        $username = $_POST['username'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $room = $_POST['room'];
        try {
            $newUser = User::createUser($username, $password, $first, $last, $email, $room);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }
        session_name('HelpdeskID');
        session_start();
        $_SESSION['username'] = $newUser->getUsername();
        echo json_encode($newUser);
        die();
    }
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
         * @api {get} /users.php?username=:username Get User
         * @apiName GetUser
         * @apiGroup Users
         * @apiParam {String} username the user's username.
         * @apiSuccess {String} username the user's username.
         * @apiSuccess {String} first the user's first name.
         * @apiSuccess {String} last the user's last name.
         * @apiSuccess {String} email the user's email.
         * @apiSuccess {String} position the user's position (e.g. User, Admin, Consultant).
         * @apiSuccess {Number} room the user's room number.
         * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
         * @apiError {String} NoAccessRight User is not allowed to view requested User (only staff are allowed to view normal users).
         */
        if(isset($_GET['username'])) {
            $requestedUser = new User($_GET['username']);
            if($user->getPositionID() == Position::User and $requestedUser->getPositionID() == Position::User) {
                http_response_code(403);
                echo json_encode(['error' => 'NoAccessRight']);
                die();
            }
            echo json_encode($requestedUser);
            die();
        }
        /**
         * @api {get} /users.php List Users
         * @apiName GetUsers
         * @apiGroup Users
         * @apiSuccess {Object[]} users all Users in the database.
         * @apiSuccess {Object[]} consultants all consultants in the database.
         * @apiSuccess {Object[]} managers all managers in the database.
         * @apiSuccess {Object[]} managers all managers in the database.
         * @apiSuccess {Object[]} admins all admins in the database.
         * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
         * @apiError {String} NoAccessRight User does not have permission to view all users (only staff may view all users).
         */
        #Only staff should be able to view all users.
        if($user->getPositionID() == Position::User) {
            http_response_code(403);
            echo json_encode(['error' => 'NoAccessRight']);
            die();
        }
        $users = ['users' => User::allUsers(), 'consultants' => User::AllConsultants(),
            'managers' => User::AllManagers(), 'admins' => User::AllAdmins()];
        echo json_encode($users);
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'UnsupportedRequestMethod']);
    }
?>
