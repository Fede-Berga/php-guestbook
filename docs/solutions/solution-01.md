# Solution 01: Personalizing the Monolith

This document provides the solutions for the tasks in `Exercise 01`.

## Task 1: Add a Footer Link
**Requirement**: Add a link to the project's GitHub repository in the footer.

**Solution**:
In the `<footer>` section of `src/index.php`, update the text to include an `<a>` tag.

```html
<footer>
    <p>
        &copy; <?php echo date('Y'); ?> 
        <a href="https://github.com/user/php-guestbook" target="_blank">PHP Guestbook Project</a> • 
        Page loaded in <?php echo round((microtime(true) - $start_time) * 1000, 2); ?>ms
    </p>
</footer>
```

---

## Task 2: Improve Time Display
**Requirement**: Change the date format in the entries to show the time in `H:i:s` format.

**Solution**:
Locate the `date()` function calls in the PHP logic and the rendering loop. Change `'Y-m-d H:i:s'` to include the seconds if not already present, or modify as desired.

In the rendering loop:
```php
<div class="entry-meta">
    <strong><?php echo $entry['name']; ?></strong> 
    • <?php echo date('M d, Y @ H:i:s', strtotime($entry['created_at'])); ?>
</div>
```

---

## Task 3: The "Slow Mode" Simulation
**Requirement**: Add `usleep(50000);` (50ms) at the top of the script and observe the load time.

**Solution**:
Add the function call immediately after the `$start_time` definition.

```php
// Track page load time
$start_time = microtime(true);

// Simulate slow processing (50ms)
usleep(50000); 
```

**Observation**: The footer should now show a value of at least `50.xx ms`.

---

## 🚀 Bonus: Fixing the XSS Vulnerability
**Requirement**: Use `htmlspecialchars()` to prevent script injection.

**Solution**:
Wrap the message output in the `htmlspecialchars()` function. This converts characters like `<` and `>` into HTML entities (`&lt;` and `&gt;`), preventing the browser from interpreting them as tags.

```php
<div class="entry-content">
    <?php echo htmlspecialchars($entry['message'], ENT_QUOTES, 'UTF-8'); ?>
</div>
```

**Result**: If you submit `<script>alert(1)</script>`, it will be displayed as literal text on the screen rather than executing the JavaScript.
