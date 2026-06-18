<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — Taskify</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                    colors: {
                        primary: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                    },
                    keyframes: {
                        slideDown: { '0%': { opacity: '0', transform: 'translateY(-8px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        fadeIn:    { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                    },
                    animation: {
                        'slide-down': 'slideDown 0.2s ease-out',
                        'fade-in':    'fadeIn 0.3s ease-out',
                    },
                }
            }
        }
    </script>

    <style>
        /* Sidebar nav items */
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 10px;
            font-size: 14px; font-weight: 500; color: #475569;
            text-decoration: none; transition: all 0.15s ease;
            cursor: pointer;
        }
        .nav-link:hover { background: #f1f5f9; color: #1e293b; }
        .nav-link.active { background: #eff6ff; color: #2563eb; font-weight: 600; }
        .nav-link.active svg { color: #2563eb; }

        /* Status dot nav */
        .nav-status { display: flex; align-items: center; gap: 10px; padding: 8px 14px; border-radius: 10px; font-size: 13px; font-weight: 500; color: #64748b; text-decoration: none; transition: all 0.15s ease; cursor: pointer; }
        .nav-status:hover { background: #f8fafc; color: #334155; }

        /* Form inputs */
        .form-field {
            width: 100%; height: 46px; padding: 0 14px;
            border-radius: 10px; border: 1.5px solid #e2e8f0;
            font-size: 14px; color: #1e293b; background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none; appearance: none;
        }
        .form-field:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .form-field.error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
        textarea.form-field { height: auto; padding: 12px 14px; resize: none; }
        select.form-field { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; padding-right: 40px; }

        .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }

        /* Buttons */
        .btn-primary { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #2563eb; color: #fff; font-size: 14px; font-weight: 600; border-radius: 10px; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s ease; white-space: nowrap; }
        .btn-primary:hover { background: #1d4ed8; box-shadow: 0 4px 12px rgba(37,99,235,0.35); transform: translateY(-1px); }

        .btn-secondary { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #f8fafc; color: #374151; font-size: 14px; font-weight: 600; border-radius: 10px; border: 1.5px solid #e2e8f0; cursor: pointer; text-decoration: none; transition: all 0.15s ease; white-space: nowrap; }
        .btn-secondary:hover { background: #f1f5f9; border-color: #cbd5e1; }

        .btn-danger { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #ef4444; color: #fff; font-size: 14px; font-weight: 600; border-radius: 10px; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s ease; }
        .btn-danger:hover { background: #dc2626; }

        .btn-success { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #22c55e; color: #fff; font-size: 14px; font-weight: 600; border-radius: 10px; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s ease; }
        .btn-success:hover { background: #16a34a; }

        /* Card */
        .card { background: #fff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }

        /* Badge */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; }

        /* Divider */
        .section-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 14px; margin-bottom: 4px; }

        /* Sidebar mobile */
        #sidebar { transition: transform 0.25s ease; }
        @media (max-width: 1023px) { #sidebar { transform: translateX(-100%); } #sidebar.open { transform: translateX(0); } }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; } ::-webkit-scrollbar-track { background: transparent; } ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 99px; }

        /* Dropdown */
        .dropdown-menu { display: none; position: absolute; z-index: 50; }
        .dropdown-menu.open { display: block; animation: slideDown 0.15s ease-out; }
    </style>
</head>

<body class="h-full bg-slate-50 font-sans antialiased text-slate-800">


<a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-primary-600 focus:text-white focus:rounded-lg focus:text-sm focus:font-semibold">
    Skip to main content
</a>

<div class="flex h-full min-h-screen">

    
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex flex-col w-72 bg-white border-r border-slate-100 lg:translate-x-0">

        
        <div class="flex items-center gap-3 px-6 h-16 border-b border-slate-100 shrink-0">
            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-white" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <span class="text-lg font-bold text-slate-900 tracking-tight">Taskify</span>
        </div>

        
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-0.5">

            <p class="section-label mb-3">Menu</p>

            <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="<?php echo e(route('tasks.index')); ?>" class="nav-link <?php echo e(request()->routeIs('tasks.index') || request()->routeIs('tasks.show') ? 'active' : ''); ?>">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                All Tasks
            </a>

            <a href="<?php echo e(route('tasks.create')); ?>" class="nav-link <?php echo e(request()->routeIs('tasks.create') ? 'active' : ''); ?>">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4v16m8-8H4"/>
                </svg>
                New Task
            </a>

            <div class="pt-5 pb-1">
                <p class="section-label mb-3">Filter by Status</p>

                <a href="<?php echo e(route('tasks.index', ['status' => 'todo'])); ?>" class="nav-status">
                    <span class="w-2 h-2 rounded-full bg-slate-400 shrink-0"></span>
                    To Do
                </a>
                <a href="<?php echo e(route('tasks.index', ['status' => 'in_progress'])); ?>" class="nav-status">
                    <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                    In Progress
                </a>
                <a href="<?php echo e(route('tasks.index', ['status' => 'done'])); ?>" class="nav-status">
                    <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                    Done
                </a>
            </div>
        </nav>

        
        <div class="px-3 py-4 border-t border-slate-100 shrink-0">
            <div class="flex items-center gap-3 bg-slate-50 rounded-2xl p-4">
                <div class="w-9 h-9 rounded-full bg-primary-600 flex items-center justify-center text-white text-sm font-bold shrink-0">T</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate">Team User</p>
                    <p class="text-xs text-slate-500 truncate">admin@taskify.app</p>
                </div>
                <button class="p-1 rounded-lg hover:bg-slate-200 transition-colors cursor-pointer" aria-label="Settings">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>
            </div>
        </div>
    </aside>

    
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 lg:hidden" onclick="closeSidebar()"></div>

    
    <div class="flex-1 flex flex-col min-w-0 lg:ml-72">

        
        <header class="sticky top-0 z-20 h-16 bg-white border-b border-slate-100 flex items-center px-4 sm:px-6 gap-4">

            
            <button onclick="openSidebar()" class="lg:hidden p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors cursor-pointer shrink-0" aria-label="Open menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            
            <div class="hidden sm:block">
                <h1 class="text-base font-bold text-slate-900"><?php echo $__env->yieldContent('heading', 'Dashboard'); ?></h1>
                <p class="text-xs text-slate-500 leading-none mt-0.5"><?php echo $__env->yieldContent('subheading', 'Welcome back!'); ?></p>
            </div>

            
            <div class="flex-1"></div>

            
            <div class="hidden md:flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 w-56 focus-within:border-primary-400 focus-within:ring-2 focus-within:ring-primary-100 transition-all">
                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <form action="<?php echo e(route('tasks.index')); ?>" method="GET" class="flex-1">
                    <input type="text" name="search" placeholder="Search tasks…" class="w-full bg-transparent text-sm text-slate-700 placeholder-slate-400 outline-none">
                </form>
            </div>

            
            <button class="relative p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors cursor-pointer" aria-label="Notifications">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            
            <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-sm font-bold shrink-0 cursor-pointer" title="Team User">T</div>

            
            <a href="<?php echo e(route('tasks.create')); ?>" class="btn-primary hidden sm:inline-flex text-sm py-2 px-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                New Task
            </a>
        </header>

        
        <?php if(session('success')): ?>
        <div class="mx-4 sm:mx-6 mt-4 animate-fade-in" data-flash>
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium flex-1"><?php echo e(session('success')); ?></p>
                <button onclick="this.closest('[data-flash]').remove()" class="p-1 rounded-lg hover:bg-green-100 text-green-500 transition-colors cursor-pointer" aria-label="Dismiss">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="mx-4 sm:mx-6 mt-4 animate-fade-in" data-flash>
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium flex-1"><?php echo e(session('error')); ?></p>
                <button onclick="this.closest('[data-flash]').remove()" class="p-1 rounded-lg hover:bg-red-100 text-red-500 transition-colors cursor-pointer" aria-label="Dismiss">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <?php endif; ?>

        
        <main id="main-content" class="flex-1 px-4 sm:px-6 py-6">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        
        <footer class="border-t border-slate-100 px-6 py-4">
            <p class="text-center text-xs text-slate-400">
                Taskify &copy; <?php echo e(date('Y')); ?> &mdash; Built with Laravel &amp; Blade
            </p>
        </footer>
    </div>
</div>

<script>
    // ── Sidebar (mobile) ──────────────────────────────────────
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // ── Flash auto-dismiss (4 s) ──────────────────────────────
    document.querySelectorAll('[data-flash]').forEach(function(el) {
        setTimeout(function() {
            el.style.transition = 'opacity 0.4s ease';
            el.style.opacity = '0';
            setTimeout(function() { el.remove(); }, 400);
        }, 4000);
    });

    // ── Dropdown menus ────────────────────────────────────────
    function toggleDropdown(id) {
        var menu = document.getElementById(id);
        var isOpen = menu.classList.contains('open');
        // close all first
        document.querySelectorAll('.dropdown-menu').forEach(function(m) { m.classList.remove('open'); });
        if (!isOpen) menu.classList.add('open');
    }

    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('[data-dropdown-parent]')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(m) { m.classList.remove('open'); });
        }
    });
</script>

</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/taskify/resources/views/layouts/app.blade.php ENDPATH**/ ?>