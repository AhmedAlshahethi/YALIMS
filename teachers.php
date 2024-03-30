<?php


            require_once 'Conn.php';
            session_start();

if(!isset($_SESSION['username'])){
  header('location: teachers.php');
}

if($_SESSION['type'] == 'teacher'){
    header('location: students.php');
  } else if($_SESSION['type'] == 'student'){
    header('location: marks.php');
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
            <div class="col-lg-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Teachers</h4>
                  <a href="addteacher.php" class="btn btn-success">Add Teacher</a>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                            Username
                          </th>
                          <th>
                            Mobile
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Salary
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
                        $sql = "select * from teachers";
                        $base = $conn->prepare($sql);
                        $base -> execute();
                        if($base->rowcount()>0)
                        {
                          while($row=$base->fetch())
                          {

                              if($row['Status'] == 0 ){
                                $Status = "Unactive";
                                $Statusbtn = '<a href="actionteacher.php?type=activate&id=' . $row['ID'] . '" class="btn btn-warning btn-icon-text">
                                                <i class="mdi mdi-upload btn-icon-prepend"></i>                                                    
                                                Activate
                                              </a>';
                              }
                              elseif($row['Status'] == 1 ){
                                $Status = "Active";
                                $Statusbtn = '<a href="actionteacher.php?type=unactivate&id=' . $row['ID'] . '" class="btn btn-outline-warning btn-icon-text">
                                                <i class="mdi mdi-reload btn-icon-prepend"></i>                                                    
                                                Unactivate
                                              </a>';
                              }



                            echo '<tr>
                            <th>
                              ' . $row['ID'] . '
                            </th>
                            <th>
                            ' . $row['Username'] . '
                            </th>
                            <th>
                            ' . $row['Mobile'] . '
                            </th>
                            <th>
                            ' . $row['Name'] . '

                            </th>
                            <th>
                            ' . $row['Email'] . '
                            </th>
                            <th>
                            ' . $row['Salary'] . '
                            </th>
                            <th>
                            ' . $Status . '
                            </th>
                            <th>
                            ' . $Statusbtn . '
                            <a href="addteacher.php?id=' . $row['ID'] . '" class="btn btn-dark btn-icon-text">
                              <i class="mdi mdi-file-check btn-icon-append"></i>   
                              Edit                       
                            </a>'
                            . '<a href="actionteacher.php?type=delete&id=' . $row['ID'] . '" class="btn btn-danger btn-icon-text">
                            <i class="mdi mdi-file-check btn-icon-append"></i>   
                            Delete                       
                          </a>' .
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