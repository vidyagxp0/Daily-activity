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
        Schema::create('task_management', function (Blueprint $table) {
            $table->id();
            $table->text('initiator_id')->nullable();
            $table->text('intiation_date')->nullable();
            $table->text('record')->nullable();
            $table->text('record_number')->nullable();
            $table->longText('short_description')->nullable();
            $table->text('status')->nullable();
            $table->text('stage')->nullable();
            $table->text('form_type')->nullable();
            $table->string('submit_by')->nullable();
            $table->string('submit_on')->nullable();
            $table->longText('submit_comment')->nullable();

            $table->string('reviewed_by')->nullable();
            $table->string('reviewed_on')->nullable();
            $table->longText('reviewed_comment')->nullable();

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
        Schema::dropIfExists('task_management');
    }
};
