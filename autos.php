<?php
session_start();

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
} 
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    exit();
} 
if (isset($_POST['clear_all'])) {
    $_SESSION['autos'] = array();
    $_SESSION['success'] = "Database reset";
    header('Location: autos.php');
    exit();
    }


// put an array of arrays into the $_SESSION under the 'autos' key. 
if(isset($_POST['add'])){
  if (!is_numeric($_POST['year'])) {
    $_SESSION['error'] = "Mileage and year must be numeric";
    header("Location: autos.php");
    exit();
  }elseif(!is_numeric($_POST['mileage'])) {
    $_SESSION['error'] = "Mileage and year must be numeric";
    header("Location: autos.php");
    exit();
  }elseif(strlen($_POST['make'])<1 || strlen($_POST['mileage']) < 1 || strlen($_POST['make']) < 1){
    $_SESSION['error'] = "Make is required";
    header("Location: autos.php");
    exit();
  }

}

$_SESSION['autos'][] = array(
    'make' => $_POST['make'],
    'year' => $_POST['year'],
    'mileage' => $_POST['mileage']
);

?>

<html>
<head>
<title>Lu Huang's Auto Tracking</title>
</head>
<body style="font-family: sans-serif;">
<h1>Tracking Autos for <?= htmlentities($_SESSION['name']); ?> </h1>
<?php 
if (isset($_SESSION['success']) ) {
      echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
      unset($_SESSION['success']);
    }
// print_r($_SESSION['autos']);

if (isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}



?>
<form method="post">
   <p><label for="make">Make</label>
   <input type="text" name="make" size="40" ></p>
   <p><label for="year">Year</label>
   <input type="text" name="year" id="year" size="40" ></p> 
   <p><label for="mileage">Mileage</label>
   <input type="text" name="mileage" id="mileage" size="40" ></p>

   <p>
   <input type="submit" name="add" value="Add">
   <input type="submit" name="clear_all" value="Clear All"> 
   <input type="submit" name="logout" value="Logout">
   </p>

<h2>Automobiles</h2>
<ul>
  <?php
   if (isset($_SESSION['autos']) ) {
      // print_r($_GET['year']);
      // foreach ($_SESSION['autos'] as $_POST[] => $value) {
      // print_r($_SESSION['autos']['year']);
      print_r('<li>'.htmlentities($_POST['year']).'   '.htmlentities($_POST['make']).'   '.htmlentities($_POST['mileage'])."</li>\n");

    //} 
    }
    // $autos = $_SESSION['autos'];
    // foreach ($_SESSION['autos'] as $_POST['year'] => $value) {
    // echo $value . "<br />";
    // print_r($_SESSION['autos']);
    // }
  ?>
</li>
</ul>
<p>Hint: You can view page source to see session data.</p>


</form>

<pre>

</pre>
</body>
</html>
