<?php


            require_once 'Conn.php';
            session_start();

if(!isset($_SESSION['username'])){
  header('location: students.php');
}
if($_SESSION['type'] == 'student'){
    header('location: marks.php');
  }
            ?>



    <!-- partial:./partials/_sidebar.html -->
    <?php 
    if($_SESSION['type'] == 'Admin'){
        include '_navbar.php';
        $role = 0;
    } else if($_SESSION['type'] == 'teacher'){
        include 'teachernavbar.php';
        $role = 1;
    } else if($_SESSION['type'] == 'student'){
        include 'studentnavbar.php';
        $role = 2;
    }
    ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Students</h4>
                  <?php echo ($role < 1 ? '<a href="addstudent.php" class="btn btn-success">Add Student</a>' : ""); ?>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                            Picture
                          </th>
                          <th>
                            Username
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Mobile
                          </th>
                          <th>
                          Birthdate
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Course Type
                          </th>
                          </th>
                          <th>
                            Level
                          </th>
                          <th>
                            Time
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "select * from student_inf";
                        $base = $conn->prepare($sql);
                        $base -> execute();
                        if($base->rowcount()>0)
                        {
                          while($row=$base->fetch())
                          {

                              if($row['Status'] == 0 ){
                                $Status = "Unactive";
                                $Statusbtn = '<a href="actionstudent.php?type=activate&id=' . $row['Id'] . '" class="btn btn-warning btn-icon-text">
                                                <i class="mdi mdi-upload btn-icon-prepend"></i>                                                    
                                                Activate
                                              </a>';
                              }
                              elseif($row['Status'] == 1 ){
                                $Status = "Active";
                                $Statusbtn = '<a href="actionstudent.php?type=unactivate&id=' . $row['Id'] . '" class="btn btn-outline-warning btn-icon-text">
                                                <i class="mdi mdi-reload btn-icon-prepend"></i>                                                    
                                                Unactivate
                                              </a>';
                              }



                            echo '<tr>
                            <th>
                              ' . $row['Id'] . '
                            </th>
                            <th>
                            <img width="80px" src="imgs/' . $row['img'] . '">
                            </th>
                            <th>
                            ' . $row['Username'] . '
                            </th>
                            <th>
                            ' . $row['Email'] . '

                            </th>
                            <th>
                            ' . $row['Phone'] . '
                            </th>
                            <th>
                            ' . $row['Birthdate'] . '
                            </th>
                            <th>
                            ' . $row['Name'] . '
                            </th>
                            <th>
                            ' . $row['CourseType'] . '
                            </th>
                            <th>
                            ' . $row['Level'] . '
                            </th>
                            <th>
                            ' . $row['Time'] . '
                            </th>
                            <th>
                            ' . $Status . '
                            </th>
                            <th>
                            ' . ($role < 1 ? ($Statusbtn . '
                            <a href="addstudent.php?id=' . $row['Id'] . '" class="btn btn-dark btn-icon-text">
                              <i class="mdi mdi-file-check btn-icon-append"></i>   
                              Edit                       
                            </a>'
                            . '<a href="actionstudent.php?type=delete&id=' . $row['Id'] . '" class="btn btn-danger btn-icon-text">
                            <i class="mdi mdi-file-check btn-icon-append"></i>   
                            Delete                       
                          </a>') : "") .
                            '</th>
                          </tr>';
                          }
                        }



                        ?>
                  
                      </tbody>
                    </table>
                  </div>
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