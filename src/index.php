<?php
/**
 * PHP Guestbook - Version 8: Security Hardening
 * 
 * Final Professional Version:
 * - CSRF Protection.
 * - Security Headers.
 * - Secure Session Cookies.
 * - Input Validation & Output Escaping (Strict).
 */

require_once 'helpers.php';
require_once 'Database.php';
require_once 'Auth.php';
require_once 'Security.php';

// Configure secure session before starting
Security::setSecureSessionConfig();
session_start();

// Set security headers
Security::setSecurityHeaders();

$start_time = microtime(true);
const MAX_MESSAGE_LENGTH = 150;
$db = Database::getConnection();

// 1. Handle Actions (Restrict to logged-in users)
if (isset($_GET['toggle_feature'])) {
    $id = (int)$_GET['toggle_feature'];
    if (Auth::isLoggedIn()) {
        $db->prepare("UPDATE entries SET is_featured = NOT is_featured WHERE id = ?")->execute([$id]);
    }
    header('Location: index.php?sort=' . ($_GET['sort'] ?? 'newest'));
    exit;
}

// 2. Handle Form Submission with CSRF check
$errors = [];
$name = Auth::isLoggedIn() ? Auth::getUsername() : '';
$email = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Validation
    if (!Security::validateCsrfToken($_POST['csrf_token'] ?? null)) {
        die('CSRF token validation failed.');
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name)) $errors['name'] = 'Name is required.';
    if (empty($email)) $errors['email'] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email.';
    if (empty($message)) $errors['message'] = 'Message is required.';
    elseif (mb_strlen($message) > MAX_MESSAGE_LENGTH) $errors['message'] = 'Too long.';

    if (empty($errors)) {
        $user_id = Auth::getUserId();
        $stmt = $db->prepare("INSERT INTO entries (user_id, name, email, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $email, $message]);
        header('Location: index.php?success=1');
        exit;
    }
}

// 3. Sorting logic
$allowed_sorts = ['newest', 'oldest', 'featured'];
$sort = $_GET['sort'] ?? 'newest';
if (!in_array($sort, $allowed_sorts)) $sort = 'newest';

$order_by = "entries.created_at DESC";
if ($sort === 'oldest') $order_by = "entries.created_at ASC";
if ($sort === 'featured') $order_by = "is_featured DESC, entries.created_at DESC";

$query = "SELECT entries.*, users.username FROM entries 
          LEFT JOIN users ON entries.user_id = users.id 
          ORDER BY $order_by";
$entries = $db->query($query)->fetchAll();

$page_title = 'Secure Guestbook';
include 'views/header.php';
?>

    <p><em>(Version 8: Security Hardened)</em></p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert">Successfully posted!</div>
    <?php endif; ?>

    <?php if (Auth::isLoggedIn()): ?>
        <form method="POST" novalidate id="guestbook-form">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
            
            <div class="form-group">
                <label for="name">Display Name:</label>
                <input type="text" name="name" id="name" value="<?php echo e($name); ?>">
            </div>
            <div class="form-group">
                <label for="email">Contact Email:</label>
                <input type="email" name="email" id="email" value="<?php echo e($email); ?>">
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea name="message" id="message" rows="4"><?php echo e($message); ?></textarea>
                <div id="char-counter" style="text-align: right; font-size: 0.8em; color: #666;"><span id="chars-used">0</span> / <?php echo MAX_MESSAGE_LENGTH; ?></div>
            </div>
            <button type="submit">Post Entry</button>
        </form>
    <?php else: ?>
        <div class="alert" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;">
            Please <a href="login.php">Login</a> or <a href="register.php">Register</a> to post messages.
        </div>
    <?php endif; ?>

    <hr>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Recent Entries</h2>
        <select onchange="window.location.href='?sort=' + this.value">
            <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest</option>
            <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Oldest</option>
            <option value="featured" <?php echo $sort === 'featured' ? 'selected' : ''; ?>>Featured</option>
        </select>
    </div>

    <div id="entries">
        <?php foreach ($entries as $entry): ?>
            <div class="entry" style="<?php echo $entry['is_featured'] ? 'border-left: 5px solid #ffc107; background: #fffdf5;' : ''; ?>">
                <div class="entry-meta">
                    <?php if ($entry['is_featured']): ?>
                        <span style="background: #ffc107; color: #000; padding: 2px 6px; border-radius: 3px; font-size: 0.7em; font-weight: bold; margin-right: 5px;">FEATURED</span>
                    <?php endif; ?>
                    <strong><?php echo e($entry['name']); ?></strong> 
                    <?php if ($entry['username']): ?><small>(@<?php echo e($entry['username']); ?>)</small><?php endif; ?>
                    • <?php echo format_date($entry['created_at']); ?>
                    
                    <?php if (Auth::isLoggedIn()): ?>
                        <a href="?toggle_feature=<?php echo $entry['id']; ?>&sort=<?php echo $sort; ?>" style="float: right; font-size: 0.8em; color: #999; text-decoration: none;">★</a>
                    <?php endif; ?>
                </div>
                <div class="entry-content"><?php echo nl2br(e($entry['message'])); ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        const messageArea = document.getElementById('message');
        if (messageArea) {
            const charsUsed = document.getElementById('chars-used');
            function updateCounter() {
                charsUsed.textContent = messageArea.value.length;
                charsUsed.style.color = messageArea.value.length > <?php echo MAX_MESSAGE_LENGTH; ?> ? '#dc3545' : '#666';
            }
            messageArea.addEventListener('input', updateCounter);
            updateCounter();
        }
    </script>

<?php include 'views/footer.php'; ?>
