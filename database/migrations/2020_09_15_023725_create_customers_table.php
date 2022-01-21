<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('user_id');
            $table->string('nid_front_image',100);
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
            $table->string('step_compleate_status', 10)->nullable();
            $table->string('status', 80)->nullable()->comment('1: accept request');;
            $table->integer('accepted_user_id')->default(0);
            $table->timestamp('accepted_timestamp')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
