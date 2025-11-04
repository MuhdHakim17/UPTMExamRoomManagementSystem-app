<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lecturer Dashboard | UPTM</title>
  <style>
    :root {
       --bg: linear-gradient(135deg, #002147 0%, #800000 100%);
      --card: #ffffff;
      --muted: #6b7280;
      --text: #111827;
      --accent: #800000;
      --accent-2: #002147;
      --border: #e5e7eb;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Roboto, Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* 🔹 Topbar */
    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 24px;
      background: var(--accent-2);
      color: white;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      border-bottom: 3px solid var(--accent);
    }

    .topbar h1 {
      margin: 0;
      font-size: 1.5rem;
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    .topbar-buttons {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .btn {
      background: var(--accent);
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s ease;
      font-size: 0.95rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .btn:hover {
      background: #660000;
      transform: translateY(-1px);
    }

    /* 🔹 Dashboard */
    .dashboard {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 60px 20px;
      background: transparent;
    }

    .dashboard h2 {
      font-size: 2rem;
      color: var(--accent-2);
      margin-bottom: 30px;
      font-weight: 700;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 25px;
      width: 100%;
      max-width: 800px;
    }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 40px 25px;
      text-align: center;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .card:hover {
      background: var(--accent-2);
      color: #fff;
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .card a {
      text-decoration: none;
      color: inherit;
      font-weight: 600;
      font-size: 1.15rem;
      display: inline-block;
      transition: color 0.2s ease;
    }

    .card a:hover {
      text-decoration: underline;
    }

    /* 🔹 Footer */
    .footer {
      background: var(--accent-2);
      color: white;
      text-align: center;
      padding: 16px;
      font-size: 0.9rem;
      border-top: 3px solid var(--accent);
      letter-spacing: 0.3px;
      margin-top: auto;
    }

    @media (max-width: 600px) {
      .dashboard {
        padding: 30px 15px;
      }
      .card {
        padding: 30px 20px;
      }
      .topbar h1 {
        font-size: 1.2rem;
      }
    }
  </style>
</head>

<body>

  <!-- 🔝 Top bar -->
  <div class="topbar">
    <h1>Exam Room Management</h1>
    <div class="topbar-buttons">
      <a href="{{ route('lecturer.logout') }}" class="btn">Logout</a>
    </div>
  </div>

  <!-- 🏠 Dashboard -->
  <div class="dashboard">
    <div class="cards">
      <div class="card">
        <a href="{{ route('report.form') }}">📝 Submit Report</a>
      </div>
      <div class="card">
        <a href="{{ route('display.timetable') }}">📅 View Timetable</a>
      </div>
    </div>
  </div>

  <div class="footer">
    © {{ date('Y') }} UPTM Exam Management System — Lecturer Portal
  </div>

</body>
</html>
