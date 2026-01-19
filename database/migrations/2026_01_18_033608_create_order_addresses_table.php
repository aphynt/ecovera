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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->index();
            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('recipient_name');
            $table->string('phone', 20);

            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('postal_code', 10);
            $table->text('address_detail');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
