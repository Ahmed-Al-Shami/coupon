@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('content')
    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold">إدارة المستخدمين</h2>
                <p class="text-gray-500">مشاهدة، حظر، وتوثيق حسابات المستخدمين.</p>
            </div>
            <div class="flex gap-4">
                <input type="text" placeholder="بحث عن مستخدم..."
                    class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 outline-none focus:border-[#f53003] text-sm md:w-64">
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-[#0a0a0a] border border-white/5 rounded-[2rem] overflow-hidden">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-8 py-4 font-bold">المستخدم</th>
                        <th class="px-8 py-4 font-bold">الرصيد</th>
                        <th class="px-8 py-4 font-bold">الحالة</th>
                        <th class="px-8 py-4 font-bold">تاريخ الانضمام</th>
                        <th class="px-8 py-4 font-bold">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <!-- Example Row -->
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=User+One&background=random"
                                    class="w-10 h-10 rounded-xl">
                                <div>
                                    <div class="font-bold text-sm">محمد أحمد</div>
                                    <div class="text-xs text-gray-500">mohamed@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div class="text-sm font-bold">1,250 كوينز</div>
                        </td>
                        <td class="px-8 py-4">
                            <span
                                class="bg-emerald-500/10 text-emerald-500 text-[10px] px-2 py-1 rounded-full font-bold">نشط</span>
                        </td>
                        <td class="px-8 py-4 text-xs text-gray-500">2026/03/01</td>
                        <td class="px-8 py-4">
                            <div class="flex gap-2">
                                <button class="p-2 hover:bg-[#f53003]/20 text-[#f53003] rounded-lg transition-all"
                                    title="حظر">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                        </path>
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-white/10 text-gray-400 rounded-lg transition-all"
                                    title="تفاصيل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection