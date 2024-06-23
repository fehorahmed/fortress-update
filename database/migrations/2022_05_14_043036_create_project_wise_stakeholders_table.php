<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectWiseStakeholdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_wise_stakeholders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('stakeholder_id');
            $table->unsignedInteger('budget_instalment')->nullable();
            $table->unsignedDouble('budget_per_instalment_amount',20,2)->nullable();
            $table->unsignedDouble('budget_total',20,2)->nullable();
            $table->unsignedDouble('budget_due_',20,2)->nullable();
            $table->unsignedDouble('budget_paid',20,2)->nullable();
            $table->unsignedInteger('profit_instalment')->nullable();
            $table->unsignedDouble('profit_per_instalment_amount',20,2)->nullable();
            $table->unsignedDouble('profit_total',20,2)->nullable();
            $table->unsignedDouble('profit_due',20,2)->nullable();
            $table->unsignedDouble('profit_paid',20,2)->nullable();
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
        Schema::dropIfExists('project_wise_stakeholders');
    }
}
