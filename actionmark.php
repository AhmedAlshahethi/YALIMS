<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location: marks.php');
  }
if($_SESSION['type'] == 'student'){
    header('location: marks.php');
  }
require_once 'Conn.php';

if(isset($_GET['type'])){
    $type = $_GET['type'];
}
switch ($type){
    case 'delete':
        if(isset($_GET['id'])){
            $stm = "DELETE FROM marks
            WHERE ID = " . $_GET['id'];
        }
        break;
}
$conn->prepare($stm)->execute();
header("location: marks.php");
?>