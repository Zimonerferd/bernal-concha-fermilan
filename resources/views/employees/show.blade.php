<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} — Employee Profile</title>
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

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            margin-bottom: 2rem;
            transition: color 0.15s;
        }

        .back-link:hover { color: var(--text); }

        .profile-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            max-width: 760px;
        }

        .profile-banner {
            height: 90px;
            background: linear-gradient(135deg, #3b2fa0 0%, #7c6af7 60%, #a78bfa 100%);
            position: relative;
        }

        .profile-banner::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .profile-body {
            padding: 0 2rem 2rem;
            position: relative;
        }

        .avatar-wrap {
            margin-top: -36px;
            margin-bottom: 1rem;
        }

        .avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            border: 3px solid var(--surface);
        }

        .profile-name {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .profile-role {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 0.2rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(74, 222, 128, 0.1);
            color: var(--success);
            border: 1px solid rgba(74, 222, 128, 0.25);
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.75rem;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--success);
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.5rem 0;
        }

        .section-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-item {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.9rem 1rem;
        }

        .info-item .label {
            font-size: 0.72rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.35rem;
        }

        .info-item .value {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text);
        }

        .info-item .value.empty {
            color: var(--muted);
            font-style: italic;
            font-weight: 400;
        }

        .actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.75rem;
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

        .btn-outline {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            color: var(--text);
            border-color: var(--text);
        }

        .btn-danger {
            background: transparent;
            color: #f87171;
            border: 1px solid rgba(248, 113, 113, 0.25);
        }

        .btn-danger:hover {
            background: rgba(248, 113, 113, 0.1);
        }
    </style>
</head>
<body>

    <a href="{{ route('employees.index') }}" class="back-link">
        ← Back to Employees
    </a>

    <div class="profile-card">
        <div class="profile-banner"></div>

        <div class="profile-body">
            <div class="avatar-wrap">
                <div class="avatar">
                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                </div>
            </div>

            <div class="profile-name">{{ $employee->name }}</div>
            <div class="profile-role">{{ $employee->position ?? 'No position assigned' }}</div>
            <div class="status-badge">Active</div>

            <hr class="divider">

            <div class="section-label">Employee Details</div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Employee ID</div>
                    <div class="value">{{ $employee->id }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Email</div>
                    <div class="value">{{ $employee->email ?? '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Department</div>
                    <div class="value {{ empty($employee->department) ? 'empty' : '' }}">
                        {{ $employee->department ?? 'Not assigned' }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="label">Position</div>
                    <div class="value {{ empty($employee->position) ? 'empty' : '' }}">
                        {{ $employee->position ?? 'Not assigned' }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="label">Phone</div>
                    <div class="value {{ empty($employee->phone) ? 'empty' : '' }}">
                        {{ $employee->phone ?? 'Not provided' }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="label">Date Hired</div>
                    <div class="value {{ empty($employee->created_at) ? 'empty' : '' }}">
                        {{ $employee->created_at ? $employee->created_at->format('M d, Y') : '—' }}
                    </div>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">
                    Edit Employee
                </a>
                <a href="{{ route('employees.index') }}" class="btn btn-outline">
                    Back to List
                </a>
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="margin-left: auto;"
                    onsubmit="return confirm('Are you sure you want to delete this employee?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>