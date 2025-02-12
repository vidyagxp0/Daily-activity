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
        Schema::table('sample_plannings', function (Blueprint $table) {
            $table->text('sample_registration_on')->nullable();
            $table->text('sample_registration_by')->nullable();
            $table->longText('sample_registration_comment')->nullable();

            $table->text('analysis_complete_on')->nullable();
            $table->text('analysis_complete_by')->nullable();
            $table->longText('analysis_complete_comment')->nullable();

            $table->text('supervisor_review_on')->nullable();
            $table->text('supervisor_review_by')->nullable();
            $table->longText('supervisor_review_comment')->nullable();

            $table->text('QA_Review_on')->nullable();
            $table->text('QA_Review_by')->nullable();
            $table->longText('QA_Review_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sample_plannings', function (Blueprint $table) {
            //
        });
    }
};
