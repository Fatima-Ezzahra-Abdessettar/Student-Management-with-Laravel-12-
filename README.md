# Gestion Etudiants Laravel

A comprehensive Student Management System built with **Laravel 12**, **Tailwind CSS**, and **Alpine.js**. This application provides a secure and efficient platform for administrators to manage student records and for students to access their personal profiles.

## 🚀 Features

*   **Role-Based Access Control (RBAC)**: Distinct dashboards and permissions for **Administrators** and **Students**.
*   **Google Authentication**: Secure login integration using **Firebase**.
*   **Student Management (CRUD)**:
    *   Add, edit, and delete student records.
    *   Upload and manage student photos.
    *   Search and filter student lists.
    *   **Safe Deletion**: Modal-based confirmation to prevent accidental data loss.
*   **Responsive UI**: Modern, mobile-friendly interface built with Tailwind CSS.
*   **Student Portal**: Dedicated area for students to view and update their profile information.

## 🛠️ Technology Stack

*   **Backend**: [Laravel 12](https://laravel.com)
*   **Frontend**: [Blade Templates](https://laravel.com/docs/blade), [Tailwind CSS](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
*   **Database**: MySQL / SQLite
*   **Authentication**: Firebase (Google OAuth)
*   **Build Tool**: Vite

## ⚙️ Installation

Follow these steps to set up the project locally:

1.  **Clone the repository**
    ```bash
    git clone https://github.com/yourusername/gestion-etudiants-laravel.git
    cd gestion-etudiants-laravel
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Install Node.js dependencies**
    ```bash
    npm install
    ```

4.  **Environment Setup**
    Copy the example environment file and configure your database and Firebase credentials:
    ```bash
    cp .env.example .env
    ```
    Open `.env` and set your database connection (`DB_DATABASE`, etc.) and add your Firebase credentials file path:
    ```env
    FIREBASE_CREDENTIALS=/path/to/firebase_credentials.json
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Run Migrations & Seeders**
    Create the database tables and (optionally) seed initial data:
    ```bash
    php artisan migrate
    # Optional: Seed admin user
    php artisan db:seed --class=AdminSeeder
    ```

7.  **Build Assets**
    ```bash
    npm run build
    ```

8.  **Start the Server**
    ```bash
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`.

## 📖 Usage

### Admin Access
*   Log in with the configured admin credentials (or Google account if authorized).
*   Navigate to the Dashboard to view stats.
*   Use the "Manage Students" section to add or modify student records.

### Student Access
*   Log in using your student credentials.
*   Access the Profile section to view personal details.


