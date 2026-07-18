<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$requestedForm = $_GET['form'] ?? null;
if (isset($_GET['clear_messages'])) {
    unset($_SESSION['errors'], $_SESSION['success']);
}

$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? null;
$formState = $requestedForm === 'login' || $requestedForm === 'register'
    ? $requestedForm
    : ($_SESSION['form_state'] ?? 'register');
unset($_SESSION['errors'], $_SESSION['success']);
unset($_SESSION['form_state']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card shadow-sm p-4">
            <div class="row">
                <h1 class="h4 mb-4 col-6" id="form-title"><?php echo $formState === 'login' ? 'Login' : 'Registration'; ?></h1>
                <div class="mb-3 col-6">
                    <button type="button" class="btn btn-outline-secondary toggle-form" id="toggle-form-button"><?php echo $formState === 'login' ? 'Switch to Register' : 'Switch to Login'; ?></button>
                </div>
            </div>
            <?php if ($success): ?>
                <div class='alert alert-success'><?php echo $success; ?></div>
            <?php endif; ?>
            <?php foreach ($errors as $error): ?>
                <div class='alert alert-danger'><?php echo $error; ?></div>
            <?php endforeach; ?>
            <form id="register-form" action="registration.php" method="post" class="<?php echo $formState === 'login' ? 'd-none' : ''; ?>">
                <div class="form-group">
                    <input type="text" name="fullname" class="form-control" placeholder="Full Name:">
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email:">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password:">
                </div>
                <div class="form-group">
                    <input type="password" name="repeat_password" class="form-control" placeholder="Repeat Password:">
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" value="Register" name="submit">
                </div>
            </form>

            <form id="login-form" action="login.php" method="post" class="<?php echo $formState === 'login' ? '' : 'd-none'; ?>">
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email:">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password:">
                </div>
                <div class="form-btn">
                    <input type="submit" class="btn btn-primary" value="Login" name="login">
                </div>
            </form>
        </div>
    </div>
    <script>
        const toggleButton = document.getElementById('toggle-form-button');
        const formTitle = document.getElementById('form-title');
        const registerForm = document.getElementById('register-form');
        const loginForm = document.getElementById('login-form');

        toggleButton.addEventListener('click', () => {
            const nextForm = loginForm.classList.contains('d-none') ? 'login' : 'register';
            window.location.href = `index.php?form=${nextForm}&clear_messages=1`;
        });
    </script>
</body>
</html>