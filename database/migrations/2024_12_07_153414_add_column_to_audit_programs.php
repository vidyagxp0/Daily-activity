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
            $table->string('cancel_second_on')->nullable();
            $table->string('cancel_second_by')->nullable();
            $table->string('cancel_third_on')->nullable();
            $table->string('cancel_third_by')->nullable();
            $table->string('cancel_on')->nullable();
            $table->string('cancel_by')->nullable();
            
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
