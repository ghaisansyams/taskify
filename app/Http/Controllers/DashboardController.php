<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total'       => Task::count(),
            'todo'        => Task::byStatus('todo')->count(),
            'in_progress' => Task::byStatus('in_progress')->count(),
            'done'        => Task::byStatus('done')->count(),
            'overdue'     => Task::overdue()->count(),
        ];

        $completionRate = $stats['total'] > 0
            ? round(($stats['done'] / $stats['total']) * 100)
            : 0;

        $recentTasks = Task::latest()->take(5)->get();
        $overdueTasks = Task::overdue()->orderBy('due_date')->take(5)->get();
        $urgentTasks = Task::byPriority('urgent')->where('status', '!=', 'done')->take(5)->get();

        $byCategory = Task::selectRaw('category, count(*) as total, sum(case when status = "done" then 1 else 0 end) as done')
            ->groupBy('category')
            ->get();

        $byPriority = Task::selectRaw('priority, count(*) as total')
            ->groupBy('priority')
            ->get()
            ->keyBy('priority');

        return view('dashboard.index', compact(
            'stats',
            'completionRate',
            'recentTasks',
            'overdueTasks',
            'urgentTasks',
            'byCategory',
            'byPriority'
        ));
    }
}
