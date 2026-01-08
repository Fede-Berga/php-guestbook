<?php
/**
 * PHP Guestbook - Version 5: Relational Data
 * 
 * Improvements:
 * - Real Database (MySQL).
 * - PDO with Prepared Statements.
 * - Database Class (Singleton).
 * - Normalization (Entries table with relational schema).
 */

require_once 'helpers.php';
require_once 'Database.php';

session_start();

// Track page load time
$start_time = microtime(true);

const MAX_MESSAGE_LENGTH = 150;

$db = Database::getConnection();

// State variables
$errors = [];
$name = '';
$email = '';
$message = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($name)) $errors['name'] = 'Name is required.';
    if (empty($email)) $errors['email'] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email.';
    if (empty($message)) $errors['message'] = 'Message is required.';
    elseif (mb_strlen($message) > MAX_MESSAGE_LENGTH) $errors['message'] = 'Too long.';

    if (empty($errors)) {
        /**
         * SECURITY: Prepared Statements
         * We never put variables directly in the query.
         */
        $stmt = $db->prepare("INSERT INTO entries (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);

        // Success redirect (Post-Redirect-Get pattern)
        header('Location: index.php?success=1');
        exit;
    }
}

// Fetch Entries
$stmt = $db->query("SELECT * FROM entries ORDER BY created_at DESC");
$entries = $stmt->fetchAll();

$page_title = 'Guestbook v5';
include 'views/header.php';
?>

    <p><em>(Database & Prepared Statements)</em></p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert">Successfully posted to the database!</div>
    <?php endif; ?>

    <form method="POST" novalidate id="guestbook-form">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" value="<?php echo e($name); ?>" class="<?php echo isset($errors['name']) ? 'error' : ''; ?>">
            <?php if (isset($errors['name'])): ?><span class="error-msg"><?php echo e($errors['name']); ?></span><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo e($email); ?>" class="<?php echo isset($errors['email']) ? 'error' : ''; ?>">
            <?php if (isset($errors['email'])): ?><span class="error-msg"><?php echo e($errors['email']); ?></span><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="message">Message (max <?php echo MAX_MESSAGE_LENGTH; ?>):</label>
            <textarea name="message" id="message" rows="4" class="<?php echo isset($errors['message']) ? 'error' : ''; ?>"><?php echo e($message); ?></textarea>
            <div id="char-counter" style="text-align: right; font-size: 0.8em; color: #666;"><span id="chars-used">0</span> / <?php echo MAX_MESSAGE_LENGTH; ?></div>
            <?php if (isset($errors['message'])): ?><span class="error-msg"><?php echo e($errors['message']); ?></span><?php endif; ?>
        </div>

        <button type="submit">Post Entry</button>
    </form>

    <hr>

    <h2>Recent Entries</h2>
    <div id="entries">
        <?php foreach ($entries as $entry): ?>
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
        const messageArea = document.getElementById('message');
        const charsUsed = document.getElementById('chars-used');
        function updateCounter() {
            charsUsed.textContent = messageArea.value.length;
            charsUsed.style.color = messageArea.value.length > <?php echo MAX_MESSAGE_LENGTH; ?> ? '#dc3545' : '#666';
        }
        messageArea.addEventListener('input', updateCounter);
        updateCounter();
    </script>

<?php include 'views/footer.php'; ?>