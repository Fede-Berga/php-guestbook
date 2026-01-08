# Exercise 03: Expanding the Helpers

## 🎯 Objective
Practice extending helper libraries and using modular components.

## 📝 Task
1.  **Add a "Greeting" Helper**: In `helpers.php`, create a function called `get_greeting()` that returns "Good Morning", "Good Afternoon", or "Good Evening" based on the current hour of the day. Display this greeting in the header.
2.  **Refactor the CSS**: Notice that the CSS is still inside `views/header.php`. Move all the CSS into a new file `public/css/style.css` and link it in the header.
3.  **Humanize Emails**: Update `helpers.php` to add a function `obfuscate_email($email)` that hides part of the email (e.g., `j***@example.com`) for privacy. Use this in the entries display.

## 💡 Hints
- `date('H')` returns the hour in 24-hour format (00-23).
- For email obfuscation, you can use `substr()` and `strpos()`.

## 🧪 Verification
- Refresh the page and check if the greeting changes appropriately.
- Ensure the site still looks correct after moving the CSS.
- Check if guest emails in the list are partially hidden.
