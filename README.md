# Mini Laravel

Mini Laravel is a lightweight PHP framework for building web applications quickly and efficiently. It uses modern PHP features, Composer-based autoloading, and includes .env environment configuration through vlucas/phpdotenv.

------------------------------------------------------------
Requirements
------------------------------------------------------------

- PHP >= 8.4
- Composer
- MySQL
- Apache or any compatible web server
- PHP built-in development server (optional)

------------------------------------------------------------
Installation
------------------------------------------------------------

1. Clone or download the repository:

git clone https://github.com/Emiranojoshua/mini-laravel.git
cd mini-laravel

2. Install Composer dependencies:

composer install

------------------------------------------------------------
Environment Setup (.env)
------------------------------------------------------------

Mini Laravel uses vlucas/phpdotenv for environment configuration.

1. Install Dotenv if not already installed:

composer require vlucas/phpdotenv

2. Create your .env file:

cp .env.example .env

3. Update your .env file with your application and database settings:

APP_NAME=MiniLaravel
APP_ENV=development
APP_URL=http://localhost:8000

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=emirano
DB_USERNAME=root
DB_PASSWORD=

4. The framework loads environment variables using:

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(base_path());
$dotenv->load();

Values can be accessed via:

$_ENV['DB_HOST']
getenv('DB_HOST')

------------------------------------------------------------
Database Configuration
------------------------------------------------------------

The framework now reads database credentials from your .env file.

Steps:

1. Create the database:

CREATE DATABASE emirano;

2. Create the users table:

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(500) NOT NULL,
  `password` VARCHAR(500) NOT NULL,
  `created_at` VARCHAR(500) NOT NULL,
  `updated_at` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

3. Update your .env file with the correct credentials.

------------------------------------------------------------
Running the Framework
------------------------------------------------------------

Start the development server:

php -S localhost:8000 -t public

Open in your browser:

http://localhost:8000

------------------------------------------------------------
Notes
------------------------------------------------------------

- .env support is fully implemented through vlucas/phpdotenv.
- Ensure that your .env file is not committed to Git.
- PHP 8.4 or higher is required.
- Composer is required for autoloading and environment variable loading.
- Additional documentation for folder structure will be added in future updates.
