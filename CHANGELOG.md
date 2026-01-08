# Changelog

All notable changes to the PHP Guestbook project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v8-security-hardening] - Version 8
### Added
- CSRF Protection using a per-session token.
- `Security` class for handling headers and tokens.
- HTTP Security Headers (`X-Frame-Options`, `X-Content-Type-Options`, etc.).
- Rate Limiting basics.
- `.htaccess` rules to block access to `src/` and `database/`.

### Changed
- All forms now require a `_csrf_token` hidden field.
- Session cookie parameters set to `HttpOnly` and `Secure`.

### Security
- Mitigated Cross-Site Request Forgery (CSRF).
- Mitigated Clickjacking.
- Mitigated MIME-type sniffing.

## [v7-auth] - Version 7
### Added
- User Authentication (Login/Register/Logout).
- `Auth` class for session management.
- Password hashing using `password_hash()` (Argon2ID/Bcrypt).
- Session regeneration on login to prevent Session Fixation.
- "Logged in as..." UI element.

### Changed
- Entries now belong to a logged-in user (optional for guestbook, but enforced for editing).

### Security
- Passwords are never stored in plain text.
- Sessions are destroyed properly on logout.

## [v6-features] - Version 6
### Added
- "Featured" entries logic.
- Sorting mechanism (Newest vs Oldest vs Featured).
- Boolean column `is_featured` in database.

### Changed
- SQL query updated to handle `ORDER BY` dynamically but safely (whitelisting columns).

## [v5-relations] - Version 5
### Added
- `users` table migration.
- `PDO` usage replacing `mysqli` completely.
- `Database` class singleton pattern.
- Foreign Key constraint between `entries` and `users`.

### Security
- **CRITICAL**: Switched to Prepared Statements for ALL queries (SQL Injection mitigation).

## [v4-constraints] - Version 4
### Added
- Character limits (150 chars) for messages.
- Visual character counter (JavaScript).
- Backend validation for string length.

### Changed
- UI feedback for validation errors is more distinct (Red borders).

## [v3-helpers] - Version 3
### Added
- `helpers.php` file for utility functions.
- `format_date()` function for "Time Ago" display.
- Separation of `views/header.php` and `views/footer.php`.

### Changed
- Date display changed from raw timestamp to relative time.

## [v2-validation] - Version 2
### Added
- Server-side input validation logic.
- Email field to the form.
- Error message array handling.
- Sticky form inputs (re-populating fields on error).

### Security
- Basic input sanitization using `trim()` and `htmlspecialchars()`.

## [v1-monolith] - Version 1
### Added
- Initial project structure.
- Single `index.php` file.
- Basic HTML form.
- Connection to MySQL using `mysqli`.
- Dynamic footer with year and load time.

### Security
- Basic `htmlspecialchars` on output (introduction to XSS prevention).
