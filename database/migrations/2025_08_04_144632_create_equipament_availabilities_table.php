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
            $table->foreignId('equipament_id')->constrained('equipaments')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_available')->default(true);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unique(['equipament_id', 'start_date', 'end_date'], 'unique_availability'); // Ensure unique availability per equipament and date range

            // Optional: Add an index for faster queries on availability
            $table->index(['equipament_id', 'start_date', 'end_date'], 'equipament_availability_index');
            $table->softDeletes(); // Allows for soft deletion of availabilities
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Ensure user exists
            $table->foreign('equipament_id')->references('id')->on('equipaments')->onDelete('cascade'); // Ensure equipament exists
            $table->string('status')->default('available'); // Status of the availability, e.g., available, booked, cancelled
            $table->decimal('price', 8, 2)->nullable(); // Optional price for the availability
            $table->text('description')->nullable(); // Optional description for the availability   
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
