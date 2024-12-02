<?php
session_start();  // Start session

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if not logged in
    header("Location: ../");
    exit;
}
$userId = $_SESSION['id'];
$stmtUser = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$stmtUser->bind_param("s", $userId);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$rowUser = $resultUser -> fetch_assoc();
?>