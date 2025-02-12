<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_training', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('hod')->nullable();
            for ($i = 1; $i <= 5; $i++) {

                $table->longText("subject_$i")->nullable();
                $table->longText("type_of_training_$i")->nullable();
                $table->longText("reference_document_no_$i")->nullable();
                $table->longText("trainee_name_$i")->nullable();
                $table->longText("trainer_$i")->nullable();

                $table->date("startdate_$i")->nullable();
                $table->date("enddate_$i")->nullable();

            }
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->text('empcode')->nullable();
            $table->text('type_of_training')->nullable();
            $table->text('start_date')->nullable();
            $table->text('sopdocument')->nullable();
            $table->string('name_employee')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('new_department')->nullable();
            $table->string('designation')->nullable();
            $table->string('qualification')->nullable();
            $table->string('experience_if_any')->nullable();
            $table->string('date_joining')->nullable();
            $table->string('revision_purpose')->nullable();
            $table->string('experience_with_agio')->nullable();
            $table->string('evaluation_required')->nullable();
            $table->string('total_experience')->nullable();
            $table->string('job_description_no')->nullable();
            $table->string('effective_date')->nullable();
            $table->string('reason_for_revision')->nullable();
            $table->string('delegate')->nullable();
            $table->longText('evaluation_comment')->nullable();
            $table->longText('final_review_comment')->nullable();
            $table->longText('qa_cqa_head_comment')->nullable();
            $table->longText('qa_cqa_comment')->nullable();
            $table->longText('qa_review')->nullable();
            $table->longText('evaluation_attachment')->nullable();
            $table->longText('final_review_attachment')->nullable();
            $table->longText('qa_cqa_head_attachment')->nullable();
            $table->longText('qa_cqa_attachment')->nullable();
            $table->longText('qa_review_attachment')->nullable();
            $table->longText('remark')->nullable();
           $table->longText('jd_type')->nullable();
           $table->integer('attempt_count')->default(3);
           $table->string('selected_document_id')->nullable();
            $table->text('end_date')->nullable();
            $table->text('submit_by')->nullable();
            $table->text('submit_on')->nullable();
            $table->text('submit_comment')->nullable();

            $table->text('approval_complete_by')->nullable();
            $table->text('approval_complete_on')->nullable();
            $table->text('approval_complete_comment')->nullable();

            $table->text('answer_submit_by')->nullable();
            $table->text('answer_submit_on')->nullable();
            $table->text('answer_submit_comment')->nullable();

            $table->text('evaluation_complete_by')->nullable();
            $table->text('evaluation_complete_on')->nullable();
            $table->text('evaluation_complete_comment')->nullable();

            $table->text('qa_head_review_complete_by')->nullable();
            $table->text('qa_head_review_complete_on')->nullable();
            $table->text('qa_head_review_complete_comment')->nullable();

            $table->text('verification_approval_complete_by')->nullable();
            $table->text('verification_approval_complete_on')->nullable();
            $table->text('verification_approval_complete_comment')->nullable();
            $table->longText('supporting_attachments1')->nullable();
            $table->longText('supporting_attachments2')->nullable();
            $table->longText('supporting_attachments3')->nullable();
            $table->longText('supporting_attachments4')->nullable();
            $table->longText('supporting_attachments5')->nullable();
            $table->integer('total_minimum_time')->default(0);
            $table->integer('per_screen_running_time')->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('classroom_training_grids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jobTraining_id')->nullable();
            $table->string('identifier')->nullable();
            $table->longtext('data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('classroom_training_audits', function (Blueprint $table) {
            $table->id();
            $table->string('job_id');
            $table->string('activity_type');
            $table->longText('previous')->nullable();
            $table->string('stage')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('origin_state')->nullable();
            $table->string('user_role')->nullable();
            $table->longText('change_to')->nullable();
            $table->longText('change_from')->nullable();
            $table->string('action')->nullable();
            $table->text('action_name')->nullable();
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
        Schema::dropIfExists('classroom_training');
    }
};
