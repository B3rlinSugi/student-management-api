# 🎓 Student Management API

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white" />
  <img src="https://img.shields.io/badge/Railway-0B0D0E?style=for-the-badge&logo=railway&logoColor=white" />
</p>

A production-ready RESTful API built with **Laravel 11** for managing student records and academic majors. This project demonstrates enterprise-grade backend development patterns, stateless authentication (JWT/Sanctum), and a clean, maintainable architecture.

## 🚀 Live Demo

- **Base URL:** [`https://student-management-api-production-b847.up.railway.app`](https://student-management-api-production-b847.up.railway.app)
- Try the endpoints in Postman by prefixing your requests with the Base URL.

## ✨ Features

- **Authentication:** Secure login and registration using stateless API tokens.
- **RESTful Endpoints:** Full CRUD operations following standard HTTP conventions.
- **Database Architecture:** Relational database design using MySQL with eager loading to prevent N+1 query problems.
- **Dockerized Deployment:** Containerized with Docker for seamless production deployment on cloud platforms like Railway.

## 🔌 API Endpoints

### 🔐 Authentication
- `POST /api/auth/register` - Register a new user
- `POST /api/auth/login` - Authenticate user and receive token

### 🏫 Majors
*Requires Authentication Bearer Token*
- `GET /api/majors` - Get a list of all majors
- `POST /api/majors` - Create a new major
- `PUT /api/majors/{id}` - Update a major
- `DELETE /api/majors/{id}` - Delete a major

### 👨‍🎓 Students
*Requires Authentication Bearer Token*
- `GET /api/students` - Get a paginated list of students
- `POST /api/students` - Register a new student
- `PUT /api/students/{id}` - Update student data
- `DELETE /api/students/{id}` - Remove a student

## 🛠️ Local Development Setup

If you wish to run this API on your local machine, follow these steps:

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
   Copy the example `.env` file and generate a new application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration:**
   Update your `.env` file with your local MySQL credentials.

5. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Start the local server:**
   ```bash
   php artisan serve
   ```
   The API will be accessible at `http://localhost:8000`.

---
*Developed by [Berlin Sugiyanto](https://github.com/B3rlinSugi)*
