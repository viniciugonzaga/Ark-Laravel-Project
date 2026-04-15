<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rituals', function (Blueprint $table) {
    $table->id();

  $table->foreignId('character_id')->constrained('fichas')->cascadeOnDelete();

    $table->string('type'); // ritual, pacto, conjuração
    $table->string('name');
    $table->text('description');

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('rituals');
    }
};