# PHP Guestbook: From Spaghetti to MVC

> **A comprehensive educational journey from procedural chaos to professional architectural patterns.**

## 🎓 Project Overview

Welcome to **PHP Guestbook: From Spaghetti to MVC**. This project is designed as a hands-on course for learning PHP, Database Design, and Software Architecture. Unlike many tutorials that show you the "right way" immediately, this course takes a unique pedagogical approach: **Evolutionary Refactoring**.

We start with "Spaghetti Code"—the kind of code beginners often write, mixing HTML, SQL, and PHP logic in a single file. Over the course of 8 distinct versions, we methodically refactor, secure, and enhance the application, eventually arriving at a modern, secure, and maintainable MVC (Model-View-Controller) architecture.

### 🎯 Learning Objectives

By the end of this course, students will understand:

1.  **The "Why" behind MVC**: Experiencing the pain of maintenance in monolithic scripts makes the solution (MVC) obvious.
2.  **Security First**: Moving from vulnerable code to hardening against XSS, SQL Injection, and CSRF.
3.  **Database Normalization**: Evolving from a single flat table to a relational schema.
4.  **Modern PHP Standards**: Adopting PSR-12, type hinting, and strict typing.
5.  **Developer Experience**: The importance of readable code, comments, and project structure.

---

## 📚 Curriculum Roadmap

The course is divided into 8 versions (Tags). Each represents a milestone in the application's evolution.

### Phase 1: The Basics (Procedural)

*   **Version 1: The Monolith** (`v1-monolith`)
    *   **Concept**: A single `index.php` file handling form submission, database connection, and display.
    *   **Focus**: Basic PHP syntax, `$_POST`, `mysqli` connection.
    *   **Interactive Task**: Add a dynamic footer.
    *   **Vulnerabilities**: XSS, basic SQL injection potential.

*   **Version 2: Validation & UX** (`v2-validation`)
    *   **Concept**: Introduction of input validation logic.
    *   **Focus**: `filter_var`, Regex, User Feedback loops.
    *   **Interactive Task**: Email field with validation.

*   **Version 3: Helpers & Formatting** (`v3-helpers`)
    *   **Concept**: Extracting logic into reusable functions.
    *   **Focus**: `date()` formatting, creating a `helpers.php` file.
    *   **Interactive Task**: Implement "Time Ago" formatting.

*   **Version 4: Constraints & Logic** (`v4-constraints`)
    *   **Concept**: Enforcing business rules.
    *   **Focus**: String manipulation, character limits, UI feedback for limits.
    *   **Interactive Task**: Visual character counter.

### Phase 2: The Database & Structure

*   **Version 5: Relational Data** (`v5-relations`)
    *   **Concept**: Database Normalization.
    *   **Focus**: Creating a `users` table, Foreign Keys, `JOIN` queries.
    *   **Security**: Introduction to Prepared Statements (PDO).

*   **Version 6: Features & Sorting** (`v6-features`)
    *   **Concept**: Advanced querying and logic.
    *   **Focus**: Boolean flags, sorting algorithms in SQL vs PHP.
    *   **Interactive Task**: "Featured" posts mechanism.

### Phase 3: Architecture & Security

*   **Version 7: Authentication** (`v7-auth`)
    *   **Concept**: Managing User Sessions.
    *   **Focus**: `session_start()`, `password_hash()`, Login/Logout logic.
    *   **Interactive Task**: "Logged in as..." display.

*   **Version 8: Security Hardening** (`v8-security`)
    *   **Concept**: Professional Grade Security.
    *   **Focus**: CSRF Tokens, HTTP Headers, Rate Limiting, strict separation of concerns.
    *   **Interactive Task**: Full CSRF protection implementation.

---

## 🔄 How to Navigate Versions

This repository uses **Git Tags** to manage the different stages of the project. This allows you to jump to any milestone to see the code as it was at that specific lesson.

### 1. View all versions
```bash
git tag
```

### 2. Switch to a specific version
To "go back in time" to a specific lesson, use the checkout command:
```bash
# Example: Switch to Version 1 (The Monolith)
git checkout v1-monolith

# Example: Switch to Version 5 (Relational Data)
git checkout v5-relations
```

### 3. Work on Exercises
When you switch to a tag, you are in a "detached HEAD" state. If you want to save your work while doing the exercises, it's best to create a new branch from that tag:
```bash
# Example: Create a working branch for Lesson 3
git checkout -b my-lesson-3-work v3-helpers
```

### 4. Return to the latest version
```bash
git checkout master
```

---

## 🛠 Tech Stack

*   **Language**: PHP 8.2+
*   **Database**: MySQL 8.0
*   **Frontend**: Plain HTML5/CSS3 (No frameworks to keep focus on PHP)
*   **Environment**: Docker (DevContainer provided)

---

## 📂 Project Structure (Final State)

```text
/
├── .devcontainer/      # Docker configuration
├── config/             # Configuration files (DB, Env)
├── database/           # Migration scripts
├── docs/               # Course material
├── public/             # Web root (Entry point)
│   ├── css/
│   ├── js/
│   └── index.php
├── src/                # Application Source
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   └── Utils/
├── tests/              # Unit tests
└── vendor/             # Composer dependencies
```

---

## 🚀 Getting Started

Please refer to [SETUP.md](./SETUP.md) for detailed installation and environment configuration instructions.

## 👨‍🏫 For Instructors

Please refer to [TEACHING.md](./TEACHING.md) for pedagogical guides, common pitfalls to watch for, and solution keys.

---

## 🤝 Contributing

This project is intended for educational purposes. Issues and Pull Requests fixing bugs or improving documentation are welcome.

## 📄 License

MIT License.
