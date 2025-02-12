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
        Schema::create('attachment_grids', function (Blueprint $table) {
            $table->id();
            $table->text('doc_name_IQ')->nullable();
            $table->text('doc_id_IQ')->nullable();
            $table->longText('doc_remark_IQ')->nullable();

            $table->text('doc_name_DQ')->nullable();
            $table->text('doc_id_DQ')->nullable();
            $table->longText('doc_remark_DQ')->nullable();

            $table->text('doc_name_OQ')->nullable();
            $table->text('doc_id_OQ')->nullable();
            $table->longText('doc_remark_OQ')->nullable();

            $table->text('doc_name_PQ')->nullable();
            $table->text('doc_id_PQ')->nullable();
            $table->longText('doc_remark_PQ')->nullable();
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
        Schema::dropIfExists('attachment_grids');
    }
};
