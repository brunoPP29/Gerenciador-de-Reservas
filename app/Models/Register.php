<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Register extends Model{
        protected $table = 'users';
        
        public $timestamps = false; 

        protected $fillable = [
            'user',
            'password',
            'email'
];
    }

?>


?>