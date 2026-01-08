# Solution 04: Constraints & Logic

## Task 1: Profanity Filter
**Solution**:
In the PHP validation block:
```php
$prohibited = ['spam', 'badword'];
foreach ($prohibited as $word) {
    if (str_contains(strtolower($message), $word)) {
        $errors['message'] = 'Your message contains prohibited language.';
        break;
    }
}
```

---

## Task 2: Orange Warning
**Solution**:
Update the `updateCounter` function in the `<script>` tag:

```javascript
function updateCounter() {
    const currentLength = messageArea.value.length;
    charsUsed.textContent = currentLength;
    
    if (currentLength > maxLength) {
        charsUsed.style.color = '#dc3545'; // Red
    } else if (currentLength >= maxLength - 10) {
        charsUsed.style.color = 'orange'; // Warning
    } else {
        charsUsed.style.color = '#666'; // Default
    }
}
```

---

## Task 3: Duplicate Submission Prevention
**Solution**:
Before saving to the session, check the last entry:

```php
$last_entry = end($_SESSION['entries']);
if ($last_entry && $last_entry['message'] === $message && $last_entry['name'] === $name) {
    $errors['message'] = 'You have already posted this message!';
}
```

---

## 🧠 Key Takeaway
Good software is built on **layers of protection**. JavaScript helps the user, PHP constants keep the code maintainable, and backend logic ensures that no matter how the data arrives, it follows your rules.
