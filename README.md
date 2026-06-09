<div align="center">
  <br />
  <h1>🎓 Student Management API</h1>
  <p>
    <strong>A Production-Grade RESTful API with Secure JWT Authentication</strong>
  </p>
  <p>
    <img src="https://img.shields.io/badge/Laravel_9-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
    <img src="https://img.shields.io/badge/PHP_8-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8" />
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    <img src="https://img.shields.io/badge/JWT_Auth-000000?style=for-the-badge&logo=jsonwebtokens&logoColor=white" alt="JWT" />
  </p>
  <p>
    <a href="https://berlinsugi.vercel.app/docs-student-api.html" target="_blank">View API Documentation</a>
  </p>
</div>

---

## 📌 Overview

**Student Management API** is a robust, server-side REST application designed to securely manage academic records. Built on the **Laravel 9** framework, it adheres to modern API design principles, providing clean JSON responses, strict input validation, and proper HTTP status codes.

Security is the primary focus of this architecture. It implements stateless authentication using **JSON Web Tokens (JWT)** and enforces strict **Role-Based Access Control (RBAC)** to ensure that sensitive data mutations are strictly protected.

## ✨ Key Features

- **Stateless JWT Authentication**: Implemented via `php-open-source-saver/jwt-auth` for secure, sessionless API access.
- **Role-Based Access Control (RBAC)**: Distinct authorization logic separating standard users/students from administrative endpoints.
- **Soft Deletion Mechanism**: Utilizes Laravel's Eloquent SoftDeletes to preserve data integrity and historical records, ensuring data is never permanently wiped by accident.
- **Form Request Validation**: Centralized and strict validation layers preventing malformed or malicious data injections.
- **Global Exception Handling**: Custom API error responses providing clear, standardized JSON error messages instead of raw HTML stack traces.

---

## 🛠️ Tech Stack & Architecture

- **Framework**: Laravel 9.x
- **Language**: PHP 8.0+
- **Database**: MySQL (Eloquent ORM)
- **Security**: JWT (Access Tokens), Bcrypt (Password Hashing)
- **Testing**: Postman API Client

---

## 🚦 Core API Endpoints

Below is a high-level overview of the available endpoints. All protected routes require a valid `Bearer Token` in the `Authorization` header.

### 🔐 Authentication
| Method | Endpoint | Description | Auth Required |
| :--- | :--- | :--- | :---: |
| `POST` | `/api/auth/register` | Register a new user | ❌ |
| `POST` | `/api/auth/login` | Authenticate and return JWT | ❌ |
| `POST` | `/api/auth/logout` | Invalidate current JWT | ✅ |
| `GET`  | `/api/auth/me` | Get authenticated user profile | ✅ |

### 👨‍🎓 Student Management
| Method | Endpoint | Description | Auth Required |
| :--- | :--- | :--- | :---: |
| `GET` | `/api/students` | Retrieve all active students | ✅ |
| `GET` | `/api/students/{id}` | Retrieve specific student | ✅ |
| `POST` | `/api/students` | Create a new student record | ✅ *(Admin)* |
| `PUT` | `/api/students/{id}` | Update existing student | ✅ *(Admin)* |
| `DELETE`| `/api/students/{id}` | Soft-delete a student | ✅ *(Admin)* |

---

## 🚀 Getting Started

### Prerequisites
- **PHP 8.0+**
- **Composer**
- **MySQL**

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/B3rlinSugi/student-management-api.git
   cd student-management-api
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   ```
   *Update your `.env` file with your MySQL credentials.*

4. **Generate Application & JWT Keys:**
   ```bash
   php artisan key:generate
   php artisan jwt:secret
   ```

5. **Run Database Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Serve the Application:**
   ```bash
   php artisan serve
   ```
   *The API will be accessible at `http://localhost:8000/api`.*

---

## 👨‍💻 Author

**Berlin Sugiyanto**  
Backend Developer & System Architect  
- Portfolio: [berlinsugi.vercel.app](https://berlinsugi.vercel.app/)
- LinkedIn: [linkedin.com/in/berlinsugi](https://linkedin.com/in/berlinsugi)

---

<div align="center">
  <i>"Secure APIs are the invisible backbone of modern software."</i>
</div>
