# 🚀 Laravel CMS Starter Template

Modern ve kullanıma hazır Laravel CMS projesi için temel template. Auth sistemi, admin paneli, ayarlar yönetimi ve çok dilli destek ile birlikte gelir.

## ✨ Özellikler

### 🔐 Kimlik Doğrulama Sistemi
- **Giriş/Kayıt**: Kullanıcı giriş ve kayıt sistemi
- **Şifre Sıfırlama**: E-posta ile şifre sıfırlama
- **Rol Tabanlı Yetkilendirme**: 4 farklı kullanıcı rolü (User, Estate Agency, Admin, SuperAdmin)
- **Oturum Yönetimi**: Güvenli oturum yönetimi ve remember me

### 🎛️ Admin Paneli
- **Dashboard**: Genel istatistikler ve sistem durumu
- **Kullanıcı Yönetimi**: Kullanıcı ekleme, düzenleme, silme
- **Blog Yönetimi**: İçerik yönetim sistemi
- **Ayarlar Sistemi**: Dinamik site ayarları yönetimi

### ⚙️ Ayarlar Sistemi
- **Genel Ayarlar**: Site başlığı, açıklama, logo, favicon
- **İletişim Bilgileri**: E-posta, telefon, adres
- **Sosyal Medya**: Facebook, Twitter, Instagram, LinkedIn
- **SEO Ayarları**: Meta etiketler ve SEO optimizasyonu
- **Grup Bazlı Yönetim**: Ayarları kategorilere göre gruplandırma

### 🌍 Çok Dilli Destek
- **Türkçe/İngilizce**: Hazır dil desteği
- **Çeviri Sistemi**: Laravel localization
- **Dinamik Dil Değiştirme**: Kullanıcı dostu dil seçimi

### 🎨 Modern UI/UX
- **Tailwind CSS**: Modern ve responsive tasarım
- **Dark Mode**: Koyu tema desteği
- **Alpine.js**: Hafif JavaScript framework
- **Responsive**: Mobil uyumlu tasarım

## 🛠️ Teknolojiler

- **Backend**: Laravel 12.x
- **Frontend**: Tailwind CSS 4.x, Alpine.js
- **Database**: SQLite (geliştirme için), MySQL/PostgreSQL (production)
- **Authentication**: Laravel Breeze benzeri özel auth sistemi
- **Asset Building**: Vite
- **PHP**: 8.2+

## 🚀 Hızlı Başlangıç

### 1. Projeyi Klonlayın

```bash
git clone https://github.com/kullanici-adi/laravel-cms-starter.git
cd laravel-cms-starter
```

### 2. Bağımlılıkları Yükleyin

```bash
# Composer bağımlılıkları
composer install

# NPM bağımlılıkları
npm install
```

### 3. Ortam Dosyasını Hazırlayın

```bash
# .env dosyasını kopyalayın
cp .env.example .env

# Uygulama anahtarını oluşturun
php artisan key:generate
```

### 4. Veritabanını Hazırlayın

```bash
# Veritabanını oluşturun (SQLite için)
touch database/database.sqlite

# Migrationları çalıştırın
php artisan migrate

# Seed verilerini ekleyin (opsiyonel)
php artisan db:seed
```

### 5. Depolama Bağlantısını Oluşturun

```bash
php artisan storage:link
```

### 6. Geliştirme Sunucusunu Başlatın

```bash
# Laravel sunucusu + Vite + Queue + Logs (concurrently ile)
composer run dev

# Veya ayrı ayrı:
php artisan serve
npm run dev
```

## 👤 Varsayılan Kullanıcılar

Seeder çalıştırıldıktan sonra şu kullanıcılar mevcut olacak:

| E-posta | Şifre | Rol |
|---------|--------|-----|
| admin@admin.com | password | SuperAdmin |
| test@test.com | password | User |

## 📁 Proje Yapısı

