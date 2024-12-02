<?php
    include('../incl/config.php');
    header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get POST data
    $itemCode = $_POST['itemCode'];
    $itemDesc = $_POST['itemDesc'];
    $itemQuantity = $_POST['itemQuantity'];
    $itemDate = $_POST['itemDate'];

    // Insert the item into the database
    $sql = "INSERT INTO encoded_item (`item_code`, `item_desc`, `quantity`, `date`) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssss", $itemCode, $itemDesc, $itemQuantity, $itemDate);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Document added successfully!'
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to add document.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Database error.'];
    }

    // Send the response as JSON
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
