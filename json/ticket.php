<?php
    require_once("../database/ticket.php");
    require_once("../database/user.php");
    require_once("../database/position.php");
    session_start();
    $ticket = new Ticket($_GET['id']);
    $user = new User($_SESSION['id']);
    if($user == $ticket->getUser() or $user->getPosition() > Position::User) {
        echo json_encode($ticket);
    }
    else {
        http_response_code(403);
    }
?>
