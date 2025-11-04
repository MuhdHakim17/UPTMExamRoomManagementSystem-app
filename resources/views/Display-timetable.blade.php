<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Lecturer Dashboard | Display Timetable</title>

  <style>
  :root {
    --bg-gradient: linear-gradient(135deg, #002147 0%, #800000 100%);
    --bg: linear-gradient(135deg, #002147 0%, #800000 100%);
    --card: #ffffffff;
    --muted: #6b7280;
    --text: #111827;
    --accent: #800000;
    --accent-2: #002147;
    --border: #d1d5db;
    --shadow: 0 8px 30px rgba(0,0,0,0.1);
  }

  body {
    margin: 0;
    font-family: 'Segoe UI', Roboto, Arial, sans-serif;
    background: var(--bg-gradient);
    color: var(--text);
    min-height: 100vh;
    display: flex;
    background-attachment: fixed;
    animation: fadeIn 0.6s ease-in;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .sidebar {
    width: 240px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    border-right: 1px solid rgba(255,255,255,0.2);
    color: white;
    display: flex;
    flex-direction: column;
    padding: 25px 18px;
    box-shadow: inset -1px 0 0 rgba(255,255,255,0.1);
  }

  .sidebar h2 {
    text-align: center;
    font-size: 1.4rem;
    margin-bottom: 30px;
    border-bottom: 2px solid var(--accent);
    padding-bottom: 10px;
    color: #ffffff;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
  }

  .sidebar a {
    text-decoration: none;
    color: #ffffff;
    padding: 12px 14px;
    border-radius: 8px;
    margin-bottom: 10px;
    display: block;
    font-weight: 500;
    transition: all 0.25s ease;
  }

  .sidebar a:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(3px);
  }

  .sidebar a.active {
    background: var(--accent);
    font-weight: 600;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  }

  .logout-btn {
    background: var(--accent);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.25s ease;
    margin-top: auto;
    text-align: center;
    box-shadow: 0 4px 10px rgba(128,0,0,0.3);
  }

  .logout-btn:hover {
    background: #660000;
    transform: scale(1.03);
  }

  .logout-btn a {
    color: white;
    text-decoration: none;
  }

  .main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: var(--bg);
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow);
  }

  .topbar {
 color: (--bg);
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .topbar h1 {
    font-size: 1.6rem;
    color: var(--card);
    margin: 0;
    font-weight: 700;
  }

  .card {
    background: var(--card);
    border-radius: 20px;
    padding: 30px;
    width: 90%;
    max-width: 1150px;
    margin: 35px auto;
    box-shadow: var(--shadow);
    overflow-x: auto;
    border: 1px solid var(--border);
    transition: transform 0.2s ease;
  }

  .card:hover {
    transform: translateY(-3px);
  }

  h2 {
    font-size: 1.6rem;
    color: var(--accent);
    text-align: center;
    margin-bottom: 20px;
    font-weight: 700;
  }

  /* === TABLE STYLING UNIFIED === */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
    font-size: 0.95rem;
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
  }

  th, td {
    padding: 12px 14px;
    text-align: center;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    background-color: #ffffff; /* unify all table backgrounds */
  }

  th {
    background: var(--accent-2);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
  }

  tr:hover td {
    background: rgba(0,33,71,0.08); /* subtle navy hover */
  }

  a[href*="download"] {
    background: var(--accent);
    color: white !important;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    box-shadow: 0 4px 10px rgba(128,0,0,0.2);
  }

  a[href*="download"]:hover {
    background: #660000;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(128,0,0,0.3);
  }

  .footer {
    text-align: center;
    padding: 18px;
    background: var(--accent-2);
    color: white;
    font-size: 0.9rem;
    margin-top: auto;
    letter-spacing: 0.3px;
  }

  @media (max-width: 768px) {
    .sidebar { display: none; }
    .main-content { width: 100%; border-radius: 0; }
    .card { padding: 20px; width: 95%; }
    th, td { font-size: 0.85rem; padding: 8px; }
  }

  /* view-only tables */
  #personalTimetable,
  #globalTimetable {
    pointer-events: none;
    user-select: none;
    cursor: default;
  }

  #personalTimetable td,
  #personalTimetable th,
  #globalTimetable td,
  #globalTimetable th {
    background-clip: padding-box;
  }
</style>

</head>

