<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["submit"])) {
    $full_name = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_repeat = $_POST["repeat_password"];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $errors = [];

    if (empty($full_name) || empty($email) || empty($password) || empty($password_repeat))
        array_push($errors,"All fields are required");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($errors,"Email is not valid");

    if (strlen($password) < 8)
        array_push($errors,"Password needs to be at least 8 characters long");

    if ($password != $password_repeat)
        array_push($errors,"Passwords don't match");
    
    require_once __DIR__ . '/config/db.php';

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);

    if ($rowCount > 0)
        array_push($errors,"Provided email already exists");

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_state'] = 'register';
        header("Location: index.php");
        exit;
    }

    $sql = "INSERT INTO users (full_name, email, pass) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
    if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt,"sss", $full_name, $email, $password_hash);
        mysqli_stmt_execute($stmt);
        $_SESSION['success'] = "Registered Successfully.";
        $_SESSION['form_state'] = 'register';
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['errors'] = ["Something went wrong"];
        $_SESSION['form_state'] = 'register';
        header("Location: index.php");
        exit;
    }
} 