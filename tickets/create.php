<?php
    session_start();
    if(!isset($_SESSION['id']))
        header('Location: http://localhost/helpdesk/login.php', TRUE, 302);
    $config = parse_ini_file("../server.conf");
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", "{$config['user']}", "{$config['password']}");
    $sql = "INSERT INTO tickets
            (user, title, description, status)
            values ({$_SESSION['id']}, '{$_POST['title']}', '{$_POST['description']}', 5)";
            #5 is the status code for In Progress (should find a more readable way to do this)
    $db->query($sql);
    header('Location: http://localhost/helpdesk/tickets/list.php', TRUE, 302);
?>
