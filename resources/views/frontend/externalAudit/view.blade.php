@extends('frontend.layout.main')
@section('container')
@php
 
$users = DB::table('users')
    ->select('id', 'name')
    ->get();

@endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        .remove-file  {
            color: white;
            cursor: pointer;
            margin-left: 10px;
        }

        .remove-file :hover {
            color: white;
        }
        iframe#\:2\.container {
        /* display: none; */
        height: 0px !important;
        background: #4274da !important;
    }
    img.goog-te-gadget-icon {
        display: none;
    }
    .skiptranslate.goog-te-gadget {
        margin-bottom: 0px;
    }
    div#google_translate_element {
        border: none;
    }
    .VIpgJd-ZVi9od-aZ2wEe-wOHMyf.VIpgJd-ZVi9od-aZ2wEe-wOHMyf-ti6hGc {
        display: none;
    }
    </style>
    <script>
        $(document).ready(function () {
    let multipleCancelButton = new Choices("#choices-multiple-remove-button", {
        removeItemButton: true,
    });
});

function addMultipleFiles(input, block_id) {
    let block = document.getElementById(block_id);
    block.innerHTML = "";
    let files = input.files;
    for (let i = 0; i < files.length; i++) {
        let div = document.createElement('div');
        div.innerHTML += files[i].name;
        let viewLink = document.createElement("a");
        viewLink.href = URL.createObjectURL(files[i]);
        viewLink.textContent = "View";
        div.appendChild(viewLink);
        block.appendChild(div);
    }
}
    </script>
  <script>
    $(document).ready(function() {
        $('#ObservationAdd').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="observation_id[]"></td>' +
                    // '<td><input type="date" name="date[]"></td>' +
                    // '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="date'+ serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="date[]" class="hide-input" oninput="handleDateInput(this, `date' + serialNumber +'`)" /></div></div></div></td>' +

                    // '<td><select name="auditorG[]">' +
                    '<option value="">Select a value</option>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                html += '</select></td>' +
                    // '<td><select name="auditeeG[]">' +
                    // '<option value="">Select a value</option>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }
                // html += '</select></td>' +
                    '<td><input type="text" name="observation_description[]"></td>' +
                    // '<td><input type="text" name="severity_level[]"></td>' +
                    '<td><input type="text" name="area[]"></td>' +
                    // '<td><input type="text" name="observation_category[]"></td>' +
                    // '<td><select name="capa_required[]"><option value="">Select A Value</option><option value="Yes">Yes</option><option value="No">No</option></select></td>' +
                     '<td><input type="text" name="auditee_response[]"></td>' +
                    // '<td><input type="text" name="auditor_review_on_response[]"></td>' +
                    // '<td><input type="text" name="qa_comment[]"></td>' +
                    // '<td><input type="text" name="capa_details[]"></td>' +
                    // '<td><input type="date" name="capa_due_date[]"></td>' +
                    // '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="capa_due_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="capa_due_date[]" class="hide-input" oninput="handleDateInput(this, `capa_due_date' + serialNumber +'`)" /></div></div></div></td>' +

                    // '<td><select name="capa_owner[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +      
                            //   '<td><input type="text" name="action_taken[]"></td>' +
                    // '<td><input type="date" name="capa_completion_date[]"></td>' +
                    // '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="capa_completion_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="capa_completion_date[]" class="hide-input" oninput="handleDateInput(this, `capa_completion_date' + serialNumber +'`)" /></div></div></div></td>' +

                    // '<td><input type="text" name="status_Observation[]"></td>' +
                    // '<td><input type="text" name="remark_observation[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#onservation-field-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
    </script>
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

    <script>
        function addAuditAgenda(tableId) {
            var users = @json($users);
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text' name='audit[]'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_start_date' + currentRowCount +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_start_date[]" id="scheduled_start_date' + currentRowCount +'_checkdate"  class="hide-input" oninput="handleDateInput(this, `scheduled_start_date' + currentRowCount +'`);checkDate(`scheduled_start_date' + currentRowCount +'_checkdate`,`scheduled_end_date' + currentRowCount +'_checkdate`)" /></div></div></div></td>';

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='time' name='scheduled_start_time[]' >";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_end_date' + currentRowCount +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_end_date[]" id="scheduled_end_date'+ currentRowCount +'_checkdate" class="hide-input" oninput="handleDateInput(this, `scheduled_end_date' + currentRowCount +'`);checkDate(`scheduled_start_date' + currentRowCount +'_checkdate`,`scheduled_end_date' + currentRowCount +'_checkdate`)" /></div></div></div></td>';

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<input type='time' name='scheduled_end_time[]' >";

            var cell7 = newRow.insertCell(6);
            var userHtml = '<select name="auditor[]"><option value="">-- Select --</option>';
                    for (var i = 0; i < users.length; i++) {
                        userHtml += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }
                    userHtml +='</select>';
            
                    cell7.innerHTML = userHtml;

            var cell8 = newRow.insertCell(7);
            var cell8 = newRow.insertCell(7);
            
            var userHtml = '<select name="auditee[]"><option value="">-- Select --</option>';
                for (var i = 0; i < users.length; i++) {
                    userHtml += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }
                userHtml +='</select>';
        
                cell8.innerHTML = userHtml;

            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input type='text'name='remark[]'>";
            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }
    </script>
<style>
        .sticky-buttons div {
             background: #4274da;
             width: 40px;
             height: 40px;
             display: grid;
             place-items: center;
             border-radius: 0 5px 5px 0;
         }
            .sticky-buttons {
                        position: fixed;
                        top: 50%;
                        left: 0;
                        transform: translate(0, -50%);
                        display: grid;
                        gap: 10px;
                        z-index: 5;
                    }
            .btn-position{
                    top:50%;
                    left:50%;
                    transform:translate(-50%, -50%);
                    position:absolute;
                    }
                .modal.right.fade.in .modal-dialog {
                right:0 !important;
                transform: translateX(-50%);
                }
            
            .modal.right .modal-content {
            height:100%;
            overflow:auto;
            border-radius:0;
            }
            
            .modal.right .modal-dialog {
                    position: fixed;
                    margin: auto;
                    height: 100%;
                    -webkit-transform: translate3d(0%, 0, 0);
                    -ms-transform: translate3d(0%, 0, 0);
                    -o-transform: translate3d(0%, 0, 0);
                    transform: translate3d(0%, 0, 0);
                    }
            
            .modal.right.fade.in .modal-dialog {
            transform: translateX(0%);
            }
            .modal.right.fade .modal-dialog {
            
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
            width: 340px;
            }
                            
                
                .modal.right .modal-header {
                background-color:#bfd0f2; 
                display: flex;
                justify-content: center;
                color:#fff
            }
                .modal.right .modal-header::after {content:""; display:inline-block;}
                .modal.right .close {text-shadow:none; opacity:1; color:#ff4d4d; font-size:26px}
            /*  form-control  */
                
                .form-control {border-radius:0; box-shadow:none}
                .form-control:focus {box-shadow:none}
                
                
            /*  Button  */
            
                
                .btn {border-radius:0}
            
                .down-logo {
                display: flex;
                justify-content: center;
            }
            .dawn_arrow {
                /* position: absolute; */
                top: 100%;
                left: 50%;
                transform: rotate(90deg) translate(-12%, 23px);
                width: 50px;
                height: 50px;
                margin-left: 42px;
            }
            
                    /* scrollbar */
                    ::-webkit-scrollbar {
                        width: 5px;
                        height: 5px;
                    }
                    
                    ::-webkit-scrollbar-track {
                        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                        -webkit-border-radius: 15px;
                        border-radius: 15px;
                    }
                    
                    ::-webkit-scrollbar-thumb {
                        -webkit-border-radius: 15px;
                        border-radius: 15px;
                        background: rgba(255, 255, 255, 0.3);
                        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
                    }
                    
                    ::-webkit-scrollbar-thumb:window-inactive {
                        background: rgba(255, 255, 255, 0.3);
                    }
                
                        .mini_buttons{
                            /* background: #1aa71a; */
                            display: flex;
                            border: 1px solid;
                            padding: 5px;
                            width: 250px;
                            border-radius: 10px;
                            justify-content: center;
                        }
                        .button-box .active{
                            background: #1aa71a;
                            display: flex;
                            border: 1px solid;
                            border-radius: 10px;
                            padding: 7px;
                            width: 250px;
                            justify-content: center;
                        }
                        .main-new-workflow{
                            display: flex;
                            justify-content: center;
                        }
                        .state-block .top-block {
                            background: #4274da;
                            color: white;
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
                        }
                        .state-block .top-block div {
                            padding: 10px 20px;
                            border-right: 1px dashed #ffffff;
                            font-size: 0.9rem;
                        }

                        
            
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName($data->division_id) }} / External Audit
        </div>
    </div>

    {{-- ---------------------- --}}
    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                    <div>Select Language </div>
                <div class="main-head" id="google_translate_element"></div>
                </div>
                            
                <script type="text/javascript">
                    function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            includedLanguages: 'en,es,fr,de,zh,hi,ar,pt,ja,ru',
                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                        }, 'google_translate_element');
                    }
                </script>                                            
                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                <script>
                    $(document).ready(function() {
                        setTimeout(() => {
                            $('body').css('top', '0');
                        }, 5000);
                    })
                </script>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow  </div>

                    <div class="d-flex" style="gap:20px;">
                      
                    <?php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    ?>
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ route('ShowexternalAuditTrial', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(13, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Schedule Audit
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                                Child
                            </button> --}}
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(12, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete Audit Preparation
                            </button>
                           
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Reject
                            </button>
                        @elseif($data->stage == 3 && (in_array(12, $userRoleIds) || in_array(18, $userRoleIds)))
                            </button> <button class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#rejection-modal">
                                Reject
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Issue Report</button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 4 && (in_array(11, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                CAPA Plan Proposed
                            </button>

                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                No CAPAs Required
                            </button>
                           
                        @elseif($data->stage == 5 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds) || in_array(11, $userRoleIds) ))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                All CAPA Closed
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>


                    </div>

                </div>










                

                <div class="sticky-buttons">
                    <div>
                        <a type="button" class="" data-toggle="modal" data-target="#myModal3">
                            <svg width="18" height="24" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#ffffff"
                                    d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M332.1 128H256V51.9zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288zm220.1-208c-5.7 0-10.6 4-11.7 9.5c-20.6 97.7-20.4 95.4-21 103.5c-.2-1.2-.4-2.6-.7-4.3c-.8-5.1.3.2-23.6-99.5c-1.3-5.4-6.1-9.2-11.7-9.2h-13.3c-5.5 0-10.3 3.8-11.7 9.1c-24.4 99-24 96.2-24.8 103.7c-.1-1.1-.2-2.5-.5-4.2c-.7-5.2-14.1-73.3-19.1-99c-1.1-5.6-6-9.7-11.8-9.7h-16.8c-7.8 0-13.5 7.3-11.7 14.8c8 32.6 26.7 109.5 33.2 136c1.3 5.4 6.1 9.1 11.7 9.1h25.2c5.5 0 10.3-3.7 11.6-9.1l17.9-71.4c1.5-6.2 2.5-12 3-17.3l2.9 17.3c.1.4 12.6 50.5 17.9 71.4c1.3 5.3 6.1 9.1 11.6 9.1h24.7c5.5 0 10.3-3.7 11.6-9.1c20.8-81.9 30.2-119 34.5-136c1.9-7.6-3.8-14.9-11.6-14.9h-15.8z" />
                            </svg>
                        </a>
                    </div>
                    {{-- <div>
                            <a type="button" class="" data-toggle="modal" data-target="#myModal4">
                              <svg width="24" height="24" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#ffffff" d="M25.01 49v46H103V49zM153 49v46h78V49zm128 0v46h78V49zm128 0v46h78V49zM55.01 113v64H119v46h18v-46h64v-64h-18v46H73.01v-46zM311 113v64h64v46h18v-46h64v-64h-18v46H329v-46zM89.01 241v46H167v-46zM345 241v46h78v-46zm-226 64v48h128v46h18v-46h128v-48h-18v30H137v-30zm98 112v46h78v-46z"/>
                              </svg>
                            </a>
                        </div> --}}
                </div>

                <div class="modal right fade" id="myModal3" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-titles ml-10">External Audit Workflow</h4>
                            </div>
                            <div style="" class="modal-body main-new-workflow">
                                <Div class="button-box">
                                    @if ($data->stage == 0)
                                        <div class="progress-bars">
                                            <div class="bg-danger">Closed-Cancelled</div>
                                        </div>
                                        @else
                                            @if ($data->stage >= 1)
                                                <div class="active">
                                                    Opened
                                                </div>
                                            @else
                                                <div class="mini_buttons">Opened</div>
                                            @endif
                                            <div class="down-logo">
                                                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                    alt="..." class="w-100 h-100">
                                            </div>
                                            @if ($data->stage >= 2)
                                                <div class="active">
                                                    Audit Preparation
                                                </div>
                                            @else
                                                <div class="mini_buttons">
                                                    Audit Preparation
                                                </div>
                                            @endif
                                            <div class="down-logo">
                                                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                    alt="..." class="w-100 h-100">

                                            </div>
                                            @if ($data->stage >= 3)
                                                <div class="active">
                                                    Pending Audit
                                                </div>
                                            @else
                                                <div class="mini_buttons">
                                                    Pending Audit
                                                </div>
                                            @endif
                                            <div class="down-logo">
                                                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                    alt="..." class="w-100 h-100">

                                            </div>
                                            @if ($data->stage >= 4)
                                                <div class="active">
                                                    Pending Response

                                                </div>
                                            @else
                                                <div class="mini_buttons">
                                                    Pending Response

                                                </div>
                                            @endif
                                            <div class="down-logo">
                                                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                    alt="..." class="w-100 h-100">

                                            </div>

                                            @if ($data->stage >= 5)
                                                <div class="active">
                                                   CAPA Execution in Progress

                                                </div>
                                            @else
                                                <div class="mini_buttons">
                                                   CAPA Execution in Progress

                                                </div>
                                            @endif
                                            <div class="down-logo">
                                                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                    alt="..." class="w-100 h-100">

                                            </div>
                                            @if ($data->stage >= 6)
                                                <div class=" mini_buttons bg-danger">Closed - Done</div>
                                            @else
                                                <div class="mini_buttons">Closed - Done </div>
                                            @endif
                                    @endif
                                </Div>
                            </div>
                        </div>
                    </div>
                </div>
                







                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">Audit Preparation </div>
                            @else
                                <div class="">Audit Preparation</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Pending Audit</div>
                            @else
                                <div class="">Pending Audit</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">Pending Response</div>
                            @else
                                <div class="">Pending Response</div>
                            @endif
                            @if ($data->stage >= 5)
                                <div class="active">CAPA Execution in Progress</div>
                            @else
                                <div class="">CAPA Execution in Progress</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif





                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <div class="control-list">
            {{-- ------------------------------- --}}

            {{-- ======================================
                    DATA FIELDS
    ======================================= --}}

            @php
                $users = DB::table('users')->get();
            @endphp

            <div id="change-control-fields">
                <div class="container-fluid">

                    <!-- Tab links -->
                    <div class="cctab">
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Audit Planning</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Audit Preparation</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Audit Execution</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Audit Response & Closure</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
                    </div>

                    <form action="{{ route('updateExternalAudit', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="step-form">

                            <!-- General information content -->
                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                <input type="hidden" name="record_number">
                                                {{-- <div class="static">QMS-EMEA/IA/{{ Helpers::year($data->created_at) }}/{{ $data->record }}</div> --}}
                                                <input disabled type="text"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}/EA/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}">
                                                    
                                       
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input disabled type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}">
                                                {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                {{-- <div class="static">{{ $data->initiator_name }} </div> --}}
                                                <input disabled type="text" value="{{ $data->initiator_name }} ">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Date of Initiation</label>
                                                <input readonly type="text"
                                                    value="{{ Helpers::getdateFormat($data->intiation_date) }}"
                                                    name="intiation_date"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Assigned to">Assigned to</label>
                                                <select name="assign_to"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->assign_to == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="due-date">Due Date <span class="text-danger"></span></label>
                                                <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div>
                                                <input readonly type="text"
                                                    value="{{ Helpers::getdateFormat($data->due_date) }}"
                                                    name="due_date"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                            </div>
                                        </div> -->

                                        
                                        <div class="col-md-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="due-date">Due Date <span class="text-danger"></span></label>
                                                <p class="text-primary">Last date this record should be closed by</p>
                                                <div class="calenderauditee">
                                                    <input type="text" id="due_date_display" readonly
                                                        placeholder="DD-MM-YYYY"
                                                        value="{{ Helpers::getdateFormat($data->due_date) }}" />
                                                    <input type="date" id="due_date" name="due_date"
                                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        class="hide-input" value="{{ $data->due_date }}"
                                                        oninput="handleDateInput(this, 'due_date_display')"
                                                        {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} />
                                                </div>
                                            </div>
                                        </div>

                                        {{-- javascript for due date --}}
                                        <script>
                                            function handleDateInput(dateInput, displayId) {
                                                const displayElement = document.getElementById(displayId);
                                                if (displayElement) {
                                                    const dateValue = new Date(dateInput.value);
                                                    const options = {
                                                        year: 'numeric',
                                                        month: 'short',
                                                        day: '2-digit'
                                                    };
                                                    displayElement.value = dateValue.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                                                }
                                            }
                                        </script>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group"><b>Initiator Group</b></label>
                                                <select name="Initiator_Group" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                     id="initiator_group">
                                                    <option value="CQA"
                                                        @if ($data->Initiator_Group == 'CQA') selected @endif>Corporate
                                                        Quality Assurance</option>
                                                    <option value="QAB"
                                                        @if ($data->Initiator_Group == 'QAB') selected @endif>Quality
                                                        Assurance Biopharma</option>
                                                    <option value="CQC"
                                                        @if ($data->Initiator_Group == 'CQC') selected @endif>Central
                                                        Quality Control</option>
                                                    <option value="MANU"
                                                        @if ($data->Initiator_Group == 'MANU') selected @endif>Manufacturing
                                                    </option>
                                                    <option value="PSG"
                                                        @if ($data->Initiator_Group == 'PSG') selected @endif>Plasma
                                                        Sourcing Group</option>
                                                    <option value="CS"
                                                        @if ($data->Initiator_Group == 'CS') selected @endif>Central
                                                        Stores</option>
                                                    <option value="ITG"
                                                        @if ($data->Initiator_Group == 'ITG') selected @endif>Information
                                                        Technology Group</option>
                                                    <option value="MM"
                                                        @if ($data->Initiator_Group == 'MM') selected @endif>Molecular
                                                        Medicine</option>
                                                    <option value="CL"
                                                        @if ($data->Initiator_Group == 'CL') selected @endif>Central
                                                        Laboratory</option>
                                                    <option value="TT"
                                                        @if ($data->Initiator_Group == 'TT') selected @endif>Tech
                                                        team</option>
                                                    <option value="QA"
                                                        @if ($data->Initiator_Group == 'QA') selected @endif>Quality
                                                        Assurance</option>
                                                    <option value="QM"
                                                        @if ($data->Initiator_Group == 'QM') selected @endif>Quality
                                                        Management</option>
                                                    <option value="IA"
                                                        @if ($data->Initiator_Group == 'IA') selected @endif>IT
                                                        Administration</option>
                                                    <option value="ACC"
                                                        @if ($data->Initiator_Group == 'ACC') selected @endif>Accounting
                                                    </option>
                                                    <option value="LOG"
                                                        @if ($data->Initiator_Group == 'LOG') selected @endif>Logistics
                                                    </option>
                                                    <option value="SM"
                                                        @if ($data->Initiator_Group == 'SM') selected @endif>Senior
                                                        Management</option>
                                                    <option value="BA"
                                                        @if ($data->Initiator_Group == 'BA') selected @endif>Business
                                                        Administration</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group Code">Initiator Group Code</label>
                                                <input type="text" name="initiator_group_code"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                    value="{{ $data->Initiator_Group }}" id="initiator_group_code"
                                                    readonly>

                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description <span
                                                        class="text-danger">*</span></label>
                                                        <div><small class="text-primary">Please mention brief summary</small></div>
                                                <textarea name="short_description" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                            </div>
                                        </div> --}}
                                        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="short_description">Short Description<span class="text-danger">*</span></label>
                                                <span id="rchars">255</span> characters remaining
                                                <div class="relative-container">
                                                    <input name="short_description"  id="short_description"  type="text"  maxlength="255"  value="{{ $data->short_description }}" 
                                                        required 
                                                        {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }} >
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 8])
                                                        @endcomponent
                                                </div>   
                                              
                                            </div>
                                            <p id="docnameError" style="color:red">**Short Description is required</p>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="severity-level">Severity Level</label>
                                                <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="severity_level">
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->severity_level == 'minor') selected @endif
                                                     value="minor">Minor</option>
                                                    <option  @if ($data->severity_level == 'major') selected @endif 
                                                    value="major">Major</option>
                                                    <option @if ($data->severity_level == 'critical') selected @endif
                                                    value="critical">Critical</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group">Initiated Through</label>
                                                <div><small class="text-primary">Please select related information</small></div>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="initiated_through"
                                                    onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                                    <option value="">-- select --</option>
                                                    <option @if ($data->initiated_through == 'recall') selected @endif
                                                        value="recall">Recall</option>
                                                    <option @if ($data->initiated_through == 'return') selected @endif
                                                        value="return">Return</option>
                                                    <option @if ($data->initiated_through == 'deviation') selected @endif
                                                        value="deviation">Deviation</option>
                                                    <option @if ($data->initiated_through == 'complaint') selected @endif
                                                        value="complaint">Complaint</option>
                                                    <option @if ($data->initiated_through == 'regulatory') selected @endif
                                                        value="regulatory">Regulatory</option>
                                                    <option @if ($data->initiated_through == 'lab-incident') selected @endif
                                                        value="lab-incident">Lab Incident</option>
                                                    <option @if ($data->initiated_through == 'improvement') selected @endif
                                                        value="improvement">Improvement</option>
                                                    <option @if ($data->initiated_through == 'others') selected @endif
                                                        value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input" id="initiated_through_req">
                                                <label for="If Other">Others<span
                                                        class="text-danger d-none">*</span></label>
                                                        <div class="relative-container">       
                                                            <textarea {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="initiated_if_other">{{$data->initiated_if_other}}</textarea>
                                                      
                                                            @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                            @endcomponent
                                                        </div>   
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="repeat">Repeat</label>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="repeat"
                                                    onchange="otherController(this.value, 'yes', 'repeat_nature')">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option  @if ($data->repeat == 'Yes') selected @endif value="Yes">Yes</option>
                                                    <option  @if ($data->repeat == 'No') selected @endif value="No">No</option>
                                                    <option  @if ($data->repeat == 'NA') selected @endif value="NA">NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input" id="repeat_nature">
                                                <label for="repeat_nature">Repeat Nature<span
                                                        class="text-danger d-none">*</span></label>
                                                <textarea {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="repeat_nature">{{$data->repeat_nature}}</textarea>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group">Type of Audit</label>
                                                <select name="audit_type"
                                                    onchange="otherController(this.value, 'others', 'if_other')"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <option>Enter Your Selection Here</option>

                                                    <option value="R&D"
                                                        @if ($data->audit_type == 'R&D') selected @endif>R&D
                                                    </option>
                                                    <option value="GLP"
                                                        @if ($data->audit_type == 'GLP') selected @endif>GLP
                                                    </option>
                                                    <option value="GCP"
                                                        @if ($data->audit_type == 'GCP') selected @endif>GCP
                                                    </option>
                                                    <option value="GDP"
                                                        @if ($data->audit_type == 'GDP') selected @endif>GDP
                                                    </option>
                                                    <option value="GEP"
                                                        @if ($data->audit_type == 'GEP') selected @endif>GEP
                                                    </option>
                                                    <option value="ISO 17025"
                                                        @if ($data->audit_type == 'ISO 17025') selected @endif>ISO 17025
                                                    </option>
                                                    <option value="others"
                                                        @if ($data->audit_type == 'others') selected @endif>Others
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input" id="if_other">
                                                <label for="If Other">If Other<span
                                                        class="text-danger d-none">*</span></label>
                                                        <div class="relative-container">        
                                                            <textarea name="if_other" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->if_other }}</textarea>
                                                            @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                            @endcomponent
                                                         </div>   
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="external_agencies">External Agencies</label>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="external_agencies">
                                                    <option value="">-- Select --</option>
                                                    <option @if ($data->external_agencies == 'jordan_fda') selected @endif
                                                         value="jordan_fda">Jordan FDA</option>
                                                    <option @if ($data->external_agencies == 'us_fda') selected @endif 
                                                         value="us_fda">USFDA</option>
                                                    <option @if ($data->external_agencies == 'mhra') selected @endif
                                                         value="mhra">MHRA</option>
                                                    <option @if ($data->external_agencies == 'anvisa') selected @endif
                                                         value="anvisa">ANVISA</option>
                                                    <option @if ($data->external_agencies == 'iso') selected @endif
                                                         value="iso">ISO</option>
                                                    <option @if ($data->external_agencies == 'who') selected @endif
                                                         value="who">WHO</option>
                                                    <option @if ($data->external_agencies == 'local_fda') selected @endif
                                                         value="local_fda">Local FDA</option>
                                                    <option @if ($data->external_agencies == 'tga') selected @endif
                                                         value="tga">TGA</option>
                                                    <option value="others"
                                                     @if ($data->external_agencies == 'others') selected @endif>Others
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="others">Others<span
                                                    class="text-danger d-none">*</span></label>
                                                    <div class="relative-container">
                                                            <textarea name="others" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->others}}</textarea>
                                                            @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                        @endcomponent
                                                     </div>   
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Initial Comments">Description</label>
                                                     <div class="relative-container">
                                                        <textarea name="initial_comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->initial_comments }}</textarea>
                                                        @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                    @endcomponent
                                                    </div>   
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Inv Attachments">Initial Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div disabled class="file-attachment-list" id="inv_attachment">
                                                        @if ($data->inv_attachment)
                                                        @foreach(json_decode($data->inv_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                        </h6>
                                                   @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="inv_attachment[]"
                                                            oninput="addMultipleFiles(this, 'inv_attachment1')"
                                                            multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Planning content -->
                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Audit Schedule Start Date">Audit Schedule Start Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="start_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->start_date) }}"
                                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}/>
                                                    <input type="date" id="start_date_checkdate" name="start_date"min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->start_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input  input-date">
                                                <label for="Audit Schedule End Date">Audit Schedule End Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="end_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->end_date) }}"
                                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}/>
                                                    <input type="date" id="end_date_checkdate" name="end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->end_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="audit-agenda-grid">
                                                    Audit Agenda<button type="button" name="audit-agenda-grid"
                                                        onclick="addAuditAgenda('audit-agenda-grid')"
                                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</button>
                                                </label>
                                                <table class="table table-bordered" id="audit-agenda-grid">
                                                    <thead>
                                                        <tr>
                                                            <th>Row #</th>
                                                            <th>Area of Audit</th>
                                                            <th>Scheduled Start Date</th>
                                                            <th>Scheduled Start Time</th>
                                                            <th>Scheduled End Date</th>
                                                            <th>Scheduled End Time</th>
                                                            <th>Auditor</th>
                                                            <th>Auditee</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($grid_data->start_date)
                                                        @foreach (unserialize($grid_data->start_date) as $key => $temps)
                                                        <tr>
                                                            <td><input disabled type="text" name="serial_number[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                                    value="{{ $key + 1 }}"></td>

                                                            <td><input type="text" name="audit[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                                    value="{{ unserialize($grid_data->area_of_audit)[$key] ? unserialize($grid_data->area_of_audit)[$key] : '' }}">
                                                            </td>
 
                                                            <td><div class="group-input new-date-data-field mb-0">
                                                                <div class="input-date ">
                                                              <div class="calenderauditee">
                                                                <input type="text" class="test" id="scheduled_start_date{{$key}}" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat(unserialize($grid_data->start_date)[$key]) }}" />
                                                                <input type="date"  id="schedule_start_date{{$key}}_checkdate" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="scheduled_start_date[]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ unserialize($grid_data->start_date)[$key] }}" class="hide-input" 
                                                                oninput="handleDateInput(this, `scheduled_start_date{{$key}}`);checkDate('schedule_start_date{{$key}}_checkdate','schedule_end_date{{$key}}_checkdate')" /></div></div></div></td>
                                                           
                                                                <td><input type="time" name="scheduled_start_time[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} 
                                                                    value="{{ unserialize($grid_data->start_time)[$key] ? unserialize($grid_data->start_time)[$key] : '' }}">
                                                            </td>
                                                             
                                                            <td><div class="group-input new-date-data-field mb-0">
                                                                <div class="input-date ">
                                                                    <div class="calenderauditee">
                                                                <input type="text" class="test" id="scheduled_end_date{{$key}}" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat(unserialize($grid_data->end_date)[$key]) }}" />
                                                                <input type="date" id="schedule_end_date{{$key}}_checkdate" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="scheduled_end_date[]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ unserialize($grid_data->end_date)[$key]}}" class="hide-input" 
                                                                oninput="handleDateInput(this, `scheduled_end_date{{$key}}`);checkDate('schedule_start_date{{$key}}_checkdate','schedule_end_date{{$key}}_checkdate')" /></div></div></div></td> 
                                                            
                                                           
                                                            
                                                            <td><input type="time" name="scheduled_end_time[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                                    value="{{ unserialize($grid_data->end_time)[$key] ? unserialize($grid_data->end_time)[$key] : '' }}">
                                                            </td>
                                                            <td> <select id="select-state" placeholder="Select..."
                                                                name="auditor[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                                <option value="">-Select-</option>
                                                                @foreach ($users as $value)
                                                                    <option
                                                                        {{ unserialize($grid_data->auditor)[$key] ? (unserialize($grid_data->auditor)[$key] == $value->id ? 'selected' : ' ') : '' }}
                                                                        value="{{ $value->id }}">
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select></td>
                                                            <td> <select id="select-state" placeholder="Select..."
                                                                name="auditee[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                                <option value="">-Select-</option>
                                                                @foreach ($users as $value)
                                                                    <option
                                                                        {{ unserialize($grid_data->auditee)[$key] ? (unserialize($grid_data->auditee)[$key] == $value->id ? 'selected' : ' ') : '' }}
                                                                        value="{{ $value->id }}">
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select></td>

                                                            <td><input type="text" name="remark[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                                value="{{ unserialize($grid_data->remark)[$key] ? unserialize($grid_data->remark)[$key] : '' }}">
                                                        </td>

                                                        </tr>
                                                    @endforeach
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                       
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Product/Material Name">Product/Material Name</label>
                                                        <div class="relative-container">
                                                            <input type="text" name="material_name"
                                                                value="{{ $data->material_name }}"
                                                            {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                            @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                    @endcomponent
                                                         </div>   
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments(If Any)">Comments(If Any)</label>
                                                <div class="relative-container">
                                                    <textarea name="if_comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->if_comments }}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                @endcomponent
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Preparation content -->
                            <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Lead Auditor">Lead Auditor</label>
                                                <select name="lead_auditor"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->lead_auditor == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="File Attachments">File Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div disabled  class="file-attachment-list" id="file_attachment">
                                                        @if ($data->file_attachment)
                                                            @foreach(json_decode($data->file_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                    <div  class="add-btn">
                                                        <div>Add</div>
                                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="file_attachment[]"
                                                         oninput="addMultipleFiles(this, 'file_attachment')"
                                                            multiple>
                                                    </div>
                                                </div>
                                                {{-- <input type="file" id="myfile" name="file_attachment"
                                                    value="{{ $data->file_attachment }}" --}}
                                                    {{-- {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="audit-agenda-grid">
                                                    Observation Details
                                                    <button type="button" name="audit-agenda-grid"
                                                      id="ObservationAdd">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#observation-field-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="onservation-field-table"
                                                        style="width: 150%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Row#</th>
                                                                <th>Observation ID</th>
                                                                <th>Date</th>
                                                                <th>Auditor</th>
                                                                <th>Auditee</th>
                                                                <th>Observation Description</th>
                                                                <th>Severity Level</th>
                                                                <th>Area/process</th>
                                                                <th>Observation Category</th>
                                                                <th>CAPA Required</th>
                                                                <th>Auditee Response</th>
                                                                <th>Auditor Review on Response</th>
                                                                <th>QA Comments</th>
                                                                <th>CAPA Details</th>
                                                                <th>CAPA Due Date</th>
                                                                <th>CAPA Owner</th>
                                                                <th>Action Taken</th>
                                                                <th>CAPA Completion Date</th>
                                                                <th>Status</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="observationDetail">
                                                            @if ($grid_data1->observation_id)
                                                            @foreach (unserialize($grid_data1->observation_id) as $key => $tempData)
                                                            <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td><input type="text" name="observation_id[]" value="{{ $tempData ? $tempData : "" }}"></td>
                                                                    <td><input type="date" name="date[]" value="{{unserialize($grid_data1->date)[$key] ? unserialize($grid_data1->date)[$key]: "" }}"></td>
                                                                <td>
                                                                    <select placeholder="Select..." name="auditorG[]">
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $datas)
                                                                            <option value="{{ $datas->id }}">

                                                                                {{ $datas->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select placeholder="Select..." name="auditeeG[]">
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $datas)
                                                                            <option value="{{ $datas->id }}">

                                                                                {{ $datas->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>                                                            <td><input type="text" name="observation_description[]" value="{{unserialize($grid_data1->observation_description)[$key] ? unserialize($grid_data1->observation_description)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="severity_level[]" value="{{unserialize($grid_data1->severity_level)[$key] ? unserialize($grid_data1->severity_level)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="area[]" value="{{unserialize($grid_data1->area)[$key] ? unserialize($grid_data1->area)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observation_category[]" value="{{unserialize($grid_data1->observation_category)[$key] ? unserialize($grid_data1->observation_category)[$key]: "" }}"></td>
                                                                    <td>
                                                                        <select name="capa_required[]">
                                                                            <option value="0">-- Select --</option>
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" name="auditee_response[]" value="{{unserialize($grid_data1->auditee_response)[$key] ? unserialize($grid_data1->auditee_response)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="auditor_review_on_response[]" value="{{unserialize($grid_data1->auditor_review_on_response)[$key] ? unserialize($grid_data1->auditor_review_on_response)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="qa_comment[]" value="{{unserialize($grid_data1->qa_comment)[$key] ? unserialize($grid_data1->qa_comment)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="capa_details[]" value="{{unserialize($grid_data1->capa_details)[$key] ? unserialize($grid_data1->capa_details)[$key]: "" }}"></td>
                                                                    <td><input type="date" name="capa_due_date[]" value="{{unserialize($grid_data1->capa_due_date)[$key] ? unserialize($grid_data1->capa_due_date)[$key]: "" }}"></td>
                                                                    <td>
                                                                        <select placeholder="Select..." name="capa_owner[]">
                                                                            <option value="">Select a value</option>
                                                                            @foreach ($users as $datas)
                                                                                <option value="{{ $datas->id }}">
                                                                                    {{ $datas->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" name="action_taken[]" value="{{unserialize($grid_data1->action_taken)[$key] ? unserialize($grid_data1->action_taken)[$key]: "" }}"></td>
                                                                    <td><input type="date" name="capa_completion_date[]" value="{{unserialize($grid_data1->capa_completion_date)[$key] ? unserialize($grid_data1->capa_completion_date)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="status_Observation[]" value="{{unserialize($grid_data1->status)[$key] ? unserialize($grid_data1->status)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="remark_observation[]" value="{{unserialize($grid_data1->remark)[$key] ? unserialize($grid_data1->remark)[$key]: "" }}"></td>
                                                                </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Audit Team">Audit Team</label>
                                                <select multiple name="Audit_team[]" placeholder="Select Audit Team"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="Audit"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <!-- @foreach ($users as $user)
                                                        <option value="{{ $user->name }}"
                                                            {{ in_array($user->name, explode(',', $data->Audit_team)) ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach -->

                                                    @if ($users->isNotEmpty())
                                                        @foreach ($users as $value)
                                                            <option 
                                                                {{ in_array($value->name, (array) old('Audit_team', explode(',', $data->Audit_team))) ? 'selected' : '' }} 
                                                                value="{{ $value->name }}">
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Auditee">Auditee</label>
                                                <select multiple name="Auditee[]" placeholder="Select Auditee"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="Auditee"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <!-- @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ in_array($user->id, explode(',', $data->Auditee)) ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach -->

                                                    @if ($users->isNotEmpty())
                                                        @foreach ($users as $value)
                                                            <option 
                                                                {{ in_array($value->name, (array) old('Auditee', explode(',', $data->Auditee))) ? 'selected' : '' }} 
                                                                value="{{ $value->name }}">
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="External Auditor Details">External Auditor Details</label>
                                                <div class="relative-container">
                                                    <textarea name="Auditor_Details" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Auditor_Details }}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                            @endcomponent
                                                </div>      
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="External Auditing Agency">External Auditing Agency</label>
                                                <div class="relative-container">
                                                    <textarea name="External_Auditing_Agency" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->External_Auditing_Agency }}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                            @endcomponent
                                                         </div>   
                                                </div>   
                                                </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Relevant Guidelines / Industry Standards">Relevant Guidelines / Industry Standards</label>
                                                <div class="relative-container">
                                                    <textarea name="Relevant_Guidelines" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Relevant_Guidelines}}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                            @endcomponent
                                                    </div>   
                                                </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="QA Comments">QA Comments</label>
                                                 <div class="relative-container">
                                                    <textarea name="QA_Comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->QA_Comments}}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                            @endcomponent
                                                         </div>       
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Guideline Attachment">Guideline Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div disabled  class="file-attachment-list" id="file_attachment_guideline">
                                                        @if ($data->file_attachment_guideline)
                                                            @foreach(json_decode($data->file_attachment_guideline) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                    <div  class="add-btn">
                                                        <div>Add</div>
                                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="file_attachment_guideline[]"
                                                            oninput="addMultipleFiles(this, 'file_attachment_guideline')"
                                                            multiple>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Audit Category">Audit Category</label>
                                                <select name="Audit_Category" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->Audit_Category == 'Internal Audit/Self Inspection') selected @endif
                                                         value="Internal Audit/Self Inspection">Internal Audit/Self Inspection</option>
                                                    <option  @if ($data->Audit_Category == 'Supplier Audit') selected @endif
                                                         value="Supplier Audit">Supplier Audit</option>
                                                    <option @if ($data->Audit_Category == 'Regulatory Audit') selected @endif
                                                         value="Regulatory Audit">Regulatory Audit</option>
                                                    <option @if ($data->Audit_Category == 'Consultant Audit') selected @endif
                                                         value="Consultant Audit">Consultant Audit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Supplier/Vendor/Manufacturer Details">Supplier/Vendor/Manufacturer Details</label>
                                                <div class="relative-container">
                                                    <textarea type="text" name="Supplier_Details" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Supplier_Details}}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                @endcomponent
                                                 </div>   
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Supplier/Vendor/Manufacturer Site">Supplier/Vendor/Manufacturer Site</label>
                                                <div class="relative-container">
                                                    <textarea type="text" name="Supplier_Site" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Supplier_Site}}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                @endcomponent
                                                         </div>   
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Comments</label>
                                                <div class="relative-container">
                                                    <textarea name="Comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Comments }}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                @endcomponent
                                                         </div>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Execution content -->
                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Due Date">Due Date</label>
                                                <input type="hidden" name="due_date" value="{{ $data->due_date }}">
                                                <div class="static">{{ $data->due_date }}</div>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Audit Start Date">Audit Start Date</label>
                                                    <div class="calenderauditee">                                     
                                                        <input type="text"  id="audit_start_date"  readonly placeholder="DD-MMM-YYYY"  value="{{ Helpers::getdateFormat($data->audit_start_date) }}"
                                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} />
                                                        <input type="date" id="audit_start_date_checkdate" name="audit_start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->audit_start_date }}"
                                                        class="hide-input"
                                                        oninput="handleDateInput(this, 'audit_start_date');checkDate('audit_start_date_checkdate','audit_end_date_checkdate')"/>
                                                    </div>    
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Audit End Date">Audit End Date</label>
                                                    <div class="calenderauditee">                                     
                                                    <input type="text"  id="audit_end_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->audit_end_date) }}"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} />
                                                    <input type="date" id="audit_end_date_checkdate" name="audit_end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->audit_end_date }}"
                                                    class="hide-input"
                                                    oninput="handleDateInput(this, 'audit_end_date');checkDate('audit_start_date_checkdate','audit_end_date_checkdate')"/>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="audit-agenda-grid">
                                                    Observation Details
                                                    <button type="button" name="audit-agenda-grid"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                      id="ObservationAdd">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#observation-field-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="onservation-field-table"
                                                        style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Row#</th>
                                                                <th>Observation Details</th>
                                                               
                                                                <th>Pre Comments</th>
                                                           
                                                                 <th>CAPA Details if any</th>
                                                               
                                                                <th>Post Comments</th>
                                                              
                                                            </tr>
                                                        </thead>
                                                        <tbody id="observationDetail">
                                                            @if ($grid_data1->observation_id)
                                                            @foreach (unserialize($grid_data1->observation_id) as $key => $tempData)
                                                            <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td><input type="text" name="observation_id[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $tempData ? $tempData : "" }}"></td>
                                                                    {{-- <td><input type="date" name="date[]" value="{{unserialize($grid_data1->date)[$key] ? unserialize($grid_data1->date)[$key]: "" }}"></td> --}}
                                                                {{-- <td> <div class="group-input new-date-data-field mb-0">
                                                                        <div class="input-date "><div class="calenderauditee">
                                                                        <input type="text" id="date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->date) }}"/>
                                                                        <input type="date" name="date[]" value="{{ $data->date }}" class="hide-input" 
                                                                        oninput="handleDateInput(this, `date' + serialNumber +'`)" /></div></div></div></td>
                                                                <td> --}}
                                                                    {{-- <select placeholder="Select..." name="auditorG[]">
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $datas)
                                                                            <option value="{{ $datas->id }}">

                                                                                {{ $datas->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select placeholder="Select..." name="auditeeG[]">
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $datas)
                                                                            <option value="{{ $datas->id }}">

                                                                                {{ $datas->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td> --}}
                                                                    <td><input type="text" name="observation_description[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($grid_data1->observation_description)[$key] ? unserialize($grid_data1->observation_description)[$key]: "" }}"></td> 
                                                                    {{-- <td><input type="text" name="severity_level[]" value="{{unserialize($grid_data1->severity_level)[$key] ? unserialize($grid_data1->severity_level)[$key]: "" }}"></td> --}}
                                                                     <td><input type="text" name="area[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($grid_data1->area)[$key] ? unserialize($grid_data1->area)[$key]: "" }}"></td>
                                                                    {{-- <td><input type="text" name="observation_category[]" value="{{unserialize($grid_data1->observation_category)[$key] ? unserialize($grid_data1->observation_category)[$key]: "" }}"></td>
                                                                    <td>
                                                                        <select name="capa_required[]">
                                                                            <option value="0">-- Select --</option>
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </td> --}}
                                                                    <td><input type="text" name="auditee_response[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($grid_data1->auditee_response)[$key] ? unserialize($grid_data1->auditee_response)[$key]: "" }}"></td>
                                                                    {{-- <td><input type="text" name="auditor_review_on_response[]" value="{{unserialize($grid_data1->auditor_review_on_response)[$key] ? unserialize($grid_data1->auditor_review_on_response)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="qa_comment[]" value="{{unserialize($grid_data1->qa_comment)[$key] ? unserialize($grid_data1->qa_comment)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="capa_details[]" value="{{unserialize($grid_data1->capa_details)[$key] ? unserialize($grid_data1->capa_details)[$key]: "" }}"></td>
                                                                    {{-- <td><input type="date" name="capa_due_date[]" value="{{unserialize($grid_data1->capa_due_date)[$key] ? unserialize($grid_data1->capa_due_date)[$key]: "" }}"></td> --}}
                                                                    {{-- <td><div class="group-input new-date-data-field mb-0">
                                                                        <div class="input-date "><div class="calenderauditee">
                                                                        <input type="text" id="capa_due_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->capa_due_date) }}"/>
                                                                        <input type="date" name="capa_due_date[]" value="{{ $data->capa_due_date }}" class="hide-input" 
                                                                        oninput="handleDateInput(this, `capa_due_date' + serialNumber +'`)" /></div></div></div></td>
                                                                    <td>
                                                                        <select placeholder="Select..." name="capa_owner[]">
                                                                            <option value="">Select a value</option>
                                                                            @foreach ($users as $datas)
                                                                                <option value="{{ $datas->id }}">
                                                                                    {{ $datas->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" name="action_taken[]" value="{{unserialize($grid_data1->action_taken)[$key] ? unserialize($grid_data1->action_taken)[$key]: "" }}"></td> --}}
                                                                    {{-- <td><input type="date" name="capa_completion_date[]" value="{{unserialize($grid_data1->capa_completion_date)[$key] ? unserialize($grid_data1->capa_completion_date)[$key]: "" }}"></td> --}}
                                                                    {{-- <td><div class="group-input new-date-data-field mb-0">
                                                                        <div class="input-date "><div class="calenderauditee">
                                                                        <input type="text" id="capa_completion_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY"value="{{ Helpers::getdateFormat($data->capa_completion_date) }}"/>
                                                                        <input type="date" name="capa_completion_date[]" value="{{ $data->capa_completion_date }}" class="hide-input" 
                                                                        oninput="handleDateInput(this, `capa_completion_date' + serialNumber +'`)" /></div></div></div></td>
                                                                    <td><input type="text" name="status_Observation[]" value="{{unserialize($grid_data1->status)[$key] ? unserialize($grid_data1->status)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="remark_observation[]" value="{{unserialize($grid_data1->remark)[$key] ? unserialize($grid_data1->remark)[$key]: "" }}"></td> --}} 
                                                         </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Audit Attachments">Audit Attachments</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                {{-- <input type="file" id="myfile" name="Audit_file"
                                                    value="{{ $data->Audit_file }}"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Audit_file">
                                                            @if ($data->Audit_file)
                                                            @foreach(json_decode($data->Audit_file) as $file)
                                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                       @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Audit_file[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                                oninput="addMultipleFiles(this, 'Audit_file')" multiple>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Audit Comments">Audit Comments</label>
                                                <div class="relative-container">
                                                    <textarea name="Audit_Comments1" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Audit_Comments1 }}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                @endcomponent
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Response & Closure content -->
                            <div id="CCForm5" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">
                                            Audit Response
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Remarks">Remarks</label>
                                                <div class="relative-container">
                                                    <textarea name="Remarks" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Remarks }}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                @endcomponent
                                                 </div>   
                                            </div>
                                        </div>

                                        <!-- <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Reference Recores">Reference Record</label>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} multiple id="reference_record" name="refrence_record[]" id="">
                                                    {{-- <option value="">--Select---</option> --}}
                                                    @foreach ($old_record as $new)
                                                        <option value="{{ $new->id }}"  {{ in_array($new->id, explode(',', $data->Reference_Recores1)) ? 'selected' : '' }}>
                                                            {{ Helpers::getDivisionName($new->division_id) }}/IA/{{date('Y')}}/{{ Helpers::recordFormat($new->record) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                   
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="Reference Recores">Reference Record</label>
                                            <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                multiple id="reference_record" name="refrence_record[]" id="">

                                            @if (!empty($old_record))
                                                @foreach ($old_record as $new)
                                                    @php
                                                    
                                                        $recordValue =
                                                            Helpers::getDivisionName($new->division_id) .
                                                            '/EA/' .
                                                            date('Y') .
                                                            '/' .
                                                            Helpers::recordFormat($new->record);

                                                            
                                                        $selected = in_array(
                                                            $recordValue,
                                                            explode(',', $data->Reference_Recores1),
                                                        )
                                                            ? 'selected'
                                                            : '';
                                                         //  dd($recordValue);
                                                    @endphp
                                                    <option value="{{ $recordValue }}" {{ $selected }}>
                                                        {{ $recordValue }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                </div> 


                                <!-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Reference Recores">Reference Record</label>
                                        <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} 
                                            multiple id="reference_record" name="refrence_record[]">

                                            @if (!empty($old_record))
                                                @foreach ($old_record as $new)
                                                    @php
                                                        $recordValue = Helpers::getDivisionName($new->division_id) . '/EA/' . date('Y') . '/' . Helpers::recordFormat($new->record);
                                                        $selected = in_array(trim($recordValue), array_map('trim', explode(',', $data->Reference_Recores1))) ? 'selected' : '';
                                                    @endphp
                                                    <option value="{{ $recordValue }}" {{ $selected }}>{{ $recordValue }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> -->





                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Report Attachments">Report Attachments</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                {{-- <input type="file" id="myfile" name="report_file"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="report_attachment">
                                                            @if ($data->report_file)
                                                            @foreach(json_decode($data->report_file) as $file)
                                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                       @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input  {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="report_file[]"
                                                                oninput="addMultipleFiles(this, 'report_attachment')" multiple>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Audit Attachments">Audit Attachments</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                {{-- <input type="file" id="myfile" name="myfile"
                                                    value="{{ $data->myfile }}"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="audit_attachment">
                                                            @if ($data->myfile)
                                                            @foreach(json_decode($data->myfile) as $file)
                                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                       @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input  {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="myfile[]"
                                                                oninput="addMultipleFiles(this, 'audit_attachment')" multiple>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Audit Comments">Audit Comments</label>
                                                <div class="relative-container">
                                                    <textarea name="Audit_Comments2" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Audit_Comments2 }}</textarea>
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                                @endcomponent
                                                         </div>   
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="due_date_extension">Due Date Extension Justification</label>
                                                <div class="relative-container">
                                                        <div><small class="text-primary">Please Mention justification if due date is crossed</small></div>
                                                    <textarea name="due_date_extension"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{$data->due_date_extension}}</textarea>

                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 6])
                                                            @endcomponent
                                                         </div>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Log content -->
                    <div id="CCForm6" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                       
                        <div class="sub-head">Activity Log</div>

                        <div class="d-flex align-item-end justify-content-end">
                        {{-- <a href="route('rcms/calibrationActivityLog')">
                                <button class="button_theme1" id="printButton" style="margin-bottom:20px;">Print </a></button> --}}
                                {{-- <button id="printButton" class="btn btn-primary">Print PDF</button> --}}

                                <button style="margin-bottom:20px;" class="button_theme1"> <a
                                        class="text-white"
                                        href="{{ url('rcms/activitylogPrint', $data->id) }}"> Print </a>
                                </button>
                        </div>


                        <div class="printable-content">
                            {{-- <div class="row">
                                <h5>
                                    <strong>Submit By:</strong> {{ $data->submit_by }}
                                    &nbsp;&nbsp;&nbsp;
                                    <strong>Date of Initiation:</strong>
                                </h5>
                            </div> --}}

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <!-- Row for Initiate Calibration By and Initiate Calibration On -->
                                    <tr>
                                        <td>
                                            <strong>Audit Schedule By :</strong><br>
                                            {{ $data->audit_schedule_by ?? 'Not Applicable' }}
                                        </td>
                                        <td>
                                            <strong>Audit Schedule On :</strong><br>
                                            {{$data->audit_schedule_on  ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <strong>Audit Schedule Comment :</strong><br>
                                            {{ $ $data->audit_schedule_on_comment ?? 'Not Applicable'}}
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <strong>Cancelled By:</strong><br>
                                            {{ $data->cancelled_by ?? 'Not Applicable' }}
                                        </td>
                                        <td>
                                            <strong>Cancelled On:</strong><br>
                                            {{  $data->cancelled_on ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <strong>Cancelled Comment:</strong><br>
                                            {{  $data->cancel_1 ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Complete Audit Preparation By :</strong><br>
                                            {{ $data->audit_preparation_completed_by ?? 'Not Applicable' }}
                                        </td>
                                        <td>
                                            <strong>Complete Audit Preparation On :</strong><br>
                                            {{ $data->audit_preparation_completed_on ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <strong>Complete Audit Preparation Comment :</strong><br>
                                            {{ $data->audit_preparation_completed_on_comment ?? 'Not Applicable' }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <strong>Reject By :</strong><br>
                                            {{  $data->rejected_by ?? 'Not Applicable'}}
                                        </td>
                                        <td>
                                            <strong>Reject On :</strong><br>
                                            {{$data->rejected_on ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <strong>Reject Comment :</strong><br>
                                            {{ $data->reject_data ?? 'Not Applicable' }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <strong>Issue Report By :</strong><br>
                                            {{  $data->audit_mgr_more_info_reqd_by ?? 'Not Applicable' }}
                                        </td>
                                        <td>
                                            <strong>Issue Report On :</strong><br>
                                            {{ $data->audit_mgr_more_info_reqd_on ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <strong>Issue Report Comment :</strong><br>
                                            {{ $data->audit_mgr_more_info_reqd_on_comment ?? 'Not Applicable' }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <strong>Reject By :</strong><br>
                                            {{ $data->rejected_by_2 ?? 'Not Applicable' }}
                                        </td>
                                        <td>
                                            <strong>Reject On :</strong><br>
                                            {{ $data->rejected_on_2 ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <strong>Reject Comment :</strong><br>
                                            {{  $data->reject_data_1 ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>CAPA Plan Proposed By :</strong><br>
                                            {{ $data->audit_observation_submitted_by ?? 'Not Applicable' }}
                                        </td>
                                        <td>
                                            <strong>CAPA Plan Proposed On :</strong><br>
                                            {{ $data->audit_observation_submitted_on ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <strong>CAPA Plan Comment :</strong><br>
                                            {{ $data->audit_observation_submitted_on_comment ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>All CAPA Closed By :</strong><br>
                                            {{ $data->response_feedback_verified_by }}
                                        </td>
                                        <td>
                                            <strong>All CAPA Closed On :</strong><br>
                                            {{ $data->response_close_done }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <strong>All CAPA Closed Comment :</strong><br>
                                            {{ $data->audit_mgr_more_info_reqd_on_comment ?? 'Not Applicable' }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                                      

                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="submit"
                                            {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Submit</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
            <div class="modal fade" id="child-modal1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('extension_child', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            {{-- <div class="modal-body">
                                <div class="group-input">
                                    <label for="major">
                                        <input type="hidden" name="parent_name" value="External_audit">
                                        <input type="hidden" name="due_date" value="{{ $data->due_date }}">
                                        <input type="radio" name="child_type" value="extension">
                                        extension
                                    </label>

                                </div>

                            </div> --}}

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


            <div class="modal fade" id="signature-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('externalAuditStateChange', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment" required>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="rejection-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ url('stateAuditee', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment" required >
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cancel-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ url('CancelStateExternalAudit', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment"required >
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="child-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('childexternalaudit', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="group-input">
                                    <label></lable>
                                    <label for="major">
                                        <input type="radio" name="child_type" value="Observations">
                                        Observations
                                    </label>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <style>
                #step-form>div {
                    display: none
                }

                #step-form>div:nth-child(1) {
                    display: block;
                }
            </style>

            <script>
                VirtualSelect.init({
                    ele: '#Facility, #Group, #Audit, #Auditee , #reference_record'
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
                }



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
                document.getElementById('initiator_group').addEventListener('change', function() {
                    var selectedValue = this.value;
                    document.getElementById('initiator_group_code').value = selectedValue;
                });
            </script>
                      <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const removeButtons = document.querySelectorAll('.remove-file');
            
                            removeButtons.forEach(button => {
                                button.addEventListener('click', function () {
                                    const fileName = this.getAttribute('data-file-name');
                                    const fileContainer = this.closest('.file-container');
            
                                    // Hide the file container
                                    if (fileContainer) {
                                        fileContainer.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>
                     <script>
                        var maxLength = 255;
                        $('#docname').keyup(function() {
                            var textlen = maxLength - $(this).val().length;
                            $('#rchars').text(textlen);});
                    </script>
  <script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);});
</script>
        @endsection
