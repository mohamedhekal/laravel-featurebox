# Laravel FeatureBox

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mohamedhekal/laravel-featurebox.svg)](https://packagist.org/packages/mohamedhekal/laravel-featurebox)
[![Tests](https://github.com/mohamedhekal/laravel-featurebox/workflows/Tests/badge.svg)](https://github.com/mohamedhekal/laravel-featurebox/actions?query=workflow%3ATests)
[![Code Style](https://github.com/mohamedhekal/laravel-featurebox/workflows/Code%20Style/badge.svg)](https://github.com/mohamedhekal/laravel-featurebox/actions?query=workflow%3A%22Code+Style%22)
[![Total Downloads](https://img.shields.io/packagist/dt/mohamedhekal/laravel-featurebox.svg)](https://packagist.org/packages/mohamedhekal/laravel-featurebox)
[![License](https://img.shields.io/github/license/mohamedhekal/laravel-featurebox.svg)](https://github.com/mohamedhekal/laravel-featurebox/blob/main/LICENSE)

> نظام بسيط ومرن لإدارة ميزات التطبيق في Laravel — تحكم في ظهور الميزات عبر البيئات والمستخدمين والشروط.

---

## 📋 جدول المحتويات

- [المقدمة](#-المقدمة)
- [الميزات](#-الميزات)
- [المتطلبات](#-المتطلبات)
- [البدء السريع](#-البدء-السريع)
- [التثبيت](#-التثبيت)
- [الاستخدام](#️-الاستخدام)
- [شروط الميزات](#-شروط-الميزات)
- [أوامر Artisan](#-أوامر-artisan)
- [الإعدادات](#-الإعدادات)
- [هيكل قاعدة البيانات](#-هيكل-قاعدة-البيانات)
- [الأمان](#-الأمان)
- [الاختبار](#-الاختبار)
- [خطة التطوير](#-خطة-التطوير)
- [الدعم](#-الدعم)
- [أمثلة](#-أمثلة)

---

## 🚀 المقدمة

**Laravel FeatureBox** هو حزمة خفيفة لـ Laravel تساعدك في إدارة ميزات التطبيق (Feature Flags).

سواء كنت تريد نشر الميزات تدريجياً، أو اختبار ميزات تجريبية لمستخدمين محددين، أو إيقاف ميزات في الإنتاج — FeatureBox يعطيك تحكم كامل.

مستوحى من أدوات مثل LaunchDarkly، لكن مصمم خصيصاً لـ Laravel.

---

## ✨ الميزات

- 🚀 **بسيط وخفيف** - سهل التثبيت والاستخدام
- 🔧 **شروط مرنة** - دعم للبيئات وأدوار المستخدمين والتواريخ والشروط المخصصة
- ⚡ **أداء عالي** - دعم التخزين المؤقت المدمج
- 🛠️ **أوامر Artisan** - إدارة الميزات من سطر الأوامر
- 🔒 **آمن** - لا توجد استدعاءات API خارجية، جميع المنطق محلي
- 📊 **تخزين قاعدة البيانات** - الميزات مخزنة في قاعدة البيانات الخاصة بك
- 🧪 **قابل للاختبار** - مجموعة اختبارات شاملة مدمجة
- 🌍 **متعدد اللغات** - توثيق باللغة الإنجليزية والعربية

---

## 📋 المتطلبات

- PHP >= 8.1
- Laravel >= 10.0
- MySQL/PostgreSQL/SQLite

## 🚀 البدء السريع

```bash
# تثبيت الحزمة
composer require mohamedhekal/laravel-featurebox

# نشر الإعدادات والـ migrations
php artisan vendor:publish --tag=featurebox-config
php artisan vendor:publish --tag=featurebox-migrations

# تشغيل الـ migrations
php artisan migrate

# تفعيل ميزة
php artisan featurebox:enable new_checkout

# الاستخدام في الكود
if (FeatureBox::isEnabled('new_checkout')) {
    // نظام دفع جديد
}
```

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

## 🆘 الدعم

- **التوثيق**: [GitHub Wiki](https://github.com/mohamedhekal/laravel-featurebox/wiki)
- **المشاكل**: [GitHub Issues](https://github.com/mohamedhekal/laravel-featurebox/issues)
- **المناقشات**: [GitHub Discussions](https://github.com/mohamedhekal/laravel-featurebox/discussions)
- **البريد الإلكتروني**: [mohamedhekal@gmail.com](mailto:mohamedhekal@gmail.com)

## 🧑‍💻 مطور بواسطة [محمد هيكل](https://github.com/mohamedhekal)

لا تتردد في إرسال المشاكل أو الأفكار أو Pull Requests.

### 🤝 المساهمة

يرجى الاطلاع على [CONTRIBUTING.md](CONTRIBUTING.md) للتفاصيل.

### 📄 الرخصة

هذه الحزمة مفتوحة المصدر تحت رخصة [MIT](LICENSE).

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