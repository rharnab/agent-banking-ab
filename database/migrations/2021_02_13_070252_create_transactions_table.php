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
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('agent_id');
            $table->integer('agent_user_id');
            $table->integer('account_type')->comment('1:gl , 2: account');
            $table->string('account_no', 30);
            $table->string('transaction_type', 3)->comment('cd:cash deposite, cw:cash withdraw, fd:fund deposite, fw:fund withdraw');
            $table->date('transaction_date');
            $table->string('currency', 15);
            $table->decimal('amount', 20 , 2);
            $table->integer('operation_type')->comment('1 : Cash Transaction, 2: Fund Transfer, 3: Clearing');
            $table->string('cheque_no', 80)->nullable();
            $table->string('deposite_account_no',)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('created_by');
            $table->integer('approved_by')->default(0);
            $table->timestamp('approved_timestamp')->nullable();
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
