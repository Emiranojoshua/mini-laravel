# Mini Laravel

![PHP](https://img.shields.io/badge/PHP-8.4-blue) ![License](https://img.shields.io/badge/License-MIT-green) ![Composer](https://img.shields.io/badge/Composer-Required-lightgrey)

Mini Laravel is a lightweight PHP framework for building web applications quickly and efficiently. It leverages modern PHP features and uses Composer for dependency management.

---

## Requirements

* PHP >= 8.4
* Composer
* MySQL
* Apache or any compatible web server
* PHP built-in development server (optional)

---

## Installation

1. **Clone or download** the Mini Laravel repository:

```bash
git clone <your-repo-url>
cd mini-laravel
```

2. **Install Composer dependencies**:

```bash
composer install
```

3. **Set up your web server**:

* **PHP built-in server**:

```bash
php -S localhost:8000 -t public
```

* **Apache**: point the document root to the `public` folder.

---

## Database Configuration

Mini Laravel uses the **`Config\Config.php`** file to manage database connections.

> ⚠️ The `.env` file feature is not yet implemented, so database settings are configured directly in the `Config` class.

### Steps to Set Up the Database

1. **Create the database in MySQL**:

```sql
CREATE DATABASE emirano;
```

2. **Create the `users` table**:

```sql
CREATE TABLE `emirano`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(500) NOT NULL,
  `password` VARCHAR(500) NOT NULL,
  `created_at` VARCHAR(500) NOT NULL,
  `updated_at` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
```

3. **Adjust database credentials in `Config\Config.php`**:

* Update `port`, `username`, and `password` to match your MySQL setup.

---

## Running the Framework

Once installed and configured:

```bash
php -S localhost:8000 -t public
```

Visit [http://localhost:8000](http://localhost:8000) in your browser to see your application.

---

## Notes

* Composer is required for dependency management.
* PHP 8.4 or higher is required.
* `.env` support and folder structure documentation will be added in future updates.
* Database setup uses the `Config\Config.php` file and the provided `users` table schema.
