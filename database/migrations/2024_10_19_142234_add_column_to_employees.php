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
        Schema::table('employees', function (Blueprint $table) {
            $table->text('date_of_birth')->nullable();
            $table->text('nationality')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('address_one')->nullable();
            $table->text('street_one')->nullable();
            $table->text('postal_code_one')->nullable();
            $table->text('employee_type')->nullable();
            $table->text('employee_status')->nullable();
            $table->text('address_two')->nullable();
            $table->text('street_two')->nullable();
            $table->text('city_two')->nullable();
            $table->text('state_two')->nullable();
            $table->text('country_two')->nullable();
            $table->text('postal_code_two')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
