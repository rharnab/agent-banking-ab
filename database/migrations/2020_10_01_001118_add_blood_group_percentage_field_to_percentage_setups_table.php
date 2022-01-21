<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBloodGroupPercentageFieldToPercentageSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('percentage_setups', function (Blueprint $table) {
            $table->float('blood_group_percentage')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('percentage_setups', function (Blueprint $table) {
            $table->dropColumn('blood_group_percentage');
        });
    }
}
