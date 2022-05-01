<?php 
include 'includes/header.php';
include 'includes/config.php';

if(isset($_GET['user_id']))
{
  $userid = $_GET['user_id']; 
}

$getQuery = "Select id, course_name from course where status=0";
$getCourse = mysqli_query($conn,$getQuery); 

$query="SELECT users.*,course.course_name FROM users 
LEFT JOIN course ON course.id = users.course WHERE users.id = $userid AND users.status=0 ORDER BY users.id DESC";
$view_users= mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($view_users))
{
    $id = $row['id'];
    $name = $row['name'];        
    $dob = $row['dob'];         
    $emailid = $row['emailid'];  
    $address = $row['address']; 
    $photo = $row['photo'];    
    $courseId = $row['course'];   
    $course = $row['course_name'];  
}
        
?>

<h1 class="text-center">Update User Details</h1>
  <div class="container ">
    <form action="" method="post">
      <div class="form-group">
        <label for="user" >Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" disabled>
      </div>

      <div class="form-group">
        <label for="dob" class="form-label">DOB</label>
        <input type="date" name="dob"  class="form-control" value="<?php echo $dob; ?>" disabled>
      </div>

      <div class="form-group">
        <label for="emailid" class="form-label">Email ID</label>
        <input type="email" name="emailid"  class="form-control" value="<?php echo $emailid; ?>" disabled>
      </div>

      <div class="form-group">
        <label for="address" class="form-label">Address</label>
        <textarea type="text" name="address"  class="form-control" disabled> <?php echo $address; ?> </textarea>
      </div>

      <div class="form-group">
        <label for="photo" class="form-label">Photo</label>
        <br/>
        <img id="blah" src="uploads/<?php echo $photo;?>" alt="your image" style="width:100px; height:100px;"/>
      </div>
      
      <div class="form-group">
        <label for="course" class="form-label">Course</label>
        <select type="text" name="course"  class="form-control" disabled>
        <?php 
            while ($row = mysqli_fetch_array($getCourse)) {
       ?>
            <option value="<?php echo $row['id']; ?>" <?php if($row['id']==$courseId){ ?>selected="selected" <?php } ?>><?php echo $row['course_name']; ?> </option>
        <?php } ?>
        </select>
      </div>

      
    </form>    
  </div>

  
  <div class="container text-center mt-5">
    <a href="index.php" class="btn btn-warning mt-5"> Back </a>
  <div>


<?php include "includes/footer.php" ?>