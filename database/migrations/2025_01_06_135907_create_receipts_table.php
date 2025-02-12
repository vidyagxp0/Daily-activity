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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->text('record')->nullable();
            $table->text('form_type')->nullable();
            $table->text('mode_receipt')->nullable();
            $table->text('intiation_date')->nullable();
            $table->text('initiator_id')->nullable();
            $table->text('record_number')->nullable();
            $table->text('receipt_division')->nullable();
            $table->text('received_from')->nullable();
            $table->text('brief_description')->nullable();
            $table->text('source_of_sample')->nullable();
            $table->text('stakeholder_email')->nullable();
            $table->text('stakeholder_contact')->nullable();
            $table->text('date_of_receipt')->nullable();
            $table->text('initiator_Group')->nullable();
            $table->text('initiator_group_code')->nullable();
            $table->text('receptionist_diary')->nullable();
            $table->text('date_of_review')->nullable();
            $table->text('other_mode')->nullable();
            $table->text('received_from_1')->nullable();
            $table->text('brief_description_of_sample_1')->nullable();
            $table->text('sample_type')->nullable();
            $table->longText('attachment_receptionist')->nullable();
            $table->text('sample_analysis_type')->nullable();
            $table->text('specifications')->nullable();
            $table->text('details')->nullable();
            $table->text('other_sample_analysis')->nullable();
            $table->text('other_sample_type')->nullable();
            $table->text('analysis_type')->nullable();
            $table->longText('attachment_analysis')->nullable();
            $table->text('Division')->nullable();
            $table->text('title')->nullable();
            $table->text('date')->nullable();
            $table->text('Acknowledgement')->nullable();
            $table->text('moa_change_needed')->nullable();
            $table->text('moa_change_details')->nullable();
            $table->text('analysis_start_date')->nullable();
            $table->text('analysis_end_date')->nullable();
            $table->text('turn_around_time')->nullable();
            $table->text('review_1_assesment')->nullable();
            $table->longtext('Review1_Comment')->nullable();
            $table->longtext('review1_attachment')->nullable();
            $table->text('review_2_assesment')->nullable();
            $table->longtext('Review2_Comment')->nullable();
            $table->longtext('review2_attachment')->nullable();
            $table->text('approver_assesment')->nullable();
            $table->longtext('approver_Comment')->nullable();
            $table->longtext('approver_attachment')->nullable();
            $table->text('status')->nullable();
            $table->text('stage')->nullable();
            $table->text('pending_front_offiece_review_by')->nullable();
            $table->text('pending_front_offiece_review_on')->nullable();
            $table->text('pending_front_offiece_review_comment')->nullable();
            $table->text('pending_Review_by_sample_coordinator')->nullable();
            $table->text('pending_Review_on_sample_coordinator')->nullable();
            $table->text('pending_Review_comment_sample_coordinator')->nullable();
            $table->text('pending_allocation_sample_coordinator_by')->nullable();
            $table->text('pending_allocation_sample_coordinator_on')->nullable();
            $table->text('pending_allocation_sample_coordinator_comment')->nullable();
            $table->text('pending_sample_acknowledgement_by')->nullable();
            $table->text('pending_sample_acknowledgement_on')->nullable();
            $table->text('pending_sample_acknowledgement_comment')->nullable();
            $table->text('Pending_sample_analysis_by')->nullable();
            $table->text('Pending_sample_analysis_on')->nullable();
            $table->text('Pending_sample_analysis_comment')->nullable();
            $table->text('closed_done1_by')->nullable();
            $table->text('closed_done1_on')->nullable();
            $table->text('closed_done1_comment')->nullable();
            $table->text('pending_verification2_by')->nullable();
            $table->text('pending_verification2_on')->nullable();
            $table->text('pending_verification2_comment')->nullable();
            $table->text('pending_verification_approve_by')->nullable();
            $table->text('pending_verification_approve_on')->nullable();
            $table->text('pending_verification_approve_comment')->nullable();
            $table->text('closed_done2_by')->nullable();
            $table->text('closed_done2_on')->nullable();
            $table->text('closed_done2_comment')->nullable();
            $table->text('pending_verification1_by')->nullable();
            $table->text('pending_verification1_on')->nullable();
            $table->text('pending_verification1_comment')->nullable();
            $table->text('Cancel_By')->nullable();
            $table->text('Cancel_On')->nullable();
            $table->text('Cancel_Comment')->nullable();
            $table->text('more_info1_by')->nullable();
            $table->text('more_info1_on')->nullable();
            $table->text('more_info1_comment')->nullable();
            $table->text('more_info2_by')->nullable();
            $table->text('more_info2_on')->nullable();
            $table->text('more_info2_comment')->nullable();
            $table->text('more_info3_by')->nullable();
            $table->text('more_info3_on')->nullable();
            $table->text('more_info3_comment')->nullable();
            $table->text('MON_change_neended_by')->nullable();
            $table->text('MON_change_neended_on')->nullable();
            $table->text('MON_change_neended_comment')->nullable();
            $table->text('more_info4_by')->nullable();
            $table->text('more_info4_on')->nullable();
            $table->text('more_info4_comment')->nullable();
            $table->text('more_info5_by')->nullable();
            $table->text('more_info5_on')->nullable();
            $table->text('more_info5_comment')->nullable();
            $table->text('more_info6_by')->nullable();
            $table->text('more_info6_on')->nullable();
            $table->text('more_info6_comment')->nullable();
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
        Schema::dropIfExists('receipts');
    }
};
