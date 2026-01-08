<?php
require_once 'helpers.php';
require_once 'Database.php';
require_once 'Auth.php';
require_once 'Security.php';

Security::setSecureSessionConfig();
session_start();
Security::setSecurityHeaders();

if (Auth::isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$errors = [];
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Security::validateCsrfToken($_POST['csrf_token'] ?? null)) {
        die('CSRF token validation failed.');
    }

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($username)) $errors['username'] = 'Username is required.';
    if (empty($email)) $errors['email'] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email.';
    
    if (empty($password)) $errors['password'] = 'Password is required.';
    elseif (strlen($password) < 8) $errors['password'] = 'Password must be at least 8 characters.';
    
    if ($password !== $password_confirm) $errors['password_confirm'] = 'Passwords do not match.';

    if (empty($errors)) {
        $db = Database::getConnection();
        
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors['general'] = 'Username or email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hash]);
            
            Auth::login($username, $password);
            header('Location: index.php');
            exit;
        }
    }
}

$page_title = 'Register';
include 'views/header.php';
?>

<div style="max-width: 400px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h2>Create Account</h2>
    
    <?php if (isset($errors['general'])): ?>
        <div class="error-msg" style="margin-bottom: 15px;"><?php echo e($errors['general']); ?></div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo e($username); ?>">
            <?php if (isset($errors['username'])): ?><span class="error-msg"><?php echo e($errors['username']); ?></span><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo e($email); ?>">
            <?php if (isset($errors['email'])): ?><span class="error-msg"><?php echo e($errors['email']); ?></span><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <?php if (isset($errors['password'])): ?><span class="error-msg"><?php echo e($errors['password']); ?></span><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirm Password:</label>
            <input type="password" name="password_confirm" id="password_confirm">
            <?php if (isset($errors['password_confirm'])): ?><span class="error-msg"><?php echo e($errors['password_confirm']); ?></span><?php endif; ?>
        </div>
        <button type="submit" style="width: 100%;">Register</button>
    </form>
    <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div>

<?php include 'views/footer.php'; ?>