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
        Schema::table('receipts', function (Blueprint $table) {
            $table->text('review_1_person')->nullable();
            $table->text('review_2_person')->nullable();
            $table->text('approver_person')->nullable();

            $table->longtext('Sample_at_ipc_Comment')->nullable();
            $table->longtext('Sample_at_ipc_attachment')->nullable();
            $table->longtext('Sample_coordinator_Comment')->nullable();
            $table->longtext('Sample_coordinator_attachment')->nullable();
            $table->longtext('sample_analysis_Comment')->nullable();
            $table->longtext('sample_analysis_attachment')->nullable();            
            $table->longtext('related_substance_Comment')->nullable();
            $table->longtext('related_substance_attachment')->nullable();
            $table->longtext('assay_analysis_Comment')->nullable();
            $table->longtext('assay_analysis_attachment')->nullable();
            $table->longtext('dissolution_analysis_Comment')->nullable();
            $table->longtext('dissolution_analysis_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            //
        });
    }
};
