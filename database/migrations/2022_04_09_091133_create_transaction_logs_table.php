<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->date('date');
            $table->string('particular');
            $table->tinyInteger('transaction_type')->nullable()->comment('1=Income; 2=Expense;4=product utilize');
            $table->tinyInteger('transaction_method')->comment('1=Cash; 2=Bank,3=Mobile Banking');
            $table->unsignedInteger('account_head_type_id');
            $table->unsignedInteger('account_head_sub_type_id');
            $table->unsignedInteger('bank_id')->nullable();
            $table->unsignedInteger('branch_id')->nullable();
            $table->unsignedInteger('bank_account_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('cheque_image')->nullable();
            $table->date('cheque_date')->nullable();
            $table->float('amount', 20,2);
            $table->string('note')->nullable();
            $table->unsignedInteger('salary_process_id')->nullable();
            $table->unsignedInteger('purchase_payment_id')->nullable();
            $table->unsignedInteger('sale_payment_id')->nullable();
            $table->unsignedInteger('transaction_id')->nullable();
            $table->unsignedInteger('balance_transfer_id')->nullable();
            $table->unsignedInteger('purchase_product_utilize_id')->nullable();
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
        Schema::dropIfExists('transaction_logs');
    }
}
