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
        <table>
            <tr>
                <td>Title</td>
                <td>User</td>
                <td>Consultant</td>
                <td>Manager</td>
                <td>Status</td>
                <td>Date</td>
            </tr>
        <?php foreach($user->getTickets() as $ticket):?>
            <tr>
                <td><a href=<?php echo 'view.php?id=' . $ticket->getID(); ?>>
                             <?php echo $ticket->getTitle(); ?></a></td>
                <td><a href=<?php echo '../users/view.php?id=' . $ticket->getUserID(); ?>>
                             <?php echo $ticket->getUser()->getName(); ?></a></td>
                <td><a href=<?php echo '../users/view.php?id=' . $ticket->getConsultantID(); ?>>
                             <?php echo $ticket->getConsultant()->getName(); ?></a></td>
                <td><a href=<?php echo '../users/view.php?id=' . $ticket->getManagerID(); ?>>
                             <?php echo $ticket->getManager()->getName(); ?></a></td>
                <td><?php echo $ticket->getStatus(); ?></td>
                <td><?php echo $ticket->getDate(); ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        <h2>Create a Ticket</h2>
        <form action="create.php" method="post"> 
            <input name="title" type ="text" placeholder="Enter Title"></input>
            <textarea name="description" placeholder="Enter Description"></textarea>
            <button class="submit" type="submit" >Submit</button>
        </form>
    </body>
</html>
