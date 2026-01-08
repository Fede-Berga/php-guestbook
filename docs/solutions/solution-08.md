# Solution 08: Security Hardening

## Task 1: Header Audit
**Solution**:
Open DevTools -> Network -> index.php -> Response Headers. You should see:
- `X-Frame-Options: DENY`
- `X-Content-Type-Options: nosniff`
- `X-XSS-Protection: 1; mode=block`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Content-Security-Policy: ...`

---

## Task 2: CSRF Bypass
**Solution**:
Create `attacker.html`:
```html
<form action="http://localhost:8080/src/index.php" method="POST">
    <input type="hidden" name="name" value="Attacker">
    <input type="hidden" name="message" value="I hacked you!">
    <button type="submit">Click for Free Prize!</button>
</form>
```
**Result**: Upon clicking, the PHP script will run `Security::validateCsrfToken(null)`, which returns `false`, and the script will `die()`.

---

## Task 3: Simple Rate Limiting
**Solution**:
In `index.php`, inside the `POST` block:

```php
if (Auth::isLoggedIn()) {
    $last_post_time = $db->prepare("SELECT created_at FROM entries WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    $last_post_time->execute([Auth::getUserId()]);
    $last_time = $last_post_time->fetchColumn();

    if ($last_time && (time() - strtotime($last_time)) < 30) {
        $errors['message'] = 'You are posting too fast! Please wait 30 seconds.';
    }
}
```

---

## 🧠 Key Takeaway
You have built a secure application. You understand that code is not just about features, but about **trust**. By protecting user data and ensuring the integrity of your forms, you have graduated from a student to a responsible developer.
