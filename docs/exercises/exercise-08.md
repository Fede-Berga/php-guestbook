# Exercise 08: The Security Audit

## 🎯 Objective
Learn how to verify security measures and implement a simple rate-limiter.

## 📝 Task
1.  **Header Audit**: Use an online tool like [securityheaders.com](https://securityheaders.com) (if your site was public) or your Browser DevTools to verify that all 5 security headers from the lesson are present.
2.  **CSRF Bypass Attempt**: Try to create a simple HTML file on your local computer with a form that submits to `http://localhost:8080/src/index.php`. See if you can "post" a message from this external file. (It should fail due to the missing CSRF token).
3.  **Simple Rate Limiting (Hard)**: In `index.php`, before processing a post, check the timestamp of the last entry by the same user. If they posted less than 30 seconds ago, block the new post with an error: "Please wait a moment before posting again."

## 💡 Hints
- For Rate Limiting, you'll need a query: `SELECT created_at FROM entries WHERE user_id = ? ORDER BY created_at DESC LIMIT 1`.
- Compare the result with `time()`.

## 🧪 Verification
- Ensure the CSRF error message appears if the token is missing or tampered with.
- Verify that your "External" form attempt results in a `403` or a `die()` message.
- Try to post two messages in 5 seconds to test the rate limiter.
