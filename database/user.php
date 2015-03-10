<?php
require_once("../globals.php");
class User {
    private static $getName = null;
    private static $getEmail = null;
    private static $getRoomNumber = null;
    private static $getTitle = null;

    public function __construct($id) {
        $this->id = $id;
        $this->first = null;
        $this->last = null;
        $this->email = null;
        $this->room = null;
        $this->title = null;
    }

    #Initializes static attributes, because PHP does not allow expressions for normal
    #static attribute declarations (e.g. private static $foo = someFunction(x);)
    public static function init($db) {
        User::$getName = $db->prepare('SELECT first, last FROM users WHERE id = :id');
        User::$getEmail = $db->prepare('SELECT email FROM users WHERE id = :id');
        User::$getRoomNumber = $db->prepare('SELECT room FROM users WHERE id = :id');
        User::$getTitle = $db->prepare('SELECT positions.title FROM users, positions 
                                        WHERE users.position = positions.id and users.id = :id');
    }


    public function getFirst() {
        if(!$this->first) {
            User::$getName->bindValue(':id', $this->id);
            User::$getName->execute();
            $this->first = User::$getName->fetch()['first'];
            $this->last = User::$getName->fetch()['last'];
        }
        return $this->first;
    }

    public function getLast() {
        if(!$this->last) {
            User::$getName->bindValue(':id', $this->id);
            User::$getName->execute();
            $this->first = User::$getName->fetch()['first'];
            $this->last = User::$getName->fetch()['last'];
        }
        return $this->last;
    }

    public function getName() {
        return $this->getFirst() . $this->getLast();
    }

    public function getRoom() {
        if(!$this->room) {
            User::$getRoomNumber->bindValue(':id', $this->id);
            User::$getRoomNumber->execute();
            $this->room = User::$getRoomNumber->fetch()['room'];
        }
        return $this->room;
    }

    public function getEmail() {
        if(!$this->email) {
            User::$getEmail->bindValue(':id', $this->id);
            User::$getEmail->execute();
            $this->email = User::$getEmail->fetch()['email'];
        }
        return $this->email;
    }

    public function getTitle() {
        if(!$this->title) {
            User::$getTitle->bindValue(':id', $this->id);
            User::$getTitle->execute();
            $this->title = User::$getTitle->fetch()['title'];
        }
        return $this->title;
    }
}

User::init($db);
?>
