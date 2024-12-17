<?php
require '../db/conn.php';
include "../functions/helpers.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     // get data from form
    $email =sanitize_input($_POST["email"]);
    $password =sanitize_input($_POST["password"]);

    $isValid = true;
    $error = "";

    
     // Validate form inputs
     if (empty($email) || empty($password)) {
          $error = "All fields are required.";
          $isValid = false;
     } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $error = "Invalid email format.";
          $isValid = false;
     }

     if($isValid){
          
   

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ? ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {

     if(password_verify($password, $user["password"])){
          $token = bin2hex(random_bytes(16));
          $ip_address = $_SERVER['REMOTE_ADDR'];
          $browser = $_SERVER['HTTP_USER_AGENT'];
  
          // Insert into userLogin table
          $stmt = $conn->prepare("INSERT INTO user_logins (user_id, ip_address, browser, token) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("isss", $user['id'], $ip_address, $browser, $token);
          $stmt->execute();
  
          // Set cookies
          setcookie("user_id", $user['id'], time() + (86400 * 7), "/", "", true, true);
          setcookie("auth_token", $token, time() + (86400 * 7), "/", "", true, true);          
  
          header("Location: ../index.php");
          exit;
     }else{
          $error = "Invalide Password";
     }
    } else {
          $error = "Email not exists.";
     }

    $stmt->close();
}
}
?>

<form method="POST">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
          <div style="color: white; background-color: red; padding: 10px; border-radius: 5px;">
               <?= htmlspecialchars($error) ?>
          </div>
     <?php endif; ?>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <p>Don't have an account? <a href="user_register.php">Register here</a></p>
</form>
