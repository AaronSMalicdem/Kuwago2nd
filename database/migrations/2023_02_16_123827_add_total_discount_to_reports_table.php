<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalDiscountToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->float('total_discount')->nullable()->after('total_sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('total_discount');
        });
    }
}
