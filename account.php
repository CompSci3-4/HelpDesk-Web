<?php
    require_once("../start_session.php");
    require_once("../database/user.php");
    $user = new User($_SESSION['username']);
?>
