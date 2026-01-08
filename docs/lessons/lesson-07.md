# Lesson 07: Authentication & Session Security

## 📖 Introduction
So far, anyone could post to the guestbook, and there was no way to prove who wrote what. In this lesson, we implement **Authentication**—the process of verifying who a user is.

## 🧠 Key Concepts

### 1. Password Hashing (The Golden Rule)
**NEVER store passwords in plain text.** If your database is stolen, every user's account (and likely their other accounts with the same password) is compromised.
*   **Solution**: Use `password_hash($password, PASSWORD_DEFAULT)`.
*   **Verification**: Use `password_verify($password, $hash)`.
*   PHP currently uses **BCRYPT** or **Argon2**, both of which are designed to be slow and secure against brute-force attacks.

### 2. Session Fixation & Hijacking
Sessions can be stolen. To make them more secure:
1.  **Regenerate ID**: Always call `session_regenerate_id(true)` when a user's privilege level changes (like during login). This gives them a new ID and invalidates the old one.
2.  **HttpOnly Cookies**: (Coming in v8) Ensures JavaScript cannot read the session cookie.

### 3. State Management (Login/Logout)
*   **Login**: Check credentials -> Store User ID in `$_SESSION`.
*   **Auth Check**: On protected pages, check if `isset($_SESSION['user_id'])`.
*   **Logout**: Clear `$_SESSION` and destroy the session.

### 4. Relational Ownership
Our `entries` table now has a `user_id` column. When a logged-in user posts, we save their ID. This allows us to:
*   Display a verified badge next to their name.
*   Allow users to edit/delete their own posts (Interactive Task).

## 🚀 The Task
1.  Register a new account.
2.  Look at the `users` table in the database (via terminal). Notice how you cannot read the password.
3.  Post an entry while logged in, then logout and post another as a guest. Observe the difference in the list.
