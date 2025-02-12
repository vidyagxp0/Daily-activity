<?php

namespace App\Http\Controllers;

use App\Models\ActionItem;
use Illuminate\Support\Facades\DB;

use App\Models\Capa;
use App\Models\Sanction;
use App\Models\CapaGrid;
use App\Models\Division;
use App\Models\Document;
use App\Models\EHSEvent;
use App\Models\EHSEventAuditTrail;
use App\Models\EHSEventHistory;
use App\Models\EHSRootCauseMethadologyGrid;
use App\Models\EHSEnvironmentTrainingData;
use App\Models\EHSTrainingAndAwarenesssGrid;
use App\Models\InternalAudit;
use App\Models\Auditee;
use App\Models\RootCauseAnalysis;
use App\Models\RecordNumber;
use App\Models\RiskManagement;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PDF;

class EhsController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $documents = Document::all();

        return view('frontend.ehs-event.ehs_event_create', compact('record_number', 'documents'));

    }

    public function ehs_event_store(Request $request)
    {

        if (! $request->short_description) {
            toastr()->error('Short description is required');

            return redirect()->back()->withInput();
        }
        $EHS = new EHSEvent;
        $EHSGrid = new EHSRootCauseMethadologyGrid;
        $EHS->form_type = 'EHS';
        $EHS->record = ((RecordNumber::first()->value('counter')) + 1);
        $EHS->initiator_id = Auth::user()->id;
        $EHS->division_id = $request->division_id;
        $EHS->division_code = $request->division_code;
        $EHS->intiation_date = $request->intiation_date;
        // $EHS->form_type = $request->form_type;
        $EHS->record_number = $request->record_number;
        $EHS->parent_id = $request->parent_id;
        $EHS->parent_type = $request->parent_type;
        $EHS->assign_to = $request->assign_to;
        $EHS->due_date = $request->due_date;
        $EHS->short_description = $request->short_description;
        $EHS->Type = $request->Type;
        $EHS->Incident_Sub_Type = $request->Incident_Sub_Type;
        $EHS->Date_Occurred = $request->Date_Occurred;
        $EHS->Time_Occurred = $request->Time_Occurred;
        $EHS->Similar_Incidents = $request->Similar_Incidents;
        $EHS->Date_Of_Reporting = $request->Date_Of_Reporting;
        $EHS->Reporter = $request->Reporter;
        $EHS->Description = $request->Description;
        $EHS->Immediate_Actions = $request->Immediate_Actions;
        $EHS->Accident_Type = $request->Accident_Type;
        $EHS->OSHA_Reportable = $request->OSHA_Reportable;
        $EHS->First_Lost_Work_Date = $request->First_Lost_Work_Date;
        $EHS->Last_Lost_Work_Date = $request->Last_Lost_Work_Date;
        $EHS->First_Restricted_Work_Date = $request->First_Restricted_Work_Date;
        $EHS->Last_Restricted_Work_Date = $request->Last_Restricted_Work_Date;
        $EHS->Vehicle_Type = $request->Vehicle_Type;
        $EHS->Vehicle_Number = $request->Vehicle_Number;
        $EHS->Litigation = $request->Litigation;
        $EHS->Department = $request->Department;
        $EHS->Employees_Involved = $request->Employees_Involved;
        $EHS->Involved_Contractors = $request->Involved_Contractors;
        $EHS->Attorneys_Involved = $request->Attorneys_Involved;
        $EHS->Lead_Investigator = $request->Lead_Investigator;
        $EHS->Line_Operator = $request->Line_Operator;
        $EHS->Reporter2 = $request->Reporter2;
        $EHS->Supervisor = $request->Supervisor;
        $EHS->Unsafe_Situation = $request->Unsafe_Situation;
        $EHS->Safeguarding_Measure_Taken = $request->Safeguarding_Measure_Taken;
        $EHS->Environmental_Category = $request->Environmental_Category;
        $EHS->Special_Weather_Conditions = $request->Special_Weather_Conditions;
        $EHS->Source_Of_Release_Or_Spill = $request->Source_Of_Release_Or_Spill;
        $EHS->Cause_Of_Release_Or_Spill = $request->Cause_Of_Release_Or_Spill;
        $EHS->Threat_Caused_By_Release_Spill = $request->Threat_Caused_By_Release_Spill;
        $EHS->Environment_Evacuation_Ordered = $request->Environment_Evacuation_Ordered;
        $EHS->Date_Samples_Taken = $request->Date_Samples_Taken;
        $EHS->Agencys_Notified = $request->Agencys_Notified;
        $EHS->Fire_Category = $request->Fire_Category;
        $EHS->Fire_Evacuation_Ordered = $request->Fire_Evacuation_Ordered;
        $EHS->Combat_By = $request->Combat_By;
        $EHS->Fire_Fighting_Equipment_Used = $request->Fire_Fighting_Equipment_Used;
        $EHS->zone = $request->zone;
        $EHS->country = $request->country;
        $EHS->state = $request->state;
        $EHS->city = $request->city;
        $EHS->Site_Name = $request->Site_Name;
        $EHS->Building = $request->Building;
        $EHS->Floor = $request->Floor;
        $EHS->Room = $request->Room;
        $EHS->Location = $request->Location;
        $EHS->Victim = $request->Victim;
        $EHS->Medical_Treatment = $request->Medical_Treatment;
        $EHS->Victim_Position = $request->Victim_Position;
        $EHS->Victim_Relation_To_Company = $request->Victim_Relation_To_Company;
        $EHS->Hospitalization = $request->Hospitalization;
        $EHS->Hospital_Name = $request->Hospital_Name;
        $EHS->Date_Of_Treatment = $request->Date_Of_Treatment;
        $EHS->Victim_Treated_By = $request->Victim_Treated_By;
        $EHS->Medical_Treatment_Description = $request->Medical_Treatment_Description;
        $EHS->Injury_Type = $request->Injury_Type;
        $EHS->Number_Of_Injuries = $request->Number_Of_Injuries;
        $EHS->Type_Of_Injuries = $request->Type_Of_Injuries;
        $EHS->Injured_Body_Parts = $request->Injured_Body_Parts;
        $EHS->Type_Of_Illness = $request->Type_Of_Illness;
        $EHS->Permanent_Disability = $request->Permanent_Disability;
        $EHS->Damage_Category = $request->Damage_Category;
        $EHS->Related_Equipment = $request->Related_Equipment;
        $EHS->Estimated_Amount_Of_Damage = $request->Estimated_Amount_Of_Damage;
        $EHS->Currency = $request->Currency;
        $EHS->Insurance_Company_Involved = $request->Insurance_Company_Involved;
        $EHS->Denied_By_Insurance_Company = $request->Denied_By_Insurance_Company;
        $EHS->Damage_Details = $request->Damage_Details;
        $EHS->Actual_Amount_Of_Damage = $request->Actual_Amount_Of_Damage;
        $EHS->Currency2 = $request->Currency2;
        $EHS->Investigation_Summary = $request->Investigation_Summary;
        $EHS->Conclusion = $request->Conclusion;
        $EHS->root_cause_methodology = implode(',', $request->root_cause_methodology);
        $EHS->Root_Cause_Description = $request->Root_Cause_Description;
        $EHS->Safety_Impact_Probability = $request->Safety_Impact_Probability;
        $EHS->Safety_Impact_Severity = $request->Safety_Impact_Severity;
        $EHS->Legal_Impact_Probability = $request->Legal_Impact_Probability;
        $EHS->Legal_Impact_Severity = $request->Legal_Impact_Severity;
        $EHS->Business_Impact_Probability = $request->Business_Impact_Probability;
        $EHS->Business_Impact_Severity = $request->Business_Impact_Severity;
        $EHS->Revenue_Impact_Probability = $request->Revenue_Impact_Probability;
        $EHS->Revenue_Impact_Severity = $request->Revenue_Impact_Severity;
        $EHS->Brand_Impact_Probability = $request->Brand_Impact_Probability;
        $EHS->Brand_Impact_Severity = $request->Brand_Impact_Severity;
        $EHS->Safety_Impact_Risk = $request->Safety_Impact_Risk;
        $EHS->Legal_Impact_Risk = $request->Legal_Impact_Risk;
        $EHS->Business_Impact_Risk = $request->Business_Impact_Risk;
        $EHS->Revenue_Impact_Risk = $request->Revenue_Impact_Risk;
        $EHS->Brand_Impact_Risk = $request->Brand_Impact_Risk;
        $EHS->Impact = $request->Impact;
        $EHS->Impact_Analysis = $request->Impact_Analysis;
        $EHS->Recommended_Actions = $request->Recommended_Actions;
        $EHS->Comments2 = $request->Comments2;
        $EHS->Direct_Cause = $request->Direct_Cause;
        $EHS->Safeguarding_Measure_Taken2 = $request->Safeguarding_Measure_Taken2;
        $EHS->severity_rate = $request->severity_rate;
        $EHS->occurrence = $request->occurrence;
        $EHS->detection = $request->detection;
        $EHS->rpn = $request->rpn;
        $EHS->Risk_Analysis = $request->Risk_Analysis;
        $EHS->Critically = $request->Critically;
        $EHS->Inform_Local_Authority = $request->Inform_Local_Authority;
        $EHS->Authority_Type = $request->Authority_Type;
        $EHS->Authority_Notified = $request->Authority_Notified;
        $EHS->Other_Authority = $request->Other_Authority;

        if (! empty($request->measurement)) {
            $EHS->measurement = serialize($request->measurement);
        }
        if (! empty($request->materials)) {
            $EHS->materials = serialize($request->materials);
        }
        if (! empty($request->environment)) {
            $EHS->environment = serialize($request->environment);
        }
        if (! empty($request->manpower)) {
            $EHS->manpower = serialize($request->manpower);
        }
        if (! empty($request->machine)) {
            $EHS->machine = serialize($request->machine);
        }
        if (! empty($request->methods)) {
            $EHS->methods = serialize($request->methods);
        }
        $EHS->problem_statement = ($request->problem_statement);
        // Why-Why Chart (Launch Instruction) Problem Statement
        if (! empty($request->why_problem_statement)) {
            $EHS->why_problem_statement = $request->why_problem_statement;
        }
        if (! empty($request->why_1)) {
            $EHS->why_1 = serialize($request->why_1);
        }
        if (! empty($request->why_2)) {
            $EHS->why_2 = serialize($request->why_2);
        }
        if (! empty($request->why_3)) {
            $EHS->why_3 = serialize($request->why_3);
        }
        if (! empty($request->why_4)) {
            $EHS->why_4 = serialize($request->why_4);
        }
        if (! empty($request->why_5)) {
            $EHS->why_5 = serialize($request->why_5);
        }
        if (! empty($request->why_root_cause)) {
            $EHS->why_root_cause = $request->why_root_cause;
        }

        // Is/Is Not Analysis (Launch Instruction)
        $EHS->what_will_be = ($request->what_will_be);
        $EHS->what_will_not_be = ($request->what_will_not_be);
        $EHS->what_rationable = ($request->what_rationable);

        $EHS->where_will_be = ($request->where_will_be);
        $EHS->where_will_not_be = ($request->where_will_not_be);
        $EHS->where_rationable = ($request->where_rationable);

        $EHS->when_will_be = ($request->when_will_be);
        $EHS->when_will_not_be = ($request->when_will_not_be);
        $EHS->when_rationable = ($request->when_rationable);

        $EHS->coverage_will_be = ($request->coverage_will_be);
        $EHS->coverage_will_not_be = ($request->coverage_will_not_be);
        $EHS->coverage_rationable = ($request->coverage_rationable);

        $EHS->who_will_be = ($request->who_will_be);
        $EHS->who_will_not_be = ($request->who_will_not_be);
        $EHS->who_rationable = ($request->who_rationable);

        // Inference

        if (! empty($request->inference_type)) {
            $EHS->inference_type = serialize($request->inference_type);
        }
        if (! empty($request->inference_remarks)) {
            $EHS->inference_remarks = serialize($request->inference_remarks);
        }

        //Failure Mode and Effect Analysis+

        if (! empty($request->risk_factor)) {
            $EHS->risk_factor = serialize($request->risk_factor);
        }
        if (! empty($request->risk_element)) {
            $EHS->risk_element = serialize($request->risk_element);
        }
        if (! empty($request->problem_cause)) {
            $EHS->problem_cause = serialize($request->problem_cause);
        }
        if (! empty($request->existing_risk_control)) {
            $EHS->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (! empty($request->initial_severity)) {
            $EHS->initial_severity = serialize($request->initial_severity);
        }
        if (! empty($request->initial_detectability)) {
            $EHS->initial_detectability = serialize($request->initial_detectability);
        }
        if (! empty($request->initial_probability)) {
            $EHS->initial_probability = serialize($request->initial_probability);
        }
        if (! empty($request->initial_rpn)) {
            $EHS->initial_rpn = serialize($request->initial_rpn);
        }

        if (! empty($request->risk_control_measure)) {
            $EHS->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (! empty($request->residual_severity)) {
            $EHS->residual_severity = serialize($request->residual_severity);
        }
        if (! empty($request->residual_probability)) {
            $EHS->residual_probability = serialize($request->residual_probability);
        }
        if (! empty($request->residual_detectability)) {
            $EHS->residual_detectability = serialize($request->residual_detectability);
        }
        if (! empty($request->residual_rpn)) {
            $EHS->residual_rpn = serialize($request->residual_rpn);
        }
        if (! empty($request->risk_acceptance)) {
            $EHS->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (! empty($request->risk_acceptance2)) {
            $EHS->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (! empty($request->mitigation_proposal)) {
            $EHS->mitigation_proposal = serialize($request->mitigation_proposal);
        }

        $EHS->employee_id = $request->employee_id;
        $EHS->employee_name = $request->employee_name;
        $EHS->designation = $request->designation;
        $EHS->Department2 = $request->Department2;
        $EHS->phone_number = $request->phone_number;
        $EHS->email = $request->email;
        $EHS->date_of_joining = $request->date_of_joining;
        $EHS->safety_training_records = $request->safety_training_records;
        $EHS->medical_history = $request->medical_history;
        $EHS->personal_protective_equipment_compliance = $request->personal_protective_equipment_compliance;
        $EHS->emergency_contacts = $request->emergency_contacts;

        $EHS->compliance_standards_regulations = $request->compliance_standards_regulations;
        $EHS->regulatory_authority_agency = $request->regulatory_authority_agency;
        $EHS->inspection_dates_and_reports = $request->inspection_dates_and_reports;
        $EHS->audit_inspection_results = $request->audit_inspection_results;
        $EHS->non_compliance_issues = $request->non_compliance_issues;
        $EHS->environmental_permits = $request->environmental_permits;
        $EHS->workplace_safety_certifications = $request->workplace_safety_certifications;

        $EHS->incident_id = $request->incident_id;
        $EHS->date_of_incident = $request->date_of_incident;
        $EHS->time_of_incident = $request->time_of_incident;
        $EHS->type_of_incident = $request->type_of_incident;
        $EHS->incident_severity = $request->incident_severity;
        $EHS->location_of_incident = $request->location_of_incident;
        $EHS->affected_personnel = $request->affected_personnel;
        $EHS->root_cause_analysis = $request->root_cause_analysis;
        $EHS->corrective_and_preventive_actions = $request->corrective_and_preventive_actions;
        $EHS->investigation_reports = $request->investigation_reports;
        $EHS->injury_severity_and_report = $request->injury_severity_and_report;
        $EHS->incident_resolution_status = $request->incident_resolution_status;

        $EHS->workplace_safety_audits = $request->workplace_safety_audits;
        $EHS->hazardous_area_identification = $request->hazardous_area_identification;
        $EHS->ventilation_systems_monitoring = $request->ventilation_systems_monitoring;
        $EHS->noise_levels_monitoring = $request->noise_levels_monitoring;
        $EHS->lighting_and_temperature_monitoring = $request->lighting_and_temperature_monitoring;
        $EHS->personal_monitoring = $request->personal_monitoring;
        $EHS->ergonomics_data = $request->ergonomics_data;

        $EHS->Employee_Health_Records = $request->Employee_Health_Records;
        $EHS->Occupational_Exposure_Limits = $request->Occupational_Exposure_Limits;
        $EHS->Vaccination_Records = $request->Vaccination_Records;
        $EHS->Pre_employment_and_Routine_Health_Screenings = $request->Pre_employment_and_Routine_Health_Screenings;
        $EHS->Workplace_Injury_and_Illness_Reporting = $request->Workplace_Injury_and_Illness_Reporting;
        $EHS->Absenteeism_Data = $request->Absenteeism_Data;
        $EHS->Safety_Drills_and_Training_Records = $request->Safety_Drills_and_Training_Records;
        $EHS->First_Aid_and_Emergency_Response_Records = $request->First_Aid_and_Emergency_Response_Records;

        $EHS->Emergency_Plan = $request->Emergency_Plan;
        $EHS->Emergency_Contacts2 = $request->Emergency_Contacts2;
        $EHS->Emergency_Equipment = $request->Emergency_Equipment;
        $EHS->Incident_Simulation_Drills = $request->Incident_Simulation_Drills;
        $EHS->Response_Time_Metrics = $request->Response_Time_Metrics;
        $EHS->Evacuation_Routes_and_Assembly_Points = $request->Evacuation_Routes_and_Assembly_Points;

        $EHS->Energy_Consumption = $request->Energy_Consumption;
        $EHS->Greenhouse_Gas_Emissions = $request->Greenhouse_Gas_Emissions;
        $EHS->Wastewater_Discharge = $request->Wastewater_Discharge;
        $EHS->Air_Quality_Monitoring = $request->Air_Quality_Monitoring;
        $EHS->Environmental_Sustainability_Projects = $request->Environmental_Sustainability_Projects;

        $EHS->enargy_type = $request->enargy_type;
        $EHS->enargy_source = $request->enargy_source;
        $EHS->energy_usage = $request->energy_usage;
        $EHS->energy_intensity = $request->energy_intensity;
        $EHS->peak_demand = $request->peak_demand;
        $EHS->energy_efficiency = $request->energy_efficiency;
        $EHS->co_emissions = $request->co_emissions;
        $EHS->greenhouse_ges_emmission = $request->greenhouse_ges_emmission;
        $EHS->scope_one_emission = $request->scope_one_emission;
        $EHS->scope_two_emission = $request->scope_two_emission;
        $EHS->scope_three_emission = $request->scope_three_emission;
        $EHS->carbon_intensity = $request->carbon_intensity;
        $EHS->water_consumption = $request->water_consumption;
        $EHS->water_source = $request->water_source;
        $EHS->water_effeciency = $request->water_effeciency;
        $EHS->water_discharge = $request->water_discharge;
        $EHS->waste_water_treatment = $request->waste_water_treatment;
        $EHS->rainwater_harvesting = $request->rainwater_harvesting;
        $EHS->sustainable_product_purchased = $request->sustainable_product_purchased;
        $EHS->supplier_sustainability = $request->supplier_sustainability;
        $EHS->sustainable_packaing = $request->sustainable_packaing;
        $EHS->local_sourcing = $request->local_sourcing;
        $EHS->fair_trade = $request->fair_trade;
        $EHS->fuel_consumption = $request->fuel_consumption;
        $EHS->Vehicle_Type1 = $request->Vehicle_Type1;
        $EHS->fleet_emissions = $request->fleet_emissions;
        $EHS->miles_traveled = $request->miles_traveled;
        $EHS->freight_and_shipping = $request->freight_and_shipping;
        $EHS->carbon_pffset_programs = $request->carbon_pffset_programs;
        $EHS->land_area_impacted = $request->land_area_impacted;
        $EHS->protected_areas = $request->protected_areas;
        $EHS->deforestation = $request->deforestation;
        $EHS->habitat_preservation = $request->habitat_preservation;
        $EHS->biodiversity_initiatives = $request->biodiversity_initiatives;
        $EHS->certifications = $request->certifications;
        $EHS->regulatory_compliance = $request->regulatory_compliance;
        $EHS->audits = $request->audits;
        $EHS->enviromental_risk = $request->enviromental_risk;
        $EHS->impact_assessment = $request->impact_assessment;
        $EHS->climate_change_adaptation = $request->climate_change_adaptation;
        $EHS->carbon_footprint = $request->carbon_footprint;
        $EHS->Risk_Assessment_Data = $request->Risk_Assessment_Data;
        $EHS->hazard_id_reports = $request->hazard_id_reports;

        //Failure Mode and Effect Analysis+

        if (! empty($request->risk_factor1)) {
            $EHS->risk_factor1 = serialize($request->risk_factor1);
        }
        if (! empty($request->risk_element1)) {
            $EHS->risk_element1 = serialize($request->risk_element1);
        }
        if (! empty($request->problem_cause1)) {
            $EHS->problem_cause1 = serialize($request->problem_cause1);
        }
        if (! empty($request->existing_risk_control1)) {
            $EHS->existing_risk_control1 = serialize($request->existing_risk_control1);
        }
        if (! empty($request->initial_severity1)) {
            $EHS->initial_severity1 = serialize($request->initial_severity1);
        }
        if (! empty($request->initial_detectability1)) {
            $EHS->initial_detectability1 = serialize($request->initial_detectability1);
        }
        if (! empty($request->initial_probability1)) {
            $EHS->initial_probability1 = serialize($request->initial_probability1);
        }
        if (! empty($request->initial_rpn1)) {
            $EHS->initial_rpn1 = serialize($request->initial_rpn1);
        }

        if (! empty($request->risk_control_measure1)) {
            $EHS->risk_control_measure1 = serialize($request->risk_control_measure1);
        }
        if (! empty($request->residual_severity1)) {
            $EHS->residual_severity1 = serialize($request->residual_severity1);
        }
        if (! empty($request->residual_probability1)) {
            $EHS->residual_probability1 = serialize($request->residual_probability1);
        }
        if (! empty($request->residual_detectability1)) {
            $EHS->residual_detectability1 = serialize($request->residual_detectability1);
        }
        if (! empty($request->residual_rpn1)) {
            $EHS->residual_rpn1 = serialize($request->residual_rpn1);
        }
        if (! empty($request->risk_acceptance1)) {
            $EHS->risk_acceptance1 = serialize($request->risk_acceptance1);
        }
        if (! empty($request->risk_acceptance3)) {
            $EHS->risk_acceptance3 = serialize($request->risk_acceptance3);
        }
        if (! empty($request->mitigation_proposal1)) {
            $EHS->mitigation_proposal1 = serialize($request->mitigation_proposal1);
        }

        $EHS->risk_migration_plan = $request->risk_migration_plan;
        $EHS->corrective_action = $request->corrective_action;
        $EHS->audit_id = $request->audit_id;
        $EHS->Audit_Type = $request->Audit_Type;
        $EHS->audit_date = $request->audit_date;
        $EHS->audit_scope = $request->audit_scope;
        $EHS->finding_and_observation = $request->finding_and_observation;
        $EHS->corrective_action_plans = $request->corrective_action_plans;
        $EHS->follow_up_audit_result = $request->follow_up_audit_result;
        $EHS->sustainability_initiatives = $request->sustainability_initiatives;
        $EHS->csr_activities = $request->csr_activities;
        $EHS->sustainability_reporting = $request->sustainability_reporting;
        $EHS->public_relation_report = $request->public_relation_report;
        $EHS->Dashboards = $request->Dashboards;
        $EHS->key_performance_indicators = $request->key_performance_indicators;
        $EHS->trend_analysis = $request->trend_analysis;
        $EHS->data_export_functionality = $request->data_export_functionality;
        $EHS->monthly_annual_reports = $request->monthly_annual_reports;
        $EHS->KPIs = $request->KPIs;
        $EHS->sustainability_targets = $request->sustainability_targets;
        $EHS->progress_towards_goals = $request->progress_towards_goals;
        $EHS->Goal_Name = $request->Goal_Name;
        $EHS->Goal_Description = $request->Goal_Description;
        $EHS->Responsible_Department = $request->Responsible_Department;
        $EHS->Goal_Timeframe = $request->Goal_Timeframe;
        $EHS->Region = $request->Region;
        $EHS->Energy_Source = $request->Energy_Source;
        $EHS->Energy_Consumption2 = $request->Energy_Consumption2;
        $EHS->Energy_Efficiency_Target = $request->Energy_Efficiency_Target;
        $EHS->Renewable_Energy_Usage_Target = $request->Renewable_Energy_Usage_Target;
        $EHS->Emission_Source = $request->Emission_Source;
        $EHS->Carbon_Footprint2 = $request->Carbon_Footprint2;
        $EHS->Reduction_Target = $request->Reduction_Target;
        $EHS->Offset_Mechanisms = $request->Offset_Mechanisms;
        $EHS->Water_Source2 = $request->Water_Source2;
        $EHS->Water_Consumption2 = $request->Water_Consumption2;
        $EHS->Water_Efficiency_Target = $request->Water_Efficiency_Target;
        $EHS->Recycled_Water_Usage_Target = $request->Recycled_Water_Usage_Target;
        $EHS->Waste_Type = $request->Waste_Type;
        $EHS->Waste_Quantity = $request->Waste_Quantity;
        $EHS->Recycling_Rate_Target = $request->Recycling_Rate_Target;
        $EHS->Disposal_Methods = $request->Disposal_Methods;
        $EHS->Protected_Areas_Covered = $request->Protected_Areas_Covered;
        $EHS->Species_Monitored = $request->Species_Monitored;
        $EHS->Habitat_Restoration_Target = $request->Habitat_Restoration_Target;
        $EHS->Biodiversity_Index_Score = $request->Biodiversity_Index_Score;
        $EHS->Supplier_Compliance = $request->Supplier_Compliance;
        $EHS->Percentage_of_Sustainable_Products = $request->Percentage_of_Sustainable_Products;
        $EHS->Local_Sourcing_Target = $request->Local_Sourcing_Target;
        $EHS->Product_Life_Extension_Target = $request->Product_Life_Extension_Target;
        $EHS->Material_Reusability = $request->Material_Reusability;
        $EHS->Recycled_Material_Usage = $request->Recycled_Material_Usage;
        $EHS->SDG_Alignment = $request->SDG_Alignment;
        $EHS->Compliance_Status = $request->Compliance_Status;
        $EHS->Progress_Measurement_Frequency = $request->Progress_Measurement_Frequency;
        $EHS->Recycled_Material_Usage1 = $request->Recycled_Material_Usage1;
        $EHS->Current_Progress = $request->Current_Progress;

        $EHS->training_programs = $request->training_programs;
        $EHS->employee_involcement = $request->employee_involcement;
        $EHS->sustainability_awareness = $request->sustainability_awareness;
        $EHS->community_project = $request->community_project;
        $EHS->Partnerships = $request->Partnerships;
        $EHS->social_impact = $request->social_impact;

        $EHS->status = 'Opened';
        $EHS->stage = 1;

        if (! empty($request->Attached_File)) {
            $files = [];
            if ($request->hasfile('Attached_File')) {
                foreach ($request->file('Attached_File') as $file) {
                    $name = $request->name.'-Attached_File'.rand(1, 100).'.'.$file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $EHS->Attached_File = json_encode($files);
        }

        $EHS->save();

        $WitnessesInformationUpdate = $EHS->id;
        if (! empty($request->WitnessesInformation)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $WitnessesInformationUpdate, 'identifier' => 'Witnesses Information'])->firstOrNew();
            $summaryShow->ehsEvent_id = $WitnessesInformationUpdate;
            $summaryShow->identifier = 'Witnesses Information';
            $summaryShow->data1 = $request->WitnessesInformation;
            $summaryShow->save();
        }

        $MaterialReleasedUpdate = $EHS->id;
        if (! empty($request->MaterialReleased)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $MaterialReleasedUpdate, 'identifier' => 'Material Released'])->firstOrNew();
            $summaryShow->ehsEvent_id = $MaterialReleasedUpdate;
            $summaryShow->identifier = 'Material Released';
            $summaryShow->data1 = $request->MaterialReleased;
            $summaryShow->save();
        }

        $RootCauseUpdate = $EHS->id;
        if (! empty($request->RootCause)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $RootCauseUpdate, 'identifier' => 'Root Cause'])->firstOrNew();
            $summaryShow->ehsEvent_id = $RootCauseUpdate;
            $summaryShow->identifier = 'Root Cause';
            $summaryShow->data1 = $request->RootCause;
            $summaryShow->save();
        }

        $ChemicalAndHazardousMaterialsUpdate = $EHS->id;
        if (! empty($request->ChemicalAndHazardousMaterials)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $ChemicalAndHazardousMaterialsUpdate, 'identifier' => 'Chemical And Hazardous Materials'])->firstOrNew();
            $summaryShow->ehsEvent_id = $ChemicalAndHazardousMaterialsUpdate;
            $summaryShow->identifier = 'Chemical And Hazardous Materials';
            $summaryShow->data1 = $request->ChemicalAndHazardousMaterials;
            $summaryShow->save();
        }

        $WasteManagementUpdate = $EHS->id;
        if (! empty($request->WasteManagement)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $WasteManagementUpdate, 'identifier' => 'Waste Management'])->firstOrNew();
            $summaryShow->ehsEvent_id = $WasteManagementUpdate;
            $summaryShow->identifier = 'Waste Management';
            $summaryShow->data1 = $request->WasteManagement;
            $summaryShow->save();
        }

        $trainingGrid = EHSTrainingAndAwarenesssGrid::where(['ehsEvent_id' => $EHS->id, 'identifier' => 'EHSTrainingAndAwareness'])->firstOrCreate();
        $trainingGrid->ehsEvent_id = $EHS->id;
        $trainingPlanData = $request->trainingPlanData;

        foreach ($trainingPlanData as $index => $data) {
            if (! empty($data['file'])) {
                $file = $data['file'];
                $fileName = 'Training'.'_file_'.rand(1, 100).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('upload'), $fileName);

                $trainingPlanData[$index]['file_path'] = 'upload/'.$fileName;
                unset($trainingPlanData[$index]['file']);
            } else {
                $trainingPlanData[$index]['file_path'] = null;
            }
        }

        $trainingGrid->data = $trainingPlanData;
        $trainingGrid->identifier = 'EHSTrainingAndAwareness';
        $trainingGrid->save();

        if (! empty($EHS->record)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Record Number';
            $history->previous = 'Null';
            $history->current = Helpers::getDivisionName(session()->get('division')).'/EHS/'.Helpers::year($EHS->created_at).'/'.str_pad($EHS->record, 4, '0', STR_PAD_LEFT);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->division_code)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = 'Null';
            $history->current = $EHS->division_code;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->initiator_id)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Initiator';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->initiator_id);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->intiation_date)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->intiation_date);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->assign_to)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Assigned to';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->assign_to);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->due_date)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Due Date';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->due_date);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->short_description)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Short Description';
            $history->previous = 'Null';
            $history->current = $EHS->short_description;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Type)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Type';
            $history->previous = 'Null';
            $history->current = $EHS->Type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Incident_Sub_Type)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Incident Sub Type';
            $history->previous = 'Null';
            $history->current = $EHS->Incident_Sub_Type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Date_Occurred)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Date Occurred';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->Date_Occurred);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Time_Occurred)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Time Occurred';
            $history->previous = 'Null';
            $history->current = $EHS->Time_Occurred;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Attached_File)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Attached File';
            $history->previous = 'Null';
            $history->current = str_replace(',', ', ', $EHS->Attached_File);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Similar_Incidents)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Similar Incidents';
            $history->previous = 'Null';
            $history->current = $EHS->Similar_Incidents;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Date_Of_Reporting)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Date Of Reporting';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->Date_Of_Reporting);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Reporter)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Reporter';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Reporter);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Description)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Description';
            $history->previous = 'Null';
            $history->current = $EHS->Description;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Immediate_Actions)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Immediate Actions';
            $history->previous = 'Null';
            $history->current = $EHS->Immediate_Actions;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Accident_Type)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Accident Type';
            $history->previous = 'Null';
            $history->current = $EHS->Accident_Type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->OSHA_Reportable)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'OSHA Reportable';
            $history->previous = 'Null';
            $history->current = $EHS->OSHA_Reportable;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->First_Lost_Work_Date)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'First Lost Work Date';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->First_Lost_Work_Date);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Last_Lost_Work_Date)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Last Lost Work Date';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->Last_Lost_Work_Date);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->First_Restricted_Work_Date)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'First Restricted Work Date';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->First_Restricted_Work_Date);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Last_Restricted_Work_Date)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Last Restricted Work Date';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->Last_Restricted_Work_Date);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Vehicle_Type)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Vehicle Type';
            $history->previous = 'Null';
            $history->current = $EHS->Vehicle_Type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Vehicle_Number)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Vehicle Number';
            $history->previous = 'Null';
            $history->current = $EHS->Vehicle_Number;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Litigation)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Litigation';
            $history->previous = 'Null';
            $history->current = $EHS->Litigation;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Department)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Department';
            $history->previous = 'Null';
            $history->current = $EHS->Department;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Employees_Involved)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Employees Involved';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Employees_Involved);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Involved_Contractors)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Involved Contractors';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Involved_Contractors);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Attorneys_Involved)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Attorneys Involved';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Attorneys_Involved);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Lead_Investigator)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Lead_Investigator);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Line_Operator)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Line Operator';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Line_Operator);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Reporter2)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Reporter';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Reporter2);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Supervisor)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Supervisor';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Supervisor);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Unsafe_Situation)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Unsafe Situation';
            $history->previous = 'Null';
            $history->current = $EHS->Unsafe_Situation;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Safeguarding_Measure_Taken)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Safeguarding Measure Taken';
            $history->previous = 'Null';
            $history->current = $EHS->Safeguarding_Measure_Taken;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Environmental_Category)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Environmental Category';
            $history->previous = 'Null';
            $history->current = $EHS->Environmental_Category;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Special_Weather_Conditions)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Special Weather Conditions';
            $history->previous = 'Null';
            $history->current = $EHS->Special_Weather_Conditions;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Source_Of_Release_Or_Spill)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Source Of Release Or Spill';
            $history->previous = 'Null';
            $history->current = $EHS->Source_Of_Release_Or_Spill;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Cause_Of_Release_Or_Spill)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Cause Of Release Or Spill';
            $history->previous = 'Null';
            $history->current = $EHS->Cause_Of_Release_Or_Spill;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Threat_Caused_By_Release_Spill)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Threat Caused By Release/Spill';
            $history->previous = 'Null';
            $history->current = $EHS->Threat_Caused_By_Release_Spill;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Environment_Evacuation_Ordered)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Environment Evacuation Ordered';
            $history->previous = 'Null';
            $history->current = $EHS->Environment_Evacuation_Ordered;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Date_Samples_Taken)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Date of Samples Taken';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->Date_Samples_Taken);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Agencys_Notified)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Agencys Notified';
            $history->previous = 'Null';
            $history->current = $EHS->Agencys_Notified;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Fire_Category)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Fire Category';
            $history->previous = 'Null';
            $history->current = $EHS->Fire_Category;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Fire_Evacuation_Ordered)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Fire Evacuation Ordered ?';
            $history->previous = 'Null';
            $history->current = $EHS->Fire_Evacuation_Ordered;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Combat_By)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Combat By';
            $history->previous = 'Null';
            $history->current = $EHS->Combat_By;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Fire_Fighting_Equipment_Used)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Fire Fighting Equipment Used';
            $history->previous = 'Null';
            $history->current = $EHS->Fire_Fighting_Equipment_Used;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->zone)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Zone';
            $history->previous = 'Null';
            $history->current = $EHS->zone;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->country)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Country';
            $history->previous = 'Null';
            $history->current = $EHS->country;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->state)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'State';
            $history->previous = 'Null';
            $history->current = $EHS->state;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->city)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'City';
            $history->previous = 'Null';
            $history->current = $EHS->city;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Site_Name)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Site Name';
            $history->previous = 'Null';
            $history->current = $EHS->Site_Name;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Building)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Building';
            $history->previous = 'Null';
            $history->current = $EHS->Building;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Floor)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Floor';
            $history->previous = 'Null';
            $history->current = $EHS->Floor;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Room)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Room';
            $history->previous = 'Null';
            $history->current = $EHS->Room;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Location)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Location';
            $history->previous = 'Null';
            $history->current = $EHS->Location;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Victim)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Victim';
            $history->previous = 'Null';
            $history->current = Helpers::getInitiatorName($EHS->Victim);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Medical_Treatment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Medical Treatment ?(Y/N)';
            $history->previous = 'Null';
            $history->current = $EHS->Medical_Treatment;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Victim_Position)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Victim Position';
            $history->previous = 'Null';
            $history->current = $EHS->Victim_Position;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Victim_Relation_To_Company)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Victim Relation To Company';
            $history->previous = 'Null';
            $history->current = $EHS->Victim_Relation_To_Company;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Hospitalization)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Hospitalization';
            $history->previous = 'Null';
            $history->current = $EHS->Hospitalization;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Hospital_Name)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Hospital Name';
            $history->previous = 'Null';
            $history->current = $EHS->Hospital_Name;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Date_Of_Treatment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Date Of Treatment';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->Date_Of_Treatment);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Victim_Treated_By)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Victim Treated By';
            $history->previous = 'Null';
            $history->current = $EHS->Victim_Treated_By;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Medical_Treatment_Description)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Medical Treatment Description';
            $history->previous = 'Null';
            $history->current = $EHS->Medical_Treatment_Description;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Injury_Type)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Injury Type';
            $history->previous = 'Null';
            $history->current = $EHS->Injury_Type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Number_Of_Injuries)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Number Of Injuries';
            $history->previous = 'Null';
            $history->current = $EHS->Number_Of_Injuries;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Type_Of_Injuries)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Type Of Injuries';
            $history->previous = 'Null';
            $history->current = $EHS->Type_Of_Injuries;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Injured_Body_Parts)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Injured Body Parts';
            $history->previous = 'Null';
            $history->current = $EHS->Injured_Body_Parts;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Type_Of_Illness)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Type Of Illness';
            $history->previous = 'Null';
            $history->current = $EHS->Type_Of_Illness;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Permanent_Disability)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Permanent Disability?';
            $history->previous = 'Null';
            $history->current = $EHS->Permanent_Disability;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Damage_Category)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Damage Category';
            $history->previous = 'Null';
            $history->current = $EHS->Damage_Category;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Related_Equipment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Related Equipment';
            $history->previous = 'Null';
            $history->current = $EHS->Related_Equipment;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Estimated_Amount_Of_Damage)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Estimated Amount Of Damage';
            $history->previous = 'Null';
            $history->current = $EHS->Estimated_Amount_Of_Damage;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Currency)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Currency';
            $history->previous = 'Null';
            $history->current = $EHS->Currency;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Insurance_Company_Involved)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Insurance Company Involved?';
            $history->previous = 'Null';
            $history->current = $EHS->Insurance_Company_Involved;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Denied_By_Insurance_Company)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Denied By Insurance Company';
            $history->previous = 'Null';
            $history->current = $EHS->Denied_By_Insurance_Company;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Damage_Details)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Damage Details';
            $history->previous = 'Null';
            $history->current = $EHS->Damage_Details;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Actual_Amount_Of_Damage)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Actual Amount Of Damage';
            $history->previous = 'Null';
            $history->current = $EHS->Actual_Amount_Of_Damage;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Currency2)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Currency';
            $history->previous = 'Null';
            $history->current = $EHS->Currency2;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Investigation_Summary)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Investigation Summary';
            $history->previous = 'Null';
            $history->current = $EHS->Investigation_Summary;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Conclusion)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Conclusion';
            $history->previous = 'Null';
            $history->current = $EHS->Conclusion;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->root_cause_methodology)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Root Cause Methodology';
            $history->previous = 'Null';
            $history->current = str_replace(',', ', ', $EHS->root_cause_methodology);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Root_Cause_Description)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Root Cause Description';
            $history->previous = 'Null';
            $history->current = $EHS->Root_Cause_Description;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Safety_Impact_Probability)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Safety Impact Probability';
            $history->previous = 'Null';
            $history->current = $EHS->Safety_Impact_Probability;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Safety_Impact_Severity)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Safety Impact Severity';
            $history->previous = 'Null';
            $history->current = $EHS->Safety_Impact_Severity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Legal_Impact_Probability)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Legal Impact Probability';
            $history->previous = 'Null';
            $history->current = $EHS->Legal_Impact_Probability;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Legal_Impact_Severity)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Legal Impact Severity';
            $history->previous = 'Null';
            $history->current = $EHS->Legal_Impact_Severity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Business_Impact_Probability)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Business Impact Probability';
            $history->previous = 'Null';
            $history->current = $EHS->Business_Impact_Probability;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Business_Impact_Severity)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Business Impact Severity';
            $history->previous = 'Null';
            $history->current = $EHS->Business_Impact_Severity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Revenue_Impact_Probability)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Revenue Impact Probability';
            $history->previous = 'Null';
            $history->current = $EHS->Revenue_Impact_Probability;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Revenue_Impact_Severity)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Revenue Impact Severity';
            $history->previous = 'Null';
            $history->current = $EHS->Revenue_Impact_Severity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Brand_Impact_Probability)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Brand Impact Probability';
            $history->previous = 'Null';
            $history->current = $EHS->Brand_Impact_Probability;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Brand_Impact_Severity)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Brand Impact Severity';
            $history->previous = 'Null';
            $history->current = $EHS->Brand_Impact_Severity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Safety_Impact_Risk)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Safety Impact Risk';
            $history->previous = 'Null';
            $history->current = $EHS->Safety_Impact_Risk;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Legal_Impact_Risk)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Legal Impact Risk';
            $history->previous = 'Null';
            $history->current = $EHS->Legal_Impact_Risk;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Business_Impact_Risk)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Business Impact Risk';
            $history->previous = 'Null';
            $history->current = $EHS->Business_Impact_Risk;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Revenue_Impact_Risk)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Revenue Impact Risk';
            $history->previous = 'Null';
            $history->current = $EHS->Revenue_Impact_Risk;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Brand_Impact_Risk)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Brand Impact Risk';
            $history->previous = 'Null';
            $history->current = $EHS->Brand_Impact_Risk;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Impact)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Impact';
            $history->previous = 'Null';
            $history->current = $EHS->Impact;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Impact_Analysis)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Impact Analysis';
            $history->previous = 'Null';
            $history->current = $EHS->Impact_Analysis;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Recommended_Actions)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Recommended Actions';
            $history->previous = 'Null';
            $history->current = $EHS->Recommended_Actions;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Comments2)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Comments';
            $history->previous = 'Null';
            $history->current = $EHS->Comments2;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Direct_Cause)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Direct Cause';
            $history->previous = 'Null';
            $history->current = $EHS->Direct_Cause;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Safeguarding_Measure_Taken2)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Safeguarding Measure Taken';
            $history->previous = 'Null';
            $history->current = $EHS->Safeguarding_Measure_Taken2;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->severity_rate)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Severity Rate';
            $history->previous = 'Null';
            $history->current = $EHS->severity_rate;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->occurrence)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Occurrence';
            $history->previous = 'Null';
            $history->current = $EHS->occurrence;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->detection)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Detection';
            $history->previous = 'Null';
            $history->current = $EHS->detection;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->rpn)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'RPN';
            $history->previous = 'Null';
            $history->current = $EHS->rpn;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Risk_Analysis)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Risk Analysis';
            $history->previous = 'Null';
            $history->current = $EHS->Risk_Analysis;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Critically)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Critically';
            $history->previous = 'Null';
            $history->current = $EHS->Critically;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Inform_Local_Authority)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Inform Local Authority?';
            $history->previous = 'Null';
            $history->current = $EHS->Inform_Local_Authority;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        if (! empty($EHS->Authority_Type)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Authority Type';
            $history->previous = 'Null';
            $history->current = $EHS->Authority_Type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Authority_Notified)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Authority Notified';
            $history->previous = 'Null';
            $history->current = $EHS->Authority_Notified;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Other_Authority)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Other Authority';
            $history->previous = 'Null';
            $history->current = $EHS->Other_Authority;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        //===================6==============================
        if (! empty($EHS->employee_id)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Employee ID';
            $history->previous = 'Null';
            $history->current = $EHS->employee_id;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->employee_name)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Employee Name';
            $history->previous = 'Null';
            $history->current = $EHS->employee_name;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->department2)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Department';
            $history->previous = 'Null';
            $history->current = $EHS->department2;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->phone_number)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Phone Number';
            $history->previous = 'Null';
            $history->current = $EHS->phone_number;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->email)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Email';
            $history->previous = 'Null';
            $history->current = $EHS->email;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->date_of_joining)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Date of Joining';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->date_of_joining);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->safety_training_records)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Safety Training Records';
            $history->previous = 'Null';
            $history->current = $EHS->safety_training_records;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->medical_history)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Medical History';
            $history->previous = 'Null';
            $history->current = $EHS->medical_history;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->personal_protective_equipment_compliance)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Personal Protective Equipment (PPE) Compliance';
            $history->previous = 'Null';
            $history->current = $EHS->personal_protective_equipment_compliance;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->emergency_contacts)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Emergency Contacts';
            $history->previous = 'Null';
            $history->current = $EHS->emergency_contacts;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->compliance_standards_regulations)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Compliance Standards/Regulations';
            $history->previous = 'Null';
            $history->current = $EHS->compliance_standards_regulations;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->regulatory_authority_agency)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Regulatory Authority/Agency';
            $history->previous = 'Null';
            $history->current = $EHS->regulatory_authority_agency;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->inspection_dates_and_reports)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Inspection Dates and Reports';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->inspection_dates_and_reports);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->audit_inspection_results)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Audit/Inspection Results';
            $history->previous = 'Null';
            $history->current = $EHS->audit_inspection_results;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->non_compliance_issues)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Non-compliance Issues';
            $history->previous = 'Null';
            $history->current = $EHS->non_compliance_issues;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->environmental_permits)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Environmental Permits';
            $history->previous = 'Null';
            $history->current = $EHS->environmental_permits;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->workplace_safety_certifications)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Workplace Safety Certifications';
            $history->previous = 'Null';
            $history->current = $EHS->workplace_safety_certifications;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->incident_id)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Incident ID';
            $history->previous = 'Null';
            $history->current = $EHS->incident_id;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->date_of_incident)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Date of Incident';
            $history->previous = 'Null';
            $history->current = Helpers::getdateFormat($EHS->date_of_incident);
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->time_of_incident)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Time of Incident';
            $history->previous = 'Null';
            $history->current = $EHS->time_of_incident;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->type_of_incident)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Type of Incident';
            $history->previous = 'Null';
            $history->current = $EHS->type_of_incident;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->incident_severity)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Incident Severity';
            $history->previous = 'Null';
            $history->current = $EHS->incident_severity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->location_of_incident)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Location of Incident';
            $history->previous = 'Null';
            $history->current = $EHS->location_of_incident;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->affected_personnel)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Affected Personnel';
            $history->previous = 'Null';
            $history->current = $EHS->affected_personnel;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->root_cause_analysis)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Root Cause Analysis';
            $history->previous = 'Null';
            $history->current = $EHS->root_cause_analysis;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->corrective_and_preventive_actions)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Corrective and Preventive Actions (CAPA)';
            $history->previous = 'Null';
            $history->current = $EHS->corrective_and_preventive_actions;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->investigation_reports)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Investigation Reports';
            $history->previous = 'Null';
            $history->current = $EHS->investigation_reports;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->injury_severity_and_report)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Injury Severity and Report';
            $history->previous = 'Null';
            $history->current = $EHS->injury_severity_and_report;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->incident_resolution_status)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Incident Resolution Status';
            $history->previous = 'Null';
            $history->current = $EHS->incident_resolution_status;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->workplace_safety_audits)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Workplace Safety Audits';
            $history->previous = 'Null';
            $history->current = $EHS->workplace_safety_audits;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->hazardous_area_identification)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Hazardous Area Identification';
            $history->previous = 'Null';
            $history->current = $EHS->hazardous_area_identification;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->ventilation_systems_monitoring)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Ventilation Systems Monitoring';
            $history->previous = 'Null';
            $history->current = $EHS->ventilation_systems_monitoring;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->noise_levels_monitoring)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Noise Levels Monitoring';
            $history->previous = 'Null';
            $history->current = $EHS->noise_levels_monitoring;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->lighting_and_temperature_monitoring)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Lighting and Temperature Monitoring';
            $history->previous = 'Null';
            $history->current = $EHS->lighting_and_temperature_monitoring;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->personal_monitoring)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Personal Monitoring (Health and Safety Data)';
            $history->previous = 'Null';
            $history->current = $EHS->personal_monitoring;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->ergonomics_data)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Ergonomics Data';
            $history->previous = 'Null';
            $history->current = $EHS->ergonomics_data;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Employee_Health_Records)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Employee Health Records';
            $history->previous = 'Null';
            $history->current = $EHS->Employee_Health_Records;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Occupational_Exposure_Limits)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Occupational Exposure Limits';
            $history->previous = 'Null';
            $history->current = $EHS->Occupational_Exposure_Limits;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Vaccination_Records)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Vaccination Records';
            $history->previous = 'Null';
            $history->current = $EHS->Vaccination_Records;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Pre_employment_and_Routine_Health_Screenings)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Pre-employment and Routine Health Screenings';
            $history->previous = 'Null';
            $history->current = $EHS->Pre_employment_and_Routine_Health_Screenings;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Workplace_Injury_and_Illness_Reporting)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Workplace Injury and Illness Reporting';
            $history->previous = 'Null';
            $history->current = $EHS->Workplace_Injury_and_Illness_Reporting;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Absenteeism_Data)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Absenteeism Data';
            $history->previous = 'Null';
            $history->current = $EHS->Absenteeism_Data;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Safety_Drills_and_Training_Records)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Safety Drills and Training Records';
            $history->previous = 'Null';
            $history->current = $EHS->Safety_Drills_and_Training_Records;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->First_Aid_and_Emergency_Response_Records)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'First Aid and Emergency Response Records';
            $history->previous = 'Null';
            $history->current = $EHS->First_Aid_and_Emergency_Response_Records;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Emergency_Plan)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Emergency Plan';
            $history->previous = 'Null';
            $history->current = $EHS->Emergency_Plan;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Emergency_Contacts2)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Emergency Contacts';
            $history->previous = 'Null';
            $history->current = $EHS->Emergency_Contacts2;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Emergency_Equipment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Emergency Equipment';
            $history->previous = 'Null';
            $history->current = $EHS->Emergency_Equipment;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Incident_Simulation_Drills)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Incident Simulation Drills';
            $history->previous = 'Null';
            $history->current = $EHS->Incident_Simulation_Drills;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Response_Time_Metrics)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Response Time Metrics';
            $history->previous = 'Null';
            $history->current = $EHS->Response_Time_Metrics;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Evacuation_Routes_and_Assembly_Points)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Evacuation Routes and Assembly Points';
            $history->previous = 'Null';
            $history->current = $EHS->Evacuation_Routes_and_Assembly_Points;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Energy_Consumption)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Energy Consumption';
            $history->previous = 'Null';
            $history->current = $EHS->Energy_Consumption;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Greenhouse_Gas_Emissions)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Greenhouse Gas Emissions';
            $history->previous = 'Null';
            $history->current = $EHS->Greenhouse_Gas_Emissions;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Wastewater_Discharge)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Wastewater Discharge';
            $history->previous = 'Null';
            $history->current = $EHS->Wastewater_Discharge;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Air_Quality_Monitoring)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Air Quality Monitoring';
            $history->previous = 'Null';
            $history->current = $EHS->Air_Quality_Monitoring;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Environmental_Sustainability_Projects)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Environmental Sustainability Projects';
            $history->previous = 'Null';
            $history->current = $EHS->Environmental_Sustainability_Projects;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }
        //=================================================

        if (! empty($EHS->enargy_type)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Enargy Type';
            $history->previous = 'Null';
            $history->current = $EHS->enargy_type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->enargy_source)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Enargy Source';
            $history->previous = 'Null';
            $history->current = $EHS->enargy_source;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->energy_usage)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Energy Usage';
            $history->previous = 'Null';
            $history->current = $EHS->energy_usage;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->energy_intensity)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Energy Intensity';
            $history->previous = 'Null';
            $history->current = $EHS->energy_intensity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->peak_demand)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Peak Demand';
            $history->previous = 'Null';
            $history->current = $EHS->peak_demand;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->energy_efficiency)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Energy Efficiency';
            $history->previous = 'Null';
            $history->current = $EHS->energy_efficiency;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->co_emissions)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'CO Emissions';
            $history->previous = 'Null';
            $history->current = $EHS->co_emissions;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->greenhouse_ges_emmission)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Greenhouse Ges Emmission';
            $history->previous = 'Null';
            $history->current = $EHS->greenhouse_ges_emmission;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->scope_one_emission)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Scope One Emission';
            $history->previous = 'Null';
            $history->current = $EHS->scope_one_emission;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->scope_two_emission)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Scope Two Emission';
            $history->previous = 'Null';
            $history->current = $EHS->scope_two_emission;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->scope_three_emission)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Scope Three Emission';
            $history->previous = 'Null';
            $history->current = $EHS->scope_three_emission;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->carbon_intensity)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Carbon Intensity';
            $history->previous = 'Null';
            $history->current = $EHS->carbon_intensity;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->water_consumption)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Water Consumption';
            $history->previous = 'Null';
            $history->current = $EHS->water_consumption;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->water_source)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Water Source';
            $history->previous = 'Null';
            $history->current = $EHS->water_source;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->water_effeciency)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Water Effeciency';
            $history->previous = 'Null';
            $history->current = $EHS->water_effeciency;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->water_discharge)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Water Discharge';
            $history->previous = 'Null';
            $history->current = $EHS->water_discharge;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->waste_water_treatment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Waste Water Treatment';
            $history->previous = 'Null';
            $history->current = $EHS->waste_water_treatment;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->rainwater_harvesting)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Rainwater Harvesting';
            $history->previous = 'Null';
            $history->current = $EHS->rainwater_harvesting;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->sustainable_product_purchased)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Sustainable Product Purchased';
            $history->previous = 'Null';
            $history->current = $EHS->sustainable_product_purchased;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->supplier_sustainability)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Supplier Sustainability';
            $history->previous = 'Null';
            $history->current = $EHS->supplier_sustainability;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->sustainable_packaing)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Sustainable Packaing';
            $history->previous = 'Null';
            $history->current = $EHS->sustainable_packaing;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->local_sourcing)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Local Sourcing';
            $history->previous = 'Null';
            $history->current = $EHS->local_sourcing;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->fair_trade)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Fair Trade';
            $history->previous = 'Null';
            $history->current = $EHS->fair_trade;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->fuel_consumption)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Fuel Consumption';
            $history->previous = 'Null';
            $history->current = $EHS->fuel_consumption;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Vehicle_Type1)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Vehicle Type';
            $history->previous = 'Null';
            $history->current = $EHS->Vehicle_Type1;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->fleet_emissions)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Fleet Emissions';
            $history->previous = 'Null';
            $history->current = $EHS->fleet_emissions;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->miles_traveled)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Miles Traveled';
            $history->previous = 'Null';
            $history->current = $EHS->miles_traveled;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->freight_and_shipping)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Freight and Shipping';
            $history->previous = 'Null';
            $history->current = $EHS->freight_and_shipping;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->carbon_pffset_programs)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Carbon Offset Programs';
            $history->previous = 'Null';
            $history->current = $EHS->carbon_pffset_programs;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->land_area_impacted)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Land Area Impacted';
            $history->previous = 'Null';
            $history->current = $EHS->land_area_impacted;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->protected_areas)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Protected Areas';
            $history->previous = 'Null';
            $history->current = $EHS->protected_areas;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->deforestation)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Deforestation';
            $history->previous = 'Null';
            $history->current = $EHS->deforestation;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->habitat_preservation)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Habitat Preservation';
            $history->previous = 'Null';
            $history->current = $EHS->habitat_preservation;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->biodiversity_initiatives)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Biodiversity Initiatives';
            $history->previous = 'Null';
            $history->current = $EHS->biodiversity_initiatives;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->certifications)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Certifications';
            $history->previous = 'Null';
            $history->current = $EHS->certifications;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->regulatory_compliance)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Regulatory Compliance';
            $history->previous = 'Null';
            $history->current = $EHS->regulatory_compliance;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->audits)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Audits';
            $history->previous = 'Null';
            $history->current = $EHS->audits;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->enviromental_risk)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Enviromental Risk';
            $history->previous = 'Null';
            $history->current = $EHS->enviromental_risk;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->impact_assessment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Impact Assessment';
            $history->previous = 'Null';
            $history->current = $EHS->impact_assessment;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->climate_change_adaptation)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Climate Change Adaptation';
            $history->previous = 'Null';
            $history->current = $EHS->climate_change_adaptation;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->carbon_footprint)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Carbon Footprint';
            $history->previous = 'Null';
            $history->current = $EHS->carbon_footprint;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Risk_Assessment_Data)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Risk Assessment Data';
            $history->previous = 'Null';
            $history->current = $EHS->Risk_Assessment_Data;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->hazard_id_reports)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Hazard Id Reports';
            $history->previous = 'Null';
            $history->current = $EHS->hazard_id_reports;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->risk_migration_plan)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Risk Migration Plan';
            $history->previous = 'Null';
            $history->current = $EHS->risk_migration_plan;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->corrective_action)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Corrective Action';
            $history->previous = 'Null';
            $history->current = $EHS->corrective_action;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->audit_id)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Audit Id';
            $history->previous = 'Null';
            $history->current = $EHS->audit_id;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Audit_Type)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Audit Type';
            $history->previous = 'Null';
            $history->current = $EHS->Audit_Type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->audit_date)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Audit Date';
            $history->previous = 'Null';
            $history->current = $EHS->audit_date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->audit_scope)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Audit Scope';
            $history->previous = 'Null';
            $history->current = $EHS->audit_scope;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->finding_and_observation)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Finding and Observation';
            $history->previous = 'Null';
            $history->current = $EHS->finding_and_observation;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->corrective_action_plans)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Corrective Action Plans';
            $history->previous = 'Null';
            $history->current = $EHS->corrective_action_plans;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->follow_up_audit_result)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Follow Up Audit Result';
            $history->previous = 'Null';
            $history->current = $EHS->follow_up_audit_result;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->sustainability_initiatives)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Sustainability Initiatives';
            $history->previous = 'Null';
            $history->current = $EHS->sustainability_initiatives;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->csr_activities)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'CSR Activities';
            $history->previous = 'Null';
            $history->current = $EHS->csr_activities;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->sustainability_reporting)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Sustainability Reporting';
            $history->previous = 'Null';
            $history->current = $EHS->sustainability_reporting;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->public_relation_report)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Public Relation Report';
            $history->previous = 'Null';
            $history->current = $EHS->public_relation_report;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Dashboards)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Dashboards';
            $history->previous = 'Null';
            $history->current = $EHS->Dashboards;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->key_performance_indicators)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Key Performance Indicators';
            $history->previous = 'Null';
            $history->current = $EHS->key_performance_indicators;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->trend_analysis)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Trend Analysis';
            $history->previous = 'Null';
            $history->current = $EHS->trend_analysis;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->data_export_functionality)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Data Export Functionality';
            $history->previous = 'Null';
            $history->current = $EHS->data_export_functionality;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->monthly_annual_reports)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Monthly Annual Reports';
            $history->previous = 'Null';
            $history->current = $EHS->monthly_annual_reports;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->KPIs)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'KPIs (Key Performance Indicators)';
            $history->previous = 'Null';
            $history->current = $EHS->KPIs;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->sustainability_targets)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Sustainability Targets';
            $history->previous = 'Null';
            $history->current = $EHS->sustainability_targets;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->progress_towards_goals)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Progress Towards Goals';
            $history->previous = 'Null';
            $history->current = $EHS->progress_towards_goals;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->training_programs)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Training Programs';
            $history->previous = 'Null';
            $history->current = $EHS->training_programs;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->employee_involcement)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Employee Involcement';
            $history->previous = 'Null';
            $history->current = $EHS->employee_involcement;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->sustainability_awareness)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Sustainability Awareness';
            $history->previous = 'Null';
            $history->current = $EHS->sustainability_awareness;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->community_project)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Community Project';
            $history->previous = 'Null';
            $history->current = $EHS->community_project;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->Partnerships)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Partnerships';
            $history->previous = 'Null';
            $history->current = $EHS->Partnerships;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        if (! empty($EHS->social_impact)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $EHS->id;
            $history->activity_type = 'Social Impact';
            $history->previous = 'Null';
            $history->current = $EHS->social_impact;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $EHS->status;
            $history->change_to = 'Opened';
            $history->change_from = 'Null';
            $history->action_name = 'Create';
            $history->save();
        }

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        toastr()->success('Record is Create Successfully');

        return redirect(url('rcms/qms-dashboard'));

    }

    public function show($id)
    {

        $data = EHSEvent::find($id);
        $EHS = EHSEvent::find($id);
        $EHSGrid = EHSRootCauseMethadologyGrid::find($id);
        $documents = Document::all();

        $WitnessesInfo = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $id, 'identifier' => 'Witnesses Information'])->first();
        $MaterialReleasedInfo = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $id, 'identifier' => 'Material Released'])->first();
        $RootCauseInfo = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $id, 'identifier' => 'Root Cause'])->first();
        $ChemicalandHazardous = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $id, 'identifier' => 'Chemical And Hazardous Materials'])->first();
        $WasteManagementInfo = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $id, 'identifier' => 'Waste Management'])->first();

        $trainingGrid = EHSTrainingAndAwarenesssGrid::where(['ehsEvent_id' => $id, 'identifier' => 'EHSTrainingAndAwareness'])->first();
        $trainingPlanData = $trainingGrid ? (is_array($trainingGrid->data) ? $trainingGrid->data : json_decode($trainingGrid->data, true)) : [];

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $EHS->record = str_pad($EHS->record, 4, '0', STR_PAD_LEFT);
        $EHS->assign_to_name = User::where('id', $EHS->assign_id)->value('name');
        $EHS->initiator_name = User::where('id', $EHS->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.ehs-event.ehs_event_view', compact('data', 'record_number', 'EHS', 'EHSGrid', 'WitnessesInfo', 'MaterialReleasedInfo', 'RootCauseInfo', 'documents', 'ChemicalandHazardous', 'WasteManagementInfo', 'trainingPlanData'));
    }

    public function update(Request $request, $id)
    {
        $lastDocument = EHSEvent::find($id);
        $EHS = EHSEvent::find($id);

        $EHS->assign_to = $request->assign_to;
        // $EHS->due_date = $request->due_date;
        $EHS->short_description = $request->short_description;
        $EHS->Type = $request->Type;
        $EHS->Incident_Sub_Type = $request->Incident_Sub_Type;
        $EHS->Date_Occurred = $request->Date_Occurred;
        $EHS->Time_Occurred = $request->Time_Occurred;
        $EHS->Similar_Incidents = $request->Similar_Incidents;
        $EHS->Date_Of_Reporting = $request->Date_Of_Reporting;
        $EHS->Reporter = $request->Reporter;
        $EHS->Description = $request->Description;
        $EHS->Immediate_Actions = $request->Immediate_Actions;
        $EHS->Accident_Type = $request->Accident_Type;
        $EHS->OSHA_Reportable = $request->OSHA_Reportable;
        $EHS->First_Lost_Work_Date = $request->First_Lost_Work_Date;
        $EHS->Last_Lost_Work_Date = $request->Last_Lost_Work_Date;
        $EHS->First_Restricted_Work_Date = $request->First_Restricted_Work_Date;
        $EHS->Last_Restricted_Work_Date = $request->Last_Restricted_Work_Date;
        $EHS->Vehicle_Type = $request->Vehicle_Type;
        $EHS->Vehicle_Number = $request->Vehicle_Number;
        $EHS->Litigation = $request->Litigation;
        $EHS->Department = $request->Department;
        $EHS->Employees_Involved = $request->Employees_Involved;
        $EHS->Involved_Contractors = $request->Involved_Contractors;
        $EHS->Attorneys_Involved = $request->Attorneys_Involved;
        $EHS->Lead_Investigator = $request->Lead_Investigator;
        $EHS->Line_Operator = $request->Line_Operator;
        $EHS->Reporter2 = $request->Reporter2;
        $EHS->Supervisor = $request->Supervisor;
        $EHS->Unsafe_Situation = $request->Unsafe_Situation;
        $EHS->Safeguarding_Measure_Taken = $request->Safeguarding_Measure_Taken;
        $EHS->Environmental_Category = $request->Environmental_Category;
        $EHS->Special_Weather_Conditions = $request->Special_Weather_Conditions;
        $EHS->Source_Of_Release_Or_Spill = $request->Source_Of_Release_Or_Spill;
        $EHS->Cause_Of_Release_Or_Spill = $request->Cause_Of_Release_Or_Spill;
        $EHS->Threat_Caused_By_Release_Spill = $request->Threat_Caused_By_Release_Spill;
        $EHS->Environment_Evacuation_Ordered = $request->Environment_Evacuation_Ordered;
        $EHS->Date_Samples_Taken = $request->Date_Samples_Taken;
        $EHS->Agencys_Notified = $request->Agencys_Notified;
        $EHS->Fire_Category = $request->Fire_Category;
        $EHS->Fire_Evacuation_Ordered = $request->Fire_Evacuation_Ordered;
        $EHS->Combat_By = $request->Combat_By;
        $EHS->Fire_Fighting_Equipment_Used = $request->Fire_Fighting_Equipment_Used;
        $EHS->zone = $request->zone;
        $EHS->country = $request->country;
        $EHS->state = $request->state;
        $EHS->city = $request->city;
        $EHS->Site_Name = $request->Site_Name;
        $EHS->Building = $request->Building;
        $EHS->Floor = $request->Floor;
        $EHS->Room = $request->Room;
        $EHS->Location = $request->Location;
        $EHS->Victim = $request->Victim;
        $EHS->Medical_Treatment = $request->Medical_Treatment;
        $EHS->Victim_Position = $request->Victim_Position;
        $EHS->Victim_Relation_To_Company = $request->Victim_Relation_To_Company;
        $EHS->Hospitalization = $request->Hospitalization;
        $EHS->Hospital_Name = $request->Hospital_Name;
        $EHS->Date_Of_Treatment = $request->Date_Of_Treatment;
        $EHS->Victim_Treated_By = $request->Victim_Treated_By;
        $EHS->Medical_Treatment_Description = $request->Medical_Treatment_Description;
        $EHS->Injury_Type = $request->Injury_Type;
        $EHS->Number_Of_Injuries = $request->Number_Of_Injuries;
        $EHS->Type_Of_Injuries = $request->Type_Of_Injuries;
        $EHS->Injured_Body_Parts = $request->Injured_Body_Parts;
        $EHS->Type_Of_Illness = $request->Type_Of_Illness;
        $EHS->Permanent_Disability = $request->Permanent_Disability;
        $EHS->Damage_Category = $request->Damage_Category;
        $EHS->Related_Equipment = $request->Related_Equipment;
        $EHS->Estimated_Amount_Of_Damage = $request->Estimated_Amount_Of_Damage;
        $EHS->Currency = $request->Currency;
        $EHS->Insurance_Company_Involved = $request->Insurance_Company_Involved;
        $EHS->Denied_By_Insurance_Company = $request->Denied_By_Insurance_Company;
        $EHS->Damage_Details = $request->Damage_Details;
        $EHS->Actual_Amount_Of_Damage = $request->Actual_Amount_Of_Damage;
        $EHS->Currency2 = $request->Currency2;
        $EHS->Investigation_Summary = $request->Investigation_Summary;
        $EHS->Conclusion = $request->Conclusion;
        $EHS->root_cause_methodology = implode(',', $request->root_cause_methodology);
        $EHS->Root_Cause_Description = $request->Root_Cause_Description;
        $EHS->Safety_Impact_Probability = $request->Safety_Impact_Probability;
        $EHS->Safety_Impact_Severity = $request->Safety_Impact_Severity;
        $EHS->Legal_Impact_Probability = $request->Legal_Impact_Probability;
        $EHS->Legal_Impact_Severity = $request->Legal_Impact_Severity;
        $EHS->Business_Impact_Probability = $request->Business_Impact_Probability;
        $EHS->Business_Impact_Severity = $request->Business_Impact_Severity;
        $EHS->Revenue_Impact_Probability = $request->Revenue_Impact_Probability;
        $EHS->Revenue_Impact_Severity = $request->Revenue_Impact_Severity;
        $EHS->Brand_Impact_Probability = $request->Brand_Impact_Probability;
        $EHS->Brand_Impact_Severity = $request->Brand_Impact_Severity;
        $EHS->Safety_Impact_Risk = $request->Safety_Impact_Risk;
        $EHS->Legal_Impact_Risk = $request->Legal_Impact_Risk;
        $EHS->Business_Impact_Risk = $request->Business_Impact_Risk;
        $EHS->Revenue_Impact_Risk = $request->Revenue_Impact_Risk;
        $EHS->Brand_Impact_Risk = $request->Brand_Impact_Risk;
        $EHS->Impact = $request->Impact;
        $EHS->Impact_Analysis = $request->Impact_Analysis;
        $EHS->Recommended_Actions = $request->Recommended_Actions;
        $EHS->Comments2 = $request->Comments2;
        $EHS->Direct_Cause = $request->Direct_Cause;
        $EHS->Safeguarding_Measure_Taken2 = $request->Safeguarding_Measure_Taken2;
        $EHS->severity_rate = $request->severity_rate;
        $EHS->occurrence = $request->occurrence;
        $EHS->detection = $request->detection;
        $EHS->rpn = $request->rpn;
        $EHS->Risk_Analysis = $request->Risk_Analysis;
        $EHS->Critically = $request->Critically;
        $EHS->Inform_Local_Authority = $request->Inform_Local_Authority;
        $EHS->Authority_Type = $request->Authority_Type;
        $EHS->Authority_Notified = $request->Authority_Notified;
        $EHS->Other_Authority = $request->Other_Authority;

        if (! empty($request->Attached_File)) {
            $files = [];
            if ($request->hasfile('Attached_File')) {
                foreach ($request->file('Attached_File') as $file) {
                    $name = $request->name.'Attached_File'.rand(1, 100).'.'.$file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $EHS->Attached_File = json_encode($files);
        }

        if (! empty($request->why_problem_statement)) {
            $EHS->why_problem_statement = $request->why_problem_statement;
        }
        if (! empty($request->why_1)) {
            $EHS->why_1 = serialize($request->why_1);
        }
        if (! empty($request->why_2)) {
            $EHS->why_2 = serialize($request->why_2);
        }
        if (! empty($request->why_3)) {
            $EHS->why_3 = serialize($request->why_3);
        }
        if (! empty($request->why_4)) {
            $EHS->why_4 = serialize($request->why_4);
        }
        if (! empty($request->why_5)) {
            $EHS->why_5 = serialize($request->why_5);
        }
        if (! empty($request->why_root_cause)) {
            $EHS->why_root_cause = $request->why_root_cause;
        }

        // Is/Is Not Analysis (Launch Instruction)
        $EHS->what_will_be = ($request->what_will_be);
        $EHS->what_will_not_be = ($request->what_will_not_be);
        $EHS->what_rationable = ($request->what_rationable);

        $EHS->where_will_be = ($request->where_will_be);
        $EHS->where_will_not_be = ($request->where_will_not_be);
        $EHS->where_rationable = ($request->where_rationable);

        $EHS->when_will_be = ($request->when_will_be);
        $EHS->when_will_not_be = ($request->when_will_not_be);
        $EHS->when_rationable = ($request->when_rationable);

        $EHS->coverage_will_be = ($request->coverage_will_be);
        $EHS->coverage_will_not_be = ($request->coverage_will_not_be);
        $EHS->coverage_rationable = ($request->coverage_rationable);

        $EHS->who_will_be = ($request->who_will_be);
        $EHS->who_will_not_be = ($request->who_will_not_be);
        $EHS->who_rationable = ($request->who_rationable);

        //Failure Mode and Effect Analysis+

        if (! empty($request->risk_factor)) {
            $EHS->risk_factor = serialize($request->risk_factor);
        }
        if (! empty($request->risk_element)) {
            $EHS->risk_element = serialize($request->risk_element);
        }
        if (! empty($request->problem_cause)) {
            $EHS->problem_cause = serialize($request->problem_cause);
        }
        if (! empty($request->existing_risk_control)) {
            $EHS->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (! empty($request->initial_severity)) {
            $EHS->initial_severity = serialize($request->initial_severity);
        }
        if (! empty($request->initial_detectability)) {
            $EHS->initial_detectability = serialize($request->initial_detectability);
        }
        if (! empty($request->initial_probability)) {
            $EHS->initial_probability = serialize($request->initial_probability);
        }
        if (! empty($request->initial_rpn)) {
            $EHS->initial_rpn = serialize($request->initial_rpn);
        }

        if (! empty($request->risk_control_measure)) {
            $EHS->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (! empty($request->residual_severity)) {
            $EHS->residual_severity = serialize($request->residual_severity);
        }
        if (! empty($request->residual_probability)) {
            $EHS->residual_probability = serialize($request->residual_probability);
        }
        if (! empty($request->residual_detectability)) {
            $EHS->residual_detectability = serialize($request->residual_detectability);
        }
        if (! empty($request->residual_rpn)) {
            $EHS->residual_rpn = serialize($request->residual_rpn);
        }
        if (! empty($request->risk_acceptance)) {
            $EHS->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (! empty($request->risk_acceptance2)) {
            $EHS->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (! empty($request->mitigation_proposal)) {
            $EHS->mitigation_proposal = serialize($request->mitigation_proposal);
        }

        // Fishbone or Ishikawa Diagram +  (Launch Instruction)

        if (! empty($request->measurement)) {
            $EHS->measurement = serialize($request->measurement);
        }
        if (! empty($request->materials)) {
            $EHS->materials = serialize($request->materials);
        }
        if (! empty($request->methods)) {
            $EHS->methods = serialize($request->methods);
        }
        if (! empty($request->environment)) {
            $EHS->environment = serialize($request->environment);
        }
        if (! empty($request->manpower)) {
            $EHS->manpower = serialize($request->manpower);
        }
        if (! empty($request->machine)) {
            $EHS->machine = serialize($request->machine);
        }
        if (! empty($request->problem_statement)) {
            $EHS->problem_statement = $request->problem_statement;
        }

        // Inference

        if (! empty($request->inference_type)) {
            $EHS->inference_type = serialize($request->inference_type);
        }
        if (! empty($request->inference_remarks)) {
            $EHS->inference_remarks = serialize($request->inference_remarks);
        }

        $EHS->employee_id = $request->employee_id;
        $EHS->employee_name = $request->employee_name;
        $EHS->designation = $request->designation;
        $EHS->Department2 = $request->Department2;
        $EHS->phone_number = $request->phone_number;
        $EHS->email = $request->email;
        $EHS->date_of_joining = $request->date_of_joining;
        $EHS->safety_training_records = $request->safety_training_records;
        $EHS->medical_history = $request->medical_history;
        $EHS->personal_protective_equipment_compliance = $request->personal_protective_equipment_compliance;
        $EHS->emergency_contacts = $request->emergency_contacts;

        $EHS->compliance_standards_regulations = $request->compliance_standards_regulations;
        $EHS->regulatory_authority_agency = $request->regulatory_authority_agency;
        $EHS->inspection_dates_and_reports = $request->inspection_dates_and_reports;
        $EHS->audit_inspection_results = $request->audit_inspection_results;
        $EHS->non_compliance_issues = $request->non_compliance_issues;
        $EHS->environmental_permits = $request->environmental_permits;
        $EHS->workplace_safety_certifications = $request->workplace_safety_certifications;

        $EHS->incident_id = $request->incident_id;
        $EHS->date_of_incident = $request->date_of_incident;
        $EHS->time_of_incident = $request->time_of_incident;
        $EHS->type_of_incident = $request->type_of_incident;
        $EHS->incident_severity = $request->incident_severity;
        $EHS->location_of_incident = $request->location_of_incident;
        $EHS->affected_personnel = $request->affected_personnel;
        $EHS->root_cause_analysis = $request->root_cause_analysis;
        $EHS->corrective_and_preventive_actions = $request->corrective_and_preventive_actions;
        $EHS->investigation_reports = $request->investigation_reports;
        $EHS->injury_severity_and_report = $request->injury_severity_and_report;
        $EHS->incident_resolution_status = $request->incident_resolution_status;

        $EHS->workplace_safety_audits = $request->workplace_safety_audits;
        $EHS->hazardous_area_identification = $request->hazardous_area_identification;
        $EHS->ventilation_systems_monitoring = $request->ventilation_systems_monitoring;
        $EHS->noise_levels_monitoring = $request->noise_levels_monitoring;
        $EHS->lighting_and_temperature_monitoring = $request->lighting_and_temperature_monitoring;
        $EHS->personal_monitoring = $request->personal_monitoring;
        $EHS->ergonomics_data = $request->ergonomics_data;

        $EHS->Employee_Health_Records = $request->Employee_Health_Records;
        $EHS->Occupational_Exposure_Limits = $request->Occupational_Exposure_Limits;
        $EHS->Vaccination_Records = $request->Vaccination_Records;
        $EHS->Pre_employment_and_Routine_Health_Screenings = $request->Pre_employment_and_Routine_Health_Screenings;
        $EHS->Workplace_Injury_and_Illness_Reporting = $request->Workplace_Injury_and_Illness_Reporting;
        $EHS->Absenteeism_Data = $request->Absenteeism_Data;
        $EHS->Safety_Drills_and_Training_Records = $request->Safety_Drills_and_Training_Records;
        $EHS->First_Aid_and_Emergency_Response_Records = $request->First_Aid_and_Emergency_Response_Records;

        $EHS->Emergency_Plan = $request->Emergency_Plan;
        $EHS->Emergency_Contacts2 = $request->Emergency_Contacts2;
        $EHS->Emergency_Equipment = $request->Emergency_Equipment;
        $EHS->Incident_Simulation_Drills = $request->Incident_Simulation_Drills;
        $EHS->Response_Time_Metrics = $request->Response_Time_Metrics;
        $EHS->Evacuation_Routes_and_Assembly_Points = $request->Evacuation_Routes_and_Assembly_Points;

        $EHS->Energy_Consumption = $request->Energy_Consumption;
        $EHS->Greenhouse_Gas_Emissions = $request->Greenhouse_Gas_Emissions;
        $EHS->Wastewater_Discharge = $request->Wastewater_Discharge;
        $EHS->Air_Quality_Monitoring = $request->Air_Quality_Monitoring;
        $EHS->Environmental_Sustainability_Projects = $request->Environmental_Sustainability_Projects;

        $EHS->enargy_type = $request->enargy_type;
        $EHS->enargy_source = $request->enargy_source;
        $EHS->energy_usage = $request->energy_usage;
        $EHS->energy_intensity = $request->energy_intensity;
        $EHS->peak_demand = $request->peak_demand;
        $EHS->energy_efficiency = $request->energy_efficiency;
        $EHS->co_emissions = $request->co_emissions;
        $EHS->greenhouse_ges_emmission = $request->greenhouse_ges_emmission;
        $EHS->scope_one_emission = $request->scope_one_emission;
        $EHS->scope_two_emission = $request->scope_two_emission;
        $EHS->scope_three_emission = $request->scope_three_emission;
        $EHS->carbon_intensity = $request->carbon_intensity;
        $EHS->water_consumption = $request->water_consumption;
        $EHS->water_source = $request->water_source;
        $EHS->water_effeciency = $request->water_effeciency;
        $EHS->water_discharge = $request->water_discharge;
        $EHS->waste_water_treatment = $request->waste_water_treatment;
        $EHS->rainwater_harvesting = $request->rainwater_harvesting;
        $EHS->sustainable_product_purchased = $request->sustainable_product_purchased;
        $EHS->supplier_sustainability = $request->supplier_sustainability;
        $EHS->sustainable_packaing = $request->sustainable_packaing;
        $EHS->local_sourcing = $request->local_sourcing;
        $EHS->fair_trade = $request->fair_trade;
        $EHS->fuel_consumption = $request->fuel_consumption;
        $EHS->Vehicle_Type1 = $request->Vehicle_Type1;
        $EHS->fleet_emissions = $request->fleet_emissions;
        $EHS->miles_traveled = $request->miles_traveled;
        $EHS->freight_and_shipping = $request->freight_and_shipping;
        $EHS->carbon_pffset_programs = $request->carbon_pffset_programs;
        $EHS->land_area_impacted = $request->land_area_impacted;
        $EHS->protected_areas = $request->protected_areas;
        $EHS->deforestation = $request->deforestation;
        $EHS->habitat_preservation = $request->habitat_preservation;
        $EHS->biodiversity_initiatives = $request->biodiversity_initiatives;
        $EHS->certifications = $request->certifications;
        $EHS->regulatory_compliance = $request->regulatory_compliance;
        $EHS->audits = $request->audits;
        $EHS->enviromental_risk = $request->enviromental_risk;
        $EHS->impact_assessment = $request->impact_assessment;
        $EHS->climate_change_adaptation = $request->climate_change_adaptation;
        $EHS->carbon_footprint = $request->carbon_footprint;
        $EHS->Risk_Assessment_Data = $request->Risk_Assessment_Data;
        $EHS->hazard_id_reports = $request->hazard_id_reports;

        //Failure Mode and Effect Analysis+

        if (! empty($request->risk_factor1)) {
            $EHS->risk_factor1 = serialize($request->risk_factor1);
        }
        if (! empty($request->risk_element1)) {
            $EHS->risk_element1 = serialize($request->risk_element1);
        }
        if (! empty($request->problem_cause1)) {
            $EHS->problem_cause1 = serialize($request->problem_cause1);
        }
        if (! empty($request->existing_risk_control1)) {
            $EHS->existing_risk_control1 = serialize($request->existing_risk_control1);
        }
        if (! empty($request->initial_severity1)) {
            $EHS->initial_severity1 = serialize($request->initial_severity1);
        }
        if (! empty($request->initial_detectability1)) {
            $EHS->initial_detectability1 = serialize($request->initial_detectability1);
        }
        if (! empty($request->initial_probability1)) {
            $EHS->initial_probability1 = serialize($request->initial_probability1);
        }
        if (! empty($request->initial_rpn1)) {
            $EHS->initial_rpn1 = serialize($request->initial_rpn1);
        }

        if (! empty($request->risk_control_measure1)) {
            $EHS->risk_control_measure1 = serialize($request->risk_control_measure1);
        }
        if (! empty($request->residual_severity1)) {
            $EHS->residual_severity1 = serialize($request->residual_severity1);
        }
        if (! empty($request->residual_probability1)) {
            $EHS->residual_probability1 = serialize($request->residual_probability1);
        }
        if (! empty($request->residual_detectability1)) {
            $EHS->residual_detectability1 = serialize($request->residual_detectability1);
        }
        if (! empty($request->residual_rpn1)) {
            $EHS->residual_rpn1 = serialize($request->residual_rpn1);
        }
        if (! empty($request->risk_acceptance1)) {
            $EHS->risk_acceptance1 = serialize($request->risk_acceptance1);
        }
        if (! empty($request->risk_acceptance3)) {
            $EHS->risk_acceptance3 = serialize($request->risk_acceptance3);
        }
        if (! empty($request->mitigation_proposal1)) {
            $EHS->mitigation_proposal1 = serialize($request->mitigation_proposal1);
        }

        $EHS->risk_migration_plan = $request->risk_migration_plan;
        $EHS->corrective_action = $request->corrective_action;
        $EHS->audit_id = $request->audit_id;
        $EHS->Audit_Type = $request->Audit_Type;
        $EHS->audit_date = $request->audit_date;
        $EHS->audit_scope = $request->audit_scope;
        $EHS->finding_and_observation = $request->finding_and_observation;
        $EHS->corrective_action_plans = $request->corrective_action_plans;
        $EHS->follow_up_audit_result = $request->follow_up_audit_result;
        $EHS->sustainability_initiatives = $request->sustainability_initiatives;
        $EHS->csr_activities = $request->csr_activities;
        $EHS->sustainability_reporting = $request->sustainability_reporting;
        $EHS->public_relation_report = $request->public_relation_report;
        $EHS->Dashboards = $request->Dashboards;
        $EHS->key_performance_indicators = $request->key_performance_indicators;
        $EHS->trend_analysis = $request->trend_analysis;
        $EHS->data_export_functionality = $request->data_export_functionality;
        $EHS->monthly_annual_reports = $request->monthly_annual_reports;
        $EHS->KPIs = $request->KPIs;
        $EHS->sustainability_targets = $request->sustainability_targets;
        $EHS->progress_towards_goals = $request->progress_towards_goals;
        $EHS->Goal_Name = $request->Goal_Name;
        $EHS->Goal_Description = $request->Goal_Description;
        $EHS->Responsible_Department = $request->Responsible_Department;
        $EHS->Goal_Timeframe = $request->Goal_Timeframe;
        $EHS->Region = $request->Region;
        $EHS->Energy_Source = $request->Energy_Source;
        $EHS->Energy_Consumption2 = $request->Energy_Consumption2;
        $EHS->Energy_Efficiency_Target = $request->Energy_Efficiency_Target;
        $EHS->Renewable_Energy_Usage_Target = $request->Renewable_Energy_Usage_Target;
        $EHS->Emission_Source = $request->Emission_Source;
        $EHS->Carbon_Footprint2 = $request->Carbon_Footprint2;
        $EHS->Reduction_Target = $request->Reduction_Target;
        $EHS->Offset_Mechanisms = $request->Offset_Mechanisms;
        $EHS->Water_Source2 = $request->Water_Source2;
        $EHS->Water_Consumption2 = $request->Water_Consumption2;
        $EHS->Water_Efficiency_Target = $request->Water_Efficiency_Target;
        $EHS->Recycled_Water_Usage_Target = $request->Recycled_Water_Usage_Target;
        $EHS->Waste_Type = $request->Waste_Type;
        $EHS->Waste_Quantity = $request->Waste_Quantity;
        $EHS->Recycling_Rate_Target = $request->Recycling_Rate_Target;
        $EHS->Disposal_Methods = $request->Disposal_Methods;
        $EHS->Protected_Areas_Covered = $request->Protected_Areas_Covered;
        $EHS->Species_Monitored = $request->Species_Monitored;
        $EHS->Habitat_Restoration_Target = $request->Habitat_Restoration_Target;
        $EHS->Biodiversity_Index_Score = $request->Biodiversity_Index_Score;
        $EHS->Supplier_Compliance = $request->Supplier_Compliance;
        $EHS->Percentage_of_Sustainable_Products = $request->Percentage_of_Sustainable_Products;
        $EHS->Local_Sourcing_Target = $request->Local_Sourcing_Target;
        $EHS->Product_Life_Extension_Target = $request->Product_Life_Extension_Target;
        $EHS->Material_Reusability = $request->Material_Reusability;
        $EHS->Recycled_Material_Usage = $request->Recycled_Material_Usage;
        $EHS->SDG_Alignment = $request->SDG_Alignment;
        $EHS->Compliance_Status = $request->Compliance_Status;
        $EHS->Progress_Measurement_Frequency = $request->Progress_Measurement_Frequency;
        $EHS->Recycled_Material_Usage1 = $request->Recycled_Material_Usage1;
        $EHS->Current_Progress = $request->Current_Progress;

        $EHS->training_programs = $request->training_programs;
        $EHS->employee_involcement = $request->employee_involcement;
        $EHS->sustainability_awareness = $request->sustainability_awareness;
        $EHS->community_project = $request->community_project;
        $EHS->Partnerships = $request->Partnerships;
        $EHS->social_impact = $request->social_impact;

        $EHS->update();

        $WitnessesInformationUpdate = $EHS->id;
        if (! empty($request->WitnessesInformation)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $WitnessesInformationUpdate, 'identifier' => 'Witnesses Information'])->firstOrNew();
            $summaryShow->ehsEvent_id = $WitnessesInformationUpdate;
            $summaryShow->identifier = 'Witnesses Information';
            $summaryShow->data1 = $request->WitnessesInformation;
            $summaryShow->update();
        }

        $MaterialReleasedUpdate = $EHS->id;
        if (! empty($request->MaterialReleased)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $MaterialReleasedUpdate, 'identifier' => 'Material Released'])->firstOrNew();
            $summaryShow->ehsEvent_id = $MaterialReleasedUpdate;
            $summaryShow->identifier = 'Material Released';
            $summaryShow->data1 = $request->MaterialReleased;
            $summaryShow->update();
        }

        $RootCauseUpdate = $EHS->id;
        if (! empty($request->RootCause)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $RootCauseUpdate, 'identifier' => 'Root Cause'])->firstOrNew();
            $summaryShow->ehsEvent_id = $RootCauseUpdate;
            $summaryShow->identifier = 'Root Cause';
            $summaryShow->data1 = $request->RootCause;
            $summaryShow->update();
        }

        $ChemicalAndHazardousMaterialsUpdate = $EHS->id;
        if (! empty($request->ChemicalAndHazardousMaterials)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $ChemicalAndHazardousMaterialsUpdate, 'identifier' => 'Chemical And Hazardous Materials'])->firstOrNew();
            $summaryShow->ehsEvent_id = $ChemicalAndHazardousMaterialsUpdate;
            $summaryShow->identifier = 'Chemical And Hazardous Materials';
            $summaryShow->data1 = $request->ChemicalAndHazardousMaterials;
            $summaryShow->update();
        }

        $WasteManagementUpdate = $EHS->id;
        if (! empty($request->WasteManagement)) {
            $summaryShow = EHSRootCauseMethadologyGrid::where(['ehsEvent_id' => $WasteManagementUpdate, 'identifier' => 'Waste Management'])->firstOrNew();
            $summaryShow->ehsEvent_id = $WasteManagementUpdate;
            $summaryShow->identifier = 'Waste Management';
            $summaryShow->data1 = $request->WasteManagement;
            $summaryShow->update();
        }

        $trainingGrid = EHSTrainingAndAwarenesssGrid::where(['ehsEvent_id' => $EHS->id, 'identifier' => 'EHSTrainingAndAwareness'])->firstOrCreate();
        $trainingGrid->ehsEvent_id = $EHS->id;
        $trainingPlanData = $request->trainingPlanData;

        foreach ($trainingPlanData as $index => $data) {
            if (! empty($data['file'])) {
                $file = $data['file'];
                $fileName = 'Training'.'_file_'.rand(1, 100).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('upload'), $fileName);

                $trainingPlanData[$index]['file_path'] = 'upload/'.$fileName;
                unset($trainingPlanData[$index]['file']);
            } else {
                $trainingPlanData[$index]['file_path'] = null;
            }
        }

        $trainingGrid->data = $trainingPlanData;
        $trainingGrid->identifier = 'EHSTrainingAndAwareness';
        $trainingGrid->save();

        if ($lastDocument->assign_to != $EHS->assign_to || ! empty($request->assign_to_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Assigned to';
            $history->previous = Helpers::getInitiatorName($lastDocument->assign_to);
            $history->current = Helpers::getInitiatorName($EHS->assign_to);
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->assign_to) || $lastDocument->assign_to === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->short_description != $EHS->short_description || ! empty($request->short_description_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $EHS->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->short_description) || $lastDocument->short_description === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Type != $EHS->Type || ! empty($request->Type_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Type';
            $history->previous = $lastDocument->Type;
            $history->current = $EHS->Type;
            $history->comment = $request->Type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Type) || $lastDocument->Type === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Incident_Sub_Type != $EHS->Incident_Sub_Type || ! empty($request->Incident_Sub_Type_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Incident Sub Type';
            $history->previous = $lastDocument->Incident_Sub_Type;
            $history->current = $EHS->Incident_Sub_Type;
            $history->comment = $request->Incident_Sub_Type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Incident_Sub_Type) || $lastDocument->Incident_Sub_Type === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Date_Occurred != $EHS->Date_Occurred || ! empty($request->Date_Occurred_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Date Occurred';
            $history->previous = Helpers::getdateFormat($lastDocument->Date_Occurred);
            $history->current = Helpers::getdateFormat($EHS->Date_Occurred);
            $history->comment = $request->Date_Occurred_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Date_Occurred) || $lastDocument->Date_Occurred === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Time_Occurred != $EHS->Time_Occurred || ! empty($request->Time_Occurred_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Time Occurred';
            $history->previous = $lastDocument->Time_Occurred;
            $history->current = $EHS->Time_Occurred;
            $history->comment = $request->Time_Occurred_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Time_Occurred) || $lastDocument->Time_Occurred === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Attached_File != $EHS->Attached_File || ! empty($request->Attached_File_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Attached File';
            $history->previous = str_replace(',', ', ', $lastDocument->Attached_File);
            $history->current = str_replace(',', ', ', $EHS->Attached_File);
            $history->comment = $request->Attached_File_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Attached_File) || $lastDocument->Attached_File === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Similar_Incidents != $EHS->Similar_Incidents || ! empty($request->Similar_Incidents_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Similar Incidents';
            $history->previous = $lastDocument->Similar_Incidents;
            $history->current = $EHS->Similar_Incidents;
            $history->comment = $request->Similar_Incidents_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Similar_Incidents) || $lastDocument->Similar_Incidents === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Date_Of_Reporting != $EHS->Date_Of_Reporting || ! empty($request->Date_Of_Reporting_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Date Of Reporting';
            $history->previous = Helpers::getdateFormat($lastDocument->Date_Of_Reporting);
            $history->current = Helpers::getdateFormat($EHS->Date_Of_Reporting);
            $history->comment = $request->Date_Of_Reporting_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Date_Of_Reporting) || $lastDocument->Date_Of_Reporting === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Reporter != $EHS->Reporter || ! empty($request->Reporter_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Reporter';
            $history->previous = Helpers::getInitiatorName($lastDocument->Reporter);
            $history->current = Helpers::getInitiatorName($EHS->Reporter);
            $history->comment = $request->Reporter_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Reporter) || $lastDocument->Reporter === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Description != $EHS->Description || ! empty($request->Description_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Description';
            $history->previous = $lastDocument->Description;
            $history->current = $EHS->Description;
            $history->comment = $request->Description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Description) || $lastDocument->Description === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Immediate_Actions != $EHS->Immediate_Actions || ! empty($request->Immediate_Actions_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Immediate Actions';
            $history->previous = $lastDocument->Immediate_Actions;
            $history->current = $EHS->Immediate_Actions;
            $history->comment = $request->Immediate_Actions_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Immediate_Actions) || $lastDocument->Immediate_Actions === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Accident_Type != $EHS->Accident_Type || ! empty($request->Accident_Type_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Accident Type';
            $history->previous = $lastDocument->Accident_Type;
            $history->current = $EHS->Accident_Type;
            $history->comment = $request->Accident_Type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Accident_Type) || $lastDocument->Accident_Type === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->OSHA_Reportable != $EHS->OSHA_Reportable || ! empty($request->OSHA_Reportable_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'OSHA Reportable';
            $history->previous = $lastDocument->OSHA_Reportable;
            $history->current = $EHS->OSHA_Reportable;
            $history->comment = $request->OSHA_Reportable_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->OSHA_Reportable) || $lastDocument->OSHA_Reportable === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->First_Lost_Work_Date != $EHS->First_Lost_Work_Date || ! empty($request->First_Lost_Work_Date_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'First Lost Work Date';
            $history->previous = Helpers::getdateFormat($lastDocument->First_Lost_Work_Date);
            $history->current = Helpers::getdateFormat($EHS->First_Lost_Work_Date);
            $history->comment = $request->First_Lost_Work_Date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->First_Lost_Work_Date) || $lastDocument->First_Lost_Work_Date === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Last_Lost_Work_Date != $EHS->Last_Lost_Work_Date || ! empty($request->Last_Lost_Work_Date_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Last Lost Work Date';
            $history->previous = Helpers::getdateFormat($lastDocument->Last_Lost_Work_Date);
            $history->current = Helpers::getdateFormat($EHS->Last_Lost_Work_Date);
            $history->comment = $request->Last_Lost_Work_Date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Last_Lost_Work_Date) || $lastDocument->Last_Lost_Work_Date === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->First_Restricted_Work_Date != $EHS->First_Restricted_Work_Date || ! empty($request->First_Restricted_Work_Date_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'First Restricted Work Date';
            $history->previous = Helpers::getdateFormat($lastDocument->First_Restricted_Work_Date);
            $history->current = Helpers::getdateFormat($EHS->First_Restricted_Work_Date);
            $history->comment = $request->First_Restricted_Work_Date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->First_Restricted_Work_Date) || $lastDocument->First_Restricted_Work_Date === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Last_Restricted_Work_Date != $EHS->Last_Restricted_Work_Date || ! empty($request->Last_Restricted_Work_Date_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Last Restricted Work Date';
            $history->previous = Helpers::getdateFormat($lastDocument->Last_Restricted_Work_Date);
            $history->current = Helpers::getdateFormat($EHS->Last_Restricted_Work_Date);
            $history->comment = $request->Last_Restricted_Work_Date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Last_Restricted_Work_Date) || $lastDocument->Last_Restricted_Work_Date === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Vehicle_Type != $EHS->Vehicle_Type || ! empty($request->Vehicle_Type_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Vehicle Type';
            $history->previous = $lastDocument->Vehicle_Type;
            $history->current = $EHS->Vehicle_Type;
            $history->comment = $request->Vehicle_Type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Vehicle_Type) || $lastDocument->Vehicle_Type === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Vehicle_Number != $EHS->Vehicle_Number || ! empty($request->Vehicle_Number_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Vehicle Number';
            $history->previous = $lastDocument->Vehicle_Number;
            $history->current = $EHS->Vehicle_Number;
            $history->comment = $request->Vehicle_Number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Vehicle_Number) || $lastDocument->Vehicle_Number === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Litigation != $EHS->Litigation || ! empty($request->Litigation_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Litigation';
            $history->previous = $lastDocument->Litigation;
            $history->current = $EHS->Litigation;
            $history->comment = $request->Litigation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Litigation) || $lastDocument->Litigation === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Department != $EHS->Department || ! empty($request->Department_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Department';
            $history->previous = $lastDocument->Department;
            $history->current = $EHS->Department;
            $history->comment = $request->Department_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Department) || $lastDocument->Department === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Employees_Involved != $EHS->Employees_Involved || ! empty($request->Employees_Involved_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Employees Involved';
            $history->previous = Helpers::getInitiatorName($lastDocument->Employees_Involved);
            $history->current = Helpers::getInitiatorName($EHS->Employees_Involved);
            $history->comment = $request->Employees_Involved_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Employees_Involved) || $lastDocument->Employees_Involved === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Involved_Contractors != $EHS->Involved_Contractors || ! empty($request->Involved_Contractors_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Involved Contractors';
            $history->previous = Helpers::getInitiatorName($lastDocument->Involved_Contractors);
            $history->current = Helpers::getInitiatorName($EHS->Involved_Contractors);
            $history->comment = $request->Involved_Contractors_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Involved_Contractors) || $lastDocument->Involved_Contractors === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Attorneys_Involved != $EHS->Attorneys_Involved || ! empty($request->Attorneys_Involved_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Attorneys Involved';
            $history->previous = Helpers::getInitiatorName($lastDocument->Attorneys_Involved);
            $history->current = Helpers::getInitiatorName($EHS->Attorneys_Involved);
            $history->comment = $request->Attorneys_Involved_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Attorneys_Involved) || $lastDocument->Attorneys_Involved === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Lead_Investigator != $EHS->Lead_Investigator || ! empty($request->Lead_Investigator_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = Helpers::getInitiatorName($lastDocument->Lead_Investigator);
            $history->current = Helpers::getInitiatorName($EHS->Lead_Investigator);
            $history->comment = $request->Lead_Investigator_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Lead_Investigator) || $lastDocument->Lead_Investigator === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Line_Operator != $EHS->Line_Operator || ! empty($request->Line_Operator_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Line Operator';
            $history->previous = Helpers::getInitiatorName($lastDocument->Line_Operator);
            $history->current = Helpers::getInitiatorName($EHS->Line_Operator);
            $history->comment = $request->Line_Operator_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Line_Operator) || $lastDocument->Line_Operator === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Reporter2 != $EHS->Reporter2 || ! empty($request->Reporter2_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Reporter';
            $history->previous = Helpers::getInitiatorName($lastDocument->Reporter2);
            $history->current = Helpers::getInitiatorName($EHS->Reporter2);
            $history->comment = $request->Reporter2_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Reporter2) || $lastDocument->Reporter2 === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Supervisor != $EHS->Supervisor || ! empty($request->Supervisor_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Supervisor';
            $history->previous = Helpers::getInitiatorName($lastDocument->Supervisor);
            $history->current = Helpers::getInitiatorName($EHS->Supervisor);
            $history->comment = $request->Supervisor_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Supervisor) || $lastDocument->Supervisor === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Unsafe_Situation != $EHS->Unsafe_Situation || ! empty($request->Unsafe_Situation_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Unsafe Situation';
            $history->previous = $lastDocument->Unsafe_Situation;
            $history->current = $EHS->Unsafe_Situation;
            $history->comment = $request->Unsafe_Situation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Unsafe_Situation) || $lastDocument->Unsafe_Situation === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Safeguarding_Measure_Taken != $EHS->Safeguarding_Measure_Taken || ! empty($request->Safeguarding_Measure_Taken_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Safeguarding Measure Taken';
            $history->previous = $lastDocument->Safeguarding_Measure_Taken;
            $history->current = $EHS->Safeguarding_Measure_Taken;
            $history->comment = $request->Safeguarding_Measure_Taken_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Safeguarding_Measure_Taken) || $lastDocument->Safeguarding_Measure_Taken === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Environmental_Category != $EHS->Environmental_Category || ! empty($request->Environmental_Category_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Environmental Category';
            $history->previous = $lastDocument->Environmental_Category;
            $history->current = $EHS->Environmental_Category;
            $history->comment = $request->Environmental_Category_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Environmental_Category) || $lastDocument->Environmental_Category === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Special_Weather_Conditions != $EHS->Special_Weather_Conditions || ! empty($request->Special_Weather_Conditions_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Special Weather Conditions';
            $history->previous = $lastDocument->Special_Weather_Conditions;
            $history->current = $EHS->Special_Weather_Conditions;
            $history->comment = $request->Special_Weather_Conditions_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Special_Weather_Conditions) || $lastDocument->Special_Weather_Conditions === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Source_Of_Release_Or_Spill != $EHS->Source_Of_Release_Or_Spill || ! empty($request->Source_Of_Release_Or_Spill_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Source Of Release Or Spill';
            $history->previous = $lastDocument->Source_Of_Release_Or_Spill;
            $history->current = $EHS->Source_Of_Release_Or_Spill;
            $history->comment = $request->Source_Of_Release_Or_Spill_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Source_Of_Release_Or_Spill) || $lastDocument->Source_Of_Release_Or_Spill === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Cause_Of_Release_Or_Spill != $EHS->Cause_Of_Release_Or_Spill || ! empty($request->Cause_Of_Release_Or_Spill_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Cause Of Release Or Spill';
            $history->previous = $lastDocument->Cause_Of_Release_Or_Spill;
            $history->current = $EHS->Cause_Of_Release_Or_Spill;
            $history->comment = $request->Cause_Of_Release_Or_Spill_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Cause_Of_Release_Or_Spill) || $lastDocument->Cause_Of_Release_Or_Spill === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Threat_Caused_By_Release_Spill != $EHS->Threat_Caused_By_Release_Spill || ! empty($request->Threat_Caused_By_Release_Spill_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Threat Caused By Release/Spill';
            $history->previous = $lastDocument->Threat_Caused_By_Release_Spill;
            $history->current = $EHS->Threat_Caused_By_Release_Spill;
            $history->comment = $request->Threat_Caused_By_Release_Spill_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Threat_Caused_By_Release_Spill) || $lastDocument->Threat_Caused_By_Release_Spill === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Environment_Evacuation_Ordered != $EHS->Environment_Evacuation_Ordered || ! empty($request->Environment_Evacuation_Ordered_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Environment Evacuation Ordered';
            $history->previous = $lastDocument->Environment_Evacuation_Ordered;
            $history->current = $EHS->Environment_Evacuation_Ordered;
            $history->comment = $request->Environment_Evacuation_Ordered_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Environment_Evacuation_Ordered) || $lastDocument->Environment_Evacuation_Ordered === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Date_Samples_Taken != $EHS->Date_Samples_Taken || ! empty($request->Date_Samples_Taken_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Date of Samples Taken';
            $history->previous = Helpers::getdateFormat($lastDocument->Date_Samples_Taken);
            $history->current = Helpers::getdateFormat($EHS->Date_Samples_Taken);
            $history->comment = $request->Date_Samples_Taken_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Date_Samples_Taken) || $lastDocument->Date_Samples_Taken === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Agencys_Notified != $EHS->Agencys_Notified || ! empty($request->Agencys_Notified_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Agencys Notified';
            $history->previous = $lastDocument->Agencys_Notified;
            $history->current = $EHS->Agencys_Notified;
            $history->comment = $request->Agencys_Notified_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Agencys_Notified) || $lastDocument->Agencys_Notified === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Fire_Category != $EHS->Fire_Category || ! empty($request->Fire_Category_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Fire Category';
            $history->previous = $lastDocument->Fire_Category;
            $history->current = $EHS->Fire_Category;
            $history->comment = $request->Fire_Category_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Fire_Category) || $lastDocument->Fire_Category === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Fire_Evacuation_Ordered != $EHS->Fire_Evacuation_Ordered || ! empty($request->Fire_Evacuation_Ordered_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Fire Evacuation Ordered ?';
            $history->previous = $lastDocument->Fire_Evacuation_Ordered;
            $history->current = $EHS->Fire_Evacuation_Ordered;
            $history->comment = $request->Fire_Evacuation_Ordered_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Fire_Evacuation_Ordered) || $lastDocument->Fire_Evacuation_Ordered === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Combat_By != $EHS->Combat_By || ! empty($request->Combat_By_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Combat By';
            $history->previous = $lastDocument->Combat_By;
            $history->current = $EHS->Combat_By;
            $history->comment = $request->Combat_By_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Combat_By) || $lastDocument->Combat_By === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Fire_Fighting_Equipment_Used != $EHS->Fire_Fighting_Equipment_Used || ! empty($request->Fire_Fighting_Equipment_Used_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Fire Fighting Equipment Used';
            $history->previous = $lastDocument->Fire_Fighting_Equipment_Used;
            $history->current = $EHS->Fire_Fighting_Equipment_Used;
            $history->comment = $request->Fire_Fighting_Equipment_Used_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Fire_Fighting_Equipment_Used) || $lastDocument->Fire_Fighting_Equipment_Used === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->zone != $EHS->zone || ! empty($request->zone_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Zone';
            $history->previous = $lastDocument->zone;
            $history->current = $EHS->zone;
            $history->comment = $request->zone_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->zone) || $lastDocument->zone === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->country != $EHS->country || ! empty($request->country_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Country';
            $history->previous = $lastDocument->country;
            $history->current = $EHS->country;
            $history->comment = $request->country_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->country) || $lastDocument->country === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->state != $EHS->state || ! empty($request->state_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'State';
            $history->previous = $lastDocument->state;
            $history->current = $EHS->state;
            $history->comment = $request->state_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->state) || $lastDocument->state === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->city != $EHS->city || ! empty($request->city_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'City';
            $history->previous = $lastDocument->city;
            $history->current = $EHS->city;
            $history->comment = $request->city_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->city) || $lastDocument->city === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Site_Name != $EHS->Site_Name || ! empty($request->Site_Name_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Site Name';
            $history->previous = $lastDocument->Site_Name;
            $history->current = $EHS->Site_Name;
            $history->comment = $request->Site_Name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Site_Name) || $lastDocument->Site_Name === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Building != $EHS->Building || ! empty($request->Building_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Building';
            $history->previous = $lastDocument->Building;
            $history->current = $EHS->Building;
            $history->comment = $request->Building_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Building) || $lastDocument->Building === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Floor != $EHS->Floor || ! empty($request->Floor_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Floor';
            $history->previous = $lastDocument->Floor;
            $history->current = $EHS->Floor;
            $history->comment = $request->Floor_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Floor) || $lastDocument->Floor === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Room != $EHS->Room || ! empty($request->Room_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Room';
            $history->previous = $lastDocument->Room;
            $history->current = $EHS->Room;
            $history->comment = $request->Room_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Room) || $lastDocument->Room === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Location != $EHS->Location || ! empty($request->Location_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Location';
            $history->previous = $lastDocument->Location;
            $history->current = $EHS->Location;
            $history->comment = $request->Location_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Location) || $lastDocument->Location === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Victim != $EHS->Victim || ! empty($request->Victim_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Victim';
            $history->previous = Helpers::getInitiatorName($lastDocument->Victim);
            $history->current = Helpers::getInitiatorName($EHS->Victim);
            $history->comment = $request->Victim_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Victim) || $lastDocument->Victim === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Medical_Treatment != $EHS->Medical_Treatment || ! empty($request->Medical_Treatment_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Medical Treatment ?(Y/N)';
            $history->previous = $lastDocument->Medical_Treatment;
            $history->current = $EHS->Medical_Treatment;
            $history->comment = $request->Medical_Treatment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Medical_Treatment) || $lastDocument->Medical_Treatment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Victim_Position != $EHS->Victim_Position || ! empty($request->Victim_Position_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Victim Position';
            $history->previous = $lastDocument->Victim_Position;
            $history->current = $EHS->Victim_Position;
            $history->comment = $request->Victim_Position_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Victim_Position) || $lastDocument->Victim_Position === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Victim_Relation_To_Company != $EHS->Victim_Relation_To_Company || ! empty($request->Victim_Relation_To_Company_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Victim Relation To Company';
            $history->previous = $lastDocument->Victim_Relation_To_Company;
            $history->current = $EHS->Victim_Relation_To_Company;
            $history->comment = $request->Victim_Relation_To_Company_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Victim_Relation_To_Company) || $lastDocument->Victim_Relation_To_Company === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Hospitalization != $EHS->Hospitalization || ! empty($request->Hospitalization_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Hospitalization';
            $history->previous = $lastDocument->Hospitalization;
            $history->current = $EHS->Hospitalization;
            $history->comment = $request->Hospitalization_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Hospitalization) || $lastDocument->Hospitalization === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Hospital_Name != $EHS->Hospital_Name || ! empty($request->Hospital_Name_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Hospital Name';
            $history->previous = $lastDocument->Hospital_Name;
            $history->current = $EHS->Hospital_Name;
            $history->comment = $request->Hospital_Name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Hospital_Name) || $lastDocument->Hospital_Name === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Date_Of_Treatment != $EHS->Date_Of_Treatment || ! empty($request->Date_Of_Treatment_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Date Of Treatment';
            $history->previous = Helpers::getdateFormat($lastDocument->Date_Of_Treatment);
            $history->current = Helpers::getdateFormat($EHS->Date_Of_Treatment);
            $history->comment = $request->Date_Of_Treatment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Date_Of_Treatment) || $lastDocument->Date_Of_Treatment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Victim_Treated_By != $EHS->Victim_Treated_By || ! empty($request->Victim_Treated_By_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Victim Treated By';
            $history->previous = $lastDocument->Victim_Treated_By;
            $history->current = $EHS->Victim_Treated_By;
            $history->comment = $request->Victim_Treated_By_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Victim_Treated_By) || $lastDocument->Victim_Treated_By === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Medical_Treatment_Description != $EHS->Medical_Treatment_Description || ! empty($request->Medical_Treatment_Description_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Medical Treatment Description';
            $history->previous = $lastDocument->Medical_Treatment_Description;
            $history->current = $EHS->Medical_Treatment_Description;
            $history->comment = $request->Medical_Treatment_Description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Medical_Treatment_Description) || $lastDocument->Medical_Treatment_Description === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Injury_Type != $EHS->Injury_Type || ! empty($request->Injury_Type_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Injury Type';
            $history->previous = $lastDocument->Injury_Type;
            $history->current = $EHS->Injury_Type;
            $history->comment = $request->Injury_Type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Injury_Type) || $lastDocument->Injury_Type === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Number_Of_Injuries != $EHS->Number_Of_Injuries || ! empty($request->Number_Of_Injuries_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Number Of Injuries';
            $history->previous = $lastDocument->Number_Of_Injuries;
            $history->current = $EHS->Number_Of_Injuries;
            $history->comment = $request->Number_Of_Injuries_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Number_Of_Injuries) || $lastDocument->Number_Of_Injuries === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Type_Of_Injuries != $EHS->Type_Of_Injuries || ! empty($request->Type_Of_Injuries_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Type Of Injuries';
            $history->previous = $lastDocument->Type_Of_Injuries;
            $history->current = $EHS->Type_Of_Injuries;
            $history->comment = $request->Type_Of_Injuries_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Type_Of_Injuries) || $lastDocument->Type_Of_Injuries === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Injured_Body_Parts != $EHS->Injured_Body_Parts || ! empty($request->Injured_Body_Parts_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Injured Body Parts';
            $history->previous = $lastDocument->Injured_Body_Parts;
            $history->current = $EHS->Injured_Body_Parts;
            $history->comment = $request->Injured_Body_Parts_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Injured_Body_Parts) || $lastDocument->Injured_Body_Parts === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Type_Of_Illness != $EHS->Type_Of_Illness || ! empty($request->Type_Of_Illness_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Type Of Illness';
            $history->previous = $lastDocument->Type_Of_Illness;
            $history->current = $EHS->Type_Of_Illness;
            $history->comment = $request->Type_Of_Illness_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Type_Of_Illness) || $lastDocument->Type_Of_Illness === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Permanent_Disability != $EHS->Permanent_Disability || ! empty($request->Permanent_Disability_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Permanent Disability?';
            $history->previous = $lastDocument->Permanent_Disability;
            $history->current = $EHS->Permanent_Disability;
            $history->comment = $request->Permanent_Disability_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Permanent_Disability) || $lastDocument->Permanent_Disability === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Damage_Category != $EHS->Damage_Category || ! empty($request->Damage_Category_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Damage Category';
            $history->previous = $lastDocument->Damage_Category;
            $history->current = $EHS->Damage_Category;
            $history->comment = $request->Damage_Category_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Damage_Category) || $lastDocument->Damage_Category === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Related_Equipment != $EHS->Related_Equipment || ! empty($request->Related_Equipment_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Related Equipment';
            $history->previous = $lastDocument->Related_Equipment;
            $history->current = $EHS->Related_Equipment;
            $history->comment = $request->Related_Equipment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Related_Equipment) || $lastDocument->Related_Equipment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Estimated_Amount_Of_Damage != $EHS->Estimated_Amount_Of_Damage || ! empty($request->Estimated_Amount_Of_Damage_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Estimated Amount Of Damage';
            $history->previous = $lastDocument->Estimated_Amount_Of_Damage;
            $history->current = $EHS->Estimated_Amount_Of_Damage;
            $history->comment = $request->Estimated_Amount_Of_Damage_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Estimated_Amount_Of_Damage) || $lastDocument->Estimated_Amount_Of_Damage === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Currency != $EHS->Currency || ! empty($request->Currency_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Currency';
            $history->previous = $lastDocument->Currency;
            $history->current = $EHS->Currency;
            $history->comment = $request->Currency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Currency) || $lastDocument->Currency === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Insurance_Company_Involved != $EHS->Insurance_Company_Involved || ! empty($request->Insurance_Company_Involved_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Insurance Company Involved?';
            $history->previous = $lastDocument->Insurance_Company_Involved;
            $history->current = $EHS->Insurance_Company_Involved;
            $history->comment = $request->Insurance_Company_Involved_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Insurance_Company_Involved) || $lastDocument->Insurance_Company_Involved === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Denied_By_Insurance_Company != $EHS->Denied_By_Insurance_Company || ! empty($request->Denied_By_Insurance_Company_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Denied By Insurance Company';
            $history->previous = $lastDocument->Denied_By_Insurance_Company;
            $history->current = $EHS->Denied_By_Insurance_Company;
            $history->comment = $request->Denied_By_Insurance_Company_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Denied_By_Insurance_Company) || $lastDocument->Denied_By_Insurance_Company === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Damage_Details != $EHS->Damage_Details || ! empty($request->Damage_Details_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Damage Details';
            $history->previous = $lastDocument->Damage_Details;
            $history->current = $EHS->Damage_Details;
            $history->comment = $request->Damage_Details_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Damage_Details) || $lastDocument->Damage_Details === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Actual_Amount_Of_Damage != $EHS->Actual_Amount_Of_Damage || ! empty($request->Actual_Amount_Of_Damage_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Actual Amount Of Damage';
            $history->previous = $lastDocument->Actual_Amount_Of_Damage;
            $history->current = $EHS->Actual_Amount_Of_Damage;
            $history->comment = $request->Actual_Amount_Of_Damage_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Actual_Amount_Of_Damage) || $lastDocument->Actual_Amount_Of_Damage === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Currency2 != $EHS->Currency2 || ! empty($request->Currency2_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Currency';
            $history->previous = $lastDocument->Currency2;
            $history->current = $EHS->Currency2;
            $history->comment = $request->Currency2_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Currency2) || $lastDocument->Currency2 === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Investigation_Summary != $EHS->Investigation_Summary || ! empty($request->Investigation_Summary_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Investigation Summary';
            $history->previous = $lastDocument->Investigation_Summary;
            $history->current = $EHS->Investigation_Summary;
            $history->comment = $request->Investigation_Summary_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Investigation_Summary) || $lastDocument->Investigation_Summary === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Conclusion != $EHS->Conclusion || ! empty($request->Conclusion_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Conclusion';
            $history->previous = $lastDocument->Conclusion;
            $history->current = $EHS->Conclusion;
            $history->comment = $request->Conclusion_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Conclusion) || $lastDocument->Conclusion === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->root_cause_methodology != $EHS->root_cause_methodology || ! empty($request->root_cause_methodology_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Root Cause Methodology';
            $history->previous = str_replace(',', ', ', $lastDocument->root_cause_methodology);
            $history->current = str_replace(',', ', ', $EHS->root_cause_methodology);
            $history->comment = $request->root_cause_methodology_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->root_cause_methodology) || $lastDocument->root_cause_methodology === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Root_Cause_Description != $EHS->Root_Cause_Description || ! empty($request->Root_Cause_Description_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Root Cause Description';
            $history->previous = $lastDocument->Root_Cause_Description;
            $history->current = $EHS->Root_Cause_Description;
            $history->comment = $request->Root_Cause_Description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Root_Cause_Description) || $lastDocument->Root_Cause_Description === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Safety_Impact_Probability != $EHS->Safety_Impact_Probability || ! empty($request->Safety_Impact_Probability_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Safety Impact Probability';
            $history->previous = $lastDocument->Safety_Impact_Probability;
            $history->current = $EHS->Safety_Impact_Probability;
            $history->comment = $request->Safety_Impact_Probability_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Safety_Impact_Probability) || $lastDocument->Safety_Impact_Probability === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Safety_Impact_Severity != $EHS->Safety_Impact_Severity || ! empty($request->Safety_Impact_Severity_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Safety Impact Severity';
            $history->previous = $lastDocument->Safety_Impact_Severity;
            $history->current = $EHS->Safety_Impact_Severity;
            $history->comment = $request->Safety_Impact_Severity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Safety_Impact_Severity) || $lastDocument->Safety_Impact_Severity === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Legal_Impact_Probability != $EHS->Legal_Impact_Probability || ! empty($request->Legal_Impact_Probability_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Legal Impact Probability';
            $history->previous = $lastDocument->Legal_Impact_Probability;
            $history->current = $EHS->Legal_Impact_Probability;
            $history->comment = $request->Legal_Impact_Probability_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Legal_Impact_Probability) || $lastDocument->Legal_Impact_Probability === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Legal_Impact_Severity != $EHS->Legal_Impact_Severity || ! empty($request->Legal_Impact_Severity_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Legal Impact Severity';
            $history->previous = $lastDocument->Legal_Impact_Severity;
            $history->current = $EHS->Legal_Impact_Severity;
            $history->comment = $request->Legal_Impact_Severity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Legal_Impact_Severity) || $lastDocument->Legal_Impact_Severity === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Business_Impact_Probability != $EHS->Business_Impact_Probability || ! empty($request->Business_Impact_Probability_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Business Impact Probability';
            $history->previous = $lastDocument->Business_Impact_Probability;
            $history->current = $EHS->Business_Impact_Probability;
            $history->comment = $request->Business_Impact_Probability_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Business_Impact_Probability) || $lastDocument->Business_Impact_Probability === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Business_Impact_Severity != $EHS->Business_Impact_Severity || ! empty($request->Business_Impact_Severity_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Business Impact Severity';
            $history->previous = $lastDocument->Business_Impact_Severity;
            $history->current = $EHS->Business_Impact_Severity;
            $history->comment = $request->Business_Impact_Severity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Business_Impact_Severity) || $lastDocument->Business_Impact_Severity === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Revenue_Impact_Probability != $EHS->Revenue_Impact_Probability || ! empty($request->Revenue_Impact_Probability_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Revenue Impact Probability';
            $history->previous = $lastDocument->Revenue_Impact_Probability;
            $history->current = $EHS->Revenue_Impact_Probability;
            $history->comment = $request->Revenue_Impact_Probability_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Revenue_Impact_Probability) || $lastDocument->Revenue_Impact_Probability === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Revenue_Impact_Severity != $EHS->Revenue_Impact_Severity || ! empty($request->Revenue_Impact_Severity_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Revenue Impact Severity';
            $history->previous = $lastDocument->Revenue_Impact_Severity;
            $history->current = $EHS->Revenue_Impact_Severity;
            $history->comment = $request->Revenue_Impact_Severity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Revenue_Impact_Severity) || $lastDocument->Revenue_Impact_Severity === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Brand_Impact_Probability != $EHS->Brand_Impact_Probability || ! empty($request->Brand_Impact_Probability_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Brand Impact Probability';
            $history->previous = $lastDocument->Brand_Impact_Probability;
            $history->current = $EHS->Brand_Impact_Probability;
            $history->comment = $request->Brand_Impact_Probability_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Brand_Impact_Probability) || $lastDocument->Brand_Impact_Probability === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Brand_Impact_Severity != $EHS->Brand_Impact_Severity || ! empty($request->Brand_Impact_Severity_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Brand Impact Severity';
            $history->previous = $lastDocument->Brand_Impact_Severity;
            $history->current = $EHS->Brand_Impact_Severity;
            $history->comment = $request->Brand_Impact_Severity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Brand_Impact_Severity) || $lastDocument->Brand_Impact_Severity === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Safety_Impact_Risk != $EHS->Safety_Impact_Risk || ! empty($request->Safety_Impact_Risk_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Safety Impact Risk';
            $history->previous = $lastDocument->Safety_Impact_Risk;
            $history->current = $EHS->Safety_Impact_Risk;
            $history->comment = $request->Safety_Impact_Risk_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Safety_Impact_Risk) || $lastDocument->Safety_Impact_Risk === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Legal_Impact_Risk != $EHS->Legal_Impact_Risk || ! empty($request->Legal_Impact_Risk_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Legal Impact Risk';
            $history->previous = $lastDocument->Legal_Impact_Risk;
            $history->current = $EHS->Legal_Impact_Risk;
            $history->comment = $request->Legal_Impact_Risk_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Legal_Impact_Risk) || $lastDocument->Legal_Impact_Risk === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Business_Impact_Risk != $EHS->Business_Impact_Risk || ! empty($request->Business_Impact_Risk_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Business Impact Risk';
            $history->previous = $lastDocument->Business_Impact_Risk;
            $history->current = $EHS->Business_Impact_Risk;
            $history->comment = $request->Business_Impact_Risk_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Business_Impact_Risk) || $lastDocument->Business_Impact_Risk === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Revenue_Impact_Risk != $EHS->Revenue_Impact_Risk || ! empty($request->Revenue_Impact_Risk_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Revenue Impact Risk';
            $history->previous = $lastDocument->Revenue_Impact_Risk;
            $history->current = $EHS->Revenue_Impact_Risk;
            $history->comment = $request->Revenue_Impact_Risk_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Revenue_Impact_Risk) || $lastDocument->Revenue_Impact_Risk === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Brand_Impact_Risk != $EHS->Brand_Impact_Risk || ! empty($request->Brand_Impact_Risk_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Brand Impact Risk';
            $history->previous = $lastDocument->Brand_Impact_Risk;
            $history->current = $EHS->Brand_Impact_Risk;
            $history->comment = $request->Brand_Impact_Risk_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Brand_Impact_Risk) || $lastDocument->Brand_Impact_Risk === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Impact != $EHS->Impact || ! empty($request->Impact_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Impact';
            $history->previous = $lastDocument->Impact;
            $history->current = $EHS->Impact;
            $history->comment = $request->Impact_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Impact) || $lastDocument->Impact === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Impact_Analysis != $EHS->Impact_Analysis || ! empty($request->Impact_Analysis_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Impact Analysis';
            $history->previous = $lastDocument->Impact_Analysis;
            $history->current = $EHS->Impact_Analysis;
            $history->comment = $request->Impact_Analysis_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Impact_Analysis) || $lastDocument->Impact_Analysis === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Recommended_Actions != $EHS->Recommended_Actions || ! empty($request->Recommended_Actions_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Recommended Actions';
            $history->previous = $lastDocument->Recommended_Actions;
            $history->current = $EHS->Recommended_Actions;
            $history->comment = $request->Recommended_Actions_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Recommended_Actions) || $lastDocument->Recommended_Actions === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Comments2 != $EHS->Comments2 || ! empty($request->Comments2_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->Comments2;
            $history->current = $EHS->Comments2;
            $history->comment = $request->Comments2_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Comments2) || $lastDocument->Comments2 === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Direct_Cause != $EHS->Direct_Cause || ! empty($request->Direct_Cause_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Direct Cause';
            $history->previous = $lastDocument->Direct_Cause;
            $history->current = $EHS->Direct_Cause;
            $history->comment = $request->Direct_Cause_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Direct_Cause) || $lastDocument->Direct_Cause === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Safeguarding_Measure_Taken2 != $EHS->Safeguarding_Measure_Taken2 || ! empty($request->Safeguarding_Measure_Taken2_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Safeguarding Measure Taken';
            $history->previous = $lastDocument->Safeguarding_Measure_Taken2;
            $history->current = $EHS->Safeguarding_Measure_Taken2;
            $history->comment = $request->Safeguarding_Measure_Taken2_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Safeguarding_Measure_Taken2) || $lastDocument->Safeguarding_Measure_Taken2 === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->severity_rate != $EHS->severity_rate || ! empty($request->severity_rate_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Severity Rate';
            $history->previous = $lastDocument->severity_rate;
            $history->current = $EHS->severity_rate;
            $history->comment = $request->severity_rate_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->severity_rate) || $lastDocument->severity_rate === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->occurrence != $EHS->occurrence || ! empty($request->occurrence_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Occurrence';
            $history->previous = $lastDocument->occurrence;
            $history->current = $EHS->occurrence;
            $history->comment = $request->occurrence_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->occurrence) || $lastDocument->occurrence === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->detection != $EHS->detection || ! empty($request->detection_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Detection';
            $history->previous = $lastDocument->detection;
            $history->current = $EHS->detection;
            $history->comment = $request->detection_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->detection) || $lastDocument->detection === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->rpn != $EHS->rpn || ! empty($request->rpn_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'RPN';
            $history->previous = $lastDocument->rpn;
            $history->current = $EHS->rpn;
            $history->comment = $request->rpn_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->rpn) || $lastDocument->rpn === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Risk_Analysis != $EHS->Risk_Analysis || ! empty($request->Risk_Analysis_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Risk Analysis';
            $history->previous = $lastDocument->Risk_Analysis;
            $history->current = $EHS->Risk_Analysis;
            $history->comment = $request->Risk_Analysis_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Risk_Analysis) || $lastDocument->Risk_Analysis === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Critically != $EHS->Critically || ! empty($request->Critically_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Critically';
            $history->previous = $lastDocument->Critically;
            $history->current = $EHS->Critically;
            $history->comment = $request->Critically_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Critically) || $lastDocument->Critically === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Inform_Local_Authority != $EHS->Inform_Local_Authority || ! empty($request->Inform_Local_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Inform Local Authority?';
            $history->previous = $lastDocument->Inform_Local_Authority;
            $history->current = $EHS->Inform_Local_Authority;
            $history->comment = $request->Inform_Local_Authority_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Inform_Local_Authority) || $lastDocument->Inform_Local_Authority === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Authority_Type != $EHS->Authority_Type || ! empty($request->Authority_Type_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Authority Type';
            $history->previous = $lastDocument->Authority_Type;
            $history->current = $EHS->Authority_Type;
            $history->comment = $request->Authority_Type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Authority_Type) || $lastDocument->Authority_Type === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Authority_Notified != $EHS->Authority_Notified || ! empty($request->Authority_Notified_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Authority Notified';
            $history->previous = $lastDocument->Authority_Notified;
            $history->current = $EHS->Authority_Notified;
            $history->comment = $request->Authority_Notified_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Authority_Notified) || $lastDocument->Authority_Notified === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        if ($lastDocument->Other_Authority != $EHS->Other_Authority || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Other Authority';
            $history->previous = $lastDocument->Other_Authority;
            $history->current = $EHS->Other_Authority;
            $history->comment = $request->Other_Authority_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Other_Authority) || $lastDocument->Other_Authority === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        //=================================================
        if ($lastDocument->employee_id != $EHS->employee_id || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Employee Id';
            $history->previous = $lastDocument->employee_id;
            $history->current = $EHS->employee_id;
            $history->comment = $request->employee_id_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->employee_id) || $lastDocument->employee_id === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->employee_name != $EHS->employee_name || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Employee Name';
            $history->previous = $lastDocument->employee_name;
            $history->current = $EHS->employee_name;
            $history->comment = $request->employee_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->employee_name) || $lastDocument->employee_name === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->designation != $EHS->designation || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Designation';
            $history->previous = $lastDocument->designation;
            $history->current = $EHS->designation;
            $history->comment = $request->Designation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->designation) || $lastDocument->designation === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->department2 != $EHS->department2 || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Department';
            $history->previous = $lastDocument->department2;
            $history->current = $EHS->department2;
            $history->comment = $request->department2_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->department2) || $lastDocument->department2 === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->phone_number != $EHS->phone_number || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Phone Number';
            $history->previous = $lastDocument->phone_number;
            $history->current = $EHS->phone_number;
            $history->comment = $request->phone_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->phone_number) || $lastDocument->phone_number === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->email != $EHS->email || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Phone Number';
            $history->previous = $lastDocument->email;
            $history->current = $EHS->email;
            $history->comment = $request->Email_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->email) || $lastDocument->email === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->date_of_joining != $EHS->date_of_joining || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Date of Joining';
            $history->previous = Helpers::getdateFormat($lastDocument->date_of_joining);
            $history->current = Helpers::getdateFormat($EHS->date_of_joining);
            $history->comment = $request->date_of_joining_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->date_of_joining) || $lastDocument->date_of_joining === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->safety_training_records != $EHS->safety_training_records || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Safety Training Records';
            $history->previous = $lastDocument->safety_training_records;
            $history->current = $EHS->safety_training_records;
            $history->comment = $request->safety_training_records_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->safety_training_records) || $lastDocument->safety_training_records === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->medical_history != $EHS->medical_history || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Medical History';
            $history->previous = $lastDocument->medical_history;
            $history->current = $EHS->medical_history;
            $history->comment = $request->medical_history_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->medical_history) || $lastDocument->medical_history === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->personal_protective_equipment_compliance != $EHS->personal_protective_equipment_compliance || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Personal Protective Equipment (PPE) Compliance';
            $history->previous = $lastDocument->personal_protective_equipment_compliance;
            $history->current = $EHS->personal_protective_equipment_compliance;
            $history->comment = $request->personal_protective_equipment_compliance_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->personal_protective_equipment_compliance) || $lastDocument->personal_protective_equipment_compliance === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->emergency_contacts != $EHS->emergency_contacts || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Emergency Contacts';
            $history->previous = $lastDocument->emergency_contacts;
            $history->current = $EHS->emergency_contacts;
            $history->comment = $request->emergency_contacts_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->emergency_contacts) || $lastDocument->emergency_contacts === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->compliance_standards_regulations != $EHS->compliance_standards_regulations || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Compliance Standards/Regulations';
            $history->previous = $lastDocument->compliance_standards_regulations;
            $history->current = $EHS->compliance_standards_regulations;
            $history->comment = $request->compliance_standards_regulations_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->compliance_standards_regulations) || $lastDocument->compliance_standards_regulations === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->regulatory_authority_agency != $EHS->regulatory_authority_agency || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Regulatory Authority/Agency';
            $history->previous = $lastDocument->regulatory_authority_agency;
            $history->current = $EHS->regulatory_authority_agency;
            $history->comment = $request->regulatory_authority_agency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->regulatory_authority_agency) || $lastDocument->regulatory_authority_agency === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->inspection_dates_and_reports != $EHS->inspection_dates_and_reports || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Inspection Dates and Reports';
            $history->previous = Helpers::getdateFormat($lastDocument->inspection_dates_and_reports);
            $history->current = Helpers::getdateFormat($EHS->inspection_dates_and_reports);
            $history->comment = $request->inspection_dates_and_reports_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->inspection_dates_and_reports) || $lastDocument->inspection_dates_and_reports === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->audit_inspection_results != $EHS->audit_inspection_results || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Audit/Inspection Results';
            $history->previous = $lastDocument->audit_inspection_results;
            $history->current = $EHS->audit_inspection_results;
            $history->comment = $request->audit_inspection_results_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->audit_inspection_results) || $lastDocument->audit_inspection_results === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->non_compliance_issues != $EHS->non_compliance_issues || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Non-compliance Issues';
            $history->previous = $lastDocument->non_compliance_issues;
            $history->current = $EHS->non_compliance_issues;
            $history->comment = $request->non_compliance_issues_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->non_compliance_issues) || $lastDocument->non_compliance_issues === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->environmental_permits != $EHS->environmental_permits || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Environmental Permits';
            $history->previous = $lastDocument->environmental_permits;
            $history->current = $EHS->environmental_permits;
            $history->comment = $request->environmental_permits_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->environmental_permits) || $lastDocument->environmental_permits === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->workplace_safety_certifications != $EHS->workplace_safety_certifications || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Workplace Safety Certifications';
            $history->previous = $lastDocument->workplace_safety_certifications;
            $history->current = $EHS->workplace_safety_certifications;
            $history->comment = $request->workplace_safety_certifications_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->workplace_safety_certifications) || $lastDocument->workplace_safety_certifications === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->incident_id != $EHS->incident_id || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Incident ID';
            $history->previous = $lastDocument->incident_id;
            $history->current = $EHS->incident_id;
            $history->comment = $request->incident_id_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->incident_id) || $lastDocument->incident_id === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->date_of_incident != $EHS->date_of_incident || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Date of Incident';
            $history->previous = Helpers::getdateFormat($lastDocument->date_of_incident);
            $history->current = Helpers::getdateFormat($EHS->date_of_incident);
            $history->comment = $request->date_of_incident_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->date_of_incident) || $lastDocument->date_of_incident === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->time_of_incident != $EHS->time_of_incident || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Time of Incident';
            $history->previous = $lastDocument->time_of_incident;
            $history->current = $EHS->time_of_incident;
            $history->comment = $request->time_of_incident_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->time_of_incident) || $lastDocument->time_of_incident === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->type_of_incident != $EHS->type_of_incident || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Type of Incident';
            $history->previous = $lastDocument->type_of_incident;
            $history->current = $EHS->type_of_incident;
            $history->comment = $request->type_of_incident_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->type_of_incident) || $lastDocument->type_of_incident === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->incident_severity != $EHS->incident_severity || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Incident Severity';
            $history->previous = $lastDocument->incident_severity;
            $history->current = $EHS->incident_severity;
            $history->comment = $request->incident_severity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->incident_severity) || $lastDocument->incident_severity === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->location_of_incident != $EHS->location_of_incident || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Location of Incident';
            $history->previous = $lastDocument->location_of_incident;
            $history->current = $EHS->location_of_incident;
            $history->comment = $request->location_of_incident_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->location_of_incident) || $lastDocument->location_of_incident === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->affected_personnel != $EHS->affected_personnel || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Affected Personnel';
            $history->previous = $lastDocument->affected_personnel;
            $history->current = $EHS->affected_personnel;
            $history->comment = $request->affected_personnel_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->affected_personnel) || $lastDocument->affected_personnel === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->root_cause_analysis != $EHS->root_cause_analysis || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Root Cause Analysis';
            $history->previous = $lastDocument->root_cause_analysis;
            $history->current = $EHS->root_cause_analysis;
            $history->comment = $request->root_cause_analysis_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->root_cause_analysis) || $lastDocument->root_cause_analysis === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->corrective_and_preventive_actions != $EHS->corrective_and_preventive_actions || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Corrective and Preventive Actions (CAPA)';
            $history->previous = $lastDocument->corrective_and_preventive_actions;
            $history->current = $EHS->corrective_and_preventive_actions;
            $history->comment = $request->corrective_and_preventive_actions_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->corrective_and_preventive_actions) || $lastDocument->corrective_and_preventive_actions === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->investigation_reports != $EHS->investigation_reports || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Investigation Reports';
            $history->previous = $lastDocument->investigation_reports;
            $history->current = $EHS->investigation_reports;
            $history->comment = $request->investigation_reports_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->investigation_reports) || $lastDocument->investigation_reports === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->injury_severity_and_report != $EHS->injury_severity_and_report || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Injury Severity and Report';
            $history->previous = $lastDocument->injury_severity_and_report;
            $history->current = $EHS->injury_severity_and_report;
            $history->comment = $request->injury_severity_and_report_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->injury_severity_and_report) || $lastDocument->injury_severity_and_report === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->incident_resolution_status != $EHS->incident_resolution_status || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Incident Resolution Status';
            $history->previous = $lastDocument->incident_resolution_status;
            $history->current = $EHS->incident_resolution_status;
            $history->comment = $request->incident_resolution_status_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->incident_resolution_status) || $lastDocument->incident_resolution_status === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->workplace_safety_audits != $EHS->workplace_safety_audits || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Workplace Safety Audits';
            $history->previous = $lastDocument->workplace_safety_audits;
            $history->current = $EHS->workplace_safety_audits;
            $history->comment = $request->workplace_safety_audits_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->workplace_safety_audits) || $lastDocument->workplace_safety_audits === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->hazardous_area_identification != $EHS->hazardous_area_identification || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Hazardous Area Identification';
            $history->previous = $lastDocument->hazardous_area_identification;
            $history->current = $EHS->hazardous_area_identification;
            $history->comment = $request->hazardous_area_identification_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->hazardous_area_identification) || $lastDocument->hazardous_area_identification === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->ventilation_systems_monitoring != $EHS->ventilation_systems_monitoring || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Ventilation Systems Monitoring';
            $history->previous = $lastDocument->ventilation_systems_monitoring;
            $history->current = $EHS->ventilation_systems_monitoring;
            $history->comment = $request->ventilation_systems_monitoring_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->ventilation_systems_monitoring) || $lastDocument->ventilation_systems_monitoring === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->noise_levels_monitoring != $EHS->noise_levels_monitoring || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Noise Levels Monitoring';
            $history->previous = $lastDocument->noise_levels_monitoring;
            $history->current = $EHS->noise_levels_monitoring;
            $history->comment = $request->noise_levels_monitoring_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->noise_levels_monitoring) || $lastDocument->noise_levels_monitoring === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->lighting_and_temperature_monitoring != $EHS->lighting_and_temperature_monitoring || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Lighting and Temperature Monitoring';
            $history->previous = $lastDocument->lighting_and_temperature_monitoring;
            $history->current = $EHS->lighting_and_temperature_monitoring;
            $history->comment = $request->lighting_and_temperature_monitoring_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->lighting_and_temperature_monitoring) || $lastDocument->lighting_and_temperature_monitoring === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->personal_monitoring != $EHS->personal_monitoring || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Personal Monitoring (Health and Safety Data)';
            $history->previous = $lastDocument->personal_monitoring;
            $history->current = $EHS->personal_monitoring;
            $history->comment = $request->personal_monitoring_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->personal_monitoring) || $lastDocument->personal_monitoring === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->ergonomics_data != $EHS->ergonomics_data || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Ergonomics Data';
            $history->previous = $lastDocument->ergonomics_data;
            $history->current = $EHS->ergonomics_data;
            $history->comment = $request->ergonomics_data_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->ergonomics_data) || $lastDocument->ergonomics_data === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Employee_Health_Records != $EHS->Employee_Health_Records || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Employee Health Records';
            $history->previous = $lastDocument->Employee_Health_Records;
            $history->current = $EHS->Employee_Health_Records;
            $history->comment = $request->Employee_Health_Records_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Employee_Health_Records) || $lastDocument->Employee_Health_Records === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Occupational_Exposure_Limits != $EHS->Occupational_Exposure_Limits || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Occupational Exposure Limits';
            $history->previous = $lastDocument->Occupational_Exposure_Limits;
            $history->current = $EHS->Occupational_Exposure_Limits;
            $history->comment = $request->Occupational_Exposure_Limits_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Occupational_Exposure_Limits) || $lastDocument->Occupational_Exposure_Limits === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Vaccination_Records != $EHS->Vaccination_Records || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Vaccination Records';
            $history->previous = $lastDocument->Vaccination_Records;
            $history->current = $EHS->Vaccination_Records;
            $history->comment = $request->Vaccination_Records_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Vaccination_Records) || $lastDocument->Vaccination_Records === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Pre_employment_and_Routine_Health_Screenings != $EHS->Pre_employment_and_Routine_Health_Screenings || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Pre-employment and Routine Health Screenings';
            $history->previous = $lastDocument->Pre_employment_and_Routine_Health_Screenings;
            $history->current = $EHS->Pre_employment_and_Routine_Health_Screenings;
            $history->comment = $request->Pre_employment_and_Routine_Health_Screenings_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Pre_employment_and_Routine_Health_Screenings) || $lastDocument->Pre_employment_and_Routine_Health_Screenings === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Workplace_Injury_and_Illness_Reporting != $EHS->Workplace_Injury_and_Illness_Reporting || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Workplace Injury and Illness Reporting';
            $history->previous = $lastDocument->Workplace_Injury_and_Illness_Reporting;
            $history->current = $EHS->Workplace_Injury_and_Illness_Reporting;
            $history->comment = $request->Workplace_Injury_and_Illness_Reporting_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Workplace_Injury_and_Illness_Reporting) || $lastDocument->Workplace_Injury_and_Illness_Reporting === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Absenteeism_Data != $EHS->Absenteeism_Data || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Absenteeism Data';
            $history->previous = $lastDocument->Absenteeism_Data;
            $history->current = $EHS->Absenteeism_Data;
            $history->comment = $request->Absenteeism_Data_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Absenteeism_Data) || $lastDocument->Absenteeism_Data === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Safety_Drills_and_Training_Records != $EHS->Safety_Drills_and_Training_Records || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Safety Drills and Training Records';
            $history->previous = $lastDocument->Safety_Drills_and_Training_Records;
            $history->current = $EHS->Safety_Drills_and_Training_Records;
            $history->comment = $request->Safety_Drills_and_Training_Records_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Safety_Drills_and_Training_Records) || $lastDocument->Safety_Drills_and_Training_Records === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->First_Aid_and_Emergency_Response_Records != $EHS->First_Aid_and_Emergency_Response_Records || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'First Aid and Emergency Response Records';
            $history->previous = $lastDocument->First_Aid_and_Emergency_Response_Records;
            $history->current = $EHS->First_Aid_and_Emergency_Response_Records;
            $history->comment = $request->First_Aid_and_Emergency_Response_Records_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->First_Aid_and_Emergency_Response_Records) || $lastDocument->First_Aid_and_Emergency_Response_Records === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Emergency_Plan != $EHS->Emergency_Plan || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Emergency Plan';
            $history->previous = $lastDocument->Emergency_Plan;
            $history->current = $EHS->Emergency_Plan;
            $history->comment = $request->Emergency_Plan_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Emergency_Plan) || $lastDocument->Emergency_Plan === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Emergency_Contacts2 != $EHS->Emergency_Contacts2 || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Emergency Contacts';
            $history->previous = $lastDocument->Emergency_Contacts2;
            $history->current = $EHS->Emergency_Contacts2;
            $history->comment = $request->Emergency_Contacts2_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Emergency_Contacts2) || $lastDocument->Emergency_Contacts2 === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Emergency_Equipment != $EHS->Emergency_Equipment || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Emergency Equipment';
            $history->previous = $lastDocument->Emergency_Equipment;
            $history->current = $EHS->Emergency_Equipment;
            $history->comment = $request->Emergency_Equipment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Emergency_Equipment) || $lastDocument->Emergency_Equipment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Incident_Simulation_Drills != $EHS->Incident_Simulation_Drills || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Incident Simulation Drills';
            $history->previous = $lastDocument->Incident_Simulation_Drills;
            $history->current = $EHS->Incident_Simulation_Drills;
            $history->comment = $request->Incident_Simulation_Drills_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Incident_Simulation_Drills) || $lastDocument->Incident_Simulation_Drills === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Response_Time_Metrics != $EHS->Response_Time_Metrics || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Response Time Metrics';
            $history->previous = $lastDocument->Response_Time_Metrics;
            $history->current = $EHS->Response_Time_Metrics;
            $history->comment = $request->Response_Time_Metrics_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Response_Time_Metrics) || $lastDocument->Response_Time_Metrics === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Evacuation_Routes_and_Assembly_Points != $EHS->Evacuation_Routes_and_Assembly_Points || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Evacuation Routes and Assembly Points';
            $history->previous = $lastDocument->Evacuation_Routes_and_Assembly_Points;
            $history->current = $EHS->Evacuation_Routes_and_Assembly_Points;
            $history->comment = $request->Evacuation_Routes_and_Assembly_Points_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Evacuation_Routes_and_Assembly_Points) || $lastDocument->Evacuation_Routes_and_Assembly_Points === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Energy_Consumption != $EHS->Energy_Consumption || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Energy Consumption';
            $history->previous = $lastDocument->Energy_Consumption;
            $history->current = $EHS->Energy_Consumption;
            $history->comment = $request->Energy_Consumption_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Energy_Consumption) || $lastDocument->Energy_Consumption === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Greenhouse_Gas_Emissions != $EHS->Greenhouse_Gas_Emissions || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Greenhouse Gas Emissions';
            $history->previous = $lastDocument->Greenhouse_Gas_Emissions;
            $history->current = $EHS->Greenhouse_Gas_Emissions;
            $history->comment = $request->Greenhouse_Gas_Emissions_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Greenhouse_Gas_Emissions) || $lastDocument->Greenhouse_Gas_Emissions === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Wastewater_Discharge != $EHS->Wastewater_Discharge || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Wastewater Discharge';
            $history->previous = $lastDocument->Wastewater_Discharge;
            $history->current = $EHS->Wastewater_Discharge;
            $history->comment = $request->Wastewater_Discharge_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Wastewater_Discharge) || $lastDocument->Wastewater_Discharge === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Air_Quality_Monitoring != $EHS->Air_Quality_Monitoring || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Air Quality Monitoring';
            $history->previous = $lastDocument->Air_Quality_Monitoring;
            $history->current = $EHS->Air_Quality_Monitoring;
            $history->comment = $request->Air_Quality_Monitoring_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Air_Quality_Monitoring) || $lastDocument->Air_Quality_Monitoring === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Environmental_Sustainability_Projects != $EHS->Environmental_Sustainability_Projects || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Environmental Sustainability Projects';
            $history->previous = $lastDocument->Environmental_Sustainability_Projects;
            $history->current = $EHS->Environmental_Sustainability_Projects;
            $history->comment = $request->Environmental_Sustainability_Projects_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Environmental_Sustainability_Projects) || $lastDocument->Environmental_Sustainability_Projects === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }
        //================

        if ($lastDocument->enargy_type != $EHS->enargy_type || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Enargy Type';
            $history->previous = $lastDocument->enargy_type;
            $history->current = $EHS->enargy_type;
            $history->comment = $request->enargy_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->enargy_type) || $lastDocument->enargy_type === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->enargy_source != $EHS->enargy_source || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Enargy Source';
            $history->previous = $lastDocument->enargy_source;
            $history->current = $EHS->enargy_source;
            $history->comment = $request->enargy_source_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->enargy_source) || $lastDocument->enargy_source === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->energy_usage != $EHS->energy_usage || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Energy Usage';
            $history->previous = $lastDocument->energy_usage;
            $history->current = $EHS->energy_usage;
            $history->comment = $request->energy_usage_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->energy_usage) || $lastDocument->energy_usage === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->energy_intensity != $EHS->energy_intensity || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Energy Intensity';
            $history->previous = $lastDocument->energy_intensity;
            $history->current = $EHS->energy_intensity;
            $history->comment = $request->energy_intensity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->energy_intensity) || $lastDocument->energy_intensity === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->peak_demand != $EHS->peak_demand || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Peak Demand';
            $history->previous = $lastDocument->peak_demand;
            $history->current = $EHS->peak_demand;
            $history->comment = $request->peak_demand_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->peak_demand) || $lastDocument->peak_demand === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->energy_efficiency != $EHS->energy_efficiency || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Energy Efficiency';
            $history->previous = $lastDocument->energy_efficiency;
            $history->current = $EHS->energy_efficiency;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->energy_efficiency) || $lastDocument->energy_efficiency === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->co_emissions != $EHS->co_emissions || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'CO Emissions';
            $history->previous = $lastDocument->co_emissions;
            $history->current = $EHS->co_emissions;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->co_emissions) || $lastDocument->co_emissions === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->greenhouse_ges_emmission != $EHS->greenhouse_ges_emmission || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Greenhouse Ges Emmission';
            $history->previous = $lastDocument->greenhouse_ges_emmission;
            $history->current = $EHS->greenhouse_ges_emmission;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->greenhouse_ges_emmission) || $lastDocument->greenhouse_ges_emmission === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->scope_one_emission != $EHS->scope_one_emission || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Scope One Emission';
            $history->previous = $lastDocument->scope_one_emission;
            $history->current = $EHS->scope_one_emission;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->scope_one_emission) || $lastDocument->scope_one_emission === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->scope_two_emission != $EHS->scope_two_emission || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Scope Two Emission';
            $history->previous = $lastDocument->scope_two_emission;
            $history->current = $EHS->scope_two_emission;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->scope_two_emission) || $lastDocument->scope_two_emission === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->scope_three_emission != $EHS->scope_three_emission || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Scope Three Emission';
            $history->previous = $lastDocument->scope_three_emission;
            $history->current = $EHS->scope_three_emission;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->scope_three_emission) || $lastDocument->scope_three_emission === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->carbon_intensity != $EHS->carbon_intensity || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Carbon Intensity';
            $history->previous = $lastDocument->carbon_intensity;
            $history->current = $EHS->carbon_intensity;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->carbon_intensity) || $lastDocument->carbon_intensity === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->water_consumption != $EHS->water_consumption || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Water Consumption';
            $history->previous = $lastDocument->water_consumption;
            $history->current = $EHS->water_consumption;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->water_consumption) || $lastDocument->water_consumption === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->water_source != $EHS->water_source || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Water Source';
            $history->previous = $lastDocument->water_source;
            $history->current = $EHS->water_source;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->water_source) || $lastDocument->water_source === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->water_effeciency != $EHS->water_effeciency || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Water Effeciency';
            $history->previous = $lastDocument->water_effeciency;
            $history->current = $EHS->water_effeciency;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->water_effeciency) || $lastDocument->water_effeciency === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->water_discharge != $EHS->water_discharge || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Water Discharge';
            $history->previous = $lastDocument->water_discharge;
            $history->current = $EHS->water_discharge;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->water_discharge) || $lastDocument->water_discharge === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->waste_water_treatment != $EHS->waste_water_treatment || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Waste Water Treatment';
            $history->previous = $lastDocument->waste_water_treatment;
            $history->current = $EHS->waste_water_treatment;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->waste_water_treatment) || $lastDocument->waste_water_treatment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->rainwater_harvesting != $EHS->rainwater_harvesting || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Rainwater Harvesting';
            $history->previous = $lastDocument->rainwater_harvesting;
            $history->current = $EHS->rainwater_harvesting;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->rainwater_harvesting) || $lastDocument->rainwater_harvesting === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->sustainable_product_purchased != $EHS->sustainable_product_purchased || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Sustainable Product Purchased';
            $history->previous = $lastDocument->sustainable_product_purchased;
            $history->current = $EHS->sustainable_product_purchased;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->sustainable_product_purchased) || $lastDocument->sustainable_product_purchased === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->supplier_sustainability != $EHS->supplier_sustainability || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Supplier Sustainability';
            $history->previous = $lastDocument->supplier_sustainability;
            $history->current = $EHS->supplier_sustainability;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->supplier_sustainability) || $lastDocument->supplier_sustainability === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->sustainable_packaing != $EHS->sustainable_packaing || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Sustainable Packaing';
            $history->previous = $lastDocument->sustainable_packaing;
            $history->current = $EHS->sustainable_packaing;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->sustainable_packaing) || $lastDocument->sustainable_packaing === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->local_sourcing != $EHS->local_sourcing || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Local Sourcing';
            $history->previous = $lastDocument->local_sourcing;
            $history->current = $EHS->local_sourcing;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->local_sourcing) || $lastDocument->local_sourcing === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->fair_trade != $EHS->fair_trade || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Fair Trade';
            $history->previous = $lastDocument->fair_trade;
            $history->current = $EHS->fair_trade;
            $history->comment = $request->Other_Authority_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->fair_trade) || $lastDocument->fair_trade === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->fuel_consumption != $EHS->fuel_consumption || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Fuel Consumption';
            $history->previous = $lastDocument->fuel_consumption;
            $history->current = $EHS->fuel_consumption;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->fuel_consumption) || $lastDocument->fuel_consumption === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Vehicle_Type1 != $EHS->Vehicle_Type1 || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Vehicle Type';
            $history->previous = $lastDocument->Vehicle_Type1;
            $history->current = $EHS->Vehicle_Type1;
            $history->comment = $request->Other_Authority_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Vehicle_Type1) || $lastDocument->Vehicle_Type1 === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->fleet_emissions != $EHS->fleet_emissions || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Fleet Emissions';
            $history->previous = $lastDocument->fleet_emissions;
            $history->current = $EHS->fleet_emissions;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->fleet_emissions) || $lastDocument->fleet_emissions === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->miles_traveled != $EHS->miles_traveled || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Miles Traveled';
            $history->previous = $lastDocument->miles_traveled;
            $history->current = $EHS->miles_traveled;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->miles_traveled) || $lastDocument->miles_traveled === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->freight_and_shipping != $EHS->freight_and_shipping || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Freight and Shipping';
            $history->previous = $lastDocument->freight_and_shipping;
            $history->current = $EHS->freight_and_shipping;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->freight_and_shipping) || $lastDocument->freight_and_shipping === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->carbon_pffset_programs != $EHS->carbon_pffset_programs || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Carbon Offset Programs';
            $history->previous = $lastDocument->carbon_pffset_programs;
            $history->current = $EHS->carbon_pffset_programs;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->carbon_pffset_programs) || $lastDocument->carbon_pffset_programs === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->land_area_impacted != $EHS->land_area_impacted || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Land Area Impacted';
            $history->previous = $lastDocument->land_area_impacted;
            $history->current = $EHS->land_area_impacted;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->land_area_impacted) || $lastDocument->land_area_impacted === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->protected_areas != $EHS->protected_areas || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Protected Areas';
            $history->previous = $lastDocument->protected_areas;
            $history->current = $EHS->protected_areas;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->protected_areas) || $lastDocument->protected_areas === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->deforestation != $EHS->deforestation || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Deforestation';
            $history->previous = $lastDocument->deforestation;
            $history->current = $EHS->deforestation;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->deforestation) || $lastDocument->deforestation === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->habitat_preservation != $EHS->habitat_preservation || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Habitat Preservation';
            $history->previous = $lastDocument->habitat_preservation;
            $history->current = $EHS->habitat_preservation;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->habitat_preservation) || $lastDocument->habitat_preservation === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->biodiversity_initiatives != $EHS->biodiversity_initiatives || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Biodiversity Initiatives';
            $history->previous = $lastDocument->biodiversity_initiatives;
            $history->current = $EHS->biodiversity_initiatives;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->biodiversity_initiatives) || $lastDocument->biodiversity_initiatives === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->certifications != $EHS->certifications || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Certifications';
            $history->previous = $lastDocument->certifications;
            $history->current = $EHS->certifications;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->certifications) || $lastDocument->certifications === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->regulatory_compliance != $EHS->regulatory_compliance || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Regulatory Compliance';
            $history->previous = $lastDocument->regulatory_compliance;
            $history->current = $EHS->regulatory_compliance;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->regulatory_compliance) || $lastDocument->regulatory_compliance === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->audits != $EHS->audits || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Audits';
            $history->previous = $lastDocument->audits;
            $history->current = $EHS->audits;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->audits) || $lastDocument->audits === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->enviromental_risk != $EHS->enviromental_risk || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Enviromental Risk';
            $history->previous = $lastDocument->enviromental_risk;
            $history->current = $EHS->enviromental_risk;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->enviromental_risk) || $lastDocument->enviromental_risk === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->impact_assessment != $EHS->impact_assessment || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Impact Assessment';
            $history->previous = $lastDocument->impact_assessment;
            $history->current = $EHS->impact_assessment;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->impact_assessment) || $lastDocument->impact_assessment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->climate_change_adaptation != $EHS->climate_change_adaptation || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Climate Change Adaptation';
            $history->previous = $lastDocument->climate_change_adaptation;
            $history->current = $EHS->climate_change_adaptation;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->climate_change_adaptation) || $lastDocument->climate_change_adaptation === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->carbon_footprint != $EHS->carbon_footprint || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Carbon Footprint';
            $history->previous = $lastDocument->carbon_footprint;
            $history->current = $EHS->carbon_footprint;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->carbon_footprint) || $lastDocument->carbon_footprint === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Risk_Assessment_Data != $EHS->Risk_Assessment_Data || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Risk Assessment Data';
            $history->previous = $lastDocument->Risk_Assessment_Data;
            $history->current = $EHS->Risk_Assessment_Data;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Risk_Assessment_Data) || $lastDocument->Risk_Assessment_Data === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->hazard_id_reports != $EHS->hazard_id_reports || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Hazard Id Reports';
            $history->previous = $lastDocument->hazard_id_reports;
            $history->current = $EHS->hazard_id_reports;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->hazard_id_reports) || $lastDocument->hazard_id_reports === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->risk_migration_plan != $EHS->risk_migration_plan || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Risk Migration Plan';
            $history->previous = $lastDocument->risk_migration_plan;
            $history->current = $EHS->risk_migration_plan;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->risk_migration_plan) || $lastDocument->risk_migration_plan === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->corrective_action != $EHS->corrective_action || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Corrective Action';
            $history->previous = $lastDocument->corrective_action;
            $history->current = $EHS->corrective_action;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->corrective_action) || $lastDocument->corrective_action === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->audit_id != $EHS->audit_id || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Audit Id';
            $history->previous = $lastDocument->audit_id;
            $history->current = $EHS->audit_id;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->audit_id) || $lastDocument->audit_id === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Audit_Type != $EHS->Audit_Type || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Audit Type';
            $history->previous = $lastDocument->Audit_Type;
            $history->current = $EHS->Audit_Type;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Audit_Type) || $lastDocument->Audit_Type === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->audit_date != $EHS->audit_date || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Audit Date';
            $history->previous = $lastDocument->audit_date;
            $history->current = $EHS->audit_date;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->audit_date) || $lastDocument->audit_date === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->audit_scope != $EHS->audit_scope || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Audit Scope';
            $history->previous = $lastDocument->audit_scope;
            $history->current = $EHS->audit_scope;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->audit_scope) || $lastDocument->audit_scope === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->finding_and_observation != $EHS->finding_and_observation || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Finding and Observation';
            $history->previous = $lastDocument->finding_and_observation;
            $history->current = $EHS->finding_and_observation;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->finding_and_observation) || $lastDocument->finding_and_observation === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->corrective_action_plans != $EHS->corrective_action_plans || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Corrective Action Plans';
            $history->previous = $lastDocument->corrective_action_plans;
            $history->current = $EHS->corrective_action_plans;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->corrective_action_plans) || $lastDocument->corrective_action_plans === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->follow_up_audit_result != $EHS->follow_up_audit_result || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Follow Up Audit Result';
            $history->previous = $lastDocument->follow_up_audit_result;
            $history->current = $EHS->follow_up_audit_result;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->follow_up_audit_result) || $lastDocument->follow_up_audit_result === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->sustainability_initiatives != $EHS->sustainability_initiatives || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Sustainability Initiatives';
            $history->previous = $lastDocument->sustainability_initiatives;
            $history->current = $EHS->sustainability_initiatives;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->sustainability_initiatives) || $lastDocument->sustainability_initiatives === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->csr_activities != $EHS->csr_activities || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'CSR Activities';
            $history->previous = $lastDocument->csr_activities;
            $history->current = $EHS->csr_activities;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->csr_activities) || $lastDocument->csr_activities === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->sustainability_reporting != $EHS->sustainability_reporting || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Sustainability Reporting';
            $history->previous = $lastDocument->sustainability_reporting;
            $history->current = $EHS->sustainability_reporting;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->sustainability_reporting) || $lastDocument->sustainability_reporting === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->public_relation_report != $EHS->public_relation_report || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Public Relation Report';
            $history->previous = $lastDocument->public_relation_report;
            $history->current = $EHS->public_relation_report;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->public_relation_report) || $lastDocument->public_relation_report === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Dashboards != $EHS->Dashboards || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Dashboards';
            $history->previous = $lastDocument->Dashboards;
            $history->current = $EHS->Dashboards;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Dashboards) || $lastDocument->Dashboards === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->key_performance_indicators != $EHS->key_performance_indicators || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Key Performance Indicators';
            $history->previous = $lastDocument->key_performance_indicators;
            $history->current = $EHS->key_performance_indicators;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->key_performance_indicators) || $lastDocument->key_performance_indicators === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->trend_analysis != $EHS->trend_analysis || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Trend Analysis';
            $history->previous = $lastDocument->trend_analysis;
            $history->current = $EHS->trend_analysis;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->trend_analysis) || $lastDocument->trend_analysis === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->data_export_functionality != $EHS->data_export_functionality || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Data Export Functionality';
            $history->previous = $lastDocument->data_export_functionality;
            $history->current = $EHS->data_export_functionality;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->data_export_functionality) || $lastDocument->data_export_functionality === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->monthly_annual_reports != $EHS->monthly_annual_reports || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Monthly Annual Reports';
            $history->previous = $lastDocument->monthly_annual_reports;
            $history->current = $EHS->monthly_annual_reports;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->monthly_annual_reports) || $lastDocument->monthly_annual_reports === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->KPIs != $EHS->KPIs || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'KPIs (Key Performance Indicators)';
            $history->previous = $lastDocument->KPIs;
            $history->current = $EHS->KPIs;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->KPIs) || $lastDocument->KPIs === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->sustainability_targets != $EHS->sustainability_targets || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Sustainability Targets';
            $history->previous = $lastDocument->sustainability_targets;
            $history->current = $EHS->sustainability_targets;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->sustainability_targets) || $lastDocument->sustainability_targets === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->progress_towards_goals != $EHS->progress_towards_goals || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Progress Towards Goals';
            $history->previous = $lastDocument->progress_towards_goals;
            $history->current = $EHS->progress_towards_goals;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->progress_towards_goals) || $lastDocument->progress_towards_goals === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->training_programs != $EHS->training_programs || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Training Programs';
            $history->previous = $lastDocument->training_programs;
            $history->current = $EHS->training_programs;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->training_programs) || $lastDocument->training_programs === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->employee_involcement != $EHS->employee_involcement || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Employee Involcement';
            $history->previous = $lastDocument->employee_involcement;
            $history->current = $EHS->employee_involcement;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->employee_involcement) || $lastDocument->employee_involcement === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->sustainability_awareness != $EHS->sustainability_awareness || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Sustainability Awareness';
            $history->previous = $lastDocument->sustainability_awareness;
            $history->current = $EHS->sustainability_awareness;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->sustainability_awareness) || $lastDocument->sustainability_awareness === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->community_project != $EHS->community_project || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Community Project';
            $history->previous = $lastDocument->community_project;
            $history->current = $EHS->community_project;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->community_project) || $lastDocument->community_project === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->Partnerships != $EHS->Partnerships || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Partnerships';
            $history->previous = $lastDocument->Partnerships;
            $history->current = $EHS->Partnerships;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->Partnerships) || $lastDocument->Partnerships === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastDocument->social_impact != $EHS->social_impact || ! empty($request->Other_Authority_comment)) {
            $history = new EHSEventAuditTrail;
            $history->ehsEvent_id = $id;
            $history->activity_type = 'Social Impact';
            $history->previous = $lastDocument->social_impact;
            $history->current = $EHS->social_impact;
            $history->comment = $request->energy_efficiency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;

            // Null or empty check
            if (is_null($lastDocument->social_impact) || $lastDocument->social_impact === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        toastr()->success('Record is Update Successfully');

        return back();
    }

    public function ehsEventStateChange(Request $request, $id)
    {

        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $EHSControl = EHSEvent::find($id);
            $lastDocument = EHSEvent::find($id);

            if ($EHSControl->stage == 1) {
                $EHSControl->stage = '2';
                $EHSControl->status = 'Pending Review';
                $EHSControl->Submit_By = Auth::user()->name;
                $EHSControl->Submit_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Submit_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Submit By,Submit On';
                $history->action = 'Submit';
                // $history->previous = "";
                // $history->current = $EHSControl->Submit_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;

                $history->change_to = 'Pending Review';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Review';
                $history->action_name = 'Update';
                if (is_null($lastDocument->Submit_By) || $lastDocument->Submit_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Submit_By.' , '.$lastDocument->Submit_On;
                }
                $history->current = $EHSControl->Submit_By.' , '.$EHSControl->Submit_On;
                if (is_null($lastDocument->Submit_By) || $lastDocument->Submit_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
               
                 $list = Helpers::getLineManagerUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Initiator";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "Submit", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Submit Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }
                

                $EHSControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 2) {
                $EHSControl->stage = '3';
                $EHSControl->status = 'Pending Investigation';
                $EHSControl->Review_Complete_By = Auth::user()->name;
                $EHSControl->Review_Complete_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Review_Complete_Comment = $request->comment;
                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Review Complete By,Review Complete On';
                $history->action = 'Review Complete';
                // $history->previous = "";
                // $history->current = $EHSControl->Review_Complete_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Pending Investigation';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Investigation';
                $history->action_name = 'Update';
                if (is_null($lastDocument->Review_Complete_By) || $lastDocument->Review_Complete_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Review_Complete_By.' , '.$lastDocument->Review_Complete_On;
                }
                $history->current = $EHSControl->Review_Complete_By.' , '.$EHSControl->Review_Complete_On;
                if (is_null($lastDocument->Review_Complete_By) || $lastDocument->Review_Complete_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                 /********** Notification User **********/
               
                 $list = Helpers::getLeadInvestigatorUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Line Manager";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "Review Complete", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Review Complete Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                $EHSControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 3) {
                $EHSControl->stage = '4';
                $EHSControl->status = 'Root Cause and Risk Analysis';
                $EHSControl->Complete_Investigation_By = Auth::user()->name;
                $EHSControl->Complete_Investigation_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Complete_Investigation_Comment = $request->comment;
                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Complete Investigation By,Complete Investigation On';
                $history->action = 'Complete Investigation';
                // $history->previous = "";
                // $history->current = $EHSControl->Complete_Investigation_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Root Cause and Risk Analysis';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Root Cause and Risk Analysis';
                $history->action_name = 'Update';
                if (is_null($lastDocument->Complete_Investigation_By) || $lastDocument->Complete_Investigation_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Complete_Investigation_By.' , '.$lastDocument->Complete_Investigation_On;
                }
                $history->current = $EHSControl->Complete_Investigation_By.' , '.$EHSControl->Complete_Investigation_On;
                if (is_null($lastDocument->Complete_Investigation_By) || $lastDocument->Complete_Investigation_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
               
                 $list = Helpers::getSafetyOfficerUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Lead Investigator";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "Complete Investigation", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Complete Investigation Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                $EHSControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 4) {
                $EHSControl->stage = '5';
                $EHSControl->status = 'Pending Action Planning';
                $EHSControl->Analysis_Complete_By = Auth::user()->name;
                $EHSControl->Analysis_Complete_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Analysis_Complete_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Analysis Complete By,Analysis Complete On';
                $history->action = 'Analysis Complete';
                // $history->previous = "";
                // $history->current = $EHSControl->Analysis_Complete_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Pending Action Planning';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Action Planning';
                $history->action_name = 'Update';
                if (is_null($lastDocument->Analysis_Complete_By) || $lastDocument->Analysis_Complete_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Analysis_Complete_By.' , '.$lastDocument->Analysis_Complete_On;
                }
                $history->current = $EHSControl->Analysis_Complete_By.' , '.$EHSControl->acknowledge_on;
                if (is_null($lastDocument->Analysis_Complete_By) || $lastDocument->Analysis_Complete_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $EHSControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 5) {
                // if (is_null($EHSControl->training_required))
                // {
                //     Session::flash('swal', [
                //         'type' => 'warning',
                //         'title' => 'Mandatory Fields!',
                //         'message' => 'Training Required tab is yet to be filled'
                //     ]);

                //     return redirect()->back();
                // }
                //  else {
                //     // dd($updateCFT->intial_update_comments);
                //     Session::flash('swal', [
                //         'type' => 'success',
                //         'title' => 'Success',
                //         'message' => 'Document Sent'
                //     ]);
                // }
                $getTrainingData = EHSTrainingAndAwarenesssGrid::where(['ehsEvent_id' => $id, 'identifier' => "EHSTrainingAndAwareness"])->first();
                $trainingPlanData = $getTrainingData ? (is_array($getTrainingData->data) ? $getTrainingData->data : json_decode($getTrainingData->data, true)) : [];

                if(!empty($trainingPlanData)){
                    foreach ($trainingPlanData as $data) {

                        $dddd = EHSEnvironmentTrainingData::create([
                            'ehsEvent_id' => $id,
                            'trainingTopic' => $data['trainingTopic'],
                            'documentNumber' => $data['documentNumber'],
                            'documentName' => $data['documentName'],
                            'sopType' => $data['sopType'],
                            'trainingType' => $data['trainingType'],
                            'trainees' => $data['trainees'],
                            'startDate' => $data['startDate'],
                            'endDate' => $data['endDate'],
                            'trainer' => $data['trainer'],
                            'trainingAttempt' => $data['trainingAttempt'],
                            'per_screen_run_time' => $data['per_screen_run_time'],
                            'total_minimum_time' => $data['total_minimum_time'],
                        ]);
                    }
                }
                $EHSControl->stage = '6';
                $EHSControl->status = 'Pending Training';
                $EHSControl->Training_required_by = Auth::user()->name;
                $EHSControl->Training_required_on = Carbon::now()->format('d-M-Y');
                $EHSControl->Training_required_comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Training Required By,Training Required On';
                $history->action = 'Training Required';
                // $history->previous = "";
                // $history->current = $EHSControl->Training_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Pending Training';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Training';
                $history->action_name = 'Update';
                if (is_null($lastDocument->Training_required_by) || $lastDocument->Training_required_by === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Training_required_by.' , '.$lastDocument->Training_required_on;
                }
                $history->current = $EHSControl->Training_required_by.' , '.$EHSControl->Training_required_on;
                if (is_null($lastDocument->Training_required_by) || $lastDocument->Training_required_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
                //  $list = Helpers::getTrainingCoordinatorUserList($EHSControl->division_id);               
                 $list = Helpers::getLineManagerUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Safety Officer";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "Training Required", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Training Required Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }
                $EHSControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 6) {
                $EHSControl->stage = '7';
                $EHSControl->status = 'Training Complete';
                $EHSControl->Training_complete_by = Auth::user()->name;
                $EHSControl->Training_complete_on = Carbon::now()->format('d-M-Y');
                $EHSControl->Training_complete_comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Training Complete By,Training Complete On';
                $history->action = 'Training Complete';
                // $history->previous = "";
                // $history->current = $EHSControl->Training_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Training Complete';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Training Complete';
                $history->action_name = 'Update';
                if (is_null($lastDocument->Training_complete_by) || $lastDocument->Training_complete_by === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Training_complete_by.' , '.$lastDocument->Training_complete_on;
                }
                $history->current = $EHSControl->Training_complete_by.' , '.$EHSControl->Training_complete_on;
                if (is_null($lastDocument->Training_complete_by) || $lastDocument->Training_complete_by === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $EHSControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 7) {
                $EHSControl->stage = '8';
                $EHSControl->status = 'Pending Approval';
                $EHSControl->Propose_Plan_By = Auth::user()->name;
                $EHSControl->Propose_Plan_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Propose_Plan_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Propose Plan By,Propose Plan On';
                $history->action = 'Propose Plan';
                // $history->previous = "";
                // $history->current = $EHSControl->Propose_Plan_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Pending Approval';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Approval';
                $history->action_name = 'Update';
                if (is_null($lastDocument->Propose_Plan_By) || $lastDocument->Propose_Plan_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Propose_Plan_By.' , '.$lastDocument->Propose_Plan_On;
                }
                $history->current = $EHSControl->Propose_Plan_By.' , '.$EHSControl->Propose_Plan_On;
                if (is_null($lastDocument->Propose_Plan_By) || $lastDocument->Propose_Plan_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $EHSControl->update();

                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
               
                 $list = Helpers::getLineManagerUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Training Coordinator";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "Propose Plan", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Propose Plan Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 8) {
                $EHSControl->stage = '9';
                $EHSControl->status = 'CAPA Execution in Progress';
                $EHSControl->Approve_Plan_By = Auth::user()->name;
                $EHSControl->Approve_Plan_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Approve_Plan_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Approve Plan By,Approve Plan On';
                $history->action = 'Approve Plan';
                // $history->previous = "";
                // $history->current = $EHSControl->Approve_Plan_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'CAPA Execution in Progress';
                $history->change_from = $lastDocument->status;
                $history->stage = 'CAPA Execution in Progress';
                $history->action_name = 'Update';
                if (is_null($lastDocument->Approve_Plan_By) || $lastDocument->Approve_Plan_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Approve_Plan_By.' , '.$lastDocument->Approve_Plan_On;
                }
                $history->current = $EHSControl->Approve_Plan_By.' , '.$EHSControl->Approve_Plan_On;
                if (is_null($lastDocument->Approve_Plan_By) || $lastDocument->Approve_Plan_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $EHSControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 9) {
                $EHSControl->stage = '10';
                $EHSControl->status = 'Closed - Done';
                $EHSControl->All_CAPA_Closed_By = Auth::user()->name;
                $EHSControl->All_CAPA_Closed_On = Carbon::now()->format('d-M-Y');
                $EHSControl->All_CAPA_Closed_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'All CAPA Closed By,All CAPA Closed On';
                $history->action = 'All CAPA Closed';
                // $history->previous = "";
                // $history->current = $EHSControl->All_CAPA_Closed_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Closed - Done';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Closed - Done';
                $history->action_name = 'Update';
                if (is_null($lastDocument->All_CAPA_Closed_By) || $lastDocument->All_CAPA_Closed_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->All_CAPA_Closed_By.' , '.$lastDocument->All_CAPA_Closed_On;
                }
                $history->current = $EHSControl->All_CAPA_Closed_By.' , '.$EHSControl->All_CAPA_Closed_On;
                if (is_null($lastDocument->All_CAPA_Closed_By) || $lastDocument->All_CAPA_Closed_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $EHSControl->update();
                toastr()->success('Document Sent');

                return back();
            }
        } else {
            toastr()->error('E-signature Not match');

            return back();
        }
    }

    public function EHSCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $EHSControl = EHSEvent::find($id);
            $lastDocument = EHSEvent::find($id);

            if ($EHSControl->stage == 2) {
                $EHSControl->stage = '0';
                $EHSControl->status = 'Closed-Cancelled';
                $EHSControl->Cancel_By = Auth::user()->name;
                $EHSControl->Cancel_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Cancel_Comment = $request->comment;
                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Cancel By,Cancel On';
                $history->action = 'Cancel';
                // $history->previous = "";
                // $history->current = $EHSControl->Cancel_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $EHSControl->status;
                $history->change_to = 'Closed-Cancelled';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Closed-Cancelled';
                if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Cancel_By.' , '.$lastDocument->Cancel_On;
                }
                $history->current = $EHSControl->Cancel_By.' , '.$EHSControl->Cancel_On;
                if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $EHSControl->update();
                $history = new EHSEventHistory;
                $history->type = 'EHS & Environment Sustainability';
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $EHSControl->stage;
                $history->status = $EHSControl->status;
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $EHSControl->division_id){
                //       $email = Helpers::getInitiatorEmail($u->user_id);
                //       if ($email !== null) {

                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $EHSControl],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("Cancelled By ".Auth::user()->name);
                //             }
                //          );
                //       }
                //     }
                // }

                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 1) {
                $EHSControl->stage = '0';
                $EHSControl->status = 'Closed-Cancelled';
                $EHSControl->Cancelled_By = Auth::user()->name;
                $EHSControl->Cancelled_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Cancelled_Comment = $request->comment;
                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Cancel By,Cancel On';
                $history->action = 'Cancel';
                // $history->previous = "";
                // $history->current = $EHSControl->Cancelled_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $EHSControl->status;
                $history->change_to = 'Closed-Cancelled';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Closed-Cancelled';
                if (is_null($lastDocument->Cancelled_By) || $lastDocument->Cancelled_By === '') {
                    $history->previous = '';
                } else {
                    $history->previous = $lastDocument->Cancelled_By.' , '.$lastDocument->Cancelled_On;
                }
                $history->current = $EHSControl->Cancelled_By.' , '.$EHSControl->Cancelled_On;
                if (is_null($lastDocument->Cancelled_By) || $lastDocument->Cancelled_By === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->save();
                $EHSControl->update();
                $history = new EHSEventHistory;
                $history->type = 'EHS & Environment Sustainability';
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $EHSControl->stage;
                $history->status = $EHSControl->status;
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $EHSControl->division_id){
                //       $email = Helpers::getInitiatorEmail($u->user_id);
                //       if ($email !== null) {

                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $EHSControl],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("Cancelled By ".Auth::user()->name);
                //             }
                //          );
                //       }
                //     }
                // }

                toastr()->success('Document Sent');

                return back();
            }
        } else {
            toastr()->error('E-signature Not match');

            return back();
        }
    }

    public function ehsMoreInfo(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $EHSControl = EHSEvent::find($id);
            $lastDocument = EHSEvent::find($id);
            if ($EHSControl->stage == 2) {
                $EHSControl->stage = '1';
                $EHSControl->status = 'Opened';
                $EHSControl->More_Info_Required_By = Auth::user()->name;
                $EHSControl->more_info_required_on = Carbon::now()->format('d-M-Y');
                $EHSControl->More_Info_Required_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action = 'More Information Required';
                $history->current = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Opened';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Opened';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->More_Info_Required_By) || $lastDocument->More_Info_Required_By === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->More_Info_Required_By . ' , ' . $lastDocument->more_info_required_on;
                // }
                // $history->current = $EHSControl->More_Info_Required_By . ' , ' . $EHSControl->more_info_required_on;
                // if (is_null($lastDocument->More_Info_Required_By) || $lastDocument->More_Info_Required_By === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
               
                 $list = Helpers::getInitiatorUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Initiator";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "More Information Required", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Information Required Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                $EHSControl->update();
                $history = new EHSEventHistory;
                $history->type = 'EHS & Environment Sustainability';
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $EHSControl->stage;
                $history->status = $EHSControl->status;
                $history->save();

                toastr()->success('Document Sent');

                return back();
            }

            if ($EHSControl->stage == 4) {
                $EHSControl->stage = '3';
                $EHSControl->status = 'Pending CAPA Plan';
                $EHSControl->More_Investigation_Req_By = Auth::user()->name;
                $EHSControl->More_Investigation_Req_On = Carbon::now()->format('d-M-Y');
                $EHSControl->More_Investigation_Req_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action = 'More Investigation Required';
                $history->current = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Pending Investigation';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Investigation';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->More_Investigation_Req_By) || $lastDocument->More_Investigation_Req_By === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->More_Investigation_Req_By . ' , ' . $lastDocument->More_Investigation_Req_On;
                // }
                // $history->current = $EHSControl->More_Investigation_Req_By . ' , ' . $EHSControl->More_Investigation_Req_On;
                // if (is_null($lastDocument->More_Investigation_Req_By) || $lastDocument->More_Investigation_Req_By === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
               
                 $list = Helpers::getLeadInvestigatorUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Safety Officer";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "More Investigation Required", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Investigation Required Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                $EHSControl->update();
                $history = new EHSEventHistory;
                $history->type = 'EHS & Environment Sustainability';
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $EHSControl->stage;
                $history->status = $EHSControl->status;
                $history->save();
                // $list = Helpers::getHodUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $EHSControl->division_id){
                //      $email = Helpers::getInitiatorEmail($u->user_id);
                //      if ($email !== null) {
                //          Mail::send(
                //             'mail.view-mail',
                //             ['data' => $EHSControl],
                //             function ($message) use ($email) {
                //                 $message->to($email)
                //                     ->subject("Document is Send By ".Auth::user()->name);
                //             }
                //         );
                //       }
                //     }
                // }
                toastr()->success('Document Sent');

                return back();
            }

            if ($EHSControl->stage == 6) {
                $EHSControl->stage = '5';
                $EHSControl->status = 'Pending Action Planning';
                $EHSControl->Pending_More_Info_by = Auth::user()->name;
                $EHSControl->Pending_More_Info_on = Carbon::now()->format('d-M-Y');
                $EHSControl->Pending_More_Info_comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action = 'More Information Required';
                $history->current = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Pending Action Planning';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Action Planning';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->Pending_More_Info_by) || $lastDocument->Pending_More_Info_by === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->Pending_More_Info_by . ' , ' . $lastDocument->Pending_More_Info_on;
                // }
                // $history->current = $EHSControl->Pending_More_Info_by . ' , ' . $EHSControl->Pending_More_Info_on;
                // if (is_null($lastDocument->Pending_More_Info_by) || $lastDocument->Pending_More_Info_by === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();

                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
               
                 $list = Helpers::getSafetyOfficerUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Training Coordinator";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "More Information Required", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Information Required Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }

                $EHSControl->update();
                $history = new EHSEventHistory;
                $history->type = 'EHS & Environment Sustainability';
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $EHSControl->stage;
                $history->status = $EHSControl->status;
                $history->save();
                toastr()->success('Document Sent');

                return back();
            }

            if ($EHSControl->stage == 8) {
                $EHSControl->stage = '5';
                $EHSControl->status = 'Pending Action Planning';
                $EHSControl->Reject_By = Auth::user()->name;
                $EHSControl->Reject_On = Carbon::now()->format('d-M-Y');
                $EHSControl->Reject_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action = 'Reject';
                $history->current = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Pending Action Planning';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Action Planning';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->Reject_By) || $lastDocument->Reject_By === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->Reject_By . ' , ' . $lastDocument->Reject_On;
                // }
                // $history->current = $EHSControl->Reject_By . ' , ' . $EHSControl->Reject_On;
                // if (is_null($lastDocument->Reject_By) || $lastDocument->Reject_By === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();
                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
               
                 $list = Helpers::getSafetyOfficerUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Line Manager";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "Reject", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: Reject Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }
                $EHSControl->update();
                $history = new EHSEventHistory;
                $history->type = 'EHS & Environment Sustainability';
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $EHSControl->stage;
                $history->status = $EHSControl->status;
                $history->save();
                toastr()->success('Document Sent');

                return back();
            }
            if ($EHSControl->stage == 9) {
                $EHSControl->stage = '5';
                $EHSControl->status = 'Pending Action Planning';
                $EHSControl->More_Infomation_By = Auth::user()->name;
                $EHSControl->More_Infomation_On = Carbon::now()->format('d-M-Y');
                $EHSControl->More_Infomation_Comment = $request->comment;

                $history = new EHSEventAuditTrail;
                $history->ehsEvent_id = $id;
                $history->activity_type = 'Not Applicable';
                $history->previous = 'Not Applicable';
                $history->action = 'More Information Required';
                $history->current = 'Not Applicable';
                $history->action_name = 'Not Applicable';
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = 'Pending Action Planning';
                $history->change_from = $lastDocument->status;
                $history->stage = 'Pending Action Planning';
                // $history->action_name = 'Update';
                // if (is_null($lastDocument->More_Infomation_By) || $lastDocument->More_Infomation_By === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->More_Infomation_By . ' , ' . $lastDocument->More_Infomation_On;
                // }
                // $history->current = $EHSControl->More_Infomation_By . ' , ' . $EHSControl->More_Infomation_On;
                // if (is_null($lastDocument->More_Infomation_By) || $lastDocument->More_Infomation_By === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                $history->save();
                // $list = Helpers::getInitiatorUserList();
                 /********** Notification User **********/
               
                 $list = Helpers::getSafetyOfficerUserList($EHSControl->division_id);
                 $userIds = collect($list)->pluck('user_id')->toArray();
                 $users = User::whereIn('id', $userIds)->select('id', 'name', 'email')->get();
                 $userIds = $users->pluck('id');
                    if(!empty($users)){
                        try {
                            $history = new EHSEventAuditTrail();
                            $history->ehsEvent_id = $id;
                            $history->activity_type = "Not Applicable";
                            $history->previous = "Not Applicable";
                            $history->current = "Not Applicable";
                            $history->action = 'Notification';
                            $history->comment = "";
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = "Not Applicable";
                            $history->change_to = "Not Applicable";
                            $history->change_from = $lastDocument->status;
                            $history->stage = "";
                            $history->action_name = "";
                            $history->mailUserId = $userIds;
                            $history->role_name = "Line Manager";
                            $history->save();
                        } catch (\Throwable $e) {
                            \Log::error('Mail failed to send: ' . $e->getMessage());
                        }
                    }

                 foreach ($users as $userValue) {
                     DB::table('notifications')->insert([
                         'activity_id' => $EHSControl->id,
                         'activity_type' => "Notification",
                         'from_id' => Auth::user()->id,
                         'user_name' => $userValue->name,
                         'to_id' => $userValue->id,
                         'process_name' => "EHS & Environment Sustainability",
                         'division_id' => $EHSControl->division_id,
                         'short_description' => $EHSControl->short_description,
                         'initiator_id' => $EHSControl->initiator_id,
                         'due_date' => $EHSControl->due_date,
                         'record' => $EHSControl->record,
                         'site' => "EHS & Environment Sustainability",
                         'comment' => $request->comments,
                         'status' => $EHSControl->status,
                         'stage' => $EHSControl->stage,
                         'created_at' => Carbon::now(),
                     ]);
                 }
                

                foreach ($list as $u) {
                    $email = Helpers::getUserEmail($u->user_id);
                        if ($email !== null) {
                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $EHSControl, 'site' => "EHS & Environment Sustainability", 'history' => "More Information Required", 'process' => 'EHS & Environment Sustainability', 'comment' => $request->comment, 'user' => Auth::user()->name],
                                function ($message) use ($email, $EHSControl) {
                                    $message->to($email)
                                    ->subject("Medicef Notification: EHS & Environment Sustainability, Record #" . str_pad($EHSControl->record, 4, '0', STR_PAD_LEFT) . " - Activity: More Information Required Performed");
                                }
                            );
                        } catch(\Exception $e) {
                            info('Error sending mail', [$e]);
                        }
                    }
                }
                $EHSControl->update();
                $history = new EHSEventHistory;
                $history->type = 'EHS & Environment Sustainability';
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $EHSControl->stage;
                $history->status = $EHSControl->status;
                $history->save();
                toastr()->success('Document Sent');

                return back();
            }
        } else {
            toastr()->error('E-signature Not match');

            return back();
        }
    }

    // public function ehsChild(Request $request, $id)
    // {
    //     $record = ((RecordNumber::first()->value('counter')) + 1);
    //     $record = str_pad($record, 4, '0', STR_PAD_LEFT);
    //     $parent_id = $id;
    //     $parent_type = "EHS & Environment Sustainability";
    //     $parent_name = "EHS & Environment Sustainability";
    //     $parent_name = $request->$parent_name;
    //     $parent_record = EHSEvent::where('id', $id)->value('record');
    //     $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
    //     $currentDate = Carbon::now();
    //     $formattedDate = $currentDate->addDays(30);
    //     $due_date = $formattedDate->format('Y-m-d');
    //     $record_number = $record;
    //     return view("frontend.forms.root-cause-analysis", compact('due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record'));
    // }

    public function ehsChild(Request $request, $id)
    {

        $cft = [];
        $data = EHSEvent::find($id);
        $parent_id = $id;
        $parent_type = 'EHS & Environment Sustainability';
        $parent_name = 'EHS & Environment Sustainability';
        $parent_name = $request->$parent_name;
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $parent_record = EHSEvent::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = EHSEvent::where('id', $id)->value('division_id');
        $parent_initiator_id = EHSEvent::where('id', $id)->value('initiator_id');
        $parent_intiation_date = EHSEvent::where('id', $id)->value('intiation_date');
        $parent_created_at = EHSEvent::where('id', $id)->value('created_at');
        $parent_short_description = EHSEvent::where('id', $id)->value('short_description');
        $hod = User::where('role', 4)->get();

        if ($request->child_type == 'CAPA') {

            $old_records = ActionItem::select('id', 'division_id', 'record')->get();
            $record = ((RecordNumber::first()->value('counter')) + 1);
            $record = str_pad($record, 4, '0', STR_PAD_LEFT);
            $record_number = $record;

            return view('frontend.forms.capa', compact('due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record', 'old_records'));
        } elseif ($request->child_type == 'Sanction') {

            return view('frontend.sanction.sanction_create', compact('due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record'));
        } elseif ($request->child_type == 'Action Item') {
            $old_record = ActionItem::select('id', 'division_id', 'record')->get();
            $record = ((RecordNumber::first()->value('counter')) + 1);
            $record = str_pad($record, 4, '0', STR_PAD_LEFT);
            $record_number = $record;
            $expectedParenRecord = Helpers::getDivisionName($data->division_id).'/EE/'.date('Y').'/'.str_pad($data->record, 4, '0', STR_PAD_LEFT);

            return view('frontend.action-item.action-item', compact('old_record', 'expectedParenRecord', 'record', 'due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record'));
        } elseif ($request->child_type == 'Risk Assessment') {
            $old_record = RiskManagement::select('id', 'division_id', 'record')->get();

            return view('frontend.forms.risk-management', compact('old_record', 'due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record'));
        } elseif ($request->child_type == 'Internal Audit') {
            $old_record = InternalAudit::select('id', 'division_id', 'record')->get();

            return view('frontend.forms.audit', compact('old_record', 'due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record'));
        } elseif ($request->child_type == 'External Audit') {
            $old_record = InternalAudit::select('id', 'division_id', 'record')->get();

            return view('frontend.forms.auditee', compact('old_record', 'due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record'));
        } else {

            return view('frontend.forms.root-cause-analysis', compact('due_date', 'record_number', 'parent_id', 'parent_type', 'parent_record'));
        }
    }

    public static function ehsAuditReport($id)
    {
        $doc = EHSEvent::find($id);
        if (! empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = EHSEventAuditTrail::where('ehsEvent_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $data = $data->sortBy('created_at');
            $pdf = PDF::loadview('frontend.ehs-event.ehs_event_audit_report', compact('data', 'doc'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);

            return $pdf->stream('CAPA-Audit'.$id.'.pdf');
        }
    }

    public function ehsAuditTrail($id)
    {
        $audit = EHSEventAuditTrail::where('ehsEvent_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = EHSEvent::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = EHSEvent::find($id);

        return view('frontend.ehs-event.ehs_event_audit_trail', compact('audit', 'document', 'today', 'data'));
    }

    public static function ehsSingleReport($id)
    {
        $data = EHSEvent::find($id);

        if (! empty($data)) {
           

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.ehs-event.ehs_event_single_report', compact('data'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);

            return $pdf->stream('CAPA'.$id.'.pdf');
        }
    }

    public static function EHSActivityLog($id)
    {
        $data = EHSEvent::find($id);

        if (! empty($data)) {
           

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.ehs-event.ehs_activity_log', compact('data'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);

            return $pdf->stream('EHS&EnvironmentActivityLog'.$id.'.pdf');
        }
    }

    public function familyReport($id)
    {

       
        $data = EHSEvent::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            
            // $Extension = extension_new::where('parent_id', $id)->get();
            $CAPA =  Capa::where('parent_id', $id)->get();
            $Sanction =  Sanction::where('parent_id', $id)->get();
            $RCA = RootCauseAnalysis::where('parent_id', $id)->get();
            $ActionItem =  ActionItem::where('parent_id', $id)->get();

            $InternalAudit =  InternalAudit::where('parent_id', $id)->get();
            $ExternalAudit =  Auditee::where('parent_id', $id)->get();
            $RiskManagement =  RiskManagement::where('parent_id', $id)->get();

            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.ehs-event.ehs_event_family_report', compact(
                'data',
                // 'Extension',
                'RCA',
                'ActionItem',
                'CAPA',
                'InternalAudit',
                'ExternalAudit',
                'RiskManagement',
                'Sanction'
            ))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();

            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');

            $canvas->page_text(
                $width / 4,
                $height / 2,
                $data->status,
                null,
                25,
                [0, 0, 0],
                2,
                6,
                -20
            );



            return $pdf->stream('SOP' . $id . '.pdf');
        }
    }

    
    public function csvehs(Request $request)
    {
        $query = EHSEvent::query();
    
        // Apply filters similar to your other methods
        if ($request->department_changecontrol) {
            $query->where('Initiator_Group', $request->department_changecontrol);
        }
    
        if ($request->division_id_changecontrol) {
            $query->where('severity', $request->division_id_changecontrol);
        }
    
        if ($request->Clasichange) {
            $query->where('severity_level1', $request->Clasichange);
        }
    
        if ($request->RadioActivtiyTCC) {
            $query->where('doc_change', $request->RadioActivtiyTCC);
        }
    
        // Fetch the filtered data
        $cc_cft = $query->get();
    
        $fileName = 'ehs_log.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($cc_cft, $columns) {
            $file = fopen('php://output', 'w');
    
            fputcsv($file, $columns);
    
            if ($cc_cft->isEmpty()) {
                fputcsv($file, ['No records found']);
            } else {
                foreach ($cc_cft as $index => $row) {
                    $data = [
                        $index + 1, 
                        $row->intiation_date ?? 'Not Applicable', 
                        $row->division ? $row->division->name . '/Audit/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable',
                        $row->division ? $row->division->name : 'Not Applicable', 
                        $row->Initiator_Group ?? 'Not Applicable', 
                        $row->short_description ?? 'Not Applicable', 
                        $row->due_date ?? 'Not Applicable', 
                        $row->initiator ? $row->initiator->name : 'Not Applicable', 
                        $row->status ?? 'Not Applicable' 
                         
                    ];
    
                    fputcsv($file, $data);
                }
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }

    public function excelehs(Request $request)
    {
        $query = EHSEvent::query();
    
        if ($request->department_changecontrol) {
            $query->where('Initiator_Group', $request->department_changecontrol);
        }
    
        if ($request->division_id_changecontrol) {
            $query->where('severity', $request->division_id_changecontrol);
        }
    
        if ($request->Clasichange) {
            $query->where('severity_level1', $request->Clasichange);
        }
      if ($request->initiator_id_changecontrol) {
            $query->where('initiator_id', $request->initiator_id_changecontrol);
        }
    
        if ($request->RadioActivtiyTCC) {
            $query->where('doc_change', $request->RadioActivtiyTCC);
        }
    
        $cc_cft = $query->get();
    
        $fileName = "ehs_log.xls";
    
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($cc_cft, $columns) {
            echo '<table border="1">';
    
            echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
            foreach ($columns as $column) {
                echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
            }
            echo '</tr>';
    
            if ($cc_cft->isEmpty()) {
                echo '<tr>';
                echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                echo '</tr>';
            } else {
                foreach ($cc_cft as $index => $row) {
                    echo '<tr>';
                    echo "<td style='padding: 5px;'>" . ($index + 1) . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->intiation_date ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->division ? $row->division->name . '/CC/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars( $row->division ? $row->division->name : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->Initiator_Group ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->short_description ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->due_date ?? 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->initiator ? $row->initiator->name : 'Not Applicable') . "</td>";
                    echo "<td style='padding: 5px;'>" . htmlspecialchars($row->status ?? 'Not Applicable') . "</td>";
                  
                    echo '</tr>';
                }
            }
    
            echo '</table>';
        };
    
        return response()->stream($callback, 200, $headers);
    }
}
