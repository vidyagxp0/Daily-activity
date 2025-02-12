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
            $table->text('pendingQAToPendingSupervisor_by')->nullable();
            $table->text('pendingQAToPendingSupervisor_on')->nullable();
            $table->longText('pendingQAToPendingSupervisor_comment')->nullable();

            $table->text('pendingSupervisorToPendingAnalysis_by')->nullable();
            $table->text('pendingSupervisorToPendingAnalysis_on')->nullable();
            $table->longText('pendingSupervisorToPendingAnalysis_comment')->nullable();

            $table->text('pendingAnalysisToOpened_by')->nullable();
            $table->text('pendingAnalysisToOpened_on')->nullable();
            $table->longText('pendingAnalysisToOpened_comment')->nullable();
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
