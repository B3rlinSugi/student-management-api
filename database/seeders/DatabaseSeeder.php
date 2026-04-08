<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@student-api.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'User Demo',
            'email'    => 'user@student-api.com',
            'password' => Hash::make('user123'),
            'role'     => 'user',
        ]);

        // ── Majors ──
        $majors = [
            ['code' => 'TI',  'name' => 'Teknik Informatika',      'faculty' => 'Fakultas Teknologi Industri'],
            ['code' => 'SI',  'name' => 'Sistem Informasi',         'faculty' => 'Fakultas Teknologi Industri'],
            ['code' => 'TK',  'name' => 'Teknik Komputer',          'faculty' => 'Fakultas Teknologi Industri'],
            ['code' => 'MI',  'name' => 'Manajemen Informatika',    'faculty' => 'Fakultas Teknologi Industri'],
            ['code' => 'KA',  'name' => 'Komputerisasi Akuntansi',  'faculty' => 'Fakultas Ekonomi'],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }

        // ── Students ──
        $studentData = [
            ['nim' => '10121001', 'name' => 'Andi Pratama',    'email' => 'andi@student.ac.id',    'gender' => 'male',   'major_id' => 1, 'semester' => 6, 'gpa' => 3.75, 'status' => 'active'],
            ['nim' => '10121002', 'name' => 'Budi Santoso',    'email' => 'budi@student.ac.id',    'gender' => 'male',   'major_id' => 1, 'semester' => 6, 'gpa' => 3.40, 'status' => 'active'],
            ['nim' => '10121003', 'name' => 'Citra Dewi',      'email' => 'citra@student.ac.id',   'gender' => 'female', 'major_id' => 2, 'semester' => 4, 'gpa' => 3.88, 'status' => 'active'],
            ['nim' => '10121004', 'name' => 'Dina Rahayu',     'email' => 'dina@student.ac.id',    'gender' => 'female', 'major_id' => 2, 'semester' => 2, 'gpa' => 3.55, 'status' => 'active'],
            ['nim' => '10121005', 'name' => 'Eko Wijaya',      'email' => 'eko@student.ac.id',     'gender' => 'male',   'major_id' => 3, 'semester' => 8, 'gpa' => 3.20, 'status' => 'graduated'],
            ['nim' => '10121006', 'name' => 'Fira Natasya',    'email' => 'fira@student.ac.id',    'gender' => 'female', 'major_id' => 1, 'semester' => 3, 'gpa' => 2.90, 'status' => 'inactive'],
            ['nim' => '10121007', 'name' => 'Gilang Ramadhan', 'email' => 'gilang@student.ac.id',  'gender' => 'male',   'major_id' => 4, 'semester' => 5, 'gpa' => 3.10, 'status' => 'active'],
            ['nim' => '10121008', 'name' => 'Hana Safitri',    'email' => 'hana@student.ac.id',    'gender' => 'female', 'major_id' => 5, 'semester' => 7, 'gpa' => 3.62, 'status' => 'active'],
        ];

        foreach ($studentData as $data) {
            Student::create($data);
        }
    }
}
