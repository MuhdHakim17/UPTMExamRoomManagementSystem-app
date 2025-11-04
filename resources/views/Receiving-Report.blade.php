<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Receiving Report | Admin Dashboard</title>

  <style>
    :root {
      --bg: linear-gradient(135deg, #002147 0%, #800000 100%);
      --card: #ffffff;
      --muted: #6b7280;
      --text: #111827;
      --accent: #800000;
      --accent-2: #002147;
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

    /* Sidebar */
    .sidebar {
      width: 250px;
      background:(--bg);
      color: white;
      display: flex;
      flex-direction: column;
      padding: 20px 0;
      
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 1.4rem;
      color: #fff;
    
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

    /* Main content */
    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      padding: 40px;
    }

    .topbar {
     
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      border-radius: 8px;
    }

    .topbar h1 {
      font-size: 1.6rem;
      color: var(--card);
      margin: 0;
      font-weight: 700;
     
    }

    /* Container (card style) */
    .container {
      background: var(--card);
      border: 2px solid var(--accent-2);
      border-radius: 16px;
      padding: 30px;
      max-width: 1000px;
      width: 100%;
      box-shadow: 0 8px 25px rgba(0,0,0,.2);
      margin: 40px auto;
      transition: transform 0.2s ease;
    }

    .container:hover {
      transform: translateY(-3px);
    }

    h2 {
      text-align: center;
      color: var(--accent-2);
      margin-bottom: 25px;
      font-size: 1.8rem;
      text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    /* Table styling */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid var(--border);
      font-size: 0.95rem;
    }

    th {
      background: var(--accent-2);
      color: white;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    tr:nth-child(even) td {
      background: #f9fafb;
    }

    tr:hover td {
      background: rgba(128, 0, 0, 0.08);
      transition: background 0.2s;
    }

    /* Buttons */
    .btn-accept {
      background: #16a34a;
      color: white;
      padding: 6px 10px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.2s;
    }
    .btn-accept:hover {
      background: #15803d;
    }

    .btn-remove {
      background: #dc2626;
      color: white;
      padding: 6px 10px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.2s;
    }
    .btn-remove:hover {
      background: #b91c1c;
    }

    /* Status badges */
    .status-pending {
      color: #b45309;
      font-weight: bold;
    }
    .status-accepted {
      color: #16a34a;
      font-weight: bold;
    }

    /* Alert messages */
    .alert-success {
      background: #dcfce7;
      color: #166534;
      padding: 10px 15px;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .alert-error {
      background: #fee2e2;
      color: #991b1b;
      padding: 10px 15px;
      border-radius: 8px;
      margin-bottom: 10px;
    }

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
        <div class="alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
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
              @if(!isset($report->status) || $report->status !== 'Accepted')
                <form method="POST" action="{{ route('receiving.report.accept', $report->id) }}" style="display:inline;">
                  @csrf
                  <button type="submit" class="btn-accept" onclick="return confirm('Mark this report as accepted?')">Accept</button>
                </form>
              @endif

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
