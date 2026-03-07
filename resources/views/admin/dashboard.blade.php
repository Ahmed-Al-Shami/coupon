@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="space-y-8">
        <!-- Breadcrumbs / Greeting -->
        <div>
            <h2 class="text-3xl font-bold">مرحباً بك مجدداً</h2>
            <p class="text-gray-500">هنا نظرة عامة على حالة المنصة اليوم.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white/5 border border-white/5 p-6 rounded-3xl space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 bg-blue-500/20 text-blue-500 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-green-500 text-sm font-medium">+12%</span>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">إجمالي المستخدمين</div>
                    <div class="text-2xl font-bold">2,450</div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/5 p-6 rounded-3xl space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 bg-orange-500/20 text-orange-500 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-green-500 text-sm font-medium">+5%</span>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">الكوبونات المنشورة</div>
                    <div class="text-2xl font-bold">1,120</div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/5 p-6 rounded-3xl space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 bg-green-500/20 text-green-500 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-red-500 text-sm font-medium">-2%</span>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">إجمالي المبيعات (كوينز)</div>
                    <div class="text-2xl font-bold">450k</div>
                </div>
            </div>

            <div class="bg-white/5 border border-white/5 p-6 rounded-3xl space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 bg-red-500/20 text-red-500 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-gray-500 text-sm font-medium">قيد المراجعة</span>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">بلاغات معلقة</div>
                    <div class="text-2xl font-bold">12</div>
                </div>
            </div>
        </div>

        <!-- Tables / Active Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Purchases -->
            <div class="bg-[#0a0a0a] border border-white/5 rounded-[2rem] p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">آخر عمليات الشراء</h3>
                    <a href="#" class="text-[#f53003] text-sm hover:underline">عرض الكل</a>
                </div>

                <div class="space-y-4">
                    @forelse([] as $purchase)
                        <!-- Dynamic content will go here -->
                    @empty
                        <div class="text-center py-10 text-gray-600 italic">لا توجد عمليات شراء حديثة</div>
                    @endforelse
                </div>
            </div>

            <!-- System Alerts / Logs -->
            <div class="bg-[#0a0a0a] border border-white/5 rounded-[2rem] p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">تنبيهات النظام</h3>
                    <a href="#" class="text-[#f53003] text-sm hover:underline">سجل العمليات</a>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-3 p-4 bg-red-500/10 rounded-2xl border border-red-500/20">
                        <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <div>
                            <div class="font-bold text-sm">اشتباه في محاولة غش</div>
                            <div class="text-xs text-gray-500">تم رصد محاولة دخول مكررة من نفس المصدر للمستخدم رقم #120
                            </div>
                        </div>
                        <span class="mr-auto text-[10px] text-gray-600">منذ 5 د</span>
                    </div>

                    <div class="flex items-start gap-3 p-4 bg-orange-500/10 rounded-2xl border border-orange-500/20">
                        <svg class="w-5 h-5 text-orange-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <div>
                            <div class="font-bold text-sm">طلب سحب جديد</div>
                            <div class="text-xs text-gray-500">المستخدم "أحمد علي" قدم طلب سحب بقيمة 5000 كوينز</div>
                        </div>
                        <span class="mr-auto text-[10px] text-gray-600">منذ 15 د</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection