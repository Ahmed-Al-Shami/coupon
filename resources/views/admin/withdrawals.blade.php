@extends('layouts.admin')

@section('title', 'طلبات السحب')

@section('content')
    <div class="space-y-8">
        <div>
            <h2 class="text-3xl font-bold">طلبات السحب</h2>
            <p class="text-gray-500">مراجعة وتحويل الأرباح للمستخدمين.</p>
        </div>

        <div class="bg-[#0a0a0a] border border-white/5 rounded-[2rem] overflow-hidden text-sm">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider font-bold">
                        <th class="px-8 py-4">المستخدم</th>
                        <th class="px-8 py-4">المبلغ</th>
                        <th class="px-8 py-4">طريقة الدفع</th>
                        <th class="px-8 py-4">الحالة</th>
                        <th class="px-8 py-4">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-8 py-6">
                            <div class="font-bold">أحمد محمود</div>
                            <div class="text-xs text-gray-500">01012345678</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="font-black text-orange-500">500.00 EGP</div>
                            <div class="text-[10px] text-gray-500">5000 كوينز</div>
                        </td>
                        <td class="px-8 py-6">
                            <span
                                class="bg-white/5 px-3 py-1 rounded-full border border-white/10 uppercase font-bold text-[10px]">فودافون
                                كاش</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="bg-orange-500/10 text-orange-500 text-[10px] px-2 py-1 rounded-full font-bold">قيد
                                الانتظار</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex gap-2">
                                <button
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg font-bold text-xs transition-all">قبول</button>
                                <button
                                    class="bg-red-600/10 hover:bg-red-600 text-red-600 hover:text-white px-4 py-1.5 rounded-lg font-bold text-xs transition-all">رفض</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection