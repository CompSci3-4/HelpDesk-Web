<?php
#TODO add check for invalid ticket id
require_once("../database/ticket.php");
require_once("../database/message.php");
require_once("../database/position.php");
session_name('HelpdeskID');
session_start();
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(['error' => 'InvalidSessionCookie']);
    die();
}
$user = new User($_SESSION['username']);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    /**
     * @api {get} /messages.php?ticket=:ticket List Messages
     * @apiName GetMessages
     * @apiGroup Messages
     * @apiSuccess {Object[]} A list of messages associated with the ticket.
     * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
     * @apiError {String} NoAccessRight User not allowed to see messages associated with given ticket.
     */
    if (isset($_GET['ticket'])) {
        $ticket = new Ticket($_GET['ticket']);
        if ($user == $ticket->getUser() or $user->getPositionID() > Position::User) {
            echo json_encode($ticket->getMessages());
            die();
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'NoAccessRight']);
            die();
        }
    }
    /**
     * @api {get} /messages.php?id=:id Get Message
     * @apiName GetMessage
     * @apiGroup Messages
     * @apiParam {Number} id the Message's ID number.
     * @apiSuccess {Number} id the Message's ID number.
     * @apiSuccess {String} title the Message's title.
     * @apiSuccess {String} body the Message's body.
     * @apiSuccess {String} date the date the Message was created.
     * @apiSuccess {Object} sender the user who sent the message.
     * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
     * @apiError {String} InvalidMessageID Message does not exist.
     * @apiError {String} MissingMessageID Message ID was not included in request.
     * @apiError {String} NoAccessRight User not allowed to see requested message.
     */
    if(!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'MissingMessageID']);
        die();
    }
    try {
        $message = new Message($_GET['id']);
    } catch (Exception $e) {
        http_response_code(404);
        echo json_encode(['error' => 'InvalidMessageID']);
        die();
    }
    $ticket = $message->getTicket();
    if ($user == $ticket->getUser() or $user->getPositionID() > Position::User) {
        echo json_encode($message);
    } else {
        http_response_code(403);
        echo json_encode(['error' => 'NoAccessRight']);
    }
}
/**
 * @api {post} /messages.php?ticket=:ticket Create a Message
 * @apiName PostMessage
 * @apiGroup Messages
 * @apiParam {String} title Title of the new Message.
 * @apiParam {String} body body of the Message.
 * @apiParam {Number} ticket The ID of the associated ticket.
 * @apiSuccess {Number} id the Message's ID number.
 * @apiSuccess {String} title the Message's title.
 * @apiSuccess {String} body the Message's body.
 * @apiSuccess {String} date the date the Message was created.
 * @apiSuccess {Object} ticket the ticket the message is associated with.
 * @apiSuccess {Object} sender the user who sent the ticket.
 * @apiError {String} MissingTicketID TicketID was not provided.
 * @apiError {String} MissingTitle title parameter not supplied.
 * @apiError {String} MissingBody body parameter not supplied.
 */ 
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_GET['ticket'])){
        http_response_code(400);
        echo json_encode(['error' => 'MissingTicketID']);
        die();
    }
    $ticket = new Ticket($_GET['ticket']);
    if ($user != $ticket->getUser() and $user->getPositionID() == Position::User) {
        http_response_code(403);
        echo json_encode(['error' => 'NoAccessRight']);
        die();
    }
    if (!isset($_POST['title'])) {
        http_response_code(400);
        echo json_encode(['error' => 'MissingTitle']);
        die();
    }
    if (!isset($_POST['body'])) {
        http_response_code(400);
        echo json_encode(['error' => 'MissingBody']);
        die();
    }
    $title = $_POST['title'];
    $body = $_POST['body'];
    echo json_encode(Message::createMessage($title, $body, $ticket, $user));
}
?>
