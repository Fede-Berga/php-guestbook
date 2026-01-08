# Exercise 01: Personalizing the Monolith

## 🎯 Objective
Learn how to manipulate the PHP Monolith and understand dynamic content generation.

## 📝 Task
1.  **Add a Footer Link**: Add a link to the project's GitHub repository in the footer.
2.  **Improve Time Display**: Change the date format in the entries to show the time in `H:i:s` format (e.g., `14:30:05`).
3.  **The "Slow Mode" Simulation**: Add a `usleep(50000);` (50ms) at the top of the script and observe how it affects the "Page loaded in..." metric in the footer.

## 💡 Hints
- The `date()` function documentation: [php.net/manual/en/function.date.php](https://www.php.net/manual/en/function.date.php)
- `usleep()` takes microseconds (1,000,000 = 1 second).

## 🧪 Verification
- Refresh the page and check the footer load time.
- Post a new entry and ensure the time (including seconds) is visible and accurate.

## 🚀 Bonus (Stretch Goal)
Try to "fix" the security vulnerability. Research the function `htmlspecialchars()` and wrap the message output in it. What happens when you try to submit a `<script>` tag now?
