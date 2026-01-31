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
        Schema::table('returns', function (Blueprint $table) {
            if (!Schema::hasColumn('returns', 'seller_note')) {
                $table->text('seller_note')->nullable()->after('admin_note');
            }
            if (!Schema::hasColumn('returns', 'return_address')) {
                $table->text('return_address')->nullable()->after('seller_note');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('returns', function (Blueprint $table) {
            if (Schema::hasColumn('returns', 'seller_note')) {
                $table->dropColumn('seller_note');
            }
            if (Schema::hasColumn('returns', 'return_address')) {
                $table->dropColumn('return_address');
            }
        });
    }
};
