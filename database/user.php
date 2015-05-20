<?php
require_once(dirname(dirname(__FILE__)) . "/globals.php");
require_once(dirname(__FILE__) . "/ticket.php");
require_once(dirname(__FILE__) . "/position.php");
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
    public function __construct($idOrUsername) {
        if(is_numeric($idOrUsername)) {
            $query = User::$db->prepare(
                 'SELECT id, first, last,
                  email, room, position,
                  username, hash
                  FROM users
                  WHERE users.id = :id');
            $query->bindValue(':id', $idOrUsername);
        }
        else {
            $query = User::$db->prepare(
                 'SELECT id, first, last,
                  email, room, position,
                  username, hash
                  FROM users
                  WHERE users.username = :name');
            $query->bindValue(':name', $idOrUsername);
        }
        $query->execute();
        $results = $query->fetch();
        $this->id = $results['id'];
        $this->username = $results['username'];
        $this->hash = $results['hash'];
        $this->first = $results['first'];
        $this->last = $results['last'];
        $this->email = $results['email'];
        $this->room = $results['room'];
        $this->position = $results['position'];
    }

    public static function createUser($username, $password, $first, $last, $email, $room) {
        $query = User::$db->prepare('INSERT INTO users 
            (username, first, last, email, room, position)
            VALUES (:username, :first, :last, :email, :room, :position)');
        $query->bindValue(':username', $username);
        $query->bindValue(':first', $first);
        $query->bindValue(':last', $last);
        $query->bindValue(':email', $email);
        $query->bindValue(':room', $room);
        $query->bindValue(':position', Position::User);
        $query->execute();
        $err = $query->errorInfo();
        if(isset($err[1]) and $err[1] == 1062) { #1062 is for duplicate entry
            throw new Exception('DuplicateUsername');
        }
        $newUser = new User(User::$db->lastInsertID());
        $newUser->setPassword($password);
        return $newUser;
    }

    public function getUsername() {
        return $this->username;
    }

    public function passwordMatches($password) {
        return ($this->hash === crypt($password, $this->hash));
    }

    public function setPassword($newPassword) {
        $salt = '$2y$07$';
        $chars = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
        for($i = 0; $i < 22; $i++) {
            $salt .= $chars[array_rand($chars)];
        }
        $hash = crypt($newPassword, $salt);
        $this->hash = $hash;
        $query = User::$db->prepare('UPDATE users
            SET hash = :hash
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':hash', $hash);
        $query->execute();
    }

    /**
     * Converts the User into JSON, for use with the API.
     *
     * @return string the JSON representation of the user.
     */
    public function jsonSerialize() {
        return array(
            'username' => $this->username,
            'first' => $this->first,
            'last' => $this->last,
            'email' => $this->email,
            'room' => $this->room,
            'position' => Position::toString($this->position),
        );
    }

    /**
     * @return string the URL to retrieve the JSON version of this user.
     */
    public function getJSON() {
        return User::$config['root_directory'] . '/api/users.php?username=' . $this->username;
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
     * @return array a list of all admins in the database.
     */
    public static function allAdmins() {
        return User::listUsers(Position::Admin);
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

    public function setFirst($newFirst) {
        $this->first = $newFirst;
        $query = User::$db->prepare('UPDATE users
            SET first = :first
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':first', $newFirst);
        $query->execute();
    }

    /**
     * @return string the user's last name.
     */
    public function getLast() {
        return $this->last;
    }

    public function setLast($newLast) {
        $this->last = $newLast;
        $query = User::$db->prepare('UPDATE users
            SET last = :last
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':last', $newLast);
        $query->execute();
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

    public function setRoom($newRoom) {
        $this->room = $newRoom;
        $query = User::$db->prepare('UPDATE users
            SET room = :room
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':room', $newRoom);
        $query->execute();
    }

    /**
     * @return string the user's email address.
     */
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($newEmail) {
        $this->email = $newEmail;
        $query = User::$db->prepare('UPDATE users
            SET email = :email
            WHERE id = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':email', $newEmail);
        $query->execute();
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
