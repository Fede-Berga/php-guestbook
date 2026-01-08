<?php
/**
 * PHP Guestbook - Version 4: Constraints & Logic
 * 
 * Improvements:
 * - Character limits (150 chars).
 * - Visual character counter (JS).
 * - Backend validation for string length.
 */

require_once 'helpers.php';

session_start();

// Track page load time
$start_time = microtime(true);

// Constants
const MAX_MESSAGE_LENGTH = 150;

// Initialize database
if (!isset($_SESSION['entries'])) {
    $_SESSION['entries'] = [
        [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'message' => 'Version 4 is here! We have added length constraints to keep things concise.',
            'created_at' => date('Y-m-d H:i:s', time() - 3600)
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
    } elseif (mb_strlen($message) > MAX_MESSAGE_LENGTH) {
        // mb_strlen is used for multi-byte character support
        $errors['message'] = 'Message is too long. Maximum ' . MAX_MESSAGE_LENGTH . ' characters.';
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
$page_title = 'Guestbook v4';

// Include Header
include 'views/header.php';
?>

    <p><em>(Constraints & Character Limits)</em></p>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)): ?>
        <div class="alert">Successfully posted your entry!</div>
    <?php endif; ?>

    <!-- Entry Form -->
    <form method="POST" novalidate id="guestbook-form">
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
            <label for="message">Message (max <?php echo MAX_MESSAGE_LENGTH; ?> chars):</label>
            <textarea name="message" id="message" rows="4" 
                      class="<?php echo isset($errors['message']) ? 'error' : ''; ?>"><?php echo e($message); ?></textarea>
            <div id="char-counter" style="text-align: right; font-size: 0.8em; color: #666; margin-top: 5px;">
                <span id="chars-used">0</span> / <?php echo MAX_MESSAGE_LENGTH; ?>
            </div>
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

    <script>
        // Simple character counter
        const messageArea = document.getElementById('message');
        const charsUsed = document.getElementById('chars-used');
        const maxLength = <?php echo MAX_MESSAGE_LENGTH; ?>;

        function updateCounter() {
            const currentLength = messageArea.value.length;
            charsUsed.textContent = currentLength;
            
            if (currentLength > maxLength) {
                charsUsed.style.color = '#dc3545';
                charsUsed.style.fontWeight = 'bold';
            } else {
                charsUsed.style.color = '#666';
                charsUsed.style.fontWeight = 'normal';
            }
        }

        messageArea.addEventListener('input', updateCounter);
        // Run once on load for "sticky" data
        updateCounter();
    </script>

<?php 
// Include Footer
include 'views/footer.php'; 
?>
