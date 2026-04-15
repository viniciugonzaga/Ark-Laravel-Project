<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichas', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->string('name');
    $table->string('image')->nullable();

    $table->integer('level')->default(1);
    $table->integer('age')->nullable();

    $table->string('class_main');
    $table->string('class_sub')->nullable();

    $table->text('lore')->nullable();
    $table->text('arsenal')->nullable();

    // ATRIBUTOS
    $table->integer('agi')->default(1);
    $table->integer('for')->default(1);
    $table->integer('int')->default(1);
    $table->integer('set')->default(1);
    $table->integer('vig')->default(1);

    // STATUS
    $table->integer('vida')->default(0);
    $table->integer('armadura')->default(0);
    $table->integer('determinacao')->default(0);
    $table->integer('folego')->default(0);
    $table->integer('resistencia_t')->default(0);
    $table->integer('resistencia')->default(0);   

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas');
    }
};