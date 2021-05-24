<?php
  require "conf.php";

  $conn = mysqli_connect(
    $conf['host'],
    $conf['user'],
    $conf['password'],
    $conf['database']
  ); if(!$conn) die("Unable to connect to database!");
?>