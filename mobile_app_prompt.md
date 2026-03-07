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
- **مثال الاستجابة (Success 201)**:
  ```json
  {
    "success": true,
    "message": "تم التسجيل بنجاح. يرجى التحقق من بريدك الإلكتروني وهاتفك.",
    "data": {
      "user": { "id": 1, "name": "Ahmed", "email": "ahmed@example.com", "coins_balance": 0 },
      "token": "1|pa5sW0rdToken..."
    }
  }
  ```

### [POST] /auth/login
- **الوظيفة (Function)**: المصادقة على بيانات المستخدم ومنحه صلاحية الوصول.
- **المفاتيح (Keys)**:
  - `email`: البريد الإلكتروني.
  - `password`: كلمة المرور.
  - `device_name`: اسم الجهاز الحالي.
- **السلوك**: يتحقق من الحساب، وفي حال الحظر يعيد رسالة الخطأ والسبب.
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "message": "تم تسجيل الدخول بنجاح.",
    "data": {
      "user": { "id": 1, "name": "Ahmed", "coins_balance": 150 },
      "token": "2|AnotherToken..."
    }
  }
  ```
- **مثال الاستجابة (Banned 403)**:
  ```json
  {
    "success": false,
    "message": "هذا الحساب محظور. السبب: مخالفة شروط الاستخدام"
  }
  ```

### [GET] /auth/user
- **الوظيفة (Function)**: التحقق من صلاحية التوكن وجلب بيانات البريد الشخصي الحالية والرصيد.
- **المفاتيح (Keys)**: لا يوجد (فقط Header Authorization).
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": { "id": 1, "name": "Ahmed", "email": "ahmed@example.com", "phone": "010...", "coins_balance": 150 }
  }
  ```

### [POST] /auth/logout
- **الوظيفة (Function)**: إبطال مفعول توكن الجهاز الحالي والخروج.
- **المفاتيح (Keys)**: لا يوجد.
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "message": "تم تسجيل الخروج بنجاح."
  }
  ```

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
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": [
      { "id": 10, "title": "خصم 50% مطعم برجر", "coins_price": 20, "place_name": "Burger Joint" }
    ],
    "pagination": { "current_page": 1, "last_page": 5, "total": 75 }
  }
  ```

### [GET] /coupons/{id}
- **الوظيفة (Function)**: جلب التفاصيل الكاملة لكوبون معين (بدون الكود السري).
- **المفاتيح (Keys)**: `id` (في المسار).
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": {
      "id": 10,
      "title": "خصم 50% مطعم برجر",
      "description": "استمتع بخصم حقيقي...",
      "coins_price": 20,
      "discount_value": 50,
      "discount_type": "percentage",
      "expiry_date": "2026-12-31"
    }
  }
  ```

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
- **مثال الاستجابة (Success 201)**:
  ```json
  {
    "success": true,
    "message": "تم نشر الكوبون بنجاح.",
    "data": { "id": 11, "title": "كوبون جديد", "status": "pending_verification" }
  }
  ```

---

## � 3. Wallet & Transactions (المحفظة والكوينز)

### [GET] /auth/coins/balance
- **الوظيفة (Function)**: جلب رصيد الكوينز المتاح حالياً للمستخدم وتفاصيل مستواه.
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": { "coins_balance": 150, "level": "Silver", "next_level_at": 500 }
  }
  ```

### [GET] /auth/coins/transactions
- **الوظيفة (Function)**: سجل العمليات المالية (شراء، بيع، شحن، سحب).
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": [
      { "id": 1, "type": "purchase", "amount": -20, "description": "شراء كوبون #10", "date": "2026-03-07" }
    ]
  }
  ```

### [GET] /coins/packages
- **الوظيفة (Function)**: قائمة باقات شراء الكوينز المتاحة وأسعارها بالجنيه.
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": [
      { "id": 1, "name": "الباقة الأساسية", "coins_amount": 100, "price": 50 }
    ]
  }
  ```

### [POST] /auth/coins/topup
- **الوظيفة (Function)**: بدء عملية شحن رصيد كوينز.
- **المفاتيح (Keys)**:
  - `package_id`: معرف الباقة المختارة.
  - `payment_method`: وسيلة الدفع (`fawry`, `vodafone_cash`, إلخ).
