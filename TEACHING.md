# 🍎 Teaching Guide

This document is intended for instructors, mentors, and self-learners acting as their own teachers. It outlines the pedagogical philosophy, common pitfalls, and strategies for effectively teaching the **PHP Guestbook** curriculum.

## 🧠 Pedagogical Philosophy

### 1. "Show, Don't Just Tell"
Students often struggle to understand *why* frameworks and patterns exist. By starting with "Spaghetti Code" (Version 1) and letting them feel the pain of modifying it, the *relief* provided by MVC (Version 8) becomes tangible and appreciated.

### 2. Security as a Habit, Not a Feature
Security is not a separate module at the end; it is woven into the progression. We introduce vulnerabilities (like XSS) early, exploit them safely, and then fix them. This "Red Team / Blue Team" approach helps concepts stick.

### 3. Progressive Disclosure
We do not introduce `Composer`, Namespaces, or ORMs immediately. We stick to raw PHP until the complexity of the application demands better tools. This reduces cognitive load.

---

## ⚠️ Common Mistakes & Pitfalls

### Mistake 1: Trusting `$_SERVER` or `$_POST` directly
**Why students do this**: It's easy and works for simple tests.
**The Problem**: Vulnerability to XSS and SQL Injection.
**The Fix**: Always wrap input in validation functions (introduced in v2) and output in escaping functions (introduced in v1).

### Mistake 2: Mixing Logic and Presentation
**Why students do this**: It's intuitive to `echo` HTML directly inside an `if` statement.
**The Problem**: The code becomes unreadable and impossible to unit test.
**The Fix**: Use "View" files or template variables. We start separating these in v3.

### Mistake 3: Not handling Database Errors
**Why students do this**: "Happy path" programming.
**The Problem**: The app crashes with a white screen or leaks sensitive credentials.
**The Fix**: Wrap DB operations in `try-catch` blocks (introduced with PDO in v5).

---

## 📝 Assessment & Interactive Tasks

Each version includes an **Interactive Task** designed to be specific and measurable.

### Grading Rubric (General)

| Criteria | 1 Point (Needs Improvement) | 2 Points (Good) | 3 Points (Excellent) |
| :--- | :--- | :--- | :--- |
| **Functionality** | Feature works but has edge-case bugs. | Feature works as requested. | Feature works and handles errors gracefully. |
| **Security** | Input is not validated or escaped. | Basic validation present. | Strict validation and escaping; no XSS/SQLi. |
| **Code Style** | Inconsistent indentation/naming. | Mostly PSR-12 compliant. | Perfectly PSR-12 compliant; excellent comments. |
| **Documentation** | No comments. | Functions are commented. | Detailed DocBlocks explaining "Why". |

---

## 🗓️ Lesson Planning

**Total Duration**: ~16-20 Hours (2-3 hours per version)

1.  **Introduction (v1)**: 2 hours. Focus on syntax and basic flow.
2.  **Validation (v2)**: 2 hours. Focus on Regex and Security.
3.  **Refactoring (v3-v4)**: 3 hours. Focus on code organization.
4.  **Database (v5-v6)**: 4 hours. SQL, Relations, Normalization.
5.  **Auth & Security (v7-v8)**: 5 hours. Sessions, Hashing, CSRF.
6.  **Final Review**: 2 hours. Code review and "Polishing".

---

## 💡 Tips for Instructors

*   **Encourage Breakage**: Tell students to try and break their own app. "Put `<script>alert('hack')</script>` in the name field. What happens?"
*   **Code Reviews**: Peer reviews are powerful. Have students swap code between v4 and v5 to see how different people solved the "Character Limit" task.
*   **Live Coding**: demonstrating the refactoring process live (e.g., taking a block of code and moving it to a function) is more effective than slides.
