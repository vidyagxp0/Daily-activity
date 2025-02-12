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
        Schema::create('scorms', function (Blueprint $table)
        {
            $table->id();
            $table->string('initiator_name')->nullable();
            $table->text('initiation_date_new')->nullable();
            $table->text('scorm_id')->nullable();
            $table->longtext('short_description')->nullable();
            $table->text('extention_attachment')->nullable();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scorms');
    }
};
