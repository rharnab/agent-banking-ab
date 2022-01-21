<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentCustomerAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_customer_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('agent_id');
            $table->integer('agent_user_id')->default(0);
            $table->integer('branch_registration_id')->default(0);
            $table->integer('account_opening_id')->default(0);
            $table->integer('customer_id')->default(0);
            $table->integer('score_id')->default(0);
            $table->integer('face_id')->default(0);
            $table->string('account_no', 30)->nullable();
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('agent_customer_accounts');
    }
}
