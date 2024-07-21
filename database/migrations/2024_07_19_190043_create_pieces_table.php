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
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->integer('board_id');
            $table->enum('colour', ['black', 'white']);
            $table->enum('x', [1, 2, 3, 4, 5, 6, 7, 8]);
            $table->enum('y', [1, 2, 3, 4, 5, 6, 7, 8]);
            $table->boolean('king')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
