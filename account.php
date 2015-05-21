<?php
    require_once("start_session.php");
    require_once("database/user.php");
    $user = new User($_SESSION['username']);
?>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <table>
            <tr>
                <td>Username</td>
                <td><?php echo $user->getUsername();?></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo $user->getName();?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo $user->getEmail();?></td>
            </tr>
            <tr>
                <td>Room Number</td>
                <td><?php echo $user->getRoom();?></td>
            </tr>
            <tr>
                <td>Position</td>
                <td><?php echo $user->getPosition();?></td>
            </tr>
        </table>
    </body>
</html>
