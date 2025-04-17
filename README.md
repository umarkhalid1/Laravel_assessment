<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

## 🚀 Laravel Technical Assessment

A Laravel-based API application that handles sales, pricing calculations, and inventory management. Built using Laravel Sanctum for authentication.

---

## 🛠️ Installation

Follow the steps below to get the project running locally:

### 1. Clone the repository

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
composer install
cp .env.example .env
php artisan key:generate
APP_NAME=Laravel
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
php artisan migrate --seed
