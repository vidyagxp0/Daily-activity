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
        Schema::table('sample_stabilities', function (Blueprint $table) {
            $table->integer('reviewer_approver')->nullable();
            $table->longText('reviewer_comment')->nullable();
            $table->date('review_date')->nullable();
            $table->longText('supervisor_attachment')->nullable();

            $table->integer('QA_reviewer_approver')->nullable();
            $table->longText('QA_reviewer_comment')->nullable();
            $table->date('QA_review_date')->nullable();
            $table->longText('QA_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sample_stabilities', function (Blueprint $table) {
            //
        });
    }
};
