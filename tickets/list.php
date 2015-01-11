<?php
    session_start();
    if(isset($_GET['user']))
        $_SESSION['id'] = $_GET['user'];
    if(!isset($_SESSION['id']))
        header('Location: http://localhost/helpdesk/login.php', TRUE, 302);
    $config = parse_ini_file("../server.conf");
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", "{$config['user']}", "{$config['password']}");
    $sql = "SELECT tickets.id, tickets.date, statuses.name AS status, 
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
    <body>
        <table>
            <tr>
                <td>ID</td>
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
                             <?php echo $row['id']; ?></a></td>
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
            <textarea name="description" placeholder="Enter Description"></textarea>
            <input type="submit" value="Create Ticket"></input>
        </form>
    </body>
</html>
