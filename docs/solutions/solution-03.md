# Solution 03: Helpers & Modular Code

## Task 1: Greeting Helper
**Solution**:
In `helpers.php`:
```php
function get_greeting(): string {
    $hour = (int)date('H');
    if ($hour < 12) return "Good Morning";
    if ($hour < 18) return "Good Afternoon";
    return "Good Evening";
}
```
In `views/header.php`:
```html
<h1>📝 <?php echo get_greeting(); ?>!</h1>
```

---

## Task 2: Refactor CSS
**Solution**:
1. Create `public/css/style.css`.
2. Move the contents of the `<style>` tag there.
3. In `views/header.php`:
```html
<link rel="stylesheet" href="/css/style.css">
```
*(Note: Since we are running in `/src`, the path might be `../public/css/style.css` or similar depending on your server setup. In our DevContainer, `src` is the root, so you might just put it in `src/css/style.css`).*

---

## Task 3: Obfuscate Email
**Solution**:
In `helpers.php`:
```php
function obfuscate_email(string $email): string {
    $parts = explode('@', $email);
    $name = $parts[0];
    $domain = $parts[1];
    
    $masked_name = substr($name, 0, 1) . str_repeat('*', max(0, strlen($name) - 1));
    return $masked_name . '@' . $domain;
}
```
In `index.php`:
```php
(<?php echo e(obfuscate_email($entry['email'])); ?>)
```

---

## 🧠 Key Takeaway
Modular code is about **Organization**. By giving names to logic (functions) and parts of the UI (views), you make the project much easier to understand for other developers (and your future self!).
