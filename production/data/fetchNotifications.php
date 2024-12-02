<?php
include('../incl/config.php'); // Include your database connection file
include('../incl/auth.php'); // Include your database connection file
header('Content-Type: application/json');

$response = array();

// Assume you're getting the logged-in user's ID
$role = $rowUser['role'];  // This assumes a session variable 'user_id' exists
$notif = 'unread';

if($role === 'User1'){
    $query = "SELECT document_title, date_released FROM document WHERE notif_status = ? AND status='pending' ORDER BY date_released "; // You can adjust the LIMIT based on your needs
}elseif($role === 'User2'){
    $query = "SELECT document_title, date_released FROM document WHERE notif_status = ? AND status='processing' ORDER BY date_released";
}else{
    $query = "SELECT document_title, date_released FROM document WHERE notif_status = ? AND status='complete' ORDER BY date_released ";
}


$stmt = $conn->prepare($query);
$stmt->bind_param("s", $notif);  // Binding the user ID parameter
$stmt->execute();
$result = $stmt->get_result();

$notifications = array();

while ($row = $result->fetch_assoc()) {
    $notifications[] = array(
        'title' => $row['document_title'],
        'time' =>$row['date_released'],  // Assuming you have a helper function for time formatting
        'role' => $role
    );
}

$response['success'] = true;
$response['notifications'] = $notifications;

// Return the response as JSON
echo json_encode($response);

// Close the database connection
$stmt->close();
$conn->close();


?>
