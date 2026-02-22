<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit — {{ $employee->FirstName }} {{ $employee->LastName }}</title>
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
            --danger: #f87171;
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

        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            max-width: 760px;
        }

        .form-banner {
            height: 90px;
            background: linear-gradient(135deg, #3b2fa0 0%, #7c6af7 60%, #a78bfa 100%);
            position: relative;
        }

        .form-banner::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
        }

        .form-body {
            padding: 2rem;
        }

        .form-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .form-subtitle {
            color: var(--muted);
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        .alert-error {
            background: rgba(248, 113, 113, 0.08);
            border: 1px solid rgba(248, 113, 113, 0.25);
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            color: var(--danger);
        }

        .alert-error ul { padding-left: 1.2rem; }
        .alert-error li { margin-bottom: 0.25rem; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
        }

        label .required { color: var(--accent); margin-left: 2px; }

        input, select {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--text);
            transition: border-color 0.15s, box-shadow 0.15s;
            width: 100%;
            outline: none;
        }

        input:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 106, 247, 0.15);
        }

        input::placeholder { color: var(--muted); }
        select option { background: #18181f; color: var(--text); }

        .is-invalid {
            border-color: var(--danger) !important;
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.12) !important;
        }

        .invalid-feedback {
            font-size: 0.78rem;
            color: var(--danger);
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.75rem 0;
        }

        .form-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.6rem 1.4rem;
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
            color: var(--danger);
            border: 1px solid rgba(248, 113, 113, 0.25);
            margin-left: auto;
        }

        .btn-danger:hover { background: rgba(248, 113, 113, 0.1); }
    </style>
</head>
<body>

    <a href="{{ route('employees.show', $employee->id) }}" class="back-link">
        ← Back to Profile
    </a>

    <div class="form-card">
        <div class="form-banner"></div>

        <div class="form-body">
            <div class="form-title">
                Edit — {{ $employee->LastName }}, {{ $employee->FirstName }}
            </div>
            <div class="form-subtitle">Update the employee's information below.</div>

            @if($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-grid">

                    <div class="form-group">
                        <label>First Name <span class="required">*</span></label>
                        <input type="text" name="FirstName"
                               class="{{ $errors->has('FirstName') ? 'is-invalid' : '' }}"
                               value="{{ old('FirstName', $employee->FirstName) }}" maxlength="30">
                        @error('FirstName')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Last Name <span class="required">*</span></label>
                        <input type="text" name="LastName"
                               class="{{ $errors->has('LastName') ? 'is-invalid' : '' }}"
                               value="{{ old('LastName', $employee->LastName) }}" maxlength="30">
                        @error('LastName')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" name="MiddleName"
                               class="{{ $errors->has('MiddleName') ? 'is-invalid' : '' }}"
                               value="{{ old('MiddleName', $employee->MiddleName) }}" maxlength="30">
                        @error('MiddleName')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Name Extension</label>
                        <input type="text" name="NameExtension"
                               class="{{ $errors->has('NameExtension') ? 'is-invalid' : '' }}"
                               value="{{ old('NameExtension', $employee->NameExtension) }}" maxlength="30">
                        @error('NameExtension')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Date of Birth <span class="required">*</span></label>
                        <input type="date" name="DateOfBirth"
                               class="{{ $errors->has('DateOfBirth') ? 'is-invalid' : '' }}"
                               value="{{ old('DateOfBirth', $employee->DateOfBirth->format('Y-m-d')) }}">
                        @error('DateOfBirth')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Civil Status <span class="required">*</span></label>
                        <select name="CivilStatus" class="{{ $errors->has('CivilStatus') ? 'is-invalid' : '' }}">
                            @foreach(['Single','Married','Widowed','Separated'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('CivilStatus', $employee->CivilStatus) === $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('CivilStatus')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <hr class="divider">

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-outline">Cancel</a>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                          style="margin-left: auto;"
                          onsubmit="return confirm('Are you sure you want to delete this employee?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </form>
        </div>
    </div>

</body>
</html>