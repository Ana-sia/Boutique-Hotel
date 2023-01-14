<?php
ob_start();
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the submitted username and password
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // Query the admins table to check if the entered username and password match any record
  $query = "SELECT * FROM `admin` WHERE username='$username' AND `password`='$password'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);
  // If a match is found, redirect to the admin page
  if ($count == 1) {
    $_SESSION['logged_in'] = true;
    header("location: staffmenu.html");
  }
  // If no match is found, display an error message
  else {
    $_SESSION['logged_in'] = false;

    //display the error message
    $error = "Incorrect username or password";
    header("location: logAsAdmin.html?error=Incorrect username or password, please try again.");
  }
  ob_end_flush();
}
mysqli_close($db);
?>

