<?php
require_once("../globals.php");
require_once("Ticket.php");
require_once("status.php");
/**
 * A help ticket within the system.
 *
 * This class serves as a wrapper for SQL queries, so that one does not need to understand SQL or databases to manipulate tickets.
 */
class message implements JsonSerializable {
    private static $db = null;
    private static $config = null;
    private $id;
    private $title;
    private $body;
    private $date;
    private $ticket;
    /**
     * Finds a ticket within the database, with the given ID.
     *
     * @param int $id The ID of the ticket. IDs can be found in the database.
     */
    public function __construct($id) {
        $this->id = $id;
        $query = Ticket::$db->prepare(
                 'SELECT message.title as subj, message.date, message.body,
                  message.status AS status, message.ticket as the current ticket 
                  FROM messages
                  WHERE tickets.id = :id');
        $query->bindValue(':id', $this->id);
        $query->execute();
        $results = $query->fetch();
        if(!$results) {
            throw new Exception("Invalid Ticket ID");
        }
        $this->ticket = $results['ticket'];
        $this->title = $results['title'];
        $this->body = $results['description'];
        $this->date = $results['date'];
    }
    public static function createMessage($title, $description, $ticket) {
        $sql = Ticket::$db->prepare("INSERT INTO tickets
                (title, description, status)
                values (:ticket, :user, :title,:description)");
                #5 is the status code for In Progress (should find a more readable way to do this)
        $sql->bindValue(':ticket', $ticket);
        $sql->bindValue(':title', $title);
        $sql->bindValue(':description', $description);
        $sql->execute();
        return new Ticket(Ticket::$db->lastInsertID());
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
            'description' => $this->body,
            'date' => $this->date
        );
    }
    /**
     * Initializes class constants.
     * @param PDO $db The database to read tickets from.
     */
    public static function init($config, $db) {
        message::$config = $config;
        message::$db = $db;
    }
    /**
     * @return string the URL to retrieve the JSON version of this ticket.
     */
    public function getJSON() {
        return message::$config['root_directory'] . '/tickets/view.json?id=' . $this->id;
    }
    /**
     * @return string the URL to retrieve the HTML representation of the ticket.
     */
    public function getHTML() {
        return message::$config['root_directory'] . '/tickets/view.php?id=' . $this->id;
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
     * @return string a detailed description of the problem.
     */
    public function getDescription() {
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
}
message::init($config, $db);
?>
