<?php
    require_once("../start_session.php");
    $sql = 'SELECT users.id, users.first, users.last, users.email, users.room, positions.title 
            FROM users, positions 
            WHERE users.position = positions.id';
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
        <?php foreach($db->query($sql) as $row): ?>
            <tr>
                <td><a href=<?php echo 'view.php?id=' . $row['id']; ?>>
                            <?php echo $row['first'] . ' ' . $row['last']; ?></a></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['room']; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </body>
</html>
