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
