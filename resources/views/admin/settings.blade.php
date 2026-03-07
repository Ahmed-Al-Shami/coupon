@extends('layouts.admin')

@section('title', 'إعدادات المنصة')

@section('content')
    <div class="max-w-5xl space-y-10 pb-20">
        <!-- Header Section -->
        <div>
            <h2 class="text-2xl font-black text-white">إعدادات المنصة المتطورة</h2>
            <p class="text-[11px] text-gray-500 mt-1 uppercase tracking-widest font-bold">Advanced Platform Configuration &
                Control</p>
        </div>

        @if(session('success'))
            <div
                class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-xl text-xs font-bold animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Financial & Rules Section -->
            <div class="bg-[#050505] border border-white/[0.03] rounded-3xl p-8 space-y-8">
                <div class="flex items-center gap-3 border-b border-white/[0.03] pb-4">
                    <div class="w-8 h-8 bg-orange-500/10 rounded-lg flex items-center justify-center text-orange-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">القواعد والنسب المالية</h3>
                        <p class="text-[10px] text-gray-500">تحكم في العوامل الاقتصادية والقوانين التشغيلية.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">نسبة عمولة المنصة (%)</label>
                        <input type="number" name="platform_commission" value="{{ $settings['platform_commission'] ?? 20 }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all">
                        <p class="text-[9px] text-gray-600">النسبة المقتطعة من قيمة الكوبون.</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">سعر الكوين (ج.م)</label>
                        <input type="number" step="0.01" name="coin_price_egp" value="{{ $settings['coin_price_egp'] ?? 1 }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all">
                        <p class="text-[9px] text-gray-600">سعر 1 كوين مقابل الجنيه.</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">وقت تحرير الكوينز
                            (دقيقة)</label>
                        <input type="number" name="coin_release_delay" value="{{ $settings['coin_release_delay'] ?? 60 }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all">
                        <p class="text-[9px] text-gray-600">المدة المعلقة للكوينز.
                        </p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">حد تعليق الحساب
                            (بلاغات)</label>
                        <input type="number" name="suspension_threshold"
                            value="{{ $settings['suspension_threshold'] ?? 5 }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all">
                        <p class="text-[9px] text-gray-600">عدد البلاغات للحظر الآلي للمراجعة.</p>
                    </div>
                </div>
            </div>

            <!-- Firebase & Notifications Section -->
            <div class="bg-[#050505] border border-white/[0.03] rounded-3xl p-8 space-y-8">
                <div class="flex items-center gap-3 border-b border-white/[0.03] pb-4">
                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">إعدادات الإشعارات (Firebase)</h3>
                        <p class="text-[10px] text-gray-500">ربط المنصة بنظام الإشعارات الفوري.</p>
                    </div>
                    <div class="mr-auto">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notifications_enabled" value="1" class="sr-only peer" {{ ($settings['notifications_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                            <div
                                class="w-9 h-5 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#f53003]">
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-right" dir="ltr">
                    <div class="space-y-2 text-right">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Firebase API
                            Key</label>
                        <input type="password" name="firebase_api_key" value="{{ $settings['firebase_api_key'] ?? '' }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all">
                    </div>
                    <div class="space-y-2 text-right">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Firebase Project
                            ID</label>
                        <input type="text" name="firebase_project_id" value="{{ $settings['firebase_project_id'] ?? '' }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all">
                    </div>
                    <div class="space-y-2 text-right">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Messaging Sender
                            ID</label>
                        <input type="text" name="firebase_messaging_sender_id"
                            value="{{ $settings['firebase_messaging_sender_id'] ?? '' }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all">
                    </div>
                    <div class="space-y-2 text-right">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Firebase App
                            ID</label>
                        <input type="text" name="firebase_app_id" value="{{ $settings['firebase_app_id'] ?? '' }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="bg-[#050505] border border-white/[0.03] rounded-3xl p-8 space-y-8">
                <div class="flex items-center gap-3 border-b border-white/[0.03] pb-4">
                    <div class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center text-green-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">الدعم الفني والخدمات</h3>
                        <p class="text-[10px] text-gray-500">طرق التواصل المباشر مع المستخدمين.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">رقم واتساب الدعم</label>
                        <input type="text" name="support_whatsapp" value="{{ $settings['support_whatsapp'] ?? '' }}"
                            class="w-full bg-white/[0.02] border border-white/[0.05] rounded-xl px-4 py-3 text-xs text-white focus:border-[#f53003] outline-none transition-all"
                            placeholder="+201000000000">
                        <p class="text-[9px] text-gray-600">هذا الرقم سيظهر للمستخدمين عند طلب المساعدة.</p>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex items-center justify-end pt-4">
                <button type="submit"
                    class="bg-[#f53003] hover:bg-orange-700 text-white px-10 py-4 rounded-2xl font-black text-xs transition-all shadow-2xl shadow-orange-900/40 border border-white/10 flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                        </path>
                    </svg>
                    حفظ كافة التغييرات
                </button>
            </div>

        </form>
    </div>
@endsection