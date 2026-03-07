@extends('layouts.admin')

@section('title', 'البلاغات والشكاوى')

@section('content')
    <div class="space-y-8">
        <div>
            <h2 class="text-3xl font-bold">البلاغات</h2>
            <p class="text-gray-500">إدارة نزاعات المستخدمين ومكافحة الغش.</p>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <!-- Report Card -->
            <div
                class="bg-[#0a0a0a] border border-white/5 rounded-[2rem] p-8 hover:border-red-500/30 transition-all flex gap-8 items-start relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 blur-3xl -z-10 group-hover:bg-red-500/10 transition-all">
                </div>

                <div class="w-16 h-16 bg-red-500/10 text-red-500 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>

                <div class="flex-1 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-gray-500 mb-1">بلاغ جديد #9041</div>
                            <h3 class="text-lg font-bold">كوبون غير صالح / مستخدم بالفعل</h3>
                        </div>
                        <span
                            class="bg-red-500/20 text-red-500 text-[10px] px-3 py-1 rounded-full font-black uppercase">عالي
                            الخطورة</span>
                    </div>

                    <div class="text-sm text-gray-400 group-hover:text-gray-300 transition-colors">
                        بواسطة: <span class="text-white font-medium">علي حسن</span> | ضد: <span
                            class="text-white font-medium">متجر الخصومات</span>
                    </div>

                    <p class="text-sm leading-relaxed text-gray-500">
                        قمت بشراء كوبون "نمشي 50%" وعند محاولة تفعيله ظهرت رسالة تفيد بأن الكود تم استخدامه مسبقاً من قبل
                        شخص آخر. أرجو استرجاع الكوينز.
                    </p>

                    <div class="pt-4 flex gap-4">
                        <button
                            class="bg-white/5 hover:bg-white/10 px-6 py-2 rounded-xl text-xs font-bold transition-all border border-white/10">مراجعة
                            التفاصيل</button>
                        <button
                            class="bg-[#f53003] hover:bg-orange-700 text-white px-6 py-2 rounded-xl text-xs font-bold transition-all">اتخاذ
                            إجراء</button>
                        <button class="text-gray-600 hover:text-white text-xs font-medium">تجاهل البلاغ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection