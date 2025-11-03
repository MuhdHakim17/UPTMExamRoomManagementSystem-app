<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetupTimetableController extends Controller
{
    // 📋 Display all timetables
    public function index()
    {
        $rooms = DB::table('exam_rooms')->select('room_number', 'floor', 'capacity')->get();
        $lecturers = DB::table('lecturers')->get();
        $timetables = DB::table('exam_timetables')->get();

        return view('Setup-Timetable', compact('rooms', 'lecturers', 'timetables'));
    }

    // 💾 Store new timetable
    public function store(Request $request)
    {
        $request->validate([
            'subject_number' => 'required|integer|min:1',
            'room' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // 🛑 Check overlapping schedule
        $overlap = DB::table('exam_timetables')
            ->where('room', $request->room)
            ->where('exam_date', $request->date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('exam_start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('exam_end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('exam_start_time', '<', $request->start_time)
                                ->where('exam_end_time', '>', $request->end_time);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', '❌ This room already has another exam scheduled during that time.');
        }

        // 🧩 Gather all subject info
        $subjects = [];
        $subjectCodes = [];
        $subjectCourses = [];
        $subjectStudents = [];

        for ($i = 1; $i <= $request->subject_number; $i++) {
            $subject = $request->input('subject' . $i);
            $code = $request->input('subject_code' . $i);
            $course = $request->input('subject_course' . $i);
            $students = $request->input('subject_students' . $i);

            if ($subject && $code && $course) {
                $subjects[] = $subject;
                $subjectCodes[] = $code;
                $subjectCourses[] = $course;
                $subjectStudents[] = $students ?? 0;
            }
        }

        // 👩‍🏫 Collect invigilators
        $invigilators = [];
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'invigilator')) {
                $invigilators[] = $value;
            }
        }

        $totalStudents = array_sum($subjectStudents);

        // 💾 Insert record into DB
        DB::table('exam_timetables')->insert([
            'invigilators' => implode(', ', $invigilators),
            'room' => $request->room,
            'exam_date' => $request->date,
            'exam_start_time' => $request->start_time,
            'exam_end_time' => $request->end_time,
            'subject_number' => $request->subject_number,
            'subject' => implode(', ', $subjects),
            'subject_code' => implode(', ', $subjectCodes),
            'course' => implode(', ', $subjectCourses),
            'subject_students' => implode(', ', $subjectStudents),
            'students' => $totalStudents,
        ]);

        return back()->with('success', '✅ Timetable saved successfully!');
    }

    // 🔁 Update timetable
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_number' => 'required|integer|min:1',
            'room' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // 🛑 Prevent overlapping updates
        $overlap = DB::table('exam_timetables')
            ->where('room', $request->room)
            ->where('exam_date', $request->date)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('exam_start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('exam_end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('exam_start_time', '<', $request->start_time)
                                ->where('exam_end_time', '>', $request->end_time);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', '❌ Cannot update. This room already has another exam during that time.');
        }

        // 🧩 Gather updated subject info
        $subjects = [];
        $subjectCodes = [];
        $subjectCourses = [];
        $subjectStudents = [];

        for ($i = 1; $i <= $request->subject_number; $i++) {
            $subject = $request->input('subject' . $i);
            $code = $request->input('subject_code' . $i);
            $course = $request->input('subject_course' . $i);
            $students = $request->input('subject_students' . $i);

            if ($subject && $code && $course) {
                $subjects[] = $subject;
                $subjectCodes[] = $code;
                $subjectCourses[] = $course;
                $subjectStudents[] = $students ?? 0;
            }
        }

        $invigilators = [];
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'invigilator')) {
                $invigilators[] = $value;
            }
        }

        $totalStudents = array_sum($subjectStudents);

        // 💾 Update DB record
        DB::table('exam_timetables')->where('id', $id)->update([
            'invigilators' => implode(', ', $invigilators),
            'room' => $request->room,
            'exam_date' => $request->date,
            'exam_start_time' => $request->start_time,
            'exam_end_time' => $request->end_time,
            'subject_number' => $request->subject_number,
            'subject' => implode(', ', $subjects),
            'subject_code' => implode(', ', $subjectCodes),
            'course' => implode(', ', $subjectCourses),
            'subject_students' => implode(', ', $subjectStudents),
            'students' => $totalStudents,
        ]);

        return redirect()->route('timetable.index')->with('success', '✅ Timetable updated successfully!');
    }

    // 🗑️ Delete timetable
    public function destroy($id)
    {
        DB::table('exam_timetables')->where('id', $id)->delete();
        return back()->with('success', '🗑️ Timetable deleted successfully!');
    }
}
