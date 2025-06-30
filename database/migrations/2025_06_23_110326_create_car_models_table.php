<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->string('generation')->nullable();
            $table->integer('year_start');
            $table->integer('year_end')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('car_models');
    }
};
