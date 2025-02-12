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
        Schema::table('audit_programs', function (Blueprint $table) {
            $table->longText('submitted_comment')->nullable();
            $table->longText('approved_comment')->nullable();
            $table->longText('Audit_Completed_comment')->nullable();
            $table->longText('cancel_1_comment')->nullable();
            $table->longText('cancel_2_comment')->nullable();
            $table->longText('Reject_comment')->nullable();
            $table->longText('Reject_comment_1')->nullable();
            $table->longText('Reject_comment_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_programs', function (Blueprint $table) {
            //
        });
    }
};
