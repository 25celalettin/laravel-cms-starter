# 🤝 Katkıda Bulunma Rehberi

Bu proje açık kaynak kodludur ve katkılarınızı memnuniyetle karşılıyoruz!

## 🎯 Katkı Türleri

- 🐛 **Bug Raporları**: Hataları bildirin
- ✨ **Yeni Özellikler**: Özellik önerilerinde bulunun
- 📖 **Dokümantasyon**: Dokümantasyonu geliştirin
- 🎨 **UI/UX İyileştirmeleri**: Arayüzü güzelleştirin
- 🔧 **Kod İyileştirmeleri**: Performans ve kalite artırın

## 🚀 Başlangıç

### 1. Projeyi Fork Edin

GitHub'da projeyi fork edin ve yerel makinenize klonlayın:

```bash
git clone https://github.com/KULLANICI-ADI/laravel-cms-starter.git
cd laravel-cms-starter
```

### 2. Geliştirme Ortamını Kurun

```bash
# Bağımlılıkları yükleyin
composer install
npm install

# Ortam dosyasını oluşturun
cp .env.example .env
php artisan key:generate

# Veritabanını hazırlayın
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
```

### 3. Branch Oluşturun

```bash
git checkout -b feature/amazing-feature
# veya
git checkout -b bugfix/issue-123
```

## 📝 Koding Standartları

### PHP (Laravel)

- **PSR-12** coding standardını takip edin
- Laravel best practices'i uygulayın
- Method ve class'lar için Türkçe yorum yazın
- Eloquent ORM kullanın, raw SQL'den kaçının

```php
<?php

namespace App\Http\Controllers;

/**
 * Kullanıcı yönetimi kontrolcüsü
 */
class UserController extends Controller
{
    /**
     * Kullanıcı listesini getir
     */
    public function index(): View
    {
        $users = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }
}
```

### JavaScript

- **ES6+** syntax kullanın
- Alpine.js için component-based yaklaşım
- Console.log'ları production'a göndermeden önce temizleyin

```javascript
// Alpine.js component
Alpine.data('userManager', () => ({
    users: [],
    loading: false,
    
    async loadUsers() {
        this.loading = true;
        try {
            const response = await fetch('/api/users');
            this.users = await response.json();
        } catch (error) {
            console.error('Kullanıcılar yüklenirken hata:', error);
        } finally {
            this.loading = false;
        }
    }
}));
```

### CSS (Tailwind)

- Utility-first yaklaşım kullanın
- Custom CSS yazarken component-based düşünün
- Dark mode desteğini unutmayın

```html
<!-- İyi -->
<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
        Başlık
    </h2>
</div>

<!-- Kötü -->
<div style="background: white; padding: 24px;">
    <h2 style="font-size: 20px; font-weight: bold;">
        Başlık
    </h2>
</div>
```

## 🧪 Testing

### Unit Testler

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Enums\UserRole;

class UserTest extends TestCase
{
    /** @test */
    public function user_can_have_role()
    {
        $user = User::factory()->create([
            'role' => UserRole::ADMIN
        ]);

        $this->assertTrue($user->hasRole(UserRole::ADMIN));
        $this->assertFalse($user->hasRole(UserRole::USER));
    }
}
```

### Feature Testler

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Enums\UserRole;

class AdminDashboardTest extends TestCase
{
    /** @test */
    public function admin_can_access_dashboard()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }
}
```

### Test Çalıştırma

```bash
# Tüm testler
php artisan test

# Specific test
php artisan test --filter=UserTest

# Coverage ile
php artisan test --coverage
```

## 📋 Pull Request Süreci

### 1. Kod Kalitesi Kontrolleri

```bash
# PHP CS Fixer
./vendor/bin/pint

# Larastan (PHPStan)
./vendor/bin/phpstan analyse

# Testleri çalıştır
php artisan test
```

### 2. Commit Mesajları

Conventional Commits formatını kullanın:

