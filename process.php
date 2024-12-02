<?php
session_start(); // Start session

include("production/incl/config.php");  // Database connection

// Get email and password from the request
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$passHash = md5($password);
// Check if email and password are provided
if (!empty($email) && !empty($password)) {
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (($passHash === $user['password'])) {
            // Set session variables on successful login
            $_SESSION['id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['logged_in'] = true;
            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            // Invalid password
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    } else {
        // Email not found
        echo json_encode(['success' => false, 'message' => 'No account found with this email']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Please fill in both fields']);
}

$conn->close();
?>
