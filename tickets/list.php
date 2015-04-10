<?php
    require_once("../start_session.php");
    require_once("../database/user.php");
    $user = new User($_SESSION['id']);
    function createTable($tickets, $userColumn = true, $consultantColumn = true, $managerColumn = true) {
        $str =
        '<table>
            <tr>
                <td>Title</td>';
        if($userColumn)
                $str .= '<td>User</td>';
        if($consultantColumn)
                $str .= '<td>Consultant</td>';
        if($managerColumn)
                $str .= '<td>Manager</td>';
        $str .= '<td>Status</td>
                 <td>Date</td>
            </tr>';
        foreach($tickets as $ticket){
            $str .= "<tr>
                <td><a href={$ticket->getHTML()}>{$ticket->getTitle()}</a></td>";
            if($userColumn)
                $str .= "<td><a href={$ticket->getUser()->getHTML()}>{$ticket->getUser()->getName()}</a></td>";
            if($consultantColumn)
                $str .= "<td><a href={$ticket->getConsultant()->getHTML()}>{$ticket->getConsultant()->getName()}</a></td>";
            if($managerColumn)
                $str .= "<td><a href={$ticket->getManager()->getHTML()}>{$ticket->getManager()->getName()}</a></td>";
            $str .= "<td>{$ticket->getStatus()}</td>
                <td>{$ticket->getDate()}</td>
                </tr>";
        }
        return $str . '</table>';
    }
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
        <?php echo createTable($user->getTickets(), false, true, true);?>
        <?php if($user->getConsultantTickets() !== null):?>
            <h2>Tickets You Consult For</h2>
            <?php echo createTable($user->getConsultantTickets(), true, false, true);?>
        <?php endif;?>
        <?php if($user->getManagerTickets() !== null):?>
            <h2>Tickets You Manage</h2>
            <?php echo createTable($user->getManagerTickets(), true, true, false);?>
        <?php endif;?>
        <h2>Create a Ticket</h2>
        <form action="create.php" method="post"> 
            <input name="title" type ="text" placeholder="Enter Title"></input>
            <textarea name="description" placeholder="Enter Description"></textarea>
            <button class="submit" type="submit" >Submit</button>
        </form>
    </body>
</html>
