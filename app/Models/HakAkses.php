<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HakAkses extends Model
{
    use HasApiTokens, HasFactory;
    protected $table = 'hak_akses';
    protected $guarded = ['id'];

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
