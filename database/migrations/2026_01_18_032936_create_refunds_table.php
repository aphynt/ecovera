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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->index();
            $table->foreignId('return_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->decimal('refund_amount', 12, 2);
            $table->enum('refund_status', ['pending','success','failed'])->default('pending');
            $table->timestamp('refunded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
