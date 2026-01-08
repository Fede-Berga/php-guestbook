<?php
/**
 * PHP Guestbook - Version 3: Helpers & Formatting
 * 
 * Improvements:
 * - Extracted helper functions.
 * - Relative time formatting ("Time Ago").
 * - Modularized layout (header/footer).
 */

require_once 'helpers.php';

session_start();

// Track page load time
$start_time = microtime(true);

// Initialize database
if (!isset($_SESSION['entries'])) {
    $_SESSION['entries'] = [
        [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'message' => 'Welcome to Version 3! Check out the relative timestamps.',
            'created_at' => date('Y-m-d H:i:s', time() - 3600) // 1 hour ago
        ]
    ];
}

// State variables for the form
$errors = [];
$name = '';
$email = '';
$message = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (empty($message)) {
        $errors['message'] = 'Message cannot be empty.';
    }

    if (empty($errors)) {
        $_SESSION['entries'][] = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Clear values
        $name = $email = $message = '';
    }
}

// Set page variables
$page_title = 'Guestbook v3';

// Include Header
include 'views/header.php';
?>

    <p><em>(Helpers & Relative Time)</em></p>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)): ?>
        <div class="alert">Successfully posted your entry!</div>
    <?php endif; ?>

    <!-- Entry Form -->
    <form method="POST" novalidate>
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" 
                   value="<?php echo e($name); ?>" 
                   class="<?php echo isset($errors['name']) ? 'error' : ''; ?>">
            <?php if (isset($errors['name'])): ?>
                <span class="error-msg"><?php echo e($errors['name']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" 
                   value="<?php echo e($email); ?>"
                   class="<?php echo isset($errors['email']) ? 'error' : ''; ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error-msg"><?php echo e($errors['email']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="4" 
                      class="<?php echo isset($errors['message']) ? 'error' : ''; ?>"><?php echo e($message); ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <span class="error-msg"><?php echo e($errors['message']); ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Post Entry</button>
    </form>

    <hr>

    <h2>Recent Entries</h2>
    <div id="entries">
        <?php foreach (array_reverse($_SESSION['entries']) as $entry): ?>
            <div class="entry">
                <div class="entry-meta">
                    <strong><?php echo e($entry['name']); ?></strong> 
                    (<?php echo e($entry['email']); ?>)
                    • <?php echo format_date($entry['created_at']); ?>
                </div>
                <div class="entry-content">
                    <?php echo nl2br(e($entry['message'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php 
// Include Footer
include 'views/footer.php'; 
?>