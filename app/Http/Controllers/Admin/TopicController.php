<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Subject;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::paginate(10);
        return view('admin.topics.index', compact('topics'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('admin.topics.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        Topic::create([
            'name' => $request->name,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('admin.topics.index')
            ->with('success', 'Topic created successfully.');
    }

    public function show(Topic $topic)
    {
        $topic->load(['subject', 'questions']);
        return view('admin.topics.show', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        $subjects = Subject::all();
        return view('admin.topics.edit', compact('topic', 'subjects'));
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $topic->update([
            'name' => $request->name,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('admin.topics.index')
            ->with('success', 'Topic updated successfully.');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect()->route('admin.topics.index')
            ->with('success', 'Topic deleted successfully.');
    }
}
