<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissions', function (Blueprint $table) {
            $table->id();
            $table->string('commission_type', 20);
            $table->string('commission_trn_type', 20);
            $table->string('commission_trn_name', 100);
            $table->string('commission_amount', 200)->nullable();
            $table->string('percentage_of_amt', 200)->nullable();
            $table->string('start_slab', 200)->nullable();
            $table->string('end_slav', 200)->nullable();
            $table->string('vat', 20)->nullable();
            $table->string('created_by', 20)->nullable();

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
        Schema::dropIfExists('comissions');
    }
}
