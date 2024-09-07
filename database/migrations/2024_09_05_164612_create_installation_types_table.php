<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('installation_types', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->timestamps();
        });

        DB::table('installation_types')->insert([
            ['item' => 'Fibrocimento (Madeira)', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Fibrocimento (Metálico)', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Cerâmico', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Metálico', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Laje', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Solo', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installation_types');
    }
};
