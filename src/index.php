<?php
/**
 * PHP Guestbook - Version 2: Validation & UX
 * 
 * Improvements:
 * - Added email field.
 * - Server-side validation.
 * - "Sticky" form inputs (retains data on error).
 * - Error message handling.
 */

session_start();

// Track page load time
$start_time = microtime(true);

// Initialize database
if (!isset($_SESSION['entries'])) {
    $_SESSION['entries'] = [
        [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'message' => 'Welcome to Version 2! We now have validation.',
            'created_at' => date('Y-m-d H:i:s')
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
    // 1. Collect and trim data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // 2. Validation Logic
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
    } elseif (strlen($message) < 5) {
        $errors['message'] = 'Message must be at least 5 characters long.';
    }

    // 3. If no errors, save and redirect
    if (empty($errors)) {
        $_SESSION['entries'][] = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Clear values for next time
        $name = $email = $message = '';
        
        // In a real app, we'd redirect here to prevent double-submission:
        // header('Location: index.php?success=1');
        // exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook v2 - Validation & UX</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; background: #f4f4f4; }
        .entry { background: #fff; padding: 15px; margin-bottom: 10px; border-left: 5px solid #28a745; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .entry-meta { font-size: 0.8em; color: #666; margin-bottom: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], textarea { 
            width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; 
        }
        input.error, textarea.error { border-color: #dc3545; background-color: #fff8f8; }
        .error-msg { color: #dc3545; font-size: 0.85em; margin-top: 5px; display: block; }
        button { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #ccc; font-size: 0.9em; color: #777; }
        .alert { padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>📝 Guestbook v2</h1>
    <p><em>(Validation & User Experience)</em></p>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)): ?>
        <div class="alert">Successfully posted your entry!</div>
    <?php endif; ?>

    <!-- Entry Form -->
    <form method="POST" novalidate>
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" 
                   value="<?php echo htmlspecialchars($name); ?>" 
                   class="<?php echo isset($errors['name']) ? 'error' : ''; ?>">
            <?php if (isset($errors['name'])): ?>
                <span class="error-msg"><?php echo $errors['name']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" 
                   value="<?php echo htmlspecialchars($email); ?>"
                   class="<?php echo isset($errors['email']) ? 'error' : ''; ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error-msg"><?php echo $errors['email']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="4" 
                      class="<?php echo isset($errors['message']) ? 'error' : ''; ?>"><?php echo htmlspecialchars($message); ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <span class="error-msg"><?php echo $errors['message']; ?></span>
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
                    <strong><?php echo htmlspecialchars($entry['name']); ?></strong> 
                    (<?php echo htmlspecialchars($entry['email']); ?>)
                    • <?php echo $entry['created_at']; ?>
                </div>
                <div class="entry-content">
                    <?php echo nl2br(htmlspecialchars($entry['message'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <p>
            &copy; <?php echo date('Y'); ?> PHP Guestbook Project • 
            Page loaded in <?php echo round((microtime(true) - $start_time) * 1000, 2); ?>ms
        </p>
    </footer>

</body>
</html>
