@if ($paginator->hasPages())
<nav class="flex items-center justify-center gap-2" aria-label="Pagination">
    @if ($paginator->onFirstPage())
    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Previous
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl transition-all duration-150 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Previous
    </a>
    @endif

    <span class="px-4 py-2 text-sm text-slate-500 bg-white border border-slate-200 rounded-xl">
        Page <strong class="text-slate-900">{{ $paginator->currentPage() }}</strong>
    </span>

    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl transition-all duration-150 cursor-pointer">
        Next
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </a>
    @else
    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed">
        Next
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </span>
    @endif
</nav>
@endif
