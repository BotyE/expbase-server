<?PHP
        $server = 'localhost';
        $username = 'root';
        $password = 'root';
        $database = 'expbase';
        $connection = mysqli_connect($server, $username, $password, $database, 4306);
        mysqli_set_charset($connection, 'utf8');
        ?>