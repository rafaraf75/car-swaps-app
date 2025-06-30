<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('engines', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('power');
            $table->string('fuel_type');
            $table->float('capacity');
            $table->string('type')->default('original');
            $table->boolean('is_swap_candidate')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('engines');
    }
};
