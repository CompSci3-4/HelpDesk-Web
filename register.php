<?php
require_once('database/user.php');
#This page is where registration happens behind the scenes; the user does not see it.
if(!isset($_POST['username']) or empty(trim($_POST['username']))) {
    header('Location: ' . $config['root_directory'] . '/registration.html', TRUE, 302);
    die();
}
if(!isset($_POST['first']) or empty(trim($_POST['first']))) {
    header('Location: ' . $config['root_directory'] . '/registration.html', TRUE, 302);
    die();
}
if(!isset($_POST['last']) or empty(trim($_POST['last']))) {
    header('Location: ' . $config['root_directory'] . '/registration.html', TRUE, 302);
    die();
}
if(!isset($_POST['password']) or empty(trim($_POST['password']))) {
    header('Location: ' . $config['root_directory'] . '/registration.html', TRUE, 302);
    die();
}
if(!isset($_POST['email']) or empty(trim($_POST['email']))) {
    header('Location: ' . $config['root_directory'] . '/registration.html', TRUE, 302);
    die();
}
if(!isset($_POST['room']) or empty(trim($_POST['room']))) {
    header('Location: ' . $config['root_directory'] . '/registration.html', TRUE, 302);
    die();
}
$username = $_POST['username'];
$first = $_POST['first'];
$last = $_POST['last'];
$password = $_POST['password'];
$email = $_POST['email'];
$room = $_POST['room'];
try {
    $newUser = User::createUser($username, $password, $first, $last, $email, $room);
} catch (Exception $e) {
    header('Location: ' . $config['root_directory'] . '/registration.html', TRUE, 302);
    die();
}
session_name('HelpdeskID');
session_start();
$_SESSION['username'] = $newUser->getUsername();
$_SESSION['id'] = $newUser->getUsername();
header('Location: ' . $config['root_directory'] . '/tickets/list.php', TRUE, 302);
?>
