# Exercise 04: Logic & Limits

## 🎯 Objective
Learn how to implement multi-layered constraints and refine the user experience.

## 📝 Task
1.  **Block Swearing**: Create a simple "profanity filter". If a message contains the word "spam" or "badword", block the submission with an error: "Your message contains prohibited language."
2.  **Visual Warning**: Modify the JavaScript in `index.php` so that when the user reaches 140 characters (10 left), the counter turns orange as a warning before it turns red at 150.
3.  **Prevent Duplicate Submissions**: In Version 2 we mentioned "Double Submission" (when a user refreshes the page after posting). Implement a check to prevent the exact same message from being posted twice in a row by the same user.

## 💡 Hints
- Use `str_contains()` or `preg_match()` for the word filter.
- In JS, you can add another `if` condition for the color change.
- For duplicate prevention, compare the `$_POST['message']` with the `end($_SESSION['entries'])['message']`.

## 🧪 Verification
- Try to submit a message with "spam" in it.
- Type exactly 141 characters and see if the counter changes color.
- Try to post the same message twice and ensure only one appears.
