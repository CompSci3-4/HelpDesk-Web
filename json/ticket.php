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
    if(!isset($_GET['id'])) {
        #TODO get all tickets
        http_response_code(501);
        echo json_encode(['error' => 'NotImplementedYet']);
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
?>
