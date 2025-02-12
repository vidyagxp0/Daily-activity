<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_n_i_employees', function (Blueprint $table) {
            $table->longText("acknowledge")->nullable();
            $table->longText("acknowledge_attachment")->nullable();
            $table->longText("hod_remark")->nullable();
            $table->longText("hod_attachment")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_n_i_employees', function (Blueprint $table) {
            //
        });
    }
};
