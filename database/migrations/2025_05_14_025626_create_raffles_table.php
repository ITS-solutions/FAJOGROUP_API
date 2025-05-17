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
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->integer('tickets_number');
            $table->integer('price');
            $table->smallInteger('status')->default(1);
            $table->timestamp('end_date');
            $table->smallInteger('sale_type')->comment('1: online, 2: presencial, 3: ambas');
            $table->integer('initial_number');

            $table->foreignId('raffle_category_id')
                ->constrained('raffle_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('lottery_id')
                ->constrained('lotteries')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffles');
    }
};
