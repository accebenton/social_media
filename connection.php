<?php

//variables to hold database login info 
$dbhost = "lochnagar.abertay.ac.uk";
$dbuser = "sql2307505";
$dbpass = "canal-easier-piece-movie";
$dbname = "sql2307505";

//initialize the variable first
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// $con means "is connected" - ! is not operator
if (!$con) {
    die("Failed to connect!");
    
}
?>