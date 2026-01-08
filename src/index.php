<?php
/**
 * PHP Guestbook - Version 7: Authentication
 * 
 * Improvements:
 * - User Registration & Login.
 * - Password Hashing (BCRYPT/Argon2).
 * - Session Management & Security.
 * - Relational Ownership (Entries linked to Users).
 */

require_once 'helpers.php';
require_once 'Database.php';
require_once 'Auth.php';

session_start();

$start_time = microtime(true);
const MAX_MESSAGE_LENGTH = 150;
$db = Database::getConnection();

// 1. Handle Actions (Delete/Feature) - Restricted to Admin or Owner
if (isset($_GET['toggle_feature'])) {
    $id = (int)$_GET['toggle_feature'];
    // In v7, we simulate admin as any logged-in user for demonstration
    if (Auth::isLoggedIn()) {
        $db->prepare("UPDATE entries SET is_featured = NOT is_featured WHERE id = ?")->execute([$id]);
    }
    header('Location: index.php?sort=' . ($_GET['sort'] ?? 'newest'));
    exit;
}

// 2. Handle Form Submission
$errors = [];
$name = Auth::isLoggedIn() ? Auth::getUsername() : '';
$email = ''; // We could fetch this from User table if logged in
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

// 3. Sorting Logic
$allowed_sorts = ['newest', 'oldest', 'featured'];
$sort = $_GET['sort'] ?? 'newest';
if (!in_array($sort, $allowed_sorts)) $sort = 'newest';

$order_by = "entries.created_at DESC";
if ($sort === 'oldest') $order_by = "entries.created_at ASC";
if ($sort === 'featured') $order_by = "is_featured DESC, entries.created_at DESC";

// 4. Fetch entries with optional User Join
$query = "SELECT entries.*, users.username FROM entries 
          LEFT JOIN users ON entries.user_id = users.id 
          ORDER BY $order_by";
$entries = $db->query($query)->fetchAll();

$page_title = 'Guestbook v7';
include 'views/header.php';
?>

    <p><em>(Authentication & Session Security)</em></p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert">Successfully posted your message!</div>
    <?php endif; ?>

    <?php if (!Auth::isLoggedIn()): ?>
        <div class="alert" style="background: #e7f3ff; color: #0c5460; border-color: #bee5eb;">
            💡 <strong>Tip:</strong> <a href="login.php">Login</a> to have your entries linked to your profile!
        </div>
    <?php endif; ?>

    <form method="POST" novalidate id="guestbook-form">
        <div class="form-group">
            <label for="name">Display Name:</label>
            <input type="text" name="name" id="name" value="<?php echo e($name); ?>" class="<?php echo isset($errors['name']) ? 'error' : ''; ?>">
            <?php if (isset($errors['name'])): ?><span class="error-msg"><?php echo e($errors['name']); ?></span><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Contact Email:</label>
            <input type="email" name="email" id="email" value="<?php echo e($email); ?>" class="<?php echo isset($errors['email']) ? 'error' : ''; ?>">
            <?php if (isset($errors['email'])): ?><span class="error-msg"><?php echo e($errors['email']); ?></span><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="4" class="<?php echo isset($errors['message']) ? 'error' : ''; ?>"><?php echo e($message); ?></textarea>
            <div id="char-counter" style="text-align: right; font-size: 0.8em; color: #666;"><span id="chars-used">0</span> / <?php echo MAX_MESSAGE_LENGTH; ?></div>
            <?php if (isset($errors['message'])): ?><span class="error-msg"><?php echo e($errors['message']); ?></span><?php endif; ?>
        </div>

        <button type="submit">Post Entry</button>
    </form>

    <hr>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Recent Entries</h2>
        <form method="GET" style="display: flex; align-items: center; gap: 10px;">
            <input type="hidden" name="sort" value="<?php echo e($sort); ?>">
            <label for="sort-select" style="margin: 0;">Sort by:</label>
            <select id="sort-select" onchange="window.location.href='?sort=' + this.value">
                <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                <option value="featured" <?php echo $sort === 'featured' ? 'selected' : ''; ?>>Featured First</option>
            </select>
        </form>
    </div>

    <div id="entries">
        <?php foreach ($entries as $entry): ?>
            <div class="entry" style="<?php echo $entry['is_featured'] ? 'border-left: 5px solid #ffc107; background: #fffdf5;' : ''; ?>">
                <div class="entry-meta">
                    <?php if ($entry['is_featured']): ?>
                        <span style="background: #ffc107; color: #000; padding: 2px 6px; border-radius: 3px; font-size: 0.7em; font-weight: bold; margin-right: 5px;">FEATURED</span>
                    <?php endif; ?>
                    
                    <strong><?php echo e($entry['name']); ?></strong> 
                    <?php if ($entry['username']): ?>
                        <span style="color: #007bff; font-size: 0.9em;">(@<?php echo e($entry['username']); ?>)</span>
                    <?php endif; ?>
                    
                    • <?php echo format_date($entry['created_at']); ?>
                    
                    <?php if (Auth::isLoggedIn()): ?>
                        <a href="?toggle_feature=<?php echo $entry['id']; ?>&sort=<?php echo $sort; ?>" style="float: right; font-size: 0.8em; color: #999; text-decoration: none;">
                            <?php echo $entry['is_featured'] ? '★ Unfeature' : '☆ Feature'; ?>
                        </a>
                    <?php endif; ?>
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