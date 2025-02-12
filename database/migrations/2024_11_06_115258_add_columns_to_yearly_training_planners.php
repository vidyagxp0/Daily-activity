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
        Schema::table('yearly_training_planners', function (Blueprint $table) {
            $table->text('Review_Comment')->nullable();
            $table->longText('Review_Attachments')->nullable();
            $table->text('Approval_Comment')->nullable();
            $table->longText('Approval_Attachments')->nullable();
            $table->string('Cancel_by')->nullable();
            $table->string('Cancel_on')->nullable();
            $table->longText('Cancel_comment')->nullable();
            $table->string('Review_info_require_by')->nullable();
            $table->string('Review_info_require_on')->nullable();
            $table->longText('Review_info_require_comment')->nullable();
            $table->string('More_info_require_by')->nullable();
            $table->string('More_info_require_on')->nullable();
            $table->longText('More_info_require_comment')->nullable();
            $table->string('More_info_by')->nullable();
            $table->string('More_info_on')->nullable();
            $table->longText('More_info_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yearly_training_planners', function (Blueprint $table) {
            //
        });
    }
};
