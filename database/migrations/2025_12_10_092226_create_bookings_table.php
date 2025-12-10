<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status')->default('pending'); // pending, confirmed, paid, cancelled
            $table->decimal('total_price', 10, 2);
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
