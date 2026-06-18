@extends('layouts.app')

@section('title', 'All Tasks')
@section('heading', 'All Tasks')
@section('subheading', 'Manage and track all your tasks')

@section('content')
<div class="space-y-6 animate-fade-in">

    {{-- ── FILTER BAR ──────────────────────────────────────────── --}}
    <div class="card p-5">
        <form action="{{ route('tasks.index') }}" method="GET">
            <div class="flex flex-wrap items-end gap-4">

                {{-- Search --}}
                <div class="flex-1 min-w-52">
                    <label class="form-label">Search</label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks…"
                               class="form-field pl-10">
                    </div>
                </div>

                {{-- Status --}}
                <div class="min-w-40">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-field">
                        <option value="">All Status</option>
                        <option value="todo"        {{ request('status') === 'todo'        ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done"        {{ request('status') === 'done'        ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                {{-- Priority --}}
                <div class="min-w-40">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-field">
                        <option value="">All Priority</option>
                        <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="high"   {{ request('priority') === 'high'   ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low"    {{ request('priority') === 'low'    ? 'selected' : '' }}>Low</option>
                    </select>
                </div>

                {{-- Category --}}
                <div class="min-w-40">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-field">
                        <option value="">All Categories</option>
                        @foreach(['work' => 'Work', 'personal' => 'Personal', 'health' => 'Health', 'finance' => 'Finance', 'learning' => 'Learning', 'other' => 'Other'] as $val => $label)
                        <option value="{{ $val }}" {{ request('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'priority', 'category']))
                    <a href="{{ route('tasks.index') }}" class="btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- ── QUICK FILTER TABS ───────────────────────────────────── --}}
    <div class="flex flex-wrap gap-2">
        @foreach([
            ['',            'bg-primary-600 text-white',         'All',         $stats['total']],
            ['todo',        'bg-slate-100 text-slate-700',        'To Do',       $stats['todo']],
            ['in_progress', 'bg-blue-100 text-blue-700',          'In Progress', $stats['in_progress']],
            ['done',        'bg-green-100 text-green-700',        'Done',        $stats['done']],
        ] as [$status, $cls, $label, $count])
        @php $active = request('status') === $status || ($status === '' && !request('status')); @endphp
        <a href="{{ route('tasks.index', $status ? ['status' => $status] : []) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-150 cursor-pointer
                  {{ $active ? $cls : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            {{ $label }}
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full text-xs font-bold
                {{ $active ? 'bg-white/30' : 'bg-slate-100 text-slate-500' }}">{{ $count }}</span>
        </a>
        @endforeach
    </div>

    {{-- ── TASK GRID ───────────────────────────────────────────── --}}
    @if($tasks->isEmpty())
    <div class="card p-16 flex flex-col items-center justify-center text-center">
        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-800 mb-1">No tasks found</h3>
        <p class="text-sm text-slate-400 mb-6">Try adjusting your filters or create a new task.</p>
        <a href="{{ route('tasks.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Create Task
        </a>
    </div>

    @else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($tasks as $task)
        @php
        $priorityStripe = match($task->priority) {
            'urgent' => 'bg-red-500',
            'high'   => 'bg-orange-500',
            'medium' => 'bg-yellow-400',
            default  => 'bg-green-500',
        };
        $priorityBadge = match($task->priority) {
            'urgent' => 'bg-red-100 text-red-600',
            'high'   => 'bg-orange-100 text-orange-600',
            'medium' => 'bg-yellow-100 text-yellow-600',
            default  => 'bg-green-100 text-green-600',
        };
        $statusBadge = match($task->status) {
            'done'        => 'bg-green-100 text-green-700',
            'in_progress' => 'bg-blue-100 text-blue-700',
            default       => 'bg-slate-100 text-slate-600',
        };
        $catIconPaths = [
            'work'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>',
            'personal' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            'health'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
            'finance'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'learning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>',
            'other'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>',
        ];
        @endphp

        <div class="card p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden
                    {{ $task->isOverdue() ? 'border-red-200' : '' }}">

            {{-- Priority stripe --}}
            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $priorityStripe }}"></div>

            <div class="pl-3">
                {{-- Card header --}}
                <div class="flex items-start justify-between gap-2 mb-3">
                    <div class="flex items-center gap-2.5 flex-1 min-w-0">
                        <div class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $catIconPaths[$task->category] ?? $catIconPaths['other'] !!}
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 truncate group-hover:text-primary-700 transition-colors
                                   {{ $task->status === 'done' ? 'line-through text-slate-400' : '' }}">
                            {{ $task->title }}
                        </h3>
                    </div>

                    {{-- Three-dot dropdown --}}
                    <div class="relative shrink-0" data-dropdown-parent>
                        <button onclick="toggleDropdown('task-menu-{{ $task->id }}')"
                                class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer"
                                aria-label="Task options">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/>
                            </svg>
                        </button>
                        <div id="task-menu-{{ $task->id }}" class="dropdown-menu right-0 top-8 w-44 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 overflow-hidden">
                            <a href="{{ route('tasks.show', $task) }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                View Detail
                            </a>
                            <a href="{{ route('tasks.edit', $task) }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <hr class="my-1 border-slate-100">
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @if($task->description)
                <p class="text-xs text-slate-500 mb-4 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
                @else
                <div class="mb-4"></div>
                @endif

                {{-- Badges --}}
                <div class="flex flex-wrap gap-1.5 mb-4">
                    <span class="badge {{ $priorityBadge }}">{{ ucfirst($task->priority) }}</span>
                    <span class="badge {{ $statusBadge }}">{{ $task->status_label }}</span>
                    @if($task->isOverdue())
                    <span class="badge bg-red-100 text-red-600">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Overdue
                    </span>
                    @endif
                </div>

                {{-- Footer: due date + quick action --}}
                <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                    @if($task->due_date)
                    <div class="flex items-center gap-1.5 text-xs {{ $task->isOverdue() ? 'text-red-500' : 'text-slate-400' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $task->due_date->format('M d, Y') }}
                    </div>
                    @else
                    <span class="text-xs text-slate-300">No due date</span>
                    @endif

                    <form action="{{ route('tasks.status', $task) }}" method="POST">
                        @csrf @method('PATCH')
                        @if($task->status === 'todo')
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="text-xs text-primary-600 hover:text-primary-800 font-semibold transition-colors cursor-pointer">Start →</button>
                        @elseif($task->status === 'in_progress')
                            <input type="hidden" name="status" value="done">
                            <button type="submit" class="text-xs text-green-600 hover:text-green-800 font-semibold transition-colors cursor-pointer">Complete ✓</button>
                        @else
                            <input type="hidden" name="status" value="todo">
                            <button type="submit" class="text-xs text-slate-500 hover:text-slate-700 font-semibold transition-colors cursor-pointer">Reopen</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($tasks->hasPages())
    <div class="flex justify-center pt-2">
        {{ $tasks->links('vendor.pagination.simple') }}
    </div>
    @endif
    @endif

</div>
@endsection
