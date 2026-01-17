

## GoldenCinema – Cinema Management and E-Ticket Booking System

### Overview
GoldenCinema is a comprehensive, full-featured web application designed to manage cinema operations, schedule movie screenings, and provide a seamless online ticket booking experience. The system implements role-based access control with three distinct user roles: **Admins**, **Managers**, and **Clients**, ensuring secure and efficient operations across all levels of the cinema business.

### Core Features

#### 🔐 Authentication & Authorization
- **Multi-role Authentication**: Separate login systems for Admins, Managers, and Clients
- **Role-Based Access Control (RBAC)**: Different permissions and dashboard interfaces for each user role
- **Secure Password Management**: Hashed passwords using Laravel's built-in security features
- **Session Management**: Persistent login with secure session handling

#### 🎬 Movie Management
- **Movie Catalog**: Add, edit, and delete movies with detailed information
- **Movie Shows/Screenings**: Schedule movie shows across multiple theaters and screens
- **Trailer Management**: Upload and manage movie trailers
- **Category Management**: Organize movies into categories for better browsing

#### 🏛️ Cinema Infrastructure
- **Theater Management**: Manage multiple cinema theaters
- **Screen/Auditorium Management**: Create and configure screens within theaters
- **Seat Management**: Define seat layouts with different seat types and statuses
- **Dynamic Pricing**: Set prices per screen, show, and seat type

#### 🎫 Ticket Booking System
- **Online Seat Selection**: Interactive seat maps for customers to select their seats
- **Real-time Availability**: Check seat availability for each show
- **Payment Processing**: Secure payment integration with pending payment tracking
- **Booking Confirmation**: Generate and manage booking confirmations

#### 📊 Admin & Manager Dashboards
- **Sales Reports**: View daily and overall sales statistics
- **Booking Analytics**: Track booking trends and popular movies
- **User Management**: Manage admins, managers, and clients
- **Theater Operations**: Monitor theater performance and screen utilization

### Project Architecture

#### Database Structure
The application uses **14 main models** with complex relationships:
- **Users**: Admin, Manager, Client (role-based)
- **Movies**: Movie details with foreign key to Category
- **MovieShows**: Schedule shows for specific movies at specific times
- **Theaters**: Cinema locations
- **Screens**: Auditoriums within theaters
- **Seats**: Individual seats with status and pricing
- **Bookings**: Customer ticket reservations
- **Tickets**: Generated from bookings
- **Categories**: Movie categorization
- **Status**: Booking and ticket statuses
- **Trailers**: Movie promotional content
- **PendingPayments**: Payment tracking

#### User Roles & Permissions

**👨‍💼 Admin**
- Full system control
- Manage manager accounts
- View system-wide reports
- Configure application settings
- Monitor all operations

**👤 Manager**
- Manage assigned theater(s)
- Add and schedule movies
- Manage screens and seats
- View theater-specific reports
- Handle customer inquiries

**🎟️ Client**
- Browse available movies
- View movie details and trailers
- Book tickets online
- Select preferred seats
- Make secure payments
- View booking history

#### Routing Structure
```
/admin          → Admin Dashboard
/manager        → Manager Dashboard  
/cinema         → Public Cinema Interface
/client         → Client Dashboard
/auth           → Authentication (login/register)
```

### Technologies & Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| **Framework** | Laravel | 11.9+ |
| **Language** | PHP | 8.2+ |
| **Database** | MySQL | Latest |
| **Templating** | Blade | Laravel's native |
| **Frontend** | Tailwind CSS | Latest |
| **Build Tool** | Vite | Latest |
| **Package Manager** | Composer & NPM | Latest |
| **API Architecture** | REST API | Custom |
| **Authentication** | Laravel Auth | Built-in |
| **PDF Generation** | DOMPDF | 3.1+ |
| **Image Processing** | Intervention Image | 3.11+ |
| **Testing** | Pest PHP | 3.4+ |

### Installation & Setup

#### Prerequisites
- PHP 8.2 or higher
- Composer installed
- Node.js and npm installed
- MySQL database server

#### Step-by-Step Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/goldencinema.git
   cd goldencinema
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**:
   ```bash
   npm install
   ```

4. **Configure environment**:
   ```bash
   cp .env.example .env
   ```
   - Update `.env` with your database credentials
   - Set `APP_KEY` using `php artisan key:generate`

