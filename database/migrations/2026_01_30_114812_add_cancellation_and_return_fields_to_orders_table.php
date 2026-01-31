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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('cancel_reason')->nullable()->after('status');
            $table->text('cancel_note')->nullable()->after('cancel_reason');
            $table->timestamp('cancelled_at')->nullable()->after('cancel_note');

            $table->string('return_reason')->nullable()->after('cancelled_at');
            $table->text('return_description')->nullable()->after('return_reason');
            $table->string('return_image')->nullable()->after('return_description');
            $table->timestamp('return_requested_at')->nullable()->after('return_image');
            $table->timestamp('completed_at')->nullable()->after('return_requested_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'cancel_reason',
                'cancel_note',
                'cancelled_at',
                'return_reason',
                'return_description',
                'return_image',
                'return_requested_at',
                'completed_at'
            ]);
        });
    }
};
