# Quizy API 🚀

## Overview

Quizy API is a robust Laravel-based backend service for managing quizzes, user authentication, and quiz interactions. Built with modern PHP practices, it provides a scalable and secure platform for quiz management.

## Prerequisites

- PHP 8.2+
- Composer
- SQLite 3 (default) or alternative database

## Installation

1. Clone the repository
```bash
git clone git@github.com:davitchanturia/quizy-api.git
```

```bash
cd quizy-api
```

2. Install dependencies
```bash
composer install
```

3. Configure environment
```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

4. provide frontend domains in .env
```bash
SANCTUM_STATEFUL_DOMAINS=
SESSION_DOMAIN=
```

5. migrate database
```bash
php artisan migrate
```

5. you can use seeder to populate database
```bash
php artisan db:seed
```

6. change the FILESYSTEM_DRIVER to public in your .env file
```bash
FILESYSTEM_DRIVER=local
```

7. link storage
```bash
  php artisan storage:link
```

## Database Configuration

### Default: SQLite
```bash
touch database/database.sqlite
```

### Alternative Databases
Update `.env` with your preferred database:

```env
DB_CONNECTION=mysql  # or pgsql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quizy_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Available Scripts

- `composer dev`: Start development server with queue, logging
- `php artisan migrate`: Run database migrations
- `php artisan test`: Execute test suite
- `php artisan queue:work`: Process background jobs

## Core Technologies

### Backend
- Laravel 11
- Laravel Sanctum (Authentication)

### Development Tools
- Laravel Breeze
