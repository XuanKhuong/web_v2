<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->String('name')->nullable();
            $table->String('address')->nullable();
            $table->String('mobile')->nullable();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('status')->unsigned();//trạng thái
            $table->bigInteger('employee_id')->unsigned();
            $table->float('total', 8, 2)->unsigned();
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
