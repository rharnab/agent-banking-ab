<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOverallPercentageFieldToPercentageSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('percentage_setups', function (Blueprint $table) {
            $table->float('overall_percentage')->default(0.00);
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
            $table->dropColumn('overall_percentage');
        });
    }
}
