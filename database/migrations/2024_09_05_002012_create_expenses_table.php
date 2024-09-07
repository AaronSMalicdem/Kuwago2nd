<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_type'); // e.g., Supply, Advertisement, Spills
            $table->string('item_name'); // Name of the item
            $table->decimal('total_expenses', 10, 2); // Total amount
            $table->dateTime('date'); // Correctly defining the date column
            $table->boolean('archived')->default(false);
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses'); // Drop the table when rolling back
    }
}
