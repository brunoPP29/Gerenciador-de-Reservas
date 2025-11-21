<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DynamicTable extends Model
{
    protected $table;
    public $timestamps = true;

    public function setTableName($table)
    {
        $this->table = $table;
        return $this;
    }
}
