<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    // tabela dinâmica, então você vai definir manualmente ao criar o objeto
    protected $table;

    public $timestamps = false; // sem created_at/updated_at

    protected $fillable = [
    'product_id',
    'product',
    'date',
    'start_time',
    'end_time',
    'client_name',
    'client_phone',
    'status'
];

}
