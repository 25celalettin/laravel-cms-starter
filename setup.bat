@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion

REM Laravel CMS Starter Template - Windows Kurulum Script'i
echo 🚀 Laravel CMS Starter Template Kurulumu Başlıyor...
echo ================================================
echo.

REM Renklendirme için
set "RED=[91m"
set "GREEN=[92m"
set "YELLOW=[93m"
set "BLUE=[94m"
set "NC=[0m"

REM Gerekli komutların kontrolü
echo %BLUE%ℹ️ Gereksinimler kontrol ediliyor...%NC%

where php >nul 2>nul
if errorlevel 1 (
    echo %RED%❌ PHP bulunamadı! PHP 8.2+ yüklü olmalı.%NC%
    pause
    exit /b 1
)

where composer >nul 2>nul
if errorlevel 1 (
    echo %RED%❌ Composer bulunamadı! Composer yüklü olmalı.%NC%
    pause
    exit /b 1
)

where npm >nul 2>nul
if errorlevel 1 (
    echo %RED%❌ NPM bulunamadı! Node.js ve NPM yüklü olmalı.%NC%
    pause
    exit /b 1
)

echo %GREEN%✅ Tüm gereksinimler mevcut!%NC%
echo.

REM Proje adı alma
if "%~1"=="" (
    set /p PROJECT_NAME="📝 Proje adınızı girin (örn: my-awesome-project): "
) else (
    set "PROJECT_NAME=%~1"
)

if "!PROJECT_NAME!"=="" (
    set "PROJECT_NAME=laravel-cms-project"
    echo %YELLOW%⚠️ Varsayılan proje adı kullanılıyor: !PROJECT_NAME!%NC%
)

echo.

REM Composer bağımlılıkları
echo %BLUE%ℹ️ Composer bağımlılıkları yükleniyor...%NC%
call composer install --no-dev --optimize-autoloader
if errorlevel 1 (
    echo %RED%❌ Composer bağımlılıkları yüklenirken hata oluştu!%NC%
    pause
    exit /b 1
)
echo %GREEN%✅ Composer bağımlılıkları yüklendi!%NC%

REM NPM bağımlılıkları
echo %BLUE%ℹ️ NPM bağımlılıkları yükleniyor...%NC%
call npm install
if errorlevel 1 (
    echo %RED%❌ NPM bağımlılıkları yüklenirken hata oluştu!%NC%
    pause
    exit /b 1
)
echo %GREEN%✅ NPM bağımlılıkları yüklendi!%NC%

REM Ortam dosyası hazırlama
echo %BLUE%ℹ️ Ortam dosyası hazırlanıyor...%NC%

if not exist .env (
    if exist .env.example (
        copy .env.example .env >nul
    ) else (
        echo %YELLOW%⚠️ .env.example bulunamadı, varsayılan .env oluşturuluyor...%NC%
        (
            echo APP_NAME="!PROJECT_NAME!"
            echo APP_ENV=local
            echo APP_KEY=
            echo APP_DEBUG=true
            echo APP_URL=http://localhost
            echo.
            echo DB_CONNECTION=sqlite
            echo.
            echo BROADCAST_CONNECTION=log
            echo FILESYSTEM_DISK=local
            echo QUEUE_CONNECTION=database
            echo.
            echo SESSION_DRIVER=database
            echo SESSION_LIFETIME=120
            echo.
            echo MAIL_MAILER=smtp
            echo MAIL_HOST=mailpit
            echo MAIL_PORT=1025
            echo MAIL_USERNAME=null
            echo MAIL_PASSWORD=null
            echo MAIL_ENCRYPTION=null
            echo MAIL_FROM_ADDRESS="hello@example.com"
            echo MAIL_FROM_NAME="${APP_NAME}"
            echo.
            echo LOG_CHANNEL=stack
            echo LOG_STACK=single
            echo LOG_DEPRECATIONS_CHANNEL=null
            echo LOG_LEVEL=debug
            echo.
            echo VITE_APP_NAME="${APP_NAME}"
        ) > .env
    )
)

REM Uygulama anahtarı oluştur
php artisan key:generate
echo %GREEN%✅ Ortam dosyası hazırlandı!%NC%

REM Veritabanı hazırlama
echo %BLUE%ℹ️ Veritabanı hazırlanıyor...%NC%

REM SQLite dosyası oluştur
if not exist database\database.sqlite (
    type nul > database\database.sqlite
    echo %GREEN%✅ SQLite veritabanı dosyası oluşturuldu!%NC%
)

REM Migrationları çalıştır
php artisan migrate --force
if errorlevel 1 (
    echo %RED%❌ Migrationlar çalıştırılırken hata oluştu!%NC%
    pause
    exit /b 1
)
echo %GREEN%✅ Veritabanı tabloları oluşturuldu!%NC%

REM Seed verilerini sor
set /p SEED_CHOICE="🌱 Varsayılan verileri yüklemek istiyor musunuz? (y/N): "
if /i "!SEED_CHOICE!"=="y" (
    php artisan db:seed --force
    echo %GREEN%✅ Seed verileri yüklendi!%NC%
    echo %BLUE%ℹ️ Varsayılan giriş bilgileri:%NC%
    echo   👤 Admin: admin@admin.com / password
    echo   👤 Kullanıcı: test@test.com / password
)

REM Depolama bağlantısı
echo %BLUE%ℹ️ Depolama bağlantısı oluşturuluyor...%NC%
php artisan storage:link
echo %GREEN%✅ Depolama bağlantısı oluşturuldu!%NC%

REM Optimizasyon
echo %BLUE%ℹ️ Uygulama optimize ediliyor...%NC%
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo %GREEN%✅ Uygulama optimize edildi!%NC%

REM Asset'leri build etme
set /p BUILD_CHOICE="🎨 Asset'leri build etmek istiyor musunuz? (production için önerilen) (y/N): "
if /i "!BUILD_CHOICE!"=="y" (
    echo %BLUE%ℹ️ Asset'ler build ediliyor...%NC%
    call npm run build
    echo %GREEN%✅ Asset'ler build edildi!%NC%
) else (
    echo %YELLOW%⚠️ Geliştirme için 'npm run dev' komutunu çalıştırabilirsiniz.%NC%
)

echo.
echo 🎉 Kurulum Tamamlandı!
echo =====================
echo %GREEN%✅ Proje başarıyla kuruldu: !PROJECT_NAME!%NC%
echo.
echo %BLUE%ℹ️ Sunucuyu başlatmak için:%NC%
echo   👉 php artisan serve
echo   👉 npm run dev (başka bir komut isteminde)
echo.
echo %BLUE%ℹ️ Veya tek komutla:%NC%
echo   👉 composer run dev
echo.
echo %BLUE%ℹ️ Admin paneline erişim:%NC%
echo   🌐 http://localhost:8000/admin
echo.
echo %BLUE%ℹ️ Daha fazla bilgi için:%NC%
echo   📖 README.md dosyasını okuyun
echo   📖 SETUP.md dosyasını inceleyin
echo.
echo %GREEN%✅ Başarılı bir proje için tebrikler! 🚀%NC%
echo.
pause
