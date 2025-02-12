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
        Schema::table('analytics', function (Blueprint $table) {
            $table->integer('stage')->nullable();
            $table->string('status')->nullable();
            $table->string('sbmitted_by')->nullable();
            $table->string('sbmitted_on')->nullable();
            $table->string('sbmitted_comment')->nullable();
            $table->string('qualified_by')->nullable();
            $table->string('qualified_on')->nullable();
            $table->string('qualified_comment')->nullable();
            $table->string('rejected_by')->nullable();
            $table->string('rejected_on')->nullable();
            $table->string('rejected_comment')->nullable();
            $table->longtext('hod')->nullable();
            $table->text('update_complete_by')->nullable();
            $table->text('update_complete_on')->nullable();
            $table->text('update_complete_comment')->nullable();

            $table->text('answer_complete_by')->nullable();
            $table->text('answer_complete_on')->nullable();
            $table->text('answer_complete_comment')->nullable();

            $table->text('evaluation_complete_by')->nullable();
            $table->text('evaluation_complete_on')->nullable();
            $table->text('evaluation_complete_comment')->nullable();

            $table->longText('employee_id')->nullable();
            $table->longText('employee_name')->nullable();
            $table->date('training_date')->nullable();
            $table->longText('topic')->nullable();
            $table->longText('type')->nullable();
            $table->longText('evaluation')->nullable();
            $table->longText('hod_comment')->nullable();
            $table->longText('hod_attachment')->nullable();
            $table->longText('qa_final_comment')->nullable();
            $table->longText('qa_final_attachment')->nullable();

            $table->string('sopdocument')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analytics', function (Blueprint $table) {
            //
        });
    }
};
