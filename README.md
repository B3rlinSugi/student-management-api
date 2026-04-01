# 🎓 Student Management API

> A production-ready RESTful API built with **Laravel 11** — featuring JWT Authentication, Role-Based Access Control, full CRUD with Soft Delete, advanced Search, Filter & Pagination.

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=flat-square&logo=jsonwebtokens)](https://jwt.io)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack & Rationale](#-tech-stack--rationale)
- [Database Schema](#-database-schema)
- [Project Structure](#-project-structure)
- [Installation](#-installation)
- [API Endpoints](#-api-endpoints)
- [Query Parameters](#-query-parameters-get-apistudents)
- [Response Format](#-response-format)
- [Authentication Flow](#-authentication-flow)
- [Security Implementation](#-security-implementation)
- [Author](#-author)

---

## 🔍 Overview

This project was built to demonstrate enterprise-grade backend patterns in a clean, documented codebase — going beyond simple CRUD by implementing stateless JWT authentication, role-based access control, and a layered query system with search, filter, sort, and pagination in a single performant query.

**Key design decisions:**
- Stateless auth via JWT to eliminate server-side session storage overhead
- Admin/User RBAC enforced at the middleware layer, not controller logic
- Soft Delete with trash/restore/force-delete lifecycle to prevent accidental data loss
- API Resources as transformers to decouple database structure from API response shape
- Form Request classes for validation, keeping controllers thin and single-responsibility

---

## 📌 Features

| Feature | Detail |
| --- | --- |
| **JWT Authentication** | Login, Register, Refresh Token, Logout via `php-open-source-saver/jwt-auth` |
| **Role-Based Access Control** | `admin` full access · `user` read-only, enforced via middleware |
| **Full CRUD** | Students & Majors with Laravel Form Request validation |
| **Soft Delete** | Delete → Trash → Restore or Force Delete lifecycle |
| **Search** | Multi-column keyword search across name, NIM, and email |
| **Filter** | Filter by status, major, and gender |
| **Pagination** | Configurable `per_page` (max 50) with meta & links |
| **Sorting** | Dynamic sort by any column, asc/desc |
| **API Resources** | Consistent JSON response shape via Laravel Resource transformers |

---

## 🛠️ Tech Stack & Rationale

| Layer | Technology | Why |
| --- | --- | --- |
| Framework | Laravel 11 | Mature ecosystem, built-in ORM, Form Requests, and Resource transformers — reduces boilerplate while enforcing good structure |
| Language | PHP 8.2 | Strong typing features (enums, readonly, fibers) for safer, more predictable code |
| Database | MySQL 8 (InnoDB) | ACID-compliant transactions, foreign key constraints, and proven performance for relational data — better fit than NoSQL for structured student/major relationships |
| Auth | JWT (php-open-source-saver/jwt-auth) | Stateless — no session storage needed on the server. Chosen over Laravel Sanctum because this API is designed to be consumed by any client (mobile, SPA, etc.) without cookie-based session coupling |
| Validation | Laravel Form Requests | Separates validation logic from controller, keeping each class single-responsibility |
| Transformer | Laravel API Resources | Decouples internal database structure from public API response — allows schema changes without breaking API consumers |
| Soft Delete | Laravel SoftDeletes trait | Prevents accidental permanent data loss, enables audit trails and data recovery |

---

## 🗄️ Database Schema

```
┌──────────────────┐         ┌───────────────────────┐         ┌──────────────────┐
│      users       │         │       students        │         │     majors       │
├──────────────────┤         ├───────────────────────┤         ├──────────────────┤
│ id (PK)          │         │ id (PK)               │         │ id (PK)          │
│ name             │         │ nim         UNIQUE     │         │ code    UNIQUE   │
│ email   UNIQUE   │         │ name                  │         │ name             │
│ password (bcrypt)│         │ email       UNIQUE     │    ┌────│ faculty          │
│ role    ENUM     │         │ phone                 │    │    │ description      │
│ created_at       │         │ gender      ENUM       │    │    │ created_at       │
│ updated_at       │         │ birth_date             │    │    │ updated_at       │
└──────────────────┘         │ address               │    │    └──────────────────┘
                             │ major_id   FK ─────────────┘
                             │ status     ENUM        │
                             │ semester               │
                             │ gpa        DECIMAL     │
                             │ created_at             │
                             │ updated_at             │
                             │ deleted_at  ← SoftDelete│
                             └───────────────────────┘
```

**Relationships:**
- `students.major_id` → `majors.id` (Many-to-One, with FK constraint)
- `students.deleted_at` — NULL = active, NOT NULL = soft deleted (in trash)

> 💡 **ERD visual:** See [`docs/erd.png`](docs/erd.png) for a full entity-relationship diagram.

---

## 📁 Project Structure

```
student-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php        # JWT login, register, refresh, logout
│   │   │   ├── StudentController.php     # CRUD + soft delete + trash management
│   │   │   └── MajorController.php       # CRUD majors
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php        # RBAC enforcement (admin/user)
│   │   ├── Requests/
│   │   │   ├── StoreStudentRequest.php   # Validation rules for create
│   │   │   └── UpdateStudentRequest.php  # Validation rules for update
│   │   └── Resources/
│   │       ├── StudentResource.php       # API response transformer
│   │       └── MajorResource.php
│   └── Models/
│       ├── User.php
│       ├── Student.php                   # SoftDeletes trait
│       └── Major.php
├── database/
│   ├── migrations/                       # Versioned schema changes
│   └── seeders/                          # Default admin + user + sample data
├── routes/
│   └── api.php                           # All API route definitions
├── .env.example                          # Environment variable template
└── README.md
```

---

## 🚀 Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL 8.0+

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/B3rlinSugi/student-management-api.git
cd student-management-api/student-api

# 2. Install dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=your_password

# 5. Generate JWT secret
php artisan jwt:secret

# 6. Run migrations & seed
php artisan migrate --seed

# 7. Start development server
php artisan serve
# → API running at http://localhost:8000
```

### Default Credentials (from seeder)

| Role | Email | Password |
| --- | --- | --- |
| Admin | admin@student-api.com | admin123 |
| User | user@student-api.com | user123 |

---

## 📡 API Endpoints

Base URL: `http://localhost:8000/api`

All protected routes require header: `Authorization: Bearer <token>`

### 🔐 Authentication

| Method | Endpoint | Auth | Role | Description |
| --- | --- | --- | --- | --- |
| POST | `/auth/register` | ✗ | — | Register new user |
| POST | `/auth/login` | ✗ | — | Login, returns JWT token |
| GET | `/auth/me` | ✓ | All | Get authenticated user info |
| POST | `/auth/refresh` | ✓ | All | Refresh JWT token |
| POST | `/auth/logout` | ✓ | All | Logout (invalidate token) |

### 👨‍🎓 Students

| Method | Endpoint | Auth | Role | Description |
| --- | --- | --- | --- | --- |
| GET | `/students` | ✓ | All | List with search, filter, sort, paginate |
| POST | `/students` | ✓ | Admin | Create new student |
| GET | `/students/{id}` | ✓ | All | Get student detail |
| PUT | `/students/{id}` | ✓ | Admin | Update student data |
| DELETE | `/students/{id}` | ✓ | Admin | Soft delete (move to trash) |
| GET | `/students/trashed/list` | ✓ | Admin | List all trashed students |
| POST | `/students/{id}/restore` | ✓ | Admin | Restore student from trash |
| DELETE | `/students/{id}/force` | ✓ | Admin | Permanently delete student |

### 🏫 Majors

| Method | Endpoint | Auth | Role | Description |
| --- | --- | --- | --- | --- |
| GET | `/majors` | ✓ | All | List all majors |
| POST | `/majors` | ✓ | Admin | Create new major |
| GET | `/majors/{id}` | ✓ | All | Get major detail |
| PUT | `/majors/{id}` | ✓ | Admin | Update major |
| DELETE | `/majors/{id}` | ✓ | Admin | Delete major |

---

## 🔍 Query Parameters (`GET /api/students`)

| Parameter | Type | Example | Description |
| --- | --- | --- | --- |
| `search` | string | `?search=andi` | Keyword search across name, NIM, email |
| `status` | string | `?status=active` | Filter: `active` / `inactive` / `graduated` |
| `major_id` | integer | `?major_id=1` | Filter by major ID |
| `gender` | string | `?gender=female` | Filter: `male` / `female` |
| `per_page` | integer | `?per_page=20` | Items per page (default: 10, max: 50) |
| `sort_by` | string | `?sort_by=gpa` | Column to sort by |
| `sort_dir` | string | `?sort_dir=desc` | Direction: `asc` / `desc` |
| `page` | integer | `?page=2` | Page number |

**Combined example:**
```
GET /api/students?search=andi&status=active&major_id=1&sort_by=gpa&sort_dir=desc&per_page=5&page=1
```

---

## 📦 Response Format

All responses follow a consistent structure:

### ✅ Success — Single Resource

```json
{
  "success": true,
  "data": {
    "id": 1,
    "nim": "10121001",
    "name": "Andi Pratama",
    "email": "andi@student.ac.id",
    "phone": "081234567890",
    "gender": "male",
    "birth_date": "2002-05-14",
    "address": "Jakarta Selatan",
    "status": "active",
    "semester": 6,
    "gpa": "3.75",
    "major": {
      "id": 1,
      "code": "TI",
      "name": "Teknik Informatika",
      "faculty": "Fakultas Teknologi Industri"
    },
    "created_at": "2026-01-15T08:00:00.000000Z",
    "updated_at": "2026-01-15T08:00:00.000000Z"
  }
}
```

### ✅ Success — Paginated List

```json
{
  "success": true,
  "data": [ ... ],
  "meta": {
    "total": 50,
    "per_page": 10,
    "current_page": 1,
    "last_page": 5,
    "from": 1,
    "to": 10
  },
  "links": {
    "first": "http://localhost:8000/api/students?page=1",
    "last": "http://localhost:8000/api/students?page=5",
    "prev": null,
    "next": "http://localhost:8000/api/students?page=2"
  }
}
```

### ❌ Error Response

```json
{
  "success": false,
  "message": "Invalid credentials."
}
```

### ❌ Validation Error (422)

```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "nim": ["The NIM field is required."],
    "email": ["The email has already been taken."]
  }
}
```

---

## 🔐 Authentication Flow

```
Client                                    Server
  │                                          │
  ├─── POST /auth/register ───────────────► │
  │    { name, email, password, role }       │  Hash password (bcrypt)
  │                                          │  Store user to DB
  │ ◄── 201 { success, data: user } ─────── │
  │                                          │
  ├─── POST /auth/login ──────────────────► │
  │    { email, password }                   │  Validate credentials
  │                                          │  Sign JWT (HS256, TTL: 60min)
  │ ◄── 200 { token, token_type, ttl } ──── │
  │                                          │
  ├─── GET /students ─────────────────────► │
  │    Authorization: Bearer <token>         │  Verify JWT signature
  │                                          │  Decode claims (user_id, role)
  │                                          │  RoleMiddleware: check role
  │ ◄── 200 { success, data, meta } ─────── │
  │                                          │
  ├─── POST /auth/refresh ────────────────► │
  │    Authorization: Bearer <old_token>     │  Invalidate old token
  │                                          │  Issue new token
  │ ◄── 200 { token } ────────────────────  │
  │                                          │
  ├─── POST /auth/logout ─────────────────► │
  │    Authorization: Bearer <token>         │  Add token to blacklist
  │ ◄── 200 { message: "logged out" } ───── │
```

---

## 🔒 Security Implementation

| Concern | Implementation |
| --- | --- |
| **Password Storage** | bcrypt hashing via Laravel's `Hash::make()` — never stored as plaintext |
| **Token Auth** | JWT (HS256) — stateless, no server-side session storage |
| **Token Invalidation** | JWT blacklist on logout — invalidated tokens cannot be reused |
| **Access Control** | Role middleware on all write endpoints — `user` role gets 403 on admin routes |
| **SQL Injection** | Eloquent ORM with parameterized queries throughout — no raw SQL with user input |
| **Input Validation** | Laravel Form Requests validate and sanitize all input before hitting the controller |
| **Sensitive Config** | All secrets in `.env` — `.env.example` provided, `.env` excluded from git |

---

## 👤 Author

**Berlin Sugiyanto Hutajulu**

[![Portfolio](https://img.shields.io/badge/Portfolio-berlinsugi.vercel.app-06B6D4?style=flat-square)](https://berlinsugi.vercel.app)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-berlinsugi-0077B5?style=flat-square&logo=linkedin&logoColor=white)](https://linkedin.com/in/berlinsugi)
[![GitHub](https://img.shields.io/badge/GitHub-B3rlinSugi-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/B3rlinSugi)
[![Email](https://img.shields.io/badge/Email-berlinsugiyanto23@gmail.com-D14836?style=flat-square&logo=gmail&logoColor=white)](mailto:berlinsugiyanto23@gmail.com)

---

> *"Clean APIs, solid databases, auth flows that don't break at 3 AM."*
