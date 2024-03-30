<?php

            require_once 'Conn.php';
            session_start();
            if(!isset($_SESSION['username'])){
                header('location: marks.php');
              }
            if($_SESSION['type'] == 'student'){
                header('location: marks.php');
              }
            $bugs = "";
        if(isset($_POST['submit']))
        {
            $Student_ID= htmlspecialchars($_POST['Student_ID']);
            $Mark = htmlspecialchars($_POST['Mark']);
            $CourseLevel = htmlspecialchars($_POST['CourseLevel']);
            $CourseName = htmlspecialchars($_POST['CourseName']);



            if(empty ($Student_ID))
            {
                $bugs="Please enter your student_Id ";
            }

            $stm = "SELECT Id FROM student_inf WHERE Id = $Student_ID ";
            $base = $conn->prepare($stm);
            $base -> execute();
            $data = $base -> fetch();

            if(!isset($_POST['id']) && !$data)
            {
                $bugs = "student_id does not exists ";
            }


            if(empty($Mark))
            {
                $bugs="Please enter your Mark ";
            }

           

            if(empty($CourseLevel))
            {
                $bugs="Please enter your CourseLevel  ";
            }
            
            if(empty($CourseName))
            {
                $bugs="Please enter your CourseName  ";
            }
            

     
            
            if(empty($bugs))
             {
                 //Insert DB
                $stm = "INSERT INTO marks (Student_ID, Mark, CourseLevel, CourseType)
                                            VALUES ($Student_ID, $Mark, $CourseLevel, '$CourseName')";
                if(isset($_POST['id'])){
                    $stm = "UPDATE marks  SET 
                   Student_ID= $Student_ID,
                   Mark = $Mark,
                   CourseLevel = $CourseLevel,
                   CourseName = '$CourseName',
                    WHERE ID = " . $_POST['id'];
                }
                echo $stm;
                $conn->prepare($stm)->execute();
                header("location: marks.php");
             }
        }
        $usrStudent_ID = NULL;
        $usrMark = NULL;
        $usrCourseLevel = NULL;
        $usrCourseName= NULL;
        if(isset($_GET['id'])){
            $stm = " select * SELECT si.Name, m.Mark, m.CourseLevel, s.CourseName FROM `marks` m join courses s on m.CourseType = s.ID join student_inf si on m.Student_ID = si.Id; = " . $_GET['id'] . ";";
            $base = $conn->prepare($stm);
            $base -> execute();
            while($row=$base->fetch()){
                $usrStudent_ID = $row[' Student_ID'];
                $usrMark = $row['Mark'];
                $usrCourseLevel = $row['CourseLevel'];
                $usrCourseName = $row['CourseName'];
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
                  <h4 class="card-title">Add Marks</h4>
                  <p style="color: red; font-size: 1.3em;"><?php echo $bugs ?></p>
                  <form class="forms-sample" action='addmark.php' method='POST'>
                    <div class="form-group">
                      <label for="exampleInputName1">Student_ID</label>
                      <input type="number" name='Student_ID' class="form-control" placeholder="Student_ID" required <?php echo ($usrStudent_ID ? "value='" . $usrStudent_ID . "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Mark</label>
                      <input type="number" name='Mark' class="form-control" id="exampleInputPassword4" placeholder="Mark" required <?php echo ($usrMark ? "value='" . $usrMark . "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">CourseLevel</label>
                      <input type="number" name='CourseLevel' class="form-control" placeholder="CourseLevel" required <?php echo ($usrCourseLevel ? "value='" . $usrCourseLevel . "'": "") ?>>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">CourseName</label>
                      <select name="CourseName" class="form-control">
                        <option value="1" <?php echo (  $usrCourseName == 1 ? "selected" : "") ?>>Level Course</option>
                        <option value="2" <?php echo (  $usrCourseName == 2 ? "selected" : "") ?>>Writing Course</option>
                        <option value="3" <?php echo (  $usrCourseName == 3 ? "selected" : "") ?>>Listing Course</option>
                    </select>
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