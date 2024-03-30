<?php

require_once 'Conn.php';
            session_start();
if(!isset($_SESSION['username'])){
    header('location: marks.php');
  }
if($_SESSION['type'] == 'teacher'){
    header('location: students.php');
  } else if($_SESSION['type'] == 'student'){
    header('location: marks.php');
  }
            $bugs = "";
        if(isset($_POST['submit']))
        {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $email = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
            $tel = filter_var($_POST['mobile'] , FILTER_SANITIZE_NUMBER_INT);
            $name = htmlspecialchars($_POST['name']);
            $Birthdate =htmlspecialchars($_POST['Birthdate']);
            $CourseType = htmlspecialchars($_POST['CourseType']);
            $Level = htmlspecialchars($_POST['Level']);
            $Time = htmlspecialchars($_POST['Time']);

            $filename = $_FILES["img"]["name"];
	        $tempname = $_FILES["img"]["tmp_name"];
		    $folder = "imgs/".$filename;

            if(isset($_POST['statues'])){
                if($_POST['statues'] == 'on')
                    $statue = 1;
                else
                    $statue = 0;
            } else {
                $statue = 0;
            }

             if(empty($email))
             {
                 $bugs="Please enter your email ";
             }
             elseif(filter_var($email , FILTER_SANITIZE_EMAIL) == false )
             {
                 $bugs="Email is wrong ";
             }

             $stm = "SELECT Email FROM student_inf WHERE Email = '$email' ";
             $base = $conn->prepare($stm);
             $base -> execute();
             $data = $base -> fetch();

             if(!isset($_POST['id']) && $data)
             {
                 $bugs = "Email is already used ";
             }


              //validate password
            if(empty($password))
            {
                $bugs="Please enter your password ";
            }
            elseif(strlen($password) < 6)
            {
                $bugs="The password must be more than 6 characters ";
            }


            if(empty($tel))
            {
                $bugs="Please enter your phone number ";
            }
            elseif(strlen($tel)!=9)
            {
                $bugs="The phone number must be 9 digits ";
            }
            elseif($tel < 700000000 || $tel > 779999999 )
            {
                $bugs="Please enter a vaild phone number ";
            }


            if(empty($Birthdate))
            {
                $bugs="Please enter your birthdate ";
            }


            if($CourseType !=1 && $CourseType!=2 && $CourseType!=3)
            {
                $bugs="Wrong course type was sent, please try agian ";
            }


            if($Time != '8:30' && $Time != '10:30' && $Time != '12:30' && $Time != '2:30' && $Time != '4:30')
            {
                $bugs="Wrong time was sent, please try agian ";
            }


            if (!move_uploaded_file($tempname, $folder)) 
            {
                $bugs= "Failed to upload image";
            }


            if(empty($username))
            {
                $bugs="Please enter your username ";
            }

            if(empty($name))
            {
                $bugs="Please enter your name ";
            }

            
            $stm = "SELECT Username FROM student_inf WHERE Username = '$username' ";
            $base = $conn->prepare($stm);
            $base -> execute();
            $data = $base -> fetch();

            if(!isset($_POST['id']) && $data)
            {
                $bugs = "Username is already used ";
            }



            if(empty($bugs))
             {
                 //Insert DB
                $encryptedPassword = Crypt(md5($password), sha1($password));
                $stm = "INSERT INTO student_inf (Email, Phone, Username, Password, Name, Birthdate, CourseType, Level, Time, `img` )
                                            VALUES ('$email', $tel, '$username', '$encryptedPassword', '$name',  '$Birthdate',  $CourseType,  $Level, '$Time', '$filename' )";
                if(isset($_POST['id'])){
                    $stm = "UPDATE student_inf  SET 
                    Email = '$email',
                    Phone = $tel,
                    Username = '$username',
                    Password = '$encryptedPassword',
                    name = '$name',
                    Birthdate = '$Birthdate',
                    CourseType = $CourseType,
                    Level= $Level,
                    Time= '$Time',
                    img= '$filename',




                    Status = $statue
                    WHERE ID = " . $_POST['id'];
                }
                echo $stm;
                $conn->prepare($stm)->execute();
                header("location: students.php");
             }
        }
        $usrEmail = NULL;
        $usrMobile = NULL;
        $usrUsername = NULL;
        $usrPassword = NULL;
        $usrName = NULL;
        $usrBirthdate= NULL;
        $usrLevel= NULL;
        $usrTime= NULL;
        $usrCourseType= NULL;
        $usrfilename =NULL;
        $usrStatus = NULL;
        if(isset($_GET['id'])){
            $stm = " select * from student_inf where ID = " . $_GET['id'] . ";";
            $base = $conn->prepare($stm);
            $base -> execute();
            while($row=$base->fetch()){
                $usrEmail = $row['Email'];
                $usrMobile = $row['Phone'];
                $usrUsername = $row['Username'];
                $usrPassword = $row['Password'];
                $usrName = $row['Name'];
                $usrBirthdate= $row['Birthdate'];
                $usrLevel= $row['Level'];
                $usrTime= $row['Time'];
                $usrCourseType= $row['CourseType'];
                $usrfilename = $row['img'];
                $usrStatus = $row['Status'];
            }

        }
            ?>



    <!-- partial:./partials/_sidebar.html -->
    <?php 
    if($_SESSION['type'] == 'Admin'){
        include '_navbar.php';
    } else if($_SESSION['type'] == 'teacher'){
        include 'teachernavbar.php';
    } else if($_SESSION['type'] == 'student'){
        include 'studentnavbar.php';
    }
    ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
          <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Students</h4>
                  <p style="color: red; font-size: 1.3em;"><?php echo $bugs ?></p>
                  <form class="forms-sample" action='addstudent.php' method='POST' enctype="multipart/form-data">
                    <div class="form-group"> 
                      <label for="exampleInputName1">Username</label>
                      <input type="text" name='username' class="form-control" placeholder="Username" required <?php echo ($usrUsername ? "value='" . $usrUsername . "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Password</label>
                      <input type="password" name='password' class="form-control" id="exampleInputPassword4" placeholder="Password" required <?php echo ($usrPassword ? "value='" . $usrPassword . "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Email</label>
                      <input type="email" name='email' class="form-control" placeholder="Email" required <?php echo ($usrEmail ? "value='" . $usrEmail . "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Mobile Number</label>
                      <input type="tel" name='mobile' class="form-control" placeholder="Mobile" required <?php echo ($usrMobile ? "value='" . $usrMobile . "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Name</label>
                      <input type="text" name='name' class="form-control" placeholder="Name" required <?php echo  ($usrName ? "value='" .  $usrName . "'": "") ?>>
                     
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Birthdate</label>
                      <input type="date" name='Birthdate' class="form-control" placeholder="Birthdate" required <?php echo ( $usrBirthdate ? "value='" .   $usrBirthdate . "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">CourseType</label>
                      <select name="CourseType" class="form-control">
                        <option value="1" <?php echo (  $usrCourseType == 1 ? "selected" : "") ?>>Level Course</option>
                        <option value="2" <?php echo (  $usrCourseType == 2 ? "selected" : "") ?>>Writing Course</option>
                        <option value="3" <?php echo (  $usrCourseType == 3 ? "selected" : "") ?>>Listing Course</option>
                    </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Level</label>
                      <input type="number" name='Level' class="form-control" placeholder="Level" required <?php echo (   $usrLevel ? "value='" .    $usrLevel. "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Time</label>
                      <select name="Time" class="form-control">
                    <option value="8:30" <?php echo ($usrTime == '08:30:00' ? "selected": "") ?>>8:30 - 10:30</option>
                    <option value="10:30" <?php echo ($usrTime == '10:30:00' ? "selected": "") ?>>10:30 - 12:30</option>
                    <option value="12:30" <?php echo ($usrTime == '12:30:00' ? "selected": "") ?>>12:30 - 2:30</option>
                    <option value="2:30" <?php echo ($usrTime == '02:30:00' ? "selected": "") ?>>2:30 - 4:30</option>
                    <option value="4:30" <?php echo ($usrTime == '04:30:00' ? "selected": "") ?>>4:30 - 6:30</option>


                </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail3">img</label>
                      <input type="file" name='img' class="form-control" placeholder="img" required >
                    </div>
                    <?php
                        if(isset($_GET['id'])){
                            
                          echo '
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label">
                                    <input type="checkbox" name="statues" class="form-check-input" ' . ($usrStatus == 1 ? "checked": "") . '>
                                    Active
                                    <i class="input-helper"></i></label>
                                </div>
                                <input type="hidden" name="id" value="' . $_GET['id'] . '">';
                        }
                    ?>
                    <button type="submit" name="submit" class="btn btn-primary me-2">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- row end -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:./partials/_footer.html -->
        
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
<?php include 'footer.php' ?>
  
</body>

</html>