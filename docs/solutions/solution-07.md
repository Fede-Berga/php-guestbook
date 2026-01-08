# Solution 07: Authentication

## Task 1: Form Visibility
**Solution**:
In `index.php`:
```php
<?php if (Auth::isLoggedIn()): ?>
    <form>...</form>
<?php else: ?>
    <p>Please <a href="login.php">login</a> to post a message.</p>
<?php endif; ?>
```

---

## Task 2: Password Strength
**Solution**:
In `register.php`:
```php
if (strlen($password) < 8) {
    $errors['password'] = 'Min 8 chars.';
} elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
    $errors['password'] = 'Must contain an uppercase letter and a number.';
}
```

---

## Task 3: Ownership Check (Delete)
**Solution**:
**Frontend**:
```php
<?php if ($entry['user_id'] === Auth::getUserId()): ?>
    <a href="?delete=<?php echo $entry['id']; ?>">Delete</a>
<?php endif; ?>
```

**Backend**:
```php
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM entries WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, Auth::getUserId()]);
}
```

---

## 🧠 Key Takeaway
Authentication is the foundation of trust in an application. By using `password_hash()` and `session_regenerate_id()`, you are following the industry standard for protecting your users.
