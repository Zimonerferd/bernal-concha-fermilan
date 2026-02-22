<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $poll->title }}</title>
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
            max-width: 760px;
            margin: 0 auto;
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

        .poll-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1rem;
        }

        .poll-meta {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1.25rem;
        }

        .poll-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            color: #fff;
        }

        .poll-author { font-size: 0.85rem; color: var(--muted); }
        .poll-author strong { color: var(--text); }

        .poll-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .poll-description {
            font-size: 0.95rem;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 1.75rem;
        }

        .vote-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .vote-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.4rem;
            border-radius: 99px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            transition: all 0.15s;
        }

        .vote-btn:hover { border-color: var(--accent); color: var(--text); }
        .vote-btn.up.active { background: rgba(74,222,128,0.1); border-color: rgba(74,222,128,0.4); color: var(--success); }
        .vote-btn.down.active { background: rgba(248,113,113,0.1); border-color: rgba(248,113,113,0.4); color: var(--danger); }

        .vote-count {
            font-size: 0.82rem;
            color: var(--muted);
            margin-left: auto;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.5rem 0;
        }

        .actions { display: flex; gap: 0.75rem; }

        .btn {
            display: inline-flex;
            align-items: center;
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

        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: #6a58e5; }

        .btn-outline {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .btn-outline:hover { color: var(--text); border-color: var(--text); }

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

    <a href="{{ route('polls.index') }}" class="back-link">← Back to Polls</a>

    <div class="poll-card">
        <div class="poll-meta">
            <div class="poll-avatar">
                {{ strtoupper(substr($poll->user->name ?? 'U', 0, 1)) }}
            </div>
            <span class="poll-author">
                <strong>{{ $poll->user->name ?? 'Unknown' }}</strong>
                · {{ $poll->created_at->diffForHumans() }}
            </span>
        </div>

        <div class="poll-title">{{ $poll->title }}</div>

        @if($poll->description)
            <p class="poll-description">{{ $poll->description }}</p>
        @endif

        <div class="vote-section">
            <form action="{{ route('polls.vote', $poll->id) }}" method="POST">
                @csrf
                <input type="hidden" name="vote" value="1">
                <button type="submit" class="vote-btn up {{ $userVote?->vote == 1 ? 'active' : '' }}">
                    👍 {{ $poll->thumbsUp() }}
                </button>
            </form>
            <form action="{{ route('polls.vote', $poll->id) }}" method="POST">
                @csrf
                <input type="hidden" name="vote" value="0">
                <button type="submit" class="vote-btn down {{ $userVote?->vote === 0 ? 'active' : '' }}">
                    👎 {{ $poll->thumbsDown() }}
                </button>
            </form>
            <span class="vote-count">{{ $poll->thumbsUp() + $poll->thumbsDown() }} total votes</span>
        </div>

        @if(auth()->id() === $poll->user_id)
            <hr class="divider">
            <div class="actions">
                <a href="{{ route('polls.edit', $poll->id) }}" class="btn btn-primary">Edit Poll</a>
                <a href="{{ route('polls.index') }}" class="btn btn-outline">Back to List</a>
                <form action="{{ route('polls.destroy', $poll->id) }}" method="POST"
                      style="margin-left: auto;"
                      onsubmit="return confirm('Delete this poll?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        @endif
    </div>

</body>
</html>