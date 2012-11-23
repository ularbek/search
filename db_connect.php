<?php

include 'database_info.php';

$conn = mysql_connect($host, $username, $pass);
if(!$conn){
    die('Could not connect: '.mysql_error());
}

mysql_close($conn);
?>