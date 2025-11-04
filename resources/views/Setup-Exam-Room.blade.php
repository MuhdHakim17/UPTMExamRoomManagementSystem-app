<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Setup Exam Room | Admin Dashboard</title>

  <style>
    :root {
      --bg: linear-gradient(135deg, #002147 0%, #800000 100%);
      --card: #ffffff;
      --muted: #6b7280;
      --text: #111827;
      --accent: #800000;   /* UPTM Maroon */
      --accent-2: #002147; /* UPTM Blue */
      --border: #d1d5db;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: system-ui, Segoe UI, Roboto, Arial, sans-serif;
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
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
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

    .sidebar a:hover,
    .sidebar a.active {
      background: var(--accent);
      color: #fff;
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

    /* Topbar */
    .topbar {
     
      padding: 14px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      
    }

    .h1 {
      font-size: 1.5rem;
      margin: 0;
      font-weight: 600;
    }

    /* Main content */
    .main {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      background: var(--bg);
      padding: 40px;
    }

    .container {
      background: var(--card);
      border: 2px solid var(--accent-2);
      border-radius: 20px;
      padding: 35px;
      max-width: 1000px;
      width: 125%;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      margin: 0 auto;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .container:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    h2 {
      text-align: center;
      color: var(--accent-2);
      margin-bottom: 25px;
      font-weight: 700;
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
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(128,0,0,0.15);
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
      border-radius: 8px;
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
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid var(--border);
    }

    th {
      background: var(--accent-2);
      color: white;
      font-weight: 600;
    }

    tr:hover td {
      background: #f9fafb;
    }

    .btn-edit {
      background: #f59e0b;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-delete {
      background: #dc2626;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-edit:hover { background: #d97706; }
    .btn-delete:hover { background: #b91c1c; }

    @media (max-width: 800px) {
      .sidebar { width: 200px; }
      .main { padding: 20px; }
      .container { padding: 25px; width: 100%; }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>Exam Room Management</h2>
    <a href="{{ route('admin.homepage') }}">🏠 Home</a>
    <a href="{{ route('examroom.index') }}" class="active">🏫 Setup Exam Room</a>
    <a href="{{ route('timetable.index') }}">📅 Setup Timetable</a>
    <a href="{{ route('receiving.report') }}">📝 Report</a>
    <div class="logout">
      <a href="{{ route('admin.logout') }}">🚪 Logout</a>
    </div>
  </aside>

  <!-- Main -->
  <div class="main">
    <div class="topbar">
      <h1>UPTM Exam Timetable</h1>
    </div>

    <div class="container">
      <h2>Setup Exam Room</h2>

      {{-- Form Section --}}
      <form id="room-form" method="POST" action="{{ route('examroom.store') }}">
        @csrf
        <input type="hidden" name="id" id="room-id">

        <label for="floor">Floor</label>
        <input type="text" id="floor" name="floor" placeholder="e.g. 1st Floor" required>

        <label for="room-number">Room Number</label>
        <input type="text" id="room-number" name="room_number" placeholder="e.g. A101" required>

        <label for="capacity">Capacity</label>
        <input type="number" id="capacity" name="capacity" placeholder="e.g. 50" min="1" required>

        <div class="actions">
          <button type="submit" id="submit-btn" class="primary">Save Room</button>
          <button type="button" id="cancel-btn" class="secondary" style="display:none;" onclick="cancelEdit()">Cancel</button>
        </div>
      </form>

      {{-- Table Section --}}
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Floor</th>
            <th>Room Number</th>
            <th>Capacity</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($rooms as $room)
          <tr>
            <td>{{ $room->id }}</td>
            <td>{{ $room->floor }}</td>
            <td>{{ $room->room_number }}</td>
            <td>{{ $room->capacity }}</td>
            <td>
              <button type="button" class="btn-edit" onclick="editRoom('{{ $room->id }}', '{{ $room->floor }}', '{{ $room->room_number }}', '{{ $room->capacity }}')">Edit</button>
              <form method="POST" action="{{ route('examroom.delete', $room->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete" onclick="return confirm('Delete this room?')">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align:center;color:var(--muted)">No rooms added yet.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function editRoom(id, floor, room_number, capacity) {
      document.getElementById('room-id').value = id;
      document.getElementById('floor').value = floor;
      document.getElementById('room-number').value = room_number;
      document.getElementById('capacity').value = capacity;

      const form = document.getElementById('room-form');
      form.action = `/admin/setup-exam-room/update/${id}`;
      document.getElementById('submit-btn').textContent = "Update Room";
      document.getElementById('cancel-btn').style.display = "inline-block";
    }

    function cancelEdit() {
      const form = document.getElementById('room-form');
      form.reset();
      form.action = "{{ route('examroom.store') }}";
      document.getElementById('submit-btn').textContent = "Save Room";
      document.getElementById('cancel-btn').style.display = "none";
    }
  </script>
</body>
</html>
