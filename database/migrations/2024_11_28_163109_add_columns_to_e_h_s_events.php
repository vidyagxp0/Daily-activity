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
        Schema::table('e_h_s_events', function (Blueprint $table) {

            $table->text('employee_id')->nullable();
            $table->text('employee_name')->nullable();
            $table->longText('designation')->nullable();
            $table->text('department2')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('email')->nullable();
            $table->text('date_of_joining')->nullable();
            $table->text('safety_training_records')->nullable();
            $table->text('medical_history')->nullable();
            $table->longText('personal_protective_equipment_compliance')->nullable();
            $table->text('emergency_contacts')->nullable();

            $table->text('compliance_standards_regulations')->nullable();
            $table->text('regulatory_authority_agency')->nullable();
            $table->text('inspection_dates_and_reports')->nullable();
            $table->text('audit_inspection_results')->nullable();
            $table->text('non_compliance_issues')->nullable();
            $table->text('environmental_permits')->nullable();
            $table->text('workplace_safety_certifications')->nullable();

            $table->text('incident_id')->nullable();
            $table->text('date_of_incident')->nullable();
            $table->time('time_of_incident')->nullable();
            $table->text('type_of_incident')->nullable();
            $table->text('incident_severity')->nullable();
            $table->text('location_of_incident')->nullable();
            $table->text('affected_personnel')->nullable();
            $table->text('root_cause_analysis')->nullable();
            $table->text('corrective_and_preventive_actions')->nullable();
            $table->text('investigation_reports')->nullable();
            $table->text('injury_severity_and_report')->nullable();
            $table->text('incident_resolution_status')->nullable();

            $table->text('workplace_safety_audits')->nullable();
            $table->text('hazardous_area_identification')->nullable();
            $table->text('ventilation_systems_monitoring')->nullable();
            $table->text('noise_levels_monitoring')->nullable();
            $table->text('lighting_and_temperature_monitoring')->nullable();
            $table->text('personal_monitoring')->nullable();
            $table->text('ergonomics_data')->nullable();

            $table->text('Employee_Health_Records')->nullable();
            $table->text('Occupational_Exposure_Limits')->nullable();
            $table->text('Vaccination_Records')->nullable();
            $table->text('Pre_employment_and_Routine_Health_Screenings')->nullable();
            $table->text('Workplace_Injury_and_Illness_Reporting')->nullable();
            $table->text('Absenteeism_Data')->nullable();
            $table->text('Safety_Drills_and_Training_Records')->nullable();
            $table->text('First_Aid_and_Emergency_Response_Records')->nullable();

            $table->text('Emergency_Plan')->nullable();
            $table->text('Emergency_Contacts2')->nullable();
            $table->text('Emergency_Equipment')->nullable();
            $table->text('Incident_Simulation_Drills')->nullable();
            $table->text('Response_Time_Metrics')->nullable();
            $table->text('Evacuation_Routes_and_Assembly_Points')->nullable();

            $table->text('Energy_Consumption')->nullable();
            $table->text('Greenhouse_Gas_Emissions')->nullable();
            $table->text('Wastewater_Discharge')->nullable();
            $table->text('Air_Quality_Monitoring')->nullable();
            $table->text('Environmental_Sustainability_Projects')->nullable();

            $table->text('enargy_type')->nullable();
            $table->text('enargy_source')->nullable();
            $table->text('energy_usage')->nullable();
            $table->text('energy_intensity')->nullable();
            $table->text('peak_demand')->nullable();
            $table->text('energy_efficiency')->nullable();

            $table->text('co_emissions')->nullable();
            $table->longText('greenhouse_ges_emmission')->nullable();
            $table->text('scope_one_emission')->nullable();
            $table->text('scope_two_emission')->nullable();
            $table->text('scope_three_emission')->nullable();
            $table->text('carbon_intensity')->nullable();

            $table->text('water_consumption')->nullable();
            $table->text('water_source')->nullable();
            $table->text('water_effeciency')->nullable();
            $table->text('water_discharge')->nullable();
            $table->longText('waste_water_treatment')->nullable();
            $table->text('rainwater_harvesting')->nullable();

            $table->text('sustainable_product_purchased')->nullable();
            $table->longText('supplier_sustainability')->nullable();
            $table->text('sustainable_packaing')->nullable();
            $table->text('local_sourcing')->nullable();
            $table->longText('fair_trade')->nullable();

            $table->text('fuel_consumption')->nullable();
            $table->text('Vehicle_Type1')->nullable();
            $table->text('fleet_emissions')->nullable();
            $table->text('miles_traveled')->nullable();
            $table->longText('freight_and_shipping')->nullable();
            $table->longText('carbon_pffset_programs')->nullable();

            $table->text('land_area_impacted')->nullable();
            $table->text('protected_areas')->nullable();
            $table->text('deforestation')->nullable();
            $table->longText('habitat_preservation')->nullable();
            $table->longText('biodiversity_initiatives')->nullable();

            $table->text('certifications')->nullable();
            $table->longText('regulatory_compliance')->nullable();
            $table->text('audits')->nullable();

            $table->text('enviromental_risk')->nullable();
            $table->longText('impact_assessment')->nullable();
            $table->text('climate_change_adaptation')->nullable();
            $table->text('carbon_footprint')->nullable();

            $table->text('Risk_Assessment_Data')->nullable();
            $table->text('hazard_id_reports')->nullable();
            $table->longText('risk_migration_plan')->nullable();
            $table->longText('corrective_action')->nullable();

            $table->longtext('risk_factor1')->nullable();
            $table->longtext('risk_element1')->nullable();
            $table->longtext('problem_cause1')->nullable();
            $table->longtext('existing_risk_control1')->nullable();
            $table->longtext('initial_severity1')->nullable();
            $table->longtext('initial_detectability1')->nullable();
            $table->longtext('initial_probability1')->nullable();
            $table->longtext('initial_rpn1')->nullable();
            $table->longtext('risk_control_measure1')->nullable();
            $table->longtext('residual_severity1')->nullable();
            $table->longtext('residual_probability1')->nullable();
            $table->longtext('residual_detectability1')->nullable();
            $table->longtext('residual_rpn1')->nullable();
            $table->longtext('risk_acceptance1')->nullable();
            $table->longtext('risk_acceptance3')->nullable();
            $table->longtext('mitigation_proposal1')->nullable();

            $table->text('audit_id')->nullable();
            $table->text('Audit_Type')->nullable();
            $table->text('audit_date')->nullable();
            $table->text('audit_scope')->nullable();
            $table->longText('finding_and_observation')->nullable();
            $table->longText('corrective_action_plans')->nullable();
            $table->longText('follow_up_audit_result')->nullable();

            $table->text('sustainability_initiatives')->nullable();
            $table->text('csr_activities')->nullable();
            $table->longText('sustainability_reporting')->nullable();
            $table->longText('public_relation_report')->nullable();

            $table->text('Dashboards')->nullable();
            $table->text('key_performance_indicators')->nullable();
            $table->text('trend_analysis')->nullable();
            $table->text('data_export_functionality')->nullable();
            $table->longText('monthly_annual_reports')->nullable();

            $table->text('KPIs')->nullable();
            $table->longText('sustainability_targets')->nullable();
            $table->longText('progress_towards_goals')->nullable();
            $table->longText('Goal_Name')->nullable();
            $table->longText('Goal_Description')->nullable();
            $table->text('Responsible_Department')->nullable();
            $table->text('Goal_Timeframe')->nullable();
            $table->text('Region')->nullable();
            $table->text('Energy_Source')->nullable();
            $table->text('Energy_Consumption2')->nullable();
            $table->text('Energy_Efficiency_Target')->nullable();
            $table->text('Renewable_Energy_Usage_Target')->nullable();
            $table->text('Emission_Source')->nullable();
            $table->text('Carbon_Footprint2')->nullable();
            $table->text('Reduction_Target')->nullable();
            $table->text('Offset_Mechanisms')->nullable();
            $table->text('Water_Source2')->nullable();
            $table->text('Water_Consumption2')->nullable();
            $table->text('Water_Efficiency_Target')->nullable();
            $table->text('Recycled_Water_Usage_Target')->nullable();
            $table->text('Waste_Type')->nullable();
            $table->text('Waste_Quantity')->nullable();
            $table->text('Recycling_Rate_Target')->nullable();
            $table->text('Disposal_Methods')->nullable();
            $table->text('Protected_Areas_Covered')->nullable();
            $table->text('Species_Monitored')->nullable();
            $table->text('Habitat_Restoration_Target')->nullable();
            $table->text('Biodiversity_Index_Score')->nullable();
            $table->text('Supplier_Compliance')->nullable();
            $table->text('Percentage_of_Sustainable_Products')->nullable();
            $table->text('Local_Sourcing_Target')->nullable();
            $table->text('Product_Life_Extension_Target')->nullable();
            $table->text('Material_Reusability')->nullable();
            $table->text('Recycled_Material_Usage')->nullable();
            $table->text('SDG_Alignment')->nullable();
            $table->text('Compliance_Status')->nullable();
            $table->text('Progress_Measurement_Frequency')->nullable();
            $table->text('Recycled_Material_Usage1')->nullable();
            $table->text('Current_Progress')->nullable();

            $table->text('training_programs')->nullable();
            $table->text('employee_involcement')->nullable();
            $table->longText('sustainability_awareness')->nullable();

            $table->text('community_project')->nullable();
            $table->text('Partnerships')->nullable();
            $table->text('social_impact')->nullable();

            $table->text('More_Infomation_By')->nullable();
            $table->text('More_Infomation_On')->nullable();
            $table->longText('More_Infomation_Comment')->nullable();

            $table->text('Pending_More_Info_by')->nullable();
            $table->text('Pending_More_Info_on')->nullable();
            $table->longText('Pending_More_Info_comment')->nullable();

            $table->text('Training_required_by')->nullable();
            $table->text('Training_required_on')->nullable();
            $table->longText('Training_required_comment')->nullable();

            $table->text('Training_complete_by')->nullable();
            $table->text('Training_complete_on')->nullable();
            $table->longText('Training_complete_comment')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_h_s_events', function (Blueprint $table) {
            //
        });
    }
};
