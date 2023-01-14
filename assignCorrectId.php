<?php

//sets the right guest and room ids in the "bookings" otherwise they are not assigned correctly

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');

// Get the id of the latest entry in the rooms table
$query = "SELECT id FROM rooms ORDER BY id DESC LIMIT 1"; // takes the room id of the latest booking
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$room_id = $row['id'];

// Updates the room_id column in the bookings table for the latest entry
$query = "UPDATE bookings SET room_id = $room_id ORDER BY id DESC LIMIT 1";
mysqli_query($db, $query);

// Get the id of the latest entry in the rooms table
$query = "SELECT id FROM guests ORDER BY id DESC LIMIT 1"; // takes the guest id of the latest booking
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$guest_id = $row['id'];

// Updates the room_id column in the bookings table for the latest entry
$query = "UPDATE bookings SET guest_id = $guest_id ORDER BY id DESC LIMIT 1";
mysqli_query($db, $query);

// Close the database connection
mysqli_close($db);
?>
