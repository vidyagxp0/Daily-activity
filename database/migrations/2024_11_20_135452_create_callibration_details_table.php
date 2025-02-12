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
        Schema::create('callibration_details', function (Blueprint $table) {
            $table->id();
            $table->text('calibrationDetails_id')->nullable();

            $table->text('initiator_id')->nullable();
            $table->text('division_id')->nullable();
            $table->text('division_code')->nullable();
            $table->text('intiation_date')->nullable();
            $table->text('status')->nullable();
            $table->text('stage')->nullable();
            $table->text('form_type')->nullable();
            $table->text('record')->nullable();
            $table->text('record_number')->nullable();
            $table->text('parent_id')->nullable();
            $table->text('parent_type')->nullable();
            $table->text('assign_to')->nullable();
            $table->text('due_date')->nullable();
            $table->longText('short_description')->nullable();

            $table->text('calibration_standard_preference')->nullable();
            $table->text('callibration_frequency')->nullable();            
            $table->text('last_calibration_date')->nullable();
            $table->text('next_calibration_date')->nullable();
            $table->text('calibration_due_reminder')->nullable();
            $table->longText('calibration_method_procedure')->nullable();
            $table->longText('calibration_procedure_attach')->nullable();
            $table->text('calibration_used')->nullable();
            $table->text('calibration_parameter')->nullable();
            $table->text('event_based_calibration')->nullable();
            $table->longText('event_based_calibration_reason')->nullable();
            $table->text('event_refernce_no')->nullable();
            $table->text('calibration_checklist')->nullable();
            $table->text('calibration_result')->nullable();
            $table->text('calibration_certificate_result')->nullable();            
            $table->longText('calibration_certificate')->nullable();
            $table->text('calibrated_by')->nullable();
            $table->text('calibration_due_alert')->nullable();
            $table->text('calibration_cost')->nullable();
            $table->longText('calibration_comments')->nullable();

            $table->text('Initiate_Calibration_by')->nullable();
            $table->text('Initiate_Calibration_on')->nullable();
            $table->longText('Initiate_Calibration_comments')->nullable();
            $table->text('Within_Limits_by')->nullable();
            $table->text('Within_Limits_on')->nullable();
            $table->longText('Within_Limits_comment')->nullable();
            $table->text('QA_Approval_by')->nullable();
            $table->text('QA_Approval_on')->nullable();
            $table->longText('QA_Approval_comment')->nullable();
            $table->text('Out_of_Limits_by')->nullable();
            $table->text('Out_of_Limits_on')->nullable();
            $table->longText('Out_of_Limits_comment')->nullable();
            $table->text('Complete_Actions_by')->nullable();
            $table->text('Complete_Actions_on')->nullable();
            $table->longText('Complete_Actions_comment')->nullable();
            $table->text('Additional_Work_Required_by')->nullable();
            $table->text('Additional_Work_Required_on')->nullable();
            $table->longText('Additional_Work_Required_comment')->nullable();
            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->longText('cancel_comment')->nullable();
            $table->text('cancelled_by')->nullable();
            $table->text('cancelled_on')->nullable();
            $table->longText('cancelled_comment')->nullable();
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
        Schema::dropIfExists('callibration_details');
    }
};
