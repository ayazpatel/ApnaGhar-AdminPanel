<?php
$servername = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$dbname = "test_ayafitech_com";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchTerm = $_GET['query'];

// Split the search term into individual words
$searchTermsArray = explode(" ", $searchTerm);

// Build the SQL query dynamically to search for each word
$sql = "SELECT * FROM buy_sell WHERE ";

foreach ($searchTermsArray as $term) {
    $sql .= "(BS_Type LIKE '%$term%' OR 
              BS_Sub_Type LIKE '%$term%' OR
              BS_Sub_Type2 LIKE '%$term%' OR
              Description LIKE '%$term%' OR
              City LIKE '%$term%' OR
              State LIKE '%$term%' OR
              Landmark LIKE '%$term%' OR
              Price LIKE '%$term%') AND ";
}

// Remove the trailing 'AND' from the SQL query
$sql = rtrim($sql, "AND ");

$result = $conn->query($sql);

$resultsArray = array();
$dataArray = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dataArray[] = $row;
    }
}

$resultsArray["data"] = $dataArray;

header('Content-Type: application/json');
echo json_encode($resultsArray);

$conn->close();
?>
