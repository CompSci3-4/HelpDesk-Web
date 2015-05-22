<?php
    require_once("start_session.php");
    require_once("database/user.php");
    $user = new User($_SESSION['username']);
?>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/changePassword.js"></script>
    </head>
    <body>
        <form action="tickets/list.php" method="get"> 
            <button class="submit" type="submit" >Tickets</button>
        </form>
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
        <form id="changePassword">
            <label>New Password<input type="text" id="newPassword"></label>
            <input type="submit" id="submit" value="Change Password">
        </form>
    </body>
</html>
