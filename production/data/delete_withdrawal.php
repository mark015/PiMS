<?php
    include('../incl/config.php');
    header('Content-Type: application/json');

    // Check if the id is provided
    if (isset($_POST['id'])) {
        $documentId = $_POST['id'];

        // Prepare the SQL query to delete the document
        $query = "DELETE FROM withdral_item WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        // Execute the query
        if ($stmt->execute([$documentId])) {
            // If deletion is successful, return a success response
            echo json_encode(['status' => 'success', 'message' => 'Withdrawal item deleted successfully.']);
        } else {
            // If deletion fails, return an error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete the withdrawal item.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No withdrawal item ID provided.']);
    }
?>
