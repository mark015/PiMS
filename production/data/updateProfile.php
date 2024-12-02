<?php
include('../incl/config.php'); // Include your database connection file

header('Content-Type: application/json');

// Retrieve session user ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = trim($_POST['id']);
    $oldPassword = trim($_POST['oldPassword']);
    $newPassword = trim($_POST['newPassword']);
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $hashOldPassword=md5($oldPassword);
    // Fetch user's current password hash
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($currentPasswordHash);
    $stmt->fetch();
    $stmt->close();
    // Verify old password
    if ($hashOldPassword === $currentPasswordHash) {
        // Hash the new password
        $newPasswordHash = md5($newPassword);
        // Update user information
        $updateSql = "UPDATE users SET name = ?, username = ?, password = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('sssi', $name, $username, $newPasswordHash, $userId);

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
        }

        $updateStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Old password is incorrect.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
