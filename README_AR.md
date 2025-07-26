# Laravel FeatureBox

> نظام بسيط ومرن لإدارة ميزات التطبيق في Laravel — تحكم في ظهور الميزات عبر البيئات والمستخدمين والشروط.

---

## 🚀 المقدمة

**Laravel FeatureBox** هو حزمة خفيفة لـ Laravel تساعدك في إدارة ميزات التطبيق (Feature Flags).

سواء كنت تريد نشر الميزات تدريجياً، أو اختبار ميزات تجريبية لمستخدمين محددين، أو إيقاف ميزات في الإنتاج — FeatureBox يعطيك تحكم كامل.

مستوحى من أدوات مثل LaunchDarkly، لكن مصمم خصيصاً لـ Laravel.

---

## 📦 التثبيت

ثبت عبر Composer:

```bash
composer require mohamedhekal/laravel-featurebox
```

ثم انشر ملفات الإعداد والـ migrations:

```bash
php artisan vendor:publish --tag=featurebox-config
php artisan vendor:publish --tag=featurebox-migrations
php artisan migrate
```

---

## ⚙️ الاستخدام

تفعيل أو إيقاف الميزات من قاعدة البيانات أو باستخدام أوامر Artisan.

### الاستخدام الأساسي

```php
use FeatureBox\Facades\FeatureBox;

if (FeatureBox::isEnabled('new_checkout')) {
    // عرض نظام الدفع الجديد
} else {
    // عرض نظام الدفع الكلاسيكي
}
```

### مع السياق

يمكنك تمرير سياق لتقييم الشروط:

```php
FeatureBox::isEnabled('new_checkout', [
    'user_id' => auth()->id(),
    'role'    => auth()->user()->role,
]);
```

### في قوالب Blade

```php
@if(FeatureBox::isEnabled('dark_mode'))
    <link rel="stylesheet" href="/css/dark-mode.css">
@endif
```

### في Controllers

```php
public function checkout()
{
    if (FeatureBox::isEnabled('new_checkout')) {
        return view('checkout.new');
    }
    
    return view('checkout.classic');
}
```

---

## 🧠 شروط الميزات

كل ميزة يمكن أن تتضمن شروط اختيارية مثل:

* ✅ البيئات (`local`, `staging`, `production`)
* 👤 أدوار المستخدمين أو معرفات مستخدمين محددين
* 📅 تواريخ البداية والنهاية
* 🔧 شروط JSON مخصصة

### أمثلة على الشروط

```json
{
  "environments": ["staging", "production"],
  "user_roles": ["admin", "beta"],
  "user_ids": [1, 2, 3],
  "start_date": "2025-01-01",
  "end_date": "2025-12-31",
  "custom": {
    "plan": "premium",
    "region": "US"
  }
}
```

سيتم تقييم الشروط ديناميكياً قبل تفعيل أي ميزة.

---

## 🧪 أوامر Artisan

### تفعيل ميزة

```bash
# تفعيل بدون شروط
php artisan featurebox:enable new_checkout

# تفعيل مع شروط
php artisan featurebox:enable new_checkout --conditions='{"environments":["production"],"user_roles":["admin"]}'
```

### إيقاف ميزة

```bash
php artisan featurebox:disable new_checkout
```

### عرض جميع الميزات

```bash
php artisan featurebox:list
```

---

## 🔧 الإعدادات

إعدادات الحزمة موجودة في `config/featurebox.php`:

```php
return [
    'cache' => [
        'enabled' => env('FEATUREBOX_CACHE_ENABLED', true),
        'ttl' => env('FEATUREBOX_CACHE_TTL', 300), // 5 دقائق
    ],
    
    'default_conditions' => [
        // الشروط الافتراضية لجميع الميزات
    ],
    
    'table' => env('FEATUREBOX_TABLE', 'features'),
];
```

### متغيرات البيئة

```env
FEATUREBOX_CACHE_ENABLED=true
FEATUREBOX_CACHE_TTL=300
FEATUREBOX_TABLE=features
```

---

## 📊 هيكل قاعدة البيانات

الحزمة تنشئ جدول `features` بالهيكل التالي:

```sql
CREATE TABLE features (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    is_enabled BOOLEAN DEFAULT FALSE,
    conditions JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## 🔐 الأمان

جميع المنطق محلي؛ لا توجد استدعاءات API خارجية أو تتبع.
يمكنك اختيارياً تخزين الميزات مؤقتاً للأداء باستخدام نظام التخزين المؤقت في Laravel.

---

## 🧪 الاختبار

```bash
composer test
```

### مثال على الاختبار

```php
use FeatureBox\Facades\FeatureBox;

public function test_feature_can_be_enabled()
{
    FeatureBox::enable('test_feature');
    
    $this->assertTrue(FeatureBox::isEnabled('test_feature'));
}
```

---

## ✅ خطة التطوير

* [x] منطق تفعيل الميزات
* [x] الشروط القائمة على JSON
* [x] أوامر Artisan
* [x] دعم التخزين المؤقت
* [ ] لوحة تحكم ويب
* [ ] دعم اختبار A/B
* [ ] Redis driver
* [ ] تحليلات الميزات

---

## 🤝 المساهمة

1. Fork المستودع
2. أنشئ فرع الميزة (`git checkout -b feature/amazing-feature`)
3. اكتب التغييرات (`git commit -m 'Add some amazing feature'`)
4. ادفع للفرع (`git push origin feature/amazing-feature`)
5. افتح Pull Request

---

## 📄 الرخصة

هذه الحزمة مفتوحة المصدر تحت رخصة [MIT](LICENSE).

---

## 🧑‍💻 مطور بواسطة [محمد هيكل](https://github.com/mohamedhekal)

لا تتردد في إرسال المشاكل أو الأفكار أو Pull Requests.

---

## 📚 أمثلة

### مثال التجارة الإلكترونية

```php
// تفعيل نظام دفع جديد للمستخدمين المميزين فقط
FeatureBox::enable('new_checkout', [
    'user_roles' => ['premium'],
    'environments' => ['production']
]);

// في controller الدفع
public function checkout()
{
    $user = auth()->user();
    
    if (FeatureBox::isEnabled('new_checkout', [
        'user_id' => $user->id,
        'role' => $user->role
    ])) {
        return $this->newCheckout();
    }
    
    return $this->classicCheckout();
}
```

### مثال الاختبار التجريبي

```php
// تفعيل ميزات تجريبية لمستخدمين محددين
FeatureBox::enable('beta_dashboard', [
    'user_ids' => [1, 5, 10, 15],
    'start_date' => '2025-01-01',
    'end_date' => '2025-03-31'
]);
```

### ميزات خاصة بالبيئة

```php
// تفعيل ميزات التصحيح في البيئة المحلية فقط
FeatureBox::enable('debug_panel', [
    'environments' => ['local']
]);
``` 