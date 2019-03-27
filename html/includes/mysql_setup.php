<?php
 // Database credentials 
 define('DB_SERVER', 'localhost');
 define('DB_USERNAME', 'u480593864_space');
 define('DB_PASSWORD', 'KuuW`;343ly[bSbe0*');
 define('DB_NAME', 'u480593864_space');
 
 // connect to database
 $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
 // check connection
 if($link === false){
  die("Err: Could not connect to database." . mysqli_connect_error());
}
?>
I
