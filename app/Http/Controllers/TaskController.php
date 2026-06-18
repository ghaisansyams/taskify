<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $query = Task::query();

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['title', 'priority', 'status', 'due_date', 'created_at'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction === 'asc' ? 'asc' : 'desc');
        }

        $tasks = $query->paginate(9)->withQueryString();

        $stats = [
            'total'       => Task::count(),
            'todo'        => Task::byStatus('todo')->count(),
            'in_progress' => Task::byStatus('in_progress')->count(),
            'done'        => Task::byStatus('done')->count(),
            'overdue'     => Task::overdue()->count(),
        ];

        return view('tasks.index', compact('tasks', 'stats'));
    }

    public function create(): View
    {
        return view('tasks.create', [
            'priorities' => Task::PRIORITIES,
            'statuses'   => Task::STATUSES,
            'categories' => Task::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'priority'    => 'required|in:' . implode(',', Task::PRIORITIES),
            'status'      => 'required|in:' . implode(',', Task::STATUSES),
            'category'    => 'required|in:' . implode(',', Task::CATEGORIES),
            'due_date'    => 'nullable|date',
        ]);

        if ($validated['status'] === 'done') {
            $validated['completed_at'] = now();
        }

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task): View
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', [
            'task'       => $task,
            'priorities' => Task::PRIORITIES,
            'statuses'   => Task::STATUSES,
            'categories' => Task::CATEGORIES,
        ]);
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'priority'    => 'required|in:' . implode(',', Task::PRIORITIES),
            'status'      => 'required|in:' . implode(',', Task::STATUSES),
            'category'    => 'required|in:' . implode(',', Task::CATEGORIES),
            'due_date'    => 'nullable|date',
        ]);

        if ($validated['status'] === 'done' && $task->status !== 'done') {
            $validated['completed_at'] = now();
        } elseif ($validated['status'] !== 'done') {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', Task::STATUSES),
        ]);

        if ($validated['status'] === 'done') {
            $validated['completed_at'] = now();
        } else {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        return back()->with('success', 'Task status updated!');
    }
}
