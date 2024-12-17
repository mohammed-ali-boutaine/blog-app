<?php

require '../db/conn.php';
include "../functions/helpers.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // get data from form
    $username = sanitize_input($_POST["username"]);
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);

    $isValid = true;
    $error = "";


    // Validate form inputs
    if (empty($email) || empty($password) || empty($username)) {
        $error = "All fields are required.";
        $isValid = false;

        // email validation
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
        $isValid = false;
    }
    if ($isValid) {

        // check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $existingUser  = $result->fetch_assoc();


        if ($existingUser ) {
            $error = "this email aleardy exists";
        } else {
        // hash password

            $password = password_hash($password,PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);
            $stmt->execute();

            // Retrieve the newly inserted user ID
            $userId = $conn->insert_id;


            // insert token and user after check if email not exists
            $token = bin2hex(random_bytes(16));
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $browser = $_SERVER['HTTP_USER_AGENT'];

            // Insert into userLogin table
            $stmt = $conn->prepare("INSERT INTO user_logins (user_id, ip_address, browser, token) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $userId, $ip_address, $browser, $token);
            $stmt->execute();

            // Set cookies
            setcookie("user_id", $userId, time() + (86400 * 7), "/", "", true, true);
            setcookie("auth_token", $token, time() + (86400 * 7), "/", "", true, true);

            header("Location: ../index.php");
            exit;
        }


        $stmt->close();
    }
}
?>

<form method="POST">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
        <div style="color: red"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <input type="text" name="username" placeholder="User nName" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
    <p>Already have an account? <a href="user_login.php">Login here</a></p>
</form>