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
        Schema::create('calibration_audit_trails', function (Blueprint $table) {
            $table->id();
            $table->text('calibrationDetails_id');
            $table->text('activity_type')->nullable();
            $table->longText('previous')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->text('user_id')->nullable();
            $table->text('user_name')->nullable();
            $table->text('origin_state')->nullable();
            $table->text('user_role')->nullable();
            $table->text('stage')->nullable();
            $table->longText('change_to')->nullable();
            $table->longText('change_from')->nullable();
            $table->text('action_name')->nullable();
            $table->text('action')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('calibration_audit_trails');
    }
};
