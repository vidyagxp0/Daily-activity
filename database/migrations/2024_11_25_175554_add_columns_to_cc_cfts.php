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
        Schema::table('cc_cfts', function (Blueprint $table) {
            $table->text('Warehouse_person')->nullable();
            $table->longtext('Warehouse_comment')->nullable();
            $table->text('Warehouse_Change_in_Raw_Material')->nullable();
            $table->text('Warehouse_Change_in_Supplier_Vendor')->nullable();
            $table->text('Warehouse_Change_in_SOP_Procedure')->nullable();
            $table->text('Warehouse_Change_in_Packing_Material')->nullable();
            $table->text('Warehouse_Change_in_Specification_Labels')->nullable();
            $table->text('Warehouse_Change_in_Bill_of_Material_BOM')->nullable();
            $table->longtext('Warehouse_Any_Other_Specify')->nullable();

            $table->text('CQA_Review')->nullable();
            $table->text('CQA_person')->nullable();
            $table->longtext('CQA_comment')->nullable();
            $table->text('CQA_attachment')->nullable();
            $table->text('CQA_by')->nullable();
            $table->date('CQA_on')->nullable();

            $table->text('marketing_Review')->nullable();
            $table->text('marketing_person')->nullable();
            $table->longtext('marketing_comment')->nullable();
            $table->text('marketing_attachment')->nullable();
            $table->text('marketing_by')->nullable();
            $table->date('marketing_on')->nullable();

            $table->text('SystemIT_Review')->nullable();
            $table->text('SystemIT_person')->nullable();
            $table->longtext('SystemIT_comment')->nullable();
            $table->text('SystemIT_attachment')->nullable();
            $table->text('SystemIT_by')->nullable();
            $table->date('SystemIT_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cc_cfts', function (Blueprint $table) {
            //
        });
    }
};
