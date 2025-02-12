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
        Schema::table('risk_management', function (Blueprint $table) {
            $table->longText('submitted_comment')->nullable();
            $table->longText('evaluated_comment')->nullable();
            $table->string('plan_complete_by')->nullable();
            $table->string('plan_complete_on')->nullable();
            $table->longText('plan_complete_comment')->nullable();
            $table->longText('plan_approved_comment')->nullable();
            $table->string('actions_completed_by')->nullable();
            $table->string('actions_completed_on')->nullable();
            $table->longText('actions_completed_comment')->nullable();
            $table->longText('risk_analysis_completed_comment')->nullable();
            $table->longText('cancelled_comment')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_management', function (Blueprint $table) {
            //
        });
    }
};
