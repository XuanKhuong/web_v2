<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_detail_id')->unsigned();
            $table->bigInteger('qty')->unsigned();
            $table->float('price', 8, 2)->unsigned();
            $table->float('sale_price', 8, 2)->unsigned();
            $table->String('unit')->nullable();//đơn vị tính
            $table->float('total', 8, 2)->unsigned();//tổng tiền
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
        Schema::dropIfExists('order_details');
    }
}
