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
        Schema::create('risk_assesment_grids', function (Blueprint $table) {
            $table->id();

            $table->text('type')->nullable();
            $table->text('risk_id')->nullable();
            $table->longText('risk_factor')->nullable();
            $table->longText('risk_element')->nullable();
            $table->longText('problem_cause')->nullable();
            $table->longText('existing_risk_control')->nullable();
            $table->longText('initial_severity')->nullable();
            $table->longText('initial_detectability')->nullable();
            $table->longText('initial_probability')->nullable();
            $table->longText('initial_rpn')->nullable();
            $table->longText('risk_acceptance')->nullable();
            $table->longText('risk_control_measure')->nullable();
            $table->longText('residual_severity')->nullable();
            $table->longText('residual_probability')->nullable();
            $table->longText('residual_detectability')->nullable();
            $table->longText('residual_rpn')->nullable();
            $table->longText('risk_acceptance2')->nullable();
            $table->longText('mitigation_proposal')->nullable();
            $table->longText('measurement')->nullable();
            $table->longText('materials')->nullable();
            $table->longText('methods')->nullable();
            $table->longText('environment')->nullable();
            $table->longText('manpower')->nullable();
            $table->longText('machine')->nullable();
            $table->longText('problem_statement')->nullable();
            $table->longText('why_problem_statement')->nullable();
            $table->longText('why_root_cause')->nullable();
            $table->longText('why_1')->nullable();
            $table->longText('why_2')->nullable();
            $table->longText('why_3')->nullable();
            $table->longText('why_4')->nullable();
            $table->longText('why_5')->nullable();
            $table->longText('what_will_be')->nullable();
            $table->longText('what_will_not_be')->nullable();
            $table->longText('what_rationable')->nullable();
            $table->longText('where_will_be')->nullable();
            $table->longText('where_will_not_be')->nullable();
            $table->longText('where_rationable')->nullable();
            $table->longText('when_will_be')->nullable();
            $table->longText('when_will_not_be')->nullable();
            $table->longText('when_rationable')->nullable();
            $table->longText('coverage_will_be')->nullable();
            $table->longText('coverage_will_not_be')->nullable();
            $table->longText('coverage_rationable')->nullable();
            $table->longText('who_will_be')->nullable();
            $table->longText('who_will_not_be')->nullable();
            $table->longText('who_rationable')->nullable();
            $table->longText('Root_Cause_Category')->nullable();
            $table->longText('Root_Cause_Sub_Category')->nullable();
            $table->longText('Probability')->nullable();
            $table->longText('Remarks')->nullable();
            $table->longText('action')->nullable();
            $table->string('responsible')->nullable();
            $table->longText('deadline')->nullable();
            $table->longText('item_static')->nullable();
            $table->longtext('mitigation_steps')->nullable();
            $table->longtext('deadline2')->nullable();
            $table->longtext('responsible_person')->nullable();
            $table->longtext('status')->nullable();
            $table->longtext('remark')->nullable();

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
        Schema::dropIfExists('risk_assesment_grids');
    }
};
