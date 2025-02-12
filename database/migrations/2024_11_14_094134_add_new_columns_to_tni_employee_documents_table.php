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
        Schema::table('tni_employee_documents', function (Blueprint $table) {
            $table->boolean('training_effective')->default(false);
            $table->integer('attempt_count')->default(3); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tni_employee_documents', function (Blueprint $table) {
            //
        });
    }
};
