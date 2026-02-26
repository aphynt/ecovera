<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Add user_id to products
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('uuid');
        });

        // Migrate data
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $store = DB::table('stores')->where('id', $product->store_id)->first();
            if ($store) {
                DB::table('products')->where('id', $product->id)->update(['user_id' => $store->user_id]);
            }
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropColumn('store_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // 2. Drop store_subscriptions
        Schema::dropIfExists('store_subscriptions');

        // 3. Create subscriptions table tied to user
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_id')->unique();
            $table->decimal('amount', 10, 2)->default(30000);
            $table->string('status')->default('pending');
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });

        // 4. Drop stores table
        Schema::dropIfExists('stores');
    }

    public function down(): void
    {
        // no down migration
    }
};
