#  Library Management API (Laravel 12)

A RESTful **Library Management System** built with **Laravel 12**, featuring **role-based access control**, **event-driven notifications**, **caching**, and **automated testing**.  
This application allows users to browse, borrow, and return books, while administrators manage the book catalog.

---

##  Overview

This API project is designed to showcase modern Laravel backend development practices, including:

- Authentication & Authorization with Laravel Sanctum  
- Role-based access control (Admin & User)  
- RESTful CRUD APIs for book management  
- Borrow and return functionality  
- Caching for performance optimization  
- Event-driven design for decoupled notifications  
- Automated testing for reliability  

---

##  Requirements

| Tool | Version |
|------|----------|
| PHP | >= 8.2 |
| Laravel | 12.x |
| Composer | >= 2.x |
| Database | MySQL or MariaDB |

---

##  Installation & Setup

Follow these steps to run the project locally:

### 1️ Clone Repository
```bash
git clone https://github.com/keyurdudhagara/librarymanagement-practical.git
cd librarymanagement-practical

#2 Install Dependencies

composer install


#3 Clone Repository
cp .env.example .env

#4 upddate database credencial 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_db
DB_USERNAME=root
DB_PASSWORD=

#5 genraate app key

php artisan key:generate

# 6 R=run migrations and seeders

php artisan migrate --seed


and searve project