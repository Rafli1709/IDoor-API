<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvalancheEffect extends Model
{
    use HasFactory;
    protected $table = 'avalanche_effect';
    protected $guarded = ['id'];
}
