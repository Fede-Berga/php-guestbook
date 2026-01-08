# Lesson 06: Features & Dynamic Sorting

## 📖 Introduction
Now that we have a database, we can do more than just list items. We can manipulate how they are displayed and add "Meta-Features" like highlighting specific content.

This lesson covers **Schema Updates** and **Dynamic SQL Queries**.

## 🧠 Key Concepts

### 1. Migrations (Schema Updates)
As your app grows, you will need to change the database structure. Instead of manually clicking in a GUI (like phpMyAdmin), we write **Migration Scripts** (`.sql` files). This ensures every developer on your team has the exact same database structure.

### 2. Boolean Flags in SQL
MySQL doesn't have a specific `BOOLEAN` type; it uses `TINYINT(1)`.
*   `0` = False
*   `1` = True
We use the `is_featured` flag to highlight special entries.

### 3. Dynamic Ordering (`ORDER BY`)
In previous versions, we used a hardcoded sorting. Now, we allow the user to choose.
**Security Note**: You cannot use prepared statements for column names or SQL keywords like `DESC/ASC`.
**The Fix**: Use **Whitelisting**. We check if the user's input is in our list of `$allowed_sorts`. If it's not, we default to "newest".

### 4. Multi-Column Sorting
You can sort by more than one thing at a time:
```sql
ORDER BY is_featured DESC, created_at DESC
```
This query says: "Show me all featured items first, and within the featured and non-featured groups, show the newest ones first."

## 🚀 The Task
1.  Notice the `idx_is_featured` in the migration file. This is an **Index**. It tells the database to keep a "map" of which rows are featured, making the "Featured First" sort much faster as your guestbook grows to thousands of entries.
2.  Try the "Feature/Unfeature" toggle and see how the UI changes color.
3.  Change the sorting and observe how the URL changes (e.g., `index.php?sort=oldest`).
