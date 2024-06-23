<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseProductUtilizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_product_utilizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('purchase_product_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('product_segment_id');
            $table->float('quantity', 20);
            $table->float('unit_price', 20,2);
            $table->date('date');
            $table->string('note')->nullable();
            $table->unsignedInteger('purchase_inventory_id');
            $table->unsignedInteger('purchase_inventory_log_id');
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
        Schema::dropIfExists('purchase_product_utilizes');
    }
}
