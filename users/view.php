<?php
    require_once("../start_session.php");
    require_once("../database/user.php");
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
        <?php $user = new User($_GET['id']); ?>
            <tr>
                <td><?php echo $user->getName(); ?></td>
                <td><?php echo $user->getEmail(); ?></td>
                <td><?php echo $user->getTitle(); ?></td>
                <td><?php echo $user->getRoom(); ?></td>
            </tr>
        </table>
    </body>
</html>
