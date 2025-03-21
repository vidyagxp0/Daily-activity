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
        Schema::table('induction_trainings', function (Blueprint $table) {
            //

            $table->text('submit_by')->nullable();
            $table->text('submit_on')->nullable();
            $table->text('submit_comment')->nullable();

            $table->text('answer_submit_by')->nullable();
            $table->text('answer_submit_on')->nullable();
            $table->text('answer_submit_comment')->nullable();

            $table->text('evaluation_complete_by')->nullable();
            $table->text('evaluation_complete_on')->nullable();
            $table->text('evaluation_complete_comment')->nullable();

            $table->text('approval_complete_by')->nullable();
            $table->text('approval_complete_on')->nullable();
            $table->text('approval_complete_comment')->nullable();

            $table->text('qa_head_approval_complete_by')->nullable();
            $table->text('qa_head_approval_complete_on')->nullable();
            $table->text('qa_head_approval_complete_comment')->nullable();

            $table->text('Send_To_OJT_by')->nullable();
            $table->text('Send_To_OJT_on')->nullable();
            $table->text('Send_To_OJT_comment')->nullable();

            $table->text('creation_complete_by')->nullable();
            $table->text('creation_complete_on')->nullable();
            $table->text('creation_complete_comment')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('induction_trainings', function (Blueprint $table) {
            //
        });
    }
};
