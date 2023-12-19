<?php

// Include your database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_management";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if "id" is set in the $_POST array
if (isset($_POST['id'])) {
    // Get the record ID from the POST data
    $recordId = $_POST['id'];

    // Use a prepared statement to avoid SQL injection
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Bind the parameter
    $stmt->bind_param('i', $recordId);

    // Execute the query
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();

        // Fetch the record details
        $recordDetails = $result->fetch_assoc();

        // Output the record details as JSON
        header('Content-Type: application/json');
        echo json_encode($recordDetails);
    } else {
        // Handle the case where the query execution failed
        echo "Error in query execution: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Handle the case where "id" is not set
    echo "Error: Record ID is not set.";
}

// Close the database connection
$conn->close();

?>
