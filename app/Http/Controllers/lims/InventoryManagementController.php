<?php

namespace App\Http\Controllers\lims;

use App\Http\Controllers\Controller;
use App\Models\InventoryManagement;
use App\Models\InventoryManagementAudit;
use App\Models\InventoryManagementGrid;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use PDF;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InventoryManagementController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
       return view('frontend.inventory-management.inventory_management', compact('record_number',) );
        
    }

    public function inventorymanagment_store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back()->withInput();
        }
        $equipment = new InventoryManagement();
        $equipment->form_type = "Inventory Management";
        $equipment->record = ((RecordNumber::first()->value('counter')) + 1);
        $equipment->initiator_id = Auth::user()->id;
        $equipment->division_id = $request->division_id;
        $equipment->division_code = $request->division_code;
        $equipment->intiation_date = $request->intiation_date;
        // $equipment->form_type = $request->form_type;
        $equipment->record_number = $request->record_number;
        $equipment->parent_id = $request->parent_id;
        $equipment->parent_type = $request->parent_type;
        $equipment->assign_to = $request->assign_to;
        $equipment->due_date = $request->due_date;
        $equipment->short_description = $request->short_description;
        $equipment->reagent_name = $request->reagent_name;
        $equipment->reagent_code = $request->reagent_code;
        $equipment->cas_number = $request->cas_number;
        $equipment->physical_form = $request->physical_form;
        $equipment->hazard_classification = $request->hazard_classification;
        $equipment->manufacturer_name = $request->manufacturer_name;
        $equipment->supplier_contact_info = $request->supplier_contact_info;
        // $equipment->certificate_of_analysis = $request->certificate_of_analysis;
        $equipment->supplier_lot_number = $request->supplier_lot_number;
        $equipment->usage_date = $request->usage_date;
        $equipment->geade_purity = $request->geade_purity;
        $equipment->status_gi = $request->status_gi;
        $equipment->purpose_of_use = $request->purpose_of_use;
        $equipment->quality_used = $request->quality_used;
        $equipment->logged_by = $request->logged_by;
        $equipment->storage_condition = $request->storage_condition;
        $equipment->container_type = $request->container_type;
        $equipment->shelf_life = $request->shelf_life;
        $equipment->supplier_name = $request->supplier_name;
        $equipment->handling_instructions = $request->handling_instructions;
        $equipment->risk_assesment_code = $request->risk_assesment_code;
        $equipment->disposal_guidelines = $request->disposal_guidelines;
        $equipment->regualatory_info = $request->regualatory_info;


        // $data = $request->validate([
        //     'batch_lot_number' => 'required|string|max:255',
        //     'storage_location' => 'required|string|max:255',
        //     'initial_quantity' => 'required|numeric',
        //     'used_quantity' => 'nullable|numeric',
        //     'reagent_expiry_date' => 'required|date',
        //     'reagent_opened_date' => 'nullable|date',
        //     'reagent_status' => 'required|in:Active,Expired,Quarantined',
        //     'transfer_to_another_location' => 'required|in:yes,no',
        //     'reason_for_stock_transfer' => 'nullable|string',
        //     'new_location' => 'nullable|string',
        //     'transfer_quantity' => 'nullable|numeric',
        //     'remaining_quantity' => 'required|numeric',
        //     'remarks' => 'nullable|string',
        // ]);

        // InventoryManagementGrid::create($data);

    
    
        $equipment->status = 'Opened';
        $equipment->stage = 1;
    
        if (!empty($request->certificate_of_analysis)) {
            $files = [];
            if ($request->hasfile('certificate_of_analysis')) {
                foreach ($request->file('certificate_of_analysis') as $file) {
                    $name = $request->name . '-certificate_of_analysis' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->certificate_of_analysis = json_encode($files);
        }

        if (!empty($request->safety_date_sheet)) {
            $files = [];
            if ($request->hasfile('safety_date_sheet')) {
                foreach ($request->file('safety_date_sheet') as $file) {
                    $name = $request->name . '-safety_date_sheet' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->safety_date_sheet = json_encode($files);
        }
        $equipment->save();

        $inventory_management_id = $equipment->id;

        $InventoryManagementGrid = InventoryManagementGrid::where(['inventory_management_id' => $inventory_management_id, 'identifier' => 'stoke'])->firstOrNew();
        $InventoryManagementGrid->inventory_management_id = $inventory_management_id;
        $InventoryManagementGrid->identifier = 'stoke';
        $InventoryManagementGrid->data = $request->stoke_info;
        // dd($InventoryManagementGrid);
        $InventoryManagementGrid->save();

        /////-----------------------audit trail--------------------
    
        if(!empty($request->record_number))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current =$request->record_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        
        if(!empty($request->division_id))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Site/Location Code';
            $history->previous = "Null";
            $history->current =Helpers::getDivisionName($request->division_id);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        if(!empty($request->initiator_id))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current =Helpers::getInitiatorName($request->initiator_id);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        if(!empty($request->intiation_date))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($request->intiation_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        
        if(!empty($request->assign_to))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Assigned to';
            $history->previous = "Null";
            $history->current = Helpers::getInitiatorName($request->assign_to);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        if(!empty($request->due_date))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = Helpers::getdateFormat($request->due_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        
        if(!empty($request->short_description))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current =$request->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->status_gi))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Status';
            $history->previous = "Null";
            $history->current =$request->status_gi;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->reagent_name))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Reagent/Item Name';
            $history->previous = "Null";
            $history->current =$request->reagent_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->reagent_code))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Reagent/Item Code/ID';
            $history->previous = "Null";
            $history->current = $request->reagent_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->cas_number))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'CAS Number';
            $history->previous = "Null";
            $history->current = $request->cas_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->geade_purity))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Grade/Purity';
            $history->previous = "Null";
            $history->current = $request->geade_purity;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->physical_form))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Physical Form';
            $history->previous = "Null";
            $history->current =$request->physical_form;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->hazard_classification))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Hazard Classification';
            $history->previous = "Null";
            $history->current =$request->hazard_classification;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->manufacturer_name))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Reason for Unscheduled or Event Based Preventive Maintenance';
            $history->previous = "Null";
            $history->current =$request->manufacturer_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->supplier_contact_info))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Event Reference No.';
            $history->previous = "Null";
            $history->current =$request->supplier_contact_info;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->supplier_lot_number))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Performed By';
            $history->previous = "Null";
            $history->current =$request->supplier_lot_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->supplier_name))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Supplier Name';
            $history->previous = "Null";
            $history->current =$request->supplier_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
        if(!empty($request->manufacturer_name))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Manufacturer Name';
            $history->previous = "Null";
            $history->current =$request->manufacturer_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->supplier_contact_info))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Supplier Contact Information';
            $history->previous = "Null";
            $history->current =$request->supplier_contact_info;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
        if(!empty($request->supplier_lot_number))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Supplier Lot Number';
            $history->previous = "Null";
            $history->current =$request->supplier_lot_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        // if(!empty($request->certificate_of_analysis))
        // {
        //     $history = new InventoryManagementAudit();
        //     $history->inventorymanagement_id = $equipment->id;
        //     $history->activity_type = 'Certificate of Analysis (CoA)';
        //     $history->previous = "Null";
        //     $history->current =$request->certificate_of_analysis;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $equipment->status;
        //     $history->change_to =   "Opened";
        //     $history->change_from = "Initiation";
        //     $history->action_name = 'Create';
         
        //     $history->save();
        // }
        if(!empty($request->shelf_life))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Shelf Life After Opening';
            $history->previous = "Null";
            $history->current =$request->shelf_life;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }


        if(!empty($request->usage_date))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Usage Date';
            $history->previous = "Null";
            $history->current =Helpers::getdateFormat($request->usage_date);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->purpose_of_use))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Purpose of Use';
            $history->previous = "Null";
            $history->current =$request->purpose_of_use;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->quality_used))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Quantity Used';
            $history->previous = "Null";
            $history->current =$request->quality_used;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->logged_by))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Logged By';
            $history->previous = "Null";
            $history->current =$request->logged_by;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->storage_condition))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Storage Conditions';
            $history->previous = "Null";
            $history->current =$request->storage_condition;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->container_type))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Container Type';
            $history->previous = "Null";
            $history->current =$request->container_type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->handling_instructions))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Handling Instructions';
            $history->previous = "Null";
            $history->current =$request->handling_instructions;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
    
        // if(!empty($request->safety_date_sheet))
        // {
        //     $history = new InventoryManagementAudit();
        //     $history->inventorymanagement_id = $equipment->id;
        //     $history->activity_type = 'Safety Data Sheet (SDS)';
        //     $history->previous = "Null";
        //     $history->current =$request->safety_date_sheet;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $equipment->status;
        //     $history->change_to =   "Opened";
        //     $history->change_from = "Initiation";
        //     $history->action_name = 'Create';
         
        //     $history->save();
        // }
        if(!empty($request->risk_assesment_code))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Risk Assessment Code';
            $history->previous = "Null";
            $history->current =$request->risk_assesment_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->disposal_guidelines))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Disposal Guidelines';
            $history->previous = "Null";
            $history->current =$request->disposal_guidelines;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }

        if(!empty($request->regualatory_info))
        {
            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $equipment->id;
            $history->activity_type = 'Regulatory Compliance Information';
            $history->previous = "Null";
            $history->current =$request->regualatory_info;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $equipment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
         
            $history->save();
        }
      
        ///-----------------------------------------------------------
    
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
    
        toastr()->success("Record is Create Successfully");
        return redirect(url('rcms/lims-dashboard'));
    }

    public function show($id)
    {      
        
        $data = InventoryManagement::find($id);
        $equipment  = InventoryManagement::find($id);
        $InventoryManagement_grid = InventoryManagementGrid::where(['inventory_management_id' => $equipment->id, 'identifier' => 'stoke'])->first();
        // $InventoryManagement_grid = InventoryManagementGrid::where(['inventory_management_id' => $equipment->id, 'identifier' => 'stoke'])->first();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $equipment->record = str_pad($equipment->record, 4, '0', STR_PAD_LEFT);
        $equipment->assign_to_name = User::where('id', $equipment->assign_id)->value('name');
        $equipment->initiator_name = User::where('id', $equipment->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
    
        return view('frontend.inventory-management.inventory_management_view', compact('data', 'equipment', 'record_number','InventoryManagement_grid'));
    }

    public function update(Request $request, $id)
    {

        $lastDocument = InventoryManagement::find($id);
        $equipment = InventoryManagement::find($id);

        $equipment->assign_to = $request->assign_to;
        // $equipment->due_date = $request->due_date;
        $equipment->short_description = $request->short_description;
        $equipment->reagent_name = $request->reagent_name;
        $equipment->reagent_code = $request->reagent_code;
        $equipment->cas_number = $request->cas_number;
        $equipment->physical_form = $request->physical_form;
        $equipment->hazard_classification = $request->hazard_classification;
        $equipment->manufacturer_name = $request->manufacturer_name;
        $equipment->supplier_contact_info = $request->supplier_contact_info;
        $equipment->supplier_lot_number = $request->supplier_lot_number;
        $equipment->certificate_of_analysis = $request->certificate_of_analysis;
        $equipment->usage_date = $request->usage_date;
        $equipment->geade_purity = $request->geade_purity;
        $equipment->status_gi = $request->status_gi;
        $equipment->purpose_of_use = $request->purpose_of_use;
        $equipment->quality_used = $request->quality_used;
        $equipment->logged_by = $request->logged_by;
        $equipment->supplier_name = $request->supplier_name;
        $equipment->storage_condition = $request->storage_condition;
        $equipment->container_type = $request->container_type;
        $equipment->handling_instructions = $request->handling_instructions;
        $equipment->risk_assesment_code = $request->risk_assesment_code;
        $equipment->disposal_guidelines = $request->disposal_guidelines;
        $equipment->regualatory_info = $request->regualatory_info;

        // $Grid = InventoryManagementGrid::find($id);

        // $data = $request->validate([
        //     'batch_lot_number' => 'required|string|max:255',
        //     'storage_location' => 'required|string|max:255',
        //     'initial_quantity' => 'required|numeric',
        //     'used_quantity' => 'nullable|numeric',
        //     'reagent_expiry_date' => 'required|date',
        //     'reagent_opened_date' => 'nullable|date',
        //     'reagent_status' => 'required|in:Active,Expired,Quarantined',
        //     'transfer_to_another_location' => 'required|in:yes,no',
        //     'reason_for_stock_transfer' => 'nullable|string',
        //     'new_location' => 'nullable|string',
        //     'transfer_quantity' => 'nullable|numeric',
        //     'remaining_quantity' => 'required|numeric',
        //     'remarks' => 'nullable|string',
        // ]);

        // $Grid->update($data);

        
        if (!empty($request->certificate_of_analysis)) {
            $files = [];
            if ($request->hasfile('certificate_of_analysis')) {
                foreach ($request->file('certificate_of_analysis') as $file) {
                    $name = $request->name . '-certificate_of_analysis' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->certificate_of_analysis = json_encode($files);
        }
        if (!empty($request->safety_date_sheet)) {
            $files = [];
            if ($request->hasfile('safety_date_sheet')) {
                foreach ($request->file('safety_date_sheet') as $file) {
                    $name = $request->name . '-safety_date_sheet' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $equipment->safety_date_sheet = json_encode($files);
        }
        $equipment->update();
        $inventory_management_id = $equipment->id;

        $InventoryManagementGrid = InventoryManagementGrid::where(['inventory_management_id' => $inventory_management_id, 'identifier' => 'stoke'])->firstOrNew();
        $InventoryManagementGrid->inventory_management_id = $inventory_management_id;
        $InventoryManagementGrid->identifier = 'stoke';
        $InventoryManagementGrid->data = $request->stoke_info;
        // dd($InventoryManagementGrid);
        $InventoryManagementGrid->save();

        if ($lastDocument->short_description != $equipment->short_description || !empty($request->status_gi_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Status';
            $history->previous = $lastDocument->short_description;
            $history->current = $equipment->short_description;
            $history->comment = $request->status_gi_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            if (is_null($lastDocument->short_description) || $lastDocument->short_description === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }        
            $history->save();
        }

        if ($lastDocument->status_gi != $equipment->status_gi || !empty($request->short_description_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->status_gi;
            $history->current = $equipment->status_gi;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->status_gi) || $lastDocument->status_gi === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->reagent_name != $equipment->reagent_name || !empty($request->reagent_name_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Reagent/Item Name';
            $history->previous = $lastDocument->reagent_name;
            $history->current = $equipment->reagent_name;
            $history->comment = $request->reagent_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->reagent_name) || $lastDocument->reagent_name === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->reagent_code != $equipment->reagent_code || !empty($request->reagent_code_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Reagent/Item Code/ID';
            $history->previous = $lastDocument->reagent_code;
            $history->current = $equipment->reagent_code;
            $history->comment = $request->reagent_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->reagent_code) || $lastDocument->reagent_code === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }
        if ($lastDocument->cas_number != $equipment->cas_number || !empty($request->cas_number_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'CAS Number';
            $history->previous = $lastDocument->cas_number;
            $history->current = $equipment->cas_number;
            $history->comment = $request->cas_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->cas_number) || $lastDocument->cas_number === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->geade_purity != $equipment->geade_purity || !empty($request->geade_purity_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Grade/Purity';
            $history->previous = $lastDocument->geade_purity;
            $history->current = $equipment->geade_purity;
            $history->comment = $request->geade_purity_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->initiator_group_code) || $lastDocument->initiator_group_code === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }
        if ($lastDocument->physical_form != $equipment->physical_form || !empty($request->physical_form_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Physical Form';
            $history->previous = $lastDocument->physical_form;
            $history->current = $equipment->physical_form;
            $history->comment = $request->physical_form_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->physical_form) || $lastDocument->physical_form === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->hazard_classification != $equipment->hazard_classification || !empty($request->hazard_classification_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Hazard Classification';
            $history->previous = $lastDocument->hazard_classification;
            $history->current = $equipment->hazard_classification;
            $history->comment = $request->hazard_classification_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->hazard_classification) || $lastDocument->hazard_classification === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->supplier_name != $equipment->supplier_name || !empty($request->supplier_name_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Supplier Name';
            $history->previous = $lastDocument->supplier_name;
            $history->current = $equipment->supplier_name;
            $history->comment = $request->supplier_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->supplier_name) || $lastDocument->supplier_name === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->manufacturer_name != $equipment->manufacturer_name || !empty($request->manufacturer_name_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Manufacturer Name';
            $history->previous = $lastDocument->manufacturer_name;
            $history->current = $equipment->manufacturer_name;
            $history->comment = $request->manufacturer_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->manufacturer_name) || $lastDocument->manufacturer_name === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }


        if ($lastDocument->supplier_contact_info != $equipment->supplier_contact_info || !empty($request->supplier_contact_info_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Supplier Contact Information';
            $history->previous = $lastDocument->supplier_contact_info;
            $history->current = $equipment->supplier_contact_info;
            $history->comment = $request->supplier_contact_info_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->supplier_contact_info) || $lastDocument->supplier_contact_info === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->supplier_lot_number != $equipment->supplier_lot_number || !empty($request->supplier_lot_number_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Supplier Lot Number';
            $history->previous = $lastDocument->supplier_lot_number;
            $history->current = $equipment->supplier_lot_number;
            $history->comment = $request->supplier_lot_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->supplier_lot_number) || $lastDocument->supplier_lot_number === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        // if ($lastDocument->certificate_of_analysis != $equipment->certificate_of_analysis || !empty($request->certificate_of_analysis_comment)) {

        //     $history = new InventoryManagementAudit();
        //     $history->inventorymanagement_id = $id;
        //     $history->activity_type = 'Certificate of Analysis (CoA)';
        //     $history->previous = $lastDocument->certificate_of_analysis;
        //     $history->current = $equipment->certificate_of_analysis;
        //     $history->comment = $request->certificate_of_analysis_comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastDocument->status;
        //      if (is_null($lastDocument->certificate_of_analysis) || $lastDocument->certificate_of_analysis === '') {
        //         $history->action_name = "New";
        //     } else {
        //         $history->action_name = "Update";
        //     }
        
        //     $history->save();
        // }


        if ($lastDocument->shelf_life != $equipment->shelf_life || !empty($request->shelf_life_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Shelf Life After Opening';
            $history->previous = $lastDocument->shelf_life;
            $history->current = $equipment->shelf_life;
            $history->comment = $request->shelf_life_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->shelf_life) || $lastDocument->shelf_life === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->usage_date != $equipment->usage_date || !empty($request->usage_date_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Usage Date';
            $history->previous = Helpers::getdateFormat($lastDocument->usage_date);
            $history->current = Helpers::getdateFormat($equipment->usage_date);
            $history->comment = $request->usage_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->usage_date) || $lastDocument->usage_date === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->purpose_of_use != $equipment->purpose_of_use || !empty($request->purpose_of_use_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Purpose of Use';
            $history->previous = $lastDocument->purpose_of_use;
            $history->current = $equipment->purpose_of_use;
            $history->comment = $request->purpose_of_use_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->purpose_of_use) || $lastDocument->purpose_of_use === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->quality_used != $equipment->quality_used || !empty($request->quality_used_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Quantity Used';
            $history->previous = $lastDocument->quality_used;
            $history->current = $equipment->quality_used;
            $history->comment = $request->quality_used_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->quality_used) || $lastDocument->quality_used === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        

        if ($lastDocument->logged_by != $equipment->logged_by || !empty($request->logged_by_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Logged By';
            $history->previous = $lastDocument->logged_by;
            $history->current = $equipment->logged_by;
            $history->comment = $request->logged_by_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->logged_by) || $lastDocument->logged_by === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->storage_condition != $equipment->storage_condition || !empty($request->storage_condition_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Storage Conditions';
            $history->previous = $lastDocument->storage_condition;
            $history->current = $equipment->storage_condition;
            $history->comment = $request->storage_condition_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->storage_condition) || $lastDocument->storage_condition === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }
        if ($lastDocument->container_type != $equipment->container_type || !empty($request->container_type_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Container Type';
            $history->previous = $lastDocument->container_type;
            $history->current = $equipment->container_type;
            $history->comment = $request->container_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->container_type) || $lastDocument->container_type === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->handling_instructions != $equipment->handling_instructions || !empty($request->handling_instructions_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Handling Instructions';
            $history->previous = $lastDocument->handling_instructions;
            $history->current = $equipment->handling_instructions;
            $history->comment = $request->handling_instructions_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->handling_instructions) || $lastDocument->handling_instructions === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->risk_assesment_code != $equipment->risk_assesment_code || !empty($request->risk_assesment_code_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Risk Assessment Code';
            $history->previous = $lastDocument->risk_assesment_code;
            $history->current = $equipment->risk_assesment_code;
            $history->comment = $request->risk_assesment_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->risk_assesment_code) || $lastDocument->risk_assesment_code === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->disposal_guidelines != $equipment->disposal_guidelines || !empty($request->disposal_guidelines_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Disposal Guidelines';
            $history->previous = $lastDocument->disposal_guidelines;
            $history->current = $equipment->disposal_guidelines;
            $history->comment = $request->disposal_guidelines_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->disposal_guidelines) || $lastDocument->disposal_guidelines === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        if ($lastDocument->regualatory_info != $equipment->regualatory_info || !empty($request->regualatory_info_comment)) {

            $history = new InventoryManagementAudit();
            $history->inventorymanagement_id = $id;
            $history->activity_type = 'Regulatory Compliance Information';
            $history->previous = $lastDocument->regualatory_info;
            $history->current = $equipment->regualatory_info;
            $history->comment = $request->regualatory_info_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
             if (is_null($lastDocument->regualatory_info) || $lastDocument->regualatory_info === '') {
                $history->action_name = "New";
            } else {
                $history->action_name = "Update";
            }
        
            $history->save();
        }

        toastr()->success("Record is Update Successfully");
        return back(); 
    }

    public function InventoryStateChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = InventoryManagement::find($id);
            $lastDocument =  InventoryManagement::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = 'Pending Review';
                $equipment->submit_by = Auth::user()->name;
                $equipment->submit_on = Carbon::now()->format('d-M-Y');
                $equipment->submit_comments = $request->comment;

                $history = new InventoryManagementAudit();
                $history->inventorymanagement_id = $id;
                $history->activity_type = 'Submit By ,Submit On';
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->submit_by . ' , ' . $lastDocument->submit_on;
                }
                $history->current = $equipment->submit_by . ' , ' . $equipment->submit_on;
                if (is_null($lastDocument->submit_by) || $lastDocument->submit_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;  
                $history->action = 'submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending Review";
                $history->change_from = $lastDocument->status;
             
                $history->save();
                
                // $history->stage = 'Supervisor Review';
                // if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->submit_by . ' , ' . $lastDocument->submit_on;
                // }
                // $history->current = $root->submit_by . ' , ' . $root->submit_on;
                // if (is_null($lastDocument->submit_by) || $lastDocument->submit_by === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                // $history->save();
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 2) {
                $equipment->stage = "3";
                $equipment->status = 'Pending Approval';
                $equipment->Review_Complete_by  = Auth::user()->name;
                $equipment->Review_Complete_on = Carbon::now()->format('d-M-Y');
                $equipment->Review_Complete_comment = $request->comment;

                $history = new InventoryManagementAudit();
                $history->inventorymanagement_id = $id;
                $history->activity_type = 'Review Complete By ,Review Complete On';
                if (is_null($lastDocument->Review_Complete_by) || $lastDocument->Review_Complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Review_Complete_by . ' , ' . $lastDocument->Review_Complete_on;
                }
                $history->current = $equipment->Review_Complete_by . ' , ' . $equipment->Review_Complete_on;
                if (is_null($lastDocument->Review_Complete_by) || $lastDocument->Review_Complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;  
                $history->action = 'Review Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending Approval";
                $history->change_from = $lastDocument->status;
             
                $history->save();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 3) {
                $equipment->stage = "5";
                $equipment->status = 'Stock Transferring';
                $equipment->Approval_Complete_by  = Auth::user()->name;
                $equipment->Approval_Complete_on = Carbon::now()->format('d-M-Y');
                $equipment->Approval_Complete_comment = $request->comment;

                $history = new InventoryManagementAudit();
                $history->inventorymanagement_id = $id;
                $history->activity_type = 'Approval Complete By ,Approval Complete On';
                if (is_null($lastDocument->Approval_Complete_by) || $lastDocument->Approval_Complete_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Approval_Complete_by . ' , ' . $lastDocument->Approval_Complete_on;
                }
                $history->current = $equipment->Approval_Complete_by . ' , ' . $equipment->Approval_Complete_on;
                if (is_null($lastDocument->Approval_Complete_by) || $lastDocument->Approval_Complete_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;  
                $history->action = 'Approval Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Stock Transferring";
                $history->change_from = $lastDocument->status;
             
                $history->save();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 5) {
                $equipment->stage = "4";
                $equipment->status = 'Stock Transferring';
                $equipment->stock_transfer_by  = Auth::user()->name;
                $equipment->stock_transfer_on = Carbon::now()->format('d-M-Y');
                $equipment->stock_transfer_comment = $request->comment;

                $history = new InventoryManagementAudit();
                $history->inventorymanagement_id = $id;
                $history->activity_type = 'Stock Transfer By ,Stock Transfer On';
                if (is_null($lastDocument->stock_transfer_by) || $lastDocument->stock_transfer_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->stock_transfer_by . ' , ' . $lastDocument->stock_transfer_on;
                }
                $history->current = $equipment->stock_transfer_by . ' , ' . $equipment->stock_transfer_on;
                if (is_null($lastDocument->stock_transfer_by) || $lastDocument->stock_transfer_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->previous ="";
                $history->current = $equipment->submit_by;
                $history->comment = $request->comment;  
                $history->action = 'Stock Transfer';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Stock Transferring";
                $history->change_from = $lastDocument->status;
             
                $history->save();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 4) {
                $equipment->stage = "5";
                $equipment->status = 'Closed - Done';
                $equipment->stock_transfer1_by  = Auth::user()->name;
                $equipment->stock_transfer1_on = Carbon::now()->format('d-M-Y');
                $equipment->stock_transfer1_comment = $request->comment;

                $history = new InventoryManagementAudit();
                $history->inventorymanagement_id = $id;
                $history->activity_type = 'Complete Transferring By ,Complete Transferring On';
                if (is_null($lastDocument->stock_transfer1_by) || $lastDocument->stock_transfer1_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->stock_transfer1_by . ' , ' . $lastDocument->stock_transfer1_on;
                }
                $history->current = $equipment->stock_transfer1_by . ' , ' . $equipment->stock_transfer1_on;
                if (is_null($lastDocument->stock_transfer1_by) || $lastDocument->stock_transfer1_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->previous ="";
                $history->current = $equipment->submit_by;
                $history->comment = $request->comment;  
                $history->action = 'Complete Transferring';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Done";
                $history->change_from = $lastDocument->status;
             
                $history->save();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function InventoryCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = InventoryManagement::find($id);
            $lastDocument = InventoryManagement::find($id);
            

            if ($equipment->stage == 1) {
                $equipment->stage = "0";
                $equipment->status = "Closed - Cancelled";
                $equipment->Cancel_By = Auth::user()->name;
                $equipment->Cancel_On = Carbon::now()->format('d-M-Y');
                $equipment->Cancel_Comment = $request->comment;

                $history = new InventoryManagementAudit();
                $history->inventorymanagement_id = $id;
                $history->activity_type = 'Cancel By ,Cancel On';
                if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Cancel_By . ' , ' . $lastDocument->Cancel_On;
                }
                $history->current = $equipment->Cancel_By . ' , ' . $equipment->Cancel_On;
                if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_On === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = $request->comment;  
                $history->action = 'Cancel';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
             
                $history->save();
                // $history = new PreventiveMaintenanceAudit();
                // $history->sanction_id = $id;
                // $history->activity_type = 'Cancel By,Cancel On';
                // $history->action = 'Cancel';
                // // $history->previous = "";
                // // $history->current = $SanctionControl->Cancel_By;
                // $history->comment = $request->comment;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                // $history->origin_state =  $SanctionControl->status;
                // $history->change_to = "Closed";
                // $history->change_from = $lastDocument->status;
                // $history->stage = 'Closed';
                // if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                //     $history->previous = "";
                // } else {
                //     $history->previous = $lastDocument->Cancel_By . ' , ' . $lastDocument->Cancel_On;
                // }
                // $history->current = $SanctionControl->Cancel_By . ' , ' . $SanctionControl->Cancel_On;
                // if (is_null($lastDocument->Cancel_By) || $lastDocument->Cancel_By === '') {
                //     $history->action_name = 'New';
                // } else {
                //     $history->action_name = 'Update';
                // }
                // $history->save();
                // $SanctionControl->update();
                // $history = new EHSEventHistory();
                // $history->type = "Sanction";
                // $history->doc_id = $id;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->stage_id = $SanctionControl->stage;
                // $history->status = $SanctionControl->status;
                // $history->save();

                // $list = Helpers::getInitiatorUserList();
                // foreach ($list as $u) {
                //     if($u->q_m_s_divisions_id == $SanctionControl->division_id){
                //       $email = Helpers::getInitiatorEmail($u->user_id);
                //       if ($email !== null) {

                //         Mail::send(
                //             'mail.view-mail',
                //             ['data' => $SanctionControl],
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

    public function MoreInfoInventory(Request $request, $id)
    {
        if ($request->username == Auth::user()->Username && Hash::check($request->password, Auth::user()->password)) {
            $equipment = InventoryManagement::find($id);
            $lastDocument =  InventoryManagement::find($id);


            if ($equipment->stage == 2) {
                $equipment->stage = "1";
                $equipment->status = "Opened";

                $equipment->Request_More_Info_by = Auth::user()->name;
                $equipment->Request_More_Info_on = Carbon::now()->format('d-M-Y');
                $equipment->Request_More_Info_comment = $request->comment;
                $history = new InventoryManagementAudit();
                $history->inventorymanagement_id = $id;
                $history->activity_type = 'Request More Info By ,Request More Info On';
                if (is_null($lastDocument->Request_More_Info_by) || $lastDocument->Request_More_Info_by === '') {
                    $history->previous = "NULL";
                } else {
                    $history->previous = $lastDocument->Request_More_Info_by . ' , ' . $lastDocument->Request_More_Info_on;
                }
                $history->current = $equipment->Request_More_Info_by . ' , ' . $equipment->Request_More_Info_on;
                if (is_null($lastDocument->Request_More_Info_by) || $lastDocument->Request_More_Info_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
               
                $history->comment = $request->comment;  
                $history->action = 'Request More Info';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending Review";
                $history->change_from = $lastDocument->status;
             
                $history->save();
                $equipment->update();


                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function PrevantiveAuditTrail($id)
    {
        $audit = InventoryManagementAudit::where('inventorymanagement_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = InventoryManagement::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = InventoryManagement::find($id);

        return view('frontend.inventory-management.inventory_management_audit', compact('audit', 'document', 'today', 'data'));
    }
    public function InventoryAuditTrail($id)
    {
        $audit = InventoryManagementAudit::where('inventorymanagement_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = InventoryManagement::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        $data = InventoryManagement::find($id);

        return view('frontend.inventory-management.inventory_management_audit', compact('audit', 'document', 'today', 'data'));
    }

       public function inventoryChild(Request $request, $id)
    {
        $equipment = InventoryManagement::find($id);
        $parent_id = $id;
        $parent_name = "Inventory Management";
        $parent_type = "Inventory Management";
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');

        $parent_data = InventoryManagement::where('id', $id)->select('record', 'division_id', 'initiator_id', 'short_description')->first();
        $parent_data1 = InventoryManagement::select('record', 'division_id', 'initiator_id', 'id')->get();
        $parent_record = InventoryManagement::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = InventoryManagement::where('id', $id)->value('division_id');
        $parent_initiator_id = InventoryManagement::where('id', $id)->value('initiator_id');
        $parent_intiation_date = InventoryManagement::where('id', $id)->value('intiation_date');
        $parent_short_description = InventoryManagement::where('id', $id)->value('short_description');
        $old_record = InventoryManagement::select('id', 'division_id', 'record')->get();
        
        if ($request->revision == "action-item") {
            $record = ((RecordNumber::first()->value('counter')) + 1);
            $record = str_pad($record, 4, '0', STR_PAD_LEFT);
            $equipment->originator = User::where('id', $equipment->initiator_id)->value('name');
            return view('frontend.action-item.action-item', compact('parent_record','record','parent_id', 'parent_name', 'record_number', 'equipment', 'parent_data', 'parent_data1', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id', 'due_date', 'old_record', 'parent_type'));
        }
        
        else{
            toastr()->warning('Not Working');
            return back();
        }
    }

    public static function inventory_singlereport($id)
    {
        $data = InventoryManagement::find($id);
        $equipment = InventoryManagementGrid::find($id);
        if (!empty($data)) {
            
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $InventoryManagement_grid = InventoryManagementGrid::where(['inventory_management_id' => $equipment->id, 'identifier' => 'stoke'])->first();
            $pdf = PDF::loadview('frontend.inventory-management.inventorymanagementSinglereport', compact('data','InventoryManagement_grid'))
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
            return $pdf->stream('CAPA' . $id . '.pdf');
        }


    }
    public static function inventory_auditreport($id)
    {
        $doc = InventoryManagement::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = InventoryManagementAudit::where('inventorymanagement_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.inventory-management.audit_report', compact('data', 'doc'))
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
            return $pdf->stream('CAPA-Audit' . $id . '.pdf');
        }
    }




    public function exportCsv(Request $request)
    {
        $query = InventoryManagement::query();
    
        $query = InventoryManagement::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_inventorymanagement)) {
            $query->whereIn('Initiator_Group', $request->department_inventorymanagement);  // Use whereIn for multiple selections
        }

        if ($request->division_id_inventorymanagement) {
            $query->where('division_id', $request->division_id_inventorymanagement);
        }

        if ($request->initiator_id_inventorymanagement) {
            $query->where('initiator_id', $request->initiator_id_inventorymanagement);
        }

        if ($request->date_frominventorymanagement) {
            $dateFrom = Carbon::parse($request->date_frominventorymanagement)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_toinventorymanagement) {
            $dateTo = Carbon::parse($request->date_toinventorymanagement)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $inventorymanagement = $query->get();

        $fileName = 'inventory_management_log.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($inventorymanagement, $columns) {
            $file = fopen('php://output', 'w');
    
            fputcsv($file, $columns);
    
            if ($inventorymanagement->isEmpty()) {
                fputcsv($file, ['No records found']);
            } else {
                foreach ($inventorymanagement as $index => $row) {
                    $data = [
                        $index + 1, 
                        $row->intiation_date ?? 'Not Applicable', 
                        $row->division ? $row->division->name . '/CC/' . date('Y') . '/' . str_pad($row->record, 4, '0', STR_PAD_LEFT) : 'Not Applicable',
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
    
    


    public function exportExcel(Request $request)
    {
        $query = InventoryManagement::query();
    
        $query = InventoryManagement::query();

        // Handle department filter when multiple departments are selected
        if (!empty($request->department_inventorymanagement)) {
            $query->whereIn('Initiator_Group', $request->department_inventorymanagement);  // Use whereIn for multiple selections
        }

        if ($request->division_id_inventorymanagement) {
            $query->where('division_id', $request->division_id_inventorymanagement);
        }

        if ($request->initiator_id_inventorymanagement) {
            $query->where('initiator_id', $request->initiator_id_inventorymanagement);
        }

        if ($request->date_frominventorymanagement) {
            $dateFrom = Carbon::parse($request->date_frominventorymanagement)->startOfDay();
            $query->whereDate('intiation_date', '>=', $dateFrom);
        }

        if ($request->date_toinventorymanagement) {
            $dateTo = Carbon::parse($request->date_toinventorymanagement)->endOfDay();
            $query->whereDate('intiation_date', '<=', $dateTo);
        }

        
        if ($request->sort_column && $request->sort_order) {
            $query->orderBy($request->sort_column, $request->sort_order);
        }

        $inventorymanagement = $query->get();
    
        $fileName = "inventory_management_log.xls";
    
        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ];
    
        $columns = [
            'Sr. No.', 'Initiation Date', 'Record No',
            'Division', 'Department Name', 'Short Description.', 'Due Date',
            'Initiator', 'Status'
        ];
    
        $callback = function () use ($inventorymanagement, $columns) {
            echo '<table border="1">';
    
            echo '<tr style="font-weight: bold; background-color: #1F4E79; color: #FFFFFF;">';
            foreach ($columns as $column) {
                echo "<th style='padding: 5px;'>" . htmlspecialchars($column) . "</th>";
            }
            echo '</tr>';
    
            if ($inventorymanagement->isEmpty()) {
                echo '<tr>';
                echo "<td colspan='" . count($columns) . "' style='text-align: center;'>No records found</td>";
                echo '</tr>';
            } else {
                foreach ($inventorymanagement as $index => $row) {
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
