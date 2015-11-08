<?php
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
} 
if ( isset($_POST['logout']) ) {
    header('Location: index-extra.php');
    exit();
} 

if ( isset($_POST['clear'])) {
    $sql = "DELETE FROM autos WHERE user_id = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':uid' => $_SESSION['user_id']));
    $_SESSION['success']="reset";
    header("Location: auto-extra.php");
    exit();
}

// put an array of arrays into the $_SESSION under the 'autos' key. 
if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
  if (!is_numeric($_POST['year'])) {
    $_SESSION['error'] = "Mileage and year must be numeric";
    header("Location: auto-extra.php");
    exit();
  }
  elseif(!is_numeric($_POST['mileage'])) {
    $_SESSION['error'] = "Mileage and year must be numeric";
    header("Location: auto-extra.php");
    exit();
  }
  elseif(strlen($_POST['make'])<1 || strlen($_POST['mileage']) < 1 || strlen($_POST['make']) < 1){
    $_SESSION['error'] = "Make is required";
    header("Location: auto-extra.php");
    exit();
  }
  else{
    $sql = "INSERT INTO autos (user_id, make, year, mileage) VALUES ( :uid, :mk, :yr, :mi)";
    // echo("<pre>\n".$sql."\n</pre>\n");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
       ':uid' => $_SESSION['user_id'],
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage']));
  }
}
if ( isset($_POST['url'])) {
  if (false === strpos($_POST['url'], 'http://')) {
    $_POST['url'] = 'http://' . $_POST['url'];
  }else if (false === strpos($_POST['url'], 'https://')) {
    $_POST['url'] = 'https://' . $_POST['url'];
  }
}

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
   <input type="text" name="mileage" id="mileage" size="80" ></p>
   <p><label for="url">URL</label>
   <input type="link" name="url" id="url" size="500" ></p>

   <p>
   <input type="submit" name="add" value="Add">
   <input type="submit" name="clear" value="Clear All"> 
   <input type="submit" name="logout" value="Logout">
   </p>

<h2>Automobiles</h2>
<ul>
<?php
$stmt = $pdo->prepare("SELECT make, year, mileage FROM autos WHERE user_id = :uid ORDER BY make;");
$stmt->execute(array(':uid' => $_SESSION['user_id']));
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo('<li>'.'<a href='. htmlentities($_POST['url']). 'target="_blank">'.htmlentities($row['make']).'</a>'.'    '.htmlentities($row['year']).'   '.htmlentities($row['mileage']).'   '."</li>\n");
}
?>
</li>
</ul>
<p>Hint: You can view page source to see session data.</p>


</form>

<pre>

</pre>
</body>
</html>
