<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeDocuments;
use App\Models\Employee\EmployeeDetails;
use App\Models\Employee\SecurityPriorAcquaintance;
use Illuminate\Http\Request;
use App\Http\Requests\Employee\AddEmployeeRequest;
use App\Http\Requests\Employee\EditEmployeeRequest;

use App\Models\Settings\Location\District;
use App\Models\Settings\Location\Upazila;
use App\Models\Settings\Location\Union;
use App\Models\Settings\Location\Ward;
use App\Models\Settings\BloodGroup;
use App\Models\Settings\Religion;
use App\Models\JobPost;
use App\Models\Settings\JobpostDescription;

use Toastr;
use Carbon\Carbon;
use DB;
use File;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;


class EmployeeController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::orderBy('id', 'ASC');
        if ($request->admission_id_no) {
            $employees = $employees->where('admission_id_no', $request->admission_id_no);
        }/*else{
            $employees = $employees->whereRaw("admission_id_no NOT REGEXP '^[0-9]+$'");
        }*/

        $employees = $employees->paginate(20);
        return view('employee.index', compact('employees'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobposts = JobPost::all();
        $districts = District::all();
        $upazila = Upazila::all();
        $union = Union::all();
        $ward = Ward::all();
        $bloods = BloodGroup::all();
        $religions = Religion::all();
        return view('employee.create', compact('districts', 'upazila', 'union', 'ward', 'bloods', 'religions', 'jobposts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddEmployeeRequest $request)
    {
        try {
            // dd($request->all());
            $employee = new Employee();
            $employee->bn_applicants_name = $request->bn_applicants_name;
            $employee->bn_fathers_name = $request->bn_fathers_name;
            $employee->bn_mothers_name = $request->bn_mothers_name;
            $employee->admission_id_no = $request->admission_id_no;
            $employee->joining_date = $request->joining_date;
            $employee->salary_joining_date = $request->salary_joining_date;
            $employee->salary_status = $request->salary_status;
            // $employee->admission_id_no = 'AD-'.Carbon::now()->format('m-y').'-'. str_pad((Employee::whereYear('created_at', Carbon::now()->year)->count() + 1),4,"0",STR_PAD_LEFT);

            $employee->bn_parm_district_id = $request->bn_parm_district_id;
            $employee->bn_parm_upazila_id = $request->bn_parm_upazila_id;
            $employee->bn_parm_union_id = $request->bn_parm_union_id;
            $employee->bn_parm_ward_id = $request->bn_parm_ward_id;
            $employee->bn_parm_holding_name = $request->bn_parm_holding_name;
            $employee->bn_parm_village_name = $request->bn_parm_village_name;
            $employee->bn_parm_post_ofc = $request->bn_parm_post_ofc;
            $employee->bn_parm_phone_my = $request->bn_parm_phone_my;
            $employee->bn_parm_phone_alt = $request->bn_parm_phone_alt;
            $employee->employee_type = $request->employee_type;
            $employee->designation_id = $request->designation_id;
            $employee->gross_salary = $request->gsalary;
            $employee->ot_salary = $request->otsalary;
            $employee->salary_serial = $request->salary_serial;

            $employee->bn_pre_district_id = $request->bn_pre_district_id;
            $employee->bn_pre_upazila_id = $request->bn_pre_upazila_id;
            $employee->bn_pre_union_id = $request->bn_pre_union_id;
            $employee->bn_pre_ward_no = $request->bn_pre_ward_no;
            $employee->bn_pre_holding_no = $request->bn_pre_holding_no;
            $employee->bn_pre_village_name = $request->bn_pre_village_name;
            $employee->bn_pre_post_ofc = $request->bn_pre_post_ofc;
            $employee->bn_identification_mark = $request->bn_identification_mark;
            $employee->bn_edu_qualification = $request->bn_edu_qualification;
            $employee->bn_blood_id = $request->bn_blood_id;
            $employee->bn_dob = $request->bn_dob;
            $employee->bn_age = $request->bn_age;
            $employee->bn_birth_certificate = $request->bn_birth_certificate;
            $employee->bn_nid_no = $request->bn_nid_no;
            $employee->bn_nationality = $request->bn_nationality;
            $employee->bn_religion = $request->bn_religion;
            $employee->bn_height_foot = $request->bn_height_foot;
            $employee->bn_height_inc = $request->bn_height_inc;
            $employee->bn_weight_kg = $request->bn_weight_kg;
            $employee->bn_weight_pounds = $request->bn_weight_pounds;
            $employee->bn_experience = $request->bn_experience;
            $employee->bn_marital_status = $request->bn_marital_status;
            $employee->bn_legacy_name = $request->bn_legacy_name;
            $employee->bn_legacy_relation = $request->bn_legacy_relation;
            $employee->bn_reference_admittee = $request->bn_reference_admittee;
            $employee->bn_reference_adm_phone = $request->bn_reference_adm_phone;
            $employee->bn_reference_adm_adress = $request->bn_reference_adm_adress;
            $employee->bn_addmit_post = $request->bn_addmit_post;
            $employee->bn_jobpost_id = $request->bn_jobpost_id;
            $employee->bn_post_allowance = $request->bn_post_allowance;
            $employee->bn_food_allowance = $request->bn_food_allowance;
            $employee->bn_fuel_bill = $request->bn_fuel_bill;
            $employee->bn_traning_cost = $request->bn_traning_cost;
            $employee->bn_remaining_cost = $request->bn_remaining_cost;
            $employee->bn_traning_cost_byMonth = $request->bn_traning_cost_byMonth;
            $employee->bn_bank_name = $request->bn_bank_name;
            $employee->bn_brance_name = $request->bn_brance_name;
            $employee->bn_ac_no = $request->bn_ac_no;
            $employee->bn_ac_name = $request->bn_ac_name;
            $employee->second_bank_name = $request->second_bank_name;
            $employee->second_brance_name = $request->second_brance_name;
            $employee->second_ac_no = $request->second_ac_no;
            $employee->second_ac_name = $request->second_ac_name;
            $employee->bn_routing_number = $request->bn_routing_number;
            $employee->salary_prepared_type = $request->salary_prepared_type;
            $employee->remarks = $request->remarks;

            //   English
            $employee->en_applicants_name = $request->en_applicants_name;
            $employee->en_fathers_name = $request->en_fathers_name;
            $employee->en_mothers_name = $request->en_mothers_name;
            // $employee->en_parm_district_id = $request->en_parm_district_id;
            // $employee->en_parm_upazila_id = $request->en_parm_upazila_id;
            // $employee->en_parm_union_id = $request->en_parm_union_id;
            // $employee->en_parm_ward_id = $request->en_parm_ward_id;
            $employee->en_parm_holding_name = $request->en_parm_holding_name;
            $employee->en_parm_village_name = $request->en_parm_village_name;
            $employee->en_parm_post_ofc = $request->en_parm_post_ofc;
            $employee->en_parm_phone_my = $request->en_parm_phone_my;
            $employee->en_parm_phone_alt = $request->en_parm_phone_alt;

            // $employee->en_pre_district_id = $request->en_pre_district_id;
            // $employee->en_pre_upazila_id = $request->en_pre_upazila_id;
            // $employee->en_pre_union_id = $request->en_pre_union_id;
            // $employee->en_pre_ward_id = $request->en_pre_ward_id;
            $employee->en_pre_holding_no = $request->en_pre_holding_no;
            $employee->en_pre_village_name = $request->en_pre_village_name;
            $employee->en_pre_post_ofc = $request->en_pre_post_ofc;
            $employee->en_identification_mark = $request->en_identification_mark;
            $employee->en_edu_qualification = $request->en_edu_qualification;
            // $employee->en_blood_id = $request->en_blood_id;
            $employee->en_dob = $request->en_dob;
            $employee->en_age = $request->en_age;
            $employee->en_birth_certificate = $request->en_birth_certificate;
            $employee->en_nid_no = $request->en_nid_no;
            $employee->en_nationality = $request->en_nationality;
            // $employee->en_religion = $request->en_religion;
            $employee->en_height_foot = $request->en_height_foot;
            $employee->en_height_inc = $request->en_height_inc;
            $employee->en_weight_kg = $request->en_weight_kg;
            $employee->en_weight_pounds = $request->en_weight_pounds;
            $employee->en_experience = $request->en_experience;
            $employee->en_marital_status = $request->en_marital_status;
            $employee->en_legacy_name = $request->en_legacy_name;
            $employee->en_legacy_relation = $request->en_legacy_relation;
            $employee->en_reference_admittee = $request->en_reference_admittee;
            $employee->en_reference_adm_phone = $request->en_reference_adm_phone;
            $employee->en_reference_adm_adress = $request->en_reference_adm_adress;
            $employee->en_place_of_posting = $request->en_place_of_posting;
            $employee->en_is_any_case = $request->en_is_any_case;
            $employee->en_is_criminal_court = $request->en_is_criminal_court;
            $employee->en_any_other_info = $request->en_any_other_info;
            // $employee->en_jobpost_id = $request->en_jobpost_id;
            $employee->bn_cer_gender = $request->bn_cer_gender;
            $employee->bn_cer_physical_ability = $request->bn_cer_physical_ability;

            $employee->bn_spouse_name = $request->bn_spouse_name;
            $employee->bn_song_name = $request->bn_song_name;
            $employee->bn_daughters_name = $request->bn_daughters_name;
            $employee->en_spouse_name = $request->en_spouse_name;
            $employee->en_song_name = $request->en_song_name;
            $employee->en_daughters_name = $request->en_daughters_name;
            if ($request->has('concerned_person_sign'))
                $employee->concerned_person_sign = $this->uploadImage($request->concerned_person_sign, 'uploads/concerned_person_sign/');
            if ($request->has('bn_doctor_sign'))
                $employee->bn_doctor_sign = $this->uploadImage($request->bn_doctor_sign, 'uploads/bn_doctor_sign/');

            if ($request->has('profile_img'))
                $employee->profile_img = $this->uploadImage($request->profile_img, 'uploads/profile_img/');
            if ($request->has('signature_img'))
                $employee->signature_img = $this->uploadImage($request->signature_img, 'uploads/signature_img/');

            if ($employee->save()) {
                if ($request->has('document_img')) {
                    foreach ($request->document_img as $key => $value) {
                        if ($value) {
                            $document = new EmployeeDocuments;
                            $document->employee_id = $employee->id;
                            $document->document_caption = $request->document_caption[$key];
                            $document->document_img = $this->uploadImage($request->document_img[$key], 'uploads/document_img/');
                            $document->save();
                        }
                    }
                }
                $this->notice::success('Data Saved!');
                return redirect()->route('employee.index', ['role' => currentUser()]);
            } else {
                $this->notice::error('Please try again!', 'Fail');
                return redirect()->back()->withInput();
            }

            // if($employee->save()){
            //     if($request->bn_song_name || $request->bn_daughters_name){
            //         foreach($request->bn_spouse_name as $key => $value){
            //             // dd($request->all());
            //             if($value){
            //                 $details = new EmployeeDetails;
            //                 $details->employee_id=$employee->id;
            //                 $details->bn_song_name=$request->bn_song_name[$key];
            //                 $details->bn_daughters_name=$request->bn_daughters_name[$key];
            //                 $details->save();
            //             }
            //         }
            //     }
            // Toastr::success('Create Successfully!');
            // return redirect()->route('employee.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            // } else{
            // Toastr::warning('Please try Again!');
            // return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            // }
        } catch (Exception $e) {
            dd($e);
            $this->notice::error('Please try again!', 'Fail');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees = Employee::findOrFail(encryptor('decrypt', $id));
        $employeeDocuments = EmployeeDocuments::where('employee_id', encryptor('decrypt', $id))->get();
        $security = SecurityPriorAcquaintance::where('employee_id', encryptor('decrypt', $id))->first();
        $jobposts = JobPost::where('id', $employees->bn_jobpost_id)->first();
        $jobdescription = JobpostDescription::where('jobpost_id', $employees->bn_jobpost_id)->first();
        return view('employee.show', compact('employees', 'security', 'jobposts', 'jobdescription', 'employeeDocuments'));
    }
    public function exportToWord($id)
    {
        // Fetch the employee data
        $employees = Employee::find($id);
        //dd($employees);
        if (!$employees) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        // Create a new PHPWord object
        $phpWord = new PhpWord();

        // Add a new section
        $section = $phpWord->addSection();

        // Create the first table (logo, text, photo)
        $table1 = $section->addTable();

        // Add a row to the first table
        $table1->addRow();

        // Add the first image (logo) in the first cell of the first table
        $table1->addCell(2500)->addImage(public_path('assets/images/logo/logo.png'), array('width' => 100, 'height' => 'auto', 'align' => 'left'));

        // Add the text in the second cell of the first table
        $textCell = $table1->addCell(5000); // Adjust width for the text wrapping
        $textCell->addText("ELITE SECURITY SERVICES LIMITED", array('bold' => true, 'size' => 11), array('align' => 'center'));
        $textCell->addText("BIO-DATA", array('size' => 10), array('bold' => true, 'align' => 'center'));
        $textCell->addText("Position: " . $employees->position?->name, array('bold' => true, 'size' => 9), array('align' => 'center'));
        $textCell->addTextBreak(1);



        // Add the second image (employee photo or fallback) in the third cell of the first table
        //$table1->addCell(2000)->addImage(public_path('assets/images/av.png'), array('width' => 70, 'height' => 'auto', 'align' => 'right'));


        // Add a photo (ensure the photo exists or provide a fallback if not)
        if ($employees->profile_img && file_exists(public_path('uploads/profile_img/' . $employees->profile_img))) {
            $table1->addCell(2000)->addImage(public_path('uploads/profile_img/' . $employees->profile_img), array('width' => 90, 'height' => 110, 'align' => 'right'));
        } else {
            // Default fallback image if the employee does not have a profile image
            $table1->addCell(2000)->addImage(public_path('assets/images/av.png'), array('width' => 80, 'height' => 90, 'align' => 'right'));
        }

        // Create the second table with borders and specific columns for serial number, colon, and text
        $table2 = $section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40]);

        if ($employees->en_is_any_case == '1')
            $language_status = 'Yes';
        else if ($employees->en_is_any_case == '2')
            $language_status = 'No';
        // Define employee additional details array
        $employeeAdditionalDetails = [
            ['Name', $employees->en_applicants_name],
            ['Designation', $employees->position?->name],
            ['Place of Posting', $employees->en_place_of_posting],
            ['Employee ID No', $employees->admission_id_no],
            ['Height', $employees->en_height_foot . "Feet" . $employees->en_height_inc . "Inch"],
            ['Blood Group', $employees->bloodgroup?->name],
            ['Fathers Name', $employees->en_fathers_name],
            ['Mothers Name', $employees->en_mothers_name],
            ['Next of Kin(NOK)', $employees->en_legacy_name],
            [
                'Present Address',
                ($employees->en_pre_holding_no ? 'C/O: ' . $employees->en_pre_holding_no . ', ' : '') .
                    ($employees->en_pre_village_name ? 'Vill: ' . $employees->en_pre_village_name . ', ' : '') .
                    ($employees->bn_pre_ward?->name ? 'Ward: ' . $employees->bn_pre_ward?->name . ', ' : '') .
                    ($employees->en_pre_post_ofc ? 'Post: ' . $employees->en_pre_post_ofc . ', ' : '') .
                    ($employees->bn_union?->name ? 'P.S: ' . $employees->bn_union?->name . ', ' : '') .
                    ($employees->bn_upazilla?->name ? 'UP: ' . $employees->bn_upazilla?->name . ', ' : '') .
                    ($employees->bn_district?->name ? 'Dist: ' . $employees->bn_district?->name : '')
            ],
            [
                'Permanent Address',
                ($employees->en_parm_holding_name ? 'C/O: ' . $employees->en_parm_holding_name . ', ' : '') .
                    ($employees->en_parm_village_name ? 'Vill: ' . $employees->en_parm_village_name . ', ' : '') .
                    ($employees->bn_perm_ward?->name ? 'Ward: ' . $employees->bn_perm_ward?->name . ', ' : '') .
                    ($employees->en_parm_post_ofc ? 'Post: ' . $employees->en_parm_post_ofc . ', ' : '') .
                    ($employees->bn_parm_union?->name ? 'P.S: ' . $employees->bn_parm_union?->name . ', ' : '') .
                    ($employees->bn_parm_upazilla?->name ? 'UP: ' . $employees->bn_parm_upazilla?->name . ', ' : '') .
                    ($employees->bn_parm_district?->name ? 'Dist: ' . $employees->bn_parm_district?->name : '')
            ],
            [
                'NID Or Birth Registration No.',
                $employees->en_nid_no
                    ? 'NID: ' . $employees->en_nid_no
                    : 'B.C.: ' . $employees->en_birth_certificate
            ],
            ['Date of Birth', date('d-M-Y', strtotime($employees->bn_dob))],
            // ['Email', $employees->email],
            ['Personal and  Alt. Phone No', $employees->en_parm_phone_my.','.$employees->en_parm_phone_alt],
            ['Educational Qualification', $employees->en_edu_qualification],
            ['Experience', $employees->en_experience],
            ['Religion', $employees->religion?->name],
            ['Marital Status', ($employees->bn_marital_status == '1') ? 'Unmarried' : 'Married'],
            ['Nationality', $employees->en_nationality],
            ['Character Certificate (By Chairman)', '(Certificate attached)'],
            ['Identification Mark(if any)', $employees->en_identification_mark],
            ['Is any case filed against him in any court of Justice', $language_status],
            [
                'Had he ever been convicted by the criminal Court',
                $employees->en_is_criminal_court == '1' ? 'Yes' : ($employees->en_is_criminal_court == '2' ? 'No' : 'Unknown')
            ],
            [
                'Any Other Information',
                $employees->en_any_other_info == '1' ? 'Yes' : ($employees->en_any_other_info == '2' ? 'No' : '')
            ],
            [
                'Emergency Address',
                ($employees->en_emergency_holding_no ? 'C/O: ' . $employees->en_parm_holding_name . ', '.$employees->en_pre_holding_no : '') .
                    ($employees->en_emergency_village_name ? 'Vill: ' . $employees->en_parm_village_name . ', ' : '') .
                    ($employees->en_emergency_post_ofc ? 'Post: ' . $employees->en_parm_post_ofc . ', ' : '') .
                    ($employees->bn_emergency_union?->name ? 'P.S: ' . $employees->bn_emergency_union?->name . ', ' : '') .
                    ($employees->bn_emergency_upazilla?->name ? 'UP: ' . $employees->bn_emergency_upazilla?->name . ', ' : '') .
                    ($employees->bn_emergency_district?->name ? 'Dist: ' . $employees->bn_emergency_district?->name : '')
            ]
        ];


        // Loop through each additional detail and add it to the second table
        foreach ($employeeAdditionalDetails as $index => $detail) {
            // Add a new row for each detail
            $table2->addRow();

            // Add a cell for the serial number, centered
            $table2->addCell(1000)->addText(($index + 1), ['bold' => true, 'size' => 10], ['align' => 'center', 'valign' => 'center']);

            // Add a cell for the label (e.g., "Designation"), left-aligned
            $table2->addCell(3000)->addText($detail[0], ['size' => 10], ['align' => 'left', 'valign' => 'center']);

            // Add a cell for the colon (:) to separate the label and value, centered
            $table2->addCell(300)->addText(":", ['size' => 10], ['align' => 'center', 'valign' => 'center']);

            // Add a cell for the value (e.g., employee's designation), centered and bold
            $table2->addCell(6000)->addText($detail[1] ?: 'N/A', ['size' => 10], ['align' => 'left', 'valign' => 'center']);
        }
        // Add a text break to separate the second table from the third table
        $section->addTextBreak(2); // Add a line break

        // Create the third table (separate from the second one)
        $table3 = $section->addTable();

        // Add a row to the table
        $table3->addRow();

        // Add the text cell (left-aligned)
        $textCellmiddle = $table3->addCell(6000); // Adjust width for the text wrapping

        // Add the "Signature" on the right (second cell with top border only)
        $signatureCell = $table3->addCell(2000); // Top border only for "Signature"

        // Check if signature image exists and add it 
        if ($employees->signature_img != '') {
            $signatureCell->addImage(asset('uploads/signature_img/' . $employees->signature_img), [
                'height' => 50, // Set the height of the image
                'width' => 150,  // Set the width of the image
                'align' => 'center', // Center the image
                'marginTop' => 0,  // Add top margin for spacing
            ]);
        }

        // Add the "Signature of the Position" text below the image
        $signatureCell->addText(
            "Signature of the " . ($employees->position?->name ?? 'Employee'),
            ['bold' => true],
            ['align' => 'center', 'marginTop' => 0, 'borderTopSize' => 0, 'borderTopColor' => '000000']
        );
        $section->addTextBreak(1); // Add a line break
        // Create the fourth table (separate full-width table)
        $table4 = $section->addTable();

        // Add a row to the table
        $table4->addRow();

        // Add the first text (first cell, spans full width)
        $textCellLeft = $table4->addCell(10000); // Full width cell for text (spanning entire width)
        $textCellLeft->addText("I have checked and verified the above mentioned information and found all correct.", ['size' => 10], ['align' => 'left']);

        // Add a new row and cell for "Certified By"
        $table4->addRow();

        // Add the "Certified By" text in its own cell
        $certifiedCell = $table4->addCell(10000); // Full width cell
        $certifiedCell->addText("Certified By", ['size' => 10], ['align' => 'left']);




        // Save the document to a variable and send it for download
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        ob_start();
        $writer->save("php://output");
        $fileContent = ob_get_clean();

        // Set headers to force the file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="employee_biodata.docx"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        header('Expires: 0');

        // Output the file content for download
        echo $fileContent;
        exit;
    }
    public function certificate($id)
    {
        $emp = Employee::findOrFail(encryptor('decrypt', $id));
        return view('employee.certificate', compact('emp'));
    }
    public function additionalFile()
    {
        return view('employee.additional-file');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobposts = JobPost::all();
        $districts = District::all();
        $upazila = Upazila::all();
        $union = Union::all();
        $ward = Ward::all();
        $bloods = BloodGroup::all();
        $religions = Religion::all();
        $employees = Employee::findOrFail(encryptor('decrypt', $id));
        $employeeDocuments = EmployeeDocuments::where('employee_id', encryptor('decrypt', $id))->get();
        return view('employee.edit', compact('districts', 'upazila', 'union', 'ward', 'bloods', 'religions', 'employees', 'jobposts', 'employeeDocuments'));
    }

    public function employeeDocument(Request $request)
    {
        $documents = EmployeeDocuments::findOrFail($request->id);
        if ($this->deleteImage($documents->document_img, 'uploads/document_img/'))
            EmployeeDocuments::find($request->id)->delete();
        return back();
    }

    public function update(EditEmployeeRequest $request, $id)
    {
        try {
            $employee = Employee::findOrFail(encryptor('decrypt', $id));
            $employee->bn_applicants_name = $request->bn_applicants_name;
            $employee->bn_fathers_name = $request->bn_fathers_name;
            $employee->bn_mothers_name = $request->bn_mothers_name;
            $employee->admission_id_no = $request->admission_id_no;
            $employee->joining_date = $request->joining_date;
            $employee->salary_joining_date = $request->salary_joining_date;
            $employee->salary_status = $request->salary_status;
            // $employee->admission_id_no = 'AD-'.Carbon::now()->format('m-y').'-'. str_pad((Employee::whereYear('created_at', Carbon::now()->year)->count() + 1),4,"0",STR_PAD_LEFT);

            $employee->bn_parm_district_id = $request->bn_parm_district_id;
            $employee->bn_parm_upazila_id = $request->bn_parm_upazila_id;
            $employee->bn_parm_union_id = $request->bn_parm_union_id;
            $employee->bn_parm_ward_id = $request->bn_parm_ward_id;
            $employee->bn_parm_holding_name = $request->bn_parm_holding_name;
            $employee->bn_parm_village_name = $request->bn_parm_village_name;
            $employee->bn_parm_post_ofc = $request->bn_parm_post_ofc;
            $employee->bn_parm_phone_my = $request->bn_parm_phone_my;
            $employee->bn_parm_phone_alt = $request->bn_parm_phone_alt;
            $employee->employee_type = $request->employee_type;
            $employee->designation_id = $request->designation_id;
            $employee->gross_salary = $request->gsalary;
            $employee->ot_salary = $request->otsalary;
            $employee->salary_serial = $request->salary_serial;

            $employee->bn_pre_district_id = $request->bn_pre_district_id;
            $employee->bn_pre_upazila_id = $request->bn_pre_upazila_id;
            $employee->bn_pre_union_id = $request->bn_pre_union_id;
            $employee->bn_pre_ward_no = $request->bn_pre_ward_no;
            $employee->bn_pre_holding_no = $request->bn_pre_holding_no;
            $employee->bn_pre_village_name = $request->bn_pre_village_name;
            $employee->bn_pre_post_ofc = $request->bn_pre_post_ofc;
            $employee->bn_identification_mark = $request->bn_identification_mark;
            $employee->bn_edu_qualification = $request->bn_edu_qualification;
            $employee->bn_blood_id = $request->bn_blood_id;
            $employee->bn_dob = $request->bn_dob;
            $employee->bn_age = $request->bn_age;
            $employee->bn_birth_certificate = $request->bn_birth_certificate;
            $employee->bn_nid_no = $request->bn_nid_no;
            $employee->bn_nationality = $request->bn_nationality;
            $employee->bn_religion = $request->bn_religion;
            $employee->bn_height_foot = $request->bn_height_foot;
            $employee->bn_height_inc = $request->bn_height_inc;
            $employee->bn_weight_kg = $request->bn_weight_kg;
            $employee->bn_weight_pounds = $request->bn_weight_pounds;
            $employee->bn_experience = $request->bn_experience;
            $employee->bn_marital_status = $request->bn_marital_status;
            $employee->bn_legacy_name = $request->bn_legacy_name;
            $employee->bn_legacy_relation = $request->bn_legacy_relation;
            $employee->bn_reference_admittee = $request->bn_reference_admittee;
            $employee->bn_reference_adm_phone = $request->bn_reference_adm_phone;
            $employee->bn_reference_adm_adress = $request->bn_reference_adm_adress;
            $employee->bn_addmit_post = $request->bn_addmit_post;
            $employee->bn_jobpost_id = $request->bn_jobpost_id;
            $employee->bn_post_allowance = $request->bn_post_allowance;
            $employee->bn_food_allowance = $request->bn_food_allowance;
            $employee->insurance = $request->insurance;
            $employee->p_f = $request->p_f;
            $employee->medical = $request->medical;
            $employee->bn_fuel_bill = $request->bn_fuel_bill;
            $employee->bn_traning_cost = $request->bn_traning_cost;
            $employee->bn_remaining_cost = $request->bn_remaining_cost;
            $employee->bn_traning_cost_byMonth = $request->bn_traning_cost_byMonth;
            $employee->bn_bank_name = $request->bn_bank_name;
            $employee->bn_brance_name = $request->bn_brance_name;
            $employee->bn_ac_no = $request->bn_ac_no;
            $employee->bn_ac_name = $request->bn_ac_name;
            $employee->second_bank_name = $request->second_bank_name;
            $employee->second_brance_name = $request->second_brance_name;
            $employee->second_ac_no = $request->second_ac_no;
            $employee->second_ac_name = $request->second_ac_name;
            $employee->bn_routing_number = $request->bn_routing_number;
            $employee->salary_prepared_type = $request->salary_prepared_type;
            $employee->remarks = $request->remarks;

            //   English
            $employee->en_applicants_name = $request->en_applicants_name;
            $employee->en_fathers_name = $request->en_fathers_name;
            $employee->en_mothers_name = $request->en_mothers_name;
            // $employee->en_parm_district_id = $request->en_parm_district_id;
            // $employee->en_parm_upazila_id = $request->en_parm_upazila_id;
            // $employee->en_parm_union_id = $request->en_parm_union_id;
            // $employee->en_parm_ward_id = $request->en_parm_ward_id;
            $employee->en_parm_holding_name = $request->en_parm_holding_name;
            $employee->en_parm_village_name = $request->en_parm_village_name;
            $employee->en_parm_post_ofc = $request->en_parm_post_ofc;
            $employee->en_parm_phone_my = $request->en_parm_phone_my;
            $employee->en_parm_phone_alt = $request->en_parm_phone_alt;

            // $employee->en_pre_district_id = $request->en_pre_district_id;
            // $employee->en_pre_upazila_id = $request->en_pre_upazila_id;
            // $employee->en_pre_union_id = $request->en_pre_union_id;
            // $employee->en_pre_ward_id = $request->en_pre_ward_id;
            $employee->en_pre_holding_no = $request->en_pre_holding_no;
            $employee->en_pre_village_name = $request->en_pre_village_name;
            $employee->en_pre_post_ofc = $request->en_pre_post_ofc;
            $employee->en_identification_mark = $request->en_identification_mark;
            $employee->en_edu_qualification = $request->en_edu_qualification;
            //$employee->en_blood_id = $request->en_blood_id;
            //$employee->en_dob = $request->en_dob;
            //$employee->en_age = $request->en_age;
            $employee->en_birth_certificate = $request->en_birth_certificate;
            $employee->en_nid_no = $request->en_nid_no;
            $employee->en_nationality = $request->en_nationality;
            // $employee->en_religion = $request->en_religion;
            $employee->en_height_foot = $request->en_height_foot;
            $employee->en_height_inc = $request->en_height_inc;
            $employee->en_weight_kg = $request->en_weight_kg;
            $employee->en_weight_pounds = $request->en_weight_pounds;
            $employee->en_experience = $request->en_experience;
            $employee->en_marital_status = $request->en_marital_status;
            $employee->en_legacy_name = $request->en_legacy_name;
            $employee->en_legacy_relation = $request->en_legacy_relation;
            $employee->en_reference_admittee = $request->en_reference_admittee;
            $employee->en_reference_adm_phone = $request->en_reference_adm_phone;
            $employee->en_reference_adm_adress = $request->en_reference_adm_adress;
            //$employee->en_jobpost_id = $request->en_jobpost_id;
            $employee->en_place_of_posting = $request->en_place_of_posting;
            $employee->en_is_any_case = $request->en_is_any_case;
            $employee->en_is_criminal_court = $request->en_is_criminal_court;
            $employee->en_any_other_info = $request->en_any_other_info;
            $employee->bn_cer_gender = $request->bn_cer_gender;
            $employee->bn_cer_physical_ability = $request->bn_cer_physical_ability;

            $employee->bn_spouse_name = $request->bn_spouse_name;
            $employee->bn_song_name = $request->bn_song_name;
            $employee->bn_daughters_name = $request->bn_daughters_name;
            $employee->en_spouse_name = $request->en_spouse_name;
            $employee->en_song_name = $request->en_song_name;
            $employee->en_daughters_name = $request->en_daughters_name;
            if ($request->has('concerned_person_sign'))
                $employee->concerned_person_sign = $this->uploadImage($request->concerned_person_sign, 'uploads/concerned_person_sign/');
            if ($request->has('bn_doctor_sign'))
                $employee->bn_doctor_sign = $this->uploadImage($request->bn_doctor_sign, 'uploads/bn_doctor_sign/');

            if ($request->has('profile_img'))
                $employee->profile_img = $this->uploadImage($request->profile_img, 'uploads/profile_img/');
            if ($request->has('signature_img'))
                $employee->signature_img = $this->uploadImage($request->signature_img, 'uploads/signature_img/');

            /*== Employee Status Change == */
            $employee->status = $request->status;
            if ($employee->save()) {
                if ($request->has('document_img')) {
                    foreach ($request->document_img as $key => $value) {
                        if ($value) {
                            $document = new EmployeeDocuments;
                            $document->employee_id = $employee->id;
                            $document->document_caption = $request->document_caption[$key];
                            $document->document_img = $this->uploadImage($request->document_img[$key], 'uploads/document_img/');
                            $document->save();
                        }
                    }
                }
                return redirect()->route('employee.index', ['role' => currentUser()])->with(Toastr::success('Data Updated!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function securityGuards($id)
    {
        $employees = Employee::findOrFail(encryptor('decrypt', $id));
        $security = SecurityPriorAcquaintance::where('employee_id', encryptor('decrypt', $id))->first();
        $districts = District::all();
        $upazila = Upazila::all();
        return view('employee.security-prior-acquaintance', compact('employees', 'districts', 'upazila', 'security'));
    }

    public function securityGuardsStore(Request $request, $id)
    {
        try {
            $security = SecurityPriorAcquaintance::where('employee_id', $id)->firstOrNew();
            // $security=new SecurityPriorAcquaintance;
            $security->employee_id = $id;
            $security->bn_in_laws_district_id = $request->bn_in_laws_district_id;
            $security->bn_in_laws_upazilla_id = $request->bn_in_laws_upazilla_id;
            $security->bn_in_laws_village_name = $request->bn_in_laws_village_name;
            $security->bn_in_laws_post_office = $request->bn_in_laws_post_office;
            $security->bn_husband_profession = $request->bn_husband_profession;
            $security->bn_father_profession = $request->bn_father_profession;
            $security->bn_landlord_name = $request->bn_landlord_name;
            $security->bn_landlord_mobile_no = $request->bn_landlord_mobile_no;
            $security->bn_living_dur = $request->bn_living_dur;
            $security->bn_passport_no = $request->bn_passport_no;
            $security->bn_old_office_name = $request->bn_old_office_name;
            $security->bn_old_office_address = $request->bn_old_office_address;
            $security->bn_resign_reason = $request->bn_resign_reason;
            $security->bn_resign_letter_status = $request->bn_resign_letter_status;
            $security->bn_service_book_status = $request->bn_service_book_status;
            $security->bn_service_book_no = $request->bn_service_book_no;
            $security->bn_old_job_salary = $request->bn_old_job_salary;
            $security->bn_old_job_last_desig = $request->bn_old_job_last_desig;
            $security->bn_old_job_experience = $request->bn_old_job_experience;
            $security->bn_new_job_transportation = $request->bn_new_job_transportation;
            $security->bn_current_living = $request->bn_current_living;
            $security->bn_total_member = $request->bn_total_member;
            $security->bn_mobile_no = $request->bn_mobile_no;
            $security->bn_solvent_person = $request->bn_solvent_person;
            $security->bn_sim_card_reg_status = $request->bn_sim_card_reg_status;
            $security->bn_case_filed_status = $request->bn_case_filed_status;
            $security->bn_old_job_officer_name = $request->bn_old_job_officer_name;
            $security->bn_old_job_officer_mobile = $request->bn_old_job_officer_mobile;
            $security->bn_old_job_officer_post = $request->bn_old_job_officer_post;
            $security->bn_identifier_name1 = $request->bn_identifier_name1;
            $security->bn_identifier_occupation1 = $request->bn_identifier_occupation1;
            $security->bn_identifier_address1 = $request->bn_identifier_address1;
            $security->bn_identifier_phone1 = $request->bn_identifier_phone1;
            $security->bn_identifier_name2 = $request->bn_identifier_name2;
            $security->bn_identifier_occupation2 = $request->bn_identifier_occupation2;
            $security->bn_identifier_address2 = $request->bn_identifier_address2;
            $security->bn_identifier_phone2 = $request->bn_identifier_phone2;
            if ($request->has('informant_sing'))
                $security->informant_sing = $this->uploadImage($request->informant_sing, 'uploads/informant_sing/');
            if ($request->has('data_collector_sing'))
                $security->data_collector_sing = $this->uploadImage($request->data_collector_sing, 'uploads/data_collector_sing/');
            if ($request->has('executive_sing'))
                $security->executive_sing = $this->uploadImage($request->executive_sing, 'uploads/executive_sing/');
            if ($request->has('manager_sing'))
                $security->manager_sing = $this->uploadImage($request->manager_sing, 'uploads/manager_sing/');
            if ($security->save())
                return redirect()->route('employee.index', ['role' => currentUser()])->with(Toastr::success('Successfully Done!', 'Success', ["positionClass" => "toast-top-right"]));
            else
                return redirect()->back()->withInput()->with($this->resMessageHtml(false, 'error', 'please try again'));
        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->withInput()->with($this->resMessageHtml(false, 'error', 'Please try again'));
        }
    }
}
