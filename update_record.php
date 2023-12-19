<?php
include('db_connection.php');

// Check if the ID and other parameters are set in the POST request
if (isset($_POST['id'], $_POST['productName'], $_POST['unit'], $_POST['price'], $_POST['expiryDate'], $_POST['inventory'])) {
    $id = $_POST['id'];
    $productName = $_POST['productName'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $expiryDate = $_POST['expiryDate'];
    $inventory = $_POST['inventory'];

    try {
        // Assuming your database connection is included via db_connection.php
        // Adjust these variables according to your actual database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "product_management";
       
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the update query
        $stmt = $pdo->prepare("UPDATE products SET product_name = ?, unit = ?, price = ?, expiry_date = ?, available_inventory = ? WHERE id = ?");
        $stmt->execute([$productName, $unit, $price, $expiryDate, $inventory, $id]);

        // Simulate a success response (adjust as needed)
        $response = "Record updated successfully.";
        echo json_encode($response);
    } catch (PDOException $e) {
        // Handle database connection or query errors
        $response = "Error updating record: " . $e->getMessage();
        echo json_encode($response);
    }
} else {
    // Handle the case where required parameters are not set
    $response = "Error: Required parameters are missing.";
    echo json_encode($response);
}
?>
