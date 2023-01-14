

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Booking managment system</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Josefin+Slab:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header>
      <h1>BOOKING MANAGEMENT SYSTEM</h1>
    </header>
    <script>
      // Get the error message from the query string
      const error = new URLSearchParams(window.location.search).get('error');
      // If there is an error message, display it
      if (error) {
        document.body.innerHTML += `<div class="error-message">${error}</div>`;
      }
    </script>
    <style>
      .error-message {
    
    top: 120%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255);
    color: rgb(148, 71, 71);
    padding: 20px;
    border-radius: 5px;
    font-size: larger;
    font-weight: bold;
    text-align: center;
    
  }
      </style>

    <main>
      <p>Choose the start date and the end date of the period you would like to review the bookings for:</p>
      <form action="viewBookings.php" method="post">
        <label for="start_date">Start date:</label><br>
        <input type="date" id="start_date" name="start_date"><br>
        <label for="end_date">End date:</label><br>
        <input type="date" id="end_date" name="end_date"><br>
        <input type="submit" value="View bookings">
      </form>
      <section id="reservations">
      <div class="table-name">ALL RESERVATIONS:</div>
      <table>
  <tr>
    <th>Booking ID</th>
    <th>Guest</th>
    <th>Room Type</th>
    <th>Room Number</th>
    <th>Total Price</th>
    <th>Check-in</th>
    <th>Check-out</th>
    <th>Breakfast</th>
    <th>Comment</th>
  </tr>
  
  <?php
    //displays the information about the bookings from the database


    // Connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');

    // Query the bookings table
    $query = "SELECT bookings.id AS booking_id, guests.name, rooms.type, rooms.id AS room_id, rooms.price, 
    bookings.check_in, bookings.check_out, bookings.breakfast, bookings.comment, bookings.room_number FROM rooms
    INNER JOIN bookings ON bookings.room_id=rooms.id INNER JOIN guests ON bookings.guest_id=guests.id";

$result = mysqli_query($db, $query);

// Loop through the rows and display the information in a table
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  echo "<tr>";
  echo "<td>" . $row['booking_id'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['type'] . "</td>";
  echo "<td>" . $row['room_number'] . "</td>";
  //echo "<td>" . $row['room_id'] . "</td>";
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['check_in'] . "</td>";
  echo "<td>" . $row['check_out'] . "</td>";
  if ($row['breakfast'] == 0) {
    echo "<td>No</td>";
  } else {
    echo "<td>Yes</td>";
  }
  echo "<td>" . $row['comment'] . "</td>";
  echo "</tr>";
}

    mysqli_close($db);
  ?>

  
</table>
<p>Match the guest's preferences with a room of the chosen type:</p>
<form action="assignRoomNumber2.php" method="POST">
  <label for="booking_id">Booking ID:</label>
  <input type="text" name="booking_id" id="booking_id" required>
  <label for="room_number">Room Number:</label>
  <input type="text" name="room_number" id="room_number" required><br>
  <input type="submit" value="Save">
</form>

<secction id=guests>
  <h2></h2>
    <div class="table-name">GUEST INFORMATION:</div>
      <table>
        <tr>
          <th>Name</th>
          <th>Phone</th>
          <th>Gender</th>
          <th>Date of Birth</th>
        </tr>
        
        <?php
          //displays the information about each unique guests


        // Connect to the database
        $db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');

        // Retrieve all the guests from the guests table
        $query = "SELECT DISTINCT `name`, phone, gender, date_of_birth FROM guests";
        $result = mysqli_query($db, $query);

        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          echo "<tr>";
          //echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>" . $row['phone'] . "</td>";
          echo "<td>" . $row['gender'] . "</td>";
          echo "<td>" . $row['date_of_birth'] . "</td>";
          echo "</tr>";
        }
        

        // Close the database connection
        mysqli_close($db);
        ?>
        </table>



     
     

      
        
<button class="blue"><a href="staffmenu.html">Back to the menu</a></button>

    

</main>
</body>
</html>