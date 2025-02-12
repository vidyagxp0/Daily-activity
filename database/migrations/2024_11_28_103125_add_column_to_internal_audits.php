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
        Schema::table('internal_audits', function (Blueprint $table) {
            //
            $table->string('supproting_attachment')->nullable();
            $table->string('tablet_coating_supporting_attachment')->nullable();
            $table->string('dispensing_and_manufacturing_attachment')->nullable();
            $table->string('ointment_packing_attachment')->nullable();
            $table->string('engineering_response_attachment')->nullable();
            $table->string('quality_control_response_attachment')->nullable();
            $table->string('checklist_stores_response_attachment')->nullable();
            $table->string('checklist_hr_response_attachment')->nullable();
            $table->string('remark_injection_packing_attachment')->nullable();
            $table->string('remark_analytical_research_attachment')->nullable();
            $table->string('remark_powder_manufacturing_filling_attachment')->nullable();
            $table->string('remark_formulation_research_development_attachment')->nullable();
            $table->string('remark_documentation_name_attachment')->nullable();
            $table->string('tablet_capsule_packing_attachment')->nullable();
            $table->string('file_attach_add_2')->nullable();
            $table->string('file_attach_add_1')->nullable();
            $table->string('file_attach3')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_audits', function (Blueprint $table) {
            //
        });
    }
};
