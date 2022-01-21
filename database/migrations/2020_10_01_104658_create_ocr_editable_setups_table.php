<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOcrEditableSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocr_editable_setups', function (Blueprint $table) {
            $table->id();            
            $table->boolean('bn_name')->default(false);
            $table->boolean('en_name')->default(false);
            $table->boolean('father_name')->default(false);
            $table->boolean('mother_name')->default(false);
            $table->boolean('address')->default(false);
            $table->boolean('date_of_birth')->default(false);
            $table->boolean('nid_number')->default(false);
            $table->boolean('blood_group')->default(false);
            $table->boolean('place_of_birth')->default(false);
            $table->boolean('issue_date')->default(false);
            $table->boolean('nid_code')->default(false);
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('ocr_editable_setups');
    }
}
