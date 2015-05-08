<?php
    require_once("../database/ticket.php");
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
        if($user == $ticket->getUser() or $user->getPositionID() > Position::User) {
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
        echo json_encode(Ticket::createTicket($title, $description, $user));
    }
    else if($_SERVER['REQUEST_METHOD'] == 'PATCH') {
        #Fills $_POST with the content of the request body, because
        #PHP does not automatically do this for PATCH requests.
        parse_str(file_get_contents('php://input'), $_POST);
        if(!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingTicketID']);
            die();
        }
        $ticket = new Ticket($_GET['id']);
        if(isset($_POST['manager'])) {
            if($user->getPositionID() >= Position::Admin) {
                $manager = new User($_POST['manager']);
                $ticket->setManager($manager);
            }
            else {
                http_response_code(403);
                echo json_encode(['error' => 'NoPatchRight']);
                die();
            }
        }
        if(isset($_POST['consultant'])) {
            if($user->getPositionID() >= Position::Manager) {
                $consultant = new User($_POST['consultant']);
                $ticket->setConsultant($consultant);
            }
            else {
                http_response_code(403);
                echo json_encode(['error' => 'NoPatchRight']);
                die();
            }
        }
        if(isset($_POST['description'])) {
            if($user == $ticket->getUser() or $user->getPositionID() > Position::User) {
                $ticket->setDescription($_POST['description']);
            }
            else {
                http_response_code(403);
                echo json_encode(['error' => 'NoPatchRight']);
                die();
            }
        }
        echo json_encode($ticket);
    }
    else if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        if(!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'MissingTicketID']);
            die();
        }
        if($user->getPositionID() < Position::Admin) {
            http_response_code(403);
            echo json_encode(['error' => 'NoDeletionRight']);
            die();
        }
        $ticket = new Ticket($_GET['id']);
        echo json_encode($ticket);
        $ticket->delete();
    }
    else {
        http_response_code(405);
        echo json_encode(['error' => 'UnsupportedRequestMethod']);
    }
?>
