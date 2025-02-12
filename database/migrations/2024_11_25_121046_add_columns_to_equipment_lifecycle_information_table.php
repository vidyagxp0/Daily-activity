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
        Schema::table('equipment_lifecycle_information', function (Blueprint $table) {
            $table->text('Training_required_by')->nullable();
            $table->text('Training_required_on')->nullable();
            $table->longText('Training_required_comment')->nullable();
            $table->text('Training_complete_by')->nullable();
            $table->text('Training_complete_on')->nullable();
            $table->longText('Training_complete_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment_information', function (Blueprint $table) {
            //
        });
    }
};
