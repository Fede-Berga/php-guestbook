# Exercise 07: Secure Authentication

## 🎯 Objective
Understand how to manage user sessions and protect sensitive actions.

## 📝 Task
1.  **Strict Auth for Messaging**: Modify `index.php` so that *only* logged-in users can see the post entry form. Guests should see a message saying "Please login to post."
2.  **Password Strength**: Update `register.php` to require the password to contain at least one number and one uppercase letter.
3.  **Delete My Own**: Add a "Delete" button that *only* appears on entries that belong to the currently logged-in user. Ensure the backend check verifies ownership before deleting!

## 💡 Hints
- Use `Auth::isLoggedIn()` to toggle the form visibility.
- For password strength, use `preg_match('/[A-Z]/', $password)` and `preg_match('/[0-9]/', $password)`.
- For the delete check: `if ($entry['user_id'] === Auth::getUserId())`.

## 🧪 Verification
- Log out and ensure the post form is hidden.
- Try to register with a simple password (if you implemented task 2).
- Create a post with User A, log in as User B, and ensure User B *cannot* see the delete button for User A's post.
