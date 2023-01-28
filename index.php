<?php include 'inc/header.php'; ?>

<?php
// Set vars to empty values
// $NIC = $Name = $Doctor = $Address = $Gender = $Age = $tp ='';
$NIC = $Name  = $Address = $tp = $email =  $noOfPhotos = $size= $finish = $note ='';

$NICErr = $NameErr  = $AddressErr = $tpErr = $emailErr = $noErr = $sizeErr= $finishErr= '';

// Form submit
if (isset($_POST['submit'])) {

//Insert image





  // echo 'rooooOOOOOOOOOOOO';
  // Validate name
  if (empty($_POST['Name'])) {
    $nameErr = 'Name is required';
  } else {
    // $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Name = filter_input(
      INPUT_POST,
      'Name', FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  // Validate NIC
  if (empty($_POST['NIC'])) {
    $NICErr = 'NIC is required';
  } else {
    // $Name = filter_var($_POST['Name'], FILTER_SANITIZE_Name);
    $NIC = filter_input(INPUT_POST, 'NIC', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
  }

  // Validate Doc
  if (empty($_POST['email'])) {
    $emailErr = 'email is required';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(
      INPUT_POST,
      'email',
      FILTER_VALIDATE_EMAIL
    );
  }

  if (empty($_POST['Address'])) {
    $AddressErr = 'Address is required';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Address = filter_input(
      INPUT_POST,
      'Address',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  if (empty($_POST['tp'])) {
    $tpErr = 'Contact Number is required';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tp = filter_input(
      INPUT_POST,
      'tp',
      FILTER_SANITIZE_NUMBER_INT
    );
  }

  if (empty($_POST['noOfPhotos'])) {
    $noErr = 'Number of Photos is required';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $noOfPhotos = filter_input(
      INPUT_POST,
      'noOfPhotos',
      FILTER_SANITIZE_NUMBER_INT
    );
  }

  // $Gender = $_POST['Gender'];


  if (empty($_POST['size'])) {
    $sizeErr = 'Size is required';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $size = filter_input(
      INPUT_POST,
      'size',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  if (empty($_POST['finish'])) {
    $finishErr = 'Finish is required';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $finish = filter_input(
      INPUT_POST,
      'finish',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  if (empty($_POST['note'])) {
    // $noteErr = 'email is required';
  } else {
    // $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $note = filter_input(
      INPUT_POST,
      'note',
      FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );
  }

  // $Gender = $_POST['Gender'];
  if (empty($NICErr) && empty($NameErr) && empty($tpErr) && empty($AddressErr) && empty($emailErr)  && empty($noErr) && empty($sizeErr)&& empty($finishErr)) {
    // add to database
 //Insert PHOTO
 $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
 $query ="INSERT INTO cusorder(photo) values('$file') ";
 
//  if(mysqli_query($conn, $query))  
//  {  
//       echo '<script>alert("Image Inserted into Database")</script>';  
//  } 

    $sql = "INSERT INTO cusorder (NIC, note, finish, size, noOfPhotos,photo) VALUES ('$NIC','$note', '$finish','$size','$noOfPhotos','$file')";
    $sql2 = "INSERT INTO customer (NIC, Name, Address,  tp,email ) VALUES ('$NIC', '$Name', '$Address',  '$tp', '$email')";

    $fetch='SELECT * from customer';
    $result= mysqli_query($conn, $fetch);
    $customerContent = mysqli_fetch_all($result, MYSQLI_ASSOC);




//Avoid Multiple User entries

    $customerExists = false;

    foreach ($customerContent as $item): 
      if($item['NIC'] == $NIC){
       $customerExists = true;
        
      } 
    endforeach; 

    if($customerExists== true){
      echo 'true';
       
     }

    if ($customerExists == false){
      if (mysqli_query($conn, $sql2) ) {
        echo "success";
        // header('Location: feedback.php');
      } else {
        // error
        echo 'Error: ' . mysqli_error($conn);
      }
    }

    if (mysqli_query($conn, $sql)) {
      // success
      // header('Location: feedback.php');
    } else {
      // error
      echo 'Error: ' . mysqli_error($conn);
    }
   



  }
}
?>

    <img src="/studio/img/logo.jpg" class="w-25 mb-8" alt="">
    <h2 class=" text-danger">Welcome!</h2>
    <?php echo isset($name) ? $name : ''; ?>
    <p class="lead text-center text-success">Place Your Order</p>

    <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars(
      $_SERVER['PHP_SELF']
    ); ?>" class="mt-4 w-50">
      <div class="mb-3">
        <label for="Name" class="form-label">Name</label>
        <input type="text" class="form-control <?php echo !$nameErr ?:
          'is-invalid'; ?>" id="Name" name="Name" placeholder="Enter your name" value="<?php echo $Name; ?>">
        <div id="validationServerFeedback" class="invalid-feedback">
          Please provide a valid name.
        </div>
      </div>
      <div class="mb-3">
        <label for="NIC" class="form-label">NIC</label>
        <input type="text" class="form-control <?php echo !$NICErr ?:
          'is-invalid'; ?>" id="NIC" name="NIC" placeholder="Enter your NIC" value="<?php echo $NIC; ?>">
      </div>
      <div class="mb-3">
        <label for="Address" class="form-label">Address</label>
        <textarea class="form-control <?php echo !$AddressErr ?:
          'is-invalid'; ?>" id="Address" name="Address" placeholder="Enter your Address"><?php echo $Address; ?></textarea>
      </div>
      <div class="mb-3">
        <label for="tp" class="form-label">Contact Number</label>
        <input type="number" class="form-control <?php echo !$tpErr ?:
          'is-invalid'; ?>" id="tp" name="tp" placeholder="Enter your Contact Number" value="<?php echo $tp; ?>">
      </div>

      <div class="mb-3">
        <label for="Address" class="form-label">Email</label>
        <textarea type="text"class="form-control <?php echo !$emailErr ?:
          'is-invalid'; ?>" id="email" name="email" placeholder="Enter your email"><?php echo $email; ?></textarea>
      </div>

      <div class="mb-3">
        <label for="noOfPhotos" class="form-label">No of copies</label>
        <input type="number" class="form-control <?php echo !$noErr ?:
          'is-invalid'; ?>" id="noOfPhotos" name="noOfPhotos" placeholder="Enter number of copies" value="<?php echo $noOfPhotos; ?>">
      </div>

  <div class="col-md-3">
    <label for="validationCustom04" class="form-label">Size</label>
    <select name="size" class="form-select <?php echo !$sizeErr ?:'is-invalid'; ?>" id="validationCustom04" required>
      <option selected disabled value="">Choose...</option>
      <option>Passport 1.4 x 1.8 inches</option>
      <option>1.5 x 1.5 inches</option>
      <option>1 x 1 inches</option>
      <option>2 x 2.75 inches</option>
      <option>2 x 2 inches</option>
      <option>2 x 3.5 inches</option>
      <option>3.5 x 5 inches</option>
    </select>
    <div class="invalid-feedback">
      Please select a valid Size.
    </div>
  </div>




  <div class="col-md-3">
    <label for="validationCustom04" class="form-label">Finish</label>
    <select name="finish" class="form-select <?php echo !$finishErr ?:'is-invalid'; ?>" id="validationCustom04" required>
      <option selected disabled value="">Choose...</option>
      <option>Matt</option>
      <option>Gloss</option>
    </select>
    <div class="invalid-feedback">
      Please select a valid finish.
    </div>
  </div>

  <div class="mb-3">
        <label for="note" class="form-label">Note</label>
        <textarea class="form-control" id="note" name="note" placeholder="Enter your Note"><?php echo $note; ?></textarea>
      </div>
<div class="mb-3">
      <label class="form-label" for="customFile">Your Photo</label>
<input type="file" name="image" class="form-control" id="image" />
</div>
      
        </br>
      <div class="mb-3">
        <input type="submit" name="submit" value="Send" class="btn btn-primary w-100">
      </div>
    </form>
<?php include 'inc/footer.php'; ?>

<script>  
 $(document).ready(function(){  
      $('#insert').click(function(){  
           var image_name = $('#image').val();  
           if(image_name == '')  
           {  
                alert("Please Select Image");  
                return false;  
           }  
           else  
           {  
                var extension = $('#image').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                }  
           }  
      });  
 });  
 </script>  
