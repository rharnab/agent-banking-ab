<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePercentageSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percentage_setups', function (Blueprint $table) {
            $table->id();
            $table->float('bn_name_percentage')->default(0.00);
            $table->float('en_name_percentage')->default(0.00);
            $table->float('father_name_percentage')->default(0.00);
            $table->float('mother_name_percentage')->default(0.00);
            $table->float('address_percentage')->default(0.00);
            $table->float('face_percentage')->default(0.00);
            $table->float('date_of_birth_percentage')->default(0.00);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('percentage_setups');
    }
}
