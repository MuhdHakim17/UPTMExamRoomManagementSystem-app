<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DisplayTimetableController extends Controller
{
    public function index(Request $request)
    {
        // 🔹 Get lecturer from session (if any)
        $lecturerId = session('lecturer_id');
        $lecturer = $lecturerId
            ? DB::table('lecturers')->where('lecturer_id', $lecturerId)->first()
            : null;

        // 🔹 Personal Timetable (if lecturer exist)
        $personalTimetable = collect();
        if ($lecturer) {
            $personalTimetable = DB::table('exam_timetables')
                ->where('invigilators', 'LIKE', '%' . $lecturer->name . '%')
                ->orderBy('exam_date')
                ->get()
                ->map(fn($row) => $this->formatTimetableRow($row));
        }

        // 🔹 All Timetables
        $allTimetables = DB::table('exam_timetables')
            ->orderBy('exam_date')
            ->get()
            ->map(fn($row) => $this->formatTimetableRow($row));

        // --- Provide $timetables for blade compatibility (if blade expects it)
        $timetables = $allTimetables;

        // --- Compute grouped collection (group by invigilator list string)
        $grouped = collect($timetables ?? $personalTimetable)
            ->groupBy(fn($t) => implode(', ', $t->invigilator_list));

        return view('Display-timetable', compact(
            'lecturer',
            'personalTimetable',
            'allTimetables',
            'timetables',
            'grouped'
        ));
    }

    private function formatTimetableRow($row)
    {
        // split per-subject fields into arrays (safe with null checks)
        $row->subject_list = is_null($row->subject) ? [] : array_map('trim', explode(',', $row->subject));
        $row->subject_number_list = is_null($row->subject_number) ? [] : array_map('trim', explode(',', $row->subject_number));
        $row->subject_code_list = is_null($row->subject_code) ? [] : array_map('trim', explode(',', $row->subject_code));
        $row->subject_students_list = is_null($row->subject_students) ? [] : array_map('trim', explode(',', $row->subject_students));
        $row->invigilator_list = is_null($row->invigilators) ? [] : array_map('trim', explode(',', $row->invigilators));
        $row->total_students = $row->students ?? 0;

        // ✅ FIXED: properly detect and split course/subject_courses columns
        if (property_exists($row, 'course') && !is_null($row->course)) {
            $row->course_list = array_map('trim', explode(',', $row->course));
        } elseif (property_exists($row, 'subject_courses') && !is_null($row->subject_courses)) {
            $row->course_list = array_map('trim', explode(',', $row->subject_courses));
        } else {
            $row->course_list = [];
        }

        return $row;
    }

    // PDF: All Exam Timetables
    public function downloadAllTimetablesPDF()
    {
        $timetables = DB::table('exam_timetables')
            ->orderBy('exam_date')
            ->get()
            ->map(fn($row) => $this->formatTimetableRow($row));

        $html = view('PDF.all-timetables', compact('timetables'))->render();
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('All_Exam_Timetables.pdf');
    }

    // PDF: Personal Timetable
    public function downloadPersonalTimetablePDF()
    {
        $lecturerId = session('lecturer_id');
        $lecturer = DB::table('lecturers')->where('lecturer_id', $lecturerId)->first();

        $personalTimetable = DB::table('exam_timetables')
            ->where('invigilators', 'LIKE', '%' . $lecturer->name . '%')
            ->orderBy('exam_date')
            ->get()
            ->map(fn($row) => $this->formatTimetableRow($row));

        $html = view('PDF.personal-timetables', compact('lecturer', 'personalTimetable'))->render();
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('My_Exam_Timetable.pdf');
    }
    // PDF: Student Timetable
public function downloadStudentTimetablePDF(Request $request)
{
    $studentName = $request->input('student_name'); // You can pass this dynamically
    $timetables = DB::table('exam_timetables')
        ->orderBy('exam_date')
        ->get()
        ->map(fn($row) => $this->formatTimetableRow($row));

    // Filter timetables that include this student name in the subject_students_list
    $studentTimetables = $timetables->filter(function ($row) use ($studentName) {
        return collect($row->subject_students_list)
            ->contains(fn($students) => str_contains($students, $studentName));
    });

    $html = view('PDF.students-timetables', [
        'studentName' => $studentName,
        'studentTimetables' => $studentTimetables,
    ])->render();

    $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
    return $pdf->download("Students_Exam_Timetable.pdf");
}

}
