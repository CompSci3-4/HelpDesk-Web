<?php
    require_once("../database/ticket.php");
    require_once("../database/user.php");
    require_once("../database/position.php");
    session_start();
    if(!isset($_SESSION['id'])) {
        http_response_code(403);
        echo json_encode(['error' => 'InvalidSessionCookie']);
        die();
    }
    $user = new User($_SESSION['id']);
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(!isset($_GET['id'])) {
            $personal = $user->getTickets();
            $consulted = $user->getConsultantTickets();
            $managed = $user->getManagerTickets();
            echo json_encode(['personal' => $personal,
                              'consultantFor' => $consulted,
                              'managerFor' => $managed]);
            die();
        }
        try {
            $ticket = new Ticket($_GET['id']);
        }
        catch(Exception $e) {
            http_response_code(404);
            echo json_encode(['error' => 'InvalidTicketID']);
            die();
        }
        if($user == $ticket->getUser() or $user->getPosition() > Position::User) {
            echo json_encode($ticket);
        }
        else {
            http_response_code(403);
            echo json_encode(['error' => 'NoAccessRight']);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!isset($_POST['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingTitle']);
            die();
        }
        if(!isset($_POST['description'])) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingDescription']);
            die();
        }
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = $db->prepare("INSERT INTO tickets
                (user, title, consultant, manager, description, status)
                values (:user, :title, :consultant, :manager, :description, 5)");
                #5 is the status code for In Progress (should find a more readable way to do this)
        $sql->bindValue(':user', $user->getID());
        $sql->bindValue(':title', $title);
        $sql->bindValue(':description', $description);
        $sql->bindValue(':consultant', 7);
        $sql->bindValue(':manager', 8);
        $sql->execute();
        echo json_encode(new Ticket($db->lastInsertID()));
    }
    else if($_SERVER['REQUEST_METHOD'] == 'PATCH') {
        http_response_code(501);
        echo json_encode(['error' => 'NotImplementedYet']);
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'UnsupportedRequestMethod']);
    }
?>
