<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول | CouponX</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Readex Pro', sans-serif;
            background-color: #050505;
            color: #ffffff;
            overflow: hidden;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 relative">

    <!-- Background Glow -->
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#f53003]/10 blur-[100px] -z-10">
    </div>

    <div class="w-full max-w-md space-y-8 glass p-10 rounded-[2.5rem] shadow-2xl">
        <div class="text-center space-y-2">
            <div
                class="w-16 h-16 bg-[#f53003] rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-orange-900/40 mb-6">
                <span class="text-3xl font-bold">C</span>
            </div>
            <h1 class="text-3xl font-bold">مرحباً بعودتك</h1>
            <p class="text-gray-500">قم بتسجيل الدخول للوصول إلى لوحة التحكم</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6 text-right">
            @csrf

            @if ($errors->any())
                <div
                    class="bg-red-500/10 border border-red-500/20 p-4 rounded-xl text-red-500 text-xs text-center font-bold">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-2">
                <label class="text-sm text-gray-400 mr-2">البريد الإلكتروني</label>
                <input type="email" name="email" required autofocus
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 outline-none focus:border-[#f53003] transition-all text-left dir-ltr">
            </div>

            <div class="space-y-2">
                <label class="text-sm text-gray-400 mr-2">كلمة المرور</label>
                <input type="password" name="password" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 outline-none focus:border-[#f53003] transition-all text-left dir-ltr">
            </div>

            <div class="flex items-center justify-between px-2">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-white/10 bg-white/5 text-[#f53003] focus:ring-[#f53003]">
                    <span class="text-xs text-gray-500 group-hover:text-gray-300">تذكرني</span>
                </label>
                <a href="#" class="text-xs text-[#f53003] hover:underline">نسيت كلمة المرور؟</a>
            </div>

            <button type="submit"
                class="w-full bg-[#f53003] hover:bg-orange-700 text-white py-4 rounded-2xl font-bold text-lg shadow-xl shadow-orange-900/20 transition-all hover:scale-[1.02] active:scale-95">
                دخول
            </button>
        </form>

        <div class="text-center pt-4">
            <p class="text-xs text-gray-600">ليس لديك حساب؟ <a href="#" class="text-white hover:underline">أنشئ حساباً
                    جديداً</a></p>
        </div>
    </div>

</body>

</html>