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
        Schema::create('change_control_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('cc_id')->nullable();
            $table->longText('type_of_change')->nullable();
            $table->longText('impact_operations')->nullable();
            $table->longText('impact_product_quality')->nullable();
            $table->longText('regulatory_impact')->nullable();
            $table->longText('risk_level')->nullable();
            $table->longText('validation_requirment')->nullable();
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
        Schema::dropIfExists('change_control_fields');
    }
};
