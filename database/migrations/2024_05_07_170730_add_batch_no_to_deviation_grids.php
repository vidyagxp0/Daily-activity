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
        Schema::table('deviation_grids', function (Blueprint $table) {
            $table->longtext('product_name')->nullable()->after('Document_Remarks');
            $table->longtext('product_stage')->nullable()->after('product_name');
            $table->longtext('batch_no')->nullable()->after('product_stage');
            $table->longtext('product_remark')->nullable()->after('batch_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deviation_grids', function (Blueprint $table) {
            //
        });
    }
};
