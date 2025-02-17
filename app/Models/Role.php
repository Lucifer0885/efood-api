<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasTranslations;

    protected $fillable = ["name"];

    public $translatable = ["name"];

    public static $idByCode = [
        'admin' => 1,
        'merchant'=> 2,
        'driver'=> 3
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
