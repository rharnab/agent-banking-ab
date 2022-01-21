<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faces', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');          
            $table->string('webcam_face_image', 100)->nullable();
            $table->float('nid_and_webcam_recognize_percentage')->default(0.00);
            $table->float('ec_and_webcam_recognize_percentage')->default(0.00);
            $table->boolean('face_verification')->default(false);
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
        Schema::dropIfExists('faces');
    }
}
