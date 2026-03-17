# 🎓 Student Management API

> A production-ready RESTful API built with **Laravel 11** — featuring JWT Authentication, Role-Based Access Control, full CRUD with Soft Delete, Search, Filter & Pagination.

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=flat-square&logo=jsonwebtokens)](https://jwt.io)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## 📌 Features

| Feature | Detail |
|---|---|
| **JWT Authentication** | Login, Register, Refresh, Logout via `php-open-source-saver/jwt-auth` |
| **Role-Based Access Control** | `admin` full access · `user` read-only |
| **Full CRUD** | Students & Majors with validation via Form Requests |
| **Soft Delete** | Delete → Trash → Restore or Force Delete |
| **Search** | Name, NIM, Email — single keyword across multiple columns |
| **Filter** | Status, Major, Gender |
| **Pagination** | Configurable per_page (max 50) with meta & links |
| **Sorting** | Sort by any column, asc/desc |
| **API Resources** | Clean, consistent JSON response transformers |

---

## 🗄️ Database Schema

```
┌──────────┐     ┌───────────┐     ┌──────────┐
│  users   │     │ students  │     │  majors  │
├──────────┤     ├───────────┤     ├──────────┤
│ id       │     │ id        │     │ id       │
│ name     │     │ nim       │     │ code     │
│ email    │     │ name      │  ┌──│ name     │
│ password │     │ email     │  │  │ faculty  │
│ role     │     │ phone     │  │  │ desc     │
└──────────┘     │ gender    │  │  └──────────┘
                 │ birth_date│  │
                 │ address   │  │
                 │ major_id  │──┘
                 │ status    │
                 │ semester  │
                 │ gpa       │
                 │ deleted_at│ ← Soft Delete
                 └───────────┘
```

---

## 🚀 Installation

```bash
# 1. Clone the repository
git clone https://github.com/B3rlinSugi/student-management-api.git
cd student-management-api

# 2. Install dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=

# 5. Generate JWT secret
php artisan jwt:secret

# 6. Run migrations & seed
php artisan migrate --seed

# 7. Start server
php artisan serve
```

### Default Credentials (from seeder)

| Role  | Email                     | Password   |
|-------|---------------------------|------------|
| Admin | admin@student-api.com     | admin123   |
| User  | user@student-api.com      | user123    |

---

## 📡 API Endpoints

### Authentication

| Method | Endpoint              | Auth | Description           |
|--------|-----------------------|------|-----------------------|
| POST   | `/api/auth/register`  | ✗    | Register new user     |
| POST   | `/api/auth/login`     | ✗    | Login, get JWT token  |
| GET    | `/api/auth/me`        | ✓    | Get current user info |
| POST   | `/api/auth/refresh`   | ✓    | Refresh JWT token     |
| POST   | `/api/auth/logout`    | ✓    | Logout (invalidate)   |

### Students

| Method | Endpoint                       | Role  | Description              |
|--------|--------------------------------|-------|--------------------------|
| GET    | `/api/students`                | All   | List with search/filter  |
| POST   | `/api/students`                | Admin | Create new student       |
| GET    | `/api/students/{id}`           | All   | Get student detail       |
| PUT    | `/api/students/{id}`           | Admin | Update student           |
| DELETE | `/api/students/{id}`           | Admin | Soft delete              |
| GET    | `/api/students/trashed/list`   | Admin | List trashed students    |
| POST   | `/api/students/{id}/restore`   | Admin | Restore from trash       |
| DELETE | `/api/students/{id}/force`     | Admin | Permanently delete       |

### Majors

| Method | Endpoint          | Role  | Description     |
|--------|-------------------|-------|-----------------|
| GET    | `/api/majors`     | All   | List all majors |
| POST   | `/api/majors`     | Admin | Create major    |
| GET    | `/api/majors/{id}`| All   | Major detail    |
| PUT    | `/api/majors/{id}`| Admin | Update major    |
| DELETE | `/api/majors/{id}`| Admin | Delete major    |

---

## 🔍 Query Parameters (GET /api/students)

| Parameter | Type    | Example               | Description              |
|-----------|---------|-----------------------|--------------------------|
| `search`  | string  | `?search=andi`        | Search name/NIM/email    |
| `status`  | string  | `?status=active`      | Filter by status         |
| `major_id`| integer | `?major_id=1`         | Filter by major          |
| `gender`  | string  | `?gender=female`      | Filter by gender         |
| `per_page`| integer | `?per_page=20`        | Items per page (max 50)  |
| `sort_by` | string  | `?sort_by=gpa`        | Sort column              |
| `sort_dir`| string  | `?sort_dir=desc`      | asc or desc              |

**Example:** `GET /api/students?search=andi&status=active&major_id=1&sort_by=gpa&sort_dir=desc&per_page=5`

---

## 📦 Response Format

### Success (single)
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nim": "10121001",
    "name": "Andi Pratama",
    "email": "andi@student.ac.id",
    "gender": "male",
    "status": "active",
    "semester": 6,
    "gpa": "3.75",
    "major": {
      "id": 1,
      "code": "TI",
      "name": "Teknik Informatika",
      "faculty": "Fakultas Teknologi Industri"
    },
    "created_at": "2026-01-15T08:00:00.000000Z"
  }
}
```

### Success (paginated)
```json
{
  "success": true,
  "data": [...],
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

### Error
```json
{
  "success": false,
  "message": "Invalid credentials."
}
```

---

## 🔐 Authentication Flow

```
Client                           Server
  │                                │
  ├── POST /auth/login ──────────► │
  │   { email, password }          │  Validate credentials
  │                                │  Generate JWT token
  │ ◄────── 200 { token } ─────── │
  │                                │
  ├── GET /students ────────────► │
  │   Authorization: Bearer <token>│  Verify JWT
  │                                │  Check role (admin/user)
  │ ◄────── 200 { data } ──────── │
  │                                │
  ├── POST /auth/refresh ────────► │  Rotate token
  │ ◄────── 200 { new_token } ─── │
  │                                │
  ├── POST /auth/logout ─────────► │  Invalidate token
  │ ◄────── 200 { success } ───── │
```

---

## 🛠️ Tech Stack

| Layer        | Technology                          |
|--------------|-------------------------------------|
| Framework    | Laravel 11                          |
| Language     | PHP 8.2                             |
| Database     | MySQL 8 (InnoDB, FK Constraints)    |
| Auth         | JWT via php-open-source-saver/jwt-auth |
| Validation   | Laravel Form Requests               |
| Transformer  | Laravel API Resources               |
| Soft Delete  | Laravel SoftDeletes trait           |

---

## 👤 Author

**Berlin Sugiyanto**
- 🌐 Portfolio: [berlinsugi.vercel.app](https://berlinsugi.vercel.app)
- 💼 LinkedIn: [linkedin.com/in/berlinsugi](https://linkedin.com/in/berlinsugi)
- 📧 Email: berlinsugiyanto23@gmail.com
