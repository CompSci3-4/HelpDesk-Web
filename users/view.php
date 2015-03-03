<?php
    include("../start_session.php");
    $sql = 'SELECT users.id, users.first, users.last, users.email, users.room, positions.title 
            FROM users, positions 
            WHERE users.position = positions.id and users.id = ' . $_GET['id'];
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <?php include("../header.php") ?>
        <table>
            <tr>
                <td>Name</td>
                <td>Email</td>
                <td>Position</td>
                <td>Room #</td>
            </tr>
        <?php $user = $db->query($sql)->fetch(PDO::FETCH_ASSOC); ?>
            <tr>
                <td><?php echo $user['first'] . ' ' . $user['last']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['title']; ?></td>
                <td><?php echo $user['room']; ?></td>
            </tr>
        </table>
    </body>
</html>
