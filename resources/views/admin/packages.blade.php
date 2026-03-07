@extends('layouts.admin')

@section('title', 'باقات الكوينز')

@section('content')
    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold">باقات الكوينز</h2>
                <p class="text-gray-500">إدارة الباقات المتاحة للشراء في التطبيق.</p>
            </div>
            <button
                class="bg-[#f53003] hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة باقة جديدة
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Package Card 1 -->
            <div class="bg-[#0a0a0a] border border-white/5 rounded-[2rem] p-8 space-y-6 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 blur-3xl -z-10 group-hover:bg-blue-500/20 transition-all">
                </div>
                <div class="text-center space-y-2">
                    <div class="text-gray-400 text-sm italic underline text-right">باقة أساسية</div>
                    <div class="text-4xl font-black">100 <span class="text-sm font-normal text-gray-500">كوينز</span></div>
                    <div class="text-2xl text-[#f53003] font-bold">10.00 <span class="text-xs uppercase">EGP</span></div>
                </div>
                <div class="pt-4 border-t border-white/5 flex gap-2">
                    <button class="flex-1 bg-white/5 hover:bg-white/10 py-2 rounded-xl text-xs font-semibold">تعديل</button>
                    <button
                        class="w-10 h-10 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-xl flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Package Card 2 -->
            <div class="bg-[#0a0a0a] border-2 border-[#f53003] rounded-[2rem] p-8 space-y-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-[#f53003]/20 blur-3xl -z-10 transition-all"></div>
                <div class="text-center space-y-2">
                    <div class="text-[#f53003] text-sm font-bold text-right italic">الأكثر مبيعاً 🔥</div>
                    <div class="text-4xl font-black">500 <span class="text-sm font-normal text-gray-500">كوينز</span></div>
                    <div class="text-2xl text-[#f53003] font-bold">45.00 <span class="text-xs uppercase">EGP</span></div>
                    <div class="text-[10px] text-green-500 font-bold">وفر 10%</div>
                </div>
                <div class="pt-4 border-t border-white/5 flex gap-2">
                    <button class="flex-1 bg-white/5 hover:bg-white/10 py-2 rounded-xl text-xs font-semibold">تعديل</button>
                    <button
                        class="w-10 h-10 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-xl flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection