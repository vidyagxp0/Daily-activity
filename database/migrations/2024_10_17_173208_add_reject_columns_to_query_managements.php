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
        Schema::table('query_managements', function (Blueprint $table) {
            $table->text('sentToInitiator_by')->nullable();
            $table->text('sentToInitiator_on')->nullable();
            $table->longText('sentToInitiator_comment')->nullable();

            $table->text('sentToHOD')->nullable();
            $table->text('sentToHOD_on')->nullable();
            $table->longText('sentToHOD_comment')->nullable();

            $table->text('sentToAdmin1_by')->nullable();
            $table->text('sentToAdmin1_on')->nullable();
            $table->longText('sentToAdmin1_comment')->nullable();

            $table->text('pendingQueryReviewToOpened_by')->nullable();
            $table->text('pendingQueryReviewToOpened_on')->nullable();
            $table->longText('pendingQueryReviewToOpened_comment')->nullable();

            $table->text('pendingAckToPendingQuery_by')->nullable();
            $table->text('pendingAckToPendingQuery_on')->nullable();
            $table->longText('pendingAckToPendingQuery_comment')->nullable();

            $table->text('pendingHodToPendingAck_by')->nullable();
            $table->text('pendingHodToPendingAck_on')->nullable();
            $table->longText('pendingHodToPendingAck_comment')->nullable();

            $table->text('pendingCftToPendingHod_by')->nullable();
            $table->text('pendingCftToPendingHod_on')->nullable();
            $table->longText('pendingCftToPendingHod_comment')->nullable();

            $table->text('pendingAdmin1ToAdmin2_by')->nullable();
            $table->text('pendingAdmin1ToAdmin2_on')->nullable();
            $table->longText('pendingAdmin1ToAdmin2_comment')->nullable();

            $table->text('pendingResponseToAdmin1_by')->nullable();
            $table->text('pendingResponseToAdmin1_on')->nullable();
            $table->longText('pendingResponseToAdmin1_comment')->nullable();

            $table->text('submissionCompleted_by')->nullable();
            $table->text('submissionCompleted_on')->nullable();
            $table->longText('submissionCompleted_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('query_managements', function (Blueprint $table) {
            //
        });
    }
};
