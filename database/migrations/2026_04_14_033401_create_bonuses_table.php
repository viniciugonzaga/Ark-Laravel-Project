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
       Schema::create('bonuses', function (Blueprint $table) {
    $table->id();

    $table->foreignId('character_id')->constrained('fichas')->cascadeOnDelete();

    $table->string('name');
    $table->integer('value'); // 5,10,15

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonuses');
    }
};
