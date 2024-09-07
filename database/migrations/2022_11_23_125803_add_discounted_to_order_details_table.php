<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountedToOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('discount_type')->nullable()->after('note');
            $table->float('discount')->nullable()->after('discount_type');
            $table->float('orig_price')->nullable()->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('discount_type');
            $table->dropColumn('discount');
            $table->dropColumn('orig_price');
        });
    }
}
