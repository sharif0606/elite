<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\Biometric;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use App\Http\Traits\ImageHandleTraits;

class BiometricController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $employee = Employee::with('biometrics')->findOrFail(encryptor('decrypt', $request->id));
        return view('employee.biometric', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'hand_type' => 'required|in:1,2', // Left or Right
            'finger_type' => 'required|in:1,2,3,4,5', // Thumb, Index, etc.
            'img' => 'required', // Image validation
        ]);
        /*|image|mimes:jpeg,png,jpg,gif|max:2048*/

        // Check if the biometric data already exists for the given employee_id, hand_type, and finger_type
        $existingBiometric = Biometric::where('employee_id', $request->employee_id)
            ->where('hand_type', $request->hand_type)
            ->where('finger_type', $request->finger_type)
            ->first();

        if ($existingBiometric) {
            //return redirect()->back()->with('error', 'This fingerprint already exists for the selected hand and finger!');
            $this->notice::error('This fingerprint already exists for the selected hand and finger!', 'Fail');
            return redirect()->back()->withInput();
        }
        // Handle file upload
        if ($request->hasFile('img')) {
            // Generate the file name with employee_id, hand_type, and finger_type
            //$imageName = $request->employee_id . '_' . $request->hand_type . '_' . $request->finger_type . '.' . $request->img->extension();

            // Move the image to the desired directory
            //$request->profile_img->move(public_path('uploads/fingerprints'), $imageName); // Store in the 'uploads/fingerprints' folder
            $imageName = $this->uploadImage($request->img, 'uploads/fingerprints/');
        }

        // Store data in the database
        Biometric::create([
            'employee_id' => $request->employee_id, // Get employee_id from the request
            'hand_type' => $request->hand_type,
            'finger_type' => $request->finger_type,
            'img' => $imageName, // Store the image path with the new name
        ]);

        //return redirect()->back()->with('success', 'Finger print added successfully!');
        $this->notice::success('Data Saved!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Biometric  $biometric
     * @return \Illuminate\Http\Response
     */
    public function show(Biometric $biometric) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Biometric  $biometric
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the biometric record by ID
        $biometric = Biometric::findOrFail($id);

        // Return the view with the biometric data to edit
        return view('biometric.edit', compact('biometric'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Biometric  $biometric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the form data
        $validated = $request->validate([
            'hand_type' => 'required|in:1,2', // Left or Right
            'finger_type' => 'required|in:1,2,3,4,5', // Thumb, Index, etc.
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        // Find the biometric record by ID
        $biometric = Biometric::findOrFail($id);

        // Handle file upload (only if a new image is uploaded)
        if ($request->hasFile('img')) {
            // Delete the old image if it exists
            if (file_exists(public_path('uploads/fingerprints/' . $biometric->img))) {
                unlink(public_path('uploads/fingerprints/' . $biometric->img));
            }
            // Upload the new image
            $imageName = $this->uploadImage($request->img, 'uploads/fingerprints/');
        } else {
            // Keep the old image if no new image is uploaded
            $imageName = $biometric->img;
        }

        // Update the biometric record in the database
        $biometric->update([
            'hand_type' => $request->hand_type,
            'finger_type' => $request->finger_type,
            'img' => $imageName, // Store the image path with the new name
        ]);

        return redirect()->route('biometric.index')->with('success', 'Finger print updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Biometric  $biometric
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the biometric record by ID
        $biometric = Biometric::findOrFail($id);

        // Delete the image file if it exists
        if (file_exists(public_path('uploads/fingerprints/' . $biometric->img))) {
            unlink(public_path('uploads/fingerprints/' . $biometric->img));
        }

        // Delete the biometric record from the database
        $biometric->delete();

        return redirect()->back()->with('success', 'Finger print deleted successfully!');
    }
}
