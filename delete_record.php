<?php
include('db_connection.php');

// Check if the ID parameter is set in the POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Assuming your database connection is included via db_connection.php
        // Adjust these variables according to your actual database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "product_management";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the delete query
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Simulate a success response (adjust as needed)
        $response = "Record deleted successfully.";
        echo json_encode($response);
    } catch (Exception $e) {
        // Handle database connection or query errors
        $response = "Error deleting record: " . $e->getMessage();
        echo json_encode($response);
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    // Handle the case where the ID parameter is not set
    $response = "Error: Required parameters are missing.";
    echo json_encode($response);
}
?>
