# Exercise 05: Relational Queries

## 🎯 Objective
Learn how to interact with a real database and perform basic relational operations.

## 📝 Task
1.  **Manual Migration**: Use the terminal to import the `database/schema/001_initial_schema.sql` file into your MySQL database.
    *   Command: `cat database/schema/001_initial_schema.sql | mysql -u user -ppassword -h db my_database`
2.  **Count Entries**: Add a line at the top of the "Recent Entries" section that says: "Showing X entries", where X is the total number of entries in the database. (Use a `SELECT COUNT(*)` query).
3.  **Delete Entry (Hard)**: Add a small "Delete" link next to each entry. It should send the `id` of the entry to a new script (or the same index.php) which then runs a `DELETE` query. *Warning: Make sure you use a prepared statement for the ID!*

## 💡 Hints
- `$db->query("SELECT COUNT(*) FROM entries")->fetchColumn()` is a quick way to get a single count.
- For deletion, you can use `index.php?delete=5`. Check `isset($_GET['delete'])` at the top of your script.

## 🧪 Verification
- Refresh the page and ensure the data persists even if you restart your browser.
- Verify that the entry count updates when you post a new message.
