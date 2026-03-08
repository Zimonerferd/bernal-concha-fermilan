<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollVote;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $type = $request->query('type');
        $categoryId = $request->query('category');

        $query = Poll::with('votes', 'user', 'category')->latest();

        if ($type) {
            $query->where('type', $type);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $polls = $query->paginate(10);
        $categories = Category::all();

        if ($request->wantsJson()) {
            $html = '';
            foreach ($polls as $poll) {
                $typeLabel = $poll->type === 'urgent' ? '🚨 Urgent' : '💡 Suggestion';
                $typeBadge = $poll->type === 'urgent' ? 'badge-urgent' : 'badge-suggestion';
                $categoryBadge = $poll->category ? "<span class='poll-badge badge-category'>{$poll->category->icon} {$poll->category->name}</span>" : '';
                $userInitial = strtoupper(substr($poll->user->name ?? 'U', 0, 1));
                $userName = e($poll->user->name ?? 'Unknown');
                $timeAgo = $poll->created_at->diffForHumans();
                $title = e($poll->title);
                $description = $poll->description ? '<p class="poll-description">' . e(Str::limit($poll->description, 120)) . '</p>' : '';
                $thumbsUp = $poll->thumbsUp();
                $thumbsDown = $poll->thumbsDown();
                $upActive = $poll->userVote(auth()->id())?->vote == 1 ? 'active' : '';
                $downActive = $poll->userVote(auth()->id())?->vote === 0 ? 'active' : '';
                $authId = auth()->id();
                $ownerButtons = '';
                if ($authId === $poll->user_id) {
                    $escapedTitle = addslashes($poll->title);
                    $escapedDesc = addslashes($poll->description ?? '');
                    $catId = $poll->category_id ?? 'null';
                    $ownerButtons = "
                        <button class='edit-btn' onclick=\"openEditModal({$poll->id}, '{$escapedTitle}', '{$escapedDesc}', '{$poll->type}', {$catId})\">✏️ Edit</button>
                        <button class='delete-btn' onclick='openDeleteModal({$poll->id})'>🗑</button>
                    ";
                }

                $html .= "
                <div class='poll-card' id='poll-{$poll->id}'>
                    <div class='poll-meta'>
                        <div class='poll-avatar'>{$userInitial}</div>
                        <span class='poll-author'><strong>{$userName}</strong> · {$timeAgo}</span>
                        <span class='poll-badge {$typeBadge}'>{$typeLabel}</span>
                        {$categoryBadge}
                    </div>
                    <a href='javascript:void(0)' onclick='openShowModal({$poll->id})' class='poll-title'>{$title}</a>
                    {$description}
                    <div class='poll-footer'>
                        <button onclick='castVote(this)' class='vote-btn up {$upActive}' data-poll='{$poll->id}' data-vote='1'>
                            👍 <span class='up-count-{$poll->id}'>{$thumbsUp}</span>
                        </button>
                        <button onclick='castVote(this)' class='vote-btn down {$downActive}' data-poll='{$poll->id}' data-vote='0'>
                            👎 <span class='down-count-{$poll->id}'>{$thumbsDown}</span>
                        </button>
                        <button onclick='openShowModal({$poll->id})' class='view-link' style='background:none;border:none;cursor:pointer;font-family:inherit;'>View →</button>
                        {$ownerButtons}
                    </div>
                </div>";
            }

            if ($polls->isEmpty()) {
                $html = "<div class='empty-state'><div class='icon'>🗳️</div><p>No polls found!</p></div>";
            }

            return response()->json([
                'html' => $html,
                'total' => $polls->total(),
                'type' => $type,
                'categoryId' => $categoryId,
            ]);
        }

        return view('polls.index', compact('polls', 'type', 'categories', 'categoryId'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('polls.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:urgent,suggestion',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = auth()->id();
        $poll = Poll::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'poll' => $poll]);
        }

        return redirect()->route('polls.index')->with('success', 'Poll posted successfully!');
    }

    public function show(Poll $poll)
    {
        $poll->load('votes', 'user', 'category');
        $userVote = $poll->userVote(auth()->id());

        if (request()->wantsJson()) {
            return response()->json([
                'id'          => $poll->id,
                'title'       => $poll->title,
                'description' => $poll->description,
                'type'        => $poll->type,
                'category'    => $poll->category ? ['icon' => $poll->category->icon, 'name' => $poll->category->name] : null,
                'user'        => ['name' => $poll->user->name ?? 'Unknown'],
                'created_at'  => $poll->created_at->diffForHumans(),
                'thumbsUp'    => $poll->thumbsUp(),
                'thumbsDown'  => $poll->thumbsDown(),
                'userVote'    => $userVote ? $userVote->vote : null,
                'isOwner'     => auth()->id() === $poll->user_id,
                'category_id' => $poll->category_id,
            ]);
        }

        return view('polls.show', compact('poll', 'userVote'));
    }

    public function edit(Poll $poll)
    {
        if ($poll->user_id !== auth()->id()) {
            return redirect()->route('polls.index')->with('error', 'You can only edit your own polls.');
        }
        $categories = Category::all();
        return view('polls.edit', compact('poll', 'categories'));
    }

    public function update(Request $request, Poll $poll)
    {
        if ($poll->user_id !== auth()->id()) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            return redirect()->route('polls.index')->with('error', 'You can only edit your own polls.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:urgent,suggestion',
            'category_id' => 'required|exists:categories,id',
        ]);

        $poll->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'poll' => $poll]);
        }

        return redirect()->route('polls.show', $poll->id)->with('success', 'Poll updated successfully!');
    }

    public function destroy(Poll $poll)
    {
        if ($poll->user_id !== auth()->id()) {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            return redirect()->route('polls.index')->with('error', 'You can only delete your own polls.');
        }

        $poll->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('polls.index')->with('success', 'Poll deleted.');
    }

    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'vote' => 'required|in:0,1',
        ]);

        $existing = PollVote::where('poll_id', $poll->id)
                            ->where('user_id', auth()->id())
                            ->first();

        if ($existing) {
            if ($existing->vote == $request->vote) {
                $existing->delete();
            } else {
                $existing->update(['vote' => $request->vote]);
            }
        } else {
            PollVote::create([
                'poll_id' => $poll->id,
                'user_id' => auth()->id(),
                'vote'    => $request->vote,
            ]);
        }

        $userVote = PollVote::where('poll_id', $poll->id)
                            ->where('user_id', auth()->id())
                            ->first();

        return response()->json([
            'thumbsUp'   => $poll->thumbsUp(),
            'thumbsDown' => $poll->thumbsDown(),
            'userVote'   => $userVote ? $userVote->vote : null,
        ]);
    }

    public function top()
    {
        $popular = Poll::withCount('votes')
                    ->orderBy('votes_count', 'desc')
                    ->take(3)
                    ->get();

        $html = '';
        if ($popular->count() > 0) {
            $medals = ['🥇', '🥈', '🥉'];
            $html .= "<div class='section-label'>⭐ Top Suggestion</div><div style='display:flex;flex-direction:column;gap:0.6rem;margin-bottom:2rem;'>";
            foreach ($popular as $index => $top) {
                $medal = $medals[$index];
                $up = $top->thumbsUp();
                $down = $top->thumbsDown();
                $total = $top->votes_count;
                $upPercent = $total > 0 ? round(($up / $total) * 100) : 0;
                $title = e($top->title);
                $bar = $total > 0 ? "<div style='margin-top:0.5rem;height:3px;background:var(--border);border-radius:99px;'><div style='height:100%;width:{$upPercent}%;background:linear-gradient(90deg,var(--accent),#a78bfa);border-radius:99px;'></div></div>" : '';
                $html .= "
                <div class='top-card'>
                    <span style='font-size:1.4rem;'>{$medal}</span>
                    <div style='flex:1;'>
                        <button onclick='openShowModal({$top->id})'
                            style='font-family:Syne,sans-serif;font-weight:700;font-size:0.95rem;color:var(--text);background:none;border:none;cursor:pointer;display:block;margin-bottom:0.4rem;text-align:left;'>
                            {$title}
                        </button>
                        <div style='display:flex;align-items:center;gap:0.75rem;'>
                            <span style='font-size:0.78rem;color:var(--success);'>👍 {$up}</span>
                            <span style='font-size:0.78rem;color:var(--danger);'>👎 {$down}</span>
                            <span style='font-size:0.78rem;color:var(--muted);'>{$total} total votes</span>
                        </div>
                        {$bar}
                    </div>
                </div>";
            }
            $html .= "</div><hr class='divider'>";
        }

        return response()->json(['html' => $html]);
    }
}