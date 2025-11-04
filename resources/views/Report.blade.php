<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Report Issue | Lecturer Dashboard</title>

  <style>
    :root {
      --bg-gradient: linear-gradient(135deg, #002147 0%, #800000 100%);
      --card: #ffffffff;
      --muted: #6b7280;
      --text: #111827;
      --accent: #800000;
      --accent-2: #002147;
      --border: #d1d5db;
      --shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Roboto, Arial, sans-serif;
      background: var(--bg-gradient);
      color: var(--text);
      display: flex;
      min-height: 100vh;
      background-attachment: fixed;
      animation: fadeIn 0.6s ease-in; /* ✨ added smooth fade-in like timetable */
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Sidebar */
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
      animation: fadeIn 0.8s ease-in; /* ✨ animate sidebar as well */
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

    .sidebar .logout {
      margin-top: auto;
      background: var(--accent);
      text-align: center;
      padding: 12px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(128,0,0,0.3);
      transition: all 0.3s ease;
    }

    .sidebar .logout:hover {
      background: #660000;
      transform: scale(1.03);
    }

    .sidebar .logout a {
      color: white;
      text-decoration: none;
      font-weight: 600;
    }

    /* Main content area */
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      background: var(--bg-gradient);
      border-top-left-radius: 20px;
      border-bottom-left-radius: 20px;
      box-shadow: var(--shadow);
      animation: fadeIn 0.8s ease-in; /* ✨ animate main content */
    }

    /* Topbar */
    .topbar {
     color: (--bg-gradient);
      padding: 18px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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

    /* Card containers */
    .container {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 30px;
      width: 90%;
      max-width: 1100px;
      margin: 35px auto;
      box-shadow: var(--shadow);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      animation: fadeIn 1s ease-in; /* ✨ container fade-in effect */
    }

    .container:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: var(--accent);
      margin-bottom: 25px;
      font-weight: 700;
    }

    label {
      display: block;
      margin-bottom: 6px;
      color: var(--muted);
      font-weight: 500;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid var(--border);
      font-size: 1rem;
      background-color: #ffffff;
    }

    button {
      background: var(--accent);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
      box-shadow: 0 4px 12px rgba(128,0,0,0.25);
    }

    button:hover {
      background: #660000;
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(128,0,0,0.35);
    }

    /* Table Styling */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px 14px;
      border-bottom: 1px solid var(--border);
      text-align: center;
      background-color: #ffffff;
    }

    th {
      background: var(--accent-2);
      color: white;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }

    tr:hover td {
      background: rgba(0,33,71,0.08);
    }

    .status-pending {
      color: #b45309;
      font-weight: bold;
    }

    .status-accepted {
      color: #16a34a;
      font-weight: bold;
    }

    @media (max-width: 768px) {
      .sidebar { display: none; }
      .main-content { width: 100%; border-radius: 0; }
      .container { width: 95%; padding: 20px; }
      th, td { font-size: 0.85rem; padding: 8px; }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>Exam Room Management</h2>
    <a href="{{ route('lecturer.homepage') }}">🏠 Home</a>
    <a href="{{ route('display.timetable') }}">📅 Display Timetable</a>
    <a href="{{ route('report.index') }}" class="active">📝 Report Issue</a>
    <div class="logout">
      <a href="{{ route('lecturer.logout') }}">🚪 Logout</a>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="main-content">
    <div class="topbar">
      <h1>UPTM Exam Report</h1>
      <span>Welcome, {{ $lecturer->name }}</span>
    </div>

    <div class="container">
      <h2>Submit New Report</h2>

      @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:10px 15px;border-radius:8px;margin-bottom:10px;">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('report.submit') }}">
        @csrf

        <label>Your Name</label>
        <input name="reporter" value="{{ $lecturer->name }}" readonly>

        <label>Subject</label>
        <input name="subject" required>

        <label>Subject Code</label>
        <input name="subjectCode" required>

        <label>Room</label>
        <select name="room" required>
          <option value="">Select Room</option>
          @foreach ($rooms as $room)
            <option value="{{ $room->room_number }}">{{ $room->room_number }}</option>
          @endforeach
        </select>

        <label>Date</label>
        <input type="date" name="date" required>

        <label>Start Time</label>
        <input type="time" name="start_time" required>

        <label>End Time</label>
        <input type="time" name="end_time" required>

        <label>Category</label>
        <select name="category" required>
          <option value="">Select Category</option>
          <option>Technical</option>
          <option>Attendance</option>
          <option>Discipline</option>
          <option>Other</option>
        </select>

        <label>Details</label>
        <textarea name="details" required></textarea>

        <div style="text-align:center;">
          <button type="submit">Submit Report</button>
        </div>
      </form>
    </div>

    <div class="container">
      <h2>My Submitted Reports</h2>

      <table>
        <thead>
          <tr>
            <th>Subject</th>
            <th>Subject Code</th>
            <th>Room</th>
            <th>Date</th>
            <th>Start</th>
            <th>End</th>
            <th>Category</th>
            <th>Details</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $report)
            <tr>
              <td>{{ $report->subject }}</td>
              <td>{{ $report->subject_code }}</td>
              <td>{{ $report->room }}</td>
              <td>{{ $report->date }}</td>
              <td>{{ $report->start_time }}</td>
              <td>{{ $report->end_time }}</td>
              <td>{{ $report->category }}</td>
              <td>{{ $report->details }}</td>
              <td>
                @if($report->status === 'Accepted')
                  <span class="status-accepted">Accepted</span>
                @else
                  <span class="status-pending">Pending</span>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="9">No reports submitted yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
