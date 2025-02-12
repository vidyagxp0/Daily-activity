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
        Schema::table('deviations', function (Blueprint $table) {
            $table->longtext('risk_factor')->nullable();
            $table->longtext('risk_element')->nullable();
            $table->longtext('problem_cause')->nullable();
            $table->longtext('existing_risk_control')->nullable();
            $table->longtext('initial_severity')->nullable();
            $table->longtext('initial_detectability')->nullable();
            $table->longtext('initial_probability')->nullable();
            $table->longtext('initial_rpn')->nullable();
            $table->longtext('risk_acceptance')->nullable();
            $table->longtext('risk_control_measure')->nullable();
            $table->longtext('residual_severity')->nullable();
            $table->longtext('residual_probability')->nullable();
            $table->longtext('residual_detectability')->nullable();
            $table->longtext('residual_rpn')->nullable();
            $table->longtext('risk_acceptance2')->nullable();
            $table->longtext('mitigation_proposal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deviations', function (Blueprint $table) {
            //
        });
    }
};
