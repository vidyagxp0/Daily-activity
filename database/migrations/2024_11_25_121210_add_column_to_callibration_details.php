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
        Schema::table('callibration_details', function (Blueprint $table) {
            $table->text('Imp_review_comm')->nullable();
            $table->text('Implementor_Attachment')->nullable();
            $table->text('qa_rev_comm')->nullable();
            $table->text('qa_rev_attachment')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('callibration_details', function (Blueprint $table) {
            //
        });
    }
};