5. **Create database**:
   ```bash
   mysql -u root -p -e "CREATE DATABASE cinema;"
   ```

6. **Run migrations**:
   ```bash
   php artisan migrate
   ```

7. **Seed initial data (optional)**:
   ```bash
   php artisan db:seed
   ```

8. **Build assets**:
   ```bash
   npm run build
   ```
   Or for development with hot reload:
   ```bash
   npm run dev
   ```

9. **Start the development server**:
   ```bash
   php artisan serve
   ```

10. **Access the application**:
    - Home: `http://localhost:8000`
    - Admin Login: `http://localhost:8000/admin/login`
    - Manager Login: `http://localhost:8000/manager/login`
    - Client Login: `http://localhost:8000/client/login`

### Key Models & Relationships

```php
// Example relationships implemented in the system
Movie → hasMany(MovieShow)
Movie → belongsToMany(Category)
Movie → hasMany(Trailer)

MovieShow → belongsTo(Movie)
MovieShow → belongsTo(Screen)

Theater → hasMany(Screen)

Screen → belongsTo(Theater)
Screen → hasMany(Seat)
Screen → hasMany(MovieShow)

Seat → belongsTo(Screen)
Seat → hasMany(Ticket)

Booking → belongsTo(Client)
Booking → belongsTo(MovieShow)
Booking → hasMany(Ticket)

Ticket → belongsTo(Booking)
Ticket → belongsTo(Seat)
Ticket → belongsTo(Status)

Client → hasMany(Booking)
Manager → hasMany(Theater)
Admin → hasMany(Manager)
```

### Development & Testing

- **Unit & Feature Tests**: Located in `tests/` directory
- **Testing Framework**: Pest PHP
- **Database Factory**: Mock data generation with Faker
- **Code Standards**: Laravel Pint for code formatting

### Project Structure
```
cinema/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          (Admin controllers)
│   │   │   ├── manager/        (Manager controllers)
│   │   │   └── client/         (Client controllers)
│   │   ├── Middleware/         (Auth & custom middleware)
│   │   └── Requests/           (Form validation)
│   ├── Models/                 (Eloquent models)
│   └── Providers/              (Service providers)
├── database/
│   ├── migrations/             (Database schema)
│   ├── seeders/                (Initial data)
│   └── factories/              (Test data factories)
├── resources/
│   ├── views/
│   │   ├── admin/              (Admin templates)
│   │   ├── manager/            (Manager templates)
│   │   └── client/             (Client templates)
│   ├── css/                    (Stylesheets)
│   └── js/                     (Frontend scripts)
├── routes/
│   ├── admin/                  (Admin routes)
│   ├── manager/                (Manager routes)
│   ├── client/                 (Client routes)
│   └── web.php                 (Main routes)
└── public/                     (Public assets)
```

### Security Considerations
- ✅ CSRF Protection on all forms
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ Password Hashing (bcrypt)
- ✅ Authorization checks on protected routes
- ✅ Input validation on all forms
- ✅ Secure session management
- ✅ Protected API endpoints

### Performance Features
- Database indexing on foreign keys
- Eager loading with relationships (`with()`)
- Pagination for large datasets
- Caching strategies implemented
- Optimized database queries

### Contributing
Contributions are welcome! Please follow Laravel coding standards and create pull requests with detailed descriptions.

### Troubleshooting

**Composer install fails**:
```bash
composer install --no-interaction
```

**Migrations error**:
```bash
php artisan migrate:refresh
```

**Cache issues**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Conclusion
GoldenCinema delivers a production-ready cinema management solution with secure authentication, comprehensive cinema operations management, and an intuitive online booking platform. It demonstrates professional Laravel development practices with clean code, proper architectural patterns, and user-friendly interfaces for all stakeholders in the cinema business.

---

## النسخة العربية

### نظرة عامة
GoldenCinema هو تطبيق ويب كامل الميزات مصمم لإدارة عمليات السينما وتسهيل حجز التذاكر عبر الإنترنت. يوفر النظام حلاً شاملاً لإدارة السينما، بما في ذلك المصادقة الآمنة، جدولة الأفلام، التسعير، وإدارة المقاعد من خلال لوحة تحكم إدارية بديهية.

