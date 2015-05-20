<?php
require_once(dirname(dirname(__FILE__)) . "/globals.php");
require_once(dirname(__FILE__) . "/user.php");
require_once(dirname(__FILE__) . "/status.php");
/**
 * A help ticket within the system.
 *
 * This class serves as a wrapper for SQL queries, so that one does not need to understand SQL or databases to manipulate tickets.
 */
class Ticket implements JsonSerializable {

    private static $db = null;
    private static $config = null;
    private $id;
    private $title;
    private $description;
    private $status;
    private $date;
    private $uid;
    private $cid;
    private $mid;
    private $user;
    private $manager;
    private $consultant;
    /**
     * Finds a ticket within the database, with the given ID.
     *
     * @param int $id The ID of the ticket. IDs can be found in the database.
     */
    public function __construct($id) {
        $this->id = $id;
        $query = Ticket::$db->prepare(
                 'SELECT tickets.title as title, tickets.date, tickets.description,
                  tickets.status AS status, 
                  users.id AS uid, users.first AS ufirst, users.last AS ulast, 
                  consultants.id AS cid, consultants.first AS cfirst, consultants.last AS clast, 
                  managers.id AS mid, managers.first AS mfirst, managers.last AS mlast 
                  FROM tickets
                  LEFT JOIN users ON tickets.user = users.id
                  LEFT JOIN users consultants ON tickets.consultant = consultants.id
                  LEFT JOIN users managers ON tickets.manager = managers.id
                  WHERE tickets.id = :id');
        $query->bindValue(':id', $this->id);
        $query->execute();
        $results = $query->fetch();
        if(!$results) {
            throw new Exception("Invalid Ticket ID");
        }
        $this->title = $results['title'];
        $this->description = $results['description'];
        $this->status = $results['status'];
        $this->date = $results['date'];
        $this->uid = $results['uid'];
        $this->cid = $results['cid'];
        $this->mid = $results['mid'];
    }

    public function setDescription($newDescription) {
        $this->description = $newDescription;
        $query = Ticket::$db->prepare('UPDATE tickets
            SET description = :description
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':description', $newDescription);
        $query->execute();
    }

    public static function createTicket($title, $description, $user) {
        $sql = Ticket::$db->prepare("INSERT INTO tickets
                (user, title, consultant, manager, description, status)
                values (:user, :title, :consultant, :manager, :description, 5)");
                #5 is the status code for In Progress (should find a more readable way to do this)
        $sql->bindValue(':user', $user->getID());
        $sql->bindValue(':title', $title);
        $sql->bindValue(':description', $description);
        $sql->bindValue(':consultant', 7);
        $sql->bindValue(':manager', 8);
        $sql->execute();
        return new Ticket(Ticket::$db->lastInsertID());
    }

    public function delete() {
        $sql = Ticket::$db->prepare('DELETE FROM tickets WHERE id = :id');
        $sql->bindValue(':id', $this->id);
        $sql->execute();
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
            'description' => $this->description,
            'status' => Status::toString($this->status),
            'date' => $this->date,
            'user' => $this->getUser(),
            'consultant' => $this->getConsultant(),
            'manager' => $this->getManager(),
        );
    }

    /**
     * Initializes class constants.
     * @param PDO $db The database to read tickets from.
     */
    public static function init($config, $db) {
        Ticket::$config = $config;
        Ticket::$db = $db;
    }

    /**
     * @return string the URL to retrieve the JSON version of this ticket.
     */
    public function getJSON() {
        return Ticket::$config['root_directory'] . '/api/tickets.php?id=' . $this->id;
    }

    /**
     * @return string the URL to retrieve the HTML representation of the ticket.
     */
    public function getHTML() {
        return Ticket::$config['root_directory'] . '/tickets/view.php?id=' . $this->id;
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
        return $this->description;
    }

    /**
     * @return int the ticket's status (a list of statuses can be found in status.php).
     */
    public function getStatus() {
        return Status::toString($this->status);
    }

    /**
     * Updates the status of the ticket, both in the object and in the database.
     *
     * @param int the new status of the ticket.
     */
    public function setStatus($newStatus) {
        $this->status = $newStatus;
        $query = Ticket::$db->prepare('UPDATE tickets
            SET status = :status
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':status', $newStatus);
        $query->execute();
    }

    /**
     * @return string the date the ticket was created.
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @return int the ID of the user who created the ticket.
     */
    public function getUserID() {
        return $this->uid;
    }

    /**
     * @return User the User who created the ticket.
     */
    public function getUser() {
        if(!isset($this->user))
            $this->user = new User($this->getUserID());
        return $this->user;
    }

    /**
     * @return int the ID of the user who consults for the ticket.
     */
    public function getConsultantID() {
        return $this->cid;
    }

    /**
     * @return User the user who consults for the ticket.
     */
    public function getConsultant() {
        if(!isset($this->consultant))
            $this->consultant = new User($this->getConsultantID());
        return $this->consultant;
    }

    /**
     * @param User $newConsultant the new consultant for the ticket.
     */
    public function setConsultant($newConsultant) {
        $query = Ticket::$db->prepare('UPDATE tickets
            SET consultant = :consultant
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':consultant', $newConsultant->getID());
        $query->execute();
        $this->cid = $newConsultant->getID();
        $this->consultant = $newConsultant;
    }

    /**
     * @return int the ID of the user who manages the ticket.
     */
    public function getManagerID() {
        return $this->mid;
    }

    /**
     * @return User the user who managers the ticket.
     */
    public function getManager() {
        if(!isset($this->manager))
            $this->manager = new User($this->getManagerID());
        return $this->manager;
    }

    /**
     * @param User $newManager the new manager for the ticket.
     */
    public function setManager($newManager) {
        $query = Ticket::$db->prepare('UPDATE tickets
            SET manager = :manager
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':manager', $newManager->getID());
        $query->execute();
        $this->mid = $newManager->getID();
        $this->manager = $newManager;
    }
}

Ticket::init($config, $db);
?>
