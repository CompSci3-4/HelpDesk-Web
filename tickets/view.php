<?php
require_once("../start_session.php");
require_once("../database/ticket.php");
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <?php include("../header.php") ?>
        <form action=<?php echo 'list.php?user=' . $_SESSION['id']; ?> method="get"> 
            <button class="submit" type="submit" >Back</button>
        </form>
        <table>
            <tr>
                <td>User</td>
                <td>Description</td>
                <td>Consultant</td>
                <td>Manager</td>
                <td>Status</td>
                <td>Date</td>
            </tr>
        <?php $ticket = new Ticket($_GET['id']);?>
            <tr>
                <td><a href=<?php echo $ticket->getUser()->getHTML(); ?>>
                             <?php echo $ticket->getUser()->getName(); ?></a></td>
                <td><?php echo $ticket->getDescription(); ?></td>
                <td><a href=<?php echo $ticket->getConsultant()->getHTML(); ?>>
                             <?php echo $ticket->getConsultant()->getName(); ?></a></td>
                <td><a href=<?php echo $ticket->getManager()->getHTML(); ?>>
                             <?php echo $ticket->getManager()->getName(); ?></a></td>
                <td><?php echo $ticket->getStatus(); ?></td>
                <td><?php echo $ticket->getDate(); ?></td>
            </tr>
        </table>
    </body>
</html>
