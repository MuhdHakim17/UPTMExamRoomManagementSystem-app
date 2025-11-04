<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lecturer Login | UPTM</title>
  <style>
    :root {
      --bg: linear-gradient(135deg, #002147 0%, #800000 100%);
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
      background-attachment: fixed;
    }

    .card {
      background: var(--card);
      border-radius: 20px;
      padding: 45px 40px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.25);
      text-align: center;
      animation: fadeIn 0.7s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo {
      width: 70px;
      height: 70px;
      margin: 0 auto 15px;
      background: url('https://upload.wikimedia.org/wikipedia/en/7/7c/Universiti_Putra_Malaysia_Logo.svg') no-repeat center;
      background-size: contain;
      opacity: 0.85;
    }

    .card h1:first-child {
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--accent-2);
      margin-bottom: 5px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    .card h1:last-of-type {
      font-size: 1.6rem;
      color: var(--accent);
      margin-bottom: 25px;
      font-weight: 700;
    }

    input {
      width: 90%;
      padding: 14px 16px;
      margin-bottom: 18px;
      border-radius: 10px;
      border: 1px solid var(--border);
      background: var(--input-bg);
      font-size: 1rem;
      color: var(--text);
      transition: all 0.25s ease;
    }

    input:focus {
      border-color: var(--ring);
      box-shadow: 0 0 0 4px rgba(128,0,0,.25);
      outline: none;
      background: #fff;
    }

    button {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 10px;
      background: var(--accent-2);
      color: #fff;
      font-size: 1.05rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,33,71,0.3);
    }

    button:hover {
      background: #001a3d;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0,33,71,0.4);
    }

    .alert {
      color: #b91c1c;
      background: #fee2e2;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 0.9rem;
      border-left: 4px solid #dc2626;
      text-align: left;
    }

    .switch {
      margin-top: 22px;
      font-size: 0.9rem;
      color: var(--muted);
    }

    .switch a {
      color: var(--accent);
      font-weight: 600;
      text-decoration: none;
      transition: color 0.2s;
    }

    .switch a:hover {
      color: var(--accent-2);
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="logo"></div>
    <h1>Exam Room Management</h1>
    <h1>Lecturer Login</h1>

    <!-- ✅ Error message -->
    @if (session('error'))
      <div class="alert">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('lecturer.login.submit') }}">
      @csrf
      <input type="text" name="lecturer_id" placeholder="Lecturer ID" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <div class="switch">
      For Admin? <a href="{{ route('admin.login') }}">Login here</a>
    </div>
  </div>
</body>
</html>
