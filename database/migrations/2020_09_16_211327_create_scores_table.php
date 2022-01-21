<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('ecdata_id');
            $table->float('bn_name_percentage')->default(0.00);
            $table->float('en_name_percentage')->default(0.00);
            $table->float('father_name_percentage')->default(0.00);
            $table->float('mother_name_percentage')->default(0.00);
            $table->float('address_percentage')->default(0.00);
            $table->float('date_of_birth_percetage')->default(0.00);
            $table->float('nid_and_webcam_recognize_percentage')->default(0.00);
            $table->float('ec_and_webcam_recognize_percentage')->default(0.00);
            $table->float('text_maching_score')->default(0.00);
            $table->integer('user_id');
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
        Schema::dropIfExists('scores');
    }
}
