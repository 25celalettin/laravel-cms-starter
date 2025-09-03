<?php

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case ESTATE_AGENCY = 'estate_agency';
    case ADMIN = 'admin';
    case SUPERADMIN = 'superadmin';

    /**
     * Kullanıcı oluşturma/düzenleme formunda gösterilecek rolleri döndürür
     * Süper admin rolü sadece seeder veya artisan command ile atanabilir
     */
    public static function getAvailableRoles(): array
    {
        return [
            self::USER,
            self::ESTATE_AGENCY,
            self::ADMIN,
        ];
    }

    /**
     * Yeni kullanıcılar için varsayılan rolü döndürür
     */
    public static function getDefaultRole(): self
    {
        return self::USER;
    }

    /**
     * Rol için uygun label döndürür
     */
    public function label(): string
    {
        return match($this) {
            self::SUPERADMIN => __('messages.roles.superadmin'),
            self::ADMIN => __('messages.roles.admin'),
            self::ESTATE_AGENCY => __('messages.roles.estate_agency'),
            self::USER => __('messages.roles.user')
        };
    }

    /**
     * Rol için uygun renk döndürür
     */
    public function color(): string
    {
        return match($this) {
            self::SUPERADMIN => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            self::ADMIN => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            self::ESTATE_AGENCY => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            self::USER => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
        };
    }
} 