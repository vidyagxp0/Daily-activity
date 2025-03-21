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
        Schema::table('department_document_numbers', function (Blueprint $table) {
            $table->integer('total_minimum_time')->default(0);
            $table->integer('per_screen_run_time')->default(0);
            $table->integer('sop_spent_time')->default(0);
            $table->boolean('training_effective')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_document_numbers', function (Blueprint $table) {
            //
        });
    }
};
