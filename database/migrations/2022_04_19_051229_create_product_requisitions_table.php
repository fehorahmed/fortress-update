<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requisitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('costing_id');
            $table->unsignedInteger('estimate_product_id');
            $table->string('name');
            $table->string('unit_id');
            $table->string('unit_price');
            $table->double('costing_amount', 20,2);
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
        Schema::dropIfExists('product_requisitions');
    }
}
