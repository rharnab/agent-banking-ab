<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountOpeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_openings', function (Blueprint $table) {
            $table->id();
            $table->integer('self_registration_id');
            $table->integer('company_id');
            $table->integer('branch_id')->default(0);
            $table->string('signature_image', 80)->nullable();
            $table->decimal('probably_monthly_income', 10, 2)->defalult(0.00);
            $table->decimal('probably_monthly_deposite', 10, 2)->defalult(0.00);
            $table->decimal('probably_monthly_withdraw', 10, 2)->defalult(0.00);
            $table->string('nominee_name', 80)->nullable();
            $table->string('nominee_nid_number',30)->nullable();
            $table->text('nominee_address')->nullable();
            $table->timestamp('request_timestamp')->nullable();
            $table->integer('status')->comment('1: succesfully requested, 0: means does not compleate, 2: request approved, 3: request decline');
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
        Schema::dropIfExists('account_openings');
    }
}
