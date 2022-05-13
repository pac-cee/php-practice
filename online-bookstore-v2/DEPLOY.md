# Deployment Guide: OnlineBookstore Web Application

---

## 1. Prerequisites
- Web server (Apache/Nginx) with PHP 7.4+
- MySQL 5.7+ database
- Composer (optional, for dependencies)
- Git (for version control)

## 2. Environment Variables & Configuration
- Copy `config.sample.php` to `config.php` and set DB credentials, secret keys, etc.
- Set up environment variables for sensitive data (DB credentials, API keys).

## 3. Database Setup
- Import `setup.sql` into your MySQL database:
  ```sh
  mysql -u <user> -p <database> < setup.sql
  ```
