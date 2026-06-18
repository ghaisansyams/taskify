<?php if($paginator->hasPages()): ?>
<nav class="flex items-center justify-center gap-2" aria-label="Pagination">
    <?php if($paginator->onFirstPage()): ?>
    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Previous
    </span>
    <?php else: ?>
    <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl transition-all duration-150 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Previous
    </a>
    <?php endif; ?>

    <span class="px-4 py-2 text-sm text-slate-500 bg-white border border-slate-200 rounded-xl">
        Page <strong class="text-slate-900"><?php echo e($paginator->currentPage()); ?></strong>
    </span>

    <?php if($paginator->hasMorePages()): ?>
    <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-600 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl transition-all duration-150 cursor-pointer">
        Next
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </a>
    <?php else: ?>
    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-300 bg-white border border-slate-200 rounded-xl cursor-not-allowed">
        Next
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </span>
    <?php endif; ?>
</nav>
<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/taskify/resources/views/vendor/pagination/simple.blade.php ENDPATH**/ ?>