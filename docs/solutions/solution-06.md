# Solution 06: Features & Sorting

## Task 1: Count Featured
**Solution**:
Before the dropdown form:
```php
$featured_count = $db->query("SELECT COUNT(*) FROM entries WHERE is_featured = 1")->fetchColumn();
```
In the `<select>` tag:
```html
<option value="featured">Featured First (<?php echo $featured_count; ?>)</option>
```

---

## Task 2: Admin Mode Toggle
**Solution**:
Define the variable at the top:
```php
$admin_mode = true; // Set to false to hide
```
In the loop:
```php
<?php if ($admin_mode): ?>
    <a href="?toggle_feature=<?php echo $entry['id']; ?>...">...</a>
<?php endif; ?>
```

---

## Task 3: Search Feature
**Solution**:
1. Add `<input type="text" name="q">` to the sorting form.
2. In PHP:
```php
$q = $_GET['q'] ?? '';
$where = "1=1"; // Default always true
$params = [];

if ($q) {
    $where = "message LIKE ?";
    $params[] = "%$q%";
}

$entries = $db->prepare("SELECT * FROM entries WHERE $where ORDER BY $order_by");
$entries->execute($params);
$results = $entries->fetchAll();
```

---

## 🧠 Key Takeaway
Dynamic sorting and filtering make applications feel "Pro". The key is balancing the flexibility (allowing users to sort) with security (ensuring they can't inject malicious SQL into your `ORDER BY` clause).
