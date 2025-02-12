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
        Schema::table('global_change_controls', function (Blueprint $table) {
            $table->text('RA_data_person')->nullable();
            $table->integer('QA_CQA_person')->nullable();
            $table->longText('qa_final_comments')->nullable();
            $table->longText('qa_final_attach1')->nullable();
            $table->longText('intial_update_comments')->nullable();
            $table->longText('hod_final_review_comment')->nullable();
            $table->longText('implementation_verification_comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('global_change_controls', function (Blueprint $table) {
            //
        });
    }
};
