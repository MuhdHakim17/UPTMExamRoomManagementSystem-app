<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show the lecturer report page with form + submitted reports.
     */
    public function create()
    {
        // Get lecturer ID from session
        $lecturerId = session('lecturer_id');

        if (!$lecturerId) {
            return redirect()->route('lecturer.login')->with('error', 'Please log in first.');
        }

        $lecturer = DB::table('lecturers')->where('lecturer_id', $lecturerId)->first();
        if (!$lecturer) {
            return redirect()->route('lecturer.login')->with('error', 'Lecturer not found.');
        }

        // Get exam rooms
        $rooms = DB::table('exam_rooms')->select('room_number')->get();

        // Get reports submitted by this lecturer
        $reports = DB::table('reports')
            ->where('name', $lecturer->name)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Report', compact('rooms', 'lecturer', 'reports'));
    }

    /**
     * Store a newly submitted report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reporter' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'subjectCode' => 'required|string|max:50',
            'room' => 'required|string|max:50',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'category' => 'required|string|max:100',
            'details' => 'required|string',
        ]);

        DB::table('reports')->insert([
            'name' => $request->reporter,
            'subject' => $request->subject,
            'subject_code' => $request->subjectCode,
            'room' => $request->room,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'category' => $request->category,
            'details' => $request->details,
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('report.index')->with('success', 'Report submitted successfully!');
    }

    /**
     * Admin view (combined report page).
     */
    public function index()
    {
        // Show all reports for admin
        $reports = DB::table('reports')->orderBy('date', 'desc')->get();
        return view('Receiving-Report', compact('reports'));
    }

    /**
     * Accept a report (admin action) — sets status = 'Accepted'
     */
    public function accept($id)
    {
        $affected = DB::table('reports')->where('id', $id)->update([
            'status' => 'Accepted',
            'updated_at' => now()
        ]);

        if ($affected) {
            return redirect()->route('receiving.report')->with('success', 'Report accepted.');
        }

        return redirect()->route('receiving.report')->with('error', 'Report not found or failed to update.');
    }

    /**
     * Remove a report (admin action)
     */
    public function destroy($id)
    {
        $deleted = DB::table('reports')->where('id', $id)->delete();

        if ($deleted) {
            return redirect()->route('receiving.report')->with('success', 'Report removed.');
        }

        return redirect()->route('receiving.report')->with('error', 'Report not found or failed to delete.');
    }
}
