<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <style>
    body { 
      font-family: DejaVu Sans, sans-serif; 
      font-size: 12px; 
      background: #f4f4f9;
      color: #111827;
    }
    h1 { 
      text-align: center; 
      color: #002147; 
      margin-bottom: 5px;
    }
    p { 
      text-align: center; 
      color: #6b7280; 
      margin-top: 0; 
      margin-bottom: 10px;
    }
    table { 
      width: 100%; 
      border-collapse: collapse; 
      margin-top: 20px; 
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    th, td { 
      border: 1px solid #d1d5db; 
      padding: 8px 10px; 
      text-align: center; 
    }
    th { 
      background: #002147; 
      color: white; 
      font-weight: bold;
    }
    tr:nth-child(even) { background: #f9fafb; }
    tr:hover { background: #f1f5f9; }
  </style>
</head>
<body>
  <h1>UPTM — My Exam Timetable</h1>
  <p>Lecturer: <strong>{{ $lecturer->name }}</strong></p>

  <table>
    <thead>
      <tr>
       <th>Invigilator(s)</th>
        <th>No of Subject</th>
        <th>Room</th>
        <th>Date</th>
        <th>Start</th>
        <th>End</th>
        <th>Subject</th>
        <th>Subject Code</th>
        <th>Students per Subject</th>
        <th>Course</th> <!-- ✅ New column added here -->
        <th>Total Students</th>
      </tr>
    </thead>
    <tbody>
      @php
        $grouped = collect($personalTimetable)
          ->groupBy(fn($t) => implode(', ', $t->invigilator_list));
      @endphp

      @forelse ($grouped as $invigilator => $group)
        @php
          $totalRows = $group->reduce(fn($carry, $item) => $carry + count($item->subject_list), 0);
          $numSubjects = $group->reduce(fn($carry, $item) => $carry + count($item->subject_list), 0);
          $totalStudents = $group->sum('total_students');
          $printedInvigilator = false;
          $printedSubjectCount = false;
          $printedTotalStudents = false;
        @endphp

        @foreach ($group as $timetable)
          @php
            $subjectCount = count($timetable->subject_list);
            $printedRoomInfo = false;
          @endphp

          @foreach ($timetable->subject_list as $i => $subject)
        <tr>
          @if (!$printedInvigilator)
            <td rowspan="{{ $totalRows }}">{{ $invigilator }}</td>
            @php $printedInvigilator = true; @endphp
          @endif

          @if (!$printedSubjectCount)
            <td rowspan="{{ $totalRows }}">{{ $numSubjects }}</td>
            @php $printedSubjectCount = true; @endphp
          @endif

          @if (!$printedRoomInfo)
            <td rowspan="{{ $subjectCount }}">{{ $timetable->room }}</td>
            <td rowspan="{{ $subjectCount }}">{{ \Carbon\Carbon::parse($timetable->exam_date)->format('d M Y (D)') }}</td>
            <td rowspan="{{ $subjectCount }}">{{ \Carbon\Carbon::parse($timetable->exam_start_time)->format('h:i A') }}</td>
            <td rowspan="{{ $subjectCount }}">{{ \Carbon\Carbon::parse($timetable->exam_end_time)->format('h:i A') }}</td>
            @php $printedRoomInfo = true; @endphp
          @endif

          <td style="text-align:left;">{{ $subject }}</td>
          <td>{{ $timetable->subject_code_list[$i] ?? '-' }}</td>
          <td>{{ $timetable->subject_students_list[$i] ?? '-' }}</td>
          <td>{{ $timetable->course_list[$i] ?? '-' }}</td> <!-- ✅ Added course data -->

          @if (!$printedTotalStudents)
            <td rowspan="{{ $totalRows }}">{{ $totalStudents }}</td>
            @php $printedTotalStudents = true; @endphp
          @endif
        </tr>
      @endforeach
    @endforeach
    @empty
        <tr>
          <td colspan="10" style="text-align:center;">No timetables found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
</body>
</html>
