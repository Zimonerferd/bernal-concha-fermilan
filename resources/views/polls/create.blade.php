<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Poll</title>
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
            --danger: #f87171;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            padding: 2.5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            align-self: flex-start;
            margin-left: calc((100% - 560px) / 2);
            transition: color 0.15s;
        }

        .back-link:hover { color: var(--text); }

        .post-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 100%;
            max-width: 560px;
            padding: 1.5rem;
        }

        /* Top row — avatar + name */
        .post-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info { display: flex; flex-direction: column; gap: 2px; }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .post-audience {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 1px 7px;
            font-size: 0.7rem;
            color: var(--muted);
            width: fit-content;
        }

        /* Title input */
        .title-input {
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text);
            resize: none;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .title-input::placeholder { color: #3a3a4a; }

        /* Description textarea */
        .desc-input {
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--muted);
            resize: none;
            min-height: 80px;
            line-height: 1.6;
        }

        .desc-input::placeholder { color: #3a3a4a; }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.25rem 0;
        }

        /* Poll badge */
        .poll-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--accent-glow);
            border: 1px solid rgba(124, 106, 247, 0.3);
            color: var(--accent);
            border-radius: 99px;
            padding: 0.3rem 0.85rem;
            font-size: 0.78rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }

        /* Thumbs preview */
        .vote-preview {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .vote-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
            color: var(--muted);
            flex: 1;
            justify-content: center;
        }

        /* Error */
        .alert-error {
            background: rgba(248, 113, 113, 0.08);
            border: 1px solid rgba(248, 113, 113, 0.25);
            border-radius: 10px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.82rem;
            color: var(--danger);
        }

        .alert-error ul { padding-left: 1.2rem; }

        /* Bottom actions */
        .post-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-post {
            flex: 1;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.65rem 1.2rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .btn-post:hover {
            background: #6a58e5;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(124, 106, 247, 0.4);
        }

        .btn-cancel {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.65rem 1.2rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.18s;
        }

        .btn-cancel:hover { color: var(--text); border-color: var(--text); }

        .char-count {
            font-size: 0.75rem;
            color: var(--muted);
            text-align: right;
            margin-top: 0.25rem;
        }

        .char-count.warn { color: var(--danger); }
    </style>
</head>
<body>

    <a href="{{ route('polls.index') }}" class="back-link">← Back to Polls</a>

    <div class="post-card">

        <div class="post-header">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="post-audience">🌐 Public Poll</span>
            </div>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('polls.store') }}" method="POST">
            @csrf

            <textarea name="title"
                      class="title-input"
                      rows="2"
                      maxlength="255"
                      placeholder="What's on your mind? Write your poll question..."
                      oninput="updateCount(this, 'title-count', 255)"
                      required>{{ old('title') }}</textarea>
            <div class="char-count" id="title-count">255 characters remaining</div>

            <textarea name="description"
                      class="desc-input"
                      rows="3"
                      placeholder="Add more context or details (optional)...">{{ old('description') }}</textarea>

            <hr class="divider">

            <div class="poll-tag">🗳️ Community Poll</div>

            <div class="vote-preview">
                <div class="vote-chip">👍 Agree</div>
                <div class="vote-chip">👎 Disagree</div>
            </div>

            <hr class="divider">

            <div class="post-actions">
                <a href="{{ route('polls.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-post">Post Poll</button>
            </div>
        </form>
    </div>

    <script>
        function updateCount(el, countId, max) {
            const remaining = max - el.value.length;
            const counter = document.getElementById(countId);
            counter.textContent = remaining + ' characters remaining';
            counter.classList.toggle('warn', remaining < 30);
        }
    </script>

</body>
</html>