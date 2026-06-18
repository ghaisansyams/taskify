@extends('layouts.app')

@section('title', $task->title)
@section('heading', 'Task Detail')
@section('subheading', 'Viewing full task information')

@section('content')
@php
$priorityStripe = match($task->priority) { 'urgent'=>'bg-red-500','high'=>'bg-orange-500','medium'=>'bg-yellow-400',default=>'bg-green-500' };
$priorityBadge  = match($task->priority) { 'urgent'=>'bg-red-100 text-red-700','high'=>'bg-orange-100 text-orange-700','medium'=>'bg-yellow-100 text-yellow-700',default=>'bg-green-100 text-green-700' };
$statusBadge    = match($task->status)   { 'done'=>'bg-green-100 text-green-700','in_progress'=>'bg-blue-100 text-blue-700',default=>'bg-slate-100 text-slate-600' };
$catIconPaths = [
    'work'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>',
    'personal' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
    'health'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
    'finance'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'learning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>',
    'other'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>',
];
$catColors = [
    'work'=>'bg-blue-50 text-blue-600','personal'=>'bg-violet-50 text-violet-600',
    'health'=>'bg-red-50 text-red-500','finance'=>'bg-yellow-50 text-yellow-600',
    'learning'=>'bg-green-50 text-green-600','other'=>'bg-slate-100 text-slate-500',
];
@endphp

<div class="max-w-4xl mx-auto animate-fade-in">

    {{-- Breadcrumb + actions --}}
    <div class="flex items-center justify-between mb-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('tasks.index') }}" class="hover:text-primary-600 transition-colors font-medium">Tasks</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-900 font-semibold truncate max-w-64">{{ Str::limit($task->title, 50) }}</span>
        </nav>
        <div class="flex items-center gap-2">
            <a href="{{ route('tasks.edit', $task) }}" class="btn-secondary py-2 px-4 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                  onsubmit="return confirm('Permanently delete this task?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger py-2 px-4 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── MAIN CARD ───────────────────────────────────────── --}}
        <div class="lg:col-span-2">
            <div class="card p-8 relative overflow-hidden">
                {{-- Priority stripe --}}
                <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $priorityStripe }}"></div>

                <div class="pl-4">
                    {{-- Category + title --}}
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-7 h-7 rounded-lg {{ $catColors[$task->category] ?? 'bg-slate-100 text-slate-500' }} flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $catIconPaths[$task->category] ?? $catIconPaths['other'] !!}
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider capitalize">{{ $task->category }}</span>
                    </div>

                    <h1 class="text-2xl font-bold text-slate-900 leading-snug mb-4
                               {{ $task->status === 'done' ? 'line-through text-slate-400' : '' }}">
                        {{ $task->title }}
                    </h1>

                    {{-- Badges --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="badge {{ $priorityBadge }} text-xs">{{ ucfirst($task->priority) }} Priority</span>
                        <span class="badge {{ $statusBadge }} text-xs">{{ $task->status_label }}</span>
                        @if($task->isOverdue())
                        <span class="badge bg-red-100 text-red-600 text-xs">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Overdue
                        </span>
                        @endif
                    </div>

                    {{-- Description --}}
                    @if($task->description)
                    <div class="bg-slate-50 rounded-2xl p-5 mb-6">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Description</p>
                        <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $task->description }}</p>
                    </div>
                    @else
                    <div class="bg-slate-50 rounded-2xl p-5 mb-6">
                        <p class="text-sm text-slate-400 italic">No description provided.</p>
                    </div>
                    @endif

                    {{-- Quick Status Actions --}}
                    <div class="pt-5 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Quick Action</p>
                        <div class="flex items-center gap-3 flex-wrap">
                            @if($task->status === 'todo')
                            <form action="{{ route('tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="btn-primary py-2.5 px-5 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    Start Task
                                </button>
                            </form>
                            @elseif($task->status === 'in_progress')
                            <form action="{{ route('tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="done">
                                <button type="submit" class="btn-success py-2.5 px-5 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Mark Complete
                                </button>
                            </form>
                            @else
                            <form action="{{ route('tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="todo">
                                <button type="submit" class="btn-secondary py-2.5 px-5 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Reopen Task
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── SIDEBAR META ─────────────────────────────────────── --}}
        <div class="space-y-4">

            {{-- Due Date --}}
            <div class="card p-5">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Due Date</p>
                </div>
                @if($task->due_date)
                <p class="text-sm font-bold {{ $task->isOverdue() ? 'text-red-600' : 'text-slate-800' }}">
                    {{ $task->due_date->format('D, M d, Y') }}
                </p>
                <p class="text-xs {{ $task->isOverdue() ? 'text-red-400' : 'text-slate-400' }} mt-0.5">
                    {{ $task->due_date->diffForHumans() }}
                </p>
                @else
                <p class="text-sm text-slate-400">Not set</p>
                @endif
            </div>

            {{-- Created --}}
            <div class="card p-5">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Created</p>
                </div>
                <p class="text-sm font-bold text-slate-800">{{ $task->created_at->format('D, M d, Y') }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $task->created_at->diffForHumans() }}</p>
            </div>

            {{-- Last Updated --}}
            <div class="card p-5">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Last Updated</p>
                </div>
                <p class="text-sm font-bold text-slate-800">{{ $task->updated_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $task->updated_at->diffForHumans() }}</p>
            </div>

            {{-- Completed --}}
            @if($task->completed_at)
            <div class="card p-5 border-green-100 bg-green-50">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Completed</p>
                </div>
                <p class="text-sm font-bold text-green-800">{{ $task->completed_at->format('D, M d, Y') }}</p>
                <p class="text-xs text-green-500 mt-0.5">{{ $task->completed_at->diffForHumans() }}</p>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
