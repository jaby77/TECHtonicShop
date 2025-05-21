<?php

    $con = new mysqli("localhost","root","","techtonic_db");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $con->set_charset("utf8");


 

?>