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
        Schema::create('t_n_i_employees', function (Blueprint $table) {
            $table->id();
            $table->text('employee_name')->nullable();
            $table->text('employee_code')->nullable();
            $table->text('department')->nullable();
            $table->text('designation')->nullable();
            $table->text('job_role')->nullable();
            $table->string('joining_date')->nullable();
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
        Schema::dropIfExists('t_n_i_employees');
    }
};
