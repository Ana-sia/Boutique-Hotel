<?php
//this script is for matching a staff member and a room they clean and sends the information to the database
//it is called from "staff schedule"


ob_start();
$db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');
// Read the form data
$staff_id = $_POST['staff'];
$room_id = $_POST['room'];

$query = "SELECT canCleanHowManyRooms FROM staff WHERE id = '$staff_id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($row['canCleanHowManyRooms'] > 0){
// Update the staff and rooms tables to reflect the assignment
$query = "UPDATE rooms SET housekeeper_id = $staff_id WHERE id = $room_id";
mysqli_query($db, $query);
$query = "UPDATE staff SET canCleanHowManyRooms = canCleanHowManyRooms - 1 WHERE id = $staff_id";
mysqli_query($db, $query);
// Redirect back to the staff schedule page
header("location: schedule.php");
ob_end_flush();
}

else{
 $query="UPDATE staff SET canCleanHowManyRooms = 0 WHERE `role` = 'Administrator'";
 mysqli_query($db, $query);
  header("location: schedule.php?error=Please choose another staff member.");

}

mysqli_close($db);
exit;
?>