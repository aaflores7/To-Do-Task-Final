<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Task Master

A modern, commercial-grade To-Do application built with **Laravel**, **Vue 3**, and **Tailwind CSS**. This project demonstrates a full-stack implementation featuring authentication, state management, and a polished user interface.

## 🚀 Features

-   **User Authentication**: Secure registration and login using Laravel Sanctum.
-   **Task Management**: Create, read, update, and delete tasks.
-   **Categories**: Organize tasks with color-coded categories.
-   **Due Dates**: Set deadlines and track overdue items.
-   **Sorting**: Sort tasks by creation date or due date.
-   **Modern UI**: Glass-morphism accents, smooth transitions, and responsive design.
-   **State Management**: Powered by Pinia for a reactive frontend experience.

## 🛠 Tech Stack

-   **Backend**: Laravel 11 (PHP 8.2+)
-   **Frontend**: Vue 3 (Composition API)
-   **State Management**: Pinia
-   **Styling**: Tailwind CSS v4
-   **Build Tool**: Vite
-   **Database**: MySQL / SQLite

## ⚙️ Installation

Follow these steps to set up the project locally.

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & npm
-   MySQL (or use SQLite)

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/todo-app.git
cd todo-app
```

### 2. Backend Setup

Install PHP dependencies:

```bash
composer install
```

Copy the environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=root
DB_PASSWORD=
```

Run database migrations:

```bash
php artisan migrate
```

### 3. Frontend Setup

Install JavaScript dependencies:

```bash
npm install
```

### 4. Running the Application

You need to run both the backend server and the frontend build process.

**Terminal 1 (Backend):**

```bash
php artisan serve
```

**Terminal 2 (Frontend):**

```bash
npm run dev
```

Access the application at `http://127.0.0.1:8000`.

## 🧪 Testing

Run the backend test suite:

```bash
php artisan test
```

## 📂 Project Structure

-   `app/Models`: Eloquent models (User, Todo, Category).
-   `app/Http/Controllers/Api`: API controllers for handling requests.
-   `resources/js`: Vue 3 application source code.
    -   `components`: Reusable UI components.
    -   `stores`: Pinia stores for state management.
    -   `App.vue`: Main application entry component.
-   `routes/api.php`: API route definitions.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
