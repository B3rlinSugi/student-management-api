# 🎓 Student Management API

> A production-ready RESTful API built with **Laravel 11** — featuring JWT Authentication, Role-Based Access Control (RBAC), full CRUD with Soft Delete, and a unified query layer handling search, filter, sort, and pagination in a single performant database query.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)
![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=flat-square&logo=jsonwebtokens&logoColor=cyan)
![RBAC](https://img.shields.io/badge/RBAC-Access_Control-blue?style=flat-square)

---

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Database Schema](#-database-schema)
- [API Endpoints](#-api-endpoints)
- [Installation](#-installation)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [Author](#-author)

---

## ✨ Features

- 🔐 **JWT Authentication** — Stateless auth with HS256 signing, token blacklisting on logout, and token refresh. Works across any client (mobile, SPA) without server-side sessions
- 👥 **Role-Based Access Control (RBAC)** — Dual-role system enforced at middleware layer, not scattered across controllers
  - `Admin` — Full access: manage students, majors, trashed records
  - `User` — Read-only access to student data
- 🎓 **Student Management** — Full CRUD with Soft Delete lifecycle: delete → trash → restore → force delete
- 🏫 **Major Management** — Full CRUD for academic majors, linked to students via foreign key
- 🔍 **Unified Query Layer** — Single endpoint handles multi-column search, filter by status/major/gender, dynamic sorting, and configurable pagination (up to 50/page) — all resolved in one database query
- 🗑️ **Soft Delete** — Trashed student endpoints accessible only to Admin role; zero data loss during normal operations
- 📦 **API Resources** — Clean JSON responses via Resource classes that decouple DB schema from API response shape
- ✅ **Form Request Validation** — All input validated via dedicated Request classes, keeping controllers single-responsibility

---

## 🛠️ Tech Stack

| Technology | Version | Description |
|---|---|---|
| Laravel | 11.x | PHP Framework |
| PHP | 8.2+ | Server-side scripting |
| MySQL | 8.0 | Relational Database |
| tymon/jwt-auth | 2.x | JWT token-based authentication |
| Postman | — | API testing & documentation |

---

## 🗄️ Database Schema

### Users Table
```
id, name, email, password, role (admin|user), created_at, updated_at
```

### Students Table
```
id, nim, name, email, phone, address, birth_date, gender,
major_id (FK), year, status, created_at, updated_at, deleted_at
```

### Majors Table
```
id, name, code, created_at, updated_at
```

**Relationships:**
- `Major` → hasMany `Students`
- `Student` → belongsTo `Major`
- Soft Deletes enabled on `Students`

---

## 🌐 API Endpoints

### Authentication

| Method | Endpoint | Description | Auth |
|---|---|---|---|
| POST | `/api/auth/register` | Register new user | No |
| POST | `/api/auth/login` | Login & get JWT token | No |
| POST | `/api/auth/logout` | Invalidate token (blacklist) | Yes |
| POST | `/api/auth/refresh` | Refresh JWT token | Yes |
| GET | `/api/auth/me` | Get current authenticated user | Yes |

### Students

| Method | Endpoint | Description | Role |
|---|---|---|---|
| GET | `/api/students` | List students (search, filter, sort, paginate) | Admin / User |
| GET | `/api/students/{id}` | Get student details | Admin / User |
| POST | `/api/students` | Create new student | Admin |
| PUT | `/api/students/{id}` | Update student | Admin |
| DELETE | `/api/students/{id}` | Soft delete student | Admin |
| GET | `/api/students/trashed` | List trashed students | Admin |
| POST | `/api/students/{id}/restore` | Restore trashed student | Admin |
| DELETE | `/api/students/{id}/force` | Permanently delete student | Admin |

### Majors

| Method | Endpoint | Description | Role |
|---|---|---|---|
| GET | `/api/majors` | List all majors | Admin / User |
| GET | `/api/majors/{id}` | Get major details | Admin / User |
| POST | `/api/majors` | Create new major | Admin |
| PUT | `/api/majors/{id}` | Update major | Admin |
| DELETE | `/api/majors/{id}` | Delete major | Admin |

### Query Parameters (GET /api/students)

| Parameter | Type | Example | Description |
|---|---|---|---|
| `search` | string | `?search=john` | Search by name, NIM, or email |
| `major_id` | integer | `?major_id=1` | Filter by major |
| `gender` | string | `?gender=male` | Filter by gender |
| `status` | string | `?status=active` | Filter by status |
| `sort_by` | string | `?sort_by=name` | Sort column |
| `sort_order` | string | `?sort_order=asc` | Sort direction (asc/desc) |
| `per_page` | integer | `?per_page=20` | Items per page (max: 50) |

---

## 🚀 Installation

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/B3rlinSugi/student-management-api.git
cd student-management-api
```

**2. Install dependencies**
```bash
composer install
```

**3. Configure environment**
```bash
cp .env.example .env
```

**4. Update `.env` file**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=  # will be generated in step 6
```

**5. Generate application key**
```bash
php artisan key:generate
```

**6. Generate JWT secret**
```bash
php artisan jwt:secret
```

**7. Run migrations**
```bash
php artisan migrate
```

**8. Seed database (optional)**
```bash
php artisan db:seed
```

**9. Start the server**
```bash
php artisan serve
```

The API will be available at `http://localhost:8000/api`

---

## 📖 Usage

### Authentication Flow

**Register**
```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "Berlin Sugiyanto",
  "email": "berlin@example.com",
  "password": "password",
  "role": "admin"
}
```

**Login**
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "berlin@example.com",
  "password": "password"
}
```

**Response**
```json
{
  "access_token": "eyJ0eXAiOiJKV1Qi...",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "name": "Berlin Sugiyanto",
    "email": "berlin@example.com",
    "role": "admin"
  }
}
```

**Using the token**
```http
Authorization: Bearer <your-token>
```

### Example: List Students with Filters
```bash
curl -X GET "http://localhost:8000/api/students?search=john&major_id=1&sort_by=name&sort_order=asc&per_page=10" \
  -H "Authorization: Bearer <your-token>"
```

### Example: Soft Delete & Restore
```bash
# Soft delete
curl -X DELETE http://localhost:8000/api/students/1 \
  -H "Authorization: Bearer <your-token>"

# Restore from trash
curl -X POST http://localhost:8000/api/students/1/restore \
  -H "Authorization: Bearer <your-token>"
```

---

## 📁 Project Structure

```
student-management-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/
│   │   │   ├── AuthController.php
│   │   │   ├── StudentController.php
│   │   │   └── MajorController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/
│   │       ├── StoreStudentRequest.php
│   │       └── UpdateStudentRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Student.php
│   │   └── Major.php
│   └── Resources/
│       ├── StudentResource.php
│       └── MajorResource.php
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
├── .env.example
├── composer.json
└── README.md
```

---

## 🔧 Useful Artisan Commands

```bash
# Generate JWT secret
php artisan jwt:secret

# Run migrations fresh with seeders
php artisan migrate:fresh --seed

# List all registered routes
php artisan route:list

# Clear all cache
php artisan config:clear && php artisan cache:clear
```

---

## 👤 Author

**Berlin Sugiyanto**

- 📧 Email: [berlinsugiyanto23@gmail.com](mailto:berlinsugiyanto23@gmail.com)
- 💼 LinkedIn: [berlinsugi](https://linkedin.com/in/berlinsugi)
- 🐙 GitHub: [@B3rlinSugi](https://github.com/B3rlinSugi)
- 🌐 Portfolio: [berlinsugi.vercel.app](https://berlinsugi.vercel.app)

---

<p align="center">Made with ❤️ using Laravel 11</p>
