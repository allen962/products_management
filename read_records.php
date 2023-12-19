<?php
// Add error reporting to display any PHP errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database connection code here
// Replace the placeholders with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "product_management";

$conn = new mysqli($servername, $username, $password, $database);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch records from your database table
$sql = "SELECT * FROM products"; // Replace 'your_table_name' with the actual table name
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Error in query: " . $conn->error);
}

// Fetch records and store them in an array
$records = array();
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

// Close the database connection
$conn->close();

// Output the JSON data
header('Content-Type: application/json');
echo json_encode($records);
?>
