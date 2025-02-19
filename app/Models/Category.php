<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasTranslations;

    protected $translatable = ['name'];

    protected $fillable = ['name'];

    protected $appends = ['icon'];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getIconAttribute()
    {
        return 'https://static.vecteezy.com/system/resources/previews/049/351/008/non_2x/microsoft-lists-icon-logo-symbol-free-png.png';
    }
}
