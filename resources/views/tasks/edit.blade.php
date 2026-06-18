@extends('layouts.app')

@section('title', 'Edit Task')
@section('heading', 'Edit Task')
@section('subheading', Str::limit($task->title, 50))

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('tasks.index') }}" class="hover:text-primary-600 transition-colors font-medium">Tasks</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('tasks.show', $task) }}" class="hover:text-primary-600 transition-colors truncate max-w-48">{{ Str::limit($task->title, 40) }}</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-semibold">Edit</span>
    </nav>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── LEFT COLUMN ───────────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Task Information --}}
                <div class="card p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Task Information</h2>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="title" class="form-label">Task Title <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                                   placeholder="What needs to be done?"
                                   class="form-field @error('title') error @enderror">
                            @error('title')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="description" class="form-label">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                            <textarea id="description" name="description" rows="5"
                                      placeholder="Add more context or notes…"
                                      class="form-field @error('description') error @enderror"
                                      style="min-height: 120px;">{{ old('description', $task->description) }}</textarea>
                            @error('description')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Priority & Status --}}
                <div class="card p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Priority & Status</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="priority" class="form-label">Priority <span class="text-red-500">*</span></label>
                            <select id="priority" name="priority" class="form-field">
                                <option value="low"    {{ old('priority', $task->priority) === 'low'    ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high"   {{ old('priority', $task->priority) === 'high'   ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority', $task->priority) === 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                            <select id="status" name="status" class="form-field">
                                <option value="todo"        {{ old('status', $task->status) === 'todo'        ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done"        {{ old('status', $task->status) === 'done'        ? 'selected' : '' }}>Done</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Task Meta (read-only) --}}
                <div class="card p-6 bg-slate-50 border-slate-100">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                        <div>
                            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Created</p>
                            <p class="font-semibold text-slate-700">{{ $task->created_at->format('M d, Y') }}</p>
                            <p class="text-slate-400">{{ $task->created_at->format('H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 font-semibold uppercase tracking-wider mb-1">Updated</p>
                            <p class="font-semibold text-slate-700">{{ $task->updated_at->diffForHumans() }}</p>
                        </div>
                        @if($task->completed_at)
                        <div>
                            <p class="text-green-500 font-semibold uppercase tracking-wider mb-1">Completed</p>
                            <p class="font-semibold text-green-700">{{ $task->completed_at->format('M d, Y') }}</p>
                            <p class="text-green-400">{{ $task->completed_at->format('H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── RIGHT COLUMN ──────────────────────────────────── --}}
            <div class="space-y-6">

                {{-- Scheduling --}}
                <div class="card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Scheduling</h2>
                    </div>
                    <div>
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" id="due_date" name="due_date"
                               value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                               class="form-field @error('due_date') error @enderror">
                        @error('due_date')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Category --}}
                <div class="card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 bg-violet-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Category</h2>
                    </div>
                    <div>
                        <label for="category" class="form-label">Category <span class="text-red-500">*</span></label>
                        <select id="category" name="category" class="form-field">
                            <option value="work"     {{ old('category', $task->category) === 'work'     ? 'selected' : '' }}>Work</option>
                            <option value="personal" {{ old('category', $task->category) === 'personal' ? 'selected' : '' }}>Personal</option>
                            <option value="health"   {{ old('category', $task->category) === 'health'   ? 'selected' : '' }}>Health</option>
                            <option value="finance"  {{ old('category', $task->category) === 'finance'  ? 'selected' : '' }}>Finance</option>
                            <option value="learning" {{ old('category', $task->category) === 'learning' ? 'selected' : '' }}>Learning</option>
                            <option value="other"    {{ old('category', $task->category) === 'other'    ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="space-y-3">
                    <button type="submit" class="btn-primary w-full justify-center py-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Save Changes
                    </button>
                    <a href="{{ route('tasks.show', $task) }}" class="btn-secondary w-full justify-center py-3">
                        Cancel
                    </a>
                </div>

                {{-- Danger zone --}}
                <div class="card p-5 border-red-100">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Danger Zone</p>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to permanently delete this task?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger w-full justify-center py-2.5 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Task
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
