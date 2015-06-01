<?php
    require_once("../start_session.php");
    require_once("../database/user.php");
    $user = new User($_SESSION['username']);
    function createTable($tickets, $userColumn = true, $consultantColumn = true, $managerColumn = true, $create = true) {
        $str =
        '<table class="tab-content">
            <tr>
                <th>Title</th>';
        if($userColumn)
                $str .= '<th>User</th>';
        if($consultantColumn)
                $str .= '<th>Consultant</th>';
        if($managerColumn)
                $str .= '<th>Manager</th>';
        $str .= '<th>Status</th>
                 <th>Date</th>
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
            
            date_default_timezone_set("America/Los_Angeles");
            $date = date('M j', strtotime($ticket->getDate()));
            $str .= "<td>{$ticket->getStatus()}</td>
                <td>{$date}</td>
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
        <ul class="tabs">
            On this page, you can view the tickets or, if you'd like, create a new ticket.<hr> 
                <li>
                    <input type="radio" checked name="tabs" id="myTab">
                    <label for="myTab">My Tickets</label>
                    <?php echo createTable($user->getTickets(), false, true, false);?>
                </li>
                <?php if($user->getConsultantTickets() !== null):?>
                    <li>
                        <input type="radio" name="tabs" id="consultantTab">
                        <label for="consultantTab">Tickets You Consult For</label>
                        <?php echo createTable($user->getConsultantTickets(), true, false, true);?>
                    </li>
                <?php endif;?>
                <?php if($user->getManagerTickets() !== null):?>
                    <li>
                        <input type="radio" name="tabs" id="managerTab">
                        <label for="managerTab">Tickets You Manage</label>
                        <?php echo createTable($user->getManagerTickets(), true, true, false);?>
                    </li>
                <?php endif;?>
                <?php if($user->getCreate() !== null):?>
                    <li>
                        <input type="radio" name="tabs" id="createTab">
                        <label for="createTicket">Create Ticket</label>
                        <form action="create.php" method="post"> 
                            <input name="title" type ="text" placeholder="Enter Title"></input>
                            <textarea name="description" placeholder="Enter Description"></textarea>
                            <button class="submit" type="submit" >Submit</button>
                        </form>
                    </li>
                <?php endif;?>
        </ul>
    </body>
</html>
