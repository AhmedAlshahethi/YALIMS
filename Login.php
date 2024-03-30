<?php
session_start();
        
        /*if(isset($_SESSION['username']))
        {
           header('Location: index.html');
        }else if(isset($_COOKIE['username'])&& isset($_COOKIE['password']))
        {
            $username=$_COOKIE['username'];
            $password=$_COOKIE['password'];
        }*/

        if(isset($_POST['submit']))
        {
            require_once 'Conn.php';
            $username= htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);

            $stm = " select *  FROM student_inf WHERE Username  = '$username' and Password= '" . Crypt(md5($password), sha1($password)) . "'  and Status=1";
            $base = $conn->prepare($stm);
            $base -> execute();
            $data = $base -> fetch();

            if(!$data)
            {
                $bug = "Username or password is wrong";
            }
            else{
                $_SESSION['id'] = $data['Id'];
                $_SESSION['username'] = $username;
                $_SESSION['type']='student';
                setcookie('username', $username,time()+3600*24*7,"/");
                setcookie('password', $password,time()+3600*24*7,"/");
                header('location: marks.php ');

            }

        }


        ?>







<!DOCTYPE html>
<head>
    <title> English Acadmey - Home page </title>
    
    <!--main style-->
    <link rel="stylesheet" href="./css/style2.css">

    <script src="js/Login.js"></script>

</head>





<body >
    <nav  id="navbar" class="bg-dark"> 
        <div class="logo"> 
            <img src="./img/logo.png" alt="logo">
        </div>
        <ul>
        <li><a href="index.html">Home</a></li>
            <li><a href="About.html">About</a></li>
            <li><a href="Courses.html">Courses</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="Login.php">Login</a></li>
            <li><a href="SignAdmin.php">Sign admin</a></li>
        </ul>

    </nav>
    <div class="Register bg-primary py-3 text-center "> 
        <h2 class="m-heading py-3"> Login </h2>
        <form name="form" onsubmit="Verfiy() ;" method="POST" action="Login.php"> 
        <?php if(isset($bug)) echo $bug ?>
            <div>
                <input type="text" name="username" placeholder="Username">
            </div>
            <div>
                <input type="password" name="password" placeholder="Password">
            </div>
            <input class="btn" type="Submit" name="submit" value="Submit" placeholder="Submit">
            <span style="display:block;">Don't Have an Acount, <a href="register.php">Register Now!</a></span>
        </form>
    </div>
















     <!--footer-->
     <footer class="bg-dark py-2 text-center">
        <p>Copyright 2022, New Horizons, All Rights Reserved </p>

    </footer>