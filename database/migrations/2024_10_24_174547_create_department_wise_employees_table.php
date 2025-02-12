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
        Schema::create('department_wise_employees', function (Blueprint $table) {
            $table->id();
            $table->text('location')->nullable();
            $table->text('Prepared_by')->nullable();
            $table->date('Prepared_date')->nullable();
            $table->text('department')->nullable();
            $table->text('document_number')->nullable();
            $table->text('year')->nullable();
            $table->text('employee_name')->nullable();
            $table->text('employee_code')->nullable();
            $table->longText('job_role')->nullable();

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
        Schema::dropIfExists('department_wise_employees');
    }
};
