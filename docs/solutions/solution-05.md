# Solution 05: Relational Data

## Task 1: Manual Migration
**Solution**:
Run this command in the terminal inside your container:
```bash
mysql -u user -ppassword -h db my_database < database/schema/001_initial_schema.sql
```

---

## Task 2: Count Entries
**Solution**:
In `index.php`, before the entries loop:

```php
$total_entries = $db->query("SELECT COUNT(*) FROM entries")->fetchColumn();
?>
<h2>Recent Entries (Showing <?php echo $total_entries; ?>)</h2>
```

---

## Task 3: Delete Entry
**Solution**:
At the top of the PHP block:
```php
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM entries WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php');
    exit;
}
```
In the entries loop:
```html
<a href="?delete=<?php echo $entry['id']; ?>" 
   onclick="return confirm('Are you sure?')" 
   style="color: red; font-size: 0.8em;">[Delete]</a>
```

---

## 🧠 Key Takeaway
Persistent storage changes everything. Your application is now "Stateful". But with power comes responsibility—using PDO and Prepared Statements is non-negotiable for security.
