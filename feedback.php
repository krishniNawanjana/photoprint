<?php
session_start();
if(!isset($_SESSION["username"])){
  header("location:register.php?action=login");
}
?>
<?php include 'inc/header.php'; ?>

<!-- //Delete -->
<?php
if (isset($_GET['id'])) {  
      $id = $_GET['id'];  
      $query = "DELETE FROM `cusorder` WHERE orderNum = '$id'";  
      $run = mysqli_query($conn,$query);  
      if ($run) {  
           header('location:feedback.php');  
      }else{  
           echo "Error: ".mysqli_error($conn);  
      }  
      echo $_GET['id'];
 }
 ?>

<!--SEARCHED or NOT BITFLIP-->
<?php 
$searchKey = '';
$searched = false;
  if (isset($_POST['submit'])) {

    if (empty($_POST['search'])) {
      $nameErr = 'Search Key required!';
    } else {
      // $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $searchKey = filter_input(
        INPUT_POST,
        'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }
// THE BIT FLIP
    $searched = true;

    if (empty($_POST['search'])) {
      $nameErr = 'Enter Key';
    } else {
      $Name = filter_input(
        INPUT_POST,
        'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }
  }
  if(isset ($_POST['showall'])){
    $searched = false;
  }       

  if($searched ==true){
    $fetch="SELECT * from cusorder
    WHERE NIC LIKE '%$searchKey%'
    OR note LIKE '%$searchKey%' ";

    $result= mysqli_query($conn, $fetch);
    $cusorder = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }else{
    $fetch='SELECT * from cusorder';
    $result= mysqli_query($conn, $fetch);
    $cusorder = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
?>

  <?php if (empty($cusorder)): ?>
    <p class="lead mt-3">There are no Orders</p>
  <?php endif; ?>

  <?php //foreach ($cusorder as $item): ?>
    <!-- <div class="card my-3 w-75">
     <div class="card-body text-center">
       <?php //echo $item['patientName']; ?>
       <div class="text-success mt-2"> <?php //echo $item['NIC']; ?>
          Doctor: <?php // echo $item['docName'];?>
  </div>
     </div>
   </div> -->
  <?php 
  echo '<h6>Welcome '.$_SESSION["username"].'</h6>';  
  echo '<label><a class="text-danger " href="logout.php">Logout</a></label>';  
  ?>
  <a href="customers.php" class="btn btn-secondary btn-sm active" role="button" aria-pressed="true">Customers.</a>
  <h2>Orders</h2>


<!-- SEARCH -->
  <nav class="navbar navbar-light ">
  <form  method="POST" action="<?php echo htmlspecialchars(
      $_SERVER['PHP_SELF']
    ); ?>" class="mt-4 w-155" style="display: flex;">
    <input name="search" class="form-control" type="search" placeholder="Search" aria-label="Search">
    <!-- <button class="btn btn-outline-success " name="submit" type="submit">Search</button> -->
    <input type="submit" name="submit" value="Search" class="btn btn-outline-primary w-35">
    <input type="submit" name="showall" value="Back" class="btn btn-outline-success w-25 text-center">
  </form>
</nav>

  <table class="table table-striped">
  <thead>
    <tr >
      <th scope="col">Order #</th>
      <th scope="col">NoOf Photos</th>
      <th scope="col">Size</th>
      <th scope="col">Finish</th>
      <th scope="col">Note</th>
      <th scope="col">NIC</th>
      <th scope="col">Photo</th>
      <th scope="col">x</th>

    </tr>
  </thead>
  <tbody>
  <?php foreach ($cusorder as $item): 
    echo "
    <tr>
      <th >".$item['orderNum']."</th>
      <td>".$item['noOfPhotos']."</td>
      <td>".$item['size']."</td>
      <td>".$item['finish']."</td>
      <td>".$item['note']."</td>
      <td>".$item['NIC']."</td>
      <td>
      <img src='data:image/jpeg;base64,".base64_encode($item['photo'] )."' height='150' class='img-thumnail' />
      </td>


      <td>
      <a href='feedback.php?id=".$item["orderNum"]."' class='btn btn-danger'>Delete</a></td>
    </tr>
    ";
    
    
    
 endforeach; ?>

  </tbody>
</table>





<?php include 'inc/footer.php'; ?>
