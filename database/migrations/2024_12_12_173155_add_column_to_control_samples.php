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
        Schema::table('control_samples', function (Blueprint $table) {
            $table->string('submit_by')->nullable();
            $table->string('submit_on')->nullable();
            $table->longtext('submit_comment')->nullable();
            $table->string('more_info_by')->nullable();
            $table->string('more_info_on')->nullable();
            $table->longtext('more_info_comment')->nullable();
            $table->string('control_sample_insp_by')->nullable();
            $table->string('control_sample_insp_on')->nullable();
            $table->longtext('control_sample_ins_comment')->nullable();
            $table->string('distraction_complete_by')->nullable();
            $table->string('distraction_complete_on')->nullable();
            $table->longtext('distraction_complete_comment')->nullable();
            $table->string('more_info_second_by')->nullable();
            $table->string('more_info_second_on')->nullable();
            $table->longtext('more_info_second_comment')->nullable();
            $table->text('data_extra')->nullable();
            $table->text('data_extra_more')->nullable();
            $table->longtext('data_extra_second')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('control_samples', function (Blueprint $table) {
            //
        });
    }
};
