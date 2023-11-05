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
        Schema::create('transfusion_point_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transfusion_point_id');
            $table->unsignedInteger('user_id');
            $table->index('transfusion_point_id', 'trans_point_user_trans_point_idx');
            $table->index('user_id', 'trans_point_user_user_idx');
            $table->foreign('transfusion_point_id', 'trans_point_user_trans_point_fk')->on('transfusion_points')->references('id')->onDelete('cascade');
            $table->foreign('user_id', 'trans_point_user_user_fk')->on('users')->references('id')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfusion_point_users');
    }
};
