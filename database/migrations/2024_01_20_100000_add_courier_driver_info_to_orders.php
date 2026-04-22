<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasWaybill = Schema::hasColumn('orders', 'waybill_id');

        Schema::table('orders', function (Blueprint $table) use ($hasWaybill) {
            if ($hasWaybill) {
                $table->string('courier_driver_name')->nullable()->after('waybill_id');
                $table->string('courier_driver_phone')->nullable()->after('courier_driver_name');
                $table->string('courier_driver_photo')->nullable()->after('courier_driver_phone');
                $table->decimal('courier_driver_rating', 3, 2)->nullable()->after('courier_driver_photo');
                $table->string('courier_driver_vehicle')->nullable()->after('courier_driver_rating');
                $table->string('courier_driver_vehicle_number')->nullable()->after('courier_driver_vehicle');
                $table->timestamp('pickup_time')->nullable()->after('courier_driver_vehicle_number');
                return;
            }

            $table->string('courier_driver_name')->nullable();
            $table->string('courier_driver_phone')->nullable();
            $table->string('courier_driver_photo')->nullable();
            $table->decimal('courier_driver_rating', 3, 2)->nullable();
            $table->string('courier_driver_vehicle')->nullable();
            $table->string('courier_driver_vehicle_number')->nullable();
            $table->timestamp('pickup_time')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'courier_driver_name',
                'courier_driver_phone',
                'courier_driver_photo',
                'courier_driver_rating',
                'courier_driver_vehicle',
                'courier_driver_vehicle_number',
                'pickup_time',
            ]);
        });
    }
};
