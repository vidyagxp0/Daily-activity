@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">

<!-- intl-tel-input JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

@php
$users = DB::table('users')->select('id', 'name')->get();

@endphp
    <style>
        header .header_rcms_bottom {
            display: none;
        }

        .calenderauditee {
            position: relative;
        }

        .new-date-data-field .input-date input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
        }

        .remove-file {
            cursor: pointer;
        }     
        
            .language-select {
                display: flex;
                justify-content: flex-start; 
                width: 100%; 
            }
    </style>

        <style>
            .input-date {
                margin-bottom: 20px;
            }
            label {
                display: block;
                margin-bottom: 5px;
            }
            input[type="date"] {
                padding: 8px;
                font-size: 16px;
                width: 100%;
            }
        </style>

    <style>
        #change-control-fields .inner-block .group-input table input, #change-control-fields .inner-block .group-input table select{
            border: 1px solid black;
            padding: 4px
        }
    </style>

    <script>
        function otherController(value, checkValue, blockID) {
            let block = document.getElementById(blockID)
            let blockTextarea = block.getElementsByTagName('textarea')[0];
            let blockLabel = block.querySelector('label span.text-danger');
            if (value === checkValue) {
                blockLabel.classList.remove('d-none');
                blockTextarea.setAttribute('required', 'required');
            } else {
                blockLabel.classList.add('d-none');
                blockTextarea.removeAttribute('required');
            }
        }
    </script>



    <div id="rcms_form-head">
        <div class="container-fluid">
            <div class="inner-block">


                <div class="slogan">
                    <strong>Site Division / Project </strong>:
                    {{ Helpers::getDivisionName(session()->get('division')) }} / Control Sample
                </div>
            </div>
        </div>
    </div>
    @php
        $users = DB::table('users')->get();
    @endphp
    <div id="change-control-fields">
        <div class="container-fluid">
            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- <div class="language-sleect d-flex" style="align-items: center; gap: 20px;">
                        <div>Select Language </div>
                        <div class="main-head" id="google_translate_element"></div>
                    </div> -->

                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                includedLanguages: 'af,am,ar,az,be,bg,bn,bs,ca,ceb,co,cs,cy,da,de,el,en,eo,es,et,eu,fa,fi,fr,fy,ga,gd,gl,gu,ha,haw,he,hi,hmn,hr,ht,hu,hy,id,ig,is,it,ja,jw,ka,kk,km,kn,ko,ku,ky,la,lb,lo,lt,lv,mg,mi,mk,ml,mn,mr,ms,mt,my,ne,nl,no,ny,pa,pl,ps,pt,ro,ru,sd,si,sk,sl,sm,sn,so,sq,sr,st,su,sv,sw,ta,te,tg,th,tl,tr,uk,ur,uz,vi,xh,yi,yo,zh-CN,zh-TW,zu',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                            }, 'google_translate_element');
                        }
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
                    </script>
                </div>
            </div>


            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Control Sample</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Activity Log</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">QA Review</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity Log</button> --}}
                
                <div class="language-select d-flex align-items-center" style="justify-content: flex-start;">
                    <div>Select Language</div>
                    <div class="main-head" id="google_translate_element"></div>
                </div>
            </div>

           
            <form action="{{ route('control-sample-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tab content -->
                <div id="step-form">

                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input readonly type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/CS/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>

                               

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" name="division_code"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="assign_to" placeholder="Select..." name="assign_to">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Due Date <span class="text-danger">*</span></label>
                                        {{-- <div><small class="text-primary">If revising Due Date, kindly mention revision
                                                reason in "Due Date Extension Justification" data field.</small></div> --}}
                                        <div class="calenderauditee">
                                            <input disabled type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                required />
                                            <input type="date" name="due_date" required
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars"
                                            class="text-primary">255 </span><span class="text-primary"> characters
                                            remaining</span>
                                        <div class="relative-container">
                                            <input id="docname" type="text" name="short_description" maxlength="255"
                                                required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Sample Id</b></label>
                                        <input disabled type="text" name="sample_id"
                                            value="">
                                        <input type="hidden" name="sample_id" value="">
                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Product Name">Product Name</label>
                                        <input type="text" name="product_name">
                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Product Code">Product Code</label>
                                        <input type="text" name="product_code">
                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Type">Sample Type</label>
                                        <input type="text" name="sample_type">
                                    </div>
                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Type">Reagent Item Required?</label>
                                        <select name="reagion_item" id="">
                                            <option value="0">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">NO</option>
                                        </select>
                                    </div>
                                </div>
                                
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="market">Market</label>
                                        
                                        <select name="market" id="market">
                                            <option value="0">Select  country</option>
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="American Samoa">American Samoa</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Canada">Canada</option>
                                            <option value="China">China</option>
                                            <option value="Croatia">Croatia</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="Finland">Finland</option>
                                            <option value="Croatia">Croatia</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="Germany">Germany</option>
                                            <option value="India">India</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Russia">Russia</option>
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>

                                        </select>
                                    </div>
                                </div> --}}
                                
                               
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="AR No.">AR No.</label>
                                        <input type="text" name="ar_number">
                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="AR No.">Batch Number</label>
                                        <input type="text" name="batch_number">
                                    </div>
                                </div> --}}



                                {{-- <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Manufacturing Date</label>
                                        
                                        <div class="calenderauditee">
                                            <input disabled type="text" id="manufacturing_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="manufacturing_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'manufacturing_date')" />
                                        </div>
                                    </div>
                                </div> --}}


                                {{-- <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Expiry Date"> Expiry Date</label>
                                        
                                        <div class="calenderauditee">
                                            <input disabled type="text" id="expiry_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="expiry_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'expiry_date')" />
                                        </div>
                                    </div>
                                </div> --}}
                               
        
                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        Control Sample Grid
                                        <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="job-responsibilty-table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th><div style="width: 80px;">Row #</div></th>
                                                    <th><div style="width: 100px;">Product Name</div></th>
                                                    <th><div style="width: 100px;">Product Code</div></th>
                                                    <th><div style="width: 100px;">Sample Type</div></th>
                                                    <th><div style="width: 100px;">Market</div></th>
                                                    <th><div style="width: 100px;">Ar No</div></th>
                                                    <th><div style="width: 100px;">Batch Number</div></th>
                                                    <th><div style="width: 100px;">Manufacturing Date</div></th>
                                                    <th><div style="width: 100px;">Expiry Date</div></th>
                                                    <th><div style="width: 100px;">Quantity</div></th>
                                                    <th><div style="width: 180px;">Unit of Measurement (UOM)</div></th>
                                                    <th><div style="width: 200px;">Visual Inspection Scheduled On</div></th>
                                                    <th><div style="width: 180px;">Quantity Withdrawn</div></th>
                                                    <th><div style="width: 180px;">Reason For Withdrawal</div></th>
                                                    <th><div style="width: 180px;">Current Quantity</div></th>
                                                    <th><div style="width: 180px;">Storage Location</div></th>
                                                    <th><div style="width: 180px;">Storage Condition</div></th>
                                                    <th><div style="width: 180px;">Inspection Date</div></th>
                                                    <th><div style="width: 180px;">Inspection Detail</div></th>
                                                    <th><div style="width: 180px;">Inspection Done By</div></th>
                                                    <th><div style="width: 180px;">Destruction Due On</div></th>
                                                    <th><div style="width: 180px;">Destruction Date</div></th>
                                                    <th><div style="width: 180px;">Destroyed By</div></th>
                                                    <th><div style="width: 180px;">Neutralizing Agent</div></th>
                                                    <th><div style="width: 180px;">Instruction for destruction</div></th>
                                                    <th><div style="width: 180px;">Remarks</div></th>
                                                    <th><div style="width: 100px;">Action</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial[]" value="1"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][product_name]" class="product_name"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][product_code]" class="product_code"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][sample_type]" class="sample_type"></td>
                                                    <td><select  name="ControlSampleGrid[0][market]">
                                                        <option value="0">Select  country</option>
                                                        <option value="Afghanistan">Afghanistan</option>
                                                        <option value="Albania">Albania</option>
                                                        <option value="Algeria">Algeria</option>
                                                        <option value="American Samoa">American Samoa</option>
                                                        <option value="Andorra">Andorra</option>
                                                        <option value="Angola">Angola</option>
                                                        <option value="Argentina">Argentina</option>
                                                        <option value="Armenia">Armenia</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Austria">Austria</option>
                                                        <option value="Azerbaijan">Azerbaijan</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Barbados">Barbados</option>
                                                        <option value="Belgium">Belgium</option>
                                                        <option value="Belize">Belize</option>
                                                        <option value="Benin">Benin</option>
                                                        <option value="Bhutan">Bhutan</option>
                                                        <option value="Bolivia">Bolivia</option>
                                                        <option value="Botswana">Botswana</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="Bulgaria">Bulgaria</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="China">China</option>
                                                        <option value="Croatia">Croatia</option>
                                                        <option value="Colombia">Colombia</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="Finland">Finland</option>
                                                        <option value="Croatia">Croatia</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="India">India</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Netherlands">Netherlands</option>
                                                        <option value="New Zealand">New Zealand</option>
                                                        <option value="Pakistan">Pakistan</option>
                                                        <option value="Poland">Poland</option>
                                                        <option value="Russia">Russia</option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Sweden">Sweden</option>
                                                        <option value="Switzerland">Switzerland</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="United States">United States</option>
            
                                                    </select></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][ar_number]" class="ar_number"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][batch_number]" class="batch_number"></td>
                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[0][manufacturing_date]" placeholder="DD-MM-YYYY"></td>
                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[0][expiry_date]" placeholder="DD-MM-YYYY"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][quantity]" class="quantity"></td>
                                                    <td>
                                                        <select name="ControlSampleGrid[0][unit_of_measurment]">
                                                            <option value="">Select UOM</option>
                                                            <option value="Pieces">Pieces</option>
                                                            <option value="Kilograms">Kilograms</option>
                                                            <option value="Liters">Liters</option>
                                                            <option value="Meters">Meters</option>
                                                            <option value="Cubic Meters">Cubic Meters</option>
                                                            <option value="Grams">Grams</option>
                                                            <option value="Milliliters">Milliliters</option>
                                                            <option value="Dozens">Dozens</option>
                                                            <option value="Percent">Percent</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[0][vi_scheduled_on]" placeholder="DD-MM-YYYY"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][quantity_withdrawn]" class="quantity_withdrawn"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][reason_for_withdrawal]" class="reason_for_withdrawal"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][current_quantity]" class="current_quantity"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][storage_location]"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][storage_condition]"></td>
                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[0][inspection_date]" placeholder="DD-MM-YYYY"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][inspection_detail]"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][inspection_done_by]"></td>
                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[0][destruction_due_on]" placeholder="DD-MM-YYYY"></td>
                                                    <td><input type="text" class="datepicker" name="ControlSampleGrid[0][destruction_date]" placeholder="DD-MM-YYYY"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][destroyed_by]"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][neutralizing_agent]"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][instruct_of_destrct]"></td>
                                                    <td><input type="text" name="ControlSampleGrid[0][remarks]"></td>
                                                    <td><button type="button" class="removeRowBtn">Remove</button></td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Remarks">Status</label>
                                        <input type="text" name="status">
                                    </div> 
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Calibration Procedure Reference/Document">Supportive Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="supportive_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile"
                                                    name="supportive_attachment[]"
                                                    oninput="addMultipleFiles(this, 'supportive_attachment')"
                                                    multiple>
                                             </div>
                                        </div>
                                    </div>
                                </div>                                                            
   
                            </div>


                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>

                    </div>


                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Cancel By">Implementor Review Comment</label>
                                        {{-- <input type="text" name="Imp_review_comm" value=""> --}}
                                        <textarea name="Imp_review_comm" id="" cols="30" rows=""></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Implementor Review Attachment">Implementor Review Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Implementor_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile"
                                                    name="Implementor_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'Implementor_Attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="submit">Submit</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
             


                </div>
            </form>

        </div>
    </div>

    <div class="modal fade" id="change-control-type-of-change-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4>1. Major Change:</h4>
                    <ul>
                        <li>A major change is usually a significant alteration that may have a substantial impact on the
                            product.</li>

                        <li>It might involve modifications to the manufacturing process, formulation, equipment, or other
                            critical aspects of production.</li>

                        <li>Major changes often require thorough assessment, validation, and regulatory approval before
                            implementation.</li>
                    </ul>


                    <h4>2. Minor Change:</h4>
                    <ul>

                        <li>A minor change is typically a less significant alteration, one that is unlikely to have a
                            substantial impact on product quality, safety, or efficacy.</li>

                        <li>Minor changes may include adjustments to documentation, labeling, or other non-critical aspects
                            that don't significantly affect the product's characteristics.</li>

                        <li>These changes may still require some level of evaluation and documentation but may not
                            necessitate the same level of scrutiny as major changes.</li>
                    </ul>


                    <h4>3. Critical Change:</h4>
                    <ul>

                        <li>A critical change is one that has the potential to significantly impact product quality, safety,
                            or efficacy and may require immediate attention.</li>

                        <li>These changes are often associated with unexpected events or deviations that need prompt
                            resolution to maintain product integrity.</li>

                        <li>Critical changes may require urgent assessment, corrective actions, and regulatory reporting.
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('#submitPrompt').click(async function() {
                let docDescription = $('input[name=short_description]').val().trim();
                if (docDescription === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Input',
                        text: 'Please enter a document short description.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Generating AI Response...',
                    html: 'Please wait while we gather insights based on your input. This might take a moment...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    let open_ai_key = "{{ config('app.open_ai_key') }}";

                    const response = await axios.post(
                        'https://api.openai.com/v1/chat/completions', {
                            "model": "gpt-3.5-turbo",
                            "messages": [{
                                "role": "user",
                                "content": `Generate a structured JSON response (string key: string value) with fields Impact On Operations, Impact On Product Quality, Regulatory Impact, Risk Level, Validation Requirement based on the Change Control description: "${docDescription}". Make content as lengthy as possible.`
                            }]
                        }, {
                            headers: {
                                'Authorization': `Bearer ${open_ai_key}`,
                                'Content-Type': 'application/json'
                            }
                        }
                    );

                    Swal.close();

                    let content = response.data.choices[0].message.content;
                    let jsonResponse = JSON.parse(content);
                    console.log('data', jsonResponse)
                    populateFields(jsonResponse);
                    $('#customModal').modal('hide');

                } catch (error) {
                    console.log('error in ai generating response', error.message)
                }
            });

            function populateFields(data) {
                for (let section in data) {
                    let sectionData = data[section];

                    switch (section.toLowerCase()) {
                        case "impact on operations":
                            $("textarea[name='impact_operations']").val(sectionData);
                            break;

                        case "impact on product quality":
                            $("textarea[name='impact_product_quality']").val(sectionData);
                            break;

                        case "regulatory impact":
                            $("textarea[name='regulatory_impact']").val(sectionData);
                            break;

                        case "risk level":
                            $("textarea[name='risk_level']").val(sectionData);
                            break;

                        case "validation requirement":
                            $("textarea[name='validation_requirment']").val(sectionData);
                            break;

                        default:
                            console.warn(`No matching field found for section: ${section}`);
                    }
                }
            }

        });
    </script>

    <style>
        #step-form>div {
            display: none;
        }

        #step-form>div:nth-child(1) {
            display: block;
        }

        #productTable,
        #materialTable {
            display: none;
        }
    </style>

    <script>
        const productSelect = document.getElementById('productSelect');
        const productTable = document.getElementById('productTable');
        const materialSelect = document.getElementById('materialSelect');
        const materialTable = document.getElementById('materialTable');

        materialSelect.addEventListener('change', function() {
            if (materialSelect.value === 'yes') {
                materialTable.style.display = 'block';
            } else {
                materialTable.style.display = 'none';
            }
        });

        productSelect.addEventListener('change', function() {
            if (productSelect.value === 'yes') {
                productTable.style.display = 'block';
            } else {
                productTable.style.display = 'none';
            }
        });
    </script>

    <script>
        VirtualSelect.init({
            ele: '#related_records, #cft_reviewer, #risk_assessment_related_record'
        });

        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";

            // Find the index of the clicked tab button
            const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

            // Update the currentStep to the index of the clicked tab
            currentStep = index;
        }

        const saveButtons = document.querySelectorAll(".saveButton");
        const nextButtons = document.querySelectorAll(".nextButton");
        const form = document.getElementById("step-form");
        const stepButtons = document.querySelectorAll(".cctablinks");
        const steps = document.querySelectorAll(".cctabcontent");
        let currentStep = 0;

        function nextStep() {
            // Check if there is a next step
            if (currentStep < steps.length - 1) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show next step
                steps[currentStep + 1].style.display = "block";

                // Add active class to next button
                stepButtons[currentStep + 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep++;
            }
        }

        function previousStep() {
            // Check if there is a previous step
            if (currentStep > 0) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show previous step
                steps[currentStep - 1].style.display = "block";

                // Add active class to previous button
                stepButtons[currentStep - 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep--;
            }
        }
    </script>

    <script>
        function calculateRiskAnalysis(selectElement) {
            // Get the row containing the changed select element
            let row = selectElement.closest('tr');

            // Get values from select elements within the row
            let R = parseFloat(document.getElementById('analysisR').value) || 0;
            let P = parseFloat(document.getElementById('analysisP').value) || 0;
            let N = parseFloat(document.getElementById('analysisN').value) || 0;

            // Perform the calculation
            let result = R * P * N;

            // Update the result field within the row
            document.getElementById('analysisRPN').value = result;
        }
    </script>
    {{-- var riskData = @json($riskData); --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() { //DISABLED PAST DATES IN APPOINTMENT DATE
            var dateToday = new Date();
            var month = dateToday.getMonth() + 1;
            var day = dateToday.getDate();
            var year = dateToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            $('#dueDate').attr('min', maxDate);
        });
    </script>

    <script>
        $(document).ready(function() {
            var aiText = $('.ai_text');


            console.log(riskData);
            $('#short_description').on('input', function() {
                var description = $(this).val().toLowerCase();
                var riskLevelSelectize = $('#risk_level')[0].selectize;
                // var aiText = $('#ai_text');

                var foundRiskLevel = false;
                for (var i = 0; i < riskData.length; i++) {
                    if (description.includes(riskData[i].keyword.toLowerCase())) {
                        riskLevelSelectize.setValue(riskData[i].risk_level, true);
                        aiText.show();
                        foundRiskLevel = true;
                        console.log(riskData[i].keyword);
                        break;
                    }
                }
                if (!foundRiskLevel) {
                    riskLevelSelectize.setValue('0', true);
                    aiText.hide();
                }
            });

            $('#risk_level').on('change', function() {
                if ($(this).val() !== '0') {
                    aiText.hide();
                }
            });
        });
    </script>
    <script>
        // JavaScript
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>

    <style>
        .swal2-container.swal2-center.swal2-backdrop-show .swal2-icon.swal2-error.swal2-icon-show,
        .swal2-container.swal2-center.swal2-backdrop-show .selectize-control.swal2-select.single {
            display: none !important;
        }

        .swal2-container.swal2-center.swal2-backdrop-show #swal2-title {
            text-align: center;
            font-size: 1.5rem !important;
        }

        .swal2-container.swal2-center.swal2-backdrop-show .swal2-html-container.my-html-class {
            text-transform: capitalize !important;
        }
    </style>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Event listener for the remove file button
            $(document).on('click', '.remove-file', function() {
                $(this).closest('.file-container').remove();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileName = this.getAttribute('data-file-name');
                    const fileContainer = this.parentElement;

                    // Hide the file container
                    if (fileContainer) {
                        fileContainer.style.display = 'none';
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function () {
        $(".datepicker").datepicker({
            dateFormat: "dd-mm-yy"
        });

        $('#ObservationAdd').click(function(e) {
            var tableBody = $('#job-responsibilty-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
            // Initialize datepicker for newly added row
            $(".datepicker").datepicker({
                dateFormat: "dd-mm-yy"
            });
        });

        function generateTableRow(serialNumber) {
            var html =
            '<tr>' +
                '<td><input disabled type="text" name="ControlSampleGrid[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][product_name]" class="product_name"></td>'+
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][product_code]" class="product_code"></td>'+
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][sample_type]" class="sample_type"></td>'+
                '<td><select name="ControlSampleGrid['+ serialNumber +'][market]">' + 
                    '<option value="">Select Country</option>' + 
                    '<option value="Afghanistan">Afghanistan</option>'+
                    '<option value="Albania">Albania</option>'+
                    '<option value="Algeria">Algeria</option>'+
                    '<option value="American Samoa">American Samoa</option>'+
                    '<option value="Andorra">Andorra</option>'+
                    '<option value="Angola">Angola</option>'+
                    '<option value="Argentina">Argentina</option>'+
                    '<option value="Armenia">Armenia</option>'+
                    '<option value="Australia">Australia</option>'+
                    '<option value="Austria">Austria</option>'+
                    '<option value="Azerbaijan">Azerbaijan</option>'+
                    '<option value="Bahrain">Bahrain</option>'+
                    '<option value="Bangladesh">Bangladesh</option>'+
                    '<option value="Barbados">Barbados</option>'+
                    '<option value="Belgium">Belgium</option>'+
                    '<option value="Belize">Belize</option>'+
                    '<option value="Benin">Benin</option>'+
                    '<option value="Bhutan">Bhutan</option>'+
                    '<option value="Bolivia">Bolivia</option>'+
                    '<option value="Botswana">Botswana</option>'+
                    '<option value="Brazil">Brazil</option>'+
                    '<option value="Bulgaria">Bulgaria</option>'+
                    '<option value="Canada">Canada</option>'+
                    '<option value="China">China</option>'+
                    '<option value="Croatia">Croatia</option>'+
                    '<option value="Colombia">Colombia</option>'+
                    '<option value="Czech Republic">Czech Republic</option>'+
                    '<option value="Denmark">Denmark</option>'+
                    '<option value="Egypt">Egypt</option>'+
                    '<option value="Finland">Finland</option>'+
                    '<option value="Croatia">Croatia</option>'+
                    '<option value="Czech Republic">Czech Republic</option>'+
                    '<option value="Denmark">Denmark</option>'+
                    '<option value="Egypt">Egypt</option>'+
                    '<option value="Germany">Germany</option>'+
                    '<option value="India">India</option>'+
                    '<option value="Italy">Italy</option>'+
                    '<option value="Japan">Japan</option>'+
                    '<option value="Mexico">Mexico</option>'+
                    '<option value="Netherlands">Netherlands</option>'+
                    '<option value="New Zealand">New Zealand</option>'+
                    '<option value="Pakistan">Pakistan</option>'+
                    '<option value="Poland">Poland</option>'+
                    '<option value="Russia">Russia</option>'+
                   ' <option value="Saudi Arabia">Saudi Arabia</option>'+
                    '<option value="Sweden">Sweden</option>'+
                    '<option value="Switzerland">Switzerland</option>'+
                    '<option value="Turkey">Turkey</option>'+
                    '<option value="United Kingdom">United Kingdom</option>'+
                    '<option value="United States">United States</option>'+
                '</select></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][ar_number]" class="ar_number"></td>'+
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][batch_number]" class="batch_number"></td>'+
                '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][manufacturing_date]" placeholder="DD-MM-YYYY"></td>' +
                '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][expiry_date]" placeholder="DD-MM-YYYY"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][quantity]" class="quantity"></td>'+
                '<td><select name="ControlSampleGrid['+ serialNumber +'][unit_of_measurment]">' + 
                    '<option value="">Select UOM</option>' + 
                    '<option value="Pieces">Pieces</option>' +
                    '<option value="Kilograms">Kilograms</option>' +
                    '<option value="Liters">Liters</option>' +
                    '<option value="Meters">Meters</option>' +
                    '<option value="Cubic Meters">Cubic Meters</option>' +
                    '<option value="Grams">Grams</option>' +
                    '<option value="Milliliters">Milliliters</option>' +
                    '<option value="Dozens">Dozens</option>' +
                    '<option value="Percent">Percent</option>' +
                '</select></td>' +
                '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][vi_scheduled_on]" placeholder="DD-MM-YYYY"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][quantity_withdrawn]" class="quantity_withdrawn"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][reason_for_withdrawal]" class="reason_for_withdrawal"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][current_quantity]" class="current_quantity"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][storage_location]"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][storage_condition]"></td>' +
                '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][inspection_date]" placeholder="DD-MM-YYYY"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][inspection_detail]"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][inspection_done_by]"></td>' +
                '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][destruction_due_on]" placeholder="DD-MM-YYYY"></td>' +
                '<td><input type="text" class="datepicker" name="ControlSampleGrid[' + serialNumber + '][destruction_date]" placeholder="DD-MM-YYYY"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][destroyed_by]"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][neutralizing_agent]"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][instruct_of_destrct]"></td>' +
                '<td><input type="text" name="ControlSampleGrid['+ serialNumber +'][remarks]"></td>' +
                '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
            '</tr>';
            return html;
        }

        // Remove row functionality
        $(document).on('click', '.removeRowBtn', function () {
            $(this).closest('tr').remove();
        });

        // Handle quantity withdrawn and current quantity
        $(document).on('input', '.quantity_withdrawn', function() {
            var row = $(this).closest('tr');
            var quantity = parseFloat(row.find('.quantity').val()) || 0;
            var withdrawn = parseFloat($(this).val()) || 0;
            var currentQuantity = quantity - withdrawn;
            row.find('.current_quantity').val(currentQuantity);
        });
    });
</script>

@endsection
