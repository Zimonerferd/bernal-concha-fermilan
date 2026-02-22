@extends('layouts.sneat')

@section('title', 'Home — KEPABARA')

@push('styles')
<style>
    :root {
        --bg: #0f0f13;
        --surface: #18181f;
        --border: #2a2a35;
        --accent: #7c6af7;
        --accent-glow: rgba(124, 106, 247, 0.18);
        --text: #eeeef2;
        --muted: #7a7a90;
        --success: #4ade80;
        --warning: #ffa657;
        --danger: #f87171;
    }

    .layout-wrapper,
    .layout-container,
    .layout-page,
    .content-wrapper {
        background: var(--bg) !important;
    }

    /* Dark navbar */
    .navbar-detached,
    .layout-navbar {
        background-color: var(--surface) !important;
        border-bottom: 1px solid var(--border) !important;
        box-shadow: none !important;
    }

    .navbar .form-control,
    .navbar input[type="text"] {
        background-color: var(--surface) !important;
        border-color: var(--border) !important;
        color: var(--text) !important;
    }

    .navbar input::placeholder { color: var(--muted) !important; }
    .navbar .bx-search { color: var(--muted) !important; }

    /* Dark dropdown */
    .dropdown-menu {
        background-color: var(--surface) !important;
        border: 1px solid var(--border) !important;
    }

    .dropdown-item { color: var(--text) !important; }
    .dropdown-item:hover { background-color: rgba(124, 106, 247, 0.08) !important; }
    .dropdown-divider { border-color: var(--border) !important; }
    .text-muted { color: var(--muted) !important; }

    .announcement-card {
        background: var(--surface) !important;
        border: 1px solid var(--border) !important;
        border-radius: 12px !important;
        color: var(--text) !important;
        box-shadow: none !important;
    }

    .announcement-card .card-body { padding: 1.25rem; }

    .announcement-card h6 {
        color: var(--text) !important;
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .announcement-card p {
        color: var(--muted) !important;
        font-size: 0.875rem;
        line-height: 1.6;
        margin: 0;
    }

    .announcement-card a { color: var(--accent) !important; }

    .tag {
        display: inline-flex;
        align-items: center;
        border-radius: 99px;
        padding: 2px 10px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .tag-pinned {
        background: rgba(124,106,247,0.12);
        color: var(--accent);
        border: 1px solid rgba(124,106,247,0.3);
    }

    .tag-new {
        background: rgba(74,222,128,0.12);
        color: var(--success);
        border: 1px solid rgba(74,222,128,0.3);
    }

    .tag-reminder {
        background: rgba(255,166,87,0.12);
        color: var(--warning);
        border: 1px solid rgba(255,166,87,0.3);
    }

    .tag-important {
        background: rgba(248,113,113,0.12);
        color: var(--danger);
        border: 1px solid rgba(248,113,113,0.3);
    }

    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--muted);
        margin-bottom: 1rem;
    }

    .meta-date {
        font-size: 0.78rem;
        color: var(--muted);
    }
</style>
@endpush

@section('content')

{{-- Welcome Banner --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card announcement-card" style="border-left: 3px solid var(--accent) !important;
             background: linear-gradient(135deg, rgba(59,47,160,0.5) 0%, rgba(124,106,247,0.2) 100%) !important;">
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5 style="color: var(--text); font-weight: 700; margin-bottom: 0.25rem;">
                        Welcome back, {{ Auth::user()->name ?? 'there' }}! 👋
                    </h5>
                    <p style="color: var(--muted); font-size: 0.875rem; margin: 0;">
                        Here's what's happening at KEPABARA today.
                    </p>
                </div>
                <a href="{{ route('polls.index') }}"
                    style="background: var(--accent); color: #fff !important; padding: 0.5rem 1.25rem;
                    border-radius: 8px; font-size: 0.875rem; font-weight: 600;
                    text-decoration: none; white-space: nowrap;
                    transition: all 0.15s; box-shadow: 0 4px 16px rgba(124,106,247,0.3);">
                    🗳️ Community Polls
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Announcements --}}
<div class="row">
    <div class="col-12 mb-2">
        <div class="section-label">📢 Announcements</div>
    </div>

    {{-- Pinned --}}
    <div class="col-12 mb-3">
        <div class="card announcement-card" style="border-left: 3px solid var(--accent) !important;">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="tag tag-pinned">📌 Pinned</span>
                    <span class="meta-date">Feb 22, 2026</span>
                </div>
                <h6>Welcome to the KEPABARA Portal!</h6>
                <p>This is your central hub for all company updates, announcements, and community polls.
                   Use the sidebar to navigate and don't forget to check out the Polls page to make your voice heard!</p>
            </div>
        </div>
    </div>

    {{-- New --}}
    <div class="col-12 mb-3">
        <div class="card announcement-card" style="border-left: 3px solid var(--success) !important;">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="tag tag-new">🆕 New</span>
                    <span class="meta-date">Feb 20, 2026</span>
                </div>
                <h6>Employee Records System is Now Live</h6>
                <p>You can now view and manage employee records through the Employees section in the sidebar.
                   Please ensure all records are up to date.</p>
            </div>
        </div>
    </div>

    {{-- Reminder --}}
    <div class="col-12 mb-3">
        <div class="card announcement-card" style="border-left: 3px solid var(--warning) !important;">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="tag tag-reminder">📅 Reminder</span>
                    <span class="meta-date">Feb 18, 2026</span>
                </div>
                <h6>Community Poll: Office Hours Feedback</h6>
                <p>There's an active poll regarding preferred office hours. Your vote matters —
                   head over to the <a href="{{ route('polls.index') }}">Polls page</a> to participate!</p>
            </div>
        </div>
    </div>

    {{-- Important --}}
    <div class="col-12 mb-3">
        <div class="card announcement-card" style="border-left: 3px solid var(--danger) !important;">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="tag tag-important">⚠️ Important</span>
                    <span class="meta-date">Feb 15, 2026</span>
                </div>
                <h6>System Maintenance — Feb 28</h6>
                <p>The portal will undergo scheduled maintenance on February 28, 2026 from 12:00 AM to 4:00 AM.
                   Please save your work before then.</p>
            </div>
        </div>
    </div>

</div>
@endsection