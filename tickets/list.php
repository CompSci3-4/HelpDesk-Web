<?php
require_once("../start_session.php");
require_once("../database/user.php");
$user = new User($_SESSION['id']);
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <?php include("../header.php") ?>
	<h1>Tickets</h1>
	On this page, you can view the tickets or, if you'd like, create a new ticket.<hr> 
        <h2>My Tickets</h2>
        <?php echo Ticket::createTable($user->getTickets(), false, true, true);?>
        <?php if($user->getConsultantTickets() !== null):?>
            <h2>Tickets You Consult For</h2>
            <?php echo Ticket::createTable($user->getConsultantTickets(), true, false, true);?>
        <?php endif;?>
        <?php if($user->getManagerTickets() !== null):?>
            <h2>Tickets You Manage</h2>
            <?php echo Ticket::createTable($user->getManagerTickets(), true, true, false);?>
        <?php endif;?>
        <h2>Create a Ticket</h2>
        <form action="create.php" method="post"> 
            <input name="title" type ="text" placeholder="Enter Title"></input>
            <textarea name="description" placeholder="Enter Description"></textarea>
            <button class="submit" type="submit" >Submit</button>
        </form>
    </body>
</html>
