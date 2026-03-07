# CouponX Master API Prompt (Mobile Developer Ready) 🚀

This is the ultimate technical blueprint for building the CouponX mobile application. Every endpoint is detailed with its **Functionality**, **Keys (Parameters)**, and **Behavior**.

---

## 🔐 1. Authentication & Identity (الهوية والتحقق)

### [POST] /auth/register
- **الوظيفة (Function)**: إنشاء حساب مستخدم جديد وتوليد توكن الدخول الأول.
- **المفاتيح (Keys)**:
  - `name`: اسم المستخدم (السلسلة النصية، 2-50 حرف).
  - `email`: البريد الإلكتروني (فريد، صيغة بريد صحيحة).
  - `phone`: رقم الهاتف (10-15 رقم، فريد).
  - `password`: كلمة المرور (8 أحرف على الأقل، تشمل كبير، صغير، رقم، ورمز).
  - `password_confirmation`: تأكيد كلمة المرور (يجب أن يتطابق).
  - `device_name`: اسم جهاز الموبايل (لتحديد مصدر التوكن).
- **السلوك**: يعيد بيانات المستخدم مع `API Token` لاستخدامه في الطلبات القادمة.

### [POST] /auth/login
- **الوظيفة (Function)**: المصادقة على بيانات المستخدم ومنحه صلاحية الوصول.
- **المفاتيح (Keys)**:
  - `email`: البريد الإلكتروني.
  - `password`: كلمة المرور.
  - `device_name`: اسم الجهاز الحالي.
- **السلوك**: يتحقق من الحساب، وفي حال الحظر يعيد رسالة الخطأ والسبب.

### [GET] /auth/user
- **الوظيفة (Function)**: التحقق من صلاحية التوكن وجلب بيانات البريد الشخصي الحالية والرصيد.
- **المفاتيح (Keys)**: لا يوجد (فقط Header Authorization).

### [POST] /auth/logout
- **الوظيفة (Function)**: إبطال مفعول توكن الجهاز الحالي والخروج.
- **المفاتيح (Keys)**: لا يوجد.

---

## 🎫 2. Coupon Management (إدارة الكوبونات)

### [GET] /coupons
- **الوظيفة (Function)**: البحث وجلب قائمة الكوبونات المتاحة للبيع.
- **المفاتيح (Keys)**:
  - `search`: (اختياري) نص للبحث في العناوين والوصف.
  - `category`: (اختياري) تصنيف المكان.
  - `lat`, `lng`: (اختياري) إحداثيات الموقع للبحث عن الأقرب.
  - `radius`: (اختياري) القطر بالكيلومتر (الافتراضي 10).
  - `sort`: ترتيب النتائج (`newest`, `cheapest`, `most_popular`).
- **السلوك**: يعيد قائمة مرقمة (Paginated).

### [GET] /coupons/{id}
- **الوظيفة (Function)**: جلب التفاصيل الكاملة لكوبون معين (بدون الكود السري).
- **المفاتيح (Keys)**: `id` (في المسار).

### [POST] /auth/coupons
- **الوظيفة (Function)**: نشر كوبون جديد للبيع في المنصة.
- **المفاتيح (Keys)**:
  - `title`: العنوان.
  - `description`: الوصف التفصيلي.
  - `place_name`: اسم المطعم أو المحل.
  - `place_category`: التصنيف.
  - `latitude`, `longitude`: الموقع الجغرافي.
  - `discount_value`: قيمة الخصم.
  - `discount_type`: نوع الخصم (`percentage` أو `fixed`).
  - `expiry_date`: تاريخ الانتهاء.
  - `coupon_code`: **الكود السري** (سيتم تشفيره في السيرفر).
  - `coins_price`: السعر المطلوب بالكوينز.
  - `image`: ملف الصورة (Logo أو صورة المنتج).

---

## � 3. Wallet & Transactions (المحفظة والكوينز)

### [GET] /auth/coins/balance
- **الوظيفة (Function)**: جلب رصيد الكوينز المتاح حالياً للمستخدم وتفاصيل مستواه.

