<?php

    $dbHost="localhost";
    $dbUser="root";
    $dbpass="";
    $dbname="newhorizons"; 

    try {
        $conn = new PDO("mysql:host=$dbHost;dbname=$dbname", $dbUser, $dbpass );
    }

    catch(Exception $e)
    {
        echo $e->getMessage();
        exit();
    }

?>