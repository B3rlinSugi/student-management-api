# Contributing to Student Management API

Thank you for considering contributing to this API!

## 🧠 Philosophy
This project strictly adheres to Laravel best practices. Controllers should remain thin. Validation must occur in Form Requests.

## 🛠️ Development Setup
1. Fork and clone the repository.
2. Run `composer install`.
3. Configure your `.env` database settings.
4. Run `php artisan migrate:fresh --seed`.
5. Start development server `php artisan serve`.

## 💻 Coding Standards
*   **Validation:** Never use `$request->validate()` in the controller. Always generate a dedicated Form Request class (`php artisan make:request`).
*   **Database:** Always use Eloquent or Query Builder. Never write raw SQL strings to prevent injection.
*   **Responses:** Return standard JSON formats, preferably using Laravel's Resource classes.

## 🔄 Pull Request Process
1. Ensure your code passes all linting and local tests.
2. Submit the PR against the `main` branch.
