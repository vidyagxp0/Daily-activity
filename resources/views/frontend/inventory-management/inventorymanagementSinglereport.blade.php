<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VidyaGxP - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
    }

    .w-25 {
        width: 25%;
    }

    .w-30 {
        width: 30%;
    }

    .w-40 {
        width: 40%;
    }

    .w-50 {
        width: 50%;
    }

    .w-60 {
        width: 60%;
    }

    .w-70 {
        width: 70%;
    }

    .w-80 {
        width: 80%;
    }

    .w-90 {
        width: 90%;
    }

    .w-100 {
        width: 100%;
    }

    .h-100 {
        height: 100%;
    }

    header table,
    header th,
    header td,
    footer table,
    footer th,
    footer td,
    .border-table table,
    .border-table th,
    .border-table td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    table {
        width: 100%;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    footer .head,
    header .head {
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    @page {
        size: A4;
        margin-top: 160px;
        margin-bottom: 60px;
    }

    header {
        position: fixed;
        top: -140px;
        left: 0;
        width: 100%;
        display: block;
    }

    footer {
        width: 100%;
        position: fixed;
        display: block;
        bottom: -40px;
        left: 0;
        font-size: 0.9rem;
    }

    footer td {
        text-align: center;
    }

    .inner-block {
        padding: 10px;
    }

    .inner-block tr {
        font-size: 0.8rem;
    }

    .inner-block .block {
        margin-bottom: 30px;
    }

    .inner-block .block-head {
        font-weight: bold;
        font-size: 1.1rem;
        padding-bottom: 5px;
        border-bottom: 2px solid #4274da;
        margin-bottom: 10px;
        color: #4274da;
    }

    .inner-block th,
    .inner-block td {
        vertical-align: baseline;
    }

    .table_bg {
        background: #4274da57;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Inventory Management Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://navin.mydemosoftware.com/public/user/images/logo.png" alt=""
                            class="w-60">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong> Inventory Management No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/IM/20{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>
    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
                {{-- <td class="w-30">
                    <strong>Page :</strong> 
                </td> --}}
            </tr>
        </table>
    </footer>
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30"> {{ Helpers::getDivisionName($data->division_id) }}</td>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ $data->created_at ? $data->created_at->format('d-m-Y') : '' }} </td>

                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                            {{ \Carbon\Carbon::parse($data->due_date)->format('d-m-Y') }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Assigned to</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{ $data->assign_to}}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Short Description</th>
                        <td class="w-30">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        {{-- <th class="w-20">Department Code</th> --}}
                        {{-- <td class="w-30">@if ($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td> --}}
                    </tr>
                   
                    <tr>
                        <th class="w-20"> Reagent/Item Name</th>
                        <td class="w-30">
                            @if ($data->reagent_name)
                            {{ $data->reagent_name}}
                        @else
                            Not Applicable
                        @endif
                        </td>
                        <th class="w-20"> Reagent/Item Code/ID</th>
                        <td class="w-30">
                            @if ($data->reagent_code)
                                {{ $data->reagent_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20"> CAS Number</th>
                        <td class="w-30"> @if ($data->cas_number)
                            {{ $data->cas_number }}
                        @else
                            Not Applicable
                        @endif</td>

                        <th class="w-20"> Grade/Purity</th>
                        <td class="w-30"> @if ($data->geade_purity)
                            {{ $data->geade_purity }}
                        @else
                            Not Applicable
                        @endif</td>
                       
                    </tr>
                    <tr>
                        <th class="w-20"> Physical Form</th>
                        <td class="w-30"> @if ($data->physical_form)
                            {{ $data->physical_form }}
                        @else
                            Not Applicable
                        @endif</td>

                        <th class="w-20"> Hazard Classification</th>
                        <td class="w-30"> @if ($data->hazard_classification)
                            {{ $data->hazard_classification }}
                        @else
                            Not Applicable
                        @endif</td>
                       
                    </tr>


                   


                    {{-- <tr> --}}
                    {{-- <th class="w-20">Name of Product & Batch No</th> --}}
                    {{-- <td class="w-30">@if ($data->Product_Batch){{ ($data->Product_Batch) }} @else Not Applicable @endif</td> --}}
                    {{-- </tr> --}}
                 

                </table>
               
                
                
                

                {{-- <div class="border-table">
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <tr>
                                    <th><div style="width: 30px;">Sr No.</div></th>
                                    <th><div style="width: 100px;">Batch/Lot Number</div></th>
                                    <th><div style="width: 100px;">Storage Location</div></th>
                                    <th><div style="width: 100px;">Storage Conditions</div></th>
                                </tr>
                                <tr>
                                    <th><div style="width: 100px;">Container Type</div></th>
                                    <th><div style="width: 100px;">Shelf Life After Opening</div></th>
                                    <th><div style="width: 100px;">Handling Instructions</div></th>
                                    <th><div style="width: 100px;">Supplier Name</div></th>
                                </tr>
                                <tr>
                                    <th><div style="width: 100px;">Manufacturer Name</div></th>
                                    <th><div style="width: 100px;">Supplier Contact Information</div></th>
                                    <th><div style="width: 100px;">Supplier Lot/AR Number</div></th>
                                    <th><div style="width: 100px;">Initial Quantity</div></th>
                                </tr>
                                <tr>
                                    <th><div style="width: 100px;">Unit</div></th>
                                    <th><div style="width: 100px;">Reagent/Item Name</div></th>
                                    <th><div style="width: 100px;">Used Quantity</div></th>
                                    <th><div style="width: 100px;">Reagent/Item Expiry Date</div></th>
                                </tr>
                                <tr>
                                    <th><div style="width: 100px;">Reagent/Item Opened Date</div></th>
                                    <th><div style="width: 100px;">Reagent/Item Status</div></th>
                                    <th><div style="width: 100px;">CAS Number</div></th>
                                    <th><div style="width: 100px;">Transfer to Another Location?</div></th>
                                </tr>
                                <tr>
                                    <th><div style="width: 100px;">Reason for Stock Transfer</div></th>
                                    <th><div style="width: 100px;">New Location</div></th>
                                    <th><div style="width: 100px;">Transfer Quantity</div></th>
                                    <th><div style="width: 100px;">Remaining Quantity</div></th>
                                </tr>
                                <tr>
                                    <th><div style="width: 100px;">Destruction Instruction</div></th>
                                    <th><div style="width: 100px;">Destruction Due On</div></th>
                                    <th><div style="width: 100px;">Destruction Date</div></th>
                                    <th><div style="width: 100px;">Destruction By</div></th>
                                </tr>
                                <tr>
                                    <th><div style="width: 100px;">Remarks</div></th>
                                </tr>
                                <tbody>
                                    @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                        @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                            <tr>
                                                <td><input disabled type="text" name="stoke_info[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][Batch]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('Batch', $inventory_grid) ? $inventory_grid['Batch'] : '' }}"></td>
                                                <td>
                                                    <select name="stoke_info[{{ $loop->index }}][storage_location]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                        <option>Select Storage</option>
                                                        <option value="Fridge" {{ (array_key_exists('storage_location', $inventory_grid) && $inventory_grid['storage_location'] == 'Fridge') ? 'selected' : '' }}>Fridge</option>
                                                        <option value="Freezer" {{ (array_key_exists('storage_location', $inventory_grid) && $inventory_grid['storage_location'] == 'Freezer') ? 'selected' : '' }}>Freezer</option>
                                                        <option value="Room Temperature" {{ (array_key_exists('storage_location', $inventory_grid) && $inventory_grid['storage_location'] == 'Room Temperature') ? 'selected' : '' }}>Room Temperature</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][storage_condition]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('storage_condition', $inventory_grid) ? $inventory_grid['storage_condition'] : '' }}"></td>
                                                <td>
                                                    <select name="stoke_info[{{ $loop->index }}][container_type]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                        <option>Select Container</option>
                                                        <option value="Glass" {{ (array_key_exists('container_type', $inventory_grid) && $inventory_grid['container_type'] == 'Glass') ? 'selected' : '' }}>Glass</option>
                                                        <option value="Plastic" {{ (array_key_exists('container_type', $inventory_grid) && $inventory_grid['container_type'] == 'Plastic') ? 'selected' : '' }}>Plastic</option>
                                                        <option value="Asses" {{ (array_key_exists('container_type', $inventory_grid) && $inventory_grid['container_type'] == 'Asses') ? 'selected' : '' }}>Asses</option>
                                                    </select>
                                                </td>                                                                
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][shelf_life]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('shelf_life', $inventory_grid) ? $inventory_grid['shelf_life'] : '' }}"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][handling_instruction]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('handling_instruction', $inventory_grid) ? $inventory_grid['handling_instruction'] : '' }}"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][supplier_name]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('supplier_name', $inventory_grid) ? $inventory_grid['supplier_name'] : '' }}"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][manufacturer_name]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('manufacturer_name', $inventory_grid) ? $inventory_grid['manufacturer_name'] : '' }}"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][supplier_contact]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('supplier_contact', $inventory_grid) ? $inventory_grid['supplier_contact'] : '' }}"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][supplier_lot]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('supplier_lot', $inventory_grid) ? $inventory_grid['supplier_lot'] : '' }}"></td>  
                                                <td><input type="text" id="initial_quality_{{ $loop->index }}" name="stoke_info[{{ $loop->index }}][initial_quality]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('initial_quality', $inventory_grid) ? $inventory_grid['initial_quality'] : '' }}" oninput="calculateRemaining({{ $loop->index }})"></td>
                                                <td>
                                                    <select name="stoke_info[{{ $loop->index }}][unit]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                        <option>Select Unit</option>
                                                        <option value="Pieces" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Pieces') ? 'selected' : '' }}>Pieces</option>
                                                        <option value="Kilograms" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Kilograms') ? 'selected' : '' }}>Kilograms</option>
                                                        <option value="Liters" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Liters') ? 'selected' : '' }}>Liters</option>
                                                        <option value="Meters" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Meters') ? 'selected' : '' }}>Meters</option>
                                                        <option value="Cubic Meters" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Cubic Meters') ? 'selected' : '' }}>Cubic Meters</option>
                                                        <option value="Grams" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Grams') ? 'selected' : '' }}>Grams</option>
                                                        <option value="Milliliters" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Milliliters') ? 'selected' : '' }}>Milliliters</option>
                                                        <option value="Dozens" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Dozens') ? 'selected' : '' }}>Dozens</option>
                                                        <option value="Percent " {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Percent ') ? 'selected' : '' }}>Percent </option>
                                                    </select>
                                                </td>
                                                <script>
                                                    $(document).ready(function () {
                                                        $(".datepicker").datepicker({
                                                            dateFormat: "d-M-yy" 
                                                        });
                                                    });
                                                </script>
                                                <td><input type="text" id="used_quality_{{ $loop->index }}" name="stoke_info[{{ $loop->index }}][used_quality]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('used_quality', $inventory_grid) ? $inventory_grid['used_quality'] : '' }}" oninput="calculateRemaining({{ $loop->index }})"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][reagent_name]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('reagent_name', $inventory_grid) ? $inventory_grid['reagent_name'] : '' }}"></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][expiry_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('expiry_date', $inventory_grid) ? $inventory_grid['expiry_date'] : '' }}"></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][opened_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('opened_date', $inventory_grid) ? $inventory_grid['opened_date'] : '' }}"></td>
                                                <td>
                                                    <select name="stoke_info[{{ $loop->index }}][status]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                        <option>Select Value</option>
                                                        <option value="Approved" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Approved') ? 'selected' : '' }}>Approved</option>
                                                        <option value="Expired" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Expired') ? 'selected' : '' }}>Expired</option>
                                                        <option value="Quarantined" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Quarantined') ? 'selected' : '' }}>Quarantined</option>
                                                        <option value="Rejected" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Rejected') ? 'selected' : '' }}>Rejected</option>
                                                        <option value="Under Test" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Under Test') ? 'selected' : '' }}>Under Test</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][cas_number]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('cas_number', $inventory_grid) ? $inventory_grid['cas_number'] : '' }}"></td>
                                                <td>
                                                    <select name="stoke_info[{{ $loop->index }}][another_location]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                        <option>Select Value</option>
                                                        <option value="Yes" {{ (array_key_exists('another_location', $inventory_grid) && $inventory_grid['another_location'] == 'Yes') ? 'selected' : '' }}>Yes</option>
                                                        <option value="No" {{ (array_key_exists('another_location', $inventory_grid) && $inventory_grid['another_location'] == 'No') ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][stock_transfer]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('stock_transfer', $inventory_grid) ? $inventory_grid['stock_transfer'] : '' }}"></td>
                                                <td>
                                                    <select name="stoke_info[{{ $loop->index }}][new_location]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                        <option>Select Value</option>
                                                        @if (Helpers::getDivisionName($data->division_id) != "Corporate Quality Assurance (CQA)")
                                                        <option value="Corporate Quality Assurance (CQA)" 
                                                            {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Corporate Quality Assurance (CQA)') ? 'selected' : '' }}>
                                                            Corporate Quality Assurance (CQA)
                                                        </option>
                                                        @endif
                                                        
                                                        @if (Helpers::getDivisionName($data->division_id) != "Plant 1")
                                                            <option value="Plant 1" 
                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Plant 1') ? 'selected' : '' }}>
                                                                Plant 1
                                                            </option>
                                                        @endif
                                                        
                                                        @if (Helpers::getDivisionName($data->division_id) != "Plant 2")
                                                            <option value="Plant 2" 
                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Plant 2') ? 'selected' : '' }}>
                                                                Plant 2
                                                            </option>
                                                        @endif
                                                        
                                                        @if (Helpers::getDivisionName($data->division_id) != "Plant 3")
                                                            <option value="Plant 3" 
                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Plant 3') ? 'selected' : '' }}>
                                                                Plant 3
                                                            </option>
                                                        @endif
                                                        
                                                        @if (Helpers::getDivisionName($data->division_id) != "Plant 4")
                                                            <option value="Plant 4" 
                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Plant 4') ? 'selected' : '' }}>
                                                                Plant 4
                                                            </option>
                                                        @endif
                                                        
                                                        @if (Helpers::getDivisionName($data->division_id) != "C1")
                                                            <option value="C1" 
                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'C1') ? 'selected' : '' }}>
                                                                C1
                                                            </option>
                                                        @endif
                                                    </select>
                                                </td>
                                                <td><input type="text" id="transfer_quality_{{ $loop->index }}" name="stoke_info[{{ $loop->index }}][transfer_quality]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('transfer_quality', $inventory_grid) ? $inventory_grid['transfer_quality'] : '' }}" oninput="calculateRemaining({{ $loop->index }})"></td>
                                                <td><input type="text" id="remaining_quality_{{ $loop->index }}" name="stoke_info[{{ $loop->index }}][remaining_quality]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('remaining_quality', $inventory_grid) ? $inventory_grid['remaining_quality'] : '' }}" readonly></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][distruction]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('distruction', $inventory_grid) ? $inventory_grid['distruction'] : '' }}"></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][distruction_due_on]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('distruction_due_on', $inventory_grid) ? $inventory_grid['distruction_due_on'] : '' }}"></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][distruction_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('distruction_date', $inventory_grid) ? $inventory_grid['distruction_date'] : '' }}"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][distruction_by]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('distruction_by', $inventory_grid) ? $inventory_grid['distruction_by'] : '' }}"></td>
                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][Remarks]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('Remarks', $inventory_grid) ? $inventory_grid['Remarks'] : '' }}"></td>
                                            </tr>
                                        @endforeach
                                    @else
                                       N/A
                                    @endif
                                </tbody>
                            </tr>
                        </thead>
                    </table>
                </div>  --}}
                <div class="border-table">
                    <!-- Section 1 -->
                    <h4>Section 1</h4>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Batch/Lot Number</th>
                                <th>Storage Location</th>
                                <th>Storage Conditions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['Batch'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['storage_location'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['storage_condition'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                
                    <!-- Section 2 -->
                    <h4>Section 2</h4>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Container Type</th>
                                <th>Shelf Life After Opening</th>
                                <th>Handling Instructions</th>
                                <th>Supplier Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['container_type'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['shelf_life'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['handling_instruction'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['supplier_name'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                
                    <!-- Section 3 -->
                    <h4>Section 3</h4>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Manufacturer Name</th>
                                <th>Supplier Contact Information</th>
                                <th>Supplier Lot/AR Number</th>
                                <th>Initial Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['manufacturer_name'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['supplier_contact'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['supplier_lot'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['initial_quality'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                
                    <h4>Section 4</h4>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Unit</th>
                                <th>Reagent/Item Name</th>
                                <th>Used Quantity</th>
                                <th>Reagent/Item Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['unit'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['reagent_name'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['used_quality'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['expiry_date'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <h4>Section 5</h4>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Reagent/Item Opened Date</th>
                                <th>Reagent/Item Status</th>
                                <th>CAS Number</th>
                                <th>Transfer to Another Location?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['opened_date'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['status'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['cas_number'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['another_location'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <h4>Section 6</h4>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Reason for Stock Transfer</th>
                                <th>New Location</th>
                                <th>Transfer Quantity</th>
                                <th>Remaining Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['stock_transfer'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['new_location'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['transfer_quality'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['remaining_quality'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <h4>Section 6</h4>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Destruction Instruction</th>
                                <th>Destruction Due On</th>
                                <th>Destruction Date</th>
                                <th>Destruction By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['distruction'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['distruction_due_on'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['distruction_date'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['distruction_by'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <h4>Section 7</h4>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Remarks</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['Remarks'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>


                {{-- <div class="border-table">
                    <h4>Inventory Management</h4>
                    <table border="1" cellspacing="0" cellpadding="5" width="100%">
                        <thead>
                            <!-- Section 1 -->
                            <tr class="table_bg">
                                <th>Sr No.</th>
                                <th>Batch/Lot Number</th>
                                <th>Storage Location</th>
                                <th>Storage Conditions</th>
                            </tr>
                            <!-- Section 2 -->
                            <tr class="table_bg">
                                <th>Container Type</th>
                                <th>Shelf Life After Opening</th>
                                <th>Handling Instructions</th>
                                <th>Supplier Name</th>
                            </tr>
                            <!-- Section 3 -->
                            <tr class="table_bg">
                                <th>Manufacturer Name</th>
                                <th>Supplier Contact Information</th>
                                <th>Supplier Lot/AR Number</th>
                                <th>Initial Quantity</th>
                            </tr>
                            <!-- Section 4 -->
                            <tr class="table_bg">
                                <th>Unit</th>
                                <th>Used Quantity</th>
                                <th>Reagent/Item Name</th>
                                <th>Reagent/Item Expiry Date</th>
                            </tr>
                            <!-- Section 5 -->
                            <tr class="table_bg">
                                <th>Reagent/Item Opened Date</th>
                                <th>Reagent/Item Status</th>
                                <th>CAS Number</th>
                                <th>Transfer to Another Location?</th>
                            </tr>
                            <!-- Section 6 -->
                            <tr class="table_bg">
                                <th>Reason for Stock Transfer</th>
                                <th>New Location</th>
                                <th>Transfer Quantity</th>
                                <th>Remaining Quantity</th>
                            </tr>
                            <!-- Section 7 -->
                            <tr class="table_bg">
                                <th>Destruction Instruction</th>
                                <th>Destruction Due On</th>
                                <th>Destruction Date</th>
                                <th>Destruction By</th>
                            </tr>
                            <!-- Section 8 -->
                            <tr class="table_bg">
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                    <!-- Section 1 -->
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $inventory_grid['Batch'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['storage_location'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['storage_condition'] ?? '' }}</td>
                                    </tr>
                
                                    <!-- Section 2 -->
                                    <tr>
                                        <td>{{ $inventory_grid['container_type'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['shelf_life'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['handling_instruction'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['supplier_name'] ?? '' }}</td>
                                    </tr>
                
                                    <!-- Section 3 -->
                                    <tr>
                                        <td>{{ $inventory_grid['manufacturer_name'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['supplier_contact'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['supplier_lot'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['initial_quality'] ?? '' }}</td>
                                    </tr>
                
                                    <!-- Section 4 -->
                                    <tr>
                                        <td>{{ $inventory_grid['unit'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['used_quality'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['reagent_name'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['expiry_date'] ?? '' }}</td>
                                    </tr>
                
                                    <!-- Section 5 -->
                                    <tr>
                                        <td>{{ $inventory_grid['opened_date'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['status'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['cas_number'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['transfer_location'] ?? '' }}</td>
                                    </tr>
                
                                    <!-- Section 6 -->
                                    <tr>
                                        <td>{{ $inventory_grid['reason_transfer'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['new_location'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['transfer_quantity'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['remaining_quantity'] ?? '' }}</td>
                                    </tr>
                
                                    <!-- Section 7 -->
                                    <tr>
                                        <td>{{ $inventory_grid['destruction_instruction'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['destruction_due'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['destruction_date'] ?? '' }}</td>
                                        <td>{{ $inventory_grid['destruction_by'] ?? '' }}</td>
                                    </tr>
                
                                    <!-- Section 8 -->
                                    <tr>
                                        <td>{{ $inventory_grid['remarks'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div> --}}
                
                
                
                
                

                <div class="block">
                    <div class="block-head">
                        HOD Review
                    </div>
                    <table>
                        <tr>
                            <th class="w-20"> Supplier Name</th>
                            <td class="w-30"> @if ($data->supplier_name)
                                {{ $data->supplier_name }}
                            @else
                                Not Applicable
                            @endif</td>
    
                            <th class="w-20"> Manufacturer Name</th>
                            <td class="w-30"> @if ($data->manufacturer_name)
                                {{ $data->manufacturer_name }}
                            @else
                                Not Applicable
                            @endif</td>
                           
                        </tr>
                        <tr>
                            <th class="w-20"> Supplier Contact Information</th>
                            <td class="w-30"> @if ($data->supplier_contact_info)
                                {{ $data->supplier_contact_info }}
                            @else
                                Not Applicable
                            @endif</td>
    
                            <th class="w-20"> Supplier Lot Number</th>
                            <td class="w-30"> @if ($data->supplier_lot_number)
                                {{ $data->supplier_lot_number }}
                            @else
                                Not Applicable
                            @endif</td>
                           
                        </tr>

                       
                    </table>
                    <div class="border-table">
                        <div class="block-head">
                            Certificate of Analysis (CoA) Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if ($data->certificate_of_analysis)
                                @foreach (json_decode($data->certificate_of_analysis) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                    </div>



                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Stock Information
                </div>

            </div>
            <div class="block">
                <div class="block-head">
                   Usage Tracking
                </div>

                <table>
                    <tr>
                        <th class="w-20"> Usage Date</th>
                        <td class="w-80">
                            @if ($data->usage_date)
                                {{ $data->usage_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20"> Purpose of Use</th>
                        <td class="w-80">
                            @if ($data->purpose_of_use)
                                {{ $data->purpose_of_use }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Quantity Used</th>
                        <td class="w-80">
                            @if ($data->quality_used)
                                {{ $data->quality_used }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                   
                        <th class="w-20">Logged By</th>
                        <td class="w-80">
                            @if ($data->logged_by)
                                {{ $data->logged_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    
                   

                   
                   
                </table>
               
            </div>
            <div class="block">
                <div class="block-head">
                   Storage and Handling
                </div>
                <table>
                    <tr>
                        <th class="w-20">Storage Conditions</th>
                        <td class="w-80">
                            @if ($data->storage_condition)
                                {{ $data->storage_condition }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                   
                        <th class="w-20">Container Type</th>
                        <td class="w-80">
                            @if ($data->container_type)
                                {{ $data->container_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Shelf Life After Opening</th>
                        <td class="w-80">
                            @if ($data->shelf_life)
                                {{ $data->shelf_life }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                   
                        <th class="w-20">Handling Instructions</th>
                        <td class="w-80">
                            @if ($data->handling_instructions)
                                {{ $data->handling_instructions }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>


            </div>
           
            <div class="block">
                <div class="block-head">
                   Storage and Handling
                </div>
            <div class="border-table">
                <div class="block-head">
                    Safety Data Sheet (SDS) Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                    @if ($data->safety_date_sheet)
                        @foreach (json_decode($data->certificate_of_analysis) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                        target="_blank"><b>{{ $file }}</b></a> </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif

                </table>
            </div>


                <table>
                    <tr>
                        <th class="w-20">Risk Assessment Code</th>
                        <td class="w-80">
                            @if ($data->risk_assesment_code)
                                {{ $data->risk_assesment_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                   
                        <th class="w-20">Disposal Guidelines</th>
                        <td class="w-80">
                            @if ($data->disposal_guidelines)
                                {{ $data->disposal_guidelines }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Regulatory Compliance Information</th>
                        <td class="w-80">
                            @if ($data->regualatory_info)
                                {{ $data->regualatory_info }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

            
            </div>


            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submit By</th>
                        <td class="w-30">{{ $data->submit_by }}</td>
                        <th class="w-20">Submit On</th>
                        <td class="w-30"> {{ \Carbon\Carbon::parse($data->submit_on)->format('d-m-Y') }}</td>
                        <th class="w-20">Submit Comments</th>
                        <td class="w-30">{{ $data->submit_comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">{{ $data->Cancel_By }}</td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">{{ $data->Cancel_On }}</td>
                        <th class="w-20">Cancelled Comments</th>
                        <td class="w-30">{{ $data->Cancel_Comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Review Complete By</th>
                        <td class="w-30">{{ $data->Review_Complete_by }}</td>
                        <th class="w-20">Review Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Review_Complete_on) }}</td>
                        <th class="w-20">Review Complete Comments</th>
                        <td class="w-30">{{ $data->Review_Complete_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20"> Approval Complete By</th>
                        <td class="w-30">{{ $data->Approval_Complete_by }}</td>
                        <th class="w-20"> Approval Complete On</th>
                        <td class="w-30">{{ $data->Approval_Complete_on }}</td>
                        <th class="w-20">Approval Complete Comments</th>
                        <td class="w-30">{{ $data->Approval_Complete_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Additional Work Required By</th>
                        <td class="w-30">{{ $data->additional_work_by }}</td>
                        <th class="w-20">Additional Work Required On</th>
                        <td class="w-30">{{ $data->additional_work_on }}</td>
                        <th class="w-20">Additional Work Required Comments</th>
                        <td class="w-30">{{ $data->additional_work_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Stock Transfer By</th>
                        <td class="w-30">{{ $data->stock_transfer_by }}</td>
                        <th class="w-20">Stock Transfer On</th>
                        <td class="w-30">{{ $data->stock_transfer_on }}</td>
                        <th class="w-20">Stock Transfer Comments</th>
                        <td class="w-30">{{ $data->stock_transfer_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Complete Transferring By</th>
                        <td class="w-30">{{ $data->stock_transfer1_by }}</td>
                        <th class="w-20">Complete Transferring On</th>
                        <td class="w-30">{{ $data->stock_transfer1_on }}</td>
                        <th class="w-20">Complete Transferring Comments</th>
                        <td class="w-30">{{ $data->stock_transfer1_comment }}</td>
                    </tr>
                    {{-- <tr>
                        <th class="w-20">Initiator Update By</th>
                        <td class="w-30">{{ $data->CFT_Review_Complete_By }}</td>
                        <th class="w-20">Initiator Update On </th>
                        <td class="w-30">{{ $data->CFT_Review_Complete_On }}</td>
                        <th class="w-20">Initiator Update Comments</th>
                        <td class="w-30">{{ $data->CFT_Review_Comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">HOD Final Review By </th>
                        <td class="w-30">{{ $data->CFT_Review_Complete_By }}</td>
                        <th class="w-20">HOD Final Review On </th>
                        <td class="w-30">{{ $data->CFT_Review_Complete_On }}</td>
                        <th class="w-20">HOD Final Review Comments</th>
                        <td class="w-30">{{ $data->CFT_Review_Comments }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">QA Final Review Complete By</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Complete_By }}</td>
                        <th class="w-20">QA Final Review Complete On</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Complete_On }}</td>
                        <th class="w-20">QA Final Review Comments</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Comments }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Approved By</th>
                        <td class="w-30">{{ $data->Approved_By }}</td>
                        <th class="w-20">Approved ON</th>
                        <td class="w-30">{{ $data->Approved_On }}</td>
                        <th class="w-20">Approved Comments</th>
                        <td class="w-30">{{ $data->Approved_Comments }}</td>
                    </tr> --}}



                </table>
            </div>
        </div>

    </div>

  

</body>

</html>
