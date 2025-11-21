<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Store extends Model
{
    // tabela dinâmica, então você vai definir manualmente ao criar o objeto
    protected $table;

    public $timestamps = false; // sem created_at/updated_at

}
