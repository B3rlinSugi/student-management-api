<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=0:1a1a2e,50:16213e,100:0f3460&height=180&section=header&text=Student%20Management%20API&fontSize=38&fontColor=e94560&animation=fadeIn&fontAlignY=38&desc=RESTful%20API%20%7C%20Laravel%2011%20%7C%20JWT%20Auth%20%7C%20RBAC%20%7C%20Soft%20Delete&descAlignY=55&descColor=a8b2d8" />

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=for-the-badge&logo=jsonwebtokens&logoColor=white)](https://jwt.io)
[![Status](https://img.shields.io/badge/Status-Complete-brightgreen?style=for-the-badge)](https://github.com/B3rlinSugi/student-management-api)
[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](LICENSE)

</div>

---

## 📌 Overview

**Student Management API** adalah RESTful API production-ready yang dibangun dengan **Laravel 11**, dirancang untuk mengelola data mahasiswa dengan fitur autentikasi JWT, Role-Based Access Control, Soft Delete, serta pencarian dan filter yang fleksibel.

> 💡 **Mengapa proyek ini penting?** Proyek ini mendemonstrasikan kemampuan membangun API backend yang bersih menggunakan framework modern — dari desain endpoint, validasi request, transformasi response, hingga manajemen autentikasi berbasis token yang aman.

### 🏆 Fitur Unggulan

| Kategori | Detail |
|---|---|
| **Auth** | JWT Login, Register, Refresh Token, Logout (token invalidation) |
| **RBAC** | `admin` akses penuh · `user` read-only |
| **Data Management** | Full CRUD dengan Soft Delete → Trash → Restore → Force Delete |
| **Query** | Search multi-kolom, Filter, Pagination (max 50/page), Sorting |
| **Response** | Konsisten menggunakan Laravel API Resources + meta pagination |

---

## ✨ Fitur Lengkap

### 🔐 Autentikasi & Keamanan
- JWT Authentication via `php-open-source-saver/jwt-auth`
- Register, Login, Refresh Token, Logout (token invalidation)
- Role-Based Access Control: **Admin** (full access) dan **User** (read-only)
- Validasi request menggunakan **Laravel Form Requests**

### 👨‍🎓 Manajemen Mahasiswa
- CRUD lengkap dengan validasi data (NIM, email unique, dsb.)
- **Soft Delete** — data tidak langsung terhapus permanen
- Trash management: list → restore → force delete
- Field lengkap: NIM, nama, email, telepon, gender, tanggal lahir, alamat, jurusan, status, semester, IPK

### 🏛️ Manajemen Jurusan
- CRUD data jurusan (kode, nama, fakultas, deskripsi)
- Relasi ke data mahasiswa via foreign key

### 🔍 Query yang Fleksibel
- **Search** — satu keyword mencakup nama, NIM, dan email sekaligus
- **Filter** — berdasarkan status, jurusan, dan gender
- **Pagination** — configurable `per_page` hingga maks 50
- **Sorting** — berdasarkan kolom apapun, asc/desc

### 📦 Response Konsisten
- Format sukses, error, dan paginated yang seragam
- Meta pagination lengkap (total, per_page, current_page, last_page)
- Links navigasi (first, last, prev, next)

---

## 🗄️ Desain Database

```
┌──────────┐          ┌───────────────┐          ┌──────────┐
│  users   │          │   students    │          │  majors  │
├──────────┤          ├───────────────┤          ├──────────┤
│ id       │          │ id            │          │ id       │
│ name     │          │ nim           │          │ code     │
│ email    │          │ name          │    ┌────▶│ name     │
│ password │          │ email         │    │     │ faculty  │
│ role     │          │ phone         │    │     │ desc     │
└──────────┘          │ gender        │    │     └──────────┘
                      │ birth_date    │    │
                      │ address       │    │
                      │ major_id ─────│────┘
                      │ status        │
                      │ semester      │
                      │ gpa           │
                      │ deleted_at ◀──│── Soft Delete
                      └───────────────┘
```

---

## 📡 API Endpoints

### 🔑 Authentication

| Method | Endpoint | Auth | Deskripsi |
|---|---|---|---|
| `POST` | `/api/auth/register` | ✗ | Daftarkan user baru |
| `POST` | `/api/auth/login` | ✗ | Login, dapatkan JWT token |
| `GET` | `/api/auth/me` | ✓ | Info user yang sedang login |
| `POST` | `/api/auth/refresh` | ✓ | Refresh JWT token |
| `POST` | `/api/auth/logout` | ✓ | Logout (invalidate token) |

### 👨‍🎓 Students

| Method | Endpoint | Role | Deskripsi |
|---|---|---|---|
| `GET` | `/api/students` | All | List mahasiswa (search/filter/paginate) |
| `POST` | `/api/students` | Admin | Tambah mahasiswa baru |
| `GET` | `/api/students/{id}` | All | Detail mahasiswa |
| `PUT` | `/api/students/{id}` | Admin | Update data mahasiswa |
| `DELETE` | `/api/students/{id}` | Admin | Soft delete mahasiswa |
| `GET` | `/api/students/trashed/list` | Admin | List mahasiswa yang dihapus |
| `POST` | `/api/students/{id}/restore` | Admin | Restore dari trash |
| `DELETE` | `/api/students/{id}/force` | Admin | Hapus permanen |

### 🏛️ Majors

| Method | Endpoint | Role | Deskripsi |
|---|---|---|---|
| `GET` | `/api/majors` | All | List semua jurusan |
| `POST` | `/api/majors` | Admin | Tambah jurusan |
| `GET` | `/api/majors/{id}` | All | Detail jurusan |
| `PUT` | `/api/majors/{id}` | Admin | Update jurusan |
| `DELETE` | `/api/majors/{id}` | Admin | Hapus jurusan |

---

## 🔍 Query Parameters

**`GET /api/students`**

| Parameter | Type | Contoh | Deskripsi |
|---|---|---|---|
| `search` | string | `?search=andi` | Cari di nama, NIM, email |
| `status` | string | `?status=active` | Filter status |
| `major_id` | integer | `?major_id=1` | Filter jurusan |
| `gender` | string | `?gender=female` | Filter gender |
| `per_page` | integer | `?per_page=20` | Item per halaman (maks 50) |
| `sort_by` | string | `?sort_by=gpa` | Kolom pengurutan |
| `sort_dir` | string | `?sort_dir=desc` | `asc` atau `desc` |

**Contoh request kompleks:**
```
GET /api/students?search=andi&status=active&major_id=1&sort_by=gpa&sort_dir=desc&per_page=5
```

---

## 📦 Format Response

<details>
<summary><b>✅ Success — Single Resource</b></summary>

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
</details>

<details>
<summary><b>✅ Success — Paginated List</b></summary>

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
</details>

<details>
<summary><b>❌ Error Response</b></summary>

```json
{
  "success": false,
  "message": "Invalid credentials."
}
```
</details>

---

## 🔐 Alur Autentikasi JWT

```
Client                              Server
  │                                   │
  ├── POST /auth/login ─────────────▶ │
  │   { email, password }             │  Validasi kredensial
  │                                   │  Generate JWT token
  │ ◀─────── 200 { token } ───────── │
  │                                   │
  ├── GET /students ────────────────▶ │
  │   Authorization: Bearer <token>   │  Verifikasi JWT
  │                                   │  Cek role (admin/user)
  │ ◀─────── 200 { data } ────────── │
  │                                   │
  ├── POST /auth/refresh ───────────▶ │  Rotate token
  │ ◀─────── 200 { new_token } ───── │
  │                                   │
  ├── POST /auth/logout ────────────▶ │  Invalidate token
  │ ◀─────── 200 { success } ─────── │
```

---

## 🚀 Cara Menjalankan

### Prasyarat
- PHP 8.2+
- Composer
- MySQL 8.0+

### Instalasi

```bash
# 1. Clone repository
git clone https://github.com/B3rlinSugi/student-management-api.git
cd student-management-api

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
DB_DATABASE=student_management
DB_USERNAME=root
DB_PASSWORD=

# 5. Generate JWT secret
php artisan jwt:secret

# 6. Jalankan migrasi & seeder
php artisan migrate --seed

# 7. Jalankan server
php artisan serve
# API tersedia di: http://localhost:8000/api
```

### Kredensial Default (dari seeder)

| Role | Email | Password |
|---|---|---|
| **Admin** | admin@student-api.com | admin123 |
| **User** | user@student-api.com | user123 |

---

## 📁 Struktur Proyek

```
student-management-api/
├── student-api/
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/Api/
│   │   │   │   ├── AuthController.php      # JWT auth logic
│   │   │   │   ├── StudentController.php   # Student CRUD + soft delete
│   │   │   │   └── MajorController.php     # Major CRUD
│   │   │   ├── Requests/                   # Form Request validations
│   │   │   └── Resources/                  # API Resource transformers
│   │   └── Models/
│   │       ├── User.php                    # JWT user model
│   │       ├── Student.php                 # SoftDeletes trait
│   │       └── Major.php
│   ├── database/
│   │   ├── migrations/                     # DB schema
│   │   └── seeders/                        # Default data seeder
│   └── routes/
│       └── api.php                         # API route definitions
├── .env.example
├── composer.json
└── README.md
```

---

## 🛠️ Tech Stack

| Layer | Teknologi | Alasan |
|---|---|---|
| Framework | Laravel 11 | Modern PHP framework, built-in tools |
| Language | PHP 8.2 | Latest stable, type safety improvements |
| Database | MySQL 8 (InnoDB) | FK constraints + relational integrity |
| Auth | JWT (php-open-source-saver/jwt-auth) | Stateless, scalable API authentication |
| Validation | Laravel Form Requests | Clean separation of validation logic |
| Response | Laravel API Resources | Consistent JSON output transformation |
| Soft Delete | Laravel SoftDeletes | Non-destructive delete workflow |

---

## 👤 Author

<div align="center">

**Berlin Sugiyanto**

[![LinkedIn](https://img.shields.io/badge/LinkedIn-berlinsugi-0077B5?style=flat-square&logo=linkedin)](https://linkedin.com/in/berlinsugi)
[![Portfolio](https://img.shields.io/badge/Portfolio-berlinsugi.vercel.app-4e73df?style=flat-square&logo=vercel)](https://berlinsugi.vercel.app)
[![Email](https://img.shields.io/badge/Email-berlinsugiyanto23%40gmail.com-D14836?style=flat-square&logo=gmail)](mailto:berlinsugiyanto23@gmail.com)
[![GitHub](https://img.shields.io/badge/GitHub-B3rlinSugi-181717?style=flat-square&logo=github)](https://github.com/B3rlinSugi)

</div>

---

<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=0:0f3460,50:16213e,100:1a1a2e&height=100&section=footer" />

</div>
