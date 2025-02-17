<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\RoleCode;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    protected $fillable = ['role_id', 'user_id', 'slug'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($roleUser) {
            $roleUser->slug = self::getSlugForRole($roleUser->role_id);
        });

        static::saving(function ($roleUser) {
            $roleUser->slug = self::getSlugForRole($roleUser->role_id);
        });
    }

    private static function getSlugForRole($roleId)
    {
        switch ($roleId) {
            case RoleCode::admin:
                return 'admin';
            case RoleCode::merchant:
                return 'merchant';
            case RoleCode::driver:
                return 'driver';
            default:
                return 'unknown';
        }
    }
}