- **السلوك**: يعيد `payment_url` يتم فتحه في WebView لإتمام الدفع.
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "message": "تم إنشاء طلب الشحن بنجاح.",
    "data": {
      "topup_id": 5,
      "payment_url": "https://payment-gateway.com/pay/5"
    }
  }
  ```

---

## 💳 4. Purchase Flow (عملية الشراء والنزاعات)

### [POST] /auth/coupons/{id}/purchase
- **الوظيفة (Function)**: خصم الكوينز من المشتري وحجز الكوبون.
- **السلوك**: تبدأ فترة السماح (Grace Period) قبل ظهور الكود.
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "message": "تم شراء الكوبون بنجاح.",
    "data": { "purchase_id": 101, "grace_period_ends_at": "2026-03-08 14:00:00" }
  }
  ```

### [GET] /auth/purchases/{id}/reveal
- **الوظيفة (Function)**: الكشف عن الكود السري للكوبون بعد انتهاء فترة السماح.
- **السلوك**: يعيد `coupon_code` الصافي للاستخدام.
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": { "coupon_code": "SAVE50-XYZ-2026" }
  }
  ```
- **مثال الاستجابة (Locked 403)**:
  ```json
  {
    "success": false,
    "message": "فترة السماح لم تنتهِ بعد.",
    "grace_period_ends_at": "2026-03-08 14:00:00"
  }
  ```

### [POST] /auth/purchases/{id}/confirm
- **الوظيفة (Function)**: تأكيد المشتري بأن الكوبون عمل بنجاح (لتحويل الرصيد للبائع).
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "message": "تم تأكيد الكوبون بنجاح."
  }
  ```

### [POST] /auth/purchases/{id}/dispute
- **الوظيفة (Function)**: فتح نزاع في حال كان الكود غير صحيح أو مستخدم.
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "message": "تم فتح نزاع. ستقوم الإدارة بالمراجعة."
  }
  ```

---

## 💸 5. Withdrawals (عمليات سحب الأرباح)

### [POST] /auth/withdrawals/request
- **الوظيفة (Function)**: تقديم طلب تحويل الكوينز إلى كاش (جنيه مصري).
- **المفاتيح (Keys)**:
  - `coins_amount`: المبلغ المراد سحبه.
  - `payment_method`: وسيلة الاستلام (مثلاً: Vodafone Cash).
  - `payment_details`: بيانات التحويل (مثلاً: رقم الهاتف).
- **مثال الاستجابة (Success 201)**:
  ```json
  {
    "success": true,
    "message": "تم تقديم طلب السحب بنجاح.",
    "data": { "id": 50, "coins_amount": 1000, "status": "pending" }
  }
  ```

### [GET] /auth/withdrawals
- **الوظيفة (Function)**: متابعة سجل طلبات السحب وحالاتها (Pending, Approved, Rejected).
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": [
      { "id": 50, "coins_amount": 1000, "status": "pending", "created_at": "2026-03-07" }
    ]
  }
  ```

---

## 🔔 6. Notifications (الإشعارات)

### [GET] /auth/notifications
- **الوظيفة (Function)**: جلب قائمة التنبيهات (بيع، شراء، تحديث رصيد).
- **مثال الاستجابة (Success 200)**:
  ```json
  {
    "success": true,
    "data": [
      { "id": "uuid-1", "title": "تم بيع كوبون!", "message": "باع أحدهم كوبونك بنجاح", "read_at": null }
    ]
  }
  ```

### [POST] /auth/notifications/{id}/read
- **الوظيفة (Function)**: تمييز إشعار معين كمقروء.
- **مثال الاستجابة (Success 200)**:
  ```json
  { "success": true, "message": "تم تمييز الإشعار كمقروء." }
  ```

### [POST] /auth/notifications/read-all
- **الوظيفة (Function)**: تمييز كافة الإشعارات كمقروءة بضغطة واحدة.
- **مثال الاستجابة (Success 200)**:
  ```json
  { "success": true, "message": "تم تمييز جميع الإشعارات كمقروءة." }
  ```

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
- **مثال الاستجابة (Success 201)**:
  ```json
  {
    "success": true,
    "message": "تم إرسال البلاغ بنجاح.",
    "data": { "id": 5, "type": "fraud", "status": "pending" }
  }
  ```

---

## ⚙️ Technical Rules (قواعد تقنية)
1. **Headers**: يجب إرسال `Authorization: Bearer {token}` في كل الطلبات داخل موديول `auth`.
2. **Fingerprint**: أرسل `X-Device-Fingerprint` في الـ Header لضمان أمان العمليات المالية.
3. **Images**: الصور يتم رفعها بصيغة `Multipart/form-data`.
4. **Validation**: في حال وجود خطأ في المفاتيح، يعيد السيرفر Code `422` مع مصفوفة `errors` توضح الحقل الناقص أو الخاطئ.
