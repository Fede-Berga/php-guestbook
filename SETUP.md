# ⚙️ Setup Guide

This guide covers the installation and configuration of the **PHP Guestbook** project. We strongly recommend using the provided **Docker** and **DevContainer** setup for a consistent development environment.

## 📋 Prerequisites

*   **Git**: For version control.
*   **Docker Desktop**: For running the containerized environment.
*   **VS Code**: Recommended editor (with "Dev Containers" extension).

---

## 🐳 Option 1: Docker (Recommended)

This project comes with a pre-configured DevContainer. This ensures you have the exact PHP version (8.2), extensions, and Database configuration required.

### Steps

1.  **Clone the Repository**
    ```bash
    git clone <repository-url>
    cd php-db-integration
    ```

2.  **Open in VS Code**
    Open the folder in VS Code. You should see a notification popup in the bottom right corner:
    > "Folder contains a Dev Container configuration file. Reopen to folder to develop in a container."

    Click **Reopen in Container**.

    *Alternatively:* Press `F1`, type "Dev Containers: Reopen in Container", and select it.

3.  **Wait for Build**
    Docker will build the image and start the MySQL service. This may take a few minutes the first time.

4.  **Verify Connection**
    Once the terminal opens in VS Code, you are inside the Linux container.
    Open your browser to `http://localhost:8080`. You should see the application (or a "Success" message if on the starting branch).

### Database Management

The MySQL database is available at host `db` with the following credentials (defined in `docker-compose.yml`):

*   **Host**: `db`
*   **User**: `user`
*   **Password**: `password`
*   **Database**: `my_database`
*   **Root Password**: `rootpassword`

---

## 💻 Option 2: Local LAMP/WAMP/MAMP Setup

If you prefer to run PHP locally:

1.  **Install PHP 8.2+**
    Ensure you have `php-mysql`, `php-pdo`, and `php-mbstring` extensions enabled in your `php.ini`.

2.  **Install MySQL 8.0**
    Create a database named `my_database`.

3.  **Configure Application**
    You may need to edit `src/config/database.php` (in later versions) or the connection string in `index.php` (in early versions) to match your local database credentials (e.g., host might be `localhost` or `127.0.0.1` instead of `db`).

4.  **Start Server**
    You can use the built-in PHP server:
    ```bash
    php -S localhost:8080 -t public/
    ```
    *(Note: The document root `-t` may vary depending on the specific version you are working on).*

---

## 🗄️ Database Migrations

Each version contains SQL scripts in `database/schema/`.

**To import a schema via command line (Docker):**

```bash
# Example for Version 1
cat database/schema/001_create_entries_table.sql | docker exec -i mysql-db mysql -u user -ppassword my_database
```

*Note: In the interactive exercises, you will often be writing the SQL queries yourself before running these scripts.*

---

## 🐞 Troubleshooting

### "Connection Refused"
*   Ensure the Docker containers are running (`docker ps`).
*   If running locally, check if MySQL is running on port 3306.

### "Driver not found"
*   Ensure the `pdo_mysql` extension is installed and enabled in PHP.

### Permissions
*   If you cannot write files, ensure your user owns the `src` directory. In the DevContainer, this is handled automatically.
