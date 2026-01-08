# Exercise 06: Advanced Sorting

## 🎯 Objective
Learn how to implement complex UI logic and handle dynamic database queries safely.

## 📝 Task
1.  **Count Featured**: Add a small badge next to the "Featured First" option in the dropdown that shows how many featured entries currently exist (e.g., "Featured First (3)").
2.  **Hide Unfeature Button**: Currently, anyone can click "Feature/Unfeature". Since we don't have login yet, simulate a "Maintenance Mode". Add a PHP variable `$admin_mode = false;`. Only show the toggle link if `$admin_mode` is true.
3.  **Search Feature (Hard)**: Add a simple search input field. When the user types a word and hits enter, update the SQL query to include a `WHERE message LIKE %word%` clause.

## 💡 Hints
- For Task 2, use a simple `if ($admin_mode): ... endif;` around the toggle link.
- For Task 3, remember to use a **Prepared Statement** for the search word!
  ```php
  $stmt = $db->prepare("... WHERE message LIKE ? ...");
  $stmt->execute(["%$search%"]);
  ```

## 🧪 Verification
- Toggle an entry to featured and ensure it moves to the top when "Featured First" is selected.
- Ensure that sorting by "Oldest" correctly puts the admin's welcome message (the first entry) at the very top.
