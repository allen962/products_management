<?php
include('db_connection.php');

// Check if the required parameters are set in the POST request
if (isset($_POST['productName'], $_POST['unit'], $_POST['price'], $_POST['expiryDate'], $_POST['inventory'])) {
    $productName = $_POST['productName'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $expiryDate = $_POST['expiryDate'];
    $inventory = $_POST['inventory'];
    $image_url = '';  // Set default value to an empty string

    // Check if an image file is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Directory where you want to store uploaded images
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image_url = $uploadFile;
        } else {
            // Handle the case where file upload fails
            $response = "Error uploading image.";
            echo json_encode($response);
            exit;
        }
    } else {
        // Handle the case where no image is provided
        $response = "Error: Image file is required.";
        echo json_encode($response);
        exit;
    }

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
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the insert query
        $stmt = $conn->prepare("INSERT INTO products (product_name, unit, price, expiry_date, available_inventory, image_url) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssdsss", $productName, $unit, $price, $expiryDate, $inventory, $image_url);
        $stmt->execute();

        // Simulate a success response (adjust as needed)
        $response = "Record created successfully.";
        echo json_encode($response);
    } catch (Exception $e) {
        // Handle database connection or query errors
        $response = "Error creating record: " . $e->getMessage();
        echo json_encode($response);
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    // Handle the case where required parameters are not set
    $response = "Error: Required parameters are missing.";
    echo json_encode($response);
}
?>
