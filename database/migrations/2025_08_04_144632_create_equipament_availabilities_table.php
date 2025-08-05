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
        Schema::create('equipament_availabilities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Relacionamentos
            $table->foreignId('equipament_id')->constrained('equipaments')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Datas de disponibilidade
            $table->date('start_date');
            $table->date('end_date');

            // Informações adicionais
            $table->boolean('is_available')->default(true);
            $table->string('status')->default('available'); // e.g. available, booked, cancelled
            $table->decimal('price', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // Soft delete
            $table->softDeletes();

            // Índices
            $table->unique(['equipament_id', 'start_date', 'end_date'], 'unique_availability');
            $table->index(['equipament_id', 'start_date', 'end_date'], 'equipament_availability_index');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipament_availabilities');
    }
};
