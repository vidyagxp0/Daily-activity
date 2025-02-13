<?php

namespace Database\Seeders;

use App\Models\RoleGroup;
use App\Models\QMSDivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            'IND',
            'Asia',
            'Africa',
            'Antractica',
            'Australia',
            'North America',
            'South America',
            'Europe',
        ];

        $processes_roles = [
            'Deviation' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'External User', 'QA', 'View Only', 'FP', 'Closed Record'],
            'Change Control' => ['Initiator', 'HOD/Designee', 'QA', 'CQA', 'CFT', 'Head QA', 'Head QA/Designee', 'External User', 'View Only', 'FP', 'Closed Record'],
            'CAPA' => ['Initiator', 'HOD/Designee', 'CQA Reviewer', 'QA Approver', 'CQA Approver', 'QA', 'CQA Head', 'Head QA', 'QA Head/Designee', 'View Only', 'FP', 'Closed Record'],
            'Action Item' => ['Initiator', 'Action Owner', 'QA', 'CQA', 'View Only', 'FP', 'Closed Record'],
            'Root Cause Analysis' => ['Initiator', 'HOD/Designee', 'QA', 'CQA', 'View Only', 'FP', 'Closed Record'],
            'Risk Assessment' => ['Initiator', 'HOD/Designee', 'Work Group (Risk Management Head)', 'HOD/Designee', 'QA', 'View Only', 'FP', 'Closed Record'],
            'Effectiveness Check' => ['Initiator', 'Supervisor', 'QA', 'HOD/Designee', 'CQA', 'View Only', 'FP', 'Closed Record'],
            'Due Date Extension' => ['Initiator', 'Head QA/Designee', 'QA Approver', 'CQA Approver', 'View Only', 'FP', 'Closed Record', 'HOD/Designee'],
            'Incident' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP', 'Closed Record'],
            'Lab Incident' => ['Initiator', 'HOD/Supervisor/Designee', 'Head QA', 'Initiator', 'Head QA', 'View Only', 'FP', 'Closed Record'],
            'OOS/OOT' => ['Initiator','HOD/Designee', 'Lab Supervisor', 'QC Head/Designee', 'QA', 'Production','Production Head', 'Head QA/Designee', 'View Only', 'FP', 'Closed Record'],
            'External Audit' => ['Initiator', 'Audit Manager', 'Lead Auditor', 'Lead Auditee', 'View Only', 'FP', 'Closed Record'],
            'Internal Audit' => ['Initiator', 'Audit Manager', 'Lead Auditor', 'Lead Auditee', 'View Only', 'FP', 'Closed Record'],
            'Complaint Management' => ['Initiator', 'Supervisor', 'QA', 'Responsible Person', 'Supervisor', 'QA Head/Designee', 'Initiator', 'View Only', 'FP', 'Closed Record'],
            'Global Change Control' => ['Initiator', 'HOD/Designee', 'QA', 'CQA', 'CFT', 'Head QA', 'Head QA/Designee', 'View Only', 'FP', 'Closed Record'],
            'Global CAPA' => ['Initiator', 'HOD/Designee', 'CQA Reviewer', 'QA Approver', 'CQA Approver', 'QA', 'CQA Head', 'Head QA', 'QA Head/Designee', 'View Only', 'FP', 'Closed Record'],
            "Equipment/Instrument Lifecycle Management" => ['Initiator', 'Supervisor', 'Qualification', 'Training Coordinator', 'QA', 'View Only', 'FP', 'Closed Record'],
            "Calibration Management" => ['Initiator', 'Implementor', 'Qualification', 'Training Coordinator', 'QA', 'View Only', 'FP', 'Closed Record'],
            'Supplier' => ['Purchase Department','Initiator','CQA','F&D/MS&T', 'View Only', 'FP'],
            'Supplier Audit' => ['Audit Manager', 'Supplier Auditor', 'Auditee', 'View Only', 'FP'],
            'Preventive Maintenance' => ['Initiator', 'Supervisor', 'Implementor','QA', 'View Only', 'FP'],
            'ERRATA' => ['Initiator', 'QA Reviewer', 'Initiator', 'Supervisor', 'HOD/Designee', 'QA Head/Designee', 'View Only', 'FP', 'Closed Record'],
            'New Document' => ['Initiator', 'Author', 'HOD/Designee', 'QA','Approver', 'Reviewer', 'View Only', 'FP', 'Trainer', 'Closed Record'],            
            'Audit Program' => ['Initiator', 'Audit Manager', 'View Only', 'FP', 'Closed Record'],
            'Task Management' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'External User', 'QA', 'View Only', 'FP', 'Closed Record'],
            
        ];

        $start_from_id = 1; // Initialize your starting ID

        foreach ($sites as $site) {
            foreach ($processes_roles as $process => $roles) {
                foreach ($roles as $role) {
                    $group = new RoleGroup();
                    $group->id = $start_from_id;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                    $start_from_id++;
                }
            }
        }

        $cft_roles = [
            "Production",
            "Warehouse",
            "Quality Control",
            "Quality Assurance",
            "Engineering",
            "Analytical Development Laboratory",
            "Process Development Laboratory / Kilo Lab",
            "Technology Transfer / Design",
            "Environment, Health & Safety",
            "Human Resource & Administration",
            "Information Technology",
            "Project Management"
        ];

        $processes = [
            'Change Control',
            'Deviation',
            'Query Management',
            // 'Non Conformance',
            'Incident',
        ];

        $incrementCount = $start_from_id;

        foreach ($processes as $process) {
            foreach ($sites as $site) {
                foreach ($cft_roles as $role) {
                    $group = new RoleGroup();
                    $group->id = $incrementCount++;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                }
            }
        }

        //failure
        $cft_roles1 = [
            "RA Review",
            "Production Tablet",
            "Production Liquid",
            "Production Injection",
            "Stores",
            "Research & Development",
            "Microbiology",
            "Regulatory Affair",
            "Corporate Quality Assurance",
            "Safety",
            "Contract Giver",
            "Quality Control",
            "Quality Assurance",
            "Engineering",
            "Human Resource & Administration",
            "Information Technology",
        ];

        $processes2 = [
            'Change Control',
            'Query Management',
            'Incident'
        ];

        $incrementCount1 = $incrementCount;

        foreach ($processes2 as $process) 
        {
            foreach ($sites as $site) {
                foreach ($cft_roles1 as $role) {
                    $group = new RoleGroup();
                    $group->id = $incrementCount1++;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                }
            }
        }

        $additonal_processes = [
            'Sanction' => ['Initiator', 'Safety Officer', 'View Only', 'FP', 'Closed Record'],
            'EHS & Environment Sustainability' => ['Initiator', 'Line Manager', 'Lead Investigator', 'Safety Officer', 'View Only', 'FP', 'Closed Record'],
            'Meeting' => ['Initiator', 'HOD/Designee', 'Approver', 'Reviewer', 'Drafter', 'View Only', 'FP'],
            'Sample Management I' => ['Initiator', 'Lab Technician','Supervisor', 'QA', 'View Only', 'FP', 'Closed Record'],
            'Control Sample' => ['Initiator', 'Reviewer','Responsible Person', 'View Only', 'FP', 'Closed Record'],
            'Stability Management' => ['Initiator', 'Lab Technician','Supervisor', 'QA', 'View Only', 'FP', 'Closed Record'],
            'Analyst Qualification' => ['Initiator', 'Supervisor', 'View Only', 'FP', 'Closed Record'],
            'Inventory Management' => ['Initiator', 'Audit Manager', 'View Only', 'FP', 'Closed Record'],
            'Sample Management II' => ['Initiator', 'Lab Technician','Supervisor', 'QA', 'View Only', 'FP', 'Closed Record'],
        ];

        $incrementCount2 = $incrementCount1;
        foreach ($sites as $site) {
            foreach ($additonal_processes as $process => $roles) {
                foreach ($roles as $role) {
                    $group = new RoleGroup();
                    $group->id = $incrementCount2;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                    $incrementCount2++;
                }
            }
        }
    }
}
