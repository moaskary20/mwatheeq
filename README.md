# مواثيق

موقع تعريفي عربي مبني على Laravel و Filament.

## التشغيل

```bash
composer install
cp .env.example .env   # إن لزم
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
composer serve
```

> ملاحظة: استخدم `composer serve` (أو `php -c php.ini artisan serve`) حتى يعمل رفع الصور حتى حجم 32 ميجا. الحد الافتراضي لـ PHP كان 2 ميجا فقط.

- الموقع: http://127.0.0.1:8000
- لوحة التحكم: http://127.0.0.1:8000/admin

## بيانات الدخول الافتراضية

- البريد: `admin@mwatheeq.com`
- كلمة المرور: `password`

## ما يشمله المشروع

- موقع تعريفي RTL بالعربية (الرئيسية، من نحن، الخدمات، التواصل)
- لوحة Filament لإدارة الخدمات وإعدادات الموقع ورسائل التواصل
