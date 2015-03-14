<?php
    require_once("../start_session.php");
    require_once("../database/user.php");
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
