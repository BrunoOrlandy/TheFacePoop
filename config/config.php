<?php

ob_start();

session_start();

$host = "localhost";
$user = "postgres"; 
$password = "1234"; 
$bd = "facepoop";

$con  = pg_pconnect("host=localhost dbname=postgres user=postgres password=1234"); 

?>
