<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('agent_id');
            $table->foreign('agent_id')->references('id')->on('agents');
            $table->string('name', 80)->nullable();
            $table->string('email', 80)->unique();
            $table->string('password', 150)->nullable();
            $table->string('short_code', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('account_no', 30);
            $table->integer('division_id');
            $table->integer('district_id');
            $table->decimal('transaction_amount_limit', 20, 2);
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('approved_by')->default(0);
            $table->timestamp('approved_timestamp')->nullable();
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('agent_users');
    }
}
