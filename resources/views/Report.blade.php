<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Report Issue | Lecturer Dashboard</title>

  <style>
    :root {
      --bg: #f4f4f9;
      --card: #ffffff;
      --muted: #6b7280;
      --text: #111827;
      --accent: #800000;
      --accent-2: #002147;
      --border: #d1d5db;
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
      box-shadow: 4px 0 10px rgba(0,0,0,0.2);
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

    .sidebar a:hover { background: var(--accent); }
    .sidebar a.active { background: var(--accent); font-weight: 600; }
    .sidebar .logout { margin-top: auto; background: var(--accent); text-align: center; padding: 12px; border-top: 1px solid rgba(255,255,255,0.2); }
    .sidebar .logout a { color: white; text-decoration: none; font-weight: 600; }

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

    .container {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 30px;
      max-width: 1000px;
      width: 100%;
      box-shadow: 0 6px 25px rgba(0,0,0,.1);
      margin: 40px auto;
    }

    h2 { text-align: center; color: var(--accent-2); margin-bottom: 25px; }
    label { display: block; margin-bottom: 6px; color: var(--muted); font-weight: 500; }
    input, select, textarea {
      width: 100%; padding: 10px; margin-bottom: 15px;
      border-radius: 8px; border: 1px solid var(--border); font-size: 1rem;
    }

    button {
      background: var(--accent); color: white; border: none;
      border-radius: 10px; padding: 10px 20px; cursor: pointer; font-weight: 600;
    }

    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border-bottom: 1px solid var(--border); text-align: center; }
    th { background: var(--accent-2); color: white; }
    tr:nth-child(even) { background: #f9fafb; }
    .status-pending { color: #b45309; font-weight: bold; }
    .status-accepted { color: #16a34a; font-weight: bold; }

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
