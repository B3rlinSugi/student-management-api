<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=0:1a1a2e,50:16213e,100:0f3460&height=180&section=header&text=Student%20Management%20API&fontSize=38&fontColor=e94560&animation=fadeIn&fontAlignY=38&desc=RESTful%20API%20%7C%20Laravel%2011%20%7C%20JWT%20Auth%20%7C%20RBAC%20%7C%20Soft%20Delete&descAlignY=55&descColor=a8b2d8" />

<a href="https://readme-typing-svg.herokuapp.com"><img src="https://readme-typing-svg.herokuapp.com?font=JetBrains+Mono&size=15&duration=3000&pause=1000&color=E94560&center=true&vCenter=true&width=535&lines=🚀+High+Performance+Laravel+11+REST+API;🛡️+Stateless+Tokenized+Auth+(JWT);🗑️+Soft-Delete+%26+Trash+Data+Management;🔎+Advanced+Multi-Column+Query+%26+Filters" alt="Typing SVG" /></a>
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=for-the-badge&logo=jsonwebtokens&logoColor=white)](https://jwt.io)
[![Live Demo](https://img.shields.io/badge/Live_Demo-Railway-0B0D0E?style=for-the-badge&logo=railway&logoColor=white)](https://student-management-api-production-b847.up.railway.app/)
[![Status](https://img.shields.io/badge/Status-Complete-brightgreen?style=for-the-badge)](https://github.com/B3rlinSugi/student-management-api)
[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](LICENSE)

</div>

---

## 📌 Overview

**Student Management API** adalah RESTful API production-ready yang dibangun dengan **Laravel 11**, dirancang untuk mengelola data mahasiswa dengan fitur autentikasi JWT, Role-Based Access Control, Soft Delete, serta pencarian dan filter yang fleksibel.

> 💡 **Fokus Teknis:** Proyek ini mendemonstrasikan kemampuan membangun API backend yang bersih menggunakan framework modern — dari desain endpoint, validasi request, transformasi response, hingga manajemen autentikasi berbasis token yang aman.

### 🏆 Fitur Unggulan

| Kategori | Detail |
|---|---|
| **Auth** | JWT Login, Register, Refresh Token, Logout (token invalidation) |
| **RBAC** | `admin` akses penuh · `user` read-only |
| **Data Management** | Full CRUD dengan Soft Delete → Trash → Restore → Force Delete |
| **Query** | Search multi-kolom, Filter, Pagination, Sorting |
| **Response** | Konsisten menggunakan Laravel API Resources + meta pagination |

---

## ✨ Fitur Lengkap

### 🔐 Autentikasi & Keamanan
- JWT Authentication via `php-open-source-saver/jwt-auth`
- Register, Login, Refresh Token, Logout (token invalidation)
- Role-Based Access Control: **Admin** (full access) dan **User** (read-only)
- Validasi request menggunakan **Laravel Form Requests**

### 👨‍🎓 Manajemen Mahasiswa
- CRUD lengkap dengan validasi data ketat (NIM, email unique, dsb.)
- **Soft Delete** — data tidak langsung terhapus permanen untuk mencegah data loss
- Trash management: list → restore → force delete
- Field lengkap: NIM, nama, email, telepon, gender, tanggal lahir, alamat, jurusan, status, semester, IPK

### 🏛️ Manajemen Jurusan
- CRUD data jurusan (kode, nama, fakultas, deskripsi)
- Relasi ke data mahasiswa via foreign key (relational integrity)

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
| `POST` | `/api/students/{id}/restore` | Admin | Restore dari trash |

---

## ⚙️ DevOps & Deployment

Proyek ini menggunakan alur kerja DevOps modern untuk memastikan availabilitas tinggi:

- **Infrastruktur**: [Railway](https://railway.app)
- **Containerization**: Menggunakan **Docker** untuk standardisasi lingkungan produksi (PHP-FPM + Nginx optimized).
- **Automation**: Pipeline CI/CD yang secara otomatis melakukan build dan deploy saat `git push` ke branch utama.
- **Security Audit**: Arsitektur tokenized stateless memastikan nol dependensi pada session file di server, meningkatkan skalabilitas.
- **Monitoring**: Health checks terintegrasi yang memantau status aplikasi secara real-time.

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
php artisan jwt:secret

# 4. Jalankan migrasi & seeder
php artisan migrate --seed

# 5. Jalankan server
php artisan serve
```

---

## 👤 Author

<div align="center">

**Berlin Sugiyanto Hutajulu**

[![GitHub](https://img.shields.io/badge/GitHub-B3rlinSugi-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/B3rlinSugi)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-berlinsugi-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://linkedin.com/in/berlinsugi)
[![Portfolio](https://img.shields.io/badge/Portfolio-berlinsugi.vercel.app-4e73df?style=for-the-badge&logo=vercel&logoColor=white)](https://berlinsugi.vercel.app)

---

Built with ❤️ and Laravel · High Performance REST API

</div>
