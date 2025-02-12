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
        Schema::table('sample_stabilities', function (Blueprint $table) {
            $table->longtext('reviewerApprover')->nullable();
            $table->text('reviewerComment')->nullable();
            $table->longtext('stabilityStudyType')->nullable();
            $table->longtext('selectDisposition')->nullable();
            $table->longtext('stabilityStudyProtocol')->nullable();
            $table->date('protocolApprovalDate')->nullable();
            $table->longtext('regulatoryCountry')->nullable();
            $table->integer('ichZone')->nullable();
            $table->text('photostabilityResults')->nullable();
            $table->text('reconstitutionStability')->nullable();
            $table->longtext('testingInterval')->nullable();
            $table->text('shelfLife')->nullable();
            $table->longtext('qaReviewerApprover')->nullable();
            $table->date('qaReviewDate')->nullable();
            $table->text('qaReviewerComment')->nullable();
            $table->longtext('initiatorName')->nullable();
            $table->date('dateOfInitiation')->nullable();
            $table->longtext('labTechnicianName')->nullable();
            $table->date('dateOfLabTechReview')->nullable();
            $table->longtext('supervisorName')->nullable();
            $table->date('dateOfSupervisionReview')->nullable();
            $table->text('qaReview')->nullable();
            $table->date('dateOfQaReview')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sample_stabilities', function (Blueprint $table) {
            //
        });
    }
};
