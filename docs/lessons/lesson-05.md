# Lesson 05: Relational Data & SQL Injection

## 📖 Introduction
Until now, our data vanished every time the session ended. To build real applications, we need persistent storage. This lesson introduces **MySQL** and the **PDO** (PHP Data Objects) extension.

## 🧠 Key Concepts

### 1. Database Normalization
Instead of one big mess, we organize data into **Tables**.
*   `entries`: Stores the messages.
*   `users`: Stores user accounts.
*   **Foreign Keys**: The `user_id` in the entries table "points" to a specific user in the users table. This is the "Relation" in Relational Database.

### 2. The Singleton Pattern
Connecting to a database is "expensive" (takes time). We don't want to create a new connection every time we need to run a query.
The `Database` class uses the **Singleton Pattern** to ensure only ONE connection is created per request and reused everywhere.

### 3. PDO (PHP Data Objects)
PDO is the modern way to talk to databases in PHP. It is consistent, object-oriented, and supports many different database types (MySQL, PostgreSQL, SQLite).

### 4. 🛑 SQL Injection & Prepared Statements
This is the most important security concept in this course.
**BAD CODE**:
```php
$db->query("INSERT INTO entries (name) VALUES ('$name')");
```
If a user submits `' OR 1=1; --`, they can delete your whole database.

**GOOD CODE (Prepared Statements)**:
```php
$stmt = $db->prepare("INSERT INTO entries (name) VALUES (?)");
$stmt->execute([$name]);
```
Prepared statements send the "Template" and the "Data" separately. The database engine never interprets the Data as a command. **Always use Prepared Statements.**

## 🚀 The Task
1.  Run the migration in `database/schema/001_initial_schema.sql` to set up your tables.
2.  Observe how `index.php` now fetches data using `$db->query()->fetchAll()`.
