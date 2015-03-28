<?php
require_once("../globals.php");
require_once("ticket.php");
class User {

    private static $db = null;
    private static $config = null;
    private $id;
    private $first;
    private $last;
    private $email;
    private $room;
    private $title;
    private $tickets;
    private $consultantTickets;
    private $managerTickets;

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

    public function jsonSerialize() {
        $config = User::$config;
        $tickets = array();
        foreach($this->getTickets() as $ticket)
            array_push($tickets, $ticket->getJSON());
        return array(
            'id' => $this->id,
            'first' => $this->first,
            'last' => $this->last,
            'email' => $this->email,
            'room' => $this->room,
            'title' => $this->title,
            'tickets' => $tickets
        );
    }

    public function getJSON() {
        return User::$config['root_directory'] . '/users/view.json?id=' . $this->id;
    }

    public function getHTML() {
        return User::$config['root_directory'] . '/users/view.php?id=' . $this->id;
    }

    #Initializes static attributes, because PHP does not allow expressions for normal
    #static attribute declarations (e.g. private static $foo = someFunction(x);)
    public static function init($config, $db) {
        User::$config = $config;
        User::$db = $db;
    }

    public static function allUsers() {
        $query = User::$db->prepare('SELECT id FROM users');
        $query->execute();
        $users = array();
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
            $this->tickets = array();
            foreach($results as $result) {
                array_push($this->tickets, new Ticket($result['id']));
            }
        }
        return $this->tickets;
    }

    public function getConsultantTickets() {
        if($this->title === 'user')
            return null;
        if(!isset($this->consultantTickets)) {
            $query = User::$db->prepare("SELECT id
                                  FROM tickets
                                  WHERE tickets.consultant = :id
                                  ORDER BY tickets.date DESC");
            $query->bindValue(':id', $this->id);
            $query->execute();
            $results = $query->fetchAll();
            $this->consultantTickets = [];
            foreach($results as $result) {
                array_push($this->consultantTickets, new Ticket($result['id']));
            }
        }
        return $this->consultantTickets;
    }

    public function getManagerTickets() {
        if($this->title === 'user' or $this->title === 'consultant')
            return null;
        if(!isset($this->managerTickets)) {
            $query = User::$db->prepare("SELECT id
                                  FROM tickets
                                  WHERE tickets.manager = :id
                                  ORDER BY tickets.date DESC");
            $query->bindValue(':id', $this->id);
            $query->execute();
            $results = $query->fetchAll();
            $this->managerTickets = [];
            foreach($results as $result) {
                array_push($this->managerTickets, new Ticket($result['id']));
            }
        }
        return $this->managerTickets;
    }
}

User::init($config, $db);
?>
