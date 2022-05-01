<?php
include 'includes/header.php';
include 'includes/config.php';

$query="SELECT users.*,course.course_name FROM users 
        LEFT JOIN course ON course.id = users.course WHERE users.status=0 ORDER BY users.id DESC";
$view_users= mysqli_query($conn,$query);
?>
    <div class="container">
    <h1 class="text-center" >NPTEL Student Management</h1>
      <a href="register.php" class='btn btn-outline-dark mb-2'> <i class="bi bi-person-plus"></i> Registeration Form</a>

        <table class="table table-striped table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th  scope="col">ID</th>
              <th  scope="col">Name</th>
              <th  scope="col">DOB</th>
              <th  scope="col">Email Id</th>
              <th  scope="col">Address</th>
              <th  scope="col">Course</th>
              <th  scope="col">Photo</th>
              <th  scope="col" colspan="3" class="text-center">Operations</th>
            </tr>  
          </thead>
            
            <?php if(mysqli_num_rows($view_users) > 0)  {?>
              <tbody>
              <tr>
            <?php
            $i=1;
            while($row= mysqli_fetch_assoc($view_users)){
              $id = $row['id'];
              $sno = $i;                
              $name = $row['name'];        
              $dob = $row['dob'];         
              $emailid = $row['emailid'];  
              $address = $row['address'];        
              $course = $row['course_name'];
              $photo = "uploads/".$row['photo'];        

              echo "<tr >";
              echo " <th scope='row' >$sno</th>";
              echo " <td >$name</td>";
              echo " <td >$dob</td>";
              echo " <td >$emailid </td>";
              echo " <td >$address</td>";
              echo " <td >$course </td>";
              echo " <td ><img src='$photo' height='40' width='60'></td>";

              echo " <td class='text-center'> <a href='view.php?user_id={$id}' class='btn btn-primary'> <i class='bi bi-eye'></i> View</a> </td>";

              echo " <td class='text-center' > <a href='update.php?edit&user_id={$id}' class='btn btn-secondary'><i class='bi bi-pencil'></i> EDIT</a> </td>";

              echo " <td  class='text-center'>  <a href='delete.php?delete={$id}' class='btn btn-danger'> <i class='bi bi-trash'></i> DELETE</a> </td>";
              echo " </tr> ";
              $i++;
                  }  
                ?>
              </tr>  
              </tbody>
              <?php }else{?>
                <tbody>
              <tr><td colspan="7"> No Records Found</td> </tr>
              </tbody>
              <?php } ?>
           
        </table>
    </div>
<?php include "includes/footer.php" ?>
