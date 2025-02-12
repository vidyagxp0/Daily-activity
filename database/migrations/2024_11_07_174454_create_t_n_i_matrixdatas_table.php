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
        Schema::create('t_n_i_matrixdatas', function (Blueprint $table) {
            $table->id();
            $table->longtext('tni_id')->nullable();
            $table->string('division')->nullable();
            $table->boolean('training_effective')->default(false);
            $table->integer('attempt_count')->default(3); 
            $table->longtext('training_completion')->nullable();
            $table->longtext('documentNumber')->nullable();
            $table->longtext('designation')->nullable();
            $table->longtext('department')->nullable();
            $table->longtext('employee')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
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
        Schema::dropIfExists('t_n_i_matrixdatas');
    }
};
