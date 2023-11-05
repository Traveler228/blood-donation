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
        Schema::create('blood_type_transfusion_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transfusion_point_id');
            $table->unsignedInteger('blood_type_id');
            $table->integer('quantity');
            $table->index('transfusion_point_id', 'trans_point_blood_type_trans_point_idx');
            $table->index('blood_type_id', 'trans_point_blood_type_blood_type_idx');
            $table->foreign('transfusion_point_id', 'trans_point_blood_type_trans_point_fk')->on('transfusion_points')->references('id');
            $table->foreign('blood_type_id', 'trans_point_blood_type_blood_type_fk')->on('blood_types')->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_type_transfusion_points');
    }
};
