<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20)->unique()->comment('Student ID Number');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('major_id')->constrained('majors')->onDelete('restrict');
            $table->enum('status', ['active', 'inactive', 'graduated', 'dropout'])->default('active');
            $table->integer('semester')->default(1);
            $table->float('gpa', 3, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for search & filter performance
            $table->index(['name', 'nim', 'email']);
            $table->index('status');
            $table->index('major_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
