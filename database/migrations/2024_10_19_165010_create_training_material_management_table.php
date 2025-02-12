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
        Schema::create('training_material_management', function (Blueprint $table) {
            $table->id();
            $table->string('TMM_id')->nullable();
            $table->string('site_division')->nullable();
            $table->string('form_type')->nullable();
            $table->string('stage')->nullable();
            $table->string('traning_material_id')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('Type_of_Material')->nullable();
            $table->string('Instructor')->nullable();
            $table->string('version_num')->nullable();
            $table->string('Creation_date')->nullable();
            $table->string('last_updated_date')->nullable();
            $table->string('Keywords')->nullable();
            $table->string('Training_Category')->nullable();
            $table->string('training_duration')->nullable();
            $table->string('regulatory_requirement')->nullable();
            $table->string('revision_history')->nullable();
            $table->string('review_frequency')->nullable();
            $table->string('approver')->nullable();
            $table->longText('Supporting_Documents')->nullable();
            $table->string('external_links')->nullable();
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
        Schema::dropIfExists('training_material_management');
    }
};
