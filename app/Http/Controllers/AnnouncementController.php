<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('publish_at', 'desc')->get();

        return view('student.announcement', compact('announcements'));
    }
}

