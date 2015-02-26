<?php
    $config = parse_ini_file("server.conf");
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", "{$config['user']}", "{$config['password']}");
    $sql = 'SELECT id, first, last
            FROM users
	    ';
?>
<html>
    <head>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <form action="tickets/list.php" method="get"> 
            <select name="user">
            <?php foreach($db->query($sql) as $row):
                $id = $row['id'];
                $name = $row['first'] . ' ' . $row['last'];
                echo "<option value='$id'>$name</option>";
            endforeach;?>
            </select>
            <input type="submit" value="Log In"></input>
        </form>
    </body>
</html>
