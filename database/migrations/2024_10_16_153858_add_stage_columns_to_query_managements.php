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
            $table->text('submitted_by')->nullable();
            $table->text('submitted_on')->nullable();
            $table->longText('submitted_comment')->nullable();

            $table->text('cancelled_by')->nullable();
            $table->text('cancelled_on')->nullable();
            $table->longText('cancelled_comment')->nullable();

            $table->text('queryReviewCompleted_by')->nullable();
            $table->text('queryReviewCompleted_on')->nullable();
            $table->longText('queryReviewCompleted_comment')->nullable();

            $table->text('AcknowledgementCompleted_by')->nullable();
            $table->text('AcknowledgementCompleted_on')->nullable();
            $table->longText('AcknowledgementCompleted_comment')->nullable();

            $table->text('Admin2Completed_by')->nullable();
            $table->text('Admin2Completed_on')->nullable();
            $table->longText('Admin2Completed_comment')->nullable();

            $table->text('cftRequired_by')->nullable();
            $table->text('cftRequired_on')->nullable();
            $table->longText('cftRequired_comment')->nullable();

            $table->text('cftNotRequired_by')->nullable();
            $table->text('cftNotRequired_on')->nullable();
            $table->longText('cftNotRequired_comment')->nullable();

            $table->text('cftCompleted_by')->nullable();
            $table->text('cftCompleted_on')->nullable();
            $table->longText('cftCompleted_comment')->nullable();

            $table->text('Admin2UpdateComplete_by')->nullable();
            $table->text('Admin2UpdateComplete_on')->nullable();
            $table->longText('Admin2UpdateComplete_comment')->nullable();

            $table->text('Admin1UpdateComplete_by')->nullable();
            $table->text('Admin1UpdateComplete_on')->nullable();
            $table->longText('Admin1UpdateComplete_comment')->nullable();

            $table->text('responseSent_by')->nullable();
            $table->text('responseSent_on')->nullable();
            $table->longText('responseSent_comment')->nullable();

            $table->text('pendingAcknowledgementComplete_by')->nullable();
            $table->text('pendingAcknowledgementComplete_on')->nullable();
            $table->longText('pendingAcknowledgementComplete_comment')->nullable();

            $table->text('reopen_by')->nullable();
            $table->text('reopen_on')->nullable();
            $table->longText('reopen_comment')->nullable();
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