```
├── app/
│   ├── Enums/
│   │   └── UserRole.php          # Kullanıcı rolleri
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            # Admin panel kontrolcüleri
│   │   │   └── AuthController.php # Kimlik doğrulama
│   │   └── Middleware/           # Özel middleware'ler
│   ├── Models/
│   │   ├── User.php             # Kullanıcı modeli
│   │   ├── Setting.php          # Ayarlar modeli
│   │   └── Blog.php             # Blog modeli
│   └── Helpers/
│       └── functions.php        # Yardımcı fonksiyonlar
├── config/
│   └── settings.php             # Ayarlar konfigürasyonu
├── resources/
│   └── views/
│       ├── admin/               # Admin panel görünümleri
│       ├── auth/                # Kimlik doğrulama görünümleri
│       └── layouts/             # Layout dosyaları
└── routes/
    ├── web.php                  # Web rotaları
    ├── auth.php                 # Auth rotaları
    └── admin.php                # Admin rotaları
```

## 🔧 Konfigürasyon

### .env Dosyası

```env
# Temel ayarlar
APP_NAME="Laravel CMS"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Veritabanı
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# Mail ayarları (şifre sıfırlama için)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yoursite.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 📝 Kullanım

### Yeni Ayar Ekleme

`config/settings.php` dosyasına yeni ayar ekleyin:

```php
[
    'key' => 'new_setting',
    'value' => 'default_value',
    'group' => 'general',
    'type' => 'text',
    'title' => 'Yeni Ayar',
    'description' => 'Ayar açıklaması',
    'is_translatable' => false
]
```

### Ayar Değerini Alma

```php
// Helper fonksiyonu ile
$value = setting('site_title');

// Model üzerinden
$value = \App\Models\Setting::get('site_title', 'varsayılan değer');
```

### Yeni Rol Ekleme

`app/Enums/UserRole.php` dosyasını düzenleyin:

```php
enum UserRole: string
{
    case USER = 'user';
    case NEW_ROLE = 'new_role';
    case ADMIN = 'admin';
    case SUPERADMIN = 'superadmin';
}
```

## 🎨 Özelleştirme

### Tema Renkleri

`tailwind.config.js` dosyasında `primary` rengini değiştirin:

```javascript
theme: {
    extend: {
        colors: {
            primary: colors.blue, // İstediğiniz rengi seçin
        }
    }
}
```

### Logo ve Favicon

1. Dosyaları `public/storage` klasörüne yükleyin
2. Admin panelinden ayarlar > genel bölümünden güncelleyin

## 🔒 Güvenlik

- **CSRF Koruması**: Tüm formlarda CSRF token kontrolü
- **XSS Koruması**: Blade template engine otomatik escape
- **SQL Injection**: Eloquent ORM ile parameterized queries
- **Authentication**: Güvenli şifre hash'leme
- **Authorization**: Middleware tabanlı yetkilendirme

## 📖 Dokümantasyon

### API Endpoint'leri

```
GET    /admin/dashboard         # Admin dashboard
GET    /admin/users            # Kullanıcı listesi
POST   /admin/users            # Yeni kullanıcı
GET    /admin/settings         # Ayarlar
PUT    /admin/settings         # Ayar güncelleme
```

### Middleware'ler

- `auth`: Giriş yapmış kullanıcı kontrolü
- `guest`: Misafir kullanıcı kontrolü
- `admin`: Admin yetkisi kontrolü

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit yapın (`git commit -m 'Add amazing feature'`)
4. Push yapın (`git push origin feature/amazing-feature`)
5. Pull Request açın

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasına bakın.

## 🙋‍♂️ Destek

Sorularınız için:
- GitHub Issues açın
- Email: your-email@domain.com
- Discord: your-discord-server

## 🚀 Deployment

### Production Hazırlığı

```bash
# Önbelleği temizle
php artisan optimize:clear

# Production için optimize et
php artisan optimize
php artisan view:cache
php artisan route:cache
php artisan config:cache

# Asset'leri build et
npm run build
```

### Server Gereksinimleri

- PHP 8.2+
- Composer
- MySQL 8.0+ / PostgreSQL 13+
- Node.js 18+
- Web server (Apache/Nginx)

---

⭐ **Bu template'i beğendiyseniz star vermeyi unutmayın!**

📢 **Yeni projelerinizde kullanmak için `Use this template` butonuna tıklayın.**