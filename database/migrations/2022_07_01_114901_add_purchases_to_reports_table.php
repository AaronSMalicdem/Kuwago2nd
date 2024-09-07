<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchasesToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->json('purchases')->nullable()->after('late');
            $table->float('total_purchases')->nullable()->after('late');
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
            $table->dropColumn('purchases');
            $table->dropColumn('total_purchases');
        });
    }
}
