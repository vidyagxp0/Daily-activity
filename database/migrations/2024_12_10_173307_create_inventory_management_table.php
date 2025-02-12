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
        Schema::create('inventory_management', function (Blueprint $table) {
            $table->id();
            $table->text('inventorymanagement_id')->nullable();
            $table->text('initiator_id')->nullable();
            $table->text('division_id')->nullable();
            $table->text('division_code')->nullable();
            $table->text('intiation_date')->nullable();
            $table->text('status')->nullable();
            $table->text('stage')->nullable();
            $table->text('form_type')->nullable();
            $table->text('record')->nullable();
            $table->text('record_number')->nullable();
            $table->text('parent_id')->nullable();
            $table->text('parent_type')->nullable();
            $table->text('assign_to')->nullable();
            $table->text('due_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->text('status_gi')->nullable();
            $table->text('reagent_name')->nullable();
            $table->text('reagent_code')->nullable();
            $table->text('cas_number')->nullable();
            $table->text('supplier_name')->nullable();
            $table->text('geade_purity')->nullable();
            $table->text('physical_form')->nullable();
            $table->longText('hazard_classification')->nullable();
            $table->text('manufacturer_name')->nullable();
            $table->longText('supplier_contact_info')->nullable();
            $table->text('supplier_lot_number')->nullable();
            $table->longText('certificate_of_analysis')->nullable();
            $table->date('usage_date')->nullable();
            $table->longText('purpose_of_use')->nullable();
            $table->text('quality_used')->nullable();
            $table->text('logged_by')->nullable();
            $table->text('storage_condition')->nullable();
            $table->text('container_type')->nullable();
            $table->text('shelf_life')->nullable();
            $table->text('handling_instructions')->nullable();
            $table->longText('safety_date_sheet')->nullable();
            $table->text('risk_assesment_code')->nullable();
            $table->text('disposal_guidelines')->nullable();
            $table->text('regualatory_info')->nullable();
            $table->text('submit_by')->nullable();
            $table->text('submit_on')->nullable();
            $table->text('submit_comments')->nullable();
            $table->text('Review_Complete_by')->nullable();
            $table->text('Review_Complete_on')->nullable();
            $table->text('Review_Complete_comment')->nullable();
            $table->text('Approval_Complete_by')->nullable();
            $table->text('Approval_Complete_on')->nullable();
            $table->text('Approval_Complete_comment')->nullable();
            $table->text('stock_transfer_by')->nullable();
            $table->text('stock_transfer_on')->nullable();
            $table->text('stock_transfer_comment')->nullable();
            $table->text('Cancel_By')->nullable();
            $table->text('Cancel_On')->nullable();
            $table->text('Cancel_Comment')->nullable();
            $table->text('Request_More_Info_by')->nullable();
            $table->text('Request_More_Info_on')->nullable();
            $table->text('Request_More_Info_comment')->nullable();
            $table->text('stock_transfer1_by')->nullable();
            $table->text('stock_transfer1_on')->nullable();
            $table->text('stock_transfer1_comment')->nullable();   
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
        Schema::dropIfExists('inventory_management');
    }
};
