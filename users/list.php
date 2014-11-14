<?php
    $db = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'ljhs');
    $sql = 'SELECT users.id, users.first, users.last, users.email, users.room, positions.title 
            FROM users, positions 
            WHERE users.position = positions.id';
?>
<html>
    <body>
        <table>
            <tr>
                <td>Name</td>
                <td>Email</td>
                <td>Position</td>
                <td>Room #</td>
            </tr>
        <?php foreach($db->query($sql) as $row): ?>
            <tr>
                <td><a href=<?php echo 'http://localhost/users/view.php?id=' . $row['id']; ?>>
                            <?php echo $row['first'] . ' ' . $row['last']; ?></a></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['room']; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </body>
</html>
