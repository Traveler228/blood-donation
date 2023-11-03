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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->date('is_honorary')->default(null);
            $table->unsignedInteger('number_donations')->nullable();
            $table->string('blood_type');
            $table->string('city');
            $table->unsignedInteger('user_id');
            $table->index('user_id', 'info_user_idx');
            $table->foreign('user_id', 'info_user_fk')->on('users')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
