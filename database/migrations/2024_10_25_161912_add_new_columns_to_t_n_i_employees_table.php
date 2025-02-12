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
            $table->longtext('submit_by')->nullable();
            $table->longtext('submit_on')->nullable();
            $table->longtext('submit_comment')->nullable();
            $table->longtext('acknowledge_by')->nullable();
            $table->longtext('acknowledge_on')->nullable();
            $table->longtext('acknowledge_comment')->nullable();
            $table->longtext('approved_by')->nullable();
            $table->longtext('approved_on')->nullable();
            $table->longtext('approved_comment')->nullable();

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
