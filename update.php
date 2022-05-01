<?php 
include 'includes/header.php';
include 'includes/config.php';

$errorMsg = "";
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

if(isset($_POST['update'])) 
{
  $imageName = $_FILES['photo']['name'];
  if($imageName){
      $imageName = $_POST['name'].$_FILES["photo"]["name"];

      $target_dir = "uploads/";
      $target_file = $target_dir . basename($imageName);
      
      $imgExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
      $allowExt  = array('jpeg', 'jpg', 'png', 'gif');
      if(in_array($imgExt, $allowExt)){

          if($_FILES['photo']['size'] > 200000) {
              $errorMsg = "Image size should not be greated than 200Kb";
          }
          else{
              move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
              $photo = $imageName;
          }
      
      }else{
          $errorMsg = 'Please select a valid image';
      }        
  }else{
      $photo =  $photo;
  }

  if(!$errorMsg){
      
      $name = preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['name']);
      $dob = $_POST['dob'];
      $emailid = $_POST['emailid'];
      $address = preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['address']);
      $course = $_POST['course'];
      
      $query = "UPDATE users SET name = '$name',dob='$dob',emailid='$emailid',address='$address',photo='$photo',
                  course=$course,status=0 WHERE id = $userid";
      $update_user = mysqli_query($conn, $query);
      if($update_user){
          header("Location: index.php");
      }
      else{echo "fff";exit;
          echo "something went wrong ". mysqli_error($conn);
      }
  }
   
}             
?>

<h1 class="text-center">Update User Details</h1>
<div class="container">
    <form id="update_form" action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" minlength="3" maxlength="50" value="<?php echo $name; ?>">
      </div>

      <div class="form-group">
        <label for="dob" class="form-label">DOB</label>
        <input type="date" name="dob" id="dob" class="form-control" value="<?php echo $dob; ?>">
      </div>

       <div class="form-group">
        <label for="emailid" class="form-label">Email ID</label>
        <input type="email" name="emailid" id="emailval" class="form-control" value="<?php echo $emailid; ?>">
      </div>

      <div class="form-group">
        <label for="address" class="form-label">Address</label>
        <textarea type="text" name="address"  class="form-control" minlength="3" maxlength="255"> <?php echo $address; ?> </textarea>
      </div>

      <div class="form-group">
        <label for="photo" class="form-label">Photo</label>
        <input type="file" name="photo"  class="form-control" onChange="readURL(this);">
        <span class="error"><?php echo $errorMsg;?></span><br/>
        <img id="blah" src="uploads/<?php echo $photo;?>" alt="your image" style="width:100px; height:100px;"/>
      </div>
      
      <div class="form-group">
        <label for="course" class="form-label">Course</label>
        <select type="text" name="course"  class="form-control">
        <?php 
            while ($row = mysqli_fetch_array($getCourse)) {
       ?>
            <option value="<?php echo $row['id']; ?>" <?php if($row['id']==$courseId){ ?>selected="selected" <?php } ?>><?php echo $row['course_name']; ?> </option>
        <?php } ?>
        </select>
      </div> 

      <div class="form-group">
         <input type="submit" name="update" class="btn btn-primary mt-2" value="Submit">
      </div>

    </form> 
  </div>

<div class="container text-center mt-5">
    <a href="index.php" class="btn btn-warning mt-5"> Back </a>
<div>

<script>
var userid = '<?php echo $userid; ?>';

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

 $(document).ready(function() {
    var email = $('#emailval').val();
console.log(userid);console.log(email);
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;    
    $('#dob').attr('max', maxDate);

      $("#update_form").validate({
          rules: {
            name : {
            required: true,
            minlength: 3,
            maxlength: 50
            },
            dob : {
                required: true
            },
            emailid: {
                required: true,
                remote: { 
                    url:"check_email.php", 
                    data: {'id':userid,'emailval':email},
                    async:false
                }
            },
            address: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            course : {
                required: true
            }
          },
          messages : {
              name: {
                required: "Please enter the Name",
                minlength: "Name should be at least 3 characters",
                maxlength: "Name no more than 50 characters"
              },
            dob: {
                required: "Please enter the Dob"
            },
            emailid: {
                required: "Please enter the Email Id",
                remote: "Email address already exists!"
            },
            address: {
                required: "Please enter the Address",
                minlength: "Address should be at least 3 characters",
                maxlength: "Address no more than 255 characters"
            },
            course: {
                required: "Please enter the Course",
            }
          }
      });
});

</script>