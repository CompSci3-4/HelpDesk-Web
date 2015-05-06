<?php
require_once("../globals.php");
require_once("ticket.php");
require_once("position.php");
/**
 * A user within the system.
 */
class User implements JsonSerializable {

    private static $db = null;
    private static $config = null;
    private $id;
    private $username;
    private $hash;
    private $first;
    private $last;
    private $email;
    private $room;
    private $position;
    private $tickets;
    private $consultantTickets;
    private $managerTickets;

    /**
     * Retrieves a user from the database.
     *
     * @param int $id the ID of the user to be retrieved.
     */
    public function __construct($id) {
        $this->id = $id;
        $query = User::$db->prepare(
                 'SELECT first, last,
                  email, room, position,
                  username, hash
                  FROM users
                  WHERE users.id = :id');
        $query->bindValue(':id', $this->id);
        $query->execute();
        $results = $query->fetch();
        $this->username = $results['username'];
        $this->hash = $results['hash'];
        $this->first = $results['first'];
        $this->last = $results['last'];
        $this->email = $results['email'];
        $this->room = $results['room'];
        $this->position = $results['position'];
    }

    public function getUsername() {
        return $this->username;
    }

    public function passwordMatches($password) {
        return ($this->hash === crypt($password, $this->hash));
    }

    /**
     * Converts the User into JSON, for use with the API.
     *
     * @return string the JSON representation of the user.
     */
    public function jsonSerialize() {
        $config = User::$config;
        $tickets = array();
        foreach($this->getTickets() as $ticket)
            array_push($tickets, $ticket->getJSON());
        $consultantTickets = array();
        foreach($this->getConsultantTickets() as $ticket)
            array_push($consultantTickets, $ticket->getJSON());
        $managerTickets = array();
        foreach($this->getManagerTickets() as $ticket)
            array_push($managerTickets, $ticket->getJSON());
        $tickets = array(
            'personal' => $tickets,
            'consultant for' => $consultantTickets,
            'manager for' => $managerTickets);
        return array(
            'id' => $this->id,
            'first' => $this->first,
            'last' => $this->last,
            'email' => $this->email,
            'room' => $this->room,
            'position' => Position::toString($this->position),
            'tickets' => $tickets
        );
    }

    /**
     * @return string the URL to retrieve the JSON version of this user.
     */
    public function getJSON() {
        return User::$config['root_directory'] . '/users/view.json?id=' . $this->id;
    }

    /**
     * @return string the URL to retrieve the HTML representation of the user.
     */
    public function getHTML() {
        return User::$config['root_directory'] . '/users/view.php?id=' . $this->id;
    }

    /**
     * Initializes class constants.
     * @param PDO $db The database to read users from.
     */
    public static function init($config, $db) {
        User::$config = $config;
        User::$db = $db;
    }

    /**
     * @return array a list of all  users in the database.
     */
    public static function allUsers() {
        return User::listUsers(Position::User);
    }

    /**
     * @return array a list of all consultants (or above) in the database.
     */
    public static function allConsultants() {
        return User::listUsers(Position::Consultant);
    }

    /**
     * @return array a list of all managers (or above) in the database.
     */
    public static function allManagers() {
        return User::listUsers(Position::Manager);
    }

    /**
     * Finds all users of at least a given rank.
     *
     * @param int $minPosition the minimum position of user's to list.
     * @return array a list of all users of or above a certain position.
     */
    private static function listUsers($minPosition) {
        $query = User::$db->prepare("SELECT id FROM users WHERE position >= $minPosition");
        $query->execute();
        $users = array();
        foreach($query->fetchAll() as $user)
            array_push($users, new User($user['id']));
        return $users;
    }

    /**
     * @return int the user's id.
     */
    public function getID() {
        return $this->id;
    }

    /**
     * @return string the user's first name.
     */
    public function getFirst() {
        return $this->first;
    }

    /**
     * @return string the user's last name.
     */
    public function getLast() {
        return $this->last;
    }

    /**
     * @return string the user's full name.
     */
    public function getName() {
        return $this->getFirst() . ' ' . $this->getLast();
    }

    /**
     * @return int the user's room number.
     */
    public function getRoom() {
        return $this->room;
    }

    /**
     * @return string the user's email address.
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return string the name of the user's position (e.g. consultant).
     */
    public function getPosition() {
        return Position::toString($this->position);
    }

    /**
     * @return int the user's position.
     */
    public function getPositionID() {
        return $this->position;
    }

    /**
     * @return array a list of all tickets created by the user.
     */
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

    /**
     * @return array a list of all tickets consulted by the user.
     */
    public function getConsultantTickets() {
        if($this->position < Position::Consultant)
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

    /**
     * @return array a list of all tickets managed by the user.
     */
    public function getManagerTickets() {
        if($this->position < Position::Manager)
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
