<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('product_segment_id');

            $table->unsignedDouble('daily_unit_done',10,2)->nullable();
           // $table->unsignedDouble('today_progress',10,2)->nullable();
            $table->unsignedDouble('segment_progress_percentage',10,2)->nullable();
            $table->unsignedDouble('project_progress_percentance',10,2)->nullable();
            $table->date('date');
            $table->string('note')->nullable();

            //$table->('date');

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
        Schema::dropIfExists('physical_progress');
    }
}