### الميزات
- **المصادقة للمستخدمين**: تسجيل دخول وتسجيل آمن للمستخدمين والمديرين.
- **إدارة الأفلام**: يمكن للمديرين إضافة وتحديث وحذف الأفلام، بما في ذلك تفاصيل مثل مواعيد العرض والتسعير.
- **حجز التذاكر**: يمكن للمستخدمين حجز التذاكر عبر الإنترنت، اختيار المقاعد، وإجراء المدفوعات بشكل آمن.
- **لوحة التحكم الإدارية**: واجهة سهلة الاستخدام لإدارة عمليات السينما، عرض التقارير، والتعامل مع استفسارات المستخدمين.
- **بنية قابلة للتوسع**: مبنية على نمط MVC، مما يضمن بنية خلفية قوية وقابلة للتوسع.

### التقنيات المستخدمة
- **Laravel**: إطار عمل PHP قوي لتطوير تطبيقات الويب.
- **PHP**: لغة البرمجة المستخدمة في تطوير الواجهة الخلفية.
- **MySQL**: نظام إدارة قواعد البيانات العلائقية لتخزين البيانات.
- **Blade**: محرك القوالب الخاص بـ Laravel لإنشاء واجهات ديناميكية.
- **REST APIs**: لتسهيل التواصل بين الواجهة الأمامية والخلفية.
- **التحكم في الوصول القائم على الدور (RBAC)**: لضمان الوصول الآمن إلى أجزاء مختلفة من التطبيق.
- **برمجة كائنية التوجه (OOP)**: لتحسين تنظيم الكود وإعادة استخدامه.

### البدء
لتشغيل تطبيق GoldenCinema محليًا، اتبع الخطوات التالية:
1. **استنساخ المستودع**:
   ```bash
   git clone https://github.com/yourusername/goldencinema.git
   cd goldencinema
   ```
2. **تثبيت التبعيات**:
   ```bash
   composer install
   npm install
   ```
3. **إعداد البيئة**:
   - انسخ `.env.example` إلى `.env` وقم بتكوين إعدادات قاعدة البيانات الخاصة بك.
4. **تشغيل الهجرات**:
   ```bash
   php artisan migrate
   ```
5. **بدء الخادم**:
   ```bash
   php artisan serve
   ```
6. **الوصول إلى التطبيق**:
   افتح متصفحك وانتقل إلى `http://localhost:8000`.

### نظرة عامة تفصيلية

#### 🎬 الميزات الأساسية

**🔐 المصادقة والتفويض**
- **مصادقة متعددة الأدوار**: أنظمة تسجيل دخول منفصلة للمديرين والعملاء والمسؤولين
- **التحكم في الوصول القائم على الأدوار (RBAC)**: أذونات وواجهات لوحة تحكم مختلفة لكل دور
- **إدارة كلمات المرور الآمنة**: كلمات مرور مشفرة باستخدام ميزات أمان Laravel المدمجة
- **إدارة الجلسات**: تسجيل دخول مستمر مع معالجة جلسات آمنة

**🎬 إدارة الأفلام**
- **قائمة الأفلام**: إضافة وتعديل وحذف الأفلام مع معلومات مفصلة
- **عروض الأفلام/الجلسات**: جدولة عروض الأفلام عبر عدة مسارح وشاشات
- **إدارة الإعلانات**: تحميل وإدارة إعلانات الأفلام
- **إدارة الفئات**: تنظيم الأفلام إلى فئات لتسهيل التصفح

**🏛️ البنية التحتية للسينما**
- **إدارة المسارح**: إدارة عدة مسارح سينمائية
- **إدارة الشاشات/القاعات**: إنشاء وتكوين الشاشات داخل المسارح
- **إدارة المقاعد**: تعريف تخطيطات المقاعد مع أنواع وحالات مختلفة
- **التسعير الديناميكي**: تعيين الأسعار حسب الشاشة والعرض ونوع المقعد

**🎫 نظام حجز التذاكر**
- **اختيار المقاعد عبر الإنترنت**: خرائط مقاعد تفاعلية لاختيار المقاعد
- **توفر المقاعد في الوقت الفعلي**: التحقق من توفر المقاعد لكل عرض
- **معالجة الدفع**: تكامل الدفع الآمن مع تتبع الدفع المعلق
- **تأكيد الحجز**: إنشاء وإدارة تأكيدات الحجز

**📊 لوحات التحكم للمسؤولين والمديرين**
- **تقارير المبيعات**: عرض إحصائيات المبيعات اليومية والإجمالية
- **تحليلات الحجز**: تتبع اتجاهات الحجز والأفلام الشهيرة
- **إدارة المستخدمين**: إدارة حسابات المسؤولين والمديرين والعملاء
- **عمليات المسرح**: مراقبة أداء المسرح واستخدام الشاشة

