# Solution 02: Validation & UX

## Task 1: Name Length Constraint
**Solution**:
Update the validation section in the PHP block:

```php
if (empty($name)) {
    $errors['name'] = 'Name is required.';
} elseif (strlen($name) < 2) {
    $errors['name'] = 'Name is too short (min 2 characters).';
}
```

---

## Task 2: Custom Email Regex / String Check
**Solution**:
You can use `preg_match` or string functions.

```php
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
} elseif (!str_ends_with($email, '.com') && !str_ends_with($email, '.org')) {
    $errors['email'] = 'Only .com and .org emails are allowed for this guestbook.';
}
```

---

## Task 3: Success Autofocus
**Solution**:
Create a variable to track success, then use it in the HTML.

In the PHP block:
```php
$is_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
    // ... saving logic ...
    $is_success = true;
}
```

In the HTML:
```php
<input type="text" name="name" id="name" 
       value="<?php echo htmlspecialchars($name); ?>" 
       <?php echo $is_success ? 'autofocus' : ''; ?>>
```

---

## 🧠 Key Takeaway
Validation is about **business rules**. If your guestbook is only for professional use, you might validate that names don't contain numbers. If it's for a specific company, you might validate the email domain. PHP gives you the tools; you define the rules!
