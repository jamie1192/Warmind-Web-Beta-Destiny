<?php

    $user="website";
    $password="password";
    $host="localhost";
    $db="datastore";
    $connection = mysqli_connect($host, $user, $password, $db);
    
    if(!$connection){
        echo "Connection Error";
    }

?>