<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    :root {
      --bg: linear-gradient(135deg, #002147 0%, #800000 100%);
      --card: #ffffff;
      --muted: #6b7280;
      --text: #111827;
      --accent: #800000;    /* UPTM Maroon */
      --accent-2: #002147;  /* UPTM Blue */
      --border: #d1d5db;
    }

    body {
      margin: 0;
      font-family: system-ui, Segoe UI, Roboto, Arial, sans-serif;
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
      padding: 12px 20px;
      background: rgba(0, 33, 71, 0.95);
      border-bottom: 2px solid var(--accent);
      box-shadow: 0 4px 10px rgba(0, 0, 0, .3);
      color: white;
    }
    .topbar h1 {
      font-size: 1.4rem;
      margin: 0;
      font-weight: 600;
    }
    .topbar-buttons {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .btn {
      background: var(--accent);
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.2s;
      text-decoration: none;
    }
    .btn:hover {
      background: #660000;
    }

    /* 🔹 Dashboard section */
    .dashboard {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding: 40px 20px;
    }

    .dashboard h2 {
      font-size: 2rem;
      color: white;
      margin-bottom: 30px;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }

    /* 🔹 Cards grid */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      width: 100%;
      max-width: 800px;
    }

    .card {
      background: var(--card);
      border: 2px solid var(--accent-2);
      border-radius: 12px;
      padding: 30px 20px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
    }

    .card:hover {
      transform: translateY(-6px);
      background: var(--accent-2);
      color: white;
    }

    .card a {
      text-decoration: none;
      color: inherit;
      font-weight: 600;
      font-size: 1.1rem;
    }

    /* 🔹 Footer */
    .footer {
      text-align: center;
      padding: 15px;
      background: rgba(0, 33, 71, 0.95);
      color: white;
      font-size: 0.9rem;
      margin-top: auto;
      border-top: 2px solid var(--accent);
      box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

  <!-- 🔝 Topbar -->
  <div class="topbar">
    <h1>Exam Room Management</h1>
    <div class="topbar-buttons">
      <a href="{{ route('admin.homepage') }}" class="btn">Home</a>
      <a href="{{ route('admin.logout') }}" class="btn">Logout</a>
    </div>
  </div>

  <!-- 🏠 Dashboard content -->
  <div class="dashboard">
    <h2>Welcome, Admin</h2>

    <div class="cards">
      <div class="card">
        <a href="{{ route('examroom.index') }}">🧱 Setup Exam Room</a>
      </div>
      <div class="card">
        <a href="{{ route('timetable.index') }}">📅 Setup Timetable</a>
      </div>
      <div class="card">
        <a href="{{ route('receiving.report') }}">📊 View Reports</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    © {{ date('Y') }} UPTM Exam Management System. All rights reserved.
  </div>

</body>
</html>
    