<?php 
session_start();
unset($_SESSION['name']); 
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // php123
$failure = false;  
if ( isset($_POST['who']) && isset($_POST['pass']) ) {
   
    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1  ) {
    $_SESSION['error'] = "User name and password are required";
    header("Location: index.php");
    exit();
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            $_SESSION['name'] = $_POST['who'];
            header("Location: autos.php");
            exit();
        } else {
            $_SESSION['error'] = "Incorrect Password";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Lu Huang's Login Page</title>
</head>
<body style="font-family: sans-serif;">
<h1>Please Log In</h1>
<?php 
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}

?>
<form method="POST" action="index.php">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="pass">Password</label>
<input type="text" name="pass" id="pass"><br/>
<input type="submit" value="Log In">
</form>
<p>
For a password hint, view source and find a password hint in the HTML comments.
<!-- Hint: The password is three lower characters of a computer language followed by 123. -->
</p>
<ul>
<li> ATTEMPT to <a href="autos.php">Edit Autos</a> without
logging in.</li>
<li><a href="https://github.com/csev/php-intro/tree/master/code/rps"
target="_blank">Source Code</a></li>
<ul>
</body>
