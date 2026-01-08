<?php
require_once 'helpers.php';
require_once 'Database.php';
require_once 'Auth.php';

session_start();

if (Auth::isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (Auth::login($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $errors['login'] = 'Invalid username or password.';
    }
}

$page_title = 'Login';
include 'views/header.php';
?>

<div style="max-width: 400px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h2>Login</h2>
    
    <?php if (isset($errors['login'])): ?>
        <div class="error-msg" style="margin-bottom: 15px;"><?php echo e($errors['login']); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo e($username); ?>">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit" style="width: 100%;">Login</button>
    </form>
    <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>

<?php include 'views/footer.php'; ?>
