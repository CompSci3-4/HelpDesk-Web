<?php
require_once("../globals.php");
require_once("user.php");
require_once("status.php");
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
        $this->title = $results['title'];
        $this->description = $results['description'];
        $this->status = $results['status'];
        $this->date = $results['date'];
        $this->uid = $results['uid'];
        $this->cid = $results['cid'];
        $this->mid = $results['mid'];
    }

    public function jsonSerialize() {
        $config = Ticket::$config;
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => Status::toString($this->status),
            'date' => $this->date,
            'user' => $this->getUser()->getJSON(),
            'consultant' => $this->getConsultant()->getJSON(),
            'manager' => $this->getManager()->getJSON(),
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

    public function getJSON() {
        return Ticket::$config['root_directory'] . '/tickets/view.json?id=' . $this->id;
    }

    public function getHTML() {
        return Ticket::$config['root_directory'] . '/tickets/view.php?id=' . $this->id;
    }

    public function getID() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function getStatus() {
        return Status::toString($this->status);
    }

    public function setStatus($newStatus) {
        $this->status = $newStatus;
        $query = Ticket::$db->prepare('UPDATE tickets
            SET status = :status
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':status', $newStatus);
        $query->execute();
    }

    public function getDate() {
        return $this->date;
    }

    public function getUserID() {
        return $this->uid;
    }

    public function getUser() {
        if(!isset($this->user))
            $this->user = new User($this->getUserID());
        return $this->user;
    }

    public function getConsultantID() {
        return $this->cid;
    }

    public function getConsultant() {
        if(!isset($this->consultant))
            $this->consultant = new User($this->getConsultantID());
        return $this->consultant;
    }

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

    public function getManagerID() {
        return $this->mid;
    }

    public function getManager() {
        if(!isset($this->manager))
            $this->manager = new User($this->getManagerID());
        return $this->manager;
    }

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
