<?php
require_once("../globals.php");
class User {

    private static $db = null;

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
}

User::init($db);
?>