<body>
  <div class="sidebar">
    <h2>Exam Room Management</h2>
    <a href="{{ route('lecturer.homepage') }}">🏠 Home</a>
    <a href="{{ route('display.timetable') }}" class="active">📅 Display Timetable</a>
    <a href="{{ route('report.form') }}">📝 Report</a>
    <button class="logout-btn">
      <a href="{{ route('lecturer.logout') }}">Logout</a>
    </button>
  </div>

  <div class="main-content">
    <div class="topbar">
      <h1>UPTM Exam Timetable</h1>
      @if($lecturer)
        <div>Welcome, <strong>{{ $lecturer->name }}</strong></div>
      @endif
    </div>

    <!-- === PERSONAL TIMETABLE === -->
@if($lecturer)
  @php
    // Group the personalTimetable (comes from DisplayTimetableController)
    $grouped = collect($personalTimetable ?? [])->groupBy(fn($t) => implode(', ', $t->invigilator_list));
  @endphp

  <div class="card">
     <div style="display:flex; justify-content:space-between; align-items:center;">
    <h2>My Exam Timetable</h2>
    <a href="{{ route('timetable.download.personal.pdf') }}" 
       style="background:#800000; color:white; padding:10px 16px; border-radius:8px; text-decoration:none; font-weight:600;">
      ⬇️ Download My Timetable PDF
    </a>
    
    <a href="{{ route('timetable.download.students.pdf') }}" 
       style="background:#800000; color:white; padding:10px 16px; border-radius:8px; text-decoration:none; font-weight:600;">
      ⬇️ Students Timetable PDF
    </a>
    </div>

   

    <table id="personalTimetable">
      <thead>
        <tr>
          <th>Invigilator(s)</th>
          <th>No. Subject</th>
          <th>Room</th>
          <th>Date</th>
          <th>Start</th>
          <th>End</th>
          <th>Subject</th>
          <th>Code</th>
          <th>Students per Subject</th>
          <th>Course</th>
          <th>Total Students</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($grouped as $invigilator => $group)
          @php
            $totalRows = $group->reduce(fn($carry, $item) => $carry + count(explode(',', $item->subject)), 0);
            $numSubjects = $group->reduce(fn($carry, $item) => $carry + count(explode(',', $item->subject)), 0);
            $totalStudents = $group->sum('students');
            $printedInvigilator = $printedSubjectCount = $printedRoom = $printedDate = $printedStart = $printedEnd = $printedTotalStudents = false;
          @endphp

          @foreach ($group as $timetable)
            @php
              $subjects = array_map('trim', explode(',', $timetable->subject));
              $codes = array_map('trim', explode(',', $timetable->subject_code));
              $studentsList = array_map('trim', explode(',', $timetable->subject_students ?? ''));
              $courses = array_map('trim', explode(',', $timetable->course ?? ''));
            @endphp

            @foreach ($subjects as $i => $subject)
              <tr>
                @if (!$printedInvigilator)
                  <td rowspan="{{ $totalRows }}">{{ $invigilator }}</td>
                  @php $printedInvigilator = true; @endphp
                @endif

                @if (!$printedSubjectCount)
                  <td rowspan="{{ $totalRows }}">{{ $numSubjects }}</td>
                  @php $printedSubjectCount = true; @endphp
                @endif

                @if (!$printedRoom)
                  <td rowspan="{{ $totalRows }}">{{ $timetable->room }}</td>
                  @php $printedRoom = true; @endphp
                @endif

                @if (!$printedDate)
                  <td rowspan="{{ $totalRows }}">{{ \Carbon\Carbon::parse($timetable->exam_date)->format('l, d-m-Y') }}</td>
                  @php $printedDate = true; @endphp
                @endif

                @if (!$printedStart)
                  <td rowspan="{{ $totalRows }}">{{ \Carbon\Carbon::parse($timetable->exam_start_time)->format('h:i A') }}</td>
                  @php $printedStart = true; @endphp
                @endif

                @if (!$printedEnd)
                  <td rowspan="{{ $totalRows }}">{{ \Carbon\Carbon::parse($timetable->exam_end_time)->format('h:i A') }}</td>
                  @php $printedEnd = true; @endphp
                @endif

                <td style="text-align:left;">{{ $subject }}</td>
                <td>{{ $codes[$i] ?? '-' }}</td>
                <td>{{ $studentsList[$i] ?? '-' }}</td>
                <td>{{ $courses[$i] ?? '-' }}</td>

                @if (!$printedTotalStudents)
                  <td rowspan="{{ $totalRows }}">{{ $totalStudents }}</td>
                  @php $printedTotalStudents = true; @endphp
                @endif
              </tr>
            @endforeach
          @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
@else
  <div class="card" style="text-align:center; color:#6b7280;">
    <h2>My Exam Timetable</h2>
    <p><strong>Please log in</strong> to view your personal exam timetable.</p>
  </div>
