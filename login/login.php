<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["login"])){
    $email = $_POST["email"];
    $password = $_POST["password"];

    $errors = [];

    if (empty($email) || empty($password)) {
        $errors = ["All fields are required"];
    }
    

    if (empty($errors)) {
        require_once __DIR__ . '/config/db.php';

        $sql = "SELECT full_name, pass FROM users WHERE email = ? LIMIT 1";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            if ($user && password_verify($password, $user['pass'])) {
                $_SESSION['success'] = "Login successful.";
                $_SESSION['form_state'] = 'login';
            } else {
                $_SESSION['errors'] = ["Invalid email or password"];
                $_SESSION['form_state'] = 'login';
            }

            header("Location: index.php");
            exit;
        }

        $_SESSION['errors'] = ["Something went wrong"];
        $_SESSION['form_state'] = 'login';
        header("Location: index.php");
        exit;
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['form_state'] = 'login';
    header("Location: index.php");
    exit;
}