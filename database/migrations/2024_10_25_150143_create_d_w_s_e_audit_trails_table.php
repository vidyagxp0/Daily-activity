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
        Schema::create('d_w_s_e_audit_trails', function (Blueprint $table) {
            $table->string('dwse_id')->nullable();
            $table->string('activity_type')->nullable();
            $table->longText('previous')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('origin_state')->nullable();
            $table->string('user_role')->nullable();
            $table->string('change_to')->nullable();
            $table->string('change_from')->nullable();
            $table->string('action_name')->nullable();
            $table->string('action')->nullable();
             $table->string('stage')->nullable();
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
        Schema::dropIfExists('d_w_s_e_audit_trails');
    }
};
