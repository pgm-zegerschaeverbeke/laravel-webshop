<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add new separate fields first
            $table->string('shipping_postal_code')->nullable()->after('shipping_address');
            $table->string('shipping_city')->nullable()->after('shipping_postal_code');
            $table->string('shipping_country')->nullable()->after('shipping_city');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_postal_code', 'shipping_city', 'shipping_country']);
        });
    }
};

