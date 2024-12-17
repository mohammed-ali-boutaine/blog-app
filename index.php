<?php

require './db/conn.php';

// Check if user is logged in via cookies
if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['auth_token'])) {
    header("Location: view/user_login.php");
    exit;
}

$user_id = $_COOKIE['user_id'];
$auth_token = $_COOKIE['auth_token'];

// Verify token
$stmt = $conn->prepare("SELECT users.username FROM users 
                        JOIN user_logins ON users.id = user_logins.user_id 
                        WHERE users.id = ? AND user_logins.token = ?");
$stmt->bind_param("is", $user_id, $auth_token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo "<h1>Welcome, " . htmlspecialchars($user['username']) . "!</h1>";


    echo "<a href='./view/user_logout.php'>Logout</a>";
} else {
    echo "Unauthorized access. <a href='login.php'>Login again</a>";
}

$stmt->close();

?>
