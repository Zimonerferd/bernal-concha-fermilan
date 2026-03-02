<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollVote;
use App\Models\Category;
use Illuminate\Http\Request;

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

        Poll::create($validated);

        return redirect()->route('polls.index')->with('success', 'Poll posted successfully!');
    }

    public function show(Poll $poll)
    {
        $poll->load('votes', 'user', 'category');
        $userVote = $poll->userVote(auth()->id());
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
            return redirect()->route('polls.index')->with('error', 'You can only edit your own polls.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:urgent,suggestion',
            'category_id' => 'required|exists:categories,id',
        ]);

        $poll->update($validated);

        return redirect()->route('polls.show', $poll->id)->with('success', 'Poll updated successfully!');
    }

    public function destroy(Poll $poll)
    {
        if ($poll->user_id !== auth()->id()) {
            return redirect()->route('polls.index')->with('error', 'You can only delete your own polls.');
        }

        $poll->delete();
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

        return back();
    }
}