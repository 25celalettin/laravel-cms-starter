#!/bin/bash

# Laravel CMS Starter Template - Otomatik Kurulum Script'i
# Bu script yeni proje oluşturduktan sonra hızlı kurulum için kullanılır

echo "🚀 Laravel CMS Starter Template Kurulumu Başlıyor..."
echo "================================================"

# Renklendirme için
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Hata durumunda script'i durdur
set -e

# Fonksiyonlar
print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️ $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ️ $1${NC}"
}

# Gerekli komutların kontrolü
check_requirements() {
    print_info "Gereksinimler kontrol ediliyor..."
    
    if ! command -v php &> /dev/null; then
        print_error "PHP bulunamadı! PHP 8.2+ yüklü olmalı."
        exit 1
    fi
    
    if ! command -v composer &> /dev/null; then
        print_error "Composer bulunamadı! Composer yüklü olmalı."
        exit 1
    fi
    
    if ! command -v npm &> /dev/null; then
        print_error "NPM bulunamadı! Node.js ve NPM yüklü olmalı."
        exit 1
    fi
    
    print_success "Tüm gereksinimler mevcut!"
}

# Proje adı alma
get_project_name() {
    if [ -z "$1" ]; then
        read -p "📝 Proje adınızı girin (örn: my-awesome-project): " PROJECT_NAME
    else
        PROJECT_NAME=$1
    fi
    
    if [ -z "$PROJECT_NAME" ]; then
        PROJECT_NAME="laravel-cms-project"
        print_warning "Varsayılan proje adı kullanılıyor: $PROJECT_NAME"
    fi
}

# Composer bağımlılıkları
install_composer_dependencies() {
    print_info "Composer bağımlılıkları yükleniyor..."
    composer install --no-dev --optimize-autoloader
    print_success "Composer bağımlılıkları yüklendi!"
}

# NPM bağımlılıkları
install_npm_dependencies() {
    print_info "NPM bağımlılıkları yükleniyor..."
    npm install
    print_success "NPM bağımlılıkları yüklendi!"
}

# Ortam dosyası hazırlama
setup_environment() {
    print_info "Ortam dosyası hazırlanıyor..."
    
    if [ ! -f .env ]; then
        if [ -f .env.example ]; then
            cp .env.example .env
        else
            print_warning ".env.example bulunamadı, varsayılan .env oluşturuluyor..."
            cat > .env << EOL
APP_NAME="$PROJECT_NAME"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

SESSION_DRIVER=database
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="\${APP_NAME}"

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

VITE_APP_NAME="\${APP_NAME}"
EOL
        fi
    fi
    
    # Uygulama anahtarı oluştur
    php artisan key:generate
    
    print_success "Ortam dosyası hazırlandı!"
}

# Veritabanı hazırlama
setup_database() {
    print_info "Veritabanı hazırlanıyor..."
    
    # SQLite dosyası oluştur
    if [ ! -f database/database.sqlite ]; then
        touch database/database.sqlite
        print_success "SQLite veritabanı dosyası oluşturuldu!"
    fi
    
    # Migrationları çalıştır
    php artisan migrate --force
    print_success "Veritabanı tabloları oluşturuldu!"
    
    # Seed verilerini sor
    read -p "🌱 Varsayılan verileri yüklemek istiyor musunuz? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        php artisan db:seed --force
        print_success "Seed verileri yüklendi!"
        print_info "Varsayılan giriş bilgileri:"
        echo "  👤 Admin: admin@admin.com / password"
        echo "  👤 Kullanıcı: test@test.com / password"
    fi
}

# Depolama bağlantısı
setup_storage() {
    print_info "Depolama bağlantısı oluşturuluyor..."
    php artisan storage:link
    print_success "Depolama bağlantısı oluşturuldu!"
}

# İzinleri ayarlama (Linux/Mac için)
setup_permissions() {
    if [[ "$OSTYPE" == "linux-gnu"* ]] || [[ "$OSTYPE" == "darwin"* ]]; then
        print_info "Dosya izinleri ayarlanıyor..."
        chmod -R 755 storage bootstrap/cache
        print_success "Dosya izinleri ayarlandı!"
    fi
}

# Optimizasyon
optimize_application() {
    print_info "Uygulama optimize ediliyor..."
    php artisan optimize:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    print_success "Uygulama optimize edildi!"
}

# Asset'leri build etme
build_assets() {
    read -p "🎨 Asset'leri build etmek istiyor musunuz? (production için önerilen) (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        print_info "Asset'ler build ediliyor..."
        npm run build
        print_success "Asset'ler build edildi!"
    else
        print_warning "Geliştirme için 'npm run dev' komutunu çalıştırabilirsiniz."
    fi
}

# Ana kurulum fonksiyonu
main() {
    echo
    get_project_name $1
    echo
    check_requirements
    echo
    
    print_info "Kurulum başlıyor..."
    echo
    
    install_composer_dependencies
    install_npm_dependencies
    setup_environment
    setup_database
    setup_storage
    setup_permissions
    optimize_application
    build_assets
    
    echo
    echo "🎉 Kurulum Tamamlandı!"
    echo "====================="
    print_success "Proje başarıyla kuruldu: $PROJECT_NAME"
    echo
    print_info "Sunucuyu başlatmak için:"
    echo "  👉 php artisan serve"
    echo "  👉 npm run dev (başka bir terminalde)"
    echo
    print_info "Veya tek komutla:"
    echo "  👉 composer run dev"
    echo
    print_info "Admin paneline erişim:"
    echo "  🌐 http://localhost:8000/admin"
    echo
    print_info "Daha fazla bilgi için:"
    echo "  📖 README.md dosyasını okuyun"
    echo "  📖 SETUP.md dosyasını inceleyin"
    echo
    print_success "Başarılı bir proje için tebrikler! 🚀"
}

# Script'i çalıştır
main $1
