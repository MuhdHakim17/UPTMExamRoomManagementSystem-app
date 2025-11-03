<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | UPTM</title>
  <style>
    :root {
      --bg: #f4f4f9;
      --card: #ffffff;
      --muted: #6b7280;
      --text: #111827;
      --accent: #800000;
      --accent-2: #002147;
      --border: #e5e7eb;
      --ring: #800000;
      --input-bg: #f9fafb;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Roboto, Arial, sans-serif;
      background: var(--bg);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 40px 30px;
      width: 100%;
      max-width: 380px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.1);
      text-align: center;
      transition: all 0.3s ease;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 14px 40px rgba(0,0,0,0.15);
    }

    h1 {
      color: var(--accent);
      font-size: 1.7rem;
      margin-bottom: 20px;
      letter-spacing: 0.5px;
    }

    input {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 18px;
      border-radius: 10px;
      border: 1px solid var(--border);
      background: var(--input-bg);
      font-size: 1rem;
      color: var(--text);
      transition: border 0.2s, box-shadow 0.2s;
    }

    input:focus {
      border-color: var(--ring);
      box-shadow: 0 0 0 3px rgba(128,0,0,.25);
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 10px;
      background: var(--accent-2);
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    button:hover {
      background: #001a3d;
      transform: translateY(-1px);
    }

    .error {
      color: #b91c1c;
      background: #fee2e2;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }

    .switch {
      margin-top: 18px;
      font-size: 0.9rem;
      color: var(--muted);
    }

    .switch a {
      color: var(--accent);
      font-weight: 600;
      text-decoration: none;
    }

    .switch a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Exam Room Management</h1>
    <h1>Admin Login</h1>

    <!-- Display error message -->
    @if(session('error'))
      <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf
      <input type="text" name="admin_id" placeholder="Admin ID" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <div class="switch">
      For Lecturer? <a href="{{ route('lecturer.login') }}">Login here</a>
    </div>
  </div>
</body>
</html>
