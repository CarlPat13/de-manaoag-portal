<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('faculties', function (Blueprint $table) {
    $table->id(); // ✅ BIGINT UNSIGNED — tugma sa classes
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('faculties');
    }
};