<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset(($_SESSION["user"]))){
    header("Location: index.php");
    exit;
}
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php if($success): ?>
        <div class='alert alert-success'><?php echo $success; ?></div>
    <?php endif; ?>
    <div class="container">
        <h1>Welcome to Dashboard</h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>