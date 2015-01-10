<?php
    $config = parse_ini_file("../server.conf");
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", "{$config['user']}", "{$config['password']}");
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
