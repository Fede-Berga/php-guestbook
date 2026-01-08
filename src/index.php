<?php
/**
 * PHP Guestbook - Version 6: Features & Sorting
 * 
 * Improvements:
 * - "Featured" entry flag.
 * - Dynamic sorting (Newest, Oldest, Featured).
 * - Multi-column ordering in SQL.
 */

require_once 'helpers.php';
require_once 'Database.php';

session_start();

$start_time = microtime(true);
const MAX_MESSAGE_LENGTH = 150;
$db = Database::getConnection();

// 1. Handle "Feature" Toggle Action (Simulated Admin)
if (isset($_GET['toggle_feature'])) {
    $id = (int)$_GET['toggle_feature'];
    // Invert the boolean value in DB
    $db->prepare("UPDATE entries SET is_featured = NOT is_featured WHERE id = ?")->execute([$id]);
    header('Location: index.php?sort=' . ($_GET['sort'] ?? 'newest'));
    exit;
}

// 2. Handle Form Submission
$errors = [];
$name = $email = $message = '';

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
        $stmt = $db->prepare("INSERT INTO entries (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        header('Location: index.php?success=1');
        exit;
    }
}

// 3. Handle Sorting Logic
$allowed_sorts = ['newest', 'oldest', 'featured'];
$sort = $_GET['sort'] ?? 'newest';
if (!in_array($sort, $allowed_sorts)) $sort = 'newest';

$order_by = "created_at DESC";
if ($sort === 'oldest') $order_by = "created_at ASC";
if ($sort === 'featured') $order_by = "is_featured DESC, created_at DESC";

// Fetch entries with dynamic sort
$entries = $db->query("SELECT * FROM entries ORDER BY $order_by")->fetchAll();

$page_title = 'Guestbook v6';
include 'views/header.php';
?>

    <p><em>(Features & Dynamic Sorting)</em></p>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert">Successfully posted!</div>
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
            <label for="sort" style="margin: 0;">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
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
                    • <?php echo format_date($entry['created_at']); ?>
                    
                    <a href="?toggle_feature=<?php echo $entry['id']; ?>&sort=<?php echo $sort; ?>" style="float: right; font-size: 0.8em; color: #999; text-decoration: none;">
                        <?php echo $entry['is_featured'] ? '★ Unfeature' : '☆ Feature'; ?>
                    </a>
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
