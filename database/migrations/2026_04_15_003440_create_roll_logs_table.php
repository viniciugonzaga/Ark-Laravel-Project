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
        Schema::create('roll_logs', function (Blueprint $table) {
            $table->id();
            
            // FK para o usuário
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // FK para a ficha (apontando explicitamente para 'fichas')
            $table->foreignId('character_id')->constrained('fichas')->cascadeOnDelete();

            // Dados da Rolagem
            $table->json('dice_result')->nullable(); // Armazena o histórico do dado
            $table->text('event_result')->nullable(); // Armazena o texto do evento/resultado
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roll_logs');
    }
};