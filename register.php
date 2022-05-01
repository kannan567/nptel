<?php  
include 'includes/header.php';
include 'includes/config.php';

$errorMsg = "";

$getQuery = "Select id, course_name from course where status=0";
$getCourse = mysqli_query($conn,$getQuery);

if(isset($_POST['register'])) 
{
  $imageName = $_POST['name'].$_FILES["photo"]["name"];
   
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($imageName);
  
  $imgExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
  $allowExt  = array('jpeg', 'jpg', 'png', 'gif');
  if(in_array($imgExt, $allowExt)){

    if($_FILES['photo']['size'] > 200000) {
      $errorMsg = "Image size should not be greated than 200Kb";
      $msg_class = "alert-danger";
    }
    else{
      move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    }
  }else{
    $errorMsg = 'Please select a valid image';
  }

  if(!$errorMsg){
    $name = preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['name']);
    $dob = $_POST['dob'];
    $emailid = $_POST['emailid'];
    $address = preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['address']);
    $photo = $imageName;
    $course = $_POST['course'];
    
    $query= "INSERT INTO users(name, dob, emailid, address, photo, course) VALUES('{$name}','{$dob}','{$emailid}','{$address}','{$photo}','{$course}')";
    $add_user = mysqli_query($conn,$query);

    if (!$add_user) {
        echo "something went wrong ". mysqli_error($conn);
    }
    else { 
        header("Location: index.php");
    }        
  }
}
?>

<h1 class="text-center">Registeration</h1>
  <div class="container">
    <form id="register_form" action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" minlength="3" maxlength="50">
      </div>

      <div class="form-group">
        <label for="dob" class="form-label">DOB</label>
        <input type="date" name="dob" id="dob" class="form-control">
      </div>

      <div class="form-group">
        <label for="emailid" class="form-label">Email ID</label>
        <input type="email" name="emailid" id="email" class="form-control" maxlength="50">
      </div>

      <div class="form-group">
        <label for="address" class="form-label">Address</label>
        <textarea type="text" name="address"  class="form-control" minlength="3" maxlength="255"> </textarea>
      </div>

      <div class="form-group">
        <label for="photo" class="form-label">Photo</label>
        <input type="file" name="photo"  class="form-control" onChange="readURL(this);">
        <span class="error"><?php echo $errorMsg;?></span><br/>
        <img id="blah" src="images/avatar.jpg" alt="your image" style="width:100px; height:100px;"/>
      </div>

      <div class="form-group">
        <label for="course" class="form-label">Course</label>
        <select type="text" name="course"  class="form-control">
          <option value="">Select</option>
          <?php while ($row = mysqli_fetch_array($getCourse)) { ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['course_name']; ?> </option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <input type="submit" name="register" class="btn btn-primary mt-2" value="Submit">
      </div>

    </form> 
  </div>
  <div class="container text-center mt-5">
      <a href="index.php" class="btn btn-warning mt-5"> Back </a>
  <div>
<script>

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

      $("#register_form").validate({
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
                email: true,
                maxlength: 50,
                remote: { 
                    url:"check_email_new.php", 
                    data: {'emailval':$('#email').val()},
                    async:false
                }
              },
              address: {
                required: true,
                minlength: 3,
                maxlength: 255
              },
              photo : {
                required: true
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
                email: "Invalid Email Address",
                maxlength: "Email no more than 50 characters",
                remote: "Email address already exists!"
              },
              address: {
                required: "Please enter the Address",
                minlength: "Address should be at least 3 characters",
                maxlength: "Address no more than 255 characters"
              },
              photo: {
                required: "Please enter the Photo"
              },
              course: {
                required: "Please enter the Course"
              }
          }
      });
    });
</script>
<?php include "includes/footer.php" ?>