### [GET] /auth/coins/transactions
- **الوظيفة (Function)**: سجل العمليات المالية (شراء، بيع، شحن، سحب).

### [GET] /coins/packages
- **الوظيفة (Function)**: قائمة باقات شراء الكوينز المتاحة وأسعارها بالجنيه.

### [POST] /auth/coins/topup
- **الوظيفة (Function)**: بدء عملية شحن رصيد كوينز.
- **المفاتيح (Keys)**:
  - `package_id`: معرف الباقة المختارة.
  - `payment_method`: وسيلة الدفع (`fawry`, `vodafone_cash`, إلخ).
- **السلوك**: يعيد `payment_url` يتم فتحه في WebView لإتمام الدفع.

---

## 💳 4. Purchase Flow (عملية الشراء والنزاعات)

### [POST] /auth/coupons/{id}/purchase
- **الوظيفة (Function)**: خصم الكوينز من المشتري وحجز الكوبون.
- **السلوك**: تبدأ فترة السماح (Grace Period) قبل ظهور الكود.

### [GET] /auth/purchases/{id}/reveal
- **الوظيفة (Function)**: الكشف عن الكود السري للكوبون بعد انتهاء فترة السماح.
- **السلوك**: يعيد `coupon_code` الصافي للاستخدام.

### [POST] /auth/purchases/{id}/confirm
- **الوظيفة (Function)**: تأكيد المشتري بأن الكوبون عمل بنجاح (لتحويل الرصيد للبائع).

### [POST] /auth/purchases/{id}/dispute
- **الوظيفة (Function)**: فتح نزاع في حال كان الكود غير صحيح أو مستخدم.

---

## 💸 5. Withdrawals (عمليات سحب الأرباح)

### [POST] /auth/withdrawals/request
- **الوظيفة (Function)**: تقديم طلب تحويل الكوينز إلى كاش (جنيه مصري).
- **المفاتيح (Keys)**:
  - `coins_amount`: المبلغ المراد سحبه.
  - `payment_method`: وسيلة الاستلام (مثلاً: Vodafone Cash).
  - `payment_details`: بيانات التحويل (مثلاً: رقم الهاتف).

### [GET] /auth/withdrawals
- **الوظيفة (Function)**: متابعة سجل طلبات السحب وحالاتها (Pending, Approved, Rejected).

---

## 🔔 6. Notifications (الإشعارات)

### [GET] /auth/notifications
- **الوظيفة (Function)**: جلب قائمة التنبيهات (بيع، شراء، تحديث رصيد).

### [POST] /auth/notifications/{id}/read
- **الوظيفة (Function)**: تمييز إشعار معين كمقروء.

### [POST] /auth/notifications/read-all
- **الوظيفة (Function)**: تمييز كافة الإشعارات كمقروءة بضغطة واحدة.

---

## � 7. Reports (البلاغات)

### [POST] /auth/reports
- **الوظيفة (Function)**: الإبلاغ عن مستخدم أو كوبون مخالف.
- **المفاتيح (Keys)**:
  - `reported_user_id`: الحساب المبلّغ عنه.
  - `reported_coupon_id`: (اختياري) الكوبون المعني.
  - `type`: نوع المخالفة.
  - `description`: شرح المشكلة.
  - `evidence_images[]`: (اختياري) صور إثبات.

---

## ⚙️ Technical Rules (قواعد تقنية)
1. **Headers**: يجب إرسال `Authorization: Bearer {token}` في كل الطلبات داخل موديول `auth`.
2. **Fingerprint**: أرسل `X-Device-Fingerprint` في الـ Header لضمان أمان العمليات المالية.
3. **Images**: الصور يتم رفعها بصيغة `Multipart/form-data`.
4. **Validation**: في حال وجود خطأ في المفاتيح، يعيد السيرفر Code `422` مع مصفوفة `errors` توضح الحقل الناقص أو الخاطئ.
