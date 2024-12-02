<?php
session_start();

session_destroy();

header('Location: ../'); // Replace 'login.php' with your desired redirect URL
exit();
?>