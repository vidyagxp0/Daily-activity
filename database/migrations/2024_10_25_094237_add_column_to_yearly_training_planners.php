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
        Schema::table('yearly_training_planners', function (Blueprint $table) {
            $table->text('division_id')->nullable();
            $table->text('ytp_id')->nullable();
            $table->text('form_type')->nullable();
            $table->text('stage')->nullable();
            $table->text('status')->nullable();
            $table->text('y_t_p_submit_by')->nullable();
            $table->text('y_t_p_submit_on')->nullable();
            $table->longText('y_t_p_comment')->nullable();
            $table->text('y_t_p_reviewed_by')->nullable();
            $table->text('y_t_p_reviewed_on')->nullable();
            $table->longText('y_t_p_reviewed_comment')->nullable();
            $table->text('y_t_p_approve_by')->nullable();
            $table->text('y_t_p_approve_on')->nullable();
            $table->longText('y_t_p_approve_commnet')->nullable();
            $table->text('Complete_by')->nullable();
            $table->text('Complete_on')->nullable();
            $table->longText('Complete_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yearly_training_planners', function (Blueprint $table) {
            //
        });
    }
};
