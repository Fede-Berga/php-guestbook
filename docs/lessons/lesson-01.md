# Lesson 01: The Monolith & In-Memory State

## 📖 Introduction
Welcome to your first step in PHP development! In this version, we are building a "Monolith"—a single file that handles everything:
1.  **State Management**: Using PHP Sessions to remember data.
2.  **Request Handling**: Processing `$_POST` data.
3.  **Presentation**: Rendering HTML with embedded PHP.

## 🧠 Key Concepts

### 1. PHP Tags & Echo
PHP code starts with `<?php` and ends with `?>`. To output content to the browser, we use the `echo` statement.
```php
echo "Hello World";
```

### 2. The Superglobals: `$_POST` and `$_SESSION`
*   `$_POST`: An associative array that contains data sent via an HTTP POST request (the form).
*   `$_SESSION`: A way to store information (in variables) to be used across multiple pages. Unlike cookies, the data is stored on the server.

### 3. State in a Stateless Protocol
HTTP is "stateless"—it forgets everything after a request finishes. `session_start()` tells PHP to link this request to a specific user using a unique ID, allowing us to keep an "In-Memory Database" (an array) alive between page refreshes.

## 🛑 Security: Cross-Site Scripting (XSS)
In this version, we are doing something **dangerous**. We are printing user-provided content directly to the page:
```php
echo $entry['message']; // DANGER!
```
If a user submits `<script>alert('Hacked!')</script>`, that script will run in every visitor's browser. This is called **XSS**.

## 🚀 The Task
Your job is to understand the flow of data:
`Form (HTML) -> POST Request -> PHP Script -> Session Array -> HTML Render`

---

## 🔧 Core Code Breakdown
- `session_start()`: Must be called before any output.
- `microtime(true)`: Used to calculate performance.
- `foreach`: Iterating over our array to display entries.