### بنية المشروع

#### هيكل قاعدة البيانات
يستخدم التطبيق **14 نموذج رئيسي** مع علاقات معقدة:
- **المستخدمون**: مسؤول، مدير، عميل (قائم على الدور)
- **الأفلام**: معلومات الأفلام مع مفتاح خارجي للفئة
- **عروض الأفلام**: جدولة عروض الأفلام في أوقات محددة
- **المسارح**: مواقع السينما
- **الشاشات**: القاعات داخل المسارح
- **المقاعد**: المقاعد الفردية مع الحالة والتسعير
- **الحجوزات**: حجوزات تذاكر العملاء
- **التذاكر**: المولدة من الحجوزات
- **الفئات**: تصنيف الأفلام
- **الحالات**: حالات الحجز والتذاكر
- **الإعلانات**: محتوى ترويجي للأفلام
- **الدفع المعلق**: تتبع الدفع

#### أدوار المستخدمين والأذونات

**👨‍💼 المسؤول**
- التحكم الكامل بالنظام
- إدارة حسابات المديرين
- عرض التقارير على مستوى النظام بالكامل
- تكوين إعدادات التطبيق
- مراقبة جميع العمليات

**👤 المدير**
- إدارة المسرح(ات) المخصصة
- إضافة وجدولة الأفلام
- إدارة الشاشات والمقاعد
- عرض التقارير الخاصة بالمسرح
- التعامل مع استفسارات العملاء

**🎟️ العميل**
- تصفح الأفلام المتاحة
- عرض تفاصيل الأفلام والإعلانات
- حجز التذاكر عبر الإنترنت
- اختيار المقاعد المفضلة
- إجراء الدفع الآمن
- عرض سجل الحجز

#### هيكل التوجيه
```
/admin          → لوحة التحكم الإدارية
/manager        → لوحة التحكم للمدير
/cinema         → واجهة السينما العامة
/client         → لوحة التحكم للعميل
/auth           → المصادقة (تسجيل الدخول/التسجيل)
```

### التقنيات والأدوات المستخدمة

| المكون | التقنية | الإصدار |
|------|---------|---------|
| **الإطار** | Laravel | 11.9+ |
| **اللغة** | PHP | 8.2+ |
| **قاعدة البيانات** | MySQL | الأحدث |
| **محرك القوالب** | Blade | أصلي من Laravel |
| **واجهة أمامية** | Tailwind CSS | الأحدث |
| **أداة البناء** | Vite | الأحدث |
| **مدير الحزم** | Composer و NPM | الأحدث |
| **بنية الـ API** | REST API | مخصص |
| **المصادقة** | Laravel Auth | مدمج |
| **إنشاء ملفات PDF** | DOMPDF | 3.1+ |
| **معالجة الصور** | Intervention Image | 3.11+ |
| **الاختبار** | Pest PHP | 3.4+ |

### التثبيت والإعداد

#### المتطلبات الأساسية
- PHP 8.2 أو أحدث
- Composer مثبت
- Node.js و npm مثبتان
- خادم قاعدة بيانات MySQL

#### خطوات التثبيت خطوة بخطوة

1. **استنساخ المستودع**:
   ```bash
   git clone https://github.com/yourusername/goldencinema.git
   cd goldencinema
   ```

2. **تثبيت تبعيات PHP**:
   ```bash
   composer install
   ```

3. **تثبيت تبعيات Node.js**:
   ```bash
   npm install
   ```

4. **تكوين البيئة**:
   ```bash
   cp .env.example .env
   ```
   - قم بتحديث `.env` ببيانات قاعدة البيانات الخاصة بك
   - اضبط `APP_KEY` باستخدام `php artisan key:generate`

5. **إنشاء قاعدة البيانات**:
   ```bash
   mysql -u root -p -e "CREATE DATABASE cinema;"
   ```

6. **تشغيل الهجرات**:
   ```bash
   php artisan migrate
   ```

7. **ملء البيانات الأولية (اختياري)**:
   ```bash
   php artisan db:seed
   ```

8. **بناء الأصول**:
   ```bash
   npm run build
   ```
   أو للتطوير مع إعادة التحميل الفوري:
   ```bash
   npm run dev
   ```

