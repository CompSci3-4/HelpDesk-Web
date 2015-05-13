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
        /**
         * @api {get} /tickets.php List Tickets
         * @apiName GetTickets
         * @apiGroup Tickets
         * @apiSuccess {Object[]} personal Tickets created by the user.
         * @apiSuccess {Object[]} consultantFor Tickets consulted for by the user.
         * @apiSuccess {Object[]} managerFor Tickets managed by the user.
         * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
         */
        if(!isset($_GET['id'])) {
            $personal = $user->getTickets();
            $consulted = $user->getConsultantTickets();
            $managed = $user->getManagerTickets();
            echo json_encode(['personal' => $personal,
                              'consultantFor' => $consulted,
                              'managerFor' => $managed]);
            die();
        }
        /**
         * @api {get} /tickets.php?id=:id Get Ticket
         * @apiName GetTicket
         * @apiGroup Tickets
         * @apiParam {Number} id the Ticket's ID number.
         * @apiSuccess {Number} id the Ticket's ID number.
         * @apiSuccess {String} title the Ticket's title.
         * @apiSuccess {String} description the Ticket's description.
         * @apiSuccess {String} date the date the Ticket was created.
         * @apiSuccess {Object} user the user who created the ticket. Check the User API for listing of fields.
         * @apiSuccess {Object} consultant the user who consults for the ticket. Check the User API for listing of fields.
         * @apiSuccess {Object} manager the user who manages the ticket. Check the User API for listing of fields.
         * @apiError {String} InvalidSessionCookie Session cookie either does not exist or is expired.
         * @apiError {String} InvalidTicketID Ticket does not exist.
         * @apiError {String} NoAccessRight User is not allowed to access requested ticket.
         */
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
    /**
     * @api {post} /tickets.php?id=:id Create a Ticket
     * @apiName PostTicket
     * @apiGroup Tickets
     * @apiParam {String} title Title of the new Ticket.
     * @apiParam {String} description Description of the problem.
     * @apiSuccess {Number} id the Ticket's ID number.
     * @apiSuccess {String} title the Ticket's title.
     * @apiSuccess {String} description the Ticket's description.
     * @apiSuccess {String} date the date the Ticket was created.
     * @apiSuccess {Object} user the user who created the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiSuccess {Object} consultant the user who consults for the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiSuccess {Object} manager the user who manages the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiError {String} InvalidTicketID Ticket does not exist.
     * @apiError {String} MissingTitle title parameter not supplied.
     * @apiError {String} MissingDescription description parameter not supplied.
     */
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
    /**
     * @api {patch} /tickets.php?id=:id Edit a Ticket
     * @apiName PatchTicket
     * @apiGroup Tickets
     * @apiParam {Number} id the Ticket's ID number.
     * @apiParam {String} [description] Updated description of the problem.
     * @apiParam {String} [consultant] The username of the Ticket's new consultant.
     * @apiParam {String} [manager] The username of the Ticket's new manager.
     * @apiParam {Number} [status] The Ticket's new status code.
     * @apiSuccess {Number} id the Ticket's ID number.
     * @apiSuccess {String} title the Ticket's title.
     * @apiSuccess {String} description the Ticket's description.
     * @apiSuccess {String} date the date the Ticket was created.
     * @apiSuccess {Object} user the user who created the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiSuccess {Object} consultant the user who consults for the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiSuccess {Object} manager the user who manages the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiError {String} MissingTicketID id parameter not supplied.
     * @apiError {String} NoPatchRight User is not allowed to edit requested ticket.
     */
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
        if(isset($_POST['status'])) {
            if($user->getPositionID() >= Position::Consultant) {
                $ticket->setStatus($_POST['status']);
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
    /**
     * @api {delete} /tickets.php?id=:id Delete a Ticket
     * @apiName DeleteTicket
     * @apiGroup Tickets
     * @apiSuccess {Number} id the Ticket's ID number.
     * @apiSuccess {String} title the Ticket's title.
     * @apiSuccess {String} description the Ticket's description.
     * @apiSuccess {String} date the date the Ticket was created.
     * @apiSuccess {Object} user the user who created the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiSuccess {Object} consultant the user who consults for the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiSuccess {Object} manager the user who manages the ticket. WARNING: User API is not finished yet, so this field should be ignored.
     * @apiError {String} MissingTicketID id parameter not supplied.
     * @apiError {String} NoDeletionRight User is not allowed to delete requested ticket.
     */
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
