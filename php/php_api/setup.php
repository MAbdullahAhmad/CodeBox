<?php
  require "conf.php";

  // Connection
  $conn = mysqli_connect(
    $conf['host'],
    $conf['user'],
    $conf['password'],
  ); if(!$conn) die("Unable to connect to database!"); //if(!$conn) die("<br><br><br>Unable to connect to database! If yo've not created database yet, create one with command: <br><code>CREATE DATABASE ".$conf['database']."</code>;");

  // Operation
  $database = $conf['database'];
  $sql =
  " CREATE DATABASE IF NOT EXISTS $database;
    USE $database;
    CREATE TABLE IF NOT EXISTS categories(id INT PRIMARY KEY AUTO_INCREMENT, category VARCHAR(100) NOT NULL);
    CREATE TABLE IF NOT EXISTS products(id INT PRIMARY KEY AUTO_INCREMENT, title VARCHAR(254) NOT NULL, category_id INT NOT NULL, price DOUBLE NOT NULL, description TEXT NOT NULL DEFAULT '<no-description>');
  ";
  $green = true;
  foreach(
    explode(";", $sql)
    as $query
  ) if (
      (!empty(trim($query))) &&
      (!mysqli_query($conn, $query))
    ) $green = false;

  // Message
  if($green){
    echo "Setup Successfully Completed";
  } else echo "Unable to complete setup due to DB error: " . mysqli_error($conn) . $query;
?>