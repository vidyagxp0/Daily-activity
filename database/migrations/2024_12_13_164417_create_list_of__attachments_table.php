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
        // Schema::create('list_of__attachments', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('trainer_qualification_id')->nullable();
        //     $table->text('title_of_document')->nullable();
        //     $table->longText('supporting_document')->nullable();
        //     $table->longText('remarks')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('list_of__attachments');
    }
};
