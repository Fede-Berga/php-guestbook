# PHP Guestbook: From Spaghetti to Security

Teaching material for a hands-on PHP course, written for technical high school students and their teachers: one guestbook application evolves through eight tagged versions, from a single spaghetti-code file to a MySQL-backed app with user accounts, CSRF protection and security headers.

## Project Overview

The course covers PHP, Database Design, and Software Architecture. Unlike many tutorials that show you the "right way" immediately, it takes a different pedagogical approach: **Evolutionary Refactoring**.

We start with "Spaghetti Code"—the kind of code beginners often write, mixing HTML, PHP logic, and data storage in a single file. Over the course of 8 versions, we refactor, secure, and extend the application step by step: from an in-memory session array to MySQL with prepared statements, then user accounts and, finally, security hardening.

### Learning Objectives

By the end of this course, students will understand:

1.  **The "Why" behind separation of concerns**: Experiencing the pain of maintenance in a monolithic script motivates splitting it into helpers, shared views, and classes, the first steps towards MVC.
2.  **Security First**: Moving from vulnerable code to hardening against XSS, SQL Injection, and CSRF.
3.  **Database Normalization**: Evolving from an in-memory session array to a relational schema.
4.  **Modern PHP Standards**: Adopting type hinting, PDO, and the built-in password hashing API.
5.  **Developer Experience**: The importance of readable code, comments, and project structure.

---

## Curriculum Roadmap

The course is divided into 8 versions (Tags). Each represents a milestone in the application's evolution and comes with a lesson in [`docs/lessons/`](docs/lessons/), an exercise in [`docs/exercises/`](docs/exercises/) and its solution in [`docs/solutions/`](docs/solutions/).

### Phase 1: The Basics (Procedural)

*   **Version 1: The Monolith** (`v1-monolith`)
    *   **Concept**: A single `index.php` file handling form submission, storage, and display.
    *   **Focus**: Basic PHP syntax, `$_POST`, `$_SESSION` as an in-memory database.
    *   **Interactive Task**: Add a dynamic footer.
    *   **Vulnerabilities**: XSS (output is not escaped).

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
    *   **Focus**: Moving from the session to MySQL, a `users` table, Foreign Keys.
    *   **Security**: Introduction to Prepared Statements (PDO).

*   **Version 6: Features & Sorting** (`v6-features`)
    *   **Concept**: Advanced querying and logic.
    *   **Focus**: Boolean flags, dynamic `ORDER BY` with a whitelist of sort options.
    *   **Interactive Task**: "Featured" posts mechanism.

### Phase 3: Architecture & Security

*   **Version 7: Authentication** (`v7-auth`)
    *   **Concept**: Managing User Sessions.
    *   **Focus**: `session_start()`, `password_hash()`, Login/Logout logic, a `JOIN` to show the author's username.
    *   **Interactive Task**: "Logged in as..." display.

*   **Version 8: Security Hardening** (`v8-security`)
    *   **Concept**: Defense in depth.
    *   **Focus**: CSRF Tokens, HTTP security headers, secure session cookies, `.htaccess` rules.
    *   **Interactive Task**: Full CSRF protection implementation.

---

## How to Navigate Versions

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
git checkout main
```

---

## Tech Stack

*   **Language**: PHP 8.2+
*   **Database**: MySQL 8.0
*   **Frontend**: Plain HTML5/CSS3 and a few lines of JavaScript (No frameworks to keep focus on PHP)
*   **Environment**: Docker (DevContainer provided)

---

## Project Structure (Final State)

```text
/
├── .devcontainer/      # Dev Container: PHP 8.2 with Apache, MySQL 8.0
├── .htaccess           # Access rules and security headers for Apache (v8)
├── database/schema/    # SQL migrations (v5, v6)
├── docs/
│   ├── lessons/        # One lesson per version
│   ├── exercises/      # One exercise per version
│   └── solutions/      # Solutions to the exercises
└── src/                # Application source
    ├── index.php       # The guestbook page
    ├── login.php, register.php, logout.php
    ├── Auth.php, Database.php, Security.php
    ├── helpers.php
    └── views/          # header.php, footer.php
```

---

## Getting Started

Please refer to [SETUP.md](SETUP.md) for detailed installation and environment configuration instructions.

## For Instructors

Please refer to [TEACHING.md](TEACHING.md) for the pedagogical approach, common pitfalls to watch for, a grading rubric, and a suggested schedule. The solution keys are in [`docs/solutions/`](docs/solutions/).

---

## License

The code and the lesson material are licensed separately:

*   The lesson material (the lessons, exercises and solutions in [`docs/`](docs/) and the teaching guide [`TEACHING.md`](TEACHING.md)) is licensed under [Creative Commons Attribution 4.0 International](https://creativecommons.org/licenses/by/4.0/) (CC BY 4.0), see [`LICENSE-docs`](LICENSE-docs). You can reuse and adapt it, also in your own classes, as long as you credit Federico Bergamini.
*   Everything else, including the code in `src/`, `database/` and `.devcontainer/`, is released under the [MIT License](LICENSE).
