# Lesson 03: Helpers & Modular Code

## 📖 Introduction
As applications grow, keeping everything in one file (the "Monolith") becomes a nightmare. If you want to change the footer link, you have to find it in every single page. If you have a complex calculation, you don't want to copy-paste it everywhere.

In this lesson, we introduce **Modularization** and **Helper Functions**.

## 🧠 Key Concepts

### 1. Dry Principle (Don't Repeat Yourself)
The goal of refactoring is to reduce repetition. By moving our HTML header and footer into separate files, we can reuse them across multiple pages (if we had them).

### 2. Including Files: `include` vs `require`
*   `include`: Tries to load a file. If it fails, the script continues with a warning.
*   `require`: Tries to load a file. If it fails, the script stops with a fatal error.
*   `_once` versions (e.g., `require_once`): Ensures the file is only loaded once per request, preventing function redefinition errors.

### 3. Creating a "Time Ago" Logic
Users find it easier to read "2 hours ago" than "2024-01-08 14:30:00". We created a `format_date()` function that:
1.  Calculates the difference between the current time and the timestamp.
2.  Determines the largest unit (year, month, day, etc.).
3.  Returns a human-readable string.

### 4. Shorthand Functions
We created a tiny helper `e()` which is just a shortcut for `htmlspecialchars()`. This makes our template code much cleaner:
```php
// Before
<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>

// After
<?php echo e($name); ?>
```

## 🚀 The Task
Explore the `src/helpers.php` file. Notice how the logic is separated from the presentation. The function doesn't care *how* the date is displayed (CSS, HTML), only *what* the text should be.
