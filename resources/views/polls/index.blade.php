<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Polls</title>
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
            max-width: 860px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .page-title span { color: var(--accent); }

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

        .alert {
            padding: 0.85rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background: rgba(74, 222, 128, 0.08);
            border: 1px solid rgba(74, 222, 128, 0.25);
            color: var(--success);
        }

        .alert-error {
            background: rgba(248, 113, 113, 0.08);
            border: 1px solid rgba(248, 113, 113, 0.25);
            color: var(--danger);
        }

        .section-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .top-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.6rem;
        }

        .poll-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: border-color 0.2s;
        }

        .poll-card:hover { border-color: rgba(124, 106, 247, 0.4); }

        .poll-meta {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.75rem;
        }

        .poll-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #a78bfa);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.7rem;
            color: #fff;
            flex-shrink: 0;
        }

        .poll-author {
            font-size: 0.82rem;
            color: var(--muted);
        }

        .poll-author strong { color: var(--text); }

        .poll-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: var(--text);
            display: block;
            transition: color 0.15s;
        }

        .poll-title:hover { color: var(--accent); }

        .poll-description {
            font-size: 0.875rem;
            color: var(--muted);
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .poll-footer {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .vote-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 1rem;
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            transition: all 0.15s;
            text-decoration: none;
        }

        .vote-btn:hover { border-color: var(--accent); color: var(--text); }
        .vote-btn.up.active { background: rgba(74,222,128,0.1); border-color: rgba(74,222,128,0.4); color: var(--success); }
        .vote-btn.down.active { background: rgba(248,113,113,0.1); border-color: rgba(248,113,113,0.4); color: var(--danger); }

        .view-link {
            margin-left: auto;
            font-size: 0.82rem;
            color: var(--accent);
            text-decoration: none;
        }

        .view-link:hover { text-decoration: underline; }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--muted);
        }

        .empty-state .icon { font-size: 2.5rem; margin-bottom: 1rem; }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.5rem 0;
        }
    </style>
</head>
<body>

    <div class="page-header">
        <h1 class="page-title">Com<span>munity</span> Polls</h1>
        <a href="{{ route('polls.create') }}" class="btn btn-primary">+ Create Poll</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- Top Suggestion Section --}}
    @php
        $popular = \App\Models\Poll::withCount('votes')
                    ->orderBy('votes_count', 'desc')
                    ->take(3)
                    ->get();
    @endphp

    @if($popular->count() > 0)
        <div class="section-label">🏆 Most Voted</div>
        <div style="display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 2rem;">
            @foreach($popular as $index => $top)
                @php
                    $rank = $index + 1;
                    $medal = $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : '🥉');
                    $up = $top->thumbsUp();
                    $down = $top->thumbsDown();
                    $total = $top->votes_count;
                    $upPercent = $total > 0 ? round(($up / $total) * 100) : 0;
                @endphp
                <div class="top-card">
                    <span style="font-size: 1.4rem;">{{ $medal }}</span>
                    <div style="flex: 1;">
                        <a href="{{ route('polls.show', $top->id) }}"
                           style="font-family: 'Syne', sans-serif; font-weight: 700;
                                  font-size: 0.95rem; color: var(--text); text-decoration: none;
                                  display: block; margin-bottom: 0.4rem;">
                            {{ $top->title }}
                        </a>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <span style="font-size: 0.78rem; color: var(--success);">👍 {{ $up }}</span>
                            <span style="font-size: 0.78rem; color: var(--danger);">👎 {{ $down }}</span>
                            <span style="font-size: 0.78rem; color: var(--muted);">{{ $total }} total votes</span>
                        </div>
                        @if($total > 0)
                            <div style="margin-top: 0.5rem; height: 3px; background: var(--border); border-radius: 99px;">
                                <div style="height: 100%; width: {{ $upPercent }}%;
                                            background: linear-gradient(90deg, var(--accent), #a78bfa);
                                            border-radius: 99px;"></div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <hr class="divider">
    @endif

    <div class="section-label">🗳️ All Polls</div>

    @forelse($polls as $poll)
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

            <a href="{{ route('polls.show', $poll->id) }}" class="poll-title">
                {{ $poll->title }}
            </a>

            @if($poll->description)
                <p class="poll-description">{{ Str::limit($poll->description, 120) }}</p>
            @endif

            <div class="poll-footer">
                <form action="{{ route('polls.vote', $poll->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="vote" value="1">
                    <button type="submit" class="vote-btn up {{ $poll->userVote(auth()->id())?->vote == 1 ? 'active' : '' }}">
                        👍 {{ $poll->thumbsUp() }}
                    </button>
                </form>
                <form action="{{ route('polls.vote', $poll->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="vote" value="0">
                    <button type="submit" class="vote-btn down {{ $poll->userVote(auth()->id())?->vote === 0 ? 'active' : '' }}">
                        👎 {{ $poll->thumbsDown() }}
                    </button>
                </form>
                <a href="{{ route('polls.show', $poll->id) }}" class="view-link">View →</a>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="icon">🗳️</div>
            <p>No polls yet. Be the first to create one!</p>
        </div>
    @endforelse

    <div style="margin-top: 1.5rem;">
        {{ $polls->links() }}
    </div>

</body>
</html>