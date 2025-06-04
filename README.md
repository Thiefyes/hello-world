# Simple CMS Admin Panel

This repository provides a minimal example of a website builder using a PHP backend with a React frontend and MySQL storage. The backend is split into small services for easier extension.

## Structure

- `backend/` – PHP services and API endpoints
- `backend/services/` – individual service classes (pages, auth, SEO, etc.)
- `public/admin/` – React application available under `/admin`

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

Alternatively run `install.php` in your browser and follow the form to create the database and configuration automatically.

## Running

Serve the repository with a web server that supports PHP. The React admin is accessible at `/admin` and communicates with the PHP API in `backend/`.