@endif


    <!-- === ALL TIMETABLES === -->
    @php
      // Group allTimetables for the global view
      $grouped = collect($allTimetables ?? [])->groupBy(fn($t) => implode(', ', $t->invigilator_list));
    @endphp

    <div class="card">
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>All Exam Timetables</h2>
        <a href="{{ route('timetable.download.pdf') }}" 
           style="background:#800000; color:white; padding:10px 16px; border-radius:8px; text-decoration:none; font-weight:600;">
          ⬇️ Download All Timetables PDF
        </a>
      </div>

     

      <table id="globalTimetable">
        <thead>
          <tr>
            <th>Invigilator(s)</th>
            <th>No. Subject</th>
            <th>Room</th>
            <th>Date</th>
            <th>Start</th>
            <th>End</th>
            <th>Subject</th>
            <th>Code</th>
            <th>Students per Subject</th>
            <th>Course</th>
            <th>Total Students</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($grouped as $invigilator => $group)
            @php
              $totalRows = $group->reduce(fn($carry, $item) => $carry + count(explode(',', $item->subject)), 0);
              $numSubjects = $group->reduce(fn($carry, $item) => $carry + count(explode(',', $item->subject)), 0);
              $totalStudents = $group->sum('students');
              $printedInvigilator = $printedSubjectCount = $printedRoom = $printedDate = $printedStart = $printedEnd = $printedTotalStudents = false;
            @endphp

            @foreach ($group as $timetable)
              @php
                $subjects = array_map('trim', explode(',', $timetable->subject));
                $codes = array_map('trim', explode(',', $timetable->subject_code));
                $studentsList = array_map('trim', explode(',', $timetable->subject_students ?? ''));
                $courses = array_map('trim', explode(',', $timetable->course ?? ''));
              @endphp

              @foreach ($subjects as $i => $subject)
                <tr>
                  @if (!$printedInvigilator)
                    <td rowspan="{{ $totalRows }}">{{ $invigilator }}</td>
                    @php $printedInvigilator = true; @endphp
                  @endif

                  @if (!$printedSubjectCount)
                    <td rowspan="{{ $totalRows }}">{{ $numSubjects }}</td>
                    @php $printedSubjectCount = true; @endphp
                  @endif

                  @if (!$printedRoom)
                    <td rowspan="{{ $totalRows }}">{{ $timetable->room }}</td>
                    @php $printedRoom = true; @endphp
                  @endif

                  @if (!$printedDate)
                    <td rowspan="{{ $totalRows }}">{{ \Carbon\Carbon::parse($timetable->exam_date)->format('l, d-m-Y') }}</td>
                    @php $printedDate = true; @endphp
                  @endif

                  @if (!$printedStart)
                    <td rowspan="{{ $totalRows }}">{{ \Carbon\Carbon::parse($timetable->exam_start_time)->format('h:i A') }}</td>
                    @php $printedStart = true; @endphp
                  @endif

                  @if (!$printedEnd)
                    <td rowspan="{{ $totalRows }}">{{ \Carbon\Carbon::parse($timetable->exam_end_time)->format('h:i A') }}</td>
                    @php $printedEnd = true; @endphp
                  @endif

                  <td style="text-align:left;">{{ $subject }}</td>
                  <td>{{ $codes[$i] ?? '-' }}</td>
                  <td>{{ $studentsList[$i] ?? '-' }}</td>
                  <td>{{ $courses[$i] ?? '-' }}</td>

                  @if (!$printedTotalStudents)
                    <td rowspan="{{ $totalRows }}">{{ $totalStudents }}</td>
                    @php $printedTotalStudents = true; @endphp
                  @endif
                </tr>
              @endforeach
            @endforeach
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="footer">
      © {{ date('Y') }} UPTM Exam Management System — Lecturer Portal
    </div>
  </div>

  <script>
    function filterTable(tableId, term, colIndex) {
      const rows = document.querySelectorAll(`#${tableId} tbody tr`);
      rows.forEach(row => {
        const cell = row.cells[colIndex];
        if (cell) {
          const text = cell.textContent.toLowerCase();
          row.style.display = text.includes(term.toLowerCase()) ? "" : "none";
        }
      });
    }

    document.getElementById("personalSearchSubject").addEventListener("keyup", () => {
      filterTable("personalTimetable", event.target.value, 6);
    });
    document.getElementById("personalSearchInvigilator").addEventListener("keyup", () => {
      filterTable("personalTimetable", event.target.value, 0);
    });
    document.getElementById("searchSubject").addEventListener("keyup", () => {
      filterTable("globalTimetable", event.target.value, 6);
    });
    document.getElementById("searchInvigilator").addEventListener("keyup", () => {
      filterTable("globalTimetable", event.target.value, 0);
    });
  </script>
</body>
</html>
