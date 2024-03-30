<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location: marks.php');
  }
if($_SESSION['type'] == 'teacher'){
    header('location: students.php');
  } else if($_SESSION['type'] == 'student'){
    header('location: marks.php');
  }
  
require_once 'Conn.php';

if(isset($_GET['type'])){
    $type = $_GET['type'];
}
switch ($type){
    case 'unactivate':
        if(isset($_GET['id'])){
            $stm = "UPDATE admin_users SET 
            Status = 0
            WHERE ID = " . $_GET['id'];
        }
        break;
    case 'activate':
        if(isset($_GET['id'])){
            $stm = "UPDATE admin_users SET 
            Status = 1
            WHERE ID = " . $_GET['id'];
        }
        break;
    case 'delete':
        if(isset($_GET['id'])){
            $stm = "DELETE FROM admin_users
            WHERE ID = " . $_GET['id'];
        }
        break;
}
$conn->prepare($stm)->execute();
header("location: login2.php");
?>