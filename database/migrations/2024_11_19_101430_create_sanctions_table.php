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
        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            $table->text('sanction_id')->nullable();
            $table->text('initiator_id')->nullable();
            $table->text('division_id')->nullable();
            $table->text('division_code')->nullable();
            $table->text('intiation_date')->nullable();
            $table->text('status')->nullable();
            $table->text('stage')->nullable();
            $table->text('form_type')->nullable();
            $table->text('record')->nullable();
            $table->text('record_number')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('parent_type')->nullable();
            $table->text('assign_to')->nullable();
            $table->text('due_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->text('Type')->nullable();
            $table->longText('Attached_File')->nullable();
            $table->longText('Description')->nullable();
            $table->text('Authority_Type')->nullable();
            $table->text('Authority')->nullable();
            $table->text('Fine')->nullable();
            $table->text('Currency')->nullable();
            $table->text('Cancel_By')->nullable();
            $table->text('Cancel_On')->nullable();
            $table->longText('Cancel_Comment')->nullable();
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
        Schema::dropIfExists('sanctions');
    }
};
