# Lesson 02: Validation & User Experience (UX)

## 📖 Introduction
In Version 1, our app was "optimistic"—it assumed users would always provide perfect data. In the real world, users make mistakes, leave fields empty, or try to enter invalid data (like an email without an `@` symbol).

This lesson covers how to protect your application logic and improve the user experience through **Server-Side Validation**.

## 🧠 Key Concepts

### 1. The "Sticky Form" Pattern
There is nothing more frustrating than filling out a long form, making one mistake, and having the page refresh with all your data gone.
**Sticky Forms** solve this by echoing the submitted data back into the `value` attribute of the inputs:
```php
<input value="<?php echo htmlspecialchars($name); ?>">
```

### 2. `filter_var()`
PHP provides a powerful function called `filter_var()` for validating data. For emails, we use:
```php
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Handle error
}
```

### 3. Sanitization vs. Validation
*   **Validation**: Checking if the data meets certain criteria (e.g., "Is this an email?").
*   **Sanitization**: Cleaning the data (e.g., "Remove HTML tags from this string").
*   In this version, we use `trim()` to remove accidental whitespace from the start/end of inputs.

### 4. Output Escaping (XSS Prevention)
We have introduced `htmlspecialchars()`. This is your primary defense against XSS. It converts special characters like `<` to `&lt;`, so the browser treats them as text instead of HTML tags.

## 🛑 Why Client-Side Validation isn't enough
You might know about the HTML `required` attribute. While useful for UX, a malicious user can easily disable it using Browser DevTools. **Always validate on the server.**

## 🚀 The Task
Observe how the `$errors` array is used to both:
1.  Prevent the data from being saved.
2.  Provide visual feedback (CSS classes and error messages) to the user.
