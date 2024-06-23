<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('estimate_project_id');
            $table->unsignedInteger('costing_type_id');
            $table->double('type_quantity',20,2);
            $table->float('ratio', 20,2)->default(0);
            $table->float('admixture_per_bag', 20,2)->default(0);
            $table->string('size');
            $table->double('volume',20,2);
            $table->float('total', 20,2)->default(0);
            $table->date('date');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('costings');
    }
}
