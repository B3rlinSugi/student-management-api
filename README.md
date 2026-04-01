# 🎓 Student Management API

A RESTful API for managing student data, built with Laravel 9 and JWT Authentication.

![Laravel](https://img.shields.io/badge/Laravel-9.x-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql)
![JWT](https://img.shields.io/badge/JWT-Auth-FF6F20?style=flat)

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Database Schema](#database-schema)
- [API Endpoints](#api-endpoints)
- [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Screenshots](#screenshots)
- [License](#license)

---

## ✨ Features

- 🔐 **JWT Authentication** - Secure API access with JSON Web Tokens
- 👥 **Role-Based Access Control (RBAC)**
  - `Admin` - Full access to all resources
  - `Teacher` - Manage grades, view students
  - `Student` - View own data and grades
- 📚 **Student Management** - CRUD operations with Soft Deletes
- 📖 **Grade Management** - Record and track student grades
- 🔒 **Security** - bcrypt password hashing, API rate limiting
- 📄 **API Documentation** - JSON structured responses

---

## 🛠 Tech Stack

| Technology | Description |
|------------|-------------|
| **Laravel 9** | PHP Framework |
| **PHP 8.0+** | Server-side scripting |
| **MySQL 8.0** | Relational Database |
| **JWT Auth (tymon/jwt-auth)** | Token-based authentication |
| **Laravel Sanctum** | SPA authentication |
| **Postman** | API testing |

---

## 🗄 Database Schema

### Users Table
```sql
id, name, email, password, role, created_at, updated_at
```

### Students Table
```sql
id, nim, name, email, phone, address, birth_date, gender, 
major, year, created_at, updated_at, deleted_at
```

### Grades Table
```sql
id, student_id, subject, score, semester, created_at, updated_at
```

### Relationships
- User → hasOne Student
- Student → hasMany Grades
- Soft Deletes enabled on Students

---

## 🌐 API Endpoints

### Authentication
| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| POST | `/api/auth/register` | Register new user | No |
| POST | `/api/auth/login` | Login & get JWT | No |
| POST | `/api/auth/logout` | Invalidate token | Yes |
| POST | `/api/auth/refresh` | Refresh JWT token | Yes |
| GET | `/api/auth/me` | Get current user | Yes |

### Students
| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/students` | List all students | Admin/Teacher |
| GET | `/api/students/{id}` | Get student details | Admin/Teacher |
| POST | `/api/students` | Create student | Admin |
| PUT | `/api/students/{id}` | Update student | Admin |
| DELETE | `/api/students/{id}` | Soft delete student | Admin |

### Grades
| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| GET | `/api/grades` | List all grades | Admin/Teacher |
| GET | `/api/students/{id}/grades` | Get student grades | All |
| POST | `/api/grades` | Create grade | Admin/Teacher |
| PUT | `/api/grades/{id}` | Update grade | Admin/Teacher |
| DELETE | `/api/grades/{id}` | Delete grade | Admin |

### Example Request

**Login**
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

**Response**
```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com",
    "role": "admin"
  }
}
```

---

## 🚀 Installation

### Prerequisites
- PHP 8.0+
- Composer
- MySQL 8.0+
- Node.js (optional for frontend)

### Steps

1. **Clone the repository**
```bash
git clone https://github.com/B3rlinSugi/student-management-api.git
cd student-management-api
```

2. **Install dependencies**
```bash
composer install
```

3. **Configure environment**
```bash
cp .env.example .env
```

4. **Update .env file**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=your-jwt-secret-key
```

5. **Generate application key**
```bash
php artisan key:generate
```

6. **Generate JWT secret**
```bash
php artisan jwt:secret
```

7. **Run migrations**
```bash
php artisan migrate
```

8. **Seed database (optional)**
```bash
php artisan db:seed
```

9. **Start the server**
```bash
php artisan serve
```

The API will be available at `http://localhost:8000/api`

---

## 📖 Usage

### Using Postman

1. Import the Postman collection (create your own or use the endpoints above)
2. First, register a user at `/api/auth/register`
3. Login at `/api/auth/login` to get the JWT token
4. Use the token in the Authorization header:
   ```
   Authorization: Bearer <your-token>
   ```

### Testing with cURL

```bash
# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Get Students (with token)
curl -X GET http://localhost:8000/api/students \
  -H "Authorization: Bearer <your-token>"
```

---

## 📁 Project Structure

```
student-management-api/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           ├── AuthController.php
│   │           └── StudentController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Student.php
│   │   └── Grade.php
│   └── Providers/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
├── tests/
├── .env
├── artisan
├── composer.json
└── README.md
```

---

## 🔧 Available Artisan Commands

```bash
# Generate JWT secret
php artisan jwt:secret

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear cache
php artisan config:clear
php artisan cache:clear

# List routes
php artisan route:list
```

---

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

---

## 👨‍💻 Author

**Berlin Sugiyanto**
- Email: berlinsugiyanto23@gmail.com
- GitHub: [@B3rlinSugi](https://github.com/B3rlinSugi)
- LinkedIn: [berlinsugi](https://linkedin.com/in/berlinsugi)

---

<p align="center">
  Made with ❤️ using Laravel
</p>
