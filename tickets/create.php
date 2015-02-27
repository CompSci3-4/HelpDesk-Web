<?php
    session_start();
    if(!isset($_SESSION['id']))
        header('Location: http://localhost/helpdesk/login.php', TRUE, 302);
    $config = parse_ini_file("../server.conf");
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", "{$config['user']}", "{$config['password']}");
    $sql = $db->prepare("INSERT INTO tickets
            (user, title, consultant, manager, description, status)
            values (:user, :title, :consultant, :manager, :description, 5)");
            #5 is the status code for In Progress (should find a more readable way to do this)
    $sql->bindParam(':user', $_SESSION['id']);
    $sql->bindParam(':title', $_POST['title']);
    $sql->bindValue(':consultant', 5);
    $sql->bindValue(':manager', 5);
    $sql->bindParam(':description', $_POST['description']);
    $sql->execute();
    header('Location: http://10.55.255.252/master/tickets/list.php', TRUE, 302);
?>
