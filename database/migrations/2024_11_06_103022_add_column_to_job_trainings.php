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
        Schema::table('job_trainings', function (Blueprint $table) {
            $table->longText('supporting_attachments1')->nullable();
            $table->longText('supporting_attachments2')->nullable();
            $table->longText('supporting_attachments3')->nullable();
            $table->longText('supporting_attachments4')->nullable();
            $table->longText('supporting_attachments5')->nullable();
            $table->integer('total_minimum_time')->default(0);
            $table->integer('per_screen_running_time')->default(0);
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_trainings', function (Blueprint $table) {
            //
        });
    }
};
