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
        Schema::create('global_change_controls_cfts', function (Blueprint $table) {
            $table->id();
            $table->string('cc_id');
            $table->text('Production_Review')->nullable();
            $table->text('Production_person')->nullable();
            $table->longtext('Production_assessment')->nullable();
            $table->longtext('Production_feedback')->nullable();
            $table->string('production_attachment')->nullable();
            $table->text('Production_by')->nullable();
            $table->date('production_on')->nullable();

            $table->text('Warehouse_review')->nullable();
            $table->text('Warehouse_person')->nullable();
            $table->longtext('Warehouse_assessment')->nullable();
            $table->longtext('Warehouse_feedback')->nullable();
            $table->string('Warehouse_attachment')->nullable();
            $table->text('Warehouse_by')->nullable();
            $table->date('Warehouse_on')->nullable();

            $table->text('Quality_review')->nullable();
            $table->text('Quality_Control_Person')->nullable();
            $table->longtext('Quality_Control_assessment')->nullable();
            $table->longtext('Quality_Control_feedback')->nullable();
            $table->string('Quality_Control_attachment')->nullable();
            $table->text('Quality_Control_by')->nullable();
            $table->date('Quality_Control_on')->nullable();

            $table->text('Quality_Assurance_Review')->nullable();
            $table->text('QualityAssurance_person')->nullable();
            $table->longtext('QualityAssurance_assessment')->nullable();
            $table->longtext('QualityAssurance_feedback')->nullable();
            $table->string('Quality_Assurance_attachment')->nullable();
            $table->text('QualityAssurance_by')->nullable();
            $table->date('QualityAssurance_on')->nullable();

            $table->text('Engineering_review')->nullable();
            $table->text('Engineering_person')->nullable();
            $table->longtext('Engineering_assessment')->nullable();
            $table->longtext('Engineering_feedback')->nullable();
            $table->string('Engineering_attachment')->nullable();
            $table->text('Engineering_by')->nullable();
            $table->date('Engineering_on')->nullable();

            $table->text('Human_Resource_review')->nullable();
            $table->text('Human_Resource_person')->nullable();
            $table->longtext('Human_Resource_assessment')->nullable();
            $table->longtext('Human_Resource_feedback')->nullable();
            $table->longtext('Human_Resource_attachment')->nullable();
            $table->string('Human_Resource_by')->nullable();
            $table->date('Human_Resource_on')->nullable();

            $table->text('Other1_review')->nullable();
            $table->text('Other1_person')->nullable();
            $table->text('Other1_Department_person')->nullable();
            $table->longtext('Other1_assessment')->nullable();
            $table->longtext('Other1_feedback')->nullable();
            $table->string('Other1_attachment')->nullable();
            $table->text('Other1_by')->nullable();
            $table->date('Other1_on')->nullable();

            $table->text('Other2_review')->nullable();
            $table->text('Other2_person')->nullable();
            $table->text('Other2_Department_person')->nullable();
            $table->longtext('Other2_Assessment')->nullable();
            $table->longtext('Other2_feedback')->nullable();
            $table->string('Other2_attachment')->nullable();
            $table->text('Other2_by')->nullable();
            $table->date('Other2_on')->nullable();

            $table->text('Other3_review')->nullable();
            $table->text('Other3_person')->nullable();
            $table->text('Other3_Department_person')->nullable();
            $table->longtext('Other3_Assessment')->nullable();
            $table->longtext('Other3_feedback')->nullable();
            $table->string('Other3_attachment')->nullable();
            $table->text('Other3_by')->nullable();
            $table->date('Other3_on')->nullable();

            $table->text('Other4_review')->nullable();
            $table->text('Other4_person')->nullable();
            $table->string('Other4_Department_person')->nullable();
            $table->longtext('Other4_Assessment')->nullable();
            $table->longtext('Other4_feedback')->nullable();
            $table->string('Other4_attachment')->nullable();
            $table->text('Other4_by')->nullable();
            $table->date('Other4_on')->nullable();

            $table->text('Other5_review')->nullable();
            $table->text('Other5_person')->nullable();
            $table->string('Other5_Department_person')->nullable();
            $table->longtext('Other5_Assessment')->nullable();
            $table->longtext('Other5_feedback')->nullable();
            $table->string('Other5_attachment')->nullable();
            $table->text('Other5_by')->nullable();
            $table->date('Other5_on')->nullable();

            $table->text('CQA_Review')->nullable();
            $table->text('CQA_person')->nullable();
            $table->longtext('CQA_comment')->nullable();
            $table->text('CQA_attachment')->nullable();
            $table->text('CQA_by')->nullable();
            $table->date('CQA_on')->nullable();

            $table->text('SystemIT_Review')->nullable();
            $table->text('SystemIT_person')->nullable();
            $table->longtext('SystemIT_comment')->nullable();
            $table->text('SystemIT_attachment')->nullable();
            $table->text('SystemIT_by')->nullable();
            $table->date('SystemIT_on')->nullable();
            
            $table->longtext('RA_attachment_second')->nullable();

            $table->text('ResearchDevelopment_Review')->nullable();
            $table->text('ResearchDevelopment_Comments')->nullable();
            $table->text('ResearchDevelopment_person')->nullable();
            $table->longtext('ResearchDevelopment_assessment')->nullable();
            $table->longtext('ResearchDevelopment_feedback')->nullable();
            $table->string('ResearchDevelopment_attachment')->nullable();
            $table->text('ResearchDevelopment_by')->nullable();
            $table->date('ResearchDevelopment_on')->nullable();

            $table->text('Microbiology_Review')->nullable();
            $table->text('Microbiology_Comments')->nullable();
            $table->text('Microbiology_person')->nullable();
            $table->longtext('Microbiology_assessment')->nullable();
            $table->longtext('Microbiology_feedback')->nullable();
            $table->string('Microbiology_attachment')->nullable();
            $table->text('Microbiology_by')->nullable();
            $table->date('Microbiology_on')->nullable();

            $table->text('RegulatoryAffair_Review')->nullable();
            $table->text('RegulatoryAffair_Comments')->nullable();
            $table->text('RegulatoryAffair_person')->nullable();
            $table->longtext('RegulatoryAffair_assessment')->nullable();
            $table->longtext('RegulatoryAffair_feedback')->nullable();
            $table->string('RegulatoryAffair_attachment')->nullable();
            $table->text('RegulatoryAffair_by')->nullable();
            $table->date('RegulatoryAffair_on')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_change_controls_cfts');
    }
};
