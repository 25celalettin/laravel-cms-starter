# 🚀 Laravel CMS Template - Kurulum Rehberi

Bu rehber, bu template'den yeni bir proje oluşturduktan sonra izlemeniz gereken adımları açıklar.

## 📋 Ön Gereksinimler

- PHP 8.2 veya üzeri
- Composer
- Node.js 18+ ve npm
- Git

## 🎯 Hızlı Kurulum (5 dakika)

### 1. Projeyi İndirin

GitHub'da bu template'i kullanarak yeni repo oluşturun:
1. **"Use this template"** butonuna tıklayın
2. Yeni repository adını girin
3. **"Create repository from template"** tıklayın
4. Projeyi bilgisayarınıza klonlayın

```bash
git clone https://github.com/KULLANICI-ADI/PROJE-ADI.git
cd PROJE-ADI
```

### 2. Bağımlılıkları Yükleyin

```bash
# PHP bağımlılıkları
composer install

# JavaScript bağımlılıkları
npm install
```

### 3. Ortam Ayarlarını Yapın

```bash
# .env dosyasını oluşturun
cp .env.example .env

# Uygulama anahtarını oluşturun
php artisan key:generate
```

### 4. .env Dosyasını Düzenleyin

`.env` dosyasını açın ve aşağıdaki ayarları yapın:

```env
# Uygulama adını değiştirin
APP_NAME="Proje Adınız"
APP_URL=http://localhost

# Veritabanı (SQLite kullanıyorsanız değiştirmeyin)
DB_CONNECTION=sqlite

# MySQL kullanmak istiyorsanız:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=veritabani_adi
# DB_USERNAME=kullanici_adi
# DB_PASSWORD=sifre

# Mail ayarları (şifre sıfırlama için)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Veritabanını Hazırlayın

```bash
# SQLite için database dosyası oluşturun
touch database/database.sqlite

# Veritabanı tablolarını oluşturun
php artisan migrate

# Varsayılan verileri ekleyin (opsiyonel)
php artisan db:seed
```

### 6. Depolama Bağlantısını Oluşturun

```bash
php artisan storage:link
```

### 7. Geliştirme Sunucusunu Başlatın

```bash
# Tek komutla tüm servisleri başlat (önerilen)
composer run dev

# Veya ayrı ayrı:
php artisan serve        # Laravel sunucusu (http://localhost:8000)
npm run dev             # Vite geliştirme sunucusu
```

## 🎉 Tebrikler!

Projeniz artık hazır! Şu adreslere gidebilirsiniz:

- **Ana Site**: http://localhost:8000
- **Admin Paneli**: http://localhost:8000/admin
- **Giriş Sayfası**: http://localhost:8000/auth/login

### 🔑 Varsayılan Giriş Bilgileri

Seed verilerini yüklediyseniz şu hesapları kullanabilirsiniz:

| E-posta | Şifre | Rol |
|---------|--------|-----|
| admin@admin.com | password | SuperAdmin |
| test@test.com | password | User |

## 🔧 İleri Konfigürasyon

### Proje Adını Değiştirme

1. `composer.json` dosyasında `name` alanını güncelleyin
2. `package.json` dosyasında `name` alanını güncelleyin
3. README.md dosyasını projenize göre düzenleyin

### Varsayılan Ayarları Değiştirme

`config/settings.php` dosyasında varsayılan site ayarlarını düzenleyin:

```php
[
    'key' => 'site_title',
    'value' => 'Yeni Site Başlığı',
    // ...
]
```

### Yeni Kullanıcı Rolleri Ekleme

`app/Enums/UserRole.php` dosyasını düzenleyin ve yeni rolleri ekleyin.

### Tema Renklerini Değiştirme

`tailwind.config.js` dosyasında primary rengi değiştirin:

```javascript
theme: {
    extend: {
        colors: {
            primary: colors.emerald, // İstediğiniz renk
        }
    }
}
```

## 🚀 Production'a Alma

### 1. Optimizasyon

```bash
# Cache'leri temizle
php artisan optimize:clear

# Production için optimize et
php artisan optimize
php artisan view:cache
php artisan route:cache
php artisan config:cache

# Asset'leri build et
npm run build
```

### 2. .env Ayarları

Production için `.env` dosyasını güncelleyin:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Güvenli veritabanı ayarları
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=strong-password

# Gerçek mail ayarları
MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
# ... diğer mail ayarları
```

### 3. Server Gereksinimleri

- PHP 8.2+ (mbstring, openssl, pdo, tokenizer, xml extensions)
- MySQL 8.0+ veya PostgreSQL 13+
- Web server (Apache/Nginx)
- Composer
- SSL sertifikası

## 🔍 Sorun Giderme

### Sık Karşılaşılan Sorunlar

**1. "Class 'PDO' not found" hatası:**
```bash
# PHP PDO extension'ı yükleyin
sudo apt-get install php-pdo php-pdo-mysql  # Ubuntu
```

**2. Permission denied hataları:**
```bash
# Laravel için gerekli izinleri verin
sudo chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

**3. Vite assets yüklenmiyor:**
```bash
# npm cache'i temizleyin
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

**4. Migration hataları:**
```bash
# Veritabanını sıfırlayın
php artisan migrate:fresh --seed
```

### Log Dosyaları

Hata durumunda şu dosyaları kontrol edin:
- `storage/logs/laravel.log`
- Tarayıcı developer console
- Web server error logs

## 📞 Destek

- GitHub Issues: Teknik sorunlar için
- Discord: Hızlı yardım için
- Email: Özel destek için

## 📝 Sonraki Adımlar

1. **Özelleştirme**: Projeyi ihtiyaçlarınıza göre özelleştirin
2. **Content**: İlk içeriklerinizi ekleyin
3. **Testing**: Testlerinizi yazın
4. **Deployment**: Production sunucusuna yükleyin
5. **Monitoring**: Hata takibi ve performans izleme ekleyin

---

🎉 **Başarılı bir proje için tebrikler! Bu template ile harika şeyler yaratın.**
