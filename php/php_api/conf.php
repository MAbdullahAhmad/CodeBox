<?php
  $conf = [
    "host" => "localhost",
    "user" => "root",
    "password" => "",
    "database" => "php_api"
  ];

  function clean($value){
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value, ENT_QUOTES,'UTF-8');
    return $value;
  }
?>