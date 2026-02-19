<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0f0f13;
            --surface: #18181f;
            --border: #2a2a35;
            --accent: #7c6af7;
            --accent-glow: rgba(124, 106, 247, 0.18);
            --text: #eeeef2;
            --muted: #7a7a90;
            --success: #4ade80;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            padding: 2.5rem 2rem;
        }

        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .page-title span {
            color: var(--accent);
        }

        .badge {
            background: var(--accent-glow);
            color: var(--accent);
            border: 1px solid rgba(124, 106, 247, 0.3);
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-left: 0.75rem;
            vertical-align: middle;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.2rem;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.18s ease;
            border: none;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .btn-primary:hover {
            background: #6a58e5;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(124, 106, 247, 0.4);
        }

        .table-wrapper {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: rgba(124, 106, 247, 0.06);
        }

        thead th {
            padding: 1rem 1.25rem;
            text-align: left;
            font-family: 'Syne', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s ease;
        }

        tbody tr:last-child { border-bottom: none; }

        tbody tr:hover {
            background: rgba(124, 106, 247, 0.05);
        }

        td {
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            color: var(--text);
            vertical-align: middle;
        }

        .employee-name {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .employee-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            color: #fff;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .name-cell {
            display: flex;
            align-items: center;
        }

        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success);
            margin-right: 0.5rem;
        }

        .action-link {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.3rem 0.75rem;
            border-radius: 6px;
            border: 1px solid rgba(124, 106, 247, 0.25);
            transition: all 0.15s ease;
            display: inline-block;
        }

        .action-link:hover {
            background: var(--accent-glow);
            border-color: var(--accent);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--muted);
        }

        .empty-state .icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="page-header">
        <div>
            <h1 class="page-title">
                Employ<span>ees</span>
                <span class="badge">{{ count($employees) }}</span>
            </h1>
        </div>
            + Add Employee
        </a>
    </div>

    <div class="table-wrapper">
        @if($employees->isEmpty())
            <div class="empty-state">
                <div class="icon">👥</div>
                <p>No employees found. Start by adding one.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td style="color: var(--muted); font-size: 0.8rem;">{{ $loop->iteration }}</td>
                            <td>
                                <div class="name-cell">
                                    <div class="employee-avatar">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </div>
                                    <span class="employee-name">{{ $employee->name }}</span>
                                </div>
                            </td>
                            <td style="color: var(--muted);">{{ $employee->email }}</td>
                            <td>{{ $employee->position ?? '—' }}</td>
                            <td>{{ $employee->department ?? '—' }}</td>
                            <td>
                                <span class="status-dot"></span>
                                Active
                            </td>
                            <td>
                                <a href="{{ route('employees.show', $employee->id) }}" class="action-link">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</body>
</html>