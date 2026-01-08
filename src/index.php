<?php
/**
 * PHP Guestbook - Version 1: The Monolith
 * 
 * This is a "Spaghetti Code" version where everything is in one file.
 * We use $_SESSION to simulate a database (In-Memory Array).
 * 
 * Security Note: This version is INTENTIONALLY VULNERABLE to XSS
 * to demonstrate the importance of output escaping.
 */

// Start session to store our "database"
session_start();

// Track page load time (Interactive Task)
$start_time = microtime(true);

// Initialize our in-memory database if it doesn't exist
if (!isset($_SESSION['entries'])) {
    $_SESSION['entries'] = [
        [
            'name' => 'Admin',
            'message' => 'Welcome to our Guestbook! Version 1 is live.',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? 'Anonymous';
    $message = $_POST['message'] ?? '';

    if (!empty($message)) {
        // Add to "database"
        $_SESSION['entries'][] = [
            'name' => $name,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook v1 - The Monolith</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; background: #f4f4f4; }
        .entry { background: #fff; padding: 15px; margin-bottom: 10px; border-left: 5px solid #007BFF; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .entry-meta { font-size: 0.8em; color: #666; margin-bottom: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #007BFF; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #ccc; font-size: 0.9em; color: #777; }
        .alert { padding: 10px; background: #fff3cd; color: #856404; border: 1px solid #ffeeba; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>📝 Guestbook v1</h1>
    <p><em>(In-Memory Array Mode)</em></p>

    <div class="alert">
        <strong>Security Warning:</strong> This version does not escape output. 
        Try submitting: <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
    </div>

    <!-- Entry Form -->
    <form method="POST">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" placeholder="John Doe">
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="4" required placeholder="Write something..."></textarea>
        </div>
        <button type="submit">Post Entry</button>
    </form>

    <hr>

    <h2>Recent Entries</h2>
    <div id="entries">
        <?php foreach (array_reverse($_SESSION['entries']) as $entry): ?>
            <div class="entry">
                <div class="entry-meta">
                    <strong><?php echo $entry['name']; ?></strong> 
                    • <?php echo $entry['created_at']; ?>
                </div>
                <div class="entry-content">
                    <?php 
                        /**
                         * VULNERABILITY: Raw output without htmlspecialchars()
                         * This allows Cross-Site Scripting (XSS).
                         */
                        echo $entry['message']; 
                    ?>
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