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
        Schema::table('control_samples', function (Blueprint $table) {
             $table->text('controlsamples_id')->nullable();

             $table->text('initiator_id')->nullable();
             $table->text('division_id')->nullable();
             $table->text('division_code')->nullable();
             $table->text('intiation_date')->nullable();
             $table->text('stage')->nullable();
             $table->text('form_type')->nullable();
             $table->text('record')->nullable();
             $table->text('record_number')->nullable();
             $table->text('parent_id')->nullable();
             $table->text('parent_type')->nullable();
             $table->text('assign_to')->nullable();
             $table->text('due_date')->nullable();
             $table->longText('short_description')->nullable();
             $table->text('product_name')->nullable();
             $table->text('product_code')->nullable();
             $table->text('sample_type')->nullable();
             $table->text('market')->nullable();
             $table->text('ar_number')->nullable();
             $table->text('batch_number')->nullable();
             $table->text('manufacturing_date')->nullable();
             $table->text('expiry_date')->nullable();
             $table->text('quantity')->nullable();
             $table->text('quantity_withdrawn')->nullable();
             $table->text('unit_of_measurment')->nullable();
             $table->text('storage_condition')->nullable();
             $table->text('vi_scheduled_on')->nullable();
             $table->text('vi_performed_by')->nullable();
             $table->text('abnormal_observation')->nullable();
             $table->text('observation_date')->nullable();
             $table->text('destruction_due_on')->nullable();
             $table->text('destroyed_by')->nullable();
             $table->text('neutralizing_agent')->nullable();
             $table->text('destruction_date')->nullable();
             $table->text('remarks')->nullable();
             $table->text('status')->nullable();
             $table->longtext('supportive_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('control_samples', function (Blueprint $table) {
            //
        });
    }
};
