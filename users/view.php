<?php
    $config = parse_ini_file("../server.conf");
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", "{$config['user']}", "{$config['password']}");
    $sql = 'SELECT users.id, users.first, users.last, users.email, users.room, positions.title 
            FROM users, positions 
            WHERE users.position = positions.id and users.id = ' . $_GET['id'];
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
