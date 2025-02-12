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
        Schema::table('notifications', function (Blueprint $table) {
            $table->text('process_name')->after('to_id')->nullable();
            $table->integer('division_id')->after('process_name')->nullable();
            $table->longText('short_description')->after('division_id')->nullable();
            $table->integer('initiator_id')->after('short_description')->nullable();
            $table->text('due_date')->after('initiator_id')->nullable();
            $table->integer('record')->after('due_date')->nullable();
            $table->text('site')->after('record')->nullable();
            $table->text('comment')->after('site')->nullable();
            $table->text('status')->after('comment')->nullable();
            $table->integer('stage')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            //
        });
    }
};
