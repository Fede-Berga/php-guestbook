# Lesson 04: Constraints & Business Logic

## 📖 Introduction
Validation is the first step, but **Constraints** are where you define the specific rules of your application. In this version, we introduced a "Business Rule": Messages must be short (150 characters or less).

This prevents users from "spamming" your guestbook with huge walls of text and ensures the UI remains clean.

## 🧠 Key Concepts

### 1. Backend Enforcement: `mb_strlen()`
When dealing with text in PHP, we use `mb_strlen()` (Multi-Byte String Length).
**Why?** Normal `strlen()` counts *bytes*. Some characters (like emojis 🚀 or accented letters) use multiple bytes. `mb_strlen()` counts the actual characters, which is what the user expects.

### 2. Frontend Feedback (UX)
While the PHP script enforces the rule, the user shouldn't have to wait for a page refresh to find out their message is too long.
We added a small **JavaScript snippet** that:
1.  Listens for the `input` event on the textarea.
2.  Calculates the length instantly.
3.  Updates the UI (`0 / 150`) to guide the user.

### 3. Constants
Instead of typing `150` everywhere, we defined a PHP constant:
```php
const MAX_MESSAGE_LENGTH = 150;
```
If we decide later to increase the limit to 200, we only have to change it in **one place**.

## 🛑 Security: Why validate twice?
You might think: "I have JavaScript preventing the user from typing more than 150 chars. Do I still need the PHP check?"
**YES.** A user can easily:
1.  Disable JavaScript in their browser.
2.  Send a POST request directly using a tool like `curl` or Postman, bypassing your HTML form entirely.
**Frontend is for UX; Backend is for Integrity.**

## 🚀 The Task
Look at the `<script>` tag at the bottom of `index.php`. Notice how we inject the PHP constant `MAX_MESSAGE_LENGTH` directly into the JavaScript so they are always in sync.
