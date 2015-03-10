<?php
    require_once("../start_session.php");
    $sql = 'SELECT tickets.date, tickets.description, statuses.name AS status, 
                   users.id AS uid, users.first AS ufirst, users.last AS ulast, 
                   consultants.id AS cid, consultants.first AS cfirst, consultants.last AS clast, 
                   managers.id AS mid, managers.first AS mfirst, managers.last AS mlast 
            FROM tickets
            LEFT JOIN statuses ON tickets.status = statuses.id
            LEFT JOIN users ON tickets.user = users.id
            LEFT JOIN users consultants ON tickets.consultant = consultants.id
            LEFT JOIN users managers ON tickets.manager = managers.id
            WHERE tickets.id = ' . $_GET['id'];
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <?php include("../header.php") ?>
        <table>
            <tr>
                <td>User</td>
                <td>Description</td>
                <td>Consultant</td>
                <td>Manager</td>
                <td>Status</td>
                <td>Date</td>
            </tr>
        <?php $ticket = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
                  $uname = $ticket['ufirst'] . ' ' . $ticket['ulast']; 
                  $cname = $ticket['cfirst'] . ' ' . $ticket['clast']; 
                  $mname = $ticket['mfirst'] . ' ' . $ticket['mlast']; 
        ?>
            <tr>
                <td><a href=<?php echo '../users/view.php?id=' . $ticket['uid']; ?>>
                             <?php echo $uname; ?></a></td>
                <td><?php echo $ticket['description']; ?></td>
                <td><a href=<?php echo '../users/view.php?id=' . $ticket['cid']; ?>>
                             <?php echo $cname; ?></a></td>
                <td><a href=<?php echo '../users/view.php?id=' . $ticket['mid']; ?>>
                             <?php echo $mname; ?></a></td>
                <td><?php echo $ticket['status']; ?></td>
                <td><?php echo $ticket['date']; ?></td>
            </tr>
        </table>
    </body>
</html>
