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
            // Discount fields
            $table->decimal('product_discount', 12, 2)->default(0)->after('subtotal');
            $table->decimal('shipping_discount', 12, 2)->default(0)->after('product_discount');
            
            // COD related fields
            $table->boolean('cod_verified')->default(false)->after('payment_proof');
            $table->timestamp('cod_verified_at')->nullable()->after('cod_verified');
            
            // Distance in KM instead of minutes
            $table->decimal('delivery_distance_km', 10, 2)->nullable()->after('delivery_distance_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('product_discount', 12, 2)->default(0);
            $table->decimal('shipping_discount', 12, 2)->default(0);
                'shipping_discount', 
            $table->boolean('cod_verified')->default(false);
            $table->timestamp('cod_verified_at')->nullable();
                'delivery_distance_km'
            $table->decimal('delivery_distance_km', 10, 2)->nullable();
        });
    }
};
