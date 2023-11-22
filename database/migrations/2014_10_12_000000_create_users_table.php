<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('name');
            $table->string('patronymic')->nullable();
            $table->date('date_of_birth');
            $table->string('city');
            $table->unsignedInteger('blood_id');
            $table->date('is_honorary')->nullable()->default(null);
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->string('role')->default('user');
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();
            $table->index('blood_id', 'user_blood_type_idx');
            $table->foreign('blood_id', 'user_blood_type_fk')->on('blood_types')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
