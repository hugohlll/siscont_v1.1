<?php

$mysqli = new mysqli('localhost', 'root', 'spider18', 'db_CRUD'); 
 if ($mysqli->connect_error) { 
   die("Error connecting: {$mysqli->connect_errno} {$mysqli->connect_error}\n"); 
 } 
 //else { 
 //  echo "Connected to db_CRUD\n"; 
 //}
 
 $mysqli -> set_charset("utf8");

 ?>
