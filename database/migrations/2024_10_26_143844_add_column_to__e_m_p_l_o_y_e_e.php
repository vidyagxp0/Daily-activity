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
            $table->text('addressNew')->nullable();            
            $table->text('streetNew')->nullable();

        });

        Schema::table('t_n_i_s', function (Blueprint $table) {
            $table->text('department_code')->nullable();            
            $table->text('department')->nullable();            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_e_m_p_l_o_y_e_e', function (Blueprint $table) {
            //
        });
    }
};
