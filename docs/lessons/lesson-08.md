# Lesson 08: Security Hardening

## 📖 Introduction
Congratulations on reaching the final stage! You have transformed a vulnerable "Spaghetti" script into a secure, database-driven application. This final lesson focuses on **Hardening**—adding multiple layers of defense to protect against sophisticated attacks.

## 🧠 Key Concepts

### 1. Cross-Site Request Forgery (CSRF)
CSRF is an attack where a malicious website tricks your browser into performing an action on *our* website (like posting a message or changing a password) because you are already logged in.
*   **The Fix**: A **CSRF Token**. This is a secret, random string unique to your session. Every form must include this token. When the form is submitted, the server verifies that the token matches the one in your session.

### 2. Security Headers
HTTP Headers are instructions sent from the server to the browser.
*   **X-Frame-Options: DENY**: Prevents your site from being loaded in an `<iframe>`, which stops "Clickjacking" attacks.
*   **X-Content-Type-Options: nosniff**: Tells the browser to trust the `Content-Type` we send and not try to guess it.
*   **Content-Security-Policy (CSP)**: A powerful tool that tells the browser which sources of scripts, styles, and images are trusted.

### 3. Secure Cookie Flags
Cookies store your Session ID. If they are stolen, your account is hijacked.
*   **HttpOnly**: Prevents JavaScript from reading the cookie.
*   **Secure**: Ensures the cookie is only sent over HTTPS.
*   **SameSite=Strict**: Tells the browser not to send the cookie when coming from an external link (another layer of CSRF protection).

### 4. Filesystem Security
Your `database/` and `src/` directories contain sensitive information.
*   **The Fix**: Use `.htaccess` (on Apache) to explicitly deny web access to these folders. Only `index.php` and your assets (CSS/JS) should be public.

## 🛑 The "Defense in Depth" Mindset
Security is never "finished." It is about making it so difficult and expensive for an attacker that they give up. By combining Validation, Prepared Statements, Hashing, CSRF Tokens, and Headers, you have built a strong fortress.

## 🚀 The Task
1.  Open your browser's Developer Tools (`F12`), go to the **Network** tab, refresh the page, and click on `index.php`. Look at the **Headers** section to see your security configuration in action.
2.  Try to submit a form after deleting the `csrf_token` hidden input using the "Inspect Element" tool. What happens?
