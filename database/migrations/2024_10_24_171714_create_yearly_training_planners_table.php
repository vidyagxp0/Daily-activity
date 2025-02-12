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
        Schema::create('yearly_training_planners', function (Blueprint $table) {
            $table->id();
            $table->integer('initiator_id')->nullable();
            $table->text('initiation_date')->nullable();
            $table->text('site_division')->nullable();
            $table->text('department')->nullable();
            $table->text('year')->nullable();
            $table->text('topic')->nullable();
            $table->text('document_number')->nullable();
            $table->text('start_date')->nullable();
            $table->text('end_date')->nullable();
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
        Schema::dropIfExists('yearly_training_planners');
    }
};
