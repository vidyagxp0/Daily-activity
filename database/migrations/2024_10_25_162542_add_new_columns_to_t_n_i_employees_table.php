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
            $table->longtext('cancel_by')->nullable();
            $table->longtext('cancel_on')->nullable();
            $table->longtext('cancel_comment')->nullable();
            $table->longtext('acknowledge_cancel_by')->nullable();
            $table->longtext('acknowledge_cancel_on')->nullable();
            $table->longtext('acknowledge_cancel_comment')->nullable();

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
