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
        Schema::create('department_document_numbers', function (Blueprint $table) {
            $table->id();
            $table->integer('department_employee_id')->nullable();
            $table->longtext('location')->nullable();
            $table->longtext('Prepared_by')->nullable();
            $table->date('Prepared_date')->nullable();
            $table->longtext('reviewer')->nullable();
            $table->longtext('approver')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longtext('department')->nullable();
            $table->longtext('document_number')->nullable();
            $table->integer('year')->nullable();
            $table->longtext('employee_name')->nullable();
            $table->longtext('employee_code')->nullable();
            $table->longtext('job_role')->nullable();
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
        Schema::dropIfExists('department_document_numbers');
    }
};
