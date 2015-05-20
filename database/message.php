<?php
require_once("../globals.php");
require_once("ticket.php");
require_once("status.php");
/**
 * A help ticket within the system.
 *
 * This class serves as a wrapper for SQL queries, so that one does not need to understand SQL or databases to manipulate tickets.
 */
class Message implements JsonSerializable {
    private static $db = null;
    private static $config = null;
    private $id;
    private $title;
    private $body;
    private $date;
    private $sender;
    private $ticket;
    /**
     * Finds a ticket within the database, with the given ID.
     *
     * @param int $id The ID of the ticket. IDs can be found in the database.
     */
    public function __construct($id) {
        $this->id = $id;
        $query = Message::$db->prepare(
                 'SELECT id, title, date, body, sender, ticket
                  FROM messages
                  WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->execute();
        $results = $query->fetch();
        if(!$results) {
            throw new Exception("Invalid Message ID");
        }
        
        $this->title = $results['title'];
        $this->date = $results['date'];
        $this->body = $results['body'];
        $this->sender = new User($results['sender']);
        $this->ticket = new Ticket($results['ticket']);
    }
    public static function createMessage($title, $body, $ticket, $sender) {
        $sql = Message::$db->prepare("INSERT INTO messages
                (title, body, ticket, sender)
                values (:title, :body, :ticket, :sender)");
        $sql->bindValue(':ticket', $ticket->getID());
        $sql->bindValue(':title', $title);
        $sql->bindValue(':body', $body);
        $sql->bindValue(':sender', $sender->getUsername());
        $sql->execute();
        return new Message(Message::$db->lastInsertID());
    }
    /**
     * Converts the Ticket into JSON, for use with the API.
     *
     * @return string the JSON representation of the ticket.
     */
    public function jsonSerialize() {
        $config = Ticket::$config;
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'body' => $this->body,
            'sender' => $this->sender
        );
    }
    /**
     * Initializes class constants.
     * @param PDO $db The database to read tickets from.
     */
    public static function init($config, $db) {
        Message::$config = $config;
        Message::$db = $db;
    }
    /**
     * @return string the URL to retrieve the JSON version of this ticket.
     */
    public function getJSON() {
        return Message::$config['root_directory'] . '/api/messages.php?id=' . $this->id;
    }
    /**
     * @return string the URL to retrieve the HTML representation of the ticket.
     */
    public function getHTML() {
        return Message::$config['root_directory'] . '/messages/view.php?id=' . $this->id;
    }
    /**
     * @return int the ticket's id number.
     */
    public function getID() {
        return $this->id;
    }
    /**
     * @return string the ticket's official title.
     */
    public function getTitle() {
        return $this->title;
    }
    
    /**
     * @return string a detailed body of the problem.
     */
    public function getBody() {
        return $this->body;
    }
    /**
     * @return string the date the ticket was created.
     */
    public function getDate() {
        return $this->date;
    }
    
    public function getTicket() {
        return $this->ticket;
    }
    public function getSender() {
        return $this->sender;
    }
}
Message::init($config, $db);
?>
