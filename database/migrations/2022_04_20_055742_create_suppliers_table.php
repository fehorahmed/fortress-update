<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('mobile');
            $table->string('alternative_mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->bigInteger('total')->nullable();
            $table->bigInteger('paid')->nullable();
            $table->bigInteger('refund')->nullable();
            $table->bigInteger('due')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('suppliers');
    }
}
