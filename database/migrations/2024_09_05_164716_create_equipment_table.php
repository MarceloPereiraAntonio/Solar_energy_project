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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->timestamps();
        });

        DB::table('equipments')->insert([
            ['item' => 'Módulo', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Inversor','created_at' => now(), 'updated_at' => now()],
            ['item' => 'Microinversor', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Estrutura', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Cabo vermelho', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Cabo preto', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'String Box', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Cabo Tronco', 'created_at' => now(), 'updated_at' => now()],
            ['item' => 'Endcap', 'created_at' => now(), 'updated_at' => now()],

        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
