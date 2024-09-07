<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waiter_id')->constrained('users');
            $table->string('order_number');
            $table->string('full_name');
            $table->string('payment_type')->nullable();
            $table->boolean('checked_out')->default(false);
            $table->timestamp('paid_on')->nullable();
            $table->float('total')->nullable();
            $table->float('cash')->nullable();
            $table->float('change')->nullable();
            $table->boolean('care_off')->default(false);
            $table->string('by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
