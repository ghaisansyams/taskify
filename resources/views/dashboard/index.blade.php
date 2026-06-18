@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', "Here's what's happening with your tasks today.")

@section('content')
<div class="space-y-6 animate-fade-in">

    {{-- ── STAT CARDS ──────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

        {{-- Total --}}
        <div class="card p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 cursor-default">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Total Tasks</p>
                <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-primary-600" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-slate-900">{{ $stats['total'] }}</p>
            <p class="text-xs text-slate-400 mt-2">All time</p>
        </div>

        {{-- To Do --}}
        <div class="card p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 cursor-default">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">To Do</p>
                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-slate-500" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-slate-700">{{ $stats['todo'] }}</p>
            <p class="text-xs text-slate-400 mt-2">Pending</p>
        </div>

        {{-- In Progress --}}
        <div class="card p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 cursor-default">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest">In Progress</p>
                <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-primary-600" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-primary-600">{{ $stats['in_progress'] }}</p>
            <p class="text-xs text-slate-400 mt-2">Active now</p>
        </div>

        {{-- Done --}}
        <div class="card p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 cursor-default">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-semibold text-green-500 uppercase tracking-widest">Done</p>
                <div class="w-9 h-9 rounded-full bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-green-500" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-green-600">{{ $stats['done'] }}</p>
            <p class="text-xs text-slate-400 mt-2">Completed</p>
        </div>

        {{-- Overdue --}}
        <div class="card p-6 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 cursor-default {{ $stats['overdue'] > 0 ? 'border-red-100' : '' }}">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-semibold text-red-500 uppercase tracking-widest">Overdue</p>
                <div class="w-9 h-9 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-red-500" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-red-600">{{ $stats['overdue'] }}</p>
            <p class="text-xs text-slate-400 mt-2">Need attention</p>
        </div>
    </div>

    {{-- ── COMPLETION + CATEGORIES ─────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Completion Rate --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-slate-900">Completion Rate</h3>
                <span class="text-2xl font-bold text-primary-600">{{ $completionRate }}%</span>
            </div>

            <div class="w-full bg-slate-100 rounded-full h-2.5 mb-2">
                <div class="bg-primary-600 h-2.5 rounded-full transition-all duration-700" style="width: {{ $completionRate }}%"></div>
            </div>
            <p class="text-xs text-slate-400 mb-6">{{ $stats['done'] }} of {{ $stats['total'] }} tasks completed</p>

            <div class="space-y-3">
                @foreach([
                    ['urgent', 'bg-red-500',    'text-red-600',    'Urgent'],
                    ['high',   'bg-orange-500',  'text-orange-600', 'High'],
                    ['medium', 'bg-yellow-400',  'text-yellow-600', 'Medium'],
                    ['low',    'bg-green-500',   'text-green-600',  'Low'],
                ] as [$key, $dot, $text, $label])
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full {{ $dot }} shrink-0"></span>
                    <span class="text-xs text-slate-600 flex-1">{{ $label }}</span>
                    <span class="text-xs font-bold {{ $text }}">{{ $byPriority[$key]->total ?? 0 }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tasks by Category --}}
        <div class="card p-6 lg:col-span-2">
            <h3 class="text-sm font-bold text-slate-900 mb-5">Tasks by Category</h3>
            @php
            $catIcons = [
                'work'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>',
                'personal' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                'health'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
                'finance'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                'learning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>',
                'other'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>',
            ];
            $catColors = [
                'work'=>'text-blue-600 bg-blue-50','personal'=>'text-violet-600 bg-violet-50',
                'health'=>'text-red-500 bg-red-50','finance'=>'text-yellow-600 bg-yellow-50',
                'learning'=>'text-green-600 bg-green-50','other'=>'text-slate-500 bg-slate-100',
            ];
            @endphp

            @if($byCategory->isEmpty())
            <div class="flex flex-col items-center justify-center h-32 text-slate-400">
                <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-sm">No data yet</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($byCategory as $cat)
                @php $pct = $cat->total > 0 ? round(($cat->done / $cat->total) * 100) : 0; @endphp
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg {{ $catColors[$cat->category] ?? 'bg-slate-100 text-slate-500' }} flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $catIcons[$cat->category] ?? $catIcons['other'] !!}</svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700 capitalize">{{ $cat->category }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs">
                            <span class="text-slate-400">{{ $cat->done }}/{{ $cat->total }}</span>
                            <span class="font-bold text-slate-700 w-9 text-right">{{ $pct }}%</span>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div class="bg-primary-500 h-1.5 rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- ── RECENT / OVERDUE / URGENT ────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Recent Tasks --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-slate-900">Recent Tasks</h3>
                <a href="{{ route('tasks.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors">View all</a>
            </div>
            <div class="space-y-1">
            @forelse($recentTasks as $task)
            <a href="{{ route('tasks.show', $task) }}" class="flex items-start gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition-colors group cursor-pointer">
                <span class="mt-1.5 w-2 h-2 rounded-full shrink-0
                    {{ $task->status === 'done' ? 'bg-green-500' : ($task->status === 'in_progress' ? 'bg-blue-500' : 'bg-slate-300') }}">
                </span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-700 truncate group-hover:text-primary-600 transition-colors
                        {{ $task->status === 'done' ? 'line-through text-slate-400' : '' }}">
                        {{ $task->title }}
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $task->created_at->diffForHumans() }}</p>
                </div>
            </a>
            @empty
            <div class="text-center py-8">
                <p class="text-sm text-slate-400">No tasks yet.</p>
                <a href="{{ route('tasks.create') }}" class="text-sm text-primary-600 font-semibold hover:text-primary-700 mt-1 inline-block">Create one →</a>
            </div>
            @endforelse
            </div>
        </div>

        {{-- Overdue Tasks --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-slate-900">Overdue</h3>
                @if($overdueTasks->count() > 0)
                <span class="badge bg-red-100 text-red-600">{{ $overdueTasks->count() }}</span>
                @endif
            </div>
            @forelse($overdueTasks as $task)
            <a href="{{ route('tasks.show', $task) }}" class="flex items-start gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 transition-colors group cursor-pointer">
                <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-700 truncate group-hover:text-red-600 transition-colors">{{ $task->title }}</p>
                    <p class="text-xs text-red-400 mt-0.5">{{ $task->due_date->diffForHumans() }}</p>
                </div>
            </a>
            @empty
            <div class="flex flex-col items-center justify-center py-8">
                <div class="w-11 h-11 bg-green-50 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-700">All caught up!</p>
                <p class="text-xs text-slate-400 mt-1">No overdue tasks</p>
            </div>
            @endforelse
        </div>

        {{-- Urgent Tasks --}}
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-slate-900">Urgent</h3>
                @if($urgentTasks->count() > 0)
                <span class="badge bg-orange-100 text-orange-600">{{ $urgentTasks->count() }}</span>
                @endif
            </div>
            @forelse($urgentTasks as $task)
            <a href="{{ route('tasks.show', $task) }}" class="flex items-start gap-3 px-3 py-2.5 rounded-xl hover:bg-orange-50 transition-colors group cursor-pointer">
                <svg class="w-4 h-4 text-orange-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-700 truncate group-hover:text-orange-600 transition-colors">{{ $task->title }}</p>
                    <p class="text-xs text-slate-400 mt-0.5 capitalize">{{ $task->status_label }}</p>
                </div>
            </a>
            @empty
            <div class="flex flex-col items-center justify-center py-8">
                <div class="w-11 h-11 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-700">No urgent tasks</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
