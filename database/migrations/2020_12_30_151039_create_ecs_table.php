<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecs', function (Blueprint $table) {
            $table->id();
            $table->string('nid_number', 20);
            $table->string('name', 80)->nullable();
            $table->string('nameEn', 80)->nullable();
            $table->string('father', 80)->nullable();
            $table->string('mother', 80)->nullable();
            $table->string('gender', 80)->nullable();
            $table->string('spouse', 100)->nullable();
            $table->date('dob');
            $table->text('permanentAddress')->nullable();
            $table->text('presentAddress')->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('fatherEn', 50)->nullable();
            $table->string('motherEn', 50)->nullable();
            $table->string('spouseEn', 50)->nullable();
            $table->string('permanentAddressEn', 50)->nullable();
            $table->string('presentAddressEn', 50)->nullable();
            $table->string('passKyc', 20)->nullable();
            $table->string('errorCode', 50)->nullable();
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
        Schema::dropIfExists('ecs');
    }
}
