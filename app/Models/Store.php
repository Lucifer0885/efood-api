<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'minimun_cart_value',
        'latitude',
        'longitude',
        'working_hours',
        'delivery_range',
        'active'
    ];
        
    protected $translatable = ['name', 'address', 'working_hours'];
    
    protected $casts = [
        'working_hours' => 'array',
        'active' => 'boolean',
    ];

    protected $appends = ['logo', 'cover'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getLogoAttribute()
    {
        return 'https://static.vecteezy.com/system/resources/previews/049/351/008/non_2x/microsoft-lists-icon-logo-symbol-free-png.png';
    }

    public function getCoverAttribute()
    {
        return 'https://static.vecteezy.com/system/resources/previews/049/351/008/non_2x/microsoft-lists-icon-logo-symbol-free-png.png';
    }
}