9. **بدء خادم التطوير**:
   ```bash
   php artisan serve
   ```

10. **الوصول إلى التطبيق**:
    - الرئيسية: `http://localhost:8000`
    - تسجيل دخول المسؤول: `http://localhost:8000/admin/login`
    - تسجيل دخول المدير: `http://localhost:8000/manager/login`
    - تسجيل دخول العميل: `http://localhost:8000/client/login`

### نماذج العلاقات الرئيسية

```php
// مثال على العلاقات المنفذة في النظام
Movie → hasMany(MovieShow)
Movie → belongsToMany(Category)
Movie → hasMany(Trailer)

MovieShow → belongsTo(Movie)
MovieShow → belongsTo(Screen)

Theater → hasMany(Screen)

Screen → belongsTo(Theater)
Screen → hasMany(Seat)
Screen → hasMany(MovieShow)

Seat → belongsTo(Screen)
Seat → hasMany(Ticket)

Booking → belongsTo(Client)
Booking → belongsTo(MovieShow)
Booking → hasMany(Ticket)

Ticket → belongsTo(Booking)
Ticket → belongsTo(Seat)
Ticket → belongsTo(Status)

Client → hasMany(Booking)
Manager → hasMany(Theater)
Admin → hasMany(Manager)
```

### التطوير والاختبار

- **اختبارات الوحدة والميزات**: موجودة في مجلد `tests/`
- **إطار الاختبار**: Pest PHP
- **مصنع قاعدة البيانات**: توليد البيانات الوهمية باستخدام Faker
- **معايير الكود**: Laravel Pint لتنسيق الكود

### هيكل المشروع
```
cinema/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          (متحكمات الإدارة)
│   │   │   ├── manager/        (متحكمات المدير)
│   │   │   └── client/         (متحكمات العميل)
│   │   ├── Middleware/         (مصادقة وميدلوير مخصص)
│   │   └── Requests/           (التحقق من النماذج)
│   ├── Models/                 (نماذج Eloquent)
│   └── Providers/              (موفرو الخدمات)
├── database/
│   ├── migrations/             (مخطط قاعدة البيانات)
│   ├── seeders/                (البيانات الأولية)
│   └── factories/              (مصانع البيانات الاختبارية)
├── resources/
│   ├── views/
│   │   ├── admin/              (قوالب الإدارة)
│   │   ├── manager/            (قوالب المدير)
│   │   └── client/             (قوالب العميل)
│   ├── css/                    (أوراق الأنماط)
│   └── js/                     (سكريبتات الواجهة الأمامية)
├── routes/
│   ├── admin/                  (طرق الإدارة)
│   ├── manager/                (طرق المدير)
│   ├── client/                 (طرق العميل)
│   └── web.php                 (الطرق الرئيسية)
└── public/                     (الأصول العامة)
```

### اعتبارات الأمان
- ✅ حماية CSRF على جميع النماذج
- ✅ الوقاية من حقن SQL (Eloquent ORM)
- ✅ تجزئة كلمات المرور (bcrypt)
- ✅ فحوصات التفويض على المسارات المحمية
- ✅ التحقق من الإدخال على جميع النماذج
- ✅ إدارة جلسات آمنة
- ✅ نقاط نهاية API محمية

### ميزات الأداء
- فهرسة قاعدة البيانات على المفاتيح الخارجية
- التحميل المسبق مع العلاقات (`with()`)
- الترقيم للمجموعات الكبيرة
- استراتيجيات التخزين المؤقت المنفذة
- استعلامات قاعدة البيانات المحسنة

### المساهمة
المساهمات مرحب بها! يرجى اتباع معايير كود Laravel وإنشاء طلبات سحب مع وصفات مفصلة.

### استكشاف الأخطاء

**فشل تثبيت Composer**:
```bash
composer install --no-interaction
```

**خطأ في الهجرات**:
```bash
php artisan migrate:refresh
```

**مشاكل التخزين المؤقت**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### الخاتمة
يقدم GoldenCinema حلاً جاهزًا للإنتاج لإدارة السينما مع مصادقة آمنة، وإدارة شاملة لعمليات السينما، ومنصة حجز بديهية عبر الإنترنت. إنه يوضح ممارسات تطوير Laravel احترافية مع كود نظيف، وأنماط معمارية مناسبة، وواجهات سهلة الاستخدام لجميع أصحاب المصلحة في قطاع السينما.
