<?php
            require_once 'Conn.php';
            session_start();

if(!isset($_SESSION['username'])){
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
        if(isset($_SESSION['id'])){
            $sessionid = $_SESSION['id'];
        }
    }
    
    
    ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Marks</h4>
                  <?php echo ($role < 2 ? '<a href="addmark.php" class="btn btn-success">Add Marks</a>' : ""); ?>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Mark
                          </th>
                          <th>
                          CourseLevel
                          </th>
                          <th>
                          CourseName
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT m.ID, si.Name, m.Mark, m.CourseLevel, s.CourseName FROM `marks` m join courses s on m.CourseType = s.ID join student_inf si on m.Student_ID = si.Id" . (isset($sessionid) ? " where m.Student_ID = $sessionid;" : "");
                        $base = $conn->prepare($sql);
                        $base -> execute();
                        if($base->rowcount()>0)
                        {
                          while($row=$base->fetch())
                          {

                            echo '<tr>
                            <th>
                              ' . $row['ID'] . '
                            </th>
                            <th>
                            ' . $row['Name'] . '
                            </th>
                            <th>
                            ' . $row['Mark'] . '
                            </th>
                            <th>
                            ' . $row['CourseLevel'] . '

                            </th>
                            <th>
                            ' . $row['CourseName'] . '
                            </th>
                            <th>' . ($role < 2 ? ('
                            <a href="addmark.php?id=' . $row['ID'] . '" class="btn btn-dark btn-icon-text">
                              <i class="mdi mdi-file-check btn-icon-append"></i>   
                              Edit                       
                            </a>'
                            . '<a href="actionmark.php?type=delete&id=' . $row['ID'] . '" class="btn btn-danger btn-icon-text">
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