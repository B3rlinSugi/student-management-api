# 🎓 Student Management API — Production Laravel Backend

A comprehensive RESTful API built with **Laravel 11**, focusing on institutional student data management. Engineered with a stateless architecture, deep relational data mapping, and containerized deployment readiness.

[![Live Demo](https://img.shields.io/badge/Live%20Demo-student--management--api.railway.app-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://student-management-api-production-b847.up.railway.app)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://docker.com)

---

## 🏗 System Architecture

This API serves as a robust middleware layer, handling authentication, business constraints, and relational persistence.

```mermaid
graph LR
    Client["📱 Frontend / Postman"]
    Router["🛣 Laravel Router"]
    Auth["🔐 Sanctum/Auth Middleware"]
    Controller["🎮 Major/Student Controllers"]
    Eloquent["💎 Eloquent Models"]
    MySQL[("🗄️ MySQL Database")]

    Client -->|HTTP Request| Router
    Router --> Auth
    Auth -->|Verified| Controller
    Controller --> Eloquent
    Eloquent --> MySQL
```

---

## ✨ Features

- **🔐 Stateless Auth:** Secure token-based authentication using Laravel Sanctum.
- **🛡 Eloquent ORM:** Advanced relational mapping between Students and Majors with eager loading (N+1 protection).
- **📂 Mass Assignment Protection:** Strictly guarded model attributes for secure data entry.
- **📄 API Versioning:** Structured for scalability and backward compatibility.
- **🐳 Containerized:** Fully Dockerized environment for consistent staging and production builds.

---

## 🔌 API Endpoints

### 🔐 Authentication
| Method | Endpoint | Description |
|---|---|---|
| `POST` | `/api/auth/register` | User account creation |
| `POST` | `/api/auth/login` | Token generation |

### 🎓 Academic Core
*Requires `Authorization: Bearer <token>`*
| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/students` | Paginated student list |
| `POST` | `/api/students` | Enroll new student |
| `GET` | `/api/majors` | List of academic majors |
| `PUT` | `/api/students/{id}` | Update record details |

---

## 🗄 Database Schema

Designed for high relational integrity with indexed fields for fast lookups.

```mermaid
erDiagram
    USERS {
        id bigint PK
        name string
        email string
        password string
    }
    MAJORS {
        id bigint PK
        nama_jurusan string
    }
    STUDENTS {
        id bigint PK
        nim string UK
        nama string
        jurusan_id bigint FK
    }

    MAJORS ||--o{ STUDENTS : "has"
```

---

## 🚀 Deployment & Setup

### Local Installation
1. **Clone Repo:**
   ```bash
   git clone https://github.com/B3rlinSugi/student-management-api.git
   cd student-management-api
   ```

2. **Environment:**
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database:**
   Configure your `.env` with MySQL credentials, then sync:
   ```bash
   php artisan migrate
   ```

### 🐳 Docker Usage
```bash
docker-compose up -d
```

---

## 👨‍💻 Developed By

**Berlin Sugiyanto Hutajulu**

[![GitHub](https://img.shields.io/badge/GitHub-B3rlinSugi-181717?style=flat&logo=github)](https://github.com/B3rlinSugi)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-berlinsugi-0A66C2?style=flat&logo=linkedin)](https://linkedin.com/in/berlinsugi)
[![Portfolio](https://img.shields.io/badge/Portfolio-berlinsugi.vercel.app-4e73df?style=flat&logo=vercel)](https://berlinsugi.vercel.app)

---
<p align="center">Built with 💎 and Laravel 11 · Scalable RESTful Services</p>

