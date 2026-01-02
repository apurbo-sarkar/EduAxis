<?php

namespace App\Http\Controllers;

use App\Models\StudyMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudyMaterialController extends Controller
{
    // 📌 List all materials (optional filters)
    public function index()
    {
        $materials = \App\Models\StudyMaterial::orderBy('class')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('class');

    return view('teacher.studymaterials', compact('materials'));
    }


    // 📌 Upload study material
   public function store(Request $request)
    {
        $request->validate([
            'class' => 'required|integer|min:1|max:10',
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'file' => 'required|file|max:10240', // 10MB
        ]);

        $file = $request->file('file');
        $filePath = $file->store('study_materials', 'public');

        $material = new \App\Models\StudyMaterial();
        $material->class = $request->class;
        $material->title = $request->title;
        $material->subject = $request->subject;
        $material->file_path = $filePath;
        $material->file_type = $file->getClientOriginalExtension();
        $material->save();

        // Redirect back to the same page with success message
        return redirect()->back()->with('success', 'Study material uploaded successfully!');
    }


    // 📌 Delete material
    public function destroy($id)
    {
        $material = \App\Models\StudyMaterial::findOrFail($id);

        // Delete the file from storage
        if (\Storage::disk('public')->exists($material->file_path)) {
            \Storage::disk('public')->delete($material->file_path);
        }

        // Delete the database record
        $material->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Study material deleted successfully!');
    }

}
