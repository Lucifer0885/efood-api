<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\RoleCode;
use App\Models\User;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    protected $fillable = ['role_id', 'user_id', 'slug', 'user_name'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($roleUser) {
            $roleUser->slug = self::getSlugForRole($roleUser->role_id);
            $roleUser->user_name = self::getUserName($roleUser->user_id);
        });

        static::saving(function ($roleUser) {
            $roleUser->slug = self::getSlugForRole($roleUser->role_id);
            $roleUser->user_name = self::getUserName($roleUser->user_id);
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

    private static function getUserName($userId)
    {
        $user = User::find($userId);
        return $user ? $user->name : null;
    }
}

