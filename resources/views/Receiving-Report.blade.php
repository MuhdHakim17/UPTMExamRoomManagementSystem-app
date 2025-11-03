<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Receiving Report | Admin Dashboard</title>

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
    .sidebar { width: 250px; background: var(--accent-2); color: white; display: flex; flex-direction: column; padding: 20px 0; box-shadow: 4px 0 10px rgba(0,0,0,0.2); }
    .sidebar h2 { text-align: center; margin-bottom: 30px; font-size: 1.4rem; color: #fff; border-bottom: 2px solid var(--accent); padding-bottom: 10px; }
    .sidebar a { text-decoration: none; color: white; padding: 12px 25px; display: block; font-weight: 500; transition: all 0.2s ease; }
    .sidebar a:hover { background: var(--accent); }
    .sidebar a.active { background: var(--accent); font-weight: 600; }
    .sidebar .logout { margin-top: auto; background: var(--accent); text-align: center; padding: 12px; border-top: 1px solid rgba(255,255,255,0.2); }
    .sidebar .logout a { color: white; text-decoration: none; font-weight: 600; }
    .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 40px; }
    .topbar { background: var(--card); border-bottom: 1px solid var(--border); padding: 14px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .topbar h1 { font-size: 1.5rem; color: var(--accent-2); margin: 0; }
    .container { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 30px; max-width: 1000px; width: 100%; box-shadow: 0 6px 25px rgba(0,0,0,.1); margin: 40px auto; }
    h2 { text-align: center; color: var(--accent-2); margin-bottom: 25px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid var(--border); }
    th { background: var(--accent-2); color: white; }
    tr:hover td { background: rgba(128, 0, 0, 0.05); }
    .btn-accept { background: #16a34a; color: white; padding: 6px 10px; border-radius:6px; border:none; cursor:pointer; font-weight:600; }
    .btn-remove { background: #dc2626; color: white; padding: 6px 10px; border-radius:6px; border:none; cursor:pointer; font-weight:600; }
    .status-pending { color: #b45309; font-weight: bold; }
    .status-accepted { color: #16a34a; font-weight: bold; }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2>Exam Room Management</h2>
    <a href="{{ route('admin.homepage') }}">🏠 Home</a>
    <a href="{{ route('examroom.index') }}">🏫 Setup Exam Room</a>
    <a href="{{ route('timetable.index') }}">📅 Setup Timetable</a>
    <a href="{{ route('receiving.report') }}" class="active">📝 Report</a>
    <div class="logout">
      <a href="{{ route('admin.logout') }}">🚪 Logout</a>
    </div>
  </aside>

  <div class="main-content">
    <div class="topbar">
      <h1>UPTM Exam Report</h1>
    </div>

    <div class="container">
      <h2>Received Reports</h2>

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

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Subject</th>
            <th>Subject Code</th>
            <th>Room</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Category</th>
            <th>Details</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($reports as $report)
          <tr>
            <td>{{ $report->name }}</td>
            <td>{{ $report->subject }}</td>
            <td>{{ $report->subject_code }}</td>
            <td>{{ $report->room }}</td>
            <td>{{ $report->date }}</td>
            <td>{{ $report->start_time }}</td>
            <td>{{ $report->end_time }}</td>
            <td>{{ $report->category }}</td>
            <td>{{ $report->details }}</td>
            <td>
              @if(isset($report->status) && $report->status === 'Accepted')
                <span class="status-accepted">Accepted</span>
              @else
                <span class="status-pending">Pending</span>
              @endif
            </td>
            <td style="white-space:nowrap;">
              <!-- Accept form (POST) -->
              @if(!isset($report->status) || $report->status !== 'Accepted')
                <form method="POST" action="{{ route('receiving.report.accept', $report->id) }}" style="display:inline;">
                  @csrf
                  <button type="submit" class="btn-accept" onclick="return confirm('Mark this report as accepted?')">Accept</button>
                </form>
              @endif

              <!-- Remove form (DELETE) -->
              <form method="POST" action="{{ route('receiving.report.remove', $report->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-remove" onclick="return confirm('Delete this report?')">Remove</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
