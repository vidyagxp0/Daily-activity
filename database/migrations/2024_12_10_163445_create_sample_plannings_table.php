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
        Schema::create('sample_plannings', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->text('parent_type')->nullable();
            $table->integer('record')->nullable();
            $table->text('due_date')->nullable();
            $table->text('form_type')->nullable();
            $table->integer('division_id')->nullable();
            $table->longText('short_description')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->longText('initiated_through')->nullable();
            $table->text('intiation_date')->nullable();
            $table->integer('stage')->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('sample_plannings');
    }
};
