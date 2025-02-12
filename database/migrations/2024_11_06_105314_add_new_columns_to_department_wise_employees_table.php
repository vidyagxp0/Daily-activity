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
        Schema::table('department_wise_employees', function (Blueprint $table) {
            $table->longtext('reviewer_remark')->nullable();
            $table->longtext('approval_remark')->nullable();
            $table->longtext('reviewer_remark_attachment')->nullable();
            $table->longtext('approval_remark_attachment')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_wise_employees', function (Blueprint $table) {
            //
        });
    }
};
