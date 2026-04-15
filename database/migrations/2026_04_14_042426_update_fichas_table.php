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
        Schema::table('fichas', function (Blueprint $table) {
            // Adicionamos os campos apenas se eles não existirem, 
            // sem forçar uma posição específica ('after') para evitar erros.
            
            if (!Schema::hasColumn('fichas', 'mutations')) {
                $table->json('mutations')->nullable();
            }
            if (!Schema::hasColumn('fichas', 'bonuses')) {
                $table->json('bonuses')->nullable();
            }
            if (!Schema::hasColumn('fichas', 'powers')) {
                $table->json('powers')->nullable();
            }
            if (!Schema::hasColumn('fichas', 'rituals')) {
                $table->json('rituals')->nullable();
            }
            if (!Schema::hasColumn('fichas', 'arsenal')) {
                $table->text('arsenal')->nullable();
            }

            // Stats Finais
            $fields = ['vida', 'armadura', 'determinacao', 'folego', 'resistencia_t'];
            foreach ($fields as $field) {
                if (!Schema::hasColumn('fichas', $field)) {
                    $table->integer($field)->default(0);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fichas', function (Blueprint $table) {
            $table->dropColumn([
                'mutations', 'bonuses', 'powers', 'rituals', 
                'arsenal', 'vida', 'armadura', 'determinacao', 
                'folego', 'resistencia_t'
            ]);
        });
    }
};