```
feat: yeni kullanıcı rolleri eklendi
fix: şifre sıfırlama hatası düzeltildi
docs: kurulum rehberi güncellendi
style: tailwind utility class'ları düzenlendi
refactor: auth middleware yeniden yapılandırıldı
test: kullanıcı authentication testleri eklendi
chore: bağımlılıklar güncellendi
```

### 3. PR Template

Pull Request açarken şu template'i kullanın:

```markdown
## 📝 Açıklama

Bu PR ile neler değişti ve neden?

## 🔄 Değişiklikler

- [ ] Yeni özellik eklendi
- [ ] Bug düzeltildi
- [ ] Dokümantasyon güncellendi
- [ ] Breaking change var

## 🧪 Test Edildi

- [ ] Unit testler geçiyor
- [ ] Feature testler geçiyor
- [ ] Manuel test yapıldı

## 📸 Screenshots (UI değişiklikleri için)

Önce/Sonra ekran görüntüleri

## ✅ Checklist

- [ ] Kod review yapıldı
- [ ] Testler yazıldı
- [ ] Dokümantasyon güncellendi
- [ ] Breaking change yoksa veya belgelendi
```

## 🐛 Bug Raporlama

### Issue Template

```markdown
## 🐛 Bug Açıklaması

Hatanın kısa ve net açıklaması.

## 🔄 Tekrarlama Adımları

1. '...' sayfasına git
2. '...' butonuna tıkla
3. '...' alanını doldur
4. Hatayı gör

## 🎯 Beklenen Davranış

Ne olması gerekiyordu?

## 📱 Ortam

- OS: [Windows/Mac/Linux]
- Browser: [Chrome, Firefox, Safari]
- PHP Version: [8.2, 8.3]
- Laravel Version: [12.x]

## 📋 Ek Bilgi

- Error logs
- Screenshots
- Console errors
```

## ✨ Özellik Önerisi

### Feature Request Template

```markdown
## 🚀 Özellik Önerisi

Özelliğin kısa açıklaması.

## 🎯 Problem

Bu özellik hangi problemi çözüyor?

## 💡 Çözüm

Nasıl bir çözüm öneriyorsunuz?

## 🔄 Alternatifler

Başka hangi çözümler düşündünüz?

## 📋 Ek Bilgi

- Mockup'lar
- Referans linkler
- Benzer örnekler
```

## 🎨 UI/UX Contribution

### Design Guidelines

- **Responsive**: Mobil-first yaklaşım
- **Accessibility**: WCAG 2.1 AA uyumlu
- **Dark Mode**: Her component için dark mode desteği
- **Performance**: Optimize edilmiş görseller ve animasyonlar

### Asset'ler

```
public/
├── images/
│   ├── icons/          # SVG iconlar
│   ├── avatars/        # Kullanıcı avatarları
│   └── brand/          # Logo ve marka görselleri
├── css/
└── js/
```

## 📚 Dokümantasyon

### Yazım Kuralları

- Türkçe kullanın
- Başlıklarda emoji kullanın
- Kod örnekleri ekleyin
- Screenshot'lar ekleyin (gerektiğinde)

### Dokümantasyon Türleri

- **README.md**: Genel bilgiler
- **SETUP.md**: Kurulum rehberi
- **API.md**: API dokümantasyonu
- **DEPLOYMENT.md**: Deploy rehberi

## 🏆 Katkıda Bulunanlar

Katkıda bulunan herkesi [All Contributors](https://allcontributors.org/) spec'ine göre tanıyoruz.

## 📞 İletişim

- **GitHub Issues**: Teknik konular
- **Discord**: [`#laravel-cms-starter`](https://discord.gg/example)
- **Email**: contributors@example.com

## 📄 Lisans

Bu projeye katkıda bulunarak, katkınızın MIT lisansı altında yayınlanacağını kabul etmiş olursunuz.

---

🙏 **Katkılarınız için teşekkür ederiz! Birlikte harika şeyler yaratıyoruz.**
