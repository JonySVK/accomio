<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "accomio";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "INSERT INTO basic_info (name, location, price, rating, img, url)
VALUES ('Chata Púpava', 'Bystrá', '70', '4', 'styles/hotels/chata-pupava.png', 'chata-pupava')";

if ($conn->query(query: $sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "<br>New record created successfully. Last inserted ID is: " . $last_id;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


/*
$sql = "SELECT * FROM basic_info";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo " - Name: " . $row["name"]. " " . $row["location"]. "<br>";
  }
} else {
  echo "0 results";
}

$sql = "DELETE FROM basic_info";

if (mysqli_query($conn, $sql)) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . mysqli_error($conn);
}*/

?>