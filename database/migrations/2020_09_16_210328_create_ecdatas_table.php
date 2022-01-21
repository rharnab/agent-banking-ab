<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecdatas', function (Blueprint $table) {
            $table->id();
            $table->string('nid_number',50);
            $table->string('bn_name',100);
            $table->string('en_name',100);
            $table->string('father_name',100);
            $table->string('mother_name',100);
            $table->string('gender',100);
            $table->string('occupation',100);
            $table->date('date_of_birth');
            $table->string('blood_group');
            $table->text('present_address');
            $table->text('permanent_address');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('ecdatas');
    }
}
