<?php

// require '../db/conn.php';  // Assuming you have a connection file for database access

// Helper function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Helper function to redirect
function redirect($url) {
    header("Location: $url");
    exit();
}
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function check_user_authentication() {
    global $conn;

    // Check if the user_id and auth_token cookies exist
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['auth_token'])) {
        $user_id = sanitize_input($_COOKIE['user_id']);
        $auth_token = sanitize_input($_COOKIE['auth_token']);

        // Check if user exists in the database and if the token matches
        $stmt = $conn->prepare("SELECT id FROM user_logins WHERE user_id = ? AND token = ? AND is_active = 1");
        $stmt->bind_param("is", $user_id, $auth_token);
        $stmt->execute();
        $result = $stmt->get_result();

        // If a match is found, the user is authenticated
        if ($result->num_rows > 0) {
            return true;  // User is authenticated
        }
    }

    // If no valid user_id and auth_token, redirect to login page
    return false;
}

function requireAuth() {
    if (!check_user_authentication()) {
        header("Location: login.php");
        exit();
    }
}
?>