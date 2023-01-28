<?php include 'inc/header.php'; 
session_start();
if(isset($_SESSION["username"]))  
{  
     header("location:feedback.php");  
}

if (isset($_POST["register"])){
    if(empty($_POST["username"]) && empty($_POST["password"]))  
    {
        echo '<script>alert("Both Fields are required")</script>';  
    }else{
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $password = md5($password);
        $query ="INSERT INTO user (username, password) Values ('$username', '$password')";
        if(mysqli_query( $conn, $query)){
            echo '<script>alert("Registration Done")</script>';  
        }
        echo $password;

        echo $username;

    }
}

if (isset($_POST["login"])){
    if(empty($_POST["username"]) && empty($_POST["password"]))  
    {
        echo '<script>alert("Both Fields are required!")</script>';  
    }else{
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $password=md5($password);
        $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";  
        $result = mysqli_query($conn, $query); 
        if(mysqli_num_rows($result) > 0)  
        {  
             $_SESSION['username'] = $username;  
             header("location:feedback.php");  
        }  
        else  
        {  
             echo '<script>alert("Wrong User Details")</script>';  
        }

        echo $password;

        // echo $username;
    }
}

?>
<?php if(isset($_GET["action"])=="login"){?>
<form method="post">
  <div class="form-outline mb-4">
    <input type="text"  name="username"  class="form-control " />
    <label class="form-label" for="form2Example1">Username</label>
  </div>
  <div class="form-outline mb-4">
    <input type="password"  name="password" class="form-control" />
    <label class="form-label" for="form2Example2">Password</label>
  </div>
  <div class="row mb-4">
  <input type="submit" value="login" name="login" class="btn btn-dark btn-block mb-4">
</div>
<div>
<p align="center"><a href="register.php" class="text-secondary">Register</a></p>
  </div>
</form>


<?php
    }else{
?>

<form method="post">
  <div class="form-outline mb-4">
    <input type="text"  name="username"  class="form-control " />
    <label class="form-label" for="form2Example1">Username</label>
  </div>
  <div class="form-outline mb-4">
    <input type="password"  name="password" class="form-control" />
    <label class="form-label" for="form2Example2">Password</label>
  </div>
  <div class="row mb-4">
  <input type="submit" value="register" name="register" class="btn btn-dark btn-block mb-4">
</div>
<div>
<p align="center"><a href="register.php?action=login" class="text-secondary">Login</a></p>
  </div>
</form>

<?php }?>

<?php include 'inc/footer.php'; ?>

