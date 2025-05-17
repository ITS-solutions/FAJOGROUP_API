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
        Schema::create('raffle_details', function (Blueprint $table) {
            $table->id();

            $table->string('number');
            $table->smallInteger('status')->default(1)->comment('1: habilitado, 2: reservador para un vendedor, 3: vendido');
            $table->smallInteger('is_winner')->default(0)->comment('0: no es ganador, 1: es ganador');

            $table->foreignId('raffle_id')
                ->constrained('raffles')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_details');
    }
};
