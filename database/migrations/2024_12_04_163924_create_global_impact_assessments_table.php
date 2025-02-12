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
        Schema::create('global_impact_assessments', function (Blueprint $table) {
            $table->id();
            $table->integer('cc_id')->nullable();
            for ($i = 1; $i <= 33; $i++) {
                $table->text('remark_que' . $i)->nullable();
            }
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
        Schema::dropIfExists('global_impact_assessments');
    }
};
