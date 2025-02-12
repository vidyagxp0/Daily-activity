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
        Schema::create('preventive_maintenances', function (Blueprint $table) {
            $table->id();
            $table->text('preventivemaintenance_id')->nullable();
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
            $table->text('pm_schedule')->nullable();
            $table->text('last_pm_date')->nullable();
            $table->text('next_pm_date')->nullable();
            $table->longText('pm_task_description')->nullable();
            $table->text('event_based_PM')->nullable();
            $table->longText('eventbased_pm_reason')->nullable();
            $table->text('PMevent_refernce_no')->nullable();
            $table->longText('pm_procedure_document')->nullable();
            $table->text('pm_performed_by')->nullable();
            $table->longText('maintenance_observation')->nullable();
            $table->text('replaced_parts')->nullable();
            $table->text('work_order_number')->nullable();
            $table->text('pm_checklist')->nullable();
            $table->text('emergency_flag_maintenance')->nullable();
            $table->text('cost_of_maintenance')->nullable();
            $table->text('submit_by')->nullable();
            $table->text('submit_on')->nullable();
            $table->text('submit_comments')->nullable();
            $table->text('Supervisor_Approval_by')->nullable();
            $table->text('Supervisor_Approval_on')->nullable();
            $table->text('Supervisor_Approval_comment')->nullable();
            $table->text('Complete_by')->nullable();
            $table->text('Complete_on')->nullable();
            $table->text('Complete_comment')->nullable();
            $table->text('additional_work_by')->nullable();
            $table->text('additional_work_on')->nullable();
            $table->text('additional_work_comment')->nullable();
            $table->text('qa_approval_by')->nullable();
            $table->text('qa_approval_on')->nullable();
            $table->text('qa_approval_comment')->nullable();

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
        Schema::dropIfExists('preventive_maintenances');
    }
};
