<?php
require_once("../database/ticket.php");
require_once("../database/message.php");
require_once("../database/position.php");
session_name('HelpdeskID');
session_start();
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(['error' => 'InvalidSessionID']);
    die();
}
$user = new User($_SESSION['username']);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    /**
     * @api {get} /message.php List Tickets
     * @apiName GetMessage
     * @apiGroup Tickets
     * @apiSuccess {Object[]} messages for that user
     * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
     */
    if (!isset($_GET['id'])) {
        $personal = $user->getMessages();
        echo json_encode(['messages' => $personal]);
        die();
    }
    /**
     * @api {get} /tickets.php?id=:id Get Ticket
     * @apiName GetMessage
     * @apiGroup Message
     * @apiParam {Number} id the Message's ID number.
     * @apiSuccess {Number} id the Message's ID number.
     * @apiSuccess {String} title the Message's title.
     * @apiSuccess {String} description the Message's description.
     * @apiSuccess {String} date the date the Message was created.
     * @apiSuccess {Object} user the user who created the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
     * @apiError {String} InvalidMessageID Message does not exist.
     */
    try {
        $message = new Message($_GET['id']);
    } catch (Exception $e) {
        http_response_code(404);
        echo json_encode(['error' => 'InvalidMessageID']);
        die();
    }
    if ($user == $message->getUser() or $user->getPositionID() > Position::User) {
        echo json_encode($message);
    } else {
        http_response_code(403);
        echo json_encode(['error' => 'NoAccessRight']);
    }
}
/**
 * @api {post} /tickets.php?id=:id Create a Ticket
 * @apiName PostMessage
 * @apiGroup Message
 * @apiParam {String} title Title of the new Message.
 * @apiParam {String} description Description of the Message.
 * @apiSuccess {Number} id the Message's ID number.
 * @apiSuccess {String} title the Message's title.
 * @apiSuccess {String} description the Message's description.
 * @apiSuccess {String} date the date the Message was created.
 * @apiSuccess {Number} ticket id of the ticket
 * @apiError {String} InvalidMessageID Message does not exist.
 * @apiError {String} MissingTitle title parameter not supplied.
 * @apiError {String} MissingDescription description parameter not supplied.
 */ else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['title'])) {
        http_response_code(400);
        echo json_encode(['error' => 'MissingTitle']);
        die();
    }
    if (!isset($_POST['ticket'])){
        
        http_response_code(400);
        echo json_encode(['error' => 'MissingTicket']);
        die();
    }
    if (!isset($_POST['description'])) {
        http_response_code(400);
        echo json_encode(['error' => 'MissingDescription']);
        die();
    }
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ticket = $_POST['ticket'];
    echo json_encode(Message::createMessage($title, $description, $ticket));
}

?>
