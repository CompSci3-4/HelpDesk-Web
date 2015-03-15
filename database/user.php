<?php
require_once("../globals.php");
require_once("ticket.php");
class User {

    private static $db = null;
    private $id;
    private $first;
    private $last;
    private $email;
    private $room;
    private $title;
    private $tickets;

    public function __construct($id) {
        $this->id = $id;
        $query = User::$db->prepare(
                 'SELECT users.first as first, users.last as last,
                  users.email as email, users.room as room, positions.title as title
                  FROM users, positions
                  WHERE users.id = :id and users.position = positions.id');
        $query->bindValue(':id', $this->id);
        $query->execute();
        $results = $query->fetch();
        $this->first = $results['first'];
        $this->last = $results['last'];
        $this->email = $results['email'];
        $this->room = $results['room'];
        $this->title = $results['title'];
    }

    #Initializes static attributes, because PHP does not allow expressions for normal
    #static attribute declarations (e.g. private static $foo = someFunction(x);)
    public static function init($db) {
        User::$db = $db;
    }

    public static function allUsers() {
        $query = User::$db->prepare('SELECT id FROM users');
        $query->execute();
        $users = [];
        foreach($query->fetchAll() as $user)
            array_push($users, new User($user['id']));
        return $users;
    }

    public function getID() {
        return $this->id;
    }

    public function getFirst() {
        return $this->first;
    }

    public function getLast() {
        return $this->last;
    }

    public function getName() {
        return $this->getFirst() . ' ' . $this->getLast();
    }

    public function getRoom() {
        return $this->room;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getTickets() {
        if(!isset($this->tickets)) {
            $query = User::$db->prepare("SELECT id
                                  FROM tickets
                                  WHERE tickets.user = :id
                                  ORDER BY tickets.date DESC");
            $query->bindValue(':id', $this->id);
            $query->execute();
            $results = $query->fetchAll();
            $this->tickets = [];
            foreach($results as $result) {
                array_push($this->tickets, new Ticket($result['id']));
            }
        }
        return $this->tickets;
    }
}

User::init($db);
?>
