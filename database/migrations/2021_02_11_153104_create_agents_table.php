<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('name', 80)->nullable();
            $table->string('short_code', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('account_no', 30);
            $table->integer('division_id');
            $table->integer('district_id');
            $table->decimal('transaction_amount_limit', 20, 2);
            $table->integer('user_limit');
            $table->float('commission');
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
        Schema::dropIfExists('agents');
    }
}
