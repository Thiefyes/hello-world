# Simple CMS Admin Panel

This repository provides a minimal example of a website builder using a PHP backend with a React frontend and MySQL storage.

## Structure

- `backend/` – PHP API for managing pages stored in MySQL.
- `frontend/` – small React application for editing pages.

## Database

Create a MySQL database and table:

```sql
CREATE DATABASE cms;
CREATE TABLE cms.pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL
);
```

Alternatively run `install.php` in your browser and follow the form to create
the database and configuration automatically.

## Running

Serve the `frontend` and `backend` folders with a web server that supports PHP. The React code uses simple fetch requests to the PHP API.
