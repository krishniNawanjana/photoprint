<?php
session_start();
if(!isset($_SESSION["username"])){
  header("location:register.php?action=login");
}
?>
<?php include 'inc/header.php'; ?>


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
    $fetch="SELECT * from customer
    WHERE Name LIKE '%$searchKey%'
    OR NIC LIKE '%$searchKey%'
    OR address LIKE '%$searchKey%' ";

    $result= mysqli_query($conn, $fetch);
    $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }else{
    $fetch='SELECT * from customer';
    $result= mysqli_query($conn, $fetch);
    $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
?>

<!-- DELETE CODE  -->
<?php
if (isset($_GET['id'])) {  
      $id = $_GET['id'];  
      $query = "DELETE FROM `customer` WHERE NIC = '$id'";  
      $run = mysqli_query($conn,$query);  
      if ($run) {  
           header('location:customers.php');  
      }else{  
           echo "Error: ".mysqli_error($conn);  
      }  
      echo $_GET['id'];
 }
 ?>
   

  <?php if (empty($customer)): ?>
    <p class="lead mt-3">There is no customer</p>
  <?php endif; ?>

  <?php //foreach ($customer as $item): ?>
    <!-- <div class="card my-3 w-75">
     <div class="card-body text-center">
       <?php //echo $item['customerName']; ?>
       <div class="text-success mt-2"> <?php //echo $item['NIC']; ?>
          Doctor: <?php // echo $item['docName'];?>
  </div>
     </div>
   </div> -->
    <?php 
        echo '<h6>Welcome '.$_SESSION["username"].'</h6>';  
        echo '<label><a class="text-danger " href="logout.php">Logout</a></label>';  
    ?>
  <a href="feedback.php" class="btn btn-secondary btn-sm active" role="button" aria-pressed="true">ORDERS</a>

  <h2>customers</h2>

  <!-- //Search UI -->
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
  <thead >
    <tr >
      <th scope="col">Name</th>
      <th scope="col">NIC</th>
      <th scope="col">Address</th>
      <th scope="col">TP No.</th>
      <th scope="col">email</th>
      <th scope="col">x</th>



    </tr>
  </thead>
  <tbody>
  

  <?php foreach ($customer as $item): 
    echo "
    <tr>
      <th >".$item['Name']."</th>
      <td>".$item['NIC']."</td>
      <td>".$item['Address']."</td>
      <td>".$item['tp']."</td>
      <td>".$item['email']."</td>
      <td>
      <a href='customers.php?id=".$item["NIC"]."' class='btn btn-danger'>Delete</a></td>
    </tr>
    ";
    
 endforeach; ?>

  </tbody>
</table>





<?php include 'inc/footer.php'; ?>
