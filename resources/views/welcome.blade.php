<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CouponX | منصة تبادل الكوبونات الذكية</title>

    <!-- Google Fonts: Inter & Readex Pro for Arabic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Readex+Pro:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary: #f53003;
            --primary-dark: #cc2901;
            --dark-bg: #0a0a0a;
            --card-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Readex Pro', 'Inter', sans-serif;
            background-color: var(--dark-bg);
            color: #ffffff;
            overflow-x: hidden;
        }

        .glass {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
        }

        .gradient-text {
            background: linear-gradient(135deg, #fff 0%, #f53003 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-glow {
            position: absolute;
            top: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(245, 48, 3, 0.15) 0%, rgba(245, 48, 3, 0) 70%);
            filter: blur(60px);
            z-index: -1;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Glow Effect -->
    <div class="hero-glow"></div>

    <!-- Navigation -->
    <nav :class="scrolled ? 'glass py-4' : 'bg-transparent py-6'"
        class="fixed w-full z-50 transition-all duration-300 px-6 lg:px-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div
                class="w-10 h-10 bg-gradient-to-br from-[#f53003] to-[#ff7555] rounded-xl flex items-center justify-center shadow-lg shadow-orange-900/20">
                <span class="text-white font-bold text-xl">C</span>
            </div>
            <span class="text-2xl font-bold tracking-tight">Coupon<span class="text-[#f53003]">X</span></span>
        </div>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium">
            <a href="#" class="hover:text-[#f53003] transition-colors">الرئيسية</a>
            <a href="#" class="hover:text-[#f53003] transition-colors">تصفح الكوبونات</a>
            <a href="#" class="hover:text-[#f53003] transition-colors">كيف يعمل</a>
            <a href="#" class="hover:text-[#f53003] transition-colors">من نحن</a>
        </div>

        <div class="flex items-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="glass px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-white/10 transition-all">لوحة
                    التحكم</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-[#f53003] transition-colors">دخول</a>
                <a href="{{ route('register') }}"
                    class="bg-[#f53003] hover:bg-orange-700 text-white px-6 py-2.5 rounded-full text-sm font-semibold shadow-lg shadow-orange-900/20 transition-all">ابدأ
                    الآن</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6 lg:px-16 relative">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16">
            <div class="flex-1 text-center lg:text-right space-y-8">
                <div
                    class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full text-xs font-semibold text-orange-500 uppercase tracking-wider mb-4">
                    <span class="flex h-2 w-2 rounded-full bg-orange-500"></span>
                    أكبر سوق لتبادل الكوبونات في المنطقة
                </div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                    حول كوبوناتك <br>
                    <span class="gradient-text">إلى أموال حقيقية</span>
                </h1>
                <p class="text-gray-400 text-lg lg:text-xl max-w-2xl lg:ml-0 mx-auto">
                    لا تترك كوبوناتك تنتهي صلاحيتها. استبدلها بكوينز، أو اشترِ كوبونات بخصومات هائلة من مستخدمين آخرين.
                    أمان كامل، وسرعة في التنفيذ.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="#"
                        class="w-full sm:w-auto bg-[#f53003] text-white px-10 py-4 rounded-2xl font-bold text-lg hover:scale-105 transition-transform shadow-2xl shadow-orange-900/40">
                        ابدأ البيع الآن
                    </a>
                    <a href="#"
                        class="w-full sm:w-auto glass text-white px-10 py-4 rounded-2xl font-bold text-lg hover:bg-white/10 transition-all">
                        تصفح العروض
                    </a>
                </div>
                <div class="flex items-center justify-center lg:justify-start gap-8 pt-8">
                    <div>
                        <div class="text-3xl font-bold">+50k</div>
                        <div class="text-gray-500 text-sm">مستخدم نشط</div>
                    </div>
                    <div class="border-r border-white/10 h-10"></div>
                    <div>
                        <div class="text-3xl font-bold">+10k</div>
                        <div class="text-gray-500 text-sm">كوبون تم بيعه</div>
                    </div>
                    <div class="border-r border-white/10 h-10"></div>
                    <div>
                        <div class="text-3xl font-bold">4.9/5</div>
                        <div class="text-gray-500 text-sm">تقييم المستخدمين</div>
                    </div>
                </div>
            </div>

            <div class="flex-1 relative animate-float">
                <div
                    class="absolute -z-10 bg-orange-600/20 w-80 h-80 rounded-full blur-[100px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                </div>
                <div class="glass p-4 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Dashboard" class="rounded-[2rem] border border-white/5">

                    <!-- Floating Badge 1 -->
                    <div class="absolute top-10 -right-4 glass p-4 rounded-2xl shadow-xl animate-float"
                        style="animation-delay: 1s">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400">تم البيع بنجاح</div>
                                <div class="font-bold text-sm">250 كوينز</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge 2 -->
                    <div class="absolute bottom-20 -left-4 glass p-4 rounded-2xl shadow-xl animate-float"
                        style="animation-delay: 2s">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-500 font-bold italic">
                                P</div>
                            <div>
                                <div class="text-xs text-gray-400">قسيمة شراء</div>
                                <div class="font-bold text-sm">نمشي - 50%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 px-6 lg:px-16 bg-[#0f0f0f]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-4xl font-bold">لماذا تختار <span class="text-[#f53003]">CouponX</span>؟</h2>
                <p class="text-gray-500 max-w-xl mx-auto">نحن نوفر لك البيئة الأكثر أماناً وسهولة لتبادل الكوبونات
                    الرقمية.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="glass p-8 rounded-3xl hover:border-orange-500/50 transition-all group">
                    <div
                        class="w-16 h-16 bg-orange-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500 transition-colors">
                        <svg class="w-8 h-8 text-[#f53003] group-hover:text-white transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">أمان مطلق</h3>
                    <p class="text-gray-400 leading-relaxed">نضمن لك صحة الكوبون قبل تحويل الكوينز للبائع. نظام تجميد
                        الكوينز يحميك من أي تلاعب.</p>
                </div>

                <!-- Card 2 -->
                <div class="glass p-8 rounded-3xl hover:border-orange-500/50 transition-all group">
                    <div
                        class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 transition-colors">
                        <svg class="w-8 h-8 text-blue-500 group-hover:text-white transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">سرعة البرق</h3>
                    <p class="text-gray-400 leading-relaxed">اشترِ الكوبون واحصل على الكود فوراً. عمليات السحب والإيداع
                        تتم خلال دقائق معدودة.</p>
                </div>

                <!-- Card 3 -->
                <div class="glass p-8 rounded-3xl hover:border-orange-500/50 transition-all group">
                    <div
                        class="w-16 h-16 bg-green-500/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-500 transition-colors">
                        <svg class="w-8 h-8 text-green-500 group-hover:text-white transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">سحب أرباحك</h3>
                    <p class="text-gray-400 leading-relaxed">حول الكوينز التي كسبتها من بيع كوبوناتك إلى نقود حقيقية عبر
                        فودافون كاش أو حسابك البنكي.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories / CTA -->
    <section class="py-20 px-6 lg:px-16">
        <div class="max-w-7xl mx-auto glass rounded-[3rem] p-12 lg:p-20 text-center space-y-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#f53003]/10 blur-[80px] -z-10"></div>
            <h2 class="text-4xl lg:text-5xl font-bold">جاهز لاقتناص <span class="text-[#f53003]">أقوى العروض</span>؟
            </h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">انضم إلى آلاف المستخدمين الذين يوفرون المال يومياً عبر
                تبادل قسائم الخصم.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <span class="bg-white/5 border border-white/10 px-6 py-2 rounded-full text-sm">مطاعم</span>
                <span class="bg-white/5 border border-white/10 px-6 py-2 rounded-full text-sm">موضة</span>
                <span class="bg-white/5 border border-white/10 px-6 py-2 rounded-full text-sm">تقنية</span>
                <span class="bg-white/5 border border-white/10 px-6 py-2 rounded-full text-sm">سفر</span>
                <span class="bg-white/5 border border-white/10 px-6 py-2 rounded-full text-sm">ترفيه</span>
            </div>
            <div class="pt-4">
                <a href="#"
                    class="inline-block bg-white text-black px-12 py-5 rounded-2xl font-bold text-xl hover:bg-gray-200 transition-all shadow-xl">
                    أنشئ حسابك المجاني
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 lg:px-16 border-t border-white/5">
        <div
            class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8 text-gray-500 text-sm">
            <div class="flex items-center gap-2">
                <span class="text-white font-bold tracking-tight">Coupon<span class="text-[#f53003]">X</span></span>
                <span>&copy; 2026. جميع الحقوق محفوظة.</span>
            </div>
            <div class="flex gap-8">
                <a href="#" class="hover:text-white transition-colors">شروط الاستخدام</a>
                <a href="#" class="hover:text-white transition-colors">سياسة الخصوصية</a>
                <a href="#" class="hover:text-white transition-colors">الدعم الفني</a>
            </div>
        </div>
    </footer>

</body>

</html>