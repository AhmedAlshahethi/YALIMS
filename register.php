<?php
session_start();
        
        if(isset($_SESSION['username']))
        {
           header('Location: index.html');
        }else if(isset($_COOKIE['username'])&& isset($_COOKIE['password']))
        {
            header('Location: Login.php');
        }
        ?>

<!DOCTYPE html>
<head>
    <title> English Acadmey - Home page </title>
    
    <!--main style-->
    <link rel="stylesheet" href="./css/style2.css">
</head>

<body>


            

   
    <!--Register-->
    <?php  

        
        


        if(isset($_POST['submit']))
        {
            require_once 'Conn.php';
            $name = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['password']);
            $email = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
            $tel = filter_var($_POST['phone'] , FILTER_SANITIZE_NUMBER_INT);
            $date = htmlspecialchars($_POST['birthdate']);
            $username = htmlspecialchars($_POST['username']);
            $coursetype = htmlspecialchars($_POST['coursetype']);
            $time = htmlspecialchars($_POST['time']);

            $filename = $_FILES["img"]["name"];
	        $tempname = $_FILES["img"]["tmp_name"];
		    $folder = "imgs/".$filename;


            

            

           








            $bugs = [];

            if(empty($name))
            {
                $bugs[]="Please enter your name ";
            }
            elseif(strlen($name) > 50)
            {
                $bugs[]=" please the name should be less  ";
            }


             
             if(empty($email))
             {
                 $bugs[]="Please enter your email ";
             }
             elseif(filter_var($email , FILTER_SANITIZE_EMAIL) == false )
             {
                 $bugs[]="Email is wrong ";
             }

             $stm = "SELECT Email FROM student_inf WHERE Email = '$email' ";
             $base = $conn->prepare($stm);
             $base -> execute();
             $data = $base -> fetch();

             if($data)
             {
                 $bugs[] = "Email is already used ";
             }


              //validate password
            if(empty($password))
            {
                $bugs[]="Please enter your password ";
            }
            elseif(strlen($password) < 6)
            {
                $bugs[]="The password must be more than 6 characters ";
            }


            if(empty($tel))
            {
                $bugs[]="Please enter your phone number ";
            }
            elseif(strlen($tel)!=9)
            {
                $bugs[]="The phone number must be 9 digits ";
            }
            elseif($tel < 700000000 || $tel > 779999999 )
            {
                $bugs[]="Please enter a vaild phone number ";
            }

            if(empty($date))
            {
                $bugs[]="Please enter your birthdate ";
            }

            if(empty($username))
            {
                $bugs[]="Please enter your usernaem ";
            }
            

            $stm = "SELECT Username FROM student_inf WHERE Username	 = '$username' ";
            $base = $conn->prepare($stm);
            $base -> execute();
            $data = $base -> fetch();

            if($data)
            {
                $bugs[] = "Username is already used ";
            }

            if($coursetype !=1 && $coursetype!=2 && $coursetype!=3)
            {
                $bugs[]="Wrong course type was sent, please try agian ";
            }


            if($time != '8:30' && $time != '10:30' && $time != '12:30' && $time != '2:30' && $time != '4:30')
            {
                $bugs[]="Wrong time was sent, please try agian ";
            }


            
		
		    if (!move_uploaded_file($tempname, $folder)) 
                {
                    $bugs[]= "Failed to upload image";
                }
           
    
             if(empty($bugs))
             {
                 //Insert DB
                $encryptedPassword = Crypt(md5($password), sha1($password));
                $stm = "INSERT INTO `student_inf` (`Name`, `Email`, `Phone`, `Birthdate`, `Username`, `Password`, `CourseType`, `Time`, `img`)
                                            VALUES ('$name', '$email', $tel, '$date', '$username', '$encryptedPassword', $coursetype, '$time', '$filename')";
                $conn->prepare($stm)->execute();
                $_SESSION['username'] = $username;
                setcookie('username', $username,time()+3600*24*7,"/");
                setcookie('password', $password,time()+3600*24*7,"/");
                header('location: login.php');

             }

           
        }
    ?>

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



<section id="Register" >
        <div class="Register bg-primary py-3 text-center "> 
            <h2 class="m-heading py-3"> Register Now </h2>
            <form action = "register.php" method="POST" enctype="multipart/form-data">
                <?php
                
                if(isset($bugs))
                {
                    if(!empty($bugs))
                    {
                        foreach ($bugs as $msg)
                        {
                            echo $msg . "<br>";
                        }
                    }
                }
                
                ?>
                <input type ="text" name = "name" placeholder = "Name" required><br><br>
                <input type ="email" name = "email" placeholder = "Email" required><br><br>
                <input type ="password" name = "password" placeholder = "Password" required><br><br>
                <input type="tel" name="phone" placeholder="Phone Number" required><br><br>
                <input type="date" name="birthdate" placeholder="BirthDate" required><br><br>
                <input type="text" name="username" placeholder="Username" required><br><br>
                <label for="img">upload your image</label>
                <input type="file" name="img" id="img" placeholder="Img"  required><br><br>
                <select name="coursetype">
                    <option value="1">Level Course</option>
                    <option value="2">Writing Course</option>
                    <option value="3">Listing Course</option>
                </select>
                <br><br>

                <select name="time">
                    <option value="8:30">8:30 - 10:30</option>
                    <option value="10:30">10:30 - 12:30</option>
                    <option value="12:30">12:30 - 2:30</option>
                    <option value="2:30">2:30 - 4:30</option>
                    <option value="4:30">4:30 - 6:30</option>


                </select>
                <br>
                <br>



                <input type ="submit" name = "submit" placeholder = "Register">
            </form>
        </div>
</section>

    
    
    <!--footer-->
    <footer class="bg-dark py-2 text-center">
        <p>Copyright 2022, New Horizons, All Rights Reserved </p>

    </footer>


</body>