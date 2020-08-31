<?php
    define("HOST", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DB_NAME", "forum");

    $mysql_con = new mysqli(HOST, USERNAME, PASSWORD, DB_NAME);

    if($mysql_con->connect_error) {
        die("Connection failed: ".connect_error);
    }
?>