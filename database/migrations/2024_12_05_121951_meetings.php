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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->text('type')->nullable();
            $table->integer('record')->nullable();
            $table->text('record_number')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('parent_type')->nullable();
            $table->text('division_code')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->integer('assign_to')->nullable();
            $table->text('due_date')->nullable();
            $table->text('scheduled_start_date')->nullable();
            $table->text('scheduled_end_date')->nullable();
            $table->longText('attandees')->nullable();
            $table->longText('description')->nullable();
            $table->longText('short_description')->nullable();
            $table->text('related_urls')->nullable();
            $table->longText('attachment_files')->nullable();
            $table->text('actual_start_date')->nullable();
            $table->text('actual_end_date')->nullable();
            $table->longText('meeting_minutes')->nullable();
            $table->longText('decisions')->nullable();
            $table->text('zone')->nullable();
            $table->text('country')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->text('site_name')->nullable();
            $table->text('building')->nullable();
            $table->text('floor')->nullable();
            $table->text('room')->nullable();
            $table->integer('stage')->nullable();
            $table->text('status')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('meeting_url')->nullable();
            $table->longText( 'data')->nullable();
            $table->text('submitted_by')->nullable();
            $table->text('submitted_on')->nullable();
            $table->longText('submitted_comment')->nullable();
            $table->text('complete_by')->nullable();
            $table->text('complete_on')->nullable();
            $table->longText('complete_comment')->nullable();
            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->longText('cancel_comment')->nullable();
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
        Schema::dropIfExists('meetings');
    }
};
