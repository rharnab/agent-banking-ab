<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_registrations', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('nid_front_image',100)->nullable();
            $table->string('nid_back_image', 100)->nullable();
            $table->text('front_data')->nullable();
            $table->text('back_data')->nullable();
            $table->string('bn_name', 80)->nullable();
            $table->string('en_name', 80)->nullable();
            $table->string('father_name', 80)->nullable();
            $table->string('mother_name', 80)->nullable();
            $table->string('date_of_birth', 80)->nullable();
            $table->string('nid_number', 25)->nullable();
            $table->string('mobile_number', 15)->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('blood_group', 50)->nullable();
            $table->string('place_of_birth', 50)->nullable();
            $table->string('issue_date', 50)->nullable();
            $table->string('nid_unique_data', 250)->nullable();           
            $table->string('webcam_face_image', 100)->nullable();
            $table->float('bn_name_percentage')->default(0.00);
            $table->float('en_name_percentage')->default(0.00);
            $table->float('father_name_percentage')->default(0.00);
            $table->float('mother_name_percentage')->default(0.00);
            $table->float('address_percentage')->default(0.00);
            $table->float('date_of_birth_percetage')->default(0.00);
            $table->float('text_maching_score')->default(0.00);
            $table->float('nid_and_webcam_recognize_percentage')->default(0.00);
            $table->float('ec_and_webcam_recognize_percentage')->default(0.00);
            $table->boolean('face_verification')->default(false);            
            $table->tinyInteger('status')->default(0)->comment('0:initial process, 1: registration compleate, 2: registration approved, 3: registration decline')->nullable();
            $table->string('step_compleate_status', 80)->nullable();
            $table->integer('created_user_id');
            $table->timestamp('request_timestamp')->nullable();
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
        Schema::dropIfExists('branch_registrations');
    }
}
