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
        Schema::create('sample_stabilities', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('division_id')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('intiation_date')->nullable();
            $table->string('due_date')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('short_desc')->nullable();
            $table->string('Initiator_Group')->nullable();
            $table->string('initiator_group_code')->nullable();
            $table->integer('assign_to')->nullable();
            $table->text('status')->nullable();
            $table->integer('stage')->nullable();
            $table->text('samplePlanId')->nullable();
            $table->text('sampleId')->nullable();
            $table->longtext('sampleName')->nullable();
            $table->longtext('sampleType')->nullable();
            $table->longtext('productMaterialName')->nullable();
            $table->longtext('batchLotNumber')->nullable();
            $table->longtext('samplePriority')->nullable();
            $table->integer('sampleQuantity')->nullable();
            $table->string('UOM')->nullable();
            $table->longtext('market')->nullable();
            $table->longtext('sampleBarCode')->nullable();
            $table->longtext('specificationId')->nullable();
            $table->longtext('specification_attachment')->nullable();
            $table->longtext('stpId')->nullable();
            $table->longtext('stp_attachment')->nullable();
            $table->longtext('testName')->nullable();
            $table->longtext('testMethod')->nullable();
            $table->longtext('testParameter')->nullable();
            $table->longtext('testingFrequency')->nullable();
            $table->longtext('testingLocation')->nullable();
            $table->longtext('requiredInstrument')->nullable();
            $table->longtext('testGrouping')->nullable();
            $table->integer('lsl')->nullable();
            $table->integer('usl')->nullable();
            $table->longtext('labTechnician')->nullable();
            $table->longtext('sampleCostEstimation')->nullable();
            $table->longtext('resourceUtilization')->nullable();
            $table->longtext('assignedDepartmentII')->nullable();
            $table->longtext('testGrouping_ii')->nullable();
            $table->longtext('sampleCollectionDate')->nullable();
            $table->longtext('suupportive_attachment_gi')->nullable();
            $table->longtext('analysisType')->nullable();
            $table->longtext('analysisResult')->nullable();
            $table->date('analysisDate')->nullable();
            $table->date('testingStartDate')->nullable();
            $table->date('testingEndDate')->nullable();
            $table->longtext('delayJustification')->nullable();
            $table->longtext('testingOutCome')->nullable();
            $table->longtext('passFail')->nullable();
            $table->longtext('testPlanId')->nullable();
            $table->integer('turnAroundTime')->nullable();
            $table->date('sampleRetestingDate')->nullable();
            $table->date('reviewDate')->nullable();
            $table->longtext('sampleStorageLocation')->nullable();
            $table->longtext('transportationMethod')->nullable();
            $table->longtext('samplePreparationMethod')->nullable();
            $table->longtext('samplePackagingDetail')->nullable();
            $table->longtext('sampleLabel')->nullable();
            $table->longtext('regulatoryRequirement')->nullable();
            $table->longtext('qualityControlCheck')->nullable();
            $table->longtext('controlSampleReference')->nullable();
            $table->longtext('referencesample')->nullable();
            $table->longtext('controlSample')->nullable();
            $table->longtext('sampleIntegrityStatus')->nullable();
            $table->longtext('assignedDepartment')->nullable();
            $table->text('riskAssessment')->nullable();
            $table->text('supervisor')->nullable();
            $table->text('instruments_reserved')->nullable();
            $table->longtext('lab_availability')->nullable();
            $table->date('sample_date')->nullable();
            $table->longtext('sample_movement_history')->nullable();
            $table->longtext('testing_progress')->nullable();
            $table->text('deviation_logs')->nullable();
            $table->longtext('commentNotes')->nullable();
            $table->longtext('analysis_attachment')->nullable();
            $table->longtext('samplingFrequency')->nullable();
            $table->longtext('sampleDisposition')->nullable();
            $table->longtext('supportive_attachment')->nullable();

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
        Schema::dropIfExists('sample_stabilities');
    }
};
