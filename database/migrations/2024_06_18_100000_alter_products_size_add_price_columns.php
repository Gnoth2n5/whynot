<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_size', function (Blueprint $table) {
            $table->double('price_sell')->nullable()->after('quantity');
            $table->double('price_import')->nullable()->after('price_sell');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_size', function (Blueprint $table) {
            $table->dropColumn(['price_sell', 'price_import']);
        });
    }
}; 