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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('type_id');
            $table->date('date');
            $table->string('confirming_document')->unique();
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id', 'donation_user_idx');
            $table->foreign('user_id', 'donation_user_fk')->on('users')->references('id');

            $table->index('type_id', 'donation_type_idx');
            $table->foreign('type_id', 'donation_type_fk')->on('donation_types')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
