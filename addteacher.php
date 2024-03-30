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
            $salary = filter_var($_POST['salary'],FILTER_SANITIZE_NUMBER_FLOAT);
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

             $stm = "SELECT Email FROM admin_users WHERE Email = '$email' ";
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

            if(empty($username))
            {
                $bugs="Please enter your username ";
            }

            if(empty($name))
            {
                $bugs="Please enter your name ";
            }

            if(empty($salary))
            {
                $bugs="Please enter your salary ";
            }
            

            $stm = "SELECT Username FROM teachers WHERE Username = '$username' ";
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
                $stm = "INSERT INTO teachers (Email, Mobile, Username, Password, Name, Salary)
                                            VALUES ('$email', $tel, '$username', '$encryptedPassword', '$name', $salary)";
                if(isset($_POST['id'])){
                    $stm = "UPDATE teachers  SET 
                    Email = '$email',
                    Mobile = $tel,
                    Username = '$username',
                    Password = '$encryptedPassword',
                    name = '$name';
                    salary= $salary;
                    Status = $statue
                    WHERE ID = " . $_POST['id'];
                }
                echo $stm;
                $conn->prepare($stm)->execute();
                header("location: teachers.php");
             }
        }
        $usrEmail = NULL;
        $usrMobile = NULL;
        $usrUsername = NULL;
        $usrPassword = NULL;
        $usrName = NULL;
        $usrSalary = Null;
        $usrStatus = NULL;
        if(isset($_GET['id'])){
            $stm = " select * from teachers where ID = " . $_GET['id'] . ";";
            $base = $conn->prepare($stm);
            $base -> execute();
            while($row=$base->fetch()){
                $usrEmail = $row['Email'];
                $usrMobile = $row['Mobile'];
                $usrUsername = $row['Username'];
                $usrPassword = $row['Password'];
                $usrName = $row['Name'];
                $usrSalary = $row['Salary'];
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
                  <h4 class="card-title">Add Teachers</h4>
                  <p style="color: red; font-size: 1.3em;"><?php echo $bugs ?></p>
                  <form class="forms-sample" action='addteacher.php' method='POST'>
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
                      <label for="exampleInputEmail3">Salary</label>
                      <input type="number" name='salary' class="form-control" placeholder="Salary" required <?php echo ( $usrSalary ? "value='" .  $usrSalary . "'": "") ?>>
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