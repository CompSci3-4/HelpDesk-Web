<?php
#TODO Methods for accessing Users and statuses
require_once("../globals.php");
require_once("user.php");
class Ticket {

    private static $db = null;
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

    public function __construct($id) {
        $this->id = $id;
        $query = Ticket::$db->prepare(
                 'SELECT tickets.title as title, tickets.date, tickets.description,
                  statuses.name AS status, 
                  users.id AS uid, users.first AS ufirst, users.last AS ulast, 
                  consultants.id AS cid, consultants.first AS cfirst, consultants.last AS clast, 
                  managers.id AS mid, managers.first AS mfirst, managers.last AS mlast 
                  FROM tickets
                  LEFT JOIN statuses ON tickets.status = statuses.id
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

    #Initializes static attributes, because PHP does not allow expressions for normal
    #static attribute declarations (e.g. private static $foo = someFunction(x);)
    public static function init($db) {
        Ticket::$db = $db;
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
        return $this->status;
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

    public function getManagerID() {
        return $this->mid;
    }

    public function getManager() {
        if(!isset($this->manager))
            $this->manager = new User($this->getManagerID());
        return $this->manager;
    }
}

Ticket::init($db);
?>
