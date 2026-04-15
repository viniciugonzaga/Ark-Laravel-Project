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
        Schema::table('users', function (Blueprint $table) {
            // Verifica se a coluna 'cargo' já não existe antes de criar
            if (!Schema::hasColumn('users', 'cargo')) {
                $table->string('cargo')->default('jogador')->after('email');
            }

            // Verifica se a coluna 'foto' já não existe antes de criar
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('cargo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove as colunas caso você precise dar um rollback
            $table->dropColumn(['cargo', 'foto']);
        });
    }
};