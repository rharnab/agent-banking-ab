<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentUserLimitModifyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_user_limit_modify_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('agent_id');
            $table->integer('agent_user_id');
            $table->decimal('old_limit', 20, 2);
            $table->decimal('new_limit', 20 ,2);
            $table->tinyInteger('status')->default(0);
            $table->integer('created_by');
            $table->integer('approved_by')->default(0);
            $table->timestamp('approved_timestamp')->nullable();
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
        Schema::dropIfExists('agent_user_limit_modify_logs');
    }
}
