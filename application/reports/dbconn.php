<?php

$servername = HOSTNAME;
$username = USERNAME;
$password = PASSWORD;
$dbname=DATABASE;

try {
  $conn = new PDO("mysql:host=$servername;dbname=".DATABASE, $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>