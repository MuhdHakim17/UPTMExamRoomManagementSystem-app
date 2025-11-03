<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Setup Timetable | Admin Dashboard</title>

  <style>
    :root {
      --bg: #f4f4f9;
      --card: #ffffff;
      --muted: #6b7280;
      --text: #111827;
      --accent: #800000;   /* UPTM Red */
      --accent-2: #002147; /* UPTM Blue */
      --border: #d1d5db;
      --ring: #800000;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .sidebar {
      width: 250px;
      background: var(--accent-2);
      color: white;
      display: flex;
      flex-direction: column;
      padding: 20px 0;
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 1.4rem;
      color: #fff;
      border-bottom: 2px solid var(--accent);
      padding-bottom: 10px;
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      padding: 12px 25px;
      display: block;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .sidebar a:hover {
      background: var(--accent);
    }

    .sidebar a.active {
      background: var(--accent);
      font-weight: 600;
    }

    .sidebar .logout {
      margin-top: auto;
      background: var(--accent);
      text-align: center;
      padding: 12px;
      border-top: 1px solid rgba(255,255,255,0.2);
    }

    .sidebar .logout a {
      color: white;
      text-decoration: none;
      font-weight: 600;
    }

    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      padding: 40px;
    }

    .topbar {
      background: var(--card);
      border-bottom: 1px solid var(--border);
      padding: 14px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .topbar h1 {
      font-size: 1.5rem;
      color: var(--accent-2);
      margin: 0;
    }

    .container {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 30px;
      max-width: 1250px;
      width: 100%;
      box-shadow: 0 6px 25px rgba(0,0,0,.1);
      margin: 40px auto;
    }

    h2 {
      text-align: center;
      color: var(--accent-2);
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      color: var(--muted);
      font-weight: 500;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid var(--border);
      font-size: 1rem;
    }

    input:focus, select:focus {
      border-color: var(--ring);
      box-shadow: 0 0 0 3px rgba(128,0,0,.2);
      outline: none;
    }

    .actions {
      display: flex;
      gap: 12px;
      justify-content: center;
      margin-top: 20px;
    }

    button {
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      cursor: pointer;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.2s ease;
    }

    button.primary {
      background: var(--accent);
      color: white;
    }

    button.primary:hover {
      background: #660000;
    }

    button.secondary {
      background: var(--accent-2);
      color: white;
    }

    button.secondary:hover {
      background: #001a3d;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid var(--border);
    }

    th {
      background: var(--accent-2);
      color: white;
    }

    .btn-edit {
      background: #f59e0b;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn-delete {
      background: #dc2626;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn-edit:hover { background: #d97706; }
    .btn-delete:hover { background: #b91c1c; }

    @media (max-width: 768px) {
      .sidebar { width: 200px; }
      .main-content { padding: 20px; }
      .container { padding: 25px; }
    }
  </style>
</head>
<body>
  <aside class="sidebar">
    <h2>Exam Room Management</h2>
    <a href="{{ route('admin.homepage') }}">🏠 Home</a>
    <a href="{{ route('examroom.index') }}">🏫 Setup Exam Room</a>
    <a href="{{ route('timetable.index') }}" class="active">📅 Setup Timetable</a>
    <a href="{{ route('receiving.report') }}">📝 Report</a>
    <div class="logout">
      <a href="{{ route('admin.logout') }}">🚪 Logout</a>
    </div>
  </aside>

  <div class="main-content">
    <div class="topbar">
      <h1>UPTM Exam Timetable</h1>
    </div>

    <div class="container">
      <h2>Setup Timetable</h2>

      <!-- Flash messages -->
      @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:10px 15px;border-radius:8px;margin-bottom:10px;">
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:10px 15px;border-radius:8px;margin-bottom:10px;">
          {{ session('error') }}
        </div>
      @endif

      <!-- Form -->
      <form id="timetableForm" method="POST" action="{{ route('setup.timetable.store') }}">
        @csrf
        <input type="hidden" name="id" id="timetable-id">
        <label for="subject_number">Number of Subjects</label>
        <select name="subject_number" id="subject_number" onchange="generateSubjectInputs()" required>
          <option value="">Select number of subjects...</option>
          <option value="1">1</option><option value="2">2</option>
          <option value="3">3</option><option value="4">4</option><option value="5">5</option>
        </select>
        <div id="subjectsContainer"></div>

        <label for="room">Room</label>
        <select name="room" id="room" required onchange="updateStudentsCapacity()">
          <option value="">Select Room...</option>
          @foreach($rooms as $room)
            <option value="{{ $room->room_number }}" data-capacity="{{ $room->capacity }}">
              {{ $room->room_number }} ({{ $room->floor }}) - Capacity: {{ $room->capacity }}
            </option>
          @endforeach
        </select>

        <label for="students">Total Number of Students</label>
        <input type="number" name="students" id="students" readonly required>

        <label for="date">Date</label>
        <input type="date" name="date" id="date" required>

        <label for="start_time">Start Time</label>
        <input type="time" name="start_time" id="start_time" required>

        <label for="end_time">End Time</label>
        <input type="time" name="end_time" id="end_time" required>

        <label for="numInvigilators">Number of Invigilators</label>
        <select name="numInvigilators" id="numInvigilators" onchange="generateInvigilatorInputs()">
          <option value="0">Select...</option><option value="1">1</option><option value="2">2</option>
          <option value="3">3</option><option value="4">4</option>
        </select>
        <div id="invigilatorsContainer"></div>

        <div class="actions">
          <button type="button" class="secondary" onclick="autoAssign()">Auto Assign</button>
          <button type="submit" class="primary" id="submit-btn">Save</button>
          <button type="button" class="primary" id="cancel-btn" style="background:#6b7280; display:none;" onclick="cancelEdit()">Cancel</button>
        </div>
      </form>

@php $grouped = collect($timetables)->groupBy('invigilators'); @endphp
<!-- === Table === -->
<!-- === Table === -->
<table id="timetable">
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
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($grouped as $invigilator => $group)
      @php
        $totalRows = $group->reduce(fn($carry, $item) => $carry + count(explode(',', $item->subject)), 0);
        $numSubjects = $group->reduce(fn($carry, $item) => $carry + count(explode(',', $item->subject)), 0);
        $totalStudents = $group->sum(fn($item) => array_sum(array_map('intval', explode(',', $item->subject_students ?? '0'))));
        $printedInvigilator = false;
        $printedSubjectCount = false;
        $printedRoom = false;
        $printedDate = false;
        $printedStart = false;
        $printedEnd = false;
        $printedTotalStudents = false;
        $printedActions = false;
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
              <td rowspan="{{ $totalRows }}">
                {{ \Carbon\Carbon::parse($timetable->exam_date)->format('l, Y-m-d') }}
              </td>
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

            <td>{{ $subject }}</td>
            <td>{{ $codes[$i] ?? '-' }}</td>
            <td>{{ $studentsList[$i] ?? '-' }}</td>
            <td>{{ $courses[$i] ?? '-' }}</td>

            @if (!$printedTotalStudents)
              <td rowspan="{{ $totalRows }}">{{ $totalStudents }}</td>
              @php $printedTotalStudents = true; @endphp
            @endif

            @if (!$printedActions)
              <td rowspan="{{ $totalRows }}">
                <button type="button" class="btn-edit"
                  onclick="editTimetable(
                    '{{ $timetable->id }}',
                    '{{ $timetable->subject }}',
                    '{{ $timetable->subject_code }}',
                    '{{ $timetable->room }}',
                    '{{ $timetable->exam_date }}',
                    '{{ $timetable->exam_start_time }}',
                    '{{ $timetable->exam_end_time }}',
                    '{{ $timetable->students }}',
                    '{{ $timetable->subject_students }}',
                    '{{ $timetable->course ?? '' }}',
                    '{{ $timetable->invigilators }}'
                  )">
                  Edit
                </button>

                <form action="{{ route('setup.timetable.delete', $timetable->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-delete" onclick="return confirm('Delete this record?')">
                    Delete
                  </button>
                </form>
              </td>
              @php $printedActions = true; @endphp
            @endif
          </tr>
        @endforeach
      @endforeach
    @endforeach
  </tbody>
</table>



    </div>
  </div>

<script>
const availableInvigilators = @json($lecturers->pluck('name') ?? []);

// 🧩 Generate Subject + Code + Course + Student inputs dynamically
function generateSubjectInputs(subjects = [], codes = [], courses = [], students = []) {
  const container = document.getElementById("subjectsContainer");
  container.innerHTML = "";
  const num = parseInt(document.getElementById("subject_number").value);

  for (let i = 1; i <= num; i++) {
    // Subject name
    const subjectLabel = document.createElement("label");
    subjectLabel.textContent = "Subject " + i;
    const subjectInput = document.createElement("input");
    subjectInput.type = "text";
    subjectInput.name = "subject" + i;
    subjectInput.placeholder = "Enter Subject " + i;
    subjectInput.required = true;
    subjectInput.value = subjects[i - 1] || "";

    // Subject code
    const codeLabel = document.createElement("label");
    codeLabel.textContent = "Subject " + i + " Code";
    const codeInput = document.createElement("input");
    codeInput.type = "text";
    codeInput.name = "subject_code" + i;
    codeInput.placeholder = "Enter Subject Code " + i;
    codeInput.required = true;
    codeInput.value = codes[i - 1] || "";

    // 🆕 Subject course
    const courseLabel = document.createElement("label");
    courseLabel.textContent = "Subject " + i + " Course";
    const courseInput = document.createElement("input");
    courseInput.type = "text";
    courseInput.name = "subject_course" + i;
    courseInput.placeholder = "Enter Course Name";
    courseInput.required = true;
    courseInput.value = courses[i - 1] || "";

    // Students for subject
    const studentLabel = document.createElement("label");
    studentLabel.textContent = "Students for Subject " + i;
    const studentInput = document.createElement("input");
    studentInput.type = "number";
    studentInput.name = "subject_students" + i;
    studentInput.placeholder = "Enter number of students";
    studentInput.min = "1";
    studentInput.required = true;
    studentInput.value = students[i - 1] || "";
    studentInput.addEventListener('input', updateTotalStudents);

    container.appendChild(subjectLabel);
    container.appendChild(subjectInput);
    container.appendChild(codeLabel);
    container.appendChild(codeInput);
    container.appendChild(courseLabel);
    container.appendChild(courseInput);
    container.appendChild(studentLabel);
    container.appendChild(studentInput);
  }
}

// 🧑‍🏫 Generate Invigilator dropdowns
function generateInvigilatorInputs(selected = []) {
  const container = document.getElementById("invigilatorsContainer");
  container.innerHTML = "";
  const num = parseInt(document.getElementById("numInvigilators").value);

  for (let i = 1; i <= num; i++) {
    const label = document.createElement("label");
    label.textContent = "Invigilator " + i;

    const select = document.createElement("select");
    select.name = "invigilator" + i;
    select.required = true;

    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select Invigilator " + i;
    select.appendChild(defaultOption);

    availableInvigilators.forEach(name => {
      const option = document.createElement("option");
      option.value = name;
      option.textContent = name;
      if (selected[i - 1] === name) option.selected = true;
      select.appendChild(option);
    });

    container.appendChild(label);
    container.appendChild(select);
  }
}

// 🎓 Auto-fill students based on room capacity
function updateStudentsCapacity() {
  const roomSelect = document.getElementById('room');
  const selectedOption = roomSelect.options[roomSelect.selectedIndex];
  const capacity = Number(selectedOption.getAttribute('data-capacity')) || 0;
  
  const totalStudentsInput = document.getElementById('students');
  totalStudentsInput.value = capacity; // Auto-fill
  totalStudentsInput.setAttribute('max', capacity); // Set max
}


function updateTotalStudents() {
  const inputs = document.querySelectorAll('[name^="subject_students"]');
  let total = 0;
  inputs.forEach(input => {
    total += Number(input.value) || 0;
  });

  const totalStudentsInput = document.getElementById("students");
  const max = Number(totalStudentsInput.getAttribute('max')) || 0;

  // 🚨 Check against room capacity
  if (max > 0 && total > max) {
    alert(`⚠️ Total students (${total}) exceed room capacity (${max}). Please adjust.`);
    totalStudentsInput.value = max;
  } else {
    totalStudentsInput.value = total;
  }
}

// 🔀 Auto-assign invigilators randomly
function autoAssign() {
  const selects = document.querySelectorAll("#invigilatorsContainer select");
  if (!selects.length) {
    alert("⚠️ Please select number of invigilators first.");
    return;
  }

  const shuffled = [...availableInvigilators].sort(() => Math.random() - 0.5);
  selects.forEach((select, index) => {
    select.value = shuffled[index % shuffled.length];
  });
}

// ✏️ Edit button logic — UPDATED to accept subjectCoursesStr and pass to generateSubjectInputs
function editTimetable(id, subjectsStr, codesStr, room, date, start_time, end_time, totalStudents, subjectStudentsStr, subjectCoursesStr, invigilatorsStr) {
  const subjects = subjectsStr ? subjectsStr.split(',').map(s => s.trim()) : [];
  const codes = codesStr ? codesStr.split(',').map(s => s.trim()) : [];
  const students = subjectStudentsStr ? subjectStudentsStr.split(',').map(s => s.trim()) : [];
  const courses = subjectCoursesStr ? subjectCoursesStr.split(',').map(s => s.trim()) : [];
  const invigilators = invigilatorsStr ? invigilatorsStr.split(',').map(s => s.trim()) : [];

  const subjectCount = subjects.length;

  document.getElementById('timetable-id').value = id;
  document.getElementById('subject_number').value = subjectCount;

  // Regenerate subject fields with proper values (subjects, codes, courses, students)
  generateSubjectInputs(subjects, codes, courses, students);

  document.getElementById('room').value = room;
  document.getElementById('date').value = date;
  document.getElementById('start_time').value = start_time;
  document.getElementById('end_time').value = end_time;
  document.getElementById('students').value = totalStudents;

  // Set invigilators if available
  document.getElementById('numInvigilators').value = invigilators.length;
  generateInvigilatorInputs(invigilators);

  // Change form action and button text
  const form = document.getElementById('timetableForm');
  form.action = `/setup-timetable/update/${id}`;
  document.getElementById('submit-btn').textContent = "Update Timetable";
  document.getElementById('cancel-btn').style.display = "inline-block";
}

// ❌ Cancel edit
function cancelEdit() {
  const form = document.getElementById('timetableForm');
  form.reset();
  document.getElementById("subjectsContainer").innerHTML = "";
  document.getElementById("invigilatorsContainer").innerHTML = "";
  form.action = "{{ route('setup.timetable.store') }}";
  document.getElementById('submit-btn').textContent = "Save";
  document.getElementById('cancel-btn').style.display = "none";
}
</script>