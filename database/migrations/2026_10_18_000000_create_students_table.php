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
            
            // ✅ Mag-uugnay sa users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // ✅ Detalyadong impormasyon ng estudyante
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('course');
            $table->unsignedTinyInteger('year_level'); // 1 hanggang 4 lang
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};