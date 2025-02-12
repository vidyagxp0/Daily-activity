<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Scorm;

class ScormController extends Controller
{


    public function createScorm()
{
    $scormCount = Scorm::count();
    $scorm_id = 'SCORM'.$scormCount +1;
    return view('frontend.TMS.Scorm.scorm_new', compact('scorm_id'));
}

    public function store(Request $request)
    {
        $scorm = new Scorm();

        $scorm->initiator_name = Auth::user()->name;
        $scorm->initiation_date_new = $request->initiation_date_new;
        $scorm->scorm_id = $request->scorm_id;
        $scorm->short_description = $request->short_description;
        $scorm->validations = $request->validations;

        if ($request->hasFile('file_attachment')) {
            // Validate the attached file
            $request->validate([
                'file_attachment' => 'mimes:pdf,mp3,wav,mp4,avi|max:20480', // Allowed file types and max size of 20MB
            ]);
        
            // Get the uploaded file
            $file = $request->file('file_attachment');
        
            // Generate a unique file name using scorm_id and a random number
            $name = $request->scorm_id . '_file_attachment_' . time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        
            // Use Laravel's Storage facade to store the file in the 'public' disk (which is mapped to 'storage/app/public')
            $filePath = $file->storeAs('file_attachments', $name, 'public'); // 'file_attachments' is a subfolder in 'storage/app/public'
        
            // Save the file path to the 'file_attachment' column in the 'scorms' table
            $scorm->file_attachment = $filePath; // The path will be 'file_attachments/filename.ext'
        }
                
        

        $scorm->save();

        toastr()->success("Record is created Successfully");
        return redirect(url(path: 'TMS'));
    
    }

    public function show($id)
    {
        $scorm = Scorm::find($id);
        return view('frontend.TMS.Scorm.scorm_view', compact('scorm'));
    }


    public function update(Request $request, $id)
    {
        $scorm = Scorm::findOrFail($id);

        $scorm->scorm_id = $request->scorm_id;
        $scorm->short_description = $request->short_description;
        $scorm->validations = $request->validations;

        if ($request->hasFile('file_attachment')) {
            // Validate the attached file
            $request->validate([
                'file_attachment' => 'mimes:pdf,mp3,wav,mp4,avi|max:20480', // Allowed file types and max size of 20MB
            ]);
        
            // Get the uploaded file
            $file = $request->file('file_attachment');
        
            // Generate a unique file name using scorm_id and a random number
            $name = $request->scorm_id . '_file_attachment_' . time() . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        
            // Use Laravel's Storage facade to store the file in the 'public' disk (which is mapped to 'storage/app/public')
            $filePath = $file->storeAs('file_attachments', $name, 'public'); // 'file_attachments' is a subfolder in 'storage/app/public'
        
            // Save the file path to the 'file_attachment' column in the 'scorms' table
            $scorm->file_attachment = $filePath; // The path will be 'file_attachments/filename.ext'
        }
        
        $scorm->save();

        toastr()->success("Record is updated Successfully");
        return back();

    }
}
