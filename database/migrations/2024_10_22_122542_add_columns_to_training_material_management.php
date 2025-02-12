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
        Schema::table('training_material_management', function (Blueprint $table) {

            $table->string('Create_Training_Material_by')->nullable();
            $table->string('Create_Training_Material_on')->nullable();
            $table->longText('Create_Training_Material_comment')->nullable();
            $table->string('Training_Material_Created_by')->nullable();
            $table->string('Training_Material_Created_on')->nullable();
            $table->longText('Training_Material_Created_comment')->nullable();
            $table->string('HOD_Review_Complete_by')->nullable();
            $table->string('HOD_Review_Complete_on')->nullable();
            $table->longText('HOD_Review_Complete_comment')->nullable();
            $table->string('Complete_by')->nullable();
            $table->string('Complete_on')->nullable();
            $table->longText('Complete_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_material_management', function (Blueprint $table) {
            //
        });
    }
};
