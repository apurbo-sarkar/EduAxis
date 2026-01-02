<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    // Show all assignments
    public function index()
    {
        $assignments = Assignment::latest()->get();
        return view('teacher.assignmentindex', compact('assignments'));
    }

    // Show create form
    public function create()
    {
        return view('teacher.createassignment');
    }

    // Store assignment with file
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'class' => 'required|integer|between:1,10',
            'file'  => 'required|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'due_date' => 'nullable|date',
        ]);

        $filePath = $request->file('file')->store('assignments', 'public');

        Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'class' => $request->class,
            'file_path' => $filePath,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('teacher.assignmentindex')
                         ->with('success', 'Assignment created successfully');
    }

    // Download assignment file
    public function download($id)
    {
        $assignment = Assignment::findOrFail($id);
        return Storage::disk('public')->download($assignment->file_path);
    }

    // Delete assignment
    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);

        Storage::disk('public')->delete($assignment->file_path);
        $assignment->delete();

        return redirect()->route('teacher.assignmentindex')
                         ->with('success', 'Assignment deleted successfully');
    }
}
