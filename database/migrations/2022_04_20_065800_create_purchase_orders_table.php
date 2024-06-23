<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no');
            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('segment_id');
            $table->unsignedInteger('user_id');
            $table->date('date');
            $table->float('total', 50);
            $table->float('paid', 50);
            $table->float('vat', 20);
            $table->float('vat_percentage', 20);
            $table->float('discount', 20);
            $table->float('discount_percentage', 20);
            $table->float('due', 50);
            $table->float('refund', 20);
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
        Schema::dropIfExists('purchase_orders');
    }
}
