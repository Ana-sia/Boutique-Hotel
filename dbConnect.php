<?php
$host = "localhost"; // Host name 
$username = "root"; // Mysql username 
$password = ""; // Mysql password 
$db_name = "homewoodhotel"; // Database name 

// Connect to server and select database.
$conn = mysqli_connect($host, $username, $password, $db_name) or die("Error " . mysqli_error($conn));

// Check connection
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}else{
    printf("Successfully connect to database!");
}

// Close connection
mysqli_close($conn);

?>
