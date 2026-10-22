<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('classes', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('code')->unique();
        
        // Use foreignId with constrained() to automatically link to subjects and faculties tables
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('faculty_id')->nullable()->constrained('faculties')->onDelete('set null');
        
        $table->string('schedule');
        $table->enum('year_level', ['1st Year', '2nd Year', '3rd Year', '4th Year']);
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};