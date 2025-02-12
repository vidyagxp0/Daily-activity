@extends('frontend.layout.main')
@section('container')
    {{-- ======================================
                HELPDESK PERSONNEL
    ======================================= --}}
    <div id="helpdesk-personnel">
        <div class="container-fluid">

            <div class="inner-block">
                <div class="main-head">
                    HelpDesk Personnel
                </div>
                <div class="inner-block-content">
                    <div class="help-table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>HD</th>
                                    <th>Person</th>
                                    <th>Division</th>
                                    <th>Phone</th>
                                    <th>E-Mail</th>
                                    <!-- <th>Pin</th>
                                    <th>City</th>
                                    <th>State</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01.</td>
                                    <td>Yes</td>
                                    <td>Amit Guru</td>
                                    <td>Tech Support</td>
                                    <td>9179099211</td>
                                    <td>amit.g@gmail.com</td>
                                    <!-- <td>470001</td>
                                    <td>Sougar</td>
                                    <td>Madhya Pradesh</td> -->
                                </tr>
                                <tr>
                                    <td>02.</td>
                                    <td>Yes</td>
                                    <td>Shaleen Mishra</td>
                                    <td>Tech Support</td>
                                    <td>8770691509</td>
                                    <td>madhur.m@gmail.com</td>
                                    <!-- <td>470001</td>
                                    <td>Sougar</td>
                                    <td>Madhya Pradesh</td> -->
                                </tr>
                                <tr>
                                    <td>03.</td>
                                    <td>Yes</td>
                                    <td>Gautam Solanki</td>
                                    <td>Tech Support</td>
                                    <td>9425959395</td>
                                    <td>gautam.solanki@vidyagxp.com</td>
                                    <!-- <td>470001</td>
                                    <td>Sougar</td>
                                    <td>Madhya Pradesh</td> -->
                                </tr>
                                <tr>
                                    <td>04.</td>
                                    <td>Yes</td>
                                    <td>Himanshu Patil</td>
                                    <td>Tech Support</td>
                                    <td>9009425693</td>
                                    <td>himanshu.patil@vidyagxp.com</td>
                                    <!-- <td>470001</td>
                                    <td>Sougar</td>
                                    <td>Madhya Pradesh</td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="note">
                        HD indicates HelpDesk specific personnel. Others are vidyaGxP Administrators, which should be
                        contacted only when no HelpDesk Specific persons are available.
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
