<?php
    require_once("../start_session.php");
    $sql = "SELECT tickets.id, tickets.title, tickets.date, statuses.name AS status, 
                   users.id AS uid, users.first AS ufirst, users.last AS ulast, 
                   consultants.id AS cid, consultants.first AS cfirst, consultants.last AS clast, 
                   managers.id AS mid, managers.first AS mfirst, managers.last AS mlast 
            FROM tickets
            LEFT JOIN statuses ON tickets.status = statuses.id
            LEFT JOIN users ON tickets.user = users.id
            LEFT JOIN users consultants ON tickets.consultant = consultants.id
            LEFT JOIN users managers ON tickets.manager = managers.id
            WHERE tickets.user = {$_SESSION['id']}
            ORDER BY tickets.date DESC
            ";
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
        <?php foreach($db->query($sql) as $row):
                  $uname = $row['ufirst'] . ' ' . $row['ulast']; 
                  $cname = $row['cfirst'] . ' ' . $row['clast']; 
                  $mname = $row['mfirst'] . ' ' . $row['mlast']; 
        ?>
            <tr>
                <td><a href=<?php echo 'view.php?id=' . $row['id']; ?>>
                             <?php echo $row['title']; ?></a></td>
                <td><a href=<?php echo '../users/view.php?id=' . $row['uid']; ?>>
                             <?php echo $uname; ?></a></td>
                <td><a href=<?php echo '../users/view.php?id=' . $row['cid']; ?>>
                             <?php echo $cname; ?></a></td>
                <td><a href=<?php echo '../users/view.php?id=' . $row['mid']; ?>>
                             <?php echo $mname; ?></a></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['date']; ?></td>
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
