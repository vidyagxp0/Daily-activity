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
        Schema::create('risk_management_activities', function (Blueprint $table) {
            $table->id();

            $table->string('risk_id')->nullable();

            $table->string('more_info_required_by')->nullable();
            $table->string('more_info_required_on')->nullable();
            $table->longText('more_info_required_comment')->nullable();

            $table->string('reject_action_plan_by')->nullable();
            $table->string('reject_action_plan_on')->nullable();
            $table->longText('reject_action_plan_comment')->nullable();

            $table->string('request_more_information_by')->nullable();
            $table->string('request_more_information_on')->nullable();
            $table->longText('request_more_information_comment')->nullable();

            $table->string('request_more_info_by')->nullable();
            $table->string('request_more_info_on')->nullable();
            $table->longText('request_more_info_comment')->nullable();

            $table->string('more_actions_needed_by')->nullable();
            $table->string('more_actions_needed_on')->nullable();
            $table->longText('more_actions_needed_comment')->nullable();

            $table->string('risk_cancelled_by')->nullable();
            $table->string('risk_cancelled_on')->nullable();
            $table->longText('risk_cancelled_comment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risk_management_activities');
    }
};
