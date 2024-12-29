<section>
    <div style="page-break-inside: avoid;">
        {{-- <div class="row mb-2">
                            <div class="col-3 mt-2">
                                <img height="auto" width="160px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
    </div>
    <div class="col-6 text-center mt-3">
        <h6>ELITE SECURITY SERVICES LIMITED </h6>
        <p style="margin: 1px;">BIO-DATA</p>
        <p style="margin: 1px;"><b style="border-bottom: solid 1px;">{{ $employees->position?->name }}</b></p>
    </div>
    <div class="col-3 text-end">
        <img class="tbl_border" height="auto" width="120px" src="{{asset('uploads/profile_img/'.$employees->profile_img)}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="No Img">
    </div>
    </div> --}}
    <table style="width: 100%; margin-bottom: 10px; border: none;">
        <tr>
            <!-- Logo on the left side -->
            <td style="width: 20%; vertical-align: middle;">
                <img height="auto" width="160px" src="{{ asset('assets/images/logo/logo.png')}}" alt="no img">
            </td>

            <!-- Center text in the middle -->
            <td style="width: 60%; text-align: center; vertical-align: middle;">
                <h6 style="margin: 0; font-size: 16px;">ELITE SECURITY SERVICES LIMITED</h6>
                <p style="margin: 1px; font-size: 12px;">BIO-DATA</p>
                <p style="margin: 1px; font-size: 14px;"><b style="border-bottom: solid 1px;">{{ $employees->position?->name }}</b></p>
            </td>

            <!-- Employee photo on the right side -->
            <td style="width: 20%; text-align: right; vertical-align: middle;">
                <img class="tbl_border" height="auto" width="120px" src="{{asset('uploads/profile_img/'.$employees->profile_img)}}"
                    onerror="this.onerror=null;this.src='{{ asset('assets/images/logo/onerror.jpg')}}';" alt="No Img">
            </td>
        </tr>
    </table>


    <table class="tbl_border" style="width: 100%;">
        <tbody>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">1</th>
                <th class="tbl_border" style="padding: 6px;">Name</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_applicants_name }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">2</th>
                <th class="tbl_border" style="padding: 6px;">Designation</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->position?->name }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">3</th>
                <th class="tbl_border" style="padding: 6px;">Place of Posting</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_place_of_posting }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">4</th>
                <th class="tbl_border" style="padding: 6px;">Employee ID No</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->admission_id_no }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">5</th>
                <th class="tbl_border" style="padding: 6px;">Height</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_height_foot }} Feet {{ $employees->en_height_inc }} Inch</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">6</th>
                <th class="tbl_border" style="padding: 6px;">Blood Group</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->bloodgroup?->name }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">7</th>
                <th class="tbl_border" style="padding: 6px;">Father's Name</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_fathers_name }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">8</th>
                <th class="tbl_border" style="padding: 6px;">Mother's Name</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_mothers_name }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">9</th>
                <th class="tbl_border" style="padding: 6px;">Next of Kin(NOK)</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_legacy_name }} @if($employees->en_legacy_relation != '')({{ $employees->en_legacy_relation }}) @else @endif</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">10</th>
                <th class="tbl_border" style="padding: 6px;">Present Address</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">
                    @if ($employees->en_pre_holding_no != '')
                    <b>C/O:</b> {{ $employees->en_pre_holding_no }},
                    @endif
                    @if ($employees->en_pre_village_name != '')
                    <b>Vill:</b> {{ $employees->en_pre_village_name }},
                    @endif
                    @if ($employees->bn_pre_ward?->name != '')
                    <b>Ward:</b> {{ $employees->bn_pre_ward?->name }},
                    @endif
                    @if ($employees->en_pre_post_ofc != '')
                    <b>Post:</b> {{ $employees->en_pre_post_ofc }},
                    @endif
                    @if ($employees->bn_union?->name != '')
                    <b>P.S:</b> {{ $employees->bn_union?->name }},
                    @endif
                    @if ($employees->bn_upazilla?->name != '')
                    <b>UP:</b> {{ $employees->bn_upazilla?->name }},
                    @endif
                    @if ($employees->bn_district?->name != '')
                    <b>Dist:</b> {{ $employees->bn_district?->name }}
                    @endif
                </th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">11</th>
                <th class="tbl_border" style="padding: 6px;">Permanent Address</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">
                    @if ($employees->en_parm_holding_name != '')
                    <b>C/O:</b> {{ $employees->en_parm_holding_name }},
                    @endif
                    @if ($employees->en_parm_village_name != '')
                    <b>Vill:</b> {{ $employees->en_parm_village_name }},
                    @endif
                    @if ($employees->bn_parm_ward?->name != '')
                    <b>Ward:</b> {{ $employees->bn_parm_ward?->name }},
                    @endif
                    @if ($employees->en_parm_post_ofc != '')
                    <b>Post:</b> {{ $employees->en_parm_post_ofc }},
                    @endif
                    @if ($employees->bn_parm_union?->name != '')
                    <b>P.S:</b> {{ $employees->bn_parm_union?->name }},
                    @endif
                    @if ($employees->bn_parm_upazilla?->name != '')
                    <b>UP:</b> {{ $employees->bn_parm_upazilla?->name }},
                    @endif
                    @if ($employees->bn_parm_district?->name != '')
                    <b>Dist:</b> {{ $employees->bn_parm_district?->name }}
                    @endif
                </th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">12</th>
                <th class="tbl_border" style="padding: 6px;">NID/Birth Certificate No</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">@if($employees->en_nid_no) {{ 'NID  :'.$employees->en_nid_no }} @else {{ 'B.C.  :'.$employees->en_birth_certificate }} @endif</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">13</th>
                <th class="tbl_border" style="padding: 6px;">Date of Birth</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ date('d-M-Y', strtotime($employees->bn_dob)) }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">14</th>
                <th class="tbl_border" style="padding: 6px;">Personal & Alt. Phone No</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_parm_phone_my }} , {{ $employees->en_parm_phone_alt }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">15</th>
                <th class="tbl_border" style="padding: 6px;">Educational Qualification</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_edu_qualification }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">16</th>
                <th class="tbl_border" style="padding: 6px;">Experience</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_experience }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">17</th>
                <th class="tbl_border" style="padding: 6px;">Religion</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->religion?->name }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">18</th>
                <th class="tbl_border" style="padding: 6px;">Marital Status</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;"> @if($employees->bn_marital_status=='1') {{ 'Unmarried' }} @else {{ 'Married' }} @endif</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">19</th>
                <th class="tbl_border" style="padding: 6px;">Character Certificate <br> (By Chairman)</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">(Certificate attached)</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">20</th>
                <th class="tbl_border" style="padding: 6px;">Nationality</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_nationality }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">21</th>
                <th class="tbl_border" style="padding: 6px;">Identification Mark(if any)</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">{{ $employees->en_identification_mark }}</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">22</th>
                <th class="tbl_border" style="padding: 6px;">Is any case filed against him <br> in any court of Justice</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">@if($employees->en_is_any_case=='1') {{ 'Yes' }} @elseif($employees->en_is_any_case=='2') {{ 'No' }}@else @endif</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">23</th>
                <th class="tbl_border" style="padding: 6px;">Had he ever been convicted <br> by the criminal Court</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">@if($employees->en_is_criminal_court=='1') {{ 'Yes' }} @elseif($employees->en_is_criminal_court=='2') {{ 'No' }}@else @endif</th>
            </tr>
            <tr class="tbl_border">
                <th class="tbl_border" style="text-align: center; padding: 6px;">24</th>
                <th class="tbl_border" style="padding: 6px;">Any Other Information</th>
                <th class="tbl_border" style="text-align: center; padding: 6px;">:</th>
                <th class="tbl_border" style="padding: 6px;">@if($employees->en_any_other_info=='1') {{ 'Yes' }} @elseif($employees->en_any_other_info=='2') {{ 'No' }}@else @endif</th>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-12 text-end mt-5" style="margin-top: 50px !important;">
            @if($employees->signature_img !='')
            <img height="50px" width="150px" class="me-3" src="{{asset('uploads/signature_img/'.$employees->signature_img)}}" alt="">
            @endif
            <p style="margin: 1px;"><b style="border-top: solid 2px;">Signature of the {{ $employees->position?->name }}</b></p>
        </div>
    </div>
    <p class="mb-0 pb-0">I have checked and verified the above mentioned information and found all correct.</p>
    <p class="mt-0 pt-0"><span style="border-bottom: solid 1px;">Certified by</span> </p>
    </div>
</section>