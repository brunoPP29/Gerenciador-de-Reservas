<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseProduct extends Model
{
    // tabela dinâmica, então você vai definir manualmente ao criar o objeto
    protected $table = ''; // será definido dinamicamente no Service

    public $timestamps = false; // sem created_at/updated_at

    protected $fillable = [
        'name',
        'price_per_hour',
        'duration_minutes',
        'opens_at',
        'closes_at',
        'description'
    ];
}
