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
        Schema::create('change_control_stage_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('cc_id')->nullable();
            $table->text('implementationToHODFinalBy')->nullable();
            $table->text('implementationToHODFinalOn')->nullable();
            $table->longText('implementationToHODFinalComment')->nullable();
            $table->text('HodFinalToPendingInitiatorBy')->nullable();
            $table->text('HodFinalToPendingInitiatorOn')->nullable();
            $table->longText('HodFinalToPendingInitiatorComment')->nullable();
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
        Schema::dropIfExists('change_control_stage_comments');
    }
};
