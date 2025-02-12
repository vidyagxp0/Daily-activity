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
        Schema::create('sample_management_audits', function (Blueprint $table) {
            $table->id();

            $table->longtext('samplemanagement_id')->nullable();
            $table->longtext('activity_type')->nullable();
            $table->longText('previous')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->longtext('stage')->nullable();
            $table->longtext('user_id')->nullable();
            $table->longtext('user_name')->nullable();
            $table->longtext('origin_state')->nullable();
            $table->longtext('user_role')->nullable();
            $table->longtext('change_to')->nullable();
            $table->longtext('change_from')->nullable();
            $table->longtext('action')->nullable();
            $table->longtext('action_name')->nullable();
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
        Schema::dropIfExists('sample_management_audits');
    }
};
