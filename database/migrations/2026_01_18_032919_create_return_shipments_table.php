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
        Schema::create('return_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->index();
            $table->foreignId('return_id')->constrained()->cascadeOnDelete();
            $table->string('courier');
            $table->string('tracking_number')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('received_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_shipments');
    }
};
