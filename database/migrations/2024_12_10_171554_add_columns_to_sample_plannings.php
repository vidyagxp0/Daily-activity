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
        Schema::table('sample_plannings', function (Blueprint $table) {
            $table->integer('assign_to')->nullable();
            $table->text('Initiator_Group')->nullable();
            $table->text('initiator_group_code')->nullable();
            $table->integer('sample_plan_id')->nullable();
            $table->text('sample_plan')->nullable();
            $table->text('sample_name')->nullable();
            $table->text('sample_type')->nullable();
            $table->text('product_name')->nullable();
            $table->text('batch_number')->nullable();
            $table->text('sample_priority')->nullable();
            $table->integer('sample_quantity')->nullable();
            $table->text('UOM')->nullable();
            $table->text('market')->nullable();
            $table->text('specification_id')->nullable();
            $table->longText('specification_attachment')->nullable();
            $table->text('STP_id')->nullable();
            $table->longText('STP_attachment')->nullable();
            $table->text('test_name')->nullable();
            $table->text('test_method')->nullable();
            $table->text('test_parameter')->nullable();
            $table->text('testing_frequency')->nullable();
            $table->text('testing_location')->nullable();
            $table->text('test_grouping')->nullable();
            $table->text('LSL')->nullable();
            $table->text('USL')->nullable();
            $table->text('testing_deadline')->nullable();
            $table->text('planner_name')->nullable();
            $table->text('sample_source')->nullable();
            $table->date('planned_date')->nullable();
            $table->text('lab_technician')->nullable();
            $table->text('sample_cost_estimation')->nullable();
            $table->text('resource_utilization')->nullable();
            $table->text('assigned_department')->nullable();
            $table->text('test_grouping2')->nullable();
            $table->date('sample_collection_date')->nullable();
            $table->longText('supportive_attachment')->nullable();

            $table->text('analysis_type')->nullable();
            $table->text('analysis_result')->nullable();
            $table->date('analysis_date')->nullable();
            $table->date('testin_start_date')->nullable();
            $table->date('testin_End_date')->nullable();
            $table->longText('delay_justification')->nullable();
            $table->date('testin_outcome')->nullable();
            $table->text('pass_fail')->nullable();
            $table->text('test_plan_id')->nullable();

            $table->text('turnaround_time')->nullable();
            $table->date('retesting_date')->nullable();
            $table->text('storage_location')->nullable();
            $table->text('transportation_method')->nullable();
            $table->longText('sample_prepration_method')->nullable();
            $table->longText('sample_packaging_detail')->nullable();
            $table->text('sample_lable')->nullable();
            $table->longText('regulatory_requirement')->nullable();
            $table->text('quality_control_checks')->nullable();
            $table->text('control_sample_reference')->nullable();
            $table->text('control_sample')->nullable();
            $table->text('reference_sample')->nullable();
            $table->text('sample_integrity_status')->nullable();
            $table->longText('risk_assessment')->nullable();
            $table->text('supervisor')->nullable();
            $table->text('instruments_reserved')->nullable();
            $table->text('lab_availability')->nullable();
            $table->date('sample_date')->nullable();
            $table->longText('sample_movement_history')->nullable();
            $table->longText('testing_process')->nullable();
            $table->longText('alert_notification')->nullable();
            $table->longText('deviation_logs')->nullable();
            $table->longText('comments_logs')->nullable();
            $table->longText('sample_analysis_attachment')->nullable();
            $table->text('sampling_frequency')->nullable();
            $table->text('stability_type')->nullable();
            $table->longText('supportivesample_analysis_attachment')->nullable();

            $table->text('reviewer_approver')->nullable();
            $table->date('review_date')->nullable();
            $table->longText('reviewer_comment')->nullable();
            $table->longText('supervisor_attachment')->nullable();

            $table->text('stability_status')->nullable();
            $table->longText('stability_protocol')->nullable();
            $table->date('stability_protocol_date')->nullable();
            $table->text('submission_country')->nullable();
            $table->text('zone')->nullable();
            $table->text('testing_result')->nullable();
            $table->text('reconstitution_stability')->nullable();
            $table->text('testing_interval')->nullable();
            $table->text('shelf_life_recommedation')->nullable();
            $table->longText('stability_attachment')->nullable();

            $table->text('QA_reviewer_approver')->nullable();
            $table->date('QA_review_date')->nullable();
            $table->longText('QA_reviewer_comment')->nullable();
            $table->longText('QA_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sample_plannings', function (Blueprint $table) {
            //
        });
    }
};
