<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('transaction_type')->comment('1=Income; 2=Expense');
            $table->unsignedInteger('account_head_type_id');
            $table->integer('receipt_no');
            $table->unsignedInteger('account_head_sub_type_id');
            $table->tinyInteger('transaction_method')->comment('1=Cash; 2=Bank');
            $table->unsignedInteger('bank_id')->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->unsignedInteger('bank_account_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('cheque_image')->nullable();
            $table->date('cheque_date')->nullable();
            $table->float('amount', 20,2);
            $table->date('date');
            $table->date('next_date')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
