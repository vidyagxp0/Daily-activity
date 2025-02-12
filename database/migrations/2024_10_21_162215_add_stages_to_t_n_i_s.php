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
        Schema::table('t_n_i_s', function (Blueprint $table) {
            $table->text('submitted_by')->nullable();
            $table->text('submitted_on')->nullable();
            $table->longText('submitted_comment')->nullable();

            $table->text('cancelled_by')->nullable();
            $table->text('cancelled_on')->nullable();
            $table->longText('cancelled_comment')->nullable();
            
            $table->text('reviewed_by')->nullable();
            $table->text('reviewed_on')->nullable();
            $table->longText('reviewed_comment')->nullable();

            $table->text('approved_by')->nullable();
            $table->text('approved_on')->nullable();
            $table->longText('approved_comment')->nullable();

            $table->text('approvalToReview_by')->nullable();
            $table->text('approvalToReview_on')->nullable();
            $table->longText('approvalToReview_comment')->nullable();

            $table->text('inReviewToOpened_by')->nullable();
            $table->text('inReviewToOpened_on')->nullable();
            $table->longText('inReviewToOpened_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_n_i_s', function (Blueprint $table) {
            //
        });
    }
};
