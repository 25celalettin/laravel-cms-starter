<?php

return [
    // Varsayılan ayarlar
    'defaults' => [
        // Genel Ayarlar
        [
            'key' => 'site_title',
            'value' => 'Site Başlığı',
            'group' => 'general',
            'type' => 'text',
            'title' => 'Site Başlığı',
            'description' => 'Sitenin genel başlığı',
            'is_translatable' => true
        ],
        [
            'key' => 'site_description',
            'value' => 'Site Açıklaması',
            'group' => 'general',
            'type' => 'textarea',
            'title' => 'Site Açıklaması',
            'description' => 'Meta açıklamalarda kullanılacak site açıklaması',
            'is_translatable' => true
        ],
        [
            'key' => 'site_logo',
            'value' => null,
            'group' => 'general',
            'type' => 'image',
            'title' => 'Site Logosu',
            'description' => 'Header\'da kullanılacak site logosu'
        ],
        [
            'key' => 'site_favicon',
            'value' => null,
            'group' => 'general',
            'type' => 'image',
            'title' => 'Favicon',
            'description' => 'Tarayıcı sekmesinde görünecek site ikonu'
        ],
        [
            'key' => 'footer_text',
            'value' => '© 2024 Tüm hakları saklıdır.',
            'group' => 'general',
            'type' => 'text',
            'title' => 'Footer Metni',
            'description' => 'Sayfa altında görünecek telif hakkı metni',
            'is_translatable' => true
        ],

        // İletişim Ayarları
        [
            'key' => 'contact_email',
            'value' => 'info@site.com',
            'group' => 'contact',
            'type' => 'email',
            'title' => 'İletişim E-posta',
            'description' => 'İletişim formundan gelen e-postalar bu adrese gönderilecek'
        ],
        [
            'key' => 'contact_phone',
            'value' => '',
            'group' => 'contact',
            'type' => 'text',
            'title' => 'İletişim Telefonu',
            'description' => 'Ana iletişim telefon numarası'
        ],
        [
            'key' => 'contact_whatsapp',
            'value' => '',
            'group' => 'contact',
            'type' => 'text',
            'title' => 'WhatsApp Numarası',
            'description' => 'WhatsApp iletişim numarası'
        ],
        [
            'key' => 'contact_address',
            'value' => '',
            'group' => 'contact',
            'type' => 'textarea',
            'title' => 'Adres',
            'description' => 'Şirket adresi',
            'is_translatable' => true
        ],
        [
            'key' => 'google_maps',
            'value' => '',
            'group' => 'contact',
            'type' => 'textarea',
            'title' => 'Google Harita Kodu',
            'description' => 'Google Maps iframe kodu'
        ],

        // Sosyal Medya
        [
            'key' => 'social_facebook',
            'value' => '',
            'group' => 'social',
            'type' => 'text',
            'title' => 'Facebook',
            'description' => 'Facebook sayfa linki'
        ],
        [
            'key' => 'social_instagram',
            'value' => '',
            'group' => 'social',
            'type' => 'text',
            'title' => 'Instagram',
            'description' => 'Instagram profil linki'
        ],
        [
            'key' => 'social_linkedin',
            'value' => '',
            'group' => 'social',
            'type' => 'text',
            'title' => 'LinkedIn',
            'description' => 'LinkedIn profil linki'
        ],
        [
            'key' => 'social_youtube',
            'value' => '',
            'group' => 'social',
            'type' => 'text',
            'title' => 'YouTube',
            'description' => 'YouTube kanal linki'
        ],

        // SEO Ayarları
        [
            'key' => 'meta_keywords',
            'value' => '',
            'group' => 'seo',
            'type' => 'textarea',
            'title' => 'Meta Keywords',
            'description' => 'Virgülle ayrılmış anahtar kelimeler',
            'is_translatable' => true
        ],
        [
            'key' => 'google_analytics',
            'value' => '',
            'group' => 'seo',
            'type' => 'textarea',
            'title' => 'Google Analytics Kodu',
            'description' => 'Google Analytics takip kodu'
        ],
        [
            'key' => 'google_site_verification',
            'value' => '',
            'group' => 'seo',
            'type' => 'text',
            'title' => 'Google Site Doğrulama',
            'description' => 'Google Search Console doğrulama meta tag\'i'
        ]
    ],

    // Ayar grupları
    'groups' => [
        'general' => 'Genel Ayarlar',
        'contact' => 'İletişim Ayarları',
        'social' => 'Sosyal Medya',
        'seo' => 'SEO Ayarları'
    ]
]; 