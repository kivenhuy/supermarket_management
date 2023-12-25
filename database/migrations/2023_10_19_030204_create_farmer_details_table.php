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
        Schema::create('farmer_details', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->timestamps('enrollment_date');
            $table->string('enrollment_place')->nullable();
            $table->string('full_name');
            $table->string('phone_number');
            $table->integer('country');
            $table->integer('province');
            $table->integer('district');
            $table->integer('commune');
            $table->string('village')->nullable();
            $table->string('lng')->nullable();
            $table->string('lat')->nullable();
            $table->string('gender');
            $table->string('dob')->nullable();
            $table->string('farmer_code');
            $table->string('status')->default('active');
            $table->longText('farmer_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_details');
    }
};
