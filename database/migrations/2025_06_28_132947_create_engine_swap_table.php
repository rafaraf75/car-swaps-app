<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('engine_swap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('swap_id')->constrained()->onDelete('cascade');
            $table->foreignId('engine_id')->constrained()->onDelete('cascade');
            $table->enum('difficulty', ['łatwy', 'średni', 'trudny'])->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['swap_id', 'engine_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('engine_swap');
    }
};
