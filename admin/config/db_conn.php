<?php

// Server name of the MySQL database hosted 
$sname= "localhost";

// MySQL username used for authentication
$uname= "root";

// Password associated with the MySQL user (empty in this case)
$password = "";

// name of the database
$db_name = "ipt101";

// Establishin connection to the MySQL database
$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (!$conn) {
    echo "Connection Failed!";
}
?>