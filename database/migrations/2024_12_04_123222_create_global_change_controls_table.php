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
        Schema::create('global_change_controls', function (Blueprint $table) {
            $table->id();
            $table->integer('initiator_id')->nullable();
            $table->string('division_id')->nullable();

            $table->string('form_type')->nullable();
            $table->integer('record')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('priority_data')->nullable();
            $table->longText('severity_level1')->nullable();    
            $table->longText('initiated_through')->nullable();
            $table->longText('initiated_through_req')->nullable();
            $table->string('intiation_date')->nullable();
            $table->longText('Initiator_Group')->nullable();
            $table->longText('initiator_group_code')->nullable();
            $table->string('repeat')->nullable();
            $table->longText('repeat_nature')->nullable();
            $table->string('due_date')->nullable();

            $table->string('doc_change')->nullable();
            $table->longText('If_Others')->nullable();
            $table->string('in_attachment')->nullable();
            $table->longText('current_practice')->nullable();
            $table->longText('proposed_change')->nullable();
            $table->longText('reason_change')->nullable();
            $table->longText('other_comment')->nullable();
            $table->longText('qa_comments')->nullable();
            $table->string('related_records')->nullable();
            $table->string('qa_head')->nullable();

            $table->longText('qa_eval_comments')->nullable();
            $table->string('qa_eval_attach')->nullable();
            
            $table->longText('risk_identification')->nullable();
            $table->string('severity')->nullable();
            $table->string('Occurance')->nullable();
            $table->longText('migration_action')->nullable();

            $table->longText('feedback')->nullable();
            $table->string('tran_attach')->nullable();

            $table->longText('qa_closure_comments')->nullable();
            $table->string('attach_list')->nullable();
            $table->longText('due_date_extension')->nullable();
            $table->longText('external_users')->nullable();
            
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->longText('summaryReport')->nullable();
            $table->longText('risk_assessment_atch')->nullable();
            $table->text('record_number')->nullable();
            $table->text('product_name')->nullable();
            $table->string('risk_assessment_required')->nullable();
            $table->integer('hod_person')->nullable();
            $table->integer('due_days')->nullable();
            $table->longText('HOD_Remarks')->nullable();
            $table->longText('risk_assessment_related_record')->nullable();
            $table->integer('parent_record')->nullable();
            $table->longText('HOD_attachment')->nullable();

            $table->text('RA_review_required_by')->nullable();
            $table->text('RA_review_required_on')->nullable();
            $table->longText('RA_review_required_comment')->nullable();
            
            $table->text('RA_review_completed_by')->nullable();
            $table->text('RA_review_completed_on')->nullable();
            $table->longText('RA_review_completed_comment')->nullable();
            
            $table->text('approved_by')->nullable();
            $table->text('approved_on')->nullable();
            $table->longText('approved_comment')->nullable();
            
            $table->text('closure_approved_by')->nullable();
            $table->text('closure_approved_on')->nullable();
            $table->longText('closure_approved_comment')->nullable();

            $table->text('QaClouseToPostImplementationBy')->nullable();
            $table->text('QaClouseToPostImplementationOn')->nullable();
            $table->longText('QaClouseToPostImplementationComment')->nullable();
            
            $table->text('postImplementationToQaHeadBy')->nullable();
            $table->text('postImplementationToQaHeadOn')->nullable();
            $table->longText('postImplementationToQaHeadComment')->nullable(); 
            
            $table->string('qa_final_to_initiator_by')->nullable();
            $table->string('qa_final_to_initiator_on')->nullable();
            $table->string('qa_final_to_initiator_comment')->nullable();

            $table->string('qa_final_to_HOD_by')->nullable();
            $table->string('qa_final_to_HOD_on')->nullable();
            $table->string('qa_final_to_HOD_comment')->nullable();

            $table->string('qa_final_to_qainital_by')->nullable();
            $table->string('qa_final_to_qainital_on')->nullable();
            $table->string('qa_final_to_qainital_comment')->nullable();

            $table->string('qa_head_to_qaFinal_by')->nullable();
            $table->string('qa_head_to_qaFinal_on')->nullable();
            $table->string('qa_head_to_qaFinal_comment')->nullable();

            $table->text('submit_by')->nullable();
            $table->text('submit_on')->nullable();
            $table->longText('submit_comment')->nullable();

            $table->text('hod_review_by')->nullable();
            $table->text('hod_review_on')->nullable();
            $table->longText('hod_review_comment')->nullable();

            $table->text('QA_initial_review_by')->nullable();
            $table->text('QA_initial_review_on')->nullable();
            $table->longText('QA_initial_review_comment')->nullable();

            $table->text('cft_review_by')->nullable();
            $table->text('cft_review_on')->nullable();
            $table->longText('cft_review_comment')->nullable();

            $table->text('QA_final_review_by')->nullable();
            $table->text('QA_final_review_on')->nullable();
            $table->longText('QA_final_review_comment')->nullable();

            $table->string('QaHeadToQaFinalBy')->nullable();
            $table->string('QaHeadToQaFinalOn')->nullable();
            $table->longText('QaHeadToQaFinalComment')->nullable();

            $table->string('cftToQaInitialBy')->nullable();
            $table->string('cftToQaInitialOn')->nullable();
            $table->longText('cftToQaInitialComment')->nullable();

            $table->string('QaInitialToHodBy')->nullable();
            $table->string('QaInitialToHodOn')->nullable();
            $table->longText('QaInitialToHodComment')->nullable();

            $table->string('HodToOpenedBy')->nullable();
            $table->string('HodToOpenedOn')->nullable();
            $table->longText('HodToOpenedComment')->nullable();

            $table->string('openedToCancelBy')->nullable();
            $table->string('openedToCancelOn')->nullable();
            $table->longText('openedToCancelComment')->nullable();

            $table->text('initiator_update_complete_by')->nullable();
            $table->text('initiator_update_complete_on')->nullable();
            $table->longText('initiator_update_complete_comment')->nullable();

            $table->text('HOD_finalReview_complete_by')->nullable();
            $table->text('HOD_finalReview_complete_on')->nullable();
            $table->longText('HOD_finalReview_complete_comment')->nullable();
            $table->longText('send_for_final_qa_head_approval_comment')->nullable();
            $table->text('send_for_final_qa_head_approval')->nullable();
            $table->text('send_for_final_qa_head_approval_on')->nullable();
            $table->longText('qa_appro_comments')->nullable();
            $table->longText('qa_final_attach')->nullable();
            $table->longText('qa_cqa_attach')->nullable();
            $table->longText('intial_update_attach')->nullable();
            $table->longText('hod_final_review_attach')->nullable();
            $table->longText('hod_assessment_comments')->nullable();
            $table->longText('hod_assessment_attachment')->nullable();
            $table->longText('qa_review_comments')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('global_change_controls');
    }
};
