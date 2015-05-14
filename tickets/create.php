<?php
    require_once("../start_session.php");
    require_once("../database/user.php");
    $sql = $db->prepare("INSERT INTO tickets
            (user, title, consultant, manager, description, status)
            values (:user, :title, :consultant, :manager, :description, 5)");
            #5 is the status code for In Progress (should find a more readable way to do this)
    $user = new User($_SESSION['id']);
    $sql->bindValue(':user', $user->getID());
    $sql->bindValue(':title', $_POST['title']);
    $sql->bindValue(':consultant', 7);
    $sql->bindValue(':manager', 8);
    $sql->bindValue(':description', $_POST['description']);
    $sql->execute();
    header('Location: ' . $config['root_directory'] . '/tickets/list.php', TRUE, 302);
?>
