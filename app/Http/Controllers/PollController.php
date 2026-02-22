<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $polls = Poll::with('votes')->latest()->paginate(10);
        return view('polls.index', compact('polls'));
    }

    public function create()
    {
        return view('polls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Poll::create($validated);

        return redirect()->route('polls.index')->with('success', 'Poll posted successfully!');
    }

    public function show(Poll $poll)
    {
        $poll->load('votes', 'user');
        $userVote = $poll->userVote(auth()->id());
        return view('polls.show', compact('poll', 'userVote'));
    }

    public function edit(Poll $poll)
    {
        if ($poll->user_id !== auth()->id()) {
            return redirect()->route('polls.index')->with('error', 'You can only edit your own polls.');
        }
        return view('polls.edit', compact('poll'));
    }

    public function update(Request $request, Poll $poll)
    {
        if ($poll->user_id !== auth()->id()) {
            return redirect()->route('polls.index')->with('error', 'You can only edit your own polls.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
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
                // clicking same vote removes it
                $existing->delete();
            } else {
                // switch vote
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