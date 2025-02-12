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
        Schema::table('auditees', function (Blueprint $table) {
            $table->text('audit_schedule_on_comment')->nullable();
            $table->text('audit_preparation_completed_on_comment')->nullable();
            $table->text('audit_mgr_more_info_reqd_on_comment')->nullable();

            $table->text('audit_observation_submitted_on_comment')->nullable();
            $table->text('response_close_done')->nullable();
            $table->string('cancel_1')->nullable();
            $table->string('cancel_2')->nullable();
            $table->string('cancel_3')->nullable();
            $table->string('reject_data')->nullable();
            $table->string('reject_data_1')->nullable();
            $table->string('rejected_by_2')->nullable();
            $table->string('rejected_on_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auditees', function (Blueprint $table) {
            //
        });
    }
};
