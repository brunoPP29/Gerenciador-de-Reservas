<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Register extends Model{
        protected $table = 'users';

        protected $fillable = [
            'user',
            'password',
            'email'
];
    }

?>


?>