<?php 

// $mysqli = new mysqli("127.0.0.1", "root", "Anthony2019$", "clockrepair", "3310"); 
$mysqli = new mysqli("novoples.c2hmcd4sdhf1.us-east-1.rds.amazonaws.com", "dev", "ved", "dev-sgf");  


if ($mysqli->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>
