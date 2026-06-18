@extends('layouts.app')

@section('title', 'New Task')
@section('heading', 'New Task')
@section('subheading', 'Fill in the details below to create a new task')

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('tasks.index') }}" class="hover:text-primary-600 transition-colors font-medium">Tasks</a>
        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-semibold">New Task</span>
    </nav>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── LEFT COLUMN (main) ───────────────────────────── --}}
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
                        {{-- Title --}}
                        <div>
                            <label for="title" class="form-label">Task Title <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                   placeholder="What needs to be done?"
                                   class="form-field @error('title') error @enderror"
                                   autofocus>
                            @error('title')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="form-label">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                            <textarea id="description" name="description" rows="5"
                                      placeholder="Add more context, notes, or acceptance criteria for this task…"
                                      class="form-field @error('description') error @enderror"
                                      style="min-height: 120px;">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror
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
                            <select id="priority" name="priority" class="form-field @error('priority') error @enderror">
                                <option value="" disabled>Select priority</option>
                                <option value="low"    {{ old('priority') === 'low'    ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high"   {{ old('priority') === 'high'   ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            @error('priority')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                            <select id="status" name="status" class="form-field @error('status') error @enderror">
                                <option value="todo"        {{ old('status', 'todo') === 'todo'        ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done"        {{ old('status') === 'done'        ? 'selected' : '' }}>Done</option>
                            </select>
                            @error('status')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT COLUMN (meta) ──────────────────────────── --}}
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
                               value="{{ old('due_date') }}"
                               min="{{ date('Y-m-d') }}"
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
                        <select id="category" name="category" class="form-field @error('category') error @enderror">
                            <option value="" disabled>Select category</option>
                            <option value="work"     {{ old('category') === 'work'     ? 'selected' : '' }}>Work</option>
                            <option value="personal" {{ old('category') === 'personal' ? 'selected' : '' }}>Personal</option>
                            <option value="health"   {{ old('category') === 'health'   ? 'selected' : '' }}>Health</option>
                            <option value="finance"  {{ old('category') === 'finance'  ? 'selected' : '' }}>Finance</option>
                            <option value="learning" {{ old('category') === 'learning' ? 'selected' : '' }}>Learning</option>
                            <option value="other"    {{ old('category') === 'other'    ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="space-y-3">
                    <button type="submit" class="btn-primary w-full justify-center py-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Create Task
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn-secondary w-full justify-center py-3">
                        Cancel
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
