<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CouponX Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Readex Pro', sans-serif; background: #000; color: #999; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        ::-webkit-scrollbar { width: 3px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #111; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#000] overflow-hidden antialiased">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-[200px]' : 'w-0'" class="bg-[#050505] border-l border-white/[0.03] transition-all duration-300 flex flex-col flex-shrink-0 relative">
            <div class="flex flex-col h-full overflow-y-auto no-scrollbar py-6 px-4">
                
                <!-- Logo -->
                <div class="flex items-center gap-2 mb-8 px-2 overflow-hidden whitespace-nowrap">
                    <div class="w-6 h-6 bg-[#f53003] rounded flex items-center justify-center font-black text-xs text-white">C</div>
                    <span class="text-sm font-black tracking-tight text-white italic">Coupon<span class="text-[#f53003]">X</span></span>
                </div>

                <!-- Nav -->
                <nav class="space-y-0.5 whitespace-nowrap">
                    <div class="text-[8px] uppercase tracking-[0.2em] text-gray-700 font-bold mb-3 px-2">نظرة عامة</div>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[10px] font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#f53003]/10 text-[#f53003]' : 'hover:bg-white/[0.02] hover:text-white' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        الرئيسية
                    </a>

                    <div class="text-[8px] uppercase tracking-[0.2em] text-gray-700 font-bold mb-3 mt-6 px-2">الإدارة</div>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[10px] font-semibold transition-all {{ request()->routeIs('admin.users') ? 'bg-[#f53003]/10 text-[#f53003]' : 'hover:bg-white/[0.02] hover:text-white' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        المستخدمين
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[10px] font-semibold transition-all hover:bg-white/[0.02] hover:text-white">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M11 7h.01M11 11h.01M11 15h.01M15 7h.01M15 11h.01M15 15h.01M19 7h.01M19 11h.01M19 15h.01M7 19h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        الكوبونات
                    </a>

                    <div class="text-[8px] uppercase tracking-[0.2em] text-gray-700 font-bold mb-3 mt-6 px-2">المالية</div>
                    <a href="{{ route('admin.packages') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[10px] font-semibold transition-all {{ request()->routeIs('admin.packages') ? 'bg-[#f53003]/10 text-[#f53003]' : 'hover:bg-white/[0.02] hover:text-white' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        الباقات
                    </a>
                    <a href="{{ route('admin.withdrawals') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[10px] font-semibold transition-all {{ request()->routeIs('admin.withdrawals') ? 'bg-[#f53003]/10 text-[#f53003]' : 'hover:bg-white/[0.02] hover:text-white' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        السحوبات
                    </a>

                    <div class="text-[8px] uppercase tracking-[0.2em] text-gray-700 font-bold mb-3 mt-6 px-2">الأمان</div>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[10px] font-semibold transition-all {{ request()->routeIs('admin.reports') ? 'bg-[#f53003]/10 text-[#f53003]' : 'hover:bg-white/[0.02] hover:text-white' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        البلاغات
                        <span class="mr-auto text-[8px] font-black text-red-500 bg-red-500/10 px-1.5 rounded">5</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[10px] font-semibold transition-all {{ request()->routeIs('admin.settings') ? 'bg-[#f53003]/10 text-[#f53003]' : 'hover:bg-white/[0.02] hover:text-white' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        الإعدادات
                    </a>
                </nav>

                <!-- Profile -->
                <div class="mt-auto pt-4 border-t border-white/[0.03] space-y-4">
                    <div class="flex items-center gap-2 px-2 overflow-hidden whitespace-nowrap">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=f53003&color=fff" class="w-6 h-6 rounded">
                        <div class="flex-1 text-[8px] font-bold overflow-hidden">
                            <div class="text-white truncate">أدمن المنصة</div>
                            <div class="text-gray-600 truncate">admin@couponx.com</div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-1.5 rounded-md text-red-500 bg-red-500/5 hover:bg-red-500/10 text-[9px] font-black transition-all">
                            <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>تسجيل الخروج</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <main class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <header class="h-12 border-b border-white/[0.02] flex items-center justify-between px-6 bg-black/40 backdrop-blur-sm z-10 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-1 hover:bg-white/5 rounded text-gray-500 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="text-[10px] font-black tracking-widest text-[#f53003] uppercase">@yield('title', 'Admin Panel')</h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-[8px] text-gray-700 font-bold uppercase tracking-widest">Server: Riyadh-01</span>
                    <div class="w-1.5 h-1.5 bg-[#f53003] rounded-full animate-pulse shadow-[0_0_8px_#f53003]"></div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-4 md:p-10 no-scrollbar">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>

    </div>

</body>
</html>