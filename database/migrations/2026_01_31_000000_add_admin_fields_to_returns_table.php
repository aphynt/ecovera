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
            if (!Schema::hasColumn('returns', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('return_status');
            }
            if (!Schema::hasColumn('returns', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('admin_note');
            }
            if (!Schema::hasColumn('returns', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approved_at');
            }
            if (!Schema::hasColumn('returns', 'processed_by')) {
                $table->foreignId('processed_by')->nullable()->after('rejected_at')->constrained('users');
            }
            if (!Schema::hasColumn('returns', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('returns', function (Blueprint $table) {
            if (Schema::hasColumn('returns', 'processed_by')) {
                $table->dropForeign(['processed_by']);
                $table->dropColumn('processed_by');
            }
            if (Schema::hasColumn('returns', 'admin_note')) {
                $table->dropColumn('admin_note');
            }
            if (Schema::hasColumn('returns', 'approved_at')) {
                $table->dropColumn('approved_at');
            }
            if (Schema::hasColumn('returns', 'rejected_at')) {
                $table->dropColumn('rejected_at');
            }
            if (Schema::hasColumn('returns', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
