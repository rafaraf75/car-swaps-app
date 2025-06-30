<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('car_models', function (Blueprint $table) {
            $table->dropColumn('engine_id');
        });
    }

    public function down(): void {
        Schema::table('car_models', function (Blueprint $table) {
            $table->unsignedBigInteger('engine_id')->nullable();
        });
    }
};
