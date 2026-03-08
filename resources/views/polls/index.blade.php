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
            --warning: #ffa657;
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
            margin-bottom: 1.5rem;
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

        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover {
            background: #6a58e5;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(124, 106, 247, 0.4);
        }

        .filter-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .filter-tab {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 1rem;
            border-radius: 99px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid var(--border);
            color: var(--muted);
            background: transparent;
            transition: all 0.15s;
        }

        .filter-tab:hover { color: var(--text); border-color: var(--text); }
        .filter-tab.active-all { background: var(--accent-glow); border-color: rgba(124,106,247,0.4); color: var(--accent); }
        .filter-tab.active-urgent { background: rgba(248,113,113,0.1); border-color: rgba(248,113,113,0.4); color: var(--danger); }
        .filter-tab.active-suggestion { background: rgba(74,222,128,0.1); border-color: rgba(74,222,128,0.4); color: var(--success); }
        .filter-tab.active-category { background: var(--accent-glow); border-color: rgba(124,106,247,0.4); color: var(--accent); }

        .divider { border: none; border-top: 1px solid var(--border); margin: 1rem 0; }

        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 0.85rem 1.25rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.25s ease;
            pointer-events: none;
        }

        .toast.show { opacity: 1; transform: translateY(0); }
        .toast.success { background: rgba(74,222,128,0.15); border: 1px solid rgba(74,222,128,0.3); color: var(--success); }
        .toast.error { background: rgba(248,113,113,0.15); border: 1px solid rgba(248,113,113,0.3); color: var(--danger); }

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
            flex-wrap: wrap;
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

        .poll-author { font-size: 0.82rem; color: var(--muted); }
        .poll-author strong { color: var(--text); }

        .poll-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            border-radius: 99px;
            padding: 2px 8px;
            font-size: 0.68rem;
            font-weight: 600;
        }

        .badge-urgent { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.3); color: var(--danger); }
        .badge-suggestion { background: rgba(74,222,128,0.1); border: 1px solid rgba(74,222,128,0.3); color: var(--success); }
        .badge-category { background: var(--accent-glow); border: 1px solid rgba(124,106,247,0.3); color: var(--accent); }

        .poll-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: var(--text);
            display: block;
            transition: color 0.15s;
            cursor: pointer;
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            padding: 0;
        }

        .poll-title:hover { color: var(--accent); }

        .poll-description {
            font-size: 0.875rem;
            color: var(--muted);
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .poll-footer { display: flex; align-items: center; gap: 1rem; }

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
        }

        .vote-btn:hover { border-color: var(--accent); color: var(--text); }
        .vote-btn.up.active { background: rgba(74,222,128,0.1); border-color: rgba(74,222,128,0.4); color: var(--success); }
        .vote-btn.down.active { background: rgba(248,113,113,0.1); border-color: rgba(248,113,113,0.4); color: var(--danger); }

        .view-link {
            font-size: 0.82rem;
            color: var(--accent);
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            padding: 0;
            transition: opacity 0.15s;
        }

        .view-link:hover { opacity: 0.7; }

        .edit-btn {
            font-size: 0.82rem;
            color: var(--muted);
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: color 0.15s;
            padding: 0;
        }

        .edit-btn:hover { color: var(--accent); }

        .delete-btn {
            font-size: 0.82rem;
            color: var(--muted);
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: color 0.15s;
            padding: 0;
            margin-left: auto;
        }

        .delete-btn:hover { color: var(--danger); }

        .empty-state { text-align: center; padding: 4rem 2rem; color: var(--muted); }
        .empty-state .icon { font-size: 2.5rem; margin-bottom: 1rem; }

        .polls-loading {
            text-align: center;
            padding: 3rem;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .modal-overlay.open { opacity: 1; pointer-events: all; }

        .modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 100%;
            max-width: 520px;
            padding: 1.5rem;
            transform: translateY(20px);
            transition: transform 0.2s;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.open .modal { transform: translateY(0); }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 1.25rem;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            flex-shrink: 0;
        }

        .modal-close:hover { color: var(--text); }

        .field-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin-bottom: 0.75rem;
        }

        .title-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            outline: none;
            margin-bottom: 1rem;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .title-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124,106,247,0.15);
        }

        .desc-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--muted);
            outline: none;
            resize: vertical;
            min-height: 80px;
            margin-bottom: 1rem;
            transition: border-color 0.15s;
        }

        .desc-input:focus { border-color: var(--accent); }
        input::placeholder, textarea::placeholder { color: #3a3a4a; }

        .category-options {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .cat-label {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.85rem;
            border-radius: 99px;
            border: 1px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-size: 0.8rem;
            color: var(--muted);
            transition: all 0.15s;
            user-select: none;
        }

        .cat-label:hover { border-color: var(--accent); color: var(--text); }

        .cat-label.cat-active {
            background: var(--accent-glow);
            border-color: var(--accent);
            color: var(--accent);
            font-weight: 600;
        }

        .type-options {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .type-option { flex: 1; position: relative; }

        .type-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .type-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            padding: 0.75rem;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            background: rgba(255,255,255,0.02);
            cursor: pointer;
            transition: all 0.15s;
            text-align: center;
        }

        .type-option label:hover { border-color: var(--accent); background: var(--accent-glow); }

        .type-option input[type="radio"]:checked + label.urgent {
            border-color: var(--danger);
            background: rgba(248,113,113,0.08);
        }

        .type-option input[type="radio"]:checked + label.suggestion {
            border-color: var(--success);
            background: rgba(74,222,128,0.08);
        }

        .type-icon { font-size: 1.25rem; }
        .type-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.78rem; color: var(--text); }
        .type-desc { font-size: 0.68rem; color: var(--muted); }

        .modal-divider { border: none; border-top: 1px solid var(--border); margin: 1rem 0; }
        .modal-actions { display: flex; gap: 0.75rem; }

        .btn-submit {
            flex: 1;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.65rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s;
        }

        .btn-submit:hover { background: #6a58e5; }

        .btn-cancel-modal {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.65rem 1.2rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.18s;
        }

        .btn-cancel-modal:hover { color: var(--text); border-color: var(--text); }

        .delete-modal-text {
            font-size: 0.9rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .btn-confirm-delete {
            flex: 1;
            background: rgba(248,113,113,0.15);
            color: var(--danger);
            border: 1px solid rgba(248,113,113,0.3);
            border-radius: 8px;
            padding: 0.65rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s;
        }

        .btn-confirm-delete:hover { background: rgba(248,113,113,0.25); }

        .show-poll-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .show-poll-desc {
            font-size: 0.95rem;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .show-vote-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 1.25rem;
        }

        .show-vote-count {
            font-size: 0.82rem;
            color: var(--muted);
            margin-left: auto;
        }

        .show-owner-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn-show-edit {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.55rem 1.2rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.18s;
        }

        .btn-show-edit:hover { background: #6a58e5; }

        .btn-show-delete {
            background: transparent;
            color: var(--danger);
            border: 1px solid rgba(248,113,113,0.25);
            border-radius: 8px;
            padding: 0.55rem 1.2rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.18s;
            margin-left: auto;
        }

        .btn-show-delete:hover { background: rgba(248,113,113,0.1); }
    </style>
</head>
<body>

    <div class="toast" id="toast"></div>

    <div class="page-header">
        <h1 class="page-title">Com<span>munity</span> Polls</h1>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ url('/') }}" class="btn" style="background: transparent; color: var(--muted); border: 1px solid var(--border);">🏠 Home</a>
            <button onclick="openCreateModal()" class="btn btn-primary">+ Create Poll</button>
        </div>
    </div>

    <div class="filter-tabs" id="type-tabs">
        <button onclick="filterPolls(null, null)" class="filter-tab active-all" data-type="">🗳️ All Polls</button>
        <button onclick="filterPolls('urgent', null)" class="filter-tab" data-type="urgent">🚨 Urgent Polls</button>
        <button onclick="filterPolls('suggestion', null)" class="filter-tab" data-type="suggestion">💡 Community Suggestions</button>
    </div>

    <div class="filter-tabs" id="category-tabs">
        @foreach($categories as $category)
            <button onclick="filterPolls(null, {{ $category->id }})"
                    class="filter-tab"
                    data-category="{{ $category->id }}">
                {{ $category->icon }} {{ $category->name }}
            </button>
        @endforeach
    </div>

    <hr class="divider">

    @php
        $popular = \App\Models\Poll::withCount('votes')
                    ->orderBy('votes_count', 'desc')
                    ->take(3)
                    ->get();
    @endphp

    <div id="top-section">
        @if($popular->count() > 0)
            <div class="section-label">⭐ Top Suggestion</div>
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
                            <button onclick="openShowModal({{ $top->id }})"
                               style="font-family: 'Syne', sans-serif; font-weight: 700;
                                      font-size: 0.95rem; color: var(--text); text-decoration: none;
                                      background: none; border: none; cursor: pointer;
                                      display: block; margin-bottom: 0.4rem; text-align: left;">
                                {{ $top->title }}
                            </button>
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
    </div>

    <div class="section-label" id="section-label">🗳️ All Polls</div>

    <div id="polls-list">
        @forelse($polls as $poll)
            <div class="poll-card" id="poll-{{ $poll->id }}">
                <div class="poll-meta">
                    <div class="poll-avatar">{{ strtoupper(substr($poll->user->name ?? 'U', 0, 1)) }}</div>
                    <span class="poll-author">
                        <strong>{{ $poll->user->name ?? 'Unknown' }}</strong>
                        · {{ $poll->created_at->diffForHumans() }}
                    </span>
                    <span class="poll-badge {{ $poll->type === 'urgent' ? 'badge-urgent' : 'badge-suggestion' }}">
                        {{ $poll->type === 'urgent' ? '🚨 Urgent' : '💡 Suggestion' }}
                    </span>
                    @if($poll->category)
                        <span class="poll-badge badge-category">
                            {{ $poll->category->icon }} {{ $poll->category->name }}
                        </span>
                    @endif
                </div>

                <button onclick="openShowModal({{ $poll->id }})" class="poll-title">{{ $poll->title }}</button>

                @if($poll->description)
                    <p class="poll-description">{{ Str::limit($poll->description, 120) }}</p>
                @endif

                <div class="poll-footer">
                    <button onclick="castVote(this)"
                            class="vote-btn up {{ $poll->userVote(auth()->id())?->vote == 1 ? 'active' : '' }}"
                            data-poll="{{ $poll->id }}" data-vote="1">
                        👍 <span class="up-count-{{ $poll->id }}">{{ $poll->thumbsUp() }}</span>
                    </button>
                    <button onclick="castVote(this)"
                            class="vote-btn down {{ $poll->userVote(auth()->id())?->vote === 0 ? 'active' : '' }}"
                            data-poll="{{ $poll->id }}" data-vote="0">
                        👎 <span class="down-count-{{ $poll->id }}">{{ $poll->thumbsDown() }}</span>
                    </button>
                    <button onclick="openShowModal({{ $poll->id }})" class="view-link">View →</button>
                    @if(auth()->id() === $poll->user_id)
                        <button class="edit-btn" onclick="openEditModal({{ $poll->id }}, '{{ addslashes($poll->title) }}', '{{ addslashes($poll->description) }}', '{{ $poll->type }}', {{ $poll->category_id ?? 'null' }})">✏️ Edit</button>
                        <button class="delete-btn" onclick="openDeleteModal({{ $poll->id }})">🗑</button>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="icon">🗳️</div>
                <p>No polls found!</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 1.5rem;" id="pagination">
        {{ $polls->links() }}
    </div>

    {{-- Show Modal --}}
    <div class="modal-overlay" id="show-modal">
        <div class="modal" style="max-width: 600px;">
            <div class="modal-header">
                <div class="modal-title" id="show-type-badge"></div>
                <button class="modal-close" onclick="closeModal('show-modal')">✕</button>
            </div>
            <div id="show-modal-body">
                <div class="polls-loading">Loading...</div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal-overlay" id="create-modal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">✍️ Create Poll</div>
                <button class="modal-close" onclick="closeModal('create-modal')">✕</button>
            </div>
            <input type="text" class="title-input" id="create-title" placeholder="What's your poll question?" maxlength="255">
            <textarea class="desc-input" id="create-desc" placeholder="Add more context (optional)..."></textarea>

            <div class="field-label">🏷️ Category</div>
            <div class="category-options" id="create-category-options">
                @foreach($categories as $category)
                    <label onclick="selectCreateCategory({{ $category->id }}, this)"
                           id="cc-label-{{ $category->id }}"
                           class="cat-label">
                        {{ $category->icon }} {{ $category->name }}
                    </label>
                @endforeach
            </div>

            <div class="field-label">📋 Poll Type</div>
            <div class="type-options">
                <div class="type-option">
                    <input type="radio" name="create_type" id="ct-urgent" value="urgent">
                    <label for="ct-urgent" class="urgent">
                        <span class="type-icon">🚨</span>
                        <span class="type-title">Urgent Poll</span>
                        <span class="type-desc">Needs immediate attention</span>
                    </label>
                </div>
                <div class="type-option">
                    <input type="radio" name="create_type" id="ct-suggestion" value="suggestion">
                    <label for="ct-suggestion" class="suggestion">
                        <span class="type-icon">💡</span>
                        <span class="type-title">Community Suggestion</span>
                        <span class="type-desc">Share ideas with everyone</span>
                    </label>
                </div>
            </div>

            <hr class="modal-divider">
            <div class="modal-actions">
                <button class="btn-cancel-modal" onclick="closeModal('create-modal')">Cancel</button>
                <button class="btn-submit" onclick="submitCreate()">Post Poll</button>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal-overlay" id="edit-modal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">✏️ Edit Poll</div>
                <button class="modal-close" onclick="closeModal('edit-modal')">✕</button>
            </div>
            <input type="hidden" id="edit-poll-id">
            <input type="text" class="title-input" id="edit-title" placeholder="Poll question..." maxlength="255">
            <textarea class="desc-input" id="edit-desc" placeholder="Add more context (optional)..."></textarea>

            <div class="field-label">🏷️ Category</div>
            <div class="category-options" id="edit-category-options">
                @foreach($categories as $category)
                    <label onclick="selectEditCategory({{ $category->id }}, this)"
                           id="ec-label-{{ $category->id }}"
                           class="cat-label">
                        {{ $category->icon }} {{ $category->name }}
                    </label>
                @endforeach
            </div>

            <div class="field-label">📋 Poll Type</div>
            <div class="type-options">
                <div class="type-option">
                    <input type="radio" name="edit_type" id="et-urgent" value="urgent">
                    <label for="et-urgent" class="urgent">
                        <span class="type-icon">🚨</span>
                        <span class="type-title">Urgent Poll</span>
                        <span class="type-desc">Needs immediate attention</span>
                    </label>
                </div>
                <div class="type-option">
                    <input type="radio" name="edit_type" id="et-suggestion" value="suggestion">
                    <label for="et-suggestion" class="suggestion">
                        <span class="type-icon">💡</span>
                        <span class="type-title">Community Suggestion</span>
                        <span class="type-desc">Share ideas with everyone</span>
                    </label>
                </div>
            </div>

            <hr class="modal-divider">
            <div class="modal-actions">
                <button class="btn-cancel-modal" onclick="closeModal('edit-modal')">Cancel</button>
                <button class="btn-submit" onclick="submitEdit()">Save Changes</button>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal-overlay" id="delete-modal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title" style="color: var(--danger);">🗑 Delete Poll</div>
                <button class="modal-close" onclick="closeModal('delete-modal')">✕</button>
            </div>
            <input type="hidden" id="delete-poll-id">
            <p class="delete-modal-text">Are you sure you want to delete this poll? This action cannot be undone and all votes will be lost.</p>
            <div class="modal-actions">
                <button class="btn-cancel-modal" onclick="closeModal('delete-modal')">Cancel</button>
                <button class="btn-confirm-delete" onclick="submitDelete()">Yes, Delete</button>
            </div>
        </div>
    </div>

    <script>
        const csrf = '{{ csrf_token() }}';
        let activeType = null;
        let activeCategoryId = null;
        let selectedCreateCategory = null;
        let selectedEditCategory = null;

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `toast ${type} show`;
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }

        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('open');
            });
        });

        // CATEGORY SELECTION
        function selectCreateCategory(id, el) {
            selectedCreateCategory = id;
            document.querySelectorAll('#create-category-options .cat-label').forEach(l => l.classList.remove('cat-active'));
            el.classList.add('cat-active');
        }

        function selectEditCategory(id, el) {
            selectedEditCategory = id;
            document.querySelectorAll('#edit-category-options .cat-label').forEach(l => l.classList.remove('cat-active'));
            el.classList.add('cat-active');
        }

        // SHOW MODAL
        function openShowModal(pollId) {
            document.getElementById('show-modal-body').innerHTML = '<div class="polls-loading">Loading...</div>';
            openModal('show-modal');

            fetch(`/polls/${pollId}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
            })
            .then(res => res.json())
            .then(data => {
                const typeBadge = data.type === 'urgent'
                    ? "<span class='poll-badge badge-urgent'>🚨 Urgent</span>"
                    : "<span class='poll-badge badge-suggestion'>💡 Suggestion</span>";
                const categoryBadge = data.category
                    ? `<span class='poll-badge badge-category'>${data.category.icon} ${data.category.name}</span>`
                    : '';

                document.getElementById('show-type-badge').innerHTML = typeBadge + ' ' + categoryBadge;

                const description = data.description
                    ? `<p class="show-poll-desc">${data.description}</p>`
                    : '';

                const upActive = data.userVote === 1 ? 'active' : '';
                const downActive = data.userVote === 0 ? 'active' : '';

                const ownerActions = data.isOwner ? `
                    <hr class="modal-divider">
                    <div class="show-owner-actions">
                        <button class="btn-show-edit" onclick="closeModal('show-modal'); openEditModal(${data.id}, '${data.title.replace(/'/g, "\\'")}', '${(data.description || '').replace(/'/g, "\\'")}', '${data.type}', ${data.category_id})">✏️ Edit Poll</button>
                        <button class="btn-show-delete" onclick="closeModal('show-modal'); openDeleteModal(${data.id})">🗑 Delete</button>
                    </div>` : '';

                document.getElementById('show-modal-body').innerHTML = `
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem;">
                        <div class="poll-avatar" style="width:32px;height:32px;font-size:0.75rem;">${data.user.name.charAt(0).toUpperCase()}</div>
                        <span class="poll-author"><strong>${data.user.name}</strong> · ${data.created_at}</span>
                    </div>
                    <div class="show-poll-title">${data.title}</div>
                    ${description}
                    <div class="show-vote-section">
                        <button onclick="castShowVote(${data.id}, 1, this)" class="vote-btn up ${upActive}" data-show-poll="${data.id}" data-vote="1">
                            👍 <span class="show-up-count">${data.thumbsUp}</span>
                        </button>
                        <button onclick="castShowVote(${data.id}, 0, this)" class="vote-btn down ${downActive}" data-show-poll="${data.id}" data-vote="0">
                            👎 <span class="show-down-count">${data.thumbsDown}</span>
                        </button>
                        <span class="show-vote-count"><span class="show-total">${data.thumbsUp + data.thumbsDown}</span> total votes</span>
                    </div>
                    ${ownerActions}
                `;
            })
            .catch(() => {
                document.getElementById('show-modal-body').innerHTML = '<div class="empty-state"><p>Failed to load poll.</p></div>';
            });
        }

        function castShowVote(pollId, vote, btn) {
            fetch(`/polls/${pollId}/vote`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ vote })
            })
            .then(res => res.json())
            .then(data => {
                document.querySelector('.show-up-count').textContent = data.thumbsUp;
                document.querySelector('.show-down-count').textContent = data.thumbsDown;
                document.querySelector('.show-total').textContent = data.thumbsUp + data.thumbsDown;

                const upBtn = document.querySelector(`[data-show-poll="${pollId}"][data-vote="1"]`);
                const downBtn = document.querySelector(`[data-show-poll="${pollId}"][data-vote="0"]`);
                upBtn.classList.remove('active');
                downBtn.classList.remove('active');
                if (data.userVote === 1) upBtn.classList.add('active');
                if (data.userVote === 0) downBtn.classList.add('active');

                const upCount = document.querySelector(`.up-count-${pollId}`);
                const downCount = document.querySelector(`.down-count-${pollId}`);
                if (upCount) upCount.textContent = data.thumbsUp;
                if (downCount) downCount.textContent = data.thumbsDown;

                refreshTopSection();
            });
        }

        // FILTER
        function filterPolls(type, categoryId) {
            activeType = type;
            activeCategoryId = categoryId;

            document.querySelectorAll('#type-tabs .filter-tab').forEach(tab => {
                tab.className = 'filter-tab';
                const t = tab.dataset.type;
                if (!type && !categoryId && t === '') tab.classList.add('active-all');
                else if (type === 'urgent' && t === 'urgent') tab.classList.add('active-urgent');
                else if (type === 'suggestion' && t === 'suggestion') tab.classList.add('active-suggestion');
            });

            document.querySelectorAll('#category-tabs .filter-tab').forEach(tab => {
                tab.className = 'filter-tab';
                if (categoryId && tab.dataset.category == categoryId) tab.classList.add('active-category');
            });

            const label = document.getElementById('section-label');
            if (type === 'urgent') label.textContent = '🚨 Urgent Polls';
            else if (type === 'suggestion') label.textContent = '💡 Community Suggestions';
            else label.textContent = '🗳️ All Polls';

            document.getElementById('top-section').style.display = (!type && !categoryId) ? 'block' : 'none';
            document.getElementById('polls-list').innerHTML = '<div class="polls-loading">Loading...</div>';

            const params = new URLSearchParams();
            if (type) params.append('type', type);
            if (categoryId) params.append('category', categoryId);

            fetch(`/polls?${params.toString()}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('polls-list').innerHTML = data.html;
                document.getElementById('pagination').innerHTML = '';
            })
            .catch(() => {
                document.getElementById('polls-list').innerHTML = '<div class="empty-state"><div class="icon">⚠️</div><p>Failed to load polls.</p></div>';
            });
        }

        // CREATE
        function openCreateModal() {
            document.getElementById('create-title').value = '';
            document.getElementById('create-desc').value = '';
            selectedCreateCategory = null;
            document.querySelectorAll('#create-category-options .cat-label').forEach(l => l.classList.remove('cat-active'));
            document.querySelectorAll('input[name="create_type"]').forEach(r => r.checked = false);
            openModal('create-modal');
        }

        function submitCreate() {
            const title = document.getElementById('create-title').value.trim();
            const desc = document.getElementById('create-desc').value.trim();
            const category = selectedCreateCategory;
            const type = document.querySelector('input[name="create_type"]:checked')?.value;

            if (!title) return showToast('Please enter a title!', 'error');
            if (!category) return showToast('Please select a category!', 'error');
            if (!type) return showToast('Please select a poll type!', 'error');

            const formData = new FormData();
            formData.append('_token', csrf);
            formData.append('title', title);
            formData.append('description', desc);
            formData.append('category_id', category);
            formData.append('type', type);

            fetch('{{ route("polls.store") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeModal('create-modal');
                    showToast('Poll created successfully! 🎉');
                    setTimeout(() => {
                        filterPolls(activeType, activeCategoryId);
                        refreshTopSection();
                    }, 800);
                } else {
                    showToast(data.message || 'Something went wrong!', 'error');
                }
            })
            .catch(() => showToast('Something went wrong!', 'error'));
        }

        // EDIT
        function openEditModal(id, title, desc, type, categoryId) {
            document.getElementById('edit-poll-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-desc').value = desc;
            document.querySelectorAll('input[name="edit_type"]').forEach(r => r.checked = r.value === type);
            selectedEditCategory = categoryId;
            document.querySelectorAll('#edit-category-options .cat-label').forEach(l => l.classList.remove('cat-active'));
            const activeLabel = document.getElementById(`ec-label-${categoryId}`);
            if (activeLabel) activeLabel.classList.add('cat-active');
            openModal('edit-modal');
        }

        function submitEdit() {
            const id = document.getElementById('edit-poll-id').value;
            const title = document.getElementById('edit-title').value.trim();
            const desc = document.getElementById('edit-desc').value.trim();
            const category = selectedEditCategory;
            const type = document.querySelector('input[name="edit_type"]:checked')?.value;

            if (!title) return showToast('Please enter a title!', 'error');
            if (!category) return showToast('Please select a category!', 'error');
            if (!type) return showToast('Please select a poll type!', 'error');

            const formData = new FormData();
            formData.append('_token', csrf);
            formData.append('_method', 'PUT');
            formData.append('title', title);
            formData.append('description', desc);
            formData.append('category_id', category);
            formData.append('type', type);

            fetch(`/polls/${id}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeModal('edit-modal');
                    showToast('Poll updated! ✅');
                    setTimeout(() => {
                        filterPolls(activeType, activeCategoryId);
                        refreshTopSection();
                    }, 800);
                } else {
                    showToast(data.message || 'Something went wrong!', 'error');
                }
            })
            .catch(() => showToast('Something went wrong!', 'error'));
        }

        // DELETE
        function openDeleteModal(id) {
            document.getElementById('delete-poll-id').value = id;
            openModal('delete-modal');
        }

        function submitDelete() {
            const id = document.getElementById('delete-poll-id').value;

            const formData = new FormData();
            formData.append('_token', csrf);
            formData.append('_method', 'DELETE');

            fetch(`/polls/${id}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeModal('delete-modal');
                    closeModal('show-modal');
                    document.getElementById(`poll-${id}`)?.remove();
                    document.querySelectorAll(`[onclick*="openShowModal(${id})"]`).forEach(el => {
                        el.closest('.top-card')?.remove();
                    });
                    showToast('Poll deleted! 🗑');
                    refreshTopSection();
                } else {
                    showToast(data.message || 'Something went wrong!', 'error');
                }
            })
            .catch(() => showToast('Something went wrong!', 'error'));
        }

        // VOTE on index cards
        function castVote(btn) {
            const pollId = btn.dataset.poll;
            const vote = btn.dataset.vote;

            fetch(`/polls/${pollId}/vote`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ vote })
            })
            .then(res => res.json())
            .then(data => {
                const card = btn.closest('.poll-card');
                if (!card) return;

                const upCount = card.querySelector(`[class*="up-count-"]`);
                const downCount = card.querySelector(`[class*="down-count-"]`);
                if (upCount) upCount.textContent = data.thumbsUp;
                if (downCount) downCount.textContent = data.thumbsDown;

                const upBtn = card.querySelector(`[data-vote="1"]`);
                const downBtn = card.querySelector(`[data-vote="0"]`);
                if (upBtn) upBtn.classList.remove('active');
                if (downBtn) downBtn.classList.remove('active');
                if (data.userVote === 1 && upBtn) upBtn.classList.add('active');
                if (data.userVote === 0 && downBtn) downBtn.classList.add('active');

                refreshTopSection();
            });
        }

        // REFRESH TOP SECTION
        function refreshTopSection() {
            fetch('/polls/top', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('top-section').innerHTML = data.html;
            });
        }
    </script>

</body>
</html>