<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Hotel Bookings</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&family=Josefin+Slab:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
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
    position: absolute;
    top: 40%;
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
  <p>Please select a room and a housekeeper to assign to it:</p>

<form action="assignHousekeeper.php" method="post">
  <label for="staff">Staff Member:</label>
  <select name="staff" id="staff">
    
    <?php

    //list of housekeepers to match with room numbers if they have been already assigned (room_number - assigned manually by the admin)
    // note that the admin has to assign the room number first THEN choose a housekeeper


    $db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');
      // Fetch the list of staff members from the database and create an option element for each one
      $query = "SELECT id, `name` FROM staff";
      $result = mysqli_query($db, $query);
      while ($row = mysqli_fetch_array($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
      }
      
      mysqli_close($db);
    ?>
  </select>
  <br>
  <label for="room">Room:</label>
  <select name="room" id="room">
  <?php
  $db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');
  $query = "SELECT id, `type` FROM rooms";
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $room_id = $row['id'];
  $room_type = $row['type'];

  // Get the room number for the current room id
  $room_number_query = "SELECT room_number FROM bookings WHERE room_id = '$room_id' LIMIT 1";
  $room_number_result = mysqli_query($db, $room_number_query);
  $room_number_row = mysqli_fetch_array($room_number_result, MYSQLI_ASSOC);
  $room_number = $room_number_row['room_number'];

  echo "<option value='$room_id'>Room Number: $room_number</option>";
}

  mysqli_close($db);
  ?>
  </select>
  <br>
  <input type="submit" value="Assign">
</form>




<section id="housekeeper">
  <h2></h2>
<div class="table-name">STAFF SCHEDULE</div>
      <table>
        <tr>
          <th>Housekeeper</th>
          <th>Room Number</th>
          <th>Type</th>
          <!--<th>Total Price</th>!-->
        </tr>
        <?php
        $db = mysqli_connect('localhost', 'root', '', 'homewoodhotel');
        $query = "SELECT rooms.id, rooms.type, rooms.price, staff.name AS housekeeper, bookings.room_number
        FROM rooms 
        INNER JOIN staff ON rooms.housekeeper_id = staff.id
        INNER JOIN bookings ON rooms.id = bookings.room_id";

        $result = mysqli_query($db, $query);
        while ($row = mysqli_fetch_array($result)) {
          echo "<tr>";
          //echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . $row['housekeeper'] . "</td>";
          echo "<td>" . $row['room_number'] . "</td>";
          echo "<td>" . $row['type'] . "</td>";
          //echo "<td>" . $row['price'] . "</td>";
          echo "</tr>";
        }

        mysqli_close($db);
        ?>
</table>
      </section>

      

      

   
<section id="staff">
        <h2></h2>
        <?php

        // Connect to the database
        $db = mysqli_connect("localhost", "root", "", "homewoodhotel");

        // Query the staff table
        $query = "SELECT * FROM staff";
        $result = mysqli_query($db, $query);
        echo '<div class="table-name">STAFF INFORMATION</div>';
        // Start a table
        echo "<table>";

        // Print the table headers
        echo "<tr>
                <th>Name</th>
                <th>Position</th>
                <th>Phone Number</th>
              </tr>";

        // Print the staff information
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          echo "<tr>
                  <td>{$row['name']}</td>
                  <td>{$row['role']}</td>
                  <td>{$row['phone_number']}</td>
                </tr>";
        }

        // End the table
        echo "</table>";
        mysqli_close($db);
        ?>

      </section>

      <button class="blue"><a href="staffmenu.html">Back to the menu</a></button>

    </main>
  </body>
</html>
