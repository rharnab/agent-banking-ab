<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('acc_option');
            $table->string('debit_ac', 50);
            $table->integer('txn_type');
            $table->string('credit_ac', 50);
            $table->float('amount');
            $table->integer('currency');
            $table->string('cheaque_no', 50)->nullable();
            $table->integer('is_approve')->default(0);
            $table->integer('created_by');
            $table->integer('approve_by')->nullable();
            $table->timestamp('approve_date')->nullable();
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
        Schema::dropIfExists('fund_transfers');
    }
}
