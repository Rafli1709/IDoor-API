<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alat extends Model
{
    use HasApiTokens, HasFactory;
    protected $table = 'alat';
    protected $guarded = ['id'];
    protected $hidden = ['secret_key'];

    public function getPasswordAttribute()
    {
        return $this->attributes['password'];
    }

    public function getSecretKeyAttribute()
    {
        return $this->attributes['secret_key'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hakAkses(): HasOne
    {
        return $this->hasOne(HakAkses::class);
    }

    public function historyAkses(): HasMany
    {
        return $this->hasMany(HistoryAkses::class);
    }
}
