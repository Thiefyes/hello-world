# Simple CMS Admin Panel

This repository now ships with a Laravel backend. A legacy plain PHP implementation is still available in the `backend/` directory, but new development happens inside the `laravel/` folder. The React admin remains unchanged and communicates with the Laravel API.

## Structure

- `laravel/` – Laravel application providing the API
- `backend/` – legacy plain PHP API (no longer maintained)
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
CREATE TABLE cms.users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL
);
```

Alternatively run `install.php` in your browser and follow the form to create the database and configuration automatically.

## Running

Inside `laravel/` run `php artisan migrate` once to create the SQLite database. Afterwards start the server with `php artisan serve --host=127.0.0.1 --port=8000`. The React admin is accessible at `/admin` and now communicates with the Laravel API under `/api/pages`.

## Installing on Shared Hosting

Follow these steps to deploy the CMS on any typical PHP hosting service:

1. **Prepare the environment**
   - Make sure your hosting plan supports **PHP 8.0+** and **MySQL**.
   - Create a new MySQL database and user via your hosting control panel.

2. **Upload the files**
   - Download this repository or extract an archive of it.
   - Upload all files to the document root of your website (for example `public_html/`).

3. **Configure the CMS**
   - Edit `backend/config.php` and fill in the database credentials you created above.
   - If you prefer to use the web installer instead, remove `backend/config.php` before uploading and navigate to `install.php` after the upload. The installer will ask for the database settings, create the necessary tables and let you set up an administrator account.

4. **Create the database tables**
   - If you used the installer, this step is handled automatically.
   - Otherwise execute the SQL snippet from the *Database* section on your new database to create the `pages` and `users` tables.

5. **Finalize**
   - After installation, remove `install.php` from the server for security.
   - Visit `/admin/` in your browser to log in and start managing pages.

The CMS should now be fully functional on your hosting account.
