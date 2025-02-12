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
            $table->longtext('submitted_by')->nullable();
            $table->longtext('submitted_on')->nullable();
            $table->longtext('submitted_comment')->nullable();
            $table->longtext('analysis_complete_by')->nullable();
            $table->longtext('analysis_complete_on')->nullable();
            $table->longtext('analysis_complete_comment')->nullable();
            $table->longtext('supervisor_review_complete_by')->nullable();
            $table->longtext('supervisor_review_complete_on')->nullable();
            $table->longtext('supervisor_review_complete_comment')->nullable();
            $table->longtext('closed_done_by')->nullable();
            $table->longtext('closed_done_on')->nullable();
            $table->longtext('closed_done_comment')->nullable();
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
