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
        Schema::create('query_managements', function (Blueprint $table) {
            $table->id();
            $table->integer('initiation_date')->nullable(); // Submission Date
            $table->text('division_id')->nullable();
            $table->text('form_type')->nullable();
            $table->integer('record')->nullable(); // Query ID
            $table->integer('parent_id')->nullable();
            $table->text('parent_type')->nullable();
            $table->longText('short_description')->nullable();
            $table->text('due_date')->nullable();
            $table->longText('initial_attachment')->nullable();

            $table->text('query_type')->nullable();
            $table->longText('reference_document')->nullable();
            $table->integer('query_volume')->nullable();
            $table->text('query_medium')->nullable();
            $table->longText('mail_attachment')->nullable();
            $table->integer('assign_to')->nullable(); // Assigned Reviewer

            $table->integer('initiator_id')->nullable(); // Submitter Name
            $table->text('contact_mailId')->nullable();
            $table->text('contact_mobile')->nullable();
            $table->text('affiliation')->nullable();

            $table->longText('reviewer_comment')->nullable(); // Admin 1
            $table->longText('reviewer_attachment')->nullable(); // Admin 1

            $table->longText('admin1_comment')->nullable(); // Admin 2
            $table->longText('admin1_attachment')->nullable(); // Admin 2
            
            $table->longText('HOD_comment')->nullable();
            $table->longText('HOD_attachment')->nullable();

            $table->text('review_date')->nullable();
            $table->text('resolution_date')->nullable();            

            $table->text('resolution_status')->nullable();
            $table->longText('response_details')->nullable();
            $table->longText('followup_action')->nullable();
            $table->longText('supporting_doc')->nullable();
            $table->longText('category_tags')->nullable();
            $table->longText('regulatory_reference')->nullable();
            $table->longText('modification_history')->nullable();
            $table->longText('access_history')->nullable();            
            $table->integer('resolution_time')->nullable();
            $table->longText('trends')->nullable();
            $table->text('status')->nullable();
            $table->integer('stage')->nullable();
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
        Schema::dropIfExists('query_managements');
    }
};
