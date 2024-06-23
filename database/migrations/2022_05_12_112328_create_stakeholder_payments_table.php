<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStakeholderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stakeholder_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('stakeholder_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('transaction_log_id');
            $table->unsignedInteger('instalment_no');
            $table->unsignedTinyInteger('transaction_method')->comment('1=Cash; 2=Bank; 3=Mobile Banking');
            $table->unsignedTinyInteger('received_type')->comment('1=Nogod; 2=Due');
            $table->unsignedTinyInteger('type')->comment('1=pay');
            $table->unsignedInteger('bank_id');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('bank_account_id');
            $table->unsignedInteger('cheque_no');
            $table->unsignedInteger('cheque_image');
            $table->unsignedDouble('total',20,2);
            $table->unsignedDouble('paid',20,2);
            $table->unsignedDouble('due',20,2);
            $table->date('date');
            $table->string('note');

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
        Schema::dropIfExists('stakeholder_payments');
    }
}
