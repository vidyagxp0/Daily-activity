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
        Schema::create('equipment_lifecycle_information', function (Blueprint $table) {
            $table->id();
            $table->text('equipmentInfo_id')->nullable();

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
            
            $table->text('equipment_name_description')->nullable();
            $table->text('manufacturer')->nullable();
            $table->text('model_number')->nullable();
            $table->text('serial_number')->nullable();
            $table->text('equipment_id')->nullable();
            $table->longText('location')->nullable();
            $table->text('purchase_date')->nullable();
            $table->text('installation_date')->nullable();
            $table->text('warranty_expiration_date')->nullable();
            $table->text('criticality_level')->nullable();
            $table->text('asset_type')->nullable();
            
            $table->longText('urs_description')->nullable();
            $table->longText('system_level_risk_assessment_details')->nullable();
            $table->text('failure_mode_effect_analysis')->nullable();
            $table->longText('supporting_documents')->nullable();
            $table->longText('frs_description')->nullable();
            $table->longText('frs_attachment')->nullable();
            $table->longText('functional_risk_assessment_details')->nullable();

            // Installation Qualification (IQ)
            $table->text('iq_test_plan')->nullable();
            $table->text('iq_protocol')->nullable();
            $table->text('iq_execution')->nullable();
            $table->text('iq_report')->nullable();
            $table->longText('iq_attachment')->nullable();

            // Design Qualification (DQ)
            $table->text('dq_test_plan')->nullable();
            $table->text('dq_protocol')->nullable();
            $table->text('dq_execution')->nullable();
            $table->text('dq_report')->nullable();
            $table->longText('dq_attachment')->nullable();

            // Operational Qualification (OQ)
            $table->text('oq_test_plan')->nullable();
            $table->text('oq_protocol')->nullable();
            $table->text('oq_execution')->nullable();
            $table->text('oq_report')->nullable();
            $table->longText('oq_attachment')->nullable();

            // Performance Qualification (PQ)
            $table->text('pq_test_plan')->nullable();
            $table->text('pq_protocol')->nullable();
            $table->text('pq_execution')->nullable();
            $table->text('pq_report')->nullable();
            $table->longText('pq_attachment')->nullable();

            $table->text('migration_details')->nullable();
            $table->longText('migration_attachment')->nullable();
            $table->text('configuration_specification_details')->nullable();
            $table->longText('configuration_specification_attachment')->nullable();
            $table->text('requirement_traceability_details')->nullable();
            $table->longText('requirement_traceability_attachment')->nullable();
            $table->text('validation_summary_report')->nullable();
            $table->text('periodic_qualification_pending_on')->nullable();
            $table->text('periodic_qualification_notification')->nullable();

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

            $table->text('training_required')->nullable();
            $table->longText('trining_description')->nullable();
            $table->text('training_type')->nullable();
            $table->longText('training_attachment')->nullable();

            $table->longText('supervisor_comment')->nullable();
            $table->longText('Supervisor_document')->nullable();

            $table->longText('QA_comment')->nullable();
            $table->longText('QA_document')->nullable();

            $table->text('Equipment_Lifecycle_Stage')->nullable();
            $table->longText('Expected_Useful_Life')->nullable();
            $table->text('End_of_life_Date')->nullable();
            $table->longText('Decommissioning_and_Disposal_Records')->nullable();
            $table->longText('Replacement_History')->nullable();

            $table->text('submit_by')->nullable();
            $table->text('submit_on')->nullable();
            $table->longText('submit_comments')->nullable();
            $table->text('Supervisor_Approval_by')->nullable();
            $table->text('Supervisor_Approval_on')->nullable();
            $table->longText('Supervisor_Approval_comment')->nullable();
            $table->text('Complete_Qualification_by')->nullable();
            $table->text('Complete_Qualification_on')->nullable();
            $table->longText('Complete_Qualification_comment')->nullable();
            $table->text('Complete_Training_by')->nullable();
            $table->text('Complete_Training_on')->nullable();
            $table->longText('Complete_Training_comment')->nullable();
            $table->text('Take_Out_of_Service_by')->nullable();
            $table->text('Take_Out_of_Service_on')->nullable();
            $table->longText('Take_Out_of_Service_comment')->nullable();
            $table->text('Forward_to_Storage_by')->nullable();
            $table->text('Forward_to_Storage_on')->nullable();
            $table->longText('Forward_to_Storage_comment')->nullable();
            $table->text('More_Info_by')->nullable();
            $table->text('More_Info_on')->nullable();
            $table->longText('More_Info_comment')->nullable();
            $table->text('More_Info_by_sec_by')->nullable();
            $table->text('More_Info_by_sec_on')->nullable();
            $table->longText('More_Info_by_sec_comment')->nullable();
            $table->text('Re_Qualification_by')->nullable();
            $table->text('Re_Qualification_on')->nullable();
            $table->longText('Re_Qualification_comment')->nullable();
            $table->text('Re_Active_by')->nullable();
            $table->text('Re_Active_on')->nullable();
            $table->longText('Re_Active_comment')->nullable();
            $table->text('retire_by')->nullable();
            $table->text('retire_on')->nullable();
            $table->longText('retire_comment')->nullable();
            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->longText('cancel_comment')->nullable();
            $table->text('Re_Qualification_by_sec')->nullable();
            $table->text('Re_Qualification_on_sec')->nullable();
            $table->longText('Re_Qualification_comment_sec')->nullable();

            $table->text('cancelled_By')->nullable();
            $table->text('cancelled_On')->nullable();
            $table->longText('cancelled_comment')->nullable();

            $table->text('forword_storage_by')->nullable();
            $table->text('forword_storage_on')->nullable();
            $table->longText('forword_storage_comment')->nullable();


            $table->longText('risk_factor')->nullable();
            $table->longText('risk_element')->nullable();
            $table->longText('problem_cause')->nullable();
            $table->longText('existing_risk_control')->nullable();
            $table->text('initial_severity')->nullable();
            $table->text('initial_detectability')->nullable();
            $table->text('initial_probability')->nullable();
            $table->text('initial_rpn')->nullable();
            $table->text('risk_acceptance')->nullable();
            $table->longText('risk_control_measure')->nullable();
            $table->text('residual_severity')->nullable();
            $table->text('residual_probability')->nullable();
            $table->text('residual_detectability')->nullable();
            $table->text('residual_rpn')->nullable();
            $table->text('risk_acceptance2')->nullable();
            $table->longText('mitigation_proposal')->nullable();

            // Spare Part Information
            $table->longText('SpareEquipment_Name')->nullable();
            $table->longText('SpareEquipment_ID')->nullable();
            $table->longText('SparePart_ID')->nullable();
            $table->longText('SparePart_Name')->nullable();
            $table->longText('SpareManufacturer')->nullable();
            $table->longText('SpareModel_Number')->nullable();
            $table->longText('SpareSerial_Number')->nullable();
            $table->longText('SpareOEM')->nullable();
            $table->longText('SparePart_Category')->nullable();
            $table->longText('SparePart_Group')->nullable();
            $table->longText('SparePart_Dimensions')->nullable();
            $table->longText('SpareMaterial')->nullable();
            $table->longText('SpareWeight')->nullable();
            $table->longText('SpareColor')->nullable();
            $table->longText('SparePart_Lifecycle_Stage')->nullable();
            $table->longText('SparePart_Status')->nullable();
            $table->longText('SpareAvailability')->nullable();
            $table->longText('SpareQuantity_on_Hand')->nullable();
            $table->longText('SpareQuantity_on_Order')->nullable();
            $table->longText('SpareReorder_Point')->nullable();
            $table->longText('SpareSafety_Stock')->nullable();
            $table->longText('SpareMinimum_Order_Quantity')->nullable();
            $table->longText('SpareLead_Time')->nullable();
            $table->longText('SpareStock_Location')->nullable();
            $table->longText('SpareBin_Number')->nullable();
            $table->longText('SpareStock_Keeping_Unit')->nullable();
            $table->longText('SpareLot_Number')->nullable();
            $table->longText('SpareExpiry_Date')->nullable();
            $table->longText('SpareSupplier_Name')->nullable();
            $table->longText('SpareSupplier_Contact_Information')->nullable();
            $table->longText('SpareSupplier_Lead_Time')->nullable();
            $table->longText('SpareSupplier_Price')->nullable();
            $table->longText('SpareSupplier_Part_Number')->nullable();
            $table->longText('SpareSupplier_Warranty_Information')->nullable();
            $table->longText('SpareSupplier_Performance_Metrics')->nullable();

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
        Schema::dropIfExists('equipment_lifecycle_information');
    }
};
